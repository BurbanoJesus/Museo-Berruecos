-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 23-01-2021 a las 06:18:07
-- Versión del servidor: 10.4.13-MariaDB
-- Versión de PHP: 7.4.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `db_museo`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `debug`
--

CREATE TABLE `debug` (
  `id_debug` int(11) NOT NULL,
  `nombre_error` varchar(500) NOT NULL,
  `tipo_error` varchar(100) NOT NULL,
  `fecha_error` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `debug`
--

INSERT INTO `debug` (`id_debug`, `nombre_error`, `tipo_error`, `fecha_error`) VALUES
(19, 'SQLSTATE[42S22]: Column not found: 1054 Unknown column \'id\' in \'where clause\' -- 42S22', 'Actualizar - Noticia Img', '2021-01-04 11:42:12'),
(20, 'SQLSTATE[42S22]: Column not found: 1054 Unknown column \'id\' in \'where clause\' -- 42S22', 'Actualizar - Noticia Img', '2021-01-04 11:44:51'),
(21, 'SQLSTATE[42S22]: Column not found: 1054 Unknown column \'id\' in \'where clause\' -- 42S22', 'Actualizar - Noticia Img', '2021-01-04 11:45:27'),
(22, 'SQLSTATE[42000]: Syntax error or access violation: 1064 You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near \'WHERE id_pieza = ?\' at line 4 -- 42000', 'Actualizar - Producto Img', '2021-01-04 22:39:32'),
(23, 'SQLSTATE[42000]: Syntax error or access violation: 1064 You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near \'WHERE id_pieza = ?\' at line 4 -- 42000', 'Actualizar - Producto Img', '2021-01-04 22:40:17'),
(24, 'SQLSTATE[42S22]: Column not found: 1054 Unknown column \'type_preview\' in \'field list\' -- 42S22', 'Actualizar - Pieza Img', '2021-01-04 22:41:32'),
(25, 'SQLSTATE[42S22]: Column not found: 1054 Unknown column \'type_preview\' in \'field list\' -- 42S22', 'Actualizar - Pieza Img', '2021-01-04 22:42:38');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `juegos_ahorcado`
--

CREATE TABLE `juegos_ahorcado` (
  `id_juego` int(11) NOT NULL,
  `enunciado` varchar(255) NOT NULL,
  `respuesta` varchar(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `juegos_ahorcado`
--

INSERT INTO `juegos_ahorcado` (`id_juego`, `enunciado`, `respuesta`) VALUES
(1, 'Es un agente infeccioso microscópico acelular que solo puede reproducirse dentro de las células de otros organismos.​', 'viñus'),
(2, 'Sustancia cuya molécula está compuesta por dos átomos de hidrógeno y uno de oxígeno.​', 'agua');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `juegos_arrastrar`
--

CREATE TABLE `juegos_arrastrar` (
  `id_juego` int(11) NOT NULL,
  `enunciado` varchar(255) NOT NULL,
  `respuesta` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `juegos_arrastrar`
--

INSERT INTO `juegos_arrastrar` (`id_juego`, `enunciado`, `respuesta`) VALUES
(5, 'Sustancia cuya molécula está compuesta por dos átomos de hidrógeno y uno de oxígeno.​', 'agua'),
(10, 'Es un agente infeccioso microscópico acelular que solo puede reproducirse dentro de las células de otros organismos.​', 'virus'),
(30, 'Son microorganismos procariotas que presentan un tamaño de unos pocos micrómetros y diversas formas.​', 'bacterias'),
(43, 'Es una señal de que su cuerpo está tratando de combatir una enfermedad o infección.​​', 'fiebre');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `juegos_progreso`
--

CREATE TABLE `juegos_progreso` (
  `id_progreso` int(11) NOT NULL,
  `nombre_juego` varchar(30) NOT NULL,
  `id_juego` varchar(30) NOT NULL,
  `usuario` varchar(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `juegos_progreso`
--

INSERT INTO `juegos_progreso` (`id_progreso`, `nombre_juego`, `id_juego`, `usuario`) VALUES
(8, 'juego_arrastrar', '5', 'admin'),
(9, 'juego_arrastrar', '10', 'admin');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `juegos_vf`
--

CREATE TABLE `juegos_vf` (
  `id_juego_vf` varchar(30) NOT NULL,
  `titulo` varchar(30) NOT NULL,
  `fecha` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lugares`
--

CREATE TABLE `lugares` (
  `id_lugar` varchar(30) NOT NULL,
  `titulo` varchar(30) NOT NULL,
  `descripcion` text NOT NULL,
  `latitud` varchar(30) NOT NULL,
  `longitud` varchar(30) NOT NULL,
  `fecha` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `lugares`
--

INSERT INTO `lugares` (`id_lugar`, `titulo`, `descripcion`, `latitud`, `longitud`, `fecha`) VALUES
('LU5ff3ea1c239e03.83150960', 'Pieza de barro', '', '0.7166280533356308', '-77.71955535318524', '2021-01-04 23:24:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `multimedia_lugares`
--

CREATE TABLE `multimedia_lugares` (
  `id_multimedia` int(11) NOT NULL,
  `id_lugar` varchar(30) NOT NULL,
  `url` mediumtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `multimedia_lugares`
--

INSERT INTO `multimedia_lugares` (`id_multimedia`, `id_lugar`, `url`) VALUES
(11, 'LU5ff3ea1c239e03.83150960', 'http://localhost/museo/static/multimedia/lugares/LU5ff3ea1c239e03.83150960/r2.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `multimedia_noticias`
--

CREATE TABLE `multimedia_noticias` (
  `id_multimedia` int(11) NOT NULL,
  `id_noticia` varchar(30) NOT NULL,
  `url` mediumtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `multimedia_noticias`
--

INSERT INTO `multimedia_noticias` (`id_multimedia`, `id_noticia`, `url`) VALUES
(15, 'NT5ff339f492ffc1.65281958', 'http://localhost/museo/static/multimedia/noticias/NT5ff339f492ffc1.65281958/2.png'),
(16, 'NT5ff33c4706c076.97888277', 'http://localhost/museo/static/multimedia/noticias/NT5ff33c4706c076.97888277/2.png'),
(17, 'NT5ff341cef209f9.56506469', 'http://localhost/museo/static/multimedia/noticias/NT5ff341cef209f9.56506469/2.image/jpeg'),
(18, 'NT5ff342cfc07ce3.21676483', 'http://localhost/museo/static/multimedia/noticias/NT5ff342cfc07ce3.21676483/2.png'),
(19, 'NT5ff342f3f25692.14294138', 'http://localhost/museo/static/multimedia/noticias/NT5ff342f3f25692.14294138/2.png'),
(20, 'NT5ff343346a5ff7.60623812', 'http://localhost/museo/static/multimedia/noticias/NT5ff343346a5ff7.60623812/2.png'),
(21, 'NT5ff344115681e7.56086941', 'http://localhost/museo/static/multimedia/noticias/NT5ff344115681e7.56086941/2.'),
(22, 'NT5ff34420cfe0f7.04556251', 'http://localhost/museo/static/multimedia/noticias/NT5ff34420cfe0f7.04556251/2.jpg'),
(23, 'NT5ff345643ce2f6.96413837', 'http://localhost/museo/static/multimedia/noticias/NT5ff345643ce2f6.96413837/2.jpg'),
(24, 'NT5ff34602364601.34065436', 'http://localhost/museo/static/multimedia/noticias/NT5ff34602364601.34065436/3.png'),
(25, 'NT5ff34626936b13.53140448', 'http://localhost/museo/static/multimedia/noticias/NT5ff34626936b13.53140448/3.png'),
(26, 'NT5ff3465fabae03.23936066', 'http://localhost/museo/static/multimedia/noticias/NT5ff3465fabae03.23936066/2.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `multimedia_piezas`
--

CREATE TABLE `multimedia_piezas` (
  `id_multimedia` int(11) NOT NULL,
  `id_pieza` varchar(30) NOT NULL,
  `url` mediumtext NOT NULL,
  `tipo` char(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `multimedia_piezas`
--

INSERT INTO `multimedia_piezas` (`id_multimedia`, `id_pieza`, `url`, `tipo`) VALUES
(18, 'PZ5ffbc96e9135c0.54640290', 'http://localhost/museo/static/multimedia/piezas/PZ5ffbc96e9135c0.54640290/1.jpg', 'image'),
(19, 'PZ5ffbc96e9135c0.54640290', 'http://localhost/museo/static/multimedia/piezas/PZ5ffbc96e9135c0.54640290/2.jpg', 'image');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `multimedia_publicaciones`
--

CREATE TABLE `multimedia_publicaciones` (
  `id_multimedia` int(11) NOT NULL,
  `id_publicacion` varchar(30) NOT NULL,
  `url` mediumtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `multimedia_publicaciones`
--

INSERT INTO `multimedia_publicaciones` (`id_multimedia`, `id_publicacion`, `url`) VALUES
(35, 'PB5ff3e595540133.80585041', 'http://localhost/museo/static/multimedia/publicaciones/PB5ff3e595540133.80585041/2.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `municipios`
--

CREATE TABLE `municipios` (
  `id_municpio` int(11) NOT NULL,
  `municipio` varchar(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `municipios`
--

INSERT INTO `municipios` (`id_municpio`, `municipio`) VALUES
(1, 'arboleda'),
(2, 'tumaco'),
(3, 'la tola'),
(4, 'san bernardo'),
(5, 'san pablo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `noticias`
--

CREATE TABLE `noticias` (
  `id_noticia` varchar(30) NOT NULL,
  `titulo` varchar(500) NOT NULL,
  `descripcion` mediumtext NOT NULL,
  `foto_principal` text NOT NULL,
  `fecha` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `noticias`
--

INSERT INTO `noticias` (`id_noticia`, `titulo`, `descripcion`, `foto_principal`, `fecha`) VALUES
('NT5ff33954b2de65.67978919', 'dsaas', '<p>dasd<br></p>', '', '2021-01-04 10:50:44'),
('NT5ff339a49e2f79.54827504', 'd', '<p>sdds<br></p>', '', '2021-01-04 10:52:04'),
('NT5ff339f492ffc1.65281958', '2', '<p>2<br></p>', '', '2021-01-04 10:53:24'),
('NT5ff33c4706c076.97888277', '', '', '', '2021-01-04 11:03:19'),
('NT5ff341cef209f9.56506469', '', '', '', '2021-01-04 11:26:54'),
('NT5ff342cfc07ce3.21676483', '', '', '', '2021-01-04 11:31:11'),
('NT5ff342f3f25692.14294138', '', '', '', '2021-01-04 11:31:47'),
('NT5ff343346a5ff7.60623812', '', '', '', '2021-01-04 11:32:52'),
('NT5ff344115681e7.56086941', '', '', '', '2021-01-04 11:36:33'),
('NT5ff34420cfe0f7.04556251', '', '', '', '2021-01-04 11:36:48'),
('NT5ff345643ce2f6.96413837', '', '', '', '2021-01-04 11:42:12'),
('NT5ff34602364601.34065436', '', '', '', '2021-01-04 11:44:50'),
('NT5ff34626936b13.53140448', '', '', '', '2021-01-04 11:45:26'),
('NT5ff3465fabae03.23936066', '', '', 'http://localhost/museo/static/multimedia/noticias/NT5ff3465fabae03.23936066/2_preview.jpg', '2021-01-04 11:46:23');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `piezas`
--

CREATE TABLE `piezas` (
  `id_pieza` varchar(30) NOT NULL,
  `titulo` varchar(30) NOT NULL,
  `categoria` varchar(30) NOT NULL,
  `descripcion` mediumtext NOT NULL,
  `preview` text NOT NULL,
  `tipo_preview` char(9) NOT NULL,
  `fecha_pub` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `piezas`
--

INSERT INTO `piezas` (`id_pieza`, `titulo`, `categoria`, `descripcion`, `preview`, `tipo_preview`, `fecha_pub`) VALUES
('PZ5ffbc96e9135c0.54640290', 'das', 'Estatuaria en Piedra', '2', 'http://localhost/museo/static/multimedia/piezas/PZ5ffbc96e9135c0.54640290/1_preview.jpg', 'image', '2021-01-10 22:43:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `preguntas_juegos_vf`
--

CREATE TABLE `preguntas_juegos_vf` (
  `id_pregunta` int(11) NOT NULL,
  `id_juego_vf` varchar(30) NOT NULL,
  `pregunta` varchar(500) NOT NULL,
  `respuesta` varchar(10) NOT NULL,
  `url` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prueba`
--

CREATE TABLE `prueba` (
  `id` int(11) NOT NULL,
  `sadas` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `publicaciones`
--

CREATE TABLE `publicaciones` (
  `id_publicacion` varchar(30) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `descripcion` mediumtext NOT NULL,
  `preview` text NOT NULL,
  `fecha_pub` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `publicaciones`
--

INSERT INTO `publicaciones` (`id_publicacion`, `titulo`, `descripcion`, `preview`, `fecha_pub`) VALUES
('PB5ff3e595540133.80585041', '', '', 'http://localhost/museo/static/multimedia/publicaciones/PB5ff3e595540133.80585041/2_preview.jpg', '2021-01-04 23:05:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `correo` varchar(60) NOT NULL,
  `nombres` varchar(80) NOT NULL,
  `usuario` varchar(40) NOT NULL,
  `password` mediumtext NOT NULL,
  `tipo_usuario` varchar(20) NOT NULL,
  `municipio` varchar(80) NOT NULL,
  `img_preview` text NOT NULL,
  `img_usuario` text NOT NULL,
  `codigo` varchar(30) NOT NULL,
  `fecha_codigo` datetime NOT NULL,
  `carpeta_usuario` varchar(30) NOT NULL,
  `estado_juego_arrastrar` char(1) NOT NULL,
  `estado_juego_ahorcado` char(1) NOT NULL,
  `estado_juego_vf` char(1) NOT NULL,
  `estado` char(1) NOT NULL,
  `fecha_reg` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`correo`, `nombres`, `usuario`, `password`, `tipo_usuario`, `municipio`, `img_preview`, `img_usuario`, `codigo`, `fecha_codigo`, `carpeta_usuario`, `estado_juego_arrastrar`, `estado_juego_ahorcado`, `estado_juego_vf`, `estado`, `fecha_reg`) VALUES
('jesusburbanob10@gmail.com', '', '', '', 'general', '', 'http://localhost/museo/static/multimedia/usuarios/US5f800a91a0dd97.50929827/web-1935737_1920_1.png', 'http://localhost/museo/static/multimedia/usuarios/US5f800a91a0dd97.50929827/web-1935737_1920.png', '1602226834AaZRgCHX', '2020-10-10 01:55:00', 'US5f800a91a0dd97.50929827', 'D', 'D', 'D', 'A', '2020-10-09 01:55:00'),
('lifebest130@gmail.com', '', 'erewr', '$2y$10$/ycXSRXQMdI/289NlKkRqeuIvEZQDyKhhdTtnQAMKWc2NOqIQVnUq', 'general', '', 'http://localhost/museo/static/multimedia/usuarios/US5f8d1e299c5217.76898079/WhatsApp Image 2020-09-28 at 10.05.40 PM_1.jpg', 'http://localhost/museo/static/multimedia/usuarios/US5f8d1e299c5217.76898079/WhatsApp Image 2020-09-28 at 10.05.40 PM.jpg', '1603083818ZJfCKQbS', '2020-10-20 00:03:00', 'US5f8d1e299c5217.76898079', 'D', 'D', 'D', 'D', '2020-10-19 00:03:00'),
('museoberruecos@gmail.com', 'Jesus Alejandro Burbano', 'admin', '$2y$10$vNg3hTB8yCMmIPR.m33ssOHmXKF589FSaHgvQ.c39Z3ULwzVlRbxS', 'administrador', '', 'http://localhost/museo/static/multimedia/usuarios/admin/1_1.jpg', 'http://localhost/museo/static/multimedia/usuarios/admin/1.jpg', '1602123722KHEDabOS', '2020-10-08 21:19:00', 'admin', 'D', 'A', 'A', 'A', '2020-10-07 21:19:00');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `debug`
--
ALTER TABLE `debug`
  ADD PRIMARY KEY (`id_debug`);

--
-- Indices de la tabla `juegos_ahorcado`
--
ALTER TABLE `juegos_ahorcado`
  ADD PRIMARY KEY (`id_juego`);

--
-- Indices de la tabla `juegos_arrastrar`
--
ALTER TABLE `juegos_arrastrar`
  ADD PRIMARY KEY (`id_juego`);

--
-- Indices de la tabla `juegos_progreso`
--
ALTER TABLE `juegos_progreso`
  ADD PRIMARY KEY (`id_progreso`),
  ADD KEY `usuario` (`usuario`);

--
-- Indices de la tabla `juegos_vf`
--
ALTER TABLE `juegos_vf`
  ADD PRIMARY KEY (`id_juego_vf`);

--
-- Indices de la tabla `lugares`
--
ALTER TABLE `lugares`
  ADD PRIMARY KEY (`id_lugar`);

--
-- Indices de la tabla `multimedia_lugares`
--
ALTER TABLE `multimedia_lugares`
  ADD PRIMARY KEY (`id_multimedia`),
  ADD KEY `id_lugar` (`id_lugar`);

--
-- Indices de la tabla `multimedia_noticias`
--
ALTER TABLE `multimedia_noticias`
  ADD PRIMARY KEY (`id_multimedia`),
  ADD KEY `id_noticia` (`id_noticia`);

--
-- Indices de la tabla `multimedia_piezas`
--
ALTER TABLE `multimedia_piezas`
  ADD PRIMARY KEY (`id_multimedia`),
  ADD KEY `id_pieza` (`id_pieza`);

--
-- Indices de la tabla `multimedia_publicaciones`
--
ALTER TABLE `multimedia_publicaciones`
  ADD PRIMARY KEY (`id_multimedia`),
  ADD KEY `id_publicacion` (`id_publicacion`);

--
-- Indices de la tabla `municipios`
--
ALTER TABLE `municipios`
  ADD PRIMARY KEY (`id_municpio`);

--
-- Indices de la tabla `noticias`
--
ALTER TABLE `noticias`
  ADD PRIMARY KEY (`id_noticia`);

--
-- Indices de la tabla `piezas`
--
ALTER TABLE `piezas`
  ADD PRIMARY KEY (`id_pieza`);

--
-- Indices de la tabla `preguntas_juegos_vf`
--
ALTER TABLE `preguntas_juegos_vf`
  ADD PRIMARY KEY (`id_pregunta`),
  ADD KEY `id_juego_vf` (`id_juego_vf`);

--
-- Indices de la tabla `prueba`
--
ALTER TABLE `prueba`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `publicaciones`
--
ALTER TABLE `publicaciones`
  ADD PRIMARY KEY (`id_publicacion`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`correo`),
  ADD UNIQUE KEY `usuario` (`usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `debug`
--
ALTER TABLE `debug`
  MODIFY `id_debug` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de la tabla `juegos_ahorcado`
--
ALTER TABLE `juegos_ahorcado`
  MODIFY `id_juego` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `juegos_arrastrar`
--
ALTER TABLE `juegos_arrastrar`
  MODIFY `id_juego` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT de la tabla `juegos_progreso`
--
ALTER TABLE `juegos_progreso`
  MODIFY `id_progreso` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `multimedia_lugares`
--
ALTER TABLE `multimedia_lugares`
  MODIFY `id_multimedia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `multimedia_noticias`
--
ALTER TABLE `multimedia_noticias`
  MODIFY `id_multimedia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT de la tabla `multimedia_piezas`
--
ALTER TABLE `multimedia_piezas`
  MODIFY `id_multimedia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de la tabla `multimedia_publicaciones`
--
ALTER TABLE `multimedia_publicaciones`
  MODIFY `id_multimedia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT de la tabla `municipios`
--
ALTER TABLE `municipios`
  MODIFY `id_municpio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `preguntas_juegos_vf`
--
ALTER TABLE `preguntas_juegos_vf`
  MODIFY `id_pregunta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT de la tabla `prueba`
--
ALTER TABLE `prueba`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `juegos_progreso`
--
ALTER TABLE `juegos_progreso`
  ADD CONSTRAINT `juegos_progreso_ibfk_2` FOREIGN KEY (`usuario`) REFERENCES `usuarios` (`usuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `multimedia_lugares`
--
ALTER TABLE `multimedia_lugares`
  ADD CONSTRAINT `multimedia_lugares_ibfk_2` FOREIGN KEY (`id_lugar`) REFERENCES `lugares` (`id_lugar`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `multimedia_noticias`
--
ALTER TABLE `multimedia_noticias`
  ADD CONSTRAINT `multimedia_noticias_ibfk_2` FOREIGN KEY (`id_noticia`) REFERENCES `noticias` (`id_noticia`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `multimedia_piezas`
--
ALTER TABLE `multimedia_piezas`
  ADD CONSTRAINT `multimedia_piezas_ibfk_2` FOREIGN KEY (`id_pieza`) REFERENCES `piezas` (`id_pieza`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `multimedia_publicaciones`
--
ALTER TABLE `multimedia_publicaciones`
  ADD CONSTRAINT `multimedia_publicaciones_ibfk_2` FOREIGN KEY (`id_publicacion`) REFERENCES `publicaciones` (`id_publicacion`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `preguntas_juegos_vf`
--
ALTER TABLE `preguntas_juegos_vf`
  ADD CONSTRAINT `preguntas_juegos_vf_ibfk_2` FOREIGN KEY (`id_juego_vf`) REFERENCES `juegos_vf` (`id_juego_vf`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
