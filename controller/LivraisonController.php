<?php

namespace Controller;

use Model\Connect; // "use" pour accéder à la classe Connect située dans le namespace "Model"


class LivraisonController
{
    // Vue livraison.php
    public function livraison()
    {
        $pdo = Connect::seConnecter();

        // Afficher la carte

        $pdo = Connect::seConnecter();

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

        // Ajouter les produits au panier
        

        require "view/livraison.php";
    }

}