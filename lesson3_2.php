<?php	
	$active = 'lesson3_2';

	$firstName = "Kodanik";
	$lastName = "Tundmatu";
	
	if(isset($_POST['firstname']) && isset($_POST['lastname'])) {
		$firstName = htmlspecialchars($_POST['firstname']);
		$lastName = htmlspecialchars($_POST['lastname']);
	}
	if(isset($_POST['birthyear'])) {
		$birthYear = $_POST['birthyear'];
		$currentYear = date('Y');
		while ($birthYear <= $currentYear) {
			$years[] = $birthYear++;
		}
		
	}
	

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
					<h3>Tere, <?php echo $firstName . ' ' . $lastName ?>!</h3>
				</div>
				<hr>
				<form method="post">
					<div class="form-group">
						<label for="inputName">First name</label>
						<input type="text" class="form-control" name="firstname" id="inputFirstName" placeholder="Sisesta oma eesnimi">
					</div>
					<div class="form-group">
						<label for="inputName">Last name</label>
						<input type="text" class="form-control" name="lastname" id="inputLastName" placeholder="Sisesta oma perekonnanimi">
					</div>
					<div class="form-group">
						<label for="inputName">Sünniaasta</label>
						<input type="number" class="form-control" name="birthyear" min="1918" max="2000" id="inputBirthyear" placeholder="Sisesta oma vanus" value="1998">
					</div>
					<div class="form-group">
						<label for="inputName">Sünnikuu</label>
						<select name="birthMonth">
							<?php 
								$currentMonth = date('n');
							?>
							<option value="1" <?php if ($currentMonth == 1) echo 'selected'; ?> >jaanuar</option>
							<option value="2" <?php if ($currentMonth == 2) echo 'selected'; ?> >veebruar</option>
							<option value="3" <?php if ($currentMonth == 3) echo 'selected'; ?> >märts</option>
							<option value="4" <?php if ($currentMonth == 4) echo 'selected'; ?> >aprill</option>
							<option value="5" <?php if ($currentMonth == 5) echo 'selected'; ?> >mai</option>
							<option value="6" <?php if ($currentMonth == 6) echo 'selected'; ?> >juuni</option>
							<option value="7" <?php if ($currentMonth == 7) echo 'selected'; ?> >juuli</option>
							<option value="8" <?php if ($currentMonth == 8) echo 'selected'; ?> >august</option>
							<option value="9" <?php if ($currentMonth == 9) echo 'selected'; ?> >september</option>
							<option value="10" <?php if ($currentMonth == 10) echo 'selected'; ?> >oktoober</option>
							<option value="11" <?php if ($currentMonth == 11) echo 'selected'; ?> >november</option>
							<option value="12" <?php if ($currentMonth == 12) echo 'selected'; ?> >detsember</option>
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

	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
	<script type="text/javascript" src="app.js"></script>
</body>

</html>
