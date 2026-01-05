import {receiveWinner} from "./getWinner.js";
import {customTokenCursor} from "./game-animations.js";
import {animationAccessibility} from "./function-accessibility.js"

function addNewTokenFetch(col, row) {
    fetch('/api/play-area', {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify({
            row: row,
            col: col,
        })
    })
        .then(async response => {
            if (!response.ok) {
                throw new Error('Network response was not OK');
            }
            return response.json();
        })
        .then(data => {
            placeTokenColor(data);
            playersTokenAnimation(data);
            customTokenCursor(data);
            receiveWinner();
        })
        .catch(error => {
            console.error('Fetch failed:', error);
        });
}

export function initializeGame() {
    const tokenCursor = document.getElementById("token-cursor");
    tokenCursor ? tokenCursor.classList.add("d-none") : null;
    const result = animationAccessibility();
    if (result === null) return;
    fetch('/api/add-previous-tokens', {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
    })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not OK');
            }
            return response.json();
        })
        .then(data => {
            keepLastTokensColor(data);
            playersTokenAnimation(data);
            customTokenCursor(data);
            console.log(data)
        })
        .catch(error => {
            console.error('Fetch failed:', error);
        });
}


function placeTokenColor(data) {
    if (!data) {
        return;
    }
    if (typeof data['row'] === "undefined" || typeof data["col"] === "undefined") {
        keepLastTokensColor(data);
    }
    const tokenPlace = document.querySelector(`.token-place[data-row="${data['row']}"][data-col="${data['col']}"]`);
    if (data && tokenPlace && tokenPlace.classList.contains("bg-white")) {
        tokenPlace.setAttribute('data-player', data['currentPlayerId']);
        const tokenPlaceColor = data['nextBgColor'];
        tokenPlace.classList.remove("bg-white");
        tokenPlace.classList.add(tokenPlaceColor);
    }
}

// Makes errors
function keepLastTokensColor(data) {
    const playArea = data["playArea"];
    let tokenPlacesPlayed = document.querySelectorAll('[data-player]');
    if (tokenPlacesPlayed.length === 0) {
        return;
    }
    tokenPlacesPlayed.forEach((element) => {
        let row = element.dataset.row;
        let col = element.dataset.col;
        if ([1, 2].includes(playArea[parseInt(row)][parseInt(col)])) {
            let playerId =  playArea[parseInt(row)][parseInt(col)];
            if (playerId === 1) {
                element.classList.remove("bg-white");
                element.classList.add("main-blue");
            } else if (playerId === 2) {
                element.classList.remove("bg-white");
                element.classList.add("main-yellow");
            }
        }
    });
}

function playersTokenAnimation(data) {
    const currentPlayerId = data["currentPlayerId"];
    const nextPlayerId = data["nextPlayerId"];
    const tokenToShow = document.getElementById(`token-player${currentPlayerId}`);
    const tokenToHide = document.getElementById(`token-player${nextPlayerId}`);

    tokenToShow.classList.remove("light-color");
    tokenToHide.classList.add("light-color");
}

export function addNewToken() {
    const tokenPlaces = document.getElementsByClassName("token-place");
    for (let i = 0; i < tokenPlaces.length; i++) {
        tokenPlaces[i].addEventListener("click", async (e) => {
            const placeAvailability = e.target.dataset.player;
            if (placeAvailability && placeAvailability.length !== 0) {
                return;
            }
            const row = parseInt(e.target.dataset.row);
            const col = parseInt(e.target.dataset.col);
            const tokenCursor = document.getElementById("token-cursor");
            tokenCursor.classList.add("d-none");


            addNewTokenFetch(col, row);
        })
    }
}

