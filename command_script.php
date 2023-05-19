<?php
session_start();
include('db_class.php');
$db = new MyDB();
if (! isset($_SESSION['user'])) {
    header('location: login.php');
}

if (! isset($_POST['address'])) {
    header('location: command.php');
}

$panier = $db->query("SELECT * FROM Paniers WHERE idUser=".$_SESSION['user']['idUser']);

while ($donnees=$panier->fetchArray()) {

}

?>
