<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="game website">
    <meta name="keywords" content="HTML, meta tags, voorbeeld, webontwikkeling">
    <meta name="author" content="Yusuf">
    <link rel="stylesheet" href="style.css">
    <script src="js/conformatie.js" defer></script>
    
    <title>game website</title>

    <link rel="icon" href="favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>

<?php include 'header.php'; ?>

<main>
<article class="login">
  <form class="form" method="POST" action="register.php">
  <label for="username">Gebruikersnaam:</label><br>
  <input type="text" id="username" name="username" required /><br>

  <label for="password">Wachtwoord:</label><br>
  <input type="password" id="password" name="password" required /><br>

  <label for="confirm_password">Bevestig wachtwoord:</label><br>
  <input type="password" id="confirm_password" name="confirm_password" required /><br>

  <button type="submit" class="mybutton">Register</button>
</form>
</article>
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

<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $host = "localhost";
    $dbname = "pixelplayground";
    $username = "root";
    $password = "";

    $conn = new mysqli($host, $username, $password, $dbname);

    $gebruikersnaam = $_POST['username'];
    $wachtwoord = $_POST['password'];

    $hashed_wachtwoord = password_hash($wachtwoord, PASSWORD_DEFAULT);

    $sql = "INSERT INTO gebruikers (gebruikersnaam, wachtwoord) VALUES ('$gebruikersnaam', '$hashed_wachtwoord')";
    
    $conn->query($sql);
    $conn->close();

    header("Location: inloggen.php");
    exit;
}

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>