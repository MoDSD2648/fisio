<?php
session_start();

$pagina_atual = 'painel';

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
    <link rel="icon" type="image/x-icon" href=".\img\icon.ico">
    <title>FISIOTERAPIA - UNIP</title>
    <link href="https://fonts.googleapis.com/css2?family=Rubik&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles/cadastrar.css">
  </head>

  <body>
    <header>
      <div class="logo">
        <img src="img/logoUnipHeader.png" alt="UNIP">
        <h1>Cadastrar novo usuário</h1>
      </div>
      <?php include 'acesso.php';?>
      <?php include 'menu.php'; ?>
    </header>

    <div class="form-cadastro">
      <section class="conteudo-vazio">
        <form action="salvar_agendamento.php" method="post">
          <h2>Dados da agenda</h2>

          <div class="data">
            <label for="data">Data:</label>
            <input type="date" name="data" required>
          </div>
          <div class="hora">
            <label for="hora">Hora:</label>
            <select name="hora" required>
          </div>

          <option value="">Selecione</option>
          <option value="13:10">13:10</option>
          <option value="14:10">14:10</option>
          <option value="15:30">15:30</option>
          <option value="16:30">16:30</option>

          </select>

          <label for="paciente">Paciente:</label>
          <select name="paciente" id="paciente">
          <?php
          require_once __DIR__ ."/Puxa_Pacientes.php";

          echo "<option value=''></option>";

          foreach($stmt as $paciente){
          echo "<option value='{$paciente['idPaciente']}'>{$paciente['nome']}</option>";
          }
          ?>
          </select>

          <label for="setor">Setor:</label>
          <select name="setor" id="setor" required>

          <?php
          require_once __DIR__ ."/Puxa_setores.php";

          echo "<option value=''></option>";

          foreach($stmt as $setor){
            echo "<option value='{$setor['idSetor']}'>{$setor['nome']}</option>";
          }
          ?>
          </select>

          <label for="usuario">Usuario:</label>
          <select name="usuario" id="usuario">
          <?php
          require_once __DIR__ ."/Puxa_Usuarios.php";

          echo "<option value=''></option>";

          foreach($stmt as $usuario){
            echo "<option value='{$usuario['idUsuario']}'>{$usuario['nome']}</option>";
          }
          ?>
          </select>

          <label for="status">Status:</label>
          <select id="status" name="status" required>
            <option value="Marcada">Marcada</option>
            <option value="Confirmada">Confirmada</option>
          </select>

          <label for="observacoes">Obervações:</label>
          <input type="text" id="observacoes" name="observacoes">

          <button type="submit">Agendar</button>
        </form>
      </section>
    </div>
  </body>
</html>
