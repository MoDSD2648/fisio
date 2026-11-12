<?php
session_start();
$pagina_atual = 'usuarios';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: index.php");
    exit;
}

if (strtolower($_SESSION['usuario_level'] ?? '') === "aluno") {
    header("Location: painel.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="img/icon.ico">
    <title>Usuários - FISIOTERAPIA UNIP</title>
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
        <h1>Usuários do Sistema</h1>
      </div>
      <?php include 'acesso.php';?>
    </header>
    <?php include 'menu.php'; ?>

    <main class="container-principal">
      <div class="agenda-topo">
        <div class="agenda-info">
          <h2>Controle de Acessos e Usuários</h2>
          <p>Gerencie professores, alunos, profissionais e administradores do sistema.</p>
        </div>
        <div class="agenda-acoes">
          <a href="cadastrarusuario.php" class="btn-novo-agendamento">
            <i class="bi bi-person-plus"></i> Novo Usuário
          </a>
        </div>
      </div>

      <!-- Campo para pesquisa -->
      <form method="POST" action="" class="form-pesquisa mb-4">
        <div class="input-group" style="max-width: 480px;">
          <input type="text" name="texto" class="form-control" placeholder="Buscar por nome, login ou email..." value="<?php echo isset($_POST['texto']) ? htmlspecialchars($_POST['texto']) : ''; ?>" />
          
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
          $sql = "SELECT idUsuario, login, nome, email, telefone, level
                  FROM usuario
                  WHERE ativo = 1 AND (nome LIKE :termo OR login LIKE :termo OR email LIKE :termo)
                  ORDER BY nome ASC";
          $stmt = $pdo->prepare($sql);
          $stmt->execute([':termo' => "%$termo%"]);
      } else {
          $sql = "SELECT idUsuario, login, nome, email, telefone, level
                  FROM usuario
                  WHERE ativo = 1
                  ORDER BY nome ASC";
          $stmt = $pdo->prepare($sql);
          $stmt->execute();
      }

      $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

      if (count($usuarios) > 0) {
          echo '<div class="table-responsive bg-white p-3 rounded shadow-sm">';
          echo '<table class="table table-striped table-hover align-middle mb-0">';
          echo '<thead class="table-light">
                  <tr>
                      <th scope="col">Login (RA)</th>
                      <th scope="col">Nome</th>
                      <th scope="col">Email</th>
                      <th scope="col">Telefone</th>
                      <th scope="col" class="text-center">Nível</th>
                      <th scope="col" class="text-center">Ações</th>
                  </tr>
                </thead>';
          echo '<tbody>';

          foreach ($usuarios as $linha) {
              $badgeLevel = 'bg-secondary';
              $lvl = strtolower($linha['level']);
              if ($lvl === 'admin') $badgeLevel = 'bg-danger';
              elseif ($lvl === 'professor') $badgeLevel = 'bg-primary';
              elseif ($lvl === 'profissional') $badgeLevel = 'bg-info text-dark';
              elseif ($lvl === 'aluno') $badgeLevel = 'bg-success';

              echo "<tr>";
              echo "  <td class='fw-medium'>" . htmlspecialchars($linha['login']) . "</td>";
              echo "  <td>" . htmlspecialchars($linha['nome']) . "</td>";
              echo "  <td>" . htmlspecialchars($linha['email']) . "</td>";
              echo "  <td>" . htmlspecialchars($linha['telefone'] ?? '-') . "</td>";
              echo "  <td class='text-center'><span class='badge {$badgeLevel}'>" . htmlspecialchars($linha['level']) . "</span></td>";
              echo "  <td class='text-center'>";
              if ($linha['idUsuario'] != $_SESSION['usuario_id']) {
                  echo "    <a href='remover_usuario.php?id={$linha['idUsuario']}' class='btn btn-sm btn-outline-danger' onclick=\"return confirm('Deseja realmente desativar este usuário?');\" title='Remover'><i class='bi bi-trash'></i> Desativar</a>";
              } else {
                  echo "    <span class='text-muted small'>Usuário Atual</span>";
              }
              echo "  </td>";
              echo "</tr>";
          }
          echo '</tbody>';
          echo '</table>';
          echo '</div>';
      } else {
          echo "<div class='alert alert-warning'>Nenhum usuário encontrado.</div>";
      }
      ?>
    </main>
  </body>
</html>
