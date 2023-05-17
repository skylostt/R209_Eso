<?php
session_start();
include('db_class.php');
if (isset($_POST['mod']) AND isset($_POST['article-name']) AND isset($_POST['article-desc']) AND isset($_POST['article-price']) AND isset($_POST['stock-name']) AND $_SESSION['droits']) {
    if ($_POST['mod'] === '1') {
        if (! empty($_FILES)) {
            if (getimagesize($_FILES['article-image']['tmp_name']) !== FALSE) {
                echo "image";
            }
        } else {
            echo "no image";
        }
    } else {
        echo "delete";
    }

} else {
    header('location: index.php');
}

?>
