<?php
$db = getDb();
$programs = $db->query("SELECT * FROM programs WHERE status = 'published' ORDER BY id DESC LIMIT 3")->fetchAll();
$projects = $db->query("SELECT * FROM projects ORDER BY id DESC LIMIT 3")->fetchAll();
$stories = $db->query("SELECT * FROM stories WHERE status = 'published' ORDER BY id DESC LIMIT 3")->fetchAll();
$impact = $db->query("SELECT * FROM impact_metrics ORDER BY id")->fetchAll();
$testimonials = $db->query("SELECT * FROM testimonials ORDER BY id DESC LIMIT 2")->fetchAll();
?>
<?php ob_start(); ?>
<section class="hero">
    <div class="container hero-grid">
        <div class="hero-copy reveal">
            <span class="eyebrow">Africa Vulnerable Support Agency</span>
            <h1>Supporting Lives.<br>Restoring Dignity.<br>Building Hope.</h1>
            <p>AVSA works to improve the lives of vulnerable children, families and marginalized communities by providing health support, education, protection, empowerment and sustainable community development.</p>
            <div class="hero-actions">
                <a href="<?= e(BASE_URL) ?>/?page=what-we-do" class="btn btn-primary">Our Programs</a>
                <a href="<?= e(BASE_URL) ?>/?page=donate" class="btn btn-secondary">Support AVSA</a>
            </div>
            <ul class="hero-metrics">
                <li><strong>10K+</strong><span>Children supported</span></li>
                <li><strong>5K+</strong><span>Families reached</span></li>
                <li><strong>50+</strong><span>Communities served</span></li>
            </ul>
        </div>
        <div class="hero-visual reveal">
            <div class="hero-image-card large">
                <img src="<?= e(BASE_URL) ?>/public/assets/images/Picture4.png" alt="African children, families and communities supported by AVSA">
            </div>
            <div class="floating-card card-one">
                <span class="mini-label">Community care</span>
                <strong>Health & Education</strong>
            </div>
            <div class="floating-card card-two">
                <span class="mini-label">Impact</span>
                <strong>25+ projects</strong>
            </div>
        </div>
    </div>
</section>

<section class="section about-preview">
    <div class="container split-grid">
        <div class="image-stack reveal">
            <img src="<?= e(BASE_URL) ?>/public/assets/images/Picture3.png" alt="African families and children in AVSA support programs">
            <img src="<?= e(BASE_URL) ?>/public/assets/images/Picture4.png" alt="African community members and AVSA guiding values">
        </div>
        <div class="content reveal">
            <span class="eyebrow">Who we are</span>
            <h2>We stand with communities facing vulnerability.</h2>
            <p>AVSA exists to lift vulnerable children, families and marginalized communities through practical, sustainable support rooted in dignity, equity and compassion.</p>
            <div class="feature-list">
                <div>
                    <strong>Our Mission</strong>
                    <p>To improve the quality of life ...</p>
                </div>
                <div>
                    <strong>Our Vision</strong>
                    <p>A society where every vulnerable person has an opportunity to live with dignity and hope.</p>
                </div>
            </div>
            <a class="btn btn-primary" href="<?= e(BASE_URL) ?>/?page=about">Learn More</a>
        </div>
    </div>
</section>

<section class="section faith-section">
    <div class="container faith-grid faith-grid-compact">
        <div class="faith-mark" aria-hidden="true">+</div>
        <div>
            <span class="eyebrow">Our foundation</span>
            <h2>Faith in God. Service with compassion.</h2>
            <p>As a faith-based organization, AVSA follows Christian principles of dignity, integrity, justice and care for vulnerable people.</p>
            <a class="text-link" href="<?= e(BASE_URL) ?>/?page=about">Learn about our faith foundation</a>
        </div>
    </div>
</section>

<section class="section section-alt">
    <div class="container">
        <div class="section-header reveal">
            <span class="eyebrow">What we do</span>
            <h2>Programs designed to restore dignity and opportunity.</h2>
        </div>
        <div class="card-grid three-col">
            <?php foreach ($programs as $program): ?>
                <article class="program-card reveal">
                    <img src="<?= e(communityImage($program['image'], (int) $program['id'])) ?>" alt="<?= e($program['title']) ?>">
                    <div class="program-card-body">
                        <span class="icon-wrap"><i class="fa-solid <?= e($program['icon']) ?>"></i></span>
                        <h3><?= e($program['title']) ?></h3>
                        <p><?= e(substr($program['description'], 0, 140)) ?>...</p>
                        <a href="<?= e(BASE_URL) ?>/?page=program&id=<?= (int)$program['id'] ?>" class="text-link">Learn More</a>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="section-header reveal">
            <span class="eyebrow">Our impact</span>
            <h2>Measured progress across health, education, protection and livelihoods.</h2>
        </div>
        <div class="stats-grid">
            <?php foreach ($impact as $metric): ?>
                <div class="stat-box reveal">
                    <span class="stat-number" data-target="<?= preg_replace('/[^0-9]/', '', $metric['value']) ?: 0 ?>">0</span>
                    <span class="stat-label"><?= e($metric['metric_label']) ?></span>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="section section-alt">
    <div class="container">
        <div class="section-header reveal">
            <span class="eyebrow">Latest projects</span>
            <h2>Community-focused initiatives that drive lasting change.</h2>
        </div>
        <div class="card-grid three-col">
            <?php foreach ($projects as $project): ?>
                <article class="project-card reveal">
                    <img src="<?= e(communityImage($project['image'], (int) $project['id'])) ?>" alt="<?= e($project['title']) ?>">
                    <div class="project-card-body">
                        <span class="tag"><?= e($project['category']) ?></span>
                        <h3><?= e($project['title']) ?></h3>
                        <p><?= e(substr($project['description'], 0, 130)) ?>...</p>
                        <div class="project-meta">
                            <span><?= e($project['country']) ?></span>
                            <span><?= e($project['status']) ?></span>
                        </div>
                        <a href="<?= e(BASE_URL) ?>/?page=project&id=<?= (int)$project['id'] ?>" class="btn btn-secondary btn-sm">View Project</a>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="section-header reveal">
            <span class="eyebrow">Stories & news</span>
            <h2>Stories of resilience, support and hope.</h2>
        </div>
        <div class="card-grid three-col">
            <?php foreach ($stories as $story): ?>
                <article class="news-card reveal">
                    <img src="<?= e(communityImage($story['featured_image'], (int) $story['id'])) ?>" alt="<?= e($story['title']) ?>">
                    <div class="news-card-body">
                        <span class="tag"><?= e($story['category']) ?></span>
                        <h3><?= e($story['title']) ?></h3>
                        <p><?= e(substr(strip_tags($story['content']), 0, 130)) ?>...</p>
                        <div class="story-meta">
                            <span><?= e($story['author']) ?></span>
                            <span><?= e(date('M d, Y', strtotime($story['story_date']))) ?></span>
                        </div>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="section cta-band">
    <div class="container cta-box reveal">
        <div>
            <span class="eyebrow">Get involved</span>
            <h2>Be part of the transformation.</h2>
        </div>
        <a href="<?= e(BASE_URL) ?>/?page=get-involved" class="btn btn-primary">Support AVSA</a>
    </div>
</section>
<?php $content = ob_get_clean(); ?>
<?php require __DIR__ . '/layout.php'; ?>
