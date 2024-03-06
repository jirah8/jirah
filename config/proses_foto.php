<?php
session_start();
include 'koneksi.php';

if (isset($_POST['tambah'])) {

    $title = $_POST['title'];
    $album_id = $_POST['album_id'];
    $description = $_POST['description'];
    $created_at = date('Y-m-d h:i:s');
    $user_id = $_SESSION['user_id'];
    $image_path = $_FILES['lokasifile']['name'];
    $tmp = $_FILES['lokasifile']['tmp_name'];
    $lokasi = '../aset/img/';
    $foto = rand() . '-' . $image_path;

    if (move_uploaded_file($tmp, $lokasi . $foto)) {
        $sql = mysqli_query($koneksi, "INSERT INTO photos (user_id, album_id, title, description, image_path, created_at) 
        VALUES ('$user_id', '$album_id', '$title', '$description','$foto', '$created_at')");

        if ($sql) {
            if ($_SESSION['role'] === "admin") {
                header('location:../admin/foto.php');
                exit;
            } else {

                header('location:../user/foto_user.php');
                exit;
            }
        } else {

        }
    } else {

    }
}

if (isset($_POST['edit'])) {

    $title = $_POST['title'];
    $album_id = $_POST['album_id'];
    $photo_id = $_POST['photo_id'];
    $description = $_POST['description'];
    $created_at = date('Y-m-d');
    $user_id = $_SESSION['user_id'];

    if (isset($_FILES['lokasifile']) && $_FILES['lokasifile']['error'] === UPLOAD_ERR_OK) {

        $image_path = $_FILES['lokasifile']['name'];
        $tmp = $_FILES['lokasifile']['tmp_name'];
        $lokasi = '../aset/img/';
        $foto = rand() . '-' . $image_path;

        if (move_uploaded_file($tmp, $lokasi . $foto)) {

        } else {

        }
    } else {

        $sql_get_photo = mysqli_query($koneksi, "SELECT image_path FROM photos WHERE photo_id='$photo_id'");
        $photo_data = mysqli_fetch_assoc($sql_get_photo);
        $foto = $photo_data['image_path'];
    }

    $sql_update_photo = "UPDATE photos SET title='$title', description='$description', image_path='$foto' WHERE photo_id='$photo_id'";
    if (mysqli_query($koneksi, $sql_update_photo)) {
        if ($_SESSION['role'] === "admin") {
            header('location: ../admin/foto.php');
            exit;
        } else {

            header('location: ../user/foto_user.php');
            exit;
        }
    } else {

    }
}

if (isset($_POST['hapus'])) {

    $photo_id = $_POST['photo_id'];

    $sql = mysqli_query($koneksi, "DELETE FROM photos WHERE photo_id = '$photo_id'");
    
    if ($_SESSION['role'] === "admin") {
        header('location:../admin/foto.php');
        exit;
    } else {

        header('location:../user/foto_user.php');
        exit;
    }
}

?>
