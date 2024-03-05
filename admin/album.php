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
        <a href="home.php" class="nav-link">Home</a>
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


    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="card mt-2">
                    <div class="card-header">Tambah Album</div>
                    <div class="card-body">
                        <form action="../config/aksi_album.php" method="POST">
                            <!-- Hapus input hidden untuk album_id -->

                            <div class="mb-3">
                                <label for="title" class="form-label">Nama Album</label>
                                <input type="text" name="title" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="deskripsi" class="form-label">Deskripsi</label>
                                <textarea class="form-control" name="description" required></textarea>
                            </div>

                            <button type="submit" class="btn btn-primary" name="tambah">Tambah Data</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card mt-2">
                    <div class="card-header">Data Album</div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Judul</th>
                                    <th>Deskripsi</th>
                                    <th>Tanggal</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                while ($data = mysqli_fetch_array($sql)) {
                                ?>
                                    <tr>
                                        <td><?php echo $no++ ?></td>
                                        <td><?php echo $data['title'] ?></td>
                                        <td><?php echo $data['description'] ?></td>
                                        <td><?php echo $data['created_at'] ?></td>
                                        <td>
                                          <!-- Modal Edit -->
                            <div class="modal fade" id="edit<?php echo $data['album_id'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                             <div class="modal-dialog">
                               <div class="modal-content">
                                 <div class="modal-header">
                              <h5 class="modal-title" id="exampleModalLabel">Edit Album</h5>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                  </div>
                               <div class="modal-body">
                                 <!-- Isi form untuk mengedit album -->
                               <form action="../config/aksi_album.php" method="POST">
                               <input type="hidden" name="album_id" value="<?php echo $data['album_id'] ?>">

                               <div class="form-group">
                               <label for="title" class="form-label">Nama Album</label>
                                  <input type="text" name="title" class="form-control" value="<?php echo $data['title'] ?>" required>
                                 </div>

                                 <div class="form-group">
                              <label for="deskripsi" class="form-label">Deskripsi</label>
                              <textarea class="form-control" name="description" required><?php echo $data['description'] ?></textarea>
                                </div>

                              <button type="submit" class="btn btn-primary mt-2" name="edit">Simpan Perubahan</button>
                              </form>
                             </div>
                             </div>
                              </div>
                             </div>


                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#edit<?php echo $data['album_id'] ?>">
                                                Edit
                                            </button>

                                            <div class="modal fade" id="edit<?php echo $data['album_id'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <!-- ... -->
                                            </div>

                                            <!-- Modal Hapus -->
                             <div class="modal fade" id="hapus<?php echo $data['album_id'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                             <div class="modal-dialog">
                               <div class="modal-content">
                                 <div class="modal-header">
                               <h5 class="modal-title" id="exampleModalLabel">Hapus Album</h5>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                              </div>
                             <div class="modal-body">
                            
                             <p>Apakah Anda yakin ingin menghapus album ini?</p>

                             <form action="../config/aksi_album.php" method="POST">
                               <input type="hidden" name="album_id" value="<?php echo $data['album_id'] ?>">
                                <button type="submit" class="btn btn-danger" name="hapus">Ya, Hapus</button>

                                     </form>
                                   </div>
                                   </div>
                                   </div>
                                  </div>

                                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#hapus<?php echo $data['album_id'] ?>">
                                                Hapus
                                            </button>

                                            <div class="modal fade" id="hapus<?php echo $data['album_id'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <!-- ... -->
                                            </div>

                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Pagination -->
                <nav aria-label="Page navigation example">
                  <ul class="pagination justify-content-center mt-3">
                    <?php if ($page > 1): ?>
                      <li class="page-item"><a class="page-link" href="?page=<?php echo $page - 1; ?>">Previous</a></li>
                    <?php endif; ?>
                    <?php if (mysqli_num_rows($sql) == $limit): ?>
                      <li class="page-item"><a class="page-link" href="?page=<?php echo $page + 1; ?>">Next</a></li>
                    <?php endif; ?>
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

