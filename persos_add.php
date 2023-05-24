<?php require_once('functions.php'); ?>
<?php 
    if (!isset($_SESSION['user'])) {
        header('Location: login.php');
    }
    $bdd = connect();

    $sql = "SELECT * FROM classes";
    $sth = $bdd->prepare($sql);
    $sth->execute();
    $classes = $sth->fetchAll();

    if (isset($_POST["send"])) {
        if ($_POST['name'] != "") {

            $perso = [
                'name'   => $_POST['name'],
                'for'    => 10,
                'vit'    => 10,
                'hp'     => 50,
                'dex'    => 10,
                'int'   => 10,
                'char'    => 10,
                'class'  => $_POST['class'],
            ];

            if ($_POST['class'] == 1) {
                $perso['for'] += 5;
                $perso['hp'] += 7;
            }
    
            if ($_POST['class'] == 2) {
                $perso['vit'] += 10;
                $perso['for'] += 6;
            }
    
            if ($_POST['class'] == 3) {
                $perso['int'] += 5;
                $perso['for'] += 4;
            }

            $bdd = connect();

            $sql = "INSERT INTO persos (`name`, `for`, `dex`, `int`, `char`, `vit`, `hp`, `user_id`, `id_classes`) VALUES (:name, :for, :dex, :int, :char, :vit, :hp, :user_id, :id_classes);";
            echo $sql;
            $sth = $bdd->prepare($sql);

            // dd($perso);
            
            $sth->execute([
                'name'    => $perso['name'],
                'for'     => $perso['for'],
                'dex'     => $perso['dex'],
                'char'    => $perso['char'],
                'int'     => $perso['int'],
                'vit'     => $perso['vit'],
                'hp'     => $perso['hp'],
                'user_id' => $_SESSION['user']['id'],
                'id_classes' => $perso['class']
            ]);


            //header('Location: persos.php');
            header('Location: persos.php');
        }
    }
?>

    <?php require_once('_header.php'); ?>
    <div class="container">

    <h1>Créer un personnage</h1>
    <form action="" method="post">
        <div>
            <label for="name">Nom</label>
            <input type="text" 
            id="name" 
            name="name" 
            placeholder="Entrez votre nom :" 
            required
            />
        </div>

        <div>
            <label for="class">Choissez votre classe :</label>
            <select id="class" name="class">
                <option value="" required>--Choisissez une classe--</option>
                <?php foreach ($classes as $class) : ?>
                    <option value="<?php echo $class['id_classes']; ?>"><?php echo $class['name_classes']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    <div>
        <input class="button" type="submit" name="send" value="Créer"/>
    </div>
    </form>
</div>
</body>
</html>
