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
    // Hitung total data foto
    $sqlCount = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM photos WHERE user_id='$user_id'");
    $row = mysqli_fetch_assoc($sqlCount);
    $total_records = $row['total'];
    
    // Pagination setup
    $limit = 4;
    $total_pages = ceil($total_records / $limit);
    $page = isset($_GET['page']) && $_GET['page'] <= $total_pages ? $_GET['page'] : 1;
    $start = ($page - 1) * $limit;
    
    // Fetch data with pagination
    $sql1 = mysqli_query($koneksi, "SELECT * FROM photos WHERE user_id='$user_id' LIMIT $start, $limit");
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
                                $no = ($page - 1) * $limit + 1;
                                while ($data = mysqli_fetch_assoc($sql1)) {
                                ?>
                                    <tr>
                                        <td><?php echo $no++ ?></td>
                                        <!-- Tampilkan gambar -->
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
                             </button>

                                            <div class="modal fade" id="edit<?php echo $data['foto'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <!-- ... -->
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
                                                <!-- ... -->
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

<!-- Pagination -->
<nav aria-label="Page navigation example">
    <ul class="pagination justify-content-center mt-3">
        <?php if ($page > 1): ?>
            <li class="page-item"><a class="page-link" href="?page=<?php echo $page - 1; ?>">Previous</a></li>
        <?php endif; ?>
        <?php if ($page < $total_pages): ?>
            <li class="page-item"><a class="page-link" href="?page=<?php echo $page + 1; ?>">Next</a></li>
        <?php endif; ?>
    </ul>
</nav>

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

<script>
    <?php if(isset($_GET['tambah_success'])): ?>
        alert("Data berhasil ditambahkan!");
    <?php endif; ?>
</script>

<!-- Setelah form edit data -->
<script>
    <?php if(isset($_GET['edit_success'])): ?>
        alert("Data berhasil diubah!");
    <?php endif; ?>
</script>
</body>
</html>
