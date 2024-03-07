<?php
session_start();
if (!isset($_SESSION['status']) || $_SESSION['status'] != 'login') {
    echo "<script>
    alert('Anda belum Login!');
    location.href='../index.php';
    </script>";
    exit; 
}

include_once("../config/koneksi.php");

// Pastikan id_album telah diberikan
if (!isset($_GET['id_album'])) {
    echo "ID Album tidak diberikan.";
    exit;
}

// Dapatkan id_album dan amankan
$id_album = mysqli_real_escape_string($koneksi, $_GET['id_album']);

// Setup paginasi
$results_per_page = 6; // Jumlah foto per halaman
$query_count = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM photos WHERE album_id = $id_album");
$row = mysqli_fetch_assoc($query_count);
$total_results = $row['total'];
$total_pages = ceil($total_results / $results_per_page);

// Tentukan halaman saat ini
$current_page = isset($_GET['page']) ? $_GET['page'] : 1;
$offset = ($current_page - 1) * $results_per_page;

// Mendapatkan user_id dari session
$user_id = $_SESSION['user_id'];

// Ambil judul dan deskripsi album dari database
$query_album_info = mysqli_query($koneksi, "SELECT title, description, created_at FROM albums WHERE album_id = $id_album");
$album_info = mysqli_fetch_assoc($query_album_info);
$album_title = $album_info['title'];
$album_description = $album_info['description'];
$album_created_at = $album_info['created_at'];


$query = mysqli_query($koneksi, "SELECT photos.*, users.name
    FROM photos
    INNER JOIN users ON photos.user_id = users.user_id
    WHERE photos.album_id = $id_album
    LIMIT $offset, $results_per_page");

if (!$query) {
    die("Query error: " . mysqli_error($koneksi)); 
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Website Galeri Foto - <?php echo $album_title; ?></title>
    <link rel="stylesheet" type="text/css" href="../aset/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
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
    .album-button {
        width: 100%;
        text-align: center;
        transition: transform 0.3s ease; /* Menambahkan transisi */
    }
    .album-button:hover {
        transform: scale(1.1); /* Mengubah skala saat disentuh */
    }
    .card:hover {
        transform: scale(1.05); /* Memperbesar card saat disentuh */
        transition: transform 0.3s ease; /* Menambahkan transisi */
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

<!-- Tampilkan judul dan deskripsi album -->
<div class="container mt-3">
    <div class="row">
    <div class="col">
    <h2><?php echo $album_title; ?></h2>
    <p><?php echo $album_description; ?></p>
    <p><?php echo $album_created_at; ?></p>
    </div>

    </div>
</div>

<div class="container mt-3" style='padding-right:6px;padding-left:6px;padding-top:2em'>
  <div class="row">
    <?php
    while($data = mysqli_fetch_assoc($query)){
    ?>
    <div class="col-md-4 mb-3">
        <div q class="card mb-2">
            <!-- Button trigger modal -->
            <div class="btn btn-transparan" data-bs-toggle="modal" data-bs-target="#Komentar<?php echo $data['photo_id']?>"> <!-- Mengganti button dengan div -->
    <img src="../aset/img/<?php echo $data['image_path']?>" class="card-img-top" title="<?php echo $data['title'] ?>" style="height: 15rem;">
    <div class="card-footer text-center">
        <?php
        $photo_id = $data['photo_id'];
        $ceksuka = mysqli_query($koneksi,"SELECT * FROM likes WHERE photo_id = '$photo_id' AND user_id = '$user_id'");
        if (mysqli_num_rows($ceksuka) == 1) { ?> 
            <a href="../config/proses_like.php?action=unlike&photo_id=<?php echo $data['photo_id']?>" type="submit" name="batalsuka"><i class ="fa fa-heart " style='color:red'></i></a>
        <?php } else { ?>
            <a href="../config/proses_like.php?action=like&photo_id=<?php echo $data['photo_id']?>" type="submit" name="suka"><i class ="fa-regular fa-heart" ></i></a>
        <?php } ?>
        <?php
        $like = mysqli_query($koneksi,"SELECT * FROM likes WHERE photo_id = '$photo_id'");
        echo mysqli_num_rows($like). ' suka';
        ?>
        <!-- Ubah bagian ini untuk menambahkan fitur komentar -->
        <a href="#" data-bs-toggle="modal" data-bs-target="#komentarModal<?php echo $data['photo_id']; ?>"><i class="fa-regular fa-comment"></i></a>
        <?php
        $jmlkomen = mysqli_query($koneksi,"SELECT * FROM comments WHERE photo_id='$photo_id'");
        if($jmlkomen){
            $jumlah_komentar = 0;
            while($komentar = mysqli_fetch_assoc($jmlkomen)){
                if (is_komentar_buruk($komentar['comment_text'])) {
                    continue; // Lewati komentar buruk
                }
                $jumlah_komentar++;

            }
            
            echo $jumlah_komentar . ' komentar';
        } else {
            echo "0 komentar";
        }
        ?>
    </div>
</div>

        </div>
    </div>
<!-- Modal untuk komentar -->
<div class="modal fade" id="komentarModal<?php echo $data['photo_id']; ?>" tabindex="-1" aria-labelledby="komentarModalLabel<?php echo $data['photo_id']; ?>" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="komentarModalLabel<?php echo $data['photo_id']; ?>"><?php echo $data['title']; ?></h5> <!-- Menampilkan judul foto -->
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                <h6><p><?php echo $data['name']; ?></p></h6>
                    <!-- Deskripsi Foto -->
                    <div class="col-md-12">
                        <h6>Deskripsi Foto:</h6>
                        <p><?php echo $data['description']; ?></p> <!-- Menampilkan deskripsi foto -->
                    </div>
                    <!-- Foto yang akan dikomentari -->
                    <div class="col-md-6">
                        <img src="../aset/img/<?php echo $data['image_path']; ?>" class="card-img-top" style="height: 15rem;" alt="<?php echo $data['title']; ?>">
                    </div>
                    <div class="col-md-6">
                        <div class="mt-3">
                            <h6>Komentar:</h6>
                            <div class="overflow-auto" style="max-height: 300px;"> <!-- Atur ketinggian maksimum dan tambahkan overflow auto -->
                                <?php
                                $photo_id = $data['photo_id'];
                                $query_komentar = mysqli_query($koneksi, "SELECT comments.*, users.username FROM comments INNER JOIN users ON comments.user_id = users.user_id WHERE comments.photo_id='$photo_id'");
                                $jumlah_komentar = 0; // Inisialisasi jumlah komentar

                                while ($komentar = mysqli_fetch_assoc($query_komentar)) {
                                    
                                    // Cek apakah komentar buruk atau tidak
                                    if (is_komentar_buruk($komentar['comment_text'])) {
                                        continue; // Lewati komentar buruk
                                    }
                                    echo "<p style='word-wrap: break-word;'><strong>" . $komentar['username'] . ":</strong> " . $komentar['comment_text'] . "</p>"; // Tambahkan style word-wrap: break-word; pada tag p
                                    echo "<form method='post' action='../config/hapus_komentar.php'>
                                            <input type='hidden' name='komentar_id' value='{$komentar['comments_id']}' />
                                            <input type='hidden' name='photo_id' value='$photo_id' />
                                            <button type='submit' class='btn btn-danger mb-4'>Hapus</button>
                                            
                                        </form>";
                                        
                                    $jumlah_komentar++; // Tambahkan jumlah komentar
                                }
                                ?>
                            </div>
                            <!-- Tampilkan jumlah komentar jika jumlahnya tidak nol -->
                            <?php if ($jumlah_komentar > 0): ?>
                                <p>Jumlah Komentar: <?php echo $jumlah_komentar; ?></p>
                            <?php endif; ?>
                        </div>
                        <!-- Form untuk mengirim komentar -->
                        <form action="../config/proses_komentar.php" method="POST">
                            <input type="hidden" name="photo_id" value="<?php echo $data['photo_id']; ?>">
                            <div class="mb-3">
                                <label for="komentarText" class="form-label">Isi Komentar</label>
                                <textarea class="form-control" id="komentarText" name="isikomentar" required></textarea>
                            </div>
                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary">Kirim</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>




    <?php } ?>
<?php
// Fungsi untuk mengecek apakah komentar buruk atau tidak
function is_komentar_buruk($komentar) {
    // Lakukan pengecekan di sini, misalnya:
    // Jika komentar mengandung kata-kata tertentu yang dianggap buruk, kembalikan true
    // Jika tidak, kembalikan false
    // Contoh sederhana:
    $kata_buruk = array("kotor", "kutu", "jelek","goblok"); // Kata-kata yang dianggap buruk
    foreach ($kata_buruk as $kata) {
        if (stripos($komentar, $kata) !== false) {
            return true; // Komentar mengandung kata buruk
        }
    }
    return false; // Komentar tidak mengandung kata buruk
}

?>
  </div>
</div>

<!-- Tampilkan navigasi halaman -->
<div class="container mt-3">
    <div class="row">
        <div class="col">
            <nav aria-label="Page navigation example">
                <ul class="pagination justify-content-center">
                    <li class="page-item <?php echo ($current_page == 1) ? 'disabled' : ''; ?>"><a class="page-link" href="?id_album=<?php echo $id_album; ?>&page=<?php echo ($current_page - 1); ?>">Previous</a></li>
                    <li class="page-item <?php echo ($current_page == $total_pages) ? 'disabled' : ''; ?>"><a class="page-link" href="?id_album=<?php echo $id_album; ?>&page=<?php echo ($current_page + 1); ?>">Next</a></li>
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
