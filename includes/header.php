<?php
	
	require_once('includes/functions.php');
	
	if (isset($_SESSION['loginError'])) {
		$status = 'data-show="true"';
		$loginError = alert(cleanInput($_SESSION['loginError']), 'danger');
		unset($_SESSION['loginError']);
	} else {
		$status = '';
		$loginError = '';
	}

?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<title><?php echo (isset($title) ? htmlspecialchars($title) : '*CareFully* veebileht'); ?></title>
	
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
	<link rel="stylesheet" href="style.css">
	<?php
		if ($loggedIn) {
			echo '<style>' .
				'.content { ' .
					'background-color: ' . $user['background'] . '; ' .
					'color: ' . $user['foreground'] . '; ' .
				'}' .
				'.user-dark { ' .
					'background-color: ' . darkenColor($user['background'], 1.2) . '!important; ' .
					'color: ' . $user['foreground'] . '!important; ' .
				'}' .
				'.user { ' .
					'background-color: ' . $user['background'] . '!important; ' .
					'color: ' . $user['foreground'] . '!important; ' .
				'}' .
				'#sidebar ul li.active > a, a[aria-expanded="true"] { ' .
					'background-color: ' . $user['background'] . '!important; ' .
					'color: ' . $user['foreground'] . '!important; ' .
				'}' .
			'</style>';
		}

	?>
</head>

<body>
	<div class="wrapper">
		<nav id="sidebar" class="user-dark">
			<div id="particles"></div>
			<div class="sidebar-header">
				<h4 class="text-center">*CareFully* veebiarendus</h4>
			</div>
			<ul class="list-unstyled components">
				<li <?php if (isset($active) && $active === 'home') echo 'class="active"'; ?>><a href="index.php">Tund 1-2</a></li>
				<li <?php if (isset($active) && $active === 'lesson3') echo 'class="active"'; ?>><a href="lesson3.php">Tund 3 - pildid</a></li>
				<li <?php if (isset($active) && $active === 'lesson3_2') echo 'class="active"'; ?>><a href="lesson3_2.php">Tund 3 - form</a></li>
				<li <?php if (isset($active) && $active === 'lesson4') echo 'class="active"'; ?>><a href="lesson4.php">Tund 4 - funktsioonid</a></li>
				<li <?php if (isset($active) && $active === 'lesson4_add_message') echo 'class="active"'; ?>><a href="lesson4_add_message.php">Tund 4 - lisa sõnum</a></li>
				<li <?php if (isset($active) && $active === 'lesson4_read_messages') echo 'class="active"'; ?>><a href="lesson4_read_messages.php">Tund 4 - sõnumid</a></li>
				<li <?php if (isset($active) && $active === 'homework3_cats') echo 'class="active"'; ?>><a href="homework3_cats.php">Kodutöö 3 - kassid</a></li>
				<li <?php if (isset($active) && $active === 'lesson5') echo 'class="active"'; ?>><a href="lesson5.php">Tund 5 - kasutaja</a></li>
				<li <?php if (isset($active) && $active === 'lesson6') echo 'class="active"'; ?>><a href="lesson6.php">Tund 6 - Sisselogimine</a></li>
				<li <?php if (isset($active) && $active === 'homework5_users') echo 'class="active"'; ?>><a href="homework5_users.php">Kodutöö 5 - kasutajad</a></li>
				<li <?php if (isset($active) && $active === 'lesson8') echo 'class="active"'; ?>><a href="lesson8_photoupload.php">Tund 8 - Fotod</a></li>
			</ul>
		</nav>

		<div class="content">
			<nav class="navbar navbar-expand-lg navbar-light bg-light user-dark">
				<a class="navbar-brand" href="index.php">
					<img src="assets/images/vp_picfiles/vp_logo_color_w100_overlay.png" height="30" alt="">
				</a>
				<ul class="navbar-nav mr-auto"><!-- 
					<button type="button" id="sidebarCollapse" class="btn">
						<span class="navbar-toggler-icon"></span>
					</button> -->
					<?php
						if($loggedIn) {
							echo 
							'<li class="nav-item' . (isset($active) && $active === 'lesson6_validate' ? ' active' : '') . '">
								<a class="nav-link" href="lesson6_validate.php">Valideeri sõnumeid</a>
							</li>
							<li class="nav-item' . (isset($active) && $active === 'lesson7_validated' ? ' active' : '') . '">
								<a class="nav-link" href="lesson7_validated.php">Valideeritud sõnumid</a>
							</li>';
						}

					?>
				</ul>
				<ul class="navbar-nav ml-auto">
					<?php
						if($loggedIn) {
							echo 
							'<span class="navbar-text"><strong>Tere, ' . $user['firstname'] . ' ' . $user['lastname'] . '</strong></span>
							<li class="nav-item' . (isset($active) && $active === 'userprofile' ? ' active' : '') . '">
								<a class="nav-link" href="userprofile.php">Profiil</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="logout.php">Logi välja</a>
							</li>';
						} else {
							echo 
							'<li class="nav-item">
								<a class="nav-link" href="#loginModal" data-toggle="modal">Logi sisse</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="lesson5.php">Registeeru</a>
							</li>';
						}

					?>
				</ul>
			</nav>

			<div class="modal fade" id="loginModal" <?php echo $status; ?> tabindex="-1" role="dialog" aria-labelledby="loginModalLabel" aria-hidden="true">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="loginModalLabel">Sisselogimine</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<form method="POST" action="login.php">
							<div class="modal-body">
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
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-secondary" data-dismiss="modal">Sulge</button>
								<button type="submit" class="btn btn-primary">Logi sisse</button>
							</div>
						</form>
					</div>
				</div>
			</div>

		
		<!-- <div class="top-bg"></div> -->
		