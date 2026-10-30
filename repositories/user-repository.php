<?php
require_once __DIR__ . "/../config/database.php";

function getUsers()
{
    global $pdo;

    $query = "select id, name, email, role from users";
    $stmt = $pdo->prepare($query);
    $stmt->execute();

    $users = $stmt->fetchAll();

    return $users;
}

function getUser($id)
{
    global $pdo;

    $query = "select id, name, email, role from users where id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->execute([
        'id' => $id
    ]);

    $user = $stmt->fetch();

    if (!$user) {
        return null;
    }

    return $user;
}

function getUserByEmail($email)
{
    global $pdo;

    $query = "select id, name, email, password, role from users where email = :email";
    $stmt = $pdo->prepare($query);
    $stmt->execute([
        'email' => $email
    ]);

    return $stmt->fetch();
}

function storeUser($data)
{
    global $pdo;

    try {
        $name = $data['name'];
        $email = $data['email'];
        $password = password_hash($data['password'], PASSWORD_DEFAULT);
        $role = $data['role'];

        $query = "insert into users (name, email, password, role) values (:name, :email, :password, :role)";
        $stmt = $pdo->prepare($query);
        $stmt->execute([
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'role' => $role
        ]);

        return $pdo->lastInsertId();
    } catch (PDOException $e) {
        return false;
    }
}

function updateUser($data)
{
    global $pdo;

    try {
        $id = $data['id'];
        $name = $data['name'];
        $email = $data['email'];
        $role = $data['role'];

        $query = "update users set name = :name, email = :email, role = :role where id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->execute([
            'name' => $name,
            'email' => $email,
            'role' => $role,
            'id' => $id
        ]);

        return true;
    } catch (PDOException $e) {
        return false;
    }
}

function deleteUser($id)
{
    global $pdo;

    try {
        $query = "delete from users where id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->execute([
            'id' => $id
        ]);

        return true;
    } catch (PDOException $e) {
        return false;
    }
}

function getProfile($user_id)
{
    global $pdo;

    $query = "select phone, address, bio from profiles where user_id = :user_id";
    $stmt = $pdo->prepare($query);
    $stmt->execute([
        'user_id' => $user_id
    ]);

    $profile = $stmt->fetch();

    if (!$profile) {
        $profile = [
            'phone' => '',
            'address' => '',
            'bio' => ''
        ];
    }

    return $profile;
}

function updateProfile($data)
{
    global $pdo;

    try {
        $user_id = $data['user_id'];
        $name = $data['name'];
        $email = $data['email'];
        $phone = $data['phone'];
        $address = $data['address'];
        $bio = $data['bio'];

        // Update user
        $query = "update users set name = :name, email = :email where id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->execute([
            'name' => $name,
            'email' => $email,
            'id' => $user_id
        ]);

        $query = "select id from profiles where user_id = :user_id";
        $stmt = $pdo->prepare($query);
        $stmt->execute([
            'user_id' => $user_id
        ]);
        $profile = $stmt->fetch();

        if ($profile) {
            $query = "update profiles set phone = :phone, address = :address, bio = :bio where user_id = :user_id";
        } else {
            $query = "insert into profiles (user_id, phone, address, bio) values (:user_id, :phone, :address, :bio)";
        }

        $stmt = $pdo->prepare($query);
        $stmt->execute([
            'user_id' => $user_id,
            'phone' => $phone,
            'address' => $address,
            'bio' => $bio
        ]);

        return true;
    } catch (PDOException $e) {
        return false;
    }
}