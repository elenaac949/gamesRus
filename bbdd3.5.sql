-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 01-02-2025 a las 20:30:36
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

/* INSERT INTO `carrito` (`idCarrito`, `idUsuario`) VALUES
(1, 4); */

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

/* INSERT INTO `carritojuego` (`idCarrito`, `idJuego`) VALUES
(1, 16),
(1, 17),
(1, 18); */

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

/* INSERT INTO `comprado` (`idCompra`, `idUsuario`, `idJuego`, `fechaCompra`) VALUES
(1, 4, 16, '2024-12-06 15:52:52'),
(2, 4, 12, '2024-12-07 12:55:06'),
(3, 5, 4, '2024-12-13 18:24:49'),
(4, 5, 7, '2024-12-13 18:24:50'); */

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

/* INSERT INTO `generojuego` (`idGeneroJuego`, `idJuego`, `idGenero`) VALUES
(3, 25, 20),
(4, 25, 25),
(5, 25, 26),
(6, 16, 27),
(7, 18, 19),
(8, 19, 17),
(9, 19, 21),
(10, 17, 27),
(11, 20, 17),
(12, 26, 26),
(13, 27, 26),
(14, 28, 26),
(15, 29, 26),
(16, 30, 26),
(17, 31, 17),
(18, 32, 17),
(19, 33, 17); */

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
/* 
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
(16, 'Animal Crossing: New Horizons', 'Nintendo', 'Nintendo', '2020', '/imagenes/animal_crossing_nh.jpg', 'Un juego de simulación de vida donde los jugadores crean su propia isla, interactúan con vecinos y realizan diversas actividades cotidianas.', 'https://cdn.mobygames.com/covers/3083380-animal-crossing-new-horizons-nintendo-switch-front-cover.jpg'),
(17, 'Stardew Valley', 'ConcernedApe', 'ConcernedApe', '2016', '/imagenes/stardew_valley.jpg', 'Un juego de simulación agrícola donde los jugadores heredan una granja y deben cultivarla mientras interactúan con la comunidad local.', 'https://cdn.mobygames.com/covers/1863885-stardew-valley-linux-front-cover.jpg'),
(18, 'Celeste', 'Maddy Makes Games', 'Maddy Makes Games', '2018', '/imagenes/celeste.jpg', 'Un juego de plataformas desafiante sobre la vida de una joven llamada Madeline mientras asciende a la montaña Celeste.', 'https://cdn.mobygames.com/covers/3148568-celeste-linux-front-cover.jpg'),
(19, 'DOOM Eternal', 'id Software', 'Bethesda Softworks', '2020', '/imagenes/doom_eternal.jpg', 'Un juego de disparos en primera persona en el que los jugadores controlan al Doom Slayer, luchando contra demonios en escenarios infernales.', 'https://cdn.mobygames.com/covers/3947919-doom-dos-front-cover.jpg'),
(20, 'League of Legends', 'Riot Games', 'Riot Games', '2009', '/imagenes/league_of_legends.jpg', 'Un juego de estrategia en tiempo real multijugador donde dos equipos de campeones luchan por destruir la base del enemigo.', 'https://cdn.mobygames.com/covers/17214947-league-of-legends-windows-front-cover.jpg'),
(23, 'The Elder Scrolls V: Skyrim - Hearthfire', 'Square Enix', 'Yo', '2024', '', 'Hearthfire is the second official DLC pack for The Elder Scrolls V: Skyrim. As well as adding several minor quests, Hearthfire primarily allows the player to purchase land in three of the holds in Skyrim (Falkreath, Dawnstar and Morthal). Players can also design houses for their land, from a small cottage to a three wing mansion. Players can mine new materials and fashion new items for use in constructing their homes. Another new feature gives the opportunity to adopt a child to live with them.', 'https://cdn.mobygames.com/covers/3226117-the-elder-scrolls-v-skyrim-hearthfire-xbox-360-front-cover.jpg'),
(24, 'The Elder Scrolls V: Skyrim', 'Sega', 'PEPA', '2024', '', 'Two hundred years after the events described in Oblivion, the continent of Tamriel is in turmoil. The Emperors throne remained without heir; the Blades, Empires elite guards, have been disassembled; elven nations began capturing territory from the Empire. The assassination of the King of Skyrim, Tamriels Northern-most province and home of the Nord race, led to a civil war between those who wish independence for Skyrim and those who wanted it to remain under the Empires control. \r\nA prisoner is brought to a small town, awaiting execution for alleged involvement with the Stormcloaks, a group that was founded by the kings assassin Ulfric Stormcloak. Just before the executioners axe lands on the prisoners neck, a dragon attacks the city, forcing most people to flee. The unexpected freedom leads the ex-prisoner into the snowy Skyrim, where the rumors of the dragon begin to circulate.\r\nLike its predecessors in the Elder Scrolls series, Skyrim is an open-ended role-playing game with action-based combat. The player may explore the vast environments of Skyrim from either first- (default) or third-person perspective, being unrestricted in his or her travels and free to undertake any side quests in any order, or follow the main quest. It is possible to fast-travel to previously visited locations directly from the world map. The player can also opt to buy (or steal) and ride a horse.\r\nThere are ten races to choose from: Altmer (High Elves), Argonian (reptile people), Bosmer (Wood Elves), Breton, Dunmer (Dark Elves), Imperial, Khajiit (cat people), Nord, Orc, and Redguard. Each race has their own perks and limitations, such as Nord being resistant to cold, Khajiit being weak with magic, etc. Unlike the previous games in the series, the player cannot choose a class for the main character; rather, the latter evolves into any class-like combination gradually, according to the play style. When the protagonist reaches a new level, the player may increase his or her Health, Magicka, or Stamina and a new perk may be added to one of the skills. There are eighteen skills altogether, and each skill has several levels and perks which may be obtained. Most perks are only accessible after a certain level has been reached in said perk. For instance, in order to reach higher perks with Destruction, destructive spells must be leveled up. Skill levels can increase either through extensive use, skill books, or even paying for training from certain non-playable characters. \r\nThe game contains some features that were introduced in Fallout 3. Enemy level-scaling is done in a similar way, as opposed to the more intrusive system of Oblivion. The player may hire other fighters to follow the hero around and lend a helping hand in combat. Also, the lockpicking system of the previous installment has been replaced by the lockpicking methods of the recent Fallout games. Conversations with NPCs now occur in real time rather than \"freezing\" time as in Oblivion. \r\nPlayers can craft, cook, or build any number of items depending on ingredients and skill levels. Alchemy allows players to make potions, Enchanting allows players to imbue armor and items with magical abilities (such as increasing the effectiveness of magic resistance), and Smithing allows players to either craft or improve weapons and armor. Smelting, tanning and cooking are also a part of this mix as well: Smelting is the skill of turning raw mined mineral ores into usable ingots for smithing; Tanning is the process of drying animal hides to make leather strips, useful in creating or improving armor and weapons; Cooking allows players to turn otherwise minimally useful food ingredients into much more beneficial meals. \r\nMelee attacks can be performed using either two or one-handed weapons. Blocking reduces damage and allows for the opportunity to bash an opponent with a shield. Archery is also available for some ranged attacks, as is quite a bit of magicka. Each race also has a distinct magic-like power ability; only one power may be equipped at a time. For instance, a Nord power is to frighten enemies away for a while. New to the series is the Shout ability, which is a special power based on Dragon language. These require a special set of circumstances to unlock: first, the ancient words must be learned from Word Walls hidden all over Skyrim; secondly, they can only be activated by acquiring a dragon soul (from slaying a dragon). \r\nCrimes may be committed by stealing, pickpocketing, murder or attacking innocent people, or even by trespassing. Generally this puts a bounty on the head of the player character, unless said character is quick enough to eliminate all witnesses. Fines and jail time, or a beat-down from authorities, are likely to ensue if the hero commits too many crimes or merely ends up getting caught. The protagonist can serve out his or her sentence on the jail bed, or pick the lock and escape; however, going to jail is likely to cause current skill progress to be lost. \r\nAs before, there are several groups, guilds, and the like that the player may encounter and join, each with their own advantages or disadvantages, each with their own views on the current events of the world, and each with their own quests. The abilities to become a werewolf or vampire are also present and have been somewhat streamlined: for instance, sunlight is not instantly deadly to vampires, and lycanthropy can be spread around.', 'https://cdn.mobygames.com/covers/5477662-the-elder-scrolls-v-skyrim-windows-front-cover.jpg'),
(25, 'The Elder Scrolls V: Skyrim - Legendary Edition', 'sEGA', 'PEPA', '2024', '', 'The Elder Scrolls V: Skyrim - Legendary Edition includes:\r\n\r\nThe Elder Scrolls V: Skyrim (updated to the latest version, including mounted combat and the Legendary difficulty level)\r\nThe Elder Scrolls V: Skyrim - Dawnguard (DLC)\r\nThe Elder Scrolls V: Skyrim - Hearthfire (DLC)\r\nThe Elder Scrolls V: Skyrim - Dragonborn (DLC)\r\n\r\nThe retail version includes a fold-out paper map.', 'https://cdn.mobygames.com/covers/9262176-the-elder-scrolls-v-skyrim-legendary-edition-windows-front-cover.jpg'),
(26, 'Skyrim: Very Special Edition', 'aaaaaa', '', '2018', 'aaaaa', 'This Very Special Edition of The Elder Scrolls V: Skyrim is a free voice-controlled game for Amazon Alexa which isn\'t a full port of the original game but a rather simplified version that lets the player become Dragonborn in this narrated story. The places in Skyrim, creatures, monsters, actions, they are all there but with limitations on how you can interact with them and in what capacity.\r\nThe player initially starts with a level 1 character. While traveling Skyrim many characters will ask for the player\'s help. Whether their possessions have been stolen by the bandits, or some dangerous monster burnt down their village and whatnot. The player can accept each of the quests, or simply refuse and keep going. By accepting the quest, the story will lead you to retrieve some item and face the next villain. The story will constantly let you choose your path by asking you which path you wish to take, more dangerous but quicker one, or safer but a longer one. The player\'s journey will stop the moment an opponent (a bandit, a monster, enemy soldier, a dragon, etc.) blocks the way ahead. At that moment, the battle commences. There are three types of attack; using a weapon (sword, mace, or any other equipped weapon), shouting the dragon tongue, or casting a spell. There is no weapon, shout or spell selection, instead, the player character uses what he has equipped or what best serves the purpose at hand. At the end of each quest, there will be a boss battle.\r\nCertain types of enemies are resistant to certain types of attack and if attacked that way their counter-attack will be swift and deadly. The player can ask for their current health status, though at the end of each quest their health fully replenishes. There are no health potions to use or any other way to heal the player character during the quest. Weapon skill, shout skill, and spell casting skill all start at level 1, and the more a certain type of attack is used successfully, the player will level up in those areas and be able to deal with enemies more easily. Alexa will immediately prompt the player whenever the player levels up some of the skills available.', 'https://cdn.mobygames.com/covers/2045121-skyrim-very-special-edition-amazon-alexa-front-cover.png'),
(27, 'Skyrim: Very Special Edition', 'AAAA', '', '2018', 'aaaa', 'This Very Special Edition of The Elder Scrolls V: Skyrim is a free voice-controlled game for Amazon Alexa which isn\'t a full port of the original game but a rather simplified version that lets the player become Dragonborn in this narrated story. The places in Skyrim, creatures, monsters, actions, they are all there but with limitations on how you can interact with them and in what capacity.\r\nThe player initially starts with a level 1 character. While traveling Skyrim many characters will ask for the player\'s help. Whether their possessions have been stolen by the bandits, or some dangerous monster burnt down their village and whatnot. The player can accept each of the quests, or simply refuse and keep going. By accepting the quest, the story will lead you to retrieve some item and face the next villain. The story will constantly let you choose your path by asking you which path you wish to take, more dangerous but quicker one, or safer but a longer one. The player\'s journey will stop the moment an opponent (a bandit, a monster, enemy soldier, a dragon, etc.) blocks the way ahead. At that moment, the battle commences. There are three types of attack; using a weapon (sword, mace, or any other equipped weapon), shouting the dragon tongue, or casting a spell. There is no weapon, shout or spell selection, instead, the player character uses what he has equipped or what best serves the purpose at hand. At the end of each quest, there will be a boss battle.\r\nCertain types of enemies are resistant to certain types of attack and if attacked that way their counter-attack will be swift and deadly. The player can ask for their current health status, though at the end of each quest their health fully replenishes. There are no health potions to use or any other way to heal the player character during the quest. Weapon skill, shout skill, and spell casting skill all start at level 1, and the more a certain type of attack is used successfully, the player will level up in those areas and be able to deal with enemies more easily. Alexa will immediately prompt the player whenever the player levels up some of the skills available.', 'https://cdn.mobygames.com/covers/2045121-skyrim-very-special-edition-amazon-alexa-front-cover.png'),
(28, 'Skyrim: Very Special Edition', 'AAAA', '', '2018', 'aaaa', 'This Very Special Edition of The Elder Scrolls V: Skyrim is a free voice-controlled game for Amazon Alexa which isn\'t a full port of the original game but a rather simplified version that lets the player become Dragonborn in this narrated story. The places in Skyrim, creatures, monsters, actions, they are all there but with limitations on how you can interact with them and in what capacity.\r\nThe player initially starts with a level 1 character. While traveling Skyrim many characters will ask for the player\'s help. Whether their possessions have been stolen by the bandits, or some dangerous monster burnt down their village and whatnot. The player can accept each of the quests, or simply refuse and keep going. By accepting the quest, the story will lead you to retrieve some item and face the next villain. The story will constantly let you choose your path by asking you which path you wish to take, more dangerous but quicker one, or safer but a longer one. The player\'s journey will stop the moment an opponent (a bandit, a monster, enemy soldier, a dragon, etc.) blocks the way ahead. At that moment, the battle commences. There are three types of attack; using a weapon (sword, mace, or any other equipped weapon), shouting the dragon tongue, or casting a spell. There is no weapon, shout or spell selection, instead, the player character uses what he has equipped or what best serves the purpose at hand. At the end of each quest, there will be a boss battle.\r\nCertain types of enemies are resistant to certain types of attack and if attacked that way their counter-attack will be swift and deadly. The player can ask for their current health status, though at the end of each quest their health fully replenishes. There are no health potions to use or any other way to heal the player character during the quest. Weapon skill, shout skill, and spell casting skill all start at level 1, and the more a certain type of attack is used successfully, the player will level up in those areas and be able to deal with enemies more easily. Alexa will immediately prompt the player whenever the player levels up some of the skills available.', 'https://cdn.mobygames.com/covers/2045121-skyrim-very-special-edition-amazon-alexa-front-cover.png'),
(29, 'Skyrim: Very Special Edition', 'AAAA', '', '2018', 'aaaa', 'This Very Special Edition of The Elder Scrolls V: Skyrim is a free voice-controlled game for Amazon Alexa which isn\'t a full port of the original game but a rather simplified version that lets the player become Dragonborn in this narrated story. The places in Skyrim, creatures, monsters, actions, they are all there but with limitations on how you can interact with them and in what capacity.\r\nThe player initially starts with a level 1 character. While traveling Skyrim many characters will ask for the player\'s help. Whether their possessions have been stolen by the bandits, or some dangerous monster burnt down their village and whatnot. The player can accept each of the quests, or simply refuse and keep going. By accepting the quest, the story will lead you to retrieve some item and face the next villain. The story will constantly let you choose your path by asking you which path you wish to take, more dangerous but quicker one, or safer but a longer one. The player\'s journey will stop the moment an opponent (a bandit, a monster, enemy soldier, a dragon, etc.) blocks the way ahead. At that moment, the battle commences. There are three types of attack; using a weapon (sword, mace, or any other equipped weapon), shouting the dragon tongue, or casting a spell. There is no weapon, shout or spell selection, instead, the player character uses what he has equipped or what best serves the purpose at hand. At the end of each quest, there will be a boss battle.\r\nCertain types of enemies are resistant to certain types of attack and if attacked that way their counter-attack will be swift and deadly. The player can ask for their current health status, though at the end of each quest their health fully replenishes. There are no health potions to use or any other way to heal the player character during the quest. Weapon skill, shout skill, and spell casting skill all start at level 1, and the more a certain type of attack is used successfully, the player will level up in those areas and be able to deal with enemies more easily. Alexa will immediately prompt the player whenever the player levels up some of the skills available.', 'https://cdn.mobygames.com/covers/2045121-skyrim-very-special-edition-amazon-alexa-front-cover.png'),
(30, 'Skyrim: Very Special Edition', 'aaaa', '', '2018', 'aa', 'This Very Special Edition of The Elder Scrolls V: Skyrim is a free voice-controlled game for Amazon Alexa which isn\'t a full port of the original game but a rather simplified version that lets the player become Dragonborn in this narrated story. The places in Skyrim, creatures, monsters, actions, they are all there but with limitations on how you can interact with them and in what capacity.\r\nThe player initially starts with a level 1 character. While traveling Skyrim many characters will ask for the player\'s help. Whether their possessions have been stolen by the bandits, or some dangerous monster burnt down their village and whatnot. The player can accept each of the quests, or simply refuse and keep going. By accepting the quest, the story will lead you to retrieve some item and face the next villain. The story will constantly let you choose your path by asking you which path you wish to take, more dangerous but quicker one, or safer but a longer one. The player\'s journey will stop the moment an opponent (a bandit, a monster, enemy soldier, a dragon, etc.) blocks the way ahead. At that moment, the battle commences. There are three types of attack; using a weapon (sword, mace, or any other equipped weapon), shouting the dragon tongue, or casting a spell. There is no weapon, shout or spell selection, instead, the player character uses what he has equipped or what best serves the purpose at hand. At the end of each quest, there will be a boss battle.\r\nCertain types of enemies are resistant to certain types of attack and if attacked that way their counter-attack will be swift and deadly. The player can ask for their current health status, though at the end of each quest their health fully replenishes. There are no health potions to use or any other way to heal the player character during the quest. Weapon skill, shout skill, and spell casting skill all start at level 1, and the more a certain type of attack is used successfully, the player will level up in those areas and be able to deal with enemies more easily. Alexa will immediately prompt the player whenever the player levels up some of the skills available.', 'https://cdn.mobygames.com/covers/2045121-skyrim-very-special-edition-amazon-alexa-front-cover.png'),
(31, 'Pac-Man', 'pacman', '', '2004', 'pacman', 'One of the most popular and influential games of the 1980\'s, Pac-Man stars a little, yellow dot-muncher who works his way around to clear a maze of the various dots and fruit which inhabit the board.\r\nPac-Man\'s goal is continually challenged by four ghosts: The shy blue ghost Bashful (\"Inky\"), the trailing red ghost Shadow (\"Blinky\"), the fast pink ghost Speedy (\"Pinky\"), and the forgetful orange ghost Pokey (\"Clyde\"). One touch from any of these ghosts means loss of a life for Pac-Man.\r\nPac-Man can turn the tables on his pursuers by eating one of the four Power-Pills located around the maze. During this time, the ghosts turn blue, and Pac-Man can eat them for bonus points. This only lasts for a limited amount of time as the ghosts\' eyes float back to their center box and regenerate to chase after Pac-Man again.\r\nSurvive a few rounds of gameplay, and be treated to humorous intermissions starring Pac-Man and the ghosts.', 'https://cdn.mobygames.com/covers/4002121-pac-man-atari-2600-front-cover.jpg'),
(32, 'Pac-Man', 'pacman', '', '2004', 'pacman', 'One of the most popular and influential games of the 1980\'s, Pac-Man stars a little, yellow dot-muncher who works his way around to clear a maze of the various dots and fruit which inhabit the board.\r\nPac-Man\'s goal is continually challenged by four ghosts: The shy blue ghost Bashful (\"Inky\"), the trailing red ghost Shadow (\"Blinky\"), the fast pink ghost Speedy (\"Pinky\"), and the forgetful orange ghost Pokey (\"Clyde\"). One touch from any of these ghosts means loss of a life for Pac-Man.\r\nPac-Man can turn the tables on his pursuers by eating one of the four Power-Pills located around the maze. During this time, the ghosts turn blue, and Pac-Man can eat them for bonus points. This only lasts for a limited amount of time as the ghosts\' eyes float back to their center box and regenerate to chase after Pac-Man again.\r\nSurvive a few rounds of gameplay, and be treated to humorous intermissions starring Pac-Man and the ghosts.', 'https://cdn.mobygames.com/covers/4002121-pac-man-atari-2600-front-cover.jpg'),
(33, 'Spyro the Dragon', 'jjjjj', '', '1998', 'aaaaa', 'The evil Gnasty Gnorc has turned all the dragons in the Dragon Lands into crystal. He has also stolen the dragons\' gems by locking them up in chests or turning them into soldiers for his army. But he forgot about one little dragon: Spyro. Now Spyro has to travel through the dragon kingdom and free all the dragons from their crystal prison, recover the dragons\' gems and defeat Gnasty Gnorc. \r\nSpyro the Dragon is a 3D platform game similar to Super Mario 64. The game consists of six worlds: Artisans, Peace Keepers, Magic Crafters, Beast Makers, Dream Weavers and finally Gnasty\'s World. Each world consists of a home or hub area, three regular levels, one flight level and one boss level.\r\nThe goal of the game is to beat Gnasty Gnorc by working your way through all six worlds. Along the way you have to find all 80 dragons, collect all 12 dragon eggs and collect as many gems as you can. Gems are found scattered throughout the levels, in treasure chests. Also, each defeated bad guy yields a gem and end bosses hold several gems.\r\nThe inventory screen shows progress for each level, how many gems found and how many dragons, it also shows many there are in each level. The real challenge lies in completing every level 100%. To do this you really have to explore every nook and cranny, the last gems are usually located on hard to reach places.', 'https://cdn.mobygames.com/covers/4799551-spyro-the-dragon-playstation-front-cover.jpg');
 */
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

/* INSERT INTO `juegosistema` (`idJuegoSistema`, `idSistema`, `idJuego`) VALUES
(1, 18, 23),
(2, 9, 14),
(3, 17, 25),
(4, 16, 16),
(5, 17, 18),
(6, 11, 19),
(7, 17, 19),
(8, 17, 20),
(9, 17, 17),
(11, 13, 9),
(12, 5, 16),
(13, 6, 16),
(14, 12, 17),
(15, 14, 17),
(16, 12, 32),
(17, 14, 32),
(18, 5, 33),
(19, 7, 33); */

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

--
-- Volcado de datos para la tabla `prestado`
--

/* INSERT INTO `prestado` (`idPrestamo`, `idUsuarioPresta`, `idUsuarioRecibe`, `idJuego`, `fechaInicio`, `fechaFin`) VALUES
(1, 4, 9, 18, '2025-01-30 18:21:08', '2025-03-01 18:21:08'); */

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

--
-- Volcado de datos para la tabla `regalado`
--

/* INSERT INTO `regalado` (`idRegalo`, `idUsuarioRegala`, `idUsuarioRecibe`, `idJuego`, `fechaRegalo`) VALUES
(1, 4, 9, 18, '2025-01-31 21:40:11'); */

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
(6, 'usuario2', 'usuario2@gmail.es', 'usuario2', 'usuario2', '$2y$10$FL/ox5KQKpR7UijKUP/k1OPSs7eSM9sTNv6DGwHRrpZVvIPrZ5uNy', 'Calle', 'Paseo del Río', 789, 'A1, A2', 'Apartamento 8', '+34645678901', 1),
(9, 'melocoton', 'eva@gmail.com', 'Eva', 'Alonso', '$2y$10$h5LJkF9qAa.kWaFnxzIAN.5rdzOWuaBRlAZsiS26NbOei3RpeToyW', 'Avenida', 'Los Pinos', 101, '3A, 3B', 'Condominio Cerrado', '+34656789012', 1),
(10, 'iceWolf', 'axel@gmail.com', 'Axel', 'José', '$2y$10$RwBDep4hmQSjRGxVRvnbQO.LJL4ha2w6CqPx.jL3F4evSYnG5UzMS', 'Callejón', 'Roca Seca', 205, 'D1, D2', 'Casa de Campo', '+34667890123', 1)
;

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
  MODIFY `idGeneroJuego` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de la tabla `juego`
--
ALTER TABLE `juego`
  MODIFY `idJuego` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT de la tabla `juegosistema`
--
ALTER TABLE `juegosistema`
  MODIFY `idJuegoSistema` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de la tabla `prestado`
--
ALTER TABLE `prestado`
  MODIFY `idPrestamo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `regalado`
--
ALTER TABLE `regalado`
  MODIFY `idRegalo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
