<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastrar Novo Usuário</title>
    <link href="https://fonts.googleapis.com/css2?family=Rubik&display=swap" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="styles/painel.css">
</head>
<body>
    <header>
        <div class="logo">
            <img src="img/logoUnipHeader.png" alt="UNIP">
            <h1>Agenda de Consultas</h1>
        </div>
        <div class="user">
            <div class="user-info">
                <span class="nome-negrito"><?= $_SESSION['usuario_nome'] ?></span><br>
                    <!--<?= $_SESSION['api_key'] ?>--> 
                <span><?= $_SESSION['usuario_email'] ?></span><a href="sair.php">Sair</a>
            </div>
            <button class="sair">
                <img src="img/sign-out-alt-solid.svg" alt="Sair" style="width: 16px; vertical-align: middle; margin-right: 5px;">
                Sair
            </button>
        </div>
        <?php include 'menu.php'; ?>
    </header>

    <div class="container">
        <h2>Cadastrar Novo Usuário</h2>
        <form action="salvar_usuario.php" method="POST">
            <input type="text" name="login" placeholder="Login" required>
            <input type="text" name="nome" placeholder="nome" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="senha" placeholder="Senha" required>
            <input type="text" name="telefone" placeholder="Telefone (opcional)">
            <select type="text" name="level" required>
                <option value="">Selecione o nível</option>
                <option value="admin">Admin</option>
                <option value="professor">Professor</option>
                <option value="profissional">Profissional</option>
                <option value="aluno">Aluno</option>
            </select>
            <button type="submit">Cadastrar</button>
        </form>
    </div>
</body>
</html>
