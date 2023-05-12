<?php
session_start();
include('db_class.php');
$sid = session_id();
$db = new MyDB();

$idprod = 1;


$q_panier = $db->query("SELECT quantite FROM Paniers JOIN Utilisateurs ON Utilisateurs.idUser = Paniers.idUser WHERE idProd=".$idprod." AND username='".$_SESSION['username']."' ;")->fetchArray()['quantite'];
$q_dispo = $db->query("SELECT quantite FROM Articles WHERE idProd=".$idprod.";")->fetchArray()['quantite'];

$req_change_qte = "UPDATE Articles SET quantite=".$q_panier+$q_dispo." WHERE idProd='".$idprod."';";
$db->query($req_change_qte);
?>
