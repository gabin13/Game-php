<?php require_once('functions.php'); ?>

<?php 
    if (!isset($_SESSION['user'])) {
        header('Location: login.php');
    }

    if(!isset($_GET['id'])){
        header('Location: persos.php?msg=id non passé !');
    }

    $bdd = connect();

    $sql="SELECT * FROM persos WHERE id= :id AND user_id= :user_id;";

    $sth = $bdd->prepare($sql);
        
    $sth->execute([
        'id'          => $_GET['id'],
        'user_id'     => $_SESSION['user']['id']
    ]);

    $perso = $sth->fetch();
?>

    <?php require_once('_header.php'); ?>
    <div class="container">
    <h1>Votre Personnage</h1>

    <b>Nom:</b> <?php echo $perso['name']; ?><br>
    <b>Force:</b> <?php echo $perso['for']; ?><br>
    <b>Vitesse:</b> <?php echo $perso['vit']; ?><br>
    <b>Intelligence:</b> <?php echo $perso['int']; ?><br>
    <b>Points de vie:</b> <?php echo $perso['hp']; ?><br>
    <b>Dextérité:</b> <?php echo $perso['dex']; ?><br>
    <b>Charisme:</b> <?php echo $perso['char']; ?><br>  

    <div>
    <a href="persos.php" class="lien">Retour</a>
    </div>
</div>
</body>
</html>
