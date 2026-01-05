<?php

function checkForWinner()
{
    $maxP1Values = [];
    $maxP2Values = [];
    $methodValue = [
        get4Horizontal(),
        get4Vertical(),
    ];
    foreach ($methodValue as $functionResults) {
        if ($functionResults["getWinner"] === "yes") {
            $_SESSION['winner'] = $functionResults["winner"];
            addToWinnerHistory($functionResults["winner"]);

            return $functionResults;
        }
        if (isset($functionResults["maxPlayersData"])) {
            $maxP1Values[] = $functionResults["maxPlayersData"]["maxPlayer1"];
            $maxP2Values[] = $functionResults["maxPlayersData"]["maxPlayer2"];
        }
    }
    $maxP1Values = max($maxP1Values);
    $maxP2Values = max($maxP2Values);
    setPlayersMaxTokensWon($maxP1Values, 1);
    setPlayersMaxTokensWon($maxP2Values, 2);
    $maxPlayersData = [
        "maxPlayer1" => getPlayersMaxTokensWon(1),
        "maxPlayer2" => getPlayersMaxTokensWon(2),
    ];

    return [
        "maxPlayersData" => $maxPlayersData,
        "winner" => null,
        "getWinner" => "no",
        "type" => "horizontal"
    ];
}


function get4Horizontal(): array
{
    $playArea = $_SESSION['playArea'];
    if (!$playArea) {
        return [
            "getWinner" => "playArea error",
            "type" => "horizontal",
        ];
    }
    $maxPlayer1 = 0;
    $maxPlayer2 = 0;
    foreach ($playArea as $row => $cols) {
        $rowScore1 = 0;
        $rowScore2 = 0;
        foreach ($cols as $col => $value) {
            ;
            if ($value === 1) {
                $rowScore1++;
                $rowScore2 = 0;
            } elseif ($value === 2) {
                $rowScore2++;
                $rowScore1 = 0;
            } else {
                $rowScore1 = 0;
                $rowScore2 = 0;
            }
            $maxPlayer1 = max($rowScore1, $maxPlayer1);
            $maxPlayer2 = max($rowScore2, $maxPlayer2);
        }
    }
    $_SESSION['p1MaxTokensWin'] = $maxPlayer1;
    $_SESSION['p2MaxTokensWin'] = $maxPlayer2;
    if ($maxPlayer1 >= 4) {
        $winner = $_SESSION["player1"];
    } elseif ($maxPlayer2 >= 4) {
        $winner = $_SESSION["player2"];
    } else {
        $maxPlayersData = [
            "maxPlayer1" => $maxPlayer1,
            "maxPlayer2" => $maxPlayer2,
        ];

        return [
            "maxPlayersData" => $maxPlayersData,
            "winner" => null,
            "getWinner" => "no",
            "type" => "horizontal"
        ];
    }
    $_SESSION["winner"] = $winner;
    $_SESSION["winnersHistory"][] = $winner;

    return [
        "winner" => $winner,
        "getWinner" => "yes",
        "type" => "horizontal"
    ];
}

function get4Vertical(): mixed
{
    $playArea = $_SESSION['playArea'];
    if (!$playArea) {
        return [
            "getWinner" => "playArea error",
            "type" => "vertical",
        ];
    }
    $maxPlayer1 = 0;
    $maxPlayer2 = 0;
    {
        for ($col = 0; $col < $_SESSION["colsNumber"]; $col++) {
            $colScore1 = 0;
            $colScore2 = 0;
            for ($row = 0; $row < $_SESSION["rowsNumber"]; $row++) {
                if ($playArea[$row][$col] === 1) {
                    $colScore1++;
                    $colScore2 = 0;
                } elseif ($playArea[$row][$col] === 2) {
                    $colScore1 = 0;
                    $colScore2++;
                } else {
                    $colScore1 = 0;
                    $colScore2 = 0;
                }
                $maxPlayer1 = max($colScore1, $maxPlayer1);
                $maxPlayer2 = max($colScore2, $maxPlayer2);
            }
        }
        if ($maxPlayer1 >= 4) {
            $winner = $_SESSION["player1"];
        } elseif ($maxPlayer2 >= 4) {
            $winner = $_SESSION["player2"];
        } else {
            $maxPlayersData = [
                "maxPlayer1" => $maxPlayer1,
                "maxPlayer2" => $maxPlayer2,
            ];

            return [
                "maxPlayersData" => $maxPlayersData,
                "winner" => null,
                "getWinner" => "no",
                "type" => "vertical"
            ];
        }
        $_SESSION["winner"] = $winner;
        $_SESSION["winnersHistory"][] = $winner;

        return [
            "winner" => $winner,
            "getWinner" => "yes",
            "type" => "vertical"
        ];
    }
}

function getWinnerHistory()
{
    if (!$_SESSION['winnersHistory']) {
        $_SESSION['winnersHistory'] = [];

    }

    return $_SESSION['winnersHistory'];
}

function addToWinnerHistory($winner): void
{

    $_SESSION['winnersHistory'][] = $winner;
}
