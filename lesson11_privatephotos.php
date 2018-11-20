<?php 
require_once('includes/functions.php');
require_once('includes/functions/photos.php');

$active = 'lesson11_privatephotos';
$title = 'Tund11 - Privaatsed pildid';

if (!$loggedIn) {
	header('Location: index.php');
	die();
}

?>

<?php require_once('includes/header.php'); ?>
	<div class="container mt-4">
		<div class="row">
            <div class="col">
                <div class="center">
                    <h3>Tund 11 - Privaatsed pildid</h3>
                </div>
            </div>
        </div>
		<div class="row">
            <div class="d-flex flex-row justify-content-center flex-wrap">
                <?php
                    $path = $config['thumbnails_dir'];
                    $images = getPrivatePhotos($user['id']);
                    if (empty($images)) {
                        echo '<p>Privaatseid pilte pole</p>';
                    } else {
                        foreach ($images as $image) {
                            echo '<div class="p-4"><img src="' . $path . $image['file'] . '" alt="' . $image['title'] . '" class="img-thumbnail"></div>';
                        }
                    }
                ?>
            </div>
        </div>
    </div>
<?php require_once('includes/footer.php'); ?>