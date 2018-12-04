<?php

require_once('../includes/functions.php');
require_once('../includes/functions/photos.php');

if (!$loggedIn) {
    returnJsonResponse(401, 'Not logged in!');
}

if (isset($_GET["id"]) && is_numeric($_GET["id"])) {
    $photoId = intval($_GET["id"]);
} else {
    returnJsonResponse(422, 'Photo id missing');
}
//var_dump(getComments($photoId));
returnJsonResponse(200, null, getComments($photoId));

