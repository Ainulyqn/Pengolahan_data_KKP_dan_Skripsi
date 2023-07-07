<?php
// Informasi login database
$host = 'localhost';  // Nama host database (misalnya, localhost)
$username = 'root';  // Nama pengguna database
$password = '';  // Kata sandi pengguna database
$database = 'kkp-skripsi';  // Nama database yang ingin Anda akses

// Koneksi ke database
$conn = mysqli_connect($host, $username, $password, $database);

// Periksa koneksi
if (mysqli_connect_errno()) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}
?>
