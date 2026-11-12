<?php
session_start();

$pagina_atual = 'painel';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: index.php");
    exit;
}

$data_pre = $_GET['data'] ?? '';
$hora_pre = $_GET['hora'] ?? '';
?>
<!DOCTYPE html>
<html lang="pt-BR">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="img/icon.ico">
    <title>Agendar Consulta - FISIOTERAPIA UNIP</title>
    <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles/painel.css">
    <link rel="stylesheet" href="styles/cadastrar.css">
  </head>

  <body>
    <header>
      <div class="logo">
        <img src="img/logoUnipHeader.png" alt="UNIP">
        <h1>Agendar Consulta</h1>
      </div>
      <?php include 'acesso.php';?>
    </header>
    <?php include 'menu.php'; ?>

    <div class="form-cadastro">
      <section class="conteudo-vazio">
        <form action="salvar_agendamento.php" method="post">
          <h2>Dados da Agenda</h2>

          <div class="data">
            <label for="data">Data:</label>
            <input type="date" id="data" name="data" value="<?= htmlspecialchars($data_pre) ?>" required>
          </div>

          <div class="hora">
            <label for="hora">Hora:</label>
            <select name="hora" id="hora" required>
              <option value="">Selecione o horário</option>
              <option value="13:10" <?= $hora_pre === '13:10' ? 'selected' : '' ?>>13:10</option>
              <option value="14:10" <?= $hora_pre === '14:10' ? 'selected' : '' ?>>14:10</option>
              <option value="15:30" <?= $hora_pre === '15:30' ? 'selected' : '' ?>>15:30</option>
              <option value="16:30" <?= $hora_pre === '16:30' ? 'selected' : '' ?>>16:30</option>
            </select>
          </div>

          <label for="paciente">Paciente:</label>
          <select name="paciente" id="paciente" required>
            <option value="">Selecione o paciente</option>
            <?php
            require_once __DIR__ . "/../conexao.php";
            $stmtPacientes = $pdo->query("SELECT idPaciente, nome FROM paciente WHERE ativo = 1 ORDER BY nome");
            while ($paciente = $stmtPacientes->fetch(PDO::FETCH_ASSOC)) {
                echo "<option value='{$paciente['idPaciente']}'>" . htmlspecialchars($paciente['nome']) . "</option>";
            }
            ?>
          </select>

          <label for="setor">Setor:</label>
          <select name="setor" id="setor" required>
            <option value="">Selecione o setor</option>
            <?php
            $stmtSetores = $pdo->query("SELECT idSetor, nome FROM setor ORDER BY nome");
            while ($setor = $stmtSetores->fetch(PDO::FETCH_ASSOC)) {
                echo "<option value='{$setor['idSetor']}'>" . htmlspecialchars($setor['nome']) . "</option>";
            }
            ?>
          </select>

          <label for="usuario">Profissional / Aluno:</label>
          <select name="usuario" id="usuario">
            <option value="">Selecione o responsável</option>
            <?php
            $stmtUsuarios = $pdo->query("SELECT idUsuario, nome FROM usuario WHERE ativo = 1 ORDER BY nome");
            while ($usuario = $stmtUsuarios->fetch(PDO::FETCH_ASSOC)) {
                $sel = ($usuario['idUsuario'] == $_SESSION['usuario_id']) ? 'selected' : '';
                echo "<option value='{$usuario['idUsuario']}' $sel>" . htmlspecialchars($usuario['nome']) . "</option>";
            }
            ?>
          </select>

          <label for="status">Status:</label>
          <select id="status" name="status" required>
            <option value="Marcada">Marcada</option>
            <option value="Confirmada">Confirmada</option>
          </select>

          <label for="observacoes">Observações:</label>
          <input type="text" id="observacoes" name="observacoes" placeholder="Observações opcionais">

          <div style="display: flex; gap: 10px; margin-top: 15px;">
            <button type="submit" style="flex: 1;">Agendar</button>
            <a href="painel.php" class="btn btn-secondary" style="display: inline-block; padding: 10px 15px; background: #6c757d; color: white; text-decoration: none; border-radius: 4px; text-align: center;">Voltar</a>
          </div>
        </form>
      </section>
    </div>
  </body>
</html>
