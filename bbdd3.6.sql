-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 14-02-2025 a las 19:19:30
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
-- Estructura de tabla para la tabla `carrito`
--

CREATE TABLE `carrito` (
  `idCarrito` int(11) NOT NULL,
  `idUsuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `carrito`
--

INSERT INTO `carrito` (`idCarrito`, `idUsuario`) VALUES
(3, 4),
(2, 5),
(4, 32);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carritojuego`
--

CREATE TABLE `carritojuego` (
  `idCarrito` int(11) NOT NULL,
  `idJuego` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `carritojuego`
--

INSERT INTO `carritojuego` (`idCarrito`, `idJuego`) VALUES
(2, 37),
(2, 38),
(3, 34),
(3, 35),
(3, 37),
(3, 47);

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
(33, 4, 47, '2025-02-11 18:04:23'),
(34, 5, 37, '2025-02-12 18:59:42');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `genero`
--

CREATE TABLE `genero` (
  `idGenero` int(11) NOT NULL,
  `genero` varchar(50) NOT NULL,
  `idGeneroApi` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `genero`
--

INSERT INTO `genero` (`idGenero`, `genero`, `idGeneroApi`) VALUES
(17, 'Action', 1),
(18, 'Add-on', 62),
(19, 'Adventure', 2),
(20, 'Compilation', 76),
(21, 'Educational', 12),
(22, 'Gambling', 28),
(23, 'Idle', 235),
(24, 'Puzzle', 118),
(25, 'Racing / Driving', 6),
(26, 'Role-playing (RPG)', 50),
(27, 'Simulation', 3),
(28, 'Special edition', 187),
(29, 'Sports', 5),
(30, 'Strategy / tactics', 4),
(31, 'racing/driving', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `generojuego`
--

CREATE TABLE `generojuego` (
  `idGeneroJuego` int(11) NOT NULL,
  `idJuego` int(11) NOT NULL,
  `idGenero` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `generojuego`
--

INSERT INTO `generojuego` (`idGeneroJuego`, `idJuego`, `idGenero`) VALUES
(20, 34, 17),
(21, 35, 24),
(22, 36, 18),
(23, 37, 27),
(24, 38, 18),
(35, 45, 17),
(36, 45, 24),
(37, 46, 18),
(38, 46, 24),
(39, 47, 24),
(40, 48, 31),
(41, 48, 27),
(42, 49, 31),
(43, 49, 27),
(44, 50, 18),
(45, 50, 19);

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
  `descripcion` text DEFAULT NULL,
  `portada` varchar(255) DEFAULT NULL,
  `precio` decimal(10,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `juego`
--

INSERT INTO `juego` (`idJuego`, `titulo`, `desarrollador`, `distribuidor`, `anio`, `ruta`, `descripcion`, `portada`, `precio`) VALUES
(34, 'Pokemon Bike Adventure', 'Yo', '', '2011', 'www.hola.com', 'The game stars Raichu riding on a motorbike to perform stunts around a course. The player uses the directional buttons to accelerate, brake or shift the motorbike down or up. Jumps must performed carefully so the motorbike doesn\'t overturn and Raichu doesn\'t fall off.', 'https://cdn.mobygames.com/covers/9729434-pokemon-bike-adventure-browser-front-cover.jpg', 0.00),
(35, 'Xmas Lemmings', '', '', '2025', 'www.hola.com', 'Xmas Lemmings is a demo released to promote Oh No! More Lemmings. It includes two levels from Oh No! (different ones depending on version and platform) and two new exclusive Christmas-themed levels. The levels feature snowy landscapes, snowmen, festive lights, Christmas songs as background music and the Lemmings dressed in Santa hats and coats.', 'https://cdn.mobygames.com/screenshots/15921549-xmas-lemmings-amiga-menu-how-festive.png', 0.00),
(36, 'The Elder Scrolls V: Skyrim - Hearthfire', '', '', '2012', '', 'Hearthfire is the second official DLC pack for The Elder Scrolls V: Skyrim. As well as adding several minor quests, Hearthfire primarily allows the player to purchase land in three of the holds in Skyrim (Falkreath, Dawnstar and Morthal). Players can also design houses for their land, from a small cottage to a three wing mansion. Players can mine new materials and fashion new items for use in constructing their homes. Another new feature gives the opportunity to adopt a child to live with them.', 'https://cdn.mobygames.com/covers/3226117-the-elder-scrolls-v-skyrim-hearthfire-xbox-360-front-cover.jpg', 0.00),
(37, 'Animal Crossing: New Horizons', '', '', '2020', '', 'weee', 'https://cdn.mobygames.com/covers/3083380-animal-crossing-new-horizons-nintendo-switch-front-cover.jpg', 0.00),
(38, 'Halo 5: Guardians - Classic Helmet REQ Pack', '', '', '0000', '', 'The Classic Helmet REQ Pack is a downloadable content pack (DLC) for the 2015 game Halo 5: Guardians. It contains a REQ pack with nine legendary helmet designs from Halo 3 and Halo: Reach.', 'https://cdn.mobygames.com/covers/1886683-halo-5-guardians-classic-helmet-req-pack-xbox-one-front-cover.png', 0.00),
(45, 'Lemmings', 'DMA Design Limited', 'Psygnosis Limited', '1991', '.\\archivos\\XML\\lemmings.zip', ' ', '.\\archivos\\XML\\lemmings.jpg', 0.00),
(46, 'Oh No! More Lemmings', 'DMA Design Limited', 'Psygnosis Limited', '1991', '.\\archivos\\XML\\oh_no_more_lemmings.jpg', ' ', '.\\archivos\\XML\\oh_no_more_lemmings.jpg', 0.00),
(47, 'Lemmings 2: The Tribes', 'DMA Design Limited', 'Psygnosis Limited', '1993', '.\\archivos\\XML\\lemmings_2_the_tribes.zip', ' ', '.\\archivos\\XML\\lemmings_2_the_tribes.jpg', 0.00),
(48, 'Test Drive', 'Distinctive Software, Inc.', 'Accolade, Inc.', '1987', '.\\archivos\\JSON\\test_drive.zip', ' ', '.\\archivos\\JSON\\test_drive.jpg', 0.00),
(49, 'The Duel: Test Drive II', 'Distinctive Software, Inc.', 'Accolade, Inc.', '1989', '.\\archivos\\JSON\\the_duel_test_drive_2.zip', ' ', '.\\archivos\\JSON\\the_duel_test_drive_2.jpg', 0.00),
(50, 'Amnesia: The Dark Descent', '', '', '2010', '', 'In Amnesia: The Dark Descent, the player takes on the role of Daniel, an amnesiac man trapped in the mansion of a Prussian Baron named Alexander. The only clues to Daniel\'s true identity are mementos and notes left behind by Daniel himself, who reminds himself to find and kill Alexander. Gameplay has the player searching for Daniel\'s diaries and other notes and journals of the poor souls who have crossed Baron Alexander. The player must solve the mystery of the mansion while running from a Shadow that is constantly chasing the player throughout the game.\r\nThe game takes place from a first person perspective, however there are no weapons. Daniel cannot fight monsters and the only choice is to run or hide. Along with self-preservation, the players must keep the hero sane. In order to stay sane, he must keep moving and pushing the plot forward, as well as making sure there is always light. It is often necessary to scour every corner for oil and tinderboxes. Oil will allow Daniel to use a lamp to provide him with light and tinderboxes can be used to light candles and torches strewn throughout the mansion. If Daniel remains in the dark for too long, he will gradually lose his sanity. As Daniel loses sanity, the world will distort and become hard to navigate and the monsters will be able to sense the player. The player must evade the monsters entirely, but this will affect Daniel\'s sanity as to hide from the monsters, the player must also hide in the dark. The player must also never look at the monsters because if Daniel stares at them too long, his sanity will be fully compromised. \r\nThe player must solve various puzzles and the game is very much a fully interactive adventure game. Interaction with the environment is performed by using a physics based method where the mouse is emulated as a hand, meaning the player will need to rotate it to turn wheels or use it to grab drawers and pull them open by moving the mouse. It is also possible to pick up objects and throw them to distract the shadow or solve certain physical puzzles.', 'https://cdn.mobygames.com/covers/209571-amnesia-the-dark-descent-windows-front-cover.jpg', 6.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `juegosistema`
--

CREATE TABLE `juegosistema` (
  `idJuegoSistema` int(11) NOT NULL,
  `idSistema` int(11) NOT NULL,
  `idJuego` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `juegosistema`
--

INSERT INTO `juegosistema` (`idJuegoSistema`, `idSistema`, `idJuego`) VALUES
(20, 4, 34),
(21, 4, 35),
(22, 7, 36),
(23, 11, 36),
(24, 17, 36),
(25, 16, 37),
(26, 18, 38),
(33, 4, 45),
(34, 4, 46),
(35, 4, 47),
(36, 4, 48),
(37, 4, 49),
(38, 17, 50);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `poseejuego`
--

CREATE TABLE `poseejuego` (
  `idUsuario` int(11) NOT NULL,
  `idJuego` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `poseejuego`
--

INSERT INTO `poseejuego` (`idUsuario`, `idJuego`) VALUES
(4, 35),
(4, 47),
(5, 35),
(5, 36),
(5, 37),
(5, 38),
(32, 35),
(32, 37);

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
-- Estructura de tabla para la tabla `relaciona`
--

CREATE TABLE `relaciona` (
  `idJuego1` int(11) NOT NULL,
  `idJuego2` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

CREATE TABLE `rol` (
  `idRol` int(11) NOT NULL,
  `rol` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`idRol`, `rol`) VALUES
(1, 'usuario'),
(2, 'admin');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sistema`
--

CREATE TABLE `sistema` (
  `idSistema` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `idSistemaApi` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `sistema`
--

INSERT INTO `sistema` (`idSistema`, `nombre`, `idSistemaApi`) VALUES
(4, 'DOS', 2),
(5, 'PlayStation', 6),
(6, 'PlayStation 2', 7),
(7, 'PlayStation 3', 81),
(8, 'PlayStation 4', 141),
(9, 'PlayStation 5', 255),
(10, 'Xbox', 13),
(11, 'Xbox 360', 69),
(12, 'Xbox Series', 289),
(13, 'Nintendo 3DS', 101),
(14, 'Nintendo 64', 9),
(15, 'Nintendo DS', 44),
(16, 'Nintendo Switch', 203),
(17, 'Windows', 3),
(18, 'Otros', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tarjeta`
--

CREATE TABLE `tarjeta` (
  `idTarjeta` int(11) NOT NULL,
  `numeroTarjeta` varchar(19) NOT NULL,
  `fechaCaducidad` date NOT NULL,
  `idUsuario` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tarjeta`
--

INSERT INTO `tarjeta` (`idTarjeta`, `numeroTarjeta`, `fechaCaducidad`, `idUsuario`) VALUES
(1, '5540500001000004', '2025-12-01', 4),
(2, '5020080001000006', '2025-07-01', 4),
(3, '5540500001000004', '2025-10-01', 5),
(9, '4507670001000009', '2025-12-01', 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `idUsuario` int(11) NOT NULL,
  `nick` varchar(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellidos` varchar(50) NOT NULL,
  `contrasenia` varchar(255) NOT NULL,
  `tipoDeVia` varchar(50) DEFAULT NULL,
  `nombreDeVia` varchar(100) DEFAULT NULL,
  `numeroDeVia` int(11) DEFAULT NULL,
  `numeros` varchar(50) DEFAULT NULL,
  `otros` varchar(255) DEFAULT NULL,
  `numeroTelefono` varchar(15) DEFAULT NULL,
  `idRol` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`idUsuario`, `nick`, `email`, `nombre`, `apellidos`, `contrasenia`, `tipoDeVia`, `nombreDeVia`, `numeroDeVia`, `numeros`, `otros`, `numeroTelefono`, `idRol`) VALUES
(1, 'dickDestroy', 'disckDestroyer69@gmail.com', 'Escro', 'Tolamo', '$2y$10$lkwk.6NdxTvG7WHBJGl/7O8iurq2RdxW3DiFEnJsnJ1UBDbEREmNC', 'Calle', 'Gran Vía', 123, '12B, 14C', 'Departamento 5B', '+34612345678', 1),
(3, 'PirateKing', 'mugiwara@gmail.com', 'Monkey D.', 'Luffy', '$2y$10$JpJFZgRXO2KUMnvKhE.TW.hmfILFTQIsydW5m1QxGvE5KO617w3A6', 'Avenida', 'Sunny Road', 456, '4A, 4B', 'Barco Pirata', '+34623456789', 1),
(4, 'admin', 'admin@admin.es', 'admin', '', '$2y$10$PnVKzoYkiWcoLm/5H.0M0O8HHvbeCdQnHQa6xdbPMY90fynijS8nK', 'Plaza', 'Central', 1, NULL, 'Oficina Principal', '+34634567890', 1),
(5, 'usuario', 'usuario@gmail.es', 'usuario', 'usuario', '$2y$10$gbKusejZEquUL9RoHKM62OUIQWGRfaZBn.QqECu1VPxUeZesy.hT2', 'Calle', 'Paseo del Río', 789, 'A1, A2', 'Apartamento 8', '+34645678901', 1),
(9, 'melocoton', 'eva@gmail.com', 'Eva', 'Alonso', '$2y$10$h5LJkF9qAa.kWaFnxzIAN.5rdzOWuaBRlAZsiS26NbOei3RpeToyW', 'Avenida', 'Los Pinos', 101, '3A, 3B', 'Condominio Cerrado', '+34656789012', 1),
(10, 'iceWolf', 'axel@gmail.com', 'Axel', 'José', '$2y$10$RwBDep4hmQSjRGxVRvnbQO.LJL4ha2w6CqPx.jL3F4evSYnG5UzMS', 'Callejón', 'Roca Seca', 205, 'D1, D2', 'Casa de Campo', '+34667890123', 1),
(11, 'prueba', 'prueba@es.es', 'prueba', 'prueba', '$2y$10$lD.qv2kmU5XgoABo1ruOveqAH2QlIDekmbbN8l7o9Cgqn2J/pK6j.', 'Boulevard', 'Estrella', 306, NULL, 'Edificio Principal', '+34678901234', 1),
(12, 'pepito', 'pepe@pepe.es', 'pepe', 'pepe', '$2y$10$nsQjIVPn/3ptBqTGgegUIOhIRGXJ8/5Wqpjt2L6AcSje9r9ttWUPq', 'Pasaje', 'Primavera', 405, '5B, 5C', 'Villa Residencial', '+34689012345', 1),
(14, '', '', '', '', '$2y$10$rEw4W6qRC09wvjcGdqXDdOmHc0fLtacC/xrd0wmSjw9iJvtWTGiXG', NULL, NULL, NULL, NULL, NULL, NULL, 1),
(16, 'luisito', 'luis@gmail.com', 'luis', 'luis', '$2y$10$PzIZ0Uzgnpc/ATZq.FzOle8JPSvd71RPKNiQkS8Gpn9oOyE9MO5Gy', 'Camino', 'El Prado', 501, '1A, 2B', 'Finca Los Rosales', '+34690123456', 1),
(17, 'alumnito', 'alumno@gmail.com', 'alumno', 'alumno', '$2y$10$fS3DkDKR9R51ks9ChizMEuP8eLnrMV2xmgWEryTdFDHZ8z1mcG4DW', 'Autopista', 'Del Sol', 600, NULL, 'Local Comercial', '+34601234567', 1),
(20, 'profe', 'profe@es.es', 'profe', 'profe', '$2y$10$uYLAafcWG.g20IOzC4q8luR3ZOIMWFvbm7r31qtnU9oRT9WvNt4M.', 'Travesía', 'La Fuente', 705, '1C, 2D', 'Complejo Industrial', '+34612345678', 1),
(21, 'pruebita1', 'prueba1@es.es', 'prueba1', 'preuba', '$2y$10$f/6waIpKwh3Ri3jbxr0SLODjSkZoBzSTjRIm0Q.SlPIWPKLLMT0h2', 'Calle', 'Jardines', 802, 'A2, B3', 'Casa de Playa', '+34623456789', 1),
(30, 'anita90', 'ana@gmail.com', 'Ana', 'Alvarez', '$2y$10$HOGE/jkQZxWCrpx/YPu6XebUZ1ZufqXqtJelXPZeQiAmOONXfH3Q6', 'Camino', 'Las Lomas', 905, '1F, 2G', 'Zona Rural', '+34634567890', 1),
(31, 'qwerty', 'qwerty@qwerty.com', 'qwerty', 'qwerty', '$2y$10$t3eUlMMVgfYQ2EJ4.BmkquHqEMf.oYbEuenn/wMK6uJ2D7Kk7u6y.', 'Paseo', 'Los Álamos', 1001, 'A4, B5', 'Zona Residencial', '+34645678901', 1),
(32, 'usuario2', 'user@gmail.com', 'user2', 'users', '$2y$10$FL/ox5KQKpR7UijKUP/k1OPSs7eSM9sTNv6DGwHRrpZVvIPrZ5uNy', 'calle', 'del cura', 12, NULL, NULL, '672828282', 1),
(33, 'elena', 'elenaalexandra949@gmail.com', 'Elena Alexandra', 'Ciobanu', '$2y$10$inJfZ0uvF0mTBImcj7Q4m.51tLcJRKZBFDuqqmoAwBuaCJN/hqvFS', '', '', 0, '', '', '642829002', 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `carrito`
--
ALTER TABLE `carrito`
  ADD PRIMARY KEY (`idCarrito`),
  ADD KEY `fk_car_idu_usu_idu` (`idUsuario`);

--
-- Indices de la tabla `carritojuego`
--
ALTER TABLE `carritojuego`
  ADD PRIMARY KEY (`idCarrito`,`idJuego`),
  ADD KEY `fk_caj_idj_jue_idj` (`idJuego`);

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
-- Indices de la tabla `generojuego`
--
ALTER TABLE `generojuego`
  ADD PRIMARY KEY (`idGeneroJuego`),
  ADD KEY `fk_generojuego_idgenero_generoJuego_idGenero` (`idGenero`),
  ADD KEY `fk_generojuego_idjuego_juego_idJuego` (`idJuego`);

--
-- Indices de la tabla `juego`
--
ALTER TABLE `juego`
  ADD PRIMARY KEY (`idJuego`);

--
-- Indices de la tabla `juegosistema`
--
ALTER TABLE `juegosistema`
  ADD PRIMARY KEY (`idJuegoSistema`),
  ADD KEY `fk_juego_sistema_sistema` (`idSistema`),
  ADD KEY `fk_juego_sistema_juego` (`idJuego`);

--
-- Indices de la tabla `poseejuego`
--
ALTER TABLE `poseejuego`
  ADD PRIMARY KEY (`idUsuario`,`idJuego`),
  ADD KEY `fk_poj_idj_jue_idj` (`idJuego`);

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
-- Indices de la tabla `relaciona`
--
ALTER TABLE `relaciona`
  ADD PRIMARY KEY (`idJuego1`,`idJuego2`),
  ADD KEY `fk_rel_id2_jue_idj` (`idJuego2`);

--
-- Indices de la tabla `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`idRol`);

--
-- Indices de la tabla `sistema`
--
ALTER TABLE `sistema`
  ADD PRIMARY KEY (`idSistema`);

--
-- Indices de la tabla `tarjeta`
--
ALTER TABLE `tarjeta`
  ADD PRIMARY KEY (`idTarjeta`),
  ADD KEY `fk_tar_idu_usu_idu` (`idUsuario`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`idUsuario`),
  ADD UNIQUE KEY `nick` (`nick`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `fk_usuario_rol` (`idRol`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `carrito`
--
ALTER TABLE `carrito`
  MODIFY `idCarrito` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `comprado`
--
ALTER TABLE `comprado`
  MODIFY `idCompra` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT de la tabla `genero`
--
ALTER TABLE `genero`
  MODIFY `idGenero` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT de la tabla `generojuego`
--
ALTER TABLE `generojuego`
  MODIFY `idGeneroJuego` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT de la tabla `juego`
--
ALTER TABLE `juego`
  MODIFY `idJuego` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT de la tabla `juegosistema`
--
ALTER TABLE `juegosistema`
  MODIFY `idJuegoSistema` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT de la tabla `prestado`
--
ALTER TABLE `prestado`
  MODIFY `idPrestamo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `regalado`
--
ALTER TABLE `regalado`
  MODIFY `idRegalo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `rol`
--
ALTER TABLE `rol`
  MODIFY `idRol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `sistema`
--
ALTER TABLE `sistema`
  MODIFY `idSistema` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `tarjeta`
--
ALTER TABLE `tarjeta`
  MODIFY `idTarjeta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `idUsuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `carrito`
--
ALTER TABLE `carrito`
  ADD CONSTRAINT `fk_car_idu_usu_idu` FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`idUsuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `carritojuego`
--
ALTER TABLE `carritojuego`
  ADD CONSTRAINT `fk_caj_idc_car_idc` FOREIGN KEY (`idCarrito`) REFERENCES `carrito` (`idCarrito`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_caj_idj_jue_idj` FOREIGN KEY (`idJuego`) REFERENCES `juego` (`idJuego`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `comprado`
--
ALTER TABLE `comprado`
  ADD CONSTRAINT `fk_juego_compra` FOREIGN KEY (`idJuego`) REFERENCES `juego` (`idJuego`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_usuario_compra` FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`idUsuario`) ON DELETE CASCADE;

--
-- Filtros para la tabla `generojuego`
--
ALTER TABLE `generojuego`
  ADD CONSTRAINT `fk_generojuego_idgenero_generoJuego_idGenero` FOREIGN KEY (`idGenero`) REFERENCES `genero` (`idGenero`),
  ADD CONSTRAINT `fk_generojuego_idjuego_juego_idJuego` FOREIGN KEY (`idJuego`) REFERENCES `juego` (`idJuego`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `juegosistema`
--
ALTER TABLE `juegosistema`
  ADD CONSTRAINT `fk_juego_sistema_juego` FOREIGN KEY (`idJuego`) REFERENCES `juego` (`idJuego`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_juego_sistema_sistema` FOREIGN KEY (`idSistema`) REFERENCES `sistema` (`idSistema`) ON DELETE CASCADE;

--
-- Filtros para la tabla `poseejuego`
--
ALTER TABLE `poseejuego`
  ADD CONSTRAINT `fk_poj_idj_jue_idj` FOREIGN KEY (`idJuego`) REFERENCES `juego` (`idJuego`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_poj_idu_usu_idu` FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`idUsuario`) ON DELETE CASCADE ON UPDATE CASCADE;

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
-- Filtros para la tabla `relaciona`
--
ALTER TABLE `relaciona`
  ADD CONSTRAINT `fk_rel_id1_jue_idj` FOREIGN KEY (`idJuego1`) REFERENCES `juego` (`idJuego`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_rel_id2_jue_idj` FOREIGN KEY (`idJuego2`) REFERENCES `juego` (`idJuego`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `tarjeta`
--
ALTER TABLE `tarjeta`
  ADD CONSTRAINT `fk_tar_idu_usu_idu` FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`idUsuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `fk_usuario_rol` FOREIGN KEY (`idRol`) REFERENCES `rol` (`idRol`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
