<?php
session_start();
if (!isset($_SESSION['userid'])) {
    header('Location: /projet_academie/app/auth/login.php?error=1');
    exit;
}

$bdd = new PDO('mysql:host=localhost;dbname=magie_academie;charset=utf8', 'root', '');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = htmlspecialchars($_POST['name']);
    $element = htmlspecialchars($_POST['element']);
    $creator = $_SESSION['userid'];

    if (empty($name) || empty($element) || empty($_FILES['image']['name'])) {
        header('Location: add_sort.php?error=1');
        exit;
    }

    $imagePath = '/projet_academie/uploads/' . basename($_FILES['image']['name']);
    move_uploaded_file($_FILES['image']['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . $imagePath);

    $stmt = $bdd->prepare('INSERT INTO sort (name, element, creator, image_path) VALUES (?, ?, ?, ?)');
    $stmt->execute([$name, $element, $creator, $imagePath]);

    header('Location: /projet_academie/index.php?success=8');
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un Sort</title>
</head>
<body>
    <h1>Ajouter un Sort au Codex</h1>
    <?php if (isset($_GET['error'])): ?>
        <p class="error">Tous les champs sont obligatoires.</p>
    <?php endif; ?>
    <form action="add_sort.php" method="post" enctype="multipart/form-data">
        <label for="name">Nom :</label>
        <input type="text" name="name" id="name" required>
        
        <label for="element">Élément :</label>
        <select name="element" id="element" required>
            <option value="lumière">Lumière</option>
            <option value="eau">Eau</option>
            <option value="air">Air</option>
            <option value="feu">Feu</option>
        </select>
        
        <label for="image">Image :</label>
        <input type="file" name="image" id="image" accept="image/*" required>
        
        <button type="submit">Ajouter</button>
    </form>
</body>
</html>
