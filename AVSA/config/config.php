<?php

define('APP_ROOT', dirname(__DIR__));
define('BASE_URL', getenv('APP_URL') ?: 'http://localhost/AVSA');
define('SITE_NAME', 'AVSA');
define('SITE_SLOGAN', 'Supporting Lives. Restoring Dignity. Building Hope.');

define('UPLOAD_PATH', APP_ROOT . '/uploads');
define('PUBLIC_PATH', APP_ROOT . '/public');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

date_default_timezone_set('Africa/Kigali');

require_once APP_ROOT . '/config/database.php';
require_once APP_ROOT . '/includes/helpers.php';

define('DONATION_NOTIFICATION_EMAIL', env('DONATION_NOTIFICATION_EMAIL', 'shumbushobenjamin50@gmail.com'));
define('DONATION_CONTACT_PHONE', env('DONATION_CONTACT_PHONE', '0785849398'));
define('AVSA_CONTACT_EMAIL', env('AVSA_CONTACT_EMAIL', DONATION_NOTIFICATION_EMAIL));
define('AVSA_CONTACT_PHONE', env('AVSA_CONTACT_PHONE', DONATION_CONTACT_PHONE));
define('AVSA_WHATSAPP_PHONE', env('AVSA_WHATSAPP_PHONE', '250785849398'));
define('AVSA_WHATSAPP_MESSAGE', 'Can I get more information?');

try {
    $db = getDb();
    $userCount = (int) $db->query('SELECT COUNT(*) FROM users')->fetchColumn();
    if ($userCount === 0) {
        $roleId = (int) $db->query("SELECT id FROM roles WHERE name = 'Super Admin' LIMIT 1")->fetchColumn();
        if (!$roleId) {
            $db->exec("INSERT INTO roles (name, description) VALUES ('Super Admin', 'Full platform control')");
            $roleId = (int) $db->lastInsertId();
        }
        $db->prepare('INSERT INTO users (full_name, email, password_hash, role_id, status) VALUES (:full_name, :email, :password_hash, :role_id, :status)')
            ->execute([
                ':full_name' => 'AVSA Administrator',
                ':email' => 'admin@avsa.org',
                ':password_hash' => password_hash('admin123', PASSWORD_DEFAULT),
                ':role_id' => $roleId,
                ':status' => 'active',
            ]);
    }
} catch (Throwable $e) {
}
