<?php
$db = getDb();
$gallery = $db->query("SELECT * FROM gallery ORDER BY created_at DESC")->fetchAll();
?>
<?php ob_start(); ?>
<section class="page-hero small-hero">
    <div class="container">
        <span class="eyebrow">Gallery</span>
        <h1>Moments of care, community and hope.</h1>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="gallery-grid">
            <?php foreach ($gallery as $item): ?>
                <figure class="gallery-item reveal">
                    <img src="<?= e(communityImage($item['file_path'], (int) $item['id'])) ?>" alt="<?= e($item['title']) ?>">
                    <figcaption><?= e($item['title']) ?></figcaption>
                </figure>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php $content = ob_get_clean(); ?>
<?php require __DIR__ . '/layout.php'; ?>
