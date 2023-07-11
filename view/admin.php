<?php

ob_start();

if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    unset($_SESSION['message']);
} else {
    $message = "";
}

// Affiche la page pour modifier les horaires
if (isset($_GET['page']) && $_GET['page'] === 'horaire') {
    echo $message;
    $horaires = $requeteHoraires->fetchAll();
?>
    <div class="header">
        <p>ADMINISTRATION</p>
    </div>

    <div class="pagination wrap">
        <a class="bouton btn-register" href="index.php?action=admin"><span>MODIFIER LA CARTE</span></a>
        <a class="bouton btn-register" href="index.php?action=admin&page=table"><span>MODIFIER LE NOMBRE DE TABLE</span></a>
    </div>

    <div class="horaires">
        <div class="titre">HORAIRES</div>
        <div class="content-horaire">
            <?php
            foreach ($horaires as $horaire) {
            ?>
                <form class="horaire" method="POST" action="index.php?action=admin&id=<?= $horaire['id_horaire'] ?>" enctype="multipart/form-data">
                    <input class="input-horaire" type="text" id="jour" name="jour" maxlength="50" required autocomplete="off" value="<?= $horaire['jour'] ?>">
                    <input class="input-horaire" type="text" id="heure" name="heure" maxlength="50" required autocomplete="off" value="<?= $horaire['heures'] ?>">

                    <button class="bouton btn-supprimer" type="submit" name="modifierHoraire" id="submit">MODIFIER</button>
                    <button class="bouton btn-supprimer" type="submit" name="supprimerHoraire" id="submit">SUPPRIMER</button>
                </form>
            <?php
            }
            ?>
            <form class="horaire" method="POST" action="index.php?action=admin&section=dejeuner" enctype="multipart/form-data">
                <input class="input-horaire" type="text" id="jour" name="jour" maxlength="50" required autocomplete="off" placeholder="Jour(s)">
                <input class=" input-horaire" type="text" id="heure" name="heure" maxlength="50" required autocomplete="off" placeholder="Horaires">

                <button class="bouton btn-ajouter" type="submit" name="ajouterHoraire" id="submit">AJOUTER</button>
            </form>
        </div>
    </div>

<?php
    // affiche la page pour modifier le nombre de table
} elseif (isset($_GET['page']) && $_GET['page'] === 'table') {
    $nbTable = $requeteTable->fetch();
?>

    <div class="header">
        <p>ADMINISTRATION</p>
    </div>

    <div class="pagination wrap">
        <a class="bouton btn-register" href="index.php?action=admin"><span>MODIFIER LA CARTE</span></a>
        <a class="bouton btn-register" href="index.php?action=admin&page=horaire"><span>MODIFIER LES HORAIRES</span></a>
    </div>
    
    <div class="modifier-table">

        <form class="table-form" method="POST" action="index.php?action=admin" enctype="multipart/form-data">
            <div class="text">MODIFIER LE NOMBRE DE TABLE</div>
            <div class="table">
                <input class="input-table" type="number" id="table" name="table" min="1" step="1" required autocomplete="off" value="<?= $nbTable['nb_table'] ?>">
                <button class="bouton btn-supprimer" type="submit" name="modifierTable" id="submit">MODIFIER</button>
                <?= $message ?>
            </div>
        </form>
    </div>

<?php
    // affiche la page pour modifier la carte
} elseif (!isset($_GET['page']) && isset($_GET['action']) && $_GET['action'] === 'admin') {
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

    <div class="pagination wrap">
        <a class="bouton btn-register" href="index.php?action=admin&page=horaire"><span>MODIFIER LES HORAIRES</span></a>
        <a class="bouton btn-register" href="index.php?action=admin&page=table"><span>MODIFIER LE NOMBRE DE TABLE</span></a>
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
                            <input class=" input-prix" type="number" id="prix" name="prix" min="0.01" step="0.01" required autocomplete="off" placeholder="Prix">
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
                            <input class=" input-prix" type="number" id="prix" name="prix" min="0.01" step="0.01" required autocomplete="off" placeholder="Prix">
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
                            <input class=" input-prix" type="number" id="prix" name="prix" min="0.01" step="0.01" required autocomplete="off" placeholder="Prix">
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
                            <input class=" input-prix" type="number" id="prix" name="prix" min="0.01" step="0.01" required autocomplete="off" placeholder="Prix">
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
                            <input class=" input-prix" type="number" id="prix" name="prix" min="0.01" step="0.01" required autocomplete="off" placeholder="Prix">
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
                            <input class=" input-prix" type="number" id="prix" name="prix" min="0.01" step="0.01" required autocomplete="off" placeholder="Prix">
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

} else {
    header("Location: index.php?action=admin");
    exit;
}

$titre = "Admin";
$titre_secondaire = "Admin";
$style = "admin";
$contenu = ob_get_clean();
require "view/template.php";
