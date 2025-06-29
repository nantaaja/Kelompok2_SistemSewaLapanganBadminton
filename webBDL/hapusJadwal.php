<?php
    include 'koneksiDB.php'; // Sertakan file koneksi database Anda

    // Aktifkan error reporting untuk membantu debugging
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    // Pastikan ID jadwal diberikan melalui URL
    if (!isset($_GET['id']) || empty($_GET['id'])) {
        echo "<script>alert('ID Jadwal tidak ditemukan!'); window.location.href='tampilJadwal.php';</script>";
        exit();
    }

    // Ambil dan bersihkan ID jadwal dari URL
    $id_jadwal = mysqli_real_escape_string($koneksi, $_GET['id']);

    // Query DELETE untuk menghapus data jadwal berdasarkan id_jadwal
    $query = "DELETE FROM jadwal WHERE id_jadwal = '$id_jadwal'";

    if (mysqli_query($koneksi, $query)) {
        // Jika penghapusan berhasil, redirect ke halaman tampilJadwal.php
        echo "<script>alert('Data jadwal berhasil dihapus!'); window.location.href='tampilJadwal.php';</script>";
        exit(); // Penting untuk menghentikan eksekusi script setelah redirect
    } else {
        // Jika penghapusan gagal, tampilkan pesan error
        echo "<script>alert('Gagal menghapus data jadwal: " . mysqli_error($koneksi) . "'); window.location.href='tampilJadwal.php';</script>";
        // Atau, jika Anda ingin menampilkan pesan lebih detail tanpa redirect:
        // echo "Gagal menghapus data jadwal: " . mysqli_error($koneksi);
    }
?>