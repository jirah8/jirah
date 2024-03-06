<?php
session_start();
include 'koneksi.php';

if ($_SESSION['status'] != 'login') {
    echo "<script>
    alert('Anda belum Login!');
    location.href='../index.php';
    </script>";
} else {
    // Pengecekan apakah pengguna adalah admin
    if ($_SESSION['role'] == 'user') {
        // Pengecekan apakah ada data POST yang diterima
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Lakukan pengolahan data pesan peringatan di sini
            // Misalnya, menyimpan pesan peringatan ke dalam database
            // Pastikan untuk memberikan akses ke informasi hanya kepada pengguna yang login
        } else {
            // Jika tidak ada data POST yang diterima, tampilkan pesan atau halaman informasi yang sesuai
        }
    } else {
        // Jika pengguna bukan admin, redirect ke halaman lain atau tampilkan pesan sesuai kebutuhan
        echo "<script>
        alert('Anda tidak memiliki izin untuk mengakses halaman ini!');
        location.href='halaman_lain.php';
        </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informasi Pesan Peringatan</title>
    <link rel="stylesheet" type="text/css" href="../aset/css/bootstrap.min.css">
</head>

<body>

<div class="container mt-3">
    <div class='card'>
        <div class='card-header'>Informasi Pesan Peringatan</div>
        <div class='card-body'>
            <div class="table-responsive">
                <table class="table">
                    <thead class='table-stripped'>
                        <tr>
                            <th>No</th>
                            <th>Laporan ID</th>
                            <th>Username</th>
                            <th>Pesan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $no = 1;
                        while($data = mysqli_fetch_assoc($result)):
                        ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $data['laporan_id']; ?></td>
                            <td><?= $data['username']; ?></td>
                            <td><?= $data['pesan']; ?></td>
                        </tr>
                        <?php endwhile ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

</body>

</html>
