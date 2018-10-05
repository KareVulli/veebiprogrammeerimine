<?php

const USER_NOT_EXIST = 0;
const USER_EMAIL_EXISTS = 1;
const USER_NAME_EXISTS = 2;

require_once('config.php');

// include database credentials
require_once($config['db']);

$db = null;

function cleanInput($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function alert($message, $type = 'default')
{
    return '<div class="alert alert-' . $type . '" role="alert">' . $message . '</div>';
}

function getDb() {
    global $db;
    if ($db === null) {
        $db = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4', DB_USERNAME, DB_PASSWORD, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);
    }
    return $db;
}

function saveMessage($message) {
    $db = getDb();
    $stmt = $db->prepare('INSERT INTO vpamsg (message) VALUES (:message)');
    return $stmt->execute([
        ':message' => $message
    ]);
}

function getMessages() {
    $db = getDb();
    $stmt = $db->query('SELECT message, created FROM vpamsg ORDER BY created DESC');
    return $stmt->fetchAll();
}

function saveCat($name, $color, $tail) {
    $db = getDb();
    $stmt = $db->prepare('INSERT INTO cats (name, color, tail_length) VALUES (:name, :color, :tail_length)');
    return $stmt->execute([
        ':name' => $name,
        ':color' => $color,
        ':tail_length' => $tail
    ]);
}

function getCats() {
    $db = getDb();
    $stmt = $db->query('SELECT name, color, tail_length, created FROM cats ORDER BY created DESC');
    return $stmt->fetchAll();
}

function doesUserExist($username, $email) {
    $db = getDb();
    $stmt = $db->prepare(
        'SELECT id, username, email FROM vpusers ' .
        'WHERE username = :username OR email = :email LIMIT 1'
    );
    $stmt->execute([
        ':username' => $username,
        ':email' => $email
    ]);
    if ($row = $stmt->fetch()) {
        if ($row['username'] === $username) {
            return USER_NAME_EXISTS;
        } else {
            return USER_EMAIL_EXISTS;
        }
    }
    return USER_NOT_EXIST;

}

function saveUser($firstname, $lastname, $username, $email, $password, $birthDate, $gender) {
    // Don't try to do anything fancy with trying to generate your own salt. PHP will generate one itself.
    // Even PHP Documentation discourages you to do so and as of PHP 7.0, the salt option is deprecated.
    // Also PASSWORD_DEFAULT is totally safe to use if you just have long enough password field (Recommended size is 255/256 characters)
    // More info http://php.net/manual/en/function.password-hash.php
    $password = password_hash($password, PASSWORD_DEFAULT);

    $db = getDb();
    $stmt = $db->prepare(
        'INSERT INTO vpusers (firstname, lastname, username, email, password, birthdate, gender) ' .
        'VALUES (:firstname, :lastname, :username, :email, :password, :birthdate, :gender)'
    );
    return $stmt->execute([
        ':firstname' => $firstname,
        ':lastname' => $lastname,
        ':username' => $username,
        ':email' => $email,
        ':password' => $password,
        ':birthdate' => $birthDate,
        ':gender' => $gender
    ]);
}