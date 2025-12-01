<?php
// Enostaven seed demo podatkov. Zaženite enkrat in nato izbrišite to datoteko.
require_once __DIR__ . '/config/database_solski.php';

try {
    $pdo_solski->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Pomozne funkcije (simple upsert)
    $getOrCreateUser = function(string $username, string $email, string $role, string $ime, string $priimek, string $password) use ($pdo_solski): int {
        $id = $pdo_solski->prepare('SELECT id FROM uporabniki WHERE email = ?');
        $id->execute([$email]);
        $row = $id->fetch(PDO::FETCH_ASSOC);
        if ($row) { return (int)$row['id']; }
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $ins = $pdo_solski->prepare('INSERT INTO uporabniki (uporabnisko_ime, email, geslo, tip_uporabnika, ime, priimek, aktiven) VALUES (?, ?, ?, ?, ?, ?, 1)');
        $ins->execute([$username, $email, $hash, $role, $ime, $priimek]);
        return (int)$pdo_solski->lastInsertId();
    };

    $getOrCreatePredmet = function(string $naziv, ?string $opis, ?string $kratica) use ($pdo_solski): int {
        $id = $pdo_solski->prepare('SELECT id FROM predmeti WHERE naziv = ?');
        $id->execute([$naziv]);
        $row = $id->fetch(PDO::FETCH_ASSOC);
        if ($row) { return (int)$row['id']; }
        $ins = $pdo_solski->prepare('INSERT INTO predmeti (naziv, opis, kratica, aktiven) VALUES (?, ?, ?, 1)');
        $ins->execute([$naziv, $opis, $kratica]);
        return (int)$pdo_solski->lastInsertId();
    };

    $ensureRelation = function(string $table, string $colA, string $colB, int $a, int $b) use ($pdo_solski): void {
        $sel = $pdo_solski->prepare("SELECT id FROM {$table} WHERE {$colA} = ? AND {$colB} = ?");
        $sel->execute([$a, $b]);
        if (!$sel->fetch()) {
            $ins = $pdo_solski->prepare("INSERT INTO {$table} ({$colA}, {$colB}) VALUES (?, ?)");
            $ins->execute([$a, $b]);
        }
    };

    // Uporabniki
    $adminId = $getOrCreateUser('admin', 'admin@example.com', 'admin', 'Ana', 'Admin', 'admin123');
    $teachId = $getOrCreateUser('ucitelj', 'ucitelj@example.com', 'ucitelj', 'Tina', 'Ucitelj', 'ucitelj123');
    $studId  = $getOrCreateUser('ucenec', 'ucenec@example.com', 'ucenec', 'Uros', 'Ucenec', 'ucenec123');

    // Predmeti
    $matId = $getOrCreatePredmet('Matematika', 'Osnovna in višja matematika', 'MAT');
    $infId = $getOrCreatePredmet('Informatika', 'Osnove programiranja in IT', 'INF');

    // Povezave
    $ensureRelation('ucitelji_predmeti', 'ucitelj_id', 'predmet_id', $teachId, $matId);
    $ensureRelation('ucitelji_predmeti', 'ucitelj_id', 'predmet_id', $teachId, $infId);
    $ensureRelation('ucenci_predmeti', 'ucenec_id', 'predmet_id', $studId, $matId);
    $ensureRelation('ucenci_predmeti', 'ucenec_id', 'predmet_id', $studId, $infId);

    echo '<pre>Seed končan.\n\nPrijave:\n- Admin: admin@example.com / admin123\n- Učitelj: ucitelj@example.com / ucitelj123\n- Učenec: ucenec@example.com / ucenec123\n\nPo uporabi izbrišite datoteko seed_solski_users.php.</pre>';
} catch (Throwable $e) {
    http_response_code(500);
    echo '<pre>Napaka pri sejanju: ' . $e->getMessage() . '</pre>';
}
