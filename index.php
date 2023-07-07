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
            padding: 15px;
            border-bottom: none;
            border-radius: 10px 10px 0 0;
        }

        .card-body {
            padding: 20px;
        }

        .kkp-title,
        .skripsi-title {
            color: #343a40;
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .kkp-option,
        .skripsi-option {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .kkp-option li,
        .skripsi-option li {
            padding: 15px;
            border-bottom: 1px solid #eee;
            cursor: pointer;
        }

        .kkp-option li:last-child,
        .skripsi-option li:last-child {
            border-bottom: none;
        }

        .kkp-option li:hover,
        .skripsi-option li:hover {
            background-color: #f8f9fa;
        }

        .kkp-option li .option-title,
        .skripsi-option li .option-title {
            font-size: 18px;
            font-weight: bold;
            color: #343a40;
        }

        .kkp-option li .option-description,
        .skripsi-option li .option-description {
            font-size: 14px;
            color: #666;
            margin-top: 5px;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <a class="navbar-brand" href="#">Main Menu</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="kkp/submit_kkp.php">KKP</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="skripsi.php">Skripsi</a>
                </li>
            </ul>
        </div>
        <div class="navbar-nav ml-auto">
            <a class="nav-link" href="logout.php">Logout (<?php echo $username; ?>)</a>
        </div>
    </nav>
    <div class="container mt-4">
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="kkp-title">Pilihan KKP</h4>
                </div>
                <div class="card-body">
                    <ul class="kkp-option">
                        <?php
                        // Query untuk mendapatkan daftar data KKP yang telah disubmit
                        $query = "SELECT * FROM kkp";
                        $result = mysqli_query($conn, $query);

                        while ($row = mysqli_fetch_assoc($result)) {
                            echo '<li>';
                            echo '<div class="option-title">' . $row['nama'] . '</div>';
                            if (isset($row['deskripsi'])) {
                                echo '<div class="option-description">' . $row['deskripsi'] . '</div>';
                            } else {
                                echo '<div class="option-description">Deskripsi KKP tidak tersedia</div>';
                            }
                            echo '<div class="option-actions">';
                            echo <a href="detail.php?id=<?php echo $row['id']; ?>" 
                              echo  class="btn btn-primary">Detail</a>
                                <a href="edit.php?id=<?php echo $row['id']; ?>"                         
                                class="btn btn-success">Edit</a>
                                 <a href="delete.php?id=<?php echo $row['id']; ?>"
                                class="btn btn-danger">Hapus</a>
                            
                            echo '</div>';
                            echo '</li>';
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="skripsi-title">Pilihan Skripsi</h4>
                </div>
                <div class="card-body">
                    <ul class="skripsi-option">
                        <?php
                        // Query untuk mendapatkan daftar data Skripsi yang telah disubmit
                        $query = "SELECT * FROM skripsi";
                        $result = mysqli_query($conn, $query);

                        while ($row = mysqli_fetch_assoc($result)) {
                            echo '<li>';
                            echo '<div class="option-title">' . $row['nama'] . '</div>';
                            if (isset($row['deskripsi'])) {
                                echo '<div class="option-description">' . $row['deskripsi'] . '</div>';
                            } else {
                                echo '<div class="option-description">Deskripsi Skripsi tidak tersedia</div>';
                            }
                            echo '<div class="option-actions">';
                            echo '<a href="#" class="btn btn-primary btn-sm">Detail</a>';
                            echo '<a href="#" class="btn btn-success btn-sm">Edit</a>';
                            echo '<a href="#" class="btn btn-danger btn-sm">Hapus</a>';
                            echo '</div>';
                            echo '</li>';
                        }
                        ?>
                    </ul>
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