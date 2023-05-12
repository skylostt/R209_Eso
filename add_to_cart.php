<?php
session_start();
include('db_class.php');

$sid = session_id();

if (isset($_GET['prod']) AND isset($_GET['qte'])) {
    $db = new MyDB();
    if (isset($_SESSION['username'])) {
        $req_user_id = "SELECT idUser FROM Utilisateurs WHERE username='".$_SESSION['username']."'";
        $userid = $db->query($req_user_id)->fetchArray()['idUser'];
        $req = "INSERT INTO Paniers (idSession, idProd, idUser, quantite) VALUES ('".$sid."', '".$_GET['prod']."', '".$userid."', '".$_GET['qte']."');";
        $db->query($req);
        $_SESSION['ok'] = "L'article a bien été ajouté au panier.";
        header('location: article.php?id='.$_GET['prod']);
    } else {
        $req = "INSERT INTO Paniers (idSession, idProd, quantite) VALUES ('".$sid."', '".$_GET['prod']."', '".$_GET['qte']."');";
        $db->query($req);
        $_SESSION['ok'] = "L'article a bien été ajouté au panier.";
        header('location: article.php?id='.$_GET['prod']);
    }
    $db->close();
} else {
    echo 'requête invalide...';
}

?>
