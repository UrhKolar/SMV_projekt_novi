<?php
require_once __DIR__ . '/includes/auth_solski.php';
$user = current_user_solski();
if (!$user) {
    header('Location: index.php');
    exit;
}
require_role_solski('admin');

global $pdo_solski;

$message = '';
$action = $_POST['action'] ?? '';
$roleTab = $_GET['role'] ?? $_POST['role'] ?? 'ucitelj';
if (!in_array($roleTab, ['ucitelj','ucenec'], true)) { $roleTab = 'ucitelj'; }

// Dynamic CSS include (same approach as login/register)
$basePath = rtrim(dirname($_SERVER['SCRIPT_NAME'] ?? ''), '/\\');
$cssFile = __DIR__ . '/css/style.css';
$cssVersion = is_file($cssFile) ? (string)filemtime($cssFile) : '1';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($action === 'create') {
        $ime = trim($_POST['ime'] ?? '');
        $priimek = trim($_POST['priimek'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $uporabnisko_ime = trim($_POST['uporabnisko_ime'] ?? '');
        $password = trim($_POST['password'] ?? '');
        if ($ime && $priimek && $email && $uporabnisko_ime && $password) {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo_solski->prepare('INSERT INTO uporabniki (uporabnisko_ime, email, geslo, tip_uporabnika, ime, priimek, aktiven) VALUES (?, ?, ?, ?, ?, ?, 1)');
            try {
                $stmt->execute([$uporabnisko_ime, $email, $hash, $roleTab, $ime, $priimek]);
                $message = ucfirst($roleTab) . ' dodan.';
            } catch (Throwable $e) {
                $message = 'Napaka: email ali uporabniško ime že obstaja.';
            }
        }
    } elseif ($action === 'update') {
        $id = (int)($_POST['id'] ?? 0);
        $ime = trim($_POST['ime'] ?? '');
        $priimek = trim($_POST['priimek'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $uporabnisko_ime = trim($_POST['uporabnisko_ime'] ?? '');
        $password = trim($_POST['password'] ?? '');
        $aktiven = isset($_POST['aktiven']) ? 1 : 0;
        if ($id && $ime && $priimek && $email && $uporabnisko_ime) {
            if ($password !== '') {
                $hash = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $pdo_solski->prepare('UPDATE uporabniki SET ime=?, priimek=?, email=?, uporabnisko_ime=?, geslo=?, aktiven=? WHERE id=? AND tip_uporabnika=?');
                $stmt->execute([$ime, $priimek, $email, $uporabnisko_ime, $hash, $aktiven, $id, $roleTab]);
            } else {
                $stmt = $pdo_solski->prepare('UPDATE uporabniki SET ime=?, priimek=?, email=?, uporabnisko_ime=?, aktiven=? WHERE id=? AND tip_uporabnika=?');
                $stmt->execute([$ime, $priimek, $email, $uporabnisko_ime, $aktiven, $id, $roleTab]);
            }
            $message = ucfirst($roleTab) . ' posodobljen.';
        }
    } elseif ($action === 'delete') {
        $id = (int)($_POST['id'] ?? 0);
        if ($id) {
            $stmt = $pdo_solski->prepare('DELETE FROM uporabniki WHERE id=? AND tip_uporabnika=?');
            $stmt->execute([$id, $roleTab]);
            $message = ucfirst($roleTab) . ' izbrisan.';
        }
    }
}

$stmt = $pdo_solski->prepare('SELECT id, ime, priimek, email, uporabnisko_ime, aktiven FROM uporabniki WHERE tip_uporabnika=? ORDER BY priimek, ime');
$stmt->execute([$roleTab]);
$users = $stmt->fetchAll();
?>

<html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="dashboard-wrap">
		<div class="dashboard-nav">
			<div style="display:flex;align-items:center;gap:10px;">
				<a class="btn btn-outline" href="solski_dashboard.php">← Nazaj</a>
				<strong><?= $user['ime'] . ' ' . $user['priimek'] ?> (<?= $user['tip_uporabnika'] ?>)</strong>
			</div>
			<div>
				<a href="solski_logout.php">Odjava</a>
			</div>
		</div>

        <h1 class="dashboard-title">Urejanje uporabnikov</h1>

        <div class="dashboard-card" style="margin-bottom:16px;">
            <div class="tabs">
                <a class="<?= $roleTab==='ucitelj'?'active':'' ?>" href="?role=ucitelj">Učitelji</a>
                <a class="<?= $roleTab==='ucenec'?'active':'' ?>" href="?role=ucenec">Učenci</a>
            </div>
        </div>

        <?php if ($message): ?>
            <div class="alert alert-success"><?= $message ?></div>
        <?php endif; ?>

        <div class="dashboard-card" style="margin-bottom:16px;">
            <form method="post" class="form-grid grid-6">
                <input type="hidden" name="action" value="create" />
                <input type="hidden" name="role" value="<?= $roleTab ?>" />
                <div class="field">
                    <label class="form-label">Ime</label>
                    <input type="text" name="ime" required />
                </div>
                <div class="field">
                    <label class="form-label">Priimek</label>
                    <input type="text" name="priimek" required />
                </div>
                <div class="field">
                    <label class="form-label">Uporabniško ime</label>
                    <input type="text" name="uporabnisko_ime" required />
                </div>
                <div class="field col-span-2">
                    <label class="form-label">Geslo</label>
                    <input type="password" name="password" required />
                </div>
                <div class="field col-span-full">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" required />
                </div>
                <div class="actions-row">
                    <button class="btn btn-primary" type="submit">Dodaj <?= $roleTab==='ucitelj'?'učitelja':'učenca' ?></button>
                </div>
            </form>
        </div>

        <div class="dashboard-grid users-grid">
            <?php foreach ($users as $u): ?>
                <div class="dashboard-card user-card">
                    <form method="post" class="form-grid grid-3">
                        <input type="hidden" name="action" value="update" />
                        <input type="hidden" name="role" value="<?= $roleTab ?>" />
                        <input type="hidden" name="id" value="<?= (int)$u['id'] ?>" />
                        <div class="field">
                            <label class="form-label">Ime</label>
                            <input type="text" name="ime" value="<?= $u['ime'] ?>" required />
                        </div>
                        <div class="field">
                            <label class="form-label">Priimek</label>
                            <input type="text" name="priimek" value="<?= $u['priimek'] ?>" required />
                        </div>
                        <div class="field">
                            <label class="form-label">Uporabniško ime</label>
                            <input type="text" name="uporabnisko_ime" value="<?= $u['uporabnisko_ime'] ?>" required />
                        </div>
                        <div class="field col-span-2">
                            <label class="form-label">Spremeni geslo</label>
                            <input type="password" name="password" placeholder="(neobvezno)" />
                        </div>
                        <div class="field place-end">
                            <label class="checkbox">
                                <input type="checkbox" name="aktiven" <?= $u['aktiven'] ? 'checked' : '' ?> /> Aktiven
                            </label>
                        </div>
                        <div class="field col-span-full">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" value="<?= $u['email'] ?>" required />
                        </div>
                        <div class="actions-row" style="grid-column:1/-1;">
                            <button class="btn btn-primary" type="submit">Shrani</button>
                            <button class="btn btn-outline" type="submit" name="action" value="delete" onclick="return confirm('Izbrišem uporabnika?');">Izbriši</button>
                        </div>
                    </form>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>


