<?php
session_start();
include 'koneksi.php';
$photo_id = $_GET['photo_id'];
$user_id = $_SESSION['user_id'];
$redirect_page = isset($_GET['from']) ? $_GET['from'] : ''; 

$ceksuka = mysqli_query($koneksi, "SELECT * FROM likes WHERE photo_id = '$photo_id' AND user_id = '$user_id'");

if (mysqli_num_rows($ceksuka) == 1) {
    while ($row = mysqli_fetch_array($ceksuka)) {
        $like_id = $row['like_id'];
        $query = mysqli_query($koneksi, "DELETE FROM likes WHERE like_id ='$like_id'");
    }
} else {
    $created_at = date('Y-m-d');
    $query = mysqli_query($koneksi, "INSERT INTO likes VALUES ('','$user_id','$photo_id','$created_at')");
}


if ($_SESSION['role'] == "admin") { 
    if ($redirect_page == 'home') {
        //header('location:../admin/home.php');
        echo "<script>history.back()</script>";
    } else {
        //header('location:../admin/home.php');
        echo "<script>history.back()</script>";
    }
 
} else {
    if ($redirect_page == 'home') {
        echo "<script>history.back()</script>";

        //header('location:../user/home_user.php');
    } else {
        echo "<script>history.back()</script>";

        //header('location:../user/home_user.php');
    }
}


?>
