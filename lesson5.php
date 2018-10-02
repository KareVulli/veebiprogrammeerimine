<?php	
    require_once('includes/functions.php');

	$active = 'lesson5';
    $title = 'Kasutaja loomine';
    $success = false;
    $errors = [];
    $name = $color = ''; 
    $tail = 5;
    $currentYear = intval(date('Y'));
    $birthDay = intval(date('j'));
	$birthMonth = date('n') - 1;
    $birthYear = $currentYear - 15;
    $gender = 0;


    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        // Validate First name
        if (!isset($_POST['firstname']) || empty($_POST['firstname'])) {
            $errors['firstname'] = "Palun sisesta eesnimi";
        } else {
            $firstname = cleanInput($_POST['firstname']);
        }

        // Validate Last name
        if (!isset($_POST['lastname']) || empty($_POST['lastname'])) {
            $errors['lastname'] = "Palun sisesta perekonnanimi";
        } else {
            $lastname = cleanInput($_POST['lastname']);
        }

        // Validate User name
        if (!isset($_POST['username']) || empty($_POST['username'])) {
            $errors['username'] = "Palun sisesta kasutajanimi";
        } else {
            $username = cleanInput($_POST['username']);
        }

        // Validate Password and check it's length and confirmation
        if (!isset($_POST['password']) || empty($_POST['password'])) {
            $errors['password'] = "Palun sisesta parool";
        } elseif (strlen($_POST['password']) < 8) {
            $errors['password'] = "Parool peab olema vähemalt 8 tähemärki pikk";
        } elseif (!isset($_POST['confirmpassword']) || $_POST['confirmpassword'] !== $_POST['password']) {
            $errors['password'] = "Paroolid ei kattu";
        } else {
            $password = cleanInput($_POST['password']);
        }

        // Validate Email and it's format
        if (!isset($_POST['email']) || empty($_POST['email'])) {
            $errors['email'] = "Palun sisesta email";
        } else {
            $email = cleanInput($_POST['email']);
            if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                $errors['email'] = "Kontrolli oma emaili!";
            }
        }

        // Validate Birthday
        if (!isset($_POST['birthday']) || empty($_POST['birthday'])) {
            $errors['birthday'] = "Palun sisesta sünnikuupäev!";
        } else if (!filter_var($_POST['birthday'], FILTER_VALIDATE_INT)) {
            $errors['birthday'] = "Sünnikuupäev peab olema arv!";
        } else {
            $birthDay = intval($_POST['birthday']);
            if ($birthDay < 1 || $birthDay > 31) {
                $errors['birthday'] = "Sünnikuupäev peab olema 1 ja 31 vahel!";
            }
        }

        // Validate Birth month
        if (!isset($_POST['birthmonth']) || empty($_POST['birthmonth'])) {
            $errors['birthmonth'] = "Palun sisesta sünnikuu!";
        } else if (!filter_var($_POST['birthmonth'], FILTER_VALIDATE_INT)) {
            $errors['birthmonth'] = "Sünnikuu peab olema arv!";
        } else {
            $birthMonth = intval($_POST['birthmonth']);
            if ($birthMonth < 1 || $birthMonth > 12) {
                $errors['birthmonth'] = "Sünnikuupäev peab olema 1 ja 12 vahel!";
            }
        }

        // Validate Birth year
        if (!isset($_POST['birthyear']) || empty($_POST['birthyear'])) {
            $errors['birthyear'] = "Palun sisesta sünniaasta!";
        } else if (!filter_var($_POST['birthyear'], FILTER_VALIDATE_INT)) {
            $errors['birthyear'] = "Sünniaasta peab olema arv!";
        } else {
            $birthYear = intval($_POST['birthyear']);
            if ($birthYear > $currentYear - 1) {
                $errors['birthyear'] = "Sünniaasta peab olema sellest aastast väiksem!";
            }
        }

        // Check if birthday is valid and format it to mysql format
        if(checkdate($birthMonth, $birthDay, $birthYear)) {
            // I strongly recommend to use object oriented versions of DateTime functions
            $birthDate = new DateTime();
            $birthDate->setDate($birthYear, $birthMonth, $birthDay);
            $birthDate = $birthDate->format('Y-m-d');
        } else {
            $errors['birthday'] = "Valitud kuupäev ei ole kehtiv!";
        }

        // Since 0 value won't be added to post request. i will just check if gender is female then set gender to 1, otherwise 0.
        if (isset($_POST['gender']) && filter_var($_POST['gender'], FILTER_VALIDATE_INT) && $_POST['gender'] > 0) {
            $gender = 1;
        } else {
            $gender = 0; // Isn't really necessary
        }

        // If no errors were found, save the user.
        if (!count($errors)) {
            if (saveUser($firstname, $lastname, $username, $email, $password, $birthDate, $gender)) {
                $success = true;
                // Reset fields
                $firstname = $lastname = $username = $email = $password = '';
                // Ugly copy pasta
                $birthDay = intval(date('j'));
                $birthMonth = date('n') - 1;
                $birthYear = $currentYear - 15;
                $gender = 0;
            } else {
                $error = "Kasutaja salvestamine ebaõnnestus!";
            }
        }   
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

	// Build month options
	$monthOptions = '';
	for($i = 0; $i < count($monthNames); $i++) {
		$selected = '';
        if ($birthMonth - 1 == $i) {
            $selected = 'selected';
        }
		$monthOptions .= '<option value="' . ($i + 1) . '" ' . $selected . ' >' . $monthNames[$i] . '</option>';
	}


?>
<?php require_once('includes/header.php'); ?>
	<div class="container mt-4">
		<div class="row">
			<div class="col">
				<div class="center">
					<h3>Loo kasutaja</h3>
				</div>
				<hr>
                <?php
                    if (isset($error)) {
                        echo alert($error, 'danger');
                    } elseif (count($errors)) {
                        echo alert('Kasutaja loomisel tekkis viga. Kontrolli sisestatud informatsiooni.', 'danger');
                    } else if ($success) {
                        echo alert('Kasutaja loodi edukalt', 'success');
                    }
                ?>
				<form method="post">
					<div class="form-row">
                        <div class="form-group col">
                            <label for="inputName">Eesnimi</label>
                            <input type="text" class="form-control <?php if (isset($errors['firstname'])) echo "is-invalid"; ?>" name="firstname" id="inputFirstname" value="<?php if (isset($firstname)) echo $firstname; ?>" required>
                            <?php if(isset($errors['firstname'])) echo '<div class="invalid-feedback">' . $errors['firstname'] . '</div>'; ?> 
                        </div>
                        <div class="form-group col">
                            <label for="inputName">Perekonnanimi</label>
                            <input type="text" class="form-control <?php if (isset($errors['lastname'])) echo "is-invalid"; ?>" name="lastname" id="inputLastname" value="<?php if (isset($lastname)) echo $lastname; ?>" required>
                            <?php if(isset($errors['lastname'])) echo '<div class="invalid-feedback">' . $errors['lastname'] . '</div>'; ?> 
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col">
                            <label for="inputName">Kasutajanimi</label>
                            <input type="text" class="form-control <?php if (isset($errors['username'])) echo "is-invalid"; ?>" name="username" id="inputUsername" value="<?php if (isset($username)) echo $username; ?>" required>
                            <?php if(isset($errors['username'])) echo '<div class="invalid-feedback">' . $errors['username'] . '</div>'; ?> 
                        </div>
                        <div class="form-group col">
                            <label for="inputName">Email</label>
                            <input type="email" class="form-control <?php if (isset($errors['email'])) echo "is-invalid"; ?>" name="email" id="inputEmail" value="<?php if (isset($email)) echo $email; ?>" required>
                            <?php if(isset($errors['email'])) echo '<div class="invalid-feedback">' . $errors['email'] . '</div>'; ?> 
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col">
                            <label for="inputPassword4">Parool</label>
                            <input type="password" class="form-control <?php if (isset($errors['password'])) echo "is-invalid"; ?>" name="password" id="inputPassword">
                            <?php if(isset($errors['password'])) echo '<div class="invalid-feedback">' . $errors['password'] . '</div>'; ?> 
                        </div>
                        <div class="form-group col">
                            <label for="inputPassword4">Kinnita Parool</label>
                            <input type="password" class="form-control" name="confirmpassword" id="inputConfirmPassword">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col">
                            <label for="inputName">Sünnipäev</label>
                            <input type="number" class="form-control <?php if (isset($errors['birthday'])) echo "is-invalid"; ?>" name="birthday" min="1" max="31" id="inputBirthday" value="<?php echo $birthDay; ?>">
                            <?php if(isset($errors['birthday'])) echo '<div class="invalid-feedback">' . $errors['birthday'] . '</div>'; ?> 
                        </div>
                        <div class="form-group col">
                            <label for="inputName">Sünnikuu</label>
                            <select class="form-control <?php if (isset($errors['birthmonth'])) echo "is-invalid"; ?>" name="birthmonth">
                                <?php 
                                    echo $monthOptions;
                                ?>
                            </select>
                            <?php if(isset($errors['birthmonth'])) echo '<div class="invalid-feedback">' . $errors['birthmonth'] . '</div>'; ?> 
                        </div>
                        <div class="form-group col">
                            <label for="inputName">Sünniaasta</label>
                            <input type="number" class="form-control <?php if (isset($errors['birthyear'])) echo "is-invalid"; ?>" name="birthyear" min="1918" id="inputBirthyear" value="<?php echo $birthYear; ?>">
                            <?php if(isset($errors['birthyear'])) echo '<div class="invalid-feedback">' . $errors['birthyear'] . '</div>'; ?> 
                        </div>
                    </div>
					<div class="form-group">
                        <label for="inputName">Sugu</label>
                        <div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input class="custom-control-input" type="radio" name="gender" id="genderMale" value="0" required <?php if ($gender == 0) echo 'checked'; ?>>
                                <label class="custom-control-label" for="genderMale">Mees</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input class="custom-control-input" type="radio" name="gender" id="genderFemale" value="1" required <?php if ($gender == 1) echo 'checked'; ?>>
                                <label class="custom-control-label" for="genderFemale">Naine</label>
                            </div>
                        </div>
					</div>
					<button type="submit" class="btn btn-primary">Loo kasutaja</button>
				</form>
			</div>
		</div>
	</div>
<?php require_once('includes/footer.php'); ?>
