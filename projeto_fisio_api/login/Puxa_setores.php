<?php
    require_once __DIR__ . '/../conexao.php';

    // Puxa toda a tabela usuario
    $stmt = $pdo->prepare("SELECT idSetor, nome FROM Setor");
    $stmt->execute();


?>