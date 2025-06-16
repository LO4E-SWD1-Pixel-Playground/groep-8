document.addEventListener('DOMContentLoaded', function () {
    const gameImage = document.querySelector('.heya');

    if (gameImage) {
        gameImage.addEventListener('click', function () {
            fetch('checklogin.php')
                .then(response => response.json())
                .then(data => {
                    if (data.logged_in) {
                        window.location.href = 'tictactoe.php'; 
                    } else {
                        alert('Je moet inloggen om deze game te spelen.');
                    }
                });
        });
    }
});



