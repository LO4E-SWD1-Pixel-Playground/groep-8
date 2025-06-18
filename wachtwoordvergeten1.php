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

if (!isset($_SESSION['reset_gebruiker'])) {
    header("Location: wachtwoordvergeten.php");
    exit;
}

$error = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nieuwWachtwoord = $_POST["password"] ?? "";

    if (trim($nieuwWachtwoord) === "") {
        $error = "Wachtwoord mag niet leeg zijn.";
    } else {
        $hash = password_hash($nieuwWachtwoord, PASSWORD_DEFAULT);

        $conn = new mysqli("localhost", "root", "", "pixelplayground");
        if ($conn->connect_error) {
            die("Connectie mislukt: " . $conn->connect_error);
        }

        $stmt = $conn->prepare("UPDATE gebruikers SET wachtwoord = ? WHERE gebruikersnaam = ?");
        $stmt->bind_param("ss", $hash, $_SESSION['reset_gebruiker']);
        if ($stmt->execute()) {
            $success = "Wachtwoord succesvol gewijzigd.";
            unset($_SESSION['reset_gebruiker']);
        } else {
            $error = "Er is iets fout gegaan.";
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
    <?php if ($success): ?>
        <p style="color:green;"><?php echo htmlspecialchars($success); ?></p>
    <?php endif; ?>

    <form class="form" method="POST">
        <label for="password">Nieuw wachtwoord:</label><br>
        <input type="password" id="password" name="password" required /><br>
        <button type="submit" class="mybutton">Indienen</button>
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
