<?php
require_once __DIR__ . '/../conexao.php';

$nome = $_POST['nome'];
$idade = $_POST['idade'];
$telefone = $_POST['telefone'];
$obs = $_POST['obs'];
$prior = $_POST['prior'];
$status = $_POST['status'];

date_default_timezone_set('Brazil/East');
$data = date('Y/m/d h:i:s a', time());

// Insere no banco
$stmt = $pdo->prepare("INSERT INTO lista_espera (dataLigacao, nome, idade, telefone, observacoes, prioridade, status) VALUES (?, ?, ?, ?, ?, ?, ?)");
$stmt->execute([$data, $nome, $idade, $telefone, $obs, $prior, $status]);

echo "<script>alert('Cadastrado na lista de espera com sucesso!');window.location='painel.php';</script>";