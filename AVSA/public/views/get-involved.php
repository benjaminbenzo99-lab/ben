<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['volunteer_submit'])) {
    require_once dirname(__DIR__, 2) . '/config/config.php';
    $db = getDb();
    $stmt = $db->prepare('INSERT INTO volunteers (full_name, email, phone, country, area_of_interest, skills, message) VALUES (:full_name, :email, :phone, :country, :area_of_interest, :skills, :message)');
    $stmt->execute([
        ':full_name' => $_POST['full_name'] ?? '',
        ':email' => $_POST['email'] ?? '',
        ':phone' => $_POST['phone'] ?? '',
        ':country' => $_POST['country'] ?? '',
        ':area_of_interest' => $_POST['area_of_interest'] ?? '',
        ':skills' => $_POST['skills'] ?? '',
        ':message' => $_POST['message'] ?? '',
    ]);
    setFlash('success', 'Your volunteer application has been submitted successfully.');
    redirect('?page=get-involved');
}
?>
<?php ob_start(); ?>
<section class="page-hero small-hero">
    <div class="container">
        <span class="eyebrow">Get Involved</span>
        <h1>Join us in creating brighter futures.</h1>
    </div>
</section>

<section class="section">
    <div class="container involvement-grid">
        <div class="involvement-card reveal">
            <h3>Donate</h3>
            <p>Support life-changing programs in child health, education, protection and livelihoods.</p>
            <a href="<?= e(BASE_URL) ?>/?page=donate" class="btn btn-primary btn-sm">Make a Donation</a>
        </div>
        <div class="involvement-card reveal">
            <h3>Volunteer</h3>
            <p>Share your time, expertise and compassion with vulnerable communities.</p>
        </div>
        <div class="involvement-card reveal">
            <h3>Partner With Us</h3>
            <p>Build partnerships across health, education, livelihoods and community development.</p>
        </div>
        <div class="involvement-card reveal">
            <h3>Sponsor a Project</h3>
            <p>Invest directly in a project that transforms lives and strengthens communities.</p>
        </div>
    </div>
</section>

<section class="section section-alt">
    <div class="container form-grid">
        <div>
            <span class="eyebrow">Volunteer form</span>
            <h2>Tell us how you would like to contribute.</h2>
        </div>
        <form class="avsa-form" method="POST">
            <input type="hidden" name="volunteer_submit" value="1">
            <div class="form-row">
                <label>Full Name<input type="text" name="full_name" required></label>
                <label>Email<input type="email" name="email" required></label>
            </div>
            <div class="form-row">
                <label>Phone<input type="tel" name="phone"></label>
                <label>Country<input type="text" name="country"></label>
            </div>
            <div class="form-row">
                <label>Area of Interest<input type="text" name="area_of_interest"></label>
                <label>Skills<textarea name="skills" rows="3"></textarea></label>
            </div>
            <label>Message<textarea name="message" rows="5" required></textarea></label>
            <button type="submit" class="btn btn-primary">Apply to Volunteer</button>
        </form>
    </div>
</section>
<?php $content = ob_get_clean(); ?>
<?php require __DIR__ . '/layout.php'; ?>
