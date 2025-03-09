/*
 * Copyright 2025 DomDev
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at:
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */
 
<?php
session_start();
if (!isset($_SESSION['board'])) {
    die("Game not initialized.");
}

$board = $_SESSION['board'];
$ai_moves = [];


for ($row = 0; $row < 8; $row++) {
    for ($col = 0; $col < 8; $col++) {
        if (in_array($board[$row][$col], ['♜', '♞', '♝', '♛', '♚', '♝', '♞', '♜', '♟'])) {
            for ($r = max(0, $row - 1); $r <= min(7, $row + 1); $r++) {
                for ($c = max(0, $col - 1); $c <= min(7, $col + 1); $c++) {
                    if ($board[$r][$c] == '') {
                        $ai_moves[] = [$row, $col, $r, $c];
                    }
                }
            }
        }
    }
}


if (!empty($ai_moves)) {
    $move = $ai_moves[array_rand($ai_moves)];
    list($fromRow, $fromCol, $toRow, $toCol) = $move;
    $board[$toRow][$toCol] = $board[$fromRow][$fromCol];
    $board[$fromRow][$fromCol] = '';
}


$_SESSION['board'] = $board;
echo json_encode($board);
