<?php
require_once __DIR__ . '/../conexao.php';

$nome = trim($_POST['nome'] ?? '');
$idade = (int)($_POST['idade'] ?? 0);
$telefone = trim($_POST['telefone'] ?? '');
$obs = trim($_POST['obs'] ?? '');
$prior = isset($_POST['prior']) ? (int)$_POST['prior'] : 1;
$status = trim($_POST['status'] ?? 'aguardando');

if (empty($nome) || empty($telefone)) {
    echo "<script>alert('Por favor, preencha os campos obrigatórios!');window.location='cadastrarespera.php';</script>";
    exit;
}

date_default_timezone_set('America/Sao_Paulo');
$data = date('Y-m-d H:i:s');

try {
    $stmt = $pdo->prepare("INSERT INTO lista_espera (dataLigacao, nome, idade, telefone, observacoes, prioridade, status, ativo) VALUES (?, ?, ?, ?, ?, ?, ?, 1)");
    $stmt->execute([$data, $nome, $idade, $telefone, $obs, $prior, $status]);

    echo "<script>alert('Cadastrado na lista de espera com sucesso!');window.location='tabela_Espera.php';</script>";
} catch (Exception $e) {
    echo "<script>alert('Erro ao salvar: " . addslashes($e->getMessage()) . "');window.location='cadastrarespera.php';</script>";
}
