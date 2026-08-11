<?php
require_once __DIR__ . '/../conexao.php';

$login = $_POST['login'];
$nome = $_POST['nome'];
$email = $_POST['email'];
$senha = $_POST['senha'];
$telefone = $_POST['telefone'];
$level = $_POST['level'];
$idSetor = isset($_POST['setor']) ? $_POST['setor'] : null; // Verifica se o setor foi enviado

// Protege a senha
$senhaHash = password_hash($senha, PASSWORD_DEFAULT);

// Verifica se email já existe
$stmt = $pdo->prepare("SELECT idUsuario FROM usuario WHERE email = ?");
$stmt->execute([$email]);

if ($stmt->rowCount() > 0) {
    echo "<script>alert('Este email já está cadastrado!');window.location='cadastrarusuario.php';</script>";
    exit;
}

// Insere o usuário na tabela `usuario`
$stmt = $pdo->prepare("INSERT INTO usuario (login, nome, email, senha, telefone, level) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->execute([$login, $nome, $email, $senhaHash, $telefone, $level]);

// Obtém o ID do usuário recém-criado
$idUsuario = $pdo->lastInsertId();

// Se o nível for "aluno", insere o relacionamento na tabela `usuario_setor`
if ($level === 'aluno' && $idSetor) {
    $stmt = $pdo->prepare("INSERT INTO usuario_setor (idUsuario, idSetor) VALUES (?, ?)");
    $stmt->execute([$idUsuario, $idSetor]);
}

echo "<script>alert('Usuário cadastrado com sucesso!');window.location='tabela_Usuarios.php';</script>";