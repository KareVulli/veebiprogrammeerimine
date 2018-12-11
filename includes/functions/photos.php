<?php
require_once(__DIR__ . '/../functions.php');


function getComments($photoId)
{
    $db = getDb();
    $stmt = $db->prepare(
        'SELECT c.comment, c.rating, c.created, u.username, u.id ' .
        'FROM vpphotos_ratings c ' .
        'LEFT JOIN vpusers u ON u.id = c.user_id ' .
        'WHERE c.photo_id = :photo_id ' .
        'ORDER BY c.created DESC'
    );
    $stmt->execute([
        ':photo_id' => $photoId
    ]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function addComment($photoId, $userId, $rating, $comment)
{
    $db = getDb();
    $stmt = $db->prepare(
        'INSERT INTO vpphotos_ratings (photo_id, user_id, rating, comment) VALUES (:photo_id, :user_id, :rating, :comment)'
    );
    return $stmt->execute([
        ':photo_id' => $photoId,
        ':user_id' => $userId,
        ':rating' => $rating,
        ':comment' => $comment,
    ]);
}

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

function getPhoto($id, $onlyPrivate = false)
{
    $db = getDb();
    if ($onlyPrivate) {
        $private = 'AND p.private = 1 ';
    } else {
        $private = '';
    }
    $stmt = $db->prepare(
        'SELECT p.id, p.file, p.title, p.user_id, p.created, p.updated_at, p.private, AVG(r.rating) rating, u.firstname, u.lastname ' .
        'FROM vpphotos p ' .
        'LEFT JOIN vpphotos_ratings r ON p.id = r.photo_id ' .
        'LEFT JOIN vpusers u ON p.user_id = u.id ' .
        'WHERE p.id = :id AND p.deleted_at IS NULL ' . $private .
        'GROUP BY p.id '
    );
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch();
}

function getPhotos($page = 0, $perPage = 2, $onlyPublic = false)
{
    $db = getDb();
    if ($onlyPublic) {
        $private = 'AND p.private = 0 ';
    } else {
        $private = '';
    }
    $offset = $page * $perPage;
    $stmt = $db->prepare(
        'SELECT p.id, p.file, p.title, p.user_id, p.created, p.updated_at, p.private, AVG(r.rating) rating, u.firstname, u.lastname ' .
        'FROM vpphotos p ' .
        'LEFT JOIN vpphotos_ratings r ON p.id = r.photo_id ' .
        'LEFT JOIN vpusers u ON p.user_id = u.id ' .
        'WHERE p.deleted_at IS NULL ' . $private .
        'GROUP BY p.id ' .
        'ORDER BY p.created DESC ' .
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
        $private = 'AND p.private = 1 ';
    } else {
        $private = '';
    }
    $offset = $page * $perPage;
    $stmt = $db->prepare(
        'SELECT p.id, p.file, p.title, p.user_id, p.created, p.updated_at, p.private, AVG(r.rating) rating ' .
        'FROM vpphotos p ' .
        'LEFT JOIN vpphotos_ratings r ON p.id = r.photo_id ' .
        'WHERE p.deleted_at IS NULL ' . $private . ' AND user_id = :user_id ' .
        'GROUP BY p.id ' .
        'ORDER BY p.created DESC ' .
        'LIMIT :offset, :perPage'
    );
    $stmt->bindValue(':user_id', $userid, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->bindValue(':perPage', $perPage, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll();
}


function getLatestPhoto($onlyPublic = true, $offset = 0)
{
    $db = getDb();
    if ($onlyPublic) {
        $private = 'AND private = 0 ';
    } else {
        $private = '';
    }
    $stmt = $db->prepare(
        'SELECT id, file, title, user_id, created, updated_at, private ' .
        'FROM vpphotos ' .
        'WHERE deleted_at IS NULL ' . $private .
        'ORDER BY created DESC ' .
        'LIMIT :offset, 1'
    );
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch();
}

function getLatestRandomPhoto($onlyPublic = true)
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
        'LIMIT 10'
    );
    $images = $stmt->fetchAll();

    if (count($images) > 0) {
        return $images[rand(0, count($images)-1)];
    } else {
        return null;
    }

}