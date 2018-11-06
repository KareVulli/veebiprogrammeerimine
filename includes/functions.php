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
    $row = $stmt->fetch();
    // Add default colors
    if (!$row['foreground']) {
        $row['foreground'] = '#000000';
    }
    if (!$row['background']) {
        $row['background'] = '#FFFFFF';
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

function resizeImage($imagePath, $ext, $newWidth, $newHeight, $crop = false) {
    global $user;

    switch($ext){
        case "png":
            $src = imagecreatefrompng($imagePath);
        break;
        case "jpeg":
        case "jpg":
            $src = imagecreatefromjpeg($imagePath);
        break;
        case "gif":
            $src = imagecreatefromgif($imagePath);
        break;
        default:
            $src = imagecreatefromjpeg($imagePath);
        break;
    }

    if ($src) {
        $width = imagesx($src);
        $height = imagesy($src);

        if ($width > $height) {
            $sizePercent = $width / $newWidth;
        } else {
            $sizePercent = $height / $newHeight;
        }
        $imageNewWidth = $width / $sizePercent;
        $imageNewHeight = $height / $sizePercent;

        $dest = imagecreatetruecolor($imageNewWidth, $imageNewHeight);
        imagecopyresampled($dest, $src, 0, 0, 0, 0, $imageNewWidth, $imageNewHeight, $width, $height);
        addWatermark($dest, 10);
        if ($user != null) {
            addTextToImage($dest, 'Hello ' . $user['firstname'] . ' ' . $user['lastname']);
        }
        return $dest;
    }

    return false;
}

function addWatermark($image, $padding) {
    global $config;

    $watermark = imagecreatefrompng($config['watermark']);

    if ($watermark) {
        $watermarkWidth = imagesx($watermark);
        $watermarkHeight = imagesy($watermark);

        $imageWidth = imagesx($image);
        $imageHeight = imagesy($image);

        $posX = $imageWidth - $watermarkWidth - $padding;
        $posY = $imageHeight - $watermarkHeight - $padding;
        imagecopyresampled($image, $watermark, $posX, $posY, 0, 0, $watermarkWidth, $watermarkHeight, $watermarkWidth, $watermarkHeight);
    }

    return $image;
}

function addTextToImage($image, $text, $size = 25) {
    global $config;

    $white = imagecolorallocatealpha($image, 255, 255, 255, 0);
    $fontPath = $config['font'];

    $typeSpace = imagettfbbox($size, 0, $fontPath, $text);
    $textWidth = abs($typeSpace[4] - $typeSpace[0]);
    $textHeight = abs($typeSpace[5] - $typeSpace[1]);

    $imageWidth = imagesx($image);
    $imageHeight = imagesy($image);

    imagettftext($image, $size, 0, ($imageWidth / 2) - ($textWidth / 2), ($imageHeight / 2) - ($textHeight / 2), $white, $fontPath, $text);

    return $image;
}