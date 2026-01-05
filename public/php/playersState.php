<?php

function dataInitialization(): void
{
    $_SESSION['rowsNumber'] = 6;
    $_SESSION['colsNumber'] = 7;
    $_SESSION['PlayerTokensNumber'] = 21;
    $_SESSION['TokensNbrToWin'] = 4;
    $_SESSION['playArea'] = getPlayArea();
    $_SESSION['winnersHistory'] = getWinnerHistory();
    $_SESSION['winner'] = null;
}

//$_SESSION['PlayerTokens1'] = [];
//$_SESSION['PlayerTokens2'] = [];

function savePlayersName(): array
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $player1Name = !empty($_POST['player_1']) ? $_POST['player_1'] : 'Player 1';
        $player2Name = !empty($_POST['player_2']) ? $_POST['player_2'] : 'Player 2';
    } else {
        $player1Name = 'Player 1';
        $player2Name = 'Player 2';
    }

    return [
        'player1Name' => $player1Name,
        'player2Name' => $player2Name,
    ];
}

function getCurrentPlayerId(): int
{
    if (!isset($_SESSION['currentPlayerId']) || !in_array($_SESSION['currentPlayerId'], [1, 2], true)) {
        $_SESSION['currentPlayerId'] = 1;
    }

    return $_SESSION['currentPlayerId'];
}

function getNextPlayerId(): ?int
{

    return getCurrentPlayerId() === 1 ? 2 : 1;
}

function newPlayersPosition(): void
{
    $currentPlayerId = getCurrentPlayerId();
    $_SESSION['currentPlayerId'] = $currentPlayerId === 1 ? 2 : 1;
}

function actualState(): array
{
    $playersName = savePlayersName();
    $player1 = [
        "id" => 1,
        "name" => $playersName["player1Name"],
        "bgColor" => "main-blue",
    ];
    $player1["p1MaxTokensWon"] = getPlayersMaxTokensWon($player1["id"]);
    $_SESSION["player1"] = $player1;

    $player2 = [
        "id" => 2,
        "name" => $playersName["player2Name"],
        "bgColor" => "main-yellow",
    ];
    $player2["p2MaxTokensWon"] = getPlayersMaxTokensWon($player2["id"]);
    $_SESSION["player2"] = $player2;

    return [
        "player1" => $player1,
        "player2" => $player2,
    ];
}
