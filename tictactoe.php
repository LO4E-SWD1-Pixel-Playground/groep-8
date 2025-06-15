<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="game website">
    <meta name="keywords" content="HTML, meta tags, voorbeeld, webontwikkeling">
    <meta name="author" content="yusuf">
    <link rel="stylesheet" href="style.css">
    
    <title>game website</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>

<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['gebruikersnaam'])) {
    header('Location: inloggen.php');
    exit;
}


$host = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "pixelplayground";

$conn = new mysqli($host, $db_user, $db_pass, $db_name);
if ($conn->connect_error) {
    die("Connectie mislukt: " . $conn->connect_error);
}

$gebruikersnaam = $_SESSION['gebruikersnaam'];

// Haal gebruiker_id op
$stmt = $conn->prepare("SELECT id FROM gebruikers WHERE gebruikersnaam = ?");
$stmt->bind_param("s", $gebruikersnaam);
$stmt->execute();
$stmt->bind_result($gebruiker_id);
$stmt->fetch();
$stmt->close();
$conn->close();

include 'header.php'; 
?>

<!-- JavaScript variabelen doorgeven -->
<script>
    const GEBRUIKER_ID = <?php echo $gebruiker_id; ?>;
    const GAME_ID = 4; // TicTacToe game ID
</script>
<script src="js/tictactoe1.js" defer></script>

<main class="tictactoepagina">
    <h1>TicTacToe</h1>
    <section class="mijnboard">
        <article class="vakje"></article>
        <article class="vakje"></article>
        <article class="vakje"></article>
        <article class="vakje"></article>
        <article class="vakje"></article>
        <article class="vakje"></article>
        <article class="vakje"></article>
        <article class="vakje"></article>
        <article class="vakje"></article>
    </section>
    <article id="messenger"></article>

    <article class="scoreboard">X: 0 | O: 0 | Gelijkspel: 0</article>

    <button id="volgende">Volgende Game</button>
    <button id="reset">Reset Alles</button>
</main>

<footer>
    <img src="img/gamelogo.png" alt="Gaming Hotel Logo" class="logo">
    <article class="socials">
        <article>Follow us:</article>
        <a class="fa fa-facebook"></a>
        <a class="fa fa-instagram"></a>
    </article>
</footer>

</body>
</html>