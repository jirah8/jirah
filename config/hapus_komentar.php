<?php
session_start();
include_once("../config/koneksi.php");

if (isset($_POST['komentar_id']) && isset($_POST['photo_id'])) {
    $komentar_id = $_POST['komentar_id'];
    $photo_id = $_POST['photo_id'];

    // Hapus komentar dari database
    $query_delete = mysqli_query($koneksi, "DELETE FROM comments WHERE comments_id='$komentar_id'");
    $queryfoto = mysqli_query($koneksi,"SELECT * FROM photos WHERE photo_id = '$photo_id'");
    $fetchfoto = mysqli_fetch_assoc($queryfoto);

    if ($query_delete) {
        // Redirect kembali ke halaman foto setelah menghapus komentar
        header("Location: ../admin/isi_album.php?id_album={$fetchfoto['album_id']}");
        exit();
    } else {
        echo "Gagal menghapus komentar.";
        echo $komentar_id,$photo_id;
    }
} else {
    echo "Akses tidak sah.";
}
?>
