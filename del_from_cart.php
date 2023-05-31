<?php
session_start();
include('db_class.php');

$db = new MyDB();
$sid = session_id();

if (isset($_GET['id']) AND is_numeric($_GET['id'])) {
    // Si le nom d'utilisateur est défini, supprimer l'article du panier de l'utilisateur ayant executé la requête
    $req = isset($_SESSION['user']['username']) ?
        $req = "DELETE FROM Paniers WHERE idProd=".$_GET['id']." AND idUser='".$_SESSION['user']['idUser']."';" :
        $req = "DELETE FROM Paniers WHERE idProd=".$_GET['id']." AND idSession='".$sid."' AND idUser IS NULL;";

    $db->query($req);
    $_SESSION['ok'] = "L'article a bien été supprimé du panier.";
    header('location: panier.php');

} else {
    echo "Erreur, requête invalide...";
}
?>
