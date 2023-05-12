<?php
session_start();
include('db_class.php');

$db = new MyDB();

if (isset($_GET['id']) AND isset($_SESSION['username'])) {
    $id_user = $db->query("SELECT idUser FROM Utilisateurs WHERE username='".$_SESSION['username']."';")->fetchArray()['idUser'];
    $req = "DELETE FROM Paniers WHERE idProd=".$_GET['id']." AND idUser='".$id_user."';";
    $db->query($req);
    $db->close();
    $_SESSION['ok'] = "L'article a bien été supprimé.";
    header('location: panier.php');
}
?>
