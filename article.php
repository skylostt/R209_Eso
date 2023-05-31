<?php session_start(); ?>
<!DOCTYPE html>
<?php
include('db_class.php');
$_SESSION['activity'] = time();
if (! isset($_GET['id']) OR ! is_numeric($_GET['id'])) {
    header('location: index.php');
    exit;
}
$_SESSION['last_page'] = 'article.php?id='.$_GET['id'];
$db = new MyDB();
// On récupère les infos sur l'article à afficher
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

        <h1 class="title"><?php echo 'Article ~ '.$reponse['nom']; ?></h1>

<div align="center">
        <span class="erreur_span">
<?php
// Si la variable d'erreur est définie afficher le message
echo isset($_SESSION["error"]) ? $_SESSION["error"] : "";
$_SESSION["error"] = "";
?>
        </span>
        <span class="ok_span">
<?php
// Si la variable de succès est définie afficher le message
echo isset($_SESSION["ok"]) ? $_SESSION["ok"] : "";
$_SESSION["ok"] = "";
?>
        </span>
</div>
		<div class='article'>
            <img src="data:image/jpeg;base64,<?php echo $reponse['b64img']; ?>" alt="Image de l'article">
            <div class="div-second">
    <p class="description"><?php echo $reponse['description']; ?></p>


			    <h2 class="details">Achat du produit</h2>

                <p>Prix : <strong><?php echo $reponse['prix']; ?>€</strong></p>
<?php
// Si l'article est disponible, on affiche le formulaire pour l'ajouter au panier
if ($reponse['stock'] > 0) {
    echo '<form method="GET" action="add_to_cart.php">';
    echo '<label>Quantité</label>';
    echo '<input type="number" name="qte" min="1" max="'.$reponse['stock'].'" value="1" style="width: 40px;"><br>';
    echo '<button type="submit" class="submit_article" value="'.$reponse['idProd'].'" name="prod">Ajouter au panier</button>';
    echo '</form>';
} else {
    echo "Ce produit est en rupture de stock.";
}

?>
            </div>
        </div>
        <div class="commentaires">
            <h1>Commentaires</h1>
<?php
// On parcourt les commentaires pour l'idProd actuel
$req = "SELECT * FROM Commentaires WHERE idProd='".$_GET['id']."';";
$results = $db->query($req);
while ($donnees=$results->fetchArray()) {
    $username=$db->query("SELECT username FROM Utilisateurs WHERE idUser=".$donnees['idUser'].";")->fetchArray()['username'];
    echo "<div>";
    echo '<div style="display: flex;">';
    echo '<span class="user_com" style="vertical-align: middle;">'.$username.' : '.$donnees['eval'].'/5</span>';
    echo '<a href="del_com.php?idCom='.$donnees['idCom'].'&idProd='.$donnees['idProd'].'" class="suppr-link">X</a>';
    echo '</div>';
    echo '<div class="user_text">'.$donnees['texte'].'</div>';
    echo '</div>';
}
?>
<?php
// Si l'utilisateur est connecté, on affiche le formulaire pour poster un commentaire
if (isset($_SESSION['user'])) {
echo '<h1>Laisser un commentaire</h1>';
echo '<form method="POST" action="post_com.php?id='.$_GET['id'].'">';
echo '<label>Note</label><br>';
echo '<select name="eval">';
echo '<option value="0">0</option>';
echo '<option value="1">1</option>';
echo '<option value="2">2</option>';
echo '<option value="3">3</option>';
echo '<option value="4">4</option>';
echo '<option value="5">5</option>';
echo '</select><br>';
echo '<label>Commentaire</label><br>';
echo '<textarea name="comment"></textarea><br>';
echo '<input type="submit" value="Publier">';
echo '</form>';
}
?>
<?php $db->close(); ?>
</body>
</html>
