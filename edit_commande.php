<?php
session_start();
include('db_class.php');
if (! $_SESSION['user']['droits']) {
    header('location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Edit</title>
    <meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="res/editarticle.css">
	<link rel="stylesheet" type="text/css" href="res/font.css">
<?php include('nav.php'); ?>
	<div class="container">
        <h1><?php echo isset($_GET['id']) ? "Editer" : "Ajouter"; ?> une Commande</h1>
<?php
$db = new MyDB();
if (isset($_GET['id'])) {
    $req = $db->prepare("SELECT * FROM Commandes JOIN Utilisateurs ON Utilisateurs.idUser=Commandes.idUser WHERE idCom=:id;");
    $req->bindValue(":id", $_GET['id']);
    $values = $req->execute()->fetchArray();
    $price = $values['prix'];
    $state = $values['etat'];
    $user = $values['username'];
    echo "Cette commande a été passée par ".$user.", elle est actuellement ".$state." et a coûté ".$price."€.";
}
?>
	<div>
		<h3>Articles commandés</h3>
        <ul>
<?php
$articles = $db->prepare("SELECT * FROM ProdCommandes JOIN Articles ON Articles.idProd=ProdCommandes.idProd WHERE idCom=:id;");
$articles->bindValue(':id', $_GET['id']);
$values = $articles->execute();
while ($donnees=$values->fetchArray()) {
    echo "<li>".$donnees['quantite']."x ".$donnees['nom']."</li>";
}
?>
        </ul>
	</div>
		<h3>Etat de la commande</h3>
    <form action="change_state.php<?php echo isset($_GET['id']) ? "?id=".$_GET['id'] : ""; ?>" method="POST">
    <select name="state">
    <option <?php echo $state === "En préparation" ? "selected=true" : "" ?>>En préparation</option>
        <option <?php echo $state === "En expédition" ? "selected=true" : "" ?>>En expédition</option>
        <option <?php echo $state === "En cours de livraison" ? "selected=true" : "" ?>>En cours de livraison</option>
    </select>
    <br>
    <br>
<button class="form_button modify" type="submit" name="mod" value="1">Modifier</button>
<button class="form_button delete" type="submit" name="mod" value="2">Supprimer</button>

    </form>
	</div>
</body>
</html>
