<?php ob_start(); ?>
<section class="section">
    <div class="container" style="text-align:center;">
        <span class="eyebrow">404</span>
        <h1>Page not found</h1>
        <p>The page you are looking for no longer exists or may have moved.</p>
        <a href="<?= e(BASE_URL) ?>/?page=home" class="btn btn-primary">Return Home</a>
    </div>
</section>
<?php $content = ob_get_clean(); ?>
<?php require __DIR__ . '/layout.php'; ?>
