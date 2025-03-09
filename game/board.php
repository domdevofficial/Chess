<?php
session_start();


$controlFile = '../control.txt';
$settings = [];
if (file_exists($controlFile)) {
    foreach (file($controlFile, FILE_IGNORE_NEW_LINES) as $line) {
        list($key, $value) = explode('=', $line, 2);
        $settings[$key] = $value;
    }
}

if (!empty($settings['maintenance']) && $settings['maintenance'] == '1') {
    die("The game is under maintenance. Please check back later.");
}


$user_ip = $_SERVER['REMOTE_ADDR'];
$banned_ips = explode(',', $settings['banned_ips'] ?? '');
if (in_array($user_ip, $banned_ips)) {
    die("You are banned from playing this game.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DomChess</title>
    <link rel="stylesheet" href="../assets/style.css">
    <script src="../assets/move.js" defer></script>
</head>
<body>
    <h2 class="title">♔ Welcome to DomChess! ♔</h2>
    <div class="board">
        <?php
        if (!isset($_SESSION['board'])) {
            $_SESSION['board'] = [
                ['♜', '♞', '♝', '♛', '♚', '♝', '♞', '♜'],
                ['♟', '♟', '♟', '♟', '♟', '♟', '♟', '♟'],
                ['', '', '', '', '', '', '', ''],
                ['', '', '', '', '', '', '', ''],
                ['', '', '', '', '', '', '', ''],
                ['', '', '', '', '', '', '', ''],
                ['♙', '♙', '♙', '♙', '♙', '♙', '♙', '♙'],
                ['♖', '♘', '♗', '♕', '♔', '♗', '♘', '♖']
            ];
        }
        $board = $_SESSION['board'];
        for ($row = 0; $row < 8; $row++) {
            for ($col = 0; $col < 8; $col++) {
                $color = ($row + $col) % 2 == 0 ? 'light' : 'dark';
                echo "<div class='square $color' data-pos='$row,$col'>{$board[$row][$col]}</div>";
            }
        }
        ?>
    </div>
</body>
</html>
