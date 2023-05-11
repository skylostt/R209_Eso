<?php
session_start();
if (isset($_SESSION['username']) AND isset($_POST['current_password']) AND isset($_POST['new_password'])) {
    include('db_class.php');
    $db = new MyDB();
    $curr_hash = hash('sha512', $_POST['current_password']);
    $curr_req = "SELECT password FROM Utilisateurs WHERE username='".$_SESSION['username']."'";
    $curr_pass = $db->query($curr_req)->fetchArray()['password'];
    if ($curr_hash === $curr_pass) {
        $new_hash = hash('sha512', $_POST['new_password']);
        $update_req = "UPDATE Utilisateurs SET password='".$new_hash."'";
        $db->query($update_req);
        $_SESSION['ok'] = 'Mot de passe modifié avec succés.';

    } else {
        $_SESSION['error'] = "Erreur, mot de passe actuel invalide.";
    }
    $db->close();
} else {
    $_SESSION['error'] = "Erreur dans la saisie du formulaire.";
}
header('location: account.php');
?>
