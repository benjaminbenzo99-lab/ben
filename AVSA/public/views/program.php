<?php
$id = (int)($_GET['id'] ?? 0);
$db = getDb();
$program = $db->prepare('SELECT * FROM programs WHERE id = :id LIMIT 1');
$program->execute([':id' => $id]);
$item = $program->fetch();
if (!$item) {
    redirect('?page=what-we-do');
}
?>
<?php ob_start(); ?>
<section class="page-hero small-hero">
    <div class="container">
        <span class="eyebrow">Program</span>
        <h1><?= e($item['title']) ?></h1>
    </div>
</section>

<section class="section">
    <div class="container two-col">
        <div>
            <img src="<?= e(communityImage($item['image'], (int) $item['id'])) ?>" alt="<?= e($item['title']) ?>" style="border-radius:24px; box-shadow:0 22px 46px rgba(18,61,42,.12); margin-bottom: 20px;">
        </div>
        <div class="info-panel">
            <p><?= e($item['description']) ?></p>
            <ul>
                <li><strong>Objectives:</strong> <?= e($item['objectives']) ?></li>
                <li><strong>Activities:</strong> <?= e($item['activities']) ?></li>
                <li><strong>Target beneficiaries:</strong> <?= e($item['target_beneficiaries']) ?></li>
                <li><strong>Results:</strong> <?= e($item['results']) ?></li>
            </ul>
        </div>
    </div>
</section>
<?php $content = ob_get_clean(); ?>
<?php require __DIR__ . '/layout.php'; ?>
