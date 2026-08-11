<?php
require 'conexao.php';

$domain = $_POST['domain'];
$apiKey = $_POST['api_key'];

$stmt = $pdo->prepare("INSERT INTO api_keys (api_key, domain) VALUES (?, ?)");
$stmt->execute([$apiKey, $domain]);

header("Location: index.php");
exit;
