<?php

namespace Controller;

use Model\Connect; // "use" pour accéder à la classe Connect située dans le namespace "Model"


class ProfilController
{
    public function profil()
    {
        $pdo = Connect::seConnecter();

        if (!isset($_SESSION['users'])) {
            header("Location: index.php?action=login");
            exit;
        }

        $idUser = $_SESSION['users']['id'];

        // Afficher les adresses
        $requeteAdresses = $pdo->prepare("
            SELECT *
            FROM adresse
            WHERE id_user = :id_user
            ORDER BY defaut DESC
        ");
        $requeteAdresses->execute([
            'id_user' => $idUser
        ]);

        // Ajouter une adresse
        if(isset($_POST['ajouter'])) {

            // Filtre
            $nom = filter_input(INPUT_POST, 'nom', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $prenom = filter_input(INPUT_POST, 'prenom', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $adresse = filter_input(INPUT_POST, 'adresse', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $CP = filter_input(INPUT_POST, 'CP', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $ville = filter_input(INPUT_POST, 'ville', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $numero = filter_input(INPUT_POST, 'num', FILTER_VALIDATE_REGEXP, array('options' => array('regexp' => '/^[0-9]{10}$/'))); //vérifie que le numéro de téléphone est composé exactement de 10 chiffres de 0 à 9
            $defaut = filter_input(INPUT_POST, 'defaut', FILTER_VALIDATE_BOOLEAN);
            if($defaut) {
                $defaut = 1;
            } else {
                $defaut = 0;
            }

            if ($nom !== false && $prenom !== false && $adresse !== false && $CP !== false && $ville !== false && $numero !== false && $defaut !== false) {

                if (!empty($nom) && !empty($prenom) && !empty($adresse) && !empty($CP) && !empty($ville) && !empty($numero)) {

                    $adresseUser = $requeteAdresses->fetchAll();
                    $nbAdresse = count($adresseUser);

                    if($nbAdresse > 0 && $defaut == 1) {
                        $requeteChangeDefaut = $pdo->prepare("
                            UPDATE adresse
                            SET defaut = 0
                            WHERE id_user = :id_user
                        ");
                        $requeteChangeDefaut->execute([
                            'id_user' => $idUser
                        ]);
                    }

                    $requeteAjouterAdresse = $pdo->prepare("
                        INSERT INTO adresse (id_user, nom, prenom, adresse, cp, ville, telephone, defaut)
                        VALUES (:id_user, :nom, :prenom, :adresse, :cp, :ville, :telephone, :defaut)
                    ");
                    $requeteAjouterAdresse->execute([
                        'id_user' => $idUser,
                        'nom' => $nom,
                        'prenom' => $prenom,
                        'adresse' => $adresse,
                        'cp' => $CP,
                        'ville' => $ville,
                        'telephone' => $numero,
                        'defaut' => $defaut
                    ]);

                    $_SESSION['alerte'] = "<div id='alert' class='alert-green'>Adresse ajouté avec succès</div>";
                    header("Location: index.php?action=profil&page=adresses");
                    exit;

                } else {
                    $_SESSION['alerte'] = "<div id='alert' class='alert-red'>Tous les champs sont obligatoires</div>";
                    header("Location: index.php?action=profil&page=ajouterAdresse");
                    exit;
                }

            } else {
                $_SESSION['alerte'] = "<div id='alert' class='alert-red'>Erreur champs</div>";
                header("Location: index.php?action=profil&page=ajouterAdresse");
                exit;
            }

        }


        require "view/profil.php";
    }

}