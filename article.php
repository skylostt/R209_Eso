<?php session_start(); ?>
<!DOCTYPE html>
<?php include('db_class.php');
if (! isset($_GET['id'])) {
    header('location: index.php');
}
$db = new MyDB();
$req = "SELECT * FROM Articles WHERE idProd='".$_GET['id']."'";
$reponse = $db->query($req)->fetchArray();
?>
<html lang="fr">
<head>
	<meta charset="UTF-8">
    <title><?php echo $reponse['nom']; ?></title>
    <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Ubuntu:regular,bold&subset=Latin">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="res/stylearticle.css">
    <link rel="stylesheet" href="res/font.css">
<?php include('nav.php'); ?>

        <h1><?php echo 'Article ~ '.$reponse['nom']; ?></h1>
		<div class='article'>
            <img src="data:image/jpeg;base64,<?php echo $reponse['b64img']; ?>" alt="Image de l'article">
            <div class="div-second">
    <p class="description"><?php echo $reponse['description']; ?></p>


			    <h2 class="details">Achat du produit</h2>

                <p>Prix : <strong><?php echo $reponse['prix']; ?>€</strong></p>
<?php
if ($reponse['quantite'] > 0) {
    echo '<form method="POST" action="add_article.php">';
    echo '<label>Quantité</label>';
    echo '<input type="number" name="qte" min="1" max="'.$reponse['quantite'].'" value="1" style="width: 40px;"><br>';
    echo '<button type="submit" class="submit_article" value="'.$reponse['idProd'].'" name="id">Ajouter au panier</button>';
    echo '</form>';
} else {
    echo "Ce produit est en rupture de stock.";
}

?>
            </div>
        </div>

<?php $db->close(); ?>
	<div class='footer'>
        Droit d'auteur © 2056 Nom du site. Tous droits réservés.
	</div>

</body>
</html>
