<?php
require_once __DIR__ . '/../conexao.php';

$data = $_POST['data'];
$hora = $_POST['hora'];
$idPaciente = $_POST['paciente'];
$idUsuario = $_POST['usuario'];
$idSetor = $_POST['setor'];
$status = $_POST['status'];
$observacoes = $_POST['observacoes'];

// Verifica se a data, horário e setor está disponível
$stmt = $pdo->prepare("SELECT idAgenda 
FROM agenda 
WHERE data = ? 
AND hora = ? 
AND idSetor = ?
AND idPaciente =?");
$stmt->execute([$data, $hora, $idSetor, $idPaciente]);

if ($stmt->rowCount() > 0) {
    //echo "<script>alert('Horário indisponível!');window.location='agendar.php';</script>";
    echo "<script>alert('Horário indisponível!');window.location='agendar.php';</script>";
    exit;
}

// Insere no banco
$stmt = $pdo->prepare("INSERT INTO agenda (data, hora, idPaciente, idUsuario, status, observacoes) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->execute([$data, $hora, $idPaciente, $idUsuario, $status, $observacoes]);

echo "<script>alert('Agendado com sucesso!');window.location='painel.php';</script>";