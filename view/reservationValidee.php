<?php

ob_start();

if (isset($_SESSION['accesReservationValidee']) && $_SESSION['accesReservationValidee']) {

    unset($_SESSION['accesInfosReservation']);
    unset($_SESSION['accesReservationValidee']);

    if (isset($_SESSION['message'])) {
        $message = $_SESSION['message'];
        unset($_SESSION['message']);
    } else {
        $message = "";
    }

?>

    <section class="reservation column">

        <div class="column header-link">
            <div class="titre">RÉSERVATION</div>
            <div class="link wrap">
                <a href="index.php?action=accueil">Accueil</a>
                <div>></div>
                <div>Réservation validée</div>
            </div>
        </div>

        <?= $message ?>

        <a class="bouton" href="index.php?action=accueil"><span>RETOURNER À L'ACCUEIL</span></a>

    </section>

<?php

} else {
?>
    <section class="no-acces">
        <div>Cette page n'est pas accessible.</div>
    </section>
<?php
}

$titre = "Réservation validée";
$titre_secondaire = "Réservation validée";
$style = "reservation";
$contenu = ob_get_clean();
require "view/template.php";
