<?php
session_start();
include 'connexion.php'; // Assurez-vous que le chemin est correct

function articleExists($id_article) {
    global $connexion; // Utilisez la connexion globale définie dans connexion.php
    $stmt = $connexion->prepare("SELECT COUNT(*) FROM article WHERE id = :id");
    $stmt->execute([':id' => $id_article]);
    return $stmt->fetchColumn() > 0;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_article = $_POST['id_article'];
    $id_employer = $_POST['id_employer'];
    $quantite = $_POST['quantite'];

    // Validation
    if (empty($id_article) || empty($id_employer) || empty($quantite)) {
        $_SESSION['message']['text'] = "Tous les champs sont obligatoires.";
        $_SESSION['message']['type'] = "error";
        header("Location: ../vue/commande.php");
        exit();
    }

    if (!articleExists($id_article)) {
        $_SESSION['message']['text'] = "L'article sélectionné n'existe pas.";
        $_SESSION['message']['type'] = "error";
        header("Location: ../vue/commande.php");
        exit();
    }

    // Insert into database
    $stmt = $connexion->prepare("INSERT INTO commande (id_article, id_employer, quantite) VALUES (:id_article, :id_employer, :quantite)");
    $stmt->execute([
        ':id_article' => $id_article,
        ':id_employer' => $id_employer,
        ':quantite' => $quantite,
    ]);

    $_SESSION['message']['text'] = "Commande ajoutée avec succès.";
    $_SESSION['message']['type'] = "success";
    header("Location: ../vue/commande.php");
    exit();
}
?>
