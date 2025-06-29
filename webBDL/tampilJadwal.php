<?php
    include 'koneksiDB.php'; // Sertakan file koneksi database Anda
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Jadwal Lapangan</title>
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
        .button {
            display: inline-block;
            padding: 10px 15px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 16px;
            margin-bottom: 10px;
            margin-right: 10px;
            transition: background-color 0.3s ease;
        }
        .button.add {
            background-color: #28a745;
            color: white;
        }
        .button.add:hover {
            background-color: #218838;
        }
        .button.back {
            background-color: #6c757d;
            color: white;
        }
        .button.back:hover {
            background-color: #5a6268;
        }
        .button-container {
            margin-top: 20px;
            text-align: left;
        }
    </style>
</head>
<body>

<h2>Daftar Jadwal Lapangan</h2>
<hr>

<a href="dashboard.php" class="button back">Kembali ke Dashboard</a>
<hr>

<table border="1">
    <thead>
        <tr>
            <th>No.</th>
            <th>ID Jadwal</th>
            <th>Nama Lapangan</th> <th>Hari</th>
            <th>Jam Mulai</th>
            <th>Jam Berakhir</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $no = 1;
        // Query dengan JOIN untuk mendapatkan nama_lapangan dari tabel 'lapangan'
        $query = mysqli_query($koneksi, "
            SELECT
                bj.id_jadwal,
                bl.nama_lapangan,
                bj.hari,
                bj.jam_mulai,
                bj.jam_berakhir
            FROM
                jadwal bj
            JOIN
                lapangan bl ON bj.id_lapangan = bl.id_lapangan
            ORDER BY
                bj.hari, bj.jam_mulai ASC
        ");

        if (!$query) {
            echo "<tr><td colspan='7'>Error fetching data: " . mysqli_error($koneksi) . "</td></tr>";
        } else {
            if (mysqli_num_rows($query) > 0) {
                while ($data = mysqli_fetch_array($query)){
        ?>
        <tr>
            <td><?php echo $no++; ?></td>
            <td><?php echo htmlspecialchars($data['id_jadwal']); ?></td>
            <td><?php echo htmlspecialchars($data['nama_lapangan']); ?></td>
            <td><?php echo htmlspecialchars($data['hari']); ?></td>
            <td><?php echo date('H:i', strtotime($data['jam_mulai'])); ?></td>
            <td><?php echo date('H:i', strtotime($data['jam_berakhir'])); ?></td>
            <td class="action-links">
                <a href="editJadwal.php?id=<?php echo htmlspecialchars($data['id_jadwal']); ?>">Edit</a> |
                <a href="hapusJadwal.php?id=<?php echo htmlspecialchars($data['id_jadwal']); ?>" onclick="return confirm('Yakin ingin menghapus jadwal ini?')">Hapus</a>
            </td>
        </tr>
        <?php
                }
            } else {
                echo "<tr><td colspan='7'>Tidak ada data jadwal.</td></tr>";
            }
        }
        ?>
    </tbody>
</table>

<div class="button-container">
    <a href="tambahJadwal.php" class="button add">Tambah Jadwal</a>
</div>

</body>
</html>