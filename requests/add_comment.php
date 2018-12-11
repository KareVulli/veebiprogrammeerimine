<?php

require_once('../includes/functions.php');
require_once('../includes/functions/photos.php');

if (!$loggedIn) {
    returnJsonResponse(401, 'Not logged in!');
}

if (isset($_POST["id"]) && is_numeric($_POST["id"])) {
    $photoId = intval($_POST["id"]);
} else {
    returnJsonResponse(422, 'Photo id missing');
}

if (isset($_POST["comment"])) {
    $comment = htmlspecialchars($_POST["comment"]);
} else {
    $comment = "";
}

if (isset($_POST["rating"]) && is_numeric($_POST["rating"])) {
    $rating = intval($_POST["rating"]);
    if ($rating < 1 || $rating > 5) {
        returnJsonResponse(422, 'Rating must be between 1-5');
    }
} else {
    returnJsonResponse(422, 'Rating missing');
}

if (addComment($photoId, $user['id'], $rating, $comment)) {
    $photo = getPhoto($photoId);
    $extra = [];
    if ($photo) {
        $extra['rating'] = number_format($photo['rating'], 2);
    }
    returnJsonResponse(201, 'Comment added successfully', $extra);
} else {
    returnJsonResponse(500, 'Failed to post comment');
}
