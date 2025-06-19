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
session_start();
$conn = new mysqli("localhost", "root", "", "pixelplayground");
if ($conn->connect_error) {
    die("Connectie mislukt: " . $conn->connect_error);
}

$error = "";

if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($username != "" && $password != "") {
        $sql = "SELECT * FROM gebruikers WHERE gebruikersnaam = '$username'";
        $result = $conn->query($sql);

        if ($result && $result->num_rows == 1) {
            $user = $result->fetch_assoc();

            if (password_verify($password, $user['wachtwoord'])) {
                $_SESSION['account'] = $user['id'];
                $_SESSION['gebruikersnaam'] = $user['gebruikersnaam'];
                header("Location: index.php");
                exit;
            } else {
                $error = "Gebruikersnaam of wachtwoord is onjuist.";
            }
        }
    } else {
        $error = "Vul alle velden in.";
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
