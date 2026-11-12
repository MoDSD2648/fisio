<?php
ini_set('display_errors', 0);
header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . '/conexao.php';

// Limpa os parâmetros de data vindos do FullCalendar (podem vir no formato ISO com fuso horário)
$start = isset($_GET['start']) ? substr($_GET['start'], 0, 10) : date('Y-m-01');
$end   = isset($_GET['end'])   ? substr($_GET['end'], 0, 10)   : date('Y-m-t');

$eventos = [];

try {
    // Verifica se a tabela agenda possui a coluna idSetor
    $temSetor = false;
    $chk = $conn->query("SHOW COLUMNS FROM agenda LIKE 'idSetor'");
    if ($chk && $chk->rowCount() > 0) {
        $temSetor = true;
    }

    if ($temSetor) {
        $query = "
        SELECT 
            a.idAgenda,
            a.data,
            a.hora,
            a.status,
            COALESCE(p.nome, 'Sem paciente') AS paciente,
            COALESCE(s.nome, 'Fisioterapia') AS setor
        FROM agenda a
        LEFT JOIN paciente p ON a.idPaciente = p.idPaciente
        LEFT JOIN setor s ON a.idSetor = s.idSetor
        WHERE a.data BETWEEN :start AND :end
        ";
    } else {
        $query = "
        SELECT 
            a.idAgenda,
            a.data,
            a.hora,
            a.status,
            COALESCE(p.nome, 'Sem paciente') AS paciente,
            'Fisioterapia' AS setor
        FROM agenda a
        LEFT JOIN paciente p ON a.idPaciente = p.idPaciente
        WHERE a.data BETWEEN :start AND :end
        ";
    }

    $stmt = $conn->prepare($query);
    $stmt->bindParam(':start', $start);
    $stmt->bindParam(':end', $end);
    $stmt->execute();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $statusLower = strtolower($row['status'] ?? 'marcada');

        // Define cor do evento com base no status
        $color = '#0056cc'; // Padrão Marcada (Azul)
        if ($statusLower === 'confirmada' || $statusLower === 'concluído') {
            $color = '#198754'; // Confirmada (Verde)
        } elseif ($statusLower === 'cancelada' || $statusLower === 'faltou') {
            $color = '#dc3545'; // Cancelada / Faltou (Vermelho)
        }

        // Duração padrão: 1 hora
        $horaFim = date('H:i:s', strtotime($row['hora'] . ' +1 hour'));

        $eventos[] = [
            'id' => (string)$row['idAgenda'],
            'title' => $row['setor'] . ' - ' . $row['paciente'],
            'start' => $row['data'] . 'T' . $row['hora'],
            'end'   => $row['data'] . 'T' . $horaFim,
            'color' => $color,
            'extendedProps' => [
                'status' => $row['status'],
                'paciente' => $row['paciente'],
                'setor' => $row['setor']
            ]
        ];
    }
} catch (Exception $e) {
    error_log("Erro em listar_evento.php: " . $e->getMessage());
}

echo json_encode($eventos);
