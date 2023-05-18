<?php
session_start();
include('db_class.php');
$sid = session_id();
?>
<!DOCTYPE html>

<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link>
    <title>Votre panier</title>
    <link rel="stylesheet" href="res/font.css">
    <link rel="stylesheet" href="res/panier.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

<?php include('nav.php'); ?>
<h1 style="color:darkblue;" align="center">Votre panier</h1>
<br>
<div align="center">
        <span class="erreur_span" align="center">
<?php
echo isset($_SESSION["error"]) ? $_SESSION["error"] : "";
$_SESSION["error"] = "";
?>
        </span>
        <span class="ok_span" align="center">
<?php
echo isset($_SESSION["ok"]) ? $_SESSION["ok"] : "";
$_SESSION["ok"] = "";
?>
        </span>
</div>
<div class="info-text">
    <span>
<?php
$db = new MyDB();
if (isset($_SESSION['username'])) {
    $req = "SELECT COUNT(*) FROM Paniers JOIN Utilisateurs ON Paniers.idUser = Utilisateurs.idUser WHERE username='".$_SESSION['username']."';";
} else {
    $req = "SELECT COUNT(*) FROM Paniers WHERE idSession='".$sid."';";
}
echo $db->query($req)->fetchArray()['COUNT(*)'];
echo " article(s) dans votre panier";
?>
    </span>
    <a class="continue" href="index.php">Continuer mes achats</a>
</div>
<br>
<table style="" class='cart-tab' width="50%">
    <tr class='nom-colonnes'>
        <td>Articles</td>
        <td class="text-center">Quantité</td>
        <td class="text-center">Prix</td>
        <td class="text-center">Supprimer</td>
    </tr>
<?php

if (isset($_SESSION['username'])) {
    $req = "SELECT * FROM Paniers JOIN Utilisateurs ON Paniers.idUser = Utilisateurs.idUser WHERE username='".$_SESSION['username']."';";
    $reponse = $db->query($req);
} else {
    $req = "SELECT * FROM Paniers WHERE idSession='".$sid."';";
    $reponse = $db->query($req);
}
while ($donnees=$reponse->fetchArray()) {
    $infos_req = "SELECT * FROM Articles WHERE idProd='".$donnees['idProd']."';";
    $infos = $db->query($infos_req)->fetchArray();
    $price = $infos['prix']*$donnees['quantite'];
    echo '<tr>';
    echo '<td width="50%">';
    echo '<img class="tab-img valign" src="data:'.$infos['mime'].';base64,'.$infos['b64img'].'"/>';
    echo '<span class="valign">'.$infos['nom'].'</span>';
    echo '</td>';
    echo '<td class="text-center"><a href="add_to_cart.php?prod='.$infos['idProd'].'&qte=1&from=panier.php">+ </a>';
    echo $donnees['quantite'];
    echo '<a href="add_to_cart.php?prod='.$infos['idProd'].'&qte=-1&from=panier.php"> -</a>';
    echo '</td>';
    echo '<td class="text-center">'.$price.'€ ('.$infos['prix'].'€/u)</td>';
    echo '<td class="text-center"><a href="del_from_cart.php?id='.$donnees['idProd'].'" class="trash-link"><span class="material-icons">delete</span></a></td>';
    echo '</tr>';
}
?>
</table>

<div class="info-text">
    <p>Total : <b>
<?php
if (isset($_SESSION['username'])) {
    $req = "SELECT Paniers.quantite, prix FROM Paniers JOIN Utilisateurs ON Paniers.idUser = Utilisateurs.idUser JOIN Articles ON Paniers.idProd = Articles.idProd WHERE username='".$_SESSION['username']."';";
} else {
    $req = "SELECT Paniers.quantite, prix FROM Paniers JOIN Articles ON Paniers.idProd = Articles.idProd WHERE idSession='".$sid."';";
}
$reponse = $db->query($req);
$somme = 0;
while ($donnees=$reponse->fetchArray()) {
    $somme += $donnees['quantite']*$donnees['prix'];
}
echo $somme."€";
?>
</b></p>
    <a class="payment" href="command.php">Commander</a>
</div>
</body>
</html>
