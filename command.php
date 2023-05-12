<?php
session_start();
include("db_class.php");
$sid = session_id();

?>
<!DOCTYPE html>

<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link>
    <title>Votre panier</title>
    <link rel="stylesheet" href="res/font.css">
    <link rel="stylesheet" href="res/panier.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

<?php include('nav.php'); ?>
<h1 style="color:darkblue;" align="center">Votre Commande</h1>

<div align="center">
        <span class="erreur_span" align="center">
<?php
echo isset($_SESSION["error"]) ? $_SESSION["error"] : "";
$_SESSION["error"] = "";
?>
        </span>
        <span class="ok_span" align="center">
<?php
echo isset($_SESSION["ok"]) ? $_SESSION["ok"] : "";
$_SESSION["ok"] = "";
?>
        </span>
</div>
</div>
</body>
</html>
