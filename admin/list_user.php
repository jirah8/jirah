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
    $sql = mysqli_query($koneksi, "SELECT * FROM users");
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
    <div class="container mt-3">
    <td>
     <form action="tambah_pengguna.php" method="post">
     <input type="hidden" name="user_id" value="<?php echo $row['user_id']; ?>">
     <button type="submit" name="deleteUser" class="btn btn-secondary btn-outline m mb-4" >Tambah Pengguna</button>
     </form>

     </td>
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
                            <th>Password</th>
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
                                    <td><?php echo $row['password']; ?></td>
                                    <td><?php echo isset($row['acces_level']) ? $row['acces_level'] : ''; ?></td>
                                    <td><?php echo $row['created_at']; ?></td>
                                    <td>
                                        <form action="../config/aksi_user.php" method="post">
                                            <input type="hidden" name="user_id" value="<?php echo $row['user_id']; ?>">
                                            <button type="submit" name="deleteUser" class="btn btn-danger btn-sm">Delete</button>
                                        </form>
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




    <script type="text/javascript" src="../aset/js/bootstrap.min.js"></script>
</body>

</html>
