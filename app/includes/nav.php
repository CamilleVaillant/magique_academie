<nav>
    <ul>
        <li><a href="/projet_academie/index.php">accueil</a></li>
        
        <!-- On affiche differente partie de la navbar en fonction de  utilisateur est connecté ou pas -->
        <?php if(isset($_SESSION['userid'])): ?>
            <li><a href="/projet_academie/app/actions/add.php">ajouter</a></li>
            <li><a href="/projet_academie/app/auth/logout.php">se déconnecter</a></li>
        <?php else: ?>
            <li><a href="/projet_academie/app/auth/login.php">se connecter</a></li>
            <li><a href="/projet_academie/app/auth/subscribe.php">s'inscrire</a></li>
        <?php endif ?>
    </ul>
</nav>