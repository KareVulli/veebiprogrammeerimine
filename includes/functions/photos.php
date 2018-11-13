<?php
require_once(__DIR__ . '/../functions.php');

function savePhoto($userid, $filename, $title, $isPrivate)
{
    $db = getDb();
    $stmt = $db->prepare('INSERT INTO vpphotos (file, title, user_id, private) VALUES (:file, :title, :user_id, :private)');
    return $stmt->execute([
        ':file' => $filename,
        ':title' => $title,
        ':user_id' => $userid,
        ':private' => $isPrivate,
    ]);
}