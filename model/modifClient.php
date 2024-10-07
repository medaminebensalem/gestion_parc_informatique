<?php
include 'connexion.php';
if (
    !empty($_POST['nom'])
    && !empty($_POST['prenom'])
    && !empty($_POST['telephone'])
    && !empty($_POST['adresse'])
    && !empty($_POST['id'])
    && !empty($_POST['id_service'])
) {

$sql = "UPDATE employer SET nom=?, prenom=?, telephone=?, adresse=?,id_service=? WHERE id=?";
    $req = $connexion->prepare($sql);
    
    $req->execute(array(
        $_POST['nom'],
        $_POST['prenom'],
        $_POST['telephone'],
        $_POST['adresse'],
        $_POST['id'],
        $_POST['id_service'],
    ));
    
    if ( $req->rowCount()!=0) {
        $_SESSION['message']['text'] = "employer modifié avec succès";
        $_SESSION['message']['type'] = "success";
    }else {
        $_SESSION['message']['text'] = "Rien a été modifié";
        $_SESSION['message']['type'] = "warning";
    }

} else {
    $_SESSION['message']['text'] ="Une information obligatoire non rensignée";
    $_SESSION['message']['type'] = "danger";
}

header('Location: ../vue/employer.php');