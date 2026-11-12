<?php
session_start();

$pagina_atual = 'espera';

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
  <title>Cadastrar Lista de Espera - UNIP</title>
  <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="styles/painel.css">
  <link rel="stylesheet" href="styles/cadastrarPaciente.css">
</head>
<body>
  <header>
    <div class="logo">
      <img src="img/logoUnipHeader.png" alt="UNIP">
      <h1>Cadastrar na Lista de Espera</h1>
    </div>
    <?php include 'acesso.php';?>
  </header>
  <?php include 'menu.php'; ?>

  <section class="conteudo-vazio">
    <form class="form-cadastro" action="salvar_espera.php" method="POST">
      <h2>Cadastro na Lista de Espera</h2>

      <label for="nome">Nome Completo</label>
      <input type="text" id="nome" name="nome" required>

      <label for="idade">Idade</label>
      <input type="number" id="idade" name="idade" min="0" max="130" required>

      <label for="telefone">Telefone</label>
      <input type="tel" id="telefone" name="telefone" placeholder="(00) 00000-0000" required>

      <label for="obs">Observações / Diagnóstico preliminar</label>
      <input type="text" id="obs" name="obs" placeholder="Motivo da consulta, observações">

      <label for="prior">Prioridade</label>
      <select id="prior" name="prior" required>
        <option value="0">Alta</option>
        <option value="1" selected>Média</option>
        <option value="2">Baixa</option>
      </select>

      <label for="status">Status</label>
      <select id="status" name="status" required>
        <option value="aguardando" selected>Aguardando</option>
        <option value="agendado">Agendado</option>
        <option value="confirmado">Confirmado</option>
        <option value="não atendeu">Não atendeu</option>
      </select>

      <div style="display: flex; gap: 10px; margin-top: 15px;">
        <button type="submit" style="flex: 1;">Salvar na Lista</button>
        <a href="tabela_Espera.php" style="display: inline-block; padding: 10px 15px; background: #6c757d; color: white; text-decoration: none; border-radius: 4px; text-align: center;">Voltar</a>
      </div>
    </form>
  </section>
</body>
</html>
