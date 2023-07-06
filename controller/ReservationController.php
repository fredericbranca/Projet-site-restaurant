<?php

namespace Controller;

use Model\Connect; // "use" pour accéder à la classe Connect située dans le namespace "Model"


class ReservationController
{
    /* Enregistrer une réservation' */
    public function enregistrerReservation()
    {
        $pdo = Connect::seConnecter();

        // On récupère le nombre de table entrée par le restaurateur
        $requeteNbTable = $pdo->query("
            SELECT *
            FROM nb_table
        ");

        $requeteNbTable = $requeteNbTable->fetch();
        $nbTable = $requeteNbTable['nb_table'];

        if (isset($_POST['reservation']) && ($_POST['reservation'] == "MIDI" || $_POST['reservation'] == "SOIR")) {

            // Filtre
            $nbCouvert = filter_input(INPUT_POST, 'couvert', FILTER_VALIDATE_INT);
            if ($nbCouvert < 1 || $nbCouvert > 8) {
                $_SESSION['message'] = '<div class="alert">Le nombre de couvert sélectionné est indisponible.</div>';
                header("Location: index.php?action=reservation");
                exit;
            }
            $date = filter_input(INPUT_POST, 'date', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $dateActuelle = date("Y-m-d");
            $dateMax = date("Y") + 1 . "-03-31";
            if ($date < $dateActuelle || $date > $dateMax) {
                $_SESSION['message'] = '<div class="alert">La date sélectionnée est indisponible.</div>';
                header("Location: index.php?action=reservation");
                exit;
            }
            $creneau = strtolower($_POST['reservation']);

            // On vérifie si les valeurs sont valides
            if ($nbCouvert !== false && $date !== false) {

                // On vérifie si le nombre de couvert est disponible
                $requeteTableDisponible = $pdo->prepare("
                    SELECT *
                    FROM table_reserve
                    WHERE date = :date AND creneau = :creneau
                ");
                $requeteTableDisponible->execute([
                    'date' => $date,
                    'creneau' => $creneau
                ]);

                $requeteTableDisponible = $requeteTableDisponible->fetchAll();

                foreach ($requeteTableDisponible as $tableDisponible) {
                    $nbTable -= $tableDisponible['nb_table'];
                }

                $nbTable -= ceil($nbCouvert / 2);

                if ($nbTable >= 0) {
                    $_SESSION['couvert'] = $nbCouvert;
                    $_SESSION['date'] = $date;
                    $_SESSION['creneau'] = $creneau;
                    $_SESSION['accesInfosReservation'] = 1;
                    header("Location: index.php?action=infosReservation");
                    exit;
                } else {
                    $creneau = $creneau;
                    $date = date("d/m/Y", strtotime($date));
                    $_SESSION['message'] = "<div class='alert'>Il n'y a plus de place disponible pour $nbCouvert couverts le $date $creneau</div>";
                    header("Location: index.php?action=reservation");
                    exit;
                }
            } else {
                $_SESSION['message'] = "<div class='alert'>Champs incorrect.</div>";
                header("Location: index.php?action=reservation");
                exit;
            }
        }


        require "view/reservation.php";
    }

    /* Valider une réservation' */
    public function validerReservation()
    {
        $pdo = Connect::seConnecter();

        if (isset($_POST['reservation'])) {

            // Filtre
            $civilite = filter_input(INPUT_POST, 'sexe', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $prenom = filter_input(INPUT_POST, 'prenom', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $nom = filter_input(INPUT_POST, 'nom', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $numero = filter_input(INPUT_POST, 'numero', FILTER_VALIDATE_REGEXP, array('options' => array('regexp' => '/^[0-9]{10}$/'))); //vérifie que le numéro de téléphone est composé exactement de 10 chiffres de 0 à 9
            $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);

            $date = $_SESSION['date'];
            $personne = $_SESSION['couvert'];
            $creneau = $_SESSION['creneau'];
            $nbTable = ceil($personne / 2);

            if ($civilite !== false && $prenom !== false && $nom !== false && $numero !== false && $email !== false) {

                // Entre les informations de la réservation dans la DB
                $requeteReservation = $pdo->prepare("
                    INSERT INTO reservation (date, nombre, creneau, civilite, nom, prenom, telephone, email)
                    VALUES (:date, :nombre, :creneau, :civilite, :nom, :prenom, :telephone, :email)
                ");
                $requeteReservation->execute([
                    'date' => $date,
                    'nombre' => $personne,
                    'creneau' => $creneau,
                    'civilite' => $civilite,
                    'nom' => $nom,
                    'prenom' => $prenom,
                    'telephone' => $numero,
                    'email' => $email
                ]);

                $requeteTableReservee = $pdo->prepare("
                    INSERT INTO table_reserve (id_reservation, nb_table, date, creneau)
                    VALUES (LAST_INSERT_ID(), :table, :date, :creneau)
                ");
                $requeteTableReservee->execute([
                    'table' => $nbTable,
                    'date' => $date,
                    'creneau' => $creneau
                ]);

                $_SESSION['accesReservationValidee'] = 1;
                $_SESSION['message'] = "<div class='alert-2'>Reservation validée pour $personne personnes le $date ($creneau)</div>";
                header("Location: index.php?action=reservationValidee");
                exit;

            } else {
                $_SESSION['message'] = "<div class='alert-1'>Champs incorrect</div>";
                header("Location: index.php?action=infosReservation");
                exit;
            }
        }

        require "view/infosReservation.php";
    }
}
