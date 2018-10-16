<?php
    require_once('includes/functions.php');
	
	$active = 'homework5_users';
    $title = 'Kasutajad';

    // Get users as an array
    $users = getUsers();
?>
<?php require_once('includes/header.php'); ?>
	<div class="container mt-4">
		<div class="row">
			<div class="col">
				<div class="center">
					<h3>Kasutajad</h3>
				</div>
				<hr>
                <?php
                    // Only show the page if user is logged in
                    if ($loggedIn) {
                        // A template engine would come really helpful here...
                        // This was not required as homework but i added in here since it makes sense.
                        echo '<p class="border border-primary p-2">Oled sisse logitud kasutajana ' . $user['firstname'] . ' ' . $user['lastname'] .
                        ' - Email: ' . $user['email'] . '</p>';
                        echo '<div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Kasutajanimi</th>
                                            <th>Eesnimi</th>
                                            <th>Perekonnanimi</th>
                                            <th>Email</th>
                                            <th>Sünnipäev</th>
                                            <th>Sugu</th>
                                        </tr>
                                    </thead>
                                    <tbody>';
                                         
                        // Print all users as separate rows in the table
                        foreach ($users as $user) {
                            echo '<tr>' .
                                    '<td>' . cleanInput($user['username']) . '</td>' .
                                    '<td>' . cleanInput($user['firstname']) . '</td>' .
                                    '<td>' . cleanInput($user['lastname']) . '</td>' .
                                    '<td>' . cleanInput($user['email']) . '</td>' .
                                    '<td>' . cleanInput($user['birthdate']) . '</td>' .
                                    '<td>' . ($user['gender'] ? 'Naine' : 'Mees') . '</td>' .
                                '</tr>';
                        }
                                                                    
                        echo '</tbody></table></div>';
                    } else {
                        // Show error, if user is NOT logged in
                        echo alert('Palun logi sisse, et seda lehte näha.', 'warning');
                    }
                ?>
			</div>
		</div>

	</div>
<?php require_once('includes/footer.php'); ?>
