<?php
session_start();
if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    header("Location: index.php");
    exit;
}

$controlFile = '../control.txt';
$settings = [];
if (file_exists($controlFile)) {
    foreach (file($controlFile, FILE_IGNORE_NEW_LINES) as $line) {
        list($key, $value) = explode('=', $line, 2);
        $settings[$key] = $value;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $settings['maintenance'] = isset($_POST['maintenance']) ? '1' : '0';
    $settings['banned_ips'] = implode(',', array_filter(array_map('trim', explode("
", $_POST['banned_ips']))));

    file_put_contents($controlFile, "maintenance={$settings['maintenance']}
banned_ips={$settings['banned_ips']}
");
    echo "Settings saved!";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="../assets/admin.css">
</head>
<body>
    <h2>Admin Panel</h2>
    <form method="post">
        <label><input type="checkbox" name="maintenance" <?= $settings['maintenance'] == '1' ? 'checked' : '' ?>> Enable Maintenance Mode</label>
        <br>
        <label>Banned IPs (one per line):</label><br>
        <textarea name="banned_ips" rows="5" cols="30"><?= str_replace(',', "
", $settings['banned_ips']) ?></textarea>
        <br>
        <button type="submit">Save Settings</button>
    </form>
    <br>
    <a href="logout.php">Logout</a>
</body>
</html>
