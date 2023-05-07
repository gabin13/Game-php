<ul id="nav">
        <?php if (!isset($_SESSION['user'])){ ?>
            <li><a href="register.php">Créer un compte</a></li>
            <li><a href="login.php">Connexion</a></li>
        <?php } else { ?>
            <li><a href="account.php">Mon Compte</a></li>
            <li><a href="persos.php">Mes Personnages</a></li>
            <li><a href="logout.php">Logout</a></li>
        <?php } ?>
</ul>