<?php
include 'koneksi.php';

$name = $_POST['name'];
$username = $_POST['username'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
$email = $_POST['email'];
$acces_level = $_POST['acces_level']; // Ambil nilai access_level dari form

// Periksa apakah username atau email sudah terdaftar
$check_query = mysqli_query($koneksi, "SELECT * FROM users WHERE username = '$username' OR email = '$email'");
if (!$check_query) {
    die("Error: " . mysqli_error($koneksi));
}

if (mysqli_num_rows($check_query) > 0) {
    echo "<script>
            alert('Username atau email sudah terdaftar.');
            window.location.href= '../register.php'; 
            </script>";
    exit(); // Berhenti eksekusi jika username atau email sudah terdaftar
}

// Jika belum terdaftar, lakukan proses pendaftaran dengan menyimpan access_level
$sql = mysqli_query($koneksi, "INSERT INTO users (name, password, username, email, acces_level) VALUES ('$name', '$password', '$username', '$email', '$acces_level')");

if (!$sql) {
    die("Error: " . mysqli_error($koneksi));
}

echo "<script>
        alert('Pendaftaran Akun Berhasil');
        window.location.href= '../index.php'; 
        </script>";
?>
