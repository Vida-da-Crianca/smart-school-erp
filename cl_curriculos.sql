-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Tempo de geração: 20-Dez-2021 às 17:19
-- Versão do servidor: 5.7.31
-- versão do PHP: 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `sistema_escola`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `cl_curriculos`
--

DROP TABLE IF EXISTS `cl_curriculos`;
CREATE TABLE IF NOT EXISTS `cl_curriculos` (
  `id` int(99) NOT NULL AUTO_INCREMENT,
  `nome` text NOT NULL,
  `email` text NOT NULL,
  `cep` text NOT NULL,
  `endereco` text NOT NULL,
  `cpf` text NOT NULL,
  `rg` text NOT NULL,
  `funcao` text NOT NULL,
  `cargo` text NOT NULL,
  `departamento` text NOT NULL,
  `nome_pai` text NOT NULL,
  `nome_mae` text NOT NULL,
  `sexo` text NOT NULL,
  `data_nascimento` text NOT NULL,
  `telefone` text NOT NULL,
  `estado_civil` text NOT NULL,
  `escolaridade` text NOT NULL,
  `consideracoes` text NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
