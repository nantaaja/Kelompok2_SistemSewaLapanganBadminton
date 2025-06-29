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

    $id_jadwal = mysqli_real_escape_string($koneksi, $_GET['id']); // Sanitize input ID

    // Query untuk mengambil data jadwal berdasarkan ID, sekaligus nama lapangan
    $query = mysqli_query($koneksi, "
        SELECT
            bj.id_jadwal,
            bj.id_lapangan,
            bl.nama_lapangan,
            bj.hari,
            bj.jam_mulai,
            bj.jam_berakhir
        FROM
            jadwal bj
        JOIN
            lapangan bl ON bj.id_lapangan = bl.id_lapangan
        WHERE
            bj.id_jadwal = '$id_jadwal'
    ");

    // Periksa apakah data ditemukan
    if (mysqli_num_rows($query) == 0) {
        echo "<script>alert('Data jadwal tidak ditemukan!'); window.location.href='tampilJadwal.php';</script>";
        exit();
    }

    $data = mysqli_fetch_array($query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Jadwal</title>
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

<h2>Edit Data Jadwal</h2>
<hr>

<form action="" method="post">
    <table>
        <tr>
            <td>Lapangan</td>
            <td>:</td>
            <td>
                <select name="id_lapangan" id="id_lapangan" required>
                    <?php
                    // Ambil data lapangan dari database untuk dropdown
                    $query_lapangan = mysqli_query($koneksi, "SELECT id_lapangan, nama_lapangan FROM lapangan WHERE status = 'Tersedia' OR id_lapangan = '" . htmlspecialchars($data['id_lapangan']) . "'");
                    if ($query_lapangan && mysqli_num_rows($query_lapangan) > 0) {
                        while ($row_lapangan = mysqli_fetch_assoc($query_lapangan)) {
                            $selected = ($row_lapangan['id_lapangan'] == $data['id_lapangan']) ? 'selected' : '';
                            echo "<option value='" . htmlspecialchars($row_lapangan['id_lapangan']) . "' " . $selected . ">" . htmlspecialchars($row_lapangan['nama_lapangan']) . "</option>";
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
                    <?php
                    $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
                    foreach ($days as $day) {
                        $selected = ($data['hari'] == $day) ? 'selected' : '';
                        echo "<option value='" . htmlspecialchars($day) . "' " . $selected . ">" . htmlspecialchars($day) . "</option>";
                    }
                    ?>
                </select>
            </td>
        </tr>
        <tr>
            <td>Jam Mulai</td>
            <td>:</td>
            <td><input type="time" name="jam_mulai" value="<?php echo htmlspecialchars($data['jam_mulai']); ?>" required></td>
        </tr>
        <tr>
            <td>Jam Berakhir</td>
            <td>:</td>
            <td><input type="time" name="jam_berakhir" value="<?php echo htmlspecialchars($data['jam_berakhir']); ?>" required></td>
        </tr>
        <tr>
            <td colspan="3" align="center">
                <input type="submit" name="update_jadwal" value="Update Jadwal">
            </td>
        </tr>
    </table>
</form>

<a href="tampilJadwal.php" class="back-button">Kembali ke Daftar Jadwal</a>

<?php
if (isset($_POST['update_jadwal'])) {
    $id_lapangan_baru = mysqli_real_escape_string($koneksi, $_POST['id_lapangan']);
    $hari_baru = mysqli_real_escape_string($koneksi, $_POST['hari']);
    $jam_mulai_baru = mysqli_real_escape_string($koneksi, $_POST['jam_mulai']);
    $jam_berakhir_baru = mysqli_real_escape_string($koneksi, $_POST['jam_berakhir']);

    // Validasi sederhana: jam berakhir harus setelah jam mulai
    if (strtotime($jam_berakhir_baru) <= strtotime($jam_mulai_baru)) {
        echo "<p style='color: red;'>Jam berakhir harus setelah jam mulai.</p>";
    } else {
        $query_update = "UPDATE jadwal SET
                            id_lapangan = '$id_lapangan_baru',
                            hari = '$hari_baru',
                            jam_mulai = '$jam_mulai_baru',
                            jam_berakhir = '$jam_berakhir_baru'
                         WHERE id_jadwal = '$id_jadwal'";

        if (mysqli_query($koneksi, $query_update)) {
            echo "<script>alert('Data jadwal berhasil diperbarui!'); window.location.href='tampilJadwal.php';</script>";
            exit();
        } else {
            echo "<p style='color: red;'>Gagal memperbarui data jadwal: " . mysqli_error($koneksi) . "</p>";
        }
    }
}
?>

</body>
</html>