<?php
include('../includes/function.php');

// Connexion à la base de données
$bdd = new PDO('mysql:host=localhost;dbname=magie_academie;charset=utf8', 'root', '');

// Récupération des types depuis la base de données
$request = $bdd->prepare('SELECT * FROM element');
$request->execute();
$elements = $request->fetchAll(PDO::FETCH_ASSOC);

// Vérification si le formulaire a été soumis
if (isset($_POST['nom'], $_POST['id_element'])) {
    // Nettoyage des données envoyées par l'utilisateur
    $nom = sanitarize($_POST['nom']);
    $idElement = intval($_POST['id_element']);

    $img = null;

    // Gestion de l'image téléchargée
    if (!empty($_FILES['image']['name'])) {
        $imageName = sanitarize($_FILES['image']['name']);
        $imageInfo = pathinfo($imageName);
        $imageExt = strtolower($imageInfo['extension']);

        $authorizedExt = ['png', 'jpeg', 'jpg', 'webp', 'bmp', 'svg'];

        if (in_array($imageExt, $authorizedExt)) {
            // Générer un nom unique pour l'image
            $img = time() . rand(1, 1000) . "." . $imageExt;
            $uploadPath = "../../uploads/" . $img;

            // Déplacer l'image dans le dossier uploads
            if (!move_uploaded_file($_FILES['image']['tmp_name'], $uploadPath)) {
                die('Erreur lors du téléchargement du fichier.');
            }
        } else {
            die('Extension de fichier non autorisée.');
        }
    }

    // Insertion dans la base de données
    $request = $bdd->prepare('
        INSERT INTO sort (nom, id_element, id_user, image_path)
        VALUE (:nom, :id_element, :id_user, :image_path)
    ');

    $request->execute([
        'nom' => $nom,
        'id_element' => $idElement,
        'id_user' => $_SESSION['userid'],
        'image_path' => $img,
    ]);

    // Redirection après insertion réussie
    header('Location: /projet_academie/index.php?success=8');
    exit;
}
?>

<?php include('../includes/head.php'); ?>
<body>
    <?php include('../includes/nav.php'); ?>

    <section>
        <form action="add_sort.php" method="POST" enctype="multipart/form-data">
            <label for="nom">Nom du sort</label>
            <input id="nom" type="text" name="nom" required>

            <label for="element">Sélectionner l'élément du sort</label>
            <select id="element" name="id_element" required>
                <?php foreach ($elements as $element): ?>
                    <option value="<?php echo htmlspecialchars($element['id']); ?>">
                        <?php echo htmlspecialchars($element['element']); ?>
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
