<?php require_once('functions.php'); ?>
<?php 
    if (!isset($_SESSION['user'])) {
        header('Location: login.php');
    }

    $bdd = connect();

    $sql = "SELECT * FROM persos WHERE user_id = :user_id";

    $sth = $bdd->prepare($sql);
        
    $sth->execute([
        'user_id'     => $_SESSION['user']['id']
    ]);

    $persos = $sth->fetchAll();

    //dd($persos);

?>

<?php require_once('_header.php'); ?>

    <div class="container">
    <h1>Vos Personnages: <?php echo $_SESSION['user']['email']; ?> </h1>

    <?php if (isset($_GET['msg'])) {
        echo "<div>" . $_GET['msg'] . "</div>";
    }?>


    <table class="table">
        <thead>
            <tr>
                <td class="id">ID</td>
                <td class="stats">Nom</td>
                <td class="stats">Point de vie</td>
                <td class="stats">Or</td>
                <td class="stats">Force</td>
                <td class="stats">Dextérité</td>
                <td class="stats">Intelligence</td>
                <td class="stats">Charisme</td>
                <td class="stats">Vitesse</td>
                <td class="stats">Action</td>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($persos as $perso) { ?>
                <tr>
                    <td class="id"><?php echo $perso['id']; ?></td>
                    <td class="stats"><?php echo $perso['name']; ?></td>
                    <td class="stats"><?php echo $perso['hp']; ?></td>
                    <td class="stats"><?php echo $perso['gold']; ?></td>
                    <td class="stats"><?php echo $perso['for']; ?></td>
                    <td class="stats"><?php echo $perso['dex']; ?></td>
                    <td class="stats"><?php echo $perso['int']; ?></td>
                    <td class="stats"><?php echo $perso['char']; ?></td>
                    <td class="stats"><?php echo $perso['vit']; ?></td>
                    <td align="right">
                        <?php if ($perso['hp'] > 0) { ?>
                            <a 
                                class="btn-det"
                                href="persos_choice.php?id=<?php echo $perso['id']; ?>" 
                            >Choisir</a>
                        <?php } else { ?>
                            <a 
                                class="btn-det"
                                href="persos_respawn.php?id=<?php echo $perso['id']; ?>" 
                            >Résussiter</a>
                        <?php } ?>

                        <a 
                            class="btn-det"
                            href="persos_show.php?id=<?php echo $perso['id']; ?>" 
                        >Détails</a>

                        <a 
                            class="btn-modif"
                            href="persos_edit.php?id=<?php echo $perso['id']; ?>" 
                        >Modifier</a>

                        <a 
                            class="btn-supp"
                            href="persos_del.php?id=<?php echo $perso['id']; ?>" 
                            onClick="return confirm('Etes-vous sûr ?');"
                        >Supprimer</a>
                </tr>
            <?php } ?>
        </tbody>
    </table><br><br>
    <a href="persos_add.php" class="new">Créer un nouveau personnage</a>
    </div>
</body>
</html>
