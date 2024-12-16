<?php include('app/includes/head.php'); ?>

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
            case 9: return "<p class='success'>Créature suprimée !</p>";
        }
    }
    return "";
}

// Récupération des créatures du bestiaire
$bestiaireRequest = $bdd->query(
    'SELECT bestiaire.*, type.type AS type 
     FROM bestiaire
     LEFT JOIN type ON bestiaire.id_type = type.id'
)->fetchAll(PDO::FETCH_ASSOC);

// Récupération des sorts
$sortRequest = $bdd->query('
    SELECT sort.*, element.element AS element
    FROM sort
    LEFT JOIN element ON sort.id_element = element.id
')->fetchAll(PDO::FETCH_ASSOC);
?>


<body>
    <nav>
        <ul>
            <li><a href="/projet_academie/index.php">Accueil</a></li>
            <?php if (isset($_SESSION['userid'])): ?>
                <li><a href="/projet_academie/app/action/add_bestiaire.php">Ajouter au Bestiaire</a></li>
                <li><a href="/projet_academie/app/action/add_sort.php">Ajouter un Sort</a></li>
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

        <section class="bestiaire">
            <h2>Bestiaire</h2>
            <?php if (!empty($bestiaireRequest)): ?>
                <ul>
                    <?php foreach ($bestiaireRequest as $creature): ?>
                        <li class="creature">
                            <?php if ($creature['image_path']): ?>
                                <img src="uploads/bestiaire/<?php echo htmlspecialchars($creature['image_path']); ?>" alt="<?php echo htmlspecialchars($creature['nom']); ?>" style="max-width: 150px;">
                            <?php else: ?>
                                <img src="uploads/noimage.png" alt="Image par défaut" style="max-width: 150px;">
                            <?php endif; ?>
                            <strong><?php echo htmlspecialchars($creature['nom']); ?></strong> - <?php echo htmlspecialchars($creature['type']); ?>
                            <p><?php echo htmlspecialchars($creature['description']); ?></p>
                            <p><a href="app/action/change_bestiaire.php">Modifier</a></p>
                            <form action="app/action/delete_bestiaire.php" method="get">
                                <input type="hidden" name="id" value="1">
                                <button type="submit">Supprimer</button>
                            </form>

                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p>Aucune créature trouvée dans le bestiaire.</p>
            <?php endif; ?>
        </section>

        <section class="sort">
            <h2>Codex des sorts</h2>
            <?php if (!empty($sortRequest)): ?>
                <ul>
                    <?php foreach ($sortRequest as $sortilege): ?>
                        <li>
                            <?php if ($sortilege['image_path']): ?>
                                <img src="uploads/sort/<?php echo htmlspecialchars($sortilege['image_path']); ?>" alt="<?php echo htmlspecialchars($sortilege['nom']); ?>" style="max-width: 150px;">
                            <?php else: ?>
                                <img src="uploads/noimage.png" alt="Image par défaut" style="max-width: 150px;">
                            <?php endif; ?>
                            <strong><?php echo htmlspecialchars($sortilege['nom']); ?></strong> - <?php echo htmlspecialchars($sortilege['element']); ?>
                            <p><a href="app/action/change_sort.php">Modifier</a></p>
                            <p><a href="app/action/delete_sort.php?id=1">Suprimer</a></p>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p>Aucun sort enregistré pour le moment.</p>
            <?php endif; ?>
        </section>

        <?php if (isset($_SESSION['userid'])): ?>
            <p><a href="/projet_academie/app/action/add_bestiaire.php">Ajouter une créature au bestiaire</a></p>
            <p><a href="/projet_academie/app/action/add_sort.php">Ajouter un sort au codex</a></p>
        <?php else: ?>
            <p><a href="/projet_academie/app/auth/login.php">Connectez-vous</a> pour ajouter des contenus.</p>
        <?php endif; ?>
    </div>

</body>
</html>
