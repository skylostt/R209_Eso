<?php
session_start();
include('db_class.php');

$db = new MyDB();
$sid = session_id();

if (isset($_GET['id']) AND is_numeric($_GET['id'])) {
    if (isset($_SESSION['user']['username'])) {
        $id_user = $db->query("SELECT idUser FROM Utilisateurs WHERE username='".$_SESSION['user']['username']."';")->fetchArray()['idUser'];
        $req = "DELETE FROM Paniers WHERE idProd=".$_GET['id']." AND idUser='".$id_user."';";
        $q_panier = $db->query("SELECT quantite FROM Paniers JOIN Utilisateurs ON Utilisateurs.idUser = Paniers.idUser WHERE idProd=".$_GET['id']." AND username='".$_SESSION['user']['username']."' ;")->fetchArray()['quantite'];
    } else {
        $sid = session_id();
        $req = "DELETE FROM Paniers WHERE idProd=".$_GET['id']." AND idSession='".$sid."';";
        $q_panier = $db->query("SELECT quantite FROM Paniers WHERE idProd=".$_GET['id']." AND idSession='".$sid."' ;")->fetchArray()['quantite'];
    }
    $q_dispo = $db->query("SELECT quantite FROM Articles WHERE idProd=".$_GET['id'].";")->fetchArray()['quantite'];
    $req_change_qte = "UPDATE Articles SET quantite=".$q_panier+$q_dispo." WHERE idProd='".$_GET['id']."';";
    $db->query($req_change_qte);
    $db->query($req);
    $_SESSION['ok'] = "L'article a bien été supprimé.";
    header('location: panier.php');

} else {
    echo "Erreur, requête invalide...";
}
?>
