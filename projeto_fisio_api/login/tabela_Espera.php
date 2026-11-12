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
    <title>Lista de Espera - FISIOTERAPIA UNIP</title>
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
        <h1>Lista de Espera</h1>
      </div>
      <?php include 'acesso.php';?>
    </header>
    <?php include 'menu.php';?>

    <main class="container-principal">
      <div class="agenda-topo">
        <div class="agenda-info">
          <h2>Fila de Espera por Atendimento</h2>
          <p>Pacientes aguardando triagem e agendamento de vagas nos setores de fisioterapia.</p>
        </div>
        <div class="agenda-acoes">
          <a href="cadastrarespera.php" class="btn-novo-agendamento">
            <i class="bi bi-person-plus"></i> Novo Registro na Fila
          </a>
        </div>
      </div>

      <!-- Campo para pesquisa -->
      <form method="POST" action="" class="form-pesquisa mb-4">
        <div class="input-group" style="max-width: 480px;">
          <input type="text" name="texto" class="form-control" placeholder="Buscar por nome, telefone ou observações..." value="<?php echo isset($_POST['texto']) ? htmlspecialchars($_POST['texto']) : ''; ?>" />
          
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
          $sql = "SELECT IdEspera, dataLigacao, nome, idade, telefone, observacoes, prioridade, status
                  FROM lista_espera 
                  WHERE ativo = 1 AND (nome LIKE :termo OR telefone LIKE :termo OR observacoes LIKE :termo)
                  ORDER BY prioridade ASC, dataLigacao ASC";
          $stmt = $pdo->prepare($sql);
          $stmt->execute([':termo' => "%$termo%"]);
      } else {
          $sql = "SELECT IdEspera, dataLigacao, nome, idade, telefone, observacoes, prioridade, status
                  FROM lista_espera 
                  WHERE ativo = 1 
                  ORDER BY prioridade ASC, dataLigacao ASC";
          $stmt = $pdo->prepare($sql);
          $stmt->execute();
      }

      $esperas = $stmt->fetchAll(PDO::FETCH_ASSOC);

      if (count($esperas) > 0) {
          echo '<div class="table-responsive bg-white p-3 rounded shadow-sm">';
          echo '<table class="table table-striped table-hover align-middle mb-0">';
          echo '<thead class="table-light">
                  <tr>
                      <th scope="col">Data/Hora</th>
                      <th scope="col">Nome</th>
                      <th scope="col" class="text-center">Idade</th>
                      <th scope="col">Telefone</th>
                      <th scope="col">Observações</th>
                      <th scope="col" class="text-center">Prioridade</th>
                      <th scope="col" class="text-center">Status</th>
                      <th scope="col" class="text-center">Ações</th>
                  </tr>
                </thead>';
          echo '<tbody>';

          foreach ($esperas as $linha) {
              $dataFmt = !empty($linha['dataLigacao']) ? date('d/m/Y H:i', strtotime($linha['dataLigacao'])) : '-';

              $badgePrior = 'bg-secondary';
              $labelPrior = 'Baixa';
              if ((int)$linha['prioridade'] === 0) {
                  $badgePrior = 'bg-danger';
                  $labelPrior = 'Alta';
              } elseif ((int)$linha['prioridade'] === 1) {
                  $badgePrior = 'bg-warning text-dark';
                  $labelPrior = 'Média';
              }

              $paramCadastrar = urlencode($linha['nome'] . '||' . $linha['telefone']);

              echo "<tr>";
              echo "  <td><small class='text-muted'>" . htmlspecialchars($dataFmt) . "</small></td>";
              echo "  <td class='fw-medium'>" . htmlspecialchars($linha['nome']) . "</td>";
              echo "  <td class='text-center'>" . (int)$linha['idade'] . "</td>";
              echo "  <td>" . htmlspecialchars($linha['telefone']) . "</td>";
              echo "  <td>" . htmlspecialchars($linha['observacoes'] ?? '-') . "</td>";
              echo "  <td class='text-center'><span class='badge {$badgePrior}'>{$labelPrior}</span></td>";
              echo "  <td class='text-center'><span class='badge bg-info text-dark'>" . htmlspecialchars($linha['status']) . "</span></td>";
              echo "  <td class='text-center'>";
              echo "    <a href='cadastrarpaciente.php?name={$paramCadastrar}' class='btn btn-sm btn-outline-success me-1' title='Tornar Paciente'><i class='bi bi-person-check'></i> Paciente</a>";
              echo "    <a href='remover_espera.php?id={$linha['IdEspera']}' class='btn btn-sm btn-outline-danger' onclick=\"return confirm('Deseja realmente remover este registro da lista?');\" title='Remover'><i class='bi bi-trash'></i></a>";
              echo "  </td>";
              echo "</tr>";
          }
          echo '</tbody>';
          echo '</table>';
          echo '</div>';
      } else {
          echo "<div class='alert alert-info'>Nenhum registro encontrado na lista de espera.</div>";
      }
      ?>
    </main>
  </body>
</html>
