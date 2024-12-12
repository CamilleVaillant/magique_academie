<?php
session_start();

// Connexion à la base de données
$bdd = new PDO('mysql:host=localhost;dbname=magie_academie;charset=utf8', 'root', '');

// Fonction pour afficher les messages de succès ou d'erreur
function displayMessage() {
    if (isset($_GET['error'])) {
        switch ($_GET['error']) {
            case 1: return "<p class='error'>Les champs sont obligatoires.</p>";
            case 2: return "<p class='error'>Nom d'utilisateur ou mot de passe incorrect.</p>";
            default: return "<p class='error'>Erreur inconnue.</p>";
        }
    }
    if (isset($_GET['success'])) {
        switch ($_GET['success']) {
            case 4: return "<p class='success'>Inscription réussie !</p>";
            case 5: return "<p class='success'>Connexion réussie !</p>";
            case 6: return "<p class='success'>Déconnexion réussie !</p>";
            case 7: return "<p class='success'>Créature ajoutée au bestiaire !</p>";
            case 8: return "<p class='success'>Sort ajouté au codex !</p>";
        }
    }
    return "";
}

// Récupération du bestiaire et des sorts depuis la base de données
$bestiaire = $bdd->query('SELECT * FROM bestiaire')->fetchAll(PDO::FETCH_ASSOC);
$sort = $bdd->query('SELECT * FROM sort')->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/projet_academie/assets/css/style.css">
    <title>Magique Académie</title>
</head>
<body>
    <nav>
        <ul>
            <li><a href="/projet_academie/index.php">Accueil</a></li>
            <?php if (isset($_SESSION['userid'])): ?>
                <li><a href="/projet_academie/app/actions/add_bestiaire.php">Ajouter au Bestiaire</a></li>
                <li><a href="/projet_academie/app/actions/add_sort.php">Ajouter un Sort</a></li>
                <li><a href="/projet_academie/app/auth/logout.php">Se déconnecter</a></li>
            <?php else: ?>
                <li><a href="/projet_academie/app/auth/login.php">Se connecter</a></li>
                <li><a href="/projet_academie/app/auth/subscribe.php">S'inscrire</a></li>
            <?php endif; ?>
        </ul>
    </nav>

    <div class="container">
        <h1>Bienvenue à la Magique Académie</h1>
        <?php echo displayMessage(); ?>

        <section>
            <h2>Bestiaire</h2>
            <?php if (count($bestiaire) > 0): ?>
                <ul>
                    <?php foreach ($bestiaire as $creature): ?>
                        <li>
                            <img src="<?php echo htmlspecialchars($creature['image_path']); ?>" alt="<?php echo htmlspecialchars($creature['name']); ?>" style="max-width: 150px;">
                            <strong><?php echo htmlspecialchars($creature['name']); ?></strong> - <?php echo htmlspecialchars($creature['type']); ?>
                            <p><?php echo htmlspecialchars($creature['description']); ?></p>
                            <em>Ajouté par : <?php echo htmlspecialchars($creature['creator']); ?></em>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p>Aucun élément enregistré dans le bestiaire pour le moment.</p>
            <?php endif; ?>
        </section>

        <section>
            <h2>Codex des sorts</h2>
            <?php if (count($sort) > 0): ?>
                <ul>
                    <?php foreach ($sort as $spell): ?>
                        <li>
                            <img src="<?php echo htmlspecialchars($spell['image_path']); ?>" alt="<?php echo htmlspecialchars($spell['name']); ?>" style="max-width: 150px;">
                            <strong><?php echo htmlspecialchars($spell['name']); ?></strong> - <?php echo htmlspecialchars($spell['element']); ?>
                            <em>Ajouté par : <?php echo htmlspecialchars($spell['creator']); ?></em>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p>Aucun sort enregistré pour le moment.</p>
            <?php endif; ?>
        </section>

        <?php if (isset($_SESSION['userid'])): ?>
            <p><a href="/projet_academie/app/actions/add_bestiaire.php">Ajouter une créature au bestiaire</a></p>
            <p><a href="/projet_academie/app/actions/add_sort.php">Ajouter un sort au codex</a></p>
        <?php else: ?>
            <p><a href="/projet_academie/app/auth/login.php">Connectez-vous</a> pour ajouter des contenus.</p>
        <?php endif; ?>
    </div>
</body>
</html>
