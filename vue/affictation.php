<?php
include 'entete.php';

// Vérifiez si un ID est passé dans la requête GET
if (!empty($_GET['id'])) {
    $article = getEmployer($_GET['id']);
} else {
    $article = [];
}

// Récupérer les données des articles et des employeurs
$articles = getArticle();
$employers = getEmployer(); // Assurez-vous que cette fonction renvoie les données nécessaires
?>

<div class="home-content">
    <div class="overview-boxes">
        <div class="box">
            <form action="<?= !empty($_GET['id']) ? "../model/modifVente.php" : "../model/ajoutVente.php" ?>" method="post">
                <input value="<?= !empty($_GET['id']) ? htmlspecialchars($article['id'] ?? '', ENT_QUOTES, 'UTF-8') : "" ?>" type="hidden" name="id" id="id">

                <label for="id_article">Article</label>
                <select onchange="setPrix()" name="id_article" id="id_article">
                    <?php
                    if (!empty($articles) && is_array($articles)) {
                        foreach ($articles as $value) {
                            ?>
                            <option data-prix="<?= htmlspecialchars($value['prix'] ?? '0', ENT_QUOTES, 'UTF-8') ?>" value="<?= htmlspecialchars($value['id'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
                                <?= htmlspecialchars($value['nom_article'] ?? 'Non spécifié', ENT_QUOTES, 'UTF-8') . " - " . htmlspecialchars($value['quantite'] ?? 'Quantité non spécifiée', ENT_QUOTES, 'UTF-8') . " disponible" ?>
                            </option>
                            <?php
                        }
                    } else {
                        echo '<option value="">Aucun article disponible</option>';
                    }
                    ?>
                </select>

                <label for="id_employer">Employer</label>
                <select name="id_employer" id="id_employer">
                    <?php
                    if (!empty($employers) && is_array($employers)) {
                        foreach ($employers as $value) {
                            ?>
                            <option value="<?= htmlspecialchars($value['id'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
                                <?= htmlspecialchars($value['nom'] ?? 'Non spécifié', ENT_QUOTES, 'UTF-8') . " " . htmlspecialchars($value['prenom'] ?? 'Non spécifié', ENT_QUOTES, 'UTF-8') ?>
                            </option>
                            <?php
                        }
                    } else {
                        echo '<option value="">Aucun employé disponible</option>';
                    }
                    ?>
                </select>

                <label for="quantite">Quantité</label>
                <input onkeyup="setPrix()" value="<?= !empty($_GET['id']) ? htmlspecialchars($article['quantite'] ?? '', ENT_QUOTES, 'UTF-8') : "" ?>" type="number" name="quantite" id="quantite" placeholder="Veuillez saisir la quantité">

                <!--<label for="prix">Prix</label>
                <input value="<?= !empty($_GET['id']) ? htmlspecialchars($article['prix'] ?? '', ENT_QUOTES, 'UTF-8') : "" ?>" type="number" name="prix" id="prix" placeholder="Veuillez saisir le prix">-->

                <button type="submit">Valider</button>

                <?php
                if (!empty($_SESSION['message']['text'])) {
                    ?>
                    <div class="alert <?= htmlspecialchars($_SESSION['message']['type'], ENT_QUOTES, 'UTF-8') ?>">
                        <?= htmlspecialchars($_SESSION['message']['text'], ENT_QUOTES, 'UTF-8') ?>
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
                    <th>Employer</th>
                    <th>Quantité</th>
                    <!-- <th>Prix</th> -->
                    <th>Date</th>
                    <th>Action</th>
                </tr>
                <?php
                $affictations = getAffictation(); // Assurez-vous que cette fonction existe et renvoie les données correctes
                if (!empty($affictations) && is_array($affictations)) {
                    foreach ($affictations as $value) {
                        ?>
                        <tr>
                            <td><?= htmlspecialchars($value['nom_article'] ?? 'Non spécifié', ENT_QUOTES, 'UTF-8') ?></td>
                            <td><?= isset($value['nom']) && isset($value['prenom']) ? htmlspecialchars($value['nom'], ENT_QUOTES, 'UTF-8') . " " . htmlspecialchars($value['prenom'], ENT_QUOTES, 'UTF-8') : 'Non spécifié' ?></td>
                            <td><?= isset($value['quantite']) ? htmlspecialchars($value['quantite'], ENT_QUOTES, 'UTF-8') : 'Quantité non spécifiée' ?></td>
                            <td><?= isset($value['date_affictation']) ? date('d/m/Y H:i:s', strtotime(htmlspecialchars($value['date_affictation'] ?? '', ENT_QUOTES, 'UTF-8'))) : 'Date non spécifiée' ?></td>
                            <td>
                                <a href="recuVente.php?id=<?= htmlspecialchars($value['id'] ?? '', ENT_QUOTES, 'UTF-8') ?>"><i class='bx bx-receipt'></i></a>
                                <a onclick="annuleVente(<?= htmlspecialchars($value['id'] ?? '', ENT_QUOTES, 'UTF-8') ?>, <?= htmlspecialchars($value['idArticle'] ?? '', ENT_QUOTES, 'UTF-8') ?>, <?= htmlspecialchars($value['quantite'] ?? '', ENT_QUOTES, 'UTF-8') ?>)" style="color: red;"><i class='bx bx-stop-circle'></i></a>
                            </td>
                        </tr>
                        <?php
                    }
                } else {
                    echo '<tr><td colspan="5">Aucune affectation disponible</td></tr>';
                }
                ?>
            </table>
        </div>
    </div>
</div>
</section>

<?php
include 'pied.php';
?>

<script>
    function annuleVente(idAffictation, idArticle, quantite) {
        if (confirm("Voulez-vous vraiment annuler cette affictation ?")) {
            window.location.href = "../model/annuleVente.php?idAffictation=" + idAffictation + "&idArticle=" + idArticle + "&quantite=" + quantite;
        }
    }

    function setPrix() {
        var article = document.querySelector('#id_article');
        var quantite = document.querySelector('#quantite');
        // var prix = document.querySelector('#prix');

        // var prixUnitaire = article.options[article.selectedIndex].getAttribute('data-prix');

        // prix.value = Number(quantite.value) * Number(prixUnitaire);
    }
</script>
