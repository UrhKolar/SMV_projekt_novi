<?php
require_once __DIR__ . '/includes/auth_solski.php';
require_role_solski('ucitelj');
$user = current_user_solski();

global $pdo_solski;

// Teacher subjects
$stmtP = $pdo_solski->prepare('SELECT p.id, p.naziv FROM ucitelji_predmeti up JOIN predmeti p ON p.id=up.predmet_id WHERE up.ucitelj_id=? ORDER BY p.naziv');
$stmtP->execute([$user['id']]);
$predmeti = $stmtP->fetchAll();
$predmetId = isset($_GET['predmet_id']) ? (int)$_GET['predmet_id'] : (isset($predmeti[0]['id']) ? (int)$predmeti[0]['id'] : 0);

// Load submissions for selected subject
$stmt = $pdo_solski->prepare('SELECT n.id, n.naslov, n.opis, n.datoteka, n.datum_oddaje, n.ocena, n.komentar, u.ime, u.priimek FROM naloge n JOIN ucenci_predmeti sp ON sp.ucenec_id = n.ucenec_id AND sp.predmet_id = n.predmet_id JOIN uporabniki u ON u.id=n.ucenec_id WHERE n.predmet_id=? ORDER BY n.datum_oddaje DESC');
$stmt->execute([$predmetId]);
$oddaje = $stmt->fetchAll();

// Handle grading
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['oceni_id'])) {
    $nid = (int)$_POST['oceni_id'];
    $ocena = trim($_POST['ocena'] ?? '');
    $komentar = trim($_POST['komentar'] ?? '');
    $o = $pdo_solski->prepare('UPDATE naloge SET ocena=?, komentar=? WHERE id=?');
    $o->execute([$ocena !== '' ? (int)$ocena : null, $komentar !== '' ? $komentar : null, $nid]);
    header('Location: solski_ucitelj_naloge.php?predmet_id=' . $predmetId);
    exit;
}
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

        <h1 class="dashboard-title">Oddane naloge</h1>

        <?php if ($predmeti): ?>
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
        <?php else: ?>
            <div class="dashboard-card">Nimate dodeljenih predmetov.</div>
        <?php endif; ?>

        <div class="dashboard-grid">
            <?php foreach ($oddaje as $n): ?>
                <div class="dashboard-card">
                    <div style="font-weight:700;color:#2c3e50;margin-bottom:8px;">
                        <?= $n['priimek'] . ' ' . $n['ime'] ?> — <?= $n['naslov'] ?>
                    </div>
                    <?php if ($n['opis']): ?><div style="color:#666;margin-bottom:10px;">Opis: <?= nl2br($n['opis']) ?></div><?php endif; ?>
                    <?php if ($n['datoteka']): ?><a href="uploads/<?= rawurlencode($n['datoteka']) ?>" target="_blank">Prenesi datoteko</a><?php endif; ?>
                    <div style="color:#999;margin-top:10px;font-size:0.9rem;">Oddano: <?= $n['datum_oddaje'] ?></div>

                    <form method="post" style="margin-top:10px;display:grid;gap:8px;grid-template-columns:120px 1fr;align-items:center;">
                        <input type="hidden" name="oceni_id" value="<?= (int)$n['id'] ?>" />
                        <label>Ocena</label>
                        <input type="number" name="ocena" min="1" max="5" value="<?= (string)$n['ocena'] ?>" />
                        <label style="grid-column:1/-1;">Komentar</label>
                        <textarea name="komentar" rows="3" style="grid-column:1/-1;width:100%;"><?= (string)$n['komentar'] ?></textarea>
                        <div style="grid-column:1/-1;">
                            <button class="btn btn-primary" type="submit">Shrani oceno</button>
                        </div>
                    </form>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>


