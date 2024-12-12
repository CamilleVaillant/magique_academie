<?php
    include('../includes/function.php');

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $nom = $_POST['nom'];
        $password = $_POST['password']; // Correction de la variable ici

        // Préparer la requête pour vérifier l'utilisateur
        $request = $bdd->prepare('SELECT * FROM user WHERE nom = :nom');
        $request->execute(array('nom' => $nom));

        $data = $request->fetch();

        // Vérification du mot de passe
        if (password_verify($password, $data['password'])) {
            // Si le mot de passe est correct, on crée la session
            $_SESSION['userid'] = $data['id'];
            header('Location: /projet_academie/index.php?success=5');
            exit();
        } else {
            // Si le mot de passe est incorrect
            header('Location: login.php?error=1');
            exit();
        }
    }
?>

<?php include('../includes/head.php'); ?>

<body>

    <?php include('../includes/nav.php'); ?>
    <h1>Connexion</h1>
    <?php if (isset($_GET['error'])): ?>
        <p class="error">Nom d'utilisateur ou mot de passe incorrect</p>
    <?php endif; ?>
    
    <form action="login.php" method="post">
        <label for="nom">Votre nom d'utilisateur</label>
        <input type="text" name="nom" id="nom" value="<?php echo isset($_POST['nom']) ? htmlspecialchars($_POST['nom']) : ''; ?>">
        
        <label for="password">Votre mot de passe</label>
        <input type="password" name="password" id="password">
        
        <button type="submit">Se connecter</button>
    </form>

</body>
</html>
