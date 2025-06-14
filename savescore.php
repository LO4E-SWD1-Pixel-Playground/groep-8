<?php
$conn = new mysqli("localhost", "root", "", "pixelplayground");
if ($conn->connect_error) exit;

$input = json_decode(file_get_contents('php://input'), true);
if (!$input) exit;

$game_id = (int)($input['game_id'] ?? 0);
$gebruiker_id = (int)($input['gebruiker_id'] ?? 0);
$highscore = (int)($input['highscore'] ?? 0);


$stmt = $conn->prepare("SELECT highscore FROM highscores WHERE game_id = ? AND gebruiker_id = ?");
$stmt->bind_param("ii", $game_id, $gebruiker_id);
$stmt->execute();
$stmt->bind_result($existing_score);
$stmt->fetch();
$stmt->close();

if ($existing_score === null) {
    $stmt = $conn->prepare("INSERT INTO highscores (game_id, gebruiker_id, highscore) VALUES (?, ?, ?)");
    $stmt->bind_param("iii", $game_id, $gebruiker_id, $highscore);
    $stmt->execute();
    $stmt->close();
} else if ($highscore > $existing_score) {
    $stmt = $conn->prepare("UPDATE highscores SET highscore = ? WHERE game_id = ? AND gebruiker_id = ?");
    $stmt->bind_param("iii", $highscore, $game_id, $gebruiker_id);
    $stmt->execute();
    $stmt->close();
}


$conn->close();
