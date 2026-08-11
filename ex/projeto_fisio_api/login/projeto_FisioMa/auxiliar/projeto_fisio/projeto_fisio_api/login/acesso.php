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