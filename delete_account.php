<?php
session_start();
if (isset($_SESSION['user']['username']) AND isset($_POST['password'])) {
    include('db_class.php');
    $db = new MyDB();
    $pass_hash = hash('sha512', $_POST['password']);
    $pass_req = $db->prepare("SELECT * FROM Utilisateurs WHERE username=:username AND password=:pass_hash;");
    $pass_req->bindValue(':username', $_SESSION['user']['username']);
    $pass_req->bindValue(':pass_hash', $pass_hash);
    $pass = $pass_req->execute()->fetchArray();
    // Si le mot de passe du formulaire correspond avec le mot de passe de la bdd
    if (! empty($pass)) {
        // Supprimer l'utilisateur
        $del_req = $db->prepare("DELETE FROM Utilisateurs WHERE username=:username AND password=:hash;");
        $del_req->bindValue(":username", $_SESSION['user']['username']);
        $del_req->bindValue(":hash", $pass_hash);
        $del_req->execute();
        unset($_SESSION['user']['username']);
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
