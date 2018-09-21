<?php	
	$active = 'lesson3';
	$currentWeekDay = date("N");
	$currentMonth = date('n');
	$weekdayNames = [
		'Esmaspäev',
		'Teisipäev',
		'Kolmapäev',
		'Neljapäev',
		'Reede',
		'Laupäev',
		'Pühapäev'
	];

	$monthNames = [
		'Jaanuar',
		'Veebruar',
		'Märts',
		'Aprill',
		'Mail',
		'Juuni',
		'Juuli',
		'August',
		'September',
		'Oktoober',
		'November',
		'Detsember'
	];

	$image = 'https://www.cs.tlu.ee/~rinde/media/fotod/TLU_600x400/tlu_' . rand(2, 43) . '.jpg';

	$imageDirectory = '../assets/images/';
	$dirImages = array_slice(scandir($imageDirectory), 2);
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<title>Tund 3</title>
	
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
					<h1>Tund 3</h1>
				</div>
				<p><?php echo 'Täna on ' . $weekdayNames[$currentWeekDay - 1] . '. Kuu on ' . $monthNames[$currentMonth - 1] . ', '; ?><span id="datetime"><?php echo date('d.m.Y H:m:s'); ?></span></p>
				

				
			</div>
		</div>
		<div class="row">
			<div class="col">
				<p>Random image from web</p>
				<img class="img-fluid img-thumbnail" src="<?php echo $image; ?>" alt="Tallinna Ülikooli Terra õppehoone">
			</div>
			<div class="col">
				<p>Random image from folder</p>
				<img class="img-fluid img-thumbnail" src="<?php echo $imageDirectory . $dirImages[rand(0, count($dirImages) - 1)]; ?>" alt="Photo from folder">
			</div>
		</div>
		<div class="row">
			<div class="col">
				<p>All images from the folder</p>
			</div>
		</div>
		<div class="row">
			<?php
				for($i = 0; $i < count($dirImages); $i++) {
					echo '<div class="col-4">
						<img class="img-fluid img-thumbnail" src="' . $imageDirectory . $dirImages[$i] . '" alt="Pilt">
					</div>';
				}
			?>
			
		</div>
	</div>
	<?php require_once('includes/footer.php'); ?>

	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
	<script type="text/javascript" src="app.js"></script>
</body>

</html>
