<?php

ob_start();

if (isset($_SESSION['PaiementValidee']) && $_SESSION['PaiementValidee']) {

    unset($_SESSION['PaiementValidee']);

    if (isset($_SESSION['message'])) {
        $message = $_SESSION['message'];
        unset($_SESSION['message']);
    } else {
        $message = "";
    }

?>

    <section class="reservation column">

        <div class="column header-link">
            <div class="titre">Paiement</div>
            <div class="link wrap">
                <a href="index.php?action=accueil">Accueil</a>
                <div>></div>
                <div>Paiement</div>
            </div>
        </div>

        <?= $message ?>

        <a class="bouton" href="index.php?action=profil"><span>RETOURNER AU PROFIL</span></a>

    </section>

<?php

} else {
?>
    <section class="no-acces">
        <div>Cette page n'est pas accessible.</div>
    </section>
<?php
}

$titre = "Paiement";
$titre_secondaire = "Paiement";
$style = "reservation";
$contenu = ob_get_clean();
require "view/template.php";
