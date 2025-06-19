<?php
$conn = new mysqli("localhost", "root", "", "pixelplayground");
if ($conn->connect_error) exit;

$input = json_decode(file_get_contents('php://input'), true);
if (!$input) exit;

$game_id = (int)($input['game_id'] ?? 0);
$gebruiker_id = (int)($input['gebruiker_id'] ?? 0);
$highscore = (int)($input['highscore'] ?? 0);

$sql = "SELECT highscore FROM highscores WHERE game_id = $game_id AND gebruiker_id = $gebruiker_id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $existing_score = $row['highscore'];
    
    if ($highscore > $existing_score) {
        $sql = "UPDATE highscores SET highscore = $highscore WHERE game_id = $game_id AND gebruiker_id = $gebruiker_id";
        $conn->query($sql);
    }
} else {
    $sql = "INSERT INTO highscores (game_id, gebruiker_id, highscore) VALUES ($game_id, $gebruiker_id, $highscore)";
    $conn->query($sql);
}

$conn->close();
?>