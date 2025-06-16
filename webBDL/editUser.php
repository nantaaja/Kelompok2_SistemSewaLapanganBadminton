<?php
    include 'koneksiDB.php';

    $id = $_GET['id'];
    $query = mysqli_query($koneksi, "SELECT * FROM user WHERE idUser = '$id'");
    $data = mysqli_fetch_array($query);
?>

<h2>Update Data User</h2>
<hr>
<form action="" method="post">
    <table>
        <tr>
            <td>Nama</td>
            <td>:</td>
            <td><input type="text" name="namaUser" value="<?php echo $data['namaUser'] ?>"></td>
        </tr>
        <tr>
            <td>Password</td>
            <td>:</td>
            <td><input type="text" name="password" value="<?php echo $data['password'] ?>"></td>
        </tr>
        <tr>
            <td>No telepon</td>
            <td>:</td>
            <td><input type="text" name="noTelp" value="<?php echo $data['noTelp'] ?>"></td>
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
    $namaUser = $_POST['namaUser'];
    $password = md5(string: $_POST['password']);
    $noTelp = $_POST['noTelp'];
    $email = $_POST['email'];
    $role = $_POST['role'];

    $query = "UPDATE user SET 
            namaUser = '$namaUser',
            password = '$password', 
            noTelp = '$noTelp', 
            email = '$email', 
            role = '$role' WHERE idUser = '$id'";

    if(mysqli_query($koneksi, $query)){
        header("Location: tampilUser.php");
    } else {
        echo "Gagal menambahkan data!";
    }
} 

?>
