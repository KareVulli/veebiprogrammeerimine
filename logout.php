<?php
    require_once('includes/functions.php');
    session_DESTROY(); // :P
    header('Location: index.php');
?>