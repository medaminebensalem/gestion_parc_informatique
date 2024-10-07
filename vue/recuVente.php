<?php
include '../model/connexion.php'; // Inclure la connexion à la base de données
include 'entete.php'; // Inclure l'en-tête de la page

require_once '../model/function.php'; // Inclure les fonctions, assurez-vous que le chemin est correct

// Fonction pour obtenir les données de l'affectation
function getAffictation($id) {
    global $connexion; // Assurez-vous que $connexion est défini dans connexion.php
    $sql = "SELECT * FROM affictation WHERE id = :id";
    $stmt = $connexion->prepare($sql);
    $stmt->execute([':id' => $id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// Assurez-vous que l'ID est bien spécifié dans l'URL
if (!empty($_GET['id'])) {
    $affictation = getAffictation($_GET['id']);
    if ($affictation === false) {
        die("Affectation non trouvée.");
    }
} else {
    die("ID non spécifié.");
}
?>

<div class="home-content">
    <button class="hidden-print" id="btnPrint" style="position: relative; left: 45%;"> <i class='bx bx-printer'></i> Imprimer</button>

    <div class="page">
        <div class="cote-a-cote">
            <h2>Parc Stock</h2>
            <div>
                <p>Reçu N° #: <?= htmlspecialchars($affictation['id']) ?> </p>
                <p>Date: <?= date('d/m/Y H:i:s', strtotime($affictation['date_affictation'])) ?> </p>
            </div>
        </div>

        <div class="cote-a-cote" style="width: 50%;">
            <p>Nom :</p>
            <p><?= htmlspecialchars($affictation['nom'] . " " . $affictation['prenom']) ?></p>
        </div>
        <div class="cote-a-cote" style="width: 50%;">
            <p>Tel :</p>
            <p><?= htmlspecialchars($affictation['telephone']) ?></p>
        </div>
        <div class="cote-a-cote" style="width: 50%;">
            <p>Adresse :</p>
            <p><?= htmlspecialchars($affictation['adresse']) ?></p>
        </div>
        
        <br>
        
        <table class="mtable">
            <tr>
                <th>Designation</th>
                <th>Quantité</th>
            </tr>
            <tr>
                <td><?= htmlspecialchars($affictation['nom_article']) ?></td>
                <td><?= htmlspecialchars($affictation['quantite']) ?></td>
            </tr>
        </table>
    </div>
</div>

<?php
include '../vue/pied.php'; // Inclure le pied de page
?>

<script>
    var btnPrint = document.querySelector('#btnPrint');
    btnPrint.addEventListener("click", () => {
        window.print();
    });
</script>
