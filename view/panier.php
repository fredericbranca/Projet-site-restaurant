<?php

ob_start();

if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    unset($_SESSION['message']);
} else {
    $message = "";
}

$panier = $requetePanier->fetch();

if (empty($panier)) {
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
    <div>PANIER</div>
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
