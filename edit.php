<?php
session_start();
require 'config/database.php';

$errors = [];
$nama_barang = '';
$deskripsi = '';
$harga = '';
$stok = '';
$id = 0;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $id = (int)$_POST['id'];
    $nama_barang = trim($_POST['nama_barang']);
    $deskripsi = trim($_POST['deskripsi']);
    $harga = trim($_POST['harga']);
    $stok = trim($_POST['stok']);

    if (empty($nama_barang)) {
        $errors[] = "Nama barang wajib diisi.";
    }
    if (empty($harga)) {
        $errors[] = "Harga wajib diisi.";
    } elseif (!is_numeric($harga) || $harga < 0) {
        $errors[] = "Harga harus berupa angka positif.";
    }
    if (empty($stok)) {
        $errors[] = "Stok wajib diisi.";
    } elseif (!is_numeric($stok) || $stok < 0) {
        $errors[] = "Stok harus berupa angka positif.";
    }

    if (empty($errors)) {
        try {
            $sql = "UPDATE barang SET nama_barang = ?, deskripsi = ?, harga = ?, stok = ? WHERE id = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$nama_barang, $deskripsi, $harga, $stok, $id]);

            $_SESSION['message'] = "Data barang berhasil diperbarui!";
            $_SESSION['type'] = "success";

            header("Location: index.php");
            exit;

        } catch (\PDOException $e) {
            $errors[] = "Gagal memperbarui data: " . $e->getMessage();
        }
    }

} else if (isset($_GET['id'])) {
    
    $id = (int)$_GET['id'];
    
    try {
        $sql = "SELECT * FROM barang WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);
        $barang = $stmt->fetch();

        if ($barang) {
            $nama_barang = $barang['nama_barang'];
            $deskripsi = $barang['deskripsi'];
            $harga = $barang['harga'];
            $stok = $barang['stok'];
        } else {
            $_SESSION['message'] = "Data barang tidak ditemukan.";
            $_SESSION['type'] = "error";
            header("Location: index.php");
            exit;
        }
    } catch (\PDOException $e) {
        $_SESSION['message'] = "Error mengambil data: " . $e->getMessage();
        $_SESSION['type'] = "error";
        header("Location: index.php");
        exit;
    }
} else {
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Barang</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <div class="container">
        <h1>Edit Barang</h1>

        <?php if (!empty($errors)): ?>
            <div class="message error">
                <strong>Terjadi kesalahan:</strong>
                <ul style="padding-left: 20px; margin-bottom: 0;">
                    <?php foreach ($errors as $error): ?>
                        <li><?php echo $error; ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form action="edit.php" method="POST">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">
            
            <div>
                <label for="nama_barang">Nama Barang:</label>
                <input type="text" id="nama_barang" name="nama_barang" value="<?php echo htmlspecialchars($nama_barang); ?>" required>
            </div>
            <div>
                <label for="deskripsi">Deskripsi:</label>
                <textarea id="deskripsi" name="deskripsi"><?php echo htmlspecialchars($deskripsi); ?></textarea>
            </div>
            <div>
                <label for="harga">Harga:</label>
                <input type="number" id="harga" name="harga" value="<?php echo htmlspecialchars($harga); ?>" required>
            </div>
            <div>
                <label for="stok">Stok:</label>
                <input type="number" id="stok" name="stok" value="<?php echo htmlspecialchars($stok); ?>" required>
            </div>
            <div class="form-actions">
                <button type="submit">Update Data</button>
                <a href="index.php" class="btn-cancel">Batal</a>
            </div>
        </form>

        <footer>
            Oleh Febrian Pratama Saputra - 2409106033
        </footer>

    </div>

</body>
</html>