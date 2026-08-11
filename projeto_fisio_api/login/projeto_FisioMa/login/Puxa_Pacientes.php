<?php
    require_once __DIR__ . '/../conexao.php';

    // Puxa toda a tabela usuario
    $stmt = $pdo->prepare("SELECT idPaciente, nome, cpfPaciente, dataNascimento, endereco, telefone FROM paciente WHERE ativo = 1 ORDER BY nome");
    $stmt->execute();

    if ($stmt->rowCount() == 0) {
        //echo "<script>alert('Horário indisponível!');window.location='agendar.php';</script>";
        echo "<h1>Nenhum usuário encontrado!</h1>";
        exit;
    }

    // Monta a tabela de usuarios no HTML
    /*foreach($stmt as $linha)
    {
      echo "<tr>";
      echo "  <td scope=\"row\">$linha[nome]</td>";
      echo "  <td scope=\"row\">$linha[cpfPaciente]</td>";
      echo "  <td scope=\"row\">$linha[dataNascimento]</td>";
      echo "  <td scope=\"row\">$linha[endereco]</td>";
      echo "  <td scope=\"row\">$linha[telefone]</td>";
      echo "  <td scope=\"row\"><a href=\"#\">Editar</a></td>";
      echo "  <td scope=\"row\"><a href=\"#\">Remover</a></td>";
      echo "</tr>";
    }
    */

?>