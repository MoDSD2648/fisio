<?php
function getHeaders() {
    return getallheaders();
}

function logAccess($pdo, $apiKey, $endpoint, $ip) {
    $stmt = $pdo->prepare("INSERT INTO api_logs (api_key, endpoint, ip_address) VALUES (?, ?, ?)");
    $stmt->execute([$apiKey, $endpoint, $ip]);
}

function checkRateLimit($pdo, $apiKey, $ip) {
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM api_logs WHERE api_key = ? AND ip_address = ? AND request_time > NOW() - INTERVAL 1 MINUTE");
    $stmt->execute([$apiKey, $ip]);
    $count = $stmt->fetchColumn();
    return $count < RATE_LIMIT;
}
