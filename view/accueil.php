<?php

ob_start();
$horaires = $requeteHoraires->fetchAll();

?>

<div class="header">
    <img class="logo" src="public/img/logo.png" alt="Logo Restaurant Le Vieux Terroir">
    <p>RESTAURANT TRADITIONNEL</p>
    <p>Le Vieux Terroir - Restaurant</p>
    <a class="bouton" href="index.php?action=reservation"><span>RÉSERVER</span></a>
</div>

<div class="section-carte">
    <img src="public/img/plat.jpg" alt="Plat Restaurant Le vieux Terroir">
    <div class="titre">
        <p>Le Vieux Terroir - Restaurant</p>
        <a class="bouton" href="index.php?action=carte&menus"><span>DÉCOUVRIR NOTRE CARTE</span></a>
    </div>
</div>

<div class="section-commande">
    <div class="overlay"></div>
    <p>Livraison à domicile</p>
    <p>Faites-vous livrer vos repas directement chez vous !</p>
    <a class="bouton" href="index.php?action=carte&menus"><span>COMMANDER</span></a>
</div>

<div class="section-infos">
    <div class="infos-pratiques">
        <div class="titre">INFOS PRATIQUES</div>
        <span></span>
        <div class="infos">
            <p>CUISINE</p>
            <p>Cuisine Française</p>
        </div>
        <div class="infos">
            <p>TYPE DE RESTAURANT</p>
            <p>Restaurant Traditionnel</p>
        </div>
        <div class="infos">
            <p>SERVICES</p>
            <p>Accès wifi gratuit, Terrasse, Réservation midi et soir, Livraison à domicile</p>
        </div>
        <div class="infos">
            <p>MOYENS DE PAIEMENT</p>
            <p>Carte bleue, Espèces, Virement bancaire, Paiement sans contact, Ticket restaurant, Apple Pay</p>
        </div>
    </div>
    <div class="horaires">
        <div class="titre">HORAIRES</div>
        <span></span>
        <div class="content">
            <?php
            foreach ($horaires as $horaire) {
            ?>
                <div class="details-horaires">
                    <div class="jour">
                        <p><?= $horaire['jour'] ?></p>
                    </div>
                    <div class="heures">
                        <p><?= $horaire['heures'] ?></p>
                    </div>
                </div>
            <?php
            }
            ?>
        </div>
    </div>
</div>

<?php

$titre = "Accueil";
$titre_secondaire = "Accueil";
$style = "accueil";
$contenu = ob_get_clean();
require "view/template.php";
