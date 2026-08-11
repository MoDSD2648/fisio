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


    <section class="conteudo-vazio">
      <form class="form-cadastro" action="salvar_agendamento.php" method="post">
        <h2>Dados da agenda</h2>
        <label for="data">Data:</label>
        <input type="date" id="data" name="data" required>

        <label for="hora">Hora:</label>
        <input type="time" id="hora" name="hora" required>

        <!--
        <label for="paciente">Paciente:</label>
        <input type="text" id="paciente" name="paciente" required>
        -->

        <label for="paciente">Paciente:</label>
        <select name="paciente" id="paciente">
          <?php
            require_once __DIR__ ."/Puxa_Pacientes.php";

            echo "<option value=\"\"> </option>";
            //sort($stmt);

            foreach($stmt as $paciente)
            {
              echo "<option value=\"$paciente[idPaciente]\">$paciente[nome]</option>";
            }
          ?>
        </select>

        <!--
        <label for="usuario">Usuario:</label>
        <input type="text" id="usuario" name="usuario" required>
        -->
        <label for="usuario">Usuario:</label>
        <select name="usuario" id="usuario">
          <?php
            require_once __DIR__ ."/Puxa_Usuarios.php";

            echo "<option value=\"\"> </option>";
            //sort($stmt);

            foreach($stmt as $usuario)
            {
              echo "<option value=\"$usuario[idUsuario]\">$usuario[nome]</option>";
            }
          ?>
        </select>

        <label for="status">Status:</label>
        <input type="text" id="status" name="status" required>

        <label for="observacoes">Obervações:</label>
        <input type="text" id="observacoes" name="observacoes">

        <button type="submit">Agendar</button>
      </form>
    </section>
  </body>
</html>
