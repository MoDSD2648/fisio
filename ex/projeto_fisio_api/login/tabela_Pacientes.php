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
    <link rel="icon" type="image/x-icon" href=".\img\icon.ico">
    <title>FISIOTERAPIA - UNIP</title>
    <link href="https://fonts.googleapis.com/css2?family=Rubik&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles/usuarios.css">
    <link rel="stylesheet" href="styles/cadastrar.css">
    
  </head>
  <body>
    <header>
      <div class="logo">
        <img src="img/logof.png" alt="FISIOTERAPIA">
        <h1>Usuários</h1>
      </div>
      <?php include 'acesso.php';?>
      <?php include 'menu.php';?>
    </header>

    <!-- Campo para pesquisa -->
    <form method="POST" action="" class="form-pesquisa">
      <div class="input-group mb-3" style="max-width: 400px;">
        <!-- Campo de texto -->
        <input type="text" name="texto" class="form-control" placeholder="Digite a pesquisa" value="<?php echo isset($_POST['texto']) ? htmlspecialchars($_POST['texto']) : ''; ?>" />
        
        <!-- Botão de pesquisa -->
        <button type="submit" class="btn btn-primary">
          <img src="img/lupa.png" alt="Pesquisar" style="width: 20px; height: 20px;" />
        </button>
        
        <!-- Botão de voltar -->
        <button type="button" class="btn btn-secondary" onclick="limparPesquisa();">
          <img src="img/de-volta.png" alt="Voltar" style="width: 20px; height: 20px;" />
        </button>
        
        <!-- Botão de atualizar -->
        <button type="button" class="btn btn-success" onclick="window.location.reload();">
          <img src="img/atualiza.png" alt="Atualizar" style="width: 20px; height: 20px;" />
        </button>
      </div>
    </form>
    <br><br>

    <script>
    // Função para limpar o campo de pesquisa e recarregar a tabela completa
    function limparPesquisa() {
    document.querySelector('input[name="texto"]').value = ''; // Limpa o campo de texto
    document.querySelector('form').submit(); // Envia o formulário vazio para recarregar a tabela completa
    }
    </script>

    <?php
    require_once __DIR__ . '/../conexao.php'; // Inclui o arquivo de conexão com o banco de dados

    $sql = "SELECT nome, cpfPaciente, dataNascimento, endereco, telefone, faltas
        FROM paciente 
        WHERE ativo = 1"; // Busca apenas pacientes ativos

    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
      echo '<table class="table table-striped">';
      echo '<thead>
              <tr>
                  <th scope="col">Nome</th>
                  <th scope="col">CPF</th>
                  <th scope="col">Data Nascimento</th>
                  <th scope="col">Endereço</th>
                  <th scope="col">Telefone</th>
                  <th scope="col">Faltas</th>
                  <th scope="col">Editar</th>
                  <th scope="col">Remover</th>
              </tr>
            </thead>';
      echo '<tbody>';
    

    

      if (!isset($_POST['texto'])) {
      
        while ($linha = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>";
            echo "  <td scope=\"row\">{$linha['nome']}</td>";
            echo "  <td scope=\"row\">{$linha['cpfPaciente']}</td>";
            echo "  <td scope=\"row\">{$linha['dataNascimento']}</td>";
            echo "  <td scope=\"row\">{$linha['endereco']}</td>";
            echo "  <td scope=\"row\">{$linha['telefone']}</td>";
            echo "  <td scope=\"row\">{$linha['faltas']}</td>";
            echo "  <td scope=\"row\">
                      <a href=\"#\" title=\"Editar\">
                        <img src=\"img\lapis.png\" alt=\"Editar\" style=\"width:20px; height:20px;\">
                      </a>
                    </td>";

            echo "  <td scope=\"row\">
                      <a href=\"#\" title=\"Remover\">
                        <img src=\"img/lixeira.png\" alt=\"Remover\" style=\"width:20px; height:20px;\">
                      </a>
                    </td>";
            echo "</tr>";
        }
      }
      else
      {
        while ($linha = $stmt->fetch(PDO::FETCH_ASSOC)) {
          if(str_contains(strtolower($linha['nome']), strtolower($_POST['texto'])))
          {
            echo "<tr>";
            echo "  <td scope=\"row\">{$linha['nome']}</td>";
            echo "  <td scope=\"row\">{$linha['cpfPaciente']}</td>";
            echo "  <td scope=\"row\">{$linha['dataNascimento']}</td>";
            echo "  <td scope=\"row\">{$linha['endereco']}</td>";
            echo "  <td scope=\"row\">{$linha['telefone']}</td>";
            echo "  <td scope=\"row\">{$linha['faltas']}</td>";
            echo "  <td scope=\"row\">
                      <a href=\"#\" title=\"Editar\">
                        <img src=\"img\lapis.png\" alt=\"Editar\" style=\"width:20px; height:20px;\">
                      </a>
                    </td>";

            echo "  <td scope=\"row\">
                      <a href=\"#\" title=\"Remover\">
                        <img src=\"img/lixeira.png\" alt=\"Remover\" style=\"width:20px; height:20px;\">
                      </a>
                    </td>";
            echo "</tr>";
          }
        }
      }
      echo '</tbody>';
      echo '</table>';
      
    }
    ?>
    </section>
  </body>
</html>
