<?php
require 'db.php';

$profissional_id = filter_input(INPUT_GET, 'profissional_id', FILTER_VALIDATE_INT);
$data = filter_input(INPUT_GET, 'data', FILTER_SANITIZE_STRING);

if (!$profissional_id || !$data) {
    echo json_encode([]);
    exit;
}

// Simulação de horários fixos
$horariosBase = ['09:00', '10:00', '11:00', '13:00', '14:00', '15:00', '16:00'];

// Busca agendamentos existentes
$stmt = $pdo->prepare("SELECT TIME(data_agendamento) AS hora FROM agendamentos WHERE DATE(data_agendamento) = ? AND profissional_id = ?");
$stmt->execute([$data, $profissional_id]);
$agendados = $stmt->fetchAll(PDO::FETCH_COLUMN);

$disponiveis = array_diff($horariosBase, $agendados);

echo json_encode(array_values($disponiveis));