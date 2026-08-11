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
  <title>Cadastrar Paciente - UNIP</title>
  <link href="https://fonts.googleapis.com/css2?family=Rubik&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="styles/cadastrarPaciente.css">
</head>
<body>
  <header>
    <div class="logo">
      <img src="img/logoUnipHeader.png" alt="UNIP">
      <h1>Cadastrar novo paciente</h1>
    </div>
    <?php include 'acesso.php';?>
    <?php include 'menu.php'; ?>
  </header>

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

      <label for="endereco">Endereco</label>
      <input type="text" id="endereco" name="endereco">

      <button type="submit">Salvar Paciente</button>
    </form>

    <script>

        // Get the query string from the URL
        var params = new URLSearchParams(window.location.search);
  
        // Retrieve the value of the 'value' parameter
        var value = params.get('name');
        var entrada = value.split("||");
  
        document.getElementById("nome").value = entrada[0];
        console.log(entrada[0]);
        document.getElementById("telefone").value = entrada[1];
        console.log(entrada[1]);

        //console.log(value); // Outputs: 123
      
    </script>


  </section>
</body>
</html>
