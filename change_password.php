<?php
session_start();
if (isset($_SESSION['user']['username']) AND isset($_POST['current_password']) AND isset($_POST['new_password'])) {
    include('db_class.php');
    $db = new MyDB();
    // On hashe le mot de passe actuel
    $curr_hash = hash('sha512', $_POST['current_password']);
    // On récupère le mot de passe actuel hashé
    $curr_req = "SELECT password FROM Utilisateurs WHERE username='".$_SESSION['user']['username']."'";
    $curr_pass = $db->query($curr_req)->fetchArray()['password'];
    // On compare les deux mots de passe actuels
    if ($curr_hash === $curr_pass) {
        // On génère le hash du nouuveau mot de passe
        $new_hash = hash('sha512', $_POST['new_password']);
        // On change le mot de passe
        $update_req = "UPDATE Utilisateurs SET password='".$new_hash."' WHERE username='".$_SESSION['user']['username']."';";
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
