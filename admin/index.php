<?php
require 'auth.php';
require '../config.php';

// Hitung data untuk statistik
$count_p = $pdo->query("SELECT count(*) FROM packages")->fetchColumn();
$count_b = $pdo->query("SELECT count(*) FROM blogs")->fetchColumn();
$count_h = $pdo->query("SELECT count(*) FROM banners")->fetchColumn(); // Tambahan untuk Banner
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard | MyHijrah Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        :root { --sidebar-bg: #0f172a; --main-bg: #f8fafc; --accent: #3b82f6; }
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: var(--main-bg); margin: 0; }
        .sidebar { width: 280px; height: 100vh; background: var(--sidebar-bg); color: white; position: fixed; padding: 20px; }
        .nav-link { color: #94a3b8; padding: 12px 20px; border-radius: 12px; margin-bottom: 5px; transition: 0.3s; display: block; text-decoration: none; }
        .nav-link:hover, .nav-link.active { color: white; background: rgba(255,255,255,0.05); }
        .nav-link.active { background: var(--accent); color: white; }
        .main-content { margin-left: 280px; padding: 40px; }
        .stat-card { background: white; border: none; border-radius: 24px; padding: 30px; box-shadow: 0 4px 20px rgba(0,0,0,0.05); transition: 0.3s; height: 100%; }
        .stat-card:hover { transform: translateY(-5px); }
        .icon-box { width: 60px; height: 60px; border-radius: 18px; display: flex; align-items: center; justify-content: center; font-size: 24px; margin-bottom: 20px; }
    </style>
</head>
<body>

<div class="sidebar">
    <h3 class="fw-bold mb-5 px-3 text-info">MyHijrah</h3>
    <a href="dashboard" class="nav-link active"><i class="fas fa-chart-pie me-2"></i> Dashboard</a>
    <a href="manage_banners" class="nav-link"><i class="fas fa-images me-2"></i> Hero Banner</a>
    <a href="manage_packages" class="nav-link"><i class="fas fa-box me-2"></i> Paket Wisata</a>
    <a href="manage_blogs" class="nav-link"><i class="fas fa-newspaper me-2"></i> Kelola Blog</a>
    <hr class="text-secondary mt-5">
    <a href="../" target="_blank" class="nav-link"><i class="fas fa-external-link-alt me-2"></i> Lihat Web</a>
    <a href="logout" class="nav-link text-danger"><i class="fas fa-power-off me-2"></i> Logout</a>
</div>

<div class="main-content">
    <h2 class="fw-bold mb-1">Dashboard Overview</h2>
    <p class="text-muted mb-5">Selamat bekerja kembali hari ini!</p>

    <div class="row g-4">
        <div class="col-md-4">
            <div class="stat-card">
                <div class="icon-box bg-info bg-opacity-10 text-info"><i class="fas fa-images"></i></div>
                <h6 class="text-muted fw-bold">Hero Banners</h6>
                <h2 class="fw-bold m-0"><?= $count_h ?></h2>
                <a href="manage_banners" class="small text-decoration-none mt-2 d-inline-block text-info">Manage Sliders <i class="fas fa-arrow-right ms-1"></i></a>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card">
                <div class="icon-box bg-primary bg-opacity-10 text-primary"><i class="fas fa-suitcase-rolling"></i></div>
                <h6 class="text-muted fw-bold">Total Paket</h6>
                <h2 class="fw-bold m-0"><?= $count_p ?></h2>
                <a href="manage_packages" class="small text-decoration-none mt-2 d-inline-block">Manage Packages <i class="fas fa-arrow-right ms-1"></i></a>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card">
                <div class="icon-box bg-success bg-opacity-10 text-success"><i class="fas fa-feather-alt"></i></div>
                <h6 class="text-muted fw-bold">Total Blog</h6>
                <h2 class="fw-bold m-0"><?= $count_b ?></h2>
                <a href="manage_blogs" class="small text-decoration-none mt-2 d-inline-block text-success">Manage Articles <i class="fas fa-arrow-right ms-1"></i></a>
            </div>
        </div>
    </div>
</div>

</body>
</html>