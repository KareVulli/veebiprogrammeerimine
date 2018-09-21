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

?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<title>Hello <?php echo $name;?>!</title>
	
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
	<link rel="stylesheet" href="style.css">
</head>

<body>
	<?php require_once('includes/header.php'); ?>
	<div class="container">
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

	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
	<script type="text/javascript" src="app.js"></script>
</body>

</html>
