-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 16/04/2025 às 00:40
-- Versão do servidor: 10.4.28-MariaDB
-- Versão do PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `api_db`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `agenda`
--

CREATE TABLE `agenda` (
  `idAgenda` bigint(20) UNSIGNED NOT NULL,
  `data` date NOT NULL,
  `hora` time NOT NULL,
  `idPaciente` int(11) DEFAULT NULL,
  `idUsuario` int(11) DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL CHECK (`status` in ('Marcada','Confirmada','Cancelada')),
  `observacoes` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `agenda`
--

INSERT INTO `agenda` (`idAgenda`, `data`, `hora`, `idPaciente`, `idUsuario`, `status`, `observacoes`) VALUES
(1, '2025-04-11', '14:30:00', 1, 1, 'Marcada', 'Nenhuma'),
(2, '2025-04-17', '14:30:00', 1, 1, 'Confirmada', 'Nenhuma'),
(3, '2025-04-17', '15:00:00', 2, 1, 'Confirmada', 'Paciente muito bonito!! Tratar bem e pegar o numero!'),
(4, '2025-04-15', '10:00:00', 5, 1, 'Confirmada', 'nenhuma'),
(5, '2025-04-17', '10:00:00', 1, 1, 'Marcada', 'n'),
(6, '2004-04-16', '10:00:00', NULL, 1, 'Marcada', 'Nenhuma'),
(7, '2025-04-16', '10:30:00', 1, 1, 'Marcada', ''),
(8, '2025-04-18', '09:00:00', 5, 1, 'Marcada', ''),
(9, '2025-04-18', '18:00:00', 5, 1, 'Confirmada', '');

-- --------------------------------------------------------

--
-- Estrutura para tabela `aluno_setor`
--

CREATE TABLE `aluno_setor` (
  `idUsuario` int(11) NOT NULL,
  `idSetor` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `paciente`
--

CREATE TABLE `paciente` (
  `idPaciente` bigint(20) UNSIGNED NOT NULL,
  `nome` varchar(50) NOT NULL,
  `dataNascimento` date DEFAULT NULL,
  `endereco` varchar(255) DEFAULT NULL,
  `telefone` varchar(15) DEFAULT NULL,
  `ativo` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `paciente`
--

INSERT INTO `paciente` (`idPaciente`, `nome`, `dataNascimento`, `endereco`, `telefone`, `ativo`) VALUES
(1, 'Josevaldo', '1973-09-07', 'av Dr jose', '189956256', 1),
(2, 'Rodoaldo Ribeiro', '1994-05-12', 'Rua Av Dr. General Jão', '75981618622', 1),
(5, 'Monaize', '2004-04-16', 'av', '5', 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `setor`
--

CREATE TABLE `setor` (
  `idSetor` bigint(20) UNSIGNED NOT NULL,
  `nome` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `setor`
--

INSERT INTO `setor` (`idSetor`, `nome`) VALUES
(1, 'Ortopedia');

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuario`
--

CREATE TABLE `usuario` (
  `idUsuario` bigint(20) UNSIGNED NOT NULL,
  `login` varchar(50) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `telefone` varchar(15) DEFAULT NULL,
  `level` varchar(20) DEFAULT NULL CHECK (`level` in ('Admin','Aluno','Professor','Profissional')),
  `api_key` text NOT NULL,
  `ativo` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuario`
--

INSERT INTO `usuario` (`idUsuario`, `login`, `nome`, `senha`, `email`, `telefone`, `level`, `api_key`, `ativo`) VALUES
(1, 'G743962', 'Monaize', '$2y$10$196K2SmlkfNiEJ1p4//ieeeWNZ9opJHeokAsCNwLdaQ0qGDySsVC.', 'monaizedutra@gmail.com', '189948562', 'admin', '', 1),
(3, 'T653HA0', 'Matheus', '$2y$10$IMofWJxZ.yCN/fmGVGPQLeXDUh.q7ZENFW.9cYtHZxcyftgOkUcOG', 'matheusvcen@gmail.com', '', 'aluno', '', 0);

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuario_setor`
--

CREATE TABLE `usuario_setor` (
  `idUsuario` int(11) NOT NULL,
  `idSetor` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `agenda`
--
ALTER TABLE `agenda`
  ADD PRIMARY KEY (`idAgenda`);

--
-- Índices de tabela `aluno_setor`
--
ALTER TABLE `aluno_setor`
  ADD PRIMARY KEY (`idUsuario`,`idSetor`);

--
-- Índices de tabela `paciente`
--
ALTER TABLE `paciente`
  ADD PRIMARY KEY (`idPaciente`);

--
-- Índices de tabela `setor`
--
ALTER TABLE `setor`
  ADD PRIMARY KEY (`idSetor`);

--
-- Índices de tabela `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`idUsuario`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Índices de tabela `usuario_setor`
--
ALTER TABLE `usuario_setor`
  ADD PRIMARY KEY (`idUsuario`,`idSetor`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `agenda`
--
ALTER TABLE `agenda`
  MODIFY `idAgenda` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de tabela `paciente`
--
ALTER TABLE `paciente`
  MODIFY `idPaciente` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `setor`
--
ALTER TABLE `setor`
  MODIFY `idSetor` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `usuario`
--
ALTER TABLE `usuario`
  MODIFY `idUsuario` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
