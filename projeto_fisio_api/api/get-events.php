<?php
header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . '/../fullcalendar-com-bootstrap5/conexao.php';

try {
    $stmt = $conn->query("
        SELECT 
            a.idAgenda, 
            a.data, 
            a.hora, 
            a.idPaciente, 
            a.idUsuario, 
            a.status, 
            a.observacoes,
            p.nome AS paciente_nome
        FROM agenda a
        LEFT JOIN paciente p ON a.idPaciente = p.idPaciente
        ORDER BY a.data DESC, a.hora ASC
    ");
    $events = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($events);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
