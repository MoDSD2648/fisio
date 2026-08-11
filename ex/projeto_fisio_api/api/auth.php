<?php
require_once 'db.php';
require_once 'utils.php';

function isAuthorized($headers) {
    if (!isset($headers['X-API-KEY']) || !isset($headers['X-DOMAIN']) || !isset($headers['X-HASH'])) {
        return false;
    }

    $apiKey = $headers['X-API-KEY'];
    $domain = $headers['X-DOMAIN'];
    $hash = $headers['X-HASH'];

    $pdo = dbConnect();
    $stmt = $pdo->prepare("SELECT * FROM api_keys WHERE api_key = ? AND domain = ? AND active = 1");
    $stmt->execute([$apiKey, $domain]);
    $keyData = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$keyData) return false;

    // Verifica HMAC
    $expectedHash = hash_hmac('sha256', $domain, SECRET_KEY);
    if (!hash_equals($expectedHash, $hash)) return false;

    // Rate Limiting simples
    $ip = $_SERVER['REMOTE_ADDR'];
    if (!checkRateLimit($pdo, $apiKey, $ip)) return false;

    // Log de acesso
    logAccess($pdo, $apiKey, $_SERVER['REQUEST_URI'], $ip);

    return true;
}
