-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Tempo de geração: 05/08/2021 às 23:33
-- Versão do servidor: 10.4.13-MariaDB
-- Versão do PHP: 7.2.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: sistema_veiculos
--

-- --------------------------------------------------------

--
-- Estrutura para tabela anuncios
--

CREATE TABLE anuncios (
  id int(11) NOT NULL,
  modelo_id int(11) NOT NULL,
  ano int(11) NOT NULL,
  valor_compra decimal(8,2) NOT NULL,
  valor_venda decimal(8,2) NOT NULL,
  cor varchar(45) NOT NULL,
  data_venda date DEFAULT NULL,
  tipo_combustivel_id int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura para tabela marcas
--

CREATE TABLE marcas (
  id int(11) NOT NULL,
  nome varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura para tabela modelos
--

CREATE TABLE modelos (
  id int(11) NOT NULL,
  descricao varchar(40) NOT NULL,
  marca_id int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura para tabela tipo_combustiveis
--

CREATE TABLE tipo_combustiveis (
  id int(11) NOT NULL,
  descricao varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Despejando dados para a tabela tipo_combustiveis
--

INSERT INTO tipo_combustiveis (id, descricao) VALUES
(1, 'Gasolina'),
(2, 'Álcool'),
(3, 'Diesel');

-- --------------------------------------------------------

--
-- Estrutura para tabela users
--

CREATE TABLE users (
  id int(11) NOT NULL,
  nome varchar(250) DEFAULT NULL,
  login varchar(70) DEFAULT NULL,
  senha varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Despejando dados para a tabela users
--

INSERT INTO users (id, nome, login, senha) VALUES
(1, 'Usuário', 'usuario', '40bd001563085fc35165329ea1ff5c5ecbdbbeef');

--
-- Índices de tabelas apagadas
--

--
-- Índices de tabela anuncios
--
ALTER TABLE anuncios
  ADD PRIMARY KEY (id),
  ADD KEY fk_anuncios_modelos1_idx (modelo_id),
  ADD KEY fk_anuncios_combustivel1_idx (tipo_combustivel_id);

--
-- Índices de tabela marcas
--
ALTER TABLE marcas
  ADD PRIMARY KEY (id);

--
-- Índices de tabela modelos
--
ALTER TABLE modelos
  ADD PRIMARY KEY (id),
  ADD KEY fk_modelo_marca (marca_id);

--
-- Índices de tabela tipo_combustiveis
--
ALTER TABLE tipo_combustiveis
  ADD PRIMARY KEY (id);

--
-- Índices de tabela users
--
ALTER TABLE users
  ADD PRIMARY KEY (id);

--
-- AUTO_INCREMENT de tabelas apagadas
--

--
-- AUTO_INCREMENT de tabela anuncios
--
ALTER TABLE anuncios
  MODIFY id int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela marcas
--
ALTER TABLE marcas
  MODIFY id int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela modelos
--
ALTER TABLE modelos
  MODIFY id int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela tipo_combustiveis
--
ALTER TABLE tipo_combustiveis
  MODIFY id int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela users
--
ALTER TABLE users
  MODIFY id int(11) NOT NULL AUTO_INCREMENT;

--
-- Restrições para dumps de tabelas
--

--
-- Restrições para tabelas anuncios
--
ALTER TABLE anuncios
  ADD CONSTRAINT fk_anuncios_modelos1 FOREIGN KEY (modelo_id) REFERENCES modelos (id) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT fk_anuncios_tipo_combustiveis1 FOREIGN KEY (tipo_combustivel_id) REFERENCES tipo_combustiveis (id) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Restrições para tabelas modelos
--
ALTER TABLE modelos
  ADD CONSTRAINT fk_modelo_marca FOREIGN KEY (marca_id) REFERENCES marcas (id);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
