<?php	
require_once('includes/functions.php');
require_once('includes/functions/messages.php');

$active = 'lesson6_validate';
$title = 'Valideeri sõnumeid';
$error = false;
$success = false;

if (!$loggedIn) {
	header('Location: index.php');
	die();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['messages']) || count($_POST['messages']) <= 0) {
        $error = "Sa ei valinud ühtegi sõnumit";
    } else {
        foreach ($_POST['messages'] as $id => $value) {
            setMessageValidated($id);
        }
        $success = true;
    }
}

$messages = getMessages(true);

?>
<?php require_once('includes/header.php'); ?>
	<div class="container mt-4">
		<div class="row">
			<div class="col">
				<h4>Valideerimata sõnumid</h4>
                <hr>
                <?php
                    if ($error) {
                        echo alert($error, 'danger');
                    } else if ($success) {
                        echo alert('Sõnumid valideeritud edukalt', 'success');
                    }
                ?>
                <form method="post">
                    <div class="list-group">
                        <?php 
                            foreach ($messages as $message) {
                                echo '<div class="list-group-item flex-column align-items-start">' .
                                        '<div class="d-flex w-100 justify-content-between">' .
                                            '<input type="checkbox" class="mr-2 mt-1" name="messages[' . $message['id'] . ']" value="1" >' .
                                            '<span class="flex-grow-1">' . cleanInput($message['message']) . '</span>' .
                                            '<small class="text-nowrap">' . cleanInput($message['created']) . '</small>' .
                                        '</div>' .
                                    '</div>';
                            }
                        ?>
                    </div>

                    <button type="submit" class="btn btn-primary mt-3">Valideeri valitud sõnumid</button>        
                </form>
			</div>
		</div>
	</div>
<?php require_once('includes/footer.php'); ?>
