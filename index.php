<?php
session_start();
include('db_class.php');
$_SESSION['activity'] = time();
$_SESSION['last_page'] = 'index.php';

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Page d'accueil</title>
    <link rel="stylesheet" href="res/style_index.css">
<?php
include('nav.php');
?>
    <h1 style='margin-top: 5%'>Bienvenue sur la boutique La Fibre Des Ames !</h1>
    <div class='bienvenue'>
        Bienvenue dans notre boutique d'ésotérisme en ligne! Nous sommes ravis de vous accueillir dans notre univers mystique et fascinant où vous pourrez découvrir des produits uniques et spirituels pour vous aider dans votre cheminement personnel. Que vous cherchiez des cristaux pour la guérison, des tarots pour la divination ou des encens pour la méditation, nous avons tout ce dont vous avez besoin pour nourrir votre âme et votre esprit. Nous sommes passionnés par notre métier et nous nous engageons à vous offrir un service de qualité et une expérience d'achat agréable. N'hésitez pas à nous contacter si vous avez des questions ou des besoins particuliers. Nous sommes là pour vous aider à trouver ce que vous cherchez et à répondre à vos besoins en matière d'ésotérisme. Merci de nous faire confiance et bonne visite dans notre boutique en ligne!
    </div>
    <h1>Catégories</h1>
    <div class='categories_index'>
<?php
$db = new MyDB();
$req = 'SELECT * FROM Categories';
$reponse = $db->query($req);
while ($donnees=$reponse->fetchArray())
{
    echo '<div class="cat_content">';
    echo '<a href="search.php?cat='.$donnees['idCat'].'">';
    echo '<img class="cat_img" src="data:'.$donnees['mime'].';base64,'.$donnees['b64img'].'" alt="">';
    echo '</a>';
    echo '<div class="bottom-left">'.$donnees['titre'].'</div>';
    echo '</div>';
}
$db->close();
?>
    </div>
</body>
</html>
