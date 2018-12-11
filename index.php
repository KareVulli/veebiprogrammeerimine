<?php
	require_once('includes/functions.php');
	require_once('includes/functions/photos.php');
	
	$active = 'home';
	if ($loggedIn) {
		$title = 'Tere ' . $user['firstname'] . ' ' . $user['lastname'] . '!';
	} else {
		$title = '*CareFully* veebiarendus';
	}

	$javascript = '<script type="text/javascript" src="assets/js/photo_shuffler.js"></script>';

?>
<?php require_once('includes/header.php'); ?>
	<div class="container container-main mt-4">
		<div class="row">
			<div class="col-sm-8">
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
			</div>
			<div class="col-sm-4">
				<p>Viimati üleslaetud pilt:</p>
				<img id="photo" src="" style="display: none;" alt="placeholder" class="img-thumbnail">
				<p id="error" style="display: none;">Pilte pole</p>
			</div>
		</div>
		<div class="row">
			<div class="col">
				<h3 class="mt-4">Viimased Uudised</h3>
				<?php require('includes/news.php'); ?>
				
			</div>
		</div>
	</div>

<?php require_once('includes/footer.php'); ?>
