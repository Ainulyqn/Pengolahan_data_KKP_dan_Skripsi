<?php
session_start();

// Periksa apakah pengguna telah login sebelumnya
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

// Periksa apakah ID KKP telah diberikan
if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$kkpId = $_GET['id'];

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

// Query untuk mendapatkan detail KKP berdasarkan ID
$query = "SELECT * FROM kkp WHERE id = $kkpId";
$result = mysqli_query($conn, $query);

// Periksa apakah KKP ditemukan
if (mysqli_num_rows($result) == 0) {
    header("Location: index.php");
    exit;
}

$kkp = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Detail KKP</title>
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .navbar {
            background-color: #343a40;
        }

        .navbar-brand {
            color: #fff;
            font-weight: bold;
            font-size: 24px;
        }

        .navbar-nav .nav-link {
            color: #fff;
            font-size: 18px;
            margin-left: 10px;
        }

        .navbar-nav .nav-link:hover {
            color: #f8f9fa;
        }

        .card {
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            background-color: #343a40;
            color: #fff;
            font-size: 24px;
            font-weight: bold;
            padding: 15px;
            border-bottom: none;
            border-radius: 10px 10px 0 0;
        }

        .card-body {
            padding: 20px;
        }

        .kkp-title {
            color: #343a40;
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .kkp-detail {
            font-size: 18px;
            color: #666;
            margin-top: 5px;
        }

        .back-link {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <a class="navbar-brand" href="#">Main Menu</a>
        <div class="navbar-nav ml-auto">
            <a class="nav-link" href="logout.php">Logout</a>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <div class="card">
                    <div class="card-header">
                        <h4 class="kkp-title"><?php echo $kkp['nama']; ?></h4>
                    </div>
                    <div class="card-body">
                        <div class="kkp-detail">ID: <?php echo $kkp['id']; ?></div>
                        <div class="kkp-detail">Nama: <?php echo $kkp['nama']; ?></div>
                        <div class="kkp-detail">Judul: <?php echo $kkp['judul']; ?></div>
                        <div class="kkp-detail">Dosen Pembimbing: <?php echo $kkp['dosen_pembimbing']; ?></div>
                        <div class="kkp-detail">Tanggal Upload: <?php echo $kkp['tanggal_upload']; ?></div>
                        <div class="kkp-detail">File: <a href="uploads/<?php echo $kkp['file']; ?>"><?php echo $kkp['file']; ?></a></div>
                        <div class="back-link">
                            <a href="index.php">Kembali ke Pilihan KKP</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
