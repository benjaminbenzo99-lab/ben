<?php
$db = getDb();
$programs = $db->query("SELECT * FROM programs WHERE status = 'published' ORDER BY id DESC")->fetchAll();
?>
<?php ob_start(); ?>
<section class="page-hero small-hero">
    <div class="container">
        <span class="eyebrow">What We Do</span>
        <h1>Programs that restore dignity and opportunity.</h1>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="card-grid three-col">
            <?php foreach ($programs as $program): ?>
                <article class="program-card large-card">
                    <img src="<?= e(communityImage($program['image'], (int) $program['id'])) ?>" alt="<?= e($program['title']) ?>">
                    <div class="program-card-body">
                        <span class="icon-wrap"><i class="fa-solid <?= e($program['icon']) ?>"></i></span>
                        <h3><?= e($program['title']) ?></h3>
                        <p><?= e($program['description']) ?></p>
                        <ul>
                            <li><strong>Objectives:</strong> <?= e($program['objectives']) ?></li>
                            <li><strong>Activities:</strong> <?= e($program['activities']) ?></li>
                            <li><strong>Target beneficiaries:</strong> <?= e($program['target_beneficiaries']) ?></li>
                            <li><strong>Results:</strong> <?= e($program['results']) ?></li>
                        </ul>
                        <a href="<?= e(BASE_URL) ?>/?page=program&id=<?= (int)$program['id'] ?>" class="btn btn-secondary btn-sm">Learn More</a>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php $content = ob_get_clean(); ?>
<?php require __DIR__ . '/layout.php'; ?>
