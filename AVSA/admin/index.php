<?php
require_once dirname(__DIR__) . '/config/config.php';

if (!isLoggedIn()) {
    redirect('?page=admin');
}

$db = getDb();
$tab = $_GET['tab'] ?? 'overview';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['save_program'])) {
        $title = trim($_POST['title'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $slug = makeSlug($title);
        $stmt = $db->prepare('INSERT INTO programs (title, slug, icon, image, description, objectives, activities, target_beneficiaries, results, status) VALUES (:title, :slug, :icon, :image, :description, :objectives, :activities, :target_beneficiaries, :results, :status)');
        $stmt->execute([
            ':title' => $title,
            ':slug' => $slug,
            ':icon' => $_POST['icon'] ?? 'fa-heart',
            ':image' => $_POST['image'] ?? '',
            ':description' => $description,
            ':objectives' => $_POST['objectives'] ?? '',
            ':activities' => $_POST['activities'] ?? '',
            ':target_beneficiaries' => $_POST['target_beneficiaries'] ?? '',
            ':results' => $_POST['results'] ?? '',
            ':status' => $_POST['status'] ?? 'published',
        ]);
        setFlash('success', 'Program added successfully.');
    }

    if (isset($_POST['save_project'])) {
        $title = trim($_POST['title'] ?? '');
        $stmt = $db->prepare('INSERT INTO projects (title, slug, category, location, country, start_date, end_date, description, objectives, target_beneficiaries, budget, funding_source, status, progress_percentage, image) VALUES (:title, :slug, :category, :location, :country, :start_date, :end_date, :description, :objectives, :target_beneficiaries, :budget, :funding_source, :status, :progress_percentage, :image)');
        $stmt->execute([
            ':title' => $title,
            ':slug' => makeSlug($title),
            ':category' => $_POST['category'] ?? '',
            ':location' => $_POST['location'] ?? '',
            ':country' => $_POST['country'] ?? '',
            ':start_date' => $_POST['start_date'] ?? null,
            ':end_date' => $_POST['end_date'] ?? null,
            ':description' => $_POST['description'] ?? '',
            ':objectives' => $_POST['objectives'] ?? '',
            ':target_beneficiaries' => $_POST['target_beneficiaries'] ?? '',
            ':budget' => $_POST['budget'] ?? 0,
            ':funding_source' => $_POST['funding_source'] ?? '',
            ':status' => $_POST['status'] ?? 'Ongoing',
            ':progress_percentage' => (int)($_POST['progress_percentage'] ?? 0),
            ':image' => $_POST['image'] ?? '',
        ]);
        setFlash('success', 'Project added successfully.');
    }

    if (isset($_POST['save_metric'])) {
        $metricKey = trim($_POST['metric_key'] ?? '');
        $stmt = $db->prepare('INSERT INTO impact_metrics (metric_key, metric_label, value, description) VALUES (:metric_key, :metric_label, :value, :description) ON DUPLICATE KEY UPDATE metric_label = VALUES(metric_label), value = VALUES(value), description = VALUES(description)');
        $stmt->execute([
            ':metric_key' => $metricKey,
            ':metric_label' => $_POST['metric_label'] ?? '',
            ':value' => $_POST['value'] ?? '0',
            ':description' => $_POST['description'] ?? '',
        ]);
        setFlash('success', 'Impact metric updated successfully.');
    }

    if (isset($_POST['save_setting'])) {
        $key = trim($_POST['setting_key'] ?? '');
        $value = trim($_POST['setting_value'] ?? '');
        $stmt = $db->prepare('INSERT INTO site_settings (setting_key, setting_value, description) VALUES (:setting_key, :setting_value, :description) ON DUPLICATE KEY UPDATE setting_value = VALUES(setting_value), description = VALUES(description)');
        $stmt->execute([
            ':setting_key' => $key,
            ':setting_value' => $value,
            ':description' => $_POST['description'] ?? '',
        ]);
        setFlash('success', 'Site setting saved successfully.');
    }

    if (isset($_POST['delete_program'])) {
        $id = (int)($_POST['delete_program'] ?? 0);
        $db->prepare('DELETE FROM programs WHERE id = :id')->execute([':id' => $id]);
        setFlash('success', 'Program deleted.');
    }

    if (isset($_POST['delete_project'])) {
        $id = (int)($_POST['delete_project'] ?? 0);
        $db->prepare('DELETE FROM projects WHERE id = :id')->execute([':id' => $id]);
        setFlash('success', 'Project deleted.');
    }

    if (isset($_POST['delete_message'])) {
        $id = (int)($_POST['delete_message'] ?? 0);
        $db->prepare('DELETE FROM contact_messages WHERE id = :id')->execute([':id' => $id]);
        setFlash('success', 'Message deleted.');
    }

    header('Location: ' . BASE_URL . '/admin/?tab=' . urlencode($tab));
    exit;
}

$stats = [
    'projects' => (int) $db->query('SELECT COUNT(*) FROM projects')->fetchColumn(),
    'active_projects' => (int) $db->query("SELECT COUNT(*) FROM projects WHERE status = 'Ongoing'")->fetchColumn(),
    'completed_projects' => (int) $db->query("SELECT COUNT(*) FROM projects WHERE status = 'Completed'")->fetchColumn(),
    'total_donations' => (float) $db->query('SELECT COALESCE(SUM(amount),0) FROM donations WHERE status = "Successful"')->fetchColumn(),
    'volunteers' => (int) $db->query('SELECT COUNT(*) FROM volunteers')->fetchColumn(),
    'stories' => (int) $db->query('SELECT COUNT(*) FROM stories')->fetchColumn(),
    'gallery_items' => (int) $db->query('SELECT COUNT(*) FROM gallery')->fetchColumn(),
    'messages' => (int) $db->query('SELECT COUNT(*) FROM contact_messages')->fetchColumn(),
];

$programs = $db->query('SELECT * FROM programs ORDER BY id DESC LIMIT 10')->fetchAll();
$projects = $db->query('SELECT * FROM projects ORDER BY id DESC LIMIT 10')->fetchAll();
$metrics = $db->query('SELECT * FROM impact_metrics ORDER BY id')->fetchAll();
$messages = $db->query('SELECT * FROM contact_messages ORDER BY id DESC LIMIT 10')->fetchAll();
$volunteers = $db->query('SELECT * FROM volunteers ORDER BY id DESC LIMIT 10')->fetchAll();
$donations = $db->query('SELECT * FROM donations ORDER BY id DESC LIMIT 10')->fetchAll();
$settings = $db->query('SELECT * FROM site_settings ORDER BY setting_key')->fetchAll();
$flash = getFlash();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AVSA Admin Dashboard</title>
    <link rel="stylesheet" href="<?= e(BASE_URL) ?>/public/assets/css/style.css">
    <style>
        body { background: #f5f7f6; margin: 0; }
        .admin-shell { padding: 32px 18px 80px; }
        .admin-layout { display: grid; grid-template-columns: 250px 1fr; gap: 24px; }
        .admin-sidebar { background: #08275f; color: white; padding: 18px; border-radius: 20px; min-height: 620px; }
        .admin-logo { width: 210px; max-width: 100%; margin: 0 auto 24px; filter: brightness(0) invert(1); }
        .admin-sidebar a { color: white; display: block; padding: 12px 10px; border-radius: 10px; text-decoration: none; }
        .admin-sidebar a:hover { background: rgba(255,255,255,.08); }
        .admin-main { background: white; border-radius: 24px; padding: 24px; box-shadow: 0 12px 30px rgba(0,0,0,.06); }
        .stats-grid { display: grid; grid-template-columns: repeat(4, minmax(0,1fr)); gap: 18px; margin: 24px 0; }
        .admin-stat { background: #eaf5e9; border-radius: 16px; padding: 18px; }
        .admin-stat strong { display: block; font-size: 1.8rem; color: #103875; }
        .admin-table { width: 100%; border-collapse: collapse; margin-top: 18px; }
        .admin-table th, .admin-table td { padding: 12px; border-bottom: 1px solid #edf1f3; text-align: left; }
        .panel { background: #fff; border: 1px solid #ebeff0; border-radius: 18px; padding: 22px; margin-top: 20px; }
        .form-grid { display: grid; grid-template-columns: repeat(2, minmax(0,1fr)); gap: 16px; }
        .form-grid label { display: grid; gap: 8px; font-weight: 600; }
        .form-grid input, .form-grid textarea, .form-grid select { width: 100%; padding: 10px 12px; border: 1px solid #dfe5e7; border-radius: 10px; }
        .btn { display: inline-block; border: none; padding: 12px 18px; border-radius: 999px; background: #103875; color: white; cursor: pointer; }
        .btn-secondary { background: #176b32; color: white; }
        .btn-danger { background: #a13d3d; color: white; }
        .flash { padding: 12px 16px; border-radius: 12px; margin-bottom: 18px; }
        .flash.success { background: #eaf7ee; color: #14582d; }
        .flash.error { background: #fdecec; color: #8c2e2e; }
        @media (max-width: 900px) {
            .admin-layout { grid-template-columns: 1fr; }
            .stats-grid, .form-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
    <div class="admin-shell">
        <div class="admin-layout">
            <aside class="admin-sidebar">
                <img class="admin-logo" src="<?= e(BASE_URL) ?>/public/assets/images/avsa-logo.svg" alt="AVSA - Africa Vulnerable Support Agency">
                <a href="<?= e(BASE_URL) ?>/admin/?tab=overview">Overview</a>
                <a href="<?= e(BASE_URL) ?>/admin/?tab=programs">Programs</a>
                <a href="<?= e(BASE_URL) ?>/admin/?tab=projects">Projects</a>
                <a href="<?= e(BASE_URL) ?>/admin/?tab=impact">Impact</a>
                <a href="<?= e(BASE_URL) ?>/admin/?tab=volunteers">Volunteers</a>
                <a href="<?= e(BASE_URL) ?>/admin/?tab=messages">Messages</a>
                <a href="<?= e(BASE_URL) ?>/admin/?tab=settings">Settings</a>
                <a href="<?= e(BASE_URL) ?>/?page=home">Exit to site</a>
                <a href="<?= e(BASE_URL) ?>/admin/logout.php">Logout</a>
            </aside>
            <main class="admin-main">
                <?php if ($flash): ?>
                    <div class="flash <?= e($flash['type']) ?>"><?= e($flash['message']) ?></div>
                <?php endif; ?>

                <?php if ($tab === 'overview' || $tab === 'dashboard'): ?>
                    <h1>Welcome to the AVSA Admin Dashboard</h1>
                    <div class="stats-grid">
                        <div class="admin-stat"><span>Total Projects</span><strong><?= (int)$stats['projects'] ?></strong></div>
                        <div class="admin-stat"><span>Active Projects</span><strong><?= (int)$stats['active_projects'] ?></strong></div>
                        <div class="admin-stat"><span>Completed Projects</span><strong><?= (int)$stats['completed_projects'] ?></strong></div>
                        <div class="admin-stat"><span>Total Donations</span><strong>$<?= number_format((float)$stats['total_donations'], 2) ?></strong></div>
                        <div class="admin-stat"><span>Volunteers</span><strong><?= (int)$stats['volunteers'] ?></strong></div>
                        <div class="admin-stat"><span>Stories</span><strong><?= (int)$stats['stories'] ?></strong></div>
                        <div class="admin-stat"><span>Gallery Items</span><strong><?= (int)$stats['gallery_items'] ?></strong></div>
                        <div class="admin-stat"><span>Messages</span><strong><?= (int)$stats['messages'] ?></strong></div>
                    </div>
                <?php endif; ?>

                <?php if ($tab === 'programs'): ?>
                    <h2>Programs</h2>
                    <div class="panel">
                        <h3>Add a Program</h3>
                        <form method="POST" class="form-grid">
                            <input type="hidden" name="save_program" value="1">
                            <label>Title<input type="text" name="title" required></label>
                            <label>Icon<input type="text" name="icon" value="fa-heart"></label>
                            <label>Image URL<input type="text" name="image" placeholder="https://..."></label>
                            <label>Status<select name="status"><option value="published">Published</option><option value="draft">Draft</option></select></label>
                            <label style="grid-column: 1 / -1;">Description<textarea name="description" rows="4" required></textarea></label>
                            <label style="grid-column: 1 / -1;">Objectives<textarea name="objectives" rows="3"></textarea></label>
                            <label style="grid-column: 1 / -1;">Activities<textarea name="activities" rows="3"></textarea></label>
                            <label style="grid-column: 1 / -1;">Target beneficiaries<textarea name="target_beneficiaries" rows="2"></textarea></label>
                            <label style="grid-column: 1 / -1;">Results<textarea name="results" rows="2"></textarea></label>
                            <button type="submit" class="btn">Save Program</button>
                        </form>
                    </div>

                    <div class="panel">
                        <h3>Existing Programs</h3>
                        <table class="admin-table">
                            <thead><tr><th>Title</th><th>Status</th><th>Actions</th></tr></thead>
                            <tbody>
                                <?php foreach ($programs as $program): ?>
                                    <tr>
                                        <td><?= e($program['title']) ?></td>
                                        <td><?= e($program['status']) ?></td>
                                        <td>
                                            <form method="POST" style="display:inline;">
                                                <input type="hidden" name="delete_program" value="<?= (int)$program['id'] ?>">
                                                <button type="submit" class="btn btn-danger">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>

                <?php if ($tab === 'projects'): ?>
                    <h2>Projects</h2>
                    <div class="panel">
                        <h3>Create Project</h3>
                        <form method="POST" class="form-grid">
                            <input type="hidden" name="save_project" value="1">
                            <label>Project Title<input type="text" name="title" required></label>
                            <label>Category<input type="text" name="category" required></label>
                            <label>Location<input type="text" name="location" required></label>
                            <label>Country<input type="text" name="country" value="Rwanda"></label>
                            <label>Start Date<input type="date" name="start_date"></label>
                            <label>End Date<input type="date" name="end_date"></label>
                            <label>Status<select name="status"><option>Ongoing</option><option>Upcoming</option><option>Completed</option></select></label>
                            <label>Progress %<input type="number" name="progress_percentage" min="0" max="100" value="0"></label>
                            <label>Image URL<input type="text" name="image" placeholder="https://..."></label>
                            <label>Budget<input type="number" step="0.01" name="budget" value="0"></label>
                            <label>Funding Source<input type="text" name="funding_source"></label>
                            <label style="grid-column: 1 / -1;">Description<textarea name="description" rows="4" required></textarea></label>
                            <label style="grid-column: 1 / -1;">Objectives<textarea name="objectives" rows="3"></textarea></label>
                            <label style="grid-column: 1 / -1;">Target beneficiaries<textarea name="target_beneficiaries" rows="2"></textarea></label>
                            <button type="submit" class="btn">Save Project</button>
                        </form>
                    </div>

                    <div class="panel">
                        <h3>Existing Projects</h3>
                        <table class="admin-table">
                            <thead><tr><th>Title</th><th>Status</th><th>Country</th><th>Action</th></tr></thead>
                            <tbody>
                                <?php foreach ($projects as $project): ?>
                                    <tr>
                                        <td><?= e($project['title']) ?></td>
                                        <td><?= e($project['status']) ?></td>
                                        <td><?= e($project['country']) ?></td>
                                        <td>
                                            <form method="POST" style="display:inline;">
                                                <input type="hidden" name="delete_project" value="<?= (int)$project['id'] ?>">
                                                <button type="submit" class="btn btn-danger">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>

                <?php if ($tab === 'impact'): ?>
                    <h2>Impact Statistics</h2>
                    <div class="panel">
                        <h3>Update impact numbers</h3>
                        <form method="POST" class="form-grid">
                            <input type="hidden" name="save_metric" value="1">
                            <label>Key<input type="text" name="metric_key" required></label>
                            <label>Label<input type="text" name="metric_label" required></label>
                            <label>Value<input type="text" name="value" required></label>
                            <label style="grid-column: 1 / -1;">Description<textarea name="description" rows="3"></textarea></label>
                            <button type="submit" class="btn">Save Metric</button>
                        </form>
                    </div>

                    <div class="panel">
                        <table class="admin-table">
                            <thead><tr><th>Key</th><th>Label</th><th>Value</th></tr></thead>
                            <tbody>
                                <?php foreach ($metrics as $metric): ?>
                                    <tr>
                                        <td><?= e($metric['metric_key']) ?></td>
                                        <td><?= e($metric['metric_label']) ?></td>
                                        <td><?= e($metric['value']) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>

                <?php if ($tab === 'volunteers'): ?>
                    <h2>Volunteers</h2>
                    <div class="panel">
                        <table class="admin-table">
                            <thead><tr><th>Name</th><th>Email</th><th>Country</th><th>Area</th></tr></thead>
                            <tbody>
                                <?php foreach ($volunteers as $item): ?>
                                    <tr>
                                        <td><?= e($item['full_name']) ?></td>
                                        <td><?= e($item['email']) ?></td>
                                        <td><?= e($item['country']) ?></td>
                                        <td><?= e($item['area_of_interest']) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>

                <?php if ($tab === 'messages'): ?>
                    <h2>Contact Messages</h2>
                    <div class="panel">
                        <table class="admin-table">
                            <thead><tr><th>Name</th><th>Email</th><th>Subject</th><th>Action</th></tr></thead>
                            <tbody>
                                <?php foreach ($messages as $message): ?>
                                    <tr>
                                        <td><?= e($message['name']) ?></td>
                                        <td><?= e($message['email']) ?></td>
                                        <td><?= e($message['subject']) ?></td>
                                        <td>
                                            <form method="POST" style="display:inline;">
                                                <input type="hidden" name="delete_message" value="<?= (int)$message['id'] ?>">
                                                <button type="submit" class="btn btn-danger">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>

                <?php if ($tab === 'settings'): ?>
                    <h2>Website Settings</h2>
                    <div class="panel">
                        <form method="POST" class="form-grid">
                            <input type="hidden" name="save_setting" value="1">
                            <label>Setting key<input type="text" name="setting_key" required></label>
                            <label>Setting value<input type="text" name="setting_value" required></label>
                            <label style="grid-column: 1 / -1;">Description<textarea name="description" rows="3"></textarea></label>
                            <button type="submit" class="btn">Save Setting</button>
                        </form>
                    </div>

                    <div class="panel">
                        <table class="admin-table">
                            <thead><tr><th>Key</th><th>Value</th></tr></thead>
                            <tbody>
                                <?php foreach ($settings as $setting): ?>
                                    <tr>
                                        <td><?= e($setting['setting_key']) ?></td>
                                        <td><?= e($setting['setting_value']) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </main>
        </div>
    </div>
</body>
</html>
