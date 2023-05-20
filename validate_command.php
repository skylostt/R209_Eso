<?php
session_start();
include("db_class.php");
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
<h1 style="color:darkblue;" align="center">Votre Commande</h1>

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
<table class='cart-tab' width="50%">
    <tr class='nom-colonnes'>
        <td class="text-center">Articles</td>
        <td class="text-center">Quantité</td>
        <td class="text-center">Prix</td>
    </tr>
<?php
$db = new MyDB();
if (isset($_SESSION['user']['username'])) {
    $req = "SELECT * FROM Paniers JOIN Utilisateurs ON Paniers.idUser = Utilisateurs.idUser WHERE username='".$_SESSION['user']['username']."';";
    $reponse = $db->query($req);
} else {
    header('location: login.php');
}
while ($donnees=$reponse->fetchArray()) {
    $infos_req = "SELECT * FROM Articles WHERE idProd='".$donnees['idProd']."';";
    $infos = $db->query($infos_req)->fetchArray();
    $price = $infos['prix']*$donnees['quantite'];
    $est_dispo = $infos['quantite'] >= $donnees['quantite'] ? 'dispo' : 'indispo';
    echo '<tr>';
    echo '<td class="text-center">';
    echo '<span class="valign '.$est_dispo.'">'.$infos['nom'].'</span>';
    echo '</td>';
    echo '<td class="text-center">';
    echo $est_dispo === "dispo" ? $donnees['quantite'] : '-';
    echo '</td>';
    echo '<td class="text-center">';
    echo $est_dispo === "dispo" ? $price.'€ ('.$infos['prix'].'€/u)' : '-';
    echo '</td>';
    echo '</tr>';
}
?>
</table>
<h1 style="color: darkblue;">Adresse</h1>
<form action="command_script.php" method="POST">
    <input placeholder="Adresse" name="address" /><br>
    <input type="submit" value="Commander" class="command_button" />
</form>
</body>
</html>
