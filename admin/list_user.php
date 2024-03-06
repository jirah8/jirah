<?php
session_start();
include '../config/koneksi.php';

if ($_SESSION['status'] != 'login') {
    echo "<script>
    alert('Anda belum Login!');
    location.href='../index.php';
    </script>";
} else {
    $user_id = $_SESSION['user_id'];
    // Ubah kueri SQL untuk hanya mengambil pengguna yang bukan admin
    $sql = mysqli_query($koneksi, "SELECT * FROM users WHERE acces_level != 'admin'");
    if (!$sql) {
        die("Query failed: " . mysqli_error($koneksi));
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Website Galeri Foto</title>
    <link rel="stylesheet" type="text/css" href="../aset/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
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
        <a href="home.php" class="nav-link">Koleksi</a>
        <a href="album.php" class="nav-link">Album</a>  
        <a href="foto.php" class="nav-link">Foto</a> 
        <a href="list_user.php" class="nav-link">Data</a>  
        <a href="laporan.php" class="nav-link">Report</a>   
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


    <div class="container mt-3">
   
     <div class='card'>
        <div class='card-header'>Data Pengguna</div>
        <div class='card-body'>
            <div class="table-responsive">
                <table class="table">
                    <thead class='table-stripped'>
                        <tr style='vertical-align:center'>
                            <th>User ID</th>
                            <th>Name</th>
                            <th>Username</th>
                          
                            <th>Access Level</th>
                            <th>Created At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (isset($sql)) : ?>
                            <?php while ($row = mysqli_fetch_assoc($sql)) : ?>
                                <tr>
                                    <td><?php echo $row['user_id']; ?></td>
                                    <td><?php echo $row['name']; ?></td>
                                    <td><?php echo $row['username']; ?></td>
                                    
                                    <td><?php echo isset($row['acces_level']) ? $row['acces_level'] : ''; ?></td>
                                    <td><?php echo $row['created_at']; ?></td>
                                   
                           <td>
    <?php if ($row['is_deleted'] == 1) : ?>
        <form action="../config/proses_user.php" method="post" onsubmit="return confirmRestore()">
            <input type="hidden" name="user_id" value="<?php echo $row['user_id']; ?>">
            <input type="hidden" name="markAsRestored"> <!-- Tambahkan input ini -->
            <button type="submit" name="restoreUser" class="btn btn-success btn-sm">Restore</button>
        </form>
    <?php else : ?>
        <form action="../config/proses_user.php" method="post" onsubmit="return confirmDelete()">
            <input type="hidden" name="user_id" value="<?php echo $row['user_id']; ?>">
            <input type="hidden" name="markAsDeleted"> <!-- Tambahkan input ini -->
            <button type="submit" name="deleteUser" class="btn btn-danger btn-sm">Delete</button>
        </form>
    <?php endif; ?>
</td>



                                </tr>
                            <?php endwhile; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

        </div>
     </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script type="text/javascript" src="../aset/js/bootstrap.min.js"></script>
<script>
$(document).ready(function(){
    $("#profile-link").click(function(){
        $("#dropdown-menu").toggle();
    });
});
</script>


    <script type="text/javascript" src="../aset/js/bootstrap.min.js"></script>
</body>

</html>
