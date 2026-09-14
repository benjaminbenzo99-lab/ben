<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['contact_submit'])) {
    require_once dirname(__DIR__, 2) . '/config/config.php';
    $db = getDb();
    $stmt = $db->prepare('INSERT INTO contact_messages (name, email, phone, subject, message) VALUES (:name, :email, :phone, :subject, :message)');
    $stmt->execute([
        ':name' => $_POST['name'] ?? '',
        ':email' => $_POST['email'] ?? '',
        ':phone' => $_POST['phone'] ?? '',
        ':subject' => $_POST['subject'] ?? '',
        ':message' => $_POST['message'] ?? '',
    ]);
    setFlash('success', 'Your message has been sent successfully.');
    redirect('?page=contact');
}
?>
<?php ob_start(); ?>
<section class="page-hero small-hero">
    <div class="container">
        <span class="eyebrow">Contact</span>
        <h1>Connect with AVSA.</h1>
    </div>
</section>

<section class="section">
    <div class="container contact-grid">
        <div class="contact-panel">
            <h3>AVSA Headquarters</h3>
            <p>Address: Kigali, Rwanda</p>
            <p>Phone: <a class="contact-link" href="tel:0785849398">0785849398</a></p>
            <p>Email: <a class="contact-link" href="mailto:shumbushobenjamin50@gmail.com">shumbushobenjamin50@gmail.com</a></p>
            <p><a class="btn btn-secondary btn-sm" href="https://wa.me/250785849398?text=Can%20I%20get%20more%20information%3F" target="_blank" rel="noopener">Message us on WhatsApp</a></p>
            <p>Office hours: Monday–Friday, 8:00am–5:00pm</p>
            <div class="map-box">Map placeholder</div>
        </div>
        <form class="avsa-form" method="POST">
            <input type="hidden" name="contact_submit" value="1">
            <div class="form-row">
                <label>Name<input type="text" name="name" required></label>
                <label>Email<input type="email" name="email" required></label>
            </div>
            <div class="form-row">
                <label>Phone<input type="tel" name="phone"></label>
                <label>Subject<input type="text" name="subject" required></label>
            </div>
            <label>Message<textarea name="message" rows="6" required></textarea></label>
            <button type="submit" class="btn btn-primary">Send Message</button>
        </form>
    </div>
</section>
<?php $content = ob_get_clean(); ?>
<?php require __DIR__ . '/layout.php'; ?>
