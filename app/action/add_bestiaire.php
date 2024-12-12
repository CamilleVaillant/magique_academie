<?php
session_start();
if (!isset($_SESSION['userid'])) {
    header('Location: /projet_academie/app/auth/login.php?error=1');
    exit;
}

$bdd = new PDO('mysql:host=localhost;dbname=magie_academie;charset=utf8', 'root', '');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = htmlspecialchars($_POST['name']);
    $description = htmlspecialchars($_POST['description']);
    $type = htmlspecialchars($_POST['type']);
    $creator = $_SESSION['userid'];

    if (empty($name) || empty($description) || empty($type) || empty($_FILES['image']['name'])) {
        header('Location: add_bestiaire.php?error=1');
        exit;
    }

    $imagePath = '/projet_academie/uploads/' . basename($_FILES['image']['name']);
    move_uploaded_file($_FILES['image']['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . $imagePath);

    $stmt = $bdd->prepare('INSERT INTO bestiaire (name, description, type, creator, image_path) VALUES (?, ?, ?, ?, ?)');
    $stmt->execute([$name, $description, $type, $creator, $imagePath]);

    header('Location: /projet_academie/index.php?success=7');
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter au Bestiaire</title>
</head>
<body>
    <h1>Ajouter une créature au Bestiaire</h1>
    <?php if (isset($_GET['error'])): ?>
        <p class="error">Tous les champs sont obligatoires.</p>
    <?php endif; ?>
    <form action="add_bestiaire.php" method="post" enctype="multipart/form-data">
        <label for="name">Nom :</label>
        <input type="text" name="name" id="name" required>
        
        <label for="description">Description :</label>
        <textarea name="description" id="description" required></textarea>
        
        <label for="type">Type :</label>
        <select name="type" id="type" required>
            <option value="aquatique">Aquatique</option>
            <option value="démoniaque">Démoniaque</option>
            <option value="mort-vivante">Mort-vivante</option>
            <option value="mi-bête">Mi-bête</option>
        </select>
        
        <label for="image">Image :</label>
        <input type="file" name="image" id="image" accept="image/*" required>
        
        <button type="submit">Ajouter</button>
    </form>
</body>
</html>
