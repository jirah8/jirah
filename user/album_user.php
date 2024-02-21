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
    $sql = mysqli_query($koneksi, "SELECT * FROM albums WHERE user_id='$user_id'");
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

    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="card mt-2">
                    <div class="card-header">Tambah Album</div>
                    <div class="card-body">
                        <form action="../config/aksi_album.php" method="POST">
                            

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
                                     <form action="../config/aksi_album.php" method="POST">
                                  <input type="hidden" name="album_id" value="<?php echo $data['album_id'] ?>">
                                    <div class="mb-3">
                               <label for="title" class="form-label">Nama Album</label>
                                   <input type="text" name="title" class="form-control" value="<?php echo $data['title'] ?>" required>
                               </div>
                                <div class="mb-3">
                                   <label for="deskripsi" class="form-label">Deskripsi</label>
                                     <textarea class="form-control" name="description" required><?php echo $data['description'] ?></textarea>
                                   </div>
                                <button type="submit" class="btn btn-primary" name="edit">Simpan Perubahan</button>
                             </form>
                           </div>
                         </div>
                        </div>
                     </div>

                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#edit<?php echo $data['album_id'] ?>">
                         Edit
                        </button>
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


                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="../aset/js/bootstrap.min.js"></script>
</body>

</html>
