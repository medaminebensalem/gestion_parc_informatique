<?php
include 'entete.php'; // Inclut l'en-tête de la page

// Vérifie si un identifiant de commande est présent dans l'URL
if (!empty($_GET['id'])) {
    $article = getCommande($_GET['id']); // Récupère les détails de la commande
}
?>
<div class="home-content">
    <div class="overview-boxes">
        <div class="box">
            <form action="<?= !empty($_GET['id']) ? "../model/modifCommande.php" : "../model/ajoutCommande.php" ?>" method="post">
                <!-- Champ caché pour l'ID de la commande -->
                <input value="<?= !empty($_GET['id']) ? $article['id'] : "" ?>" type="hidden" name="id" id="id">

                <!-- Sélecteur pour l'article -->
                <label for="id_article">Article</label>
                <select onchange="setPrix()" name="id_article" id="id_article">
                    <?php
                    $articles = getArticle(); // Récupère la liste des articles
                    if (!empty($articles) && is_array($articles)) {
                        foreach ($articles as $value) {
                            ?>
                            <option data-prix="<?= $value['prix'] ?>" value="<?= $value['id'] ?>">
                                <?= $value['nom_article'] . " - " . $value['quantite'] . " disponible" ?>
                            </option>
                            <?php
                        }
                    }
                    ?>
                </select>

                <!-- Sélecteur pour l'employé -->
                <label for="id_employer">Employé</label>
                <select name="id_employer" id="id_employer">
                    <?php
                    $employers = getEmployer(); // Récupère la liste des employés
                    if (!empty($employers) && is_array($employers)) {
                        foreach ($employers as $value) {
                            ?>
                            <option value="<?= $value['id'] ?>"><?= $value['nom'] . " " . $value['prenom'] ?></option>
                            <?php
                        }
                    }
                    ?>
                </select>

                <!-- Champ pour la quantité -->
                <label for="quantite">Quantité</label>
                <input onkeyup="setPrix()" value="<?= !empty($_GET['id']) ? $article['quantite'] : "" ?>" type="number" name="quantite" id="quantite" placeholder="Veuillez saisir la quantité">

                <!-- Champ pour le prix (commenté pour l'instant) -->
                <!--<label for="prix">Prix</label>
                <input value="<?= !empty($_GET['id']) ? $article['prix'] : "" ?>" type="number" name="prix" id="prix" placeholder="Prix total" readonly>-->

                <button type="submit">Valider</button>

                <!-- Affichage des messages d'alerte -->
                <?php
                if (!empty($_SESSION['message']['text'])) {
                    ?>
                    <div class="alert <?= $_SESSION['message']['type'] ?>">
                        <?= $_SESSION['message']['text'] ?>
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
                $affictation = getCommande(); // Récupère la liste des commandes
                if (!empty($affictation) && is_array($affictation)) {
                    foreach ($affictation as $value) {
                        ?>
                        <tr>
                            <td><?= $value['nom_article'] ?></td>
                            <td><?= $value['nom'] . " " . $value['prenom'] ?></td>
                            <td><?= $value['quantite'] ?></td>
                            <td><?= date('d/m/Y H:i:s', strtotime($value['date_commande'])) ?></td>
                            <td>
                                <a href="recuCommande.php?id=<?= $value['id'] ?>"><i class='bx bx-receipt'></i></a>
                                <a onclick="annuleCommande(<?= $value['id'] ?>, <?= $value['idArticle'] ?>, <?= $value['quantite'] ?>)" style="color: red;"><i class='bx bx-stop-circle'></i></a>
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
include 'pied.php'; // Inclut le pied de page
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

        var prixUnitaire = article.options[article.selectedIndex].getAttribute('data-prix');

        var totalPrix = Number(quantite.value) * Number(prixUnitaire);
        if (!isNaN(totalPrix)) {
            prix.value = totalPrix.toFixed(2); // Affiche le prix avec deux décimales
        }
    }
</script>
