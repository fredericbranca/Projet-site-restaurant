<?php

namespace Controller;

use Model\Connect; // "use" pour accéder à la classe Connect située dans le namespace "Model"


class ProfilController
{
    public function profil()
    {
        // Vérification accès
        if (!isset($_SESSION['users'])) {
            header("Location: index.php?action=login");
            exit;
        }

        $pdo = Connect::seConnecter();

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
        if (isset($_POST['ajouter'])) {

            // Filtre
            $nom = filter_input(INPUT_POST, 'nom', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $prenom = filter_input(INPUT_POST, 'prenom', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $adresse = filter_input(INPUT_POST, 'adresse', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $CP = filter_input(INPUT_POST, 'CP', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $ville = filter_input(INPUT_POST, 'ville', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $numero = filter_input(INPUT_POST, 'num', FILTER_VALIDATE_REGEXP, array('options' => array('regexp' => '/^[0-9]{10}$/'))); //vérifie que le numéro de téléphone est composé exactement de 10 chiffres de 0 à 9
            $defaut = filter_input(INPUT_POST, 'defaut', FILTER_VALIDATE_BOOLEAN);
            if ($defaut) {
                $defaut = 1;
            } else {
                $defaut = 0;
            }

            if ($nom !== false && $prenom !== false && $adresse !== false && $CP !== false && $ville !== false && $numero !== false && $defaut !== false) {

                if (!empty($nom) && !empty($prenom) && !empty($adresse) && !empty($CP) && !empty($ville) && !empty($numero)) {

                    $adresseUser = $requeteAdresses->fetchAll();
                    $nbAdresse = count($adresseUser);

                    if ($defaut == 1) {
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

        // Supprimer une adresse
        if (isset($_GET['page']) && $_GET['page'] === 'adresses' && isset($_GET['supprimer'])) {

            $idAdresse = filter_input(INPUT_GET, 'supprimer', FILTER_VALIDATE_INT);

            if ($idAdresse !== false) {
                $requeteSupprimerAdresse = $pdo->prepare("
                    DELETE FROM adresse
                    WHERE id_user = :id_user AND id_adresse = :id_adresse
                ");
                $requeteSupprimerAdresse->execute([
                    'id_user' => $idUser,
                    'id_adresse' => $idAdresse
                ]);

                $_SESSION['alerte'] = "<div id='alert' class='alert-green'>Adresse supprimé avec succès</div>";
                header("Location: index.php?action=profil&page=adresses");
                exit;
            } else {
                $_SESSION['alerte'] = "<div id='alert' class='alert-red'>Une erreur s'est produit, l'adresse n'a pas été supprimée</div>";
                header("Location: index.php?action=profil&page=adresses");
                exit;
            }
        }

        // Modifier une adresse

        if (isset($_GET['page']) && $_GET['page'] === 'adresses' && isset($_GET['modifier'])) {

            $idAdresse = $_GET['modifier'];

            $requeteAdresseWithId = $pdo->prepare("
                SELECT *
                FROM adresse
                WHERE id_user = :id_user AND id_adresse = :id_adresse
            ");
            $requeteAdresseWithId->execute([
                'id_user' => $idUser,
                'id_adresse' => $idAdresse
            ]);
        }

        if (isset($_POST['modifier']) && isset($_GET['id'])) {

            $idAdresse = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

            // Filtre
            $nom = filter_input(INPUT_POST, 'nom', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $prenom = filter_input(INPUT_POST, 'prenom', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $adresse = filter_input(INPUT_POST, 'adresse', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $CP = filter_input(INPUT_POST, 'CP', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $ville = filter_input(INPUT_POST, 'ville', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $numero = filter_input(INPUT_POST, 'num', FILTER_VALIDATE_REGEXP, array('options' => array('regexp' => '/^[0-9]{10}$/'))); //vérifie que le numéro de téléphone est composé exactement de 10 chiffres de 0 à 9
            $defaut = filter_input(INPUT_POST, 'defaut', FILTER_VALIDATE_BOOLEAN);
            if ($defaut) {
                $defaut = 1;
            } else {
                $defaut = 0;
            }
            

            if ($nom !== false && $prenom !== false && $adresse !== false && $CP !== false && $ville !== false && $numero !== false && $defaut !== false && $idAdresse !== false) {

                if (!empty($nom) && !empty($prenom) && !empty($adresse) && !empty($CP) && !empty($ville) && !empty($numero) && !empty($idAdresse)) {

                    $adresseUser = $requeteAdresses->fetchAll();
                    $nbAdresse = count($adresseUser);

                    if ($defaut == 1) {
                        $requeteChangeDefaut = $pdo->prepare("
                            UPDATE adresse
                            SET defaut = 0
                            WHERE id_user = :id_user
                        ");
                        $requeteChangeDefaut->execute([
                            'id_user' => $idUser
                        ]);
                    }

                    $requeteModifierAdresse = $pdo->prepare("
                        UPDATE adresse
                        SET id_user = :id_user, nom = :nom, prenom = :prenom, adresse = :adresse, cp = :cp, ville = :ville, telephone = :telephone, defaut = :defaut
                        WHERE id_adresse = :id_adresse
                    ");
                    $requeteModifierAdresse->execute([
                        'id_user' => $idUser,
                        'nom' => $nom,
                        'prenom' => $prenom,
                        'adresse' => $adresse,
                        'cp' => $CP,
                        'ville' => $ville,
                        'telephone' => $numero,
                        'defaut' => $defaut,
                        'id_adresse' => $idAdresse
                    ]);

                    $_SESSION['alerte'] = "<div id='alert' class='alert-green'>Adresse modifié avec succès</div>";
                    header("Location: index.php?action=profil&page=adresses");
                    exit;
                } else {
                    $_SESSION['alerte'] = "<div id='alert' class='alert-red'>Tous les champs sont obligatoires</div>";
                    header("Location: index.php?action=profil&page=adresses&modifier=$idAdresse");
                    exit;
                }
            } else {
                $_SESSION['alerte'] = "<div id='alert' class='alert-red'>Erreur champs</div>";
                header("Location: index.php?action=profil&page=adresses&modifier=$idAdresse");
                exit;
            }
        }

        // Historique de commande
        $requeteCommande = $pdo->prepare("
            SELECT *, DATE_FORMAT(date, '%d - %m - %Y')
            FROM commande
            WHERE id_users = :id_user
        ");
        $requeteCommande->execute([
            'id_user' => $idUser
        ]);

        // Afficher les réservations (pour l'admin) en fonction de la date

        if(isset($_POST['dateRes'])) {

            $date = filter_input(INPUT_POST, 'date', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            if($date !== false) {
                
                $timestamp = strtotime($date);
                $_SESSION['dateFormat'] = date('d - m - Y', $timestamp);

                $requeteReservation = $pdo->prepare("
                    SELECT *
                    FROM reservation
                    WHERE date = :date
                ");
                $requeteReservation->execute([
                    'date' => $date
                ]);

                $_SESSION['dateReservation'] = $requeteReservation->fetchAll();
                
                header("Location: index.php?action=profil&page=compte");
                exit;

            } else {
                $_SESSION['alerte'] = "<div id='alert' class='alert-red'>Erreur champs</div>";
                header("Location: index.php?action=profil&page=compte");
                exit;
            }
        }

        // Annuler une réservation

        if(isset($_POST['annuler']) && isset($_GET['id'])) {

            $idRes = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

            if($idRes !== false) {

                $requeteSupprimerTable = $pdo->prepare("
                    DELETE FROM table_reserve
                    WHERE id_reservation = :id
                ");
                $requeteSupprimerTable->execute([
                    'id' => $idRes
                ]);

                $requeteAnnulerRes = $pdo->prepare("
                    DELETE FROM reservation
                    WHERE id_reservation = :id
                ");
                $requeteAnnulerRes->execute([
                    'id' => $idRes
                ]);

                $_SESSION['alerte'] = "<div id='alert' class='alert-green'>Réservation annulée avec succès</div>";
                header("Location: index.php?action=profil&page=compte");
                exit;

            } else {
                $_SESSION['alerte'] = "<div id='alert' class='alert-red'>Action non autorisée</div>";
                header("Location: index.php?action=profil&page=compte");
                exit;
            }
        }

        require "view/profil.php";
    }
}
