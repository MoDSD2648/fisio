-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 08, 2025 at 01:17 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fisiodb`
--

-- --------------------------------------------------------

--
-- Table structure for table `agenda`
--

CREATE TABLE `agenda` (
  `idAgenda` bigint(20) UNSIGNED NOT NULL,
  `data` date NOT NULL,
  `hora` time NOT NULL,
  `idPaciente` int(11) DEFAULT NULL,
  `idUsuario` int(11) DEFAULT NULL,
  `idSetor` int(11) DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL CHECK (`status` in ('Marcada','Confirmada','Cancelada','Agendado','Concluído','Faltou')),
  `observacoes` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `agenda`
--

INSERT INTO `agenda` (`idAgenda`, `data`, `hora`, `idPaciente`, `idUsuario`, `status`, `observacoes`) VALUES
(1, '2025-04-11', '14:30:00', 1, 1, 'Marcada', 'Nenhuma'),
(2, '2025-04-17', '14:30:00', 1, 1, 'Confirmada', 'Nenhuma'),
(3, '2025-04-17', '15:00:00', 2, 1, 'Confirmada', 'Paciente muito bonito!! Tratar bem e pegar o numero!'),
(4, '2025-04-15', '10:00:00', 5, 1, 'Confirmada', 'nenhuma'),
(5, '2025-04-17', '10:00:00', 1, 1, 'Marcada', 'n'),
(7, '2025-04-16', '10:30:00', 1, 1, 'Marcada', ''),
(8, '2025-04-18', '09:00:00', 5, 1, 'Marcada', ''),
(9, '2025-04-18', '18:00:00', 5, 1, 'Confirmada', ''),
(10, '2025-04-25', '20:30:00', 5, 2, 'Marcada', 'Nenhuma'),
(11, '2025-04-30', '13:00:00', 2, 3, 'Marcada', 'Bonitinho');

-- --------------------------------------------------------

--
-- Table structure for table `aluno_setor`
--

CREATE TABLE `aluno_setor` (
  `idUsuario` int(11) NOT NULL,
  `idSetor` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lista_espera`
--

CREATE TABLE `lista_espera` (
  `IdEspera` int(11) NOT NULL,
  `dataLigacao` datetime NOT NULL,
  `nome` varchar(250) NOT NULL,
  `idade` int(11) NOT NULL,
  `telefone` varchar(15) NOT NULL,
  `observacoes` varchar(250) NOT NULL,
  `prioridade` int(11) NOT NULL,
  `status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lista_espera`
--

INSERT INTO `lista_espera` (`IdEspera`, `dataLigacao`, `nome`, `idade`, `telefone`, `observacoes`, `prioridade`, `status`) VALUES
(1, '2025-05-07 02:08:32', 'Matheuszin Bacana', 22, '16547823168', 'Muito bonito, porém desconfia da Monaize', 0, 'aguardando'),
(2, '2025-05-07 02:27:04', 'Monáize', 21, '45231658974', 'Te esfaqueia pelas costas', 1, 'aguardando'),
(3, '2025-05-08 00:41:29', 'Ariézer', 21, '23564105784', 'Apenas um programador normal', 0, 'aguardando'),
(4, '2025-05-08 00:47:10', 'Jãozin das carça larga', 25, '42157846235', 'Tem as \'carça\' muito \'larga\'', 2, 'aguardando'),
(5, '2025-05-08 00:48:02', 'Rafael', 50, '13264875123', 'RAFAEL', 0, 'aguardando');

-- --------------------------------------------------------

--
-- Table structure for table `paciente`
--

CREATE TABLE `paciente` (
  `idPaciente` bigint(20) UNSIGNED NOT NULL,
  `nome` varchar(50) NOT NULL,
  `cpfPaciente` varchar(11) NOT NULL,
  `dataNascimento` date DEFAULT NULL,
  `endereco` varchar(255) DEFAULT NULL,
  `telefone` varchar(15) DEFAULT NULL,
  `faltas` int(11) NOT NULL,
  `ativo` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `paciente`
--

INSERT INTO `paciente` (`idPaciente`, `nome`, `cpfPaciente`, `dataNascimento`, `endereco`, `telefone`, `faltas`, `ativo`) VALUES
(1, 'Josevaldo', '', '1973-09-07', 'av Dr jose', '189956256', 0, 1),
(2, 'Rodoaldo Ribeiro', '', '1994-05-12', 'Rua Av Dr. General Jão', '75981618622', 0, 1),
(5, 'Monaize', '', '2004-04-16', 'av', '5', 0, 1),
(6, 'fsgfshghs', '', '1974-05-14', 'fngjf safjgl, 53', '5136151', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `setor`
--

CREATE TABLE `setor` (
  `idSetor` bigint(20) UNSIGNED NOT NULL,
  `nome` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `setor`
--

INSERT INTO `setor` (`idSetor`, `nome`) VALUES
(1, 'Ortopedia'),
(2, 'Paralisia Facial'),
(3, 'Neurologia Adulto'),
(4, 'Neurologia Infantil'),
(5, 'Reabilitação Pulmonar');

-- --------------------------------------------------------

--
-- Table structure for table `usuario`
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
  `ativo` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `usuario`
--

INSERT INTO `usuario` (`idUsuario`, `login`, `nome`, `senha`, `email`, `telefone`, `level`, `api_key`, `ativo`) VALUES
(1, 'G743962', 'Monaize', '$2y$10$196K2SmlkfNiEJ1p4//ieeeWNZ9opJHeokAsCNwLdaQ0qGDySsVC.', 'monaizedutra@gmail.com', '189948562', 'admin', '', 1),
(3, 'T653HA0', 'Matheus', '$2y$10$IMofWJxZ.yCN/fmGVGPQLeXDUh.q7ZENFW.9cYtHZxcyftgOkUcOG', 'matheusvcen@gmail.com', '', 'aluno', '', 0),
(5, 'ABC123', 'Rogério', '$2y$10$VxOUwKra2/Ebm8DxCMPur.Sem1hZb..D3meFLG21.Ed3255vTFw8S', 'rogerio@unip.com', '4531875135', 'aluno', '', 1),
(6, 'hsfu89erwferg', 'fdjuoiasg8wer9i', '$2y$10$JmhJSEM4mPQS55aTMiYCj.KLDwSttZOmAWcaZSqIMDKXM.NDG6H/C', 'kiguhgm@dsuhfo.om', '156161561', 'profissional', '', 1),
(7, '140496', 'Guilherme', '$2y$10$196K2SmlkfNiEJ1p4//ieeeWNZ9opJHeokAsCNwLdaQ0qGDySsVC.', 'guilherme@gmail.com', NULL, 'Admin', '', 1),
(8, '7656', 'Aldriano ', '$2y$10$PTxesF6pLKC4Qi.K24/5R.nxQZfQDujD6OBCA5ERPEjPP7kJLlGxG', 'aldriano@gmail.com', '18994323342', 'aluno', '', 1),
(9, '1010', 'Testando aluno', '$2y$10$M1a2injpgLcXE2J9DifXuOjZc74e53lVaEq23Bk2WxufV.u/wN.g.', 'aluno@gmail.com', '18996338628', 'aluno', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `usuario_setor`
--

CREATE TABLE `usuario_setor` (
  `idUsuario` int(11) NOT NULL,
  `idSetor` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `usuario_setor`
--

INSERT INTO `usuario_setor` (`idUsuario`, `idSetor`) VALUES
(8, 0),
(9, 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `agenda`
--
ALTER TABLE `agenda`
  ADD PRIMARY KEY (`idAgenda`);

--
-- Indexes for table `aluno_setor`
--
ALTER TABLE `aluno_setor`
  ADD PRIMARY KEY (`idUsuario`,`idSetor`);

--
-- Indexes for table `lista_espera`
--
ALTER TABLE `lista_espera`
  ADD PRIMARY KEY (`IdEspera`);

--
-- Indexes for table `paciente`
--
ALTER TABLE `paciente`
  ADD PRIMARY KEY (`idPaciente`);

--
-- Indexes for table `setor`
--
ALTER TABLE `setor`
  ADD PRIMARY KEY (`idSetor`);

--
-- Indexes for table `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`idUsuario`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `usuario_setor`
--
ALTER TABLE `usuario_setor`
  ADD PRIMARY KEY (`idUsuario`,`idSetor`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `agenda`
--
ALTER TABLE `agenda`
  MODIFY `idAgenda` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `lista_espera`
--
ALTER TABLE `lista_espera`
  MODIFY `IdEspera` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `paciente`
--
ALTER TABLE `paciente`
  MODIFY `idPaciente` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `setor`
--
ALTER TABLE `setor`
  MODIFY `idSetor` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `usuario`
--
ALTER TABLE `usuario`
  MODIFY `idUsuario` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
