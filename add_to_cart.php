<?php
session_start();
include('db_class.php');

$sid = session_id();
$db = new MyDB();

if (isset($_GET['prod']) AND isset($_GET['qte']) AND is_numeric($_GET['prod']) AND is_numeric(abs($_GET['qte']))) {
    // On compte le nomnbre d'articles en stock
    $q_dispo = $db->query("SELECT quantite FROM Articles WHERE idProd='".$_GET['prod']."';")->fetchArray()['quantite'];
    // On regarde si le produit à ajouter est déjà dans le panier
    $not_cart_req = isset($_SESSION['user']['username']) ?
        "SELECT idProd FROM Paniers WHERE idProd='".$_GET['prod']."' AND idUser='".$_SESSION['user']['idUser']."';" :
        "SELECT idProd FROM Paniers WHERE idProd='".$_GET['prod']."' AND idSession='".$sid."' AND idUser IS NULL;";
    $is_not_in_cart = empty($db->query($not_cart_req)->fetchArray());
    // On vérifie que le produit existe
    $prod_exist = ! empty($db->query("SELECT idProd FROM Articles WHERE idProd='".$_GET['prod']."'")->fetchArray());
    // Si le produit existe, est disponible et n'est pas dans le panier
    if ($q_dispo >= $_GET['qte'] AND $is_not_in_cart AND $prod_exist) {
        if (isset($_SESSION['user']['username'])) {
            // On ajoute l'article au panier
            $req = "INSERT INTO Paniers (idSession, idProd, idUser, quantite) VALUES ('".$sid."', '".$_GET['prod']."', '".$_SESSION['user']['idUser']."', '".$_GET['qte']."');";
        } else {
            // On ajoute l'article au panier
            $req = "INSERT INTO Paniers (idSession, idProd, quantite) VALUES ('".$sid."', '".$_GET['prod']."', '".$_GET['qte']."');";
        }
        $db->query($req);
        $_SESSION['ok'] = "L'article a bien été ajouté au panier.";
    // Sinon si le produit existe et est disponible
    } else if ($q_dispo >= abs($_GET['qte']) AND $prod_exist) {
        if (isset($_SESSION['user']['username'])) {
            $cur_qte = $db->query("SELECT quantite FROM Paniers WHERE idProd=".$_GET['prod']." AND idUser=".$_SESSION['user']['idUser'].";")->fetchArray()['quantite'];
            // On met à jour la quantité dans le panier
            $req = "UPDATE Paniers SET quantite=quantite+".$_GET['qte']." WHERE idProd='".$_GET['prod']."' AND idUser='".$_SESSION['user']['idUser']."';";
        } else {
            $cur_qte = $db->query("SELECT quantite FROM Paniers WHERE idProd=".$_GET['prod']." AND idSession='".$sid."' AND idUser IS NULL;")->fetchArray()['quantite'];
            if ($cur_qte+$_GET['qte'] > $q_dispo) header('location: '.$_SESSION['last_page']);
            // On met à jour la quantité dans le panier
            $req = "UPDATE Paniers SET quantite=quantite+".$_GET['qte']." WHERE idSession='".$sid."' AND idProd='".$_GET['prod']."';";
        }
        if ($_GET['qte'] > -1*$cur_qte AND $cur_qte+$_GET['qte'] <= $q_dispo) $db->query($req);

    } else {
        $_SESSION['error'] = "Erreur, soit le stock est trop faible, soit l'article n'existe pas.";
    }
} else {
    echo 'requête invalide...';
}
$db->close();
header('location: '.$_SESSION['last_page']);
?>
