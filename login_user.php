<?php
session_start();
include('db_class.php');
if (isset($_POST['username']) AND isset($_POST['password']))
{
    $db = new MyDB();
    $req = $db->prepare("SELECT password FROM Utilisateurs WHERE username=:username;");
    $req->bindValue(':username', $_POST['username']);
    $pass = $req->execute()->fetchArray()['password'];
    if ( isset($pass) AND $pass != "" AND $pass == hash('sha512', $_POST['password']))
    {
        $_SESSION['username'] = $_POST['username'];
        $_SESSION['message'] = "Vous avez bien été connecté";
        $_SESSION['connected'] = TRUE;
        header('Location: index.php');
    }
    else
    {
        $_SESSION["error"] = "Erreur, mot de passe ou nom d'utilisateur invalide.";
        header('Location: login.php');
    }
}
else if (isset($_SESSION["username"]) AND isset($_SESSION["connected"]))
{
    echo "vous êtez déjà connecté";
}
else
{
    header('Location: login.php');
}
?>
