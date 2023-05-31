<!DOCTYPE html>
<?php
include('db_class.php');
$db = new MyDB();

if (! (isset($_GET['key']) AND $_GET['key'] === 'key')) {
    echo "clef invalide";
    exit;
}

$req = $db->query("SELECT DISTINCT idSession FROM Paniers WHERE idUser IS NULL;");
$time = time();

while ($donnees=$req->fetchArray()) {
    $sid = $donnees['idSession'];
    session_id($sid);
    session_start();
    // Si l'utilisateur n'a pas utilisé sa session depuis 24h
    if (!isset($_SESSION['activity']) OR $_SESSION['activity'] < $time-3600*24) {
        $db->query("DELETE FROM Paniers WHERE idSession='".$sid."' AND idUser IS NULL;");
        echo "suppr : ";
        echo $sid;
        echo "<br>\n";
        session_destroy();
    } else {
        session_write_close();
    }
}
?>
