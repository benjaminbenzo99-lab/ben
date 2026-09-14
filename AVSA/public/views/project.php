<?php
$id = (int)($_GET['id'] ?? 0);
$db = getDb();
$stmt = $db->prepare('SELECT * FROM projects WHERE id = :id LIMIT 1');
$stmt->execute([':id' => $id]);
$project = $stmt->fetch();
if (!$project) {
    redirect('?page=projects');
}
?>
<?php ob_start(); ?>
<section class="page-hero small-hero">
    <div class="container">
        <span class="eyebrow">Project</span>
        <h1><?= e($project['title']) ?></h1>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="two-col">
            <div>
                <img src="<?= e(communityImage($project['image'], (int) $project['id'])) ?>" alt="<?= e($project['title']) ?>" style="border-radius:24px; box-shadow:0 18px 38px rgba(18,61,42,.12);">
            </div>
            <div class="info-panel">
                <p><strong>Category:</strong> <?= e($project['category']) ?></p>
                <p><strong>Location:</strong> <?= e($project['location']) ?>, <?= e($project['country']) ?></p>
                <p><strong>Status:</strong> <?= e($project['status']) ?></p>
                <p><strong>Budget:</strong> <?= e($project['budget']) ?></p>
                <p><strong>Funding source:</strong> <?= e($project['funding_source']) ?></p>
                <p><strong>Progress:</strong> <?= (int)$project['progress_percentage'] ?>%</p>
            </div>
        </div>
        <div class="info-panel" style="margin-top: 30px;">
            <h3>Project description</h3>
            <p><?= e($project['description']) ?></p>
            <p><strong>Objectives:</strong> <?= e($project['objectives']) ?></p>
            <p><strong>Target beneficiaries:</strong> <?= e($project['target_beneficiaries']) ?></p>
            <p><strong>Results:</strong> <?= e($project['results']) ?></p>
        </div>
    </div>
</section>
<?php $content = ob_get_clean(); ?>
<?php require __DIR__ . '/layout.php'; ?>
