<?php 
require 'config.php'; 

if (!isset($_GET['slug'])) {
    header("Location: blogs.php");
    exit;
}

$slug = $_GET['slug'];
$stmt = $pdo->prepare("SELECT * FROM blogs WHERE slug = ?");
$stmt->execute([$slug]);
$blog = $stmt->fetch();

if (!$blog) {
    echo "Artikel tidak ditemukan.";
    exit;
}

// Ambil artikel lain untuk rekomendasi (Sidebar)
$sidebar_query = $pdo->prepare("SELECT * FROM blogs WHERE slug != ? ORDER BY RAND() LIMIT 3");
$sidebar_query->execute([$slug]);
$other_blogs = $sidebar_query->fetchAll();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $blog['title'] ?> | MyHijrahWisata</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #ffffff; color: #1e293b; line-height: 1.8; }
        .navbar { background: white; border-bottom: 1px solid #f1f5f9; }
        .post-header { padding: 80px 0 40px; }
        .post-title { font-size: 3rem; font-weight: 800; line-height: 1.2; color: #0f172a; }
        .post-meta { color: #64748b; font-weight: 500; }
        .main-image { width: 100%; max-height: 500px; object-fit: cover; border-radius: 30px; margin: 40px 0; }
        .post-content { font-size: 1.15rem; color: #334155; }
        .post-content p { margin-bottom: 25px; }
        .sidebar-card { border: none; background: #f8fafc; border-radius: 20px; padding: 25px; }
        .cta-box { background: #38bdf8; border-radius: 24px; color: white; padding: 40px; margin-top: 60px; }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg sticky-top py-3">
        <div class="container">
            <a class="navbar-brand fw-bold fs-3 text-dark" href="./">My<span class="text-info">Hijrah</span></a>
            <a href="blogs.php" class="text-muted text-decoration-none small fw-bold"><i class="fas fa-arrow-left me-2"></i> Kembali ke Blog</a>
        </div>
    </nav>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <header class="post-header text-center">
                    <div class="post-meta mb-3">
                        <span class="badge bg-info bg-opacity-10 text-info px-3 py-2 rounded-pill me-2">Inspirasi</span>
                        • <span class="ms-2"><?= date('d M Y', strtotime($blog['created_at'])) ?></span>
                    </div>
                    <h1 class="post-title"><?= $blog['title'] ?></h1>
                </header>

                <img src="assets/img/<?= $blog['image'] ?>" class="main-image shadow-lg" alt="<?= $blog['title'] ?>">

                <div class="row">
                    <div class="col-lg-8">
                        <div class="post-content">
                            <?= nl2br($blog['content']) ?>
                        </div>
                        
                        <div class="cta-box text-center shadow">
                            <h3 class="fw-bold">Ingin berkonsultasi tentang perjalanan Anda?</h3>
                            <p class="opacity-90">Tim kami siap membantu merencanakan liburan halal terbaik untuk keluarga Anda.</p>
                            <a href="https://wa.me/628123456789" class="btn btn-light rounded-pill px-5 py-3 fw-bold mt-3"><i class="fab fa-whatsapp me-2"></i> Hubungi Kami Sekarang</a>
                        </div>
                    </div>

                    <div class="col-lg-4 mt-5 mt-lg-0">
                        <div class="sidebar-card">
                            <h5 class="fw-bold mb-4">Artikel Lainnya</h5>
                            <?php foreach($other_blogs as $ob): ?>
                            <div class="mb-4">
                                <a href="blog_detail.php?slug=<?= $ob['slug'] ?>" class="text-decoration-none">
                                    <h6 class="text-dark fw-bold mb-1 lh-base hover-text-info"><?= $ob['title'] ?></h6>
                                    <small class="text-muted"><?= date('d M Y', strtotime($ob['created_at'])) ?></small>
                                </a>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="mt-5 py-5 border-top">
        <div class="container text-center">
            <p class="small text-muted mb-0">&copy; 2026 MyHijrahWisata Indonesia.</p>
        </div>
    </footer>

</body>
</html>