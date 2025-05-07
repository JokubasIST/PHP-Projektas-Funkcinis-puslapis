<?php
session_start();
require '../classes/User.php';
require '../db/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (empty($_POST['new_password'])) {
        $_SESSION['error'] = "Slaptažodis negali būti tuščias.";
        header("Location: change_password.php");
        exit();
    }
    
    $user = new User($db);
    $success = $user->changePassword($_SESSION['user_id'], $_POST['new_password']);

    if ($success) {
        $_SESSION['message'] = "Slaptažodis pakeistas sėkmingai.";
        header("Location: index.php");
        exit();
    } else {
        $_SESSION['error'] = "Klaida keičiant slaptažodį.";
        header("Location: change_password.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Keisti slaptažodį</title>
</head>
<body>
    <h1>Keisti slaptažodį</h1>
    <?php if (isset($_SESSION['error'])): ?>
        <p style="color: red;"><?= $_SESSION['error'] ?></p>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>
    <form method="POST">
        <label for="new_password">Naujas slaptažodis:</label>
        <input type="password" id="new_password" name="new_password" required>
        <button type="submit">Keisti slaptažodį</button>
    </form>
    <p><a href="index.php">Grįžti atgal</a></p>
</body>
</html>