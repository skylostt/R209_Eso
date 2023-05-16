<?php
session_start();
include('db_class.php');
$db = new MyDB();
$_SESSION['perm'] = 'admin';
if (isset($_SESSION['perm']) AND isset($_GET['id']) AND $_SESSION['perm'] === 'admin') {
    $username = $db->prepare("SELECT username FROM Utilisateurs WHERE idUser=:id");
    $username->bindValue(':id', $_GET['id']);
    $user = $username->execute()->fetchArray();
    if (! empty($user)) {
        $del_req = $db->prepare("DELETE FROM Utilisateurs WHERE idUser=:id;");
        $del_req->bindValue(':id', $_GET['id']);
        $del_req->execute();
        $_SESSION['ok'] = "L'utilisateur a bien été banni.";
    } else {
        $_SESSION['error'] = "Erreur, l'utilisateur renseigné n'existe pas.";
    }
    header("location: admin.php");
    $db->close();
}
?>
