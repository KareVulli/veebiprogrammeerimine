<?php
    require_once('includes/functions.php');
	
	$active = 'lesson14_news';
    $title = 'Uudised';

?>
<?php require_once('includes/header.php'); ?>
	<div class="container mt-4">
		<div class="row">
			<div class="col">
				<div class="center">
					<h3>Uudised</h3>
				</div>
				<hr>
                <?php require('includes/news.php'); ?>
			</div>
		</div>
	</div>
<?php require_once('includes/footer.php'); ?>
