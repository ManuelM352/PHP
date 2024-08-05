-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 23, 2024 at 03:26 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `web`
--

-- --------------------------------------------------------

--
-- Table structure for table `materia`
--

CREATE TABLE `materia` (
  `id` int(11) NOT NULL,
  `nombre_materia` varchar(50) NOT NULL,
  `descripcion` varchar(250) NOT NULL,
  `horario` varchar(50) DEFAULT NULL,
  `codigo_de_materia` varchar(100) NOT NULL,
  `creditos` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `materia`
--

INSERT INTO `materia` (`id`, `nombre_materia`, `descripcion`, `horario`, `codigo_de_materia`, `creditos`) VALUES
(1, 'Programación WEB II', 'nnskkssksk', '4:00 pm-5:00pm', 'S6S7Q', 4),
(2, 'Taller de Investigación', 'NA', '3:00pm-4:00pm', 'S23E', 5),
(3, 'Programación Móvil', 'ADSAASSSA', '1:00pm-2:00pm', 'S3EEQ', 5),
(5, 'Redes', 'DJDJDDHS', '6:00pm-7:00pm', 'QA34', 5),
(6, 'Automatas', 'SKSKSKSK', '11:00am-12:00pm', 'I9DJ', 4),
(8, 'Automatas', 'ADSAASSSA', '3:00pm-4:00pm', 'S3EEQQ', 4),
(9, 'sfhasoifhaslk', 'ofihweofiwhowj', '9', 'As58', 50);

-- --------------------------------------------------------

--
-- Table structure for table `plansemanal`
--

CREATE TABLE `plansemanal` (
  `id` int(11) NOT NULL,
  `lunes` varchar(150) NOT NULL,
  `martes` varchar(150) NOT NULL,
  `miercoles` varchar(150) NOT NULL,
  `jueves` varchar(150) NOT NULL,
  `viernes` varchar(150) NOT NULL,
  `fechaInicio` datetime DEFAULT NULL,
  `fechaFin` datetime DEFAULT NULL,
  `materia_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `plansemanal`
--

INSERT INTO `plansemanal` (`id`, `lunes`, `martes`, `miercoles`, `jueves`, `viernes`, `fechaInicio`, `fechaFin`, `materia_id`) VALUES
(5, 'HOLLALALAL', 'SIQKJSQJIQJIS', 'sssqsqsqsq', 'KKKKKKKKKKKKKKK', 'OSOSOSOSO', '2024-06-03 00:00:00', '2024-06-07 00:00:00', 3),
(6, 'dwwddwdwwd', 'wddwwwdwdw', 'ddddddddd', 'dwdqdld', 'dkddjdjdjj', '2024-05-20 00:00:00', '2024-05-24 00:00:00', 2),
(7, 'sqsqqaaaaa', 'xsxssxxxxx', 'qwwqwqwqw', 'qqwwqwqwq', 'aaaaaaaaaaaaaa', '2024-06-24 00:00:00', '2024-06-28 00:00:00', 3),
(8, 'HOLLALALAL', 'SIQKJSQJIQJIS', 'ddddddddd', 'dwdqdld', 'dkddjdjdjj', '2024-06-17 00:00:00', '2024-06-21 00:00:00', 3),
(12, 'dwwddwdwwd', 'SIQKJSQJIQJIS', 'ddddddddd', 'qqwwqwqwq', 'dkddjdjdjj', '2024-05-20 00:00:00', '2024-05-24 00:00:00', 5),
(20, 'HOLLALALAL', 'wddwwwdwdw', 'sssqsqsqsq', 'dwdqdld', 'OSOSOSOSO', '2024-05-27 00:00:00', '2024-05-31 00:00:00', 5),
(21, 'dwwddwdwwd', 'SIQKJSQJIQJIS', 'ddddddddd', 'qqwwqwqwq', 'OSOSOSOSO', '2024-06-03 00:00:00', '2024-06-07 00:00:00', 5),
(22, 'dwwddwdwwd', 'SIQKJSQJIQJIS', 'sssqsqsqsq', 'dwdqdld', 'qwqwqwqqww', '2024-05-20 00:00:00', '2024-05-24 00:00:00', 3),
(23, 'zazaz', 'rfrfrfr', 'hnhnhnhn', 'mkookm', 'poxw', '2024-05-20 00:00:00', '2024-05-24 00:00:00', 6),
(25, 'slkfalskf', 'kvjbjdfkvb', 'oiefhwoef', 'lafnlskns', 'alkfnlakfn', '2024-05-27 00:00:00', '2024-05-31 00:00:00', 9);

-- --------------------------------------------------------

--
-- Table structure for table `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellido1` varchar(50) NOT NULL,
  `apellido2` varchar(50) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `materia_id` int(11) DEFAULT NULL,
  `tipo` varchar(50) NOT NULL,
  `password` varchar(60) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `apellido1`, `apellido2`, `email`, `materia_id`, `tipo`, `password`) VALUES
(1, 'admin', 'admin', 'admin', 'admin@admin.com', NULL, 'Administrador', '58acb7acccce58ffa8b953b12b5a7702bd42dae441c1ad85057fa70b'),
(3, 'GSGS', 'Diaz', 'LopezK', 'ddzj917@gmail.com', 1, 'Usuario', 'f8cdb04495ded47615258f9dc6a3f4707fd2405434fefc3cbf4ef4e6'),
(4, 'David', 'Diaz', 'Lopez', 'david@gmail.com', 2, 'Usuario', 'f8cdb04495ded47615258f9dc6a3f4707fd2405434fefc3cbf4ef4e6'),
(6, 'Juan', 'Perez', 'AAAA', 'juan@gmail.com', 3, 'Usuario', 'f8cdb04495ded47615258f9dc6a3f4707fd2405434fefc3cbf4ef4e6'),
(17, 'Juan', 'Diaz', 'Lopez', 'de33@gmail.com', 5, 'Usuario', 'd14a028c2a3a2bc9476102bb288234c415a2b01f828ea62ac5b3e42f'),
(24, 'Diego', 'Martinez', '', 'diego@gmail.com', 6, 'Usuario', 'f8cdb04495ded47615258f9dc6a3f4707fd2405434fefc3cbf4ef4e6'),
(28, 'Juan', 'SUUU', 'Lopez', 'juaWn@gmail.com', 8, 'Usuario', 'd14a028c2a3a2bc9476102bb288234c415a2b01f828ea62ac5b3e42f'),
(29, 'cmmck', 'kssxmxmmx', 'osososo', 'dm@gmail.com', NULL, 'Administrador', 'd14a028c2a3a2bc9476102bb288234c415a2b01f828ea62ac5b3e42f'),
(31, 'adsdsfg', 'fdge', 'wfrg', 'ddzj9999@gmail.com', 9, 'Usuario', '7e6a4309ddf6e8866679f61ace4f621b0e3455ebac2e831a60f13cd1');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `materia`
--
ALTER TABLE `materia`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `codigo_de_materia` (`codigo_de_materia`);

--
-- Indexes for table `plansemanal`
--
ALTER TABLE `plansemanal`
  ADD PRIMARY KEY (`id`),
  ADD KEY `materia_id` (`materia_id`);

--
-- Indexes for table `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `materia_id` (`materia_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `materia`
--
ALTER TABLE `materia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `plansemanal`
--
ALTER TABLE `plansemanal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `plansemanal`
--
ALTER TABLE `plansemanal`
  ADD CONSTRAINT `plansemanal_ibfk_1` FOREIGN KEY (`materia_id`) REFERENCES `materia` (`id`);

--
-- Constraints for table `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`materia_id`) REFERENCES `materia` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
