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
    <script src="js/script.js" defer></script>

    <title>game website</title>

    <link rel="icon" href="favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    </head>
<body>
<?php include 'header.php'; ?>

<main>
    <article class="slideshowgames">
        <h1 class="vanders">Welkom!</h1>
        <p class="zonders">Speel leuke games, daag je vrienden uit en verover de hoogste highscore!</p>
        <img class="slide" src="img/unnamed.png" alt="slide 1">
        <img class="slide" src="img/download.png" alt="slide 2">
    </article>
    <article class="looters">
        <h2>Latest Highscores</h2>

        <article class="kanders">
            <p><strong>galgje</strong><br>
            User: Anonymous<br>
            Highscore: 1250</p>
        </article>

        <article class="kanders">
            <p><strong>tic tac toe</strong><br>
            User: Anonymous<br>
            Highscore: 3 wins</p>
        </article>
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
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>