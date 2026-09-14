<?php
require_once dirname(__DIR__, 2) . '/config/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['donation_submit'])) {
    $db = getDb();
    $stmt = $db->prepare('INSERT INTO donations (donor_name, email, phone, country, amount, currency, donation_type, message, status, payment_reference) VALUES (:donor_name, :email, :phone, :country, :amount, :currency, :donation_type, :message, :status, :payment_reference)');
    $donation = [
        'donor_name' => $_POST['full_name'] ?? '',
        'email' => $_POST['email'] ?? '',
        'phone' => $_POST['phone'] ?? '',
        'country' => $_POST['country'] ?? '',
        'amount' => (float) ($_POST['amount'] ?? 0),
        'currency' => $_POST['currency'] ?? 'USD',
        'donation_type' => $_POST['donation_type'] ?? 'One-time',
        'message' => $_POST['message'] ?? '',
        'payment_reference' => 'AVSA-' . strtoupper(bin2hex(random_bytes(6))),
    ];
    $stmt->execute([
        ':donor_name' => $donation['donor_name'],
        ':email' => $donation['email'],
        ':phone' => $donation['phone'],
        ':country' => $donation['country'],
        ':amount' => $donation['amount'],
        ':currency' => $donation['currency'],
        ':donation_type' => $donation['donation_type'],
        ':message' => $donation['message'],
        ':status' => 'Pending',
        ':payment_reference' => $donation['payment_reference'],
    ]);
    sendDonationNotification($donation);
    setFlash('success', 'Thank you for your donation support. Your record has been created successfully.');
    redirect('?page=donate');
}
?>
<?php ob_start(); ?>
<section class="page-hero small-hero">
    <div class="container">
        <span class="eyebrow">Donate</span>
        <h1>Your support helps families thrive.</h1>
    </div>
</section>

<section class="section">
    <div class="container form-grid">
        <div>
            <span class="eyebrow">Secure donation</span>
            <h2>Every contribution creates real change.</h2>
            <p>AVSA prepares for secure integrations with Stripe, PayPal, Mobile Money and local payment providers while keeping sensitive card data out of the database.</p>
        </div>
        <form class="avsa-form" method="POST">
            <input type="hidden" name="donation_submit" value="1">
            <div class="form-row">
                <label>Full Name<input type="text" name="full_name" required></label>
                <label>Email<input type="email" name="email" required></label>
            </div>
            <div class="form-row">
                <label>Phone<input type="tel" name="phone"></label>
                <label>Country<input type="text" name="country"></label>
            </div>
            <div class="form-row">
                <label>Amount<input type="number" step="0.01" name="amount" required></label>
                <label>Currency
                    <select name="currency">
                        <option value="USD">USD</option>
                        <option value="RWF">RWF</option>
                        <option value="KES">KES</option>
                        <option value="EUR">EUR</option>
                    </select>
                </label>
            </div>
            <div class="form-row">
                <label>Donation Type
                    <select name="donation_type">
                        <option value="One-time">One-time</option>
                        <option value="Monthly">Monthly</option>
                    </select>
                </label>
                <label>Message<textarea name="message" rows="3"></textarea></label>
            </div>
            <button type="submit" class="btn btn-primary">Complete Donation</button>
        </form>
    </div>
</section>
<?php $content = ob_get_clean(); ?>
<?php require __DIR__ . '/layout.php'; ?>
