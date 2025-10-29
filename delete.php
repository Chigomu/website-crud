<?php
session_start();
require 'config/database.php';

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];

    try {
        $sql = "DELETE FROM barang WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);

        $_SESSION['message'] = "Data berhasil dihapus.";
        $_SESSION['type'] = "success";

    } catch (\PDOException $e) {
        $_SESSION['message'] = "Gagal menghapus data: " . $e->getMessage();
        $_SESSION['type'] = "error";
    }
} else {
    $_SESSION['message'] = "ID tidak ditemukan.";
    $_SESSION['type'] = "error";
}

header("Location: index.php");
exit;
?>