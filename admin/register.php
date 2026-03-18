<?php
require '../config.php';
if (isset($_POST['register'])) {
    $username = htmlspecialchars($_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
    if ($stmt->execute([$username, $password])) {
        echo "<script>alert('Admin Berhasil Terdaftar!'); window.location='login';</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Admin | MyHijrah</title>
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
    <div class="auth-card">
        <div class="text-center mb-4">
            <h2 class="fw-bold">My<span style="color: #38bdf8;">Hijrah</span></h2>
            <p class="text-white-50 small">Create New Administrator</p>
        </div>
        <form method="POST">
            <div class="mb-3"><label class="small fw-bold">Username</label><input type="text" name="username" class="form-control" required></div>
            <div class="mb-3"><label class="small fw-bold">Password</label><input type="password" name="password" class="form-control" required></div>
            <button type="submit" name="register" class="btn-auth">Register Admin</button>
            <p class="text-center mt-3 small text-white-50">Back to <a href="login" class="text-info text-decoration-none">Login</a></p>
        </form>
    </div>
</body>
</html>