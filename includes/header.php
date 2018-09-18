<nav class="navbar navbar-expand-lg navbar-light bg-light">
	<a class="navbar-brand" href="#">*CareFully*</a>
	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main-navbar" aria-controls="main-navbar" aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
	</button>
	<div class="collapse navbar-collapse" id="main-navbar">
		<div class="navbar-nav">
			<a class="nav-item nav-link <?php if (isset($active) && $active === 'home') echo 'active'; ?> " href="index.php">Tund 1-2</a>
			<a class="nav-item nav-link <?php if (isset($active) && $active === 'lesson3') echo 'active'; ?>" href="lesson3.php">Tund 3</a>
			<a class="nav-item nav-link <?php if (isset($active) && $active === 'lesson3_2') echo 'active'; ?>" href="lesson3_2.php">Tund 3 (2)</a>
		</div>
	</div>
</nav>