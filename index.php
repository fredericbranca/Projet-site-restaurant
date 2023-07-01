<?php 

session_start();

use Controller\RestaurantController; // On "use" le controller Restaurant

// On autocharge les classes du projet
spl_autoload_register(function ($class_name) {
    include $class_name . '.php';
});

$ctrlRestaurant = new RestaurantController(); // On instancie le controller Restaurant

$id = (isset($_GET["id"])) ? $_GET["id"] : null;

if(isset($_GET["action"])) {

    switch ($_GET["action"]) {

        // RestaurantController
        case "accueil" : $ctrlRestaurant -> afficherHoraire(); break;
        case "carte" : $ctrlRestaurant -> afficherCarte(); break;
    }
}