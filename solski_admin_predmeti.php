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
    <style>
        .search-input {
            border: 1px solid #dfe4ea;
            border-radius: 10px;
            background: #fbfbfc;
            outline: none;
            transition: all .2s ease;
            color: #2c3e50;
            font-size: 0.95rem;
        }
        
        .search-input:focus {
            border-color: #4f8dd9;
            box-shadow: 0 0 0 3px rgba(79,141,217,.18);
            background: #fff;
        }
        
        .search-clear:hover {
            background: #f1f3f5;
            color: #2c3e50;
        }
        
        .search-clear.visible {
            display: block !important;
        }
        
        .search-results-count {
            font-size: 0.85rem;
            color: #6c757d;
            margin-top: -4px;
            padding-left: 2px;
            min-height: 18px;
        }
        
        .search-results-count.highlight {
            color: #4f8dd9;
            font-weight: 600;
        }
        
        .search-results-count.no-results {
            color: #e74c3c;
        }
        
        .subjects-table {
            font-size: 0.95rem;
        }
        
        .subject-row {
            transition: background 0.2s ease;
        }
        
        .subject-row:hover {
            background: #f8f9fa !important;
        }
        
        .subject-row.hidden {
            display: none !important;
        }
        
        .subjects-table tbody tr:last-child {
            border-bottom: none;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-4px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .search-results-count {
            animation: fadeIn 0.2s ease;
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

        <h1 class="dashboard-title">Urejanje predmetov</h1>

        <?php if ($message): ?>
            <div class="alert alert-success"><?= $message ?></div>
        <?php endif; ?>

        <!-- Search and filter section -->
        <div class="dashboard-card" style="margin-bottom:16px;">
            <div style="display:flex;flex-direction:column;gap:12px;">
                <div style="display:flex;flex-direction:column;gap:6px;">
                    <label style="font-weight:600;font-size:0.9rem;color:#34495e;">Išči predmete:</label>
                    <div style="position:relative;">
                        <input type="text" id="search-subjects" class="search-input" placeholder="Vnesi naziv, kratico ali opis predmeta..." autocomplete="off" style="width:100%;padding:10px 40px 10px 12px;" />
                        <button type="button" class="search-clear" onclick="clearSubjectSearch()" title="Počisti iskanje" style="position:absolute;right:8px;top:50%;transform:translateY(-50%);background:transparent;border:none;color:#6c757d;cursor:pointer;padding:4px 8px;border-radius:6px;font-size:18px;line-height:1;display:none;">×</button>
                    </div>
                    <div class="search-results-count" id="count-subjects"></div>
                </div>
            </div>
        </div>

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

        <div class="dashboard-card" style="overflow-x:auto;">
            <table class="subjects-table" style="width:100%;border-collapse:collapse;">
                <thead>
                    <tr style="background:#f8f9fa;border-bottom:2px solid #e9ecef;">
                        <th style="padding:12px;text-align:left;font-weight:600;color:#2c3e50;">Naziv</th>
                        <th style="padding:12px;text-align:left;font-weight:600;color:#2c3e50;">Kratica</th>
                        <th style="padding:12px;text-align:left;font-weight:600;color:#2c3e50;">Opis</th>
                        <th style="padding:12px;text-align:center;font-weight:600;color:#2c3e50;">Status</th>
                        <th style="padding:12px;text-align:center;font-weight:600;color:#2c3e50;">Akcije</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($predmeti)): ?>
                        <tr>
                            <td colspan="5" style="padding:40px;text-align:center;color:#6c757d;">Ni predmetov.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($predmeti as $p): ?>
                            <tr class="subject-row" data-search="<?= strtolower($p['naziv'] . ' ' . ($p['kratica'] ?? '') . ' ' . ($p['opis'] ?? '')) ?>" data-active="<?= $p['aktiven'] ? '1' : '0' ?>" data-subject-id="<?= (int)$p['id'] ?>" style="border-bottom:1px solid #e9ecef;transition:background 0.2s ease;">
                                <td style="padding:12px;">
                                    <strong style="color:#2c3e50;"><?= htmlspecialchars($p['naziv']) ?></strong>
                                </td>
                                <td style="padding:12px;color:#6c757d;"><?= htmlspecialchars($p['kratica'] ?? '-') ?></td>
                                <td style="padding:12px;color:#6c757d;max-width:300px;"><?= htmlspecialchars($p['opis'] ?? '-') ?></td>
                                <td style="padding:12px;text-align:center;">
                                    <?php if ($p['aktiven']): ?>
                                        <span style="background:#27ae60;color:#fff;padding:4px 12px;border-radius:12px;font-size:0.85rem;font-weight:600;">Aktiven</span>
                                    <?php else: ?>
                                        <span style="background:#e74c3c;color:#fff;padding:4px 12px;border-radius:12px;font-size:0.85rem;font-weight:600;">Neaktiven</span>
                                    <?php endif; ?>
                                </td>
                                <td style="padding:12px;text-align:center;">
                                    <button type="button" class="btn btn-outline" onclick="toggleEdit(<?= (int)$p['id'] ?>)" style="padding:6px 12px;font-size:0.85rem;margin-right:6px;">Uredi</button>
                                    <form method="post" style="display:inline;" onsubmit="return confirm('Izbrišem predmet?');">
                                        <input type="hidden" name="action" value="delete" />
                                        <input type="hidden" name="id" value="<?= (int)$p['id'] ?>" />
                                        <button type="submit" class="btn" style="background:#e74c3c;color:#fff;padding:6px 12px;font-size:0.85rem;">Izbriši</button>
                                    </form>
                                </td>
                            </tr>
                            <tr id="edit-row-<?= (int)$p['id'] ?>" style="display:none;background:#f8f9fa;">
                                <td colspan="5" style="padding:20px;">
                                    <form method="post" class="form-grid grid-3" style="max-width:800px;">
                                        <input type="hidden" name="action" value="update" />
                                        <input type="hidden" name="id" value="<?= (int)$p['id'] ?>" />
                                        <div class="field">
                                            <label class="form-label">Naziv</label>
                                            <input type="text" name="naziv" value="<?= htmlspecialchars($p['naziv']) ?>" required />
                                        </div>
                                        <div class="field">
                                            <label class="form-label">Kratica</label>
                                            <input type="text" name="kratica" value="<?= htmlspecialchars($p['kratica'] ?? '') ?>" />
                                        </div>
                                        <div class="field col-span-full">
                                            <label class="form-label">Opis</label>
                                            <input type="text" name="opis" value="<?= htmlspecialchars($p['opis'] ?? '') ?>" />
                                        </div>
                                        <div class="field place-end">
                                            <label class="checkbox" style="display:flex;align-items:center;gap:8px;">
                                                <input type="checkbox" name="aktiven" <?= $p['aktiven'] ? 'checked' : '' ?> /> Aktiven
                                            </label>
                                        </div>
                                        <div class="actions-row" style="grid-column:1/-1;margin-top:8px;">
                                            <button class="btn btn-primary" type="submit">Shrani spremembe</button>
                                            <button type="button" class="btn btn-outline" onclick="toggleEdit(<?= (int)$p['id'] ?>)">Prekliči</button>
                                        </div>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    <script>
        // Advanced fuzzy search function
        function fuzzyMatch(text, pattern) {
            text = text.toLowerCase();
            pattern = pattern.toLowerCase();
            
            if (text.includes(pattern)) {
                return { match: true, score: 100 };
            }
            
            let patternIdx = 0;
            for (let i = 0; i < text.length && patternIdx < pattern.length; i++) {
                if (text[i] === pattern[patternIdx]) {
                    patternIdx++;
                }
            }
            
            if (patternIdx === pattern.length) {
                return { match: true, score: 50 };
            }
            
            const words = text.split(/\s+/);
            const patternWords = pattern.split(/\s+/);
            let wordMatches = 0;
            
            for (const pWord of patternWords) {
                for (const word of words) {
                    if (word.startsWith(pWord) || word.includes(pWord)) {
                        wordMatches++;
                        break;
                    }
                }
            }
            
            if (wordMatches > 0) {
                return { match: true, score: wordMatches * 20 };
            }
            
            return { match: false, score: 0 };
        }
        
        function filterSubjects() {
            const searchInput = document.getElementById('search-subjects');
            const countElement = document.getElementById('count-subjects');
            const clearBtn = searchInput.nextElementSibling;
            const filter = searchInput.value.trim().toLowerCase();
            
            // Show/hide clear button
            if (clearBtn && clearBtn.classList.contains('search-clear')) {
                if (filter.length > 0) {
                    clearBtn.classList.add('visible');
                } else {
                    clearBtn.classList.remove('visible');
                }
            }
            
            const rows = document.querySelectorAll('.subject-row');
            let visibleCount = 0;
            const totalCount = rows.length;
            
            rows.forEach(row => {
                const searchText = row.getAttribute('data-search') || '';
                const match = filter === '' ? { match: true, score: 0 } : fuzzyMatch(searchText, filter);
                
                if (filter === '' || match.match) {
                    row.classList.remove('hidden');
                    visibleCount++;
                } else {
                    row.classList.add('hidden');
                    const editRow = document.getElementById('edit-row-' + row.getAttribute('data-subject-id'));
                    if (editRow) {
                        editRow.style.display = 'none';
                    }
                }
            });
            
            // Update result count display
            if (countElement) {
                if (filter === '') {
                    countElement.textContent = '';
                    countElement.className = 'search-results-count';
                } else if (visibleCount === 0) {
                    countElement.textContent = 'Ni rezultatov';
                    countElement.className = 'search-results-count no-results';
                } else {
                    const percentage = Math.round((visibleCount / totalCount) * 100);
                    countElement.textContent = `${visibleCount} ${visibleCount === 1 ? 'predmet' : 'predmetov'} (${percentage}%)`;
                    countElement.className = visibleCount < totalCount ? 'search-results-count highlight' : 'search-results-count';
                }
            }
        }
        
        function clearSubjectSearch() {
            const searchInput = document.getElementById('search-subjects');
            searchInput.value = '';
            filterSubjects();
            searchInput.focus();
        }
        
        function toggleEdit(subjectId) {
            const editRow = document.getElementById('edit-row-' + subjectId);
            if (editRow) {
                if (editRow.style.display === 'none') {
                    editRow.style.display = 'table-row';
                    editRow.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                } else {
                    editRow.style.display = 'none';
                }
            }
        }
        
        // Initialize event listeners
        document.addEventListener('DOMContentLoaded', function() {
            const searchSubjects = document.getElementById('search-subjects');
            if (searchSubjects) {
                searchSubjects.addEventListener('input', filterSubjects);
                searchSubjects.addEventListener('keydown', (e) => {
                    if (e.key === 'Escape') {
                        clearSubjectSearch();
                    }
                });
            }
        });
    </script>
</body>
</html>


