<?php
session_start();

$pagina_atual = 'usuarios';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: index.php");
    exit;
}

if (strtolower($_SESSION['usuario_level'] ?? '') === "aluno") {
    header("Location: painel.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/x-icon" href="img/icon.ico">
    <title>Cadastrar Novo Usuário - UNIP</title>
    <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="styles/painel.css">
    <link rel="stylesheet" href="styles/cadastrarPaciente.css">
</head>
<body>
    <header>
        <div class="logo">
            <img src="img/logoUnipHeader.png" alt="UNIP">
            <h1>Cadastrar Novo Usuário</h1>
        </div>
        <?php include 'acesso.php';?>
    </header>
    <?php include 'menu.php'; ?>

    <section class="conteudo-vazio">
        <form class="form-cadastro" action="salvar_usuario.php" method="POST">
            <h2>Novo Usuário do Sistema</h2>

            <label for="login">Login (RA ou Matrícula):</label>
            <input type="text" id="login" name="login" placeholder="Ex: G743962" required>

            <label for="nome">Nome Completo:</label>
            <input type="text" id="nome" name="nome" placeholder="Nome do usuário" required>

            <label for="email">E-mail Institucional ou Pessoal:</label>
            <input type="email" id="email" name="email" placeholder="email@exemplo.com" required>

            <label for="senha">Senha:</label>
            <input type="password" id="senha" name="senha" placeholder="Digite uma senha segura" required>

            <label for="telefone">Telefone:</label>
            <input type="text" id="telefone" name="telefone" placeholder="(00) 00000-0000">

            <label for="level">Nível de Acesso:</label>
            <select name="level" id="level" onchange="toggleSetorField()" required>
                <option value="">Selecione o nível</option>
                <option value="Admin">Admin</option>
                <option value="Professor">Professor</option>
                <option value="Profissional">Profissional</option>
                <option value="Aluno">Aluno</option>
            </select>

            <!-- Campo de setor que será exibido apenas para alunos -->
            <div id="setor-field" style="display: none;">
                <label for="setor">Setor Principal:</label>
                <select name="setor" id="setor">
                    <option value="">Selecione o setor</option>
                    <?php
                    require_once __DIR__ . '/../conexao.php';
                    $stmtSetores = $pdo->query("SELECT idSetor, nome FROM setor ORDER BY nome");
                    while ($setor = $stmtSetores->fetch(PDO::FETCH_ASSOC)) {
                        echo "<option value='{$setor['idSetor']}'>" . htmlspecialchars($setor['nome']) . "</option>";
                    }
                    ?>
                </select>
            </div>

            <div style="display: flex; gap: 10px; margin-top: 15px;">
                <button type="submit" style="flex: 1;">Cadastrar Usuário</button>
                <a href="tabela_Usuarios.php" style="display: inline-block; padding: 10px 15px; background: #6c757d; color: white; text-decoration: none; border-radius: 4px; text-align: center;">Voltar</a>
            </div>
        </form>

        <script>
            function toggleSetorField() {
                const level = document.getElementById('level').value.toLowerCase();
                const setorField = document.getElementById('setor-field');

                if (level === 'aluno') {
                    setorField.style.display = 'block';
                } else {
                    setorField.style.display = 'none';
                }
            }
        </script>
    </section>
</body>
</html>
