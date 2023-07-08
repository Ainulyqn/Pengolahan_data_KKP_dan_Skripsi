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

// Periksa apakah form telah disubmit
if (isset($_POST['submit'])) {
    // Ambil data dari form
    $judul = $_POST['judul'];
    $penulis = $_POST['penulis'];
    $pembimbing = $_POST['pembimbing'];
    $tanggal = $_POST['tanggal'];

    // Periksa apakah ada file yang diupload
    if ($_FILES['file']['name'] != '') {
        $file = $_FILES['file']['name'];
        $fileTmp = $_FILES['file']['tmp_name'];
        $fileDir = "uploads/";
        $filePath = $fileDir . $file;
        move_uploaded_file($fileTmp, $filePath);
        
        // Hapus file lama jika ada
        $oldFile = $skripsi['file'];
        if ($oldFile != '') {
            unlink($fileDir . $oldFile);
        }
        
        // Query untuk mengupdate data skripsi dengan file yang diubah
        $query = "UPDATE skripsi SET judul = '$judul', penulis = '$penulis', pembimbing = '$pembimbing', tanggal_upload = '$tanggal', file = '$file' WHERE id = $skripsiId";
    } else {
        // Query untuk mengupdate data skripsi tanpa mengubah file
        $query = "UPDATE skripsi SET judul = '$judul', penulis = '$penulis', pembimbing = '$pembimbing', tanggal_upload = '$tanggal' WHERE id = $skripsiId";
    }

    // Eksekusi query
    if (mysqli_query($conn, $query)) {
        // Redirect ke halaman index.php setelah data berhasil diupdate
        header("Location: ../index.php");
        exit;
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

// Query untuk mendapatkan detail skripsi berdasarkan ID
$query = "SELECT * FROM skripsi WHERE id = $skripsiId";
$result = mysqli_query($conn, $query);

// Periksa apakah skripsi ditemukan
if (mysqli_num_rows($result) == 0) {
    header("Location: index.php");
    exit;
}

$skripsi = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Skripsi</title>
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

        .form-label {
            font-weight: bold;
        }

        .back-link {
            margin-top: 20px;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
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
                    <h4>Edit Skripsi</h4>
                </div>
                <div class="card-body">
                    <form action="" method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="id" class="form-label">ID</label>
                            <input type="text" class="form-control" id="id" name="id" value="<?php echo $skripsi['id']; ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label for="judul" class="form-label">Judul</label>
                            <input type="text" class="form-control" id="judul" name="judul" value="<?php echo $skripsi['judul']; ?>">
                        </div>
                        <div class="form-group">
                            <label for="penulis" class="form-label">Penulis</label>
                            <input type="text" class="form-control" id="penulis" name="penulis" value="<?php echo $skripsi['penulis']; ?>">
                        </div>
                        <div class="form-group">
                            <label for="pembimbing" class="form-label">Pembimbing</label>
                            <input type="text" class="form-control" id="pembimbing" name="pembimbing" value="<?php echo $skripsi['pembimbing']; ?>">
                        </div>
                        <div class="form-group">
                            <label for="tanggal" class="form-label">Tanggal</label>
                            <input type="date" class="form-control" id="tanggal" name="tanggal" value="<?php echo $skripsi['tanggal_upload']; ?>">
                        </div>
                        <div class="form-group">
                            <label for="file" class="form-label">File</label>
                            <input type="file" class="form-control" id="file" name="file">
                            <small class="form-text text-muted">Biarkan kosong jika tidak ingin mengubah file.</small>
                        </div>
                        <button type="submit" class="btn btn-primary" name="submit">Simpan Perubahan</button>
                        <div class="back-link">
                            <a href="../index.php">Kembali ke Halaman Utama</a>
                        </div>
                    </form>
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