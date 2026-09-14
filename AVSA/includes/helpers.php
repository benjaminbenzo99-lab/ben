<?php

function e($value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

function redirect($path): void
{
    $url = BASE_URL . '/' . ltrim($path, '/');
    header('Location: ' . $url);
    exit;
}

function currentRoute(): string
{
    return $_GET['page'] ?? 'home';
}

function isLoggedIn(): bool
{
    return !empty($_SESSION['user_id']);
}

function authUser(): ?array
{
    if (!isLoggedIn()) {
        return null;
    }

    return $_SESSION['user'] ?? null;
}

function csrfToken(): string
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }

    return $_SESSION['csrf_token'];
}

function verifyCsrf(): void
{
    $token = $_POST['csrf_token'] ?? '';
    if (!hash_equals($_SESSION['csrf_token'] ?? '', $token)) {
        http_response_code(403);
        exit('CSRF validation failed.');
    }
}

function setFlash($type, $message): void
{
    $_SESSION['flash'] = ['type' => $type, 'message' => $message];
}

function getFlash(): ?array
{
    $flash = $_SESSION['flash'] ?? null;
    unset($_SESSION['flash']);
    return $flash;
}

function siteSetting(string $key, string $default = ''): string
{
    static $cache = null;

    if ($cache === null) {
        try {
            $db = getDb();
            $cache = $db->query('SELECT * FROM site_settings')->fetchAll(PDO::FETCH_KEY_PAIR) ?? [];
        } catch (Throwable $e) {
            $cache = [];
        }
    }

    return $cache[$key] ?? $default;
}

function avsaContactEmail(): string
{
    return env('AVSA_CONTACT_EMAIL', 'shumbushobenjamin50@gmail.com');
}

function avsaContactPhone(): string
{
    return env('AVSA_CONTACT_PHONE', '0785849398');
}

function avsaWhatsAppPhone(): string
{
    return env('AVSA_WHATSAPP_PHONE', '250785849398');
}

function avsaWhatsAppMessage(): string
{
    return 'Can I get more information?';
}

function communityImage(?string $image, int $variant = 0): string
{
    if ($image && !preg_match('/^https?:\/\//i', $image)) {
        return $image;
    }

    $filename = $variant % 2 === 0 ? 'Picture3.png' : 'Picture4.png';
    return BASE_URL . '/public/assets/images/' . $filename;
}

function sendDonationNotification(array $donation): bool
{
    $recipient = DONATION_NOTIFICATION_EMAIL;
    $donorEmail = filter_var($donation['email'] ?? '', FILTER_VALIDATE_EMAIL);
    $subject = 'New AVSA donation interest - ' . ($donation['payment_reference'] ?? 'Pending');
    $message = "A new person wants to donate to AVSA.\n\n"
        . 'Name: ' . ($donation['donor_name'] ?? '') . "\n"
        . 'Email: ' . ($donation['email'] ?? '') . "\n"
        . 'Phone: ' . ($donation['phone'] ?? '') . "\n"
        . 'Country: ' . ($donation['country'] ?? '') . "\n"
        . 'Amount: ' . ($donation['amount'] ?? '') . ' ' . ($donation['currency'] ?? '') . "\n"
        . 'Type: ' . ($donation['donation_type'] ?? '') . "\n"
        . 'Reference: ' . ($donation['payment_reference'] ?? '') . "\n"
        . 'Message: ' . ($donation['message'] ?? '') . "\n\n"
        . 'AVSA contact phone: ' . DONATION_CONTACT_PHONE . "\n"
        . 'This is a donation request. Payment status: Pending.';
    $headers = [
        'From: AVSA Donations <' . $recipient . '>',
        'Reply-To: ' . ($donorEmail ?: $recipient),
        'Content-Type: text/plain; charset=UTF-8',
    ];

    return mail($recipient, $subject, $message, implode("\r\n", $headers));
}

function randomString(int $length = 12): string
{
    $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $max = strlen($chars) - 1;
    $result = '';

    for ($i = 0; $i < $length; $i++) {
        $result .= $chars[random_int(0, $max)];
    }

    return $result;
}

function formatCurrency(float $amount, string $currency = 'USD'): string
{
    $format = new NumberFormatter('en_US', NumberFormatter::CURRENCY);
    return $format->formatCurrency($amount, $currency);
}

function makeSlug(string $text): string
{
    $slug = strtolower(trim($text));
    $slug = preg_replace('/[^a-z0-9]+/', '-', $slug);
    $slug = trim($slug, '-');
    return $slug ?: 'item';
}

function createAuditLog(string $action, string $details = '', ?int $userId = null): void
{
    try {
        $db = getDb();
        $stmt = $db->prepare('INSERT INTO audit_logs (user_id, action, details, created_at) VALUES (:user_id, :action, :details, NOW())');
        $stmt->execute([
            ':user_id' => $userId,
            ':action' => $action,
            ':details' => $details,
        ]);
    } catch (Throwable $e) {
    }
}
