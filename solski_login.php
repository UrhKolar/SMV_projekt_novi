<?php
require_once __DIR__ . '/includes/auth_solski.php';

$error = '';
$email = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$email = trim($_POST['email'] ?? '');
	$password = trim($_POST['password'] ?? '');
	if (login_user_solski($email, $password)) {
		header('Location: solski_dashboard.php');
		exit;
	} else {
		$error = 'Napačen email ali geslo.';
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
		<div class="auth-card">
			<div class="auth-header">
				<div class="auth-brand"><span class="brand-mark">ŠS</span> Šolski sistem</div>
				<div class="auth-subtitle">Dobrodošli nazaj</div>
			</div>
			<h2 id="auth-title">Prijava</h2>
			<?php if ($error): ?>
				<div class="error-message"><?= $error ?></div>
			<?php endif; ?>
			<form method="post" class="auth-form" novalidate>
				<div class="form-field">
					<label for="email" class="form-label">Email</label>
					<input
						id="email"
						class="input"
						type="email"
						name="email"
						required
						placeholder="uporabnisko_ime"
					>
				</div>
                <div class="form-field">
                    <label for="password" class="form-label">Geslo</label>
                    <input
                        id="password"
                        class="input"
                        type="password"
                        name="password"
                        required
                        placeholder="••••••••"
                    >
                </div>
				<button type="submit" class="btn-submit">Prijava</button>
			</form>
			<div class="auth-footer">
				Še nimate računa? <a href="solski_register.php">Registracija</a>
			</div>
		</div>
	</div>

    
</body>
</html>

