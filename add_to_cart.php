<?php
session_start();
include('db_class.php');

$sid = session_id();
$db = new MyDB();

if (isset($_GET['prod']) AND isset($_GET['qte']) AND is_numeric($_GET['prod']) AND is_numeric($_GET['qte'])) {
    // On compte le nomnbre d'articles en stock
    $q_dispo = $db->query("SELECT quantite FROM Articles WHERE idProd='".$_GET['prod']."';")->fetchArray()['quantite'];
    // On regarde si le produit à ajouter est déjà dans le panier
    if (isset($_SESSION['username'])) {
        $not_cart_req = "SELECT idProd FROM Paniers JOIN Utilisateurs ON Utilisateurs.idUser = Paniers.idUser WHERE idProd='".$_GET['prod']."' AND username='".$_SESSION['username']."'";
        $is_not_in_cart = empty($db->query($not_cart_req)->fetchArray());
    } else {
        $not_cart_req = "SELECT idProd FROM Paniers WHERE idProd='".$_GET['prod']."' AND idSession='".$sid."'";
        $is_not_in_cart = empty($db->query($not_cart_req)->fetchArray());
    }
    // On vérifie que le produit existe
    $prod_exist = ! empty($db->query("SELECT idProd FROM Articles WHERE idProd='".$_GET['prod']."'")->fetchArray());
    if ($q_dispo >= $_GET['qte'] AND $is_not_in_cart AND $prod_exist) {
        if (isset($_SESSION['username'])) {
            $req_user_id = "SELECT idUser FROM Utilisateurs WHERE username='".$_SESSION['username']."'";
            $userid = $db->query($req_user_id)->fetchArray()['idUser'];
            $req = "INSERT INTO Paniers (idSession, idProd, idUser, quantite) VALUES ('".$sid."', '".$_GET['prod']."', '".$userid."', '".$_GET['qte']."');";
            $db->query($req);
        } else {
            $req = "INSERT INTO Paniers (idSession, idProd, quantite) VALUES ('".$sid."', '".$_GET['prod']."', '".$_GET['qte']."');";
            $db->query($req);
        }
        $req_change_qte = "UPDATE Articles SET quantite=".$q_dispo-$_GET['qte']." WHERE idProd='".$_GET['prod']."';";
        $db->query($req_change_qte);
        $_SESSION['ok'] = "L'article a bien été ajouté au panier.";
    } else {
        $_SESSION['error'] = "Erreur, soit le stock est trop faible, soit l'article n'existe pas, ou soit cet article est déjà dans votre panier.";
    }
} else {
    echo 'requête invalide...';
}
$db->close();
header('location: article.php?id='.$_GET['prod']);

?>
