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
    <title>Pacientes - FISIOTERAPIA UNIP</title>
    <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href='https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css' rel='stylesheet'>
    <link rel="stylesheet" href="styles/painel.css">
    <link rel="stylesheet" href="styles/usuarios.css">
  </head>
  <body>
    <header>
      <div class="logo">
        <img src="img/logoUnipHeader.png" alt="UNIP">
        <h1>Pacientes</h1>
      </div>
      <?php include 'acesso.php';?>
    </header>
    <?php include 'menu.php';?>

    <main class="container-principal">
      <div class="agenda-topo">
        <div class="agenda-info">
          <h2>Lista Geral de Pacientes</h2>
          <p>Consulte, filtre ou edite o cadastro dos pacientes da clínica.</p>
        </div>
        <div class="agenda-acoes">
          <a href="cadastrarpaciente.php" class="btn-novo-agendamento">
            <i class="bi bi-person-plus"></i> Novo Paciente
          </a>
        </div>
      </div>

      <!-- Campo para pesquisa -->
      <form method="POST" action="" class="form-pesquisa mb-4">
        <div class="input-group" style="max-width: 480px;">
          <input type="text" name="texto" class="form-control" placeholder="Buscar por nome, CPF ou telefone..." value="<?php echo isset($_POST['texto']) ? htmlspecialchars($_POST['texto']) : ''; ?>" />
          
          <button type="submit" class="btn btn-primary" title="Pesquisar">
            <i class="bi bi-search"></i> Pesquisar
          </button>
          
          <button type="button" class="btn btn-secondary" onclick="limparPesquisa();" title="Limpar pesquisa">
            <i class="bi bi-x-circle"></i>
          </button>
        </div>
      </form>

      <script>
      function limparPesquisa() {
          document.querySelector('input[name="texto"]').value = '';
          document.querySelector('.form-pesquisa').submit();
      }
      </script>

      <?php
      require_once __DIR__ . '/../conexao.php';

      $termo = trim($_POST['texto'] ?? '');
      if ($termo !== '') {
          $sql = "SELECT idPaciente, nome, cpfPaciente, dataNascimento, endereco, telefone, faltas
                  FROM paciente 
                  WHERE ativo = 1 AND (nome LIKE :termo OR cpfPaciente LIKE :termo OR telefone LIKE :termo)
                  ORDER BY nome ASC";
          $stmt = $pdo->prepare($sql);
          $stmt->execute([':termo' => "%$termo%"]);
      } else {
          $sql = "SELECT idPaciente, nome, cpfPaciente, dataNascimento, endereco, telefone, faltas
                  FROM paciente 
                  WHERE ativo = 1 
                  ORDER BY nome ASC";
          $stmt = $pdo->prepare($sql);
          $stmt->execute();
      }

      $pacientes = $stmt->fetchAll(PDO::FETCH_ASSOC);

      if (count($pacientes) > 0) {
          echo '<div class="table-responsive bg-white p-3 rounded shadow-sm">';
          echo '<table class="table table-striped table-hover align-middle mb-0">';
          echo '<thead class="table-light">
                  <tr>
                      <th scope="col">Nome</th>
                      <th scope="col">CPF</th>
                      <th scope="col">Nascimento</th>
                      <th scope="col">Endereço</th>
                      <th scope="col">Telefone</th>
                      <th scope="col" class="text-center">Faltas</th>
                      <th scope="col" class="text-center">Ações</th>
                  </tr>
                </thead>';
          echo '<tbody>';

          foreach ($pacientes as $linha) {
              $dataNasc = !empty($linha['dataNascimento']) ? date('d/m/Y', strtotime($linha['dataNascimento'])) : '-';
              echo "<tr>";
              echo "  <td class='fw-medium'>" . htmlspecialchars($linha['nome']) . "</td>";
              echo "  <td>" . htmlspecialchars($linha['cpfPaciente']) . "</td>";
              echo "  <td>" . htmlspecialchars($dataNasc) . "</td>";
              echo "  <td>" . htmlspecialchars($linha['endereco'] ?? '-') . "</td>";
              echo "  <td>" . htmlspecialchars($linha['telefone'] ?? '-') . "</td>";
              echo "  <td class='text-center'><span class='badge " . ($linha['faltas'] > 2 ? 'bg-danger' : 'bg-secondary') . "'>" . (int)$linha['faltas'] . "</span></td>";
              echo "  <td class='text-center'>";
              echo "    <a href='editarpaciente.php?id={$linha['idPaciente']}' class='btn btn-sm btn-outline-primary me-1' title='Editar'><i class='bi bi-pencil'></i> Editar</a>";
              echo "    <a href='remover_paciente.php?id={$linha['idPaciente']}' class='btn btn-sm btn-outline-danger' onclick=\"return confirm('Deseja realmente desativar este paciente?');\" title='Remover'><i class='bi bi-trash'></i></a>";
              echo "  </td>";
              echo "</tr>";
          }
          echo '</tbody>';
          echo '</table>';
          echo '</div>';
      } else {
          echo "<div class='alert alert-warning'>Nenhum paciente encontrado.</div>";
      }
      ?>
    </main>
  </body>
</html>
