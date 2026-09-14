<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login_submit'])) {
    require_once dirname(__DIR__, 2) . '/config/config.php';
    $db = getDb();
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $user = $db->prepare('SELECT * FROM users WHERE email = :email LIMIT 1');
    $user->execute([':email' => $email]);
    $row = $user->fetch();

    if ($row && password_verify($password, $row['password_hash'])) {
        $_SESSION['user_id'] = (int) $row['id'];
        $_SESSION['user'] = $row;
        redirect('admin/');
    }

    setFlash('error', 'Invalid email or password.');
    redirect('?page=login');
}
?>
<?php ob_start(); ?>
<section class="page-hero small-hero">
    <div class="container">
        <span class="eyebrow">Login</span>
        <h1>Access AVSA Admin Portal</h1>
    </div>
</section>

<section class="section">
    <div class="container narrow-form-wrap">
        <form class="avsa-form" method="POST">
            <input type="hidden" name="login_submit" value="1">
            <label>Email<input type="email" name="email" required></label>
            <label>Password<input type="password" name="password" required></label>
            <button type="submit" class="btn btn-primary">Login</button>
        </form>
    </div>
</section>
<?php $content = ob_get_clean(); ?>
<?php require __DIR__ . '/layout.php'; ?>
