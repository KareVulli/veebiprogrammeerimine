<?php
    require_once('includes/functions.php');
    require_once('includes/functions/news.php');
    
    if (!$loggedIn) {
        header('Location: index.php');
        die();
    }

	$active = 'lesson14_add_message';
    $title = 'Uudise lisamine';
    $javascript = '<script type="text/javascript" src="//cdn.tinymce.com/4/tinymce.min.js"></script>';
    $javascript .= '<script type="text/javascript" src="assets/js/news.js"></script>';
    $success = false;
    $error = false;
    $title = ''; 
    $message = ''; 
    $expire = date("Y-m-d");


    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (!isset($_POST['title']) || empty($_POST['title'])) {
            $error = "Palun sisesta uudise pealkiri!";
        } else {
            $title = cleanInput($_POST['title']);
        }
        if (!isset($_POST['content']) || empty($_POST['content'])) {
            $error = "Palun sisesta uudise sisu!";
        } else {
            $message = $_POST['content'];
        }
        if (!isset($_POST['expire']) || empty($_POST['expire'])) {
            $error = "Palun sisesta uudise aegumiskuupäev!";
        } elseif (!validateDate($_POST['expire'])) {
            $error = "Palun sisesta korrektne aegumiskuupäev!";
        } else {
            $expire = cleanInput($_POST['expire']);
        }
        
        if (!$error) {

            if (saveNews($title, $message, $expire, $user['id'])) {
                $success = true;
                // Clear the variables, so the old data isn't shown again in the form
                $title = "";
                $message = "";
                $expire = date("Y-m-d");
            } else {
                $error = "Uudise salvestamine ebaõnnestus!";
            }
        }   
    }


?>
<?php require_once('includes/header.php'); ?>
	<div class="container mt-4">
		<div class="row">
			<div class="col">
				<div class="center">
					<h3>Lisa uudis</h3>
				</div>
				<hr>
                <?php
                    if ($error) {
                        echo alert($error, 'danger');
                    } else if ($success) {
                        echo alert('Uudis salvestatud edukalt.', 'success');
                    }
                ?>
				<form method="post">
                    <div class="form-group">
						<label for="title">Pealkiri</label>
						<input type="text" class="form-control" id="title" name="title" value="<?php echo $title; ?>" required>
					</div>
					<div class="form-group">
						<label for="content">Sisu</label>
						<textarea class="form-control" name="content" id="content" rows="3" placeholder="Sisesta uudise sisu"><?php echo $message; ?></textarea>
					</div>
                    <div class="form-group">
						<label for="expire">Aegumiskuupäev (kaasaarvatud)</label>
						<input type="date" min="<?php echo date('Y-m-d'); ?>" class="form-control" id="expire" name="expire" value="<?php echo $expire; ?>" required pattern="[0-9]{4}-[0-9]{2}-[0-9]{2}">
					</div>
					<button type="submit" class="btn btn-primary">Salvesta sõnum</button>
				</form>
			</div>
		</div>

	</div>
<?php require_once('includes/footer.php'); ?>
