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
    <title>Tambah User Baru</title>
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
        input[type="password"],
        input[type="email"],
        select {
            width: calc(100% - 22px); /* Kurangi padding dan border */
            padding: 8px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        input[type="submit"] {
            background-color: #28a745; /* Warna hijau untuk tambah */
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

<h2>Tambah User</h2>
<hr>
<form action="" method="post">
    <table>
        <tr>
            <td>Nama User</td>
            <td>:</td>
            <td><input type="text" name="nama_user" required></td>
        </tr>
        <tr>
            <td>Password</td>
            <td>:</td>
            <td><input type="password" name="password" required></td>
        </tr>
        <tr>
            <td>No Telepon</td>
            <td>:</td>
            <td><input type="text" name="no_telp" required></td>
        </tr>
        <tr>
            <td>Email</td>
            <td>:</td>
            <td><input type="email" name="email" required></td>
        </tr>
        <tr>
            <td>Role</td>
            <td>:</td>
            <td>
                <select name="role" id="role">
                    <option value="customer">Customer</option>
            </td>
        </tr>
        <tr>
            <td colspan="3" align="center">
                <input type="submit" name="tambah" value="Tambah">
            </td>
        </tr>
    </table>
</form>

<a href="tampilUser.php" class="back-button">Kembali ke Daftar User</a>

<?php
if (isset($_POST['tambah'])) {
    // Sanitasi input POST sebelum digunakan dalam query
    $nama_user = mysqli_real_escape_string($koneksi, $_POST['nama_user']);
    $password = md5(mysqli_real_escape_string($koneksi, $_POST['password'])); // Pastikan input password juga disanitasi
    $no_telp = mysqli_real_escape_string($koneksi, $_POST['no_telp']);
    $email = mysqli_real_escape_string($koneksi, $_POST['email']);
    $role = mysqli_real_escape_string($koneksi, $_POST['role']);

    $query = "INSERT INTO user(nama_user, password, no_telp, email, role)
              VALUES ('$nama_user', '$password', '$no_telp', '$email', '$role')";

    if (mysqli_query($koneksi, $query)) {
        // Menggunakan JavaScript alert dan kemudian redirect
        echo "<script>alert('Data user berhasil ditambahkan!'); window.location.href='tampilUser.php';</script>";
        exit(); // Penting untuk menghentikan eksekusi script setelah redirect
    } else {
        echo "<p style='color: red;'>Gagal menambahkan data: " . mysqli_error($koneksi) . "</p>"; // Tampilkan error MySQL
    }
}
?>

</body>
</html>