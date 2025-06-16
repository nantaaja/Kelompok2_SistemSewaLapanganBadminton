<?php
    include 'koneksiDB.php'
?>

<h2>Daftar User</h2>
<hr>
<a href="tambahUser.php">Tambah User</a>
<hr>

<table border="1">
    <tr>
        <th>No.</th>
        <th>Nama User</th>
        <th>Password</th>
        <th>No telepon</th>
        <th>Email</th>
        <th>Role</th>
    </tr>

    <?php
    $no = 1;
    $query = mysqli_query($koneksi, query: "SELECT * FROM user");
    while ($data = mysqli_fetch_array($query)){
    ?>

    <tr>
        <td><?php echo $no++ ?></td>
        <td><?php echo $data['namaUser'] ?></td>
        <td><?php echo $data['password'] ?></td>
        <td><?php echo $data['noTelp'] ?></td>
        <td><?php echo $data['email'] ?></td>
        <td><?php echo $data['role'] ?></td>
        <td>
            <a href="editUser.php?id=<?php echo $data['idUser'] ?>">Edit</a> |
            <a href="hapusUser.php?id=<?php echo $data['idUser'] ?>"onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
        </td>
        </tr>

        <?php } ?>
</table>