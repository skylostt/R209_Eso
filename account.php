<?php
session_start();
include('db_class.php');
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="res/style_login.css">
        <link rel="stylesheet" href="res/font.css">
        <title>Paramètres du compte</title>
<?php
include('nav.php');
?>
    <h1 align="center">Paramètres de <?php echo $_SESSION['user']['username']; ?></h1>
        <form class="log_reg_form" action="change_password.php" method="POST">
            <span class='erreur_span'>
<?php
// Si la variable d'erreur est définie afficher le message
echo isset($_SESSION["error"]) ? $_SESSION["error"] : "";
$_SESSION["error"] = "";
?>
            </span>
            <span class='ok_span'>
<?php
// Si la variable de succès est définie afficher le message
echo isset($_SESSION["ok"]) ? $_SESSION["ok"] : "";
$_SESSION["ok"] = "";
?>
            </span>
            <h2>Nouveau mot de passe</h2>
            <input type="password" name="current_password" placeholder="Mot de passe actuel" required/><br>
            <input type="password" name="new_password" placeholder="Nouveau mot de passe" required/><br>
            <button type="submit" class="form_button_link">Changer de mot de passe</button>
        </form>
        <div class='disco_div'>
            <h2>Se déconnecter</h2>
            <a class='form_button_link' href='disconnect.php'>Déconnexion</a>
        </div>
<?php
// Si l'utilisateur est admin afficher un bouton d'accès à l'admin. page
if ($_SESSION['user']['droits']) {
    echo '<div class="disco_div">';
    echo '<h2>Accéder à la page d\'administration</h2>';
    echo '<a class="form_button_link" href="admin.php">Page d\'administration</a>';
    echo '</div>';
}
?>
        <form class="log_reg_form" action="delete_account.php" method="POST">
            <h2>Supprimer votre compte</h2>
            <input placeholder="Mot de passe" type="password" name="password" required/><br>
            <button type="submit" class="form_button_link">Supprimer le compte</button>
        </form>

    </body>
</html>
