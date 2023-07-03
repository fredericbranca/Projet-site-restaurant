<?php

ob_start();

if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    unset($_SESSION['message']);
} else {
    $message = "";
}
echo $message;

$dejeuner = $requeteDejeuner->fetchAll();
$soir = $requeteSoir->fetchAll();
$entree = $requeteEntree->fetchAll();
$plat = $requetePlat->fetchAll();
$dessert = $requeteDessert->fetchAll();
$boisson = $requeteBoisson->fetchAll();

?>

<div class="header">
    <p>ADMINISTRATION</p>
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
                    <form class="produit" method="POST" action="index.php?action=admin&id=<?= $description['id_produit'] ?>" enctype="multipart/form-data">
                        <input class="input-produit" type="text" id="produit" name="produit" maxlength="255" required autocomplete="off" value="<?= $description['description'] ?>">
                        <div class="wrap">
                            <input class="input-prix" type="number" id="prix" name="prix" min="0.01" step="0.01" required autocomplete="off" value="<?= $description['prix_format'] ?>">
                            <p>€</p>
                        </div>
                        <button class="bouton btn-supprimer" type="submit" name="modifier" id="submit">MODIFIER</button>
                        <button class="bouton btn-supprimer" type="submit" name="supprimer" id="submit">SUPPRIMER</button>
                    </form>
                <?php
                }
                ?>
                <form class="produit" method="POST" action="index.php?action=admin&section=dejeuner" enctype="multipart/form-data">
                    <input class="input-produit" type="text" id="produit" name="produit" maxlength="255" required autocomplete="off" placeholder="Ajouter un produit à la carte">
                    <div class="wrap">
                        <input class=" input-prix" type="number" id="prix" name="prix" min="0.01" step="0.01" required autocomplete="off"" placeholder="Prix">
                        <p>€</p>
                    </div>
                    <button class="bouton btn-ajouter" type="submit" name="ajouter" id="submit">AJOUTER</button>
                </form>
            </div>
        </div>
        <div class="carte-section-1" id="soir">
            <div class="sous-titre">MENU SOIR ET WEEK-END</div>
            <div class="content">
                <?php
                foreach ($soir as $description) {
                ?>
                    <form class="produit" method="POST" action="index.php?action=admin&id=<?= $description['id_produit'] ?>" enctype="multipart/form-data">
                        <input class="input-produit" type="text" id="produit" name="produit" maxlength="255" required autocomplete="off" value="<?= $description['description'] ?>">
                        <div class="wrap">
                            <input class="input-prix" type="number" id="prix" name="prix" min="0.01" step="0.01" required autocomplete="off" value="<?= $description['prix_format'] ?>">
                            <p>€</p>
                        </div>
                        <button class="bouton btn-supprimer" type="submit" name="modifier" id="submit">MODIFIER</button>
                        <button class="bouton btn-supprimer" type="submit" name="supprimer" id="submit">SUPPRIMER</button>
                    </form>
                <?php
                }
                ?>
                <form class="produit" method="POST" action="index.php?action=admin&section=soir" enctype="multipart/form-data">
                    <input class="input-produit" type="text" id="produit" name="produit" maxlength="255" required autocomplete="off" placeholder="Ajouter un produit à la carte">
                    <div class="wrap">
                        <input class=" input-prix" type="number" id="prix" name="prix" min="0.01" step="0.01" required autocomplete="off"" placeholder="Prix">
                        <p>€</p>
                    </div>
                    <button class="bouton btn-ajouter" type="submit" name="ajouter" id="submit">AJOUTER</button>
                </form>
            </div>
        </div>
        <div class="carte-section-2" id="entree">
            <div class="titre-2">Nos Entrées</div>
            <div class="content">
                <?php
                foreach ($entree as $description) {
                ?>
                    <form class="produit" method="POST" action="index.php?action=admin&id=<?= $description['id_produit'] ?>" enctype="multipart/form-data">
                        <input class="input-produit" type="text" id="produit" name="produit" maxlength="255" required autocomplete="off" value="<?= $description['description'] ?>">
                        <div class="wrap">
                            <input class="input-prix" type="number" id="prix" name="prix" min="0.01" step="0.01" required autocomplete="off" value="<?= $description['prix_format'] ?>">
                            <p>€</p>
                        </div>
                        <button class="bouton btn-supprimer" type="submit" name="modifier" id="submit">MODIFIER</button>
                        <button class="bouton btn-supprimer" type="submit" name="supprimer" id="submit">SUPPRIMER</button>
                    </form>
                <?php
                }
                ?>
                <form class="produit" method="POST" action="index.php?action=admin&section=entree" enctype="multipart/form-data">
                    <input class="input-produit" type="text" id="produit" name="produit" maxlength="255" required autocomplete="off" placeholder="Ajouter un produit à la carte">
                    <div class="wrap">
                        <input class=" input-prix" type="number" id="prix" name="prix" min="0.01" step="0.01" required autocomplete="off"" placeholder="Prix">
                        <p>€</p>
                    </div>
                    <button class="bouton btn-ajouter" type="submit" name="ajouter" id="submit">AJOUTER</button>
                </form>
            </div>
        </div>
        <div class="carte-section-2" id="plat">
            <div class="titre-2">Nos Plats</div>
            <div class="content">
                <?php
                foreach ($plat as $description) {
                ?>
                    <form class="produit" method="POST" action="index.php?action=admin&id=<?= $description['id_produit'] ?>" enctype="multipart/form-data">
                        <input class="input-produit" type="text" id="produit" name="produit" maxlength="255" required autocomplete="off" value="<?= $description['description'] ?>">
                        <div class="wrap">
                            <input class="input-prix" type="number" id="prix" name="prix" min="0.01" step="0.01" required autocomplete="off" value="<?= $description['prix_format'] ?>">
                            <p>€</p>
                        </div>
                        <button class="bouton btn-supprimer" type="submit" name="modifier" id="submit">MODIFIER</button>
                        <button class="bouton btn-supprimer" type="submit" name="supprimer" id="submit">SUPPRIMER</button>
                    </form>
                <?php
                }
                ?>
                <form class="produit" method="POST" action="index.php?action=admin&section=plat" enctype="multipart/form-data">
                    <input class="input-produit" type="text" id="produit" name="produit" maxlength="255" required autocomplete="off" placeholder="Ajouter un produit à la carte">
                    <div class="wrap">
                        <input class=" input-prix" type="number" id="prix" name="prix" min="0.01" step="0.01" required autocomplete="off"" placeholder="Prix">
                        <p>€</p>
                    </div>
                    <button class="bouton btn-ajouter" type="submit" name="ajouter" id="submit">AJOUTER</button>
                </form>
            </div>
        </div>
        <div class="carte-section-2" id="dessert">
            <div class="titre-2">Nos Desserts</div>
            <div class="content">
                <?php
                foreach ($dessert as $description) {
                ?>
                    <form class="produit" method="POST" action="index.php?action=admin&id=<?= $description['id_produit'] ?>" enctype="multipart/form-data">
                        <input class="input-produit" type="text" id="produit" name="produit" maxlength="255" required autocomplete="off" value="<?= $description['description'] ?>">
                        <div class="wrap">
                            <input class="input-prix" type="number" id="prix" name="prix" min="0.01" step="0.01" required autocomplete="off" value="<?= $description['prix_format'] ?>">
                            <p>€</p>
                        </div>
                        <button class="bouton btn-supprimer" type="submit" name="modifier" id="submit">MODIFIER</button>
                        <button class="bouton btn-supprimer" type="submit" name="supprimer" id="submit">SUPPRIMER</button>
                    </form>
                <?php
                }
                ?>
                <form class="produit" method="POST" action="index.php?action=admin&section=dessert" enctype="multipart/form-data">
                    <input class="input-produit" type="text" id="produit" name="produit" maxlength="255" required autocomplete="off" placeholder="Ajouter un produit à la carte">
                    <div class="wrap">
                        <input class=" input-prix" type="number" id="prix" name="prix" min="0.01" step="0.01" required autocomplete="off"" placeholder="Prix">
                        <p>€</p>
                    </div>
                    <button class="bouton btn-ajouter" type="submit" name="ajouter" id="submit">AJOUTER</button>
                </form>
            </div>
        </div>
        <div class="carte-section-2" id="boisson">
            <div class="titre-2">Boissons</div>
            <div class="content">
                <?php
                foreach ($boisson as $description) {
                ?>
                    <form class="produit" method="POST" action="index.php?action=admin&id=<?= $description['id_produit'] ?>" enctype="multipart/form-data">
                        <input class="input-produit" type="text" id="produit" name="produit" maxlength="255" required autocomplete="off" value="<?= $description['description'] ?>">
                        <div class="wrap">
                            <input class="input-prix" type="number" id="prix" name="prix" min="0.01" step="0.01" required autocomplete="off" value="<?= $description['prix_format'] ?>">
                            <p>€</p>
                        </div>
                        <button class="bouton btn-supprimer" type="submit" name="modifier" id="submit">MODIFIER</button>
                        <button class="bouton btn-supprimer" type="submit" name="supprimer" id="submit">SUPPRIMER</button>
                    </form>
                <?php
                }
                ?>
                <form class="produit" method="POST" action="index.php?action=admin&section=boisson" enctype="multipart/form-data">
                    <input class="input-produit" type="text" id="produit" name="produit" maxlength="255" required autocomplete="off" placeholder="Ajouter un produit à la carte">
                    <div class="wrap">
                        <input class=" input-prix" type="number" id="prix" name="prix" min="0.01" step="0.01" required autocomplete="off"" placeholder="Prix">
                        <p>€</p>
                    </div>
                    <button class="bouton btn-ajouter" type="submit" name="ajouter" id="submit">AJOUTER</button>
                </form>
            </div>
        </div>
    </div>

</div>

<!-- script -->
<script type="text/javascript" src="public/js/admin.js"></script>

<?php

$titre = "Admin";
$titre_secondaire = "Admin";
$style = "admin";
$contenu = ob_get_clean();
require "view/template.php";
