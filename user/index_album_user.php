<?php
session_start();
$user_id = $_SESSION['user_id'];
if (!isset($_SESSION['status']) || $_SESSION['status'] != 'login') {
    echo "<script>
    alert('Anda belum Login!');
    location.href='../index.php';
    </script>";
    exit; 
}

include_once("../config/koneksi.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Website Galeri Foto</title>
    <link rel="stylesheet" type="text/css" href="../aset/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container">
    <a class="navbar-brand" href="index_album_user.php">Website Galeri Foto</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse mt-2" id="navbarNavAltMarkup">
      <div class="navbar-nav me-auto">
        <a href="home_user.php" class="nav-link">Home</a>
        <a href="album_user.php" class="nav-link">Album</a>  
        <a href="foto_user.php" class="nav-link">Foto</a>    
      </div>

      <div class="ml-auto">
        <div class="dropdown">
          <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            User
          </button>
          <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            <a class="dropdown-item" href="../config/aksi_logout.php">Keluar</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</nav>

<div class="container mt-3" style='padding-right:6px;padding-left:6px;padding-top:2em'>
  <div class="row">
    <?php
$query = mysqli_query($koneksi, "SELECT albums.*, IFNULL(photos.image_path, '') AS selected_photo_id
    FROM albums
    LEFT JOIN photos ON albums.album_id = photos.album_id
    WHERE albums.user_id = $user_id
    GROUP BY albums.album_id;");

if (!$query) {
  die("Query error: " . mysqli_error($koneksi)); 
}
    while($data = mysqli_fetch_assoc($query)){
    ?>
    <div class="col-md-3">
    <a href='isi_album_user.php?id_album=<?= $data['album_id']?>'>
        <div  class="card mb-2">

        <div class="btn btn-transparan" data-bs-toggle="modal" data-bs-target="#Komentar<?php echo $data['photo_id']?>"> 
            <?php if (!empty($data['selected_photo_id'])): ?>
                <img src="../aset/img/<?php echo $data['selected_photo_id']?>" class="card-img-top" title="<?php echo $data['title'] ?>" style="height: 15rem;">
            <?php else: ?>
                <div class="text-center" style="height: 15rem; display: flex; align-items: center; justify-content: center; background-color: #f0f0f0;">
                    <span class="text-muted">Album Kosong</span>
                </div>
            <?php endif; ?>
            <div class="card-footer text-center">
                <p><?= $data['title'] ?></p>
            </div>
        </div>
     </div>

    </a>
</div>
    <?php } ?>
  </div>
</div>



<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script type="text/javascript" src="../aset/js/bootstrap.min.js"></script>
</body>
</html>
