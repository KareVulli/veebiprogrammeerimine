<?php

require_once('includes/functions.php');

if (!isset($_POST['email']) || !isset($_POST['password'])) {
    $_SESSION['loginError'] = "Palun täida kõik väljad";
    if(isset($_SERVER['HTTP_REFERER'])) {
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    } else {
        header('Location: index.php');
    }
    die();
}

$user = login($_POST['email'], $_POST['password']);

if ($user === null) {
    $_SESSION['loginError'] = "Vale kasutajanimi või parool";
} else {
    $_SESSION['user'] = $user;
}

if(isset($_SERVER['HTTP_REFERER'])) {
    header('Location: ' . $_SERVER['HTTP_REFERER']);
} else {
    header('Location: index.php');
}
die();

?>