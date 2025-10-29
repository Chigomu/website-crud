# Aplikasi CRUD PHP Native (Manajemen Barang)

Sebuah aplikasi web sederhana untuk manajemen data barang (CRUD - Create, Read, Update, Delete) yang dibangun menggunakan PHP native (tanpa framework), koneksi database PDO, dan database MySQL.

##  Fitur yang Tersedia

* **Create:** Menambah data barang baru ke dalam database.
* **Read:** Menampilkan daftar semua barang dalam format tabel.
* **Update:** Mengedit data barang yang sudah ada.
* **Delete:** Menghapus data barang dari database.
* **Detail:** Melihat rincian lengkap satu barang.
* **Pencarian:** Mencari barang berdasarkan nama.
* **Paginasi:** Membagi daftar barang menjadi beberapa halaman.
* **Notifikasi:** Pesan sukses atau error setelah melakukan aksi (menggunakan `$_SESSION`).
* **Validasi Sederhana:** Pengecekan input kosong dan numerik di sisi server.
* **Styling Modern:** Antarmuka yang bersih dan responsif menggunakan CSS modern (Flexbox/Grid).

## Kebutuhan Sistem

* PHP 7.4 atau lebih baru
* Web Server (Contoh: Apache, Nginx)
* Database MySQL atau MariaDB
* Ekstensi PHP: `PDO` dan `pdo_mysql`

## Cara Instalasi dan Konfigurasi

1.  **Clone atau Unduh Repository**
    ```bash
    # Ganti <username> dengan username Anda jika di-hosting di Git
    git clone [https://github.com/](https://github.com/)<username>/crud-php-native.git
    cd crud-php-native
    ```
    Atau unduh file ZIP dan ekstrak ke folder `htdocs` (XAMPP) atau `www` (WAMP) Anda.

2.  **Buat Database**
    Buka phpMyAdmin atau klien SQL Anda dan buat database baru dengan nama `CrudPhp` (sesuai `config/database.php`).

3.  **Import Tabel `barang`**
    Jalankan kueri MySQL berikut untuk membuat tabel `barang`:

    ```sql
    CREATE TABLE `barang` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `nama_barang` varchar(255) NOT NULL PRIMARY KEY,
      `deskripsi` text DEFAULT NULL,
      `harga` int(11) NOT NULL,
      `stok` int(11) NOT NULL,
      `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
    )
    ```

4.  **Konfigurasi Koneksi Database**
    Buka file `config/database.php` dan sesuaikan pengaturan berikut dengan konfigurasi database lokal Anda (terutama `username` dan `password`).

5.  **Jalankan Aplikasi**
    Mulai server Apache dan MySQL Anda (misalnya melalui XAMPP Control Panel). Buka browser dan akses proyek, contoh: `http://localhost/crud-php-native/`

## Struktur Folder

Berikut adalah struktur folder utama dari aplikasi ini.
crud-php-native/
├── config/
│   └── database.php        # Konfigurasi koneksi database
├── img/
│   ├── logo.png            # Favicon (dipanggil di index.php)
    └── Screenshot_1.png    # Screenshot untuk readme.md
├── create.php              # Halaman untuk menambah data
├── delete.php              # Logika untuk menghapus data
├── detail.php              # Halaman detail data
├── edit.php                # Halaman untuk mengedit data
├── index.php               # Halaman utama (daftar data)
├── style.css               # File untuk styling tampilan
└── README.md               # Dokumentasi proyek ini

## Contoh Konfigurasi (`config/database.php`)

File ini berisi konfigurasi untuk terhubung ke database MySQL menggunakan PDO.

```php
<?php
// Nama Database: CrudPhp
$host = '127.0.0.1';
$db_name = 'CrudPhp';
$username = 'root';
$password = ''; 
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db_name;charset=$charset";

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $username, $password, $options);
} catch (\PDOException $e) {
    die("Koneksi ke database gagal: " . $e->getMessage());
}
?>
```

## Screenshot Website
a