<?php 

    require_once('./classes/Gobelin.php');
    require_once('./classes/Darkknight.php');

    require_once('functions.php');
 
    if (!isset($_SESSION['user'])) {
        header('Location: login.php');
    }

    if (!isset($_SESSION['perso'])){
        header('Location: persos.php');
    }

    if(!isset($_SESSION['fight']))
    {
        $nb = random_int(0,10);

        if($nb <= 6) {
            $ennemi = new Gobelin();
        } else {
            $ennemi = new DarkKnight();
        }

        $_SESSION['fight']['ennemi'] = $ennemi;
        $_SESSION['fight']['html'][] = "Vous tombez sur un ". $ennemi->name . '.';
    }

    if ($_SESSION['fight']['ennemi']->speed > $_SESSION['perso']['vit']) {
        $_SESSION['fight']['html'][] = $ennemi->name . ' tape en premier';
        
        $touche = random_int(0, 20);
        $_SESSION['fight']['html'][] = $touche;

        if ($touche >= 10) {
            $_SESSION['fight']['html'][] = "Il vous touche.";
            $degat = random_int(0, $_SESSION['fight']['ennemi']->power) + floor($_SESSION['fight']['ennemi']->power/3);
            $_SESSION['fight']['html'][] = "Il vous inflige " . ($degat - floor($_SESSION['perso']['for']/3)) . " dégats";
            $_SESSION['perso']['hp'] -=  $degat - floor($_SESSION['perso']['for']/3);
        } else {
            $_SESSION['fight']['html'][] = "Il vous rate.";
        }

        if ($_SESSION['perso']['hp'] <= 0) {
            $_SESSION['fight']['html'][] = "Vous etes mort.";
        } else {
            $_SESSION['fight']['html'][] = "Vous attaquez";

            $touche = random_int(0, 20);
            $_SESSION['fight']['html'][] = $touche;

            if ($touche >= 10) {
                $_SESSION['fight']['html'][] = "Vous touchez votre ennmi.";
                $degat = random_int(0,10) + floor($_SESSION['perso']['for']/3);
                
                $_SESSION['fight']['html'][] = "Vous lui infligez " . ($degat - floor($_SESSION['fight']['ennemi']->constitution/3)) . " dégats";
                $_SESSION['fight']['ennemi']->hp -=  $degat - floor($_SESSION['fight']['ennemi']->constitution/3);

                if ($_SESSION['fight']['ennemi']->hp <= 0) {
                    $_SESSION['perso']['gold'] += $_SESSION['fight']['ennemi']->gold;
                    $_SESSION['fight']['html'][] = "Vous gagnez " . $_SESSION['fight']['ennemi']->gold . " Or";
                    $_SESSION['fight']['html'][] = "Vous avez tuez votre ennemi.";
                }
            } else {
                $_SESSION['fight']['html'][] = "Vous ratez votre ennmi.";
            }
        }

    } else {
        $_SESSION['fight']['html'][] = $_SESSION['perso']['name'] . ' tape en premier';
    
        $touche = random_int(0, 20);
        $_SESSION['fight']['html'][] = $touche;

        if ($touche >= 10) {
            $_SESSION['fight']['html'][] = "Vous touchez votre ennmi.";
            $degat = random_int(0,10) + floor($_SESSION['perso']['for']/3);
            $_SESSION['fight']['html'][] = "Il vous inflige " . ($degat - floor($_SESSION['fight']['ennemi']->constitution/3)) . " dégats";
            $_SESSION['fight']['ennemi']->hp -=  $degat - floor($_SESSION['fight']['ennemi']->constitution/3);

            if ($_SESSION['fight']['ennemi']->hp <= 0) {
                $_SESSION['perso']['gold'] += $_SESSION['fight']['ennemi']->gold;
                $_SESSION['fight']['html'][] = "Vous gagnez " . $_SESSION['fight']['ennemi']->gold . " Or";
                $_SESSION['fight']['html'][] = "Vous avez tuez votre ennemi.";
            } else {
                $_SESSION['fight']['html'][] = "Votre ennemi attaque";
                $touche = random_int(0, 20);
                $_SESSION['fight']['html'][] = $touche;

                if ($touche >= 10) {
                    $_SESSION['fight']['html'][] = "Il vous touche.";
                    $degat = random_int(0,$_SESSION['fight']['ennemi']->power) + floor($_SESSION['fight']['ennemi']->power/3);
                    $_SESSION['fight']['html'][] = "Il vous inflige " . ($degat - floor($_SESSION['perso']['for']/3)) . " dégats";
                    $_SESSION['perso']['hp'] -=  $degat - floor($_SESSION['perso']['for']/3);
                } else {
                    $_SESSION['fight']['html'][] = "Il vous rate votre ennmi.";
                }
            }
        } else {
            $_SESSION['fight']['html'][] = "Vous ratez votre ennmi.";

            // Attaque de l'ennemi
            $_SESSION['fight']['html'][] = "Votre ennemi attaque";
            $touche = random_int(0, 20);
            $_SESSION['fight']['html'][] = $touche;

            if ($touche >= 10) {
                $_SESSION['fight']['html'][] = "Il vous touche.";
                $degat = random_int(0,$_SESSION['fight']['ennemi']->power) + floor($_SESSION['fight']['ennemi']->power/3);
                $_SESSION['fight']['html'][] = "Il vous inflige " . ($degat - floor($_SESSION['perso']['for']/3)) . " dégats";
                $_SESSION['perso']['hp'] -=  $degat - floor($_SESSION['perso']['for']/3);
            
                if ($_SESSION['perso']['hp'] <= 0) {
                    $_SESSION['fight']['html'][] = "Vous etes mort.";
                }
            } else {
                $_SESSION['fight']['html'][] = "Il vous rate votre ennmi.";
            }
        }
    }

    $bdd = connect();
    $sql = "UPDATE persos SET `gold` = :gold, `hp` = :hp WHERE id = :id AND user_id = :user_id;";    
    $sth = $bdd->prepare($sql);

    $sth->execute([
        'gold'      => $_SESSION['perso']['gold'],
        'hp'       => $_SESSION['perso']['hp'],
        'id'        => $_SESSION['perso']['id'],
        'user_id'   => $_SESSION['user']['id']
    ]);

    // dd($_SESSION);

    /*if ($_SESSION['perso']['hp'] <= 0) {
        unset($_SESSION['perso']);
        unset($_SESSION['fight']);
        header('Location: persos.php');

    }*/

    require_once('_header.php');
?>
    <div class="container">
        <div class="row mt-4">
            <div class="px-4">
                <?php require_once('_perso.php'); ?>
            </div>
            <div class="room">
                <h1>Combat</h1>
                <?php

                    foreach($_SESSION['fight']['html'] as $html){
                        echo '<p>'.$html.'</p>';
                    }

                ?>
                
                <?php if ($_SESSION['fight']['ennemi']->hp > 0) { ?>
                <p class= 'new'><a href="donjon_fight.php?id=<?php echo $_GET['id']; ?>">
                Attaquer
                </a></p>
                <p class= 'new'><a href="donjon_play.php?id=<?php echo $_GET['id']; ?>">
                Fuir
                </a></p>

                <?php } else { ?>
                    <p class="new"><a href="donjon_play.php?id=<?php echo $_GET['id']; ?>">
                        Continuer l'exploration
                    </a></p>
                <?php } ?>

            </div>
            <div class="px-4">
                <?php require_once('_ennemi.php'); ?>
            </div>
        </div>
    </div>
    </body>
</html>