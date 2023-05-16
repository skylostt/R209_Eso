<?php
session_start();
include('db_class.php');
$db = new MyDB();
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
				<tr>
					<td>Catégorie 1</td>
                    <td>
                        <a class="admin_link" href="edit_cat.php?cat=">
                            <span class="edit_text">Editer</span>
                            <span class="material-icons" style="display: inline-block; vertical-align: middle;">edit</span>
                        </a>
                    </td>
				</tr>
				<tr>
					<td>Catégorie 2</td>
                    <td>
                        <a class="admin_link" href="edit_cat.php?cat=">
                            <span class="edit_text">Editer</span>
                            <span class="material-icons" style="display: inline-block; vertical-align: middle;">edit</span>
                        </a>
                    </td>
				</tr>
			</tbody>
		</table>
		<h2>Editer un Article</h2>
		<table>
			<thead>
				<tr>
					<th>Titre de l'article</th>
					<th>Catégorie</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>Article 1</td>
					<td>Catégorie 1</td>
                    <td>
                        <a class="admin_link">
                            <span class="edit_text">Editer</span>
                            <span class="material-icons" style="display: inline-block; vertical-align: middle;">edit</span>
                        </a>
                    </td>
				</tr>
				<tr>
					<td>Article 2</td>
					<td>Catégorie 2</td>
                    <td>
                        <a class="admin_link">
                            <span class="edit_text">Editer</span>
                            <span class="material-icons" style="display: inline-block; vertical-align: middle;">edit</span>
                        </a>
                    </td>
				</tr>
			</tbody>
		</table>
		<h2>Liste des utilisateurs</h2>
		<ul>
<?php
$users = $db->query("SELECT * FROM Utilisateurs");
while ($donnees=$users->fetchArray()) {
    echo '<li>';
    echo '<a class="admin_link" href="ban_user.php?id='.$donnees['idUser'].'">';
    echo '<span style="vertical-align: middle;">'.$donnees['username'].' -- </span>';
    echo '<span class="edit_text">Bannir</span>';
    echo '<span class="material-icons" style="display: inline-block; vertical-align: middle;">gavel</span>';
    echo '</a>';
    echo '</li>';
}
?>
		</ul>
	</div>
</body>
</html>
