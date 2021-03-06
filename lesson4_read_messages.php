<?php
    require_once('includes/functions.php');
    require_once('includes/functions/messages.php');
	
	$active = 'lesson4_read_messages';
    $title = 'Salvestatud sõnumid';

    $messages = getMessages();
?>
<?php require_once('includes/header.php'); ?>
	<div class="container mt-4">
		<div class="row">
			<div class="col">
				<div class="center">
					<h3>Salvestatud ja valideeritud sõnumid</h3>
				</div>
				<hr>
				<div class="list-group">
                    <form>
                    <?php 
                        foreach ($messages as $message) {
                            echo '<div class="list-group-item flex-column align-items-start">' .
                                    '<div class="d-flex w-100 justify-content-between">' .
                                        '<span>' . cleanInput($message['message']) . '</span>' .
                                        '<small class="text-nowrap">' . cleanInput($message['created']) . '</small>' .
                                    '</div>' .
                                '</div>';
                        }
                    ?>
                    </form>
                </div>
			</div>
		</div>

	</div>
<?php require_once('includes/footer.php'); ?>
