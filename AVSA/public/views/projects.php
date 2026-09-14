<?php
$db = getDb();
$projects = $db->query("SELECT * FROM projects ORDER BY id DESC")->fetchAll();
?>
<?php ob_start(); ?>
<section class="page-hero small-hero">
    <div class="container">
        <span class="eyebrow">Projects</span>
        <h1>Actions driven by local priorities and community trust.</h1>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="card-grid three-col">
            <?php foreach ($projects as $project): ?>
                <article class="project-card reveal">
                    <img src="<?= e(communityImage($project['image'], (int) $project['id'])) ?>" alt="<?= e($project['title']) ?>">
                    <div class="project-card-body">
                        <span class="tag"><?= e($project['category']) ?></span>
                        <h3><?= e($project['title']) ?></h3>
                        <p><?= e(substr($project['description'], 0, 130)) ?>...</p>
                        <div class="project-meta">
                            <span><?= e($project['location']) ?></span>
                            <span><?= e($project['country']) ?></span>
                        </div>
                        <a href="<?= e(BASE_URL) ?>/?page=project&id=<?= (int)$project['id'] ?>" class="btn btn-secondary btn-sm">View Project</a>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php $content = ob_get_clean(); ?>
<?php require __DIR__ . '/layout.php'; ?>
