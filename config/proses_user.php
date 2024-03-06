<?php
session_start();
include 'koneksi.php';


function addUser($koneksi, $name, $username, $password, $access_level) {
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $query = "INSERT INTO users (name, username, password, access_level, created_at) VALUES ('$name', '$username', '$hashedPassword', '$access_level', NOW())";
    return mysqli_query($koneksi, $query);
}

if (isset($_POST['markAsDeleted'])) {
    $user_id = $_POST['user_id'];

    $query = "UPDATE users SET is_deleted = 1 WHERE user_id = '$user_id'";
    $result = mysqli_query($koneksi, $query);

    if ($result) {
        // Berhasil menandai pengguna sebagai dihapus
        header("Location: ../config/list_user.php"); // Redirect ke halaman daftar pengguna
        exit();
    } else {
        // Gagal menandai pengguna sebagai dihapus
        echo "Gagal menandai pengguna sebagai dihapus.";
    }
}

if (isset($_POST['markAsRestored'])) {
    $user_id = $_POST['user_id'];

    $query = "UPDATE users SET is_deleted = 0 WHERE user_id = '$user_id'";
    $result = mysqli_query($koneksi, $query);

    if ($result) {
        // Berhasil menandai pengguna sebagai dipulihkan
        header("Location: ../config/list_user.php"); // Redirect ke halaman daftar pengguna
        exit();
    } else {
        // Gagal menandai pengguna sebagai dipulihkan
        echo "Gagal memulihkan pengguna.";
    }
}

function updateUser($koneksi, $user_id, $name, $username, $password, $access_level) {
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $query = "UPDATE users SET name = '$name', username = '$username', password = '$hashedPassword', access_level = '$access_level' WHERE user_id = '$user_id'";
    return mysqli_query($koneksi, $query);
}


if (isset($_POST['addUser'])) {
    $name = $_POST['name'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $access_level = $_POST['access_level'];
    
    if (addUser($koneksi, $name, $username, $password, $access_level)) {
        $_SESSION['success_message'] = "User berhasil ditambahkan";
    } else {
        $_SESSION['error_message'] = "Gagal menambahkan user";
    }
}


if (isset($_POST['deleteUser'])) {
    $user_id = $_POST['user_id'];
    
    if (deleteUser($koneksi, $user_id)) {
        $_SESSION['success_message'] = "User berhasil dihapus";
    } else {
        $_SESSION['error_message'] = "Gagal menghapus user";
    }
}


if (isset($_POST['updateUser'])) {
    $user_id = $_POST['user_id'];
    $name = $_POST['name'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $access_level = $_POST['access_level'];
    
    if (updateUser($koneksi, $user_id, $name, $username, $password, $access_level)) {
        $_SESSION['success_message'] = "Informasi user berhasil diperbarui";
    } else {
        $_SESSION['error_message'] = "Gagal memperbarui informasi user";
    }
}


header("Location: " . $_SERVER['HTTP_REFERER']);
?>
