<?php
session_start();
include('db_class.php');

// Si les données du GET sont invalides, quitter
if (!isset($_GET['idCom']) OR !isset($_SESSION['user']) OR !isset($_GET['idProd'])) {
    header('location: index.php');
    exit;
}

$db = new MyDB();
// On supprime le commentaire si c'est le bon utilisateur qui a executé la requête
$req = $db->prepare("DELETE FROM Commentaires WHERE idCom=:idCom AND idUser=:idUser");
$req->bindValue(":idCom", $_GET['idCom']);
$req->bindValue(":idUser", $_SESSION['user']['idUser']);
$req->execute();

header('location: article.php?id='.$_GET['idProd']);

?>
