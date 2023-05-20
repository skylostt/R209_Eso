<?php
session_start();
include('db_class.php');
if (! (isset($_SESSION['user']) AND isset($_POST['eval']) AND isset($_POST['comment']) AND is_numeric($_POST['eval']) AND isset($_GET['id']))) {
    header('location: index.php');
    exit;
}
$db = new MyDB();

if (intval($_POST['eval']) <= 5 AND intval($_POST['eval']) >= 0) {
    $req = $db->prepare("INSERT INTO Commentaires (idUser, eval, texte, idProd) VALUES (:idUser, :eval, :texte, :idProd);");
    $req->bindValue(":idUser", $_SESSION['user']['idUser']);
    $req->bindValue(":eval", intval($_POST['eval']));
    $req->bindValue(":texte", htmlspecialchars($_POST['comment']));
    $req->bindValue(":idProd", $_GET['id']);
    $req->execute();
    header('location: article.php?id='.$_GET['id']);
}
?>
