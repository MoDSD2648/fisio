<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: index.php");
    exit;
}

require_once __DIR__ . '/../conexao.php';

$id = $_GET['id'] ?? null;
if ($id) {
    $stmt = $pdo->prepare("UPDATE paciente SET ativo = 0 WHERE idPaciente = ?");
    $stmt->execute([$id]);
}

header("Location: tabela_Pacientes.php");
exit;
