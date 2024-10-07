<?php
include 'entete.php';
?>
<div class="home-content">
   

    <div class="sales-boxes">
        <div class="recent-sales box">
            <div class="title">Article utiliser recentes</div>
            <?php
            $affictation = getLastAffictation();
            ?>
            <div class="sales-details">
                <ul class="details">
                    <li class="topic">Date</li>
                    <?php
                    foreach ($affictation as $key => $value) {
                    ?>
                        <li><a href="#"><?php echo date('d M Y', strtotime($value['date_affictation'])) ?></a></li>
                    <?php
                    }
                    ?>
                </ul>
                <ul class="details">
                    <li class="topic">Employer</li>
                    <?php
                    foreach ($affictation as $key => $value) {
                    ?>
                        <li><a href="#"><?php echo $value['nom'] . " " . $value['prenom'] ?></a></li>
                    <?php
                    }
                    ?>
                </ul>
                <ul class="details">
                    <li class="topic">Article</li>
                    <?php
                    foreach ($affictation as $key => $value) {
                    ?>
                        <li><a href="#"><?php echo $value['nom_article'] ?></a></li>
                    <?php
                    }
                    ?>
                </ul>
               
                    <?php
                    foreach ($affictation as $key => $value) {
                    ?>
                       <!-- <li><a href="#"><?php echo number_format($value['prix'], 0, ",", " ") . " MAD " ?></a></li>-->
                    <?php
                    }
                    ?>
                </ul>
            </div>
            <div class="button">
                <a href="affictation.php">Voir Tout</a>
            </div>
        </div>
        <div class="top-sales box">
            <div class="title">Article le plus utilise</div>
            <ul class="top-sales-details">
                <?php
                $article = getMostAffictation();
                foreach ($article as $key => $value) {
                ?>
                    <li>
                        <a href="#">
                          
                            <span class="product"><?php echo $value['nom_article'] ?></span>
                        </a>
                        <!--<span class="price"><?php echo number_format($value['prix'], 0, ",", " ") . " MAD" ?></span>-->
                    </li>
                <?php
                }
                ?>
                
            </ul>
        </div>
    </div>
</div>
</section>

<?php
include 'pied.php';
?>