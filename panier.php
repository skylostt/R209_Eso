<?php
session_start();
include('db_class.php');
$sid = session_id();
$_SESSION['activity'] = time();
$_SESSION['last_page'] = 'panier.php';
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
$req = isset($_SESSION['user']['username'])
    ? "SELECT COUNT(*) FROM Paniers WHERE idUser='".$_SESSION['user']['idUser']."';"
    : "SELECT COUNT(*) FROM Paniers WHERE idSession='".$sid."' AND idUser IS NULL;";

echo $db->query($req)->fetchArray()['COUNT(*)'];
echo " article(s) dans votre panier";
?>
    </span>
    <a class="continue" href="index.php">Continuer mes achats</a>
</div>
<br>
<table class='cart-tab' width="50%">
    <tr class='nom-colonnes'>
        <td>Articles</td>
        <td class="text-center">Quantité</td>
        <td class="text-center">Prix</td>
        <td class="text-center">Supprimer</td>
    </tr>
<?php

if (isset($_SESSION['user']['username'])) {
    $req = "SELECT * FROM Paniers JOIN Articles ON Articles.idProd=Paniers.idProd WHERE idUser='".$_SESSION['user']['idUser']."';";
    $reponse = $db->query($req);
} else {
    $req = "SELECT * FROM Paniers JOIN Articles ON Articles.idProd=Paniers.idProd WHERE idSession='".$sid."' AND idUser IS NULL;";
    $reponse = $db->query($req);
}
while ($donnees=$reponse->fetchArray()) {
    $price = $donnees['prix']*$donnees['quantite'];
    echo '<tr>';
    echo '<td width="50%">';
    echo '<img class="tab-img valign" src="data:'.$donnees['mime'].';base64,'.$donnees['b64img'].'"/>';
    echo '<span class="valign">'.$donnees['nom'].'</span>';
    echo '</td>';
    echo '<td class="text-center"><a class="plus_moins" href="add_to_cart.php?prod='.$donnees['idProd'].'&qte=1">+ </a>';
    echo $donnees['quantite'];
    echo '<a class="plus_moins" href="add_to_cart.php?prod='.$donnees['idProd'].'&qte=-1&from=panier.php"> -</a>';
    echo '</td>';
    echo '<td class="text-center">'.$price.'€ ('.$donnees['prix'].'€/u)</td>';
    echo '<td class="text-center"><a href="del_from_cart.php?id='.$donnees['idProd'].'" class="trash-link"><span class="material-icons">delete</span></a></td>';
    echo '</tr>';
}
?>
</table>

<div class="info-text">
    <p>Total : <b>
<?php
if (isset($_SESSION['user']['username'])) {
    $req = "SELECT Paniers.quantite, prix FROM Paniers JOIN Articles ON Paniers.idProd = Articles.idProd WHERE idUser='".$_SESSION['user']['idUser']."';";
} else {
    $req = "SELECT Paniers.quantite, prix FROM Paniers JOIN Articles ON Paniers.idProd = Articles.idProd WHERE idSession='".$sid."' AND idUser IS NULL;";
}
$reponse = $db->query($req);
$somme = 0;
while ($donnees=$reponse->fetchArray()) {
    $somme += $donnees['quantite']*$donnees['prix'];
}
echo $somme."€";
?>
</b></p>
    <a class="payment" href="validate_command.php">Commander</a>
</div>
</body>
</html>
