<?php
session_start();
require '../classes/Post.php';
require '../db/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);
    $ipAddress = $_SERVER['REMOTE_ADDR'];

    if (empty($title) || empty($content)) {
        $_SESSION['error'] = "Pavadinimas ir turinys negali būti tušti.";
        header("Location: create_post.php");
        exit();
    }

    $post = new Post($db);
    $success = $post->createPost($_SESSION['user_id'], $title, $content, $ipAddress);

    if ($success) {
        $_SESSION['message'] = "Įrašas sėkmingai sukurtas!";
        header("Location: view_posts.php");
        exit();
    } else {
        $_SESSION['error'] = "Klaida kuriant įrašą.";
        header("Location: create_post.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sukurti naują įrašą</title>
</head>
<body>
    <h1>Sukurti naują įrašą</h1>
    <?php if (isset($_SESSION['error'])): ?>
        <p style="color: red;"><?= $_SESSION['error'] ?></p>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>
    <form method="POST">
        <label for="title">Pavadinimas:</label>
        <input type="text" id="title" name="title" required><br>
        
        <label for="content">Turinys:</label>
        <textarea id="content" name="content" required></textarea><br>
        
        <button type="submit">Sukurti</button>
    </form>
    <p><a href="view_posts.php">Peržiūrėti įrašus</a></p>
</body>
</html>