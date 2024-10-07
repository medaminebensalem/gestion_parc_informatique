<?php
include 'entete.php';

if (!empty($_GET['id'])) {
    $Employer = getEmployer($_GET['id']);
}

?>
<div class="home-content">
    <div class="overview-boxes">
        <div class="box">
            <form action=" <?= !empty($_GET['id']) ?  "../model/modifClient.php" : "../model/ajoutClient.php" ?>" method="post">
                <label for="nom">Nom</label>
                <input value="<?= !empty($_GET['id']) ?  $Employer['nom'] : "" ?>" type="text" name="nom" id="nom" placeholder="Veuillez saisir le nom">
                <input value="<?= !empty($_GET['id']) ?  $Employer['id'] : "" ?>" type="hidden" name="id" id="id" >
                
                <label for="prenom">Prénom</label>
                <input value="<?= !empty($_GET['id']) ?  $Employer['prenom'] : "" ?>" type="text" name="prenom" id="prenom" placeholder="Veuillez saisir le prénom">

                <label for="telephone">N° de téléphone</label>
                <input value="<?= !empty($_GET['id']) ?  $Employer['telephone'] : "" ?>" type="text" name="telephone" id="telephone" placeholder="Veuillez saisir le N° de téléphone">
                
                <label for="adresse">Adresse</label>
                <input value="<?= !empty($_GET['id']) ?  $Employer['adresse'] : "" ?>" type="text" name="adresse" id="adresse" placeholder="Veuillez saisir l'adresse">

                <label for="adresse">service</label>
                <input value="<?= !empty($_GET['id']) ?  $Employer['id_service'] : "" ?>" type="text" name="id_service" id="id_service" placeholder="Veuillez saisir le service">

                <button type="submit">Valider</button>

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
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Téléphone</th>
                    <th>Adresse</th>
                    <th>service</th>
                    <th>Action</th>
                </tr>
                <?php
                $Employer = getEmployer();

                if (!empty($Employer) && is_array($Employer)) {
                    foreach ($Employer as $key => $value) {
                ?>
                        <tr>
                            <td><?= $value['nom'] ?></td>
                            <td><?= $value['prenom'] ?></td>
                            <td><?= $value['telephone'] ?></td>
                            <td><?= $value['adresse'] ?></td>
                            <td><?= $value['id_service'] ?></td>
                            <td><a href="?id=<?= $value['id'] ?>"><i class='bx bx-edit-alt'></i></a></td>
                        </tr>
                <?php

                    }
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