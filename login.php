<?php

require_once('includes/functions.php');

if ($loggedIn) {
    // Already logged in. Nothing to do here.
    goBack();
    die();
}

if (!isset($_POST['email']) || !isset($_POST['password'])) {
    $_SESSION['loginError'] = "Palun täida kõik väljad";
    goBack();
    die();
}

$user = login($_POST['email'], $_POST['password']);

if ($user === null) {
    $_SESSION['loginError'] = "Vale kasutajanimi või parool";
} else {
    $_SESSION['user'] = $user;
}

goBack();
die();

?>