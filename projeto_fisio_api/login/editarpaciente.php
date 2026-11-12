<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: index.php");
    exit;
}

$pagina_atual = 'pacientes';
require_once __DIR__ . '/../conexao.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    header("Location: tabela_Pacientes.php");
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM paciente WHERE idPaciente = ?");
$stmt->execute([$id]);
$paciente = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$paciente) {
    echo "<script>alert('Paciente não encontrado!');window.location='tabela_Pacientes.php';</script>";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'] ?? '';
    $cpf = $_POST['cpf'] ?? '';
    $nascimento = !empty($_POST['nascimento']) ? $_POST['nascimento'] : null;
    $telefone = $_POST['telefone'] ?? '';
    $endereco = $_POST['endereco'] ?? '';
    $faltas = isset($_POST['faltas']) ? (int)$_POST['faltas'] : 0;

    try {
        $stmtUpdate = $pdo->prepare("UPDATE paciente SET nome = ?, cpfPaciente = ?, dataNascimento = ?, telefone = ?, endereco = ?, faltas = ? WHERE idPaciente = ?");
        $stmtUpdate->execute([$nome, $cpf, $nascimento, $telefone, $endereco, $faltas, $id]);

        echo "<script>alert('Paciente atualizado com sucesso!');window.location='tabela_Pacientes.php';</script>";
        exit;
    } catch (Exception $e) {
        echo "<script>alert('Erro ao atualizar: " . addslashes($e->getMessage()) . "');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" type="image/x-icon" href="img/icon.ico">
  <title>Editar Paciente - UNIP</title>
  <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="styles/painel.css">
  <link rel="stylesheet" href="styles/cadastrarPaciente.css">
</head>
<body>
  <header>
    <div class="logo">
      <img src="img/logoUnipHeader.png" alt="UNIP">
      <h1>Editar Paciente</h1>
    </div>
    <?php include 'acesso.php';?>
  </header>
  <?php include 'menu.php'; ?>

  <section class="conteudo-vazio">
    <form class="form-cadastro" method="POST">
      <h2>Atualizar Paciente</h2>

      <label for="nome">Nome Completo</label>
      <input type="text" id="nome" name="nome" value="<?= htmlspecialchars($paciente['nome']) ?>" required>

      <label for="cpf">CPF</label>
      <input type="text" id="cpf" name="cpf" value="<?= htmlspecialchars($paciente['cpfPaciente']) ?>" placeholder="000.000.000-00" required>

      <label for="nascimento">Data de Nascimento</label>
      <input type="date" id="nascimento" name="nascimento" value="<?= htmlspecialchars($paciente['dataNascimento'] ?? '') ?>">

      <label for="telefone">Telefone</label>
      <input type="tel" id="telefone" name="telefone" value="<?= htmlspecialchars($paciente['telefone'] ?? '') ?>" placeholder="(00) 00000-0000">

      <label for="endereco">Endereço</label>
      <input type="text" id="endereco" name="endereco" value="<?= htmlspecialchars($paciente['endereco'] ?? '') ?>" placeholder="Rua, número, bairro">

      <label for="faltas">Faltas</label>
      <input type="number" id="faltas" name="faltas" min="0" value="<?= (int)($paciente['faltas'] ?? 0) ?>">

      <div style="display: flex; gap: 10px; margin-top: 15px;">
        <button type="submit" style="flex: 1;">Salvar Alterações</button>
        <a href="tabela_Pacientes.php" style="display: inline-block; padding: 10px 15px; background: #6c757d; color: white; text-decoration: none; border-radius: 4px; text-align: center;">Voltar</a>
      </div>
    </form>
  </section>
</body>
</html>
