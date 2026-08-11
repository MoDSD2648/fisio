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
    <link rel="stylesheet" href="styles/cadastrarPaciente.css">
</head>
<body>
    <header>
        <div class="logo">
            <img src="img/logoUnipHeader.png" alt="UNIP">
            <h1>Agenda de Consultas</h1>
        </div>
        <?php include 'acesso.php';?>
        <?php include 'menu.php'; ?>
    </header>

    <section class="conteudo-vazio">
        <form class="form-cadastro" action="salvar_usuario.php" method="POST">
            <h2>Cadastrar Novo Usuário</h2>

            <label for="login">Login:</label>
            <input type="text" name="login" placeholder="Login" required>

            <label for="nome">Nome:</label>
            <input type="text" name="nome" placeholder="Nome" required>

            <label for="email">Email:</label>
            <input type="email" name="email" placeholder="Email" required>

            <label for="senha">Senha:</label>
            <input type="password" name="senha" placeholder="Senha" required>

            <label for="telefone">Telefone:</label>
            <input type="text" name="telefone" placeholder="Telefone (opcional)">

            <label for="level">Level:</label>
            <select type="text" name="level" id="level" onchange="toggleSetorField()" required>
                <option value="">Selecione o nível</option>
                <option value="admin">Admin</option>
                <option value="professor">Professor</option>
                <option value="profissional">Profissional</option>
                <option value="aluno">Aluno</option>
            </select>

            <!-- Campo de setor que será exibido apenas para alunos -->
            <div id="setor-field" style="display: none;">
            <label for="setor">Setor:</label>
                <select name="setor" id="setor">
                    <option value="">Selecione o setor</option>
                    <option value="1">Ortopedia</option>
                    <option value="2">Paralisia Facial</option>
                    <option value="3">Neurologia Adulto</option>
                    <option value="4">Neurologia Infantil</option>
                    <option value="5">Reabilitação Pulmonar</option>
                </select>
            </div>

            <button type="submit">Cadastrar</button>
        </form>

        <script>
            // Função para exibir ou ocultar o campo de setor
            function toggleSetorField() {
                const level = document.getElementById('level').value;
                const setorField = document.getElementById('setor-field');

                if (level === 'aluno') {
                    setorField.style.display = 'block'; // Exibe o campo de setor
                } else {
                    setorField.style.display = 'none'; // Oculta o campo de setor
                }
            }
        </script>
    </section>
</body>
</html>
