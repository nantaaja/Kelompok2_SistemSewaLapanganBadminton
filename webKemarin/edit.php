<?php
    include 'koneksiDB.php';

    $id = $_GET['id'];
    $query = mysqli_query($koneksi, "SELECT * FROM mahasiswa WHERE ID = '$id'");
    $data = mysqli_fetch_array(result: $query);
?>

<h2>Update Data Mahasiswa</h2>
<hr>
<form action="" method="post">
    <table>
        <tr>
            <td>Nama</td>
            <td>:</td>
            <td><input type="text" name="nama" value="<?php echo $data['nama'] ?>"></td>
        </tr>
        <tr>
            <td>NIM</td>
            <td>:</td>
            <td><input type="text" name="nim" value="<?php echo $data['nim'] ?>"></td>
        </tr>
        <tr>
            <td>Kelas</td>
            <td>:</td>
            <td><input type="text" name="kelas" value="<?php echo $data['kelas'] ?>"></td>
        </tr>
        <tr>
            <td>Username</td>
            <td>:</td>
            <td><input type="text" name="username" value="<?php echo $data['username'] ?>"></td>
        </tr>
        <tr>
            <td>Password</td>
            <td>:</td>
            <td><input type="text" name="password" value="<?php echo $data['password'] ?>"></td>
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
    $nama = $_POST['nama'];
    $nim = $_POST['nim'];
    $kelas = $_POST['kelas'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = "UPDATE mahasiswa SET 
            nama = '$nama',
            nim = '$nim', 
            kelas = '$kelas', 
            username = '$username', 
            password = '$password' WHERE id = '$id'";

    if(mysqli_query($koneksi, $query)){
        header("Location: tampilMHS.php");
    } else {
        echo "Gagal menambahkan data!";
    }
} 

?>
