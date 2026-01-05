<?php
require_once __DIR__ . '/playersState.php';
require_once __DIR__ . '/playAreaLogic.php';

function isMovePossible($col, $row): bool
{
    $rowsNumber = $_SESSION["rowsNumber"];
    $colsNumber = $_SESSION["colsNumber"];
    $playArea = getPlayArea();
    if (
        !in_array($row, range(0, $rowsNumber - 1), true) ||
        !in_array($col, range(0, $colsNumber - 1), true) ||
        $playArea[$row][$col] !== null) {

        return false;
    }
    $previousPlace = $playArea[$row - 1][$col];
    if ($row === 0 || ($row >= 1 && in_array($previousPlace, [1, 2], true))) {

        return true;
    }

    return false;
}
