<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<title><?php echo (isset($title) ? htmlspecialchars($title) : '*CareFully* veebileht'); ?></title>
	
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
	<link rel="stylesheet" href="style.css">
</head>

<body>
	<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
		<a class="navbar-brand" href="#">*CareFully*</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main-navbar" aria-controls="main-navbar" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="main-navbar">
			<div class="navbar-nav">
				<a class="nav-item nav-link <?php if (isset($active) && $active === 'home') echo 'active'; ?> " href="index.php">Tund 1-2</a>
				<a class="nav-item nav-link <?php if (isset($active) && $active === 'lesson3') echo 'active'; ?>" href="lesson3.php">Tund 3 - pildid</a>
				<a class="nav-item nav-link <?php if (isset($active) && $active === 'lesson3_2') echo 'active'; ?>" href="lesson3_2.php">Tund 3 - form</a>
				<a class="nav-item nav-link <?php if (isset($active) && $active === 'lesson4') echo 'active'; ?>" href="lesson4.php">Tund 4 - funktsioonid</a>
				<a class="nav-item nav-link <?php if (isset($active) && $active === 'lesson4_add_message') echo 'active'; ?>" href="lesson4_add_message.php">Tund 4 - lisa sõnum</a>
				<a class="nav-item nav-link <?php if (isset($active) && $active === 'lesson4_read_messages') echo 'active'; ?>" href="lesson4_read_messages.php">Tund 4 - sõnumid</a>
			</div>
		</div>
	</nav>
	<div class="top-bg"></div>