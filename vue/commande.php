<?php
include 'entete.php'; // Inclure le fichier d'en-tête
include_once 'functions.php'; // Inclure une seule fois







// Vérifie si un ID de commande est fourni
$article = null;
if (!empty($_GET['id'])) {
    $article = getCommande($_GET['id']); // Récupérer les détails de la commande
}

// Fonction pour récupérer les articles
function getArticle() {
    $pdo = new PDO('mysql:host=localhost;dbname=gestion_stock_dcli', 'root', '');
    $stmt = $pdo->query("SELECT id, nom_article,  quantite FROM article");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Fonction pour récupérer les employés
function getEmployer() {
    $pdo = new PDO('mysql:host=localhost;dbname=gestion_stock_dcli', 'root', '');
    $stmt = $pdo->query("SELECT id, nom, prenom FROM employer");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Fonction pour récupérer les commandes
function getCommande($id = null) {
    $pdo = new PDO('mysql:host=localhost;dbname=gestion_stock_dcli', 'root', '');
    $sql = "SELECT c.id, a.nom_article, e.nom, e.prenom, c.quantite, c.date_commande, a.prix
            FROM commande c
            JOIN article a ON c.id_article = a.id
            JOIN employer e ON c.id_employer = e.id";
    if ($id) {
        $sql .= " WHERE c.id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } else {
        return $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
<div class="home-content">
    <div class="overview-boxes">
        <div class="box">
            <form action="<?= !empty($_GET['id']) ? "../model/modifCommande.php" : "../model/ajoutCommande.php" ?>" method="post">
                <input value="<?= !empty($_GET['id']) ? $article['id'] : "" ?>" type="hidden" name="id" id="id">

                <label for="id_article">Article</label>
                <select onchange="setPrix()" name="id_article" id="id_article">
                    <?php
                    $articles = getArticle();
                    if (!empty($articles) && is_array($articles)) {
                        foreach ($articles as $value) {
                            ?>
                            <option data-prix="<?= $value['prix'] ?>" data-quantite="<?= $value['quantite'] ?>" value="<?= $value['id'] ?>">
                                <?= htmlspecialchars($value['nom_article'] . " - " . $value['quantite'] . " disponible") ?>
                            </option>
                            <?php
                        }
                    }
                    ?>
                </select>

                <label for="id_employer">Employé</label>
                <select name="id_employer" id="id_employer">
                    <?php
                    $employers = getEmployer();
                    if (!empty($employers) && is_array($employers)) {
                        foreach ($employers as $value) {
                            ?>
                            <option value="<?= $value['id'] ?>"><?= htmlspecialchars($value['nom'] . " " . $value['prenom']) ?></option>
                            <?php
                        }
                    }
                    ?>
                </select>

                <label for="quantite">Quantité</label>
                <input onkeyup="setPrix()" value="<?= !empty($_GET['id']) ? $article['quantite'] : "" ?>" type="number" name="quantite" id="quantite" placeholder="Veuillez saisir la quantité">

                <!--<label for="prix">Prix</label>
                <input value="<?= !empty($_GET['id']) ? $article['prix'] : "" ?>" type="number" name="prix" id="prix" placeholder="Prix total" readonly>-->

                <button type="submit">Valider</button>

                <?php
                if (!empty($_SESSION['message']['text'])) {
                    ?>
                    <div class="alert <?= $_SESSION['message']['type'] ?>">
                        <?= htmlspecialchars($_SESSION['message']['text']) ?>
                    </div>
                    <?php
                }
                ?>
            </form>
        </div>

        <div class="box">
            <table class="mtable">
                <tr>
                    <th>Article</th>
                    <th>Employé</th>
                    <th>Quantité</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
                <?php
                $affictation = getCommande();
                if (!empty($affictation) && is_array($affictation)) {
                    foreach ($affictation as $value) {
                        ?>
                        <tr>
                            <td><?= htmlspecialchars($value['nom_article']) ?></td>
                            <td><?= htmlspecialchars($value['nom'] . " " . $value['prenom']) ?></td>
                            <td><?= htmlspecialchars($value['quantite']) ?></td>
                            <td><?= !empty($value['date_commande']) ? date('d/m/Y H:i:s', strtotime($value['date_commande'])) : 'Date non disponible' ?></td>
                            <td>
                                <a href="recuCommande.php?id=<?= htmlspecialchars($value['id']) ?>"><i class='bx bx-receipt'></i></a>
                                <a onclick="annuleCommande(<?= htmlspecialchars($value['id']) ?>, <?= htmlspecialchars($value['id_article']) ?>, <?= htmlspecialchars($value['quantite']) ?>)" style="color: red;"><i class='bx bx-stop-circle'></i></a>
                            </td>
                        </tr>
                        <?php
                    }
                }
                ?>
            </table>
        </div>
    </div>
</div>

<?php
include 'pied.php'; // Inclure le fichier de pied de page
?>

<script>
    function annuleCommande(idCommande, idArticle, quantite) {
        if (confirm("Voulez-vous vraiment annuler cette affectation ?")) {
            window.location.href = "../model/annuleCommande.php?idCommande=" + idCommande + "&idArticle=" + idArticle + "&quantite=" + quantite;
        }
    }

    function setPrix() {
        var article = document.querySelector('#id_article');
        var quantite = document.querySelector('#quantite');
        var prix = document.querySelector('#prix');

      //  var prixUnitaire = article.options[article.selectedIndex].getAttribute('data-prix');

       // var totalPrix = Number(quantite.value) * Number(prixUnitaire);
        if (!isNaN(totalPrix)) {
            prix.value = totalPrix.toFixed(2);
        }
    }
</script>
