<?php
session_start();
include('db_class.php');
if (! $_SESSION['droits']) {
    header('location: index.php');
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
        <h1><?php echo isset($_GET['id']) ? "Editer" : "Ajouter"; ?> une Catégorie</h1>
<?php
$db = new MyDB();
if (isset($_GET['id'])) {
    $req = $db->prepare("SELECT * FROM Categories WHERE idCat=:id;");
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
			<label for="article-name">Nom de la catégorie :</label>
            <input  class="form_input" type="text" id="article-name" name="cat-name" value="<?php echo isset($values['titre']) ? $values['titre'] : '';?>" required>
		  </div>

		  <div class="form-group">
			<label for="article-image">Image de la catégorie :</label>
			<input class="form_input" type="file" id="article-image" name="cat-image">
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
