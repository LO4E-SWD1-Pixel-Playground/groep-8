<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content="game website" />
    <meta name="keywords" content="HTML, meta tags, voorbeeld, webontwikkeling" />
    <meta name="author" content="yusuf" />
    <link rel="stylesheet" href="style.css" />
    <script src="js/change.js" defer></script>

    <title>game website</title>

    <link rel="icon" href="favicon.ico" type="image/x-icon" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
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
$error = "";
$success = "";

$getUserData = "SELECT gebruikersnaam, wachtwoord FROM gebruikers WHERE gebruikersnaam = '$gebruikersnaam';";
$userDataResult = $conn->query($getUserData)->fetch_array(MYSQLI_BOTH);
$db_gebruikersnaam = $userDataResult['gebruikersnaam'];
$db_wachtwoord = $userDataResult['wachtwoord'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['change_username'])) {
        $nieuwe_naam = trim($_POST['nieuwe_naam']);
        if ($nieuwe_naam === '') {
            $error = "Nieuwe gebruikersnaam mag niet leeg zijn.";
        } else {
            $checkUsername = "SELECT COUNT(*) as count FROM gebruikers WHERE gebruikersnaam = '$nieuwe_naam';";
            $checkResult = $conn->query($checkUsername)->fetch_array(MYSQLI_BOTH);
            
            if ($checkResult['count'] > 0) {
                $error = "Deze gebruikersnaam is al in gebruik.";
            } else {
                $updateUsername = "UPDATE gebruikers SET gebruikersnaam = '$nieuwe_naam' WHERE gebruikersnaam = '$gebruikersnaam';";
                if ($conn->query($updateUsername)) {
                    $_SESSION['gebruikersnaam'] = $nieuwe_naam;
                    $success = "Gebruikersnaam succesvol gewijzigd!";
                    $db_gebruikersnaam = $nieuwe_naam;
                    $gebruikersnaam = $nieuwe_naam;
                } else {
                    $error = "Er is iets misgegaan bij het wijzigen van de gebruikersnaam.";
                }
            }
        }
    }

    if (isset($_POST['change_password'])) {
        $nieuw_wachtwoord = $_POST['nieuw_wachtwoord'] ?? '';
        $herhaal_wachtwoord = $_POST['herhaal_wachtwoord'] ?? '';

        if ($nieuw_wachtwoord === '' || $herhaal_wachtwoord === '') {
            $error = "Vul beide wachtwoordvelden in.";
        } elseif ($nieuw_wachtwoord !== $herhaal_wachtwoord) {
            $error = "Wachtwoorden komen niet overeen.";
        } else {
            $hashed = password_hash($nieuw_wachtwoord, PASSWORD_DEFAULT);
            $updatePassword = "UPDATE gebruikers SET wachtwoord = '$hashed' WHERE gebruikersnaam = '$gebruikersnaam';";
            if ($conn->query($updatePassword)) {
                $success = "Wachtwoord succesvol gewijzigd!";
            } else {
                $error = "Er is iets misgegaan bij het wijzigen van het wachtwoord.";
            }
        }
    }
}

$getUserID = "SELECT id FROM gebruikers WHERE gebruikersnaam = '$gebruikersnaam';";
$userIDResult = $conn->query($getUserID)->fetch_array(MYSQLI_BOTH);
$userID = $userIDResult['id'];

$hoogsteScore = "SELECT MAX(highscore) AS `hoogsteScore` FROM `highscores` WHERE `gebruiker_id` = $userID AND `game_id` = 4;";
$hoogsteScoreResult = $conn->query($hoogsteScore)->fetch_array(MYSQLI_BOTH);

if ($hoogsteScoreResult['hoogsteScore'] == ""){
    $hoogsteScoreResult['hoogsteScore'] = '0';
}

$conn->close();
?>
<?php include 'header.php'; ?>

<main class="profiles">
    <article class="account">
        <h1>Account Info</h1>

        <?php if ($error): ?>
            <p class="error-message"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>
        <?php if ($success): ?>
            <p class="success-message"><?php echo htmlspecialchars($success); ?></p>
        <?php endif; ?>

        <article class="acinfo">
            <article class="row zikker">
                <p class="label">Username: <?php echo htmlspecialchars($db_gebruikersnaam); ?></p>
                <button class="nonder">Change</button>
                <form class="zolder" style="display:none;" method="post">
                    <input type="text" name="nieuwe_naam" placeholder="Nieuwe gebruikersnaam" required />
                    <button type="submit" name="change_username">Opslaan</button>
                    <button type="button" class="bonder">Annuleren</button>
                </form>
            </article>

            <article class="row zikker">
                <p class="label">Password: *********</p>
                <button class="nonder">Change</button>
                <form class="zolder" style="display:none;" method="post">
                    <input type="password" name="nieuw_wachtwoord" placeholder="Nieuw wachtwoord" required />
                    <input type="password" name="herhaal_wachtwoord" placeholder="Herhaal wachtwoord" required />
                    <button type="submit" name="change_password">Opslaan</button>
                    <button type="button" class="bonder">Annuleren</button>
                </form>
            </article>

            <a href="logout.php" class="logout">Uitloggen</a>
        </article>
    </article>

    <article class="friends1">
        <h2>Friends list</h2>
        <article class="friends2">
            <article class="friend">kopper</article>
            <article class="friend">frekers</article>
        </article>
    </article>

    <section class="badger">
        <h2>Your Badges</h2>
        <article class="badged">
            <article class="badge">
                <article class="checkmark">✓</article>
                <article class="badgerinfo">
                    <h3>Joined</h3>
                    <p>Thanks for playing!</p>
                    <article class="detailer">
                        <p>Rarity: hard (17,2%)</p>
                        <p>Unlocked: yesterday</p>
                    </article>
                </article>
            </article>
        </article>
    </section>

    
    
<article class="highscores1">
    <h2>Your Highscores</h2>
    <article class="highscores2">
        <article class="highscore3">
            <img src="img/download.png" alt="Soccer Random Game" class="game-preview" />
            <p>Your Highscore: <?php echo $hoogsteScoreResult['hoogsteScore']; ?> wins</p>
        </article>
    </article>
</article>
</main>

<footer>
    <img src="img/gamelogo.png" alt="Gaming Hotel Logo" class="logo" />
    <article class="socials">
        <article>Follow us:</article>
        <a class="fa fa-facebook"></a>
        <a class="fa fa-instagram"></a>
    </article>
</footer>