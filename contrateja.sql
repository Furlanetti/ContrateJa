-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 26-Maio-2020 às 23:52
-- Versão do servidor: 10.1.21-MariaDB
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `contrateja`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `address`
--

CREATE TABLE `address` (
  `address_id` int(11) NOT NULL,
  `state` varchar(255) DEFAULT NULL,
  `city_id` varchar(255) DEFAULT NULL,
  `neighborhood` varchar(255) DEFAULT NULL,
  `street` varchar(255) DEFAULT NULL,
  `number` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `address`
--

INSERT INTO `address` (`address_id`, `state`, `city_id`, `neighborhood`, `street`, `number`) VALUES
(1, NULL, '1', '', NULL, '');

-- --------------------------------------------------------

--
-- Estrutura da tabela `category`
--

CREATE TABLE `category` (
  `category_id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `active` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `category`
--

INSERT INTO `category` (`category_id`, `title`, `active`) VALUES
(1, 'T.I', 1),
(2, 'Manutenção Residencial', 1),
(3, 'Manutenção de Máquinas', 1),
(4, 'Transporte', 1),
(5, 'Decoração', 1),
(6, 'Limpeza', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `city`
--

CREATE TABLE `city` (
  `city_id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `active` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `city`
--

INSERT INTO `city` (`city_id`, `name`, `active`) VALUES
(1, 'Caraguatatuba', 1),
(2, 'São Sebastião', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `company`
--

CREATE TABLE `company` (
  `company_id` int(11) NOT NULL,
  `company_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `cpf` varchar(11) DEFAULT NULL,
  `cnpj` varchar(14) DEFAULT NULL,
  `how_contact` varchar(255) DEFAULT NULL,
  `active` int(11) NOT NULL DEFAULT '1',
  `image` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `inf_contact_id` int(11) NOT NULL,
  `address_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `company`
--

INSERT INTO `company` (`company_id`, `company_name`, `email`, `password`, `cpf`, `cnpj`, `how_contact`, `active`, `image`, `description`, `inf_contact_id`, `address_id`) VALUES
(1, 'Felipe\'s Desenvolvimento Web', 'felipe.furlanetti1@gmail.com', '2d4b87558d836127505e2e6f33e33864fe357297', NULL, '', NULL, 1, NULL, NULL, 1, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `company_category`
--

CREATE TABLE `company_category` (
  `company_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `company_category`
--

INSERT INTO `company_category` (`company_id`, `category_id`) VALUES
(1, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `company_subcategory`
--

CREATE TABLE `company_subcategory` (
  `subcategory_id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `company_subcategory`
--

INSERT INTO `company_subcategory` (`subcategory_id`, `company_id`) VALUES
(1, 1),
(6, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `consumer`
--

CREATE TABLE `consumer` (
  `consumer_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `cpf` varchar(11) DEFAULT NULL,
  `cnpj` varchar(14) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `active` int(11) NOT NULL DEFAULT '1',
  `inf_contact_id` int(11) DEFAULT NULL,
  `address_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `consumer`
--

INSERT INTO `consumer` (`consumer_id`, `name`, `email`, `password`, `cpf`, `cnpj`, `image`, `active`, `inf_contact_id`, `address_id`) VALUES
(6, 'Felipe', 'felipe.furlanetti@hotmail.com', '2d4b87558d836127505e2e6f33e33864fe357297', NULL, NULL, NULL, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `estimate`
--

CREATE TABLE `estimate` (
  `estimate_id` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `request_estimate_id` int(11) NOT NULL,
  `datetime` datetime NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `company_id` int(11) NOT NULL,
  `price` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `estimate`
--

INSERT INTO `estimate` (`estimate_id`, `status`, `request_estimate_id`, `datetime`, `title`, `description`, `company_id`, `price`) VALUES
(1, 0, 1, '2017-08-23 11:00:53', 'Site com 5 páginas navegáveis.', 'Prazo de desenvolvimento de 2 semanas, porém irei precisar de sua logo, nome da empresa e exemplos de sites que você goste para me basear melhor.', 1, 3.5);

-- --------------------------------------------------------

--
-- Estrutura da tabela `inf_contact`
--

CREATE TABLE `inf_contact` (
  `inf_contact_id` int(11) NOT NULL,
  `cellphone` varchar(11) DEFAULT NULL,
  `phone` varchar(11) DEFAULT NULL,
  `whatsapp` varchar(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `inf_contact`
--

INSERT INTO `inf_contact` (`inf_contact_id`, `cellphone`, `phone`, `whatsapp`) VALUES
(1, NULL, '12988640380', '12988640380');

-- --------------------------------------------------------

--
-- Estrutura da tabela `request_estimate`
--

CREATE TABLE `request_estimate` (
  `request_estimate_id` int(11) NOT NULL,
  `estimate_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `datetime` datetime NOT NULL,
  `company_id` int(11) NOT NULL,
  `consumer_id` int(11) NOT NULL,
  `description` text NOT NULL,
  `status` int(11) NOT NULL,
  `title` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `request_estimate`
--

INSERT INTO `request_estimate` (`request_estimate_id`, `estimate_id`, `category_id`, `datetime`, `company_id`, `consumer_id`, `description`, `status`, `title`) VALUES
(1, 0, 0, '2017-08-23 10:45:05', 1, 6, 'Site com 5 páginas, galeria de imagem e página de contato.', 1, 'Desenvolvimento de Site ');

-- --------------------------------------------------------

--
-- Estrutura da tabela `service`
--

CREATE TABLE `service` (
  `service_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `company_id` int(11) NOT NULL,
  `consumer_id` int(11) NOT NULL,
  `subcategory_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `subcategory`
--

CREATE TABLE `subcategory` (
  `subcategory_id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `active` int(11) NOT NULL DEFAULT '1',
  `category_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `subcategory`
--

INSERT INTO `subcategory` (`subcategory_id`, `title`, `active`, `category_id`) VALUES
(1, 'Manutenção de Computadores', 1, 1),
(2, 'Manutenção de Smartphones', 1, 1),
(3, 'Manutenção de Notebooks', 1, 1),
(4, 'Redes', 1, 1),
(5, 'Compra de Equipamento', 1, 1),
(6, 'Desenvolvimento de Sistemas', 1, 1),
(7, 'Serviços de Jardinagem', 1, 2),
(8, 'Manutenção de Piscinas', 1, 2),
(9, 'Serviços de Pintura', 1, 2),
(10, 'Serviços Elétricos', 1, 2),
(11, 'Serviços Gerais', 1, 2),
(12, 'Equipamentos de Aquecimento', 1, 3),
(13, 'Equipamentos de Refrigeração', 1, 3),
(14, 'Mecânico de Carros', 1, 3),
(15, 'Mecânico de Motos', 1, 3),
(16, 'Transporte Intermunicipal de Pessoas', 1, 4),
(17, 'Transporte Municipal de Pessoas', 1, 4),
(18, 'Transporte de Objetos', 1, 4),
(19, 'Decoração Residêncial', 1, 5),
(20, 'Decoração Empresarial', 1, 5),
(21, 'Decoração de Eventos', 1, 5),
(22, 'Diarista', 1, 6),
(23, 'Empregada Mensalista', 1, 6),
(24, 'Limpeza Empresarial', 1, 6);

-- --------------------------------------------------------

--
-- Estrutura da tabela `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `active` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `address`
--
ALTER TABLE `address`
  ADD PRIMARY KEY (`address_id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `city`
--
ALTER TABLE `city`
  ADD PRIMARY KEY (`city_id`);

--
-- Indexes for table `company`
--
ALTER TABLE `company`
  ADD PRIMARY KEY (`company_id`),
  ADD KEY `fk_prestador_inf_contato1_idx` (`inf_contact_id`),
  ADD KEY `fk_prestador_endereco1_idx` (`address_id`);

--
-- Indexes for table `company_category`
--
ALTER TABLE `company_category`
  ADD PRIMARY KEY (`company_id`,`category_id`),
  ADD KEY `fk_prestador_has_categoria_categoria1_idx` (`category_id`),
  ADD KEY `fk_prestador_has_categoria_prestador1_idx` (`company_id`);

--
-- Indexes for table `company_subcategory`
--
ALTER TABLE `company_subcategory`
  ADD PRIMARY KEY (`subcategory_id`,`company_id`),
  ADD KEY `fk_sub_categoria_has_prestador_prestador1_idx` (`company_id`),
  ADD KEY `fk_sub_categoria_has_prestador_sub_categoria1_idx` (`subcategory_id`);

--
-- Indexes for table `consumer`
--
ALTER TABLE `consumer`
  ADD PRIMARY KEY (`consumer_id`),
  ADD KEY `fk_solicitante_inf_contato1_idx` (`inf_contact_id`),
  ADD KEY `fk_solicitante_endereco1_idx` (`address_id`);

--
-- Indexes for table `estimate`
--
ALTER TABLE `estimate`
  ADD PRIMARY KEY (`estimate_id`);

--
-- Indexes for table `inf_contact`
--
ALTER TABLE `inf_contact`
  ADD PRIMARY KEY (`inf_contact_id`);

--
-- Indexes for table `request_estimate`
--
ALTER TABLE `request_estimate`
  ADD PRIMARY KEY (`request_estimate_id`);

--
-- Indexes for table `service`
--
ALTER TABLE `service`
  ADD PRIMARY KEY (`service_id`),
  ADD KEY `fk_servico_prestador1_idx` (`company_id`),
  ADD KEY `fk_servico_solicitante1_idx` (`consumer_id`),
  ADD KEY `fk_servico_sub_categoria1_idx` (`subcategory_id`),
  ADD KEY `fk_servico_categoria1_idx` (`category_id`);

--
-- Indexes for table `subcategory`
--
ALTER TABLE `subcategory`
  ADD PRIMARY KEY (`subcategory_id`),
  ADD KEY `fk_sub_categoria_categoria_idx` (`category_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `address`
--
ALTER TABLE `address`
  MODIFY `address_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `city`
--
ALTER TABLE `city`
  MODIFY `city_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `company`
--
ALTER TABLE `company`
  MODIFY `company_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `consumer`
--
ALTER TABLE `consumer`
  MODIFY `consumer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `estimate`
--
ALTER TABLE `estimate`
  MODIFY `estimate_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `inf_contact`
--
ALTER TABLE `inf_contact`
  MODIFY `inf_contact_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `request_estimate`
--
ALTER TABLE `request_estimate`
  MODIFY `request_estimate_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `service`
--
ALTER TABLE `service`
  MODIFY `service_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `subcategory`
--
ALTER TABLE `subcategory`
  MODIFY `subcategory_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `company`
--
ALTER TABLE `company`
  ADD CONSTRAINT `fk_prestador_endereco1` FOREIGN KEY (`address_id`) REFERENCES `address` (`address_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_prestador_inf_contato1` FOREIGN KEY (`inf_contact_id`) REFERENCES `inf_contact` (`inf_contact_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `company_category`
--
ALTER TABLE `company_category`
  ADD CONSTRAINT `fk_prestador_has_categoria_categoria1` FOREIGN KEY (`category_id`) REFERENCES `category` (`category_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_prestador_has_categoria_prestador1` FOREIGN KEY (`company_id`) REFERENCES `company` (`company_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `company_subcategory`
--
ALTER TABLE `company_subcategory`
  ADD CONSTRAINT `fk_sub_categoria_has_prestador_prestador1` FOREIGN KEY (`company_id`) REFERENCES `company` (`company_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_sub_categoria_has_prestador_sub_categoria1` FOREIGN KEY (`subcategory_id`) REFERENCES `subcategory` (`subcategory_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `consumer`
--
ALTER TABLE `consumer`
  ADD CONSTRAINT `fk_solicitante_endereco1` FOREIGN KEY (`address_id`) REFERENCES `address` (`address_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_solicitante_inf_contato1` FOREIGN KEY (`inf_contact_id`) REFERENCES `inf_contact` (`inf_contact_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `service`
--
ALTER TABLE `service`
  ADD CONSTRAINT `fk_servico_categoria1` FOREIGN KEY (`category_id`) REFERENCES `category` (`category_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_servico_prestador1` FOREIGN KEY (`company_id`) REFERENCES `company` (`company_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_servico_solicitante1` FOREIGN KEY (`consumer_id`) REFERENCES `consumer` (`consumer_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_servico_sub_categoria1` FOREIGN KEY (`subcategory_id`) REFERENCES `subcategory` (`subcategory_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `subcategory`
--
ALTER TABLE `subcategory`
  ADD CONSTRAINT `fk_sub_categoria_categoria` FOREIGN KEY (`category_id`) REFERENCES `category` (`category_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
