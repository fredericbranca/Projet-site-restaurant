<?php

ob_start();

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
            <div>Réserver une table</div>
        </div>
    </div>

    <form class="column" action="index.php?action=reservation" method="POST" enctype="multipart/form-data">

        <?php
        if ($message) {
            echo $message;
        }
        ?>

        <div class="choix-1 wrap">

            <select class="input-theme" name="couvert" id="couvert-select" required>
                <option>Nombre de couvert</option>
                <option value="1">1 couvert</option>
                <option value="2">2 couverts</option>
                <option value="3">3 couverts</option>
                <option value="4">4 couverts</option>
                <option value="5">5 couverts</option>
                <option value="6">6 couverts</option>
                <option value="7">7 couverts</option>
                <option value="8">8 couverts</option>
            </select>

            <input class="input-theme" type="date" name="date" min="<?= date("Y-m-d") ?>" max="<?= date("Y") + 1 ?>-03-31" required>

        </div>

        <div class="choix-2 wrap">
            <input type="hidden" id="creneau" name="creneau">
            <input class="bouton input-btn" type="submit" name="reservation" value="MIDI">
            <input class="bouton input-btn" type="submit" name="reservation" value="SOIR">
        </div>

    </form>

</section>

<?php

$titre = "Réservation";
$titre_secondaire = "Réservation";
$style = "reservation";
$contenu = ob_get_clean();
require "view/template.php";
