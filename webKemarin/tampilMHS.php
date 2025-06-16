<?php
    include 'koneksiDB.php'
?>

<h2>Daftar Mahasiswa</h2>
<hr>
<a href="tambahMHS.php">Tambah Mahahsiswa</a>
<hr>

<table border="1">
    <tr>
        <th>No.</th>
        <th>Nama Mahasiswa</th>
        <th>NIM</th>
        <th>Kelas</th>
        <th>Username</th>
        <th>Aksi</th>
    </tr>

    <?php
    $no = 1;
    $query = mysqli_query(mysql: $koneksi, query: "SELECT * FROM mahasiswa");
    while ($data = mysqli_fetch_array(result: $query)){
    ?>

    <tr>
        <td><?php echo $no++ ?></td>
        <td><?php echo $data['nama'] ?></td>
        <td><?php echo $data['nim'] ?></td>
        <td><?php echo $data['kelas'] ?></td>
        <td><?php echo $data['username'] ?></td>
        <td>
            <a href="edit.php?id=<?php echo $data['id'] ?>">Edit</a> |
            <a href="hapus.php?id=<?php echo $data['id'] ?>"onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
        </td>
        </tr>

        <?php } ?>
</table>