<!DOCTYPE html>
<?php include('db_class.php'); ?>
<html lang="fr">
<head>
    <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Ubuntu:regular,bold&subset=Latin">
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
/*
class MyDB extends SQLite3
{
    function __construct()
    {
        $this->open('bdd.db');
    }
}*/
$db = new MyDB();
$query = isset($_GET['query']) ? $_GET['query'] : '';
$req = 'SELECT * FROM Articles WHERE nom LIKE "%'.$query.'%" AND (idCat='.$_GET['cat'].' OR '.$_GET['cat'].'=0)';
$reponse = $db->query($req);
while ($donnees=$reponse->fetchArray())
{
    echo '<div class="ranger" style="line-height: 22px;">';
    echo '<img src="data:image/jpeg;base64,'.$donnees['b64img'].'" width="200" height="200" ><br>';
    echo '<p align="center"><b>'.$donnees['nom'].'</b><br>';
    $stock = $donnees['quantite'] !== 0 ? '<i style="color:green">En stock</i>' : '<i style="color:red">Rupture</i>';
    echo $stock.'</span><br>';
    echo '<b style="color:darkblue;">- '.$donnees['prix'].' € -</b><br>';
    echo '<a style="color:black;text-decoration: none;" href="article.php?id='.$donnees['idProd'].'">Voir plus</a><br>';
    echo '<br>';
    echo '<a class="button">Acheter</a><br></p>';
    echo '</div>';
}
$db->close();

?>
</body>
</html>
