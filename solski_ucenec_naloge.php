<?php
require_once __DIR__ . '/includes/auth_solski.php';
require_role_solski('ucenec');
$user = current_user_solski();

global $pdo_solski;

$stmtP = $pdo_solski->prepare('SELECT p.id, p.naziv FROM ucenci_predmeti up JOIN predmeti p ON p.id = up.predmet_id WHERE up.ucenec_id = ? ORDER BY p.naziv');
$stmtP->execute([$user['id']]);
$predmeti = $stmtP->fetchAll();
$predmetId = (int)($_GET['predmet_id'] ?? ($predmeti[0]['id'] ?? 0));

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['predmet_id'])) {
    $predmetId = (int)$_POST['predmet_id'];
    $naslov = trim($_POST['naslov'] ?? '');
    $opis = trim($_POST['opis'] ?? '');
    $filename = null;
    
    $uploadsDir = __DIR__ . '/uploads';
    if (!is_dir($uploadsDir)) { @mkdir($uploadsDir, 0777, true); }
    
    if (!empty($_FILES['datoteka']['name'])) {
        $ext = pathinfo($_FILES['datoteka']['name'], PATHINFO_EXTENSION);
        $safe = time() . '_' . preg_replace('/[^A-Za-z0-9_\.-]/', '_', basename($_FILES['datoteka']['name']));
        if (move_uploaded_file($_FILES['datoteka']['tmp_name'], $uploadsDir . '/' . $safe)) {
            $filename = $safe;
        }
    }
    
    $stmtIns = $pdo_solski->prepare('INSERT INTO naloge (predmet_id, ucenec_id, naslov, opis, datoteka) VALUES (?, ?, ?, ?, ?)');
    $stmtIns->execute([$predmetId, $user['id'], $naslov, $opis, $filename]);
}

$stmt = $pdo_solski->prepare('SELECT n.id, n.naslov, n.opis, n.datoteka, n.datum_oddaje, n.ocena, n.komentar FROM naloge n WHERE n.ucenec_id = ? AND n.predmet_id = ? ORDER BY n.datum_oddaje DESC');
$stmt->execute([$user['id'], $predmetId]);
$naloge = $stmt->fetchAll();
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

        <h1 class="dashboard-title">Oddaja nalog</h1>

        <?php if ($predmeti): ?>
            <div class="dashboard-card" style="border-radius: 20px; background: rgba(255, 255, 255, 0.6); backdrop-filter: blur(10px); -webkit-backdrop-filter: blur(10px);">
                <form method="get">
                    <label for="predmet_id">Predmet</label>
                    <select id="predmet_id" name="predmet_id" onchange="this.form.submit()">
                        <?php foreach ($predmeti as $p): ?>
                            <option value="<?= (int)$p['id'] ?>" <?= $predmetId===(int)$p['id']?'selected':'' ?>><?= $p['naziv'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </form>
            </div>

            <?php if ($predmetId): ?>
            <div class="dashboard-card" style="border-radius: 20px; background: rgba(255, 255, 255, 0.6); backdrop-filter: blur(10px); -webkit-backdrop-filter: blur(10px);">
                <form method="post" enctype="multipart/form-data">
                    <input type="hidden" name="predmet_id" value="<?= (int)$predmetId ?>" />
                    <div>
                        <label>Naslov</label>
                        <input type="text" name="naslov" required />
                    </div>
                    <div>
                        <label>Datoteka</label>
                        <input type="file" name="datoteka" />
                    </div>
                    <div>
                        <label>Opis</label>
                        <textarea name="opis" rows="4"></textarea>
                    </div>
                    <div>
                        <button class="btn btn-primary" type="submit">Oddaj nalogo</button>
                    </div>
                </form>
            </div>
            <?php endif; ?>
        <?php endif; ?>

        <h2 class="dashboard-title">Moje oddaje</h2>
        <div class="dashboard-grid">
            <?php if ($naloge): ?>
                <?php foreach ($naloge as $n): ?>
                    <div class="dashboard-card" style="border-radius: 20px; background: rgba(255, 255, 255, 0.6); backdrop-filter: blur(10px); -webkit-backdrop-filter: blur(10px);">
                        <div><?= $n['naslov'] ?></div>
                        <?php if ($n['opis']): ?><div><?= nl2br($n['opis']) ?></div><?php endif; ?>
                        <?php if ($n['datoteka']): ?><a href="uploads/<?= rawurlencode($n['datoteka']) ?>" target="_blank">Prenesi datoteko</a><?php endif; ?>
                        <div>Oddano: <?= $n['datum_oddaje'] ?></div>
                        <?php if ($n['ocena'] !== null): ?><div>Ocena: <strong><?= (int)$n['ocena'] ?></strong></div><?php endif; ?>
                        <?php if ($n['komentar']): ?><div>Komentar: <?= nl2br($n['komentar']) ?></div><?php endif; ?>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="dashboard-card" style="border-radius: 20px; background: rgba(255, 255, 255, 0.6); backdrop-filter: blur(10px); -webkit-backdrop-filter: blur(10px);">Ni oddanih nalog.</div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>


