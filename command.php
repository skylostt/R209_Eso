<?php
session_start();
include("db_class.php");
$sid = session_id();
$_SESSION['activity'] = time();
$_SESSION['last_page'] = 'command.php';

?>
<!DOCTYPE html>

<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link>
    <title>Votre commande</title>
    <link rel="stylesheet" href="res/font.css">
    <link rel="stylesheet" href="res/panier.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

<?php include('nav.php'); ?>
<h1 style="color:darkblue;" align="center">Vos commandes</h1>

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
    $req = "SELECT * FROM Commandes  WHERE idUser='".$_SESSION['user']['idUser']."';";
    $reponse = $db->query($req);
} else {
    header('location: login.php');
    exit;
}

$somme = 0;
while ($donnees=$reponse->fetchArray()) {
    $price = $donnees['prix']*$donnees['quantite'];
    $est_dispo = $donnees['stock'] >= $donnees['quantite'] ? 'dispo' : 'indispo';
    echo '<tr>';
    echo '<td class="text-center">';
    echo '<span class="valign '.$est_dispo.'">'.$donnees['nom'].'</span>';
    echo '</td>';
    echo '<td class="text-center">';
    echo $est_dispo === "dispo" ? $donnees['quantite'] : '-';
    echo '</td>';
    echo '<td class="text-center">';
    echo $est_dispo === "dispo" ? $price.'€ ('.$donnees['prix'].'€/u)' : '-';
    echo '</td>';
    echo '</tr>';
    $somme += $donnees['quantite']*$donnees['prix'];
}
?>
</table>
</body>
</html>
