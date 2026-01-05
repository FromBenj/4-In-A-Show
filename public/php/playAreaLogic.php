<?php
require_once __DIR__ . '/playersState.php';
require_once __DIR__ . '/gravityRules.php';

function getPlayArea(): array
{
    if (!$_SESSION['playArea']) {
        $_SESSION['playArea'] = [];
        for ($row = 0; $row < $_SESSION['rowsNumber']; $row++) {
            for ($col = 0; $col < $_SESSION['colsNumber'] ; $col++) {
                $_SESSION['playArea'][$row][$col] = null;
            }
        }
    }

    return $_SESSION['playArea'];
}

function updatePlayArea($playerId, $row, $col): void
{
    if (is_null($_SESSION['playArea'][$col][$row]) &&
        in_array($playerId, [1, 2], true) &&
        in_array($row, range(0, $_SESSION['rowsNumber'] - 1), true) &&
        in_array($col, range(0, $_SESSION['colsNumber'] - 1), true)
    ) {
        $_SESSION['playArea'][$row][$col] = $playerId;
    }
}

function getPlayersMaxTokensWon($playerId): int
{
    $sessionVariableName = "p" . $playerId . "MaxTokensWon";
    if (!$_SESSION[$sessionVariableName]) {
        $_SESSION[$sessionVariableName] = 0;
    }

    return $_SESSION[$sessionVariableName];
}

function setPlayersMaxTokensWon($maxTokens, $playerId): void
{
    $currentMaxTokens = getPlayersMaxTokensWon($playerId);
    if (
        is_int($maxTokens) && $maxTokens > 0
        && $maxTokens > $currentMaxTokens) {
        $sessionVariableName = "p" . $playerId . "MaxTokensWon";
        $_SESSION[$sessionVariableName] = $maxTokens;
    }
}





