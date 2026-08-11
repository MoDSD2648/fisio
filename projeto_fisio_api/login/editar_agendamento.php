<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: index.php");
    exit;
}

require_once __DIR__ . '/../conexao.php';

// Obtém o ID do agendamento pela URL
$idAgenda = $_GET['id'] ?? null;

if (!$idAgenda) {
    echo "<script>alert('Agendamento não encontrado!');window.location='painel.php';</script>";
    exit;
}

// Busca os dados do agendamento no banco de dados
$stmt = $pdo->prepare("SELECT a.id, a.data, a.hora, a.status, a.observacoes, p.nome AS paciente_nome, p.idPaciente 
                       FROM agendamento a 
                       INNER JOIN paciente p ON a.idPaciente = p.idPaciente 
                       WHERE a.id = ?");
$stmt->execute([$idAgenda]);
$agenda = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$agenda) {
    echo "<script>alert('Agendamento não encontrado!');window.location='painel.php';</script>";
    exit;
}

// Atualiza o status do agendamento e incrementa as faltas do paciente
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $status = $_POST['status'];
    $observacoes = $_POST['observacoes'];

    try {
        // Inicia uma transação
        $pdo->beginTransaction();

        // Atualiza o status do agendamento
        $stmt = $pdo->prepare("UPDATE agendamento SET status = ?, observacoes = ? WHERE id = ?");
        $stmt->execute([$status, $observacoes, $idAgenda]);

        // Se o status for "Faltou", incrementa as faltas do paciente
        if ($status === 'Faltou') {
            $stmt = $pdo->prepare("UPDATE paciente SET faltas = faltas + 1 WHERE idPaciente = ?");
            $stmt->execute([$agenda['idPaciente']]);
        }

        // Confirma a transação
        $pdo->commit();

        echo "<script>alert('Agendamento atualizado com sucesso!');window.location='painel.php';</script>";
    } catch (Exception $e) {
        // Reverte a transação em caso de erro
        $pdo->rollBack();
        echo "<script>alert('Erro ao atualizar agendamento: {$e->getMessage()}');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Agendamento</title>
    <link href="https://fonts.googleapis.com/css2?family=Rubik&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles/cadastrar.css">
</head>
<body>
    <header>
        <div class="logo">
            <img src="img/logoUnipHeader.png" alt="UNIP">
            <h1>Editar Agendamento</h1>
        </div>
        <?php include 'menu.php'; ?>
    </header>

    <section class="conteudo-vazio">
        <form class="form-cadastro" method="POST">
            <h2>Editar Agendamento</h2>

            <label for="paciente">Paciente:</label>
            <input type="text" id="paciente" name="paciente" value="<?= $agendamento['paciente_nome'] ?>" readonly>

            <label for="data">Data:</label>
            <input type="date" id="data" name="data" value="<?= $agendamento['data'] ?>" readonly>

            <label for="hora">Hora:</label>
            <input type="time" id="hora" name="hora" value="<?= $agendamento['hora'] ?>" readonly>

            <label for="status">Status:</label>
            <select id="status" name="status" required>
                <option value="Agendado" <?= $agendamento['status'] === 'Agendado' ? 'selected' : '' ?>>Agendado</option>
                <option value="Concluído" <?= $agendamento['status'] === 'Concluído' ? 'selected' : '' ?>>Concluído</option>
                <option value="Faltou" <?= $agendamento['status'] === 'Faltou' ? 'selected' : '' ?>>Faltou</option>
            </select>

            <label for="observacoes">Observações:</label>
            <textarea id="observacoes" name="observacoes"><?= $agendamento['observacoes'] ?></textarea>

            <button type="submit">Salvar Alterações</button>
            <a href="painel.php" class="btn btn-secondary">Voltar</a>
        </form>
    </section>
</body>
</html>