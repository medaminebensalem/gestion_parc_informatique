<?php
include 'connexion.php';
include_once "function.php";

if (
    !empty($_POST['id_article'])
    && !empty($_POST['id_employer'])
    && !empty($_POST['quantite'])
    
) {

$article = getArticle($_POST['id_article']);

if (!empty($article) && is_array($article)) {
    if ($_POST['quantite']>$article['quantite']) {
        $_SESSION['message']['text'] = "La quantité à vendre n'est pas disponible";
        $_SESSION['message']['type'] = "danger";
    }else {
        $sql = "INSERT INTO affictation (id_article, id_employer, quantite )
            VALUES(?, ?, ?)";
        $req = $connexion->prepare($sql);
    
        $req->execute(array(
            $_POST['id_article'],  
            $_POST['id_employer'],
            $_POST['quantite'],
            
        ));
    
        if ( $req->rowCount()!=0) {
        
        $sql = "UPDATE article SET quantite=quantite-? WHERE id=?";
        $req = $connexion->prepare($sql);
    
        $req->execute(array(
            $_POST['quantite'],
            $_POST['id_article'], 
        ));
        
        if ($req->rowCount()!=0) {
            $_SESSION['message']['text'] = "affictation effectué avec succès";
            $_SESSION['message']['type'] = "success";
        } else {
            $_SESSION['message']['text'] = "Impossible de faire cette affictation";
            $_SESSION['message']['type'] = "danger";
        }
            
        }else {
            $_SESSION['message']['text'] = "Une erreur s'est produite lors de la affictation";
            $_SESSION['message']['type'] = "danger";
        }
    }
}




} else {
    $_SESSION['message']['text'] ="Une information obligatoire non rensignée";
    $_SESSION['message']['type'] = "danger";
}

header('Location: ../vue/affictation.php');