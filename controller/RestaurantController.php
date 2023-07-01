<?php

namespace Controller;

use Model\Connect; // "use" pour accéder à la classe Connect située dans le namespace "Model"


class RestaurantController
{
    /* Afficher la carte et menus */
    public function afficherHoraire()
    {
        $pdo = Connect::seConnecter();

        $requeteHoraires = $pdo -> query("
            SELECT *
            FROM horaires
        ");

        require "view/accueil.php";
    }
}