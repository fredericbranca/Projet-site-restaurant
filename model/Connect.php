<?php

namespace Model; //namespace permettant de catégoriser virtuellement (dans un espace de nom la classe en question)

abstract class Connect {

    const HOST = "localhost";
    const DB = "restaurant";
    const USER = "root";
    const PASS = "";

    public static function seConnecter(){

        try {   
            return new \PDO(
                "mysql:host=".self::HOST.";dbname=".self::DB.";charset=utf8", self::USER, self::PASS); // On se connecte à MySQL
        } catch (\PDOException $ex) {
            die('Erreur : ' . $ex->getMessage()); // En cas d'erreur, on affiche un message
        }
    }
}

?>