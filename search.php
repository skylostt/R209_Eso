<?php session_start(); ?>
<!DOCTYPE html>
<?php
include('db_class.php');
$_SESSION['activity'] = time();
$_SESSION['last_page'] = 'search.php';
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
<h1>Résultats</h1>
<div class="container">
<?php
$db = new MyDB();
$query = isset($_GET['query']) ? $_GET['query'] : '';
$req = $db->prepare('SELECT * FROM Articles WHERE nom LIKE :query AND (idCat=:cat OR :cat="0")');
$req->bindValue(':query', '%'.$query.'%');
$req->bindValue(':cat', $_GET['cat']);
$reponse = $req->execute();
// On parcourt la liste des articles
while ($donnees=$reponse->fetchArray())
{
    echo '<div class="ranger">';
    echo '<div align="center"><a href="article.php?id='.$donnees['idProd'].'"><img class="prod_img" src="data:'.$donnees['mime'].';base64,'.$donnees['b64img'].'" width="200" height="200" ></a></div><br>';
    echo '<div class="under-img">';
    echo '<div class="article-name"><b>'.$donnees['nom'].'</b></div>';
    $stock = $donnees['stock'] !== 0 ? '<i style="color:green">En stock</i>' : '<i style="color:red">Rupture</i>';
    echo $stock.'</span><br>';
    echo '<b style="color:darkblue;">- '.$donnees['prix'].' € -</b><br>';
    echo '<a class="see-more" href="article.php?id='.$donnees['idProd'].'">Plus d\'info.</a><br>';
    echo '<br>';
    echo '<br></div>';
    echo '</div>';
}
$db->close();
?>
</div>
</body>
</html>
