<?php	
    require_once('includes/functions.php');
	
	$active = 'lesson3_2';
	$title = 'Tund 3';

	// Default values
	$firstName = "Kodanik";
	$lastName = "Tundmatu";
	$birthYear = 1998;
	
	if(isset($_POST['firstname']) && isset($_POST['lastname'])) {
		// htmlspecialchars() protects us from XSS eg. when user writes "<script>alert('haxed')</script>"
		// as their name, then that wont be run as javascript when we show it on the site.
		$firstName = htmlspecialchars($_POST['firstname']);
		$lastName = htmlspecialchars($_POST['lastname']);
	}
	// Too lazy to check if the value is valid... but you should do it.
	if(isset($_POST['birthyear'])) {
		$birthYear = intval($_POST['birthyear']); // cast to int to be safe when echoing it to the site.
		$tempYear = $birthYear;
		$currentYear = date('Y');
		while ($tempYear <= $currentYear) {
			$years[] = $tempYear++;
		}
	}

	// We make sure that the submitted birth month is actually valid
	if(isset($_POST['birthmonth']) && $_POST['birthmonth'] >= 0 && $_POST['birthmonth'] < 12) {
		$birthmonth = $_POST['birthmonth'];
	}

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

	// ==== 2nd homework 3rd exercise ====
	// Build month options
	$currentMonth = date('n') - 1;
	$monthOptions = ''; // Initialize with empty string.
	for($i = 0; $i < count($monthNames); $i++) {
		$selected = '';
		if (isset($birthmonth)) {
			if ($birthmonth == $i) {
				$selected = 'selected';
			}
		} elseif ($currentMonth == $i) {
			$selected = 'selected';
		}
		// "$a .= $b" is the same as "$a = $a . $b"
		$monthOptions .= '<option value="' . $i . '" ' . $selected . ' >' . $monthNames[$i] . '</option>';
	}
	

?>
<?php require_once('includes/header.php'); ?>
	<div class="container mt-4">
		<div class="row">
			<div class="col">
				<div class="center">
					<h3>Tere, <?php echo $firstName . ' ' . $lastName ?>!</h3>
				</div>
				<hr>
				<form method="post">
					<div class="form-group">
						<label for="inputName">First name</label>
						<input type="text" class="form-control" name="firstname" id="inputFirstName" value="<?php echo $firstName; ?>" placeholder="Sisesta oma eesnimi">
					</div>
					<div class="form-group">
						<label for="inputName">Last name</label>
						<input type="text" class="form-control" name="lastname" id="inputLastName" value="<?php echo $lastName; ?>" placeholder="Sisesta oma perekonnanimi">
					</div>
					<div class="form-group">
						<label for="inputName">Sünniaasta</label>
						<input type="number" class="form-control" name="birthyear" min="1918" max="2000" id="inputBirthyear" placeholder="Sisesta oma vanus" value="<?php echo $birthYear; ?>">
					</div>
					<div class="form-group">
						<label for="inputName">Sünnikuu</label>
						<select class="form-control" name="birthmonth">
							<?php 
								echo $monthOptions;
							?>
						</select>
					</div>
					<button type="submit" class="btn btn-primary">Salvesta</button>
				</form>
			</div>
			<?php
				if (isset($years)) {
					echo '<div class="col"><div class="center"><h3>Oled elanud aastatel:</h3></div>';
					echo '<ul class="list-group list-group-flush">';
					foreach($years as $year) {
						echo '<li class="list-group-item">' . $year . '</li>';
					}
					echo '</ul></div>';
				}
			?>
		</div>

	</div>
<?php require_once('includes/footer.php'); ?>
