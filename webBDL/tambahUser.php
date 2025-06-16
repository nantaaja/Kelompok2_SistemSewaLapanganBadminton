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
            <td><input type="text" name="namaUser"></td>
        </tr>
        <tr>
            <td>Password</td>
            <td>:</td>
            <td><input type="password" name="password"></td>
        </tr>
        <tr>
            <td>No telepon</td>
            <td>:</td>
            <td><input type="text" name="noTelp"></td>
        </tr>
        <tr>
            <td>Email</td>
            <td>:</td>
            <td><input type="email" name="email"></td>
        </tr>
        <tr>
            <td>Role</td>
            <td>:</td>
            <td><input type="text" name="role"></td>
        </tr>
        <tr>
            <td colspan="3" align="center">
                <input type="submit" name="tambah" value="Tambah">
            </td>
        </tr>
    </table>
</form>

<?php
if (isset($_POST['tambah'])){
    $namaUser = $_POST['namaUser'];
    $password = md5(string: $_POST['password']);
    $noTelp = $_POST['noTelp'];
    $email = $_POST['email'];
    $role = $_POST['role'];

    $query = "INSERT INTO user(namaUser, password, noTelp, email, role)
                VALUES  ('$namaUser', '$password', '$noTelp', '$email', '$role')";

    if(mysqli_query($koneksi, $query)){
        header(header: "Location: tampilUser.php");
    } else {
        echo "Gagal menambahkan data!";
    }
} 
?>