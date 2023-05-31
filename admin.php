<?php
session_start();
include('db_class.php');
$db = new MyDB();
if (! $_SESSION['user']['droits']) {
    header('location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Page d'administration</title>
	<link rel="stylesheet" type="text/css" href="res/admin.css">
	<link rel="stylesheet" type="text/css" href="res/font.css">
    <meta charset='utf-8'>
<?php
include('nav.php');
?>
	<div class="container">
		<h1>Page d'administration</h1>
        <h2>Editer une Catégorie</h2>
		<table>
			<thead>
				<tr>
					<th>Catégorie</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
<?php
// On parcourt la liste des catégories
$categories = $db->query("SELECT * FROM Categories;");
while ($donnees=$categories->fetchArray()) {
    echo '<tr>';
    echo '<td>'.$donnees['titre'].'</td>';
    echo '<td>';
    echo '<a class="admin_link" href="edit_cat.php?id='.$donnees['idCat'].'">';
    echo '<span class="edit_text">Editer</span>';
    echo '<span class="material-icons" style="display: inline-block; vertical-align: middle;">edit</span>';
    echo '</a>';
    echo '</td>';
    echo '</tr>';
}
?>
			</tbody>
		</table>
        <a class="admin_link edit_text" href="edit_cat.php">Ajouter une catégorie</a>
		<h2>Editer un Article</h2>
		<table>
			<thead>
				<tr>
					<th>Article</th>
					<th>Catégorie</th>
					<th>Stock</th>
					<th>Prix</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
<?php
// On parcourt la liste des articles
$articles = $db->query("SELECT * FROM Articles");
while ($donnees=$articles->fetchArray()) {
    echo '<tr>';
    echo '<td>'.$donnees['nom'].'</td>';
    echo '<td>'.$donnees['idCat'].'</td>';
    echo '<td>'.$donnees['stock'].'</td>';
    echo '<td>'.$donnees['prix'].'€</td>';
    echo '<td>';
    echo '<a class="admin_link" href="edit_article.php?id='.$donnees['idProd'].'">';
    echo '<span class="edit_text">Editer</span>';
    echo '<span class="material-icons" style="display: inline-block; vertical-align: middle;">edit</span>';
    echo '</a>';
    echo '</td>';
    echo '</tr>';
}
?>
			</tbody>
		</table>
        <a class="admin_link edit_text" href="edit_article.php">Ajouter un article</a>
		<h2>Agir sur une commande</h2>
		<table>
			<thead>
				<tr>
					<th>N° Commande</th>
					<th>Utilisateur</th>
					<th>Prix</th>
					<th>Editer</th>
				</tr>
			</thead>
			<tbody>
<?php

// On parcourt la liste des commandes
$commandes = $db->query("SELECT * FROM Commandes JOIN Utilisateurs ON Commandes.idUser=Utilisateurs.idUser;");
while ($donnees=$commandes->fetchArray()) {
    echo '<tr>';
    echo '<td>'.$donnees['idCom'].'</td>';
    echo '<td>'.$donnees['username'].'</td>';
    echo '<td>'.$donnees['prix'].'</td>';
    echo '<td>';
    echo '<a class="admin_link" href="edit_commande.php?id='.$donnees['idCom'].'">';
    echo '<span class="edit_text">Editer</span>';
    echo '<span class="material-icons" style="display: inline-block; vertical-align: middle;">edit</span>';
    echo '</a>';
    echo '</td>';
    echo '</tr>';
}
?>
			</tbody>
		</table>
		<h2>Liste des utilisateurs</h2>
		<ul>
<?php
// On parcourt la liste des utilisateurs
$users = $db->query("SELECT * FROM Utilisateurs");
while ($donnees=$users->fetchArray()) {
    echo '<li>';
    echo '<a class="admin_link" href="ban_user.php?id='.$donnees['idUser'].'">';
    echo '<span style="vertical-align: middle;">'.$donnees['username'].' -- </span>';
    echo '<span class="edit_text">Bannir </span>';
    echo '<span class="material-icons" style="display: inline-block; vertical-align: middle;">gavel</span>';
    echo '</a>';
    echo '</li>';
}
?>
		</ul>
	</div>
</body>
</html>
