<?php
include('db_class.php');
$db = new MyDB();

$req = $db->query("SELECT DISTINCT idSession FROM Paniers WHERE idUser IS NULL;");
$time = time();

while ($donnees=$req->fetchArray()) {
    $sid = $donnees['idSession'];
    session_id($sid);
    session_start();
    if (!isset($_SESSION['activity']) OR $_SESSION['activity'] < $time-3600*24) {
        $db->query("DELETE FROM Paniers WHERE idSession='".$sid."' AND idUser IS NULL;");
        echo "suppr : ";
        echo $sid;
        echo "<br>";
        session_destroy();
    } else {
        session_write_close();
    }
}
?>
