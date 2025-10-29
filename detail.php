<?php
session_start();
require 'config/database.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$barang = null;

if ($id > 0) {
    try {
        $sql = "SELECT * FROM barang WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);
        $barang = $stmt->fetch();
    } catch (\PDOException $e) {
        die("Error mengambil data: " . $e->getMessage());
    }
}

if (!$barang) {
    $_SESSION['message'] = "Barang tidak ditemukan (ID: $id).";
    $_SESSION['type'] = "error";
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Barang</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <div class="container">
        <h1>Detail Barang</h1>
        
        <div class="item-detail">
            <strong>ID Barang:</strong>
            <?php echo htmlspecialchars($barang['id']); ?>
        </div>
        <div class="item-detail">
            <strong>Nama Barang:</strong>
            <?php echo htmlspecialchars($barang['nama_barang']); ?>
        </div>
        <div class="item-detail">
            <strong>Deskripsi:</strong>
            <p><?php echo nl2br(htmlspecialchars($barang['deskripsi'])); ?></p>
        </div>
        <div class="item-detail">
            <strong>Harga:</strong>
            Rp <?php echo htmlspecialchars(number_format($barang['harga'], 0, ',', '.')); ?>
        </div>
        <div class="item-detail">
            <strong>Stok:</strong>
            <?php echo htmlspecialchars($barang['stok']); ?>
        </div>
        <div class="item-detail">
            <strong>Tanggal Dibuat:</strong>
            <?php echo htmlspecialchars($barang['created_at']); ?>
        </div>
        
        <br>
        <a href="index.php" class="btn-cancel" style="margin-left: 0;">Kembali ke Daftar</a>

        <footer>
            Oleh Febrian Pratama Saputra - 2409106033
        </footer>
    </div>

</body>
</html>