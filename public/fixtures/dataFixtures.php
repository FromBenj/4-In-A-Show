<?php

function setDataFixtures(): void
{
    $_SESSION['rowsNumber'] = 6;
    $_SESSION['colsNumber'] = 7;
    $_SESSION['PlayerTokensNumber'] = 21;
    $_SESSION['playerTokens1'] = [];
    $_SESSION['playerTokens2'] = [];
    $_SESSION['player1Name'] = 'Ben';
    $_SESSION['player2Name'] = 'Betty';
    $_SESSION['playersName'] = [
        'player1Name' => 'Ben',
        'player2Name' => 'Betty',
    ];
    $_SESSION['currentPlayerId'] = 2;
    $_SESSION['nextPlayerId'] = 1;
    $_SESSION['playArea'] = [
        1 => [
            0 => 1,
            1 => null,
            2 => null,
            3 => null,
            4 => null,
            5 => null,
        ],
        2 => [
            0 => 2,
            1 => null,
            2 => null,
            3 => null,
            4 => null,
            5 => null,
        ],
        3 => [
            0 => 1,
            1 => null,
            2 => null,
            3 => null,
            4 => null,
            5 => null,
        ],
        4 => [
            0 => 2,
            1 => null,
            2 => null,
            3 => null,
            4 => null,
            5 => null,
        ],
        5 => [
            0 => 1,
            1 => null,
            2 => null,
            3 => null,
            4 => null,
            5 => null,
        ],
        6 => [
            0 => 2,
            1 => null,
            2 => null,
            3 => null,
            4 => null,
            5 => null,
        ],
        7 => [
            0 => 1,
            1 => null,
            2 => null,
            3 => null,
            4 => null,
            5 => null,
        ]
    ];
}
setDataFixtures();

function getFixturesValues(): array
{
    $rowsNumber = $_SESSION['rowsNumber'];
    $colsNumber = $_SESSION['colsNumber'];
    $PlayerTokensNumber = $_SESSION['PlayerTokensNumber'];
    $PlayerTokens1 = $_SESSION['layerTokens1'];
    $PlayerTokens2 = $_SESSION['playerTokens2'];
    $player1Name = $_SESSION['Player1Name'];
    $player2Name = $_SESSION['Player2Name'];
    $playersName = $_SESSION['playersName'];
    $currentPlayerId = $_SESSION['currentPlayerId'];
    $nextPlayerId = $_SESSION['nextPlayerId'];
    $playArea = $_SESSION['playArea'];

    return [
        "rowsNumber" => $rowsNumber,
        "colsNumber" => $colsNumber,
        "PlayerTokensNumber" => $PlayerTokensNumber,
        "playerTokens1" => $PlayerTokens1,
        "playerTokens2" => $PlayerTokens2,
        "player1Name" => $player1Name,
        "player2Name" => $player2Name,
        "playersName" => $playersName,
        "currentPlayerId" => $currentPlayerId,
        "nextPlayerId" => $nextPlayerId,
        "playArea" => $playArea,
    ];
}

function tokensFixturesToSend(): array
{
    $data = getFixturesValues();
    $tokensFixtures = [];

    if ($data["playArea"]) {
        $_SESSION['currentPlayerId'] = 1;
        foreach ($data["playArea"] as $col => $rows) {
            foreach ($rows as $row => $value) {
                if ($value) {
                    $currentPlayerId = $value === 1 ? 1 : 2;
                    $newPlayerId = $currentPlayerId === 1 ? 2 : 1;
                    $tokensFixtures[] = [
                        "col" => $col,
                        "row" => $row,
                        "currentPlayerId" => $currentPlayerId,
                        "newPlayerId" => $newPlayerId,
                        "movePossible" => true,
                    ];
                }
            }
        }
    }

    return $tokensFixtures;
}

