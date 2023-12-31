<?php

ob_start();

if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    unset($_SESSION['message']);
} else {
    $message = "";
}

$panier = $requetePanier->fetch();

if (!$panier) {
    ?>
    <div class="column header-link">
        <div class="titre">PANIER</div>
        <div class="link wrap">
            <a href="index.php?action=accueil">Accueil</a>
            <div>></div>
            <div>Votre panier</div>
        </div>
    </div>

    <div class="panier-vide">
        <div>Votre panier est vide. <a href="index.php?action=livraison">Retour à la commande</a></div>
    </div>

    <?php
} else {
    $produits = $requeteProduits->fetchAll();
    if (isset($requeteAdresseDefaut)) {
        $adresseDefaut = $requeteAdresseDefaut->fetch();
    }
    if (isset($requeteAdresse)) {
        $adressesAutre = $requeteAdresse->fetchAll();
    }
    ?>

    <div class="column header-link">
        <div class="titre">PANIER</div>
        <div class="link wrap">
            <a href="index.php?action=livraison">Livraison : Carte</a>
            <div>></div>
            <div>Votre panier</div>
        </div>
    </div>

    <div class="content">

        <table class="panier-table">
            <thead>
                <tr>
                    <th>Plat</th>
                    <th>Prix</th>
                    <th>Quantité</th>
                    <th>Total</th>
                </tr>
                <!-- <div class="ligne"></div> -->
            </thead>
            <tbody>
                <?php
                $total = 0;
                foreach ($produits as $produit) {
                    $total += $produit['quantite'] * $produit['prix'];
                    ?>

                    <tr>
                        <td>
                            <?= $produit['description'] ?>
                        </td>
                        <td class="prix">
                            <?= $produit['prix'] ?> €
                        </td>
                        <td>
                            <form class="qtt" method="POST" action="index.php?action=panier&id=<?= $produit['id_produit'] ?>"
                                enctype="multipart/form-data">
                                <button class="btn" type="submit" name="moins" id="submit">-</button>
                                <?= $produit['quantite'] ?>
                                <button class="btn" type="submit" name="plus" id="submit">+</button>
                            </form>
                        </td>
                        <td class="prixTotal">
                            <?= $produit['quantite'] * $produit['prix'] ?>€
                        </td>
                    </tr>
                    <!-- <div class="ligne"></div> -->

                    <?php
                }
                ?>
            </tbody>
        </table>

        <form method="POST" action="index.php?action=panier" enctype="multipart/form-data">
            <div class="fin">
                <div class="adresse">
                    <div>Adresse de livraison</div>
                    <?php
                    if ($adresseDefaut) {
                        ?>
                        <select name="adresse" id="adresse">
                            <option value="<?= $adresseDefaut['id_adresse'] ?>"><?= $adresseDefaut['adresse'] ?></option>
                            <?php
                            if (isset($adressesAutre)) {
                                foreach ($adressesAutre as $adresse) {
                                    ?>
                                    <option value="<?= $adresse['id_adresse'] ?>"><?= $adresse['adresse'] ?></option>
                                    <?php
                                }
                            }
                            ?>
                        </select>

                        <?php
                    } elseif (!$adresseDefaut && $adressesAutre) {
                        ?>
                        <select name="adresse" id="adresse">
                            <option value="">Choisir une adresse</option>
                            <?php
                            foreach ($adressesAutre as $adresse) {
                                ?>
                                <option value="<?= $adresse['id_adresse'] ?>"><?= $adresse['adresse'] ?></option>
                                <?php
                            }
                            ?>
                        </select>
                        <?php
                    } else {
                        ?>
                        <select name="adresse" id="adresse">
                            <option value="">Aucune adresse enregistrée</option>
                        </select>
                        <?php
                    }
                    ?>

                    <a class="bouton btn-register" href="index.php?action=profil&page=ajouterAdresse"><span>NOUVELLE
                            ADRESSE</span></a>
                </div>
                <div class="payer">
                    <div class="livraison">
                        <div>Livraison</div>
                        <div>3 €</div>
                    </div>
                    <div class="total">
                        <div>Total</div>
                        <div>
                            <?= $total + 3 ?> €
                        </div>
                    </div>
                    <input class="bouton input-btn" type="submit" name="submit" value="PAYER">
                </div>
            </div>
        </form>
    </div>

    <?php
}
?>




<?php

$titre = "Panier";
$titre_secondaire = "Panier";
$style = "panier";
$contenu = ob_get_clean();
require "view/template.php";