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

// Query untuk mendapatkan data KKP berdasarkan ID
$query = "SELECT * FROM kkp WHERE id = $kkpId";
$result = mysqli_query($conn, $query);

// Periksa apakah KKP ditemukan
if (mysqli_num_rows($result) == 0) {
    header("Location: index.php");
    exit;
}

$kkp = mysqli_fetch_assoc($result);

// Hapus file jika ada
if (isset($kkp['file'])) {
    $file = $kkp['file'];
    $fileDir = "uploads/";
    $filePath = $fileDir . $file;
    if (file_exists($filePath)) {
        unlink($filePath);
    }
}

// Query untuk menghapus data KKP berdasarkan ID
$deleteQuery = "DELETE FROM kkp WHERE id = $kkpId";
if (mysqli_query($conn, $deleteQuery)) {
    header("Location: ../index.php");
    exit;
} else {
    echo "Error: " . mysqli_error($conn);
}

mysqli_close($conn);
?>
