<?php

ob_start();

if (isset($_SESSION['accesInfosReservation']) && $_SESSION['accesInfosReservation']) {

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
                <a href="index.php?action=reservation">Réserver une table</a>
                <div>></div>
                <div>Informations pour la réservation</div>
            </div>
        </div>

        <div class="input-infos-date">
            <?= $_SESSION['couvert'] ?> personnes le <?= date("d/m/Y", strtotime($_SESSION['date'])) . " " . $_SESSION['creneau'] ?>
            <a href="index.php?action=reservation"><i class="fa-regular fa-calendar"></i></a>
        </div>

        <form class="column" action="index.php?action=infosReservation" method="POST" enctype="multipart/form-data">

            <?php
            if ($message) {
                echo $message;
            }
            ?>

            <div class="input-1 column">

                <div class="civilite-section">
                    <div>Civilité</div>
                    <div class="civilite">
                        <div>
                            <input id="monsieur" type="radio" name="sexe" value="monsieur" checked>
                            <label for="monsieur">Monsieur</label>
                        </div>
                        <div>
                            <input id="madame" type="radio" name="sexe" value="madame">
                            <label for="madame">Madame</label>
                        </div>
                    </div>
                </div>

                <div class="champs">
                    <input class="input-infos" type="text" id="prenom" name="prenom" required maxlength="50" size="20" placeholder="Prénom" autocomplete="off">
                    <input class="input-infos" type="text" id="nom" name="nom" required maxlength="50" size="20" placeholder="Nom" autocomplete="off">
                </div>
                <div class="champs">
                    <input class="input-infos" type="text" id="numero" name="numero" required maxlength="10" size="20" placeholder="Numéro de téléphone" autocomplete="off">
                    <input class="input-infos" type="text" id="email" name="email" required maxlength="80" size="20" placeholder="Email" autocomplete="off">
                </div>

            </div>

            <div class="column">
                <input class="bouton bouton-modif input-btn" type="submit" name="reservation" value="RÉSERVER">
            </div>

        </form>

    </section>

<?php

} else {
        ?>
        <section class="no-acces">
            <div>Cette page n'est pas accessible.</div>
        </section>
        <?php
        }

$titre = "Réservation";
$titre_secondaire = "Réservation";
$style = "reservation";
$contenu = ob_get_clean();
require "view/template.php";
