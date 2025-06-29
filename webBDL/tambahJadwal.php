<?php
include 'koneksiDB.php'; // Sertakan file koneksi database Anda
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Jadwal Baru</title>
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
        input[type="time"],
        select {
            width: calc(100% - 22px); /* Kurangi padding dan border */
            padding: 8px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        input[type="submit"] {
            background-color: #28a745;
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
            background-color: #218838;
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

<h2>Tambah Jadwal Baru</h2>
<hr>

<form action="" method="post">
    <table>
        <tr>
            <td>Lapangan</td>
            <td>:</td>
            <td>
                <select name="id_lapangan" id="id_lapangan" required>
                    <option value="">-- Pilih Lapangan --</option>
                    <?php
                    // Ambil data lapangan dari database untuk dropdown
                    $query_lapangan = mysqli_query($koneksi, "SELECT id_lapangan, nama_lapangan FROM lapangan WHERE status = 'Tersedia'"); // Hanya lapangan Tersedia
                    if ($query_lapangan && mysqli_num_rows($query_lapangan) > 0) {
                        while ($row_lapangan = mysqli_fetch_assoc($query_lapangan)) {
                            echo "<option value='" . htmlspecialchars($row_lapangan['id_lapangan']) . "'>" . htmlspecialchars($row_lapangan['nama_lapangan']) . "</option>";
                        }
                    } else {
                        echo "<option value=''>Tidak ada lapangan tersedia</option>";
                    }
                    ?>
                </select>
            </td>
        </tr>
        <tr>
            <td>Hari</td>
            <td>:</td>
            <td>
                <select name="hari" id="hari" required>
                    <option value="">-- Pilih Hari --</option>
                    <option value="Senin">Senin</option>
                    <option value="Selasa">Selasa</option>
                    <option value="Rabu">Rabu</option>
                    <option value="Kamis">Kamis</option>
                    <option value="Jumat">Jumat</option>
                    <option value="Sabtu">Sabtu</option>
                    <option value="Minggu">Minggu</option>
                </select>
            </td>
        </tr>
        <tr>
            <td>Jam Mulai</td>
            <td>:</td>
            <td><input type="time" name="jam_mulai" required></td>
        </tr>
        <tr>
            <td>Jam Berakhir</td>
            <td>:</td>
            <td><input type="time" name="jam_berakhir" required></td>
        </tr>
        <tr>
            <td colspan="3" align="center">
                <input type="submit" name="tambah_jadwal" value="Tambah Jadwal">
            </td>
        </tr>
    </table>
</form>

<a href="tampilJadwal.php" class="back-button">Kembali ke Daftar Jadwal</a>

<?php
if (isset($_POST['tambah_jadwal'])) {
    $id_lapangan = $_POST['id_lapangan'];
    $hari = $_POST['hari'];
    $jam_mulai = $_POST['jam_mulai'];
    $jam_berakhir = $_POST['jam_berakhir'];

    // Validasi sederhana: jam berakhir harus setelah jam mulai
    if (strtotime($jam_berakhir) <= strtotime($jam_mulai)) {
        echo "<p style='color: red;'>Jam berakhir harus setelah jam mulai.</p>";
    } else {
        $query = "INSERT INTO jadwal (id_lapangan, hari, jam_mulai, jam_berakhir)
                  VALUES ('$id_lapangan', '$hari', '$jam_mulai', '$jam_berakhir')";

        if (mysqli_query($koneksi, $query)) {
            echo "<p style='color: green;'>Data jadwal berhasil ditambahkan!</p>";
            // Redirect ke halaman tampilJadwal.php setelah berhasil
            header("Location: tampilJadwal.php");
            exit(); // Penting untuk menghentikan eksekusi script setelah header
        } else {
            echo "<p style='color: red;'>Gagal menambahkan data jadwal: " . mysqli_error($koneksi) . "</p>";
        }
    }
}
?>

</body>
</html>