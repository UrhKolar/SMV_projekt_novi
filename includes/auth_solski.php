<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../config/database_solski.php';

function login_user_solski(string $email, string $password): bool {
    global $pdo_solski;
    $stmt = $pdo_solski->prepare('SELECT id, uporabnisko_ime, email, geslo, tip_uporabnika, ime, priimek FROM uporabniki WHERE email = ? AND aktiven = 1');
    $stmt->execute([$email]);
    $user = $stmt->fetch();
    if ($user && password_verify($password, $user['geslo'])) {
        session_regenerate_id(true);
        $_SESSION['solski_user'] = [
            'id' => $user['id'],
            'uporabnisko_ime' => $user['uporabnisko_ime'],
            'email' => $user['email'],
            'tip_uporabnika' => $user['tip_uporabnika'],
            'ime' => $user['ime'],
            'priimek' => $user['priimek'],
            'prikazno_ime' => $user['ime'] . ' ' . $user['priimek'],
        ];
        // Backward compatibility for existing code
        $_SESSION['solski_user_id'] = $user['id'];
        $_SESSION['solski_user_role'] = $user['tip_uporabnika'];
        $_SESSION['solski_user_name'] = $user['ime'] . ' ' . $user['priimek'];
        return true;
    }
    return false;
}

function register_student_solski(string $ime, string $priimek, string $email, string $uporabnisko_ime, string $password): bool {
    global $pdo_solski;
    $hash = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $pdo_solski->prepare('INSERT INTO uporabniki (uporabnisko_ime, email, geslo, tip_uporabnika, ime, priimek, aktiven) VALUES (?, ?, ?, "ucenec", ?, ?, 1)');
    try {
        return $stmt->execute([$uporabnisko_ime, $email, $hash, $ime, $priimek]);
    } catch (PDOException $e) {
        return false;
    }
}

function current_user_solski(): ?array {
    if (isset($_SESSION['solski_user']) && is_array($_SESSION['solski_user'])) {
        return $_SESSION['solski_user'];
    }
    return null;
}

function require_role_solski(string $role): void {
    $currentRole = $_SESSION['solski_user']['tip_uporabnika'] ?? $_SESSION['solski_user_role'] ?? null;
    if ($currentRole !== $role) {
        header('Location: solski_login.php');
        exit;
    }
}

function logout_solski(): void {
    unset($_SESSION['solski_user'], $_SESSION['solski_user_id'], $_SESSION['solski_user_role'], $_SESSION['solski_user_name']);
}
?>

