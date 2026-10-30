<?php
require_once __DIR__ . "/../config/database.php";

function getAuthors()
{
    global $pdo;

    $query = "select a.id, a.name, a.bio, count(ba.book_id) as total_books from authors a
              left join book_author ba on a.id = ba.author_id
              group by a.id, a.name, a.bio
             ";
    $stmt = $pdo->prepare($query);
    $stmt->execute();

    $authors = $stmt->fetchAll();

    return $authors;
}

function getAuthor($id)
{
    global $pdo;

    $query = "select id, name, bio from authors where id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->execute([
        'id' => $id
    ]);

    $author = $stmt->fetch();

    if (!$author) {
        return null;
    }

    return $author;
}

function storeAuthor($data)
{
    global $pdo;

    try {
        $name = $data['name'];
        $bio = $data['bio'];

        $query = "insert into authors (name, bio) values (:name, :bio)";
        $stmt = $pdo->prepare($query);
        $stmt->execute([
            'name' => $name,
            'bio' => $bio
        ]);

        return $pdo->lastInsertId();
    } catch (PDOException $e) {
        return false;
    }
}

function updateAuthor($data)
{
    global $pdo;

    try {
        $id = $data['id'];
        $name = $data['name'];
        $bio = $data['bio'];

        $query = "update authors set name = :name, bio = :bio where id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->execute([
            'name' => $name,
            'bio' => $bio,
            'id' => $id
        ]);

        return true;
    } catch (PDOException $e) {
        return false;
    }
}

function deleteAuthor($id)
{
    global $pdo;

    try {
        $pdo->beginTransaction();

        
        $query = "delete from book_author where author_id = :author_id";
        $stmt = $pdo->prepare($query);
        $stmt->execute([
            'author_id' => $id
        ]);

   
        $query = "delete from authors where id = :id";
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