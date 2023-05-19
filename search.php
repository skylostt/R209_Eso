<?php session_start(); ?>
<!DOCTYPE html>
<?php
include('db_class.php');
$_SESSION['activity'] = time();
?>
<html lang="fr">
<head>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="res/nav.css">
    <link rel="stylesheet" href="res/step1.css">
    <link rel="stylesheet" href="res/font.css">
    <meta charset="UTF-8">
    <title>Recherche</title>
<?php include('nav.php'); ?>
<body>
<h1>Résultats</h1>
<?php
$db = new MyDB();
$query = isset($_GET['query']) ? $_GET['query'] : '';
$req = $db->prepare('SELECT * FROM Articles WHERE nom LIKE :query AND (idCat=:cat OR :cat="0")');
$req->bindValue(':query', '%'.$query.'%');
$req->bindValue(':cat', $_GET['cat']);
$reponse = $req->execute();
while ($donnees=$reponse->fetchArray())
{
    echo '<div class="ranger" style="line-height: 22px;">';
    echo '<div align="center"><img class="prod_img" src="data:'.$donnees['mime'].';base64,'.$donnees['b64img'].'" width="200" height="200" ></div><br>';
    echo '<div class="under-img"><b>'.$donnees['nom'].'</b><br>';
    $stock = $donnees['quantite'] !== 0 ? '<i style="color:green">En stock</i>' : '<i style="color:red">Rupture</i>';
    echo $stock.'</span><br>';
    echo '<b style="color:darkblue;">- '.$donnees['prix'].' € -</b><br>';
    echo '<a class="see-more" href="article.php?id='.$donnees['idProd'].'">Voir plus</a><br>';
    echo '<br>';
    echo '<a class="button">Acheter</a><br></div>';
    echo '</div>';
}
$db->close();
?>
</body>
</html>
