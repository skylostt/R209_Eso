<?php session_start(); ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="res/style_login.css">
    <title>File Upload</title>
</head>
<body>
    <form action="/login_user.php" method="POST" class="log_reg_form">
        <span style="color: red;">
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
        <button type="submit" class="connect-button" size="100" maxlength="100">Se connecter</button>
    </form>
    <form action="/register" method="POST" class="log_reg_form">
        <h1>S'inscrire</h1>
        <div>
        <span class="material-icons" style="display: inline-block; vertical-align: middle;">person</span>
        <input placeholder="Nom d'utilisateur" type="text" name="username" required/>
        </div>
        <div>
            <span class="material-icons" style="display: inline-block; vertical-align: middle;">mail</span>
            <input placeholder="Adresse email" type="text" name="email" required/><br>
        </div>
        <div>
        <span class="material-icons" style="display: inline-block; vertical-align: middle;">lock</span>
        <input placeholder="Mot de passe" type="password" name="password" required/><br>
        </div>
        <button type="submit" class="connect-button">S'inscrire</button>
    </form>
</body>
</html>
