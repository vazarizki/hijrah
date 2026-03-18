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
    
    <link rel="icon" type="image/jpeg" href="assets/img/logo_hijrah.jpeg">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    
    <style>
        :root {
            --primary-white: #ffffff;
            --primary-black: #1a1a1a; /* Hitam yang lebih elegan */
            --accent-green: #198754; /* Hijau Bootstrap Success, segar dan islami */
            --soft-gray: #f8f9fa;
        }

        body { font-family: 'Poppins', sans-serif; color: var(--primary-black); scroll-behavior: smooth; overflow-x: hidden; background-color: var(--primary-white); }
        
        /* Utilitas Warna Hijau */
        .text-hijrah { color: var(--accent-green) !important; }
        .bg-hijrah { background-color: var(--accent-green) !important; }
        
        /* NAVBAR - HANYA LOGO */
        .navbar { background: rgba(255, 255, 255, 0.98); backdrop-filter: blur(10px); z-index: 1050; border-bottom: 1px solid #eee; }
        .navbar-brand img {
            height: 60px; /* Ukuran logo di navbar disesuaikan */
            width: auto;
            object-fit: contain;
        }
        .nav-link { color: var(--primary-black) !important; font-weight: 500; }
        .nav-link:hover { color: var(--accent-green) !important; }
        
        /* Tombol Navasi Utama (Hitam) */
        .btn-nav { background: var(--primary-black); color: var(--primary-white); border-radius: 50px; padding: 10px 25px; transition: 0.3s; font-weight: 600; border: none; }
        .btn-nav:hover { background: var(--accent-green); color: var(--primary-white); transform: translateY(-2px); }

        /* HERO SLIDER */
        .hero-slider .carousel-item img { width: 100%; height: auto; display: block; }
        .carousel-control-prev, .carousel-control-next { filter: invert(1); z-index: 10; }
        /* Warna indikator slider jadi hijau */
        .carousel-indicators [data-bs-target] { background-color: var(--accent-green); }

        /* SECTIONS & CARDS */
        .section-padding { padding: 80px 0; }
        
        /* Kartu Paket & Blog */
        .card-custom { border: none; border-radius: 25px; overflow: hidden; transition: 0.4s; box-shadow: 0 10px 30px rgba(0,0,0,0.05); background: var(--primary-white); border: 1px solid #eee; }
        .card-custom:hover { transform: translateY(-12px); box-shadow: 0 20px 40px rgba(0,0,0,0.1); border-color: var(--accent-green); }
        
        .img-wrapper { height: 230px; overflow: hidden; }
        .img-wrapper img { width: 100%; height: 100%; object-fit: cover; }
        
        /* Warna Harga jadi Hijau */
        .text-price { color: var(--accent-green) !important; font-weight: 700; }

        /* MODAL CUSTOM */
        .modal-content { border-radius: 30px; border: none; overflow: hidden; background-color: var(--primary-white); }
        .modal-header { border-bottom: none; padding: 30px 30px 10px; color: var(--primary-black); }
        .modal-body { padding: 10px 30px 30px; color: var(--primary-black); }

        /* GALERI & TESTIMONI */
        .img-gallery { height: 250px; width: 100%; object-fit: cover; border-radius: 20px; transition: 0.3s; border: 2px solid #eee; }
        .img-gallery:hover { border-color: var(--accent-green); }
        
        .testi-card { background: var(--primary-white); border-radius: 25px; padding: 40px; border: 1px solid #f1f5f9; position: relative; }
        .quote-icon { position: absolute; top: 20px; right: 30px; font-size: 3rem; color: var(--accent-green); opacity: 0.1; }

        /* CONTACT SECTION REVISED */
        .contact-wrapper { background: var(--primary-white); border-radius: 35px; overflow: hidden; box-shadow: 0 25px 70px rgba(0,0,0,0.08); border: 1px solid #f1f5f9; }
        /* Sisi Informasi Kontak jadi Hitam */
        .contact-info-side { background: var(--primary-black); color: var(--primary-white); padding: 60px; }
        .contact-info-side .text-info { color: var(--accent-green) !important; } /* Ikon jadi Hijau */
        
        .contact-form-side { padding: 60px; background-color: var(--primary-white); }
        .form-control, .form-select { border: 1px solid #e2e8f0; background: var(--soft-gray); padding: 14px 22px; border-radius: 15px; color: var(--primary-black); }
        .form-control:focus, .form-select:focus { border-color: var(--accent-green); box-shadow: 0 0 0 0.25rem rgba(25, 135, 84, 0.25); }
        
        /* Tombol Form jadi Hijau */
        .btn-hijrah-submit { background-color: var(--accent-green); color: var(--primary-white); border: none; }
        .btn-hijrah-submit:hover { background-color: #146c43; color: var(--primary-white); }

        /* FOOTER */
        footer { background-color: var(--soft-gray) !important; color: var(--primary-black); }

        @media (max-width: 991.98px) {
            .contact-info-side, .contact-form-side { padding: 40px; }
            .navbar-brand img { height: 50px; }
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg sticky-top py-1">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="#">
                <img src="assets/img/logo_hijrah.jpeg" alt="Logo MyHijrah">
            </a>
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
                <div class="carousel-item active" style="background-color: var(--primary-black); height: 400px;">
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
                    <h6 class="text-hijrah fw-bold mb-2">TENTANG KAMI</h6>
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
                            <h4 class="text-price mb-3">Rp <?= number_format($p['price'], 0, ',', '.') ?></h4>
                            
                            <button class="btn btn-link text-hijrah text-decoration-none fw-bold mb-3 small" data-bs-toggle="modal" data-bs-target="#modalPaket<?= $p['id'] ?>">
                                Lihat Detail Paket <i class="fas fa-chevron-right ms-1"></i>
                            </button>

                            <a href="#contact" onclick="setPackage('<?= $p['title'] ?>')" class="btn bg-hijrah text-white w-100 rounded-pill py-2 fw-bold">Tanya Kuota</a>
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
                                        <h5 class="fw-bold text-price mb-0">Rp <?= number_format($p['price'], 0, ',', '.') ?></h5>
                                    </div>
                                    <button onclick="setPackage('<?= $p['title'] ?>')" data-bs-dismiss="modal" class="btn bg-hijrah text-white rounded-pill px-4 fw-bold">Pilih Paket</button>
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
                        <i class="fas fa-quote-right quote-icon"></i>
                        <p class="text-muted fs-5">"Pelayanan luar biasa, pembimbingnya sangat sabar dan akomodasi hotel sangat dekat Nabawi."</p>
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
                            <a href="blog_detail.php?slug=<?= $b['slug'] ?>" class="text-hijrah text-decoration-none fw-bold small">Baca Selengkapnya →</a>
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
                            <button type="submit" class="btn btn-hijrah-submit w-100 py-3 rounded-pill fw-bold shadow-sm">Chat Admin Sekarang</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer class="py-5 text-center bg-light border-top">
        <div class="container">
            <img src="assets/img/logo_hijrah.jpeg" alt="Logo MyHijrah" height="50" class="mb-3">
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