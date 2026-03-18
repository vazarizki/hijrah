<?php
session_start();
require '../config.php';

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['admin_logged_in'] = true;
        header("Location: index");
        exit;
    } else {
        $error = "Username atau Password salah!";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin | MyHijrah</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%); font-family: 'Inter', sans-serif; height: 100vh; display: flex; align-items: center; }
        .auth-card { background: rgba(255, 255, 255, 0.05); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.1); border-radius: 24px; padding: 40px; width: 100%; max-width: 400px; color: white; margin: auto; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5); }
        .form-control { background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.2); color: white; border-radius: 12px; padding: 12px; }
        .form-control:focus { background: rgba(255, 255, 255, 0.1); border-color: #38bdf8; color: white; box-shadow: none; }
        .btn-auth { background: #38bdf8; border: none; border-radius: 12px; padding: 12px; font-weight: 600; color: #0f172a; transition: 0.3s; width: 100%; }
        .btn-auth:hover { background: #0ea5e9; transform: translateY(-2px); }
    </style>
</head>
<body>
    <div class="auth-card text-center">
        <h2 class="fw-bold mb-1">My<span style="color: #38bdf8;">Hijrah</span></h2>
        <p class="text-white-50 small mb-4">Welcome back, Admin!</p>
        
        <?php if(isset($error)): ?>
            <div class="alert alert-danger py-2 small border-0 bg-danger text-white bg-opacity-25"><?= $error ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="mb-3 text-start">
                <label class="small fw-bold mb-1">Username</label>
                <input type="text" name="username" class="form-control" placeholder="Enter username" required>
            </div>
            <div class="mb-4 text-start">
                <label class="small fw-bold mb-1">Password</label>
                <input type="password" name="password" class="form-control" placeholder="••••••••" required>
            </div>
            <button type="submit" name="login" class="btn-auth">Sign In</button>
            <p class="mt-3 small text-white-50">Don't have an account? <a href="register" class="text-info text-decoration-none">Register</a></p>
        </form>
    </div>
</body>
</html>