<?php
require 'conexao.php';

$id = $_GET['id'];
$acao = $_GET['acao'];

$ativo = ($acao === 'ativar') ? 1 : 0;
$stmt = $pdo->prepare("UPDATE api_keys SET active = ? WHERE id = ?");
$stmt->execute([$ativo, $id]);

header("Location: index.php");
exit;
