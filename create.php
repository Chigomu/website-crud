<?php
session_start();
require 'config/database.php';

$errors = [];
$nama_barang = '';
$deskripsi = '';
$harga = '';
$stok = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

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
            $sql = "INSERT INTO barang (nama_barang, deskripsi, harga, stok) VALUES (?, ?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            
            $stmt->execute([$nama_barang, $deskripsi, $harga, $stok]);

            $_SESSION['message'] = "Data barang berhasil ditambahkan!";
            $_SESSION['type'] = "success";

            header("Location: index.php");
            exit;

        } catch (\PDOException $e) {
            $errors[] = "Gagal menyimpan data: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Barang Baru</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <div class="container">
        <h1>Tambah Barang Baru</h1>

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

        <form action="create.php" method="POST">
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
                <button type="submit">Simpan Data</button>
                <a href="index.php" class="btn-cancel">Batal</a>
            </div>
        </form>

        <footer>
            Oleh Febrian Pratama Saputra - 2409106033
        </footer>

    </div>

</body>
</html>