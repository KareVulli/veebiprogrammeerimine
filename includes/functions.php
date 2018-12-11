<?php

session_start();

const USER_NOT_EXIST = 0;
const USER_EMAIL_EXISTS = 1;
const USER_NAME_EXISTS = 2;

require_once(__DIR__.'/config.php');

// include database credentials
require_once(__DIR__.$config['db']);

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
    global $config;

    $db = getDb();
    $stmt = $db->prepare(
        'SELECT u.*, a.id AS profile_image_id, a.file AS profile_image FROM vpusers u
        LEFT JOIN vpavatars a ON a.user_id = u.id 
        WHERE u.id = :id AND a.id = (
            SELECT MAX(id)
            FROM vpavatars 
            WHERE user_id = :id
        )'
    );
    $stmt->execute([
        ':id' => $id
    ]);
    $row = $stmt->fetch();
    // Add default colors
    if (!$row['foreground']) {
        $row['foreground'] = '#000000';
    }
    if (!$row['background']) {
        $row['background'] = '#FFFFFF';
    }
    if (!$row['profile_image']) {
        $row['profile_image'] = $config['default_avatar'];
    } else {
        $row['profile_image'] = $config['avatars_dir'] . $row['profile_image'];
        $row['profile_image_id'] = $row['profile_image_id'];
    }
    return $row;
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


// UTIL FUNCIONS

function darkenColor($rgb, $darker=2) {

    $hash = (strpos($rgb, '#') !== false) ? '#' : '';
    $rgb = (strlen($rgb) == 7) ? str_replace('#', '', $rgb) : ((strlen($rgb) == 6) ? $rgb : false);
    if(strlen($rgb) != 6) return $hash.'000000';
    $darker = ($darker > 1) ? $darker : 1;

    list($R16,$G16,$B16) = str_split($rgb,2);

    $R = sprintf("%02X", floor(hexdec($R16)/$darker));
    $G = sprintf("%02X", floor(hexdec($G16)/$darker));
    $B = sprintf("%02X", floor(hexdec($B16)/$darker));

    return $hash.$R.$G.$B;
}

function returnJsonResponse($status = 400, $message = null, $extra = null) {
    header('Content-type: application/json');
    http_response_code($status);
    $data = [];
    if ($message !== null) {
        $data['message'] = $message;
    }
    if ($extra !== null) {
        if ($message === null) {
            $data = $extra;
        } else {
            $data = array_merge($data, $extra);
        }
    }
    echo json_encode($data);
    exit();
}

function validateDate($date, $format = 'Y-m-d')
{
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) === $date;
}