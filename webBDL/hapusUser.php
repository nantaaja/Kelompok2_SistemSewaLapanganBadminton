<?php
    include 'koneksiDB.php';

    $id = $_GET['id'];

    $query = "DELETE FROM user WHERE id_user = '$id'";

    if(mysqli_query($koneksi, $query)){
        header("Location: tampilUser.php");
    } else {
        echo "Gagal menghapus data!";
    }
?>