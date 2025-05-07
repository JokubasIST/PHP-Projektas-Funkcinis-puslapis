<?php
session_start();
require '../classes/User.php';
require '../db/db.php';

if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = new User($db);
    
    $username = trim($_POST['username']);
    $firstName = trim($_POST['first_name']);
    $lastName = trim($_POST['last_name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'] ?: bin2hex(random_bytes(8));

    if (empty($username) || empty($firstName) || empty($lastName) || empty($email)) {
        $error = "Visi laukai yra privalomi.";
    } else {
        $success = $user->register($username, $firstName, $lastName, $email, $password);

        if ($success) {
            $_SESSION['message'] = "Registracija sėkminga. Slaptažodis: $password";
            header("Location: login.php");
            exit();
        } else {
            $error = "Registracija nepavyko. Vartotojo vardas arba el. paštas jau užimtas.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registracija</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        .register-container {
            max-width: 600px;
            margin: 0 auto;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            margin-top: 3rem;
            background: white;
        }
        body {
            background-color: #f8f9fa;
        }
        .password-info {
            font-size: 0.8rem;
            color: #6c757d;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="register-container">
            <h1 class="text-center mb-4"><i class="bi bi-person-plus"></i> Registracija</h1>
            
            <?php if (isset($error)): ?>
            <div class="alert alert-danger alert-dismissible fade show">
                <?= $error ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php endif; ?>
            
            <form method="POST">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="first_name" class="form-label">Vardas:</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-person"></i></span>
                            <input type="text" class="form-control" id="first_name" name="first_name" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="last_name" class="form-label">Pavardė:</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-person"></i></span>
                            <input type="text" class="form-control" id="last_name" name="last_name" required>
                        </div>
                    </div>
                </div>
                
                <div class="mb-3">
                    <label for="username" class="form-label">Vartotojo vardas:</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-person-badge"></i></span>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                </div>
                
                <div class="mb-3">
                    <label for="email" class="form-label">El. paštas:</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                </div>
                
                <div class="mb-3">
                    <label for="password" class="form-label">Slaptažodis:</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-lock"></i></span>
                        <input type="password" class="form-control" id="password" name="password">
                    </div>
                    <div class="password-info">
                        Palikite tuščią norėdami, kad slaptažodis būtų sugeneruotas automatiškai
                    </div>
                </div>
                
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="bi bi-person-plus"></i> Registruotis
                    </button>
                </div>
            </form>
            
            <div class="text-center mt-3">
                <p>Jau turite paskyrą? <a href="login.php" class="text-decoration-none">Prisijunkite</a></p>
                <a href="index.php" class="text-decoration-none"><i class="bi bi-arrow-left"></i> Grįžti atgal</a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>