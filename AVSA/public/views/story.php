<?php
$id = (int)($_GET['id'] ?? 0);
$db = getDb();
$stmt = $db->prepare('SELECT * FROM stories WHERE id = :id LIMIT 1');
$stmt->execute([':id' => $id]);
$story = $stmt->fetch();
if (!$story) {
    redirect('?page=stories');
}
?>
<?php ob_start(); ?>
<section class="page-hero small-hero">
    <div class="container">
        <span class="eyebrow">Story</span>
        <h1><?= e($story['title']) ?></h1>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="info-panel">
            <p><strong>Author:</strong> <?= e($story['author']) ?> | <strong>Date:</strong> <?= e(date('M d, Y', strtotime($story['story_date']))) ?> | <strong>Category:</strong> <?= e($story['category']) ?></p>
            <img src="<?= e(communityImage($story['featured_image'], (int) $story['id'])) ?>" alt="<?= e($story['title']) ?>" style="margin: 20px 0; border-radius: 24px;">
            <div><?= nl2br(e($story['content'])) ?></div>
        </div>
    </div>
</section>
<?php $content = ob_get_clean(); ?>
<?php require __DIR__ . '/layout.php'; ?>
