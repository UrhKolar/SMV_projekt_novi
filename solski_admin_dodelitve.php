<?php
require_once __DIR__ . '/includes/auth_solski.php';
require_role_solski('admin');
$user = current_user_solski();

global $pdo_solski;

$message = '';
$action = $_POST['action'] ?? '';

// Load lists
$predmeti = $pdo_solski->query('SELECT id, naziv FROM predmeti WHERE aktiven=1 ORDER BY naziv')->fetchAll();
$ucitelji = $pdo_solski->query("SELECT id, ime, priimek FROM uporabniki WHERE tip_uporabnika='ucitelj' AND aktiven=1 ORDER BY priimek, ime")->fetchAll();
$ucenci = $pdo_solski->query("SELECT id, ime, priimek FROM uporabniki WHERE tip_uporabnika='ucenec' AND aktiven=1 ORDER BY priimek, ime")->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($action === 'assign_teacher') {
        $ucitelj = (int)($_POST['ucitelj_id'] ?? 0);
        $predmet = (int)($_POST['predmet_id'] ?? 0);
        if ($ucitelj && $predmet) {
            $stmt = $pdo_solski->prepare('INSERT IGNORE INTO ucitelji_predmeti (ucitelj_id, predmet_id) VALUES (?, ?)');
            $stmt->execute([$ucitelj, $predmet]);
            $message = 'Učitelj dodeljen predmetu.';
        }
    } elseif ($action === 'remove_teacher') {
        $rid = (int)($_POST['relation_id'] ?? 0);
        if ($rid) {
            $pdo_solski->prepare('DELETE FROM ucitelji_predmeti WHERE id=?')->execute([$rid]);
            $message = 'Dodelitev učitelja odstranjena.';
        }
    } elseif ($action === 'assign_student') {
        $ucenec = (int)($_POST['ucenec_id'] ?? 0);
        $predmet = (int)($_POST['predmet_id'] ?? 0);
        if ($ucenec && $predmet) {
            $stmt = $pdo_solski->prepare('INSERT IGNORE INTO ucenci_predmeti (ucenec_id, predmet_id) VALUES (?, ?)');
            $stmt->execute([$ucenec, $predmet]);
            $message = 'Učenec dodeljen predmetu.';
        }
    } elseif ($action === 'remove_student') {
        $rid = (int)($_POST['relation_id'] ?? 0);
        if ($rid) {
            $pdo_solski->prepare('DELETE FROM ucenci_predmeti WHERE id=?')->execute([$rid]);
            $message = 'Dodelitev učenca odstranjena.';
        }
    }
}

// Current relations
$teacherMap = $pdo_solski->query('SELECT up.id, u.ime, u.priimek, p.naziv FROM ucitelji_predmeti up JOIN uporabniki u ON u.id=up.ucitelj_id JOIN predmeti p ON p.id=up.predmet_id ORDER BY p.naziv, u.priimek')->fetchAll();
$studentMap = $pdo_solski->query('SELECT sp.id, u.ime, u.priimek, p.naziv FROM ucenci_predmeti sp JOIN uporabniki u ON u.id=sp.ucenec_id JOIN predmeti p ON p.id=sp.predmet_id ORDER BY p.naziv, u.priimek')->fetchAll();
?>

<html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/style.css">
    <style>
        .search-wrapper {
            position: relative;
            display: flex;
            flex-direction: column;
            gap: 6px;
        }
        
        .search-container {
            position: relative;
        }
        
        .search-input {
            width: 100%;
            padding: 10px 40px 10px 12px;
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
        
        .search-clear {
            position: absolute;
            right: 8px;
            top: 50%;
            transform: translateY(-50%);
            background: transparent;
            border: none;
            color: #6c757d;
            cursor: pointer;
            padding: 4px 8px;
            border-radius: 6px;
            font-size: 18px;
            line-height: 1;
            display: none;
            transition: all .2s ease;
        }
        
        .search-clear:hover {
            background: #f1f3f5;
            color: #2c3e50;
        }
        
        .search-clear.visible {
            display: block;
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
        
        .select-enhanced {
            padding: 10px 12px;
            border: 1px solid #dfe4ea;
            border-radius: 10px;
            background: #fbfbfc;
            outline: none;
            transition: all .2s ease;
            color: #2c3e50;
            font-size: 0.95rem;
            cursor: pointer;
        }
        
        .select-enhanced:focus {
            border-color: #4f8dd9;
            box-shadow: 0 0 0 3px rgba(79,141,217,.18);
            background: #fff;
        }
        
        .select-enhanced option {
            padding: 8px;
        }
        
        .select-enhanced option:checked {
            background: #4f8dd9 linear-gradient(0deg, #4f8dd9 0%, #4f8dd9 100%);
            color: white;
        }
        
        .form-group {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }
        
        .form-label {
            font-weight: 600;
            font-size: 0.9rem;
            color: #34495e;
        }
        
        .search-icon {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #9aa7b2;
            pointer-events: none;
        }
        
        .search-input.has-icon {
            padding-left: 38px;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-4px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .search-results-count {
            animation: fadeIn 0.2s ease;
        }
        
        .assignment-item {
            transition: all 0.2s ease;
        }
        
        .assignment-item:hover {
            background: #f8f9fa;
            padding-left: 4px;
            padding-right: 4px;
            border-radius: 6px;
        }
        
        .dashboard-card h3 {
            color: #2c3e50;
            font-size: 1.1rem;
            margin-bottom: 0;
        }
        
        .select-enhanced option:disabled {
            display: none;
        }
        
        /* Smooth transitions for select options */
        .select-enhanced {
            transition: all 0.2s ease;
        }
        
        .select-enhanced:focus {
            transform: translateY(-1px);
        }
        
        /* Loading state animation */
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }
        
        .search-input:focus::placeholder {
            color: #9aa7b2;
            transition: color 0.2s ease;
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

        <h1 class="dashboard-title">Dodelitve</h1>
        <?php if ($message): ?>
            <div class="alert alert-success"><?= $message ?></div>
        <?php endif; ?>

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:16px;">
            <div class="dashboard-card" style="border-radius: 20px; background: rgba(255, 255, 255, 0.6); backdrop-filter: blur(10px); -webkit-backdrop-filter: blur(10px);">
                <h3 style="margin-bottom:8px;">Dodeli učitelja predmetu</h3>
                <form method="post" style="display:flex;flex-direction:column;gap:12px;">
                    <input type="hidden" name="action" value="assign_teacher" />
                    <div class="form-group">
                        <label class="form-label">Išči učitelja:</label>
                        <div class="search-wrapper">
                            <div class="search-container">
                                <input type="text" id="search-teacher" class="search-input" placeholder="Vnesi ime ali priimek..." autocomplete="off" />
                                <button type="button" class="search-clear" onclick="clearSearch('search-teacher', 'ucitelj_id')" title="Počisti iskanje">×</button>
                            </div>
                            <div class="search-results-count" id="count-teacher"></div>
                        </div>
                        <select name="ucitelj_id" id="ucitelj_id" class="select-enhanced" required>
                            <option value="">Izberi učitelja</option>
                            <?php foreach ($ucitelji as $u): ?>
                                <option value="<?= (int)$u['id'] ?>" data-search="<?= strtolower($u['priimek'] . ' ' . $u['ime']) ?>"><?= $u['priimek'] . ' ' . $u['ime'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Išči predmet:</label>
                        <div class="search-wrapper">
                            <div class="search-container">
                                <input type="text" id="search-subject-teacher" class="search-input" placeholder="Vnesi naziv predmeta..." autocomplete="off" />
                                <button type="button" class="search-clear" onclick="clearSearch('search-subject-teacher', 'predmet_id_teacher')" title="Počisti iskanje">×</button>
                            </div>
                            <div class="search-results-count" id="count-subject-teacher"></div>
                        </div>
                        <select name="predmet_id" id="predmet_id_teacher" class="select-enhanced" required>
                            <option value="">Izberi predmet</option>
                            <?php foreach ($predmeti as $p): ?>
                                <option value="<?= (int)$p['id'] ?>" data-search="<?= strtolower($p['naziv']) ?>"><?= $p['naziv'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <button class="btn btn-primary" type="submit" style="margin-top:4px;">Dodeli</button>
                </form>
            </div>

            <div class="dashboard-card" style="border-radius: 20px; background: rgba(255, 255, 255, 0.6); backdrop-filter: blur(10px); -webkit-backdrop-filter: blur(10px);">
                <h3 style="margin-bottom:8px;">Dodeli učenca predmetu</h3>
                <form method="post" style="display:flex;flex-direction:column;gap:12px;">
                    <input type="hidden" name="action" value="assign_student" />
                    <div class="form-group">
                        <label class="form-label">Išči učenca:</label>
                        <div class="search-wrapper">
                            <div class="search-container">
                                <input type="text" id="search-student" class="search-input" placeholder="Vnesi ime ali priimek..." autocomplete="off" />
                                <button type="button" class="search-clear" onclick="clearSearch('search-student', 'ucenec_id')" title="Počisti iskanje">×</button>
                            </div>
                            <div class="search-results-count" id="count-student"></div>
                        </div>
                        <select name="ucenec_id" id="ucenec_id" class="select-enhanced" required>
                            <option value="">Izberi učenca</option>
                            <?php foreach ($ucenci as $u): ?>
                                <option value="<?= (int)$u['id'] ?>" data-search="<?= strtolower($u['priimek'] . ' ' . $u['ime']) ?>"><?= $u['priimek'] . ' ' . $u['ime'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Išči predmet:</label>
                        <div class="search-wrapper">
                            <div class="search-container">
                                <input type="text" id="search-subject-student" class="search-input" placeholder="Vnesi naziv predmeta..." autocomplete="off" />
                                <button type="button" class="search-clear" onclick="clearSearch('search-subject-student', 'predmet_id_student')" title="Počisti iskanje">×</button>
                            </div>
                            <div class="search-results-count" id="count-subject-student"></div>
                        </div>
                        <select name="predmet_id" id="predmet_id_student" class="select-enhanced" required>
                            <option value="">Izberi predmet</option>
                            <?php foreach ($predmeti as $p): ?>
                                <option value="<?= (int)$p['id'] ?>" data-search="<?= strtolower($p['naziv']) ?>"><?= $p['naziv'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <button class="btn btn-primary" type="submit" style="margin-top:4px;">Dodeli</button>
                </form>
            </div>
        </div>

        <h2 class="dashboard-title" style="margin-top:16px;">Trenutne dodelitve</h2>
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:16px;">
            <div class="dashboard-card" style="border-radius: 20px; background: rgba(255, 255, 255, 0.6); backdrop-filter: blur(10px); -webkit-backdrop-filter: blur(10px);">
                <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:12px;">
                    <h3 style="margin:0;">Učitelji - Predmeti</h3>
                    <div class="search-container" style="max-width:200px;">
                        <input type="text" id="filter-teachers" class="search-input" placeholder="Filtriraj dodelitve..." autocomplete="off" style="font-size:0.85rem;padding:6px 30px 6px 10px;" />
                        <button type="button" class="search-clear" onclick="clearFilter('filter-teachers', 'teachers-list')" title="Počisti filter" style="font-size:16px;padding:2px 6px;">×</button>
                    </div>
                </div>
                <div id="teachers-list">
                    <?php foreach ($teacherMap as $r): ?>
                        <form method="post" class="assignment-item" data-search="<?= strtolower($r['naziv'] . ' ' . $r['priimek'] . ' ' . $r['ime']) ?>" style="display:flex;justify-content:space-between;align-items:center;border-bottom:1px solid #eee;padding:8px 0;transition:opacity 0.2s ease;">
                            <div><?= htmlspecialchars($r['naziv']); ?> — <?= htmlspecialchars($r['priimek'] . ' ' . $r['ime']); ?></div>
                            <div>
                                <input type="hidden" name="action" value="remove_teacher" />
                                <input type="hidden" name="relation_id" value="<?= (int)$r['id'] ?>" />
                                <button class="btn" onclick="return confirm('Odstranim dodelitev?');">Odstrani</button>
                            </div>
                        </form>
                    <?php endforeach; ?>
                </div>
                <div id="teachers-empty" style="display:none;text-align:center;padding:20px;color:#6c757d;font-style:italic;">
                    Ni rezultatov
                </div>
            </div>
            <div class="dashboard-card" style="border-radius: 20px; background: rgba(255, 255, 255, 0.6); backdrop-filter: blur(10px); -webkit-backdrop-filter: blur(10px);">
                <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:12px;">
                    <h3 style="margin:0;">Učenci - Predmeti</h3>
                    <div class="search-container" style="max-width:200px;">
                        <input type="text" id="filter-students" class="search-input" placeholder="Filtriraj dodelitve..." autocomplete="off" style="font-size:0.85rem;padding:6px 30px 6px 10px;" />
                        <button type="button" class="search-clear" onclick="clearFilter('filter-students', 'students-list')" title="Počisti filter" style="font-size:16px;padding:2px 6px;">×</button>
                    </div>
                </div>
                <div id="students-list">
                    <?php foreach ($studentMap as $r): ?>
                        <form method="post" class="assignment-item" data-search="<?= strtolower($r['naziv'] . ' ' . $r['priimek'] . ' ' . $r['ime']) ?>" style="display:flex;justify-content:space-between;align-items:center;border-bottom:1px solid #eee;padding:8px 0;transition:opacity 0.2s ease;">
                            <div><?= htmlspecialchars($r['naziv']); ?> — <?= htmlspecialchars($r['priimek'] . ' ' . $r['ime']); ?></div>
                            <div>
                                <input type="hidden" name="action" value="remove_student" />
                                <input type="hidden" name="relation_id" value="<?= (int)$r['id'] ?>" />
                                <button class="btn" onclick="return confirm('Odstranim dodelitev?');">Odstrani</button>
                            </div>
                        </form>
                    <?php endforeach; ?>
                </div>
                <div id="students-empty" style="display:none;text-align:center;padding:20px;color:#6c757d;font-style:italic;">
                    Ni rezultatov
                </div>
            </div>
        </div>
    </div>
    <script>
        // Advanced fuzzy search function
        function fuzzyMatch(text, pattern) {
            text = text.toLowerCase();
            pattern = pattern.toLowerCase();
            
            // Exact match gets highest priority
            if (text.includes(pattern)) {
                return { match: true, score: 100 };
            }
            
            // Check if all characters in pattern exist in order
            let patternIdx = 0;
            for (let i = 0; i < text.length && patternIdx < pattern.length; i++) {
                if (text[i] === pattern[patternIdx]) {
                    patternIdx++;
                }
            }
            
            if (patternIdx === pattern.length) {
                return { match: true, score: 50 };
            }
            
            // Check individual words
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
        
        // Enhanced filter function with result counting
        function filterSelect(searchInputId, selectId, countId) {
            const searchInput = document.getElementById(searchInputId);
            const select = document.getElementById(selectId);
            const countElement = document.getElementById(countId);
            const searchContainer = searchInput.closest('.search-container');
            const clearBtn = searchContainer ? searchContainer.querySelector('.search-clear') : null;
            const filter = searchInput.value.trim();
            
            // Show/hide clear button
            if (clearBtn && clearBtn.classList.contains('search-clear')) {
                if (filter.length > 0) {
                    clearBtn.classList.add('visible');
                } else {
                    clearBtn.classList.remove('visible');
                }
            }
            
            const options = Array.from(select.getElementsByTagName('option'));
            let visibleCount = 0;
            let totalOptions = 0;
            
            // Store original order for sorting
            const optionData = options.map((option, index) => {
                if (index === 0 || option.value === '') {
                    return { option, index, isPlaceholder: true };
                }
                totalOptions++;
                const searchText = option.getAttribute('data-search') || option.textContent.toLowerCase();
                const match = filter === '' ? { match: true, score: 0 } : fuzzyMatch(searchText, filter);
                return { option, index, match, searchText, isPlaceholder: false };
            });
            
            // Filter and sort options
            optionData.forEach(({ option, isPlaceholder, match }) => {
                if (isPlaceholder) {
                    option.style.display = '';
                    option.disabled = false;
                    return;
                }
                
                if (filter === '' || match.match) {
                    option.style.display = '';
                    option.disabled = false;
                    visibleCount++;
                } else {
                    option.style.display = 'none';
                    option.disabled = true;
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
                    const percentage = Math.round((visibleCount / totalOptions) * 100);
                    countElement.textContent = `${visibleCount} ${visibleCount === 1 ? 'rezultat' : 'rezultatov'} (${percentage}%)`;
                    countElement.className = visibleCount < totalOptions ? 'search-results-count highlight' : 'search-results-count';
                }
            }
            
            // Reset select if no valid option is selected
            if (filter.length > 0 && select.value) {
                const selectedOption = select.options[select.selectedIndex];
                if (selectedOption && (selectedOption.disabled || selectedOption.style.display === 'none')) {
                    select.value = '';
                }
            }
        }
        
        // Clear search function
        function clearSearch(searchInputId, selectId) {
            const searchInput = document.getElementById(searchInputId);
            const select = document.getElementById(selectId);
            let countId = '';
            
            // Determine count element ID based on search input ID
            if (searchInputId === 'search-teacher') {
                countId = 'count-teacher';
            } else if (searchInputId === 'search-subject-teacher') {
                countId = 'count-subject-teacher';
            } else if (searchInputId === 'search-student') {
                countId = 'count-student';
            } else if (searchInputId === 'search-subject-student') {
                countId = 'count-subject-student';
            }
            
            searchInput.value = '';
            select.value = '';
            
            // Trigger filter to reset everything
            if (countId) {
                filterSelect(searchInputId, selectId, countId);
            }
            searchInput.focus();
        }
        
        // Initialize event listeners
        document.addEventListener('DOMContentLoaded', function() {
            // Teacher search
            const searchTeacher = document.getElementById('search-teacher');
            if (searchTeacher) {
                searchTeacher.addEventListener('input', () => filterSelect('search-teacher', 'ucitelj_id', 'count-teacher'));
                searchTeacher.addEventListener('keydown', (e) => {
                    if (e.key === 'Escape') {
                        clearSearch('search-teacher', 'ucitelj_id');
                    }
                });
            }
            
            // Subject search (teacher)
            const searchSubjectTeacher = document.getElementById('search-subject-teacher');
            if (searchSubjectTeacher) {
                searchSubjectTeacher.addEventListener('input', () => filterSelect('search-subject-teacher', 'predmet_id_teacher', 'count-subject-teacher'));
                searchSubjectTeacher.addEventListener('keydown', (e) => {
                    if (e.key === 'Escape') {
                        clearSearch('search-subject-teacher', 'predmet_id_teacher');
                    }
                });
            }
            
            // Student search
            const searchStudent = document.getElementById('search-student');
            if (searchStudent) {
                searchStudent.addEventListener('input', () => filterSelect('search-student', 'ucenec_id', 'count-student'));
                searchStudent.addEventListener('keydown', (e) => {
                    if (e.key === 'Escape') {
                        clearSearch('search-student', 'ucenec_id');
                    }
                });
            }
            
            // Subject search (student)
            const searchSubjectStudent = document.getElementById('search-subject-student');
            if (searchSubjectStudent) {
                searchSubjectStudent.addEventListener('input', () => filterSelect('search-subject-student', 'predmet_id_student', 'count-subject-student'));
                searchSubjectStudent.addEventListener('keydown', (e) => {
                    if (e.key === 'Escape') {
                        clearSearch('search-subject-student', 'predmet_id_student');
                    }
                });
            }
            
            // Filter current assignments
            const filterTeachers = document.getElementById('filter-teachers');
            if (filterTeachers) {
                filterTeachers.addEventListener('input', () => filterAssignments('filter-teachers', 'teachers-list', 'teachers-empty'));
                filterTeachers.addEventListener('keydown', (e) => {
                    if (e.key === 'Escape') {
                        clearFilter('filter-teachers', 'teachers-list');
                    }
                });
            }
            
            const filterStudents = document.getElementById('filter-students');
            if (filterStudents) {
                filterStudents.addEventListener('input', () => filterAssignments('filter-students', 'students-list', 'students-empty'));
                filterStudents.addEventListener('keydown', (e) => {
                    if (e.key === 'Escape') {
                        clearFilter('filter-students', 'students-list');
                    }
                });
            }
        });
        
        // Filter assignments list
        function filterAssignments(filterInputId, listId, emptyId) {
            const filterInput = document.getElementById(filterInputId);
            const list = document.getElementById(listId);
            const empty = document.getElementById(emptyId);
            const searchContainer = filterInput.closest('.search-container');
            const clearBtn = searchContainer ? searchContainer.querySelector('.search-clear') : null;
            const filter = filterInput.value.trim().toLowerCase();
            
            // Show/hide clear button
            if (clearBtn) {
                if (filter.length > 0) {
                    clearBtn.classList.add('visible');
                } else {
                    clearBtn.classList.remove('visible');
                }
            }
            
            const items = list.getElementsByClassName('assignment-item');
            let visibleCount = 0;
            
            for (let item of items) {
                const searchText = item.getAttribute('data-search') || '';
                const match = filter === '' || searchText.includes(filter);
                
                if (match) {
                    item.style.display = 'flex';
                    item.style.opacity = '1';
                    visibleCount++;
                } else {
                    item.style.display = 'none';
                    item.style.opacity = '0';
                }
            }
            
            // Show/hide empty message
            if (empty) {
                if (filter.length > 0 && visibleCount === 0) {
                    empty.style.display = 'block';
                } else {
                    empty.style.display = 'none';
                }
            }
        }
        
        // Clear filter for assignments
        function clearFilter(filterInputId, listId) {
            const filterInput = document.getElementById(filterInputId);
            const list = document.getElementById(listId);
            const emptyId = filterInputId === 'filter-teachers' ? 'teachers-empty' : 'students-empty';
            
            filterInput.value = '';
            
            // Reset all items
            const items = list.getElementsByClassName('assignment-item');
            for (let item of items) {
                item.style.display = 'flex';
                item.style.opacity = '1';
            }
            
            // Hide empty message
            const empty = document.getElementById(emptyId);
            if (empty) {
                empty.style.display = 'none';
            }
            
            // Hide clear button
            const searchContainer = filterInput.closest('.search-container');
            const clearBtn = searchContainer ? searchContainer.querySelector('.search-clear') : null;
            if (clearBtn) {
                clearBtn.classList.remove('visible');
            }
            
            filterInput.focus();
        }
    </script>
</body>
</html>

