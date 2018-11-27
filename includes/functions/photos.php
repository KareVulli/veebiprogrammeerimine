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

function getPhotosCount($onlyPublic = false)
{
    $db = getDb();
    if ($onlyPublic) {
        $private = 'AND private = 0';
    } else {
        $private = '';
    }
    $stmt = $db->query(
        'SELECT COUNT(id) AS photos ' .
        'FROM vpphotos ' .
        'WHERE deleted_at IS NULL ' . $private
    );
    $row = $stmt->fetch();
    return $row['photos'];
}

function getPhotos($page = 0, $perPage = 2, $onlyPublic = false)
{
    $db = getDb();
    if ($onlyPublic) {
        $private = 'AND private = 0 ';
    } else {
        $private = '';
    }
    $offset = $page * $perPage;
    $stmt = $db->prepare(
        'SELECT id, file, title, user_id, created, updated_at, private ' .
        'FROM vpphotos ' .
        'WHERE deleted_at IS NULL ' . $private .
        'ORDER BY created DESC ' .
        'LIMIT :offset, :perPage'
    );
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->bindValue(':perPage', $perPage, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll();
}

function getUserPhotosCount($userid, $onlyPublic = true)
{
    $db = getDb();
    if ($onlyPublic) {
        $private = 'AND private = 1';
    } else {
        $private = '';
    }
    $stmt = $db->prepare(
        'SELECT COUNT(id) AS photos ' .
        'FROM vpphotos ' .
        'WHERE deleted_at IS NULL ' . $private . ' AND user_id = :user_id'
    );
    $stmt->execute([
        ':user_id' => $userid
    ]);
    $row = $stmt->fetch();
    return $row['photos'];
}

function getUserPhotos($userid, $page = 0, $perPage = 2, $onlyPrivate = true)
{
    $db = getDb();
    if ($onlyPrivate) {
        $private = 'AND private = 1 ';
    } else {
        $private = '';
    }
    $offset = $page * $perPage;
    $stmt = $db->prepare(
        'SELECT id, file, title, user_id, created, updated_at, private ' .
        'FROM vpphotos ' .
        'WHERE deleted_at IS NULL ' . $private . ' AND user_id = :user_id ' .
        'ORDER BY created DESC ' .
        'LIMIT :offset, :perPage'
    );
    $stmt->bindValue(':user_id', $userid, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->bindValue(':perPage', $perPage, PDO::PARAM_INT);
    $stmt->execute();
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