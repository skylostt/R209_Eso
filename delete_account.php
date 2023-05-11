<?php
session_start();
if (isset($_SESSION['username']) AND isset($_POST['password'])) {
    include('db_class.php');
    $db = new MyDB();
    $pass_hash = hash('sha512', $_POST['password']);
    $pass_req = "SELECT password FROM Utilisateurs WHERE username='".$_SESSION['username']."'";
    $pass = $db->query($pass_req)->fetchArray()['password'];
    if ($pass_hash === $pass) {
        $new_hash = hash('sha512', $_POST['new_password']);
        $del_req = "DELETE FROM Utilisateurs WHERE password='".$pass_hash."'";
        $db->query($del_req);
        unset($_SESSION['username']);
        $_SESSION['ok'] = "Compte supprimé avec succès.";
        header('location: login.php');

    } else {
        $_SESSION['error'] = "Erreur, mot de passe invalide.";
        header('location: account.php');
    }
    $db->close();
} else {
    $_SESSION['error'] = "Erreur dans la saisie du formulaire.";
    header('location: account.php');
}
?>
