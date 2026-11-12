<?php
require_once __DIR__ . '/../conexao.php';

$data = $_POST['data'] ?? '';
$hora = $_POST['hora'] ?? '';
$idPaciente = $_POST['paciente'] ?? null;
$idUsuario = !empty($_POST['usuario']) ? $_POST['usuario'] : null;
$idSetor = !empty($_POST['setor']) ? $_POST['setor'] : null;
$status = $_POST['status'] ?? 'Marcada';
$observacoes = $_POST['observacoes'] ?? '';

if (empty($data) || empty($hora) || empty($idPaciente)) {
    echo "<script>alert('Por favor, preencha todos os campos obrigatórios!');window.location='agendar.php';</script>";
    exit;
}

// Verifica se o paciente já possui agendamento no mesmo dia e horário
$stmt = $pdo->prepare("SELECT idAgenda FROM agenda WHERE data = ? AND hora = ? AND idPaciente = ?");
$stmt->execute([$data, $hora, $idPaciente]);

if ($stmt->rowCount() > 0) {
    echo "<script>alert('Este paciente já possui agendamento neste mesmo dia e horário!');window.location='agendar.php';</script>";
    exit;
}

// Verifica se a coluna idSetor existe na tabela agenda
$temSetor = false;
try {
    $chk = $pdo->query("SHOW COLUMNS FROM agenda LIKE 'idSetor'");
    if ($chk && $chk->rowCount() > 0) {
        $temSetor = true;
    }
} catch (Exception $e) {}

try {
    if ($temSetor) {
        $stmt = $pdo->prepare("INSERT INTO agenda (data, hora, idPaciente, idUsuario, idSetor, status, observacoes) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$data, $hora, $idPaciente, $idUsuario, $idSetor, $status, $observacoes]);
    } else {
        $stmt = $pdo->prepare("INSERT INTO agenda (data, hora, idPaciente, idUsuario, status, observacoes) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$data, $hora, $idPaciente, $idUsuario, $status, $observacoes]);
    }

    echo "<script>alert('Agendado com sucesso!');window.location='painel.php';</script>";
} catch (Exception $e) {
    echo "<script>alert('Erro ao salvar agendamento: " . addslashes($e->getMessage()) . "');window.location='agendar.php';</script>";
}
