<?php
    require_once('includes/functions.php');
    require_once('includes/functions/users.php');
    require_once('includes/functions/photos.php');
	
	$active = 'userprofile';
    $title = 'Sinu profiil';
    $success = false;
    $errors = [];

    if (!$loggedIn) {
        header('Location: index.php');
        die();
    }

    $bio = $user['bio'];
    $foreground = $user['foreground'];
    $background = $user['background'];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        if (!isset($_POST['bio'])) {
            $_POST['bio'] = '';
        }
        $bio = cleanInput($_POST['bio']);

        if (!isset($_POST['foreground']) || !preg_match('/#([a-f0-9]{3}){1,2}\b/i', $_POST['foreground'])) {
            $errors['foreground'] = 'Palun vali tekstivärv';
        } else {
            $foreground = $_POST['foreground'];
        }

        if (!isset($_POST['background']) || !preg_match('/#([a-f0-9]{3}){1,2}\b/i', $_POST['background'])) {
            $errors['background'] = 'Palun vali taustavärv';
        } else {
            $background = $_POST['background'];
        }

        // Check if avatar is uploaded and save it.
        if (isset($_FILES["avatar"]) && !empty($_FILES["avatar"]["name"])) {
            $targetDir = "uploads/avatars/";
            $imageFileType = strtolower(pathinfo($_FILES["avatar"]["name"], PATHINFO_EXTENSION));
            $fileName = 'vp_avatar_' . $user['id'] . '-' . microtime(true) * 10000 . '.png';
            $target_file = $targetDir . $fileName;
            $check = getimagesize($_FILES["avatar"]["tmp_name"]);
    
            if($check !== false) {
                $uploadOk = 1;
            } else {
                $uploadOk = 0;
            }
    
            if ($_FILES["avatar"]["size"] > 2500000) {
                $errors['avatar'] = "Sorry, your avatar is too large.";
                $uploadOk = 0;
            }
    
            if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
                $errors['avatar'] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                $uploadOk = 0;
            }
    
            if ($uploadOk == 1) {
                $image = resizeImage($_FILES["avatar"]["tmp_name"], $imageFileType, 300, 300, false, false);
                if ($image && imagepng($image, $target_file)) {
                    imagedestroy($image);
                    if (!setAvatar($user['id'], $fileName)) {
                        $errors['avatar'] = 'Sorry, there was an error saving your avatar.';
                    }
                } else {
                    $errors['avatar'] = 'Sorry, there was an error uploading your avatar.';
                }
            }
        }

        if (!count($errors)) {
            if (updateProfile($user['id'], $bio, $foreground, $background)) {
                $success = true;
                // Update user
                $user = getUser($_SESSION['user']);
            } else {
                $error = "Profiili salvestamine ebaõnnestus!";
            }
        }   
    }


?>
<?php require_once('includes/header.php'); ?>
	<div class="container mt-4">
		<div class="row">
			<div class="col">
				<div class="center">
					<h3>Muuda profiili</h3>
				</div>
				<hr>
                <?php
                    if (isset($error)) {
                        echo alert($error, 'danger');
                    } elseif (count($errors)) {
                        echo alert('Profiili muutmisel tekkis viga. Kontrolli sisestatud informatsiooni.', 'danger');
                    } else if ($success) {
                        echo alert('Profiil salvestatud edukalt', 'success');
                    }
                ?>
				<form method="post" enctype="multipart/form-data">
                    <img src="<?php echo $user['profile_image']; ?>" alt="Profile picture" class="img-thumbnail">
					<div class="form-group">
						<label for="avatar">Muuda avatari</label>
						<input type="file" name="avatar" class="form-control-file <?php if (isset($errors['avatar'])) echo "is-invalid"; ?>" id="avatar">
                        <?php if(isset($errors['avatar'])) echo '<div class="invalid-feedback">' . $errors['avatar'] . '</div>'; ?> 
						<small id="avatarHelpBlock" class="form-text text-muted">
							Max file size 2.5 MB. 
						</small>
					</div>
					<div class="form-group">
						<label for="inputName">Kirjeldus</label>
						<textarea class="form-control <?php if (isset($errors['bio'])) echo "is-invalid"; ?>" name="bio" id="inputBio" rows="3" placeholder="Sisesta oma kirjeldus" required><?php echo $bio; ?></textarea>
                        <?php if(isset($errors['bio'])) echo '<div class="invalid-feedback">' . $errors['bio'] . '</div>'; ?> 
					</div>
                    <div class="form-group">
                        <label for="inputName">Tekstivärv</label>
                        <input type="color" class="form-control <?php if (isset($errors['foreground'])) echo "is-invalid"; ?>" name="foreground" id="inputForeground" value="<?php echo $foreground; ?>" required>
                        <?php if(isset($errors['foreground'])) echo '<div class="invalid-feedback">' . $errors['foreground'] . '</div>'; ?> 
                    </div>
                    <div class="form-group">
                        <label for="inputName">Taustavärv</label>
                        <input type="color" class="form-control <?php if (isset($errors['background'])) echo "is-invalid"; ?>" name="background" id="inputBackground" value="<?php echo $background; ?>" required>
                        <?php if(isset($errors['background'])) echo '<div class="invalid-feedback">' . $errors['background'] . '</div>'; ?> 
                    </div>
					<button type="submit" class="btn btn-primary">Salvesta profiil</button>
				</form>
			</div>
		</div>

	</div>
<?php require_once('includes/footer.php'); ?>
