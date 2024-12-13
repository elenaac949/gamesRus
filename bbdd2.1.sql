-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 13-12-2024 a las 18:04:04
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
-- Estructura de tabla para la tabla `juego`
--

CREATE TABLE `juego` (
  `idJuego` int(11) NOT NULL,
  `titulo` varchar(50) NOT NULL,
  `desarrollador` varchar(50) NOT NULL,
  `distribuidor` varchar(50) NOT NULL,
  `anio` year(4) NOT NULL,
  `ruta` varchar(255) NOT NULL,
  `idGenero` int(11) DEFAULT NULL,
  `descripcion` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `juego`
--

INSERT INTO `juego` (`idJuego`, `titulo`, `desarrollador`, `distribuidor`, `anio`, `ruta`, `idGenero`, `descripcion`) VALUES
(1, 'The Legend of Zelda: Breath of the Wild', 'Nintendo', 'Nintendo', '2017', '/imagenes/zelda_botw.jpg', 1, 'Una aventura de mundo abierto donde Link debe derrotar a la Calamidad Ganon para salvar Hyrule.'),
(2, 'God of War', 'Santa Monica Studio', 'Sony Interactive Entertainment', '2018', '/imagenes/god_of_war.jpg', 2, 'Un reinicio de la franquicia que sigue a Kratos y su hijo Atreus en un viaje a través de la mitología nórdica.'),
(3, 'The Witcher 3: Wild Hunt', 'CD Projekt Red', 'CD Projekt', '2015', '/imagenes/witcher3.jpg', 3, 'Un RPG de mundo abierto donde Geralt de Rivia caza monstruos y desentraña una historia profunda en un mundo medieval y oscuro.'),
(4, 'Cyberpunk 2077', 'CD Projekt Red', 'CD Projekt', '2020', '/imagenes/cyberpunk2077.jpg', 3, 'Un RPG distópico ambientado en una ciudad futurista donde los jugadores crean su propio personaje y exploran vastos entornos tecnológicos.'),
(5, 'Elden Ring', 'FromSoftware', 'Bandai Namco Entertainment', '2022', '/imagenes/elden_ring.jpg', 2, 'Un RPG de acción ambientado en un vasto mundo lleno de criaturas mitológicas, profunda narrativa y combate desafiante.'),
(6, 'Red Dead Redemption 2', 'Rockstar Games', 'Rockstar Games', '2018', '/imagenes/rdr2.jpg', 4, 'Un juego de acción y aventura en el oeste donde los jugadores experimentan la vida de Arthur Morgan, un forajido tratando de sobrevivir en un mundo cambiante.'),
(7, 'Minecraft', 'Mojang Studios', 'Microsoft', '2011', '/imagenes/minecraft.jpg', 5, 'Un juego de sandbox donde los jugadores pueden construir, explorar y sobrevivir en un mundo generado proceduralmente.'),
(8, 'Overwatch', 'Blizzard Entertainment', 'Blizzard Entertainment', '2016', '/imagenes/overwatch.jpg', 6, 'Un juego de disparos multijugador en equipo donde los jugadores eligen héroes con habilidades únicas para luchar en batallas por objetivos.'),
(9, 'Fortnite', 'Epic Games', 'Epic Games', '2017', '/imagenes/fortnite.jpg', 6, 'Un juego de batalla real donde 100 jugadores luchan para ser el último en pie, con mecánicas de construcción y actualizaciones de contenido regulares.'),
(10, 'Super Mario Odyssey', 'Nintendo', 'Nintendo', '2017', '/imagenes/super_mario_odyssey.jpg', 1, 'Una aventura de plataformas 3D donde Mario viaja por el mundo para rescatar a la princesa Peach y detener los planes de Bowser.'),
(11, 'Hollow Knight', 'Team Cherry', 'Team Cherry', '2017', '/imagenes/hollow_knight.jpg', 7, 'Un juego de acción y aventuras en 2D ambientado en un mundo subterráneo donde los jugadores controlan a un caballero en busca de respuestas.'),
(12, 'Dark Souls III', 'FromSoftware', 'Bandai Namco Entertainment', '2016', '/imagenes/dark_souls_3.jpg', 2, 'Un desafiante RPG de acción en un mundo oscuro y sombrío, conocido por su alta dificultad y combate meticuloso.'),
(13, 'Call of Duty: Modern Warfare', 'Infinity Ward', 'Activision', '2019', '/imagenes/cod_mw.jpg', 8, 'Un shooter en primera persona con una campaña intensa y multijugador en línea, ambientado en un conflicto moderno.'),
(14, 'Grand Theft Auto V', 'Rockstar Games', 'Rockstar Games', '2013', '/imagenes/gta_v.jpg', 4, 'Un juego de acción y aventura en un mundo abierto donde los jugadores asumen el rol de tres criminales en Los Santos.'),
(15, 'Assassin’s Creed Valhalla', 'Ubisoft Montreal', 'Ubisoft', '2020', '/imagenes/ac_valhalla.jpg', 9, 'Un juego de acción y aventura en el que los jugadores controlan a un vikingo en su lucha por conquistar tierras en Inglaterra.'),
(16, 'Animal Crossing: New Horizons', 'Nintendo', 'Nintendo', '2020', '/imagenes/animal_crossing_nh.jpg', 10, 'Un juego de simulación de vida donde los jugadores crean su propia isla, interactúan con vecinos y realizan diversas actividades cotidianas.'),
(17, 'Stardew Valley', 'ConcernedApe', 'ConcernedApe', '2016', '/imagenes/stardew_valley.jpg', 11, 'Un juego de simulación agrícola donde los jugadores heredan una granja y deben cultivarla mientras interactúan con la comunidad local.'),
(18, 'Celeste', 'Maddy Makes Games', 'Maddy Makes Games', '2018', '/imagenes/celeste.jpg', 7, 'Un juego de plataformas desafiante sobre la vida de una joven llamada Madeline mientras asciende a la montaña Celeste.'),
(19, 'DOOM Eternal', 'id Software', 'Bethesda Softworks', '2020', '/imagenes/doom_eternal.jpg', 12, 'Un juego de disparos en primera persona en el que los jugadores controlan al Doom Slayer, luchando contra demonios en escenarios infernales.'),
(20, 'League of Legends', 'Riot Games', 'Riot Games', '2009', '/imagenes/league_of_legends.jpg', 6, 'Un juego de estrategia en tiempo real multijugador donde dos equipos de campeones luchan por destruir la base del enemigo.');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `juego`
--
ALTER TABLE `juego`
  ADD PRIMARY KEY (`idJuego`),
  ADD KEY `fk_genero` (`idGenero`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `juego`
--
ALTER TABLE `juego`
  MODIFY `idJuego` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `juego`
--
ALTER TABLE `juego`
  ADD CONSTRAINT `fk_genero` FOREIGN KEY (`idGenero`) REFERENCES `genero` (`idGenero`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
