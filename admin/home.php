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
      </div>
      <!-- Tombol dropdown ditempatkan di pojok kanan -->
      <div class="ml-auto">
        <div class="dropdown">
          <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Admin
          </button>
          <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            <a class="dropdown-item" href="list_user.php">Data</a>
            <a class="dropdown-item" href="../config/aksi_logout.php">Keluar</a>
          </div>
        </div>
      </div>
    </div>
  </div>
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
     <?php
     if(isset($_GET['album_id'])) {
        $album_id = $_GET['album_id'];
        $query = mysqli_query($koneksi, "SELECT * FROM photos WHERE user_id='$user_id' AND album_id='$album_id'");
        while($data= mysqli_fetch_array($query)){ ?>
        <div class="col-md-3">
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
          <a href=""><i class="fa-regular fa-comment"></i></a>
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
     

$query = mysqli_query($koneksi, "SELECT * FROM photos WHERE user_id='$user_id'");
if (!$query) {
    die("Query error: " . mysqli_error($koneksi)); 
}
while($data = mysqli_fetch_array($query)){
?>
<div class="col-md-3">
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
          <a href=""><i class="fa-regular fa-comment"></i></a>
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



<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script type="text/javascript" src="../aset/js/bootstrap.min.js"></script>
</body>
</html>
