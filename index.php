<?php
session_start();
require 'config/database.php';

$data_per_halaman = 5;
$halaman_aktif = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($halaman_aktif - 1) * $data_per_halaman;

$keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';
$params = [];

$sql = "SELECT id, nama_barang, harga, stok, created_at FROM barang";

if (!empty($keyword)) {
    $sql .= " WHERE nama_barang LIKE ?";
    $params[] = "%$keyword%";
}

$sql .= " ORDER BY created_at ASC";

$total_sql = "SELECT COUNT(*) FROM barang" . (!empty($keyword) ? " WHERE nama_barang LIKE ?" : "");
$total_stmt = $pdo->prepare($total_sql);
if (!empty($keyword)) {
    $total_stmt->execute(["%$keyword%"]);
} else {
    $total_stmt->execute();
}
$total_data = $total_stmt->fetchColumn();
$total_halaman = ceil($total_data / $data_per_halaman);

$sql .= " LIMIT ? OFFSET ?";
$params[] = $data_per_halaman;
$params[] = $offset;

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$barang = $stmt->fetchAll();

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <link rel="icon" href="img/logo.png" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Barang</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <div class="container">

        <h1>Daftar Barang</h1>

        <?php if (isset($_SESSION['message'])): ?>
            <div class="message <?php echo $_SESSION['type']; ?>">
                <?php
                echo $_SESSION['message'];
                unset($_SESSION['message']);
                unset($_SESSION['type']);
                ?>
            </div>
        <?php endif; ?>

        <div class="header-controls">
            <a href="create.php" class="btn-create">Tambah Barang Baru</a>

            <form action="index.php" method="GET" class="search-form">
                <input type="text" name="keyword" placeholder="Cari nama barang..." value="<?php echo htmlspecialchars($keyword); ?>">
                <button type="submit">Cari</button>
            </form>
        </div>

        <table>
            <thead>
                <tr>
                    <th>ID (Kunci)</th>
                    <th>Nama Barang</th>
                    <th>Harga</th>
                    <th>Stok</th>
                    <th>Dibuat Tanggal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($barang)): ?>
                    <tr>
                        <td colspan="6" style="text-align: center;">Tidak ada data ditemukan.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($barang as $item): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($item['id']); ?></td>
                            <td><?php echo htmlspecialchars($item['nama_barang']); ?></td>
                            <td><?php echo htmlspecialchars(number_format($item['harga'], 0, ',', '.')); ?></td>
                            <td><?php echo htmlspecialchars($item['stok']); ?></td>
                            <td><?php echo htmlspecialchars($item['created_at']); ?></td>
                            <td>
                                <a href="detail.php?id=<?php echo $item['id']; ?>">Detail</a>
                                <a href="edit.php?id=<?php echo $item['id']; ?>">Edit</a>
                                <a href="delete.php?id=<?php echo $item['id']; ?>" 
                                onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?');">Hapus</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>

        <div class="pagination">
            Halaman:
            <?php for ($i = 1; $i <= $total_halaman; $i++): ?>
                <a href="index.php?page=<?php echo $i; ?>&keyword=<?php echo htmlspecialchars($keyword); ?>"
                   class="<?php echo ($i == $halaman_aktif) ? 'active' : ''; ?>">
                    <?php echo $i; ?>
                </a>
            <?php endfor; ?>
        </div>

        <footer>
            Oleh Febrian Pratama Saputra - 2409106033
        </footer>

    </div>

</body>
</html>