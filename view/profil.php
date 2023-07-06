<?php

// vérifie les liens de l'url
if (
    isset($_GET['action']) && $_GET['action'] === 'profil' && isset($_GET['page']) &&
    ($_GET['page'] === 'compte' ||
        $_GET['page'] === 'adresses' ||
        ($_GET['page'] === 'adresses' && isset($_GET['modifier'])) ||
        $_GET['page'] === 'ajouterAdresse' ||
        $_GET['page'] === 'messagerie'
    )
) {

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
            if ($_SESSION['users']['admin'] == 1) {
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

            // Vue ajouter Adresse

            if (isset($_GET['page']) && $_GET['page'] === "ajouterAdresse" && !isset($_GET['modifier']) && !isset($_GET['supprimer'])) {
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
            }

            // Vue modifier adresse

            elseif (isset($_GET['page']) && $_GET['page'] === 'adresses' && isset($_GET['modifier']) && !isset($_GET['supprimer'])) {
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
            }

            // Vue adresses de l'user

            elseif (isset($_GET['page']) && $_GET['page'] === 'adresses') {
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

            // Vue messagerie

            elseif (isset($_GET['page']) && $_GET['page'] === 'messagerie') {
            ?>
                <div>messagerie</div>
            <?php
            }

            // Vue Compte client

            elseif ($_SESSION['users']['admin'] == 0 && isset($_GET['page']) && $_GET['page'] === 'compte') {
                if (!empty($requeteCommande)) {
                    $commandes = $requeteCommande->fetchAll();
                }

            ?>
                <div>Bonjour <?= $_SESSION['users']['nom'] . ' ' . $_SESSION['users']['prenom'] ?> </div>
                <div>Historique de commande</div>
                <?php
                if ($commandes) {
                    foreach ($commandes as $commande) {
                ?>
                        <div><?= $commande['date'] ?></div>
                        <div><?= $commande['prix_total'] ?> €</div>
                    <?php
                    }
                } else {
                    ?>
                    <div>
                        <i class="fa-solid fa-check"></i>
                        <a href="index.php?action=livraison">Passez votre première commande.</a>
                        <div>Vous n'avez pas encore passé de commande</div>
                    </div>
                <?php
                }
                ?>
                <div class="détails">
                    <div>Détails du compte</div>
                    <div class="detailsContent">
                        <div>Utilisateur</div>
                        <div><?= $_SESSION['users']['nom'] . ' ' . $_SESSION['users']['prenom'] ?></div>
                        <div class="ligneDetails"></div>
                    </div>
                    <div class="detailsContent">
                        <div>Email</div>
                        <div><?= $_SESSION['users']['email'] ?></div>
                        <div class="ligneDetails"></div>
                    </div>
                </div>
            <?php
            }

            // Vue Compte admin

            elseif ($_SESSION['users']['admin'] == 1 && isset($_GET['page']) && $_GET['page'] === 'compte') {
            ?>
                <div>Bonjour <?= $_SESSION['users']['nom'] . ' ' . $_SESSION['users']['prenom'] ?> (Administrateur)</div>
                <div>Réservation client</div>
                
        <?php
            }
        } else {
            header("Location: index.php?action=profil&page=compte");
            exit;
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
