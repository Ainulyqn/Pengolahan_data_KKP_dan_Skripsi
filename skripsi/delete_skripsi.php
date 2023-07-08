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

// Hapus file jika ada
if (isset($skripsi['file'])) {
    $file = $skripsi['file'];
    $fileDir = "uploads/";
    $filePath = $fileDir . $file;
    if (file_exists($filePath)) {
        unlink($filePath);
    }
}

// Query untuk menghapus data Skripsi berdasarkan ID
$deleteQuery = "DELETE FROM skripsi WHERE id = $skripsiId";
if (mysqli_query($conn, $deleteQuery)) {
    header("Location: ../index.php");
    exit;
} else {
    echo "Error: " . mysqli_error($conn);
}

mysqli_close($conn);
?>
