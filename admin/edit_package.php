<?php
require '../config.php';
$id = $_GET['id'];
$p = $pdo->prepare("SELECT * FROM packages WHERE id = ?");
$p->execute([$id]);
$data = $p->fetch();

if (isset($_POST['update'])) {
    $title = $_POST['title'];
    $price = $_POST['price'];
    $category = $_POST['category'];
    $desc = $_POST['description'];
    
    if ($_FILES['image']['name'] != "") {
        $img = $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], "../assets/img/" . $img);
    } else {
        $img = $data['image'];
    }

    $sql = "UPDATE packages SET title=?, price=?, category=?, description=?, image=? WHERE id=?";
    $pdo->prepare($sql)->execute([$title, $price, $category, $desc, $img, $id]);
    header("Location: manage_packages.php");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Paket</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="card border-0 shadow mx-auto" style="max-width: 600px;">
            <div class="card-body p-4">
                <h4 class="fw-bold mb-4">Edit Paket Wisata</h4>
                <form method="POST" enctype="multipart/form-data">
                    <div class="mb-3"><label>Nama Paket</label><input type="text" name="title" class="form-control" value="<?= $data['title'] ?>"></div>
                    <div class="mb-3"><label>Harga</label><input type="number" name="price" class="form-control" value="<?= $data['price'] ?>"></div>
                    <div class="mb-3"><label>Kategori</label><input type="text" name="category" class="form-control" value="<?= $data['category'] ?>"></div>
                    <div class="mb-3"><label>Deskripsi</label><textarea name="description" class="form-control" rows="4"><?= $data['description'] ?></textarea></div>
                    <div class="mb-3">
                        <label>Foto Baru (Kosongkan jika tidak ganti)</label>
                        <input type="file" name="image" class="form-control">
                    </div>
                    <button type="submit" name="update" class="btn btn-primary w-100">Update Paket</button>
                    <a href="manage_packages.php" class="btn btn-link w-100 text-muted mt-2">Batal</a>
                </form>
            </div>
        </div>
    </div>
</body>
</html>