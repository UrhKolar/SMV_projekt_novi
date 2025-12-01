<?php
require_once __DIR__ . '/includes/auth_solski.php';
require_role_solski('ucitelj');
$user = current_user_solski();

global $pdo_solski;

// Load teacher's subjects
$stmtP = $pdo_solski->prepare('SELECT p.id, p.naziv FROM ucitelji_predmeti up JOIN predmeti p ON p.id=up.predmet_id WHERE up.ucitelj_id=? ORDER BY p.naziv');
$stmtP->execute([$user['id']]);
$predmeti = $stmtP->fetchAll();
$predmetId = isset($_GET['predmet_id']) ? (int)$_GET['predmet_id'] : (isset($predmeti[0]['id']) ? (int)$predmeti[0]['id'] : 0);

$action = $_POST['action'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $predmetId) {
    if ($action === 'upload') {
        $naslov = trim($_POST['naslov'] ?? '');
        $opis = trim($_POST['opis'] ?? '');
        $filename = null;
        $uploadsDir = __DIR__ . '/uploads';
        if (!is_dir($uploadsDir)) { @mkdir($uploadsDir, 0777, true); }
        if (!empty($_FILES['datoteka']['name'])) {
            $safe = time() . '_' . preg_replace('/[^A-Za-z0-9_\.-]/', '_', basename($_FILES['datoteka']['name']));
            if (move_uploaded_file($_FILES['datoteka']['tmp_name'], $uploadsDir . '/' . $safe)) { $filename = $safe; }
        }
        $stmt = $pdo_solski->prepare('INSERT INTO gradiva (predmet_id, ucitelj_id, naslov, opis, datoteka) VALUES (?, ?, ?, ?, ?)');
        $stmt->execute([$predmetId, $user['id'], $naslov, $opis, $filename]);
    } elseif ($action === 'delete') {
        $id = (int)($_POST['id'] ?? 0);
        if ($id) {
            $g = $pdo_solski->prepare('SELECT datoteka FROM gradiva WHERE id=? AND ucitelj_id=?');
            $g->execute([$id, $user['id']]);
            if ($row = $g->fetch()) {
                $pdo_solski->prepare('DELETE FROM gradiva WHERE id=?')->execute([$id]);
                if (!empty($row['datoteka'])) { @unlink(__DIR__ . '/uploads/' . $row['datoteka']); }
                // deleted
            }
        }
    }
}

// Load materials for selected subject
$stmt = $pdo_solski->prepare('SELECT id, naslov, opis, datoteka, datum_nalaganja FROM gradiva WHERE predmet_id=? AND ucitelj_id=? ORDER BY datum_nalaganja DESC');
$stmt->execute([$predmetId, $user['id']]);
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
            <strong><?= $user['prikazno_ime'] ?? ($user['ime'] . ' ' . $user['priimek']) ?> (<?= $user['tip_uporabnika'] ?>)</strong>
            <a href="solski_logout.php">Odjava</a>
        </div>

        <h1 class="dashboard-title" style="color: #ffffff; text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);">Moja gradiva</h1>

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

            <div class="dashboard-card" style="border-radius: 20px; background: rgba(255, 255, 255, 0.6); backdrop-filter: blur(10px); -webkit-backdrop-filter: blur(10px);">
                <form method="post" enctype="multipart/form-data">
                    <input type="hidden" name="action" value="upload" />
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
                        <textarea name="opis" rows="3"></textarea>
                    </div>
                    <div>
                        <button class="btn btn-primary" type="submit">Naloži gradivo</button>
                    </div>
                </form>
            </div>
        <?php else: ?>
            <div class="dashboard-card" style="border-radius: 20px; background: rgba(255, 255, 255, 0.6); backdrop-filter: blur(10px); -webkit-backdrop-filter: blur(10px);">Nimate dodeljenih predmetov.</div>
        <?php endif; ?>

        <div class="dashboard-grid">
            <?php foreach ($gradiva as $g): ?>
                <div class="dashboard-card" style="border-radius: 20px; background: rgba(255, 255, 255, 0.6); backdrop-filter: blur(10px); -webkit-backdrop-filter: blur(10px);">
                    <div><?= $g['naslov'] ?></div>
                    <?php if ($g['opis']): ?><div><?= nl2br($g['opis']) ?></div><?php endif; ?>
                    <?php if ($g['datoteka']): ?><a href="uploads/<?= rawurlencode($g['datoteka']) ?>" target="_blank">Prenesi datoteko</a><?php endif; ?>
                    <div>Naloženo: <?= $g['datum_nalaganja'] ?></div>
                    <form method="post">
                        <input type="hidden" name="action" value="delete" />
                        <input type="hidden" name="id" value="<?= (int)$g['id'] ?>" />
                        <button class="btn">Izbriši</button>
                    </form>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>


