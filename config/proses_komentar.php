<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['status']) || $_SESSION['status'] != 'login') {
    echo "<script>
    alert('Anda belum Login!');
    location.href='../index.php';
    </script>";
    exit;
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['photo_id'], $_POST['isikomentar'])) {
        $photo_id = $_POST['photo_id'];
        $comment_text = $_POST['isikomentar'];
        $created_at = date('Y-m-d');

        $query = mysqli_query($koneksi, "INSERT INTO comments (`user_id`, `photo_id`, `comment_text`, `created_at`) VALUES ('$user_id', '$photo_id', '$comment_text', '$created_at')");

        if (!$query) {
            die("Query error: " . mysqli_error($koneksi));
        }


        header('location: ' . $_SERVER['HTTP_REFERER']);
        exit;
    }
    else if(isset($_POST['komenid'])){
        $komenid = $_POST['komenid'];

        $query = mysqli_query($koneksi,"DELETE FROM comments WHERE comments_id = '$komenid'");

        if($query){
            header("Location:{$_SERVER['HTTP_REFERER']}");
        }
    } 
    else if(isset($_POST['editkomentar'])){
        $fotoid = $_POST['photo_id'];
        $userid = $_SESSION['user_id'];
        $isikomentar = $_POST['isikomentar'];
    }   
    else {
        echo "Invalid request!";
    }
}

?>
