<?php	
require_once('includes/functions.php');

$active = 'lesson6';
$title = 'Logi sisse';

if ($loggedIn) {
	header('Location: index.php');
	die();
}


?>
<?php require_once('includes/header.php'); ?>
	<div class="container mt-4">
		<div class="row">
			<div class="col">
				<div class="center">
					<h3>Logi sisse</h3>
				</div>
				<form method="POST" action="login.php">
					<?php 
						echo $loginError;
					?>
					<div class="form-group">
						<label for="loginEmail">Email või kasutajanimi</label>
						<input type="text" class="form-control" id="loginEmail" name="email">
					</div>
					<div class="form-group">
						<label for="loginPassword">Parool</label>
						<input type="password" class="form-control" id="loginPassword" name="password">
					</div>
					<button type="submit" class="btn btn-primary">Logi sisse</button>
				</form>
			</div>
		</div>
	</div>
<?php require_once('includes/footer.php'); ?>
