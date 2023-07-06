<?php

namespace Controller;

use Model\Connect; // "use" pour accéder à la classe Connect située dans le namespace "Model"


class AdminController
{
    /* Afficher les horaires' */
    public function admin($id)
    {

        if (!isset($_SESSION['users']) || $_SESSION['users']['admin'] != 1) {
            $_SESSION['alerte'] = "<div id='alert' class='alert-red'>Accès non autorisé</div>";
            header("Location: index.php?action=login");
            exit;
        }

        $pdo = Connect::seConnecter();

        // Afficher le nombre de table
        $requeteTable = $pdo->query("
            SELECT *
            FROM nb_table
        ");

        // Modifier le nombre de table

        if (isset($_POST['modifierTable'])) {

            // Filtre
            $nbTable = filter_input(INPUT_POST, 'table', FILTER_SANITIZE_NUMBER_INT);
            // On vérifie si table est un nombre positif
            if ($nbTable < 0) {
                $_SESSION['message'] = "<div class='alert-table'>Le nombre de table doit être un nombre positif ou égal à 0</div>";
                header("Location: index.php?action=admin&page=table");
                exit;
            }

            if ($nbTable !== false) {

                // Requete pour modifier le nombre de table
                $requeteUpdateTable = $pdo->prepare("
                    UPDATE nb_table
                    SET nb_table = :nb_table
                ");
                $requeteUpdateTable->execute([
                    'nb_table' => $nbTable
                ]);

                //Redirection
                $_SESSION['message'] = "<div class='alert-table'>Le nombre de table a été modifié</div>";
                header("Location: index.php?action=admin&page=table");
                exit;

            } else {
                $_SESSION['message'] = "<div class='alert-table'>Champs incorrect</div>";
                header("Location: index.php?action=admin&page=table");
                exit;
            }
        }


        // Afficher les horaires
        $requeteHoraires = $pdo->query("
            SELECT *
            FROM horaires
        ");

        // Modifier les horaires

        if (isset($_POST['modifierHoraire']) && isset($_GET['id'])) {

            // Filtre
            $jour = filter_input(INPUT_POST, 'jour', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            // On vérifie si la longueur du jour est correct
            if (strlen($jour) <= 0 || strlen($jour) > 50 || empty($jour)) {
                $_SESSION['alerte'] = "<div id='alert' class='alert-red'>Le jour doit contenir entre 1 et 50 caractères.</div>";
                header("Location: index.php?action=admin&page=horaire");
                exit;
            }

            $heure = filter_input(INPUT_POST, 'heure', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            // On vérifie si la longueur de l'heure est correct
            if (strlen($heure) <= 0 || strlen($heure) > 50 || empty($heure)) {
                $_SESSION['alerte'] = "<div id='alert' class='alert-red'>L'heure doit contenir entre 1 et 50 caractères.</div>";
                header("Location: index.php?action=admin&page=horaire");
                exit;
            }

            $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
            if (empty($id)) {
                $_SESSION['alerte'] = "<div id='alert' class='alert-red'>Erreur URL id</div>";
                header("Location: index.php?action=admin&page=horaire");
                exit;
            }

            if ($jour !== false && $heure !== false && $id !== false) {

                // Requete pour modifier les horaires
                $requeteUpdateHoraire = $pdo->prepare("
                    UPDATE horaires
                    SET jour = :jour, heures = :heures
                    WHERE id_horaire = :id
                ");
                $requeteUpdateHoraire->execute([
                    'jour' => $jour,
                    'heures' => $heure,
                    'id' => $id
                ]);

                // Redirection
                $_SESSION['alerte'] = "<div id='alert' class='alert-green'>L'horaire a été modifiée</div>";
                header("Location: index.php?action=admin&page=horaire");
                exit;
            } else {
                $_SESSION['alerte'] = "<div id='alert' class='alert-red'>Champs incorrect</div>";
                header("Location: index.php?action=admin&page=horaire");
                exit;
            }
        }

        // Ajouter un horaire

        if (isset($_POST['ajouterHoraire'])) {

            // Filtre
            $jour = filter_input(INPUT_POST, 'jour', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            // On vérifie si la longueur du jour est correct
            if (strlen($jour) <= 0 || strlen($jour) > 50 || empty($jour)) {
                $_SESSION['alerte'] = "<div id='alert' class='alert-red'>Le jour doit contenir entre 1 et 50 caractères.</div>";
                header("Location: index.php?action=admin&page=horaire");
                exit;
            }

            $heure = filter_input(INPUT_POST, 'heure', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            // On vérifie si la longueur de l'heure est correct
            if (strlen($heure) <= 0 || strlen($heure) > 50 || empty($heure)) {
                $_SESSION['alerte'] = "<div id='alert' class='alert-red'>L'heure doit contenir entre 1 et 50 caractères.</div>";
                header("Location: index.php?action=admin&page=horaire");
                exit;
            }

            if ($jour !== false && $heure !== false) {

                // Requete pour ajouter un horaires
                $requeteAddHoraire = $pdo->prepare("
                    INSERT INTO horaires (jour, heures)
                    VALUES (:jour, :heures)
                ");
                $requeteAddHoraire->execute([
                    'jour' => $jour,
                    'heures' => $heure,
                ]);

                // Redirection
                $_SESSION['alerte'] = "<div id='alert' class='alert-green'>L'horaire a été ajoutée</div>";
                header("Location: index.php?action=admin&page=horaire");
                exit;
            } else {
                $_SESSION['alerte'] = "<div id='alert' class='alert-red'>Champs incorrect</div>";
                header("Location: index.php?action=admin&page=horaire");
                exit;
            }
        }

        // Supprimer un horaire

        if (isset($_POST['supprimerHoraire']) && isset($_GET['id'])) {

            $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

            if (empty($id)) {
                $_SESSION['alerte'] = "<div id='alert' class='alert-red'>Erreur URL id</div>";
                header("Location: index.php?action=admin&page=horaire");
                exit;
            }

            if ($id !== false) {

                // Requete pour supprimer un horaire
                $requeteSuprHoraire = $pdo->prepare("
                    DELETE FROM horaires
                    WHERE id_horaire = :id
                ");
                $requeteSuprHoraire->execute([
                    'id' => $id
                ]);

                // Redirection
                $_SESSION['alerte'] = "<div id='alert' class='alert-green'>L'horaire a été supprimée</div>";
                header("Location: index.php?action=admin&page=horaire");
                exit;
            } else {
                $_SESSION['alerte'] = "<div id='alert' class='alert-red'>Champs incorrect</div>";
                header("Location: index.php?action=admin&page=horaire");
                exit;
            }
        }

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
            if (empty($id)) {
                $_SESSION['alerte'] = "<div id='alert' class='alert-red'>Erreur URL id</div>";
                header("Location: index.php?action=admin");
                exit;
            }

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

        // Supprimer un produit de la carte

        if (isset($_POST['supprimer']) && isset($_GET['id'])) {

            // Filtre
            $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
            if (empty($id)) {
                $_SESSION['alerte'] = "<div id='alert' class='alert-red'>Erreur URL id</div>";
                header("Location: index.php?action=admin");
                exit;
            }

            if ($id !== false) {

                // Requete pour supprimer le produit
                $requeteSupprimerProduit = $pdo->prepare("
                    DELETE FROM carte
                    WHERE id_produit = :id
                ");
                $requeteSupprimerProduit->execute([
                    'id' => $id
                ]);

                $_SESSION['alerte'] = "<div id='alert' class='alert-green'>Le produit a été supprimé de la carte</div>";
                header("Location: index.php?action=admin");
                exit;
            } else {
                $_SESSION['alerte'] = "<div id='alert' class='alert-red'>Erreur URL id</div>";
                header("Location: index.php?action=admin");
                exit;
            }
        }

        require "view/admin.php";
    }
}
