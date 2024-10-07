<?php
session_start();
include 'connexion.php'; // Your database connection file

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $id_article = $_POST['id_article'];
    $id_employer = $_POST['id_employer'];
    $quantite = $_POST['quantite'];
   // $prix = $_POST['prix'];

    // Validation
    if (empty($id_article) || empty($id_employer) || empty($quantite)) {
        $_SESSION['message']['text'] = "Tous les champs sont obligatoires.";
        $_SESSION['message']['type'] = "error";
        header("Location: ../vue/commande.php");
        exit();
    }

    // Check if the order exists
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM commande WHERE id = :id");
    $stmt->execute([':id' => $id]);
    if ($stmt->fetchColumn() == 0) {
        $_SESSION['message']['text'] = "La commande spécifiée n'existe pas.";
        $_SESSION['message']['type'] = "error";
        header("Location: ../vue/commande.php");
        exit();
    }

    // Update the order
    $stmt = $pdo->prepare("UPDATE commande SET id_article = :id_article, id_employer = :id_employer, quantite = :quantite WHERE id = :id");
    $stmt->execute([
        ':id_article' => $id_article,
        ':id_employer' => $id_employer,
        ':quantite' => $quantite,
        //':prix' => $prix,
        ':id' => $id
    ]);

    $_SESSION['message']['text'] = "Commande modifiée avec succès.";
    $_SESSION['message']['type'] = "success";
    header("Location: ../vue/commande.php");
    exit();
}
?>
