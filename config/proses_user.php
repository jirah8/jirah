<?php
session_start();
include 'koneksi.php';

function addUser($koneksi, $name, $username, $password, $access_level) {
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $query = "INSERT INTO users (name, username, password, access_level, created_at) VALUES ('$name', '$username', '$hashedPassword', '$access_level', NOW())";
    return mysqli_query($koneksi, $query);
}

function deleteUser($koneksi, $user_id) {
    // Query untuk mengambil data pengguna yang akan dihapus
    $query = "SELECT * FROM users WHERE user_id = '$user_id'";
    $result = mysqli_query($koneksi, $query);
    $user_data = mysqli_fetch_assoc($result);

    // Query untuk memindahkan data pengguna yang dihapus ke tabel sampah
    $insert_query = "INSERT INTO sampah (user_id, name, username, password, email, acces_level, created_at, is_deleted) 
                     VALUES ('".$user_data['user_id']."', '".$user_data['name']."', '".$user_data['username']."', '".$user_data['password']."', 
                     '".$user_data['email']."', '".$user_data['acces_level']."', '".$user_data['created_at']."', 1)";
    $insert_result = mysqli_query($koneksi, $insert_query);
    
    if ($insert_result) {
        // Jika data pengguna berhasil dipindahkan ke tabel sampah, lanjutkan proses penghapusan
        $delete_query = "DELETE FROM users WHERE user_id = '$user_id'";
        return mysqli_query($koneksi, $delete_query);
    } else {
        return false;
    }
}

function updateUser($koneksi, $user_id, $name, $username, $password, $access_level) {
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $query = "UPDATE users SET name = '$name', username = '$username', password = '$hashedPassword', access_level = '$access_level' WHERE user_id = '$user_id'";
    return mysqli_query($koneksi, $query);
}

// Cek apakah ada permintaan untuk menambah pengguna baru
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

// Cek apakah ada permintaan untuk menghapus pengguna
if (isset($_POST['deleteUser'])) {
    $user_id = $_POST['user_id'];
    
    if (deleteUser($koneksi, $user_id)) {
        $_SESSION['success_message'] = "User berhasil dihapus";
    } else {
        $_SESSION['error_message'] = "Gagal menghapus user";
    }
}

// Cek apakah ada permintaan untuk memperbarui informasi pengguna
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

// Redirect kembali ke halaman sebelumnya
header("Location: " . $_SERVER['HTTP_REFERER']);
?>
