<?php
session_start();
include 'koneksi.php';

// Pastikan data terkirim dari form sebelum melakukan operasi apapun
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil nilai dari form
    $laporan_id = $_POST['laporan_id'];
    $username = $_POST['username'];
    $pesan = $_POST['pesan'];

    // Lakukan validasi jika perlu

    // Lakukan operasi penyimpanan ke database
    $query = "INSERT INTO pesan_peringatan (laporan_id, username, pesan) VALUES ('$laporan_id', '$username', '$pesan')";
    $result = mysqli_query($koneksi, $query);

    // Periksa apakah data berhasil disimpan
    if ($result) {
        // Jika berhasil, arahkan kembali ke halaman sebelumnya atau ke halaman lain sesuai kebutuhan
        header("Location: laporan.php");
        exit();
    } else {
        // Jika terjadi kesalahan, tampilkan pesan kesalahan atau lakukan penanganan yang sesuai
        echo "Terjadi kesalahan. Silakan coba lagi.";
    }
} else {
    // Jika tidak ada data terkirim melalui metode POST, arahkan kembali ke halaman sebelumnya atau lakukan penanganan yang sesuai
    header("Location: laporan.php");
    exit();
}
?>
