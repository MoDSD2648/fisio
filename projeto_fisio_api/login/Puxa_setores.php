<?php
require_once __DIR__ . '/../conexao.php';

// Puxa tabela setor
$stmt = $pdo->prepare("SELECT idSetor, nome FROM setor ORDER BY nome");
$stmt->execute();
