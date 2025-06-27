<?php
// Configurações devem vir de variáveis de ambiente
$host = getenv('DB_HOST') ?: 'localhost';
$dbname = getenv('DB_NAME') ?: 'essence';
$user = getenv('DB_USER') ?: 'root';
$password = getenv('DB_PASS') ?: 'mysql2024';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    error_log("Erro de conexão com o banco: " . $e->getMessage());
    die("Desculpe, ocorreu um erro no sistema. Por favor, tente novamente mais tarde.");
}
?>
