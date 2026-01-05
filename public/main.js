import {getPhpFixtures} from "./fixtures/get-fixtures.js";
import {storePhpFixtures} from "./fixtures/fixtures-storage.js";
import {applyFixtures} from "./fixtures/fixtures-game.js";
import {adjustGameBoardStyle, adjustPlayersContainer} from "./js/adjust-game-style.js"
import {addNewToken, initializeGame} from "./js/token-management.js"
import {dotAnimation} from "./js/game-animations.js";
import {winnerAnimation} from "./js/winner-animation.js"
import {setLeftDotPosition, setRightDotPosition, removeCustomCursor} from "./js/game-animations.js";

const gameBoard = document.getElementById("game-board");


document.addEventListener("DOMContentLoaded", () => {
    adjustGameBoardStyle();
    adjustPlayersContainer();
    initializeGame();
    setLeftDotPosition();
    winnerAnimation();
    removeCustomCursor();
})
onresize = (event) => {
    adjustGameBoardStyle()
}
dotAnimation();
addNewToken();

// getPhpFixtures();
// storePhpFixtures();
// applyFixtures();

