<?php
require 'conexao.php';

$stmt = $pdo->query("SELECT * FROM api_keys ORDER BY created_at DESC");
$chaves = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Painel de API Keys</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    
</body>
</html>
