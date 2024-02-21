<?php 
include "config/koneksi.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Website Galeri Foto</title>
    <link rel="stylesheet" type="text/css" href="aset/css/bootstrap.min.css">
    <style>
        .card-img-top {
            height: 12rem;
            object-fit: cover; /
        }
        .card-footer {
            display: flex;
            justify-content: space-around; 
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container">
        <a class="navbar-brand" href="index.php">Website Galeri Foto</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse mt-2" id="navbarNavAltMarkup">
            <div class="navbar-nav me-auto"></div>
            <a href="register.php" class="btn btn-outline-primary m-1">Daftar</a>
            <a href="login.php" class="btn btn-outline-success m-1">Masuk</a>
        </div>
    </div>
</nav>

<div class="container mt-3">
    <div class="row">
        <?php 
            $result = mysqli_query($koneksi,"SELECT * FROM photos");
            while($data = mysqli_fetch_assoc($result)):
        ?>
        <div class="col-md-3 mb-3">
            <div class="card">
                <img src="aset/img/<?= $data['image_path'] ?>" class="card-img-top" title="" alt="<?= $data['image_description'] ?>">
                <div class="card-footer text-center">
                    <a href="#">
                        <?php 
                            $result_like = mysqli_query($koneksi,"SELECT * FROM likes WHERE photo_id = '{$data['photo_id']}'");
                            echo mysqli_num_rows($result_like);
                        ?>
                        Suka
                    </a>
                    <a href="#">
                        <?php 
                            $result_comment = mysqli_query($koneksi,"SELECT * FROM photos WHERE photo_id = '{$data['photo_id']}'");
                            echo mysqli_num_rows($result_comment);
                        ?>
                        Komentar
                    </a>
                </div>
            </div>
        </div>
        <?php endwhile ?>
    </div>
</div>



<script type="text/javascript" src="aset/js/bootstrap.min.js"></script>
</body>
</html>
