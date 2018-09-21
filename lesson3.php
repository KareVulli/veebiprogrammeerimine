<?php	
	$active = 'lesson3';

	// Arrays for weekday and month names
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

	// Random image
	$image = 'https://www.cs.tlu.ee/~rinde/media/fotod/TLU_600x400/tlu_' . rand(2, 43) . '.jpg';

	// Get array of all images in directory
	$imageDirectory = '../assets/images/';

	// Check if the images direcotry exist.
	// I'm sometimes running this locally where the images folder does not exist
	if (file_exists($imageDirectory)) {
		$dirImages = array_slice(scandir($imageDirectory), 2);
	}

	// Format date
	// Get the indexes for weekday and month
	$currentWeekDay = date("N") - 1;
	$currentMonth = date('n') - 1;

	// ==== 2nd homework 1st exercise ====
	// Note that as the month we have set \x. This will add the actual character "x" that we can later replace.
	$date = date('d \x Y H:m:s');
	// Add month name to the date string. (replace "x" with the month name)
	$date = str_replace('x', $monthNames[$currentMonth], $date);
	$dateText = 'Täna on ' . $weekdayNames[$currentWeekDay] . ', ' . $date;
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<title>Tund 3</title>
	
	<!-- Bootstrap -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
	
	<!-- Custom css -->
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
				<p><?php echo $dateText; ?></p>
			</div>
		</div>
		<div class="row">
			<div class="col">
				<p>Random image from web</p>
				<img class="img-fluid img-thumbnail" src="<?php echo $image; ?>" alt="Tallinna Ülikooli Terra õppehoone">
			</div>
			<div class="col">
				<p>Random image from folder</p>
				<?php
					// ==== 2nd homework 2nd exercise ====
					// Since there is a possibility that the images folder does not exist and thus the array doesn't exist,
					// then we need to check for that
					if (isset($dirImages) && count($dirImages) > 0) {
						echo '<img class="img-fluid img-thumbnail" src="' . $imageDirectory . $dirImages[rand(0, count($dirImages) - 1)] . '" alt="Photo from folder">';
					} else {
						echo '<p><small class="text-warning">No images found!</small></p>';
					}
				?>
			</div>
		</div>
		<div class="row">
			<div class="col">
				<p>All images from the folder</p>
			</div>
		</div>
		<div class="row">
			<?php
				// Since there is a possibility that the images folder does not exist and thus the array doesn't exist,
				// then we need to check for that
				if (isset($dirImages) && count($dirImages) > 0) {
					for($i = 0; $i < count($dirImages); $i++) {
						echo '<div class="col-4">
							<img class="img-fluid img-thumbnail" src="' . $imageDirectory . $dirImages[$i] . '" alt="Pilt">
						</div>';
					}
				} else {
					echo '<div class="col-12"><p><small class="text-warning">No images found!</small></p></div>';
				}
			?>
			
		</div>
	</div>
	<?php require_once('includes/footer.php'); ?>

	<!-- Javascript -->
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
	<script type="text/javascript" src="app.js"></script>
</body>

</html>
