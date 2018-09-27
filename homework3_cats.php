<?php	
    require_once('includes/functions.php');

	$active = 'homework3_cats';
    $title = 'Kassid';
    $success = false;
    $error = false;
    $name = $color = ''; 
    $tail = 5;


    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (!isset($_POST['name']) || empty($_POST['name'])) {
            $error = "Palun sisesta kassi nimi";
        } else {
            $name = cleanInput($_POST['name']);
        }
        if (!isset($_POST['color']) || empty($_POST['color'])) {
            $error = "Palun sisesta kassi värv!";
        } else {
            $color = cleanInput($_POST['color']);
        }
        if (!isset($_POST['tail']) || empty($_POST['tail'])) {
            $error = "Palun sisesta saba pikkus!";
        } else if (!filter_var($_POST['tail'], FILTER_VALIDATE_INT)) {
            $error = "Saba pikkus peab olema arv!";
        } else {
            $tail = intval($_POST['tail']);
            if ($tail <= 0) {
                $error = "Saba pikkus peab olema 0'st suurem arv!";
            }
        }
        if (!$error) {
            if (saveCat($name, $color, $tail)) {
                $success = true;
            } else {
                $error = "Kassi salvestamine ebaõnnestus!";
            }
        }   
    }


?>
<?php require_once('includes/header.php'); ?>
	<div class="container mt-4">
		<div class="row">
			<div class="col">
				<div class="center">
					<h3>Lisa kass</h3>
				</div>
				<hr>
                <?php
                    if ($error) {
                        echo alert($error, 'danger');
                    } else if ($success) {
                        echo alert('Kass salvestatud edukalt', 'success');
                    }
                ?>
				<form method="post">
					<div class="form-group">
						<label for="inputName">Kassi nimi</label>
						<input type="text" class="form-control" name="name" id="inputName" placeholder="Sisesta kassi nimi" value="<?php echo $name; ?>" required>
					</div>
					<div class="form-group">
						<label for="inputName">Kassi värv</label>
						<input type="text" class="form-control" name="color" id="inputColor" placeholder="Sisesta kassi värv" value="<?php echo $color; ?>" required>
					</div>
					<div class="form-group">
						<label for="inputName">Kassi saba pikkus</label>
						<input type="number" min="1" step="1" class="form-control" name="tail" id="inputTail" placeholder="Sisesta saba pikkus" value="<?php echo $tail; ?>" required>
					</div>
					<button type="submit" class="btn btn-primary">Lisa kass</button>
				</form>
			</div>
            <div class="col">
                <div class="center">
                    <h3>Salvestatud sõnumid</h3>
				</div>
				<hr>
				<div class="list-group">
                    <?php 
                        $cats = getCats();
                        foreach ($cats as $cat) {
                            echo '<div class="list-group-item flex-column align-items-start">' .
                                    '<div class="d-flex w-100 justify-content-between">' .
                                        '<span>Nimi: ' . cleanInput($cat['name']) . ' -  Värv:  ' . cleanInput($cat['color']) . '</span>' .
                                        '<span class="text-nowrap">Saba pikkus: ' . cleanInput($cat['tail_length']) . '</span>' .
                                    '</div>' .
                                '</div>';
                        }
                    ?>
                </div>
			</div>
		</div>

	</div>
<?php require_once('includes/footer.php'); ?>
