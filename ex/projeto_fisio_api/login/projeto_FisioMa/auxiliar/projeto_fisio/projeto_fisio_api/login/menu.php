<nav>
<ul class="menu">
  <li>
    <a href="painel.php" class="<?php echo ($pagina_atual == 'painel') ? 'ativo' : ''; ?>">1. Agenda</a>
    <ul class="submenu">
      <li><a href="agendar.php">Criar Evento</a></li>
    </ul>
  </li>
  
  <li>
    <a href="tabela_Pacientes.php" class="<?php echo ($pagina_atual == 'pacientes') ? 'ativo' : ''; ?>">2. Pacientes</a>
    <ul class="submenu">
      <li><a href="cadastrarpaciente.php">Cadastrar Paciente</a></li>
    </ul>
  </li>
  
  <li>
    <a href="#" class="<?php echo ($pagina_atual == 'prontuarios') ? 'ativo' : ''; ?>">3. Prontuários</a>
    <ul class="submenu">
      <li><a href="#">Novo Prontuário</a></li>
      <li><a href="#">Buscar Prontuário</a></li>
      <li><a href="#">Anexar Documentos</a></li>
    </ul>
  </li>
  
  <li>
    <a href="tabela_Usuarios.php" class="<?php echo ($pagina_atual == 'usuarios') ? 'ativo' : ''; ?>">4. Usuários</a>
    <ul class="submenu">
      <li><a href="cadastrarusuario.php">Novo Usuário</a></li>
    </ul>
  </li>
</ul>
</nav>
<!--
  <li><a href="#">5. Configurações</a>
    <ul class="submenu">
      <li><a href="#">Sistema</a></li>
      <li><a href="#">Backup</a></li>
      <li><a href="#">Preferências</a></li>
    </ul>
  </li>-->