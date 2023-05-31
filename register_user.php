<?php
session_start();
include('db_class.php');
// Si le formulaire est invalide, quitter le script
if (! isset($_POST['email']) OR ! isset($_POST['password']) OR ! isset($_POST['username']) OR ! filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    $_SESSION['error'] = "Erreur, formulaire invalide";
    header("location: login.php");
    exit;
} else {
    // On vérifie que le nom d'utilisateur n'est que composé de caractères alphanumériques
    $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
    foreach (str_split($_POST['username']) as $i) {
        if (! str_contains($_POST['username'], $i)) {
            $_SESSION['error'] = "Erreur, nom d'utilisateur invalide";
            header("location: login.php");
            exit;
        }
    }
    // On hache son mot de passe pour le stocker dans la bdd
    $hash_pass = hash('sha512', $_POST['password']);
    $db = new MyDB();
    $req = $db->prepare("SELECT * FROM Utilisateurs WHERE username=:username AND mail=:email;");
    $req->bindValue(':username', $_POST['username']);
    $req->bindValue(':email', $_POST["email"]);
    $check_array = $req->execute()->fetchArray();
    // On vérifie que le nom d'utilisateur et l'email ne soient pas déjà pris
    if (! empty($check_array)) {
        $_SESSION['error'] = "Erreur, l'utilisateur ".$_POST['username']." existe déjà !";
    } else {
        // On insère dans la base de données
        $insert = $db->prepare('INSERT INTO Utilisateurs (username, mail, password, droits) VALUES (:username, :email, :hash, :droits);');
        $insert->bindValue(':username', $_POST["username"]);
        $insert->bindValue(':email', $_POST["email"]);
        $insert->bindValue(':hash', $hash_pass);
        $insert->bindValue(':droits', 0);
        $insert->execute();
        $db->close();
        $_SESSION['ok'] = "Inscription réussie.";
    }
    header('location: login.php');
}
?>
