<?php

    require_once("functions.php");

    if (!isset($_SESSION['user'])) {
        header('Location: login.php');
    }

    if (!isset($_GET['id'])) {
        header('Location: account.php?msg=id non passé !');
    }

    $bdd = connect();

    if (isset($_POST["send"])) {
        if ($_POST['password'] != "") {

            $sql = "UPDATE users SET `password` = :password WHERE id = :id";
            
            $sth = $bdd->prepare($sql);
        
            $sth->execute([
                'password'  => password_hash($_POST['password'], PASSWORD_DEFAULT),
                'id'        => $_GET['id']
            ]);

            header('Location: account.php');
        }
    }


    $sql="SELECT * FROM users WHERE id = :id ";

    $sth = $bdd->prepare($sql);
        
    $sth->execute([
        'id'          => $_GET['id']
    ]);

    $user = $sth->fetch();
?>

<?php require_once('_header.php'); ?>
<div class="container">
    <h1>Modifier votre mot de passe</h1>
    <form action="" method="post">
        <div>
            <label for="password">Mot de passe: </label>
            <input 
                type="password"
                id="password"
                name="password"
                placeholer="Choisissez votre nouveau mot de passe"
                value="<?php echo $user['password']; ?>"
                required
            />
        </div>
        <div>
            <input 
                type="submit" 
                class="button" 
                name="send" 
                value="Modifier" 
            />
        </div>
    </form>
</div>
</body>
</html>