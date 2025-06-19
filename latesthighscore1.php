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

    <link rel="icon" href="favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    </head>
<body>

<?php include 'header.php'; ?>

<main>
  <article class="frees">
    <h1>Latest Highscores</h1>
  </article>

  <article class="highscores">
    <article class="scores">
      <p><strong>Top 1</strong><br>User: Anonymous<br>Highscore: 1250</p>
      <p><strong>Top 2</strong><br>User: Anonymous<br>Highscore: 900</p>
      <p><strong>Top 3</strong><br>User: Anonymous<br>Highscore: 850</p>
      <p><strong>Top 4</strong><br>User: Anonymous<br>Highscore: 704</p>
      <p><strong>Top 5</strong><br>User: Anonymous<br>Highscore: 600</p>
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