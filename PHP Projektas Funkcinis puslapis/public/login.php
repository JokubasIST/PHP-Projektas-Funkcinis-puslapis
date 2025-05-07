<?php
session_start();
require '../classes/User.php';
require '../classes/LoginLog.php';
require '../db/db.php';

if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = new User($db);
    $log = new LoginLog($db);
    $ipAddress = $_SERVER['REMOTE_ADDR'];

    $username = trim($_POST['username']);
    $password = $_POST['password'];

    $success = $user->login($username, $password);
    $log->log($username, $success, $ipAddress);

    if ($success) {
        $_SESSION['message'] = "Prisijungimas sėkmingas!";
        header("Location: index.php");
        exit();
    } else {
        $error = "Prisijungimas nepavyko. Neteisingas vartotojo vardas arba slaptažodis.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Prisijungimas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        .login-container {
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
    <div class="container">
        <div class="login-container">
            <h1 class="text-center mb-4"><i class="bi bi-box-arrow-in-right"></i> Prisijungimas</h1>
            
            <?php if (isset($error)): ?>
            <div class="alert alert-danger alert-dismissible fade show">
                <?= $error ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php endif; ?>
            
            <form method="POST">
                <div class="mb-3">
                    <label for="username" class="form-label">Vartotojo vardas:</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-person-fill"></i></span>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                </div>
                
                <div class="mb-3">
                    <label for="password" class="form-label">Slaptažodis:</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                </div>
                
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="bi bi-box-arrow-in-right"></i> Prisijungti
                    </button>
                </div>
            </form>
            
            <div class="text-center mt-3">
                <p>Neturite paskyros? <a href="register.php" class="text-decoration-none">Registruokitės</a></p>
                <a href="index.php" class="text-decoration-none"><i class="bi bi-arrow-left"></i> Grįžti atgal</a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>