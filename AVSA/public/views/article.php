<?php
$id = (int)($_GET['id'] ?? 0);
$db = getDb();
$stmt = $db->prepare('SELECT * FROM news WHERE id = :id LIMIT 1');
$stmt->execute([':id' => $id]);
$article = $stmt->fetch();
if (!$article) {
    redirect('?page=stories');
}
?>
<?php ob_start(); ?>
<section class="page-hero small-hero">
    <div class="container">
        <span class="eyebrow">News</span>
        <h1><?= e($article['title']) ?></h1>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="info-panel">
            <p><strong>Author:</strong> <?= e($article['author']) ?> | <strong>Date:</strong> <?= e(date('M d, Y', strtotime($article['news_date']))) ?> | <strong>Category:</strong> <?= e($article['category']) ?></p>
            <img src="<?= e(communityImage($article['featured_image'], (int) $article['id'])) ?>" alt="<?= e($article['title']) ?>" style="margin: 20px 0; border-radius: 24px;">
            <div><?= nl2br(e($article['content'])) ?></div>
        </div>
    </div>
</section>
<?php $content = ob_get_clean(); ?>
<?php require __DIR__ . '/layout.php'; ?>
