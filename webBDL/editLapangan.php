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

    $id_lapangan = mysqli_real_escape_string($koneksi, $_GET['id']); // Sanitize input ID

    // Query untuk mengambil data lapangan berdasarkan ID
    $query = mysqli_query($koneksi, "SELECT * FROM lapangan WHERE id_lapangan = '$id_lapangan'");

    // Periksa apakah data ditemukan
    if (mysqli_num_rows($query) == 0) {
        echo "<script>alert('Data lapangan tidak ditemukan!'); window.location.href='tampilLapangan.php';</script>";
        exit();
    }

    $data = mysqli_fetch_array($query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Lapangan</title>
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
            max-width: 500px;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        td {
            padding: 10px;
            border: 1px solid #ddd;
        }
        input[type="text"],
        input[type="number"],
        select {
            width: calc(100% - 22px);
            padding: 8px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        input[type="submit"] {
            background-color: #007bff; /* Warna biru untuk update */
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 10px;
            transition: background-color 0.3s ease;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
        .back-button {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 15px;
            background-color: #6c757d;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }
        .back-button:hover {
            background-color: #5a6268;
        }
    </style>
</head>
<body>

<h2>Edit Data Lapangan</h2>
<hr>

<form action="" method="post">
    <table>
        <tr>
            <td>Nama Lapangan</td>
            <td>:</td>
            <td><input type="text" name="nama_lapangan" value="<?php echo htmlspecialchars($data['nama_lapangan']); ?>" required></td>
        </tr>
        <tr>
            <td>Harga Per Jam</td>
            <td>:</td>
            <td><input type="number" name="harga" value="<?php echo htmlspecialchars($data['harga']); ?>" required min="0"></td>
        </tr>
        <tr>
            <td>Status</td>
            <td>:</td>
            <td>
                <select name="status" id="status">
                    <option value="Tersedia" <?php echo ($data['status'] == 'Tersedia') ? 'selected' : ''; ?>>Tersedia</option>
                    <option value="Tidak Tersedia" <?php echo ($data['status'] == 'Tidak Tersedia') ? 'selected' : ''; ?>>Tidak Tersedia</option>
                    <option value="Perbaikan" <?php echo ($data['status'] == 'Perbaikan') ? 'selected' : ''; ?>>Perbaikan</option>
                </select>
            </td>
        </tr>
        <tr>
            <td colspan="3" align="center">
                <input type="submit" name="update_lapangan" value="Update Lapangan">
            </td>
        </tr>
    </table>
</form>

<a href="tampilLapangan.php" class="back-button">Kembali ke Daftar Lapangan</a>

<?php
if (isset($_POST['update_lapangan'])) {
    $nama_lapangan = mysqli_real_escape_string($koneksi, $_POST['nama_lapangan']);
    $harga = mysqli_real_escape_string($koneksi, $_POST['harga']);
    $status = mysqli_real_escape_string($koneksi, $_POST['status']);

    $query_update = "UPDATE lapangan SET
                        nama_lapangan = '$nama_lapangan',
                        harga = '$harga',
                        status = '$status'
                     WHERE id_lapangan = '$id_lapangan'";

    if (mysqli_query($koneksi, $query_update)) {
        echo "<script>alert('Data lapangan berhasil diperbarui!'); window.location.href='tampilLapangan.php';</script>";
        exit();
    } else {
        echo "<p style='color: red;'>Gagal memperbarui data lapangan: " . mysqli_error($koneksi) . "</p>";
    }
}
?>

</body>
</html>