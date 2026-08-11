<?php
// CONFIGURAÇÕES
$apiUrl = 'http://localhost/projeto_fisio_api/api/index.php'; // URL da sua API
$apiKey = '8a647cdc945377c49251926cea7d1167ab0a9e9b3b98dbef52d6c64aa1059e35'; // 🔑 Coloque aqui sua chave gerada
$domain = 'localhost'; // 🌐 O domínio autorizado
$secretKey = 'sua_chave_super_secreta'; // 🔒 Igual ao que está no config.php

// GERAÇÃO DO HASH (assinatura de segurança)
$hash = hash_hmac('sha256', $domain, $secretKey);

// MONTAR OS HEADERS
$headers = [
    "X-API-KEY: $apiKey",
    "X-DOMAIN: $domain",
    "X-HASH: $hash"
];

// INICIAR CURL
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $apiUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

// EXECUTAR
$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

// ERRO?
if (curl_errno($ch)) {
    echo 'Erro: ' . curl_error($ch);
} else {
    echo "HTTP $httpCode\n";
    echo "Resposta:\n$response";
}

curl_close($ch);
