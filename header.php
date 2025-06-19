<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<header>
    <img src="img/gamelogo.png" alt="Gaming Hotel Logo" class="logo">

    <nav>
        <a href="homepagina.php">Home</a>
        <a href="#">Add friends</a>
        <a href="games.php">Games</a>
        <a href="highscore.php">Highscores</a>

        <?php if (isset($_SESSION['gebruikersnaam'])): ?>
            <a href="profile.php">Profile</a>
        <?php else: ?>
            <a href="inloggen.php">Login</a>
            <a href="register.php">Register</a>
        <?php endif; ?>
    </nav>
</header>
