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

function getPhotos($onlyPublic = false)
{
    $db = getDb();
    if ($onlyPublic) {
        $private = 'AND private = 0 ';
    } else {
        $private = '';
    }
    $stmt = $db->query(
        'SELECT id, file, title, user_id, created, updated_at, private ' .
        'FROM vpphotos ' .
        'WHERE deleted_at IS NULL ' . $private .
        'ORDER BY created DESC'
    );
    return $stmt->fetchAll();
}

function getPrivatePhotos($userid)
{
    $db = getDb();
    $stmt = $db->prepare(
        'SELECT id, file, title, user_id, created, updated_at, private ' .
        'FROM vpphotos ' .
        'WHERE deleted_at IS NULL AND private = 1 AND user_id = :user_id ' .
        'ORDER BY created DESC'
    );
    $stmt->execute([
        ':user_id' => $userid
    ]);
    return $stmt->fetchAll();
}


function getLatestPhoto($onlyPublic = true)
{
    $db = getDb();
    if ($onlyPublic) {
        $private = 'AND private = 0 ';
    } else {
        $private = '';
    }
    $stmt = $db->query(
        'SELECT id, file, title, user_id, created, updated_at, private ' .
        'FROM vpphotos ' .
        'WHERE deleted_at IS NULL ' . $private .
        'ORDER BY created DESC ' .
        'LIMIT 1'
    );
    return $stmt->fetch();
}