<?php
session_start();

// Periksa apakah pengguna telah login sebelumnya
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

// Periksa apakah ID Skripsi telah diberikan
if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$skripsiId = $_GET['id'];

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

// Query untuk mendapatkan data Skripsi berdasarkan ID
$query = "SELECT * FROM skripsi WHERE id = $skripsiId";
$result = mysqli_query($conn, $query);

// Periksa apakah Skripsi ditemukan
if (mysqli_num_rows($result) == 0) {
    header("Location: index.php");
    exit;
}

$skripsi = mysqli_fetch_assoc($result);

mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Detail Skripsi</title>
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .container {
            margin-top: 50px;
        }

        h2 {
            margin-bottom: 30px;
        }

        label {
            font-weight: bold;
        }

        .btn-edit {
            margin-right: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Detail Skripsi</h2>
        <div class="form-group row">
            <label for="id" class="col-sm-2 col-form-label">ID</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="id" value="<?php echo $skripsi['id']; ?>" readonly>
            </div>
        </div>
        <div class="form-group row">
            <label for="judul" class="col-sm-2 col-form-label">Judul</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="judul" value="<?php echo $skripsi['judul']; ?>" readonly>
            </div>
        </div>
        <div class="form-group row">
            <label for="penulis" class="col-sm-2 col-form-label">Penulis</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="penulis" value="<?php echo $skripsi['penulis']; ?>" readonly>
            </div>
        </div>
        <div class="form-group row">
            <label for="pembimbing" class="col-sm-2 col-form-label">Pembimbing</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="pembimbing" value="<?php echo $skripsi['pembimbing']; ?>" readonly>
            </div>
        </div>
        <div class="form-group row">
            <label for="tanggal" class="col-sm-2 col-form-label">Tanggal</label>
            <div class="col-sm-10">
                <?php
                if (isset($skripsi['tanggal_upload'])) {
                    $tanggalFormatted = date('d F Y', strtotime($skripsi['tanggal_upload']));
                    echo '<input type="text" class="form-control" id="tanggal" value="' . $tanggalFormatted . '" readonly>';
                } else {
                    echo '<input type="text" class="form-control" id="tanggal" value="Tanggal tidak tersedia" readonly>';
                }
                ?>
            </div>
        </div>
        <div class="form-group row">
            <label for="file" class="col-sm-2 col-form-label">File</label>
            <div class="col-sm-10">
                <?php
                if (isset($skripsi['file'])) {
                    echo '<input type="text" class="form-control" id="file" value="' . $skripsi['file'] . '" readonly>';
                } else {
                    echo '<input type="text" class="form-control" id="file" value="File tidak tersedia" readonly>';
                }
                ?>
            </div>
        </div>
        <div class="form-group">
            <a href="edit_skripsi.php?id=<?php echo $skripsiId; ?>" class="btn btn-primary btn-edit">Edit</a>
            <a href="delete_skripsi.php?id=<?php echo $skripsiId; ?>" class="btn btn-danger">Hapus</a>
        </div>
        <a href="../index.php" class="btn btn-secondary">Kembali ke Halaman Utama</a>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
