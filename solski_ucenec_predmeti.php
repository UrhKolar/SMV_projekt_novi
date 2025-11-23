<?php
require_once __DIR__ . '/includes/auth_solski.php';
require_role_solski('ucenec');
$user = current_user_solski();

global $pdo_solski;

$message = '';
$action = $_POST['action'] ?? '';

// Handle subject enrollment/unenrollment
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($action === 'enroll') {
        $predmet_id = (int)($_POST['predmet_id'] ?? 0);
        if ($predmet_id) {
            try {
                $stmt = $pdo_solski->prepare('INSERT IGNORE INTO ucenci_predmeti (ucenec_id, predmet_id) VALUES (?, ?)');
                $stmt->execute([$user['id'], $predmet_id]);
                $message = 'Uspešno ste se pridružili predmetu.';
            } catch (PDOException $e) {
                $message = 'Napaka pri pridružitvi predmetu.';
            }
        }
    } elseif ($action === 'unenroll') {
        $predmet_id = (int)($_POST['predmet_id'] ?? 0);
        if ($predmet_id) {
            $stmt = $pdo_solski->prepare('DELETE FROM ucenci_predmeti WHERE ucenec_id = ? AND predmet_id = ?');
            $stmt->execute([$user['id'], $predmet_id]);
            $message = 'Uspešno ste zapustili predmet.';
        }
    }
}

// Load student's enrolled subjects
$stmt = $pdo_solski->prepare(
    'SELECT p.id, p.naziv, p.opis, p.kratica
     FROM ucenci_predmeti up
     JOIN predmeti p ON p.id = up.predmet_id
     WHERE up.ucenec_id = ? AND p.aktiven = 1
     ORDER BY p.naziv'
);
$stmt->execute([$user['id']]);
$mojiPredmeti = $stmt->fetchAll();

// Get IDs of enrolled subjects for filtering
$enrolledIds = array_column($mojiPredmeti, 'id');

// Load all active subjects
$stmt = $pdo_solski->prepare(
    'SELECT p.id, p.naziv, p.opis, p.kratica
     FROM predmeti p
     WHERE p.aktiven = 1
     ORDER BY p.naziv'
);
$stmt->execute();
$vsiPredmeti = $stmt->fetchAll();
?>

<html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/style.css">
    <style>
        #search-subjects:focus {
            border-color: #4f8dd9;
            box-shadow: 0 0 0 3px rgba(79,141,217,.18);
            background: #fff;
        }
        
        .subject-card {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        
        .subject-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>
    <div class="dashboard-wrap">
        <div class="dashboard-nav">
        <a class="btn btn-outline" href="solski_dashboard.php">← Nazaj</a>
            <strong><?= $user['prikazno_ime'] ?? ($user['ime'] . ' ' . $user['priimek']) ?> (<?= $user['tip_uporabnika'] ?>)</strong>
             <a href="solski_logout.php">Odjava</a>
        </div>

        <h1 class="dashboard-title">Moji predmeti</h1>
        
        <?php if ($message): ?>
            <div class="alert alert-success"><?= htmlspecialchars($message) ?></div>
        <?php endif; ?>

        <!-- My enrolled subjects -->
        <h2 class="dashboard-title" style="margin-top:24px;font-size:1.3rem;">Vpisani predmeti</h2>
        <div class="dashboard-grid" style="display:flex;justify-content:center;gap:20px;flex-wrap:wrap;">
            <?php if ($mojiPredmeti): ?>
                <?php foreach ($mojiPredmeti as $p): ?>
                    <div class="dashboard-card" style="width:280px;">
                        <div style="margin-bottom:8px;font-weight:700;color:#2c3e50;font-size:1.1rem;">
                            <?= htmlspecialchars($p['naziv']) ?><?= $p['kratica'] ? ' <span style="color:#6c757d;">(' . htmlspecialchars($p['kratica']) . ')</span>' : '' ?>
                        </div>
                        <?php if ($p['opis']): ?>
                            <div style="color:#666;margin-bottom:12px;font-size:0.9rem;"><?= nl2br(htmlspecialchars($p['opis'])) ?></div>
                        <?php endif; ?>
                        <div style="display:flex;gap:12px;flex-wrap:wrap;margin-bottom:8px;">
                            <a href="solski_ucenec_gradiva.php?predmet_id=<?= (int)$p['id'] ?>" style="text-decoration:none;color:#3498db;font-weight:600;">Gradiva</a>
                            <a href="solski_ucenec_naloge.php?predmet_id=<?= (int)$p['id'] ?>" style="text-decoration:none;color:#3498db;font-weight:600;">Moje naloge</a>
                        </div>
                        <form method="post" style="margin-top:8px;">
                            <input type="hidden" name="action" value="unenroll" />
                            <input type="hidden" name="predmet_id" value="<?= (int)$p['id'] ?>" />
                            <button type="submit" class="btn" style="background:#e74c3c;color:#fff;padding:6px 12px;font-size:0.85rem;" onclick="return confirm('Ali ste prepričani, da želite zapustiti ta predmet?');">Zapusti predmet</button>
                        </form>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="dashboard-card" style="width:280px;text-align:center;color:#6c757d;">
                    Nimate vpisanih predmetov. Spodaj si izberite predmete, ki jih želite obiskovati.
                </div>
            <?php endif; ?>
        </div>

        <!-- All available subjects -->
        <h2 class="dashboard-title" style="margin-top:32px;font-size:1.3rem;">Vsi predmeti</h2>
        <div class="dashboard-card" style="margin-bottom:16px;">
            <div style="display:flex;flex-direction:column;gap:8px;">
                <label style="font-weight:600;font-size:0.9rem;color:#34495e;">Išči predmet:</label>
                <input type="text" id="search-subjects" placeholder="Vnesi naziv predmeta..." style="padding:10px 12px;border:1px solid #dfe4ea;border-radius:10px;background:#fbfbfc;outline:none;transition:border-color .2s ease, box-shadow .2s ease;" onkeyup="filterSubjects()" />
            </div>
        </div>
        
        <div class="dashboard-grid" id="subjects-list" style="display:flex;justify-content:center;gap:20px;flex-wrap:wrap;">
            <?php foreach ($vsiPredmeti as $p): ?>
                <?php $isEnrolled = in_array($p['id'], $enrolledIds); ?>
                <div class="dashboard-card subject-card" style="width:280px;" data-search="<?= strtolower($p['naziv'] . ' ' . ($p['kratica'] ?? '') . ' ' . ($p['opis'] ?? '')) ?>">
                    <div style="margin-bottom:8px;font-weight:700;color:#2c3e50;font-size:1.1rem;">
                        <?= htmlspecialchars($p['naziv']) ?><?= $p['kratica'] ? ' <span style="color:#6c757d;">(' . htmlspecialchars($p['kratica']) . ')</span>' : '' ?>
                        <?php if ($isEnrolled): ?>
                            <span style="background:#27ae60;color:#fff;padding:2px 8px;border-radius:12px;font-size:0.75rem;margin-left:8px;">Vpisan</span>
                        <?php endif; ?>
                    </div>
                    <?php if ($p['opis']): ?>
                        <div style="color:#666;margin-bottom:12px;font-size:0.9rem;"><?= nl2br(htmlspecialchars($p['opis'])) ?></div>
                    <?php endif; ?>
                    <?php if ($isEnrolled): ?>
                        <div style="color:#27ae60;font-weight:600;margin-top:8px;">✓ Ste že vpisani v ta predmet</div>
                    <?php else: ?>
                        <form method="post" style="margin-top:8px;">
                            <input type="hidden" name="action" value="enroll" />
                            <input type="hidden" name="predmet_id" value="<?= (int)$p['id'] ?>" />
                            <button type="submit" class="btn btn-primary" style="width:100%;">Pridruži se predmetu</button>
                        </form>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
        
        <div id="no-results" style="display:none;text-align:center;padding:40px;color:#6c757d;font-style:italic;">
            Ni rezultatov za vaše iskanje.
        </div>
    </div>
    
    <script>
        function filterSubjects() {
            const searchInput = document.getElementById('search-subjects');
            const filter = searchInput.value.toLowerCase();
            const cards = document.querySelectorAll('.subject-card');
            const noResults = document.getElementById('no-results');
            let visibleCount = 0;
            
            cards.forEach(card => {
                const searchText = card.getAttribute('data-search') || '';
                if (filter === '' || searchText.includes(filter)) {
                    card.style.display = 'block';
                    visibleCount++;
                } else {
                    card.style.display = 'none';
                }
            });
            
            if (noResults) {
                noResults.style.display = (filter !== '' && visibleCount === 0) ? 'block' : 'none';
            }
        }
    </script>
</body>
</html>


