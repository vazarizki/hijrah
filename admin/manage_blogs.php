<?php
require 'auth.php';
require '../config.php';

function createSlug($str) {
    $str = strtolower(trim($str));
    $str = preg_replace('/[^a-z0-9-]/', '-', $str);
    $str = preg_replace('/-+/', '-', $str);
    return trim($str, '-');
}

// Logic Tambah Blog
if (isset($_POST['add_blog'])) {
    $title = htmlspecialchars($_POST['title']);
    $slug = createSlug($title);
    $content = $_POST['content'];
    $img_name = time() . '_' . $_FILES['image']['name'];
    
    if (move_uploaded_file($_FILES['image']['tmp_name'], "../assets/img/" . $img_name)) {
        $stmt = $pdo->prepare("INSERT INTO blogs (title, slug, content, image) VALUES (?,?,?,?)");
        $stmt->execute([$title, $slug, $content, $img_name]);
        header("Location: manage_blogs"); exit;
    }
}

// Logic Edit Blog
if (isset($_POST['edit_blog'])) {
    $id = $_POST['id'];
    $title = htmlspecialchars($_POST['title']);
    $slug = createSlug($title);
    $content = $_POST['content'];
    $old_image = $_POST['old_image'];

    if (!empty($_FILES['image']['name'])) {
        $img_name = time() . '_' . $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], "../assets/img/" . $img_name);
    } else {
        $img_name = $old_image;
    }

    $stmt = $pdo->prepare("UPDATE blogs SET title = ?, slug = ?, content = ?, image = ? WHERE id = ?");
    $stmt->execute([$title, $slug, $content, $img_name, $id]);
    header("Location: manage_blogs"); exit;
}

// Logic Hapus Blog
if (isset($_GET['delete'])) {
    $pdo->prepare("DELETE FROM blogs WHERE id = ?")->execute([$_GET['delete']]);
    header("Location: manage_blogs"); exit;
}

$blogs = $pdo->query("SELECT * FROM blogs ORDER BY id DESC")->fetchAll();
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Manage Blogs | MyHijrah Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
    :root {
        --sidebar-bg: #0f172a;
        --main-bg: #f8fafc;
        --accent: #3b82f6;
    }

    body {
        font-family: 'Plus Jakarta Sans', sans-serif;
        background-color: var(--main-bg);
        margin: 0;
    }

    .sidebar {
        width: 280px;
        height: 100vh;
        background: var(--sidebar-bg);
        color: white;
        position: fixed;
        padding: 20px;
    }

    .nav-link {
        color: #94a3b8;
        padding: 12px 20px;
        border-radius: 12px;
        margin-bottom: 5px;
        transition: 0.3s;
        display: block;
        text-decoration: none;
    }

    .nav-link:hover,
    .nav-link.active {
        color: white;
        background: rgba(255, 255, 255, 0.05);
    }

    .nav-link.active {
        background: var(--accent);
        color: white;
    }

    .main-content {
        margin-left: 280px;
        padding: 40px;
    }

    .table-container {
        background: white;
        border-radius: 24px;
        padding: 30px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
    }

    .img-thumb {
        width: 80px;
        height: 50px;
        object-fit: cover;
        border-radius: 8px;
    }

    .btn-add {
        background: #38bdf8;
        color: #0f172a;
        border-radius: 12px;
        padding: 10px 24px;
        font-weight: 700;
        border: none;
    }

    .modal-content {
        border-radius: 24px;
        border: none;
    }
    </style>
</head>

<body>

    <div class="sidebar">
        <h3 class="fw-bold mb-5 px-3 text-info">MyHijrah</h3>
        <a href="index" class="nav-link"><i class="fas fa-chart-pie me-2"></i> Dashboard</a>
        <a href="manage_packages" class="nav-link"><i class="fas fa-box me-2"></i> Paket Wisata</a>
        <a href="manage_blogs" class="nav-link active"><i class="fas fa-newspaper me-2"></i> Kelola Blog</a>
        <hr class="text-secondary mt-5">
        <a href="../" target="_blank" class="nav-link"><i class="fas fa-external-link-alt me-2"></i> Lihat Web</a>
        <a href="logout" class="nav-link text-danger"><i class="fas fa-power-off me-2"></i> Logout</a>
    </div>

    <div class="main-content">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold">Manajemen Blog</h2>
            <button class="btn-add shadow-sm" data-bs-toggle="modal" data-bs-target="#addBlog"><i
                    class="fas fa-pen-nib me-2"></i> Tulis Artikel</button>
        </div>

        <div class="table-container">
            <table class="table table-hover align-middle">
                <thead>
                    <tr class="text-muted small">
                        <th>PREVIEW</th>
                        <th>ARTICLE TITLE</th>
                        <th class="text-end">ACTION</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($blogs as $b): ?>
                    <tr>
                        <td><img src="../assets/img/<?= $b['image'] ?>" class="img-thumb"></td>
                        <td>
                            <div class="fw-bold text-dark"><?= $b['title'] ?></div>
                            <div class="small text-muted">/<?= $b['slug'] ?></div>
                        </td>
                        <td class="text-end">
                            <button type="button" class="btn btn-sm btn-light text-primary p-2 me-2"
                                data-bs-toggle="modal" data-bs-target="#editBlog<?= $b['id'] ?>">
                                <i class="fas fa-edit"></i>
                            </button>
                            <a href="?delete=<?= $b['id'] ?>" class="btn btn-sm btn-light text-danger p-2"
                                onclick="return confirm('Hapus artikel ini?')">
                                <i class="fas fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="modal fade" id="addBlog" tabindex="-1">
        <div class="modal-dialog modal-xl">
            <form method="POST" enctype="multipart/form-data" class="modal-content shadow-lg">
                <div class="modal-header border-0 p-4 pb-0">
                    <h5 class="fw-bold">Tulis Artikel Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="row g-4">
                        <div class="col-md-8">
                            <label class="small fw-bold mb-1">Judul Artikel</label>
                            <input type="text" name="title" class="form-control rounded-3 py-2" required
                                placeholder="Contoh: Tips Umroh Saat Ramadhan">
                            <label class="small fw-bold mt-3 mb-1">Isi Konten</label>
                            <textarea name="content" class="form-control rounded-3" rows="12"
                                placeholder="Tulis artikel lengkap di sini..." required></textarea>
                        </div>
                        <div class="col-md-4">
                            <div class="p-4 bg-light rounded-4">
                                <label class="small fw-bold mb-1">Gambar Cover</label>
                                <input type="file" name="image" class="form-control mb-4" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 p-4 pt-0">
                    <button type="submit" name="add_blog" class="btn-add w-100 py-3">Publish Artikel Sekarang</button>
                </div>
            </form>
        </div>
    </div>

    <?php foreach($blogs as $b): ?>
    <div class="modal fade" id="editBlog<?= $b['id'] ?>" tabindex="-1">
        <div class="modal-dialog modal-xl">
            <form method="POST" enctype="multipart/form-data" class="modal-content shadow-lg">
                <input type="hidden" name="id" value="<?= $b['id'] ?>">
                <input type="hidden" name="old_image" value="<?= $b['image'] ?>">
                <div class="modal-header border-0 p-4 pb-0">
                    <h5 class="fw-bold">Edit Artikel</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="row g-4">
                        <div class="col-md-8">
                            <label class="small fw-bold mb-1">Judul Artikel</label>
                            <input type="text" name="title" class="form-control rounded-3 py-2" required
                                value="<?= $b['title'] ?>">
                            <label class="small fw-bold mt-3 mb-1">Isi Konten</label>
                            <textarea name="content" class="form-control rounded-3" rows="12"
                                required><?= $b['content'] ?></textarea>
                        </div>
                        <div class="col-md-4">
                            <div class="p-4 bg-light rounded-4">
                                <label class="small fw-bold mb-1">Ganti Cover (Opsional)</label>
                                <input type="file" name="image" class="form-control mb-3">
                                <p class="small text-muted">Preview Saat Ini:</p>
                                <img src="../assets/img/<?= $b['image'] ?>" class="img-fluid rounded-3 border">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 p-4 pt-0">
                    <button type="submit" name="edit_blog" class="btn-add w-100 py-3 bg-primary text-white">Simpan
                        Perubahan</button>
                </div>
            </form>
        </div>
    </div>
    <?php endforeach; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>