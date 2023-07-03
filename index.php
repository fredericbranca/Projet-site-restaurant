<?php 

session_start();

use Controller\RestaurantController; // On "use" le controller Restaurant
use Controller\ReservationController;
use Controller\AuthentificationController;
use Controller\AdminController;

// On autocharge les classes du projet
spl_autoload_register(function ($class_name) {
    include $class_name . '.php';
});

$ctrlRestaurant = new RestaurantController(); // On instancie le controller Restaurant
$ctrlReservation = new ReservationController();
$ctrlAuthentification = new AuthentificationController();
$ctrlAdmin = new AdminController();

$id = (isset($_GET["id"])) ? $_GET["id"] : null;

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
        case "admin" : $ctrlAdmin -> admin($id); break;
    }
}