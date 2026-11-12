<?php
session_start();
if (!isset($_SESSION['usuario_id']) || strtolower($_SESSION['usuario_level'] ?? '') === 'aluno') {
    header("Location: index.php");
    exit;
}

require_once __DIR__ . '/../conexao.php';

$id = $_GET['id'] ?? null;
// Não permite desativar a própria conta
if ($id && $id != $_SESSION['usuario_id']) {
    $stmt = $pdo->prepare("UPDATE usuario SET ativo = 0 WHERE idUsuario = ?");
    $stmt->execute([$id]);
}

header("Location: tabela_Usuarios.php");
exit;
