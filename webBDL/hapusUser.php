<?php
    include 'koneksiDB.php';

    $id = $_GET['id'];

    $query = "DELETE FROM user WHERE idUser = '$id'";

    if(mysqli_query(mysql: $koneksi, query: $query)){
        header("Location: tampilUser.php");
    } else {
        echo "Gagal menghapus data!";
    }
?>