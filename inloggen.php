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
    <link rel="icon" href="favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    
</head>
<body>
<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$host = "localhost";
$db_user = "root";      
$db_pass = "";          
$db_name = "pixelplayground";

$conn = new mysqli($host, $db_user, $db_pass, $db_name);
if ($conn->connect_error) {
    die("Connectie mislukt: " . $conn->connect_error);
}

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $gebruikersnaam = $_POST['username'] ?? '';
    $wachtwoord = $_POST['password'] ?? '';

    if ($gebruikersnaam && $wachtwoord) {
        $stmt = $conn->prepare("SELECT wachtwoord FROM gebruikers WHERE gebruikersnaam = ?");
        $stmt->bind_param("s", $gebruikersnaam);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows === 1) {
            $stmt->bind_result($hashed_wachtwoord);
            $stmt->fetch();

            if (password_verify($wachtwoord, $hashed_wachtwoord)) {
                $_SESSION['gebruikersnaam'] = $gebruikersnaam;
                header("Location: homepagina.php");
                exit;
            } else {
                $error = "Wachtwoord is onjuist.";
            }
        } else {
            $error = "Gebruiker niet gevonden.";
        }
        $stmt->close();
    } else {
        $error = "Vul zowel gebruikersnaam als wachtwoord in.";
    }
}

$conn->close();
?>
<?php include 'header.php'; ?>

<main>
<article class="login">

<?php if ($error): ?>
    <p style="color: red; font-weight: bold;"><?= htmlspecialchars($error) ?></p>
<?php endif; ?>

<form class="form" method="POST" action="inloggen.php">
    <label for="username">Gebruikersnaam:</label><br>
    <input type="text" id="username" name="username" required /><br>

    <label for="password">Wachtwoord:</label><br>
    <input type="password" id="password" name="password" required /><br>
    <a href="wachtwoordvergeten.php" class="forgot">Wachtwoord vergeten?</a><br>

    <button type="submit" class="mybutton">Inloggen</button>
</form>
</article>
</main>

<footer>
    <img src="img/gamelogo.png" alt="Gaming Hotel" class="logo">
    <article class="socials">
        <article>Follow us:</article>
        <a class="fa fa-facebook"></a>
        <a class="fa fa-instagram"></a>
    </article>
</footer>

</body>
</html>
