<?php
    require_once('includes/functions.php');
	
	$active = 'lesson4_add_message';
    $title = 'Sõnumi lisamine';
    $success = false;
    $error = false;
    $message = ''; 


    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (!isset($_POST['message']) || empty($_POST['message'])) {
            $error = "Palun sisesta sõnum!";
        }
        $message = cleanInput($_POST['message']);
        if (!$error) {
            if (saveMessage($message)) {
                $success = true;
                // Clear the message variable, so the massage isn't shown again in the textbox
                $message = "";
            } else {
                $error = "Sõnumi salvestamine ebaõnnestus!";
            }
        }   
    }


?>
<?php require_once('includes/header.php'); ?>
	<div class="container mt-4">
		<div class="row">
			<div class="col">
				<div class="center">
					<h3>Lisa sõnum</h3>
				</div>
				<hr>
                <?php
                    if ($error) {
                        echo alert($error, 'danger');
                    } else if ($success) {
                        echo alert('Sõnum salvestatud edukalt.', 'success');
                    }
                ?>
				<form method="post">
					<div class="form-group">
						<label for="inputName">Sõnum <small>(max 256 märki)</small></label>
						<textarea class="form-control" name="message" id="inputMessage" rows="3" placeholder="Sisesta oma sõnum" required><?php echo $message; ?></textarea>
					</div>
					<button type="submit" class="btn btn-primary">Salvesta sõnum</button>
				</form>
			</div>
		</div>

	</div>
<?php require_once('includes/footer.php'); ?>
