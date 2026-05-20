<?php
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['ok' => false, 'error' => 'Pouze POST']);
    exit;
}

$input = file_get_contents('php://input');
if (!$input) {
    echo json_encode(['ok' => false, 'error' => 'Žádná data']);
    exit;
}

json_decode($input);
if (json_last_error() !== JSON_ERROR_NONE) {
    echo json_encode(['ok' => false, 'error' => 'Neplatný JSON: ' . json_last_error_msg()]);
    exit;
}

$file = __DIR__ . '/listiny_data.json';

if (file_put_contents($file, $input) !== false) {
    $size = round(strlen($input) / 1024);
    echo json_encode(['ok' => true, 'message' => "Data uložena ({$size} KB) — " . date('d.m.Y H:i:s')]);
} else {
    echo json_encode(['ok' => false, 'error' => 'Nepodařilo se zapsat soubor. Zkontrolujte oprávnění složky.']);
}
