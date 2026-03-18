<?php 
require 'config.php'; 
$query = $pdo->query("SELECT * FROM blogs ORDER BY id DESC");
$blogs = $query->fetchAll();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog & Inspirasi Perjalanan | MyHijrahWisata</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        body { font-family: 'Poppins', sans-serif; background-color: #f8fafc; color: #334155; }
        .navbar { background: white; border-bottom: 1px solid #e2e8f0; }
        .blog-header { background: #2c3e50; padding: 100px 0; color: white; text-align: center; margin-bottom: 60px; }
        .card-blog { border: none; border-radius: 20px; overflow: hidden; transition: 0.3s; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); background: white; }
        .card-blog:hover { transform: translateY(-10px); box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1); }
        .img-wrapper { height: 220px; overflow: hidden; }
        .img-wrapper img { width: 100%; height: 100%; object-fit: cover; }
        .blog-category { font-size: 0.75rem; font-weight: 700; color: #38bdf8; text-transform: uppercase; letter-spacing: 1px; }
        .blog-title { font-size: 1.25rem; font-weight: 700; color: #1e293b; margin: 10px 0; line-height: 1.4; }
        footer { background: #2c3e50; color: white; padding: 60px 0; margin-top: 100px; }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg sticky-top py-3">
        <div class="container">
            <a class="navbar-brand fw-bold fs-3 text-dark" href="./">My<span class="text-info">Hijrah</span></a>
            <div class="ms-auto">
                <a href="./" class="btn btn-outline-dark rounded-pill px-4">Kembali ke Beranda</a>
            </div>
        </div>
    </nav>

    <header class="blog-header">
        <div class="container">
            <h1 class="display-4 fw-bold">Wawasan & Inspirasi</h1>
            <p class="lead opacity-75">Tips, berita, dan cerita perjalanan keberkahan untuk Anda.</p>
        </div>
    </header>

    <div class="container">
        <div class="row g-4">
            <?php foreach($blogs as $b): ?>
            <div class="col-md-4">
                <article class="card-blog h-100">
                    <div class="img-wrapper">
                        <img src="assets/img/<?= $b['image'] ?>" alt="<?= $b['title'] ?>">
                    </div>
                    <div class="p-4">
                        <span class="blog-category">Travel Tips</span>
                        <h2 class="blog-title"><?= $b['title'] ?></h2>
                        <p class="small text-muted mb-4"><?= substr(strip_tags($b['content']), 0, 100) ?>...</p>
                        <a href="blog_detail.php?slug=<?= $b['slug'] ?>" class="btn btn-dark w-100 rounded-pill py-2 fw-bold">Baca Selengkapnya</a>
                    </div>
                </article>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

    <footer>
        <div class="container text-center">
            <p class="mb-0 opacity-50">&copy; 2026 MyHijrahWisata. All Rights Reserved.</p>
        </div>
    </footer>

</body>
</html>