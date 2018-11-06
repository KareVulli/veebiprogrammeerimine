<?php	
const WIDTH = 600;
const HEIGHT = 400;

require_once('includes/functions.php');
require_once('includes/functions/photos.php');

if (!$loggedIn) {
	header('Location: index.php');
	die();
}

$active = 'lesson8_photoupload';
$title = 'Tund8 - Fotod';
$uploadOk = -1;
$uploadError = null;


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

	if (isset($_POST['public']) && $_POST['public'] == 1) {
		$private = 0;
	} else {
		$private = 1;
	}

	if (isset($_POST['title']) && !empty($_POST['title'])) {
		$title = $_POST['title'];
	} else {
		$title = "Nimetu";
	}

	$fileName = $user['id'] . '-' . microtime(true) * 10000 . '.png';

	if (isset($_FILES["photo"]) && !empty($_FILES["photo"]["name"])) {
		$targetDir = "uploads/";
		$imageFileType = strtolower(pathinfo($_FILES["photo"]["name"], PATHINFO_EXTENSION));
		$target_file = $targetDir . $fileName;
		$check = getimagesize($_FILES["photo"]["tmp_name"]);

		if($check !== false) {
			$uploadOk = 1;
		} else {
			$uploadOk = 0;
		}

		if ($_FILES["photo"]["size"] > 2500000) {
			$uploadError = "Sorry, your file is too large.";
			$uploadOk = 0;
		}

		if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
			$uploadError = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
			$uploadOk = 0;
		}

		if ($uploadOk == 1) {
			$image = resizeImage($_FILES["photo"]["tmp_name"], $imageFileType, WIDTH, HEIGHT);
			if ($image && imagepng($image, $target_file)) {
				$uploadError = 'The file '. basename($_FILES["photo"]["name"]) . ' has been uploaded.';
				imagedestroy($image);
				if (!savePhoto($user['id'], $fileName, $title, $private)) {
					$uploadError = 'Sorry, there was an error saving your file.';
					$uploadOk = 0;
				}
			} else {
				$uploadError = 'Sorry, there was an error uploading your file.';
				$uploadOk = 0;
			}
		}

	} else {
		$uploadOk = -2;
	}
}

?>
<?php require_once('includes/header.php'); ?>
	<div class="container mt-4">
		<div class="row">
			<div class="col">
				<div class="center">
					<h3>Tund 8 - Fotod</h3>
				</div>
				<form method="POST" enctype="multipart/form-data">
					<?php 
						if ($uploadOk === 0) {
							echo alert($uploadError, 'danger');
						} else if ($uploadOk === 1) {
							echo alert($uploadError, 'success');
						} else if ($uploadOk === -2) {
							echo alert('Te ei valinud pilti!', 'warning');
						}
					?>
					<div class="form-group">
						<label for="inputTitle">Title</label>
						<input type="text" class="form-control" id="inputTitle" name="title">
					</div>
					<div class="form-group">
						<label for="photo">Vali foto</label>
						<input type="file" name="photo" class="form-control-file" id="photo">
						<small id="photoHelpBlock" class="form-text text-muted">
							Max file size 2.5 MB. 
						</small>
					</div>
					<div class="form-group">
						<div class="custom-control custom-checkbox">
							<input type="checkbox" class="custom-control-input" name="public" value="1" id="inputPublic">
							<label class="custom-control-label" for="inputPublic">Public image</label>
						</div>
					</div>
					<button type="submit" class="btn btn-primary">Lae üles</button>
				</form>
			</div>
		</div>
	</div>
<?php require_once('includes/footer.php'); ?>
