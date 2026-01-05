<?php

session_start();

//require_once __DIR__ . '/dataFixtures.php';

header('Content-Type: application/json');

$tokensFixtures = getFixturesValues();
echo json_encode($tokensFixtures, JSON_THROW_ON_ERROR);

exit;
