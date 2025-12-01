<?php
$host = 'localhost';
$dbname = 'solski_sistem';
$username = 'root';
$password = '';

try {
    $pdo_solski = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo_solski->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo_solski->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    echo "Napaka povezave z bazo (solski): " . $e->getMessage();
    die();
}
?>

