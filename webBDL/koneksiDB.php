<?php
    $hostname = "localhost";
    $username = "root";
    $password = "";
    $database = "badminton";

    $koneksi = new mysqli($hostname, $username, $password, $database);

    if($koneksi->connect_error){
        die("Koneksi Gagal");
    } else {

    }
?>