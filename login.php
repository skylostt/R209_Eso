<?php
session_start();
include("db_class.php");

if (isset($_SESSION['username'])) {
    header('location: account.php');
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="res/style_login.css">
    <title>File Upload</title>


<?php include('nav.php'); ?>
    <form action="login_user.php" method="POST" class="log_reg_form">
        <span class="erreur_span">
<?php
echo isset($_SESSION["error"]) ? $_SESSION["error"] : "";
$_SESSION["error"] = "";
?>
        </span>
        <span class="ok_span">
<?php
echo isset($_SESSION["ok"]) ? $_SESSION["ok"] : "";
$_SESSION["ok"] = "";
?>
        </span>
        <h1>Se connecter</h1>
        <div>
            <span class="material-icons" style="display: inline-block; vertical-align: middle;">person</span>
            <input placeholder="Nom d'utilisateur" type="text" name="username" required/><br>
        </div>
        <div>
            <span class="material-icons" style="display: inline-block; vertical-align: middle;">lock</span>
            <input placeholder="Mot de passe" type="password" name="password" required/><br>
        </div>
        <button type="submit" class="connect-button form_button_link" size="100" maxlength="100">Se connecter</button>
    </form>
    <form action="register_user.php" method="POST" class="log_reg_form">
        <h1>S'inscrire</h1>
        <div>
        <span class="material-icons" style="display: inline-block; vertical-align: middle;">person</span>
        <input placeholder="Nom d'utilisateur" type="text" name="username" required/>
        </div>
        <div>
            <span class="material-icons" style="display: inline-block; vertical-align: middle;">mail</span>
            <input placeholder="Adresse email" type="email" name="email" required/><br>
        </div>
        <div>
        <span class="material-icons" style="display: inline-block; vertical-align: middle;">lock</span>
        <input placeholder="Mot de passe" type="password" name="password" required/><br>
        </div>
        <button type="submit" class="connect-button form_button_link">S'inscrire</button>
    </form>
</body>
</html>
