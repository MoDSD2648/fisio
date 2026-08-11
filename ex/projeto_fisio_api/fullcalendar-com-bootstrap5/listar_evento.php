<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
header('Content-Type: application/json');

require_once __DIR__ . '/../fullcalendar-com-bootstrap5/conexao.php';

$start = $_GET['start'] ?? date('Y-m-01');
$end = $_GET['end'] ?? date('Y-m-t');

$query = "
SELECT 
    a.idAgenda,
    a.data,
    a.hora,
    a.status,
    p.nome AS paciente,
    s.nome AS setor
FROM agenda a
LEFT JOIN paciente p ON a.idPaciente = p.idPaciente
LEFT JOIN setor s ON a.idSetor = s.idSetor
WHERE a.data BETWEEN :start AND :end
";

$stmt = $conn->prepare($query);
$stmt->bindParam(':start', $start);
$stmt->bindParam(':end', $end);
$stmt->execute();

$eventos = [];

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

    $eventos[] = [
        'id' => $row['idAgenda'],
        'title' => $row['setor'] . ' - ' . $row['paciente'],
        'start' => $row['data'] . 'T' . $row['hora'],
        'color' => '#257e4a'
    ];
}

echo json_encode($eventos);