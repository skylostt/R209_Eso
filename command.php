<?php
session_start();
include("db_class.php");
$sid = session_id();
$_SESSION['activity'] = time();
$_SESSION['last_page'] = 'command.php';
$db = new MyDB();
if (isset($_SESSION['user']['username'])) {
    $req = "SELECT * FROM Commandes WHERE idUser='".$_SESSION['user']['idUser']."';";
    $reponse = $db->query($req);
} else {
    header('location: login.php');
    exit;
}

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
    <div class="container">

<?php
$somme = 0;
while ($donnees=$reponse->fetchArray()) {
    echo '<div class="commande">';
    echo '<div class="command_num">Commande n°'.$donnees['idCom'].' : '.$donnees['etat'].'</div>';
    echo '<div>';
    echo '<ul class="command_list">';
    $command_items = $db->query("SELECT * FROM ProdCommandes JOIN Articles ON ProdCommandes.idProd=Articles.idProd WHERE idCom=".$donnees['idCom'].";");
    while ($items=$command_items->fetchArray()) {
        echo '<li class="command_item">'.$items['quantite'].'x '.$items['nom'].'</li>';
    }
    echo '</ul>';
    echo '</div>';
    echo '<div class="command_price">'.$donnees['adresse'].'</div>';
    echo '<div class="command_price">Prix total : '.$donnees['prix'].'€</div>';
    echo '</div>';
}
?>

</div>

</body>
</html>
