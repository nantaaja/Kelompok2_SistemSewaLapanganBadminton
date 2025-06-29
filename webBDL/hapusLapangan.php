<?php
    include 'koneksiDB.php'; // Sertakan file koneksi database Anda

    // Aktifkan error reporting untuk membantu debugging
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    // Pastikan ID lapangan diberikan melalui URL
    if (!isset($_GET['id']) || empty($_GET['id'])) {
        echo "<script>alert('ID Lapangan tidak ditemukan!'); window.location.href='tampilLapangan.php';</script>";
        exit();
    }

    // Ambil dan bersihkan ID lapangan dari URL
    $id_lapangan = mysqli_real_escape_string($koneksi, $_GET['id']);

    // Query DELETE untuk menghapus data lapangan berdasarkan id_lapangan
    $query = "DELETE FROM lapangan WHERE id_lapangan = '$id_lapangan'";

    if (mysqli_query($koneksi, $query)) {
        // Jika penghapusan berhasil, redirect ke halaman tampilLapangan.php
        echo "<script>alert('Data lapangan berhasil dihapus!'); window.location.href='tampilLapangan.php';</script>";
        exit(); // Penting untuk menghentikan eksekusi script setelah redirect
    } else {
        // Jika penghapusan gagal, tampilkan pesan error
        echo "<script>alert('Gagal menghapus data lapangan: " . mysqli_error($koneksi) . "'); window.location.href='tampilLapangan.php';</script>";
        // Atau, jika Anda ingin menampilkan pesan lebih detail tanpa redirect:
        // echo "Gagal menghapus data lapangan: " . mysqli_error($koneksi);
    }
?>