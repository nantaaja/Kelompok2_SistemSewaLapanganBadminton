<?php
    include 'koneksiDB.php';

    $id = $_GET['id'];
    $query = mysqli_query($koneksi, "SELECT * FROM user WHERE id_user = '$id'");
    $data = mysqli_fetch_array($query);
?>

<h2>Update Data User</h2>
<hr>
<form action="" method="post">
    <table>
        <tr>
            <td>Nama</td>
            <td>:</td>
            <td><input type="text" name="nama_user" value="<?php echo $data['nama_user'] ?>"></td>
        </tr>
        <tr>
            <td>Password</td>
            <td>:</td>
            <td><input type="text" name="password" value="<?php echo $data['password'] ?>"></td>
        </tr>
        <tr>
            <td>No telepon</td>
            <td>:</td>
            <td><input type="text" name="no_telp" value="<?php echo $data['no_telp'] ?>"></td>
        </tr>
        <tr>
            <td>Email</td>
            <td>:</td>
            <td><input type="email" name="email" value="<?php echo $data['email'] ?>"></td>
        </tr>
        <tr>
            <td>Role</td>
            <td>:</td>
            <td><input type="text" name="role" value="<?php echo $data['role'] ?>"></td>
        </tr>
        <tr>
            <td colspan="3" align="center">
                <input type="submit" name="update" value="update">
            </td>
        </tr>
    </table>
</form>

<?php
if (isset($_POST['update'])){
    $nama_user = $_POST['nama_user'];
    $password = md5(string: $_POST['password']);
    $no_telp = $_POST['no_telp'];
    $email = $_POST['email'];
    $role = $_POST['role'];

    $query = "UPDATE user SET 
            nama_user = '$nama_user',
            password = '$password', 
            no_telp = '$no_telp', 
            email = '$email', 
            role = '$role' WHERE id_user = '$id'";

    if(mysqli_query($koneksi, $query)){
        header("Location: tampilUser.php");
    } else {
        echo "Gagal menambahkan data!";
    }
} 

?>
