<?php
include('db_class.php');
$db = new MyDB();

$req = $db->query("SELECT idSession FROM Paniers WHERE idUser IS NULL;");

while ($donnees=$req->fetchArray()) {
    $sid=$donnees['idSession'];
    echo "<br>";
    session_id($sid);
    session_start();
    echo "session : ";
    echo session_abort();
}

?>
