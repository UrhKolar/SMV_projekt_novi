<?php
require_once __DIR__ . '/includes/auth_solski.php';
$user = current_user_solski();
if (!$user) { header('Location: index.php'); exit; }

$role = $user['tip_uporabnika'];
?>

<html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/style.css">
    <style>
        .dashboard-card a[style*="background: #3498db"]:hover {
            background: #2980b9 !important;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(52, 152, 219, 0.4);
        }
        .dashboard-card h2 a:hover {
            color: #3498db !important;
        }
    </style>
    </head>
<body>
    <div class="dashboard-wrap">
        <div class="dashboard-nav">
            <strong><?= $user['prikazno_ime'] ?? ($user['ime'] . ' ' . $user['priimek']) ?> (<?= $role ?>)</strong>
            <a href="solski_logout.php">Odjava</a>
        </div>

        <?php if ($role === 'admin'): ?>
            <h1 class="dashboard-title" style="color: #ffffff; text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);">Administrator</h1>
            <div class="dashboard-grid" style="justify-content: center; gap: 30px;">
                <div class="dashboard-card" style="min-width: 350px; max-width: 400px; padding: 40px 30px; text-align: left; border-radius: 20px; background: rgba(255, 255, 255, 0.6); backdrop-filter: blur(10px); -webkit-backdrop-filter: blur(10px);">
                    <div style="font-size: 3rem; margin-bottom: 15px; text-align: center;">📖</div>
                    <h2 style="font-size: 1.8rem; color: #1a1a1a; margin-bottom: 15px; text-align: center; font-weight: 700; text-shadow: 0 1px 2px rgba(255, 255, 255, 0.8);">
                        <a href="solski_admin_predmeti.php" style="text-decoration: none; color: inherit;">Urejanje predmetov</a>
                    </h2>
                    <p style="color: #2c3e50; line-height: 1.7; font-size: 1.05rem; margin: 0; font-weight: 500; text-shadow: 0 1px 1px rgba(255, 255, 255, 0.6);">
                        Tukaj lahko upravljate predmete, dodajate nove predmete, urejate obstoječe in upravljate njihove nastavitve.
                    </p>
                    <div style="margin-top: 20px; text-align: center;">
                        <a href="solski_admin_predmeti.php" style="display: inline-block; padding: 12px 24px; background: #3498db; color: #fff; text-decoration: none; border-radius: 12px; font-weight: 600; transition: background 0.2s ease; font-size: 1.05rem;">Odpri →</a>
                    </div>
                </div>
                <div class="dashboard-card" style="min-width: 350px; max-width: 400px; padding: 40px 30px; text-align: left; border-radius: 20px; background: rgba(255, 255, 255, 0.6); backdrop-filter: blur(10px); -webkit-backdrop-filter: blur(10px);">
                    <div style="font-size: 3rem; margin-bottom: 15px; text-align: center;">👥</div>
                    <h2 style="font-size: 1.8rem; color: #1a1a1a; margin-bottom: 15px; text-align: center; font-weight: 700; text-shadow: 0 1px 2px rgba(255, 255, 255, 0.8);">
                        <a href="solski_admin_uporabniki.php" style="text-decoration: none; color: inherit;">Urejanje uporabnikov</a>
                    </h2>
                    <p style="color: #2c3e50; line-height: 1.7; font-size: 1.05rem; margin: 0; font-weight: 500; text-shadow: 0 1px 1px rgba(255, 255, 255, 0.6);">
                        Tukaj lahko upravljate uporabnike sistema, dodajate nove učitelje in učence ter urejate njihove podatke.
                    </p>
                    <div style="margin-top: 20px; text-align: center;">
                        <a href="solski_admin_uporabniki.php" style="display: inline-block; padding: 12px 24px; background: #3498db; color: #fff; text-decoration: none; border-radius: 12px; font-weight: 600; transition: background 0.2s ease; font-size: 1.05rem;">Odpri →</a>
                    </div>
                </div>
                <div class="dashboard-card" style="min-width: 350px; max-width: 400px; padding: 40px 30px; text-align: left; border-radius: 20px; background: rgba(255, 255, 255, 0.6); backdrop-filter: blur(10px); -webkit-backdrop-filter: blur(10px);">
                    <div style="font-size: 3rem; margin-bottom: 15px; text-align: center;">🔗</div>
                    <h2 style="font-size: 1.8rem; color: #1a1a1a; margin-bottom: 15px; text-align: center; font-weight: 700; text-shadow: 0 1px 2px rgba(255, 255, 255, 0.8);">
                        <a href="solski_admin_dodelitve.php" style="text-decoration: none; color: inherit;">Dodelitve</a>
                    </h2>
                    <p style="color: #2c3e50; line-height: 1.7; font-size: 1.05rem; margin: 0; font-weight: 500; text-shadow: 0 1px 1px rgba(255, 255, 255, 0.6);">
                        Tukaj lahko dodeljujete učitelje in učence predmetom ter upravljate njihove povezave.
                    </p>
                    <div style="margin-top: 20px; text-align: center;">
                        <a href="solski_admin_dodelitve.php" style="display: inline-block; padding: 12px 24px; background: #3498db; color: #fff; text-decoration: none; border-radius: 12px; font-weight: 600; transition: background 0.2s ease; font-size: 1.05rem;">Odpri →</a>
                    </div>
                </div>
            </div>
        <?php elseif ($role === 'ucitelj'): ?>
            <h1 class="dashboard-title" style="color: #ffffff; text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);">Učitelj</h1>
            <div class="dashboard-grid" style="justify-content: center; gap: 30px;">
                <div class="dashboard-card" style="min-width: 350px; max-width: 400px; padding: 40px 30px; text-align: left; border-radius: 20px; background: rgba(255, 255, 255, 0.6); backdrop-filter: blur(10px); -webkit-backdrop-filter: blur(10px);">
                    <div style="font-size: 3rem; margin-bottom: 15px; text-align: center;">📚</div>
                    <h2 style="font-size: 1.8rem; color: #1a1a1a; margin-bottom: 15px; text-align: center; font-weight: 700; text-shadow: 0 1px 2px rgba(255, 255, 255, 0.8);">
                        <a href="solski_ucitelj_gradiva.php" style="text-decoration: none; color: inherit;">Moja gradiva</a>
                    </h2>
                    <p style="color: #2c3e50; line-height: 1.7; font-size: 1.05rem; margin: 0; font-weight: 500; text-shadow: 0 1px 1px rgba(255, 255, 255, 0.6);">
                        Tukaj lahko naložite gradiva za svoje predmete, upravljate datoteke in organizirate učno gradivo za učence.
                    </p>
                    <div style="margin-top: 20px; text-align: center;">
                        <a href="solski_ucitelj_gradiva.php" style="display: inline-block; padding: 12px 24px; background: #3498db; color: #fff; text-decoration: none; border-radius: 12px; font-weight: 600; transition: background 0.2s ease; font-size: 1.05rem;">Odpri →</a>
                    </div>
                </div>
                <div class="dashboard-card" style="min-width: 350px; max-width: 400px; padding: 40px 30px; text-align: left; border-radius: 20px; background: rgba(255, 255, 255, 0.6); backdrop-filter: blur(10px); -webkit-backdrop-filter: blur(10px);">
                    <div style="font-size: 3rem; margin-bottom: 15px; text-align: center;">📝</div>
                    <h2 style="font-size: 1.8rem; color: #1a1a1a; margin-bottom: 15px; text-align: center; font-weight: 700; text-shadow: 0 1px 2px rgba(255, 255, 255, 0.8);">
                        <a href="solski_ucitelj_naloge.php" style="text-decoration: none; color: inherit;">Oddane naloge</a>
                    </h2>
                    <p style="color: #2c3e50; line-height: 1.7; font-size: 1.05rem; margin: 0; font-weight: 500; text-shadow: 0 1px 1px rgba(255, 255, 255, 0.6);">
                        Tukaj lahko pregledujete oddane naloge učencev, ocenjujete delo in dajete povratne informacije.
                    </p>
                    <div style="margin-top: 20px; text-align: center;">
                        <a href="solski_ucitelj_naloge.php" style="display: inline-block; padding: 12px 24px; background: #3498db; color: #fff; text-decoration: none; border-radius: 12px; font-weight: 600; transition: background 0.2s ease; font-size: 1.05rem;">Odpri →</a>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <h1 class="dashboard-title" style="color: #ffffff; text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);">Učenec</h1>
            <div class="dashboard-grid">
                <div class="dashboard-card" style="border-radius: 20px; background: rgba(255, 255, 255, 0.6); backdrop-filter: blur(10px); -webkit-backdrop-filter: blur(10px);">
                    <a href="solski_ucenec_predmeti.php" style="color: #1a1a1a; font-weight: 700; font-size: 1.1rem; text-shadow: 0 1px 2px rgba(255, 255, 255, 0.8);">Moji predmeti</a>
                </div>
                <div class="dashboard-card" style="border-radius: 20px; background: rgba(255, 255, 255, 0.6); backdrop-filter: blur(10px); -webkit-backdrop-filter: blur(10px);">
                    <a href="solski_ucenec_gradiva.php" style="color: #1a1a1a; font-weight: 700; font-size: 1.1rem; text-shadow: 0 1px 2px rgba(255, 255, 255, 0.8);">Gradiva predmetov</a>
                </div>
                <div class="dashboard-card" style="border-radius: 20px; background: rgba(255, 255, 255, 0.6); backdrop-filter: blur(10px); -webkit-backdrop-filter: blur(10px);">
                    <a href="solski_ucenec_naloge.php" style="color: #1a1a1a; font-weight: 700; font-size: 1.1rem; text-shadow: 0 1px 2px rgba(255, 255, 255, 0.8);">Oddaja nalog</a>
                </div>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>

