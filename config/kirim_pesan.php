<?php
session_start();
include 'koneksi.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil nilai dari form
    $laporan_id = $_POST['laporan_id'];
    $username = $_POST['username'];
    $pesan = $_POST['pesan'];

    
    $query = "INSERT INTO pesan_peringatan (laporan_id, username, pesan) VALUES ('$laporan_id', '$username', '$pesan')";
    $result = mysqli_query($koneksi, $query);

    
    if ($result) {
       
        header("Location: ../admin/laporan.php");
        exit();
    } else {
       
        echo "Terjadi kesalahan. Silakan coba lagi.";
    }
} else {
    
    header("Location: ../admin/laporan.php");
    exit();
}
?>
