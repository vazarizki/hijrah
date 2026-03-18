<?php 
require 'config.php'; 

/**
 * LOGIK DATA DINAMIS
 */
try {
    $banners = $pdo->query("SELECT * FROM banners ORDER BY id DESC")->fetchAll();
    $packages = $pdo->query("SELECT * FROM packages ORDER BY id DESC")->fetchAll();
    $blogs = $pdo->query("SELECT * FROM blogs ORDER BY id DESC LIMIT 3")->fetchAll();
} catch (PDOException $e) {
    die("Koneksi Database Gagal: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyHijrahWisata | Perjalanan Berkah, Hati Bahagia</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    
    <style>
        :root {
            --primary-dark: #2c3e50;
            --accent-blue: #38bdf8;
            --soft-gray: #f8fafc;
        }

        body { font-family: 'Poppins', sans-serif; color: #334155; scroll-behavior: smooth; overflow-x: hidden; }
        .text-info { color: var(--accent-blue) !important; }
        
        .navbar { background: rgba(255, 255, 255, 0.98); backdrop-filter: blur(10px); z-index: 1050; border-bottom: 1px solid #eee; }
        .btn-nav { background: var(--primary-dark); color: white; border-radius: 50px; padding: 10px 25px; transition: 0.3s; font-weight: 600; }
        .btn-nav:hover { background: var(--accent-blue); color: white; transform: translateY(-2px); }

        /* HERO SLIDER */
        .hero-slider .carousel-item img { width: 100%; height: auto; display: block; }
        .carousel-control-prev, .carousel-control-next { filter: invert(1); z-index: 10; }

        /* SECTIONS & CARDS */
        .section-padding { padding: 80px 0; }
        .card-custom { border: none; border-radius: 25px; overflow: hidden; transition: 0.4s; box-shadow: 0 10px 30px rgba(0,0,0,0.05); background: white; }
        .card-custom:hover { transform: translateY(-12px); box-shadow: 0 20px 40px rgba(0,0,0,0.1); }
        .img-wrapper { height: 230px; overflow: hidden; }
        .img-wrapper img { width: 100%; height: 100%; object-fit: cover; }

        /* MODAL CUSTOM */
        .modal-content { border-radius: 30px; border: none; overflow: hidden; }
        .modal-header { border-bottom: none; padding: 30px 30px 10px; }
        .modal-body { padding: 10px 30px 30px; }

        .img-gallery { height: 250px; width: 100%; object-fit: cover; border-radius: 20px; transition: 0.3s; }
        .testi-card { background: white; border-radius: 25px; padding: 40px; border: 1px solid #f1f5f9; }

        /* CONTACT SECTION */
        .contact-wrapper { background: #ffffff; border-radius: 35px; overflow: hidden; box-shadow: 0 25px 70px rgba(0,0,0,0.08); border: 1px solid #f1f5f9; }
        .contact-info-side { background: var(--primary-dark); color: white; padding: 60px; }
        .contact-form-side { padding: 60px; }
        .form-control, .form-select { border: 1px solid #e2e8f0; background: #f8fafc; padding: 14px 22px; border-radius: 15px; }

        @media (max-width: 991.98px) {
            .contact-info-side, .contact-form-side { padding: 40px; }
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg sticky-top py-3">
        <div class="container">
            <a class="navbar-brand fw-bold fs-3 text-dark" href="#">My<span class="text-info">Hijrah</span></a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item"><a class="nav-link mx-2" href="#">Beranda</a></li>
                    <li class="nav-item"><a class="nav-link mx-2" href="#about">Tentang</a></li>
                    <li class="nav-item"><a class="nav-link mx-2" href="#paket">Paket</a></li>
                    <li class="nav-item"><a class="nav-link mx-2" href="#gallery">Galeri</a></li>
                    <li class="nav-item"><a class="nav-link mx-2" href="#blog">Blog</a></li>
                    <li class="nav-item ms-lg-3"><a class="btn btn-nav" href="#contact">Hubungi Kami</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <section id="heroSlider" class="carousel slide carousel-fade hero-slider" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <?php foreach($banners as $i => $b): ?>
                <button type="button" data-bs-target="#heroSlider" data-bs-slide-to="<?= $i ?>" class="<?= $i == 0 ? 'active' : '' ?>"></button>
            <?php endforeach; ?>
        </div>
        <div class="carousel-inner">
            <?php if(count($banners) > 0): ?>
                <?php foreach($banners as $i => $b): ?>
                <div class="carousel-item <?= $i == 0 ? 'active' : '' ?>">
                    <a href="<?= !empty($b['link']) ? $b['link'] : '#contact' ?>">
                        <img src="assets/img/<?= $b['image'] ?>" alt="Banner <?= $i ?>">
                    </a>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="carousel-item active" style="background-color: var(--primary-dark); height: 400px;">
                    <div class="carousel-caption">
                        <h1 class="fw-bold text-white">Selamat Datang di MyHijrah</h1>
                    </div>
                </div>
            <?php endif; ?>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#heroSlider" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#heroSlider" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
        </button>
    </section>

    <section id="about" class="section-padding">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <img src="https://images.unsplash.com/photo-1523059623039-a9ed027e7fad?auto=format&fit=crop&w=800&q=80" class="img-fluid rounded-5 shadow-lg" alt="About">
                </div>
                <div class="col-lg-6 ps-lg-5">
                    <h6 class="text-info fw-bold mb-2">TENTANG KAMI</h6>
                    <h2 class="display-5 fw-bold mb-4">Partner Perjalanan Ibadah & Wisata Anda</h2>
                    <p class="text-muted fs-5 mb-4">Kami menghadirkan pengalaman perjalanan religi yang mengutamakan kenyamanan jamaah sesuai syariat.</p>
                </div>
            </div>
        </div>
    </section>

    <section id="paket" class="section-padding bg-light">
        <div class="container text-center mb-5">
            <h2 class="display-6 fw-bold">Paket Pilihan Terbaik</h2>
        </div>
        <div class="container">
            <div class="row g-4">
                <?php foreach($packages as $p): ?>
                <div class="col-md-4">
                    <div class="card card-custom h-100">
                        <div class="img-wrapper">
                            <img src="assets/img/<?= $p['image'] ?>" alt="<?= $p['title'] ?>">
                        </div>
                        <div class="card-body p-4 text-center">
                            <h5 class="fw-bold mb-2"><?= $p['title'] ?></h5>
                            <h4 class="text-primary fw-bold mb-3">Rp <?= number_format($p['price'], 0, ',', '.') ?></h4>
                            
                            <button class="btn btn-link text-info text-decoration-none fw-bold mb-3 small" data-bs-toggle="modal" data-bs-target="#modalPaket<?= $p['id'] ?>">
                                Lihat Detail Paket <i class="fas fa-chevron-right ms-1"></i>
                            </button>

                            <a href="#contact" onclick="setPackage('<?= $p['title'] ?>')" class="btn btn-primary w-100 rounded-pill py-2 fw-bold">Tanya Kuota</a>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="modalPaket<?= $p['id'] ?>" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content shadow-lg">
                            <div class="modal-header">
                                <h5 class="modal-title fw-bold"><?= $p['title'] ?></h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body text-start">
                                <div class="mb-3 text-center">
                                    <img src="assets/img/<?= $p['image'] ?>" class="img-fluid rounded-4 mb-3" style="max-height: 200px; width: 100%; object-fit: cover;">
                                </div>
                                <h6 class="fw-bold text-muted small mb-2 uppercase">Deskripsi Paket:</h6>
                                <div class="text-muted" style="line-height: 1.6;">
                                    <?= nl2br($p['description']) ?>
                                </div>
                                <hr class="my-4 opacity-50">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <p class="small text-muted mb-0">Harga Mulai</p>
                                        <h5 class="fw-bold text-primary mb-0">Rp <?= number_format($p['price'], 0, ',', '.') ?></h5>
                                    </div>
                                    <button onclick="setPackage('<?= $p['title'] ?>')" data-bs-dismiss="modal" class="btn btn-success rounded-pill px-4 fw-bold">Pilih Paket</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <section id="gallery" class="section-padding">
        <div class="container text-center mb-5">
            <h2 class="display-6 fw-bold">Galeri & Testimoni</h2>
        </div>
        <div class="container text-center">
            <div class="row g-3 mb-5">
                <div class="col-md-3 col-6"><img src="https://images.unsplash.com/photo-1591604129939-f1efa4d9f7fa?auto=format&fit=crop&w=500" class="img-gallery shadow-sm"></div>
                <div class="col-md-3 col-6"><img src="https://images.unsplash.com/photo-1564769625905-50e93615e769?auto=format&fit=crop&w=500" class="img-gallery shadow-sm"></div>
                <div class="col-md-3 col-6"><img src="https://images.unsplash.com/photo-1542466507-d7491d54236e?auto=format&fit=crop&w=500" class="img-gallery shadow-sm"></div>
                <div class="col-md-3 col-6"><img src="https://images.unsplash.com/photo-1519817650390-64a934479f67?auto=format&fit=crop&w=500" class="img-gallery shadow-sm"></div>
            </div>
            <div class="row g-4 justify-content-center">
                <div class="col-md-5 text-center">
                    <div class="testi-card shadow-sm">
                        <p class="text-muted fs-5">"Pelayanan luar biasa, pembimbingnya sangat sabar dan akomodasi hotel sangat dekat."</p>
                        <h6 class="fw-bold mb-0">Hj. Ratna Sari</h6>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="blog" class="section-padding bg-light">
        <div class="container text-center mb-5">
            <h2 class="display-6 fw-bold">Artikel & Tips</h2>
        </div>
        <div class="container">
            <div class="row g-4">
                <?php foreach($blogs as $b): ?>
                <div class="col-md-4">
                    <div class="card card-custom h-100 border-0 shadow-sm">
                        <div class="img-wrapper">
                            <img src="assets/img/<?= $b['image'] ?>" alt="<?= $b['title'] ?>">
                        </div>
                        <div class="card-body p-4">
                            <h5 class="fw-bold mb-3"><?= $b['title'] ?></h5>
                            <a href="blog_detail.php?slug=<?= $b['slug'] ?>" class="text-info text-decoration-none fw-bold small">Baca Selengkapnya →</a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <section id="contact" class="section-padding">
        <div class="container">
            <div class="contact-wrapper">
                <div class="row g-0">
                    <div class="col-lg-5 contact-info-side">
                        <h2 class="display-6 fw-bold mb-4">Konsultasikan Perjalanan Anda</h2>
                        <div class="d-flex align-items-center">
                            <i class="fab fa-whatsapp fs-3 text-info me-3"></i>
                            <div><p class="fw-bold mb-0">0812-3456-7890</p></div>
                        </div>
                    </div>
                    <div class="col-lg-7 contact-form-side">
                        <form onsubmit="sendToWhatsapp(); return false;">
                            <div class="mb-4">
                                <label class="small fw-bold text-muted mb-2">Nama Lengkap</label>
                                <input type="text" id="name" class="form-control" required>
                            </div>
                            <div class="mb-4">
                                <label class="small fw-bold text-muted mb-2">Pilih Paket</label>
                                <select id="packageSelect" class="form-select">
                                    <option value="Umum">Paket Umum</option>
                                    <?php foreach($packages as $p): ?>
                                        <option value="<?= $p['title'] ?>"><?= $p['title'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-success w-100 py-3 rounded-pill fw-bold">Chat Admin Sekarang</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer class="py-5 text-center bg-white border-top">
        <div class="container">
            <p class="small text-muted mb-0">&copy; 2026 MyHijrahWisata Indonesia.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function setPackage(packageName) {
            document.getElementById('packageSelect').value = packageName;
            window.location.hash = '#contact';
        }
        function sendToWhatsapp() {
            const name = document.getElementById('name').value;
            const pckg = document.getElementById('packageSelect').value;
            const text = `Halo Admin MyHijrah, saya *${name}* ingin tanya paket: *${pckg}*.`;
            window.open(`https://wa.me/628123456789?text=${encodeURIComponent(text)}`, '_blank');
        }
    </script>
</body>
</html>