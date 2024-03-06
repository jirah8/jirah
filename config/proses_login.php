<?php
session_start();
include 'koneksi.php';

if (isset($_POST['Kirim'])) {
    $username = isset($_POST['Username']) ? $_POST['Username'] : '';
    $password = isset($_POST['Password']) ? $_POST['Password'] : '';

    $sql = mysqli_query($koneksi, "SELECT * FROM users WHERE username='$username'");
    
    if (!$sql) {
        die("Query failed: " . mysqli_error($koneksi));
    }

    $user = mysqli_fetch_assoc($sql);

    if ($user) {
        // Periksa apakah pengguna memiliki is_deleted bernilai 0
        if ($user['is_deleted'] == 0) {
            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['status'] = 'login';
                $_SESSION['role'] = $user['acces_level']; // Sesuaikan dengan nama kolom yang benar

                // Sesuaikan halaman redirect sesuai kebutuhan
                if ($_SESSION['role'] === "admin") {
                    header("Location: ../admin/index_album.php");
                    exit();
                } else {
                    header("Location: ../user/index_album_user.php");
                    exit();
                }
            } else {
                echo "<script>
                alert('Username atau password salah!');
                location.href='../login.php';
                </script>";
            }
        } else {
            echo "<script>
            alert('Akun Anda telah dinonaktifkan!');
            location.href='../login.php';
            </script>";
        }
    } else {
        echo "<script>
        alert('Username tidak ditemukan!');
        location.href='../login.php';
        </script>";
    }
}
?>
