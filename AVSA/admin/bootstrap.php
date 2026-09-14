<?php
require_once dirname(__DIR__) . '/config/config.php';

$db = getDb();
$exists = $db->query("SELECT COUNT(*) AS total FROM users")->fetch()['total'];
if ((int)$exists === 0) {
    $stmt = $db->prepare('INSERT INTO users (full_name, email, password_hash, role_id, status) VALUES (:full_name, :email, :password_hash, :role_id, :status)');
    $role = $db->query("SELECT id FROM roles WHERE name = 'Super Admin' LIMIT 1")->fetch();
    $stmt->execute([
        ':full_name' => 'AVSA Administrator',
        ':email' => 'admin@avsa.org',
        ':password_hash' => password_hash('admin123', PASSWORD_DEFAULT),
        ':role_id' => $role['id'] ?? 1,
        ':status' => 'active',
    ]);
}

echo "Admin bootstrap completed. Default login: admin@avsa.org / admin123";
