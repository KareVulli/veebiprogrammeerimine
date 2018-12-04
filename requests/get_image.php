<?php
require_once('../includes/functions.php');
require_once('../includes/functions/photos.php');

/* if (isset($_GET["last"]) && is_numeric($_GET["last"])) {
    $offset = intval($_GET["last"]);
    if ($offset < 0) {
        $offset = 0;
    }
} else {
    $offset = 0;
} */

$path = $config['images_dir'];
$image = getLatestRandomPhoto(true/* , $offset */);

header('Content-type: application/json');
if ($image === null) {
    echo json_encode([
        'title' => "",
        'url' => ""
    ]);
} else {
    echo json_encode([
        'title' => $image['title'],
        'url' => $path . $image['file']
    ]);
}