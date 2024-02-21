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

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['status'] = 'login';
        $_SESSION['role'] = $user['acces_level'];
        if($user['acces_level'] === "admin"){
            header("Location: ../admin/index_album.php");
        }
        else if($user['acces_level'] === "user"){
            header("Location: ../user/index_album_user.php");
        }
        

        exit();
    } else {
        echo "<script>
        alert('Username atau password salah!');
        location.href='../login.php';
        </script>";
    }
}
?>
