<?php

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
        $db = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USERNAME, DB_PASSWORD);
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