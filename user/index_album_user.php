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
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
    /* Custom CSS */
    .navbar-nav .nav-link {
        color: #333;
        transition: color 0.3s ease;
    }
    .navbar-nav .nav-link:hover {
        color: #007bff;
        text-decoration: none;
    }
    .navbar-nav .nav-link.active {
        color: #007bff;
        text-decoration: underline;
    }
    .album-button {
        width: 100%;
        text-align: center;
        transition: transform 0.3s ease; /* Menambahkan transisi */
    }
    .album-button:hover {
        transform: scale(1.1); /* Mengubah skala saat disentuh */
    }
    .card:hover {
        transform: scale(1.05); /* Memperbesar card saat disentuh */
        transition: transform 0.3s ease; /* Menambahkan transisi */
    }
</style>
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
        <a href="home_user.php" class="nav-link">Koleksi</a>
        <a href="album_user.php" class="nav-link">Album</a>  
        <a href="informasi.php" class="nav-link">Informasi</a>
        <a href="foto_user.php" class="nav-link">Foto</a> 
      </div>

      <!-- profile img code -->
      <div class="btn-group">
        <button type="button" style='border:none;background-color:transparent;display:flex;flex-direction:row;justify-content:center;align-items:center;gap:8px' class="dropdown-toggle" style='' data-toggle="dropdown" data-mdb-dropdown-init data-mdb-ripple-init aria-expanded="false">
          <img id="profilee-img" class="img-circle img-responsive rounded-circle" src="../aset/img/profilee.png" width="40" height="40">
          <p class='mb-0'><?= $_SESSION['username'] ?></p>
        </button>
        <ul class="dropdown-menu">
          
          <li class='cursor-pointer'><a id="logoutButton" class="text-danger m-1 cursor-pointer dropdown-item" style="cursor:pointer">Logout</a></li>
        </ul>
      </div>

  </div>
  <script>
    document.getElementById('logoutButton').addEventListener('click', function(event) {
        event.preventDefault(); 
       
        if (confirm('Apakah Anda yakin ingin keluar?')) {
            window.location.href = '../logout.php'; 
        }
    });
</script>
</nav>

<div class="container mt-3" style='padding-right:6px;padding-left:6px;padding-top:2em'>
    <div class="row">
        <div class="col-md-12">
            <h2 class="text-center mb-4">Album</h2>
        </div>
        <?php
        // Hitung total halaman berdasarkan jumlah album
        $query_count = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM albums");
        $row_count = mysqli_fetch_assoc($query_count);
        $total_records = $row_count['total'];
        $total_pages = ceil($total_records / 6); // Menggunakan 6 album per halaman
        $current_page = isset($_GET['page']) ? $_GET['page'] : 1; // Halaman saat ini
        $offset = ($current_page - 1) * 6; // Menghitung offset

        // Query untuk menampilkan album pada halaman saat ini
        $query = mysqli_query($koneksi, "SELECT albums.*, MIN(photos.photo_id),photos.image_path AS selected_photo_id,users.*
        FROM albums
        INNER JOIN photos ON albums.album_id = photos.album_id
        INNER JOIN users ON users.user_id = photos.user_id
        GROUP BY albums.album_id
        LIMIT $offset, 6"); // Batasi jumlah album per halaman menjadi 6
        if (!$query) {
            die("Query error: " . mysqli_error($koneksi)); 
        }
        $counter = 0; // inisialisasi counter
        while($data = mysqli_fetch_assoc($query)){
            // Mulai baris baru setiap kali counter mencapai 3
            if ($counter % 3 == 0) {
                echo '</div><div class="row">';
            }
        ?>
            <div class="col-md-4">
                <a href='isi_album_user.php?id_album=<?= $data['album_id']?>'>
                    <div class="card mb-2">
                        <button class="btn btn-primary album-button"><?= $data['title'] ?></button> <!-- Perubahan dilakukan di sini -->
                        <!-- Button trigger modal -->
                        <div class="btn btn-transparan" data-bs-toggle="modal" data-bs-target="#Komentar<?php echo $data['photo_id']?>"> <!-- Mengganti button dengan div -->
                            <img src="../aset/img/<?php echo $data['selected_photo_id']?>" class="card-img-top" title="<?php echo $data['title'] ?>" style="height: 15rem;">
                        </div>
                    </div>
                </a>
            </div>
            <?php 
            $counter++; // Increment counter
        } ?>
    </div>
</div>

<!-- Tampilkan navigasi halaman -->
<div class="container mt-3">
    <div class="row">
        <div class="col">
            <nav aria-label="Page navigation example">
                <ul class="pagination justify-content-center">
                    <li class="page-item <?php echo ($current_page == 1) ? 'disabled' : ''; ?>"><a class="page-link" href="?page=<?php echo ($current_page - 1); ?>">Previous</a></li>
                    <li class="page-item <?php echo ($current_page == $total_pages) ? 'disabled' : ''; ?>"><a class="page-link" href="?page=<?php echo ($current_page + 1); ?>">Next</a></li>
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
