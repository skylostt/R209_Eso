<?php
session_start();
include('db_class.php');
$db = new MyDB();
if (! isset($_SESSION['user'])) {
    header('location: login.php');
    exit;
}

if (isset($_POST['address']) AND $_POST['address'] !== '') {
    $panier_vide = $db->query("SELECT * FROM Paniers WHERE idUser='".$_SESSION['user']['idUser']."';")->fetchArray();
    if (! empty($panier_vide)) {
        $new_com = $db->prepare("INSERT INTO Commandes (idUser, adresse, etat, prix) VALUES (:user, :addr, 'En préparation', 0);");
        $new_com->bindValue(':user', $_SESSION['user']['idUser']);
        $new_com->bindValue(':addr', $_POST['address']);
        $new_com->execute();

        $com_id = $db->query("SELECT MAX(idCom) FROM Commandes WHERE idUser='".$_SESSION['user']['idUser']."';")->fetchArray()['MAX(idCom)'];
    } else {
        header('location: panier.php');
        exit;
    }
    $panier = $db->query("SELECT * FROM Paniers WHERE idUser='".$_SESSION['user']['idUser']."';");
    $prix = 0;
    while ($donnees=$panier->fetchArray()) {
        $stock_prix = $db->query("SELECT stock, prix FROM Articles WHERE idProd='".$donnees['idProd']."';")->fetchArray();
        if ($stock_prix['stock'] >= $donnees['quantite']) {
            $prix += $donnees['quantite']*$stock_prix['prix'];
            $req_change_qte = "UPDATE Articles SET stock=".$stock_prix['stock']-$donnees['quantite']." WHERE idProd='".$donnees['idProd']."';";
            $db->query($req_change_qte);

            $insert_command = $db->prepare("INSERT INTO ProdCommandes (idCom, idProd, quantite) VALUES (:com, :prod, :qte);");
            $insert_command->bindValue(':com', $com_id);
            $insert_command->bindValue(':prod', $donnees['idProd']);
            $insert_command->bindValue(':qte', $donnees['quantite']);
            $insert_command->execute();

            $del_command=$db->prepare("DELETE FROM Paniers WHERE idProd=:prod AND idUser=:user;");
            $del_command->bindValue(':prod', $donnees['idProd']);
            $del_command->bindValue(':user', $_SESSION['user']['idUser']);
            $del_command->execute();
        }
    }
    $db->query("UPDATE Commandes SET prix=".$prix." WHERE idCom=".$com_id.";");
} else {
    header('location: validate_command.php');
    exit;
}
header('location: command.php');

?>
