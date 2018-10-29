<?php
    require_once('includes/functions.php');
    require_once('includes/functions/users.php');
	
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
				<form method="post">
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
