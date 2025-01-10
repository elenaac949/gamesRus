-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 31-12-2024 a las 13:18:36
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
(1, 4);

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
(1, 23);

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
(2, 4, 12, '2024-12-07 12:55:06'),
(3, 5, 4, '2024-12-13 18:24:49'),
(4, 5, 7, '2024-12-13 18:24:50');

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
(30, 'Strategy / tactics', 4);

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
(3, 25, 20),
(4, 25, 25),
(5, 25, 26);

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
  `portada` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `juego`
--

INSERT INTO `juego` (`idJuego`, `titulo`, `desarrollador`, `distribuidor`, `anio`, `ruta`, `descripcion`, `portada`) VALUES
(1, 'The Legend of Zelda: Breath of the Wild', 'Nintendo', 'Nintendo', '2017', '/imagenes/zelda_botw.jpg', 'Una aventura de mundo abierto donde Link debe derrotar a la Calamidad Ganon para salvar Hyrule.', NULL),
(2, 'God of War', 'Santa Monica Studio', 'Sony Interactive Entertainment', '2018', '/imagenes/god_of_war.jpg', 'Un reinicio de la franquicia que sigue a Kratos y su hijo Atreus en un viaje a través de la mitología nórdica.', NULL),
(3, 'The Witcher 3: Wild Hunt', 'CD Projekt Red', 'CD Projekt', '2015', '/imagenes/witcher3.jpg', 'Un RPG de mundo abierto donde Geralt de Rivia caza monstruos y desentraña una historia profunda en un mundo medieval y oscuro.', NULL),
(4, 'Cyberpunk 2077', 'CD Projekt Red', 'CD Projekt', '2020', '/imagenes/cyberpunk2077.jpg', 'Un RPG distópico ambientado en una ciudad futurista donde los jugadores crean su propio personaje y exploran vastos entornos tecnológicos.', NULL),
(5, 'Elden Ring', 'FromSoftware', 'Bandai Namco Entertainment', '2022', '/imagenes/elden_ring.jpg', 'Un RPG de acción ambientado en un vasto mundo lleno de criaturas mitológicas, profunda narrativa y combate desafiante.', NULL),
(6, 'Red Dead Redemption 2', 'Rockstar Games', 'Rockstar Games', '2018', '/imagenes/rdr2.jpg', 'Un juego de acción y aventura en el oeste donde los jugadores experimentan la vida de Arthur Morgan, un forajido tratando de sobrevivir en un mundo cambiante.', NULL),
(7, 'Minecraft', 'Mojang Studios', 'Microsoft', '2011', '/imagenes/minecraft.jpg', 'Un juego de sandbox donde los jugadores pueden construir, explorar y sobrevivir en un mundo generado proceduralmente.', NULL),
(8, 'Overwatch', 'Blizzard Entertainment', 'Blizzard Entertainment', '2016', '/imagenes/overwatch.jpg', 'Un juego de disparos multijugador en equipo donde los jugadores eligen héroes con habilidades únicas para luchar en batallas por objetivos.', NULL),
(9, 'Fortnite', 'Epic Games', 'Epic Games', '2017', '/imagenes/fortnite.jpg', 'Un juego de batalla real donde 100 jugadores luchan para ser el último en pie, con mecánicas de construcción y actualizaciones de contenido regulares.', NULL),
(10, 'Super Mario Odyssey', 'Nintendo', 'Nintendo', '2017', '/imagenes/super_mario_odyssey.jpg', 'Una aventura de plataformas 3D donde Mario viaja por el mundo para rescatar a la princesa Peach y detener los planes de Bowser.', NULL),
(11, 'Hollow Knight', 'Team Cherry', 'Team Cherry', '2017', '/imagenes/hollow_knight.jpg', 'Un juego de acción y aventuras en 2D ambientado en un mundo subterráneo donde los jugadores controlan a un caballero en busca de respuestas.', NULL),
(12, 'Dark Souls III', 'FromSoftware', 'Bandai Namco Entertainment', '2016', '/imagenes/dark_souls_3.jpg', 'Un desafiante RPG de acción en un mundo oscuro y sombrío, conocido por su alta dificultad y combate meticuloso.', NULL),
(13, 'Call of Duty: Modern Warfare', 'Infinity Ward', 'Activision', '2019', '/imagenes/cod_mw.jpg', 'Un shooter en primera persona con una campaña intensa y multijugador en línea, ambientado en un conflicto moderno.', NULL),
(14, 'Grand Theft Auto V', 'Rockstar Games', 'Rockstar Games', '2013', '/imagenes/gta_v.jpg', 'Un juego de acción y aventura en un mundo abierto donde los jugadores asumen el rol de tres criminales en Los Santos.', NULL),
(15, 'Assassin’s Creed Valhalla', 'Ubisoft Montreal', 'Ubisoft', '2020', '/imagenes/ac_valhalla.jpg', 'Un juego de acción y aventura en el que los jugadores controlan a un vikingo en su lucha por conquistar tierras en Inglaterra.', NULL),
(16, 'Animal Crossing: New Horizons', 'Nintendo', 'Nintendo', '2020', '/imagenes/animal_crossing_nh.jpg', 'Un juego de simulación de vida donde los jugadores crean su propia isla, interactúan con vecinos y realizan diversas actividades cotidianas.', NULL),
(17, 'Stardew Valley', 'ConcernedApe', 'ConcernedApe', '2016', '/imagenes/stardew_valley.jpg', 'Un juego de simulación agrícola donde los jugadores heredan una granja y deben cultivarla mientras interactúan con la comunidad local.', NULL),
(18, 'Celeste', 'Maddy Makes Games', 'Maddy Makes Games', '2018', '/imagenes/celeste.jpg', 'Un juego de plataformas desafiante sobre la vida de una joven llamada Madeline mientras asciende a la montaña Celeste.', NULL),
(19, 'DOOM Eternal', 'id Software', 'Bethesda Softworks', '2020', '/imagenes/doom_eternal.jpg', 'Un juego de disparos en primera persona en el que los jugadores controlan al Doom Slayer, luchando contra demonios en escenarios infernales.', NULL),
(20, 'League of Legends', 'Riot Games', 'Riot Games', '2009', '/imagenes/league_of_legends.jpg', 'Un juego de estrategia en tiempo real multijugador donde dos equipos de campeones luchan por destruir la base del enemigo.', NULL),
(23, 'The Elder Scrolls V: Skyrim - Hearthfire', 'Square Enix', 'Yo', '2024', '', 'Hearthfire is the second official DLC pack for The Elder Scrolls V: Skyrim. As well as adding several minor quests, Hearthfire primarily allows the player to purchase land in three of the holds in Skyrim (Falkreath, Dawnstar and Morthal). Players can also design houses for their land, from a small cottage to a three wing mansion. Players can mine new materials and fashion new items for use in constructing their homes. Another new feature gives the opportunity to adopt a child to live with them.', 'https://cdn.mobygames.com/covers/3226117-the-elder-scrolls-v-skyrim-hearthfire-xbox-360-front-cover.jpg'),
(24, 'The Elder Scrolls V: Skyrim', 'Sega', 'PEPA', '2024', '', 'Two hundred years after the events described in Oblivion, the continent of Tamriel is in turmoil. The Emperors throne remained without heir; the Blades, Empires elite guards, have been disassembled; elven nations began capturing territory from the Empire. The assassination of the King of Skyrim, Tamriels Northern-most province and home of the Nord race, led to a civil war between those who wish independence for Skyrim and those who wanted it to remain under the Empires control. \r\nA prisoner is brought to a small town, awaiting execution for alleged involvement with the Stormcloaks, a group that was founded by the kings assassin Ulfric Stormcloak. Just before the executioners axe lands on the prisoners neck, a dragon attacks the city, forcing most people to flee. The unexpected freedom leads the ex-prisoner into the snowy Skyrim, where the rumors of the dragon begin to circulate.\r\nLike its predecessors in the Elder Scrolls series, Skyrim is an open-ended role-playing game with action-based combat. The player may explore the vast environments of Skyrim from either first- (default) or third-person perspective, being unrestricted in his or her travels and free to undertake any side quests in any order, or follow the main quest. It is possible to fast-travel to previously visited locations directly from the world map. The player can also opt to buy (or steal) and ride a horse.\r\nThere are ten races to choose from: Altmer (High Elves), Argonian (reptile people), Bosmer (Wood Elves), Breton, Dunmer (Dark Elves), Imperial, Khajiit (cat people), Nord, Orc, and Redguard. Each race has their own perks and limitations, such as Nord being resistant to cold, Khajiit being weak with magic, etc. Unlike the previous games in the series, the player cannot choose a class for the main character; rather, the latter evolves into any class-like combination gradually, according to the play style. When the protagonist reaches a new level, the player may increase his or her Health, Magicka, or Stamina and a new perk may be added to one of the skills. There are eighteen skills altogether, and each skill has several levels and perks which may be obtained. Most perks are only accessible after a certain level has been reached in said perk. For instance, in order to reach higher perks with Destruction, destructive spells must be leveled up. Skill levels can increase either through extensive use, skill books, or even paying for training from certain non-playable characters. \r\nThe game contains some features that were introduced in Fallout 3. Enemy level-scaling is done in a similar way, as opposed to the more intrusive system of Oblivion. The player may hire other fighters to follow the hero around and lend a helping hand in combat. Also, the lockpicking system of the previous installment has been replaced by the lockpicking methods of the recent Fallout games. Conversations with NPCs now occur in real time rather than \"freezing\" time as in Oblivion. \r\nPlayers can craft, cook, or build any number of items depending on ingredients and skill levels. Alchemy allows players to make potions, Enchanting allows players to imbue armor and items with magical abilities (such as increasing the effectiveness of magic resistance), and Smithing allows players to either craft or improve weapons and armor. Smelting, tanning and cooking are also a part of this mix as well: Smelting is the skill of turning raw mined mineral ores into usable ingots for smithing; Tanning is the process of drying animal hides to make leather strips, useful in creating or improving armor and weapons; Cooking allows players to turn otherwise minimally useful food ingredients into much more beneficial meals. \r\nMelee attacks can be performed using either two or one-handed weapons. Blocking reduces damage and allows for the opportunity to bash an opponent with a shield. Archery is also available for some ranged attacks, as is quite a bit of magicka. Each race also has a distinct magic-like power ability; only one power may be equipped at a time. For instance, a Nord power is to frighten enemies away for a while. New to the series is the Shout ability, which is a special power based on Dragon language. These require a special set of circumstances to unlock: first, the ancient words must be learned from Word Walls hidden all over Skyrim; secondly, they can only be activated by acquiring a dragon soul (from slaying a dragon). \r\nCrimes may be committed by stealing, pickpocketing, murder or attacking innocent people, or even by trespassing. Generally this puts a bounty on the head of the player character, unless said character is quick enough to eliminate all witnesses. Fines and jail time, or a beat-down from authorities, are likely to ensue if the hero commits too many crimes or merely ends up getting caught. The protagonist can serve out his or her sentence on the jail bed, or pick the lock and escape; however, going to jail is likely to cause current skill progress to be lost. \r\nAs before, there are several groups, guilds, and the like that the player may encounter and join, each with their own advantages or disadvantages, each with their own views on the current events of the world, and each with their own quests. The abilities to become a werewolf or vampire are also present and have been somewhat streamlined: for instance, sunlight is not instantly deadly to vampires, and lycanthropy can be spread around.', 'https://cdn.mobygames.com/covers/5477662-the-elder-scrolls-v-skyrim-windows-front-cover.jpg'),
(25, 'The Elder Scrolls V: Skyrim - Legendary Edition', 'sEGA', 'PEPA', '2024', '', 'The Elder Scrolls V: Skyrim - Legendary Edition includes:\r\n\r\nThe Elder Scrolls V: Skyrim (updated to the latest version, including mounted combat and the Legendary difficulty level)\r\nThe Elder Scrolls V: Skyrim - Dawnguard (DLC)\r\nThe Elder Scrolls V: Skyrim - Hearthfire (DLC)\r\nThe Elder Scrolls V: Skyrim - Dragonborn (DLC)\r\n\r\nThe retail version includes a fold-out paper map.', 'https://cdn.mobygames.com/covers/9262176-the-elder-scrolls-v-skyrim-legendary-edition-windows-front-cover.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `poseejuego`
--

CREATE TABLE `poseejuego` (
  `idUsuario` int(11) NOT NULL,
  `idJuego` int(11) NOT NULL
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
-- Estructura de tabla para la tabla `tarjeta`
--

CREATE TABLE `tarjeta` (
  `idTarjeta` int(11) NOT NULL,
  `numeroTarjeta` varchar(19) NOT NULL,
  `ccv` char(3) NOT NULL,
  `fechaCaducidad` date NOT NULL,
  `idUsuario` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(31, 'qwerty', 'qwerty@qwerty.com', 'qwerty', 'qwerty', '$2y$10$t3eUlMMVgfYQ2EJ4.BmkquHqEMf.oYbEuenn/wMK6uJ2D7Kk7u6y.', 'Paseo', 'Los Álamos', 1001, 'A4, B5', 'Zona Residencial', '+34645678901', 1);

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
-- Indices de la tabla `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`idRol`);

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
  MODIFY `idCarrito` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `comprado`
--
ALTER TABLE `comprado`
  MODIFY `idCompra` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `genero`
--
ALTER TABLE `genero`
  MODIFY `idGenero` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT de la tabla `generojuego`
--
ALTER TABLE `generojuego`
  MODIFY `idGeneroJuego` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `juego`
--
ALTER TABLE `juego`
  MODIFY `idJuego` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

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
-- AUTO_INCREMENT de la tabla `rol`
--
ALTER TABLE `rol`
  MODIFY `idRol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

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
