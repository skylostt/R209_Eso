<?php
session_start();
include('db_class.php');
if (! isset($_POST['email']) OR ! isset($_POST['password']) OR ! isset($_POST['username']) OR ! filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    $_SESSION['error'] = "Erreur, formulaire invalide";
    header("location: login.php");
} else {
    $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
    foreach (str_split($_POST['username']) as $i) {
        if (! str_contains($_POST['username'], $i)) {
            $_SESSION['error'] = "Erreur, nom d'utilisateur invalide";
            header("location: login.php");
        }
    }
    $hash_pass = hash('sha512', $_POST['password']);
    $db = new MyDB();
    $req = $db->prepare("SELECT * FROM Utilisateurs WHERE username=:username;");
    $req->bindValue(':username', $_POST['username']);
    $check_array = $req->execute()->fetchArray();
    if (! empty($check_array)) {
        $_SESSION['error'] = "Erreur, l'utilisateur ".$_POST['username']." existe déjà !";
        header('location: login.php');
    } else {
        $insert = $db->prepare('INSERT INTO Utilisateurs (username, mail, password, droits) VALUES (:username, :email, :hash, :droits);');
        $insert->bindValue(':username', $_POST["username"]);
        $insert->bindValue(':email', $_POST["email"]);
        $insert->bindValue(':hash', $hash_pass);
        $insert->bindValue(':droits', 0);
        $insert->execute();
        $db->close();
        $_SESSION['ok'] = "Inscription réussie.";
        header('location: login.php');
    }
}
?>
