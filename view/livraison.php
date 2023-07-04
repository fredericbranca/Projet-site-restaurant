<?php

ob_start();

$entree = $requeteEntree->fetchAll();
$plat = $requetePlat->fetchAll();
$dessert = $requeteDessert->fetchAll();
$boisson = $requeteBoisson->fetchAll();

?>

<div class="header">
    <p>LIVRAISON À DOMICILE</p>
</div>

<div class="section-carte">
    <div class="titre">CARTE</div>
    <form class="carte-content" action="index.php?action=livraison" method="POST" enctype="multipart/form-data">
        <div class="carte-section-2" id="entree">
            <div class="titre-2">Nos Entrées</div>
            <div class="content">
                <?php
                foreach ($entree as $description) {
                ?>
                    <div class="produit">
                        <p><?= $description['description'] ?></p>
                        <p><?= $description['prix_format'] ?>€</p>
                        <input type="hidden" id="produit" name="<?= $description['id_produit'] ?>">
                        <input class="input-qqt" type="number" id="qqt" name="qqt[]" min="0" step="1" required autocomplete="off" value="0">
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
                        <input type="hidden" id="produit" name="<?= $description['id_produit'] ?>">
                        <input class="input-qqt" type="number" id="qqt" name="qqt[]" min="0" step="1" required autocomplete="off" value="0">
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
                        <input type="hidden" id="produit" name="<?= $description['id_produit'] ?>">
                        <input class="input-qqt" type="number" id="qqt" name="qqt[]" min="0" step="1" required autocomplete="off" value="0">
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
                        <input type="hidden" id="produit" name="<?= $description['id_produit'] ?>">
                        <input class="input-qqt" type="number" id="qqt" name="qqt[]" min="0" step="1" required autocomplete="off" value="0">
                    </div>
                <?php
                }
                ?>
            </div>
        </div>
        <div class="wrap">
            <a class="bouton input-btn" href="index.php?action=panier">VOIR LE PANIER</a>
            <input class="bouton input-btn" type="submit" name="submit" value="AJOUTER AU PANIER">
        </div>
    </form>

</div>

<?php

$titre = "Livraison à domicile";
$titre_secondaire = "Livraison";
$style = "livraison";
$contenu = ob_get_clean();
require "view/template.php";
