<?php
$db = getDb();
$metrics = $db->query("SELECT * FROM impact_metrics ORDER BY id")->fetchAll();
?>
<?php ob_start(); ?>
<section class="page-hero small-hero">
    <div class="container">
        <span class="eyebrow">Our Impact</span>
        <h1>Progress that is visible, measurable and life-changing.</h1>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="stats-grid large">
            <?php foreach ($metrics as $metric): ?>
                <div class="stat-box reveal">
                    <span class="stat-number" data-target="<?= preg_replace('/[^0-9]/', '', $metric['value']) ?: 0 ?>">0</span>
                    <span class="stat-label"><?= e($metric['metric_label']) ?></span>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php $content = ob_get_clean(); ?>
<?php require __DIR__ . '/layout.php'; ?>
