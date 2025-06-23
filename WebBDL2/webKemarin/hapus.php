<?php
    include 'koneksiDB.php';

    $id = $_GET['id'];

    $query = "DELETE FROM mahasiswa WHERE id = '$id'";

    if(mysqli_query(mysql: $koneksi, query: $query)){
        header("Location: tampilMHS.php");
    } else {
        echo "Gagal menghapus data!";
    }
?>