const vakjes = document.getElementsByClassName('vakje');
const messenger = document.getElementById('messenger');
const resetKnop = document.getElementById('reset');
const volgendeKnop = document.getElementById('volgende');

let board = ["", "", "", "", "", "", "", "", ""];
let currentPlayer = "X";
let gameOver = false;

let scores = {
    X: 0,
    O: 0,
    draw: 0
};

function loadGameState() {
    const savedBoard = localStorage.getItem('tictactoe_board');
    const savedPlayer = localStorage.getItem('tictactoe_player');
    const savedScores = localStorage.getItem('tictactoe_scores');
    if (savedBoard) board = JSON.parse(savedBoard);
    if (savedPlayer) currentPlayer = savedPlayer;
    if (savedScores) scores = JSON.parse(savedScores);
}

function saveGameState() {
    localStorage.setItem('tictactoe_board', JSON.stringify(board));
    localStorage.setItem('tictactoe_player', currentPlayer);
    localStorage.setItem('tictactoe_scores', JSON.stringify(scores));
}

function clearGameState() {
    localStorage.removeItem('tictactoe_board');
    localStorage.removeItem('tictactoe_player');
    localStorage.removeItem('tictactoe_scores');
}

function checkWin() {
    const winCombinaties = [
        [0,1,2],[3,4,5],[6,7,8],
        [0,3,6],[1,4,7],[2,5,8],
        [0,4,8],[2,4,6]
    ];
    for (let combo of winCombinaties) {
        const [a,b,c] = combo;
        if (board[a] && board[a] === board[b] && board[a] === board[c]) {
            return board[a];
        }
    }
    return null;
}

function updateBoard() {
    for (let i = 0; i < vakjes.length; i++) {
        vakjes[i].textContent = board[i];
    }
}

function updateMessenger(text) {
    if (text) {
        messenger.style.display = "block";
        messenger.textContent = text;
    } else {
        messenger.style.display = "none";
    }
}

function updateScoresUI() {
    const scoreboard = document.querySelector('.scoreboard');
    scoreboard.textContent = `X: ${scores.X} | O: ${scores.O} | Gelijkspel: ${scores.draw}`;
}

function sendScoreToServer(resultaat) {
    // Controleer of GEBRUIKER_ID beschikbaar is
    if (typeof GEBRUIKER_ID === 'undefined') {
        console.error('GEBRUIKER_ID is niet gedefinieerd');
        return;
    }

    const scoreData = {
        game_id: GAME_ID,
        gebruiker_id: GEBRUIKER_ID,
        highscore: resultaat,
        timestamp: new Date().toISOString().slice(0, 19).replace('T', ' ')
    };

    console.log('Verstuur score:', scoreData); // Voor debugging

    fetch('savescore.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(scoreData)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            console.log('Score succesvol opgeslagen!');
        } else {
            console.error('Fout bij opslaan:', data.message);
        }
    })
    .catch(error => {
        console.error('Fetch error:', error);
    });
}

function handleClick(e) {
    if (gameOver) return;
    const index = Array.from(vakjes).indexOf(e.target);
    if (board[index] !== "") return;

    board[index] = currentPlayer;
    updateBoard();

    const winnaar = checkWin();
    if (winnaar) {
        updateMessenger(`Speler ${winnaar} wint!`);
        scores[winnaar]++;
        gameOver = true;
        saveGameState();
        updateScoresUI();
        
        // Stuur totale winst van winnaar naar server
        sendScoreToServer(scores[winnaar]);
        return;
    }

    if (!board.includes("")) {
        updateMessenger(`Gelijkspel!`);
        scores.draw++;
        gameOver = true;
        saveGameState();
        updateScoresUI();
        
        // Bij gelijkspel kun je ook de draw score versturen
        // sendScoreToServer(scores.draw);
        return;
    }

    currentPlayer = currentPlayer === "X" ? "O" : "X";
    saveGameState();
}

function resetGame() {
    board = ["", "", "", "", "", "", "", "", ""];
    currentPlayer = "X";
    gameOver = false;
    updateMessenger(null);
    updateBoard();
    
    // Reset alle scores
    scores = { X: 0, O: 0, draw: 0 };
    clearGameState();
    localStorage.setItem('tictactoe_scores', JSON.stringify(scores));
    updateScoresUI();
}

function volgendeGame() {
    board = ["", "", "", "", "", "", "", "", ""];
    currentPlayer = "X";
    gameOver = false;
    updateMessenger(null);
    updateBoard();
    saveGameState();
}

// Event listeners
for (let vakje of vakjes) {
    vakje.addEventListener('click', handleClick);
}

resetKnop.addEventListener('click', resetGame);
volgendeKnop.addEventListener('click', volgendeGame);

// Initialisatie
loadGameState();
updateBoard();
updateMessenger(null);
updateScoresUI();