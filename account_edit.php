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
        if ($_POST['email'] != "") {

            $sql = "UPDATE users SET email = :email WHERE id = :id";
            
            $sth = $bdd->prepare($sql);
        
            $sth->execute([
                'email'      => $_POST['email'],
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
    <h1>Modifier votre Email</h1>
    <form action="" method="post">
        <div>
            <label for="email">Email</label>
            <input 
                type="email"
                id="email"
                name="email"
                placeholer="Choisissez votre nouvelle adresse"
                value="<?php echo $user['email']; ?>"
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