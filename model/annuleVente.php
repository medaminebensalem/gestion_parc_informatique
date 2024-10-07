<?php
include 'connexion.php';

if (
    !empty($_GET['idAffictation']) &&
    !empty($_GET['idArticle']) &&
    !empty($_GET['quantite'])
) {

    $sql = "UPDATE affictation SET etat=? WHERE id=?";
    $req = $connexion->prepare($sql);
    $req->execute(array(0,$_GET['idAffictation']));

    if ($req->rowCount() != 0) {
        $sql = "UPDATE article SET quantite=quantite+? WHERE id=?";
        $req = $connexion->prepare($sql);
        $req->execute(array($_GET['quantite'],$_GET['idArticle']));

    }
}
header('Location: ../vue/affictation.php');