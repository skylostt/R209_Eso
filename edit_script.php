<?php
session_start();
include('db_class.php');
$db = new MyDB();
if (isset($_POST['mod']) AND isset($_POST['article-name']) AND isset($_POST['article-desc']) AND isset($_POST['article-price']) AND isset($_POST['stock-name']) AND $_SESSION['droits'] AND isset($_GET['id']) AND isset($_POST['article-cat'])) {
    if ($_POST['mod'] === '1') {
        echo $_POST['stock-name'];
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
        $req->execute();
        header('location: admin.php');
    } else {
        echo "delete";
    }

} else {
    header('location: index.php');
}

?>
