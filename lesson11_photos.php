<?php 
require_once('includes/functions.php');
require_once('includes/functions/photos.php');

$perPage = 5;
$maxPages = ceil(getPhotosCount(!$loggedIn) / $perPage);

if (isset($_GET['page']) && $maxPages > 0) {
    $page = intval($_GET['page']);
    if ($page < 0) {
        $page = 0;
    } elseif ($page >= $maxPages) {
        $page = $maxPages - 1;
    }
} else {
    $page = 0;
}

$active = 'lesson11_photos';
$title = 'Tund11 - Vaata pilte';
$javascript = '<script type="text/javascript" src="assets/js/photos.js"></script>';

?>

<?php require_once('includes/header.php'); ?>
    <div class="modal fade" id="image-modal" tabindex="-1" role="dialog" aria-labelledby="image-modal-label" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="image-modal-label">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <img id="full-image" class="rounded mx-auto d-block" alt="placeholder">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
	<div class="container mt-4">
		<div class="row">
            <div class="col">
                <div class="center">
                    <h3>Tund 11 - Pildid</h3>
                </div>
            </div>
        </div>
		<div class="row">
            <div class="d-flex flex-row justify-content-center flex-wrap">
                <?php
                $path = $config['thumbnails_dir'];
                $fullPath = $config['images_dir'];
                $images = getPhotos($page, $perPage, !$loggedIn);
                if (empty($images)) {
                    echo '<p>Pilte pole</p>';
                } else {
                    foreach ($images as $image) {
                        echo '<div class="p-4"><img class="img-thumbnail image-priview" data-url="' . $fullPath . $image['file'] . '" src="' . $path . $image['file'] . '" alt="' . $image['title'] . '"></div>';
                    }
                }
                ?>
            </div>
        </div>
        <?php require('includes/pagination.php'); ?>
    </div>
<?php require_once('includes/footer.php'); ?>