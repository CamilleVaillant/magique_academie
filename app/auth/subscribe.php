<?php
include('../includes/function.php');

if($_SERVER['REQUEST_METHOD']==='POST'){
    $nom = sanitarize($_POST['nom']);
    $password = htmlspecialchars($_POST['password']);
    $passwordConfirm = htmlspecialchars($_POST['passwordConfirm']);

    $request = $bdd->prepare('   SELECT COUNT(*) as usernb
                                 FROM user
                                 WHERE nom =  ? '
    );

    $request->execute(array($nom));

    $data = $request->fetch();

    if($data['usernb'] >= 1){
        header('location:subscrib.php?error=2');
    }else{

        if($password == $passwordConfirm){
            $passwordCrypt = password_hash($password,PASSWORD_BCRYPT);

            $request = $bdd->prepare('INSERT INTO user (nom,password)
            VALUE (:nom,:password)'
        );

            $request->execute(array(
            'nom' => $nom,
            'password' => $passwordCrypt,
            ));

            header('location:/projet_academie/index.php?success=4');
        }else{
            header('location:subscribe.php?error=1');
        }
    }
}

?>










<?php include('../includes/head.php'); ?>
<body>
    <?php include ('../includes/nav.php'); ?>
    <h1>Inscription</h1>

    <?php if(isset($_GET['error'])){ ?>
        <?php switch($__GET['error']){
            case 1:
                echo "<p class='error'>Vos mots de passe ne correspondent pas</p>";
                break;
            case 2:
                echo "<p class='error'>Ce nom d'utilisateur existe déjà</p>";
                break;
        }

    } ?>

<form action="subscribe.php" method="post">
        <label for="nom">Votre nom d'utilisateur</label>
        <input type="text" name="nom" id="nom">
        <label for="password">Votre mot de passe</label>
        <input type="password" name="password" id="password">
        <label for="passwordConfirm">Confirmez votre mot de passe</label>
        <input type="password" name="passwordConfirm" id="passwordConfirm">
        <button>s'inscrire</button>
    </form>
</body>
</html>
    