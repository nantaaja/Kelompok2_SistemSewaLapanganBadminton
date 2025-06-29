<?php
    include 'koneksiDB.php'; // Sertakan file koneksi database Anda
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Lapangan Badminton</title>
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

<h2>Daftar Lapangan Badminton</h2>
<hr>

<a href="dashboard.php" class="button back">Kembali ke Dashboard</a>
<hr>

<table border="1">
    <thead>
        <tr>
            <th>No.</th>
            <th>ID Lapangan</th>
            <th>Nama Lapangan</th>
            <th>Harga</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $no = 1;
        $query = mysqli_query($koneksi, "SELECT * FROM lapangan ORDER BY id_lapangan ASC");

        if (!$query) {
            echo "<tr><td colspan='6'>Error fetching data: " . mysqli_error($koneksi) . "</td></tr>";
        } else {
            if (mysqli_num_rows($query) > 0) {
                while ($data = mysqli_fetch_array($query)){
        ?>
        <tr>
            <td><?php echo $no++; ?></td>
            <td><?php echo htmlspecialchars($data['id_lapangan']); ?></td>
            <td><?php echo htmlspecialchars($data['nama_lapangan']); ?></td>
            <td><?php echo 'Rp ' . number_format($data['harga'], 0, ',', '.'); ?></td>
            <td><?php echo htmlspecialchars($data['status']); ?></td>
            <td class="action-links">
                <a href="editLapangan.php?id=<?php echo htmlspecialchars($data['id_lapangan']); ?>">Edit</a> |
                <a href="hapusLapangan.php?id=<?php echo htmlspecialchars($data['id_lapangan']); ?>" onclick="return confirm('Yakin ingin menghapus lapangan ini?')">Hapus</a>
            </td>
        </tr>
        <?php
                }
            } else {
                echo "<tr><td colspan='6'>Tidak ada data lapangan.</td></tr>";
            }
        }
        ?>
    </tbody>
</table>

<div class="button-container">
    <a href="tambahLapangan.php" class="button add">Tambah Lapangan</a>
</div>

</body>
</html>