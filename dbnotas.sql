-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 12, 2023 at 04:46 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

-- CREATE DATABASE dbnotas;
-- USE dbnotas;

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dbnotas`
--

-- --------------------------------------------------------

--
-- Table structure for table `categorias`
--

CREATE TABLE `categorias` (
  `id` int(11) NOT NULL,
  `usuario` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categorias`
--

INSERT INTO `categorias` (`id`, `usuario`) VALUES
(1, 'Trabajo'),
(2, 'Estudios'),
(3, 'Personal');

-- --------------------------------------------------------

--
-- Table structure for table `notas`
--

CREATE TABLE `notas` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `titulo` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `categoria_id` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `estado` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notas`
--

INSERT INTO `notas` (`id`, `id_usuario`, `titulo`, `descripcion`, `categoria_id`, `fecha`, `estado`) VALUES
(1, 1, 'Nota de Ejemplo 1', 'Esta es una nota de ejemplo número 1.', 1, '2023-11-10', 1),
(2, 1, 'Nota de Ejemplo 2', 'Esta es una nota de ejemplo número 2.', 2, '2023-11-11', 1),
(3, 2, 'Mi Lista de Compras', 'Leche, pan, huevos, frutas.', 3, '2023-11-12', 1),
(4, 2, 'Tareas Pendientes', 'Terminar el informe y enviar correos.', 2, '2023-11-13', 1),
(5, 3, 'Ideas para el Proyecto', 'Recopilar ideas y diseñar el proyecto.', 3, '2023-11-14', 1);

-- --------------------------------------------------------

--
-- Table structure for table `papelera`
--

CREATE TABLE `papelera` (
  `idpapelera` int(11) NOT NULL,
  `idnota` int(11) NOT NULL,
  `fecha` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `usuario` varchar(50) DEFAULT NULL,
  `contrasenia` varchar(50) DEFAULT NULL,
  `privilegio` enum('administrador','cliente') DEFAULT NULL,
  `nombre` varchar(120) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `usuarios`
--

INSERT INTO `usuarios` (`id`, `usuario`, `contrasenia`, `privilegio`, `nombre`) VALUES
(1, 'usuario1', 'contrasenia1', 'administrador', 'Admin 1'),
(2, 'usuario2', 'contrasenia2', 'cliente', 'Cliente 1'),
(3, 'usuario3', 'contrasenia3', 'cliente', 'Cliente 2'),
(4, 'usuario4', 'contrasenia4', 'administrador', 'Admin 2'),
(5, 'usuario5', 'contrasenia5', 'cliente', 'Cliente 3');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notas`
--
ALTER TABLE `notas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `categoria_id` (`categoria_id`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indexes for table `papelera`
--
ALTER TABLE `papelera`
  ADD KEY `idnota` (`idnota`);

--
-- Indexes for table `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `notas`
--
ALTER TABLE `notas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `notas`
--
ALTER TABLE `notas`
  ADD CONSTRAINT `notas_ibfk_1` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`id`),
  ADD CONSTRAINT `notas_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `papelera`
--
ALTER TABLE `papelera`
  ADD CONSTRAINT `papelera_ibfk_1` FOREIGN KEY (`idnota`) REFERENCES `notas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
