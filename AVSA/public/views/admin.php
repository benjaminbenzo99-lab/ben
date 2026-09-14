<?php
require_once dirname(__DIR__, 2) . '/config/config.php';
if (!isLoggedIn()) {
    redirect('?page=admin');
}
?>
<?php ob_start(); ?>
<section class="page-hero small-hero">
    <div class="container">
        <span class="eyebrow">Admin</span>
        <h1>Dashboard access granted</h1>
    </div>
</section>
<section class="section">
    <div class="container">
        <div class="info-panel">
            <p>You are now logged in to the AVSA admin environment.</p>
            <a class="btn btn-primary" href="<?= e(BASE_URL) ?>/admin/">Open dashboard</a>
        </div>
    </div>
</section>
<?php $content = ob_get_clean(); ?>
<?php require __DIR__ . '/layout.php'; ?>
