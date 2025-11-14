<?php
require_once __DIR__ . '/includes/auth_solski.php';
require_role_solski('admin');
$user = current_user_solski();

global $pdo_solski;

$action = $_POST['action'] ?? $_GET['action'] ?? '';
$message = '';

// Static CSS include

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($action === 'create') {
        $naziv = trim($_POST['naziv'] ?? '');
        $opis = trim($_POST['opis'] ?? '');
        $kratica = trim($_POST['kratica'] ?? '');
        if ($naziv !== '') {
            $stmt = $pdo_solski->prepare('INSERT INTO predmeti (naziv, opis, kratica, aktiven) VALUES (?, ?, ?, 1)');
            $stmt->execute([$naziv, $opis ?: null, $kratica ?: null]);
            $message = 'Predmet ustvarjen.';
        }
    } elseif ($action === 'update') {
        $id = (int)($_POST['id'] ?? 0);
        $naziv = trim($_POST['naziv'] ?? '');
        $opis = trim($_POST['opis'] ?? '');
        $kratica = trim($_POST['kratica'] ?? '');
        $aktiven = isset($_POST['aktiven']) ? 1 : 0;
        if ($id && $naziv !== '') {
            $stmt = $pdo_solski->prepare('UPDATE predmeti SET naziv=?, opis=?, kratica=?, aktiven=? WHERE id=?');
            $stmt->execute([$naziv, $opis ?: null, $kratica ?: null, $aktiven, $id]);
            $message = 'Predmet posodobljen.';
        }
    } elseif ($action === 'delete') {
        $id = (int)($_POST['id'] ?? 0);
        if ($id) {
            $stmt = $pdo_solski->prepare('DELETE FROM predmeti WHERE id=?');
            $stmt->execute([$id]);
            $message = 'Predmet izbrisan.';
        }
    }
}

// Load list
$stmt = $pdo_solski->query('SELECT id, naziv, kratica, opis, aktiven FROM predmeti ORDER BY naziv');
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

        <h1 class="dashboard-title">Urejanje predmetov</h1>

        <?php if ($message): ?>
            <div class="alert alert-success"><?= $message ?></div>
        <?php endif; ?>

        <div class="dashboard-card" style="margin-bottom:16px;">
            <form method="post" class="form-grid grid-3">
                <input type="hidden" name="action" value="create" />
                <div class="field">
                    <label class="form-label">Naziv</label>
                    <input type="text" name="naziv" required />
                </div>
                <div class="field">
                    <label class="form-label">Kratica</label>
                    <input type="text" name="kratica" />
                </div>
                <div class="field col-span-full">
                    <label class="form-label">Opis</label>
                    <input type="text" name="opis" />
                </div>
                <div class="actions-row">
                    <button class="btn btn-primary" type="submit">Dodaj predmet</button>
                </div>
            </form>
        </div>

        <div class="dashboard-grid users-grid">
            <?php foreach ($predmeti as $p): ?>
                <div class="dashboard-card user-card">
                    <form method="post" class="form-grid grid-3">
                        <input type="hidden" name="action" value="update" />
                        <input type="hidden" name="id" value="<?= (int)$p['id'] ?>" />
                        <div class="field">
                            <label class="form-label">Naziv</label>
                            <input type="text" name="naziv" value="<?= $p['naziv'] ?>" required />
                        </div>
                        <div class="field">
                            <label class="form-label">Kratica</label>
                            <input type="text" name="kratica" value="<?= (string)$p['kratica'] ?>" />
                        </div>
                        <div class="field col-span-full">
                            <label class="form-label">Opis</label>
                            <input type="text" name="opis" value="<?= (string)$p['opis'] ?>" />
                        </div>
                        <div class="field place-end">
                            <label class="checkbox">
                                <input type="checkbox" name="aktiven" <?= $p['aktiven'] ? 'checked' : '' ?> /> Aktiven
                            </label>
                        </div>
                        <div class="actions-row" style="grid-column:1/-1;">
                            <button class="btn btn-primary" type="submit">Shrani</button>
                            <button class="btn btn-outline" type="submit" formaction="" formmethod="post" name="action" value="delete" onclick="return confirm('Izbrišem predmet?');">Izbriši</button>
                        </div>
                    </form>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>


