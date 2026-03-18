<?php
require 'auth.php'; 
require '../config.php'; // Keluar dari admin/ untuk ambil config.php

// --- LOGIC: TAMBAH BANNER ---
if (isset($_POST['add'])) {
    $title    = $_POST['t'];
    $subtitle = $_POST['s'];
    $link     = $_POST['l'] ?? '#contact';
    
    $filename  = $_FILES['img']['name'];
    $tmp_name  = $_FILES['img']['tmp_name'];
    $error     = $_FILES['img']['error'];

    if ($error === 0) {
        $new_filename = uniqid() . '-' . $filename;
        
        // SESUAI GAMBAR: Path ke assets/img/ (Tanpa folder banners karena di gambar tidak ada)
        // Jika kamu ingin pakai folder banners, buat dulu foldernya di assets/img/banners
        $target_path  = "../assets/img/" . $new_filename;

        if (move_uploaded_file($tmp_name, $target_path)) {
            $stmt = $pdo->prepare("INSERT INTO banners (image, title, subtitle, button_link) VALUES (?, ?, ?, ?)");
            if($stmt->execute([$new_filename, $title, $subtitle, $link])) {
                header("Location: manage_banners.php?msg=success");
                exit();
            }
        } else {
            $err_msg = "Gagal upload! Pastikan folder assets/img/ bisa ditulis (writable).";
        }
    } else {
        $err_msg = "File error. Kode Error: " . $error;
    }
}

// --- LOGIC: HAPUS BANNER ---
if (isset($_GET['del'])) {
    $id = $_GET['del'];
    $get_img = $pdo->prepare("SELECT image FROM banners WHERE id = ?");
    $get_img->execute([$id]);
    $row = $get_img->fetch();
    
    if ($row) {
        $path = "../assets/img/" . $row['image'];
        if (file_exists($path)) { unlink($path); }
        $pdo->prepare("DELETE FROM banners WHERE id = ?")->execute([$id]);
    }
    header("Location: manage_banners.php?msg=deleted");
    exit();
}

$banners = $pdo->query("SELECT * FROM banners ORDER BY id DESC")->fetchAll();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Manage Banners | MyHijrah Admin</title>
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
        .card-table { background: white; border: none; border-radius: 24px; padding: 25px; box-shadow: 0 4px 20px rgba(0,0,0,0.05); }
        .img-preview { width: 140px; height: 70px; border-radius: 12px; object-fit: cover; border: 1px solid #eee; }
    </style>
</head>
<body>

<div class="sidebar">
    <h3 class="fw-bold mb-5 px-3 text-info">MyHijrah</h3>
    <a href="index.php" class="nav-link"><i class="fas fa-chart-pie me-2"></i> Dashboard</a>
    <a href="manage_banners.php" class="nav-link active"><i class="fas fa-images me-2"></i> Hero Banner</a>
    <a href="manage_packages.php" class="nav-link"><i class="fas fa-box me-2"></i> Paket Wisata</a>
    <a href="manage_blogs.php" class="nav-link"><i class="fas fa-newspaper me-2"></i> Kelola Blog</a>
    <hr class="text-secondary mt-5">
    <a href="../" target="_blank" class="nav-link"><i class="fas fa-external-link-alt me-2"></i> Lihat Web</a>
    <a href="logout.php" class="nav-link text-danger"><i class="fas fa-power-off me-2"></i> Logout</a>
</div>

<div class="main-content">
    <div class="d-flex justify-content-between align-items-center mb-5">
        <div><h2 class="fw-bold mb-1">Hero Banners</h2><p class="text-muted">Manajemen slider promo utama.</p></div>
        <button class="btn btn-primary rounded-pill px-4 py-2 fw-bold" data-bs-toggle="modal" data-bs-target="#addModal">
            <i class="fas fa-plus me-2"></i> Tambah Banner
        </button>
    </div>

    <?php if(isset($err_msg)): ?><div class="alert alert-danger rounded-4"><?= $err_msg ?></div><?php endif; ?>

    <div class="card-table">
        <div class="table-responsive">
            <table class="table align-middle">
                <thead><tr class="text-muted small"><th>Preview</th><th>Info Banner</th><th>Link</th><th class="text-end">Aksi</th></tr></thead>
                <tbody>
                    <?php foreach($banners as $b): ?>
                    <tr>
                        <td><img src="../assets/img/<?= $b['image'] ?>" class="img-preview"></td>
                        <td><div class="fw-bold"><?= htmlspecialchars($b['title']) ?></div><small class="text-muted"><?= htmlspecialchars($b['subtitle']) ?></small></td>
                        <td><code class="small"><?= $b['button_link'] ?></code></td>
                        <td class="text-end">
                            <a href="?del=<?= $b['id'] ?>" class="btn btn-sm btn-light text-danger rounded-3" onclick="return confirm('Hapus?')"><i class="fas fa-trash-alt"></i></a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="addModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0" style="border-radius: 28px;">
            <form method="POST" enctype="multipart/form-data">
                <div class="modal-header border-0 pb-0">
                    <h5 class="fw-bold">Upload New Banner</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3"><label class="small fw-bold mb-2">Judul</label><input type="text" name="t" class="form-control" ></div>
                    <div class="mb-3"><label class="small fw-bold mb-2">Subtitle</label><textarea name="s" class="form-control"></textarea></div>
                    <div class="mb-3"><label class="small fw-bold mb-2">Link</label><input type="text" name="l" class="form-control" value="#contact"></div>
                    <div class="mb-3"><label class="small fw-bold mb-2">File Gambar</label><input type="file" name="img" class="form-control" accept="image/*" required></div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="submit" name="add" class="btn btn-primary w-100 rounded-pill py-3 fw-bold">Simpan Banner</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>