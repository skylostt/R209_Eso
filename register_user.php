<?php
session_start();
if (! isset($_POST['email']) OR ! isset($_POST['password']) OR ! isset($_POST['username']) OR ! filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
{
    $_SESSION['error'] = "Erreur, formulaire invalide";
    header("location: login.php");
}
?>
