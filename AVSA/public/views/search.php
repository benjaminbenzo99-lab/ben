<?php
$query = trim($_GET['q'] ?? '');
$db = getDb();
$results = [];
if ($query !== '') {
    $stmt = $db->prepare('SELECT id, title, description, image, category, created_at FROM projects WHERE title LIKE :q OR description LIKE :q OR category LIKE :q UNION SELECT id, title, description, image, category, created_at FROM programs WHERE title LIKE :q OR description LIKE :q UNION SELECT id, title, content as description, featured_image as image, category, story_date as created_at FROM stories WHERE title LIKE :q OR content LIKE :q OR category LIKE :q');
    $term = '%' . $query . '%';
    $stmt->execute([':q' => $term]);
    $results = $stmt->fetchAll();
}
?>
<?php ob_start(); ?>
<section class="page-hero small-hero">
    <div class="container">
        <span class="eyebrow">Search</span>
        <h1>Search results for “<?= e($query) ?>”</h1>
    </div>
</section>

<section class="section">
    <div class="container">
        <?php if (empty($results)): ?>
            <p>No results found for your search.</p>
        <?php else: ?>
            <div class="card-grid three-col">
                <?php foreach ($results as $result): ?>
                    <article class="news-card reveal">
                        <img src="<?= e(communityImage($result['image'] ?? null, (int) $result['id'])) ?>" alt="<?= e($result['title']) ?>">
                        <div class="news-card-body">
                            <span class="tag"><?= e($result['category'] ?? 'Search result') ?></span>
                            <h3><?= e($result['title']) ?></h3>
                            <p><?= e(substr(strip_tags($result['description']), 0, 120)) ?>...</p>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>
<?php $content = ob_get_clean(); ?>
<?php require __DIR__ . '/layout.php'; ?>
