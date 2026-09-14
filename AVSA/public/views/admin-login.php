<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['admin_login'])) {
    require_once dirname(__DIR__, 2) . '/config/config.php';
    $db = getDb();
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $stmt = $db->prepare('SELECT u.*, r.name AS role_name FROM users u LEFT JOIN roles r ON r.id = u.role_id WHERE u.email = :email LIMIT 1');
    $stmt->execute([':email' => $email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password_hash'])) {
        $_SESSION['user_id'] = (int) $user['id'];
        $_SESSION['user'] = $user;
        $_SESSION['user_role'] = $user['role_name'];
        redirect('admin/');
    }

    setFlash('error', 'Invalid admin credentials.');
    redirect('admin');
}
?>
<?php ob_start(); ?>
<section class="page-hero small-hero">
    <div class="container">
        <span class="eyebrow">Admin Access</span>
        <h1>Secure AVSA dashboard login</h1>
    </div>
</section>

<section class="section">
    <div class="container narrow-form-wrap">
        <form class="avsa-form" method="POST">
            <input type="hidden" name="admin_login" value="1">
            <label>Email<input type="email" name="email" required></label>
            <label>Password<input type="password" name="password" required></label>
            <button type="submit" class="btn btn-primary">Login to Dashboard</button>
        </form>
    </div>
</section>
<?php $content = ob_get_clean(); ?>
<?php require __DIR__ . '/layout.php'; ?>
