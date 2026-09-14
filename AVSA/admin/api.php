<?php
require_once dirname(__DIR__) . '/config/config.php';
header('Content-Type: application/json');

if (!isLoggedIn()) {
    http_response_code(401);
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}

$db = getDb();
$action = $_GET['action'] ?? '';

switch ($action) {
    case 'programs':
        echo json_encode($db->query('SELECT * FROM programs ORDER BY id DESC')->fetchAll());
        break;
    case 'projects':
        echo json_encode($db->query('SELECT * FROM projects ORDER BY id DESC')->fetchAll());
        break;
    case 'donations':
        echo json_encode($db->query('SELECT * FROM donations ORDER BY id DESC')->fetchAll());
        break;
    case 'messages':
        echo json_encode($db->query('SELECT * FROM contact_messages ORDER BY id DESC')->fetchAll());
        break;
    default:
        echo json_encode(['status' => 'ok']);
}
