<?php
require_once __DIR__ . '/includes/auth_solski.php';
$user = current_user_solski();
if (!$user) { header('Location: solski_login.php'); exit; }

$role = $user['tip_uporabnika'];
?>

<html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/style.css">
    </head>
<body>
    <div class="dashboard-wrap">
        <div class="dashboard-nav">
            <strong><?= $user['prikazno_ime'] ?? ($user['ime'] . ' ' . $user['priimek']) ?> (<?= $role ?>)</strong>
            <a href="solski_logout.php">Odjava</a>
        </div>

        <?php if ($role === 'admin'): ?>
            <h1 class="dashboard-title">Administrator</h1>
            <div class="dashboard-grid">
                <div class="dashboard-card">
                    <a href="solski_admin_predmeti.php">Urejanje predmetov</a>
                </div>
                <div class="dashboard-card">
                    <a href="solski_admin_uporabniki.php">Urejanje uporabnikov (učitelji, učenci)</a>
                </div>
                <div class="dashboard-card">
                    <a href="solski_admin_dodelitve.php">Dodelitev učiteljev in učencev predmetom</a>
                </div>
            </div>
        <?php elseif ($role === 'ucitelj'): ?>
            <h1 class="dashboard-title">Učitelj</h1>
            <div class="dashboard-grid">
                <div class="dashboard-card">
                    <a href="solski_ucitelj_gradiva.php">Moja gradiva</a>
                </div>
                <div class="dashboard-card">
                    <a href="solski_ucitelj_naloge.php">Oddane naloge</a>
                </div>
            </div>
        <?php else: ?>
            <h1 class="dashboard-title">Učenec</h1>
            <div class="dashboard-grid">
                <div class="dashboard-card">
                    <a href="solski_ucenec_predmeti.php">Moji predmeti</a>
                </div>
                <div class="dashboard-card">
                    <a href="solski_ucenec_gradiva.php">Gradiva predmetov</a>
                </div>
                <div class="dashboard-card">
                    <a href="solski_ucenec_naloge.php">Oddaja nalog</a>
                </div>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>

