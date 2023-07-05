<?php

namespace Controller;

use Model\Connect; // "use" pour accéder à la classe Connect située dans le namespace "Model"


class LivraisonController
{
    // Vue livraison.php
    public function livraison()
    {

        if (!isset($_SESSION['users'])) {
            header("Location: index.php?action=login");
            exit;
        }

        $pdo = Connect::seConnecter();

        // id de l'utilisateur connecté
        $idUser = $_SESSION['users']['id'];

        // On vérifie qu'il n'y a pas déjà une commande qui a été créé mais pas encore validé
        $requeteStatutCommande = $pdo->prepare("
            SELECT *
            FROM commande
            WHERE id_users = :id_user AND statut = 0
        ");
        $requeteStatutCommande->execute([
            'id_user' => $idUser
        ]);
        $commande = $requeteStatutCommande->fetch();

        // Si oui, on vérifie les quantités des produits pour les mettres à jour dans la vue livraison
        if (!empty($commande)) {
            $idCommande = $commande['id_commande'];
            $requeteQttProduits = $pdo->prepare("
                SELECT id_produit, quantite
                FROM produit_commande
                WHERE id_commande = :id_commande
            ");
            $requeteQttProduits->execute([
                'id_commande' => $idCommande
            ]);
        }

        // Afficher la carte

        $requeteEntree = $pdo->query("
            SELECT *, FORMAT(prix, 2) AS prix_format
            FROM carte
            WHERE section = 'entree'
        ");
        $requetePlat = $pdo->query("
            SELECT *, FORMAT(prix, 2) AS prix_format
            FROM carte
            WHERE section = 'plat'
        ");
        $requeteDessert = $pdo->query("
            SELECT *, FORMAT(prix, 2) AS prix_format
            FROM carte
            WHERE section = 'dessert'
        ");
        $requeteBoisson = $pdo->query("
            SELECT *, FORMAT(prix, 2) AS prix_format
            FROM carte
            WHERE section = 'boisson'
        ");


        // Ajouter les produits au panier

        if (isset($_POST['submit'])) {

            // Filtre
            $idProduits = filter_input(INPUT_POST, 'produit', FILTER_VALIDATE_INT, FILTER_REQUIRE_ARRAY);
            $quantites = filter_input(INPUT_POST, 'qtt', FILTER_VALIDATE_INT, FILTER_REQUIRE_ARRAY);

            // On vérifie si les tableaux ont la même longueur
            if (count($idProduits) !== count($quantites)) {
                $_SESSION['alerte'] = "<div id='alert' class='alert-red'>La panier n'a pas pu être mise à jour : veuillez recommencer</div>";
                header("Location: index.php?action=livraison");
                exit;
            }

            if ($idProduits !== false && $quantites !== false) {

                if (empty($commande)) {
                    // Vérifie si au moins un produit a été sélectionné correctement
                    $somme = 0;
                    foreach ($quantites as $quantite) {
                        if ($quantite < 0) {
                            $_SESSION['alerte'] = "<div id='alert' class='alert-red'>La quantité d'un produit ne peut pas être négatif</div>";
                            header("Location: index.php?action=livraison");
                            exit;
                        }
                        $somme += $quantite;
                    }
                    if ($somme < 1) {
                        $_SESSION['alerte'] = "<div id='alert' class='alert-red'>Aucun produit n'a été sélectionné</div>";
                        header("Location: index.php?action=livraison");
                        exit;
                    }
                }

                // Si aucune commande en cours (même panier vidé), on en créé une
                if (empty($commande)) {
                    // Création de la commande
                    $requeteCreationCommande = $pdo->prepare("
                    INSERT INTO commande (id_users)
                    VALUES (:id_user)
                ");
                    $requeteCreationCommande->execute([
                        'id_user' => $idUser
                    ]);
                }

                // Récupère l'id de la commande
                $requeteIdCommande = $pdo->prepare("
                    SELECT id_commande
                    FROM commande
                    WHERE id_users = :id_user AND statut = 0
                ");
                $requeteIdCommande->execute([
                    'id_user' => $idUser
                ]);
                $idCommande = $requeteIdCommande->fetch();
                $idCommande = $idCommande['id_commande'];

                // Ajout des produits au panier
                // array_map permet d'appliquer une fonction à tous les éléments d'un ou plusieurs tableaux et de renvoyer un nouveau tableau avec les résultats
                $data = array_map(function ($idProduit, $quantite) use ($idCommande, $pdo) {

                    // Vérifie si le produit existe déjà dans la table
                    $requeteExistProduit = $pdo->prepare("
                        SELECT id_produit 
                        FROM produit_commande
                        WHERE id_commande = :id_commande AND id_produit = :id_produit
                        LIMIT 1
                    ");
                    $requeteExistProduit->execute([
                        'id_commande' => $idCommande,
                        'id_produit' => $idProduit
                    ]);

                    $existingProduit = $requeteExistProduit->fetch();

                    if ($existingProduit) {
                        // Le produit existe déjà, on met à jour dans la table
                        $requeteUpdatePanier = $pdo->prepare("
                            UPDATE produit_commande
                            SET quantite = :quantite
                            WHERE id_commande = :id_commande AND id_produit = :id_produit
                        ");
                        $requeteUpdatePanier->execute([
                            'id_commande' => $idCommande,
                            'id_produit' => $idProduit,
                            'quantite' => $quantite
                        ]);
                    } else {
                        // On vérifie que la quantité soit minimum 1
                        if ($quantite >= 1) {
                            // Le produit n'existe pas, on l'ajoute dans la commande
                            $requeteAddPanier = $pdo->prepare("
                                INSERT INTO produit_commande (id_commande, id_produit, quantite)
                                VALUES (:id_commande, :id_produit, :quantite)
                            ");
                            $requeteAddPanier->execute([
                                'id_commande' => $idCommande,
                                'id_produit' => $idProduit,
                                'quantite' => $quantite
                            ]);
                        } else {
                            $requeteSuprProduit = $pdo->query("
                                DELETE FROM produit_commande
                                WHERE quantite = 0
                            ");
                        }
                    }
                }, $idProduits, $quantites);

                $_SESSION['alerte'] = "<div id='alert' class='alert-green'>Le panier a été mise à jour</div>";
                header("Location: index.php?action=livraison#panier");
                exit;
            } else {
                $_SESSION['alerte'] = "<div id='alert' class='alert-red'>Champs incorrect</div>";
                header("Location: index.php?action=livraison");
                exit;
            }
        }


        require "view/livraison.php";
    }

    // Vue panier.php
    public function panier()
    {
        $pdo = Connect::seConnecter();

        if (!isset($_SESSION['users'])) {
            header("Location: index.php?action=login");
            exit;
        }

        $id = $_SESSION['users']['id'];

        // Requete pour avoir le panier par rapport à l'id de l'user et le statut de la commande (0 : commande en cours donc panier avec produit, 1 : commande validé donc panier vide)
        $requetePanier = $pdo->prepare("
            SELECT *
            FROM commande
            WHERE id_users = :id_user AND statut = 0
        ");
        $requetePanier->execute([
            'id_user' => $id
        ]);

        $panier = $requetePanier->fetch();

        if (!empty($panier)) {
            $idCommande = $panier['id_commande'];

            // Vérifie s'il y a des produits dans la commande, si non : on la supprime
            $requeteCommande = $pdo->prepare("
                SELECT *
                FROM produit_commande
                WHERE id_commande = :id_commande
            ");
            $requeteCommande->execute([
                'id_commande' => $idCommande
            ]);

            $commande = $requeteCommande->fetchAll();

            if (empty($commande)) {
                $requeteSuprCommande = $pdo->prepare("
                DELETE FROM commande
                WHERE id_commande = :id_commande
            ");
                $requeteSuprCommande->execute([
                    'id_commande' => $idCommande
                ]);
            }

            $requetePanier->execute([
                'id_user' => $id
            ]);
        }

        require "view/panier.php";
    }
}
