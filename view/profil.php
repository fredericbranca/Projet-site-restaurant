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
    <div class="titre">MON COMPTE</div>
    <div class="link wrap">
        <a href="index.php?action=accueil">Accueil</a>
        <div>></div>
        <div>Compte</div>
    </div>
</div>

<div class="content">
    <div class="menu">
        <a href="index.php?action=profil">Compte</a>
        <a href="index.php?action=profil&page=adresses">Adresses</a>
        <a href="index.php?action=profil&page=messagerie">Messagerie</a>
        <?php
        if ($_SESSION['users']['admin'] = 1) {
        ?>
            <a href="index.php?action=admin">Administration</a>
        <?php
        }
        ?>
        <a href="index.php?action=logout">Déconnexion</a>
    </div>

    <div class="ligne"></div>

    <div class="page">
        <?php
        if (isset($_GET['page']) && $_GET['page'] === "ajouterAdresse") {
            $adresses = $requeteAdresses->fetchAll();
            $nbAdresses = count($adresses);
        ?>

            <div class="sous-titre">Vos adresses (<?= $nbAdresses ?>)</div>
            <form class="ajouterAdresse" method="POST" action="index.php?action=profil" enctype="multipart/form-data">
                <input class="input-adresse" type="text" id="nom" name="nom" maxlength="50" required placeholder="Nom" autocomplete="off">
                <input class="input-adresse" type="text" id="prenom" name="prenom" maxlength="50" required placeholder="Prénom" autocomplete="off">
                <input class="input-adresse" type="text" id="adresse" name="adresse" maxlength="255" required placeholder="Adresse" autocomplete="off">
                <input class="input-adresse" type="text" id="CP" name="CP" required placeholder="Code postale" autocomplete="off">
                <input class="input-adresse" type="text" id="ville" name="ville" maxlength="50" required placeholder="Ville" autocomplete="off">
                <input class="input-adresse" type="text" id="num" name="num" maxlength="10" required placeholder="Numéro de téléphone" autocomplete="off">
                <div class="checkboxDefaut">
                    <input type="checkbox" id="defaut" name="defaut">
                    <label for="defaut">Adresse par défaut</label>
                </div>
                <div class="wrap-ajouter">
                    <button class="bouton btn-ajouter" type="submit" name="ajouter" id="submit">AJOUTER</button>
                    <a href="index.php?action=profil&page=adresses">Annuler</a>
                </div>
            </form>
        <?php
        } elseif (isset($_GET['page']) && $_GET['page'] === 'adresses' && isset($_GET['modifier'])) {
            $adresse = $requeteAdresseWithId->fetch();
        ?>

            <div class="sous-titre">Modifier une adresse</div>
            <form class="ajouterAdresse" method="POST" action="index.php?action=profil&id=<?= $adresse['id_adresse'] ?>" enctype="multipart/form-data">
                <input class="input-adresse" type="text" id="nom" name="nom" maxlength="50" required value="<?= $adresse['nom'] ?>" autocomplete="off">
                <input class="input-adresse" type="text" id="prenom" name="prenom" maxlength="50" required value="<?= $adresse['prenom'] ?>" autocomplete="off">
                <input class="input-adresse" type="text" id="adresse" name="adresse" maxlength="255" required value="<?= $adresse['adresse'] ?>" autocomplete="off">
                <input class="input-adresse" type="text" id="CP" name="CP" required value="<?= $adresse['cp'] ?>" autocomplete="off">
                <input class="input-adresse" type="text" id="ville" name="ville" maxlength="50" required value="<?= $adresse['ville'] ?>" autocomplete="off">
                <input class="input-adresse" type="text" id="num" name="num" maxlength="10" required value="<?= $adresse['telephone'] ?>" autocomplete="off">
                <?php
                if ($adresse['defaut'] == 0) {
                ?>
                    <div class="checkboxDefaut">
                        <input type="checkbox" id="defaut" name="defaut">
                        <label for="defaut">Adresse par défaut</label>
                    </div>
                <?php
                } else {
                ?>
                    <div class="checkboxDefaut">
                        <input type="checkbox" id="defaut" name="defaut" checked>
                        <label for="defaut">Adresse par défaut</label>
                    </div>
                <?php
                }
                ?>
                <div class="wrap-ajouter">
                    <button class="bouton btn-ajouter" type="submit" name="modifier" id="submit">MODIFIER</button>
                    <a href="index.php?action=profil&page=adresses">Annuler</a>
                </div>
            </form>
        <?php
        } elseif (isset($_GET['page']) && $_GET['page'] === 'adresses') {
            $adresses = $requeteAdresses->fetchAll();
            $nbAdresses = count($adresses);
        ?>

            <div class="sous-titre">Vos adresses (<?= $nbAdresses ?>)</div>
            <a class="bouton" href="index.php?action=profil&page=ajouterAdresse"><span>AJOUTEZ UNE NOUVELLE ADRESSE</span></a>
            <?php
            if ($nbAdresses > 0) {
                foreach ($adresses as $adresse) {
            ?>
                    <div class="adresses">
                        <div class="adresse">
                            <div class="text">
                                <?= $adresse['adresse'] ?>
                                <?php
                                if ($adresse['defaut'] == 1) {
                                ?>
                                    (Adresse par défaut)
                                <?php
                                }
                                ?>
                            </div>
                            <a class="bouton" href="index.php?action=profil&page=adresses&modifier=<?= $adresse['id_adresse'] ?>"><span>MODIFIER</span></a>
                            <a class="bouton" href="index.php?action=profil&page=adresses&supprimer=<?= $adresse['id_adresse'] ?>"><span>SUPPRIMER</span></a>
                        </div>
                    </div>
            <?php
                }
            }
            ?>

        <?php
        }
        ?>
    </div>
</div>

<?php

$titre = "Profil";
$titre_secondaire = "Profil";
$style = "profil";
$contenu = ob_get_clean();
require "view/template.php";
