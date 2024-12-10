-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 10-12-2024 a las 18:35:07
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

--
-- Volcado de datos para la tabla `comprado`
--

INSERT INTO `comprado` (`idCompra`, `idUsuario`, `idJuego`, `fechaCompra`) VALUES
(1, 4, 16, '2024-12-06 15:52:52'),
(2, 4, 12, '2024-12-07 12:55:06');

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

--
-- Volcado de datos para la tabla `juego`
--

INSERT INTO `juego` (`idJuego`, `titulo`, `desarrollador`, `distribuidor`, `anio`, `ruta`, `idGenero`) VALUES
(1, 'The Legend of Zelda: Breath of the Wild', 'Nintendo', 'Nintendo', '2017', '/imagenes/zelda_botw.jpg', 1),
(2, 'God of War', 'Santa Monica Studio', 'Sony Interactive Entertainment', '2018', '/imagenes/god_of_war.jpg', 2),
(3, 'The Witcher 3: Wild Hunt', 'CD Projekt Red', 'CD Projekt', '2015', '/imagenes/witcher3.jpg', 3),
(4, 'Cyberpunk 2077', 'CD Projekt Red', 'CD Projekt', '2020', '/imagenes/cyberpunk2077.jpg', 3),
(5, 'Elden Ring', 'FromSoftware', 'Bandai Namco Entertainment', '2022', '/imagenes/elden_ring.jpg', 2),
(6, 'Red Dead Redemption 2', 'Rockstar Games', 'Rockstar Games', '2018', '/imagenes/rdr2.jpg', 4),
(7, 'Minecraft', 'Mojang Studios', 'Microsoft', '2011', '/imagenes/minecraft.jpg', 5),
(8, 'Overwatch', 'Blizzard Entertainment', 'Blizzard Entertainment', '2016', '/imagenes/overwatch.jpg', 6),
(9, 'Fortnite', 'Epic Games', 'Epic Games', '2017', '/imagenes/fortnite.jpg', 6),
(10, 'Super Mario Odyssey', 'Nintendo', 'Nintendo', '2017', '/imagenes/super_mario_odyssey.jpg', 1),
(11, 'Hollow Knight', 'Team Cherry', 'Team Cherry', '2017', '/imagenes/hollow_knight.jpg', 7),
(12, 'Dark Souls III', 'FromSoftware', 'Bandai Namco Entertainment', '2016', '/imagenes/dark_souls_3.jpg', 2),
(13, 'Call of Duty: Modern Warfare', 'Infinity Ward', 'Activision', '2019', '/imagenes/cod_mw.jpg', 8),
(14, 'Grand Theft Auto V', 'Rockstar Games', 'Rockstar Games', '2013', '/imagenes/gta_v.jpg', 4),
(15, 'Assassin’s Creed Valhalla', 'Ubisoft Montreal', 'Ubisoft', '2020', '/imagenes/ac_valhalla.jpg', 9),
(16, 'Animal Crossing: New Horizons', 'Nintendo', 'Nintendo', '2020', '/imagenes/animal_crossing_nh.jpg', 10),
(17, 'Stardew Valley', 'ConcernedApe', 'ConcernedApe', '2016', '/imagenes/stardew_valley.jpg', 11),
(18, 'Celeste', 'Maddy Makes Games', 'Maddy Makes Games', '2018', '/imagenes/celeste.jpg', 7),
(19, 'DOOM Eternal', 'id Software', 'Bethesda Softworks', '2020', '/imagenes/doom_eternal.jpg', 12),
(20, 'League of Legends', 'Riot Games', 'Riot Games', '2009', '/imagenes/league_of_legends.jpg', 6);

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
  `contrasenia` varchar(255) NOT NULL,
  `Apellido2` varchar(50) DEFAULT NULL,
  `TipoDeVia` varchar(50) DEFAULT NULL,
  `NombreDeVia` varchar(100) DEFAULT NULL,
  `Numero` int(11) DEFAULT NULL,
  `Numeros` varchar(50) DEFAULT NULL,
  `Otros` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`idUsuario`, `nick`, `email`, `idTarjeta`, `nombre`, `apellidos`, `contrasenia`, `Apellido2`, `TipoDeVia`, `NombreDeVia`, `Numero`, `Numeros`, `Otros`) VALUES
(1, 'dickDestroy', 'disckDestroyer69@gmail.com', NULL, 'Escro', 'Tolamo', '$2y$10$lkwk.6NdxTvG7WHBJGl/7O8iurq2RdxW3DiFEnJsnJ1UBDbEREmNC', 'López', 'Calle', 'Gran Vía', 123, '12B, 14C', 'Departamento 5B'),
(3, 'PirateKing', 'mugiwara@gmail.com', NULL, 'Monkey D.', 'Luffy', '$2y$10$JpJFZgRXO2KUMnvKhE.TW.hmfILFTQIsydW5m1QxGvE5KO617w3A6', 'Monkey', 'Avenida', 'Sunny Road', 456, '4A, 4B', 'Barco Pirata'),
(4, 'admin', 'admin@admin.es', NULL, 'admin', '', '$2y$10$PnVKzoYkiWcoLm/5H.0M0O8HHvbeCdQnHQa6xdbPMY90fynijS8nK', NULL, 'Plaza', 'Central', 1, NULL, 'Oficina Principal'),
(5, 'usuario', 'usuario@gmail.es', NULL, 'usuario', 'usuario', '$2y$10$gbKusejZEquUL9RoHKM62OUIQWGRfaZBn.QqECu1VPxUeZesy.hT2', 'Gómez', 'Calle', 'Paseo del Río', 789, 'A1, A2', 'Apartamento 8'),
(9, 'melocoton', 'eva@gmail.com', NULL, 'Eva', 'Alonso', '$2y$10$h5LJkF9qAa.kWaFnxzIAN.5rdzOWuaBRlAZsiS26NbOei3RpeToyW', 'Martínez', 'Avenida', 'Los Pinos', 101, '3A, 3B', 'Condominio Cerrado'),
(10, 'iceWolf', 'axel@gmail.com', NULL, 'Axel', 'José', '$2y$10$RwBDep4hmQSjRGxVRvnbQO.LJL4ha2w6CqPx.jL3F4evSYnG5UzMS', 'Rodríguez', 'Callejón', 'Roca Seca', 205, 'D1, D2', 'Casa de Campo'),
(11, 'prueba', 'prueba@es.es', NULL, 'prueba', 'prueba', '$2y$10$lD.qv2kmU5XgoABo1ruOveqAH2QlIDekmbbN8l7o9Cgqn2J/pK6j.', NULL, 'Boulevard', 'Estrella', 306, NULL, 'Edificio Principal'),
(12, 'pepito', 'pepe@pepe.es', NULL, 'pepe', 'pepe', '$2y$10$nsQjIVPn/3ptBqTGgegUIOhIRGXJ8/5Wqpjt2L6AcSje9r9ttWUPq', 'Hernández', 'Pasaje', 'Primavera', 405, '5B, 5C', 'Villa Residencial'),
(14, '', '', NULL, '', '', '$2y$10$rEw4W6qRC09wvjcGdqXDdOmHc0fLtacC/xrd0wmSjw9iJvtWTGiXG', NULL, NULL, NULL, NULL, NULL, NULL),
(16, 'luisito', 'luis@gmail.com', NULL, 'luis', 'luis', '$2y$10$PzIZ0Uzgnpc/ATZq.FzOle8JPSvd71RPKNiQkS8Gpn9oOyE9MO5Gy', 'Fernández', 'Camino', 'El Prado', 501, '1A, 2B', 'Finca Los Rosales'),
(17, 'alumnito', 'alumno@gmail.com', NULL, 'alumno', 'alumno', '$2y$10$fS3DkDKR9R51ks9ChizMEuP8eLnrMV2xmgWEryTdFDHZ8z1mcG4DW', 'García', 'Autopista', 'Del Sol', 600, NULL, 'Local Comercial'),
(20, 'profe', 'profe@es.es', NULL, 'profe', 'profe', '$2y$10$uYLAafcWG.g20IOzC4q8luR3ZOIMWFvbm7r31qtnU9oRT9WvNt4M.', 'Ramos', 'Travesía', 'La Fuente', 705, '1C, 2D', 'Complejo Industrial'),
(21, 'pruebita1', 'prueba1@es.es', NULL, 'prueba1', 'preuba', '$2y$10$f/6waIpKwh3Ri3jbxr0SLODjSkZoBzSTjRIm0Q.SlPIWPKLLMT0h2', 'Suárez', 'Calle', 'Jardines', 802, 'A2, B3', 'Casa de Playa'),
(30, 'anita90', 'ana@gmail.com', NULL, 'Ana', 'Alvarez', '$2y$10$HOGE/jkQZxWCrpx/YPu6XebUZ1ZufqXqtJelXPZeQiAmOONXfH3Q6', 'Vega', 'Camino', 'Las Lomas', 905, '1F, 2G', 'Zona Rural'),
(31, 'qwerty', 'qwerty@qwerty.com', NULL, 'qwerty', 'qwerty', '$2y$10$t3eUlMMVgfYQ2EJ4.BmkquHqEMf.oYbEuenn/wMK6uJ2D7Kk7u6y.', 'López', 'Paseo', 'Los Álamos', 1001, 'A4, B5', 'Zona Residencial');

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
  MODIFY `idCompra` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `genero`
--
ALTER TABLE `genero`
  MODIFY `idGenero` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `juego`
--
ALTER TABLE `juego`
  MODIFY `idJuego` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

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
  MODIFY `idUsuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

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
