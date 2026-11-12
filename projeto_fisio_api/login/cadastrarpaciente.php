<?php
session_start();

$pagina_atual = 'pacientes';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" type="image/x-icon" href="img/icon.ico">
  <title>Cadastrar Paciente - UNIP</title>
  <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="styles/painel.css">
  <link rel="stylesheet" href="styles/cadastrarPaciente.css">
</head>
<body>
  <header>
    <div class="logo">
      <img src="img/logoUnipHeader.png" alt="UNIP">
      <h1>Cadastrar novo paciente</h1>
    </div>
    <?php include 'acesso.php';?>
  </header>
  <?php include 'menu.php'; ?>

  <section class="conteudo-vazio">
    <form class="form-cadastro" action="salvar_paciente.php" method="POST">
      <h2>Cadastro de Paciente</h2>

      <label for="nome">Nome Completo</label>
      <input type="text" id="nome" name="nome" required>

      <label for="cpf">CPF</label>
      <input type="text" id="cpf" name="cpf" placeholder="000.000.000-00" required>

      <label for="nascimento">Data de Nascimento</label>
      <input type="date" id="nascimento" name="nascimento" required>

      <label for="telefone">Telefone</label>
      <input type="tel" id="telefone" name="telefone" placeholder="(00) 00000-0000">

      <label for="endereco">Endereço</label>
      <input type="text" id="endereco" name="endereco" placeholder="Rua, número, bairro">

      <div style="display: flex; gap: 10px; margin-top: 15px;">
        <button type="submit" style="flex: 1;">Salvar Paciente</button>
        <a href="tabela_Pacientes.php" style="display: inline-block; padding: 10px 15px; background: #6c757d; color: white; text-decoration: none; border-radius: 4px; text-align: center;">Voltar</a>
      </div>
    </form>

    <script>
        var params = new URLSearchParams(window.location.search);
        var value = params.get('name');
        if (value) {
            var entrada = value.split("||");
            if (entrada[0]) document.getElementById("nome").value = entrada[0];
            if (entrada[1]) document.getElementById("telefone").value = entrada[1];
        }
    </script>
  </section>
</body>
</html>
