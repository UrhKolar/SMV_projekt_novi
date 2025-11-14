<?php
require_once __DIR__ . '/includes/auth_solski.php';
require_role_solski('admin');
$user = current_user_solski();

global $pdo_solski;

$message = '';
$action = $_POST['action'] ?? '';

// Load lists
$predmeti = $pdo_solski->query('SELECT id, naziv FROM predmeti WHERE aktiven=1 ORDER BY naziv')->fetchAll();
$ucitelji = $pdo_solski->query("SELECT id, ime, priimek FROM uporabniki WHERE tip_uporabnika='ucitelj' AND aktiven=1 ORDER BY priimek, ime")->fetchAll();
$ucenci = $pdo_solski->query("SELECT id, ime, priimek FROM uporabniki WHERE tip_uporabnika='ucenec' AND aktiven=1 ORDER BY priimek, ime")->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($action === 'assign_teacher') {
        $ucitelj = (int)($_POST['ucitelj_id'] ?? 0);
        $predmet = (int)($_POST['predmet_id'] ?? 0);
        if ($ucitelj && $predmet) {
            $stmt = $pdo_solski->prepare('INSERT IGNORE INTO ucitelji_predmeti (ucitelj_id, predmet_id) VALUES (?, ?)');
            $stmt->execute([$ucitelj, $predmet]);
            $message = 'Učitelj dodeljen predmetu.';
        }
    } elseif ($action === 'remove_teacher') {
        $rid = (int)($_POST['relation_id'] ?? 0);
        if ($rid) {
            $pdo_solski->prepare('DELETE FROM ucitelji_predmeti WHERE id=?')->execute([$rid]);
            $message = 'Dodelitev učitelja odstranjena.';
        }
    } elseif ($action === 'assign_student') {
        $ucenec = (int)($_POST['ucenec_id'] ?? 0);
        $predmet = (int)($_POST['predmet_id'] ?? 0);
        if ($ucenec && $predmet) {
            $stmt = $pdo_solski->prepare('INSERT IGNORE INTO ucenci_predmeti (ucenec_id, predmet_id) VALUES (?, ?)');
            $stmt->execute([$ucenec, $predmet]);
            $message = 'Učenec dodeljen predmetu.';
        }
    } elseif ($action === 'remove_student') {
        $rid = (int)($_POST['relation_id'] ?? 0);
        if ($rid) {
            $pdo_solski->prepare('DELETE FROM ucenci_predmeti WHERE id=?')->execute([$rid]);
            $message = 'Dodelitev učenca odstranjena.';
        }
    }
}

// Current relations
$teacherMap = $pdo_solski->query('SELECT up.id, u.ime, u.priimek, p.naziv FROM ucitelji_predmeti up JOIN uporabniki u ON u.id=up.ucitelj_id JOIN predmeti p ON p.id=up.predmet_id ORDER BY p.naziv, u.priimek')->fetchAll();
$studentMap = $pdo_solski->query('SELECT sp.id, u.ime, u.priimek, p.naziv FROM ucenci_predmeti sp JOIN uporabniki u ON u.id=sp.ucenec_id JOIN predmeti p ON p.id=sp.predmet_id ORDER BY p.naziv, u.priimek')->fetchAll();
?>

<html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="dashboard-wrap">
        <div class="dashboard-nav">
        <a class="btn btn-outline" href="solski_dashboard.php">← Nazaj</a>
            <strong><?= $user['prikazno_ime'] ?? ($user['ime'] . ' ' . $user['priimek']) ?> (<?= $user['tip_uporabnika'] ?>)</strong>
             <a href="solski_logout.php">Odjava</a>
        </div>

        <h1 class="dashboard-title">Dodelitve</h1>
        <?php if ($message): ?>
            <div class="alert alert-success"><?= $message ?></div>
        <?php endif; ?>

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:16px;">
            <div class="dashboard-card">
                <h3 style="margin-bottom:8px;">Dodeli učitelja predmetu</h3>
                <form method="post" style="display:flex;gap:12px;align-items:center;flex-wrap:wrap;">
                    <input type="hidden" name="action" value="assign_teacher" />
                    <select name="ucitelj_id" required>
                        <option value="">Izberi učitelja</option>
                        <?php foreach ($ucitelji as $u): ?>
                            <option value="<?= (int)$u['id'] ?>"><?= $u['priimek'] . ' ' . $u['ime'] ?></option>
                        <?php endforeach; ?>
                    </select>
                    <select name="predmet_id" required>
                        <option value="">Izberi predmet</option>
                        <?php foreach ($predmeti as $p): ?>
                            <option value="<?= (int)$p['id'] ?>"><?= $p['naziv'] ?></option>
                        <?php endforeach; ?>
                    </select>
                    <button class="btn btn-primary" type="submit">Dodeli</button>
                </form>
            </div>

            <div class="dashboard-card">
                <h3 style="margin-bottom:8px;">Dodeli učenca predmetu</h3>
                <form method="post" style="display:flex;gap:12px;align-items:center;flex-wrap:wrap;">
                    <input type="hidden" name="action" value="assign_student" />
                    <select name="ucenec_id" required>
                        <option value="">Izberi učenca</option>
                        <?php foreach ($ucenci as $u): ?>
                            <option value="<?= (int)$u['id'] ?>"><?= $u['priimek'] . ' ' . $u['ime'] ?></option>
                        <?php endforeach; ?>
                    </select>
                    <select name="predmet_id" required>
                        <option value="">Izberi predmet</option>
                        <?php foreach ($predmeti as $p): ?>
                            <option value="<?= (int)$p['id'] ?>"><?= $p['naziv'] ?></option>
                        <?php endforeach; ?>
                    </select>
                    <button class="btn btn-primary" type="submit">Dodeli</button>
                </form>
            </div>
        </div>

        <h2 class="dashboard-title" style="margin-top:16px;">Trenutne dodelitve</h2>
        <div class="dashboard-grid">
            <div class="dashboard-card">
                <h3>Učitelji - Predmeti</h3>
                <?php foreach ($teacherMap as $r): ?>
                    <form method="post" style="display:flex;justify-content:space-between;align-items:center;border-bottom:1px solid #eee;padding:6px 0;">
                    <div><?= $r['naziv']; ?> — <?= $r['priimek'] . ' ' . $r['ime']; ?></div>
                        <div>
                            <input type="hidden" name="action" value="remove_teacher" />
                            <input type="hidden" name="relation_id" value="<?= (int)$r['id'] ?>" />
                            <button class="btn" onclick="return confirm('Odstranim dodelitev?');">Odstrani</button>
                        </div>
                    </form>
                <?php endforeach; ?>
            </div>
            <div class="dashboard-card">
                <h3>Učenci - Predmeti</h3>
                <?php foreach ($studentMap as $r): ?>
                    <form method="post" style="display:flex;justify-content:space-between;align-items:center;border-bottom:1px solid #eee;padding:6px 0;">
                    <div><?= $r['naziv']; ?> — <?= $r['priimek'] . ' ' . $r['ime']; ?></div>
                        <div>
                            <input type="hidden" name="action" value="remove_student" />
                            <input type="hidden" name="relation_id" value="<?= (int)$r['id'] ?>" />
                            <button class="btn" onclick="return confirm('Odstranim dodelitev?');">Odstrani</button>
                        </div>
                    </form>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</body>
</html>


