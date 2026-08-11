<?php session_start(); 
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/x-icon" href=".\img\icon.ico">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistema Fisioterapia</title>
    <link rel="stylesheet" href="styles/style-login.css">
</head>
<body>
    <div class="background-overlay"></div>

    <div class="container">
        <img src="img/logo.png" alt="Logo" class="logo">
        <h1 class="titulo">Sistema - Fisioterapia</h1>
        <br>

        <?php if (isset($_SESSION['erro_login'])): ?>
            <p class="erro"><?php echo $_SESSION['erro_login']; unset($_SESSION['erro_login']); ?></p>
        <?php endif; ?>

        <form action="validar.php" method="POST">
            <input type="text" name="login" placeholder="Usuário" required>
            <input type="password" name="senha" placeholder="Senha" required>
            <button type="submit">Entrar</button>
        </form>
            
        <a href="#" class="esqueci">Esqueci a senha</a>
    </div>
</body>
</html>