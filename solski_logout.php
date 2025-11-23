<?php
require_once __DIR__ . '/includes/auth_solski.php';
logout_solski();
header('Location: solski_login.php');
exit;
?>

