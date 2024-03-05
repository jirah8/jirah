<?php
    include "koneksi.php";

    $fotoid = $_GET['id'];
    $query = mysqli_query($koneksi,"DELETE FROM photos WHERE photo_id = '$fotoid'");
    if($query){
        header("Location:../admin/laporan.php");
    }
?>