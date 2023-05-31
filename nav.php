<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<link rel="stylesheet" href="res/nav.css">
</head>
<body>
<nav>
    <div class='topbar'>
        <a class='logo' href='index.php'>
            <span class="material-icons">home</span>
        </a>
        <form method='GET' action='search.php' class='form_bar'>
            <select name="cat" class="sel_cat">
                <option value="0">Toutes catégories</option>
<?php
$db_nav = new MyDB();
$req_nav = 'SELECT * FROM Categories';
$reponse_nav = $db_nav->query($req_nav);
// On parcourt les catégories pour le menu déroulant
while ($donnees=$reponse_nav->fetchArray())
{
    $select = '';
    // Si la catégorie parcourue est celle du GET, alors on ajoute l'attribut selected à la balise option
    if (isset($_GET['cat'])) {
        if ($_GET['cat'] === strval($donnees['idCat'])) {
            $select = 'selected';
        }
    }
    echo '<option value="'.$donnees['idCat'].'" '.$select.'>'.$donnees['titre'].'</option>';
}
?>

            </select>
            <input type='text' class='searchbar' name='query' <?php echo isset($_GET['query']) ? 'value="'.$_GET['query'].'"' : '';?>><input type='submit' class='submitsearch' value='Rechercher'>
        </form>
        <a class='bar_elt' href='login.php'>
        <span class="material-icons">person</span><span class='valign-link'><?php echo isset($_SESSION['user']['username']) ? $_SESSION['user']['username'] : "Mon compte"; ?></span>
        </a>
        <a class='bar_elt' href='command.php'>
            <span class="material-icons">receipt_long</span><span class='valign-link'>Mes commandes</span>
        </a>
        <a class='bar_elt' href='panier.php'>
            <span class="material-icons">shopping_basket</span><span class='valign-link'>Mon panier</span>
        </a>
    </div>
    <div class='cat_bar'>
<?php
$req_nav = 'SELECT * FROM Categories';
$reponse_nav = $db_nav->query($req_nav);
while ($donnees=$reponse_nav->fetchArray())
{
    // On forge à la main le lien vers la catégorie (plus simple qu'un forumlaire...)
    echo '<a href="search.php?cat='.$donnees['idCat'].'" class="item_cat_bar">'.$donnees['titre'].'</a>';
}

$db_nav->close();
?>
    </div>
</nav>
