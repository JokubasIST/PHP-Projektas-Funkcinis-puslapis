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
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Keisti slaptažodį</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        .password-container {
            max-width: 500px;
            margin: 0 auto;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            margin-top: 5rem;
            background: white;
        }
        body {
            background-color: #f8f9fa;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php">PHP Projektas</a>
            <div class="navbar-nav ms-auto">
                <a href="index.php" class="btn btn-outline-light"><i class="bi bi-house"></i> Pagrindinis</a>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="password-container">
            <h1 class="text-center mb-4"><i class="bi bi-key"></i> Keisti slaptažodį</h1>
            
            <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show">
                <?= $_SESSION['error'] ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php unset($_SESSION['error']); ?>
            <?php endif; ?>
            
            <form method="POST">
                <div class="mb-4">
                    <label for="new_password" class="form-label">Naujas slaptažodis:</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                        <input type="password" class="form-control" id="new_password" name="new_password" required>
                    </div>
                    <div class="form-text">Slaptažodis turi būti bent 8 simbolių ilgio</div>
                </div>
                
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="bi bi-check-circle"></i> Keisti slaptažodį
                    </button>
                </div>
            </form>
            
            <div class="text-center mt-3">
                <a href="index.php" class="text-decoration-none"><i class="bi bi-arrow-left"></i> Grįžti atgal</a>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>