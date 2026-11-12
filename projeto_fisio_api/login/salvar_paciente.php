<?php
require_once __DIR__ . '/../conexao.php';

$nome = trim($_POST['nome'] ?? '');
$cpf = trim($_POST['cpf'] ?? '');
$dataNascimento = $_POST['nascimento'] ?? null;
$telefone = trim($_POST['telefone'] ?? '');
$endereco = trim($_POST['endereco'] ?? '');

if (empty($nome) || empty($cpf) || empty($dataNascimento)) {
    echo "<script>alert('Por favor, preencha todos os campos obrigatórios!');window.location='cadastrarpaciente.php';</script>";
    exit;
}

// Verifica se CPF já existe entre os pacientes ativos
$stmt = $pdo->prepare("SELECT idPaciente FROM paciente WHERE cpfPaciente = ? AND ativo = 1");
$stmt->execute([$cpf]);

if ($stmt->rowCount() > 0) {
    echo "<script>alert('Este CPF já está cadastrado para outro paciente!');window.location='cadastrarpaciente.php';</script>";
    exit;
}

try {
    $stmt = $pdo->prepare("INSERT INTO paciente (nome, cpfPaciente, dataNascimento, telefone, endereco, faltas, ativo) VALUES (?, ?, ?, ?, ?, 0, 1)");
    $stmt->execute([$nome, $cpf, $dataNascimento, $telefone, $endereco]);

    echo "<script>alert('Paciente cadastrado com sucesso!');window.location='tabela_Pacientes.php';</script>";
} catch (Exception $e) {
    echo "<script>alert('Erro ao cadastrar paciente: " . addslashes($e->getMessage()) . "');window.location='cadastrarpaciente.php';</script>";
}
