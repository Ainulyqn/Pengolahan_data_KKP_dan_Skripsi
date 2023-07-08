<?php
session_start();

// Periksa apakah pengguna telah login sebelumnya
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

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
if (isset($_POST['edit'])) {
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $judul = $_POST['judul'];
    $dosen_pembimbing = $_POST['dosen_pembimbing'];

    // Query untuk mengupdate data KKP
    $query = "UPDATE kkp SET nama='$nama', judul='$judul', dosen_pembimbing='$dosen_pembimbing' WHERE id=$id";

    // Eksekusi query
    if (mysqli_query($conn, $query)) {
        // Redirect ke halaman list_kkp.php setelah data berhasil diupdate
        header("Location: list_kkp.php");
        exit;
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

// Proses penghapusan data KKP
if (isset($_POST['delete'])) {
    $id = $_POST['id'];

    // Query untuk menghapus data KKP
    $query = "DELETE FROM kkp WHERE id=$id";

    // Eksekusi query
    if (mysqli_query($conn, $query)) {
        // Redirect ke halaman list_kkp.php setelah data berhasil dihapus
        header("Location: list_kkp.php");
        exit;
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

// Query untuk mendapatkan daftar data KKP yang telah disubmit
$query = "SELECT * FROM kkp";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html>

<head>
    <title>List KKP</title>
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .navbar-brand {
            display: flex;
            align-items: center;
        }

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
            <img src="../img/UPB.png" width="30" height="30" class="d-inline-block align-top" alt="Logo">
        </a>
        <div class="navbar-nav ml-auto">
            <a class="nav-link" href="../index.php">Keluar</a>
        </div>
    </nav>

    <div class="container mt-4">
        <h2>List KKP</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Nama</th>
                    <th>Judul</th>
                    <th>Dosen Pembimbing</th>
                    <th>Tanggal Upload</th>
                    <th>File</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $no . "</td>";
                    echo "<td>" . $row['nama'] . "</td>";
                    echo "<td>" . $row['judul'] . "</td>";
                    echo "<td>" . $row['dosen_pembimbing'] . "</td>";
                    echo "<td>" . $row['tanggal_upload'] . "</td>";
                    echo "<td><a href='" . $row['file'] . "'>Download</a></td>";
                    echo "<td>";
                    echo "<button type='button' class='btn btn-primary' data-toggle='modal' data-target='#editModal" . $row['id'] . "'>Edit</button>";
                    echo "<form method='post' class='d-inline-block'>";
                    echo "<input type='hidden' name='id' value='" . $row['id'] . "'>";
                    echo "<button type='submit' name='delete' class='btn btn-danger'>Hapus</button>";
                    echo "</form>";
                    echo "</td>";
                    echo "</tr>";
                    $no++;
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Modal Edit -->
    <?php
    mysqli_data_seek($result, 0); // Reset pointer hasil query

    while ($row = mysqli_fetch_assoc($result)) {
        $id = $row['id'];
        $nama = $row['nama'];
        $judul = $row['judul'];
        $dosen_pembimbing = $row['dosen_pembimbing'];
    ?>
        <div class="modal fade" id="editModal<?php echo $id; ?>" tabindex="-1" role="dialog" aria-labelledby="editModalLabel<?php echo $id; ?>" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel<?php echo $id; ?>">Edit KKP</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="post" action="list_kkp.php">
                            <input type="hidden" name="id" value="<?php echo $id; ?>">
                            <div class="form-group">
                                <label for="nama">Nama:</label>
                                <input type="text" name="nama" id="nama" class="form-control" value="<?php echo $nama; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="judul">Judul:</label>
                                <input type="text" name="judul" id="judul" class="form-control" value="<?php echo $judul; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="dosen_pembimbing">Dosen Pembimbing:</label>
                                <input type="text" name="dosen_pembimbing" id="dosen_pembimbing" class="form-control" value="<?php echo $dosen_pembimbing; ?>" required>
                            </div>
                            <button type="submit"
                            name="edit" class="btn btn-primary">Simpan</button>
                            </form>
</div>
</div>
</div>
</div>
<?php
 }
 ?>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>