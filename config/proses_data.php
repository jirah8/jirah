<?php
include 'koneksi.php';

$name = $_POST['name'];
$username = $_POST['username'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
$email = $_POST['email'];


$check_query = mysqli_query($koneksi, "SELECT * FROM users WHERE username = '$username' OR email = '$email'");
if (!$check_query) {
    die("Error: " . mysqli_error($koneksi));
}

if (mysqli_num_rows($check_query) > 0) {
    echo "<script>
            alert('Username atau email sudah terdaftar.');
            window.location.href= '../admin/tambah_pengguna.php'; 
            </script>";
    exit();
}


$sql = mysqli_query($koneksi, "INSERT INTO users (name, password, username, email) VALUES ('$name', '$password', '$username', '$email')");

if (!$sql) {
    die("Error: " . mysqli_error($koneksi));
}

echo "<script>
        alert('Pendaftaran Akun Berhasil');
        window.location.href= '../admin/list_user.php'; 
        </script>";
?>
