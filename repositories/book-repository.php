<?php
require_once __DIR__ . "/../config/database.php";

function getBooks($filters = [], $page = 1, $perPage = 10)
{
  global $pdo;

  $offset = ($page - 1) * $perPage;

  
  $whereClause = "";
  $bindings = [];

  if (!empty($filters['search'])) {
    $whereClause = "WHERE b.title LIKE :search";
    $bindings['search'] = '%' . $filters['search'] . '%';
  }

  if (!empty($filters['category'])) {
    if (!empty($whereClause)) {
      $whereClause .= " AND ";
    }
    $whereClause .= "c.name = :category";
    $bindings['category'] = $filters['category'];
  }

  $query = "select b.id, b.title, b.stock, c.name as category from books b
            left join categories c on b.category_id = c.id
            {$whereClause}
            limit :limit offset :offset ";

  $stmt = $pdo->prepare($query);

  
  foreach ($bindings as $key => $value) {
      $stmt->bindValue($key, $value);
  }
  $stmt->bindValue('limit', $perPage, PDO::PARAM_INT);
  $stmt->bindValue('offset', $offset, PDO::PARAM_INT);

  $stmt->execute();

  $books = $stmt->fetchAll(PDO::FETCH_ASSOC);

  $query = "select ba.book_id, a.name from book_author ba
            left join authors a on ba.author_id = a.id
           ";

  $stmt = $pdo->prepare($query);
  $stmt->execute();

  $bookAuthors = $stmt->fetchAll();

  $bookByAuthors = [];

  foreach ($bookAuthors as $bookAuthor) {
    $bookByAuthors[$bookAuthor['book_id']][] = $bookAuthor['name'];
  }

  foreach ($books as $index => $book) {
    $books[$index]['authors'] = $bookByAuthors[$book['id']] ?? [];
  }

  return $books;
}

function countBooks($filters = [])
{
  global $pdo;


  $whereClause = "";
  $bindings = [];

  if (!empty($filters['search'])) {
    $whereClause = "WHERE title LIKE :search";
    $bindings['search'] = '%' . $filters['search'] . '%';
  }

  if (!empty($filters['category'])) {
    if (!empty($whereClause)) {
      $whereClause .= " AND ";
    }
    $whereClause .= "category_id = :category";
    $bindings['category'] = $filters['category'];
  }

  $query = "select count(*) as total from books {$whereClause}";

  $stmt = $pdo->prepare($query);
  foreach ($bindings as $key => $value) {
      $stmt->bindValue($key, $value);
  }
  $stmt->execute();

  $result = $stmt->fetch();

  return $result['total'];
}

function getBook($id)
{
  global $pdo;

  $query = "select id, title, isbn, year, stock, category_id, description from books where id = :id";
  $stmt = $pdo->prepare($query);
  $stmt->execute([
      'id' => $id
  ]);

  $book = $stmt->fetch();

  if (!$book) {
      return null;
  }

  $query = "select a.id, a.name from book_author ba
      left join authors a on ba.author_id = a.id
      where ba.book_id = :book_id
   ";

  $stmt = $pdo->prepare($query);
  $stmt->execute([
      'book_id' => $book['id']
  ]);

  $authorIds = $stmt->fetchAll();

  $book['author_ids'] = array_column($authorIds, 'id');

  return $book;
}

function storeBook($data)
{
  global $pdo;

  try {
      $pdo->beginTransaction();

      $title = $data['title'];
      $isbn = $data['isbn'];
      $year = $data['year'];
      $stock = $data['stock'];
      $description = $data['description'];
      $category_id = $data['category_id'];

      $query = "insert into books (title, isbn, year, stock, description, category_id)
                values (:title, :isbn, :year, :stock, :description, :category_id)
               ";
      $stmt = $pdo->prepare($query);
      $stmt->execute([
          'title' => $title,
          'isbn' => $isbn,
          'year' => $year,
          'stock' => $stock,
          'description' => $description,
          'category_id' => $category_id
      ]);

      $bookId = $pdo->lastInsertId();

      // Insert authors
      if (!empty($data['author_ids'])) {
          $query = "insert into book_author (book_id, author_id) values (:book_id, :author_id)";
          $stmt = $pdo->prepare($query);

          foreach ($data['author_ids'] as $authorId) {
              $stmt->execute([
                  'book_id' => $bookId,
                  'author_id' => $authorId
              ]);
          }
      }

      $pdo->commit();

      return $bookId;
  } catch (PDOException $e) {
      $pdo->rollBack();
      return false;
  }
}

function updateBook($data)
{
  global $pdo;

  try {
      $pdo->beginTransaction();

      $id = $data['id'];
      $title = $data['title'];
      $isbn = $data['isbn'];
      $year = $data['year'];
      $stock = $data['stock'];
      $category_id = $data['category_id'];
      $description = $data['description'];
      $authorIds = $data['author_ids'] ?? [];

      $query = "update books set title = :title, isbn = :isbn,
    year = :year, stock = :stock, category_id = :category_id,
    description = :description where id = :id
 ";

      $stmt = $pdo->prepare($query);

      $stmt->execute([
          'title' => $title,
          'isbn' => $isbn,
          'year' => $year,
          'stock' => $stock,
          'category_id' => $category_id,
          'description' => $description,
          'id' => $id
      ]);

    
      $query = "delete from book_author where book_id = :book_id";
      $stmt = $pdo->prepare($query);
      $stmt->execute([
          'book_id' => $id
      ]);

      
      $query = "insert into book_author (book_id, author_id) values (:book_id, :author_id)";
      $stmt = $pdo->prepare($query);

      foreach ($authorIds as $authorId) {
          $stmt->execute([
              'book_id' => $id,
              'author_id' => $authorId
          ]);
      }

      $pdo->commit();

      return true;
  } catch (PDOException $e) {
      $pdo->rollBack();
      return false;
  }
}

function deleteBook($id)
{
  global $pdo;

  try {
      $pdo->beginTransaction();

     
      $query = "delete from book_author where book_id = :book_id";
      $stmt = $pdo->prepare($query);
      $stmt->execute([
          'book_id' => $id
      ]);


      $query = "delete from books where id = :id";
      $stmt = $pdo->prepare($query);
      $stmt->execute([
          'id' => $id
      ]);

      $pdo->commit();

      return true;
  } catch (PDOException $e) {
      $pdo->rollBack();
      return false;
  }
}