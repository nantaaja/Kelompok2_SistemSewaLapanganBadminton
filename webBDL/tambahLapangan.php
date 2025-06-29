<?php
include 'koneksiDB.php'; // Sertakan file koneksi database Anda
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Lapangan Baru</title>
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
        input[type="number"] {
            width: calc(100% - 22px);
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

<h2>Tambah Lapangan Baru</h2>
<hr>

<form action="" method="post">
    <table>
        <tr>
            <td>Nama Lapangan</td>
            <td>:</td>
            <td><input type="text" name="nama_lapangan" required></td>
        </tr>
        <tr>
            <td>Harga Per Jam</td>
            <td>:</td>
            <td><input type="number" name="harga" required min="0"></td>
        </tr>
        <tr>
            <td colspan="3" align="center">
                <input type="submit" name="tambah_lapangan" value="Tambah Lapangan">
            </td>
        </tr>
    </table>
</form>

<a href="tampilLapangan.php" class="back-button">Kembali ke Daftar Lapangan</a>

<?php
if (isset($_POST['tambah_lapangan'])) {
    $nama_lapangan = $_POST['nama_lapangan'];
    $harga = $_POST['harga'];

    // Query INSERT hanya menyertakan kolom 'nama_lapangan' dan 'harga'
    // Kolom 'status' akan otomatis diisi dengan nilai default 'Tersedia' oleh database
    $query = "INSERT INTO lapangan (nama_lapangan, harga)
              VALUES ('$nama_lapangan', '$harga')";

    if (mysqli_query($koneksi, $query)) {
        echo "<p style='color: green;'>Data lapangan berhasil ditambahkan!</p>";
        header("Location: tampilLapangan.php");
        exit();
    } else {
        echo "<p style='color: red;'>Gagal menambahkan data lapangan: " . mysqli_error($koneksi) . "</p>";
    }
}
?>

</body>
</html>