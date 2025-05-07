<?php
session_start();
require '../classes/Post.php';
require '../classes/User.php';
require '../db/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$post = new Post($db);
$posts = $post->getAllPosts();

$user = new User($db);
$currentUser = $user->getUserById($_SESSION['user_id']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Įrašai</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        .post-card {
            transition: transform 0.2s;
            margin-bottom: 20px;
        }
        .post-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
        .author-badge {
            font-size: 0.8rem;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php">PHP Projektas</a>
            <div class="navbar-nav ms-auto">
                <a href="create_post.php" class="btn btn-success me-2"><i class="bi bi-plus-circle"></i> Sukurti įrašą</a>
                <a href="index.php" class="btn btn-outline-light"><i class="bi bi-house"></i> Pagrindinis</a>
            </div>
        </div>
    </nav>

    <div class="container py-5">
        <h1 class="text-center mb-5"><i class="bi bi-list-ul"></i> Visi įrašai</h1>
        
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
        
        <?php if (empty($posts)): ?>
        <div class="text-center py-5">
            <i class="bi bi-info-circle" style="font-size: 3rem; color: #6c757d;"></i>
            <h3 class="mt-3">Nėra jokių įrašų</h3>
            <p class="text-muted">Būkite pirmas kuriantis naują įrašą!</p>
            <a href="create_post.php" class="btn btn-primary">Sukurti įrašą</a>
        </div>
        <?php else: ?>
        <div class="row">
            <?php foreach ($posts as $post): ?>
            <div class="col-md-6 col-lg-4">
                <div class="card post-card h-100">
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($post['title']) ?></h5>
                        <p class="card-text"><?= nl2br(htmlspecialchars(substr($post['content'], 0, 150))) ?>...</p>
                    </div>
                    <div class="card-footer bg-transparent">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="badge bg-secondary author-badge">
                                <i class="bi bi-person"></i> <?= htmlspecialchars($post['username']) ?>
                            </span>
                            <small class="text-muted">
                                <i class="bi bi-clock"></i> <?= date('Y-m-d H:i', strtotime($post['created_at'])) ?>
                            </small>
                        </div>
                        <?php if ($post['user_id'] == $_SESSION['user_id']): ?>
                        <div class="mt-3 text-end">
                            <a href="delete_post.php?id=<?= $post['id'] ?>" 
                               class="btn btn-sm btn-outline-danger"
                               onclick="return confirm('Ar tikrai norite ištrinti šį įrašą?')">
                                <i class="bi bi-trash"></i> Ištrinti
                            </a>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>