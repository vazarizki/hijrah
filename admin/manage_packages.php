<?php
require 'auth.php';
require '../config.php';

function createSlug($str) {
    $str = strtolower(trim($str));
    $str = preg_replace('/[^a-z0-9-]/', '-', $str);
    $str = preg_replace('/-+/', '-', $str);
    return trim($str, '-');
}

// 1. PROSES TAMBAH
if (isset($_POST['add_package'])) {
    $title = htmlspecialchars($_POST['title']);
    $slug = createSlug($title);
    $price = $_POST['price'];
    $category = htmlspecialchars($_POST['category']);
    $desc = $_POST['description'];
    $img_name = time() . '_' . $_FILES['image']['name'];
    
    if (move_uploaded_file($_FILES['image']['tmp_name'], "../assets/img/" . $img_name)) {
        $stmt = $pdo->prepare("INSERT INTO packages (title, slug, price, category, description, image) VALUES (?,?,?,?,?,?)");
        $stmt->execute([$title, $slug, $price, $category, $desc, $img_name]);
        header("Location: manage_packages"); exit;
    }
}

// 2. PROSES UPDATE
if (isset($_POST['update_package'])) {
    $id = $_POST['id'];
    $title = htmlspecialchars($_POST['title']);
    $slug = createSlug($title);
    $price = $_POST['price'];
    $category = htmlspecialchars($_POST['category']);
    $desc = $_POST['description'];
    $old_image = $_POST['old_image'];

    $img_name = (!empty($_FILES['image']['name'])) ? time() . '_' . $_FILES['image']['name'] : $old_image;
    if (!empty($_FILES['image']['name'])) {
        move_uploaded_file($_FILES['image']['tmp_name'], "../assets/img/" . $img_name);
    }

    $stmt = $pdo->prepare("UPDATE packages SET title=?, slug=?, price=?, category=?, description=?, image=? WHERE id=?");
    $stmt->execute([$title, $slug, $price, $category, $desc, $img_name, $id]);
    header("Location: manage_packages"); exit;
}

// 3. PROSES DELETE
if (isset($_GET['delete'])) {
    $pdo->prepare("DELETE FROM packages WHERE id = ?")->execute([$_GET['delete']]);
    header("Location: manage_packages"); exit;
}

$packages = $pdo->query("SELECT * FROM packages ORDER BY id DESC")->fetchAll();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Manage Packages | MyHijrah Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        :root { --sidebar-bg: #0f172a; --main-bg: #f8fafc; --accent: #3b82f6; }
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: var(--main-bg); margin: 0; }
        .sidebar { width: 280px; height: 100vh; background: var(--sidebar-bg); color: white; position: fixed; padding: 20px; z-index: 1050; }
        .nav-link { color: #94a3b8; padding: 12px 20px; border-radius: 12px; margin-bottom: 5px; transition: 0.3s; display: block; text-decoration: none; }
        .nav-link:hover, .nav-link.active { color: white; background: rgba(255,255,255,0.05); }
        .nav-link.active { background: var(--accent); color: white; }
        .main-content { margin-left: 280px; padding: 40px; position: relative; }
        .table-container { background: white; border-radius: 24px; padding: 30px; box-shadow: 0 4px 20px rgba(0,0,0,0.05); }
        .img-thumb { width: 60px; height: 45px; object-fit: cover; border-radius: 8px; }
        .btn-add { background: var(--accent); color: white; border-radius: 12px; padding: 10px 24px; font-weight: 600; border: none; }
        .modal { z-index: 2000; } /* Menjamin modal di atas segalanya */
        .modal-content { border-radius: 24px; border: none; }
    </style>
</head>
<body>

<div class="sidebar">
    <h3 class="fw-bold mb-5 px-3">My<span class="text-info">Hijrah</span></h3>
    <a href="index" class="nav-link"><i class="fas fa-chart-pie me-2"></i> Dashboard</a>
    <a href="manage_packages" class="nav-link active"><i class="fas fa-box me-2"></i> Paket Wisata</a>
    <a href="manage_blogs" class="nav-link"><i class="fas fa-newspaper me-2"></i> Kelola Blog</a>
    <hr class="text-secondary mt-5">
    <a href="../" target="_blank" class="nav-link"><i class="fas fa-external-link-alt me-2"></i> Lihat Web</a>
    <a href="logout" class="nav-link text-danger"><i class="fas fa-power-off me-2"></i> Logout</a>
</div>

<div class="main-content">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">Paket Wisata</h2>
        <button class="btn-add shadow-sm" data-bs-toggle="modal" data-bs-target="#addPackage"><i class="fas fa-plus me-2"></i> Tambah Paket</button>
    </div>

    <div class="table-container">
        <table class="table table-hover align-middle">
            <thead>
                <tr class="text-muted small">
                    <th>IMAGE</th>
                    <th>PACKAGE NAME</th>
                    <th>PRICE</th>
                    <th class="text-end">ACTION</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($packages as $p): ?>
                <tr>
                    <td><img src="../assets/img/<?= $p['image'] ?>" class="img-thumb shadow-sm"></td>
                    <td>
                        <div class="fw-bold"><?= $p['title'] ?></div>
                        <div class="text-muted small">/paket/<?= $p['slug'] ?></div>
                    </td>
                    <td class="fw-bold text-primary">Rp <?= number_format($p['price'], 0, ',', '.') ?></td>
                    <td class="text-end">
                        <button type="button" class="btn btn-sm btn-light text-primary rounded-3 p-2 btn-edit" 
                            data-id="<?= $p['id'] ?>"
                            data-title="<?= htmlspecialchars($p['title']) ?>"
                            data-category="<?= htmlspecialchars($p['category']) ?>"
                            data-price="<?= $p['price'] ?>"
                            data-desc="<?= htmlspecialchars($p['description']) ?>"
                            data-img="<?= $p['image'] ?>">
                            <i class="fas fa-edit"></i>
                        </button>
                        <a href="?delete=<?= $p['id'] ?>" class="btn btn-sm btn-light text-danger rounded-3 p-2" onclick="return confirm('Hapus?')"><i class="fas fa-trash"></i></a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="addPackage" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <form method="POST" enctype="multipart/form-data" class="modal-content shadow-lg">
            <div class="modal-header border-0 p-4 pb-0"><h5 class="fw-bold">Tambah Paket</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
            <div class="modal-body p-4">
                <div class="row g-3">
                    <div class="col-md-8"><label class="small fw-bold mb-1">Judul</label><input type="text" name="title" class="form-control rounded-3" required></div>
                    <div class="col-md-4"><label class="small fw-bold mb-1">Kategori</label><input type="text" name="category" class="form-control rounded-3"></div>
                    <div class="col-md-6"><label class="small fw-bold mb-1">Harga</label><input type="number" name="price" class="form-control rounded-3" required></div>
                    <div class="col-md-6"><label class="small fw-bold mb-1">Gambar</label><input type="file" name="image" class="form-control rounded-3" required></div>
                    <div class="col-12"><label class="small fw-bold mb-1">Deskripsi</label><textarea name="description" class="form-control rounded-3" rows="5"></textarea></div>
                </div>
            </div>
            <div class="modal-footer border-0 p-4 pt-0"><button type="submit" name="add_package" class="btn-add w-100">Simpan</button></div>
        </form>
    </div>
</div>

<div class="modal fade" id="editModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <form method="POST" enctype="multipart/form-data" class="modal-content shadow-lg">
            <input type="hidden" name="id" id="edit-id">
            <input type="hidden" name="old_image" id="edit-old-img">
            <div class="modal-header border-0 p-4 pb-0"><h5 class="fw-bold">Edit Paket Wisata</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
            <div class="modal-body p-4">
                <div class="row g-3">
                    <div class="col-md-8"><label class="small fw-bold mb-1">Judul Paket</label><input type="text" name="title" id="edit-title" class="form-control rounded-3" required></div>
                    <div class="col-md-4"><label class="small fw-bold mb-1">Kategori</label><input type="text" name="category" id="edit-category" class="form-control rounded-3"></div>
                    <div class="col-md-6"><label class="small fw-bold mb-1">Harga</label><input type="number" name="price" id="edit-price" class="form-control rounded-3" required></div>
                    <div class="col-md-6"><label class="small fw-bold mb-1">Ganti Gambar (Opsional)</label><input type="file" name="image" class="form-control rounded-3"></div>
                    <div class="col-12"><label class="small fw-bold mb-1">Deskripsi</label><textarea name="description" id="edit-desc" class="form-control rounded-3" rows="5"></textarea></div>
                </div>
            </div>
            <div class="modal-footer border-0 p-4 pt-0"><button type="submit" name="update_package" class="btn-add w-100">Simpan Perubahan</button></div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
// Script untuk mengisi data ke Modal Edit
document.querySelectorAll('.btn-edit').forEach(button => {
    button.addEventListener('click', function() {
        document.getElementById('edit-id').value = this.dataset.id;
        document.getElementById('edit-title').value = this.dataset.title;
        document.getElementById('edit-category').value = this.dataset.category;
        document.getElementById('edit-price').value = this.dataset.price;
        document.getElementById('edit-desc').value = this.dataset.desc;
        document.getElementById('edit-old-img').value = this.dataset.img;
        
        var editModal = new bootstrap.Modal(document.getElementById('editModal'));
        editModal.show();
    });
});
</script>
</body>
</html>