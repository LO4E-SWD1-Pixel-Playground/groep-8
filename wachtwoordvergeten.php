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
    <link rel="icon" href="favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>game website</title>
</head>
<body>
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $gebruikersnaam = trim($_POST["username"]);

    if ($gebruikersnaam === "") {
        $error = "Vul een gebruikersnaam in.";
    } else {
        $conn = new mysqli("localhost", "root", "", "pixelplayground");
        if ($conn->connect_error) {
            die("Connectie mislukt: " . $conn->connect_error);
        }

        $stmt = $conn->prepare("SELECT gebruikersnaam FROM gebruikers WHERE gebruikersnaam = ?");
        $stmt->bind_param("s", $gebruikersnaam);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows === 1) {
            $_SESSION['reset_gebruiker'] = $gebruikersnaam;
            header("Location: wachtwoordvergeten1.php");
            exit;
        } else {
            $error = "Gebruikersnaam bestaat niet.";
        }

        $stmt->close();
        $conn->close();
    }
}
?>
<?php include 'header.php'; ?>

<main>
<article class="login">
    <?php if ($error): ?>
        <p style="color:red;"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>

    <form class="form" method="POST">
        <label for="username">Gebruikersnaam:</label><br>
        <input type="text" id="username" name="username" required /><br>
        <button type="submit" class="mybutton">Verder</button>
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
