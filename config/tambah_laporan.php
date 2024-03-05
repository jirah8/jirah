<?php 
    include "koneksi.php";

    $isi = $_POST['isi_laporan'];
    $username = $_POST['username'];
    $foto_id = $_POST['foto_id'];
    $created_at = date("Y-m-d");
    $idalbum = $_POST['id_album'];

    $query = mysqli_query($koneksi,"INSERT INTO laporan (isi,username,foto_id,created_at) VALUES('$isi','$username','$foto_id','$created_at')");

    if($query){
        header("Location:../user/isi_album_user.php?id_album=$idalbum");
    }
?>