<?php

ob_start();

if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    unset($_SESSION['message']);
} else {
    $message = "";
}

?>

<div class="column header-link">
    <div class="titre">CONNEXION</div>
    <div class="link wrap">
        <a href="index.php?action=accueil">Accueil</a>
        <div>></div>
        <div>Connexion</div>
    </div>
</div>

<section class="content">
    <form class="login" method="POST" action="index.php?action=login" enctype="multipart/form-data">
        <?= $message ?>
        <div class="sous-titre">CONNEXION</div>
        <input class="input-login" type="text" id="email" name="email" maxlength="80" required placeholder="Email" autocomplete="off">
        <input class="input-login" type="password" id="password" name="password" maxlength="255" required placeholder="Mot de passe" autocomplete="off">
        <a href="#">Mot de passe oublié ?</a>
        <button class="bouton btn-login" type="submit" name="submit" id="submit">CONNEXION</button>
    </form>
    <div class="register">
        <div class="sous-titre">NOUVEL UTILISATEUR</div>
        <div class="text">Inscrivez-vous pour recevoir des codes de réduction. Pour vous désinscrire, cliquez sur le bouton "se désinscrire" dans nos courriels.</div>
        <a class="bouton btn-register" href="index.php?action=register"><span>INSCRIPTION</span></a>
    </div>
</section>

<?php

$titre = "Connexion";
$titre_secondaire = "Connexion";
$style = "login";
$contenu = ob_get_clean();
require "view/template.php";
