<?php
session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta charset="utf-8">
        <link rel="stylesheet" href="">
        <title></title>
    </head>
    <body>

    <h1 align="center">Paramètres de <?php echo $_SESSION['username']; ?></h1>
        <form class="log_reg_form" action="change_password.php" method="POST">
            <h2>Nouveau mot de passe</h2>
            <input type="password" name="current_password" placeholder="Mot de passe acutel" required/><br>
            <input type="password" name="new_password" placeholder="Nouveau mot de passe" required/><br>
            <button type="submit">Changer de mot de passe</button>
        </form>
        <form class="log_reg_form" action="delete_account.php" method="POST">
            <h2>Supprimer votre compte</h2>
            <input placeholder="Mot de passe" type="password" name="password" required/><br>
            <button type="submit">Supprimer le compte</button>
        </form>

    </body>
</html>
