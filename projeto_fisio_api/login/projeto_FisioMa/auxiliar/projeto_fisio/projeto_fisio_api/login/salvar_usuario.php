<?php
require_once __DIR__ . '/../conexao.php';
//isso é uma api?! entao vamos ter que colocar na pasta API
$login = $_POST['login'];
$nome = $_POST['nome'];
$email = $_POST['email'];
$senha = $_POST['senha'];
$telefone = $_POST['telefone'];
$level = $_POST['level'];

// Protege a senha
$senhaHash = password_hash($senha, PASSWORD_DEFAULT);

// Gera a API Key automaticamente
$apiKey = bin2hex(random_bytes(32));

// Verifica se email já existe
$stmt = $pdo->prepare("SELECT idUsuario FROM usuario WHERE email = ?");
$stmt->execute([$email]);

if ($stmt->rowCount() > 0) {
    echo "<script>alert('Este email já está cadastrado!');window.location='cadastrar.php';</script>";
    exit;
}

// Insere no banco

echo $level;
$stmt = $pdo->prepare("INSERT INTO usuario ( login, nome, email, senha, telefone, level) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->execute([$login, $nome, $email, $senhaHash, $telefone, $level]);

echo "<script>alert('Usuário cadastrado com sucesso!');window.location='tabela_Usuarios.php';</script>";
