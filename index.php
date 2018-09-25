<?php
	
	// This file contains some random crap that is not related to school work or anything :)


	$firstName = "Marvin";
	$lastName = "Helstein";
	
	if(isset($_POST['name'])) {
		$name = htmlspecialchars($_POST['name']);
		$bName = true;
		setcookie('name', $name);
	} elseif (isset($_COOKIE["name"])) {
		$name = $_COOKIE["name"];
		$bName = true;
	} else {
		$name = $firstName . ' ' . $lastName;
		$bName = false;
	}
	
	$hourNow = date("G");
	if ($hourNow < 8 ) {
		$timeDescription = "Varahommik";
	} elseif ($hourNow < 16 ) {
		$timeDescription = "Keskpäev";
	} elseif ($hourNow < 24 ) {
		$timeDescription = "Õhtu";
	}
	
	$active = 'home';
	$title = 'Hello ' . $name . '!';

?>
<?php require_once('includes/header.php'); ?>
	<div class="container container-main mt-4">
		<div class="row">
			<div class="col">
				<div class="center">
					<h1>Marvin Helstein, IF18</h1>
				</div>
				<p>See leht on loodud <a href="https://www.tlu.ee/" target="_blank">TLÜ</a> õppetöö raames, ei pruugi parim välja näha ning kindlasti ei sisalda tõsiseltvõetavat sisu :)</p>
				<?php
					if ($bName) {
						echo '<p><strong>Your name is ' . $name . '</strong></p>';
					} else {
						echo '
							<div class="card">
								<div class="card-block">
									<form method="post">
										<div class="form-group">
											<label for="inputName">Your name</label>
											<input class="form-control" name="name" id="inputName" placeholder="Enter your name">
											<small class="form-text text-muted">Please enter your name.</small>
										</div>
										<button type="submit" class="btn btn-primary">Save</button>
									</form>
								</div>
							</div>';
					}
				
				?>
				<p>Praegu on <span id="datetime"></span></p>
				<img class="img-fluid img-thumbnail" src="../../~rinde/veebiprogrammeerimine2018s/tlu_terra_600x400_1.jpg" alt="Tallinna Ülikooli Terra õppehoone">
				
				<p>Mul on ka sõber kes teeb oma <a href="../../~jaanlil/">veebi</a>.</p>
			</div>
		</div>
	</div>

<?php require_once('includes/footer.php'); ?>
