<?php
session_start();
include '../config/koneksi.php';


$user_id = $_SESSION['user_id'];

if (isset($_POST['tambah'])) {
  
    $title = $_POST['title'];
    $description = $_POST['description'];
    $created_at = date('Y-m-d h:i:s');


    if ($_SESSION['role'] != 'admin') {

        $stmt = $koneksi->prepare("INSERT INTO albums(title, description, created_at, user_id) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sssi", $title, $description, $created_at, $user_id);
        if ($stmt->execute()) {
            header("location: ../user/album_user.php");
            exit; 
        } else {
            echo "Gagal menambahkan album. Silakan coba lagi.";
        }
    } else {

        $stmt = $koneksi->prepare("INSERT INTO albums(title, description, created_at, user_id) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sssi", $title, $description, $created_at, $user_id);
        if ($stmt->execute()) {
            header("location: ../admin/album.php");
            exit; 
        } else {
            echo "Gagal menambahkan album. Silakan coba lagi.";
        }
    }
}

if (isset($_POST['edit'])) {
    $album_id = $_POST['album_id'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $created_at = date('Y-m-d H:i:s');


    if ($_SESSION['role'] != 'admin') {

        $stmt = $koneksi->prepare("UPDATE albums SET title=?, description=?, created_at=? WHERE album_id=? AND user_id=?");
        $stmt->bind_param("sssii", $title, $description, $created_at, $album_id, $user_id);
        if ($stmt->execute()) {
            header("location: ../user/album_user.php");
            exit; 
        } else {
            echo "Gagal mengedit album. Silakan coba lagi.";
        }
    } else {

        $stmt = $koneksi->prepare("UPDATE albums SET title=?, description=?, created_at=? WHERE album_id=?");
        $stmt->bind_param("sssi", $title, $description, $created_at, $album_id);
        if ($stmt->execute()) {
            header("location: ../admin/album.php");
            exit; 
        } else {
            echo "Gagal mengedit album. Silakan coba lagi.";
        }
    }
}

if (isset($_POST['hapus'])) {
    $album_id = $_POST['album_id'];


    if ($_SESSION['role'] != 'admin') {
        $deletephotos = mysqli_query($koneksi,"DELETE FROM photos WHERE album_id = '$album_id'");
        $stmt = $koneksi->prepare("DELETE FROM albums WHERE album_id=? AND user_id=?");
        $stmt->bind_param("ii", $album_id, $user_id);
        if ($stmt->execute()) {
            header("location: ../user/album_user.php");
            exit; 
        } else {
            echo "Gagal menghapus album. Silakan coba lagi.";
        }
    } else {
        $deletephotos = mysqli_query($koneksi,"DELETE FROM photos WHERE album_id = '$album_id'");
        $stmt = $koneksi->prepare("DELETE FROM albums WHERE album_id=?");
        $stmt->bind_param("i", $album_id);
        if ($stmt->execute()) {
            header("location: ../admin/album.php");
            exit; 
        } else {
            echo "Gagal menghapus album. Silakan coba lagi.";
        }
    }
}
?>
