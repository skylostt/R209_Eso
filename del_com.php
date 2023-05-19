<?php
session_start();
include('db_class.php');

if (!isset($_GET['idCom']) OR !isset($_SESSION['user']) OR !isset($_GET['idProd'])) {
    header('location: index.php');
}

$db = new MyDB();
$req = $db->prepare("DELETE FROM Commentaires WHERE idCom=:idCom AND idUser=:idUser");
$req->bindValue(":idCom", $_GET['idCom']);
$req->bindValue(":idUser", $_SESSION['user']['idUser']);
$req->execute();

header('location: article.php?id='.$_GET['idProd']);

?>
