<div class="user">
    <div class="user-info">
        <span class="nome-negrito"><?= htmlspecialchars($_SESSION['usuario_nome'] ?? '') ?></span><br>
        <span><?= htmlspecialchars($_SESSION['usuario_email'] ?? '') ?></span>
    </div>
    <a href="sair.php" class="sair">
        <img src="img/sign-out-alt-solid.svg" alt="Sair" style="width: 16px; vertical-align: middle; margin-right: 5px;">
        Sair
    </a>
</div>
