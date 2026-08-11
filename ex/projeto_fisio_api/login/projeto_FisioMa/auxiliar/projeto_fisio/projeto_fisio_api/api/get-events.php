<?php
// Define o cabeçalho da resposta como JSON
header('Content-Type: application/json');

// Inclui o arquivo de conexão
require_once '../fullcalendar-com-bootstrap5/conexao.php';

try {
    // Executa a consulta SQL para buscar os eventos
    $stmt = $conn->query("SELECT idAgenda, titulo, data, hora, idProntuario, idUsuario, status, observacoes FROM agenda"); // Seleciona os campos necessários da tabela 'events'
    $events = $stmt->fetchAll(PDO::FETCH_ASSOC); // Obtém os resultados como um array associativo

    // Retorna os eventos no formato JSON
    echo json_encode($events);
} catch (PDOException $e) {
    // Em caso de erro, retorna uma mensagem de erro no formato JSON
    echo json_encode(['error' => $e->getMessage()]);
}
?>