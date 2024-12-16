<?php
include('../includes/function.php');

// Récupération des types depuis la base de données
$request = $bdd->prepare('SELECT * FROM type');
$request->execute();
$types = $request->fetchAll(PDO::FETCH_ASSOC);

// Vérification si le formulaire est soumis
if (isset($_POST['nom'], $_POST['description'], $_POST['type_id'])) {
    $nom = sanitarize($_POST['nom']);
    $description = sanitarize($_POST['description']);
    $type_id = intval($_POST['type_id']); // Conversion sécurisée en entier

    $img = null;

    // Gestion de l'upload d'image
    if (!empty($_FILES['image']['name'])) {
        $imageName = sanitarize($_FILES['image']['name']);
        $imageInfo = pathinfo($imageName);
        $imageExt = strtolower($imageInfo['extension']); // Extension en minuscule

        $authorizedExt = ['png', 'jpeg', 'jpg', 'webp', 'bmp', 'svg'];

        if (in_array($imageExt, $authorizedExt)) {
            $img = time() . rand(1, 1000) . "." . $imageExt;
            $uploadPath = "../../uploads/" . $img;

            if (!move_uploaded_file($_FILES['image']['tmp_name'], $uploadPath)) {
                die('Erreur lors de l\'upload de l\'image.');
            }
        } else {
            die('Extension de fichier non autorisée.');
        }
    }

    // Connexion à la base de données
    $bdd = new PDO('mysql:host=localhost;dbname=magie_academie;charset=utf8', 'root', '');

    // Insertion dans la base de données
    $request = $bdd->prepare('
        INSERT INTO bestiaire (nom, description, id_user, id_type, image_path)
        VALUES (:nom, :description, :id_user, :id_type, :image_path)
    ');

    $request->execute([
        'nom' => $nom,
        'description' => $description,
        'id_user' => $_SESSION['userid'], // Assurez-vous que l'utilisateur est connecté
        'id_type' => $type_id,
        'image_path' => $img,
    ]);

    // Redirection après succès
    header('Location: /projet_academie/index.php?success=7');
    exit;
}
?>

<?php include('../includes/head.php'); ?>
<body>
    <?php include('../includes/nav.php'); ?>
    <section>
        <form action="add_bestiaire.php" method="POST" enctype="multipart/form-data">
            <label for="nom">Nom de la créature</label>
            <input id="nom" type="text" name="nom" required>

            <label for="description">Entrez la description</label>
            <textarea id="description" name="description" required></textarea>

            <label for="type">Sélectionner le type de la créature</label>
            <select id="type" name="type_id" required>
                <?php foreach ($types as $type): ?>
                    <option value="<?php echo htmlspecialchars($type['id']); ?>">
                        <?php echo htmlspecialchars($type['type']); ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label for="image">Choisissez une image</label>
            <input id="image" type="file" name="image">

            <button type="submit">Ajouter</button>
        </form>
    </section>
</body>
</html>
