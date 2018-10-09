<?php
    require_once('includes/functions.php');
	
	$active = 'homework5_users';
    $title = 'Kasutajad';

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
                <div class="table-responsive">
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
                        <tbody>
                            <?php 
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
                            ?>                            
                        </tbody>
                    </table>
                </div>
			</div>
		</div>

	</div>
<?php require_once('includes/footer.php'); ?>
