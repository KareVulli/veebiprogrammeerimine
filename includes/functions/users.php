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