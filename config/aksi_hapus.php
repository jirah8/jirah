<?php
session_start();
include 'koneksi.php';
if (isset($_POST['hapus'])) {
    $photo_id = $_GET['photo_id'];

    $sql = mysqli_query($koneksi, "DELETE FROM photos WHERE photo_id = '$photo_id'");
   
  
    if ($sql) {
        if($_SESSION['acces_level' === "admin"]){
            header('location: ../admin/foto.php');
        } 
       
    }

  
  }
?>