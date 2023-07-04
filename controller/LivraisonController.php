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

    // Vue panier.php
    public function panier() 
    {
        $pdo = Connect::seConnecter();

        if(!isset($_SESSION['users'])) {
            header("Location: index.php?action=login");
            exit;
        }

        $id = $_SESSION['users']['id'];

        // Requete pour avoir le panier par rapport à l'id de l'user et le statut de la commande (0 : commande en cours donc panier avec produit, 1 : commande validé donc panier vide)
        $requetePanier = $pdo -> prepare("
            SELECT *
            FROM commande
            WHERE id_users = :id_user AND statut = 0
        ");
        $requetePanier->execute([
            'id_user' => $id
        ]);

        require "view/panier.php";
    }

}