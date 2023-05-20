<?php
session_start();
include('db_class.php');
$db = new MyDB();
if (! isset($_SESSION['user'])) {
    header('location: login.php');
}

if (! isset($_POST['address'])) {
    header('location: command.php');
}

$panier = $db->query("SELECT * FROM Paniers WHERE idUser=".$_SESSION['user']['idUser']);

while ($donnees=$panier->fetchArray()) {
    $q_dispo = $db->query("SELECT stock FROM Articles WHERE idProd='".$donnees['idProd']."';")->fetchArray()['stock'];
    if ($q_dispo >= $donnees['quantite']) {
        $req_change_qte = "UPDATE Articles SET stock=".$q_dispo-$donnees['quantite']." WHERE idProd='".$donnees['idProd']."';";
        $db->query($req_change_qte);

        $insert_command = $db->prepare("INSERT INTO Commandes (idUser, adresse, idProd, quantite, etat) VALUES (:user, :addr, :prod, :qte, 'En préparation');");
        $insert_command->bindValue(':user', $_SESSION['user']['idUser']);
        $insert_command->bindValue(':addr', htmlspecialchars($_POST['address']));
        $insert_command->bindValue(':prod', $donnees['idProd']);
        $insert_command->bindValue(':qte', $donnees['quantite']);
        $insert_command->execute();

        $del_command=$db->prepare("DELETE FROM Paniers WHERE idProd=:prod AND idUser=:user;");
        $del_command->bindValue(':prod', $donnees['idProd']);
        $del_command->bindValue(':user', $_SESSION['user']['idUser']);
        $del_command->execute();
    }
}
header('location: command.php');

?>
