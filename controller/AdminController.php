<?php

namespace Controller;

use Model\Connect; // "use" pour accéder à la classe Connect située dans le namespace "Model"


class AdminController
{
    /* Afficher les horaires' */
    public function admin($id)
    {
        $pdo = Connect::seConnecter();

        // Afficher les horaires
        $requeteHoraires = $pdo->query("
            SELECT *
            FROM horaires
        ");

        // Modifier les horaires



        // Afficher la carte
        $requeteDejeuner = $pdo->query("
            SELECT *, FORMAT(prix, 2) AS prix_format
            FROM carte
            WHERE section = 'dejeuner'
        ");
        $requeteSoir = $pdo->query("
            SELECT *, FORMAT(prix, 2) AS prix_format
            FROM carte
            WHERE section = 'soir'
        ");
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

        // Modifier la carte

        if (isset($_POST['modifier']) && isset($_GET['id'])) {

            // Filtre
            $produit = filter_input(INPUT_POST, 'produit', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            // On vérifie si la longueur du produit est correct
            if (strlen($produit) <= 0 || strlen($produit) > 255 || empty($produit)) {
                $_SESSION['alerte'] = "<div id='alert' class='alert-red'>Le produit doit contenir entre 1 et 255 caractères.</div>";
                header("Location: index.php?action=admin");
                exit;
            }

            $prix = filter_input(INPUT_POST, 'prix', FILTER_VALIDATE_FLOAT);
            // On vérifie si la longueur du produit est correct
            if ($prix <= 0 || empty($prix)) {
                $_SESSION['alerte'] = "<div id='alert' class='alert-red'>Le prix minimale est de 0,01€</div>";
                header("Location: index.php?action=admin");
                exit;
            }

            $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

            if ($produit !== false && $prix !== false && $id !== false) {

                // Requete pour modifier la carte
                $requeteUpdateCarte = $pdo->prepare("
                    UPDATE carte
                    SET description = :description, prix = :prix
                    WHERE id_produit = :id
                ");
                $requeteUpdateCarte->execute([
                    'description' => $produit,
                    'prix' => $prix,
                    'id' => $id
                ]);

                // Redirection
                $requeteSection = $pdo->prepare("
                    SELECT section
                    FROM carte
                    WHERE id_produit = :id
                ");
                $requeteSection->execute([
                    'id' => $id
                ]);
                $section = $requeteSection->fetch();
                $section = $section['section'];

                $_SESSION['alerte'] = "<div id='alert' class='alert-green'>Le produit a été modifié</div>";
                header("Location: index.php?action=admin#$section");
                exit;
            } else {
                $_SESSION['alerte'] = "<div id='alert' class='alert-red'>Champs incorrect</div>";
                header("Location: index.php?action=admin");
                exit;
            }
        }

        // Ajouter un produit à la carte

        if (isset($_POST['ajouter']) && isset($_GET['section'])) {

            // Filtre

            $section = filter_input(INPUT_GET, 'section', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            // Vérification de la section
            $sectionsAutorisees = ["dejeuner", "soir", "entree", "plat", "dessert", "boisson"];
            if (!in_array($section, $sectionsAutorisees)) {
                $_SESSION['alerte'] = "<div id='alert' class='alert-red'>Erreur URL section</div>";
                header("Location: index.php?action=admin");
                exit;
            }

            $produit = filter_input(INPUT_POST, 'produit', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            // On vérifie si la longueur du produit est correct
            if (strlen($produit) <= 0 || strlen($produit) > 255 || empty($produit)) {
                $_SESSION['alerte'] = "<div id='alert' class='alert-red'>Le produit doit contenir entre 1 et 255 caractères.</div>";
                header("Location: index.php?action=admin#$section");
                exit;
            }

            $prix = filter_input(INPUT_POST, 'prix', FILTER_VALIDATE_FLOAT);
            // On vérifie si la longueur du produit est correct
            if ($prix <= 0 || empty($prix)) {
                $_SESSION['alerte'] = "<div id='alert' class='alert-red'>Le prix minimale est de 0,01€</div>";
                header("Location: index.php?action=admin#$section");
                exit;
            }

            if ($produit !== false && $prix !== false && $section !== false) {

                // Requete pour ajouter le produit entrée
                $requeteAjoutProduit = $pdo->prepare("
                    INSERT INTO carte (description, prix, section)
                    VALUES (:description, :prix, :section)
                ");
                $requeteAjoutProduit->execute([
                    'description' => $produit,
                    'prix' => $prix,
                    'section' => $section
                ]);

                $_SESSION['alerte'] = "<div id='alert' class='alert-green'>Le produit a été ajouté</div>";
                header("Location: index.php?action=admin#$section");
                exit;
            } else {
                $_SESSION['alerte'] = "<div id='alert' class='alert-red'>Champs incorrect</div>";
                header("Location: index.php?action=admin#$section");
                exit;
            }
        }

        require "view/admin.php";
    }
}
