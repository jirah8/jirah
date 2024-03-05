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

// Tentukan jumlah foto yang ditampilkan per halaman
$per_page = 6;

// Hitung offset (mulai dari) data yang akan ditampilkan berdasarkan halaman saat ini
$current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start_from = ($current_page - 1) * $per_page;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Website Galeri Foto</title>
    <link rel="stylesheet" type="text/css" href="../aset/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

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
    
    <a class="navbar-brand" href="index_album.php">Website Galeri Foto</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse mt-2" id="navbarNavAltMarkup">
      <div class="navbar-nav me-auto">
        <a href="home.php" class="nav-link">Home</a>
        <a href="album.php" class="nav-link">Album</a>  
        <a href="foto.php" class="nav-link">Foto</a> 
        <a href="list_user.php" class="nav-link">Data</a>    
        <a href="laporan.php" class="nav-link">Report</a> 
      </div>
 <!-- profile img code -->
 <div class="btn-group">
        <button type="button" style='border:none;background-color:transparent;display:flex;flex-direction:row;justify-content:center;align-items:center;gap:8px' class="dropdown-toggle" style='' data-toggle="dropdown" data-mdb-dropdown-init data-mdb-ripple-init aria-expanded="false">
          <img id="profilee-img" class="img-circle img-responsive rounded-circle"src="../aset/img/profilee.png" width="40" height="40">
          <p class='mb-0'><?= $_SESSION['username'] ?></p>
        </button>
        <ul class="dropdown-menu">
          
          <li class='cursor-pointer'><a id="logoutButton" class="text-danger m-1  dropdown-item" style="cursor:pointer">Logout</a></li>
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

<div class="container mt-3" style='margin-bottom:1em'>
  
Album :   
<?php
  $album = mysqli_query($koneksi,"SELECT * FROM albums WHERE user_id ='$user_id'");
  while($row = mysqli_fetch_array($album)){ ?>
 <a href ="home.php?album_id=<?php echo $row['album_id'] ?>" class="btn btn-outline-primary " style='margin-right:1em'>
  <?php echo $row['title'] ?></a>
  
  <?php } ?>  



<div class="row" style='margin-top:1em'>
    <div class="row">
        <?php
        if(isset($_GET['album_id'])) {
            $album_id = $_GET['album_id'];
            $query = mysqli_query($koneksi, "SELECT * FROM photos WHERE user_id='$user_id' AND album_id='$album_id' LIMIT $start_from, $per_page");
            while($data= mysqli_fetch_array($query)){ ?>
            <div class="col-md-4 mb-3"> <!-- Menggunakan col-md-4 untuk membuat setiap baris memiliki 3 foto -->
                <div class="card">
                    <img src="../aset/img/<?php echo $data['image_path']?>" class="card-img-top" title="<?php echo $data['title'] ?>" style="height: 12rem;">
                    <div class="card-footer text-center">
                        <?php
                        $photo_id = $data['photo_id'];
                        $ceksuka = mysqli_query($koneksi,"SELECT * FROM likes WHERE photo_id = '$photo_id' AND user_id = '$user_id'");
                        if (mysqli_num_rows($ceksuka) == 1) { ?> 
                            <a href="../config/proses_like.php?photo_id=<?php echo $data['photo_id']?>" type="submit" name="batalsuka"><i class ="fa fa-heart"  style='color:red'></i></a>
                        <?php }else{ ?>
                            <a href="../config/proses_like.php?photo_id=<?php echo $data['photo_id']?>" type="submit" name="suka"><i class ="fa-regular fa-heart"></i></a>
                        <?php }
                        $like = mysqli_query($koneksi,"SELECT * FROM likes WHERE photo_id = '$photo_id'");
                        echo mysqli_num_rows($like). ' suka';
                        ?>
                        <a href="../config/proses_komentar.php"><i class="fa-regular fa-comment"></i></a>
                        <?php
                        $jmlkomen = mysqli_query($koneksi,"SELECT * FROM comments WHERE photo_id='$photo_id'");
                        if($jmlkomen){
                            $jumlah_komentar = mysqli_num_rows($jmlkomen);
                            echo $jumlah_komentar . ' komentar';
                        } else {
                            echo "0 komentar";
                        }
                        ?>
                    </div>
                </div>
            </div>
        <?php } }else{
            $query = mysqli_query($koneksi, "SELECT * FROM photos WHERE user_id='$user_id' LIMIT $start_from, $per_page");
            if (!$query) {
                die("Query error: " . mysqli_error($koneksi)); 
            }
            while($data = mysqli_fetch_array($query)){
            ?>
    
    
            
            <div class="col-md-4 mb-3"> <!-- Menggunakan col-md-4 untuk membuat setiap baris memiliki 3 foto -->
                <div class="card">
                    <img src="../aset/img/<?php echo $data['image_path']?>" class="card-img-top" title="<?php echo $data['title'] ?>" style="height: 12rem;">
                    <div class="card-footer text-center">
                        <?php
                        $photo_id = $data['photo_id'];
                        $ceksuka = mysqli_query($koneksi,"SELECT * FROM likes WHERE photo_id = '$photo_id' AND user_id = '$user_id'");
                        if (mysqli_num_rows($ceksuka) == 1) { ?> 
                            <a href="../config/proses_like.php?photo_id=<?php echo $data['photo_id']?>" type="submit" name="batalsuka"><i class ="fa fa-heart" style='color:red'></i></a>
                        <?php }else{ ?>
                            <a href="../config/proses_like.php?photo_id=<?php echo $data['photo_id']?>" type="submit" name="suka"><i class ="fa-regular fa-heart"></i></a>
                        <?php }
                        $like = mysqli_query($koneksi,"SELECT * FROM likes WHERE photo_id = '$photo_id'");
                        echo mysqli_num_rows($like). ' suka';
                        ?>
                        <a href="" class="comment-icon"><i class="fa-regular fa-comment"></i></a>

                        <?php
                        $jmlkomen = mysqli_query($koneksi,"SELECT * FROM comments WHERE photo_id='$photo_id'");
                        if($jmlkomen){
                            $jumlah_komentar = mysqli_num_rows($jmlkomen);
                            echo $jumlah_komentar . ' komentar';
                        } else {
                            echo "0 komentar";
                        }
                        ?>
                    </div>
                </div>
            </div>
        <?php } } ?>
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
