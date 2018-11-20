<?php
	require_once('includes/functions.php');
	require_once('includes/functions/photos.php');
	
	$active = 'home';
	if ($loggedIn) {
		$title = 'Tere ' . $user['firstname'] . ' ' . $user['lastname'] . '!';
	} else {
		$title = '*CareFully* veebiarendus';
	}

?>
<?php require_once('includes/header.php'); ?>
	<div class="container container-main mt-4">
		<div class="row">
			<div class="col">
				<div class="center">
					<h1>Marvin Helstein, IF18</h1>
				</div>
				<?php
					if ($loggedIn) {
						echo '<p><small>Oled sisse logitud kasutajana <strong>' . $user['firstname'] . ' ' . $user['lastname'] . '</strong>.</small></p>';
					}

				?>
				<p>See leht on loodud <a href="https://www.tlu.ee/" target="_blank">TLÜ</a> õppetöö raames, ei pruugi parim välja näha ning kindlasti ei sisalda tõsiseltvõetavat sisu :)</p>
				
				<p>Praegu on <span id="datetime"></span></p>
				<!-- <img class="img-fluid img-thumbnail" src="../../~rinde/veebiprogrammeerimine2018s/tlu_terra_600x400_1.jpg" alt="Tallinna Ülikooli Terra õppehoone"> -->
				
				<p>Mul on ka sõber kes teeb oma <a href="../../~jaanlil/"><strong><u>veebi</u></strong></a>.</p>

				<p>Viimati üleslaetud pilt:</p>
				<?php
					$path = $config['images_dir'];
					$image = getLatestPhoto(!$loggedIn);
					if (!$image) {
						echo '<p>Puudub</p>';
					} else {
						echo '<img src="' . $path . $image['file'] . '" alt="' . $image['title'] . '" class="img-thumbnail">';
					}
				?>
				
			</div>
		</div>
	</div>

<?php require_once('includes/footer.php'); ?>
