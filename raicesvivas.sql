-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 06-04-2026 a las 10:54:35
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
-- Base de datos: `raicesvivas`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `actividad`
--

CREATE TABLE `actividad` (
  `id` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(120) NOT NULL,
  `tipo` enum('taller','ruta','charla','alojamiento') NOT NULL,
  `descripcion_general` text NOT NULL,
  `precio` decimal(8,2) NOT NULL,
  `duracion` int(10) UNSIGNED NOT NULL,
  `estado` enum('activa','cancelada') NOT NULL DEFAULT 'activa',
  `motivo_cancelacion` varchar(255) DEFAULT NULL,
  `id_organizador` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `actividad`
--

INSERT INTO `actividad` (`id`, `nombre`, `tipo`, `descripcion_general`, `precio`, `duracion`, `estado`, `motivo_cancelacion`, `id_organizador`) VALUES
(1, 'Cocina de la Sierra', 'taller', 'Elaboración de las famosas patatas machaconas con pimentón de la Vera y los huesillos, un postre típico de la zona. Una experiencia para chuparse los dedos en una cocina de piedra original con productos locales.', 5.00, 180, 'activa', NULL, 1),
(2, 'Cestos de Mimbre', 'taller', 'Conrado Prieto, maestro artesano local, te enseñará a domar el mimbre para crear tu propia cesta para ir a pescar o incluso gorras. Aprenderás cómo se recolectaba y trataba el material a la orilla del río Tormes siguiendo técnicas centenarias.', 0.00, 240, 'activa', NULL, 3),
(3, 'Pesca Tradicional', 'taller', 'Descubre cómo los habitantes de la sierra aprovechaban el río. Aprenderás las técnicas de pesca manual y con caña en las aguas del Tormes, además de diferentes \"trucos\" para pescar más truchas.', 0.00, 180, 'activa', NULL, 1),
(4, 'Cultivo Tradicional', 'taller', 'Descubre el sistema de riego tradicional que mantiene vivos los huertos de montaña junto con sus herramientas tradicionales, además de la fruta, verdura y hortalizas que se siembran.', 0.00, 150, 'activa', NULL, 2),
(5, 'Juegos Tradicionales', 'taller', 'Aprenderás juegos tradicionales a los que se jugaban todos los amigos en las calles de los pueblos como El Burro, Las Tabas, La Rana o La Calva.', 2.50, 120, 'activa', NULL, 1),
(6, 'Laguna Grande de Gredos', 'ruta', 'Expedición guiada al corazón del Circo de Gredos. Veremos la fauna local, especialmente la cabra montesa, y conoceremos la geología glaciar que dio forma a nuestra sierra en una caminata inolvidable.', 15.00, 480, 'activa', NULL, 4),
(7, 'Subida a La Espesura', 'ruta', 'Caminaremos por las antiguas veredas por las que los pastores subían al ganado en verano. Un paisaje lleno de robles, piornos y una paz inigualable, donde hay un chozo donde se quedaban los pastores a dormir.', 10.00, 300, 'activa', NULL, 4),
(8, '5 Lagunas de Gredos', 'ruta', 'Las Cinco Lagunas de Gredos son un conjunto de lagunas glaciares formadas hace unos 10.000 a 15.000 años durante el Pleistoceno, situadas en el circo de la Garganta del Pinar, en el Macizo Central de la Sierra de Gredos.', 18.00, 540, 'activa', NULL, 4),
(9, 'Senda del Río Tormes', 'ruta', 'Una ruta diseñada para toda la familia. Recorreremos las orillas del río, visitando puentes romanos y pozas naturales de agua cristalina, explicando la importancia del agua para la vida económica de Angostura.', 5.00, 120, 'activa', NULL, 4),
(10, 'Secretos de Gredos', 'ruta', 'Gredos es un paraíso biológico. En esta ruta aprenderás a identificar especies endémicas, desde la cabra montesa hasta el águila real o incluso el quebrantahuesos, además de conocer el uso medicinal que los lugareños daban a las plantas de la zona.\r\nLa interpretación de la flora y fauna local será con guías expertos, conociendo el piorno en flor y una gran diversidad de aves. Incluye préstamo de prismáticos.', 5.00, 240, 'activa', NULL, 4),
(11, 'Memoria de la Pobreza', 'charla', 'Una charla emotiva donde los mayores de Angostura nos contarán cómo se vivía antes, sin luz ni agua corriente, y cómo la solidaridad entre vecinos permitió que el pueblo prosperara en tiempos difíciles.', 0.00, 90, 'activa', NULL, 1),
(12, 'La Elaboración de la Matanza', 'charla', 'Descubre cómo elaboraban la matanza antiguamente como los chorizos. Hace años algunas personas no tenían la posibilidad de ir a comprar a los mercados, ya sea por distancia o por la economía de la familia. Al finalizar se podrá probar el producto final.', 0.00, 120, 'activa', NULL, 1),
(13, 'La Vida del Pastor', 'charla', 'Una charla profunda sobre la soledad del pastor en el puerto. Conoceremos cómo era pasar meses en el monte, el lenguaje de los silbidos y la cultura de la trashumancia que dio forma a nuestra identidad.', 2.00, 90, 'activa', NULL, 1),
(14, 'Lo que Gredos Calla', 'charla', '¿Sabías por qué ciertos rincones del pueblo tienen nombres extraños? En esta sesión descubriremos las historias más divertidas, misteriosas y sorprendentes que han pasado de boca en boca durante siglos en Angostura.', 0.00, 90, 'activa', NULL, 1),
(15, 'Bailes, Vestimenta y Canciones Tradicionales', 'charla', 'Descubrirás cómo son los bailes típicos junto con la vestimenta tradicional y algunas canciones que nunca habrás escuchado. Algunas canciones son personalizadas con personas de los pueblos.', 2.50, 90, 'activa', NULL, 1),
(16, 'La Casa de la Plaza', 'alojamiento', 'Situada en pleno centro de Angostura de Tormes, posee capacidad para cuatro personas. La casa se encuentra totalmente equipada y cuenta con chimenea, calefacción en toda la casa y cocina americana. Tiene la arquitectura tradicional de Gredos con el máximo confort moderno y unas espectaculares vistas al entorno.', 80.00, 1440, 'activa', NULL, 5),
(17, 'Casa Rural El Pinta', 'alojamiento', 'Se encuentra en La Aliseda de Tormes, a orillas del río Tormes. El entorno invita al descanso o a la práctica de actividades al aire libre en pleno contacto con la naturaleza.', 75.00, 1440, 'activa', NULL, 5),
(18, 'Casa Rural La Tabilla', 'alojamiento', 'Se encuentra en Navalperal de Tormes. Es el resultado de una rehabilitación realizada en una construcción del siglo XIX que en su momento fue utilizada con fines agrícolas y ganaderos. Rehabilitación hecha a la antigua usanza utilizando materiales originales de la zona como piedra y madera, consiguiendo finalmente recuperar su ambiente rústico y rural típico de estas tierras serranas.', 70.00, 1440, 'activa', NULL, 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alojamiento`
--

CREATE TABLE `alojamiento` (
  `id_actividad` int(10) UNSIGNED NOT NULL,
  `tipo_alojamiento` varchar(40) NOT NULL,
  `noches` tinyint(3) UNSIGNED NOT NULL,
  `regimen` enum('solo_alojamiento','desayuno','media_pension','pension_completa') NOT NULL,
  `condiciones` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `alojamiento`
--

INSERT INTO `alojamiento` (`id_actividad`, `tipo_alojamiento`, `noches`, `regimen`, `condiciones`) VALUES
(16, 'Casa rural', 2, 'solo_alojamiento', 'Check-in a partir de las 16:00. Mascotas no permitidas. Fianza de 50€.'),
(17, 'Casa rural', 2, 'desayuno', 'Check-in a partir de las 15:00. Mascotas pequeñas permitidas. A orillas del río.'),
(18, 'Casa rural', 2, 'desayuno', 'Check-in a partir de las 16:00. Edificio del siglo XIX rehabilitado. Chimenea.');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `charla`
--

CREATE TABLE `charla` (
  `id_actividad` int(10) UNSIGNED NOT NULL,
  `tema` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `charla`
--

INSERT INTO `charla` (`id_actividad`, `tema`) VALUES
(11, 'Historia y memoria oral de Angostura de Tormes'),
(12, 'Gastronomía y tradiciones de la matanza serrana'),
(13, 'Trashumancia y vida pastoril en la Sierra de Gredos'),
(14, 'Leyendas y anécdotas populares de Angostura'),
(15, 'Jotas, indumentaria y música tradicional de Gredos');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `edicion`
--

CREATE TABLE `edicion` (
  `id` int(10) UNSIGNED NOT NULL,
  `anio` smallint(5) UNSIGNED NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_fin` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `edicion`
--

INSERT INTO `edicion` (`id`, `anio`, `fecha_inicio`, `fecha_fin`) VALUES
(1, 2024, '2024-06-14', '2024-06-16'),
(2, 2025, '2025-06-13', '2025-06-15'),
(3, 2026, '2026-06-12', '2026-06-14');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `localidad`
--

CREATE TABLE `localidad` (
  `id` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `localidad`
--

INSERT INTO `localidad` (`id`, `nombre`) VALUES
(1, 'Álava'),
(2, 'Albacete'),
(3, 'Alicante'),
(4, 'Almería'),
(5, 'Asturias'),
(6, 'Ávila'),
(7, 'Badajoz'),
(8, 'Barcelona'),
(9, 'Burgos'),
(10, 'Cáceres'),
(11, 'Cádiz'),
(12, 'Cantabria'),
(13, 'Castellón'),
(51, 'Ceuta'),
(14, 'Ciudad Real'),
(15, 'Córdoba'),
(16, 'Cuenca'),
(20, 'Gipuzkoa'),
(17, 'Girona'),
(18, 'Granada'),
(19, 'Guadalajara'),
(21, 'Huelva'),
(22, 'Huesca'),
(23, 'Islas Baleares'),
(24, 'Jaén'),
(25, 'La Coruña'),
(26, 'La Rioja'),
(27, 'Las Palmas'),
(28, 'León'),
(29, 'Lleida'),
(30, 'Lugo'),
(31, 'Madrid'),
(32, 'Málaga'),
(52, 'Melilla'),
(33, 'Murcia'),
(34, 'Navarra'),
(53, 'Otro'),
(35, 'Ourense'),
(36, 'Palencia'),
(37, 'Pontevedra'),
(38, 'Salamanca'),
(39, 'Santa Cruz de Tenerife'),
(40, 'Segovia'),
(41, 'Sevilla'),
(42, 'Soria'),
(43, 'Tarragona'),
(44, 'Teruel'),
(45, 'Toledo'),
(46, 'Valencia'),
(47, 'Valladolid'),
(48, 'Vizcaya'),
(49, 'Zamora'),
(50, 'Zaragoza');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `organizador`
--

CREATE TABLE `organizador` (
  `id` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(120) NOT NULL,
  `tipo` enum('empresa','asociacion','ayuntamiento','autonomo') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `organizador`
--

INSERT INTO `organizador` (`id`, `nombre`, `tipo`) VALUES
(1, 'Asociación Cultural Raíces Vivas', 'asociacion'),
(2, 'Ayuntamiento de Angostura de Tormes', 'ayuntamiento'),
(3, 'Artesanos de Gredos S.L.', 'empresa'),
(4, 'Guías de la Sierra de Gredos', 'empresa'),
(5, 'Casas Rurales Tormes', 'empresa');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `persona`
--

CREATE TABLE `persona` (
  `id` int(10) UNSIGNED NOT NULL,
  `codigo` varchar(20) NOT NULL,
  `nombre` varchar(60) NOT NULL,
  `priApe` varchar(80) NOT NULL,
  `segApe` varchar(80) DEFAULT NULL,
  `fecha_nacimiento` date NOT NULL,
  `email` varchar(120) NOT NULL,
  `rol` enum('ADMIN','USER') NOT NULL,
  `fecha_registro` datetime NOT NULL DEFAULT current_timestamp(),
  `id_localidad` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `persona`
--

INSERT INTO `persona` (`id`, `codigo`, `nombre`, `priApe`, `segApe`, `fecha_nacimiento`, `email`, `rol`, `fecha_registro`, `id_localidad`) VALUES
(4, 'RV-9430', 'Hugo', 'Salguero', NULL, '2008-11-03', 'hugo@gmail.com', 'USER', '2026-04-06 10:19:39', 10),
(5, 'RV-6520', 'Emma', 'Martín', 'Prieto', '2006-03-16', 'emma.marpri@gmail.com', 'USER', '2026-04-06 10:24:37', 6),
(6, 'RV-0358', 'Ana', 'Gomez', NULL, '1956-02-15', 'ana@gmail.com', 'USER', '2026-04-06 10:34:02', 20);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `persona_sesion`
--

CREATE TABLE `persona_sesion` (
  `id_persona` int(10) UNSIGNED NOT NULL,
  `id_sesion` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `persona_sesion`
--

INSERT INTO `persona_sesion` (`id_persona`, `id_sesion`) VALUES
(4, 1),
(5, 3),
(5, 8),
(5, 13),
(5, 17),
(6, 7),
(6, 13);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ruta`
--

CREATE TABLE `ruta` (
  `id_actividad` int(10) UNSIGNED NOT NULL,
  `dificultad` enum('baja','media','alta') NOT NULL,
  `distancia_km` decimal(5,2) NOT NULL,
  `recomendaciones` text DEFAULT NULL,
  `punto_inicio` varchar(120) NOT NULL,
  `punto_fin` varchar(120) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `ruta`
--

INSERT INTO `ruta` (`id_actividad`, `dificultad`, `distancia_km`, `recomendaciones`, `punto_inicio`, `punto_fin`) VALUES
(6, 'alta', 18.00, 'Botas de montaña, ropa de abrigo, agua y comida. No recomendada para niños menores de 8 años.', 'Plataforma de Gredos', 'Laguna Grande'),
(7, 'media', 8.50, 'Calzado cómodo, agua. Apta para familias con niños mayores de 6 años.', 'Angostura de Tormes', 'Chozo de La Espesura'),
(8, 'alta', 22.00, 'Botas de alta montaña, ropa de abrigo, bastones recomendados. Solo adultos.', 'Plataforma de Gredos', '5 Lagunas'),
(9, 'baja', 3.20, 'Calzado cómodo. Apta para todas las edades y familias con niños.', 'Puente medieval de Angostura', 'Poza del Molino'),
(10, 'media', 6.00, 'Prismáticos incluidos. Ropa discreta para no espantar a la fauna.', 'Angostura de Tormes', 'Mirador del Piorno');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sesion`
--

CREATE TABLE `sesion` (
  `id` int(10) UNSIGNED NOT NULL,
  `cupo_max` tinyint(3) UNSIGNED NOT NULL,
  `fecha_hora_inicio` datetime NOT NULL,
  `fecha_hora_fin` datetime NOT NULL,
  `id_actividad` int(10) UNSIGNED NOT NULL,
  `id_edicion` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `sesion`
--

INSERT INTO `sesion` (`id`, `cupo_max`, `fecha_hora_inicio`, `fecha_hora_fin`, `id_actividad`, `id_edicion`) VALUES
(1, 12, '2026-06-12 10:00:00', '2026-06-12 13:00:00', 1, 3),
(2, 12, '2026-06-13 10:00:00', '2026-06-13 13:00:00', 1, 3),
(3, 10, '2026-06-12 16:00:00', '2026-06-12 20:00:00', 2, 3),
(4, 10, '2026-06-14 16:00:00', '2026-06-14 20:00:00', 2, 3),
(5, 15, '2026-06-12 09:00:00', '2026-06-12 12:00:00', 3, 3),
(6, 15, '2026-06-14 09:00:00', '2026-06-14 12:00:00', 3, 3),
(7, 12, '2026-06-13 09:00:00', '2026-06-13 11:30:00', 4, 3),
(8, 20, '2026-06-12 17:00:00', '2026-06-12 19:00:00', 5, 3),
(9, 20, '2026-06-14 17:00:00', '2026-06-14 19:00:00', 5, 3),
(10, 12, '2026-06-13 07:00:00', '2026-06-13 15:00:00', 6, 3),
(11, 15, '2026-06-12 08:00:00', '2026-06-12 13:00:00', 7, 3),
(12, 15, '2026-06-14 08:00:00', '2026-06-14 13:00:00', 7, 3),
(13, 20, '2026-06-12 10:00:00', '2026-06-12 12:00:00', 8, 3),
(14, 20, '2026-06-13 10:00:00', '2026-06-13 12:00:00', 8, 3),
(15, 20, '2026-06-14 10:00:00', '2026-06-14 12:00:00', 8, 3),
(16, 15, '2026-06-13 08:00:00', '2026-06-13 12:00:00', 9, 3),
(17, 10, '2026-06-14 06:30:00', '2026-06-14 15:30:00', 10, 3),
(18, 20, '2026-06-12 19:00:00', '2026-06-12 20:30:00', 11, 3),
(19, 20, '2026-06-12 18:00:00', '2026-06-12 20:00:00', 12, 3),
(20, 20, '2026-06-13 19:00:00', '2026-06-13 20:30:00', 13, 3),
(21, 20, '2026-06-13 20:30:00', '2026-06-13 22:00:00', 14, 3),
(22, 20, '2026-06-14 19:00:00', '2026-06-14 20:30:00', 15, 3),
(23, 4, '2026-06-12 16:00:00', '2026-06-14 12:00:00', 16, 3),
(24, 6, '2026-06-12 15:00:00', '2026-06-14 11:00:00', 17, 3),
(25, 5, '2026-06-12 16:00:00', '2026-06-14 12:00:00', 18, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `taller`
--

CREATE TABLE `taller` (
  `id_actividad` int(10) UNSIGNED NOT NULL,
  `nivel` enum('iniciacion','medio','avanzado') NOT NULL,
  `materiales_incluidos` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `taller`
--

INSERT INTO `taller` (`id_actividad`, `nivel`, `materiales_incluidos`) VALUES
(1, 'iniciacion', 'Ingredientes, mandil, recetario'),
(2, 'iniciacion', 'Mimbre, herramientas de cestería, patrón'),
(3, 'iniciacion', 'Caña de pescar, cebo, cesta'),
(4, 'iniciacion', 'Herramientas de huerto, semillas, guantes'),
(5, 'iniciacion', 'Todos los materiales de juego incluidos');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `actividad`
--
ALTER TABLE `actividad`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_actividad_organizador` (`id_organizador`);

--
-- Indices de la tabla `alojamiento`
--
ALTER TABLE `alojamiento`
  ADD PRIMARY KEY (`id_actividad`);

--
-- Indices de la tabla `charla`
--
ALTER TABLE `charla`
  ADD PRIMARY KEY (`id_actividad`);

--
-- Indices de la tabla `edicion`
--
ALTER TABLE `edicion`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uk_edicion_anio` (`anio`);

--
-- Indices de la tabla `localidad`
--
ALTER TABLE `localidad`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uk_localidad_nombre` (`nombre`);

--
-- Indices de la tabla `organizador`
--
ALTER TABLE `organizador`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `persona`
--
ALTER TABLE `persona`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uk_persona_codigo` (`codigo`),
  ADD KEY `fk_persona_localidad` (`id_localidad`);

--
-- Indices de la tabla `persona_sesion`
--
ALTER TABLE `persona_sesion`
  ADD PRIMARY KEY (`id_persona`,`id_sesion`),
  ADD KEY `fk_persona_sesion_sesion` (`id_sesion`);

--
-- Indices de la tabla `ruta`
--
ALTER TABLE `ruta`
  ADD PRIMARY KEY (`id_actividad`);

--
-- Indices de la tabla `sesion`
--
ALTER TABLE `sesion`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_sesion_actividad` (`id_actividad`),
  ADD KEY `fk_sesion_edicion` (`id_edicion`);

--
-- Indices de la tabla `taller`
--
ALTER TABLE `taller`
  ADD PRIMARY KEY (`id_actividad`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `actividad`
--
ALTER TABLE `actividad`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `edicion`
--
ALTER TABLE `edicion`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `localidad`
--
ALTER TABLE `localidad`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT de la tabla `organizador`
--
ALTER TABLE `organizador`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `persona`
--
ALTER TABLE `persona`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `sesion`
--
ALTER TABLE `sesion`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `actividad`
--
ALTER TABLE `actividad`
  ADD CONSTRAINT `fk_actividad_organizador` FOREIGN KEY (`id_organizador`) REFERENCES `organizador` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `alojamiento`
--
ALTER TABLE `alojamiento`
  ADD CONSTRAINT `fk_alojamiento_actividad` FOREIGN KEY (`id_actividad`) REFERENCES `actividad` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `charla`
--
ALTER TABLE `charla`
  ADD CONSTRAINT `fk_charla_actividad` FOREIGN KEY (`id_actividad`) REFERENCES `actividad` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `persona`
--
ALTER TABLE `persona`
  ADD CONSTRAINT `fk_persona_localidad` FOREIGN KEY (`id_localidad`) REFERENCES `localidad` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `persona_sesion`
--
ALTER TABLE `persona_sesion`
  ADD CONSTRAINT `fk_persona_sesion_persona` FOREIGN KEY (`id_persona`) REFERENCES `persona` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_persona_sesion_sesion` FOREIGN KEY (`id_sesion`) REFERENCES `sesion` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `ruta`
--
ALTER TABLE `ruta`
  ADD CONSTRAINT `fk_ruta_actividad` FOREIGN KEY (`id_actividad`) REFERENCES `actividad` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `sesion`
--
ALTER TABLE `sesion`
  ADD CONSTRAINT `fk_sesion_actividad` FOREIGN KEY (`id_actividad`) REFERENCES `actividad` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_sesion_edicion` FOREIGN KEY (`id_edicion`) REFERENCES `edicion` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `taller`
--
ALTER TABLE `taller`
  ADD CONSTRAINT `fk_taller_actividad` FOREIGN KEY (`id_actividad`) REFERENCES `actividad` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
