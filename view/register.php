<?php

if (isset($_SESSION['user'])) {
    header("Location: index.php?action=profil");
    exit;
}

ob_start();

if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    unset($_SESSION['message']);
} else {
    $message = "";
}

?>

<div class="column header-link">
    <div class="titre">INSCRIPTION</div>
    <div class="link wrap">
        <a href="index.php?action=accueil">Accueil</a>
        <div>></div>
        <div>Inscription</div>
    </div>
</div>

<div class="content">
    <div class="sous-titre">
        <div>INSCRIPTION</div>
    </div>

    <form class="champs" method="POST" action="index.php?action=register" enctype="multipart/form-data">
        <?= $message ?>
        <input class="input-register" type="text" id="nom" name="nom" maxlength="50" required placeholder="Nom" autocomplete="off">
        <input class="input-register" type="text" id="prenom" name="prenom" maxlength="50" required placeholder="Prénom" autocomplete="off">
        <input class="input-register" type="email" id="email" name="email" maxlength="80" required placeholder="Email" autocomplete="off">
        <input class="input-register" type="password" id="password" name="password" maxlength="25" required placeholder="Mot de passe" autocomplete="off">
        <input class="input-register" type="password" id="confirm-password" maxlength="25" name="confirm-password" required placeholder="Confirmation du mot de passe" autocomplete="off">
        <div class="text">Inscrivez-vous pour recevoir des codes de réduction. Pour vous désinscrire, cliquez sur le bouton "se désinscrire" dans nos courriels.</div>
        <button class="bouton btn-register" type="submit" name="submit" id="submit">INSCRIPTION</button>
        <a class="bouton btn-login" href="index.php?action=login">CONNEXION</a>
    </form>
</div>
<?php

$titre = "Inscription";
$titre_secondaire = "Inscription";
$style = "register";
$contenu = ob_get_clean();
require "view/template.php";
