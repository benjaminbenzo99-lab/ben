<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e(siteSetting('site_name', 'AVSA')) ?> | <?= e(siteSetting('site_slogan', 'Supporting Lives. Restoring Dignity. Building Hope.')) ?></title>
    <meta name="description" content="AVSA works to improve the lives of vulnerable children, families and marginalized communities through sustainable health, education, protection, empowerment and support.">
    <meta property="og:title" content="AVSA | Africa Vulnerable Support Agency">
    <meta property="og:description" content="Supporting Lives. Restoring Dignity. Building Hope.">
    <meta property="og:type" content="website">
    <meta name="twitter:card" content="summary_large_image">
    <link rel="canonical" href="<?= e(BASE_URL) ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= e(BASE_URL) ?>/public/assets/css/style.css">
</head>
<body>
    <header class="site-header">
        <div class="container nav-wrap">
            <a href="<?= e(BASE_URL) ?>/?page=home" class="brand" aria-label="AVSA home page">
                <img class="brand-logo" src="<?= e(BASE_URL) ?>/public/assets/images/avsa-logo.svg" alt="AVSA - Africa Vulnerable Support Agency">
            </a>

            <nav class="main-nav" aria-label="Main navigation">
                <a href="<?= e(BASE_URL) ?>/?page=home">Home</a>
                <a href="<?= e(BASE_URL) ?>/?page=about">About Us</a>
                <a href="<?= e(BASE_URL) ?>/?page=what-we-do">What We Do</a>
                <a href="<?= e(BASE_URL) ?>/?page=impact">Our Impact</a>
                <a href="<?= e(BASE_URL) ?>/?page=projects">Projects</a>
                <a href="<?= e(BASE_URL) ?>/?page=stories">Stories & News</a>
                <a href="<?= e(BASE_URL) ?>/?page=gallery">Gallery</a>
                <a href="<?= e(BASE_URL) ?>/?page=get-involved">Get Involved</a>
                <a href="<?= e(BASE_URL) ?>/?page=contact">Contact</a>
            </nav>

            <div class="nav-actions">
                <a class="btn btn-primary btn-sm" href="<?= e(BASE_URL) ?>/?page=donate">DONATE</a>
                <button class="menu-toggle" aria-label="Toggle menu" aria-expanded="false">
                    <span></span><span></span><span></span>
                </button>
            </div>
        </div>
    </header>

    <main>
        <?php if (isset($content)) { echo $content; } ?>
    </main>

    <a class="live-chat" href="https://wa.me/250785849398?text=Can%20I%20get%20more%20information%3F" target="_blank" rel="noopener" aria-label="Chat with AVSA on WhatsApp">
        <span class="live-chat-dot" aria-hidden="true"></span>
        <span>Chat with AVSA</span>
    </a>

    <footer class="site-footer">
        <div class="container footer-grid">
            <div>
                <div class="brand brand-footer">
                    <img class="brand-logo brand-logo-footer" src="<?= e(BASE_URL) ?>/public/assets/images/avsa-logo.svg" alt="AVSA - Africa Vulnerable Support Agency">
                </div>
                <p>AVSA is committed to improving the lives of vulnerable children, families and communities through compassionate, sustainable support.</p>
            </div>

            <div>
                <h4>Quick Links</h4>
                <ul>
                    <li><a href="<?= e(BASE_URL) ?>/?page=what-we-do">Programs</a></li>
                    <li><a href="<?= e(BASE_URL) ?>/?page=projects">Projects</a></li>
                    <li><a href="<?= e(BASE_URL) ?>/?page=get-involved">Get Involved</a></li>
                    <li><a href="<?= e(BASE_URL) ?>/?page=contact">Contact</a></li>
                    <li><a href="<?= e(BASE_URL) ?>/?page=stories">Newsletter</a></li>
                </ul>
            </div>

            <div>
                <h4>Social Media</h4>
                <ul>
                    <li><a href="#">Facebook</a></li>
                    <li><a href="#">Instagram</a></li>
                    <li><a href="#">LinkedIn</a></li>
                    <li><a href="#">YouTube</a></li>
                    <li><a href="#">X</a></li>
                </ul>
            </div>

            <div>
                <h4>Contact AVSA</h4>
                <ul>
                    <li><a href="mailto:shumbushobenjamin50@gmail.com">shumbushobenjamin50@gmail.com</a></li>
                    <li><a href="tel:0785849398">0785849398</a></li>
                    <li><a href="https://wa.me/250785849398?text=Can%20I%20get%20more%20information%3F" target="_blank" rel="noopener">WhatsApp us</a></li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <div class="container">
                <p>© AVSA – Africa Vulnerable Support Agency. All Rights Reserved.</p>
            </div>
        </div>
    </footer>

    <script src="<?= e(BASE_URL) ?>/public/assets/js/main.js"></script>
</body>
</html>
