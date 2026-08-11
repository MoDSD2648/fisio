<?php
require_once 'auth.php';

header('Content-Type: application/json');
$headers = getHeaders();

if (!isAuthorized($headers)) {
    http_response_code(401);
    echo json_encode(['error' => 'Não autorizado']);
    exit;
}

// Exemplo de retorno da API
echo json_encode([
    'status' => 'sucesso',
    'mensagem' => 'Você está autenticado!',
    'hora' => date('Y-m-d H:i:s')
]);
