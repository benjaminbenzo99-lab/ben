<?php
$db = getDb();
$stories = $db->query("SELECT * FROM stories WHERE status = 'published' ORDER BY story_date DESC")->fetchAll();
?>
<?php ob_start(); ?>
<section class="page-hero small-hero">
    <div class="container">
        <span class="eyebrow">Stories & News</span>
        <h1>Updates, lessons and stories of resilience.</h1>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="card-grid three-col">
            <?php foreach ($stories as $story): ?>
                <article class="news-card reveal">
                    <img src="<?= e(communityImage($story['featured_image'], (int) $story['id'])) ?>" alt="<?= e($story['title']) ?>">
                    <div class="news-card-body">
                        <span class="tag"><?= e($story['category']) ?></span>
                        <h3><?= e($story['title']) ?></h3>
                        <p><?= e(substr(strip_tags($story['content']), 0, 140)) ?>...</p>
                        <div class="story-meta">
                            <span><?= e($story['author']) ?></span>
                            <span><?= e(date('M d, Y', strtotime($story['story_date']))) ?></span>
                        </div>
                        <a href="<?= e(BASE_URL) ?>/?page=story&id=<?= (int)$story['id'] ?>" class="text-link">Read article</a>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php $content = ob_get_clean(); ?>
<?php require __DIR__ . '/layout.php'; ?>
