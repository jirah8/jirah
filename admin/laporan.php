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
    
    // Pagination setup
    $limit = 5;
    $page = isset($_GET['page']) ? $_GET['page'] : 1;
    $start = ($page - 1) * $limit;
    
    // Fetch data with pagination
    $sql = mysqli_query($koneksi, "SELECT * FROM albums WHERE user_id='$user_id' LIMIT $start, $limit");
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
        <div class='card-header'>Data Laporan</div>
        <div class='card-body'>
            <div class="table-responsive">
                <table class="table">
                    <thead class='table-stripped'>
                        <tr>
                            <th>No</th>
                            <th>Isi Laporan</th>
                            <th>Laporan Oleh</th>
                            <th>Postingan</th>
                            <th>Tanggal</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $query = mysqli_query($koneksi,"SELECT laporan.*, photos.*, users.username AS owner_username FROM laporan INNER JOIN photos ON laporan.foto_id = photos.photo_id INNER JOIN users ON photos.user_id = users.user_id");
                        $no = 1;
                        while($data = mysqli_fetch_assoc($query)):
                        ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $data['isi']; ?></td>
                            <td><?= $data['username']; ?></td>
                            <td><img src="../aset/img/<?= $data['image_path'] ?>" alt="" width='100' height='100'></td>
                            <td><?= $data['created_at']; ?></td>
                            <td>
                                <div class="btn-group" role="group">
                                    <form action='../config/hapus_postingan.php' method='POST' onsubmit="return confirm('Apakah anda ingin menghapus postingan ini?')">
                                        <input type='hidden' name='id' value='<?= $data['photo_id'] ?>'>
                                        <button type='submit' class='btn btn-danger btn-sm'>Delete</button>
                                    </form>
                                    <!-- Tambahkan button check di sini -->
                                    <button type='button' class='btn btn-primary btn-sm' data-toggle="modal"
                                    data-target="#laporan<?= $data['laporan_id'] ?>">Check
                                    </button>
                                </div>
                            </td>
                        </tr>

                  <!-- Modal -->
                  <div class="modal fade" id="laporan<?= $data['laporan_id']; ?>" tabindex="-1" aria-labelledby="komentarModalLabel<?= $data['laporan_id']; ?>" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="komentarModalLabel<?= $data['laporan_id']; ?>">Kirim Pesan Peringatan</h5>
               
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <p class='mb-2'>Anda yakin ingin mengirim pesan peringatan kepada <?= $data['owner_username'] ?> tentang laporan: "<?= $data['isi'] ?>"?</p>
                        <form method='post' action='kirim_pesan.php'>
                            <input type='hidden' name='laporan_id' value='<?= $data['laporan_id'] ?>'>
                            <input type='hidden' name='username' value='<?= $_SESSION['username'] ?>'>
                            <div class="form-group">
                                <label for="pesan<?= $data['laporan_id'] ?>">Pesan:</label>
                                <textarea class="form-control" id="pesan<?= $data['laporan_id'] ?>" name="pesan" rows="3" placeholder="Masukkan pesan peringatan"></textarea>
                            </div>
                            <button type='submit' class='btn btn-primary'>Kirim</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



                                </div>
                            </td>
                        </tr>
                        <?php endwhile ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script type="text/javascript" src="../aset/js/bootstrap.min.js"></script>

<script>
    function submitPesan(laporan_id) {
        var pesan = document.getElementById('pesan' + laporan_id).value;
        if (pesan.trim() !== '') {
            document.getElementById('pesanForm' + laporan_id).submit();
        } else {
            alert('Silakan isi pesan peringatan terlebih dahulu.');
        }
    }
</script>

</body>

</html>
