import {animationAccessibility} from "./function-accessibility.js";

export function adjustGameBoardStyle() {
    const result = animationAccessibility();
    if (result === null) return;
    const gameBoard = document.getElementById("game-board");
    const tokenPlace = document.getElementsByClassName("token-place");
    const computedStyle = window.getComputedStyle(gameBoard);
    const gameBoardWidth = computedStyle.width;
    const gameBoardHeight = computedStyle.height;
    const tokenPlaceSize = Math.min(parseFloat(gameBoardWidth) / 7, parseFloat(gameBoardHeight) / 6);
    for (let i = 0; i < tokenPlace.length; i++) {
        tokenPlace[i].style.width = tokenPlaceSize;
        tokenPlace[i].style.height = tokenPlaceSize;
    }

    return gameBoardWidth;
}

export function adjustPlayersContainer() {
    const result = animationAccessibility();
    if (result === null) return;
    const playersContainer = document.getElementById("players-container");
    playersContainer.style.width = adjustGameBoardStyle();
    // const movingDot = document.getElementById("moving-dot");
    const tokenPlayer1Container = document.getElementById("token-player1-container");
    const tokenPlayer1 = document.getElementById("token-player1");
    let computedStyle = window.getComputedStyle(tokenPlayer1);
    const tokenPlayer1MRight = parseFloat(computedStyle.marginRight);
    computedStyle = window.getComputedStyle(tokenPlayer1Container);
    const tokenPlayer1ContainerWidth = parseFloat(computedStyle.width);
    // const finalPosition = tokenPlayer1ContainerWidth - tokenPlayer1MRight;

    // movingDot.style.left = toString(finalPosition);
}

export function tokenCursorStyle(backgroundColor) {
    const tokenCursor = document.getElementById("token-cursor");
    const tokenPlaces = document.getElementsByClassName("token-place");
    if (tokenCursor && tokenPlaces) {
        const tokenPlace = tokenPlaces[0];
        const computTokenPlace = window.getComputedStyle(tokenPlace);
        let tokenCursorWidth = parseFloat(computTokenPlace.width);
        tokenCursorWidth = 90/100 * tokenCursorWidth;

        Object.assign(tokenCursor.style, {
            width: tokenCursorWidth.toString() + 'px',
            border: "solid thin black",
            borderRadius: "50%",
            aspectRatio: "1 / 1",
            position: "absolute",
        });
        console.log(backgroundColor)
        tokenCursor.classList.add(backgroundColor);
    }
}
