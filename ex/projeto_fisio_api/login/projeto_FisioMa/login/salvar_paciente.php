<?php
require_once __DIR__ . '/../conexao.php';
//isso é uma api?! entao vamos ter que colocar na pasta API
$nome = $_POST['nome'];
$cpf = $_POST['cpf'];
$dataNascimento = $_POST['nascimento'];
$telefone = $_POST['telefone'];
$endereco = $_POST['endereco'];

// Protege a senha
//$senhaHash = password_hash($senha, PASSWORD_DEFAULT);

// Gera a API Key automaticamente
//$apiKey = bin2hex(random_bytes(32));

// Verifica se email já existe
$stmt = $pdo->prepare("SELECT idPaciente FROM paciente WHERE nome = ?");
$stmt->execute([$nome]);

if ($stmt->rowCount() > 0) {
    echo "<script>alert('Este paciente já está cadastrado!');window.location='cadastrar.php';</script>";
    exit;
}

// Insere no banco

echo $level;
$stmt = $pdo->prepare("INSERT INTO paciente (nome, cpfPaciente, dataNascimento, telefone, endereco) VALUES (?, ?, ?, ?)");
$stmt->execute([$nome, $cpf, $dataNascimento, $telefone, $endereco]);

echo "<script>alert('Paciente cadastrado com sucesso!');window.location='tabela_Usuarios.php';</script>";
