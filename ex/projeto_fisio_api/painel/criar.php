<?php require 'funcoes.php'; ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Criar Nova Chave</title>
</head>
<body>
    <h1>Criar Nova API Key</h1>
    <form action="salvar.php" method="post">
        <label>Domínio autorizado:</label><br>
        <input type="text" name="domain" required><br><br>
        
        <input type="hidden" name="api_key" value="<?= gerarApiKey() ?>">
        <input type="submit" value="Criar Chave">
    </form>
</body>
</html>
