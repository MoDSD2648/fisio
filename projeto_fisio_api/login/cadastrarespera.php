<?php
session_start();
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
  <title>Cadastrar Lista de Espera - UNIP</title>
  <link href="https://fonts.googleapis.com/css2?family=Rubik&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="styles/cadastrarPaciente.css">
</head>
<body>
  <header>
    <div class="logo">
      <img src="img/logoUnipHeader.png" alt="UNIP">
      <h1>Cadastrar na lista de espera</h1>
    </div>
    <?php include 'acesso.php';?>
    <?php include 'menu.php'; ?>
  </header>

  <section class="conteudo-vazio">
    <form class="form-cadastro" action="salvar_espera.php" method="POST">
      <h2>Cadastro de lista de espera</h2>

      <label for="nome">Nome Completo</label>
      <input type="text" id="nome" name="nome" required>

      <label for="idade">Idade</label>
      <input type="number" id="idade" name="idade" required>

      <label for="telefone">Telefone</label>
      <input type="tel" id="telefone" name="telefone" placeholder="(00) 00000-0000">

      <label for="obs">Observações</label>
      <input type="text" id="obs" name="obs">

      <label for="prior">Prioridade</label>
      <select id="prior" name="prior">
        <option value="0">Baixa</option>
        <option value="1">Média</option>
        <option value="2">Alta</option>
      </select>

      <label for="status">Status</label>
      <select id="status" name="status">
        <option value="aguardando">Aguardando</option>
        <option value="agendado">Agendado</option>
        <option value="confirmado">Confirmado</option>
        <option value="não atendeu">Não atendeu</option>
      </select>

      <button type="submit">Salvar na lista</button>
    </form>
  </section>
</body>
</html>
