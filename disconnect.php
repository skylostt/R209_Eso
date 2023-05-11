<?php
session_start();
$_SESSION = array();
$_SESSION['ok'] = "Vous avez bien été déconnecté.";
header('location: login.php');
?>
