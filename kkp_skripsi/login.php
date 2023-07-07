<?php
session_start();

require_once 'includes/db.php';

// Jika pengguna sudah login sebelumnya, langsung arahkan ke index.php
if (isset($_SESSION['username'])) {
    header("Location: index.php");
    exit;
}

$error = '';

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = "SELECT * FROM pengguna WHERE username = '$username' AND password = '$password'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        // Login berhasil, simpan username dalam session
        $_SESSION['username'] = $username;
        header("Location: index.php");
        exit;
    } else {
        $error = "Username atau password salah.";
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Halaman Login</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>

<body>
    <div class="container">
        <h2>Login</h2>
        <?php if ($error !== '') { ?>
            <div class="alert"><?php echo $error; ?></div>
        <?php } ?>
        <form method="post" action="">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" name="username" id="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" name="password" id="password" required>
            </div>
            <button type="submit" name="login">Login</button>
        </form>
    </div>
</body>

</html>
