<?php
require_once __DIR__ . '/includes/auth_solski.php';
require_role_solski('ucenec');
$user = current_user_solski();

global $pdo_solski;

$stmt = $pdo_solski->prepare(
    'SELECT p.id, p.naziv, p.opis, p.kratica
     FROM ucenci_predmeti up
     JOIN predmeti p ON p.id = up.predmet_id
     WHERE up.ucenec_id = ? AND p.aktiven = 1
     ORDER BY p.naziv'
);
$stmt->execute([$user['id']]);
$predmeti = $stmt->fetchAll();
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

        <h1 class="dashboard-title">Moji predmeti</h1>
<div class="dashboard-grid" style="display:flex;justify-content:center;gap:20px;flex-wrap:wrap;">
    <?php if ($predmeti): ?>
        <?php foreach ($predmeti as $p): ?>
            <div class="dashboard-card" style="width:250px;">
                <div style="margin-bottom:8px;font-weight:700;color:#2c3e50;">
                    <?= $p['naziv'] ?><?= $p['kratica'] ? ' ('.$p['kratica'].')' : '' ?>
                </div>
                <?php if ($p['opis']): ?>
                    <div style="color:#666;margin-bottom:10px;"><?= nl2br($p['opis']) ?></div>
                <?php endif; ?>
                <div style="display:flex;gap:12px;">
                    <a href="solski_ucenec_gradiva.php?predmet_id=<?= (int)$p['id'] ?>">Gradiva</a>
                    <a href="solski_ucenec_naloge.php?predmet_id=<?= (int)$p['id'] ?>">Moje naloge</a>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="dashboard-card" style="width:250px;">Nimate dodeljenih predmetov.</div>
    <?php endif; ?>
</div>
    </div>
</body>
</html>


