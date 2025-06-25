<?php
session_start();
include 'config/db.php';

if (isset($_SESSION['login'])) {
    header("Location: index.php");
    exit;
}

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $q = mysqli_query($conn, "SELECT * FROM admin WHERE username='$username' AND password='$password'");
    if (mysqli_num_rows($q) > 0) {
        $_SESSION['login'] = true;
        $_SESSION['username'] = $username;
        header("Location: index.php");
        exit;
    } else {
        $error = "Username atau password salah!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login MCU Klinik</title>
    <style>
        body { font-family: Arial; display: flex; justify-content: center; align-items: center; height: 100vh; background: #f0f0f0; }
        .login-box { background: white; padding: 20px; border-radius: 10px; box-shadow: 0 0 10px #aaa; width: 300px; }
        input { width: 100%; padding: 10px; margin: 8px 0; }
        button { width: 100%; padding: 10px; background: teal; color: white; border: none; }
    </style>
</head>
<body>
    <div class="login-box">
        <h3>Login MCU Klinik</h3>
        <form method="post">
            <input type="text" name="username" placeholder="Username" required />
            <input type="password" name="password" placeholder="Password" required />
            <button type="submit" name="login">Masuk</button>
        </form>
        <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
    </div>
</body>
</html>
