<?php
session_start();
if (isset($_POST['username']) AND isset($_POST['password']))
{
    $bdd = new PDO('mysql:host=localhost;dbname=test', 'root', '');
    $pass = $bdd->query("SELECT password FROM users WHERE username='".$_POST['username']."';")->fetch()['password'];
    if ($pass != "" AND $pass == sha1($_POST['password']))
    {
        $_SESSION['username'] = $_POST['username'];
        if ($_POST["store"])
        {
            setcookie("username", $_POST['username'], time()+365*24*3600);
            setcookie("password", $_POST['password'], time()+365*24*3600);
        }
        else
        {
            setcookie("username", "");
            setcookie("password", "");
        }
        header('Location: /');
    }
    else
    {
        $_SESSION["error"] = "Erreur, mot de passe ou nom d'utilisateur invalide.";
        header('Location: login');
    }
}
else
{
    header('Location: login');
}
?>
