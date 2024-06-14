-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 09-06-2024 a las 21:39:58
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
-- Base de datos: `doctors_db`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `info`
--

CREATE TABLE `info` (
  `id` int(11) NOT NULL,
  `medico_id` int(11) DEFAULT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `fecha_inscripcion` date DEFAULT NULL,
  `matricula_mpps` varchar(20) DEFAULT NULL,
  `especialidad_1` varchar(100) DEFAULT NULL,
  `especialidad_1_fecha` date DEFAULT NULL,
  `especialidad_1_numero` varchar(20) DEFAULT NULL,
  `especialidad_1_folio` varchar(20) DEFAULT NULL,
  `especialidad_2` varchar(100) DEFAULT NULL,
  `especialidad_2_fecha` date DEFAULT NULL,
  `especialidad_2_numero` varchar(20) DEFAULT NULL,
  `especialidad_2_folio` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `info`
--

INSERT INTO `info` (`id`, `medico_id`, `fecha_nacimiento`, `fecha_inscripcion`, `matricula_mpps`, `especialidad_1`, `especialidad_1_fecha`, `especialidad_1_numero`, `especialidad_1_folio`, `especialidad_2`, `especialidad_2_fecha`, `especialidad_2_numero`, `especialidad_2_folio`) VALUES
(1, NULL, '0000-00-00', '0000-00-00', '130031', '', '0000-00-00', '', '', '', '0000-00-00', '', ''),
(2, NULL, '0000-00-00', '0000-00-00', '98764', '', '0000-00-00', '', '', '', '0000-00-00', '', ''),
(3, NULL, '0000-00-00', '0000-00-00', '306654', '', '0000-00-00', '', '', '', '0000-00-00', '', ''),
(4, NULL, '1987-06-04', '2024-06-12', '130031', '', NULL, '', '', '', NULL, '', ''),
(10, NULL, '2024-06-04', '2024-06-27', '130031', '', NULL, '', '', '', NULL, '', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `login_records`
--

CREATE TABLE `login_records` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `login_time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `medicos`
--

CREATE TABLE `medicos` (
  `id` int(11) NOT NULL,
  `cedula` varchar(20) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellido` varchar(50) NOT NULL,
  `estatus` enum('Definitivo','Provisional') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `medicos`
--

INSERT INTO `medicos` (`id`, `cedula`, `nombre`, `apellido`, `estatus`) VALUES
(1, '30160490', 'Leniangel', 'Perez', 'Definitivo'),
(3, '30626369', 'Josue', 'Armas', 'Provisional');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pagos`
--

CREATE TABLE `pagos` (
  `id` int(11) NOT NULL,
  `medico_id` int(11) DEFAULT NULL,
  `cuota_colegio` decimal(10,2) DEFAULT NULL,
  `cuota_fmv` decimal(10,2) DEFAULT NULL,
  `pago_montepio` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pagos`
--

INSERT INTO `pagos` (`id`, `medico_id`, `cuota_colegio`, `cuota_fmv`, `pago_montepio`) VALUES
(1, 1, 0.00, 0.00, 0.00),
(3, 3, 0.00, 0.00, 0.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `rol` enum('admin','visualizador') NOT NULL,
  `contrasena` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `nombre`, `correo`, `rol`, `contrasena`) VALUES
(4, 'Leni', 'leniangel03@gmail.com', 'admin', '$2y$10$5fqGgiZPkCf5x5mlxnmAXOi9ezm5FKCeu4rmkTqfk/WgsriBArYBa');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `info`
--
ALTER TABLE `info`
  ADD PRIMARY KEY (`id`),
  ADD KEY `medico_id` (`medico_id`);

--
-- Indices de la tabla `login_records`
--
ALTER TABLE `login_records`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indices de la tabla `medicos`
--
ALTER TABLE `medicos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `pagos`
--
ALTER TABLE `pagos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `medico_id` (`medico_id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `correo` (`correo`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `info`
--
ALTER TABLE `info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `login_records`
--
ALTER TABLE `login_records`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `pagos`
--
ALTER TABLE `pagos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `info`
--
ALTER TABLE `info`
  ADD CONSTRAINT `info_ibfk_1` FOREIGN KEY (`medico_id`) REFERENCES `medicos` (`id`);

--
-- Filtros para la tabla `login_records`
--
ALTER TABLE `login_records`
  ADD CONSTRAINT `login_records_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Filtros para la tabla `pagos`
--
ALTER TABLE `pagos`
  ADD CONSTRAINT `pagos_ibfk_1` FOREIGN KEY (`medico_id`) REFERENCES `medicos` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
