<?php
session_start();
include('db_class.php');
if (isset($_POST['username']) AND isset($_POST['password']) AND ! isset($_SESSION["username"]))
{
    $sid = session_id();
    $db = new MyDB();
    $req = $db->prepare("SELECT * FROM Utilisateurs WHERE username=:username AND password=:password;");
    $req->bindValue(':username', $_POST['username']);
    $req->bindValue(':password', hash('sha512', $_POST['password']));
    $entry = $req->execute()->fetchArray();
    if (! empty($entry))
    {
        $_SESSION['user'] = $entry;
        $_SESSION['message'] = "Vous avez bien été connecté";

        $update_cart = $db->prepare("UPDATE Paniers SET idUser=:user WHERE idSession=:session");
        $update_cart->bindValue(":user", $_SESSION['user']['idUser']);
        $update_cart->bindValue(":session", $sid);
        $update_cart->execute();

        header('Location: '.$_SESSION['last_page']);
    }
    else
    {
        $_SESSION["error"] = "Erreur, mot de passe ou nom d'utilisateur invalide.";
        header('Location: login.php');
    }
}
else if (isset($_SESSION["username"]))
{
    echo "vous êtez déjà connecté";
}
else
{
    header('Location: login.php');
}
?>
