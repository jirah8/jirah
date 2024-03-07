<?php 
include "config/koneksi.php";

// Setup paginasi
$limit_per_page = 6; // Jumlah foto per halaman
$current_page = isset($_GET['page']) ? $_GET['page'] : 1; // Tentukan halaman saat ini

$offset = ($current_page - 1) * $limit_per_page;
$query = mysqli_query($koneksi, "SELECT * FROM photos LIMIT $offset, $limit_per_page");

// Pastikan query berhasil dieksekusi
if (!$query) {
    die("Query error: " . mysqli_error($koneksi)); 
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Website Galeri Foto</title>
    <link rel="stylesheet" type="text/css" href="aset/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
    .card-img-top {
        height: 12rem;
        object-fit: cover;
    }
    .card-footer {
        display: flex;
        justify-content: space-around; 
    }
    .card:hover {
        transform: scale(1.05);
        transition: transform 0.1s ease;
        box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.5);
    }
</style>

</head>
<body>

<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container">
        <a class="navbar-brand" href="index.php">Website Galeri Foto</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse mt-2" id="navbarNavAltMarkup">
            <div class="navbar-nav me-auto"></div>
            <a href="register.php" class="btn btn-outline-primary m-1">Daftar</a>
            <a href="login.php" class="btn btn-outline-success m-1">Masuk</a>
        </div>
    </div>
</nav>

<div class="container mt-3">
    <div class="row">
        <?php while($data = mysqli_fetch_assoc($query)): ?>
        <div class="col-md-4 mb-3">
            <div class="card">
                <img src="aset/img/<?= $data['image_path'] ?>" class="card-img-top" title="" alt="<?= $data['description'] ?>">
                <div class="card-footer text-center">
                    <a href="#">
                        <i class="fa-regular fa-heart"></i>
                        <?php 
                            $result_like = mysqli_query($koneksi,"SELECT * FROM likes WHERE photo_id = '{$data['photo_id']}'");
                            echo mysqli_num_rows($result_like);
                        ?>
                        Suka
                    </a>
                    <a href="#">
                        <i class="fa-regular fa-comment"></i>
                        <?php 
                            $result_comment = mysqli_query($koneksi,"SELECT * FROM photos WHERE photo_id = '{$data['photo_id']}'");
                            echo mysqli_num_rows($result_comment);
                        ?>
                        Komentar
                    </a>
                </div>
            </div>
        </div>
        <?php endwhile; ?>
    </div>

    <!-- Paginasi -->
    <nav aria-label="Page navigation example">
        <ul class="pagination justify-content-center">
            <?php if($current_page > 1): ?>
            <!-- Tombol "Previous" hanya ditampilkan jika halaman saat ini bukan halaman pertama -->
            <li class="page-item"><a class="page-link" href="?page=<?= $current_page - 1 ?>">Previous</a></li>
            <?php endif; ?>
            <?php 
            // Hitung jumlah total data
            $total_data = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM photos"));
            
            // Hitung halaman terakhir
            $last_page = ceil($total_data / $limit_per_page);
            
            // Tampilkan tombol "Next" jika halaman saat ini tidak sama dengan halaman terakhir
            if($current_page < $last_page): ?>
            <li class="page-item"><a class="page-link" href="?page=<?= $current_page + 1 ?>">Next</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</div>

<script type="text/javascript" src="aset/js/bootstrap.min.js"></script>
</body>
</html>
