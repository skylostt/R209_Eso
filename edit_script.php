<?php
session_start();
include('db_class.php');
if (isset($_POST['mod']) AND isset($_POST['article-name']) AND isset($_POST['article-desc']) AND isset($_POST['article-price']) AND isset($_POST['stock-name']) AND $_SESSION['droits'] AND isset($_POST['article-cat'])) {
    $db = new MyDB();
    if ($_POST['mod'] === '1' AND isset($_GET['id'])) {
        if ($_FILES['article-image']['tmp_name'] AND getimagesize($_FILES['article-image']['tmp_name'])) {
            $mime = mime_content_type($_FILES['article-image']['tmp_name']);
            $b64img = base64_encode(file_get_contents($_FILES['article-image']['tmp_name']));
            $req = $db->prepare("UPDATE Articles SET nom=:nom, quantite=:quantite, prix=:prix, description=:description, b64img=:b64img, idCat=:idCat, mime=:mime WHERE idProd=:id;");
            $req->bindValue(':nom', $_POST['article-name']);
            $req->bindValue(':quantite', $_POST['stock-name']);
            $req->bindValue(':prix', $_POST['article-price']);
            $req->bindValue(':description', $_POST['article-desc']);
            $req->bindValue(':b64img', $b64img);
            $req->bindValue(':idCat', $_POST['article-cat']);
            $req->bindValue(':mime', $mime);
            $req->bindValue(':id', $_GET['id']);
        } else {
            $req = $db->prepare("UPDATE Articles SET nom=:nom, quantite=:quantite, prix=:prix, description=:description, idCat=:idCat WHERE idProd=:id;");
            $req->bindValue(':nom', $_POST['article-name']);
            $req->bindValue(':quantite', $_POST['stock-name']);
            $req->bindValue(':prix', $_POST['article-price']);
            $req->bindValue(':description', $_POST['article-desc']);
            $req->bindValue(':idCat', $_POST['article-cat']);
            $req->bindValue(':id', $_GET['id']);
        }
    } elseif ($_POST['mod'] === '2' AND isset($_GET['id'])) {
        $req = $db->prepare("DELETE FROM Articles WHERE idProd=:id;");
        $req->bindValue(':id', $_GET['id']);
    } elseif ($_POST['mod'] === '3' AND $_FILES['article-image']['tmp_name'] AND getimagesize($_FILES['article-image']['tmp_name'])) {
            $mime = mime_content_type($_FILES['article-image']['tmp_name']);
            $b64img = base64_encode(file_get_contents($_FILES['article-image']['tmp_name']));
            $req = $db->prepare("INSERT INTO Articles (nom, quantite, prix, description, b64img, idCat, mime) VALUES (:nom, :quantite, :prix, :description, :b64img, :idCat, :mime);");
            $req->bindValue(':nom', $_POST['article-name']);
            $req->bindValue(':quantite', $_POST['stock-name']);
            $req->bindValue(':prix', $_POST['article-price']);
            $req->bindValue(':description', $_POST['article-desc']);
            $req->bindValue(':b64img', $b64img);
            $req->bindValue(':idCat', $_POST['article-cat']);
            $req->bindValue(':mime', $mime);
    } else {
        $_SESSION['error'] = 'Erreur dans le formulaire.';
        header('location: admin.php');
    }
    $req->execute();
    $_SESSION['error'] = $db->lastErrorMsg();
    $db->close();
    header('location: admin.php');
} else if (isset($_POST['mod']) AND isset($_SESSION['droits']) AND isset($_POST['cat-name'])) {
    $db = new MyDB();
    if ($_POST['mod'] === '1' AND isset($_GET['id'])) {
        if ($_FILES['cat-image']['tmp_name'] AND getimagesize($_FILES['cat-image']['tmp_name'])) {
            $mime = mime_content_type($_FILES['cat-image']['tmp_name']);
            $b64img = base64_encode(file_get_contents($_FILES['cat-image']['tmp_name']));
            $req = $db->prepare("UPDATE Categories SET titre=:titre, b64img=:b64img, mime=:mime WHERE idCat=:id;");
            $req->bindValue(':titre', $_POST['cat-name']);
            $req->bindValue(':b64img', $b64img);
            $req->bindValue(':mime', $mime);
        } else {
            $req = $db->prepare("UPDATE Categories SET titre=:titre WHERE idCat=:id;");
            $req->bindValue(':titre', $_POST['cat-name']);
            $req->bindValue(':id', $_GET['id']);
        }
    } else if ($_POST['mod'] === '2' AND isset($_GET['id'])) {
        $req = $db->prepare("DELETE FROM Categories WHERE idCat=:id;");
        $req->bindValue(':id', $_GET['id']);
    } else if ($_POST['mod'] === '3' AND $_FILES['cat-image']['tmp_name'] AND getimagesize($_FILES['cat-image']['tmp_name'])) {
            $mime = mime_content_type($_FILES['cat-image']['tmp_name']);
            $b64img = base64_encode(file_get_contents($_FILES['cat-image']['tmp_name']));
            $req = $db->prepare("INSERT INTO Categories (titre, b64img, mime) VALUES (:titre, :b64img, :mime);");
            $req->bindValue(':titre', $_POST['cat-name']);
            $req->bindValue(':b64img', $b64img);
            $req->bindValue(':mime', $mime);

    } else {
        $_SESSION['error'] = 'Erreur dans le formulaire.';
        header('location: admin.php');
    }
    $req->execute();
    $db->close();
    header('location: admin.php');

} else {
    header('location: index.php');
}

?>
