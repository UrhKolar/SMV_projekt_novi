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
        
        .users-table {
            font-size: 0.95rem;
        }
        
        .user-row {
            transition: background 0.2s ease;
        }
        
        .user-row:hover {
            background: #f8f9fa !important;
        }
        
        .user-row.hidden {
            display: none !important;
        }
        
        .users-table tbody tr:last-child {
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

        <!-- Search and filter section -->
        <div class="dashboard-card" style="margin-bottom:16px;">
            <div style="display:flex;flex-direction:column;gap:12px;">
                <div style="display:flex;flex-direction:column;gap:6px;">
                    <label style="font-weight:600;font-size:0.9rem;color:#34495e;">Išči uporabnike:</label>
                    <div style="position:relative;">
                        <input type="text" id="search-users" class="search-input" placeholder="Vnesi ime, priimek, email ali uporabniško ime..." autocomplete="off" style="width:100%;padding:10px 40px 10px 12px;" />
                        <button type="button" class="search-clear" onclick="clearUserSearch()" title="Počisti iskanje" style="position:absolute;right:8px;top:50%;transform:translateY(-50%);background:transparent;border:none;color:#6c757d;cursor:pointer;padding:4px 8px;border-radius:6px;font-size:18px;line-height:1;display:none;">×</button>
                    </div>
                    <div class="search-results-count" id="count-users"></div>
                </div>
            </div>
        </div>

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

        <div class="dashboard-card" style="overflow-x:auto;">
            <table class="users-table" style="width:100%;border-collapse:collapse;">
                <thead>
                    <tr style="background:#f8f9fa;border-bottom:2px solid #e9ecef;">
                        <th style="padding:12px;text-align:left;font-weight:600;color:#2c3e50;">Ime in priimek</th>
                        <th style="padding:12px;text-align:left;font-weight:600;color:#2c3e50;">Email</th>
                        <th style="padding:12px;text-align:left;font-weight:600;color:#2c3e50;">Uporabniško ime</th>
                        <th style="padding:12px;text-align:center;font-weight:600;color:#2c3e50;">Status</th>
                        <th style="padding:12px;text-align:center;font-weight:600;color:#2c3e50;">Akcije</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($users)): ?>
                        <tr>
                            <td colspan="5" style="padding:40px;text-align:center;color:#6c757d;">Ni uporabnikov.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($users as $u): ?>
                            <tr class="user-row" data-search="<?= strtolower($u['ime'] . ' ' . $u['priimek'] . ' ' . $u['email'] . ' ' . $u['uporabnisko_ime']) ?>" data-active="<?= $u['aktiven'] ? '1' : '0' ?>" data-user-id="<?= (int)$u['id'] ?>" style="border-bottom:1px solid #e9ecef;transition:background 0.2s ease;">
                                <td style="padding:12px;">
                                    <strong style="color:#2c3e50;"><?= htmlspecialchars($u['ime'] . ' ' . $u['priimek']) ?></strong>
                                </td>
                                <td style="padding:12px;color:#6c757d;"><?= htmlspecialchars($u['email']) ?></td>
                                <td style="padding:12px;color:#6c757d;"><?= htmlspecialchars($u['uporabnisko_ime']) ?></td>
                                <td style="padding:12px;text-align:center;">
                                    <?php if ($u['aktiven']): ?>
                                        <span style="background:#27ae60;color:#fff;padding:4px 12px;border-radius:12px;font-size:0.85rem;font-weight:600;">Aktiven</span>
                                    <?php else: ?>
                                        <span style="background:#e74c3c;color:#fff;padding:4px 12px;border-radius:12px;font-size:0.85rem;font-weight:600;">Neaktiven</span>
                                    <?php endif; ?>
                                </td>
                                <td style="padding:12px;text-align:center;">
                                    <button type="button" class="btn btn-outline" onclick="toggleEdit(<?= (int)$u['id'] ?>)" style="padding:6px 12px;font-size:0.85rem;margin-right:6px;">Uredi</button>
                                    <form method="post" style="display:inline;" onsubmit="return confirm('Izbrišem uporabnika?');">
                                        <input type="hidden" name="action" value="delete" />
                                        <input type="hidden" name="role" value="<?= $roleTab ?>" />
                                        <input type="hidden" name="id" value="<?= (int)$u['id'] ?>" />
                                        <button type="submit" class="btn" style="background:#e74c3c;color:#fff;padding:6px 12px;font-size:0.85rem;">Izbriši</button>
                                    </form>
                                </td>
                            </tr>
                            <tr id="edit-row-<?= (int)$u['id'] ?>" style="display:none;background:#f8f9fa;">
                                <td colspan="5" style="padding:20px;">
                                    <form method="post" class="form-grid grid-3" style="max-width:800px;">
                                        <input type="hidden" name="action" value="update" />
                                        <input type="hidden" name="role" value="<?= $roleTab ?>" />
                                        <input type="hidden" name="id" value="<?= (int)$u['id'] ?>" />
                                        <div class="field">
                                            <label class="form-label">Ime</label>
                                            <input type="text" name="ime" value="<?= htmlspecialchars($u['ime']) ?>" required />
                                        </div>
                                        <div class="field">
                                            <label class="form-label">Priimek</label>
                                            <input type="text" name="priimek" value="<?= htmlspecialchars($u['priimek']) ?>" required />
                                        </div>
                                        <div class="field">
                                            <label class="form-label">Uporabniško ime</label>
                                            <input type="text" name="uporabnisko_ime" value="<?= htmlspecialchars($u['uporabnisko_ime']) ?>" required />
                                        </div>
                                        <div class="field col-span-full">
                                            <label class="form-label">Email</label>
                                            <input type="email" name="email" value="<?= htmlspecialchars($u['email']) ?>" required />
                                        </div>
                                        <div class="field col-span-2">
                                            <label class="form-label">Spremeni geslo</label>
                                            <input type="password" name="password" placeholder="(neobvezno - pustite prazno, če ne želite spremeniti)" />
                                        </div>
                                        <div class="field place-end">
                                            <label class="checkbox" style="display:flex;align-items:center;gap:8px;">
                                                <input type="checkbox" name="aktiven" <?= $u['aktiven'] ? 'checked' : '' ?> /> Aktiven
                                            </label>
                                        </div>
                                        <div class="actions-row" style="grid-column:1/-1;margin-top:8px;">
                                            <button class="btn btn-primary" type="submit">Shrani spremembe</button>
                                            <button type="button" class="btn btn-outline" onclick="toggleEdit(<?= (int)$u['id'] ?>)">Prekliči</button>
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
        
        function filterUsers() {
            const searchInput = document.getElementById('search-users');
            const countElement = document.getElementById('count-users');
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
            
            const rows = document.querySelectorAll('.user-row');
            let visibleCount = 0;
            const totalCount = rows.length;
            
            rows.forEach(row => {
                const searchText = row.getAttribute('data-search') || '';
                const match = filter === '' ? { match: true, score: 0 } : fuzzyMatch(searchText, filter);
                
                if (filter === '' || match.match) {
                    row.classList.remove('hidden');
                    // Also show/hide edit row if it exists
                    const editRow = document.getElementById('edit-row-' + row.getAttribute('data-user-id'));
                    if (editRow && !row.classList.contains('hidden')) {
                        // Keep edit row visibility as is
                    }
                    visibleCount++;
                } else {
                    row.classList.add('hidden');
                    // Hide edit row if parent is hidden
                    const editRow = document.getElementById('edit-row-' + row.getAttribute('data-user-id'));
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
                    countElement.textContent = `${visibleCount} ${visibleCount === 1 ? 'uporabnik' : 'uporabnikov'} (${percentage}%)`;
                    countElement.className = visibleCount < totalCount ? 'search-results-count highlight' : 'search-results-count';
                }
            }
        }
        
        function clearUserSearch() {
            const searchInput = document.getElementById('search-users');
            searchInput.value = '';
            filterUsers();
            searchInput.focus();
        }
        
        function toggleEdit(userId) {
            const editRow = document.getElementById('edit-row-' + userId);
            if (editRow) {
                if (editRow.style.display === 'none') {
                    editRow.style.display = 'table-row';
                    // Scroll to edit row
                    editRow.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                } else {
                    editRow.style.display = 'none';
                }
            }
        }
        
        // Initialize event listeners
        document.addEventListener('DOMContentLoaded', function() {
            const searchUsers = document.getElementById('search-users');
            if (searchUsers) {
                searchUsers.addEventListener('input', filterUsers);
                searchUsers.addEventListener('keydown', (e) => {
                    if (e.key === 'Escape') {
                        clearUserSearch();
                    }
                });
            }
        });
    </script>
</body>
</html>


