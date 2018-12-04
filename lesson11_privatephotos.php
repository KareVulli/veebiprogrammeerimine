<?php 
require_once('includes/functions.php');
require_once('includes/functions/photos.php');

if (!$loggedIn) {
	header('Location: index.php');
	die();
}

$perPage = 5;
$maxPages = ceil(getUserPhotosCount($user['id']) / $perPage);
$getPhotos = function($page) use ($perPage, $user) {
    return getUserPhotos($user['id'], $page, $perPage);
};
$path = $config['thumbnails_dir'];
$fullPath = $config['images_dir'];
$active = 'lesson11_privatephotos';
$title = 'Tund11 - Privaatsed pildid';
?>

<?php require_once('includes/photos.php'); ?>