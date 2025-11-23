<?php
require_once __DIR__ . '/includes/auth_solski.php';

$error = '';
$success = '';
// Persisted form values
$ime = '';
$priimek = '';
$email = '';
$uporabnisko_ime = '';
// Resolve base path for assets and cache-bust CSS
$basePath = rtrim(dirname($_SERVER['SCRIPT_NAME'] ?? ''), '/\\');
$cssFile = __DIR__ . '/css/style.css';
$cssVersion = is_file($cssFile) ? (string)filemtime($cssFile) : '1';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ime = trim($_POST['ime'] ?? '');
    $priimek = trim($_POST['priimek'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $uporabnisko_ime = trim($_POST['uporabnisko_ime'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $password2 = trim($_POST['password2'] ?? '');

    if ($password !== $password2) {
        $error = 'Gesli se ne ujemata.';
    } else if (!$ime || !$priimek || !$email || !$uporabnisko_ime || !$password) {
        $error = 'Izpolnite vsa polja.';
    } else {
        if (register_student_solski($ime, $priimek, $email, $uporabnisko_ime, $password)) {
            $success = 'Registracija uspešna. Sedaj se lahko prijavite.';
        } else {
            $error = 'Registracija ni uspela. Preverite podatke.';
        }
    }
}
?>

<html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/style.css">
    </head>
<body class="auth-page">
    <div class="auth-container">
        <div class="auth-card" role="region" aria-labelledby="auth-title">
            <div class="auth-header">
                <div class="auth-brand"><span class="brand-mark">ŠS</span> Šolski sistem</div>
                <div class="auth-subtitle">Ustvarite nov račun</div>
            </div>
            <h2 id="auth-title">Registracija učenca</h2>
            <?php if ($error): ?>
                <div class="error-message"><?= $error ?></div>
            <?php endif; ?>
            <?php if ($success): ?>
                <div class="success-message"><?= $success ?></div>
            <?php endif; ?>
            <form method="post" class="auth-form" novalidate>
                <div class="form-field">
                    <label for="ime" class="form-label">Ime</label>
                    <input id="ime" class="input" type="text" name="ime" required value="<?= $ime ?>" placeholder="Ana">
                </div>
                <div class="form-field">
                    <label for="priimek" class="form-label">Priimek</label>
                    <input id="priimek" class="input" type="text" name="priimek" required value="<?= $priimek ?>" placeholder="Novak">
                </div>
                <div class="form-field">
                    <label for="email" class="form-label">Email</label>
                    <input id="email" class="input" type="email" name="email" required value="<?= $email ?>" placeholder="ime.priimek@example.com">
                </div>
                <div class="form-field">
                    <label for="uporabnisko_ime" class="form-label">Uporabniško ime</label>
                    <input id="uporabnisko_ime" class="input" type="text" name="uporabnisko_ime" required value="<?= $uporabnisko_ime ?>" placeholder="anovak">
                </div>
                <div class="form-field">
                    <label for="password" class="form-label">Geslo</label>
                    <input id="password" class="input" type="password" name="password" required placeholder="••••••••">
                </div>
                <div class="form-field">
                    <label for="password2" class="form-label">Ponovi geslo</label>
                    <input id="password2" class="input" type="password" name="password2" required placeholder="••••••••">
                </div>
                <button type="submit" class="btn-submit">Registracija</button>
            </form>
            <div class="auth-footer">
                Že imate račun? <a href="solski_login.php">Prijava</a>
            </div>
        </div>
    </div>
</body>
</html>

