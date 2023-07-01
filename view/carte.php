<?php

ob_start();

$dejeuner = $requeteDejeuner->fetchAll();
$soir = $requeteSoir->fetchAll();
$entree = $requeteEntree->fetchAll();
$plat = $requetePlat->fetchAll();
$dessert = $requeteDessert->fetchAll();
$boisson = $requeteBoisson->fetchAll();

?>

<div class="header">
    <p>CARTE & MENUS</p>
</div>

<div class="section-carte">
    <div class="titre">CARTE & MENUS</div>
    <span></span>
    <div class="carte-content">
        <div class="carte-section-1" id="dejeuner">
            <div class="sous-titre">MENU DEJEUNER</div>
            <div class="content">
                <?php
                foreach ($dejeuner as $description) {
                ?>
                    <div class="produit">
                        <p><?= $description['description'] ?></p>
                        <p><?= $description['prix_format'] ?>€</p>
                    </div>
                <?php
                }
                ?>
            </div>
        </div>
        <div class="carte-section-1" id="soir">
            <div class="sous-titre">MENU SOIR ET WEEK-END</div>
            <div class="content">
                <?php
                foreach ($soir as $description) {
                ?>
                    <div class="produit">
                        <p><?= $description['description'] ?></p>
                        <p><?= $description['prix_format'] ?>€</p>
                    </div>
                <?php
                }
                ?>
            </div>
        </div>
        <div class="carte-section-2" id="entree">
            <div class="titre-2">Nos Entrées</div>
            <div class="content">
                <?php
                foreach ($entree as $description) {
                ?>
                    <div class="produit">
                        <p><?= $description['description'] ?></p>
                        <p><?= $description['prix_format'] ?>€</p>
                    </div>
                <?php
                }
                ?>
            </div>
        </div>
        <div class="carte-section-2" id="plat">
            <div class="titre-2">Nos Plats</div>
            <div class="content">
                <?php
                foreach ($plat as $description) {
                ?>
                    <div class="produit">
                        <p><?= $description['description'] ?></p>
                        <p><?= $description['prix_format'] ?>€</p>
                    </div>
                <?php
                }
                ?>
            </div>
        </div>
        <div class="carte-section-2" id="dessert">
            <div class="titre-2">Nos Desserts</div>
            <div class="content">
                <?php
                foreach ($dessert as $description) {
                ?>
                    <div class="produit">
                        <p><?= $description['description'] ?></p>
                        <p><?= $description['prix_format'] ?>€</p>
                    </div>
                <?php
                }
                ?>
            </div>
        </div>
        <div class="carte-section-2" id="boisson">
            <div class="titre-2">Boissons</div>
            <div class="content">
                <?php
                foreach ($boisson as $description) {
                ?>
                    <div class="produit">
                        <p><?= $description['description'] ?></p>
                        <p><?= $description['prix_format'] ?>€</p>
                    </div>
                <?php
                }
                ?>
            </div>
        </div>
    </div>

</div>

<?php

$titre = "Carte & Menus";
$titre_secondaire = "Carte & Menus";
$style = "carte";
$contenu = ob_get_clean();
require "view/template.php";
