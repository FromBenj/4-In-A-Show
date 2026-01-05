<?php

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class addTokenController
{
    private Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function addTokens(): JsonResponse
    {
        if (!$this->request->isMethod('POST')) {
            return new JsonResponse(
                ['success' => false, 'error' => 'Method not allowed'],
                405
            );
        }
        $fetchContent = $this->request->getContent();
        $data = json_decode($fetchContent, true);
        if (!is_array($data)) {
            return new JsonResponse([
                'success' => false,
                'error' => 'Invalid JSON payload'
            ], 400);
        }
        $row = $data['row'];
        $col = $data['col'];
        $result = !isMovePossible($col, $row) ? "false" : "true";
        error_log("Checking move: col=$col, row=$row, result=$result");
        if (!isMovePossible($col, $row)) {
            return new JsonResponse([
                'success' => false,
                'error' => 'Move not possible at this position'
            ], 400);
        }
        newPlayersPosition();
        $previousPlayerId = getNextPlayerId();
        $newPlayerId = getCurrentPlayerId();
        $actualState = actualState();
        $previousBgColor = $actualState['player' . $previousPlayerId]['bgColor'];
        $newBgColor = $actualState['player' . $newPlayerId]['bgColor'];
        updatePlayArea($previousPlayerId, $row, $col);

        return new JsonResponse([
            'success' => true,
            'row' => $row,
            'col' => $col,
            'currentPlayerId' => $newPlayerId,
            'nextPlayerId' => $previousPlayerId,
            'currentBgColor' => $newBgColor,
            'nextBgColor' => $previousBgColor,
            'movePossible' => true,
        ], 200);
    }

    public function addPreviousTokens(): JsonResponse
    {
        $previousPlayerId = getCurrentPlayerId();
        $newPlayerId = getNextPlayerId();
        $actualState = actualState();
        $playArea = getPlayArea();
        $previousBgColor = $actualState['player' . $previousPlayerId]['bgColor'];
        $newBgColor = $actualState['player' . $newPlayerId]['bgColor'];
        if (!$previousPlayerId || !$newPlayerId || !$previousBgColor || !$newBgColor || !$playArea) {
            return new JsonResponse([
                'success' => false,
                'error' => 'Wrong PHP data',
            ], 400);
        }
        return new JsonResponse([
            'currentPlayerId' => $previousPlayerId,
            'nextPlayerId' => $newPlayerId,
            'playArea' => $playArea,
            'currentBgColor' => $newBgColor,
            'nextBgColor' => $previousBgColor,
            'movePossible' => true,
        ], 200);
    }

    public function sendWinnerData(): JsonResponse
    {
        $checkForWinner = checkForWinner();

        return new JsonResponse($checkForWinner,200);
    }
}

