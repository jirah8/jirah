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
}
$sql1 = mysqli_query($koneksi, "SELECT * FROM photos WHERE user_id='$user_id'");

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
            <div class="col-md-4">
                <div class="card mt-2">
                    <div class="card-header">Tambah Foto</div>
                    <div class="card-body">
                    <form action="../config/aksi_foto.php" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="title" class="form-label">Judul</label>
                        <input type="text" name="title" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="deskripsi" class="form-label">Deskripsi</label>
                        <textarea class="form-control" name="description" required></textarea>
                    </div>

                    <div class="form-group">
                        <label for="deskripsi" class="form-label">Album</label>
                        <select name='album_id' class='form-control'>
                            <?php
                                $user_id = $_SESSION['user_id'];
                                $sql = mysqli_query($koneksi,"SELECT * FROM albums WHERE user_id = $user_id ");
                                while($d = mysqli_fetch_assoc($sql)) :        
                            ?>  
                                <option value="<?= $d['album_id'] ?>"><?= $d['title'] ?></option>
                            <?php endwhile ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="deskripsi" class="form-label">File</label>
                        <input type="file" class="form-control" name="lokasifile" required>
                    </div>

                    <button type="submit" class="btn btn-primary mt-2" name="tambah">Tambah Data</button>
                </form>

                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <div class="card mt-2">
                    <div class="card-header">Data Album</div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Foto</th>
                                    <th>Judul</th>
                                    <th>Deskripsi</th>
                                    <th>Tanggal</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                while ($data = mysqli_fetch_assoc($sql1)) {
                                ?>
                                    <tr>
                                        <td><?php echo $no++ ?></td>
                                        
                                        <td>
                                            <img src="../aset/img/<?php echo $data['image_path']?>" style="width:200px;height:150px" />
                                        </td>
                                        <td><?php echo $data['title'] ?></td>
                                        <td><?php echo $data['description'] ?></td>
                                        <td><?php echo $data['created_at'] ?></td>
                                        <td>
                                          <!-- Modal Edit -->
                                          <div class="modal fade" id="editModal<?php echo $data['photo_id'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                             <div class="modal-dialog">
                               <div class="modal-content">
                                 <div class="modal-header">
                              <h5 class="modal-title" id="exampleModalLabel">Edit Album</h5>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                  </div>
                               <div class="modal-body">
                               
                                 <form action="../config/aksi_foto.php" method="POST" enctype="multipart/form-data">

                               <input type="hidden" name="album_id" value="<?php echo $data['album_id'] ?>">
                               <input type="hidden" name="photo_id" value="<?php echo $data['photo_id'] ?>">

                               <div class="form-group">
                               <label for="title" class="form-label">Nama Album</label>
                                  <input type="text" name="title" class="form-control" value="<?php echo $data['title'] ?>" required>
                                 </div>

                                 <div class="form-group">
                                    <label for="deskripsi" class="form-label">Deskripsi</label>
                                    <textarea class="form-control" name="description" required><?php echo $data['description'] ?></textarea>
                                </div>
                                 <div class="form-group">
                                    <label for="deskripsi" class="form-label">Edit gambar</label>
                                    <input type='file' class='form-control' name='lokasifile' onchange='previewImage(event)'/>
                                    <img src="../aset/img/<?php echo $data['image_path'] ?>" width='200' height='200' id='preview' alt='prewiev'/>
                                </div>

                               
                              <button type="submit" class="btn btn-primary mt-2" name="edit">Simpan Perubahan</button>
                              </form>
                             </div>
                             </div>
                              </div>
                             </div>


                             <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editModal<?php echo $data['photo_id'] ?>">
                              Edit
                             </button

                                            <div class="modal fade" id="edit<?php echo $data['foto'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                              
                                            </div>

                                            <!-- Modal Hapus -->
                                            <div class="modal fade" id="hapusModal<?php echo $data['photo_id'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                             <div class="modal-dialog">
                               <div class="modal-content">
                                 <div class="modal-header">
                               <h5 class="modal-title" id="exampleModalLabel">Hapus Album</h5>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                              </div>
                             <div class="modal-body">
                            
                             <p>Apakah Anda yakin ingin menghapus album ini?</p>

                             <form action="../config/aksi_foto.php?photo_id=<?php echo $data['photo_id'] ?>" method="POST">
                               <input type="hidden" name="album_id" value="<?php echo $data['album_id'] ?>">
                               <input type="hidden" name="photo_id" value="<?php echo $data['photo_id'] ?>">

                                <button type="submit" class="btn btn-danger" name="hapus">Ya, Hapus</button>

                                     </form>
                                   </div>
                                   </div>
                                   </div>
                                  </div>

                                  <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#hapusModal<?php echo $data['photo_id'] ?>">
                                    Hapus
                                 </button>

                                            <div class="modal fade" id="hapus<?php echo $data['foto'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                           
                                            </div>

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
    <script>
    function previewImage(event) {
        var reader = new FileReader();
        reader.onload = function() {
            var output = document.getElementById('preview');
            output.src = reader.result;
        }
        reader.readAsDataURL(event.target.files[0]);
    }
</script>





    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="../aset/js/bootstrap.min.js"></script>

    <script>
    <?php if(isset($_GET['tambah_success'])): ?>
        alert("Data berhasil ditambahkan!");
    <?php endif; ?>
</script>


<script>
    <?php if(isset($_GET['edit_success'])): ?>
        alert("Data berhasil diubah!");
    <?php endif; ?>
</script>
</body>

</html>
