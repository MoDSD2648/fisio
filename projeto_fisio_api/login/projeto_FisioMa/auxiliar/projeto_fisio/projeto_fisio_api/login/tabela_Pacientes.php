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
    <title>FISIOTERAPIA - UNIP</title>
    <link href="https://fonts.googleapis.com/css2?family=Rubik&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles/cadastrar.css">
    <link rel="stylesheet" href="styles/usuarios.css">
  </head>
  <body>
    <header>
      <div class="logo">
        <img src="img/logoUnipHeader.png" alt="UNIP">
        <h1>Usuários</h1>
      </div>
      <?php include 'acesso.php';?>
      <?php include 'menu.php';?>
    </header>


    <section class="conteudo-vazio">
      <table class="table table-striped">
        <thead>
          <tr>
            <th scope="col">Nome</th>
            <th scope="col">Data Nascimento</th>
            <th scope="col">Endereço</th>
            <th scope="col">Telefone</th>
            <th scope="col">Editar</th>
            <th scope="col">Remover</th>
          </tr>
        </thead>
        <tbody>

          <?php
            require_once __DIR__ . '/../conexao.php';

            // Puxa toda a tabela usuario
            $stmt = $pdo->prepare("SELECT nome, dataNascimento, endereco, telefone FROM paciente WHERE ativo = 1");
            $stmt->execute();

            if ($stmt->rowCount() == 0) {
                //echo "<script>alert('Horário indisponível!');window.location='agendar.php';</script>";
                echo "<h1>Nenhum usuário encontrado!</h1>";
                exit;
            }

            // Monta a tabela de usuarios no HTML
            foreach($stmt as $linha)
            {
              echo "<tr>";
              echo "  <td scope=\"row\">$linha[nome]</td>";
              echo "  <td scope=\"row\">$linha[dataNascimento]</td>";
              echo "  <td scope=\"row\">$linha[endereco]</td>";
              echo "  <td scope=\"row\">$linha[telefone]</td>";
              echo "  <td scope=\"row\"><a href=\"#\">Editar</a></td>";
              echo "  <td scope=\"row\"><a href=\"#\">Remover</a></td>";
              echo "</tr>";
            }

          ?>
        </tbody>
      </table>
    </section>
  </body>
</html>
