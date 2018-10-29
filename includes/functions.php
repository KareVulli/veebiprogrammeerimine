<?php

session_start();

const USER_NOT_EXIST = 0;
const USER_EMAIL_EXISTS = 1;
const USER_NAME_EXISTS = 2;

require_once('config.php');

// include database credentials
require_once($config['db']);

$db = null;

// Get user info, if user is logged in
if (isset($_SESSION['user'])) {
    $loggedIn = true;
    $user = getUser($_SESSION['user']);
} else {
    $loggedIn = false;
    $user = null;
}

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

function getDb()
{
    global $db;
    if ($db === null) {
        $db = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4', DB_USERNAME, DB_PASSWORD, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);
    }
    return $db;
}

function saveMessage($message)
{
    $db = getDb();
    $stmt = $db->prepare('INSERT INTO vpamsg (message) VALUES (:message)');
    return $stmt->execute([
        ':message' => $message
    ]);
}

function getMessages($notValidated = false)
{
    $db = getDb();
    if ($notValidated) {
        $stmt = $db->query('SELECT id, message, created, accepted FROM vpamsg WHERE accepted <> 1 ORDER BY created DESC');
    } else {
        $stmt = $db->query('SELECT id, message, created, accepted FROM vpamsg WHERE accepted = 1 ORDER BY created DESC');
    }
    return $stmt->fetchAll();
}

function setMessageValidated($id)
{
    $db = getDb();
    $user = getUser($_SESSION['user']);
    // We're setting the message as accepted and we also add information about who and when accepted the message
    // Where selecting what message to update by filtering the messages by id. ID is unique to every message so there will be
    // Either 0 or 1 results. However even if there is 0 results, there is no error and that's fine. We don't need to care about that.
    // We do care about the validity of the user_id (specially if you have foreign key constrains properly set up). 
    $stmt = $db->prepare('UPDATE vpamsg SET accepted = 1, accepted_by = :accepted_by, accepted_at = NOW() WHERE id = :id');
    // UPDATE table set column = new_value, column2 = new_value2, ... WHERE [same as select] id = 2
    $stmt->execute([
        ':id' => $id,
        ':accepted_by' => $user['id']
    ]);
}

function saveCat($name, $color, $tail)
{
    $db = getDb();
    $stmt = $db->prepare('INSERT INTO cats (name, color, tail_length) VALUES (:name, :color, :tail_length)');
    return $stmt->execute([
        ':name' => $name,
        ':color' => $color,
        ':tail_length' => $tail
    ]);
}

function getCats()
{
    $db = getDb();
    $stmt = $db->query('SELECT name, color, tail_length, created FROM cats ORDER BY created DESC');
    return $stmt->fetchAll();
}

function doesUserExist($username, $email)
{
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

function login($email, $password)
{
    $db = getDb();
    $stmt = $db->prepare(
        'SELECT id, username, email, password FROM vpusers ' .
            'WHERE username = :username OR email = :email LIMIT 1'
    );
    $stmt->execute([
        ':username' => $email,
        ':email' => $email
    ]);
    if ($row = $stmt->fetch()) {
        if (password_verify($password, $row['password'])) {
            return $row['id'];
        } else {
            return null;
        }
    }
    return null;

}

function getUser($id)
{
    $db = getDb();
    $stmt = $db->prepare(
        'SELECT * FROM vpusers ' .
            'WHERE id = :id'
    );
    $stmt->execute([
        ':id' => $id
    ]);
    return $row = $stmt->fetch();
}

function getUsers()
{
    $db = getDb();
    if (isset($_SESSION['user'])) {
        $user = getUser($_SESSION['user']);
        if ($user === null) { // if user is not logged in, we 
            $stmt = $db->query('SELECT * FROM vpusers');
        } else {
            $stmt = $db->prepare('SELECT * FROM vpusers WHERE id <> :id');
            $stmt->execute([
                ':id' => $user['id']
            ]);
        }
    } else {
        $stmt = $db->query('SELECT * FROM vpusers'); // copy pastaaaa
    }
    return $stmt->fetchAll();
}

function saveUser($firstname, $lastname, $username, $email, $password, $birthDate, $gender)
{
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
// Redirects user to the previous page
function goBack() {
    if(isset($_SERVER['HTTP_REFERER'])) {
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    } else {
        header('Location: index.php');
    }
}

