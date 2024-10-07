<?php
include 'connexion.php';
if (
    !empty($_POST['nom'])
    && !empty($_POST['prenom'])
    && !empty($_POST['telephone'])
    && !empty($_POST['adresse'])
    && !empty($_POST['id_service'])
) {

$sql = "INSERT INTO employer(nom, prenom, telephone, adresse,id_service)
        VALUES(?, ?, ?, ?,?)";
    $req = $connexion->prepare($sql);
    
    $req->execute(array(
        $_POST['nom'],
        $_POST['prenom'],
        $_POST['telephone'],
        $_POST['adresse'],
        $_POST['id_service'],

    ));
    
    if ( $req->rowCount()!=0) {
        $_SESSION['message']['text'] = "Employer ajouté avec succès";
        $_SESSION['message']['type'] = "success";
    }else {
        $_SESSION['message']['text'] = "Une erreur s'est produite lors de l'ajout du Employer";
        $_SESSION['message']['type'] = "danger";
    }

} else {
    $_SESSION['message']['text'] ="Une information obligatoire non rensignée";
    $_SESSION['message']['type'] = "danger";
}

header('Location: ../vue/employer.php');