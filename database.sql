-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 27-07-2026 a las 05:04:09
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `base1`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alumnos`
--

CREATE TABLE `alumnos` (
  `cedula` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `mail` varchar(70) NOT NULL,
  `codigocurso` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `alumnos`
--

INSERT INTO `alumnos` (`cedula`, `nombre`, `mail`, `codigocurso`) VALUES
(338890, 'Gerardo Marquez', 'gerardomerquez@Gmail.com', '1'),
(777777, 'Isaias Enmanuel Ravelo Marquez', 'isaiasenmanuelravelomarquez@gmail.com', '1'),
(5082017, 'isaac benjamin Ravelo Marquez', 'isaac@gmail.com', '3'),
(8442879, 'luis perez', 'luis@gmail.com', '2'),
(16945786, 'Lilian Yesenia  Marquez Barrera', 'Lilianyesenia43@gmail.com', '1'),
(18169247, 'Jose Gregorio Ravelo', 'josegregorioraveloinfante@gmail.com', '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cursos`
--

CREATE TABLE `cursos` (
  `codigo` varchar(10) NOT NULL,
  `nombre_curso` varchar(100) NOT NULL,
  `profesor` varchar(100) NOT NULL,
  `estado` varchar(20) NOT NULL DEFAULT 'Activo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cursos`
--

INSERT INTO `cursos` (`codigo`, `nombre_curso`, `profesor`, `estado`) VALUES
('1', 'PHP', 'Prof. García', 'Activo'),
('2', 'ASP', 'Prof. Pérez', 'Activo'),
('3', 'JSP', 'Prof. López', 'Activo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `cedula` int(11) NOT NULL,
  `mail` varchar(70) NOT NULL,
  `nombre` varchar(70) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`cedula`, `mail`, `nombre`) VALUES
(18169247, 'josegregorioraveloinfante@gmail.com', 'Jose Ravelo');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `alumnos`
--
ALTER TABLE `alumnos`
  ADD PRIMARY KEY (`cedula`);

--
-- Indices de la tabla `cursos`
--
ALTER TABLE `cursos`
  ADD PRIMARY KEY (`codigo`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`cedula`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
