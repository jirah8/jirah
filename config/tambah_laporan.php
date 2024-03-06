<?php 
include "koneksi.php";

$isi = $_POST['isi_laporan'];
$username = $_POST['username'];
$foto_id = $_POST['foto_id'];
$created_at = date("Y-m-d");
$id_album = $_POST['id_album'];

// Dapatkan username pemilik postingan
$query_owner = mysqli_query($koneksi, "SELECT username FROM photos WHERE photo_id = '$foto_id'");
$owner_data = mysqli_fetch_assoc($query_owner);
$owner_username = $owner_data['username'];

// Dapatkan nama pengguna yang dilaporkan
$query_reported_user = mysqli_query($koneksi, "SELECT username FROM users WHERE user_id = (SELECT user_id FROM photos WHERE photo_id = '$foto_id')");
$reported_user_data = mysqli_fetch_assoc($query_reported_user);
$reported_username = $reported_user_data['username'];

$query = mysqli_query($koneksi, "INSERT INTO laporan (isi, username, foto_id, created_at, reported_username, reporter_username) VALUES ('$isi', '$username', '$foto_id', '$created_at', '$reported_username', '$username')");

if($query){
    header("Location:../user/isi_album_user.php?id_album=$id_album");
}
?>
