<?php
session_start();
include('db_class.php');
if (! $_SESSION['user']['droits']) {
    header('location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Edit</title>
    <meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="res/editarticle.css">
	<link rel="stylesheet" type="text/css" href="res/font.css">
<?php include('nav.php'); ?>
	<div class="container">
        <h1><?php echo isset($_GET['id']) ? "Editer" : "Ajouter"; ?> un Article</h1>
<?php
$db = new MyDB();
if (isset($_GET['id'])) {
    $req = $db->prepare("SELECT * FROM Articles WHERE idProd=:id;");
    $req->bindValue(":id", $_GET['id']);
    $values = $req->execute()->fetchArray();
    if (empty($values)) {
        $_SESSION['error'] = "Erreur, l'identifiant recherché n'existe pas.";
        header("admin.php");
    }
}
?>
    <form action="edit_script.php<?php echo isset($_GET['id']) ? "?id=".$_GET['id'] : ""; ?>" method="POST" enctype="multipart/form-data">
		<div class="form-group">
			<label for="article-name">Nom de l'article :</label>
            <input  class="form_input" type="text" id="article-name" name="article-name" value="<?php echo isset($values['nom']) ? $values['nom'] : '';?>" required>
		  </div>

          <div class="form-group">
			<label for="article-desc">Description de l'article :</label>
			<textarea class="form_input" id="article-desc" name="article-desc" required><?php echo isset($values['description']) ? $values['description'] : '';?></textarea>
		  </div>

		  <div class="form-group">
			<label for="article-price">Prix de l'article :</label>
			<input class="form_input" type="text" id="article-price" name="article-price" value="<?php echo isset($values['prix']) ? $values['prix'] : '';?>" required>
		  </div>

          <div class="form-group">
			<label for="stock-name">Stock :</label>
			<input class="form_input" type="text" id="stock-name" name="stock-name" value="<?php echo isset($values['stock']) ? $values['stock'] : '';?>" required>
		  </div>

		  <div class="form-group">
			<label for="article-category-id">Catégorie :</label>
            <select name="article-cat" required>
<?php
$cat = $db->query('SELECT idCat, titre FROM Categories');
while ($donnees=$cat->fetchArray()) {
    // On ajoute l'attribut selected si le produit appartient à la catégorie parcourue
    $select = (isset($values) AND $values['idCat'] === $donnees['idCat']) ? 'selected' : '';
    echo '<option value="'.$donnees['idCat'].'" '.$select.'>'.$donnees['titre'].'</option>';
}
?>
            </select>
		  </div>

		  <div class="form-group">
			<label for="article-image">Image de l'article :</label>
			<input class="form_input" type="file" id="article-image" name="article-image">
		  </div>

		  <div class="form-group">
<?php
if (isset($_GET['id'])) {
    echo '<button class="form_button modify" type="submit" name="mod" value="1">Modifier</button>';
    echo '<button class="form_button delete" type="submit" name="mod" value="2">Supprimer</button>';
} else {
    echo '<button class="form_button modify" type="submit" name="mod" value="3">Ajouter</button>';
}
?>
		  </div>

        </form>
	</div>
</body>
</html>
