<?php
require_once __DIR__ . '/../conexao.php';

$login = trim($_POST['login'] ?? '');
$nome = trim($_POST['nome'] ?? '');
$email = trim($_POST['email'] ?? '');
$senha = $_POST['senha'] ?? '';
$telefone = trim($_POST['telefone'] ?? '');
$level = ucfirst(strtolower(trim($_POST['level'] ?? 'Aluno')));
$idSetor = !empty($_POST['setor']) ? $_POST['setor'] : null;

if (empty($login) || empty($nome) || empty($email) || empty($senha)) {
    echo "<script>alert('Por favor, preencha todos os campos obrigatórios!');window.location='cadastrarusuario.php';</script>";
    exit;
}

// Verifica se email ou login já existem
$stmt = $pdo->prepare("SELECT idUsuario FROM usuario WHERE email = ? OR login = ?");
$stmt->execute([$email, $login]);

if ($stmt->rowCount() > 0) {
    echo "<script>alert('Este e-mail ou login já está cadastrado!');window.location='cadastrarusuario.php';</script>";
    exit;
}

$senhaHash = password_hash($senha, PASSWORD_DEFAULT);
$apiKey = bin2hex(random_bytes(16));

try {
    $stmt = $pdo->prepare("INSERT INTO usuario (login, nome, email, senha, telefone, level, api_key, ativo) VALUES (?, ?, ?, ?, ?, ?, ?, 1)");
    $stmt->execute([$login, $nome, $email, $senhaHash, $telefone, $level, $apiKey]);
    $idUsuario = $pdo->lastInsertId();

    if (strtolower($level) === 'aluno' && $idSetor) {
        $stmtSetor = $pdo->prepare("INSERT INTO usuario_setor (idUsuario, idSetor) VALUES (?, ?)");
        $stmtSetor->execute([$idUsuario, $idSetor]);
    }

    echo "<script>alert('Usuário cadastrado com sucesso!');window.location='tabela_Usuarios.php';</script>";
} catch (Exception $e) {
    echo "<script>alert('Erro ao cadastrar usuário: " . addslashes($e->getMessage()) . "');window.location='cadastrarusuario.php';</script>";
}
