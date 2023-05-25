<?php
session_start();
include('db_class.php');
if (! isset($_SESSION['user']) OR $_SESSION['user']['droits'] !== 1) {
    header('location: index.php');
    exit;
}

if (! isset($_GET['id']) OR ! isset($_POST['state']) OR ! isset($_POST['mod'])) {
    header('location: admin.php');
    $_SESSION['error'] = 'Erreur, formulaire invalide.';
    exit;
}

$db = new MyDB();
if ($_POST['mod'] == 1) {
    $req = $db->prepare("UPDATE Commandes SET etat=:state WHERE idCom=:id;");
    $req->bindValue(":state", $_POST['state']);
    $req->bindValue(":id", $_GET['id']);
    echo "ok";
} else {
    $req = $db->prepare("DELETE FROM Commandes WHERE idCom=:id;");
    $req->bindValue(":id", $_GET['id']);
}
$req->execute();
$db->close();
header('location: admin.php');
?>
