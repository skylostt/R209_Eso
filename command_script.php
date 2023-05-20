<?php
session_start();
include('db_class.php');
$db = new MyDB();
if (! isset($_SESSION['user'])) {
    header('location: login.php');
}

if (! isset($_POST['address'])) {
    header('location: command.php');
}

$panier = $db->query("SELECT * FROM Paniers WHERE idUser=".$_SESSION['user']['idUser']);

while ($donnees=$panier->fetchArray()) {
    $q_dispo = $db->query("SELECT quantite FROM Articles WHERE idProd='".$donnees['idProd']."';")->fetchArray()['quantite'];
    if ($q_dispo < $donnees['quantite']) {
        $_SESSION['error'] = "Attention : un article de votre panier n'est pas disponible pour le moment.";
    } else {
        $req_change_qte = "UPDATE Articles SET quantite=".$q_dispo-$donnees['quantite']." WHERE idProd='".$_GET['prod']."';";
        $db->query($req_change_qte);
    }
}

?>
