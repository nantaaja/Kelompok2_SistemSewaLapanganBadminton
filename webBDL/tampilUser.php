<?php
    include 'koneksiDB.php'; // Sertakan file koneksi database Anda

    // Aktifkan error reporting untuk membantu debugging
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Pelanggan</title>
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
            margin-bottom: 10px; /* Jarak bawah untuk tombol di atas tabel */
            margin-right: 10px; /* Jarak antar tombol */
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
            margin-top: 20px; /* Beri jarak dari tabel */
            text-align: left; /* Sesuaikan jika ingin di tengah/kanan */
        }
    </style>
</head>
<body>

<h2>Daftar Pelanggan</h2>
<hr>

<a href="dashboard.php" class="button back">Kembali ke Dashboard</a>
<hr>

<table border="1">
    <thead>
        <tr>
            <th>No.</th>
            <th>Nama User</th>
            <th>Password</th>
            <th>No Telepon</th>
            <th>Email</th>
            <th>Role</th>
            <th>Aksi</th> </tr>
    </thead>
    <tbody>
        <?php
        $no = 1;
        $query = mysqli_query($koneksi, "SELECT * FROM user ORDER BY id_user ASC"); // Tambahkan ORDER BY untuk konsistensi

        // Periksa apakah query berhasil dieksekusi
        if (!$query) {
            echo "<tr><td colspan='7'>Error fetching data: " . mysqli_error($koneksi) . "</td></tr>";
        } else {
            // Periksa apakah ada data
            if (mysqli_num_rows($query) > 0) {
                while ($data = mysqli_fetch_array($query)){
        ?>
        <tr>
            <td><?php echo $no++; ?></td>
            <td><?php echo htmlspecialchars($data['nama_user']); ?></td>
            <td><?php echo htmlspecialchars($data['password']); ?></td>
            <td><?php echo htmlspecialchars($data['no_telp']); ?></td>
            <td><?php echo htmlspecialchars($data['email']); ?></td>
            <td><?php echo htmlspecialchars($data['role']); ?></td>
            <td class="action-links">
                <a href="editUser.php?id=<?php echo htmlspecialchars($data['id_user']); ?>">Edit</a> |
                <a href="hapusUser.php?id=<?php echo htmlspecialchars($data['id_user']); ?>" onclick="return confirm('Yakin ingin menghapus user ini?')">Hapus</a>
            </td>
        </tr>
        <?php
                }
            } else {
                echo "<tr><td colspan='7'>Tidak ada data user.</td></tr>";
            }
        }
        ?>
    </tbody>
</table>

<div class="button-container">
    <a href="tambahUser.php" class="button add">Tambah Pelanggan</a>
</div>

</body>
</html>