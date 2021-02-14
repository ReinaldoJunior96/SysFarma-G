-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 15-Fev-2021 às 00:02
-- Versão do servidor: 10.4.13-MariaDB
-- versão do PHP: 7.4.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `boxhub`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `tbl_avaria`
--

CREATE TABLE `tbl_avaria` (
  `id_avaria` int(11) NOT NULL,
  `produto_avaria` int(11) DEFAULT NULL,
  `quantidade_avaria` int(11) DEFAULT NULL,
  `lote_avaria` varchar(255) DEFAULT NULL,
  `vencimento_avaria` date DEFAULT NULL,
  `obs_avaria` text DEFAULT NULL,
  `data_cadastro` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `tbl_avaria`
--

INSERT INTO `tbl_avaria` (`id_avaria`, `produto_avaria`, `quantidade_avaria`, `lote_avaria`, `vencimento_avaria`, `obs_avaria`, `data_cadastro`) VALUES
(1, 10, 1231, 'asdasd1231', '2021-02-12', 'asdasda', '2021-02-10 23:08:17'),
(2, 10, 1231, 'asdasd1231', '2021-02-12', 'asdasda', '2021-02-10 19:13:41'),
(3, 20, 4, '24wre', '2021-02-25', '234234234234', '2021-02-10 19:17:14'),
(4, 22, 2, 'IKHD21', '2021-02-13', 'ESSA OBSERVAÇÃO ELA VAI FICAR MUITO GRANDE MAS COMO A FUNÇÃO TA SENDO TESTADA ELA VAI FICAR BEM PEQUENA E VAI FICAR MUITO BOM DE SE LER', '2021-02-10 19:37:28'),
(5, 20, 23, '21231dasda', '2021-02-03', 'dddddd', '2021-02-12 12:26:43'),
(6, 25, 23, 'asdasd2342', '2021-02-20', 'asas', '2021-02-12 13:21:59');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `tbl_avaria`
--
ALTER TABLE `tbl_avaria`
  ADD PRIMARY KEY (`id_avaria`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `tbl_avaria`
--
ALTER TABLE `tbl_avaria`
  MODIFY `id_avaria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
