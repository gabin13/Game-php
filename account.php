<?php require_once('functions.php'); ?>
<?php 
    if (!isset($_SESSION['user'])) {
        header('Location: login.php');
    }

    $bdd = connect();

    $sql = "SELECT * FROM users WHERE id = :user_id";

    $sth = $bdd->prepare($sql);
        
    $sth->execute([
        'user_id'     => $_SESSION['user']['id']
    ]);

    $user = $sth->fetch();

?>

<?php require_once('_header.php'); ?>
<div class="container">
    <h1>Votre compte: </h1>

    <?php if (isset($_GET['msg'])) {
        echo "<div>" . $_GET['msg'] . "</div>";
    }?>


    <table class="table">
        <thead>
            <tr class="account">
                <td class="id">ID</td>
                <td class="stats">Email</td>
                <td class="stats">Actions</td>
            </tr>
        </thead>
        <tbody>
        
            
                <tr class="account">
                    <td class="id"><?php echo $user['id']; ?></td>
                    <td class="stats"><?php echo $user['email']; ?></td>
                    <td>
                        <a href="account_edit.php?id=<?php echo $user['id']; ?>" class="btn-modif">Modifier l'email</a>
                        <a href="account_edit2.php?id=<?php echo $user['id']; ?>" class="btn-modif2">Modifier le mot de passe</a>
                        <a href="account_del.php?id=<?php echo $user['id']; ?>" onClick="return confirm('Voulez vous vraiment supprimer ce compte ?');" class="btn-supp">Supprimer</a>
                    </td>
                </tr>
    
    
        </tbody>
    </table><br><br>
</div>
</body>
</html>