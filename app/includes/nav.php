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