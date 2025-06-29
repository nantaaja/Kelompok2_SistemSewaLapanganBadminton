<?php

include 'koneksiDB.php'; // Sertakan file koneksi database

$currentPage = 'dashboard';
$nama_admin_default = "Guest Admin"; // Karena tidak ada sesi login

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            display: flex;
            min-height: 100vh;
            background-color: #f4f7f6;
        }

        .sidebar {
            width: 250px;
            background-color: #2c3e50;
            color: white;
            padding: 20px;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
            flex-shrink: 0;
        }

        .sidebar-header {
            text-align: center;
            margin-bottom: 30px;
            font-size: 24px;
            font-weight: bold;
            color: #ecf0f1;
        }

        .sidebar-menu {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .sidebar-menu li {
            margin-bottom: 10px;
        }

        .sidebar-menu a {
            color: #ecf0f1;
            text-decoration: none;
            padding: 10px 15px;
            display: block;
            border-radius: 5px;
            transition: background-color 0.3s ease;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .sidebar-menu a:hover,
        .sidebar-menu a.active {
            background-color: #34495e;
        }

        .sidebar-menu a .fas {
            width: 20px;
            text-align: center;
        }

        .main-content {
            flex-grow: 1;
            padding: 20px 30px;
            background-color: #ffffff;
            border-radius: 8px;
            margin: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
        }

        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            padding-bottom: 15px;
            border-bottom: 1px solid #eee;
        }

        .welcome {
            font-size: 28px;
            color: #333;
            margin: 0;
        }

        .section-title {
            font-size: 24px;
            color: #34495e;
            margin-top: 40px;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #3498db;
        }

        .dashboard-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 25px;
            margin-bottom: 40px;
        }

        .data-box {
            background-color: #ecf0f1;
            padding: 25px;
            border-radius: 8px;
            text-align: center;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
            transition: transform 0.2s ease-in-out;
        }

        .data-box:hover {
            transform: translateY(-5px);
        }

        .data-box h3 {
            margin-top: 0;
            color: #2c3e50;
            font-size: 18px;
        }

        .data-box p {
            font-size: 2.5em;
            font-weight: bold;
            color: #3498db;
            margin: 10px 0 0;
        }

        .table-responsive {
            overflow-x: auto;
            margin-top: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            background-color: #fff;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 12px 15px;
            text-align: left;
        }

        th {
            background-color: #3498db;
            color: white;
            font-weight: bold;
            text-transform: uppercase;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #e9f5fd;
        }

        .action-links a {
            margin-right: 10px;
            color: #3498db;
            text-decoration: none;
        }

        .action-links a:hover {
            text-decoration: underline;
        }

        .add-button {
            background-color: #2ecc71;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            font-size: 16px;
            display: inline-block;
            margin-bottom: 20px;
            transition: background-color 0.3s ease;
        }

        .add-button:hover {
            background-color: #27ae60;
        }
    </style>
</head>

<body>
    <div class="sidebar">
        <div class="sidebar-header">
            Badminton App Admin
        </div>
        <ul class="sidebar-menu">
            <li><a href="dashboard.php" class="<?php echo ($currentPage == 'dashboard') ? 'active' : ''; ?>">
                    <i class="fas fa-chart-line"></i> Dashboard
                </a></li>
            <li><a href="tampilUser.php" class="<?php echo ($currentPage == 'user') ? 'active' : ''; ?>">
                    <i class="fas fa-users"></i> Manajemen Pelanggan
                </a></li>
            <li><a href="tampilLapangan.php" class="<?php echo ($currentPage == 'lapangan') ? 'active' : ''; ?>">
                    <i class="fas fa-volleyball-ball"></i> Manajemen Lapangan
                </a></li>
            <li><a href="tampilJadwal.php" class="<?php echo ($currentPage == 'jadwal') ? 'active' : ''; ?>">
                    <i class="fas fa-calendar-alt"></i> Manajemen Jadwal
                </a></li>
            <li><a href="tampilReservasi.php" class="<?php echo ($currentPage == 'reservasi_admin') ? 'active' : ''; ?>">
                    <i class="fas fa-file-invoice"></i> Manajemen Reservasi
                </a></li>
        </ul>
    </div>

    <div class="main-content">
        <div class="header-content">
            <h1 class="welcome">Selamat Datang, <?php echo htmlspecialchars($nama_admin_default); ?>!</h1>
        </div>

        <h2 class="section-title">Ringkasan Sistem</h2>

        <div class="dashboard-grid">
            <div class="data-box">
                <h3>Total Pelanggan</h3>
                <?php
                $query_users = "SELECT COUNT(id_user) AS total_users FROM user";
                $result_users = mysqli_query($koneksi, $query_users);
                $data_users = mysqli_fetch_assoc($result_users);
                echo "<p>" . htmlspecialchars($data_users['total_users']) . "</p>";
                ?>
            </div>

            <div class="data-box">
                <h3>Reservasi Pending</h3>
                <?php
                $query_pending = "SELECT COUNT(id_reservasi) AS total_pending FROM reservasi WHERE status_reservasi = 'pending'";
                $result_pending = mysqli_query($koneksi, $query_pending);
                $data_pending = mysqli_fetch_assoc($result_pending);
                echo "<p>" . htmlspecialchars($data_pending['total_pending']) . "</p>";
                ?>
            </div>

            <?php
            $today = date('Y-m-d');
            $query_pendapatan_harian = "SELECT FN_GetPendapatanHarian('$today') AS pendapatan_hari_ini";
            $result_pendapatan_harian = mysqli_query($koneksi, $query_pendapatan_harian);

            if ($result_pendapatan_harian) {
                $data_pendapatan_harian = mysqli_fetch_assoc($result_pendapatan_harian);
                $pendapatan_hari_ini = $data_pendapatan_harian['pendapatan_hari_ini'];
            } else {
                $pendapatan_hari_ini = "Error: " . mysqli_error($koneksi);
            }
            ?>
            <div class="data-box">
                <h3>Pendapatan Hari Ini</h3>
                <p>Rp <?php echo (is_numeric($pendapatan_hari_ini)) ? number_format($pendapatan_hari_ini, 0, ',', '.') : $pendapatan_hari_ini; ?></p>
            </div>

            <div class="data-box">
                <h3>Total Lapangan</h3>
                <?php
                $query_lapangan = "SELECT COUNT(id_lapangan) AS total_lapangan FROM lapangan";
                $result_lapangan = mysqli_query($koneksi, $query_lapangan);
                $data_lapangan = mysqli_fetch_assoc($result_lapangan);
                echo "<p>" . htmlspecialchars($data_lapangan['total_lapangan']) . "</p>";
                ?>
            </div>

            <div class="data-box">
                <h3>Reservasi Dikonfirmasi</h3>
                <?php
                $query_confirmed = "SELECT COUNT(id_reservasi) AS total_confirmed FROM reservasi WHERE status_reservasi = 'confirmed'";
                $result_confirmed = mysqli_query($koneksi, $query_confirmed);
                $data_confirmed = mysqli_fetch_assoc($result_confirmed);
                echo "<p>" . htmlspecialchars($data_confirmed['total_confirmed']) . "</p>";
                ?>
            </div>

            <?php
            $current_month = date('n');
            $current_year = date('Y');
            $query_pendapatan_bulanan = "SELECT FN_GetPendapatanBulanan($current_month, $current_year) AS pendapatan_bulan_ini";
            $result_pendapatan_bulanan = mysqli_query($koneksi, $query_pendapatan_bulanan);

            if ($result_pendapatan_bulanan) {
                $data_pendapatan_bulanan = mysqli_fetch_assoc($result_pendapatan_bulanan);
                $pendapatan_bulan_ini = $data_pendapatan_bulanan['pendapatan_bulan_ini'];
            } else {
                $pendapatan_bulan_ini = "Error: " . mysqli_error($koneksi);
            }
            ?>
            <div class="data-box">
                <h3>Pendapatan Bulan Ini</h3>
                <p>Rp <?php echo (is_numeric($pendapatan_bulan_ini)) ? number_format($pendapatan_bulan_ini, 0, ',', '.') : $pendapatan_bulan_ini; ?></p>
            </div>
        </div>

        <h2 class="section-title">Reservasi Terbaru</h2>
        <a href="tambahReservasi.php" class="add-button"><i class="fas fa-plus-circle"></i> Tambah Reservasi Baru</a>
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>User</th>
                        <th>Email</th>
                        <th>Lapangan</th>
                        <th>Tanggal</th>
                        <th>Jam Mulai</th>
                        <th>Durasi</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query_reservasi_admin = mysqli_query($koneksi, "SELECT * FROM V_DetailReservasi ORDER BY tanggal_booking DESC, jam_mulai DESC LIMIT 10");

                    if ($query_reservasi_admin) {
                        if (mysqli_num_rows($query_reservasi_admin) > 0) {
                            while ($row = mysqli_fetch_assoc($query_reservasi_admin)) {
                                echo "<tr>";
                                echo "<td>" . htmlspecialchars($row['id_reservasi']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['nama_user']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['user_email']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['nama_lapangan']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['tanggal_booking']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['jam_mulai']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['durasi_jam']) . " jam</td>";
                                echo "<td>Rp " . number_format($row['total_harga'], 0, ',', '.') . "</td>";
                                echo "<td>" . htmlspecialchars($row['status_reservasi']) . "</td>";
                                echo "<td class='action-links'>";
                                echo "<a href='editReservasi.php?id=" . htmlspecialchars($row['id_reservasi']) . "'>Edit</a> | ";
                                echo "<a href='hapusReservasi.php?id=" . htmlspecialchars($row['id_reservasi']) . "' onclick=\"return confirm('Apakah Anda yakin ingin menghapus reservasi ini?');\">Hapus</a>";
                                echo "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='10'>Tidak ada data reservasi.</td></tr>";
                        }
                    } else {
                        echo "<tr><td colspan='10'>Error: " . mysqli_error($koneksi) . "</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
            <p style="text-align: right; margin-top: 15px;"><a href="tampilReservasi.php" style="color: #3498db;">Lihat Semua Reservasi</a></p>
        </div>

        <h2 class="section-title">Pelanggan Terbaru</h2>
        <a href="tambahUser.php" class="add-button"><i class="fas fa-user-plus"></i> Tambah Pelanggan Baru</a>
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>ID User</th>
                        <th>Nama User</th>
                        <th>Email</th>
                        <th>No. Telp</th>
                        <th>Role</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query_latest_users = mysqli_query($koneksi, "SELECT id_user, nama_user, email, no_telp, role FROM user ORDER BY id_user DESC LIMIT 5");

                    if ($query_latest_users) {
                        if (mysqli_num_rows($query_latest_users) > 0) {
                            while ($row = mysqli_fetch_assoc($query_latest_users)) {
                                echo "<tr>";
                                echo "<td>" . htmlspecialchars($row['id_user']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['nama_user']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['no_telp']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['role']) . "</td>";
                                echo "<td class='action-links'>";
                                echo "<a href='editUser.php?id=" . htmlspecialchars($row['id_user']) . "'>Edit</a> | ";
                                echo "<a href='hapusUser.php?id=" . htmlspecialchars($row['id_user']) . "' onclick=\"return confirm('Apakah Anda yakin ingin menghapus pelanggan ini?');\">Hapus</a>";
                                echo "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='6'>Tidak ada data pelanggan.</td></tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6'>Error: " . mysqli_error($koneksi) . "</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
            <p style="text-align: right; margin-top: 15px;"><a href="tampilUser.php" style="color: #3498db;">Lihat Semua Pelanggan</a></p>
        </div>

    </div>

    <?php
    mysqli_close($koneksi);
    ?>
</body>

</html>