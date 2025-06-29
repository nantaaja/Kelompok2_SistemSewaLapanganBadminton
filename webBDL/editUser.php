<?php
    include 'koneksiDB.php'; // Sertakan file koneksi database Anda

    // Aktifkan error reporting untuk membantu debugging
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    // Pastikan ID user diberikan melalui URL
    if (!isset($_GET['id']) || empty($_GET['id'])) {
        echo "<script>alert('ID User tidak ditemukan!'); window.location.href='tampilUser.php';</script>";
        exit();
    }

    $id = mysqli_real_escape_string($koneksi, $_GET['id']); // Sanitize input ID

    // Query untuk mengambil data user berdasarkan ID
    $query = mysqli_query($koneksi, "SELECT * FROM user WHERE id_user = '$id'");

    // Periksa apakah data ditemukan
    if (mysqli_num_rows($query) == 0) {
        echo "<script>alert('Data user tidak ditemukan!'); window.location.href='tampilUser.php';</script>";
        exit();
    }

    $data = mysqli_fetch_array($query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data User</title>
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

<h2>Update Data Pelanggan</h2>
<hr>
<form action="" method="post">
    <table>
        <tr>
            <td>Nama</td>
            <td>:</td>
            <td><input type="text" name="nama_user" value="<?php echo htmlspecialchars($data['nama_user']); ?>" required></td>
        </tr>
        <tr>
            <td>Password</td>
            <td>:</td>
            <td>
                <input type="password" name="password" placeholder="Kosongkan jika tidak ingin mengubah password">
            </td>
        </tr>
        <tr>
            <td>No Telepon</td>
            <td>:</td>
            <td><input type="text" name="no_telp" value="<?php echo htmlspecialchars($data['no_telp']); ?>" required></td>
        </tr>
        <tr>
            <td>Email</td>
            <td>:</td>
            <td><input type="email" name="email" value="<?php echo htmlspecialchars($data['email']); ?>" required></td>
        </tr>
        <tr>
            <td>Role</td>
            <td>:</td>
            <td>
                <select name="role" id="role" required>
                    <option value="customer" <?php echo ($data['role'] == 'customer') ? 'selected' : ''; ?>>Customer</option>
                    </select>
            </td>
        </tr>
        <tr>
            <td colspan="3" align="center">
                <input type="submit" name="update" value="Update">
            </td>
        </tr>
    </table>
</form>

<a href="tampilUser.php" class="back-button">Kembali ke Daftar Pelanggan</a>

<?php
if (isset($_POST['update'])){
    $nama_user = mysqli_real_escape_string($koneksi, $_POST['nama_user']);
    $no_telp = mysqli_real_escape_string($koneksi, $_POST['no_telp']);
    $email = mysqli_real_escape_string($koneksi, $_POST['email']);
    $role = mysqli_real_escape_string($koneksi, $_POST['role']);

    // Mulai dengan query UPDATE dasar
    $query_update = "UPDATE user SET
                        nama_user = '$nama_user',
                        no_telp = '$no_telp',
                        email = '$email',
                        role = '$role'";

    // Cek apakah password diisi (tidak kosong)
    if (!empty($_POST['password'])) {
        $password_baru = md5($_POST['password']); // Hash password baru
        $query_update .= ", password = '$password_baru'"; // Tambahkan update password ke query
    }

    $query_update .= " WHERE id_user = '$id'"; // Tambahkan klausa WHERE

    if(mysqli_query($koneksi, $query_update)){
        echo "<script>alert('Data user berhasil diperbarui!'); window.location.href='tampilUser.php';</script>";
        exit();
    } else {
        echo "<p style='color: red;'>Gagal memperbarui data user: " . mysqli_error($koneksi) . "</p>";
    }
}
?>

</body>
</html>