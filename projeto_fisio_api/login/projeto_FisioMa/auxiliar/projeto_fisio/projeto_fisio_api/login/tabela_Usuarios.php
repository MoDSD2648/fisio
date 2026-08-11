<?php
$pagina_atual='usuarios';
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
      <?php include 'menu.php'; ?>
    </header>
    <section class="conteudo-vazio">
      <table class="table table-striped">
        <thead>
          <tr>
            <th scope="col">Login</th>
            <th scope="col">Nome</th>
            <th scope="col">Email</th>
            <th scope="col">Telefone</th>
            <th scope="col">Level</th>
            <th scope="col">Editar</th>
            <th scope="col">Excluir</th>
          </tr>
        </thead>
        <tbody>
          <?php
            require_once __DIR__ . '/../conexao.php';

            // Puxa toda a tabela usuario
            $stmt = $pdo->prepare("SELECT login, nome, email, telefone, level FROM usuario WHERE ativo = 1");
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
              echo "  <td scope=\"row\">$linha[login]</td>";
              echo "  <td scope=\"row\">$linha[nome]</td>";
              echo "  <td scope=\"row\">$linha[email]</td>";
              echo "  <td scope=\"row\">$linha[telefone]</td>";
              echo "  <td scope=\"row\">$linha[level]</td>";
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
