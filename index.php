<?php 
require 'config.php'; 
try {
    $banners = $pdo->query("SELECT * FROM banners ORDER BY id DESC")->fetchAll();
    $packages = $pdo->query("SELECT * FROM packages ORDER BY id DESC")->fetchAll();
    $blogs = $pdo->query("SELECT * FROM blogs ORDER BY id DESC LIMIT 3")->fetchAll();
} catch (PDOException $e) { die("Error: " . $e->getMessage()); }
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>MyHijrahWisata | Spesialis Umroh VIP & Tour Halal Eksklusif</title>
    <meta name="description" content="MyHijrahWisata menyediakan layanan Umroh VIP bintang 5 dan paket tour halal terbaik. Pengalaman ibadah nyaman dengan hotel ring 1 dan pembimbing sesuai sunnah.">
    <meta name="keywords" content="umroh vip, paket umroh bintang 5, tour halal specialist, myhijrahwisata, travel umroh terpercaya">
    <meta name="author" content="MyHijrahWisata Indonesia">
    <meta name="robots" content="index, follow">

    <meta property="og:type" content="website">
    <meta property="og:url" content="https://myhijrahwisata.com/">
    <meta property="og:title" content="MyHijrahWisata | Luxury Umroh & Halal Tour Specialist">
    <meta property="og:description" content="Wujudkan perjalanan ibadah bermakna dengan layanan premium bintang 5 dari MyHijrahWisata.">
    <meta property="og:image" content="assets/img/logo_hijrah.jpeg">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&family=Playfair+Display:wght@700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="icon" type="image/x-icon" href="assets/img/logo_hijrah.jpeg">
    <link rel="apple-touch-icon" href="assets/img/logo_hijrah.jpeg">

    <style>
    :root {
        --gold: #b38e5d;
        --dark: #0f172a;
        --emerald: #064e3b;
        --light: #f8fafc;
        --border: #e2e8f0;
    }

    body {
        font-family: 'Plus Jakarta Sans', sans-serif;
        color: var(--dark);
        background: #fff;
        line-height: 1.6;
        scroll-behavior: smooth;
        overflow-x: hidden;
    }

    h1, h2, h3 {
        font-family: 'Playfair Display', serif;
        font-weight: 800;
    }

    .navbar {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border-bottom: 1px solid var(--border);    
    }

    .navbar-brand img {
        height: 100px;
        margin-bottom:-10px;
    }

    .nav-link {
        font-weight: 700;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 1.2px;
        color: var(--dark) !important;
        margin: 0 10px;
    }

    .nav-link:hover {
        color: var(--gold) !important;
    }

    #mainSlider .carousel-item img {
        width: 100%;
        height: auto;
        min-height: 300px;
        object-fit: cover;
    }

    .trust-bar {
        background: var(--dark);
        color: #fff;
        padding: 40px 0;
        position: relative;
        z-index: 10;
    }

    .trust-item i {
        font-size: 2rem;
        color: var(--gold);
        margin-bottom: 15px;
        display: block;
    }

    .trust-item h6 {
        font-size: 0.85rem;
        letter-spacing: 1px;
        font-weight: 800;
        margin-bottom: 5px;
    }

    .trust-item p {
        font-size: 0.75rem;
        opacity: 0.6;
        margin-bottom: 0;
    }

    #about {
        padding: 80px 0 40px 0;
    }

    .about-visual {
        position: relative;
    }

    .about-visual img {
        width: 100%;
        border-radius: 4px;
        z-index: 2;
        position: relative;
    }

    .about-visual::before {
        content: '';
        position: absolute;
        width: 100%;
        height: 100%;
        border: 2px solid var(--gold);
        top: 20px;
        left: -20px;
        z-index: 1;
        border-radius: 4px;
    }

    .trust-badge-box {
        background: #fff;
        border: 1px dashed var(--gold);
        padding: 20px;
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        gap: 15px;
        margin-top: 30px;
    }

    #paket {
        padding: 80px 0;
        background: var(--light);
    }

    .pkg-card {
        background: #fff;
        border: 1px solid var(--border);
        transition: 0.4s;
        overflow: hidden;
        border-radius: 4px;
        height: 100%;
    }

    .pkg-card:hover {
        transform: translateY(-10px);
        border-color: var(--gold);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.05);
    }

    .pkg-img-wrapper {
        height: 250px;
        overflow: hidden;
        position: relative;
    }

    .pkg-img-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .pkg-badge {
        position: absolute;
        top: 15px;
        left: 15px;
        background: var(--gold);
        color: white;
        padding: 4px 12px;
        font-size: 0.7rem;
        font-weight: 800;
        border-radius: 2px;
    }

    .pkg-content {
        padding: 25px;
    }

    .price-label {
        font-size: 0.75rem;
        color: #64748b;
        display: block;
        margin-bottom: 2px;
        font-weight: 600;
        text-transform: uppercase;
    }

    .price-val {
        font-size: 1.3rem;
        color: var(--emerald);
        font-weight: 800;
        display: block;
        margin-bottom: 20px;
    }

    .btn-group-cta {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 10px;
    }

    .btn-detail, .btn-booking {
        font-size: 0.7rem;
        font-weight: 700;
        padding: 12px 5px;
        border: none;
        text-align: center;
    }

    .btn-detail { background: var(--light); color: var(--dark); }
    .btn-booking { background: var(--dark); color: #fff; }

    #gallery {
        background: #000;
        padding: 80px 0;
        color: #fff;
    }

    .gal-item {
        height: 200px;
        overflow: hidden;
        padding: 2px;
    }

    .gal-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        opacity: 0.7;
    }

    #blog {
        padding: 80px 0;
    }

    .blog-link {
        border-bottom: 1px solid #eee;
        padding: 20px 0;
        display: flex;
        justify-content: space-between;
        align-items: center;
        text-decoration: none;
        color: inherit;
    }

    .contact-box {
        background: var(--dark);
        color: #fff;
        padding: 40px;
        border-radius: 8px;
        border-right: 8px solid var(--gold);
    }

    .form-control, .form-select {
        border-radius: 0;
        height: 55px;
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.2);
        color: #fff !important;
    }

    .form-select {
        background-color: transparent;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='white' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m2 5 6 6 6-6'/%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right 1rem center;
        background-size: 16px 12px;
    }

    .form-select option {
        background-color: var(--dark);
        color: #fff;
    }

    /* FOOTER STYLES */
    footer {
        background: var(--dark);
        color: rgba(255,255,255,0.8);
        padding: 60px 0 30px;
    }
    .footer-title {
        color: #fff;
        font-family: 'Playfair Display', serif;
        margin-bottom: 25px;
        font-size: 1.25rem;
    }
    .footer-link {
        color: rgba(255,255,255,0.6);
        text-decoration: none;
        transition: 0.3s;
        display: block;
        margin-bottom: 10px;
        font-size: 0.9rem;
    }
    .footer-link:hover {
        color: var(--gold);
        transform: translateX(5px);
    }
    .social-icon {
        width: 40px;
        height: 40px;
        background: rgba(255,255,255,0.05);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        color: #fff;
        margin-right: 10px;
        transition: 0.3s;
        text-decoration: none;
    }
    .social-icon:hover {
        background: var(--gold);
        color: var(--dark);
    }
    .footer-bottom {
        border-top: 1px solid rgba(255,255,255,0.1);
        margin-top: 40px;
        padding-top: 30px;
    }

    @media (max-width: 768px) {
        .trust-bar { display: none !important; }
        .display-5 { font-size: 2.2rem !important; }
        .about-visual::before { display: none; }
        .pkg-img-wrapper { height: 200px; }
        .contact-box { 
            padding: 30px 20px !important; 
            border-right: none; 
            border-bottom: 8px solid var(--gold);
            text-align: center;
        }
        #mainSlider .carousel-item img {
            height: auto !important;
            min-height: auto !important;
            object-fit: contain;
        }
    }
    </style>
</head>

<body>

    <nav class="navbar navbar-expand-lg sticky-top">
        <div class="container">
            <a class="navbar-brand" href="/">
                <img src="assets/img/logo_hijrah.jpeg" alt="MyHijrahWisata Logo">
            </a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
                <i class="fas fa-bars"></i>
            </button>
            <div class="collapse navbar-collapse" id="mainNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="#about">Tentang Kami</a></li>
                    <li class="nav-item"><a class="nav-link" href="#paket">Paket Umroh</a></li>
                    <li class="nav-item"><a class="nav-link" href="#gallery">Dokumentasi</a></li>
                    <li class="nav-item"><a class="nav-link" href="#blog">Jurnal</a></li>
                    <li class="nav-item"><a class="nav-link" href="#contact">Kontak</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div id="mainSlider" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            <?php foreach($banners as $i => $b): ?>
            <div class="carousel-item <?= $i == 0 ? 'active' : '' ?>">
                <img src="assets/img/<?= $b['image'] ?>" alt="Promo Umroh">
            </div>
            <?php endforeach; ?>
        </div>
    </div>

    <section class="trust-bar">
        <div class="container">
            <div class="row text-center g-3">
                <div class="col-6 col-md-3 trust-item">
                    <i class="fas fa-kaaba"></i>
                    <h6>HOTEL RING 1</h6>
                    <p>Dekat Masjidil Haram</p>
                </div>
                <div class="col-6 col-md-3 trust-item">
                    <i class="fas fa-award"></i>
                    <h6>IZIN RESMI</h6>
                    <p>PPIU Terpercaya</p>
                </div>
                <div class="col-6 col-md-3 trust-item">
                    <i class="fas fa-user-shield"></i>
                    <h6>PEMBIMBING</h6>
                    <p>Sesuai Sunnah</p>
                </div>
                <div class="col-6 col-md-3 trust-item">
                    <i class="fas fa-plane-departure"></i>
                    <h6>DIRECT FLIGHT</h6>
                    <p>Tanpa Transit</p>
                </div>
            </div>
        </div>
    </section>

    <section id="about">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-lg-6">
                    <div class="about-visual">
                        <img src="https://images.unsplash.com/photo-1591604129939-f1efa4d9f7fa?auto=format&fit=crop&w=800" alt="About">
                    </div>
                </div>
                <div class="col-lg-6">
                    <span class="text-gold fw-bold small">YOUR SPIRITUAL PARTNER</span>
                    <h1 class="display-5 mb-4">Perjalanan Ibadah yang Bermakna.</h1>
                    <p class="text-muted">Kami mengkurasi layanan Travel Umroh terbaik dengan maskapai premium dan hotel bintang 5 tepat di depan pelataran masjid.</p>
                    
                    <div class="trust-badge-box">
                        <div class="text-gold"><i class="fas fa-shield-check fa-3x"></i></div>
                        <div>
                            <h5 class="mb-0 fw-bold">100% Trusted Travel</h5>
                            <p class="small text-muted mb-0">Terdaftar resmi di Kemenag RI dengan ribuan jamaah sukses diberangkatkan.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="paket">
        <div class="container">
            <div class="text-center mb-5">
                <span class="text-gold fw-bold">OUR SPECIAL OFFERS</span>
                <h2>Paket Eksklusif 2026</h2>
            </div>
            <div class="row g-4">
                <?php foreach($packages as $p): ?>
                <div class="col-md-4">
                    <div class="pkg-card">
                        <div class="pkg-img-wrapper">
                            <span class="pkg-badge">TERLARIS</span>
                            <img src="assets/img/<?= $p['image'] ?>" alt="<?= $p['title'] ?>">
                        </div>
                        <div class="pkg-content">
                            <h3 class="h5 mb-3"><?= $p['title'] ?></h3>
                            <span class="price-label">Mulai Dari</span>
                            <span class="price-val">IDR <?= number_format($p['price'], 0, ',', '.') ?></span>
                            <div class="btn-group-cta">
                                <button class="btn-detail" data-bs-toggle="modal" data-bs-target="#modalPaket<?= $p['id'] ?>">DETAIL</button>
                                <button onclick="setPackage('<?= $p['title'] ?>')" class="btn-booking">PESAN SEKARANG</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="modalPaket<?= $p['id'] ?>" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content border-0 overflow-hidden">
                            <div class="modal-header border-0 position-absolute top-0 end-0" style="z-index: 99;">
                                <button type="button" class="btn-close bg-white p-2 rounded-circle" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body p-0">
                                <div class="row g-0">
                                    <div class="col-md-5">
                                        <img src="assets/img/<?= $p['image'] ?>" class="h-100 w-100 object-fit-cover" style="min-height: 300px;">
                                    </div>
                                    <div class="col-md-7 p-4 p-lg-5">
                                        <h3 class="mb-1"><?= $p['title'] ?></h3>
                                        <span class="text-gold small d-block mb-3">KEBERANGKATAN 2026</span>
                                        <h4 class="text-success mb-4">IDR <?= number_format($p['price'], 0, ',', '.') ?></h4>
                                        <p class="text-muted small mb-4"><?= nl2br($p['description']) ?></p>
                                        <button onclick="setPackage('<?= $p['title'] ?>')" class="btn btn-dark w-100 py-3 fw-bold" data-bs-dismiss="modal">KONSULTASI VIA WHATSAPP</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <section id="gallery">
        <div class="container text-center">
            <h2 class="mb-5 text-white">Dokumentasi Jamaah</h2>
            <div class="row g-1">
                <div class="col-6 col-md-3 gal-item"><img src="https://images.unsplash.com/photo-1591604129939-f1efa4d9f7fa?auto=format&fit=crop&w=400"></div>
                <div class="col-6 col-md-3 gal-item"><img src="https://images.unsplash.com/photo-1542466507-d7491d54236e?auto=format&fit=crop&w=400"></div>
                <div class="col-6 col-md-3 gal-item"><img src="https://images.unsplash.com/photo-1519817650390-64a934479f67?auto=format&fit=crop&w=400"></div>
                <div class="col-6 col-md-3 gal-item"><img src="https://images.unsplash.com/photo-1523059623039-a9ed027e7fad?auto=format&fit=crop&w=400"></div>
            </div>
        </div>
    </section>

    <section id="blog">
        <div class="container">
            <h2 class="mb-4">Jurnal Islami & Tips</h2>
            <?php foreach($blogs as $b): ?>
            <a href="blog_detail.php?slug=<?= $b['slug'] ?>" class="blog-link">
                <div>
                    <small class="text-gold fw-bold">BLOG UPDATE</small>
                    <h4 class="mb-0 h5"><?= $b['title'] ?></h4>
                </div>
                <i class="fas fa-arrow-right"></i>
            </a>
            <?php endforeach; ?>
        </div>
    </section>

    <section id="contact" class="pb-5">
        <div class="container">
            <div class="contact-box">
                <div class="row g-4 align-items-center">
                    <div class="col-lg-5">
                        <h2 class="h3">Hubungi Kami</h2>
                        <p class="opacity-75">Bicarakan rencana ibadah Anda secara personal.</p>
                        <h4 class="text-gold">0812-3456-7890</h4>
                    </div>
                    <div class="col-lg-7">
                        <form onsubmit="sendToWhatsapp(); return false;">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <input type="text" id="name" class="form-control" placeholder="Nama Lengkap" required>
                                </div>
                                <div class="col-md-6">
                                    <select id="packageSelect" class="form-select" required>
                                        <option value="" selected disabled>Pilih Paket</option>
                                        <?php foreach($packages as $p): ?>
                                        <option value="<?= $p['title'] ?>"><?= $p['title'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-light w-100 fw-bold py-3">KIRIM PESAN SEKARANG</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer>
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4">
                    <img src="assets/img/logo_hijrah.jpeg" alt="Logo" class="mb-4" style="height: 60px; filter: brightness(0) invert(1);">
                    <p class="small mb-4">MyHijrahWisata adalah mitra perjalanan ibadah Anda yang mengedepankan kenyamanan dan kesesuaian sunnah. Layanan premium untuk pengalaman spiritual tak terlupakan.</p>
                    <div class="small">
                        <p class="mb-2"><i class="fas fa-map-marker-alt text-gold me-2"></i> Jl. Raya Utama No. 123, Jakarta Selatan</p>
                        <p class="mb-2"><i class="fas fa-phone text-gold me-2"></i>  0815-998-0084</p>
                        <p class="mb-0"><i class="fas fa-envelope text-gold me-2"></i> info@myhijrahwisata.com</p>
                    </div>
                </div>

                <div class="col-6 col-lg-2 offset-lg-1">
                    <h5 class="footer-title">Navigasi</h5>
                    <a href="#about" class="footer-link">Tentang Kami</a>
                    <a href="#paket" class="footer-link">Paket Umroh</a>
                    <a href="#gallery" class="footer-link">Dokumentasi</a>
                    <a href="#blog" class="footer-link">Jurnal Islami</a>
                </div>

                <div class="col-6 col-lg-2">
                    <h5 class="footer-title">Paket Utama</h5>
                    <?php foreach(array_slice($packages, 0, 4) as $p): ?>
                        <a href="#paket" class="footer-link text-truncate"><?= $p['title'] ?></a>
                    <?php endforeach; ?>
                </div>

                <div class="col-lg-3 text-lg-end">
                    <h5 class="footer-title">Ikuti Kami</h5>
                    <div class="mb-4">
                        <a href="#" class="social-icon"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-youtube"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-tiktok"></i></a>
                    </div>
                    <p class="small text-gold fw-bold mb-0">Izin PPIU Terdaftar Resmi</p>
                    <p class="small opacity-50">Kemenag RI No. 123 Tahun 2026</p>
                </div>
            </div>

            <div class="footer-bottom text-center">
                <p class="small mb-0">&copy; 2026 MyHijrahWisata Indonesia. All Rights Reserved.</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    function setPackage(p) {
        document.getElementById('packageSelect').value = p;
        window.location.hash = '#contact';
    }
    function sendToWhatsapp() {
        const n = document.getElementById('name').value;
        const p = document.getElementById('packageSelect').value;
        const text = `Halo Admin MyHijrah, saya *${n}* ingin tanya paket: *${p}*.`;
        window.open(`https://wa.me/628159980084?text=${encodeURIComponent(text)}`, '_blank');
    }
    </script>
</body>
</html>