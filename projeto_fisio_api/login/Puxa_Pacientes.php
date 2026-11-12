<?php
require_once __DIR__ . '/../conexao.php';

// Puxa pacientes ativos
$stmt = $pdo->prepare("SELECT idPaciente, nome, cpfPaciente, dataNascimento, endereco, telefone FROM paciente WHERE ativo = 1 ORDER BY nome");
$stmt->execute();
