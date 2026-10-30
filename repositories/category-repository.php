<?php
require_once __DIR__ . "/../config/database.php";

function getCategories($filters = [], $page = 1, $perPage = 10)
{
    global $pdo;

    $offset = ($page - 1) * $perPage;

    // Build dynamic query with filters
    $whereClause = "";
    $bindings = [];

    if (!empty($filters['search'])) {
        $whereClause = "WHERE name LIKE :search OR description LIKE :search";
        $bindings['search'] = '%' . $filters['search'] . '%';
    }

    $query = "select c.id, c.name, c.description, count(b.id) as total_books from categories c
              left join books b on c.id = b.category_id
              {$whereClause}
              group by c.id, c.name, c.description
              limit :limit offset :offset ";
    $stmt = $pdo->prepare($query);

    // Bind parameters
    foreach ($bindings as $key => $value) {
        $stmt->bindValue($key, $value);
    }
    $stmt->bindValue('limit', $perPage, PDO::PARAM_INT);
    $stmt->bindValue('offset', $offset, PDO::PARAM_INT);

    $stmt->execute();

    $categories = $stmt->fetchAll();

    return $categories;
}

function countCategories($filters = [])
{
    global $pdo;

    // Build dynamic query with filters
    $whereClause = "";
    $bindings = [];

    if (!empty($filters['search'])) {
        $whereClause = "WHERE name LIKE :search OR description LIKE :search";
        $bindings['search'] = '%' . $filters['search'] . '%';
    }

    $query = "select count(*) as total from categories {$whereClause}";
    $stmt = $pdo->prepare($query);
    foreach ($bindings as $key => $value) {
        $stmt->bindValue($key, $value);
    }
    $stmt->execute();

    $result = $stmt->fetch();

    return $result['total'];
}

function getCategory($id)
{
    global $pdo;

    $query = "select id, name, description from categories where id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->execute([
        'id' => $id
    ]);

    $category = $stmt->fetch();

    if (!$category) {
        return null;
    }

    return $category;
}

function storeCategory($data)
{
    global $pdo;

    try {
        $name = $data['name'];
        $description = $data['description'];

        $query = "insert into categories (name, description) values (:name, :description)";
        $stmt = $pdo->prepare($query);
        $stmt->execute([
            'name' => $name,
            'description' => $description
        ]);

        return $pdo->lastInsertId();
    } catch (PDOException $e) {
        return false;
    }
}

function updateCategory($data)
{
    global $pdo;

    try {
        $id = $data['id'];
        $name = $data['name'];
        $description = $data['description'];

        $query = "update categories set name = :name, description = :description where id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->execute([
            'name' => $name,
            'description' => $description,
            'id' => $id
        ]);

        return true;
    } catch (PDOException $e) {
        return false;
    }
}

function deleteCategory($id)
{
    global $pdo;

    try {
        $query = "delete from categories where id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->execute([
            'id' => $id
        ]);

        return true;
    } catch (PDOException $e) {
        return false;
    }
}