<?php

ob_start();

$entree = $requeteEntree->fetchAll();
$plat = $requetePlat->fetchAll();
$dessert = $requeteDessert->fetchAll();
$boisson = $requeteBoisson->fetchAll();
if (isset($requeteQttProduits)) {
    $qttProduits = $requeteQttProduits->fetchAll();
}

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
                    $idProduit = $description['id_produit'];
                    $quantite = 0;
                    if (isset($qttProduits)) {
                        foreach ($qttProduits as $qttProduit) {
                            if ($qttProduit['id_produit'] === $idProduit) {
                                $quantite = $qttProduit['quantite'];
                            }
                        }
                    }
                ?>
                    <div class="produit">
                        <p><?= $description['description'] ?></p>
                        <p><?= $description['prix_format'] ?>€</p>
                        <input type="hidden" id="produit" name="produit[]" value="<?= $description['id_produit'] ?>">
                        <input class="input-qtt" type="number" id="qtt" name="qtt[]" min="0" step="1" required autocomplete="off" value="<?= $quantite ?>">
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
                    $idProduit = $description['id_produit'];
                    $quantite = 0;
                    if (isset($qttProduits)) {
                        foreach ($qttProduits as $qttProduit) {
                            if ($qttProduit['id_produit'] === $idProduit) {
                                $quantite = $qttProduit['quantite'];
                            }
                        }
                    }
                ?>
                    <div class="produit">
                        <p><?= $description['description'] ?></p>
                        <p><?= $description['prix_format'] ?>€</p>
                        <input type="hidden" id="produit" name="produit[]" value="<?= $description['id_produit'] ?>">
                        <input class="input-qtt" type="number" id="qtt" name="qtt[]" min="0" step="1" required autocomplete="off" value="<?= $quantite ?>">
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
                    $idProduit = $description['id_produit'];
                    $quantite = 0;
                    if (isset($qttProduits)) {
                        foreach ($qttProduits as $qttProduit) {
                            if ($qttProduit['id_produit'] === $idProduit) {
                                $quantite = $qttProduit['quantite'];
                            }
                        }
                    }
                ?>
                    <div class="produit">
                        <p><?= $description['description'] ?></p>
                        <p><?= $description['prix_format'] ?>€</p>
                        <input type="hidden" id="produit" name="produit[]" value="<?= $description['id_produit'] ?>">
                        <input class="input-qtt" type="number" id="qtt" name="qtt[]" min="0" step="1" required autocomplete="off" value="<?= $quantite ?>">
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
                    $idProduit = $description['id_produit'];
                    $quantite = 0;
                    if (isset($qttProduits)) {
                        foreach ($qttProduits as $qttProduit) {
                            if ($qttProduit['id_produit'] === $idProduit) {
                                $quantite = $qttProduit['quantite'];
                            }
                        }
                    }
                ?>
                    <div class="produit">
                        <p><?= $description['description'] ?></p>
                        <p><?= $description['prix_format'] ?>€</p>
                        <input type="hidden" id="produit" name="produit[]" value="<?= $description['id_produit'] ?>">
                        <input class="input-qtt" type="number" id="qtt" name="qtt[]" min="0" step="1" required autocomplete="off" value="<?= $quantite ?>">
                    </div>
                <?php
                }
                ?>
            </div>
        </div>
        <div class="wrap">
            <input class="bouton input-btn" type="submit" name="submit" value="AJOUTER AU PANIER">
            <a class="bouton input-btn" id="panier" href="index.php?action=panier">VOIR LE PANIER</a>
        </div>
    </form>

</div>

<?php

$titre = "Livraison à domicile";
$titre_secondaire = "Livraison";
$style = "livraison";
$contenu = ob_get_clean();
require "view/template.php";
