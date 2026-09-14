<?php ob_start(); ?>
<section class="page-hero small-hero">
    <div class="container">
        <span class="eyebrow">About AVSA</span>
        <h1>We walk alongside the vulnerable.</h1>
    </div>
</section>

<section class="section">
    <div class="container two-col">
        <div>
            <span class="eyebrow">Who We Are</span>
            <h2>AVSA is a humanitarian platform for dignity, care and opportunity.</h2>
            <p>AVSA – Africa Vulnerable Support Agency – is a nonprofit organization committed to improving the lives of vulnerable children, orphans, poor families, marginalized communities and other people left behind by history.</p>
            <p>Our work is rooted in compassion, inclusion and sustainable community development. We help communities access health support, education, protection, livelihood opportunities and social care.</p>
        </div>
        <div class="info-panel">
            <h3>Our Mission</h3>
            <p>“To improve the quality of life of vulnerable children, families and marginalized communities through sustainable health, education, protection, empowerment and social support initiatives.”</p>
            <h3>Our Vision</h3>
            <p>“A society where every vulnerable person has an opportunity to live with dignity, health, hope and equal opportunity.”</p>
        </div>
    </div>
</section>

<section class="section section-alt">
    <div class="container">
        <div class="section-header">
            <span class="eyebrow">Our people</span>
            <h2>People serving communities with faith and purpose.</h2>
            <p class="section-intro">AVSA brings together people with different skills and a shared commitment to vulnerable children, families and communities.</p>
        </div>
        <div class="team-grid">
            <article class="team-card"><span class="team-number">01</span><h3>Executive Director</h3><p>Provides leadership and keeps AVSA focused on its mission and faith-based values.</p></article>
            <article class="team-card"><span class="team-number">02</span><h3>Programs Coordinator</h3><p>Coordinates health, education, protection and empowerment programs.</p></article>
            <article class="team-card"><span class="team-number">03</span><h3>Child Protection Officer</h3><p>Helps protect children and connect vulnerable families with safe support.</p></article>
            <article class="team-card"><span class="team-number">04</span><h3>Community Outreach Lead</h3><p>Builds respectful relationships with local leaders, caregivers and communities.</p></article>
            <article class="team-card"><span class="team-number">05</span><h3>Health Program Officer</h3><p>Supports health education, referrals and care for children and families.</p></article>
            <article class="team-card"><span class="team-number">06</span><h3>Education and Skills Lead</h3><p>Develops learning, mentoring and skills opportunities for people in need.</p></article>
            <article class="team-card"><span class="team-number">07</span><h3>Finance and Administration Officer</h3><p>Protects resources through careful planning, records and responsible stewardship.</p></article>
            <article class="team-card"><span class="team-number">08</span><h3>Monitoring and Evaluation Officer</h3><p>Tracks results and helps AVSA learn what creates lasting community impact.</p></article>
            <article class="team-card"><span class="team-number">09</span><h3>Volunteer and Partnerships Lead</h3><p>Welcomes volunteers and builds partnerships that strengthen local action.</p></article>
            <article class="team-card"><span class="team-number">10</span><h3>Community Support Volunteer</h3><p>Offers practical support and listens to the people AVSA serves every day.</p></article>
        </div>
    </div>
</section>

<section class="section faith-section">
    <div class="container faith-grid">
        <div class="faith-mark" aria-hidden="true">+</div>
        <div>
            <span class="eyebrow">Faith & Foundation</span>
            <h2>Our work is guided by faith in God and Christian principles.</h2>
            <p>AVSA is a faith-based organization. We believe every person is created with dignity and deserves compassion, protection, justice and the opportunity to live with hope. Our faith calls us to serve with humility, honesty and love, especially alongside children, families and communities facing vulnerability.</p>
            <p>In every program, we seek to follow Biblical principles of stewardship, care for the poor, integrity, reconciliation and service. We welcome people from every background and put this faith into action through practical support and respectful partnership.</p>
            <blockquote class="faith-quote">“Defend the weak and the fatherless; uphold the cause of the poor and the oppressed.” <cite>Psalm 82:3</cite></blockquote>
        </div>
    </div>
</section>

<section class="section section-alt">
    <div class="container">
        <div class="section-header">
            <span class="eyebrow">Our values</span>
            <h2>Guiding principles behind every action.</h2>
        </div>
        <div class="value-grid">
            <button class="value-card" type="button" data-principle="compassion"><h3>Compassion</h3><span>Learn more</span></button>
            <button class="value-card" type="button" data-principle="integrity"><h3>Integrity</h3><span>Learn more</span></button>
            <button class="value-card" type="button" data-principle="dignity"><h3>Dignity</h3><span>Learn more</span></button>
            <button class="value-card" type="button" data-principle="equality"><h3>Equality</h3><span>Learn more</span></button>
            <button class="value-card" type="button" data-principle="accountability"><h3>Accountability</h3><span>Learn more</span></button>
            <button class="value-card" type="button" data-principle="community"><h3>Community</h3><span>Learn more</span></button>
            <button class="value-card" type="button" data-principle="transparency"><h3>Transparency</h3><span>Learn more</span></button>
            <button class="value-card" type="button" data-principle="sustainability"><h3>Sustainability</h3><span>Learn more</span></button>
        </div>
        <div class="principle-detail" data-principle-detail aria-live="polite" hidden>
            <span class="eyebrow">Selected principle</span>
            <h3 data-principle-title></h3>
            <p data-principle-description></p>
        </div>
    </div>
</section>

<section class="section">
    <div class="container two-col">
        <div>
            <span class="eyebrow">Our approach</span>
            <h2>We work with communities, not for them.</h2>
            <p>Our approach combines direct support with long-term capacity building. We co-design solutions with local leaders, caregivers and affected communities to build systems that are resilient and locally rooted.</p>
        </div>
        <div class="timeline-list">
            <div><strong>Our History</strong><p>AVSA began through compassionate local action and grew into a network of humanitarian support and development partnerships.</p></div>
            <div><strong>Our Objectives</strong><p>To strengthen health, education, protection and resilience while promoting dignity, inclusion and equal opportunity.</p></div>
        </div>
    </div>
</section>
<?php $content = ob_get_clean(); ?>
<?php require __DIR__ . '/layout.php'; ?>
