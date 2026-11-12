<nav>
<ul class="menu">
  <li>
    <a href="painel.php" class="<?php echo ($pagina_atual == 'painel') ? 'ativo' : ''; ?>">1. Agenda</a>
    <ul class="submenu">
      <li><a href="agendar.php">Criar Evento</a></li>
    </ul>
  </li>
  
  <li>
    <a href="tabela_Espera.php" class="<?php echo ($pagina_atual == 'espera') ? 'ativo' : ''; ?>">2. Lista de Espera</a>
    <ul class="submenu">
      <li><a href="cadastrarespera.php">Cadastrar Lista de Espera</a></li>
    </ul>
  </li>

  <li>
    <a href="tabela_Pacientes.php" class="<?php echo ($pagina_atual == 'pacientes') ? 'ativo' : ''; ?>">3. Pacientes</a>
    <ul class="submenu">
      <li><a href="cadastrarpaciente.php">Cadastrar Paciente</a></li>
    </ul>
  </li>
  
  <li>
    <a href="#" class="<?php echo ($pagina_atual == 'prontuarios') ? 'ativo' : ''; ?>">4. Prontuários</a>
    <ul class="submenu">
      <li><a href="#">Novo Prontuário</a></li>
      <li><a href="#">Buscar Prontuário</a></li>
      <li><a href="#">Anexar Documentos</a></li>
    </ul>
  </li>
  
  <?php
    if (!isset($_SESSION['usuario_id'])) {
      header("Location: index.php");
      exit;
    }

    if (strtolower($_SESSION['usuario_level'] ?? '') !== "aluno") {
      echo "<li>";
      echo "<a href=\"tabela_Usuarios.php\" class=\"";
      echo ($pagina_atual == 'usuarios') ? 'ativo' : '';
      echo "\">5. Usuários</a>";

      echo "<ul class=\"submenu\">";
      echo "<li><a href=\"cadastrarusuario.php\">Novo Usuário</a></li>";
      echo "</ul>";
      echo "</li>";
    }
  ?>
</ul>
</nav>