<?php
session_start();
require_once __DIR__ . '/../conexao.php';

// Verifica se os campos 'email' e 'senha' foram enviados
if (!isset($_POST['login']) || !isset($_POST['senha'])) {
    echo "<script>alert('Por favor, preencha todos os campos.');window.location='index.php';</script>";
    exit;
}

$email = $_POST['login'];
$senha = $_POST['senha'];

try {
    // Verifica se o usuário existe e está ativo
    $stmt = $pdo->prepare("SELECT * FROM usuario WHERE login = ? AND ativo = 1");
    $stmt->execute([$email]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($usuario && password_verify($senha, $usuario['senha'])) {
        // Login bem-sucedido
        $_SESSION['usuario_id'] = $usuario['idUsuario'];
        $_SESSION['usuario_login'] = $usuario['login'];
        $_SESSION['usuario_nome'] = $usuario['nome'];
        $_SESSION['usuario_login'] = $usuario['login'];
        $_SESSION['usuario_email'] = $usuario['email'];
        $_SESSION['usuario_telefone'] = $usuario['telefone'];
        $_SESSION['usuario_level'] = $usuario['level'];
        $_SESSION['api_key'] = $usuario['api_key'];
        header("Location: painel.php");
        exit;
    } else {
        // Login inválido
        echo "<script>alert('Login inválido');window.location='index.php';</script>";
    }
} catch (PDOException $e) {
    // Tratamento de erro no banco de dados
    echo "<script>alert('Erro no banco de dados: " . $e->getMessage() . "');window.location='index.php';</script>";
}