-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 03-12-2024 a las 14:38:12
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `juegorus`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comprado`
--

CREATE TABLE `comprado` (
  `idCompra` int(11) NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `idJuego` int(11) NOT NULL,
  `fechaCompra` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `genero`
--

CREATE TABLE `genero` (
  `idGenero` int(11) NOT NULL,
  `genero` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `genero`
--

INSERT INTO `genero` (`idGenero`, `genero`) VALUES
(1, 'Acción'),
(2, 'Aventura'),
(3, 'Rol'),
(4, 'Simulación'),
(5, 'Estrategia'),
(6, 'Deportes'),
(7, 'Carreras'),
(8, 'Shooter'),
(9, 'Puzzle'),
(10, 'Arcade'),
(11, 'Survival Horror'),
(12, 'Plataformas'),
(13, 'Lucha'),
(14, 'MMORPG'),
(15, 'Battle Royale'),
(16, 'Música');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `juego`
--

CREATE TABLE `juego` (
  `idJuego` int(11) NOT NULL,
  `titulo` varchar(50) NOT NULL,
  `desarrollador` varchar(50) NOT NULL,
  `distribuidor` varchar(50) NOT NULL,
  `anio` year(4) NOT NULL,
  `ruta` varchar(255) NOT NULL,
  `idGenero` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prestado`
--

CREATE TABLE `prestado` (
  `idPrestamo` int(11) NOT NULL,
  `idUsuarioPresta` int(11) NOT NULL,
  `idUsuarioRecibe` int(11) NOT NULL,
  `idJuego` int(11) NOT NULL,
  `fechaInicio` datetime NOT NULL,
  `fechaFin` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `regalado`
--

CREATE TABLE `regalado` (
  `idRegalo` int(11) NOT NULL,
  `idUsuarioRegala` int(11) NOT NULL,
  `idUsuarioRecibe` int(11) NOT NULL,
  `idJuego` int(11) NOT NULL,
  `fechaRegalo` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tarjeta`
--

CREATE TABLE `tarjeta` (
  `idTarjeta` int(11) NOT NULL,
  `ccv` int(11) NOT NULL,
  `fechaCaducidad` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `idUsuario` int(11) NOT NULL,
  `nick` varchar(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `idTarjeta` int(11) DEFAULT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellidos` varchar(50) NOT NULL,
  `contrasenia` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`idUsuario`, `nick`, `email`, `idTarjeta`, `nombre`, `apellidos`, `contrasenia`) VALUES
(1, 'dickDestroy', 'disckDestroyer69@gmail.com', NULL, 'Escro', 'Tolamo', '12345'),
(3, 'PirateKing', 'mugiwara@gmail.com', NULL, 'Monkey D.', 'Luffy', '$2y$10$JpJFZgRXO2KUMnvKhE.TW.hmfILFTQIsydW5m1QxGvE5KO617w3A6');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `comprado`
--
ALTER TABLE `comprado`
  ADD PRIMARY KEY (`idCompra`),
  ADD KEY `fk_usuario_compra` (`idUsuario`),
  ADD KEY `fk_juego_compra` (`idJuego`);

--
-- Indices de la tabla `genero`
--
ALTER TABLE `genero`
  ADD PRIMARY KEY (`idGenero`);

--
-- Indices de la tabla `juego`
--
ALTER TABLE `juego`
  ADD PRIMARY KEY (`idJuego`),
  ADD KEY `fk_genero` (`idGenero`);

--
-- Indices de la tabla `prestado`
--
ALTER TABLE `prestado`
  ADD PRIMARY KEY (`idPrestamo`),
  ADD KEY `idx_usuario_presta` (`idUsuarioPresta`),
  ADD KEY `idx_usuario_recibe` (`idUsuarioRecibe`),
  ADD KEY `idx_juego_prestamo` (`idJuego`);

--
-- Indices de la tabla `regalado`
--
ALTER TABLE `regalado`
  ADD PRIMARY KEY (`idRegalo`),
  ADD KEY `fk_usuario_regala` (`idUsuarioRegala`),
  ADD KEY `fk_usuario_recibe` (`idUsuarioRecibe`),
  ADD KEY `fk_juego_regala` (`idJuego`);

--
-- Indices de la tabla `tarjeta`
--
ALTER TABLE `tarjeta`
  ADD PRIMARY KEY (`idTarjeta`),
  ADD UNIQUE KEY `ccv` (`ccv`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`idUsuario`),
  ADD UNIQUE KEY `nick` (`nick`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `fk_tarjeta` (`idTarjeta`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `comprado`
--
ALTER TABLE `comprado`
  MODIFY `idCompra` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `genero`
--
ALTER TABLE `genero`
  MODIFY `idGenero` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `juego`
--
ALTER TABLE `juego`
  MODIFY `idJuego` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `prestado`
--
ALTER TABLE `prestado`
  MODIFY `idPrestamo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `regalado`
--
ALTER TABLE `regalado`
  MODIFY `idRegalo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tarjeta`
--
ALTER TABLE `tarjeta`
  MODIFY `idTarjeta` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `idUsuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `comprado`
--
ALTER TABLE `comprado`
  ADD CONSTRAINT `fk_juego_compra` FOREIGN KEY (`idJuego`) REFERENCES `juego` (`idJuego`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_usuario_compra` FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`idUsuario`) ON DELETE CASCADE;

--
-- Filtros para la tabla `juego`
--
ALTER TABLE `juego`
  ADD CONSTRAINT `fk_genero` FOREIGN KEY (`idGenero`) REFERENCES `genero` (`idGenero`) ON DELETE SET NULL;

--
-- Filtros para la tabla `prestado`
--
ALTER TABLE `prestado`
  ADD CONSTRAINT `fk_prestamo_juego` FOREIGN KEY (`idJuego`) REFERENCES `juego` (`idJuego`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_prestamo_usuario_presta` FOREIGN KEY (`idUsuarioPresta`) REFERENCES `usuario` (`idUsuario`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_prestamo_usuario_recibe` FOREIGN KEY (`idUsuarioRecibe`) REFERENCES `usuario` (`idUsuario`) ON DELETE CASCADE;

--
-- Filtros para la tabla `regalado`
--
ALTER TABLE `regalado`
  ADD CONSTRAINT `fk_juego_regala` FOREIGN KEY (`idJuego`) REFERENCES `juego` (`idJuego`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_usuario_recibe` FOREIGN KEY (`idUsuarioRecibe`) REFERENCES `usuario` (`idUsuario`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_usuario_regala` FOREIGN KEY (`idUsuarioRegala`) REFERENCES `usuario` (`idUsuario`) ON DELETE CASCADE;

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `fk_tarjeta` FOREIGN KEY (`idTarjeta`) REFERENCES `tarjeta` (`idTarjeta`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
