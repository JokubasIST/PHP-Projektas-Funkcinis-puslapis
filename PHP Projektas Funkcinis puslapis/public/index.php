<?php
session_start();
require '../db/db.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pagrindinis puslapis</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .hero-section {
            background: linear-gradient(135deg, #6e8efb, #a777e3);
            color: white;
            padding: 5rem 0;
            margin-bottom: 3rem;
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php">PHP Projektas</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <?php if (isset($_SESSION['user_id'])): ?>
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="create_post.php"><i class="bi bi-plus-circle"></i> Sukurti įrašą</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="view_posts.php"><i class="bi bi-list-ul"></i> Peržiūrėti įrašus</a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="change_password.php"><i class="bi bi-key"></i> Keisti slaptažodį</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php"><i class="bi bi-box-arrow-right"></i> Atsijungti</a>
                    </li>
                </ul>
                <?php else: ?>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="register.php"><i class="bi bi-person-plus"></i> Registruotis</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="login.php"><i class="bi bi-box-arrow-in-right"></i> Prisijungti</a>
                    </li>
                </ul>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="hero-section text-center">
        <div class="container">
            <h1 class="display-4 fw-bold">Sveiki atvykę į PHP projektą!</h1>
            <p class="lead">Jūsų pirmasis žingsnis į puikius projektus</p>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container">
        <?php if (isset($_SESSION['message'])): ?>
        <div class="alert alert-success alert-dismissible fade show">
            <?= $_SESSION['message'] ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php unset($_SESSION['message']); ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger alert-dismissible fade show">
            <?= $_SESSION['error'] ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php unset($_SESSION['error']); ?>
        <?php endif; ?>

        <div class="row justify-content-center">
            <div class="col-md-8 text-center">
                <?php if (isset($_SESSION['user_id'])): ?>
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h3 class="card-title"><i class="bi bi-check-circle-fill text-success"></i> Jūs esate prisijungęs</h3>
                        <p class="card-text">Galite kurti ir peržiūrėti įrašus arba keisti slaptažodį</p>
                    </div>
                </div>
                <?php else: ?>
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h3 class="card-title"><i class="bi bi-exclamation-triangle-fill text-warning"></i> Jūs nesate prisijungęs</h3>
                        <p class="card-text">Prisijunkite arba užsiregistruokite, kad galėtumėte naudotis sistemos funkcijomis</p>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>