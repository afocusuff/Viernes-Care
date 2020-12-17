-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 17-12-2020 a las 13:32:11
-- Versión del servidor: 5.7.24
-- Versión de PHP: 7.2.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `paciente`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `paciente`
--

CREATE TABLE `paciente` (
  `idPaciente` int(8) NOT NULL,
  `clavePaciente` int(8) NOT NULL,
  `docIdPaciente` varchar(9) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `emailPaciente` varchar(50) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `telefonoPaciente` int(9) NOT NULL,
<<<<<<< HEAD
  `clavePaciente` int(8) NOT NULL,
  `estado` varchar(9) COLLATE utf8mb4_spanish2_ci NULL
=======
  `estado` varchar(9) COLLATE utf8mb4_spanish2_ci DEFAULT NULL
>>>>>>> b8d0831e638d61b2fe940cb6b01a86ed208f0a35
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `paciente`
--

INSERT INTO `paciente` (`idPaciente`, `clavePaciente`, `docIdPaciente`, `emailPaciente`, `telefonoPaciente`, `estado`) VALUES
(1, 0, '44455577M', 'yo@gmail.com', 666777888, NULL),
(2, 16494996, '44455577E', 'tu@gmail.com', 666777999, NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `paciente`
--
ALTER TABLE `paciente`
  ADD PRIMARY KEY (`idPaciente`),
  ADD UNIQUE KEY `docIdPaciente` (`docIdPaciente`),
  ADD UNIQUE KEY `emailPaciente` (`emailPaciente`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `paciente`
--
ALTER TABLE `paciente`
  MODIFY `idPaciente` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
