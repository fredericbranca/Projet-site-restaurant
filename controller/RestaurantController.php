<?php

namespace Controller;

use Model\Connect; // "use" pour accéder à la classe Connect située dans le namespace "Model"


class RestaurantController
{
    /* Afficher les horaires' */
    public function afficherHoraire()
    {
        $pdo = Connect::seConnecter();

        $requeteHoraires = $pdo -> query("
            SELECT *
            FROM horaires
        ");

        require "view/accueil.php";
    }

    /* Afficher la carte et menus' */
    public function afficherCarte()
    {
        $pdo = Connect::seConnecter();

        $requeteDejeuner = $pdo -> query("
            SELECT *, FORMAT(prix, 2) AS prix_format
            FROM carte
            WHERE section = 'dejeuner'
        ");
        $requeteSoir = $pdo -> query("
            SELECT *, FORMAT(prix, 2) AS prix_format
            FROM carte
            WHERE section = 'soir'
        ");
        $requeteEntree = $pdo -> query("
            SELECT *, FORMAT(prix, 2) AS prix_format
            FROM carte
            WHERE section = 'entree'
        ");
        $requetePlat = $pdo -> query("
            SELECT *, FORMAT(prix, 2) AS prix_format
            FROM carte
            WHERE section = 'plat'
        ");
        $requeteDessert = $pdo -> query("
            SELECT *, FORMAT(prix, 2) AS prix_format
            FROM carte
            WHERE section = 'dessert'
        ");
        $requeteBoisson = $pdo -> query("
            SELECT *, FORMAT(prix, 2) AS prix_format
            FROM carte
            WHERE section = 'boisson'
        ");

        require "view/carte.php";
    }

}