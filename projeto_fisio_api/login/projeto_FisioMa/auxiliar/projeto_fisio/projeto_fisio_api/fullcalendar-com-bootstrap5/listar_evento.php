<?php

// Incluir o arquivo com a conexão com banco de dados

require_once __DIR__ . '/../fullcalendar-com-bootstrap5/conexao.php';

// QUERY com JOIN para trazer o nome do paciente
$query_events = "SELECT agenda.idAgenda, agenda.data, agenda.hora, agenda.idPaciente, agenda.idUsuario, agenda.status, agenda.observacoes, paciente.nome AS nomePaciente 
                 FROM agenda 
                 JOIN paciente ON agenda.idPaciente = paciente.idPaciente";

// Prepara a QUERY
$result_events = $conn->prepare($query_events);

// Executar a QUERY
$result_events->execute();

// Criar o array que recebe os eventos
$eventos = [];

// Percorrer os registros retornados
while ($row_events = $result_events->fetch(PDO::FETCH_ASSOC)) {
    $eventos[] = [
        'id' => $row_events['idAgenda'],
        'title' => $row_events['nomePaciente'], // nome do paciente como título
        'start' => $row_events['data'] . 'T' . $row_events['hora'],
        'status' => $row_events['status'],
        'color' => ($row_events['status'] === 'Confirmada') ? '#257e4a' : '#ff9f89'
    ];
}

// Retornar os eventos no formato JSON
echo json_encode($eventos);
