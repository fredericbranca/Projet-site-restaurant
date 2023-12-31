<?php

$titre = (isset($titre)) ? $titre : "";
$titre_secondaire = (isset($titre_secondaire)) ? $titre_secondaire : "";

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Script fontawesome -->
    <script src="https://kit.fontawesome.com/de7e6c09fa.js" crossorigin="anonymous"></script>
    <!-- Link CSS -->
    <link rel="stylesheet" href="public/css/style.css">
    <link rel="stylesheet" href="public/css/<?= $style ?>.css">

    <title>
        <?= $titre ?>
    </title>
</head>

<body>
    <header>
        <!-- NAVBAR -->
        <nav>
            <input type="checkbox" id="nav-check">
            <div class="logo-container">
                <a href="index.php?action=accueil"><img class="logo" src="public/img/logo.png"
                        alt="Logo Le Vieux Terroir"></a>
                <a href="index.php?action=accueil">Le Vieux Terroir</a>
            </div>
            <div class="nav-btn">
                <label for="nav-check">
                    <span></span>
                    <span></span>
                    <span></span>
                </label>
            </div>
            <div class="link-container">
                <a href="index.php?action=carte&menus">Carte & Menus</a>
                <a href="index.php?action=reservation">Réserver une table</a>
                <a href="index.php?action=livraison">Livraison</a>
            </div>
            <div class="icon-container">
                <a href="index.php?action=login"><img class="icone" src="public/img/user.png"></a>
                <a href="index.php?action=panier"><img class="icone" src="public/img/panier.png"></a>
            </div>
            <label class="switch">
                <input id="switchMode" type="checkbox" class="checkbox" onclick="toggleLightDarkMode()">
                <span class="slider"></span>
            </label>
        </nav>
    </header>

    <main id="main" data-theme="light">
        <?= $contenu ?>
    </main>

    <!-- FOOTER -->
    <footer>
        <img class="logo" src="public/img/logo.png" alt="lLogo Le Vieux Terroir">
        <p>© 2023 Le Vieux Terroir - Restaurant</p>
        <p>Mentions légales | GPU | Politique de confidentialité | Politique de cookies</p>
    </footer>

    <!-- script -->
    <script type="text/javascript" src="public/js/script.js"></script>
    <?php
    if (isset($script)) {
        ?>
        <script type="text/javascript" src="public/js/<?= $script ?>.js"></script>
        <?php
    }
    ?>


    <?php

    if (isset($_SESSION['alerte'])) {
        ?>
        <?= $_SESSION['alerte'] ?>
        <script>
            tempAlert(3000, 'alert');
        </script>
        <?php
        unset($_SESSION['alerte']);
    }

    ?>

</body>

</html>