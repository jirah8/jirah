<?php
session_start();
include 'koneksi.php';

if ($_SESSION['status'] != 'login') {
    echo "<script>
    alert('Anda belum Login!');
    location.href='../index.php';
    </script>";
    exit; 
}

// Fungsi untuk menandai pengguna sebagai dihapus
function markUserAsDeleted($koneksi, $user_id) {
    $query = "UPDATE users SET is_deleted = 1 WHERE user_id = '$user_id'";
    return mysqli_query($koneksi, $query);
}

// Fungsi untuk memulihkan pengguna yang telah dihapus
function restoreUser($koneksi, $user_id) {
    $query = "UPDATE users SET is_deleted = 0 WHERE user_id = '$user_id'";
    return mysqli_query($koneksi, $query);
}

// Fungsi untuk menghapus pengguna secara permanen
function deleteUserPermanently($koneksi, $user_id) {
    $query = "DELETE FROM users WHERE user_id = '$user_id'";
    return mysqli_query($koneksi, $query);
}

if (isset($_POST['markAsDeleted'])) {
    $user_id = $_POST['user_id'];
    if (markUserAsDeleted($koneksi, $user_id)) {
        echo "Pengguna berhasil ditandai sebagai dihapus.";
    } else {
        echo "Gagal menandai pengguna sebagai dihapus.";
    }
}

if (isset($_POST['markAsRestored'])) {
    $user_id = $_POST['user_id'];
    if (restoreUser($koneksi, $user_id)) {
        echo "Pengguna berhasil dipulihkan.";
    } else {
        echo "Gagal memulihkan pengguna.";
    }
}

if (isset($_POST['deletePermanently'])) {
    $user_id = $_POST['user_id'];
    if (deleteUserPermanently($koneksi, $user_id)) {
        echo "Pengguna berhasil dihapus secara permanen.";
    } else {
        echo "Gagal menghapus pengguna secara permanen.";
    }
}
?>
