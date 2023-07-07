<?php
// Koneksi ke database
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'kkp-skripsi';
$conn = mysqli_connect($host, $username, $password, $database);

// Periksa koneksi
if (mysqli_connect_errno()) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

// Cek apakah form telah disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari form
    $username = isset($_POST['username']) ? $_POST['username'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $nama = isset($_POST['nama']) ? $_POST['nama'] : '';

    // Cek apakah username sudah digunakan
    $query = "SELECT * FROM pengguna WHERE username='$username'";
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) > 0) {
        $pesanError = "Username sudah digunakan. Silakan pilih username lain.";
    } else {
        // Insert data ke database
        $query = "INSERT INTO pengguna (username, password, nama) VALUES ('$username', '$password', '$nama')";
        if (mysqli_query($conn, $query)) {
            echo "Pendaftaran berhasil.";
            // Redirect ke halaman login
            header("Location: login.php");
            exit;
        } else {
            $pesanError = "Gagal mendaftar: " . mysqli_error($conn);
        }
    }
}

// Tutup koneksi
mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Pendaftaran Pengguna</title>
    <link rel="stylesheet" type="text/css" href="css/stylereg.css">
</head>
<body>
    <div class="container">
        <h2>Pendaftaran Pengguna</h2>
        <!-- Tampilkan pesan error jika ada -->
        <?php if (!empty($pesanError)) { ?>
            <div class="error"><?php echo $pesanError; ?></div>
        <?php } ?>
        <form method="POST" action="register.php">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" name="username" id="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" required>
            </div>
            <div class="form-group">
                <label for="nama">Nama</label>
                <input type="text" name="nama" id="nama" required>
            </div>
            <button type="submit">Daftar</button>
        </form>
        <p>Sudah memiliki akun? <a href="login.php">Masuk</a></p>
    </div>
</body>
</html>
