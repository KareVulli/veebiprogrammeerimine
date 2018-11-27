<?php

require_once(__DIR__ . '/../functions.php');


function updateProfile($id, $bio, $foreground, $background) {
    $db = getDb();
    $stmt = $db->prepare(
        'UPDATE vpusers SET bio = :bio, foreground = :foreground, background = :background WHERE id = :id'
    );
    return $stmt->execute([
        ':id' => $id,
        ':bio' => $bio,
        ':foreground' => $foreground,
        ':background' => $background
    ]);
}

function setAvatar($id, $name) {
    $db = getDb();
    $stmt = $db->prepare(
        'INSERT INTO vpavatars (user_id, file) VALUES (:user_id, :file)'
    );
    return $stmt->execute([
        ':user_id' => $id,
        ':file' => $name
    ]);
}

function getOldAvatars($userid, $ignoreID = null) {
    $db = getDb();
    if ($ignoreID === null) {
        $stmt = $db->prepare('SELECT a.file FROM vpavatars a WHERE a.user_id = :user_id ORDER BY id DESC');
        $stmt->execute([
            ':user_id' => $id
        ]);
    } else {
        $stmt = $db->prepare('SELECT a.file FROM vpavatars a WHERE a.user_id = :user_id AND id != :id ORDER BY id DESC');
        $stmt->execute([
            ':user_id' => $userid,
            ':id' => $ignoreID
        ]);
    }
    return $stmt->fetchAll();
}