<?php	
require_once('includes/functions.php');
require_once('includes/functions/messages.php');

$active = 'lesson7_validated';
$title = 'Valideeritud sõnumid';
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

$users = getMessagesByValidaters();

?>
<?php require_once('includes/header.php'); ?>
	<div class="container mt-4">
		<div class="row">
			<div class="col">
				<h4>Valideeritud sõnumid</h4>
                <hr>
                <div class="list-group">
                    <?php 
                        foreach ($users as $user) {
                            echo '<div class="card mb-3">
                                    <div class="card-header"><strong>' . $user['name'] . '</strong></div>
                                    <div class="list-group list-group-flush">';

                                    foreach ($user['messages'] as $message) {
                                        echo '<div class="list-group-item flex-column align-items-start">' .
                                            '<div class="d-flex w-100 justify-content-between">' .
                                                '<span>' . cleanInput($message['message']) . '</span>' .
                                                '<small class="text-nowrap"><p class="m-0">Loodud: ' . cleanInput($message['created']) . '</p>' .
                                                    '<p class="m-0">Valideeritud: ' . cleanInput($message['accepted_at']) . '</p>' .
                                                '</small>' .
                                            '</div>' .
                                        '</div>';
                                    }

                            echo '</div></div>';
                        }
                    ?>
                </div> 
			</div>
		</div>
	</div>
<?php require_once('includes/footer.php'); ?>
