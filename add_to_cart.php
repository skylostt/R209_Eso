<?php
session_start();
include('db_class.php');

$sid = session_id();
$db = new MyDB();

if (isset($_GET['prod']) AND isset($_GET['qte']) AND is_numeric($_GET['prod']) AND is_numeric($_GET['qte'])) {
    $q_dispo = $db->query("SELECT quantite FROM Articles WHERE idProd='".$_GET['prod']."';")->fetchArray()['quantite'];
    if (isset($_SESSION['username'])) {
        $not_cart_req = "SELECT idProd FROM Paniers JOIN Utilisateurs ON Utilisateurs.idUser = Panier.idUser WHERE idProd='".$_GET['prod']."' AND username='".$_SESSION['username']."'";
        $is_not_in_cart = empty($db->query($not_cart_req)->fetchArray());
    } else {
        $not_cart_req = "SELECT idProd FROM Paniers WHERE idProd='".$_GET['prod']."' AND idSession='".$sid."'";
        $is_not_in_cart = empty($db->query($not_cart_req)->fetchArray());
    }
    $prod_exist = ! empty($db->query("SELECT idProd FROM Articles WHERE idProd='".$_GET['prod']."'")->fetchArray());
    if ($q_dispo >= intval($_GET['qte']) AND $is_not_in_cart AND $prod_exist) {
        if (isset($_SESSION['username'])) {
            $req_user_id = "SELECT idUser FROM Utilisateurs WHERE username='".$_SESSION['username']."'";
            $userid = $db->query($req_user_id)->fetchArray()['idUser'];
            $req = "INSERT INTO Paniers (idSession, idProd, idUser, quantite) VALUES ('".$sid."', '".$_GET['prod']."', '".$userid."', '".$_GET['qte']."');";
            $db->query($req);
            $_SESSION['ok'] = "L'article a bien été ajouté au panier.";
        } else {
            $req = "INSERT INTO Paniers (idSession, idProd, quantite) VALUES ('".$sid."', '".$_GET['prod']."', '".$_GET['qte']."');";
            $db->query($req);
            $_SESSION['ok'] = "L'article a bien été ajouté au panier.";
        }
    } else {
        $_SESSION['error'] = "Erreur, soit le stock est trop faible, soit l'article n'existe pas, ou soit cet article est déjà dans votre panier.";
    }
} else {
    echo 'requête invalide...';
}
$db->close();
header('location: article.php?id='.$_GET['prod']);

?>
