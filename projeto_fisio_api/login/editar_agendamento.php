<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: index.php");
    exit;
}

$pagina_atual = 'painel';
require_once __DIR__ . '/../conexao.php';

// Obtém o ID do agendamento pela URL
$idAgenda = $_GET['id'] ?? null;

if (!$idAgenda) {
    echo "<script>alert('Agendamento não encontrado!');window.location='painel.php';</script>";
    exit;
}

// Verifica se a tabela agenda possui idSetor
$temSetor = false;
try {
    $chk = $pdo->query("SHOW COLUMNS FROM agenda LIKE 'idSetor'");
    if ($chk && $chk->rowCount() > 0) {
        $temSetor = true;
    }
} catch (Exception $e) {}

// Busca os dados do agendamento
$query = "
SELECT 
    a.idAgenda, 
    a.data, 
    a.hora, 
    a.status, 
    a.observacoes, 
    a.idPaciente,
    COALESCE(p.nome, 'Paciente não informado') AS paciente_nome,
    " . ($temSetor ? "COALESCE(s.nome, 'Não informado') AS setor_nome" : "'Fisioterapia' AS setor_nome") . "
FROM agenda a 
LEFT JOIN paciente p ON a.idPaciente = p.idPaciente 
" . ($temSetor ? "LEFT JOIN setor s ON a.idSetor = s.idSetor " : "") . "
WHERE a.idAgenda = ?
";

$stmt = $pdo->prepare($query);
$stmt->execute([$idAgenda]);
$agenda = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$agenda) {
    echo "<script>alert('Agendamento não encontrado!');window.location='painel.php';</script>";
    exit;
}

// Atualiza o agendamento
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $status = $_POST['status'] ?? $agenda['status'];
    $observacoes = $_POST['observacoes'] ?? '';

    try {
        $pdo->beginTransaction();

        $stmt = $pdo->prepare("UPDATE agenda SET status = ?, observacoes = ? WHERE idAgenda = ?");
        $stmt->execute([$status, $observacoes, $idAgenda]);

        // Se o status for "Faltou", incrementa as faltas do paciente
        if ($status === 'Faltou' && !empty($agenda['idPaciente'])) {
            $stmtFalta = $pdo->prepare("UPDATE paciente SET faltas = faltas + 1 WHERE idPaciente = ?");
            $stmtFalta->execute([$agenda['idPaciente']]);
        }

        $pdo->commit();
        echo "<script>alert('Agendamento atualizado com sucesso!');window.location='painel.php';</script>";
        exit;
    } catch (Exception $e) {
        if ($pdo->inTransaction()) {
            $pdo->rollBack();
        }
        echo "<script>alert('Erro ao atualizar agendamento: " . addslashes($e->getMessage()) . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="img/icon.ico">
    <title>Editar Agendamento - FISIOTERAPIA UNIP</title>
    <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles/painel.css">
    <link rel="stylesheet" href="styles/cadastrar.css">
</head>
<body>
    <header>
        <div class="logo">
            <img src="img/logoUnipHeader.png" alt="UNIP">
            <h1>Editar Agendamento</h1>
        </div>
        <?php include 'acesso.php';?>
    </header>
    <?php include 'menu.php'; ?>

    <section class="conteudo-vazio">
        <form class="form-cadastro" method="POST">
            <h2>Detalhes da Consulta</h2>

            <label for="paciente">Paciente:</label>
            <input type="text" id="paciente" name="paciente" value="<?= htmlspecialchars($agenda['paciente_nome']) ?>" readonly>

            <label for="setor">Setor:</label>
            <input type="text" id="setor" name="setor" value="<?= htmlspecialchars($agenda['setor_nome']) ?>" readonly>

            <label for="data">Data:</label>
            <input type="date" id="data" name="data" value="<?= htmlspecialchars($agenda['data']) ?>" readonly>

            <label for="hora">Hora:</label>
            <input type="time" id="hora" name="hora" value="<?= htmlspecialchars($agenda['hora']) ?>" readonly>

            <label for="status">Status:</label>
            <select id="status" name="status" required>
                <option value="Marcada" <?= $agenda['status'] === 'Marcada' ? 'selected' : '' ?>>Marcada</option>
                <option value="Confirmada" <?= $agenda['status'] === 'Confirmada' ? 'selected' : '' ?>>Confirmada</option>
                <option value="Cancelada" <?= $agenda['status'] === 'Cancelada' ? 'selected' : '' ?>>Cancelada</option>
                <option value="Faltou" <?= $agenda['status'] === 'Faltou' ? 'selected' : '' ?>>Faltou</option>
            </select>

            <label for="observacoes">Observações:</label>
            <textarea id="observacoes" name="observacoes" rows="4"><?= htmlspecialchars($agenda['observacoes'] ?? '') ?></textarea>

            <div style="display: flex; gap: 10px; margin-top: 15px;">
                <button type="submit" style="flex: 1;">Salvar Alterações</button>
                <a href="painel.php" class="btn btn-secondary" style="display: inline-block; padding: 10px 15px; background: #6c757d; color: white; text-decoration: none; border-radius: 4px; text-align: center;">Voltar</a>
            </div>
        </form>
    </section>
</body>
</html>
