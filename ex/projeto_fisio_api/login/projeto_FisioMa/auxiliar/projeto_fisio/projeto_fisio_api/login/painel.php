<?php
session_start();
$pagina_atual = 'painel';
if (!isset($_SESSION['usuario_id'])) {
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FISIOTERAPIA - UNIP</title>
    <link href="https://fonts.googleapis.com/css2?family=Rubik&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link href='https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css' rel='stylesheet'>
    <link rel="stylesheet" href="styles/painel.css">
    <link href="css/custom.css" rel="stylesheet">
    <title>Agenda</title>
</head>

<body>
<header>
    <div class="logo">
        <img src="img/logoUnipHeader.png" alt="UNIP">
        <h1>Agenda de Consultas</h1>
    </div>
    <div class="user">
        <div class="user-info">
            <span class="nome-negrito"><?= $_SESSION['usuario_nome'] ?></span><br>
                <!--<?= $_SESSION['api_key'] ?>--> 
            <span><?= $_SESSION['usuario_email'] ?></span><a href="sair.php">Sair</a>
        </div>
        <button class="sair">
            <img src="img/sign-out-alt-solid.svg" alt="Sair" style="width: 16px; vertical-align: middle; margin-right: 5px;">
            Sair
        </button>
    </div>
    <?php include 'menu.php'; ?>
</header><br><br><br>
    <button class="agendar">
        <a href="agendar.php">Agendar</a>
    </button>
    <div id='calendar'></div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script src='js/index.global.min.js'></script>
    <script src="js/bootstrap5/index.global.min.js"></script>
    <script src='js/core/locales-all.global.min.js'></script>
    <script src='js/custom.js'></script>

</body>

</html>
