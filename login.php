<?php

    require_once('functions.php');

    if (isset($_POST["send"])) {
        $bdd = connect();
        $sql = "SELECT * FROM users WHERE `email` = :email;";
        
        $sth = $bdd->prepare($sql);
        
        $sth->execute([
            'email'     => $_POST['email']
        ]);

        $user = $sth->fetch();
        
        if ($user && password_verify($_POST['password'], $user['password']) ) {
            // dd($user);
            $_SESSION['user'] = $user;
            header('Location: persos.php');
        } else {
            $msg = "Email ou mot de passe incorrect !";
        }
    }
?>
    <?php require_once('_header.php'); ?>
    <div class="container">
    <h1>Connexion</h1>
    <form action="" method="post">

        <?php if (isset($msg)) { echo "<div>" . $msg . "</div>"; } ?>

        <div>
            <label for="email">Email: </label>
            <input 
                type="email" 
                placeholder="Entrez votre email" 
                name="email" 
                id="email" 
                required
            />
        </div>
        <div>
            <label for="password">Mot de passe: </label>
            <input 
                type="password" 
                placeholder="Entrez votre mot de passe" 
                name="password" 
                id="password"
                required
            />
        </div>
        <div>
            <input class="button" type="submit" name="send" value="Connexion" />
        </div>
    </form>
    </div>
</div>
</body>
</html>