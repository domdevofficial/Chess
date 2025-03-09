<?php
session_start();
$admin_user = "admin";
$admin_pass = "admin"; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_POST['username'] === $admin_user && $_POST['password'] === $admin_pass) {
        $_SESSION['admin'] = true;
        header("Location: dashboard.php");
        exit;
    } else {
        $error = "Invalid credentials!";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" href="../assets/admin.css">
</head>
<body>
    <h2>🔒 Admin Login</h2>
    <form method="post">
        <input type="text" name="username" placeholder="Username" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <button type="submit">Login</button>
    </form>
    <?= isset($error) ? "<p style='color:red;'>$error</p>" : "" ?>
</body>
</html>
