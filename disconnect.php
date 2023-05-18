<?php
session_start();
// On vide la variable de session
$_SESSION = array();
$_SESSION['ok'] = "Vous avez bien été déconnecté.";
header('location: login.php');
?>
