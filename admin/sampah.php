<?php
session_start();
include '../config/koneksi.php';

if ($_SESSION['status'] != 'login') {
    echo "<script>
    alert('Anda belum Login!');
    location.href='../index.php';
    </script>";
    exit; 
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
       
        <li class='cursor-pointer'><a id="sampahButton" class="text-secondary m-1 cursor-pointer dropdown-item" style="cursor:pointer">Sampah</a></li>
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

  
    document.getElementById('sampahButton').addEventListener('click', function(event) {
        event.preventDefault(); 
        window.location.href = 'sampah.php'; // Mengarahkan pengguna ke sampah.php saat tombol "Sampah" diklik
    });
</script>
</nav>

<div class="container mt-3">
    <div class='card'>
        <div class='card-header'>Data Pengguna Terhapus</div>
        <div class='card-body'>
            <div class="table-responsive">
                <table class="table">
                    <thead class='table-stripped'>
                        <tr>
                            <th>User ID</th>
                            <th>Name</th>
                            <th>Username</th> 
                            <th>Email</th>
                            <th>Access Level</th>
                            <th>Created At</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $query = mysqli_query($koneksi, "SELECT * FROM sampah"); // Query untuk mengambil data pengguna yang telah dihapus
                        if (mysqli_num_rows($query) > 0) { // Periksa apakah ada data yang diambil
                            while($row = mysqli_fetch_assoc($query)): // Loop melalui setiap baris data
                        ?>
                       <tr>
    <td><?php echo $row['user_id']; ?></td>
    <td><?php echo $row['name']; ?></td>
    <td><?php echo $row['username']; ?></td>
    <td><?php echo $row['email']; ?></td>
    <td><?php echo $row['acces_level']; ?></td>
    <td><?php echo $row['created_at']; ?></td>
    <td>
        <button type="button" class="btn btn-primary btn-sm" onclick="restoreUser(<?php echo $row['user_id']; ?>)">Restore</button>
        <button type="button" class="btn btn-danger btn-sm" onclick="deletePermanently(<?php echo $row['user_id']; ?>)">Delete Permanently</button>
    </td>
</tr>
                        <?php endwhile;
                        } else {
                            echo "<tr><td colspan='6'>Tidak ada data</td></tr>"; // Tampilkan pesan jika tidak ada data yang dihapus
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    function restoreUser(userId) {
        if (confirm('Apakah Anda yakin ingin mengembalikan pengguna ini?')) {
            $.ajax({
                url: 'laporan.php',
                type: 'POST',
                data: {
                    user_id: userId,
                    markAsRestored: true
                },
                success: function(response) {
                    location.reload(); // Refresh halaman setelah berhasil mengembalikan pengguna
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        }
    }
</script>

<script>
    function deletePermanently(userId) {
        if (confirm('Apakah Anda yakin ingin menghapus pengguna ini secara permanen?')) {
            $.ajax({
                url: '../config/proses_sampah.php',
                type: 'POST',
                data: {
                    user_id: userId,
                    markAsDeleted: true
                },
                success: function(response) {
                    location.reload(); // Refresh halaman setelah berhasil menghapus pengguna secara permanen
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        }
    }
</script>


<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script type="text/javascript" src="../aset/js/bootstrap.min.js"></script>

</body>

</html>
