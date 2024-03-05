<?php
session_start();
include 'koneksi.php';


function addUser($koneksi, $name, $username, $password, $access_level) {
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $query = "INSERT INTO users (name, username, password, access_level, created_at) VALUES ('$name', '$username', '$hashedPassword', '$access_level', NOW())";
    return mysqli_query($koneksi, $query);
}


function deleteUser($koneksi, $user_id) {
    $querydeletealbums = "DELETE FROM albums WHERE user_id = '$user_id'";
    $querydeletephotos = "DELETE FROM photos WHERE user_id = '$user_id'";
    mysqli_query($koneksi,$querydeletealbums);
    mysqli_query($koneksi,$querydeletephotos);
    $query = "DELETE FROM users WHERE user_id = '$user_id'";
    return mysqli_query($koneksi, $query);
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
