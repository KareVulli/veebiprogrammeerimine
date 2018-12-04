<?php 
require_once('includes/functions.php');
require_once('includes/functions/photos.php');

$perPage = 5;
$maxPages = ceil(getPhotosCount(!$loggedIn) / $perPage);
$getPhotos = function($page) use ($perPage, $loggedIn) {
    return getPhotos($page, $perPage, !$loggedIn);
};
$path = $config['thumbnails_dir'];
$fullPath = $config['images_dir'];
$active = 'lesson11_photos';
$title = 'Tund11 - Vaata pilte';
?>

<?php require_once('includes/photos.php'); ?>