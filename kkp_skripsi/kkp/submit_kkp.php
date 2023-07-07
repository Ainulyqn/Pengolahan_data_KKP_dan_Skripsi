<?php
session_start();

// Periksa apakah pengguna telah login sebelumnya
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

$username = $_SESSION['username'];

// Koneksi ke database
$host = 'localhost';
$dbUsername = 'root'; // Ganti dengan username database Anda
$dbPassword = ''; // Ganti dengan password database Anda
$database = 'kkp-skripsi'; // Ganti dengan nama database Anda

$conn = mysqli_connect($host, $dbUsername, $dbPassword, $database);

// Periksa koneksi database
if (mysqli_connect_errno()) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

// Proses pengiriman data KKP
if (isset($_POST['submit'])) {
    // Ambil data dari form
    $nama = $_POST['nama'];
    $judul = $_POST['judul'];
    $dosen_pembimbing = $_POST['dosen_pembimbing'];
    $tanggal_upload = date('Y-m-d');

    // Proses unggah file
    $file_name = $_FILES['file']['name'];
    $file_tmp = $_FILES['file']['tmp_name'];
    $file_path = 'uploads/' . $file_name;

    // Pindahkan file yang diunggah ke direktori tujuan
    move_uploaded_file($file_tmp, $file_path);

    // Query untuk menyimpan data ke database
    $query = "INSERT INTO submit_kkp (nama, judul, dosen_pembimbing, tanggal_upload, file) VALUES ('$nama', '$judul', '$dosen_pembimbing', '$tanggal_upload', '$file_path')";

    // Eksekusi query
    if (mysqli_query($conn, $query)) {
        // Redirect ke halaman waiting_list.php setelah data berhasil disimpan
        header("Location: waiting_list.php");
        exit;
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Submit KKP</title>
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .navbar-brand img {
            width: 30px;
            height: 30px;
            margin-right: 5px;
            vertical-align: middle;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="index.php">
            <img src="img/UPB.png" width="30" height="30" class="d-inline-block align-top" alt="">
            <?php echo $username; ?>
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="submit_kkp.php">Submit KKP</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="edit_kkp.php">Edit KKP</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="waiting_list.php">Waiting List</a>
                </li>
            </ul>
        </div>
        <div class="navbar-nav ml-auto">
            <a class="nav-link" href="index.php">Keluar</a>
        </div>
    </nav>

    <div class="container mt-4">
        <h2>Submit KKP</h2>
        <form method="post" action="submit_kkp.php" enctype="multipart/form-data">
            <div class="form-group">
                <label for="nama">Nama:</label>
                <input type="text" name="nama" id="nama" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="judul">Judul:</label>
                <input type="text" name="judul" id="judul" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="dosen_pembimbing">Dosen Pembimbing:</label>
                <input type="text" name="dosen_pembimbing" id="dosen_pembimbing" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="file">File:</label>
                <input type="file" name="file" id="file" class="form-control-file" required>
            </div>
            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
