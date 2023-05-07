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
                <td class="stats">Action</td>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($persos as $perso) { ?>
                <tr>
                    <td class="id"><?php echo $perso['id']; ?></td>
                    <td class="stats"><?php echo $perso['name']; ?></td>
                    <td>
                        <a href="persos_choice.php?id=<?php echo $perso['id']; ?>" class="btn-det">Choisir</a>
                        <a href="persos_show.php?id=<?php echo $perso['id']; ?>" class="btn-det">Détails</a>
                        <a href="persos_edit.php?id=<?php echo $perso['id']; ?>" class="btn-modif">Modifier</a>
                        <a href="persos_del.php?id=<?php echo $perso['id']; ?>" onClick="return confirm('Voulez vous vraiment supprimer ce personnage ?');" class="btn-supp">Supprimer</a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table><br><br>
    <a href="persos_add.php" class="new">Créer un nouveau personnage</a>
    </div>
</body>
</html>
