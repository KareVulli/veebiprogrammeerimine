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
	<div class="wrapper">
		<nav id="sidebar">
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
			</ul>
		</nav>

		<div class="content">
			<nav class="navbar navbar-expand-lg navbar-light bg-light">
				<div class="container-fluid">
					<button type="button" id="sidebarCollapse" class="btn">
						<span class="navbar-toggler-icon"></span>
					</button>
				</div>
			</nav>

		
		<!-- <div class="top-bg"></div> -->
		