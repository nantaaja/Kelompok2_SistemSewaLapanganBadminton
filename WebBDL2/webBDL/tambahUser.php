<?php
include 'koneksiDB.php';
?>

<h2>Tambah User</h2>
<hr>
<form action="" method="post">
    <table>
        <tr>
            <td>Nama User</td>
            <td>:</td>
            <td><input type="text" name="nama_user"></td>
        </tr>
        <tr>
            <td>Password</td>
            <td>:</td>
            <td><input type="password" name="password"></td>
        </tr>
        <tr>
            <td>No telepon</td>
            <td>:</td>
            <td><input type="text" name="no_telp"></td>
        </tr>
        <tr>
            <td>Email</td>
            <td>:</td>
            <td><input type="email" name="email"></td>
        </tr>
        <tr>
            <td>Role</td>
            <td>:</td>
            <td><select name="role" id="role">
            <option value="customer">Customer</option>
        </td>
            </select>
        </tr>
        <tr>
            <td colspan="3" align="center">
                <input type="submit" name="tambah" value="Tambah">
            </td>
        </tr>
    </table>
</form>

<?php
if (isset($_POST['tambah'])) {
    $nama_user = $_POST['nama_user'];
    $password = md5(string: $_POST['password']);
    $no_telp = $_POST['no_telp'];
    $email = $_POST['email'];
    $role = $_POST['role'];

    $query = "INSERT INTO user(nama_user, password, no_telp, email, role)
                VALUES  ('$nama_user', '$password', '$no_telp', '$email', '$role')";

    if (mysqli_query($koneksi, $query)) {
        header(header: "Location: tampilUser.php");
    } else {
        echo "Gagal menambahkan data!";
    }
}
?>