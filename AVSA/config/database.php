<?php

function env($key, $default = null)
{
    $value = getenv($key);
    if ($value !== false && $value !== null && $value !== '') {
        return $value;
    }

    $envFile = APP_ROOT . '/.env';
    if (is_file($envFile)) {
        $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            if (strpos(trim($line), '#') === 0) {
                continue;
            }
            [$name, $value] = array_pad(explode('=', $line, 2), 2, '');
            if (trim($name) === $key) {
                return trim($value, " \n\r\t\v\0\"");
            }
        }
    }

    return $default;
}

function ensureDatabaseReady(): void
{
    $host = env('DB_HOST', '127.0.0.1');
    $db = env('DB_NAME', 'avsa_db');
    $user = env('DB_USER', 'root');
    $pass = env('DB_PASSWORD', '');
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ];

    try {
        $adminPdo = new PDO("mysql:host={$host};charset=utf8mb4", $user, $pass, $options);
        $adminPdo->exec("CREATE DATABASE IF NOT EXISTS `{$db}` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");

        $pdo = new PDO("mysql:host={$host};dbname={$db};charset=utf8mb4", $user, $pass, $options);
        $tables = $pdo->query('SHOW TABLES')->fetchAll(PDO::FETCH_COLUMN);

        if (empty($tables)) {
            $sql = file_get_contents(APP_ROOT . '/database/database.sql');
            $sql = preg_replace('/CREATE DATABASE IF NOT EXISTS.*?;\s*/is', '', $sql);
            $sql = preg_replace('/USE\s+[^;]+;\s*/is', '', $sql);
            $statements = array_filter(array_map('trim', preg_split('/;\s*(?=(?:CREATE|INSERT|ALTER|UPDATE|DELETE|DROP|SET))/', $sql)));

            foreach ($statements as $statement) {
                if ($statement !== '') {
                    $pdo->exec($statement . ';');
                }
            }
        }
    } catch (Throwable $e) {
        throw new RuntimeException('Database connection failed. Start MySQL and ensure your .env values are correct.');
    }
}

function getDb(): PDO
{
    static $pdo = null;

    if ($pdo !== null) {
        return $pdo;
    }

    ensureDatabaseReady();

    $host = env('DB_HOST', '127.0.0.1');
    $db = env('DB_NAME', 'avsa_db');
    $user = env('DB_USER', 'root');
    $pass = env('DB_PASSWORD', '');
    $charset = 'utf8mb4';

    $dsn = "mysql:host={$host};dbname={$db};charset={$charset}";

    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ];

    try {
        $pdo = new PDO($dsn, $user, $pass, $options);
    } catch (PDOException $e) {
        throw new RuntimeException('Database connection failed. Please start MySQL and update your .env values.');
    }

    return $pdo;
}
