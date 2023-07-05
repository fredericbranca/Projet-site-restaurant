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
        <div class="tableau">
            <div class="item">
                <div>Plat</div>
                <div class="prix">Prix</div>
                <div class="quantite">Quantité</div>
                <div class="prixTotal">Total</div>
            </div>
            <div class="ligne"></div>

            <?php
            $total = 0;
            foreach ($produits as $produit) {
                $total += $produit['quantite'] * $produit['prix'];
            ?>

                <div class="item">
                    <div><?= $produit['description'] ?></div>
                    <div class="prix"><?= $produit['prix'] ?> €</div>
                    <div>
                        <form class="qtt" method="POST" action="index.php?action=panier&id=<?=$produit['id_produit'] ?>" enctype="multipart/form-data">
                            <button class="btn" type="submit" name="moins" id="submit">-</button>
                            <?= $produit['quantite'] ?>
                            <button class="btn" type="submit" name="plus" id="submit">+</button>
                        </form>
                    </div>
                    <div class="prixTotal"><?= $produit['quantite'] * $produit['prix'] ?>€</div>
                </div>
                <div class="ligne"></div>

            <?php
            }
            ?>
        </div>
        <div class="fin">
            <div class="adresse">
                <div>Adresse de livraison</div>
                <select name="test" id="test">
                    <option value="">Please choose an option</option>
                    <option value="1">Bonjour</option>
                    <option value="2">Test</option>
                </select>
                <a class="bouton btn-register" href="index.php?action=adresse"><span>NOUVELLE ADRESSE</span></a>
            </div>
            <div class="payer">
                <div class="livraison">
                    <div>Livraison</div>
                    <div>3 €</div>
                </div>
                <div class="total">
                    <div>Total</div>
                    <div><?= $total + 3 ?> €</div>
                </div>
                <input class="bouton input-btn" type="submit" name="submit" value="PAYER">
                <img src="public/img/sous-bouton.png">
            </div>
        </div>
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
