<?php

namespace Controller;

use Model\Connect; // "use" pour accéder à la classe Connect située dans le namespace "Model"


class AuthentificationController
{
    /* Connexion */
    public function login()
    {
        if (isset($_SESSION['users'])) {
            header("Location: index.php?action=profil");
            exit;
        }
        if (isset($_POST['submit'])) {

            // Filtres
            $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
            // FILTER_VALIDATE_EMAIL : permet la validation des adresses e-mail Unicode conformément aux normes (n'accepte que les caractères ASCII)
            $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            if ($email !== false && $password !== false) {

                $pdo = Connect::seConnecter();

                $requeteEmail = $pdo->prepare("
                    SELECT *
                    FROM users
                    WHERE email = :email
                ");
                $requeteEmail->execute([
                    'email' => $email
                ]);

                // Vérifie si l'email existe
                if ($requeteEmail->rowCount() === 1) {
                    $userData = $requeteEmail->fetch();
                    $hashedPassword = $userData['password'];

                    // Vérifie le mot de passe
                    if (password_verify($password, $hashedPassword)) {
                        $userId = $userData['id'];
                        $_SESSION['alerte'] = "<div id='alert' class='alert-green'>Connexion réussie</div>";
                        $_SESSION['users'] = $userData;
                        header("Location: index.php?action=profil");
                        exit;
                    } else {
                        $_SESSION['message'] = "<div class='alert-password'>Mot de passe incorrect</div>";
                        header("Location: index.php?action=login");
                        exit;
                    }
                } else {
                    $_SESSION['message'] = "<div class='alert-email'>Email incorrect</div>";
                    header("Location: index.php?action=login");
                    exit;
                }
            } else {
                $_SESSION['message'] = "<div class='alert-champs'>Champs incorrect</div>";
                header("Location: index.php?action=login");
                exit;
            }
        }

        require "view/login.php";
    }

    // Inscription
    public function register()
    {
        if (isset($_SESSION['users'])) {
            header("Location: index.php?action=profil");
            exit;
        }
        if (isset($_POST['submit'])) {

            // Filtres
            $nom = filter_input(INPUT_POST, 'nom', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $prenom = filter_input(INPUT_POST, 'prenom', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
            $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $confirmPassword = filter_input(INPUT_POST, 'confirm-password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            // On vérifie si la longueur du prénom est correct
            if (strlen($prenom) <= 0 || strlen($prenom) > 50) {
                $_SESSION['message'] = "<div class='alert-prenom'>Le nom est limité à 50 caractères</div>";
                header("Location: index.php?action=register");
                exit;
            }
            // On vérifie si la longueur du nom est correct
            if (strlen($nom) <= 0 || strlen($nom) > 50) {
                $_SESSION['message'] = "<div class='alert-nom'>Le prénom est limité à 50 caractères</div>";
                header("Location: index.php?action=register");
                exit;
            }
            // On vérifie si la longueur de l'email est correct
            if (strlen($email) <= 0 || strlen($email) > 80) {
                $_SESSION['message'] = "<div class='alert-email'>L'email est limité à 80 caractères</div>";
                header("Location: index.php?action=register");
                exit;
            }
            // On vérifie si la longueur du prénom est correct
            if (strlen($password) <= 0 || strlen($password) > 25) {
                $_SESSION['message'] = "<div class='alert-pass'>Le mot de passe doit contenir entre 1 et 25 caractères.</div>";
                header("Location: index.php?action=register");
                exit;
            }

            if ($nom !== false && $prenom !== false && $email !== false && $password !== false && $confirmPassword !== false) {
                
                $pdo = Connect::seConnecter();

                // Vérifie si l'email existe déjà
                $requeteEmail = $pdo->prepare("
                    SELECT COUNT(*)
                    FROM users
                    WHERE email = :email
                ");
                $requeteEmail->execute([
                    'email' => $email
                ]);

                // J'utilise fetchColumn() pour vérifier si le nombre de ligne est supérieur à 0, si oui : l'email est déjà utilisé
                if ($requeteEmail->fetchColumn() > 0) {
                    $_SESSION['message'] = "<div class='alert-email'>Email déjà utilisé</div>";
                    header("Location: index.php?action=register");
                    exit;
                }

                // Vérifie que les 2 mots de passe correspondent
                if ($_POST['password'] !== $_POST['confirm-password']) {
                    $_SESSION['message'] = "<div class='alert-cpass'>Les deux mots de passe ne correspondent pas</div>";
                    header("Location: index.php?action=register");
                    exit;
                  }

                // Hachage du mot de passe
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                
                // Ajout à la db
                $requeteAjoutUser = $pdo->prepare("
                  INSERT INTO users (email, password, nom, prenom)
                  VALUES (:email, :password, :nom, :prenom)
                ");
                $requeteAjoutUser->execute([
                    'email' => $email,
                    'password' => $hashedPassword,
                    'nom' => $nom,
                    'prenom' => $prenom
                ]);

                // Redirection + message
                $_SESSION['alerte'] = "<div id='alert' class='alert-green'>Inscription réussie : Vous pouvez vous connecter</div>";
                header("Location: index.php?action=login");
                exit;

            } else {
                $_SESSION['message'] = "<div class='alert-champs'>Champs incorrect</div>";
                header("Location: index.php?action=register");
                exit;
            }
        }

        require "view/register.php";
    }

    // Déconnexion
    public function logout()
    {
        if (!isset($_SESSION['users'])) {
            $_SESSION['alerte'] = "<div id='alert' class='alert-red'>Vous êtes déjà déconnecté</div>";
            header("Location: index.php?action=login");
            exit;
        }
        if ($_GET['action'] === 'logout') {
            // Détruit la session et rediriger vers l'accueil
            unset($_SESSION['users']);
            $_SESSION['alerte'] = "<div id='alert' class='alert-green'>Déconnexion réussie</div>";
            header("Location: index.php?action=login");
            exit;
        }

    }

}
