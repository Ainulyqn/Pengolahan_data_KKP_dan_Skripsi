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

    // Query untuk menyimpan data ke database
    $query = "INSERT INTO submit_kkp (nama, judul, dosen_pembimbing, tanggal_upload) VALUES ('$nama', '$judul', '$dosen_pembimbing', '$tanggal_upload')";

    // Eksekusi query
    if (mysqli_query($conn, $query)) {
        // Redirect ke halaman daftar_kkp.php setelah data berhasil disimpan
        header("Location: daftar_kkp.php");
        exit;
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Main Menu</title>
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
            padding: 20px;
            border-bottom: none;
            border-radius: 10px 10px 0 0;
        }

        .card-body {
            padding: 30px;
        }

        .option-title {
            font-size: 18px;
            font-weight: bold;
            color: #343a40;
        }

        .option-description {
            font-size: 14px;
            color: #666;
            margin-top: 5px;
        }

        .submit-option,
        .peserta-option {
            margin-bottom: 20px;
        }

        .container {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-top: 50px;
        }

        .container .col-md-4 {
            flex-basis: 30%;
            margin-right: 10px;
        }

        .iframe-container {
            position: relative;
            overflow: hidden;
            padding-top: 56.25%; /* Mengatur rasio aspek 16:9 */
        }

        .iframe-container iframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border: 0;
        }

        .exit-button {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <a class="navbar-brand" href="#"></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="navbar-nav ml-auto">
            <a class="nav-link" href="logout.php">Logout (<?php echo $username; ?>)</a>
        </div>
    </nav>
    <div class="container">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h4>Submit</h4>
                </div>
                <div class="card-body">
                    <div class="submit-option">
                        <div class="option-title">Submit</div>
                        <div class="option-description">Submit KKP atau Skripsi baru</div>
                        <div class="option-actions">
                            <a href="kkp/submit_kkp.php" class="btn btn-primary">Submit KKP</a>
                            <a href="skripsi/submit_skripsi.php" class="btn btn-success">Submit Skripsi</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h4>Peserta KKP</h4>
                </div>
                <div class="card-body">
                    <div class="peserta-option">
                        <div class="option-title">Peserta KKP</div>
                        <div class="option-description">Daftar peserta KKP yang telah terdaftar</div>
                        <div class="option-actions">
                            <a href="kkp/list_kkp.php" class="btn btn-primary">Lihat Peserta KKP</a>
                            </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h4>Peserta Skripsi</h4>
                </div>
                <div class="card-body">
                    <div class="peserta-option">
                        <div class="option-title">Peserta Skripsi</div>
                        <div class="option-description">Daftar peserta Skripsi yang telah terdaftar</div>
                        <div class="option-actions">
                            <a href="skripsi/list_skripsi.php" class="btn btn-primary">Lihat Peserta Skripsi</a>
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
