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

// Pagination setup
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$photosPerPage = 12; // Jumlah foto per halaman
$offset = ($page - 1) * $photosPerPage;

// Query untuk mengambil data foto dengan batasan jumlah dan offset
$query = mysqli_query($koneksi, "SELECT photos.*, users.name, albums.description AS album_description
    FROM photos
    INNER JOIN users ON photos.user_id = users.user_id
    INNER JOIN albums ON photos.album_id = albums.album_id
    LIMIT $offset, $photosPerPage");

if (!$query) {
    die("Query error: " . mysqli_error($koneksi)); 
}

// Hitung total halaman
$total_photos_query = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM photos");
$total_photos = mysqli_fetch_assoc($total_photos_query)['total'];
$total_pages = ceil($total_photos / $photosPerPage);
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


<div class="container mt-3">
  <div class="row">
    <?php while($data = mysqli_fetch_assoc($query)): ?>
      <div class="col-md-3">
        <div class="card mb-2">
          <!-- Button trigger modal -->
          <div class="btn btn-transparent" data-bs-toggle="modal" data-bs-target="#Komentar<?php echo $data['photo_id']?>">
            <img src="../aset/img/<?php echo $data['image_path']?>" class="card-img-top" title="<?php echo $data['title'] ?>" style="height: 15rem;">
            <div class="card-footer text-center">
              <?php
              $photo_id = $data['photo_id'];
              $ceksuka = mysqli_query($koneksi,"SELECT * FROM likes WHERE photo_id = '$photo_id' AND user_id = '$user_id'");
              if (mysqli_num_rows($ceksuka) == 1): ?>
                <a href="../config/proses_like.php?action=unlike&photo_id=<?php echo $data['photo_id']?>" type="submit" name="batalsuka"><i class ="fa fa-heart " style='color:red'></i></a>
              <?php else: ?>
                <a href="../config/proses_like.php?action=like&photo_id=<?php echo $data['photo_id']?>" type="submit" name="suka"><i class ="fa-regular fa-heart" ></i></a>
              <?php endif;
              $like = mysqli_query($koneksi,"SELECT * FROM likes WHERE photo_id = '$photo_id'");
              echo mysqli_num_rows($like). ' suka';
              ?>
              <a href=""><i class="fa-regular fa-comment"></i></a>
              <?php
              $jmlkomen = mysqli_query($koneksi,"SELECT * FROM comments WHERE photo_id='$photo_id'");
              if($jmlkomen):
                  $jumlah_komentar = mysqli_num_rows($jmlkomen);
                  echo $jumlah_komentar . ' komentar';
              else:
                  echo "0 komentar";
              endif;
              ?>
            </div>
          </div>
        </div>
      </div>

      <!-- Modal -->
      <div class="modal fade" id="Komentar<?php echo $data['photo_id']?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
          <div class="modal-content">
            <div class="modal-body">
              <div class="row">
                <div class="col-md-8">
                  <img src="../aset/img/<?php echo $data['image_path']?>" class="card-img-top" title="<?php echo $data['title'] ?>" >
                  <div class="card-footer text-center"></div>
                </div>
                <div class="col-md-4">
                  <div class="m-2">
                    <div class="overflow-auto">
                      <div class="sticky-top">
                        <strong><?php echo $data['title'] ?></strong><br>
                        <span class="badge bg-secondary"><?php echo $data ['name'] ?></span>
                        <span class="badge bg-secondary"><?php echo $data ['created_at'] ?></span>
                        <span class="badge bg-primary"><?php echo $data ['description'] ?></span>
                      </div>
                      <hr>
                      <p align="left">
                        <?php echo $data ['description'] ?>
                      </p>
                      <hr>
                      <?php 
                      $photo_id = $data['photo_id'];
                      $comment_query = mysqli_query($koneksi,"SELECT * FROM comments INNER JOIN users ON comments.user_id=users.user_id WHERE comments.photo_id = '$photo_id'");
                      while($row = mysqli_fetch_assoc($comment_query)): ?>
                        <p align="left">
                          <strong><?php echo $row['name'] ?></strong>
                          <?php echo $row['comment_text'] ?>
                        </p>
                      <?php endwhile; ?>
                      <hr>
                      <div class="sticky-bottom">
                        <form action="../config/proses_komentar.php" method="POST" enctype="multipart/form-data">
                          <div class="input-group">
                            <input type="hidden" name="photo_id" value="<?php echo $data['photo_id'] ?>">
                            <input type="text" name="isikomentar" class="form-control" placeholder="tambahkomentar">
                            <div class="input-group-prepend">
                              <button type="submit" name="kirimkomentar" class="btn btn-outline-primary">Kirim</button>
                            </div>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    <?php endwhile; ?>
  </div>
</div>

<!-- Paginasi -->
<div class="container mt-3">
  <div class="row">
    <div class="col">
      <nav aria-label="Page navigation example">
        <ul class="pagination justify-content-center">
          <?php for ($i = 1; $i <= $total_pages; $i++): ?>
            <li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>"><a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
          <?php endfor; ?>
        </ul>
      </nav>
    </div>
  </div>
</div>



<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script type="text/javascript" src="../aset/js/bootstrap.min.js"></script>
</body>
</html>