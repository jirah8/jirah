<?php 
    include "config/koneksi.php";
    session_start();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaturan</title>
    <link rel="stylesheet" type="text/css" href="../aset/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
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
        <a href="foto.php" class="nav-link active">Foto</a> 
        <a href="list_user.php" class="nav-link">Data</a>    
      </div>
 <!-- profile img code -->
 <div class="btn-group">
        <button type="button" style='border:none;background-color:transparent' class="dropdown-toggle" data-toggle="dropdown" data-mdb-dropdown-init data-mdb-ripple-init aria-expanded="false">
          <img id="profile-img" class="img-circle img-responsive rounded-circle" src="https://i.pinimg.com/564x/bf/0a/3e/bf0a3ebc040ba080f701280f6cf3de35.jpg" width="40" height="40">
        </button>
        <ul class="dropdown-menu">
          <li><a href="#" class="dropdown-item">Settings</a></li>
          <li class='cursor-pointer'><a id="logoutButton" class="text-danger m-1  dropdown-item">Keluar</a></li>
        </ul>
      </div>

  </div>
</nav>

<div class="container">
    <div class="row" style='gap:2em'>
        <div class="img-container">
            <img src="" alt="" class='' style='border:2px solid red' height='200' width='200'>
        </div>
        <div class="form-container">
            <form>
                <div class="d-flex " style='flex-direction:column'>
                    <label>Username</label>
                    <input type='text' class='form-control'/>
                </div>
                <div class="d-flex " style='flex-direction:column'>
                    <label>Email</label>
                    <input type='text' class='form-control'/>
                </div>
                <div class="d-flex " style='flex-direction:column'>
                    <label>Password</label>
                    <input type='text' class='form-control'/>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script type="text/javascript" src="../aset/js/bootstrap.min.js"></script>
  <script>
    document.getElementById('logoutButton').addEventListener('click', function(event) {
        event.preventDefault(); 
       
        if (confirm('Apakah Anda yakin ingin keluar?')) {
            window.location.href = '../index.php'; 
        }
    });
</script>
</body>
</html>