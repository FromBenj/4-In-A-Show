<?php
//
//session_start();
//
//require_once  '../php/gravityRules.php';
//
//if (!$data) {
//    http_response_code(400);
//    echo json_encode([
//        'success' => false,
//        'error' => 'Invalid JSON payload'
//    ], JSON_THROW_ON_ERROR);
//
//    exit;
//}
//
//try {
//    $row = $data['row'];
//    $col = $data['col'];
//    $playerId = getCurrentPlayerId();
//    $newPlayerId = getNextPlayerId();
//    $actualState = actualState();
//    $bgColor = $actualState['player' . $playerId]['bgColor'];
//    if (isMovePossible($col, $row)) {
//        updatePlayArea($playerId, $col, $row);
//        newPlayersPosition();
//        echo json_encode([
//            'success' => true,
//            "row" => $row,
//            "col" => $col,
//            "currentPlayerId" => $currentPlayerId,
//            "newPlayerId" => $newPlayerId,
//            "bgColor" => $bgColor,
//            "movePossible" => isMovePossible($col, $row),
//        ], JSON_THROW_ON_ERROR);
//    } else {
//        http_response_code(400);
//        echo json_encode([
//            'success' => false,
//            'error' => 'Move not possible at this position'
//        ], JSON_THROW_ON_ERROR);
//    }
//} catch (Throwable $e) {
//    http_response_code(400);
//    echo json_encode([
//        'success' => false,
//        'error' => $e->getMessage()
//    ], JSON_THROW_ON_ERROR);
//}
//
//exit;
//
