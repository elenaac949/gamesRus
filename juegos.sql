-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 22-12-2024 a las 18:05:45
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/* CREAR LAS TABLAS*/

CREATE TABLE rol (
    idRol INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    rol VARCHAR(255) NOT NULL
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE genero(
    idGenero INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    genero VARCHAR(50) NOT NULL
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE juego(
    idJuego INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(50) NOT NULL,
    desarrollador VARCHAR(50) NOT NULL,
    distribuidor VARCHAR(50) NOT NULL,
    anio YEAR(4) NOT NULL,
    ruta VARCHAR(250) NOT NULL,
    descripcion VARCHAR(255),
    portada VARCHAR(255)
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE juegoGenero(
    idGenero INT(11) NOT NULL,
    idJuego INT(11) NOT NULL,
    CONSTRAINT pk_jug PRIMARY KEY (idGenero, idJuego),
    CONSTRAINT fk_jg_idg_gen_idg FOREIGN KEY (idGenero) REFERENCES genero (idGenero) 
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    CONSTRAINT fk_jg_idu_usu_idu FOREIGN KEY (idJuego) REFERENCES juego (idJuego) 
        ON DELETE CASCADE
        ON UPDATE CASCADE
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


CREATE TABLE relacionaGenero(
    idGenero1 INT(11) NOT NULL,
    idGenero2 INT(11) NOT NULL,
    CONSTRAINT pk_relGen PRIMARY KEY (idGenero1, idGenero2),
    CONSTRAINT fk_reg_id1_gen_idg FOREIGN KEY (idGenero1) REFERENCES genero (idGenero) 
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    CONSTRAINT fk_reg_id2_gen_idg FOREIGN KEY (idGenero2) REFERENCES genero (idGenero) 
        ON DELETE CASCADE
        ON UPDATE CASCADE
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE usuario (
    idUsuario INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    nick VARCHAR(30) NOT NULL UNIQUE,
    email VARCHAR(50) NOT NULL UNIQUE,
    nombre VARCHAR(50) NOT NULL,
    apellidos VARCHAR(50) NOT NULL,
    contrasenia VARCHAR(250) NOT NULL,
    tipoVia VARCHAR(50) DEFAULT NULL,
    nombreVia VARCHAR(50) DEFAULT NULL,
    numeroVia INT(11) DEFAULT NULL,
    numeros VARCHAR(30) DEFAULT NULL,
    otros VARCHAR(255) DEFAULT NULL,
    numeroTelefono VARCHAR(15) DEFAULT NULL,
    idRol INT(11) NOT NULL,
    CONSTRAINT fk_usu_idr_rol_idr FOREIGN KEY (idRol) REFERENCES rol (idRol) 
        ON DELETE CASCADE
        ON UPDATE CASCADE
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


CREATE TABLE tarjeta(
    idTarjeta INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    numeroTarjeta VARCHAR(19) NOT NULL,
    ccv CHAR(3) NOT  NULL,
    fechaCaducidad DATE NOT NULL,
    idUsuario INT(11) NOT NULL,
    CONSTRAINT fk_tar_idu_usu_idu FOREIGN KEY (idUsuario) REFERENCES usuario (idUsuario)
        ON DELETE CASCADE
        ON UPDATE CASCADE
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



CREATE TABLE carrito(
    idCarrito INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    idUsuario INT(11) NOT NULL,
    CONSTRAINT fk_car_idu_usu_idu FOREIGN KEY (idUsuario) REFERENCES usuario (idUsuario)
        ON DELETE CASCADE
        ON UPDATE CASCADE
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


CREATE TABLE carritoJuego(
    idCarrito INT(11) NOT NULL,
    idJuego INT(11) NOT NULL,
    CONSTRAINT pk_caj PRIMARY KEY (idCarrito, idJuego),
    CONSTRAINT fk_caj_idc_car_idc FOREIGN KEY (idCarrito) REFERENCES carrito (idCarrito)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    CONSTRAINT fk_caj_idj_jue_idj FOREIGN KEY (idJuego) REFERENCES juego (idJuego)
        ON DELETE CASCADE
        ON UPDATE CASCADE
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


CREATE TABLE poseeJuego(
    idUsuario INT(11) NOT NULL,
    idJuego INT(11) NOT NULL,
    CONSTRAINT fk_poseeJuego PRIMARY KEY(idUsuario,idJuego),
    CONSTRAINT fk_poj_idu_usu_idu FOREIGN KEY (idUsuario) REFERENCES usuario (idUsuario)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    CONSTRAINT fk_poj_idj_jue_idj FOREIGN KEY (idJuego) REFERENCES juego (idJuego)
        ON DELETE CASCADE
        ON UPDATE CASCADE
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


CREATE TABLE comprado(
    idCompra INT(11) NOT NULL AUTO_INCREMENT,
    idUsuario INT(11) NOT NULL,
    idJuego INT(11) NOT NULL,
    fechaCompra DATETIME NOT NULL,
    CONSTRAINT fk_com PRIMARY KEY(idCompra,idUsuario,idJuego),
    CONSTRAINT fk_com_idu_usu_idu FOREIGN KEY (idUsuario) REFERENCES usuario (idUsuario)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    CONSTRAINT fk_com_idj_jue_idj FOREIGN KEY (idJuego) REFERENCES juego (idJuego)
        ON DELETE CASCADE
        ON UPDATE CASCADE
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;




CREATE TABLE prestado(
    idPrestamo INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    idUsuPresta INT(11) NOT NULL,
    idUsuRecibePrest INT(11) NOT NULL,
    idJuego INT(11) NOT NULL,
    fechaInicio DATETIME NOT NULL,
    fechaFin DATETIME NOT NULL
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


CREATE TABLE regalado(
    idRegalo INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    idUsuRegala INT(11) NOT NULL,
    idUsuRecibe INT(11) NOT NULL,
    idJuego INT(11) NOT NULL,
    fechaRegalo DATETIME NOT NULL,
    
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



/* INSERTAR DATOS */

INSERT INTO rol (idRol, rol) VALUES
(1, 'usuario'),
(2, 'admin');


INSERT INTO genero (idGenero, genero) VALUES
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

INSERT INTO `usuario` (idUsuario, nick,email, nombre, apellidos, contrasenia, tipoVia, nombreVia, numeroVia, numeros, otros, numeroTelefono, idRol) VALUES
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


INSERT INTO juego (idJuego, titulo, desarrollador, distribuidor, anio, ruta, descripcion, portada) VALUES
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
(20, 'League of Legends', 'Riot Games', 'Riot Games', '2009', '/imagenes/league_of_legends.jpg', 'Un juego de estrategia en tiempo real multijugador donde dos equipos de campeones luchan por destruir la base del enemigo.', NULL);



INSERT INTO comprado (idCompra, idUsuario, idJuego, fechaCompra) VALUES
(1, 4, 16, '2024-12-06 15:52:52'),
(2, 4, 12, '2024-12-07 12:55:06'),
(3, 5, 4, '2024-12-13 18:24:49'),
(4, 5, 7, '2024-12-13 18:24:50');


