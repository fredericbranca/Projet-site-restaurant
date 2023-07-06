<?php 

session_start();

use Controller\RestaurantController; // On "use" le controller Restaurant
use Controller\ReservationController;
use Controller\AuthentificationController;
use Controller\AdminController;
use Controller\LivraisonController;
use Controller\ProfilController;

// On autocharge les classes du projet
spl_autoload_register(function ($class_name) {
    include $class_name . '.php';
});

$ctrlRestaurant = new RestaurantController(); // On instancie le controller Restaurant
$ctrlReservation = new ReservationController();
$ctrlAuthentification = new AuthentificationController();
$ctrlAdmin = new AdminController();
$ctrlLivraison = new LivraisonController();
$ctrlProfil = new ProfilController();

$id = (isset($_GET["id"])) ? $_GET["id"] : null;
$section = (isset($_GET["section"])) ? $_GET["section"] : null;

if(isset($_GET["action"])) {

    switch ($_GET["action"]) {

        // RestaurantController
        case "accueil" : $ctrlRestaurant -> afficherHoraire(); break;
        case "carte" : $ctrlRestaurant -> afficherCarte(); break;

        // ReservationController
        case "reservation" : $ctrlReservation -> enregistrerReservation(); break;
        case "infosReservation" : $ctrlReservation -> validerReservation(); break;
        case "reservationValidee" : include "view/reservationValidee.php"; break;

        // AuthentificationController
        case "login" : $ctrlAuthentification -> login(); break;
        case "register" : $ctrlAuthentification -> register(); break;
        case "logout" : $ctrlAuthentification -> logout(); break;

        // AdminController
        case "admin" : $ctrlAdmin -> admin($id, $section); break;
        
        // LivraisonController
        case "livraison" : $ctrlLivraison -> livraison(); break;
        case "panier" : $ctrlLivraison -> panier(); break;
        case "panierPayer" : include "view/panierPayer.php"; break;

        // ProfilController
        case "profil" : $ctrlProfil -> profil(); break;
    }
}