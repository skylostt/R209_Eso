<!DOCTYPE html>
<html lang="fr">
<head>
    <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Ubuntu:regular,bold&subset=Latin">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="res/nav.css">
    <link rel="stylesheet" href="res/style_index.css">
    <link rel="stylesheet" href="res/step1.css">
    <meta charset="UTF-8">
    <title>Recherche</title>
</head>
<body>
    <nav>
        <div class='topbar'>
            <a class='logo' href='index.html'>
                <span class="material-icons">home</span>
            </a>
            <form method='GET' action='search.php' class='form_bar'>
                <select name="cat" class="sel_cat">
                    <option value="all">Catégorie</option>
                    <option value="cartes">Cartes</option>
                    <option value="peintures">Peintures</option>
                    <option value="minéraux">Minéraux</option>
                    <option value="bijoux">Bijoux</option>
                </select>
                <input type='text' class='searchbar' name='query'><input type='submit' class='submitsearch' value='Rechercher'>
            </form>
            <a class='bar_elt' href=''>
                <span class="material-icons">person</span>Mon compte
            </a>
            <a class='bar_elt' href=''>
                <span class="material-icons">receipt_long</span>Mes commandes
            </a>
            <a class='bar_elt' href=''>
                <span class="material-icons">shopping_basket</span>Mon panier
            </a>
        </div>
        <div class='cat_bar'>
            <a href="">Cartes</a>
            <a href="">Peintures</a>
            <a href="">Minéraux</a>
            <a href="">Bijoux</a>
        </div>
    </nav>
<?php
class MyDB extends SQLite3
{
    function __construct()
    {
        $this->open('bdd.db');
    }
}
$db = new MyDB();
$req = 'SELECT * FROM Articles WHERE nom LIKE "%'.$_GET['query'].'%" AND (idCat='.$_GET['cat'].' OR '.$_GET['cat'].'=0)';
$reponse = $db->query($req);
while ($donnees=$reponse->fetchArray())
{
    echo '<div class="ranger" style="line-height: 22px;">';
    echo '<img src="tarot.jpeg" width="200" height="200" ><br>';
    echo '<p align="center"><b>'.$donnees['nom'].'</b><br>';
    $stock = $donnees['quantite'] !== 0 ? '<i style="color:green">En stock</i>' : '<i style="color:red">Rupture</i>';
    echo $stock.'</span><br>';
    echo '<b style="color:darkblue;">- '.$donnees['prix'].' € -</b><br>';
    echo '<a style="color:black;text-decoration: none;" href="article.php?id='.$donnees['idProd'].'">Voir plus</a><br>';
    echo '<br>';
    echo '<a class="button">Acheter</a><br></p>';
    echo '</div>';
}

?>
</body>
</html>
