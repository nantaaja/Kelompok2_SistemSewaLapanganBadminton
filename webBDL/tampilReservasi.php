<?php
// Pastikan file koneksiDB.php sudah terhubung dengan benar ke database Anda
include 'koneksiDB.php';

// Aktifkan error reporting untuk membantu debugging selama pengembangan
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Reservasi Badminton</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f4f4f4;
        }
        h2 {
            color: #333;
        }
        hr {
            border: 0;
            border-top: 1px solid #eee;
            margin: 20px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #007bff;
            color: white;
            text-transform: uppercase;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #e9e9e9;
        }
        a {
            text-decoration: none;
            color: #007bff;
        }
        a:hover {
            text-decoration: underline;
        }
        .action-links a {
            margin-right: 5px;
        }
        .button { /* Ubah dari .add-button menjadi .button agar lebih generik */
            display: inline-block;
            padding: 10px 15px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 16px;
            margin-bottom: 10px; /* Jarak bawah untuk tombol yang di atas tabel */
            margin-right: 10px; /* Jarak antar tombol */
            transition: background-color 0.3s ease;
        }
        .button.add { /* Gaya spesifik untuk tombol tambah */
            background-color: #28a745;
            color: white;
        }
        .button.add:hover {
            background-color: #218838;
        }
        .button.back { /* Gaya spesifik untuk tombol kembali */
            background-color: #6c757d; /* Warna abu-abu */
            color: white;
        }
        .button.back:hover {
            background-color: #5a6268;
        }
        .button-container {
            margin-top: 20px; /* Beri jarak dari tabel */
            text-align: left; /* Sesuaikan jika ingin di tengah/kanan */
        }
    </style>
</head>
<body>

<h2>Daftar Reservasi Badminton</h2>
<hr>

<a href="dashboard.php" class="button back">Kembali ke Dashboard</a>

<table border="1">
    <thead>
        <tr>
            <th>No.</th>
            <th>ID Reservasi</th>
            <th>Nama User</th>
            <th>Nama Lapangan</th>
            <th>Hari Jadwal</th>
            <th>Jam Mulai</th>
            <th>Jam Berakhir</th>
            <th>Tanggal Booking</th>
            <th>Durasi (Jam)</th>
            <th>Total Harga</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $no = 1;
        // Query untuk mengambil data reservasi
        // Menggunakan JOIN untuk mengambil nama user, nama lapangan, dan detail jadwal
        // Pastikan nama tabel di database Anda sesuai: user, lapangan, jadwal, reservasi
        $query = mysqli_query($koneksi, "
            SELECT
                br.id_reservasi,
                bu.nama_user,
                bl.nama_lapangan,
                bj.hari,
                bj.jam_mulai,
                bj.jam_berakhir,
                br.tanggal_booking,
                br.durasi,
                br.total_harga,
                br.status_reservasi
            FROM
                reservasi br
            JOIN
                user bu ON br.id_user = bu.id_user
            JOIN
                lapangan bl ON br.id_lapangan = bl.id_lapangan
            JOIN
                jadwal bj ON br.id_jadwal = bj.id_jadwal
            ORDER BY
                br.tanggal_booking DESC, bj.jam_mulai ASC
        ");

        // Periksa apakah query berhasil dieksekusi
        if (!$query) {
            echo "<tr><td colspan='12'>Error fetching reservations: " . mysqli_error($koneksi) . "</td></tr>";
        } else {
            // Periksa apakah ada data
            if (mysqli_num_rows($query) > 0) {
                while ($data = mysqli_fetch_array($query)){
        ?>
        <tr>
            <td><?php echo $no++; ?></td>
            <td><?php echo htmlspecialchars($data['id_reservasi']); ?></td>
            <td><?php echo htmlspecialchars($data['nama_user']); ?></td>
            <td><?php echo htmlspecialchars($data['nama_lapangan']); ?></td>
            <td><?php echo htmlspecialchars($data['hari']); ?></td>
            <td><?php echo date('H:i', strtotime($data['jam_mulai'])); ?></td>
            <td><?php echo date('H:i', strtotime($data['jam_berakhir'])); ?></td>
            <td><?php echo date('d-m-Y', strtotime($data['tanggal_booking'])); ?></td>
            <td><?php echo htmlspecialchars($data['durasi']); ?> jam</td>
            <td><?php echo 'Rp ' . number_format($data['total_harga'], 0, ',', '.'); ?></td>
            <td><?php echo htmlspecialchars($data['status_reservasi']); ?></td>
            <td class="action-links">
                <a href="editReservasi.php?id=<?php echo htmlspecialchars($data['id_reservasi']); ?>">Edit</a> |
                <a href="hapusReservasi.php?id=<?php echo htmlspecialchars($data['id_reservasi']); ?>" onclick="return confirm('Yakin ingin menghapus reservasi ini?')">Hapus</a>
            </td>
        </tr>
        <?php
                }
            } else {
                echo "<tr><td colspan='12'>Tidak ada data reservasi.</td></tr>";
            }
        }
        ?>
    </tbody>
</table>

<div class="button-container">
    <a href="tambahReservasi.php" class="button add">Tambah Reservasi</a>
</div>

</body>
</html>