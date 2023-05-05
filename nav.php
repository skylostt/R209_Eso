<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Ubuntu:regular,bold&subset=Latin">
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
$reponse_nav = $db->query($req_nav);
while ($donnees=$reponse_nav->fetchArray())
{
    $select = isset($_GET['cat']) && $_GET['cat'] == $donnees['idCat'] ? 'selected' : '';
    echo $select;
    echo '<option value="'.$donnees['idCat'].'" '.$select.'>'.$donnees['titre'].'</option>';
}
?>

            </select>
            <input type='text' class='searchbar' name='query' <?php echo isset($_GET['query']) ? 'value="'.$_GET['query'].'"' : '';?>><input type='submit' class='submitsearch' value='Rechercher'>
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
<?php
$req_nav = 'SELECT * FROM Categories';
$reponse_nav = $db_nav->query($req_nav);
while ($donnees=$reponse_nav->fetchArray())
{
    echo '<a href="search.php?cat='.$donnees['idCat'].'">'.$donnees['titre'].'</a>';
}
?>
    </div>
</nav>
