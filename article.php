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
                <form>
                <label>Quantité</label>
                <input type="number" name="qte" min="1" max="10" style="width: 40px;" value="1"><br>
                <button type='submit' class="submit_article">Ajouter au panier</button>
                </form>

            </div>

            </div>

		</div>
<?php $db->close(); ?>
	<div class='footer'>
        Droit d'auteur © 2056 Nom du site. Tous droits réservés.
	</div>

</body>
</html>
