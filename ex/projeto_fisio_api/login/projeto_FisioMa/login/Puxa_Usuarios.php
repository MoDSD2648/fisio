<?php
    require_once __DIR__ . '/../conexao.php';

    // Puxa toda a tabela usuario
    $stmt = $pdo->prepare("SELECT idUsuario, login, nome, email, telefone, level FROM usuario WHERE ativo = 1 ORDER BY nome");
    $stmt->execute();

    if ($stmt->rowCount() == 0) {
        //echo "<script>alert('Horário indisponível!');window.location='agendar.php';</script>";
        echo "<h1>Nenhum usuário encontrado!</h1>";
        exit;
    }

?>