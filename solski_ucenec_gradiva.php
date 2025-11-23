<?php
require_once __DIR__ . '/includes/auth_solski.php';
$user = current_user_solski();
if (!$user) {
    header('Location: index.php');
    exit;
}
require_role_solski('ucenec');

global $pdo_solski;

$predmetId = isset($_GET['predmet_id']) ? (int)$_GET['predmet_id'] : null;

// Load student's subjects for navigation
$stmtP = $pdo_solski->prepare(
    'SELECT p.id, p.naziv FROM ucenci_predmeti up JOIN predmeti p ON p.id = up.predmet_id WHERE up.ucenec_id = ? ORDER BY p.naziv'
);
$stmtP->execute([$user['id']]);
$predmeti = $stmtP->fetchAll();

if (!$predmetId && $predmeti) {
    $predmetId = (int)$predmeti[0]['id'];
}

$stmt = $pdo_solski->prepare(
    'SELECT g.id, g.naslov, g.opis, g.datoteka, g.datum_nalaganja, p.naziv
     FROM gradiva g JOIN predmeti p ON p.id = g.predmet_id
     WHERE g.predmet_id = ?
     ORDER BY g.datum_nalaganja DESC'
);
$stmt->execute([$predmetId]);
$gradiva = $stmt->fetchAll();
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
            <strong><?= $user['ime'] . ' ' . $user['priimek']; ?> (<?= $user['tip_uporabnika']; ?>)</strong>
            <a href="solski_logout.php">Odjava</a>
        </div>

        <h1 class="dashboard-title">Gradiva</h1>

        <div class="dashboard-card" style="margin-bottom:16px;">
            <form method="get" style="display:flex;gap:12px;align-items:center;">
                <label for="predmet_id">Predmet:</label>
                <select id="predmet_id" name="predmet_id" onchange="this.form.submit()">
                    <?php foreach ($predmeti as $p): ?>
                        <option value="<?= (int)$p['id'] ?>" <?= $predmetId===(int)$p['id']?'selected':'' ?>><?= $p['naziv'] ?></option>
                    <?php endforeach; ?>
                </select>
            </form>
        </div>

        <div class="dashboard-grid">
            <?php if ($gradiva): ?>
                <?php foreach ($gradiva as $g): ?>
                    <div class="dashboard-card">
                        <div style="font-weight:700;color:#2c3e50;margin-bottom:8px;"><?= $g['naslov'] ?></div>
                        <?php if ($g['opis']): ?>
                            <div style="color:#666;margin-bottom:10px;"><?= nl2br($g['opis']) ?></div>
                        <?php endif; ?>
                        <?php if ($g['datoteka']): ?>
                            <a href="uploads/<?= rawurlencode($g['datoteka']) ?>" target="_blank">Prenesi datoteko</a>
                        <?php endif; ?>
                        <div style="color:#999;margin-top:10px;font-size:0.9rem;">Naloženo: <?= $g['datum_nalaganja'] ?></div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="dashboard-card">Za izbrani predmet ni gradiv.</div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>


