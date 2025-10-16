-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 05-12-2024 a las 20:54:18
-- Versión del servidor: 10.6.20-MariaDB
-- Versión de PHP: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `grupocod_bdiacym`
--

DELIMITER $$
--
-- Procedimientos
--
CREATE DEFINER=`grupocod`@`localhost` PROCEDURE `ObtenerDatosSeguimiento` ()   BEGIN
    SELECT 
        s.fecha_contacto, 
        c.nombre AS celula_nombre, 
        a.nombre AS asistente_nombre, 
        a.apellido AS asistente_apellido, 
        s.oracion
    FROM 
        seguimiento s
    JOIN 
        celulas c ON s.celula_id = c.id
    JOIN 
        asistentes a ON s.asistente_id = a.id
    WHERE 
        s.created_at >= NOW() - INTERVAL 14 DAY
    ORDER BY 
        s.created_at DESC
    LIMIT 30;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `aniversarios`
--

CREATE TABLE `aniversarios` (
  `id` bigint(11) NOT NULL,
  `nombre` varchar(250) NOT NULL,
  `celula_id` int(11) NOT NULL,
  `tel` varchar(250) DEFAULT NULL,
  `foto` varchar(250) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `aniversarios`
--

INSERT INTO `aniversarios` (`id`, `nombre`, `celula_id`, `tel`, `foto`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Daniela Fuentes Rivera Villarreal', 10, '977808469', NULL, '2024-09-28 21:15:44', NULL, NULL),
(2, 'Belen Llanos', 9, '955794014', NULL, '2024-09-28 21:54:56', NULL, '2024-09-30 12:36:14'),
(3, 'Sebastian Vasquez', 1, '912658531', NULL, '2024-09-28 21:55:28', NULL, NULL),
(4, 'RUTH BOTETANO LEYVA', 6, '916890693', NULL, '2024-09-28 23:06:07', NULL, NULL),
(5, 'Rosa Cubillas Ubaldo', 9, '994253333', NULL, '2024-09-29 02:40:19', NULL, NULL),
(6, 'Rosa Cubillas Ubaldo', 9, '994253333', NULL, '2024-09-29 02:40:20', NULL, '2024-09-30 10:26:01'),
(7, 'Jireh Ferroa Guzmán', 3, '986929544', 'uploads/fotos/X2QV_66fae0b79ed12.jpg', '2024-09-30 17:32:39', NULL, NULL),
(8, 'Belen Llanos', 9, '955794014', 'uploads/fotos/B5FM_66fae10ce6f98.jpg', '2024-09-30 17:34:04', NULL, NULL),
(9, 'Juan Carlos Galiano', 8, '953863697', 'uploads/fotos/ATV3_66fae30ae03f9.jpg', '2024-09-30 17:42:34', NULL, NULL),
(10, 'Dannette Romero', 2, '936995788', NULL, '2024-09-30 17:42:58', NULL, '2024-10-02 07:58:51'),
(11, 'Luis Santiago Roque Machuca', 3, '921503048', 'uploads/fotos/UVS0_66fae3d2d2eb7.png', '2024-09-30 17:45:54', NULL, NULL),
(12, 'Mariajose Flores Del Pino', 7, '954831441', 'uploads/fotos/V1JB_66fae4ad95921.jpg', '2024-09-30 17:49:33', NULL, NULL),
(13, 'Jesus Aaron Arica Duque', 1, '942961887', 'uploads/fotos/VUWB_66fae6e750b8b.jpeg', '2024-09-30 17:59:03', NULL, NULL),
(14, 'Adrian Sifuentes Chavez', 1, '947848502', 'uploads/fotos/X0KK_66fae7fa9c943.jpg', '2024-09-30 18:03:38', NULL, NULL),
(15, 'Jonatan Rodríguez Espinoza', 3, '902008867', 'uploads/fotos/NVTC_66fae805cbc4f.png', '2024-09-30 18:03:49', NULL, NULL),
(16, 'Miguel Angel Ramon Porras', 3, '936268840', 'uploads/fotos/yapemiguel.jpg', '2024-09-30 18:09:59', NULL, NULL),
(17, 'Lucerito Flores', 5, '986134857', 'uploads/fotos/yapelucerito.jpg', '2024-09-30 18:11:22', NULL, NULL),
(18, 'prueba', 10, '987654321', 'uploads/fotos/3HU2_66faea19c77bf.png', '2024-09-30 18:12:41', NULL, '2024-09-30 13:19:24'),
(19, 'Juan De La Portilla', 4, '980 906 851', 'uploads/fotos/SMUZ_66faeb529efb8.jpg', '2024-09-30 18:17:54', NULL, NULL),
(20, 'prueba2', 1, 'a987654321', NULL, '2024-09-30 18:17:56', NULL, '2024-09-30 13:19:17'),
(21, 'Gabriela Chavez Vela', 5, '902795708', 'uploads/fotos/JKOP_66faec61aafd9.jpg', '2024-09-30 18:22:25', NULL, NULL),
(22, 'John Antonio Trujillo Cristobal', 4, '963 319 211', 'uploads/fotos/7N8Y_66faf0049dd7d.jpg', '2024-09-30 18:37:56', NULL, NULL),
(23, 'Cristhian Velasquez Azabache', 10, '980902508', 'uploads/fotos/RNUR_66fb0457d84c8.jpeg', '2024-09-30 20:04:39', NULL, NULL),
(24, 'Marygrace Tayro', 5, '980897365', NULL, '2024-09-30 20:40:23', NULL, NULL),
(25, 'Yireh Andrea Rodríguez Espinoza', 5, '946 643 875', 'uploads/fotos/PVTA_66fb6752c6381.jpg', '2024-10-01 03:06:58', NULL, NULL),
(26, 'Nataly Tolentino', 5, '952406032', 'uploads/fotos/86WD_66fb710293f8e.jpeg', '2024-10-01 03:48:18', NULL, NULL),
(27, 'Fiorella Lazo Garcia', 6, '928593505', 'uploads/fotos/KZRX_66fb710f49f4e.jpg', '2024-10-01 03:48:31', NULL, NULL),
(28, 'Adrian Ilie Argumedo Zuñiga', 8, '989178031', 'uploads/fotos/ZMFX_66fb75053a974.jpeg', '2024-10-01 04:05:25', NULL, NULL),
(29, 'Graciela Cecilia Becerra Alarcón', 7, '925732514', 'uploads/fotos/40RB_66fb761a9dbc8.jpg', '2024-10-01 04:10:02', NULL, '2024-10-01 12:43:40'),
(30, 'Graciela Cecilia Becerra Alarcón', 7, '925732514', 'uploads/fotos/J9LQ_66fb7661c8d6c.jpg', '2024-10-01 04:11:13', NULL, NULL),
(31, 'Isaac Rojas Aguirre', 8, '977 400 519', 'uploads/fotos/TBVD_66fb84026d72b.png', '2024-10-01 05:09:22', NULL, NULL),
(32, 'Dannette Romero Inocente', 2, '936995788', 'uploads/fotos/DXY7_66fc8777cf80b.jpg', '2024-10-01 23:36:23', NULL, NULL),
(33, 'Celeste Esmeralda Velasquez Maravi', 6, '923968826', 'uploads/fotos/4I6D_66fccfd42a4de.jpeg', '2024-10-02 04:45:08', NULL, NULL),
(34, 'Ysrael Pereira', 1, '994282995', NULL, '2024-10-02 14:34:04', NULL, NULL),
(35, 'JUAN JOSÉ SANTIAGO ATOCHE', 1, '939284163', 'uploads/fotos/V6BD_66fd5d128f2e7.jpg', '2024-10-02 14:47:46', NULL, NULL),
(36, 'AARON MORENO', 3, '912502878', 'uploads/fotos/CN44_66fd6c4688257.jpg', '2024-10-02 15:52:38', NULL, NULL),
(37, 'Claudia Flores Torres', 6, '945825616', 'uploads/fotos/RWNH_66fda53772b55.jpg', '2024-10-02 19:55:35', NULL, NULL),
(38, 'Jhon Adrianzen Alberto', 10, '995403312', 'uploads/fotos/AQ9Y_66fdcaf37dfa1.png', '2024-10-02 22:36:35', NULL, NULL),
(39, 'Beatriz Nicole Gonzaga Ascoy', 6, '992091694', 'uploads/fotos/TMTZ_66fece1d02136.jpg', '2024-10-03 17:02:21', NULL, NULL),
(40, 'Emerson Otiniano Calixto', 3, '922303115', 'uploads/fotos/QB0X_66fed5b6a2298.jpg', '2024-10-03 17:34:46', NULL, NULL),
(41, 'David Elías Moreno Quispe', 1, '990731954', NULL, '2024-10-03 21:35:51', NULL, NULL),
(42, 'Fiorella Figueroa Rengifo', 7, '940786357', 'uploads/fotos/LH6U_66ff3b9c6a106.jpg', '2024-10-04 00:49:32', NULL, NULL),
(43, 'Josbeli Michelangeli', 2, '903295363', NULL, '2024-10-04 02:17:54', NULL, NULL),
(44, 'Gerson Alex Jesús Yache', 3, '961 861 302', 'uploads/fotos/Z1VL_66ff5a56b9887.jpg', '2024-10-04 03:00:38', NULL, NULL),
(45, 'Johan Samir Jesús Yache', 3, '986296835', 'uploads/fotos/EVDD_66ff5d46c0404.jpg', '2024-10-04 03:13:10', NULL, NULL),
(46, 'José Fabricio Campo Carrion', 3, '951274462', 'uploads/fotos/yapefabricio.jpg', '2024-10-04 03:31:22', NULL, NULL),
(47, 'Anyeli Carhuaricra Caramantin', 6, '914447613', 'uploads/fotos/283I_670007ec76a47.png', '2024-10-04 15:21:16', NULL, NULL),
(48, 'Eliazar Robles', 8, '950785203', 'uploads/fotos/O2CN_67000aa02c0bb.jpeg', '2024-10-04 15:32:48', NULL, NULL),
(49, 'Eliazar Robles', 8, '950785203', 'uploads/fotos/J2FT_67002cacc3043.jpg', '2024-10-04 17:58:04', NULL, '2024-10-04 14:20:44'),
(50, 'Jose Daniel Castro Barreto', 10, '910725178', 'uploads/fotos/OJCK_670039489b04d.jpg', '2024-10-04 18:51:52', NULL, NULL),
(51, 'Angeles Alexandra Rodas Ibañez', 6, '910725178', 'uploads/fotos/RTNP_67003a1b27618.jpg', '2024-10-04 18:55:23', NULL, NULL),
(52, 'Margiorie Cabrera Villanueva', 6, '984169579', 'uploads/fotos/BXS6_670089111e40a.jpeg', '2024-10-05 00:32:17', NULL, NULL),
(53, 'Paula Santillana', 2, '934138983', NULL, '2024-10-05 00:48:02', NULL, NULL),
(54, 'Mia Barbarán', 5, '936340632', 'uploads/fotos/6MUO_67008e00977c1.jpg', '2024-10-05 00:53:20', NULL, NULL),
(55, 'Angel Barbaran', 4, '954267465', 'uploads/fotos/7TGT_67008e220f4e7.jpg', '2024-10-05 00:53:54', NULL, NULL),
(56, 'Argumedo Zuñiga Danilo Rodrigo', 8, '989097550', 'uploads/fotos/JGHR_670092a838bc4.jpeg', '2024-10-05 01:13:12', NULL, NULL),
(57, 'Madelley Salirrosas', 7, '960760258', NULL, '2024-10-05 01:56:03', NULL, NULL),
(58, 'Damarys Celeste Suarez Espinoza', 7, '975551666', NULL, '2024-10-05 01:57:22', NULL, NULL),
(59, 'Angela Brighit Salirrosas Chinchay', 2, '933787134', NULL, '2024-10-05 02:00:23', NULL, NULL),
(60, 'Selena Dextre Rojas', 2, '918761524', NULL, '2024-10-05 02:06:38', NULL, NULL),
(61, 'Rut Belén García Moreno', 5, '988470309', NULL, '2024-10-05 02:27:11', NULL, NULL),
(62, 'Leyla Sumacc Suncco Sulca Gutierrez', 10, '963402510', NULL, '2024-10-05 02:29:48', NULL, NULL),
(63, 'Josbeli y rosibel', 2, '+51 903 295 363', 'uploads/fotos/BOYZ_6700a4e1b05c5.jpg', '2024-10-05 02:30:57', NULL, NULL),
(64, 'Sebastian Rubén Malpartida Pacheco', 3, '989673332', 'uploads/fotos/SEHH_6700a88084469.jpg', '2024-10-05 02:46:24', NULL, NULL),
(65, 'José Walter Córdova durand', 3, '981406241', 'uploads/fotos/6KVD_6700aa9d1b715.jpg', '2024-10-05 02:55:25', NULL, NULL),
(66, 'Belén Saldarriaga Gómez', 9, '994329582', 'uploads/fotos/M6OF_6700b437b2465.jpg', '2024-10-05 03:36:23', NULL, NULL),
(67, 'Marlon Quiroz Ordaya', 10, '946 869 859', 'uploads/fotos/U0NW_6700b5eba1957.jpg', '2024-10-05 03:43:39', NULL, NULL),
(68, 'Ariana Saldarriaga Gómez', 5, '954 127 755', 'uploads/fotos/GJ8R_6700b71c3f923.jpg', '2024-10-05 03:48:44', NULL, NULL),
(69, 'Jerry Caramantin villanueva', 8, '0', 'uploads/fotos/VSKM_67012264044cf.jpg', '2024-10-05 11:26:28', NULL, NULL),
(70, 'Isaías Yzhar Robles Olguín', 8, '942332236', 'uploads/fotos/LMIH_670165c079531.png', '2024-10-05 16:13:52', NULL, NULL),
(71, 'Bruno Stephano Rodríguez Incio', 4, '982244920', 'uploads/fotos/QLP4_67016c41ed6df.png', '2024-10-05 16:41:37', NULL, NULL),
(72, 'David García Moreno', 4, '932068558', 'uploads/fotos/54OD_67016d0b0b116.png', '2024-10-05 16:44:59', NULL, NULL),
(73, 'Aarón García', 4, '922288684', 'uploads/fotos/YSN8_670182b498f01.jpg', '2024-10-05 18:17:24', NULL, NULL),
(74, 'Dustin Flavio Campos Loyola', 4, '939835546', NULL, '2024-10-05 18:46:46', NULL, NULL),
(75, 'Daniela Fuentes Rivera Villarreal', 10, '977808469', NULL, '2024-10-05 22:02:39', NULL, NULL),
(76, 'Eliú Gerardo Becerra Alarcón', 10, '920516060', 'uploads/fotos/IHEV_6701b8195959f.jpeg', '2024-10-05 22:05:13', NULL, NULL),
(77, 'Fabián Abel Rosario Pérez', 10, '+51 983 705 004', 'uploads/fotos/8JUN_6701d1932c24c.jpg', '2024-10-05 23:53:55', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asistencias`
--

CREATE TABLE `asistencias` (
  `id` bigint(11) NOT NULL,
  `programa_id` int(11) NOT NULL,
  `fecha_registro` varchar(50) NOT NULL,
  `celula_id` int(11) NOT NULL,
  `asistente_id` int(11) NOT NULL,
  `estado` varchar(50) NOT NULL,
  `motivo` varchar(255) DEFAULT NULL,
  `id_user` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `asistencias`
--

INSERT INTO `asistencias` (`id`, `programa_id`, `fecha_registro`, `celula_id`, `asistente_id`, `estado`, `motivo`, `id_user`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 3, '2024-09-28', 9, 8, 'presente', NULL, 3, '2024-09-29 02:34:46', NULL, NULL),
(2, 3, '2024-09-28', 9, 9, 'presente', NULL, 3, '2024-09-29 02:34:46', NULL, NULL),
(3, 3, '2024-09-28', 9, 37, 'presente', NULL, 3, '2024-09-29 02:34:46', NULL, NULL),
(4, 3, '2024-09-28', 9, 40, 'presente', NULL, 3, '2024-09-29 02:34:46', NULL, NULL),
(5, 3, '2024-09-28', 1, 1, 'presente', NULL, 1, '2024-09-29 04:33:39', NULL, NULL),
(6, 3, '2024-09-28', 1, 3, 'presente', NULL, 1, '2024-09-29 04:33:39', NULL, NULL),
(7, 3, '2024-09-28', 1, 4, 'presente', NULL, 1, '2024-09-29 04:33:39', NULL, NULL),
(8, 3, '2024-09-28', 1, 24, 'presente', NULL, 1, '2024-09-29 04:33:39', NULL, NULL),
(9, 3, '2024-09-28', 1, 6, 'justificado', 'Motivo de trabajo no pudo asistir', 1, '2024-09-29 04:34:11', NULL, NULL),
(10, 3, '2024-09-28', 1, 5, 'justificado', 'Motivo de trabajo', 1, '2024-09-29 04:34:55', NULL, NULL),
(11, 3, '2024-09-28', 1, 2, 'ausente', NULL, 1, '2024-09-29 04:35:14', NULL, NULL),
(12, 3, '2024-09-28', 2, 20, 'presente', NULL, 7, '2024-09-29 16:20:19', NULL, NULL),
(13, 3, '2024-09-28', 2, 21, 'presente', NULL, 7, '2024-09-29 16:20:19', NULL, NULL),
(14, 3, '2024-09-28', 2, 42, 'presente', NULL, 7, '2024-09-29 16:20:19', NULL, NULL),
(15, 3, '2024-09-28', 3, 38, 'presente', NULL, 8, '2024-09-29 16:27:38', NULL, NULL),
(16, 3, '2024-09-28', 3, 44, 'presente', NULL, 8, '2024-09-29 16:27:38', NULL, NULL),
(17, 3, '2024-09-28', 3, 45, 'presente', NULL, 8, '2024-09-29 16:27:38', NULL, NULL),
(18, 3, '2024-09-28', 3, 46, 'presente', NULL, 8, '2024-09-29 16:27:38', NULL, NULL),
(19, 3, '2024-09-28', 3, 47, 'presente', NULL, 8, '2024-09-29 16:27:38', NULL, NULL),
(20, 3, '2024-09-28', 3, 48, 'justificado', 'Tráfico', 8, '2024-09-29 16:32:00', NULL, NULL),
(21, 3, '2024-09-28', 5, 49, 'presente', NULL, 6, '2024-09-30 03:19:22', NULL, NULL),
(22, 3, '2024-09-28', 5, 50, 'presente', NULL, 6, '2024-09-30 03:19:22', NULL, NULL),
(23, 3, '2024-09-28', 5, 51, 'presente', NULL, 6, '2024-09-30 03:19:22', NULL, NULL),
(24, 3, '2024-09-28', 2, 18, 'justificado', 'Estudios, Salud y trabajo.', 7, '2024-09-30 14:54:21', NULL, NULL),
(25, 3, '2024-09-28', 2, 19, 'justificado', 'Estudios, Salud y trabajo.', 7, '2024-09-30 14:54:21', NULL, NULL),
(26, 3, '2024-09-28', 2, 22, 'justificado', 'Estudios, Salud y trabajo.', 7, '2024-09-30 14:54:21', NULL, NULL),
(27, 3, '2024-09-28', 2, 23, 'justificado', 'Estudios, Salud y trabajo.', 7, '2024-09-30 14:54:21', NULL, NULL),
(28, 3, '2024-09-28', 2, 41, 'justificado', 'Estudios, Salud y trabajo.', 7, '2024-09-30 14:54:21', NULL, NULL),
(29, 3, '2024-09-28', 9, 11, 'justificado', 'Viaje', 3, '2024-09-30 23:27:50', NULL, NULL),
(30, 2, '2024-10-05', 1, 1, 'presente', NULL, 1, '2024-10-07 13:27:04', NULL, NULL),
(31, 2, '2024-10-05', 1, 4, 'presente', NULL, 1, '2024-10-07 13:27:04', NULL, NULL),
(32, 2, '2024-10-05', 1, 6, 'presente', NULL, 1, '2024-10-07 13:27:04', NULL, NULL),
(33, 2, '2024-10-05', 1, 24, 'presente', NULL, 1, '2024-10-07 13:27:04', NULL, NULL),
(34, 2, '2024-10-05', 1, 36, 'presente', NULL, 1, '2024-10-07 13:27:04', NULL, NULL),
(35, 2, '2024-10-05', 2, 20, 'presente', NULL, 7, '2024-10-07 17:28:58', NULL, NULL),
(36, 2, '2024-10-05', 2, 21, 'presente', NULL, 7, '2024-10-07 17:28:58', NULL, NULL),
(37, 2, '2024-10-05', 2, 22, 'presente', NULL, 7, '2024-10-07 17:28:58', NULL, NULL),
(38, 2, '2024-10-05', 2, 23, 'presente', NULL, 7, '2024-10-07 17:28:58', NULL, NULL),
(39, 2, '2024-10-05', 2, 42, 'presente', NULL, 7, '2024-10-07 17:28:58', NULL, NULL),
(40, 2, '2024-10-05', 2, 18, 'justificado', 'Por estudios, trabajo', 7, '2024-10-07 17:29:28', NULL, NULL),
(41, 2, '2024-10-05', 2, 19, 'justificado', 'Por estudios, trabajo', 7, '2024-10-07 17:29:28', NULL, NULL),
(42, 2, '2024-10-05', 2, 41, 'justificado', 'Por estudios, trabajo', 7, '2024-10-07 17:29:28', NULL, NULL),
(43, 2, '2024-10-05', 1, 5, 'justificado', 'Se registró para el aniversario pero se me complico asistir por motivos familiares', 1, '2024-10-07 17:47:42', NULL, NULL),
(44, 2, '2024-10-05', 1, 3, 'ausente', NULL, 1, '2024-10-07 17:47:56', NULL, NULL),
(45, 2, '2024-10-05', 5, 49, 'presente', NULL, 6, '2024-10-08 05:26:28', NULL, NULL),
(46, 2, '2024-10-05', 5, 50, 'presente', NULL, 6, '2024-10-08 05:26:28', NULL, NULL),
(47, 2, '2024-10-05', 5, 51, 'presente', NULL, 6, '2024-10-08 05:26:28', NULL, NULL),
(48, 2, '2024-10-05', 5, 55, 'presente', NULL, 6, '2024-10-08 05:26:28', NULL, NULL),
(49, 2, '2024-10-05', 5, 56, 'presente', NULL, 6, '2024-10-08 05:26:28', NULL, NULL),
(50, 2, '2024-10-05', 5, 57, 'presente', NULL, 6, '2024-10-08 05:26:28', NULL, NULL),
(51, 2, '2024-10-05', 5, 58, 'presente', NULL, 6, '2024-10-08 05:26:28', NULL, NULL),
(52, 3, '2024-09-28', 4, 26, 'presente', NULL, 9, '2024-10-11 05:36:17', NULL, NULL),
(53, 3, '2024-09-28', 4, 28, 'presente', NULL, 9, '2024-10-11 05:36:17', NULL, NULL),
(54, 3, '2024-09-28', 4, 31, 'presente', NULL, 9, '2024-10-11 05:36:17', NULL, NULL),
(55, 3, '2024-09-28', 4, 35, 'presente', NULL, 9, '2024-10-11 05:36:17', NULL, NULL),
(56, 3, '2024-09-28', 4, 59, 'presente', NULL, 9, '2024-10-11 05:36:17', NULL, NULL),
(57, 2, '2024-10-05', 4, 25, 'presente', NULL, 9, '2024-10-11 05:36:51', NULL, NULL),
(58, 2, '2024-10-05', 4, 26, 'presente', NULL, 9, '2024-10-11 05:36:51', NULL, NULL),
(59, 2, '2024-10-05', 4, 27, 'presente', NULL, 9, '2024-10-11 05:36:51', NULL, NULL),
(60, 2, '2024-10-05', 4, 28, 'presente', NULL, 9, '2024-10-11 05:36:51', NULL, NULL),
(61, 2, '2024-10-05', 4, 29, 'presente', NULL, 9, '2024-10-11 05:36:51', NULL, NULL),
(62, 2, '2024-10-05', 4, 30, 'presente', NULL, 9, '2024-10-11 05:36:51', NULL, NULL),
(63, 2, '2024-10-05', 4, 31, 'presente', NULL, 9, '2024-10-11 05:36:51', NULL, NULL),
(64, 2, '2024-10-05', 4, 32, 'presente', NULL, 9, '2024-10-11 05:36:51', NULL, NULL),
(65, 2, '2024-10-05', 4, 34, 'presente', NULL, 9, '2024-10-11 05:36:51', NULL, NULL),
(66, 2, '2024-10-05', 4, 35, 'presente', NULL, 9, '2024-10-11 05:36:51', NULL, NULL),
(67, 2, '2024-10-05', 4, 59, 'presente', NULL, 9, '2024-10-11 05:36:51', NULL, NULL),
(68, 2, '2024-10-05', 3, 38, 'presente', NULL, 8, '2024-10-11 18:25:55', NULL, NULL),
(69, 2, '2024-10-05', 3, 39, 'presente', NULL, 8, '2024-10-11 18:25:55', NULL, '2024-10-14 15:10:17'),
(70, 2, '2024-10-05', 3, 44, 'presente', NULL, 8, '2024-10-11 18:25:55', NULL, NULL),
(71, 2, '2024-10-05', 3, 45, 'presente', NULL, 8, '2024-10-11 18:25:55', NULL, NULL),
(72, 2, '2024-10-05', 3, 46, 'presente', NULL, 8, '2024-10-11 18:25:55', NULL, NULL),
(73, 2, '2024-10-05', 3, 47, 'presente', NULL, 8, '2024-10-11 18:25:55', NULL, NULL),
(74, 2, '2024-10-05', 3, 48, 'presente', NULL, 8, '2024-10-11 18:25:55', NULL, NULL),
(75, 2, '2024-10-05', 7, 12, 'presente', NULL, 4, '2024-10-11 19:19:27', NULL, NULL),
(76, 2, '2024-10-05', 7, 13, 'presente', NULL, 4, '2024-10-11 19:19:27', NULL, NULL),
(77, 2, '2024-10-05', 7, 14, 'presente', NULL, 4, '2024-10-11 19:19:27', NULL, NULL),
(78, 2, '2024-10-05', 7, 15, 'presente', NULL, 4, '2024-10-11 19:19:27', NULL, NULL),
(79, 3, '2024-09-28', 4, 27, 'ausente', NULL, 9, '2024-10-11 22:54:15', NULL, NULL),
(80, 3, '2024-09-28', 4, 32, 'ausente', NULL, 9, '2024-10-11 22:54:15', NULL, NULL),
(81, 3, '2024-09-28', 4, 33, 'ausente', NULL, 9, '2024-10-11 22:54:15', NULL, NULL),
(82, 3, '2024-09-28', 4, 34, 'ausente', NULL, 9, '2024-10-11 22:54:15', NULL, NULL),
(83, 2, '2024-10-05', 6, 52, 'presente', NULL, 5, '2024-10-12 17:23:51', NULL, NULL),
(84, 2, '2024-10-05', 6, 53, 'presente', NULL, 5, '2024-10-12 17:23:51', NULL, NULL),
(85, 2, '2024-10-05', 6, 54, 'presente', NULL, 5, '2024-10-12 17:23:51', NULL, NULL),
(86, 2, '2024-10-05', 6, 62, 'presente', NULL, 5, '2024-10-12 17:23:51', NULL, NULL),
(87, 2, '2024-10-05', 6, 63, 'presente', NULL, 5, '2024-10-12 17:23:51', NULL, NULL),
(88, 2, '2024-10-05', 6, 64, 'presente', NULL, 5, '2024-10-12 17:23:51', NULL, NULL),
(89, 3, '2024-09-28', 6, 53, 'presente', NULL, 5, '2024-10-12 17:24:50', NULL, NULL),
(90, 3, '2024-09-28', 6, 54, 'presente', NULL, 5, '2024-10-12 17:24:50', NULL, NULL),
(91, 3, '2024-09-28', 6, 63, 'presente', NULL, 5, '2024-10-12 17:24:50', NULL, NULL),
(92, 2, '2024-10-05', 9, 8, 'presente', NULL, 3, '2024-10-12 22:49:48', NULL, NULL),
(93, 2, '2024-10-05', 9, 9, 'presente', NULL, 3, '2024-10-12 22:49:48', NULL, NULL),
(94, 2, '2024-10-05', 9, 37, 'presente', NULL, 3, '2024-10-12 22:49:48', NULL, NULL),
(95, 2, '2024-10-05', 9, 40, 'presente', NULL, 3, '2024-10-12 22:49:48', NULL, NULL),
(96, 2, '2024-10-05', 9, 7, 'justificado', 'Trabajo', 3, '2024-10-12 22:50:13', NULL, NULL),
(97, 2, '2024-10-05', 9, 11, 'justificado', 'Viaje', 3, '2024-10-12 22:50:40', NULL, NULL),
(98, 2, '2024-10-05', 9, 10, 'ausente', NULL, 3, '2024-10-12 22:50:56', NULL, NULL),
(99, 5, '2024-10-12', 3, 38, 'presente', NULL, 8, '2024-10-13 02:51:54', NULL, NULL),
(100, 5, '2024-10-12', 3, 39, 'presente', NULL, 8, '2024-10-13 02:51:54', NULL, NULL),
(101, 5, '2024-10-12', 3, 44, 'presente', NULL, 8, '2024-10-13 02:51:54', NULL, '2024-10-14 15:10:11'),
(102, 5, '2024-10-12', 3, 47, 'presente', NULL, 8, '2024-10-13 02:51:54', NULL, NULL),
(103, 5, '2024-10-12', 1, 4, 'presente', NULL, 1, '2024-10-13 04:20:14', NULL, NULL),
(104, 5, '2024-10-12', 1, 24, 'presente', NULL, 1, '2024-10-13 04:20:14', NULL, NULL),
(105, 5, '2024-10-12', 1, 36, 'presente', NULL, 1, '2024-10-13 04:20:14', NULL, NULL),
(106, 5, '2024-10-12', 1, 5, 'justificado', 'Motivo de familia', 1, '2024-10-13 04:20:48', NULL, NULL),
(107, 5, '2024-10-12', 1, 6, 'justificado', 'Motivo de familia', 1, '2024-10-13 04:20:48', NULL, NULL),
(108, 2, '2024-10-05', 6, 53, 'presente', NULL, 5, '2024-10-14 02:33:56', NULL, NULL),
(109, 2, '2024-10-05', 6, 63, 'presente', NULL, 5, '2024-10-14 02:33:56', NULL, NULL),
(110, 2, '2024-10-05', 6, 64, 'presente', NULL, 5, '2024-10-14 02:33:56', NULL, NULL),
(111, 2, '2024-10-12', 6, 65, 'presente', NULL, 5, '2024-10-14 02:38:16', NULL, '2024-10-14 15:11:40'),
(112, 2, '2024-10-05', 6, 65, 'presente', NULL, 5, '2024-10-14 02:38:37', NULL, NULL),
(113, 5, '2024-10-12', 2, 20, 'presente', NULL, 7, '2024-10-14 22:26:17', NULL, NULL),
(114, 5, '2024-10-12', 2, 21, 'presente', NULL, 7, '2024-10-14 22:26:17', NULL, NULL),
(115, 5, '2024-10-12', 2, 18, 'ausente', NULL, 7, '2024-10-14 22:26:44', NULL, NULL),
(116, 5, '2024-10-12', 2, 19, 'ausente', NULL, 7, '2024-10-14 22:26:44', NULL, NULL),
(117, 5, '2024-10-12', 2, 22, 'ausente', NULL, 7, '2024-10-14 22:26:44', NULL, NULL),
(118, 5, '2024-10-12', 2, 23, 'ausente', NULL, 7, '2024-10-14 22:26:44', NULL, NULL),
(119, 5, '2024-10-12', 2, 41, 'ausente', NULL, 7, '2024-10-14 22:26:44', NULL, NULL),
(120, 5, '2024-10-12', 2, 42, 'ausente', NULL, 7, '2024-10-14 22:26:44', NULL, NULL),
(121, 5, '2024-10-12', 9, 8, 'presente', NULL, 3, '2024-10-14 23:51:13', NULL, NULL),
(122, 5, '2024-10-12', 9, 37, 'presente', NULL, 3, '2024-10-14 23:51:29', NULL, NULL),
(123, 5, '2024-10-12', 7, 12, 'ausente', NULL, 4, '2024-10-17 13:30:28', NULL, NULL),
(124, 5, '2024-10-12', 7, 13, 'ausente', NULL, 4, '2024-10-17 13:30:28', NULL, NULL),
(125, 5, '2024-10-12', 7, 14, 'ausente', NULL, 4, '2024-10-17 13:30:28', NULL, NULL),
(126, 5, '2024-10-12', 7, 15, 'ausente', NULL, 4, '2024-10-17 13:30:28', NULL, NULL),
(127, 5, '2024-10-12', 7, 16, 'ausente', NULL, 4, '2024-10-17 13:30:28', NULL, NULL),
(128, 5, '2024-10-12', 7, 17, 'ausente', NULL, 4, '2024-10-17 13:30:28', NULL, NULL),
(129, 3, '2024-09-28', 7, 12, 'justificado', 'No se pudo realizar nuestra reunión por contratiempos personales de la mayoría de chicas.', 4, '2024-10-22 19:41:15', NULL, NULL),
(130, 3, '2024-09-28', 7, 13, 'justificado', 'No se pudo realizar nuestra reunión por contratiempos personales de la mayoría de chicas.', 4, '2024-10-22 19:41:15', NULL, NULL),
(131, 3, '2024-09-28', 7, 14, 'justificado', 'No se pudo realizar nuestra reunión por contratiempos personales de la mayoría de chicas.', 4, '2024-10-22 19:41:15', NULL, NULL),
(132, 3, '2024-09-28', 7, 15, 'justificado', 'No se pudo realizar nuestra reunión por contratiempos personales de la mayoría de chicas.', 4, '2024-10-22 19:41:15', NULL, NULL),
(133, 3, '2024-09-28', 7, 16, 'justificado', 'No se pudo realizar nuestra reunión por contratiempos personales de la mayoría de chicas.', 4, '2024-10-22 19:41:15', NULL, NULL),
(134, 3, '2024-09-28', 7, 17, 'justificado', 'No se pudo realizar nuestra reunión por contratiempos personales de la mayoría de chicas.', 4, '2024-10-22 19:41:15', NULL, NULL),
(135, 6, '2024-10-05', 8, 66, 'presente', NULL, 10, '2024-10-25 23:34:15', NULL, NULL),
(136, 6, '2024-10-05', 8, 67, 'presente', NULL, 10, '2024-10-25 23:44:26', NULL, NULL),
(137, 6, '2024-10-05', 8, 68, 'presente', NULL, 10, '2024-10-25 23:44:26', NULL, NULL),
(138, 6, '2024-10-05', 8, 69, 'presente', NULL, 10, '2024-10-25 23:44:26', NULL, NULL),
(139, 5, '2024-10-19', 8, 66, 'presente', NULL, 10, '2024-10-26 00:02:24', NULL, NULL),
(140, 5, '2024-10-19', 8, 67, 'presente', NULL, 10, '2024-10-26 00:02:24', NULL, NULL),
(141, 5, '2024-10-19', 8, 68, 'presente', NULL, 10, '2024-10-26 00:02:24', NULL, NULL),
(142, 5, '2024-10-19', 8, 69, 'presente', NULL, 10, '2024-10-26 00:02:24', NULL, NULL),
(143, 5, '2024-10-12', 8, 66, 'presente', NULL, 10, '2024-10-26 00:03:09', NULL, NULL),
(144, 5, '2024-10-12', 8, 68, 'presente', NULL, 10, '2024-10-26 00:03:09', NULL, NULL),
(145, 5, '2024-10-12', 8, 69, 'presente', NULL, 10, '2024-10-26 00:03:09', NULL, NULL),
(146, 3, '2024-09-28', 8, 66, 'presente', NULL, 10, '2024-10-26 00:04:21', NULL, NULL),
(147, 3, '2024-09-28', 8, 67, 'presente', NULL, 10, '2024-10-26 00:04:21', NULL, NULL),
(148, 3, '2024-09-28', 8, 68, 'presente', NULL, 10, '2024-10-26 00:04:21', NULL, NULL),
(149, 3, '2024-10-26', 1, 1, 'presente', NULL, 1, '2024-10-27 16:50:07', NULL, NULL),
(150, 3, '2024-10-26', 1, 24, 'presente', NULL, 1, '2024-10-27 16:50:07', NULL, NULL),
(151, 5, '2024-11-02', 3, 38, 'presente', NULL, 8, '2024-11-03 19:21:49', NULL, NULL),
(152, 5, '2024-11-02', 3, 39, 'presente', NULL, 8, '2024-11-03 19:21:49', NULL, NULL),
(153, 5, '2024-11-02', 3, 44, 'presente', NULL, 8, '2024-11-03 19:21:49', NULL, NULL),
(154, 5, '2024-11-02', 3, 48, 'presente', NULL, 8, '2024-11-03 19:21:49', NULL, NULL),
(155, 5, '2024-11-02', 3, 45, 'ausente', NULL, 8, '2024-11-03 19:22:20', NULL, NULL),
(156, 5, '2024-11-02', 3, 46, 'ausente', NULL, 8, '2024-11-03 19:22:20', NULL, NULL),
(157, 5, '2024-11-02', 3, 47, 'ausente', NULL, 8, '2024-11-03 19:22:20', NULL, NULL),
(158, 3, '2024-10-26', 2, 19, 'presente', NULL, 7, '2024-11-03 22:38:22', NULL, NULL),
(159, 3, '2024-10-26', 2, 21, 'presente', NULL, 7, '2024-11-03 22:38:22', NULL, NULL),
(160, 5, '2024-11-02', 2, 19, 'presente', NULL, 7, '2024-11-03 22:38:46', NULL, NULL),
(161, 5, '2024-11-02', 2, 20, 'presente', NULL, 7, '2024-11-03 22:38:46', NULL, NULL),
(162, 5, '2024-11-02', 2, 21, 'presente', NULL, 7, '2024-11-03 22:38:46', NULL, NULL),
(163, 5, '2024-11-02', 9, 8, 'presente', NULL, 3, '2024-11-05 00:31:41', NULL, NULL),
(164, 5, '2024-11-02', 9, 40, 'presente', NULL, 3, '2024-11-05 00:31:41', NULL, NULL),
(165, 5, '2024-11-02', 9, 7, 'ausente', NULL, 3, '2024-11-05 00:35:00', NULL, NULL),
(166, 5, '2024-11-02', 9, 9, 'ausente', NULL, 3, '2024-11-05 00:35:00', NULL, NULL),
(167, 5, '2024-11-02', 9, 10, 'ausente', NULL, 3, '2024-11-05 00:35:00', NULL, NULL),
(168, 5, '2024-11-02', 9, 11, 'ausente', NULL, 3, '2024-11-05 00:35:00', NULL, NULL),
(169, 5, '2024-11-02', 9, 37, 'ausente', NULL, 3, '2024-11-05 00:35:00', NULL, NULL),
(170, 5, '2024-11-02', 9, 70, 'presente', NULL, 3, '2024-11-05 00:40:40', NULL, NULL),
(171, 5, '2024-11-02', 1, 1, 'presente', NULL, 1, '2024-11-06 04:06:03', NULL, NULL),
(172, 5, '2024-11-02', 1, 4, 'presente', NULL, 1, '2024-11-06 04:06:03', NULL, NULL),
(173, 5, '2024-11-02', 1, 3, 'ausente', NULL, 1, '2024-11-06 04:06:32', NULL, NULL),
(174, 5, '2024-11-02', 1, 5, 'ausente', NULL, 1, '2024-11-06 04:06:32', NULL, NULL),
(175, 5, '2024-11-02', 1, 6, 'ausente', NULL, 1, '2024-11-06 04:06:32', NULL, NULL),
(176, 5, '2024-11-02', 1, 24, 'ausente', NULL, 1, '2024-11-06 04:06:32', NULL, NULL),
(177, 2, '2024-11-09', 9, 7, 'presente', NULL, 3, '2024-11-10 13:23:05', NULL, NULL),
(178, 2, '2024-11-09', 9, 8, 'presente', NULL, 3, '2024-11-10 13:23:05', NULL, NULL),
(179, 2, '2024-11-09', 9, 37, 'presente', NULL, 3, '2024-11-10 13:23:05', NULL, NULL),
(180, 2, '2024-11-09', 9, 40, 'presente', NULL, 3, '2024-11-10 13:23:05', NULL, NULL),
(181, 2, '2024-11-09', 9, 70, 'presente', NULL, 3, '2024-11-10 13:23:05', NULL, NULL),
(182, 2, '2024-11-09', 2, 20, 'presente', NULL, 7, '2024-11-10 21:57:24', NULL, NULL),
(183, 2, '2024-11-09', 2, 21, 'presente', NULL, 7, '2024-11-10 21:57:24', NULL, NULL),
(184, 2, '2024-11-09', 2, 42, 'presente', NULL, 7, '2024-11-10 21:57:24', NULL, NULL),
(185, 2, '2024-11-09', 1, 1, 'presente', NULL, 1, '2024-11-12 01:08:37', NULL, NULL),
(186, 2, '2024-11-09', 1, 4, 'presente', NULL, 1, '2024-11-12 01:08:37', NULL, NULL),
(187, 2, '2024-11-09', 1, 24, 'presente', NULL, 1, '2024-11-12 01:08:37', NULL, NULL),
(188, 2, '2024-11-09', 1, 36, 'presente', NULL, 1, '2024-11-12 01:08:37', NULL, NULL),
(189, 2, '2024-11-09', 1, 2, 'ausente', NULL, 1, '2024-11-12 01:09:06', NULL, NULL),
(190, 2, '2024-11-09', 1, 3, 'ausente', NULL, 1, '2024-11-12 01:09:06', NULL, NULL),
(191, 2, '2024-11-09', 1, 5, 'ausente', NULL, 1, '2024-11-12 01:09:06', NULL, NULL),
(192, 2, '2024-11-09', 1, 6, 'justificado', 'Motivo laborales', 1, '2024-11-12 01:09:48', NULL, NULL),
(193, 2, '2024-11-09', 3, 38, 'presente', NULL, 8, '2024-11-12 01:16:33', NULL, NULL),
(194, 2, '2024-11-09', 3, 39, 'presente', NULL, 8, '2024-11-12 01:16:33', NULL, NULL),
(195, 2, '2024-11-09', 3, 44, 'presente', NULL, 8, '2024-11-12 01:16:33', NULL, NULL),
(196, 2, '2024-11-09', 3, 45, 'ausente', NULL, 8, '2024-11-12 01:16:50', NULL, NULL),
(197, 2, '2024-11-09', 3, 46, 'ausente', NULL, 8, '2024-11-12 01:16:50', NULL, NULL),
(198, 2, '2024-11-09', 3, 47, 'ausente', NULL, 8, '2024-11-12 01:16:50', NULL, NULL),
(199, 2, '2024-11-09', 3, 48, 'ausente', NULL, 8, '2024-11-12 01:16:50', NULL, NULL),
(200, 2, '2024-11-09', 7, 15, 'presente', NULL, 4, '2024-11-13 14:50:39', NULL, NULL),
(201, 2, '2024-11-02', 7, 71, 'presente', NULL, 4, '2024-11-13 15:04:46', NULL, NULL),
(202, 2, '2024-10-26', 7, 12, 'presente', NULL, 4, '2024-11-13 15:06:07', NULL, NULL),
(203, 2, '2024-10-26', 7, 13, 'presente', NULL, 4, '2024-11-13 15:06:07', NULL, NULL),
(204, 2, '2024-10-26', 7, 16, 'presente', NULL, 4, '2024-11-13 15:06:07', NULL, NULL),
(205, 2, '2024-11-09', 8, 66, 'presente', NULL, 10, '2024-11-16 13:51:02', NULL, NULL),
(206, 2, '2024-11-09', 8, 68, 'presente', NULL, 10, '2024-11-16 13:51:02', NULL, NULL),
(207, 2, '2024-11-09', 8, 69, 'presente', NULL, 10, '2024-11-16 13:51:02', NULL, NULL),
(208, 2, '2024-11-09', 8, 67, 'ausente', NULL, 10, '2024-11-16 13:51:54', NULL, NULL),
(209, 2, '2024-11-09', 8, 72, 'presente', NULL, 10, '2024-11-16 14:01:04', NULL, NULL),
(210, 2, '2024-11-09', 5, 49, 'presente', NULL, 6, '2024-11-16 23:20:09', NULL, NULL),
(211, 2, '2024-11-09', 5, 50, 'presente', NULL, 6, '2024-11-16 23:20:09', NULL, NULL),
(212, 2, '2024-11-09', 5, 51, 'presente', NULL, 6, '2024-11-16 23:20:09', NULL, NULL),
(213, 2, '2024-11-09', 5, 55, 'presente', NULL, 6, '2024-11-16 23:20:09', NULL, NULL),
(214, 2, '2024-11-09', 5, 56, 'presente', NULL, 6, '2024-11-16 23:20:09', NULL, NULL),
(215, 2, '2024-11-09', 5, 58, 'presente', NULL, 6, '2024-11-16 23:20:09', NULL, NULL),
(216, 2, '2024-11-09', 5, 73, 'presente', NULL, 6, '2024-11-16 23:20:09', NULL, NULL),
(217, 2, '2024-11-09', 4, 26, 'presente', NULL, 9, '2024-11-16 23:46:05', NULL, NULL),
(218, 2, '2024-11-09', 4, 28, 'presente', NULL, 9, '2024-11-16 23:46:05', NULL, NULL),
(219, 2, '2024-11-09', 4, 30, 'presente', NULL, 9, '2024-11-16 23:46:05', NULL, NULL),
(220, 2, '2024-11-09', 4, 31, 'presente', NULL, 9, '2024-11-16 23:46:05', NULL, NULL),
(221, 2, '2024-11-09', 4, 34, 'presente', NULL, 9, '2024-11-16 23:46:05', NULL, NULL),
(222, 2, '2024-11-09', 4, 35, 'presente', NULL, 9, '2024-11-16 23:46:05', NULL, NULL),
(223, 5, '2024-11-02', 4, 26, 'presente', NULL, 9, '2024-11-16 23:49:31', NULL, NULL),
(224, 5, '2024-11-02', 4, 28, 'presente', NULL, 9, '2024-11-16 23:49:31', NULL, NULL),
(225, 5, '2024-11-02', 4, 29, 'presente', NULL, 9, '2024-11-16 23:49:31', NULL, NULL),
(226, 5, '2024-11-02', 4, 30, 'presente', NULL, 9, '2024-11-16 23:49:31', NULL, NULL),
(227, 5, '2024-11-02', 4, 34, 'presente', NULL, 9, '2024-11-16 23:49:31', NULL, NULL),
(228, 5, '2024-11-02', 4, 35, 'presente', NULL, 9, '2024-11-16 23:49:31', NULL, NULL),
(229, 3, '2024-11-16', 9, 7, 'presente', NULL, 3, '2024-11-17 04:59:25', NULL, NULL),
(230, 3, '2024-11-16', 9, 8, 'presente', NULL, 3, '2024-11-17 04:59:25', NULL, NULL),
(231, 3, '2024-11-16', 9, 37, 'presente', NULL, 3, '2024-11-17 04:59:25', NULL, NULL),
(232, 3, '2024-11-16', 9, 40, 'presente', NULL, 3, '2024-11-17 04:59:25', NULL, NULL),
(233, 3, '2024-11-16', 9, 70, 'presente', NULL, 3, '2024-11-17 04:59:25', NULL, NULL),
(234, 3, '2024-11-16', 9, 9, 'justificado', 'Eventos familiares', 3, '2024-11-17 04:59:52', NULL, NULL),
(235, 3, '2024-11-16', 9, 11, 'justificado', 'Eventos familiares', 3, '2024-11-17 04:59:52', NULL, NULL),
(236, 3, '2024-11-16', 9, 10, 'ausente', NULL, 3, '2024-11-17 05:00:59', NULL, NULL),
(237, 3, '2024-11-16', 2, 19, 'presente', NULL, 7, '2024-11-17 06:04:33', NULL, NULL),
(238, 3, '2024-11-16', 2, 20, 'presente', NULL, 7, '2024-11-17 06:04:33', NULL, NULL),
(239, 3, '2024-11-16', 2, 22, 'presente', NULL, 7, '2024-11-17 06:04:33', NULL, NULL),
(240, 3, '2024-11-16', 2, 42, 'presente', NULL, 7, '2024-11-17 06:04:33', NULL, NULL),
(241, 3, '2024-11-16', 2, 21, 'justificado', 'Motivos personales y salud.', 7, '2024-11-17 06:05:22', NULL, NULL),
(242, 3, '2024-11-16', 1, 1, 'presente', NULL, 1, '2024-11-18 16:26:01', NULL, NULL),
(243, 3, '2024-11-16', 1, 4, 'presente', NULL, 1, '2024-11-18 16:26:01', NULL, NULL),
(244, 3, '2024-11-16', 1, 24, 'presente', NULL, 1, '2024-11-18 16:26:01', NULL, NULL),
(245, 3, '2024-11-16', 1, 36, 'presente', NULL, 1, '2024-11-18 16:26:01', NULL, NULL),
(246, 3, '2024-11-16', 1, 5, 'justificado', 'ESTUDIOS Y TRABAJO', 1, '2024-11-18 16:26:30', NULL, NULL),
(247, 3, '2024-11-16', 1, 6, 'justificado', 'ESTUDIOS Y TRABAJO', 1, '2024-11-18 16:26:30', NULL, NULL),
(248, 3, '2024-11-16', 1, 2, 'ausente', NULL, 1, '2024-11-18 16:26:43', NULL, NULL),
(249, 3, '2024-11-16', 1, 3, 'ausente', NULL, 1, '2024-11-18 16:26:43', NULL, NULL),
(250, 3, '2024-11-16', 3, 38, 'presente', NULL, 8, '2024-11-19 02:47:24', NULL, NULL),
(251, 3, '2024-11-16', 3, 39, 'presente', NULL, 8, '2024-11-19 02:47:24', NULL, NULL),
(252, 3, '2024-11-16', 3, 45, 'presente', NULL, 8, '2024-11-19 02:47:24', NULL, NULL),
(253, 3, '2024-11-16', 3, 46, 'presente', NULL, 8, '2024-11-19 02:47:24', NULL, NULL),
(254, 3, '2024-11-16', 3, 48, 'presente', NULL, 8, '2024-11-19 02:47:24', NULL, NULL),
(255, 3, '2024-11-16', 7, 13, 'presente', NULL, 4, '2024-11-19 03:00:47', NULL, NULL),
(256, 3, '2024-11-16', 7, 15, 'presente', NULL, 4, '2024-11-19 03:00:47', NULL, NULL),
(257, 3, '2024-11-16', 8, 66, 'presente', NULL, 10, '2024-11-20 13:24:35', NULL, NULL),
(258, 3, '2024-11-16', 8, 67, 'presente', NULL, 10, '2024-11-20 13:24:35', NULL, NULL),
(259, 3, '2024-11-16', 8, 68, 'presente', NULL, 10, '2024-11-20 13:24:35', NULL, NULL),
(260, 3, '2024-11-16', 8, 69, 'presente', NULL, 10, '2024-11-20 13:24:35', NULL, NULL),
(261, 3, '2024-11-16', 8, 72, 'presente', NULL, 10, '2024-11-20 13:24:35', NULL, NULL),
(262, 5, '2024-10-12', 6, 53, 'presente', NULL, 5, '2024-11-21 05:36:17', NULL, NULL),
(263, 5, '2024-10-12', 6, 63, 'presente', NULL, 5, '2024-11-21 05:36:17', NULL, NULL),
(264, 5, '2024-10-12', 6, 64, 'presente', NULL, 5, '2024-11-21 05:36:17', NULL, NULL),
(265, 5, '2024-10-12', 6, 65, 'presente', NULL, 5, '2024-11-21 05:36:17', NULL, NULL),
(266, 5, '2024-11-02', 6, 52, 'presente', NULL, 5, '2024-11-21 05:37:12', NULL, NULL),
(267, 5, '2024-11-02', 6, 53, 'justificado', 'viaje', 5, '2024-11-21 05:37:38', NULL, NULL),
(268, 2, '2024-11-09', 6, 53, 'presente', NULL, 5, '2024-11-21 05:41:08', NULL, NULL),
(269, 2, '2024-11-09', 6, 74, 'presente', NULL, 5, '2024-11-21 05:41:08', NULL, NULL),
(270, 3, '2024-11-16', 6, 53, 'presente', NULL, 5, '2024-11-21 13:39:43', NULL, NULL),
(271, 3, '2024-11-16', 6, 64, 'presente', NULL, 5, '2024-11-21 13:39:43', NULL, NULL),
(272, 3, '2024-11-16', 6, 65, 'presente', NULL, 5, '2024-11-21 13:39:43', NULL, NULL),
(273, 3, '2024-11-23', 9, 8, 'presente', NULL, 3, '2024-11-25 02:59:38', NULL, NULL),
(274, 3, '2024-11-23', 9, 9, 'presente', NULL, 3, '2024-11-25 02:59:38', NULL, NULL),
(275, 3, '2024-11-23', 9, 37, 'presente', NULL, 3, '2024-11-25 02:59:38', NULL, NULL),
(276, 3, '2024-11-23', 9, 75, 'presente', NULL, 3, '2024-11-25 03:02:48', NULL, NULL),
(277, 3, '2024-11-23', 3, 38, 'presente', NULL, 8, '2024-11-25 19:56:43', NULL, NULL),
(278, 3, '2024-11-23', 3, 39, 'presente', NULL, 8, '2024-11-25 19:56:43', NULL, NULL),
(279, 3, '2024-11-23', 3, 45, 'presente', NULL, 8, '2024-11-25 19:56:43', NULL, NULL),
(280, 3, '2024-11-23', 3, 46, 'presente', NULL, 8, '2024-11-25 19:56:43', NULL, NULL),
(281, 3, '2024-11-23', 3, 47, 'presente', NULL, 8, '2024-11-25 19:56:43', NULL, NULL),
(282, 3, '2024-11-23', 3, 48, 'presente', NULL, 8, '2024-11-25 19:56:43', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asistentes`
--

CREATE TABLE `asistentes` (
  `id` bigint(11) NOT NULL,
  `dni` varchar(15) DEFAULT NULL,
  `nombre` varchar(100) NOT NULL,
  `apellido` varchar(100) NOT NULL,
  `fecha_nac` varchar(100) DEFAULT NULL,
  `distrito_id` int(11) NOT NULL,
  `direccion` varchar(250) DEFAULT NULL,
  `tel` int(10) DEFAULT NULL,
  `genero` varchar(20) NOT NULL,
  `celula_id` int(11) NOT NULL,
  `estado` int(11) NOT NULL DEFAULT 1,
  `foto` varchar(250) DEFAULT NULL,
  `periodo` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `asistentes`
--

INSERT INTO `asistentes` (`id`, `dni`, `nombre`, `apellido`, `fecha_nac`, `distrito_id`, `direccion`, `tel`, `genero`, `celula_id`, `estado`, `foto`, `periodo`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, NULL, 'ADRIÁN ANDRES', 'SIFUENTES CHAVEZ', '2004-02-13', 340, 'Jr. Pedro Labarthe 493 San Agustín', 947848502, 'masculino', 1, 1, NULL, '2024', '2024-09-14 14:35:33', NULL, NULL),
(2, NULL, 'ALBERT LEONEL', 'DURAND HERRERA', '2006-09-18', 340, 'Av. Las Primaveras MZBLT8', 935761565, 'femenino', 1, 1, NULL, '2024', '2024-09-19 21:17:33', NULL, NULL),
(3, NULL, 'JOSE ARMANDO', 'TORRES SERVELEON', '2003-06-18', 340, 'Jr. San Juan Bautista 391', 902494736, 'masculino', 1, 1, NULL, '2024', '2024-09-19 21:19:04', NULL, NULL),
(4, NULL, 'YSRAEL ANTONIO', 'PEREIRA ESPICHÁN', '2005-11-19', 340, 'Jr. San Pedro 101 Urb. San Carlos', 994282995, 'masculino', 1, 1, NULL, '2024', '2024-09-19 21:31:34', NULL, NULL),
(5, NULL, 'JUAN JOSE', 'SANTIAGO ATOCHE', '2001-02-23', 340, 'Jr. San Francisco 128', 939284163, 'masculino', 1, 1, NULL, '2024', '2024-09-19 21:35:36', NULL, NULL),
(6, NULL, 'DAVID ELIAS', 'MORENO QUISPE', '2004-06-12', 332, 'Mz h lt4 Tungasuca Los Tumis, Carabayllo', 990731954, 'masculino', 1, 1, NULL, '2024', '2024-09-19 21:37:42', NULL, NULL),
(7, NULL, 'ARISSA ZARELY', 'FERROÑAN QUISPE', '2003-09-18', 340, 'CASANAVE 423, LA PASCANA', 916556664, 'femenino', 9, 1, NULL, '2024', '2024-09-19 21:42:10', NULL, NULL),
(8, NULL, 'ROSA ', 'CUBILLAS UBALDO', '2001-02-10', 332, 'ASOC. LAS GARDENIAS TUNGASUCA MZ.CLT.03 REFERENCIA OFICINA PARADERO', 994253333, 'femenino', 9, 1, NULL, '2024', '2024-09-19 21:45:30', NULL, NULL),
(9, NULL, 'PERLA DAYAN', 'GIL CHAVEZ', '2002-07-16', 332, 'Urb. Santo Domingo Segunda Etapa Mz. L1 lote 6', 917343054, 'femenino', 9, 1, NULL, '2024', '2024-09-19 21:47:08', NULL, NULL),
(10, NULL, 'VICTORIA ALEXANDRA', 'NIFLA ROSAS', '2005-04-09', 340, 'Condominios Las Praderas Mz. E Bloque E1 dtpo. 402', 904439482, 'femenino', 9, 1, NULL, '2024', '2024-09-20 16:35:50', NULL, NULL),
(11, NULL, 'ELIZABETH RUTH', 'BONIFACIO CERVANTES', '2004-06-08', 332, 'Proviv San Cristóbal de Carabayllo', 992986617, 'femenino', 9, 1, NULL, '2024', '2024-09-20 16:37:37', NULL, NULL),
(12, NULL, 'MADELLEY', 'SALIRROSAS', '2002-08-08', 332, 'Falta', 960760258, 'masculino', 7, 1, NULL, '2024', '2024-09-20 16:47:08', NULL, NULL),
(13, NULL, 'DAMARYS', 'SUAREZ', '2002-09-22', 332, 'Falta', 975551666, 'femenino', 7, 1, NULL, '2024', '2024-09-20 16:48:37', NULL, NULL),
(14, NULL, 'FIORELLA', 'FIGUEROA', '2005-08-29', 332, 'Falta', 940786357, 'femenino', 7, 1, NULL, '2024', '2024-09-20 16:50:34', NULL, NULL),
(15, NULL, 'MARIAJOSE', 'FLORES', '2002-08-28', 340, 'Falta', 954831441, 'femenino', 7, 1, NULL, '2024', '2024-09-20 16:51:46', NULL, NULL),
(16, NULL, 'CAROL', 'CUADRA', '2005-03-28', 332, 'Falta', 951458630, 'femenino', 7, 1, NULL, '2024', '2024-09-20 16:53:07', NULL, NULL),
(17, NULL, 'CHARYS', 'TORRES', '2004-01-23', 332, 'Falta', 980981405, 'masculino', 7, 1, NULL, '2024', '2024-09-20 16:54:17', NULL, NULL),
(18, NULL, 'KEIDY MICHELLE', 'PONCE DURAND', '2001-07-14', 332, 'URB. PORTAL DE SANTA MARÍA MZ.E LT.1', 936470609, 'femenino', 2, 1, NULL, '2024', '2024-09-20 16:56:53', NULL, NULL),
(19, NULL, 'IVANNA XIOMARA', 'ESPICHÁN PANTOJA', '2002-03-22', 340, 'CONDOMINIO TORRES VISTA SOL BLOCK G10', 984355429, 'femenino', 2, 1, NULL, '2024', '2024-09-20 16:59:30', NULL, NULL),
(20, NULL, 'PAULA ALEJANDRA', 'SANTILLANA ESPICHÁN', '2001-03-31', 340, 'JR. SAN PEDRO #101 URB. SAN CARLOS', 934138983, 'femenino', 2, 1, NULL, '2024', '2024-09-20 17:04:19', NULL, NULL),
(21, NULL, 'DANNETTE ALESSANDRA', 'ROMERO INOCENTE', '2000-05-13', 332, 'JR. FRANCISCO TORRES 363, TENGAS', 936995788, 'femenino', 2, 1, NULL, '2024', '2024-09-20 17:05:25', NULL, NULL),
(22, NULL, 'SELENA', 'DEXTRE ROJAS', '2002-11-11', 332, 'ASOC. LOS CEDROS MZ M LT 8', 918761524, 'femenino', 2, 1, NULL, '2024', '2024-09-20 17:06:24', NULL, NULL),
(23, NULL, 'ANDREA BERTHA', 'SUAREZ SILVA', '2001-10-21', 332, 'PASAJE LETICIA 181 RAHÚL PORRAS BARRENECHEA', 985052292, 'femenino', 2, 1, NULL, '2024', '2024-09-20 17:07:25', NULL, NULL),
(24, NULL, 'JESUS AARON', 'ARICA DUQUE', '2005-10-27', 340, 'TRAPICHE', 942961887, 'masculino', 1, 1, NULL, '2024', '2024-09-20 17:38:22', NULL, NULL),
(25, NULL, 'JOSE WALTER', 'CORDOVA DURAND', '2003-01-18', 340, 'AV. SANTA MARIA', 981406241, 'masculino', 4, 1, NULL, '2024', '2024-09-23 13:27:21', NULL, NULL),
(26, NULL, 'JOHN ANTONIO', 'TRUJILLO CRISTOBAL', '2001-11-21', 332, 'Mz N1 Lt. 35 4ta Etapa Santo Domingo', 963319211, 'femenino', 4, 1, NULL, '2024', '2024-09-23 13:32:06', NULL, NULL),
(27, NULL, 'DUSTIN FLAVIO', 'CAMPOS LOYOLA', '2004-12-05', 332, 'Av.César Vallejo285.Urb Lucyana', 939835546, 'masculino', 4, 1, NULL, '2024', '2024-09-23 13:34:24', NULL, NULL),
(28, NULL, 'JAVIER JEFERSSON', 'ALAYO SURCO', '2004-05-19', 340, 'Calle los frutales mz d lote 9', 947287213, 'masculino', 4, 1, NULL, '2024', '2024-09-23 13:42:22', NULL, NULL),
(29, NULL, 'JUAN JOSÉ', 'DE LA PORTILLA CÁRDENAS', '2003-06-07', 332, 'Av. Isabel Chimpu Ocllo 401', 980906851, 'masculino', 4, 1, NULL, '2024', '2024-09-23 13:45:00', NULL, NULL),
(30, NULL, 'FABRICIO ALDAIR', 'VEGA CHAUCA', '2005-05-17', 340, 'Hr san Isidro 372 san Carlos', 903343168, 'masculino', 4, 1, NULL, '2024', '2024-09-23 13:46:38', NULL, NULL),
(31, NULL, 'DAVID FERNANDO', 'GARCÍA MORENO', '2000-12-08', 332, 'Estrella Solar MZ H lote 10', 932068558, 'masculino', 4, 1, NULL, '2024', '2024-09-23 13:48:07', NULL, NULL),
(32, NULL, 'BRUNO STEPHANO', 'RODRÍGUEZ INCIO', '2003-11-15', 332, 'Jr. Las margaritas 192 santa Isabel', 982244920, 'masculino', 4, 1, NULL, '2024', '2024-09-23 13:48:42', NULL, NULL),
(33, NULL, 'ANDREW WILLIAMS', 'ROMERO DEXTRE', '2001-03-27', 332, 'Av. Sta Maria #296', 918505563, 'masculino', 4, 1, NULL, '2024', '2024-09-23 13:49:57', NULL, NULL),
(34, NULL, 'LEONEL AARÓN', 'GARCIA ASCOY', '2004-01-18', 332, 'Jr. Jorge Chávez Mz. 102 Lt. 11 RPB', 922288684, 'masculino', 4, 1, NULL, '2024', '2024-09-23 13:50:48', NULL, NULL),
(35, NULL, 'ANGEL', 'BARBARAN LA COTERA', '2003-06-25', 332, 'Av Caudivilla con Jr. Juan Valer No 113 int 102', 954267465, 'masculino', 4, 1, NULL, '2024', '2024-09-23 13:51:56', NULL, NULL),
(36, NULL, 'SEBASTIAN GIANCARLO', 'VASQUEZ WONG', '2000-11-08', 340, 'PSJ. AMAZONAS 101', 912648531, 'masculino', 1, 1, NULL, '2024', '2024-09-23 14:01:12', NULL, NULL),
(37, NULL, 'BELEN CRISTINA', 'LLANOS AGUILAR', '2001-02-21', 340, 'ARICA 275', 955794014, 'femenino', 9, 1, NULL, '2024', '2024-09-23 14:03:04', NULL, NULL),
(38, NULL, 'JONATHAN', 'RODRIGUEZ ESPINOZA', '2000-12-22', 340, 'Falta', 902008867, 'masculino', 3, 1, NULL, '2024', '2024-09-24 17:08:02', NULL, NULL),
(39, NULL, 'LUIS SANTIAGO', 'ROQUE MACHUCA', '2001-06-25', 332, 'Falta', 921503048, 'masculino', 3, 1, NULL, '2024', '2024-09-24 17:09:13', NULL, NULL),
(40, NULL, 'BELEN', 'SALDARRIAGA', '2008-06-19', 332, 'Falta', 994329582, 'femenino', 9, 1, NULL, '2024', '2024-09-29 02:34:04', NULL, NULL),
(41, NULL, 'SOFIA', 'CARRASCO TARIFENO', '2000-08-08', 340, 'Trapiche', 983985496, 'femenino', 2, 1, NULL, '2024', '2024-09-29 16:16:32', NULL, NULL),
(42, NULL, 'JOSBELI', 'MICHELANGELI GARCIA', '1999-08-18', 340, 'Alborada con Universitaria', 903295363, 'femenino', 2, 1, NULL, '2024', '2024-09-29 16:19:05', NULL, NULL),
(43, NULL, 'JONATAN', 'RODRÍGUEZ ESPINOZA', '2000-12-22', 332, 'Falta', NULL, 'masculino', 3, 1, NULL, '2024', '2024-09-29 16:20:32', NULL, '2024-09-29 11:20:58'),
(44, NULL, 'LUIS SANTIAGO', 'ROQUE MACHUCA', '2001-06-25', 340, 'Falta', NULL, 'masculino', 3, 1, NULL, '2024', '2024-09-29 16:22:07', NULL, '2024-11-15 10:03:01'),
(45, NULL, 'GERSON ALEX', 'JESÚS YACHE', '1999-10-05', 340, 'Falta', NULL, 'masculino', 3, 1, NULL, '2024', '2024-09-29 16:24:04', NULL, NULL),
(46, NULL, 'JOHAN SAMIR', 'JESÚS YACHE', '2000-01-30', 340, 'Falta', NULL, 'masculino', 3, 1, NULL, '2024', '2024-09-29 16:25:31', NULL, NULL),
(47, NULL, 'EMERSON', 'OTINIANO CALIXTO', '1999-09-03', 340, 'Falta', NULL, 'masculino', 3, 1, NULL, '2024', '2024-09-29 16:26:46', NULL, NULL),
(48, NULL, 'AARÓN ISRAEL', 'MORENO QUISPE', '2001-11-21', 340, 'Falta', NULL, 'masculino', 3, 1, NULL, '2024', '2024-09-29 16:31:31', NULL, NULL),
(49, NULL, 'LUCERITO', 'FLORES RUIZ', '2000-03-06', 340, 'Av. Sangarará 8913 Universitaria', NULL, 'femenino', 5, 1, NULL, '2024', '2024-09-30 02:41:30', NULL, NULL),
(50, NULL, 'YIREH ANDREA', 'RODRÍGUEZ ESPINOZA', '2007-02-10', 332, 'Carabayllo/ El Progreso Km. 19 Jr. Los Tulipanes 290 3.', NULL, 'femenino', 5, 1, NULL, '2024', '2024-09-30 03:08:32', NULL, NULL),
(51, NULL, 'RUT', 'GARCIA MORENO', '2002-02-14', 332, 'Muicipalidad de Merino', NULL, 'femenino', 5, 1, NULL, '2024', '2024-09-30 03:18:32', NULL, NULL),
(52, NULL, 'Claudia', 'Flores Torres', '1998-09-10', 340, 'Sangarará', 945825616, 'femenino', 6, 1, NULL, '2024', '2024-10-03 21:52:05', NULL, NULL),
(53, NULL, 'Ruth Jael', 'Botetano Leyva', '2000-04-20', 332, 'Av. Manuel Prado', 916890693, 'femenino', 6, 1, NULL, '2024', '2024-10-03 22:05:13', NULL, NULL),
(54, NULL, 'Beatriz Nicole', 'Gonzaga Ascoy', '2001-03-26', 533, 'Ventanilla', 992091694, 'masculino', 6, 1, NULL, '2024', '2024-10-03 22:14:18', NULL, NULL),
(55, NULL, 'Marygrace', 'TAYRO RUIZ', '2007-03-04', 340, 'Av Sangarara universitaria', 980897365, 'femenino', 5, 1, NULL, '2024', '2024-10-07 20:19:35', NULL, NULL),
(56, NULL, 'Sara Gabriela', 'CHAVEZ VELA', '2003-01-06', 332, 'Km 19 - Jr.Chiclayo 193-El Progreso', 902795708, 'femenino', 5, 1, NULL, '2024', '2024-10-07 20:33:03', NULL, NULL),
(57, NULL, 'Mia Camila', 'BARBARÁN LA COTERA', '2006-12-14', 332, 'Calle 16 n113 int 102 Residencial Lucyana de Carabayllo', 936340632, 'femenino', 5, 1, NULL, '2024', '2024-10-08 05:23:15', NULL, NULL),
(58, NULL, 'Ariana', 'gomez', '0001-01-01', 332, 'Carabyllo', 954127755, 'femenino', 5, 1, NULL, '2024', '2024-10-08 05:25:03', NULL, NULL),
(59, NULL, 'Camilo', 'Arbaiza', '2005-10-11', 340, 'San Carlos, Comas', 952724281, 'masculino', 4, 1, NULL, '2024', '2024-10-11 05:35:15', NULL, NULL),
(60, NULL, 'Eliane Madelyne', 'Falcón Chuqui', '2003-12-02', 340, 'Belaunde', 923004715, 'femenino', 6, 1, NULL, '2024', '2024-10-12 17:08:37', NULL, NULL),
(61, NULL, 'Daniuska Antuaneth', 'Meza Rojas', '2004-01-10', 340, 'Trapiche', 959100434, 'femenino', 6, 1, NULL, '2024', '2024-10-12 17:09:37', NULL, NULL),
(62, NULL, 'Angeles Alexandra', 'Rodas Ibañez', '2004-01-01', 332, 'Santo Domingo', 910725178, 'femenino', 6, 1, NULL, '2024', '2024-10-12 17:11:28', NULL, NULL),
(63, NULL, 'Fiorella Victoria', 'Lazo Garcia', '2002-12-26', 332, 'La Cumbre', 928593505, 'femenino', 6, 1, NULL, '2024', '2024-10-12 17:13:05', NULL, NULL),
(64, NULL, 'Celeste esmeralda', 'velasquez', '2002-06-25', 332, 'Av. Manuel Prado', 923968826, 'femenino', 6, 1, NULL, '2024', '2024-10-12 17:19:48', NULL, NULL),
(65, NULL, 'Anyeli Nicol', 'Carhuaricra Caramantin', '2007-03-05', 332, 'Santo Domingo 5ta etapa a la altura  del grifo 39', 914447613, 'femenino', 6, 1, NULL, '2024', '2024-10-14 02:35:53', NULL, NULL),
(66, NULL, 'Juan', 'Carlos galiano', '2000-12-30', 340, NULL, 953863697, 'masculino', 8, 1, NULL, '2024', '2024-10-25 23:23:34', NULL, NULL),
(67, NULL, 'Eliazar', 'Robles', '2005-06-27', 340, 'Comas', 950785203, 'masculino', 8, 1, NULL, '2024', '2024-10-25 23:36:50', NULL, NULL),
(68, NULL, 'Danilo', 'Argumedo', '2002-08-18', 340, 'Comas', 989097550, 'masculino', 8, 1, NULL, '2024', '2024-10-25 23:40:04', NULL, NULL),
(69, NULL, 'Adrian', 'Argumedo zuñiga', '2001-08-28', 340, 'Comas', 989178031, 'masculino', 8, 1, NULL, '2024', '2024-10-25 23:43:09', NULL, NULL),
(70, NULL, 'Kristie candy', 'Vela rabello', '2001-02-10', 332, NULL, 944360854, 'femenino', 9, 1, NULL, '2024', '2024-11-05 00:40:16', NULL, NULL),
(71, NULL, 'DANIELA', 'SOTELO', '2005-05-08', 332, 'CARABAYLLO', 936924680, 'femenino', 7, 1, NULL, '2024', '2024-11-13 15:03:54', NULL, NULL),
(72, NULL, 'Isaac', 'Rojas', '1997-07-01', 340, 'Comas', 977400519, 'masculino', 8, 1, NULL, NULL, '2024-11-16 14:00:26', NULL, NULL),
(73, NULL, 'Luana', 'Argumedo Zuñiga', '2007-01-30', 340, 'Urb.El alamo condominio Buganvillas dpto.406A', 987223200, 'femenino', 5, 1, NULL, NULL, '2024-11-16 23:19:14', NULL, NULL),
(74, NULL, 'Nicole Mirelly', 'Laguna Albornoz', '2021-01-18', 340, '4ta zona de collique  Asent. H. Villa de Jesús Mz D Lt 5', 953744619, 'masculino', 6, 1, NULL, NULL, '2024-11-21 05:21:44', NULL, NULL),
(75, NULL, 'Ariana', '.', '2002-02-14', 340, '.', 901800604, 'femenino', 9, 1, NULL, NULL, '2024-11-25 03:01:16', NULL, NULL),
(76, NULL, 'Fabrizio Jaime', 'Oré Del Pino', '2003-04-12', 340, NULL, NULL, 'masculino', 3, 1, NULL, NULL, '2024-11-25 19:53:27', NULL, NULL),
(77, NULL, 'JoSE Fabricio', 'Campo C.', NULL, 340, NULL, NULL, 'masculino', 3, 1, NULL, NULL, '2024-11-25 19:55:32', NULL, NULL),
(78, NULL, 'Jhon', 'Adrianzen', NULL, 340, NULL, NULL, 'masculino', 3, 1, NULL, NULL, '2024-11-25 19:59:29', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `calendarios`
--

CREATE TABLE `calendarios` (
  `id` bigint(11) NOT NULL,
  `nombre` varchar(250) NOT NULL,
  `fecha_registro` varchar(40) NOT NULL,
  `tema` varchar(250) DEFAULT NULL,
  `libro` varchar(250) DEFAULT NULL,
  `estado` varchar(11) NOT NULL DEFAULT '1',
  `responsable` varchar(250) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `calendarios`
--

INSERT INTO `calendarios` (`id`, `nombre`, `fecha_registro`, `tema`, `libro`, `estado`, `responsable`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Reunion Unida JAC', '2024-08-03', 'EN MODO ESPERA - SALMO 118:24', 'Biblia', '1', 'Pr. Pablo', '2024-09-19 14:02:30', NULL, NULL),
(2, 'Reunion Homogenea', '2024-08-10', 'La vida esta herida', 'Destruye los dioses que llevas dentro', '1', NULL, '2024-09-19 14:11:44', NULL, NULL),
(3, 'Celulas', '2024-08-17', 'Enfrenta la duda intelectual', 'Enfrenta tu Goliat', '1', 'Pr. Pablo', '2024-09-19 14:14:25', NULL, NULL),
(4, 'Ayuno', '2024-08-24', NULL, NULL, '1', NULL, '2024-09-19 14:22:59', NULL, NULL),
(5, 'Celulas', '2024-08-31', 'Enfrenta el miedo', 'Enfrenta tu Goliat', '1', NULL, '2024-09-19 14:23:31', NULL, NULL),
(6, 'Congreso para la Familia', '2024-09-7', NULL, NULL, '1', NULL, '2024-09-19 14:23:49', NULL, NULL),
(7, 'Reunion Unida', '2024-09-14', 'SOLO O SOLTERO', 'Ge. 2:18', '1', 'Pr. Pablo', '2024-09-19 14:24:23', NULL, NULL),
(8, 'Led Juvenil', '2024-09-21', 'Discipula2', NULL, '1', NULL, '2024-09-19 14:26:14', NULL, NULL),
(9, 'Celula', '2024-09-28', 'Enfrenta el orgullo', 'Enfrenta tu Goliat', '1', 'Sebastian Vasquez', '2024-09-19 14:28:08', NULL, NULL),
(10, 'Aniversario JAC', '2024-10-05', 'Rompiendo la conformidad', 'Destruye los dioses que llevas dentro', '1', 'Pr. Pablo', '2024-09-19 14:29:20', NULL, NULL),
(11, 'Homogenea', '2024-10-12', 'Materialismo: El Dios invisible', 'Destruye los dioses que llevas dentro', '1', NULL, '2024-09-19 14:33:17', NULL, NULL),
(12, 'Congreso Juvenil', '2024-10-19', NULL, NULL, '1', NULL, '2024-09-19 14:33:44', NULL, NULL),
(13, 'Celulas', '2024-10-26', 'Enfrenta tu lujuría', 'Enfrenta tu Goliat', '1', 'Angela Salirrosas', '2024-09-19 14:35:47', NULL, NULL),
(14, 'Homogenea', '2024-11-02', 'COMO ENFRENTAR EL YO HERIDO', NULL, '1', NULL, '2024-09-19 14:37:09', NULL, NULL),
(15, 'JAC Unido', '2024-11-09', 'COMO ENFRENTAR EL YO HERIDO', 'Destruye los dioses que llevas dentro', '1', 'Pr. Pablo', '2024-09-19 14:38:27', NULL, NULL),
(16, 'Celula', '2024-11-16', 'Enfrenta el miedo', 'Enfrenta tu Goliat', '1', 'John Trujillo', '2024-09-19 14:39:22', NULL, NULL),
(17, 'JAC Unido', '2024-11-23', 'Carácter en medio del caos', 'Destruye los dioses que llevas dentro', '1', 'Pr. Pablo', '2024-09-19 14:40:48', NULL, NULL),
(18, 'Celula', '2024-11-30', 'Enfrenta tu gigante con la verdad', 'Enfrenta tu Goliat', '1', 'Graciela Becerra', '2024-09-19 14:41:55', NULL, NULL),
(19, 'Homogenea', '2024-12-07', 'EL perdón: La gracia sanadora', 'Destruye los dioses que llevas dentro', '1', NULL, '2024-09-19 14:44:27', NULL, NULL),
(20, 'Reunión Unida ', '2024-12-21', 'De las heridas a la adoración', 'Destruye los dioses que llevas dentro', '1', 'Pr. Pablo', '2024-09-19 14:45:12', NULL, NULL),
(21, 'NAVIDAD', '2024-12-21', NULL, NULL, '1', NULL, '2024-09-19 14:45:32', NULL, NULL),
(22, 'Celulas', '2024-12-28', 'Enfrenta tu gigante con la oración', 'Enfrenta tu Goliat', '1', 'Belén Llanos', '2024-09-19 14:46:02', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `celulas`
--

CREATE TABLE `celulas` (
  `id` bigint(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` varchar(250) DEFAULT NULL,
  `lider_id` int(11) NOT NULL,
  `estado` int(11) NOT NULL DEFAULT 1,
  `periodo` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `celulas`
--

INSERT INTO `celulas` (`id`, `nombre`, `descripcion`, `lider_id`, `estado`, `periodo`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'CELULA REVELACION', 'LIDER SEBASTIAN VASQUEZ', 1, 1, '2024', '2024-09-14 14:32:42', NULL, NULL),
(2, 'CELULA GRACIA', 'LIDER ANGELA SALIRROSAS', 7, 1, '2024', '2024-09-19 15:53:54', NULL, NULL),
(3, 'CELULA AGAPE', 'LIDER MIGUEL RAMON', 8, 1, '2024', '2024-09-19 15:54:08', NULL, NULL),
(4, 'CELULA FE', 'LIDER JOHN TRUJILLO', 9, 1, '2024', '2024-09-19 15:54:38', NULL, NULL),
(5, 'CELULA VIRTUOSA', 'LIDER NATY ICHIGO', 6, 1, '2024', '2024-09-19 15:54:56', NULL, NULL),
(6, 'CELULA EBENEZER', 'LIDER MARGIORIE CABRERA', 5, 1, '2024', '2024-09-19 15:55:22', NULL, NULL),
(7, 'CELULA PAZ', 'LIDER GRACIELA BECERRA', 4, 1, '2024', '2024-09-19 15:55:49', NULL, NULL),
(8, 'CELULA JEREMIAS', 'LIDER JERRY CARAMANTIN', 10, 1, '2024', '2024-09-19 15:56:55', NULL, NULL),
(9, 'CELULA ZOE', 'LIDER BELÉN LLANOS', 3, 1, '2024', '2024-09-19 15:57:16', NULL, NULL),
(10, 'NUEVO', 'INTEGRANTES NUEVOS', 11, 1, '2024', '2024-09-19 17:20:28', NULL, NULL),
(11, 'Virtuosa', 'Alabar a Dios con todo el corazón', 6, 1, '2024', '2024-09-29 04:47:40', NULL, '2024-09-28 23:48:24');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `celula_asistente`
--

CREATE TABLE `celula_asistente` (
  `id` bigint(11) NOT NULL,
  `asistente_id` int(11) NOT NULL,
  `celula_id` int(11) NOT NULL,
  `fecha_inicio` date DEFAULT NULL,
  `fecha_fin` date DEFAULT NULL,
  `estado` varchar(20) DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `celula_asistente`
--

INSERT INTO `celula_asistente` (`id`, `asistente_id`, `celula_id`, `fecha_inicio`, `fecha_fin`, `estado`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 1, '2024-01-01', NULL, '1', '2024-11-15 20:02:37', '0000-00-00 00:00:00', NULL),
(2, 2, 1, '2024-01-01', NULL, '1', '2024-11-15 20:02:37', '0000-00-00 00:00:00', NULL),
(3, 3, 1, '2024-01-01', NULL, '1', '2024-11-15 20:02:37', '0000-00-00 00:00:00', NULL),
(4, 4, 1, '2024-01-01', NULL, '1', '2024-11-15 20:02:37', '0000-00-00 00:00:00', NULL),
(5, 5, 1, '2024-01-01', NULL, '1', '2024-11-15 20:02:37', '0000-00-00 00:00:00', NULL),
(6, 6, 1, '2024-01-01', NULL, '1', '2024-11-15 20:02:37', '0000-00-00 00:00:00', NULL),
(7, 7, 9, '2024-01-01', NULL, '1', '2024-11-15 20:02:37', '0000-00-00 00:00:00', NULL),
(8, 8, 9, '2024-01-01', NULL, '1', '2024-11-15 20:02:37', '0000-00-00 00:00:00', NULL),
(9, 9, 9, '2024-01-01', NULL, '1', '2024-11-15 20:02:37', '0000-00-00 00:00:00', NULL),
(10, 10, 9, '2024-01-01', NULL, '1', '2024-11-15 20:02:37', '0000-00-00 00:00:00', NULL),
(11, 11, 9, '2024-01-01', NULL, '1', '2024-11-15 20:02:37', '0000-00-00 00:00:00', NULL),
(12, 12, 7, '2024-01-01', NULL, '1', '2024-11-15 20:02:37', '0000-00-00 00:00:00', NULL),
(13, 13, 7, '2024-01-01', NULL, '1', '2024-11-15 20:02:37', '0000-00-00 00:00:00', NULL),
(14, 14, 7, '2024-01-01', NULL, '1', '2024-11-15 20:02:37', '0000-00-00 00:00:00', NULL),
(15, 15, 7, '2024-01-01', NULL, '1', '2024-11-15 20:02:37', '0000-00-00 00:00:00', NULL),
(16, 16, 7, '2024-01-01', NULL, '1', '2024-11-15 20:02:37', '0000-00-00 00:00:00', NULL),
(17, 17, 7, '2024-01-01', NULL, '1', '2024-11-15 20:02:37', '0000-00-00 00:00:00', NULL),
(18, 18, 2, '2024-01-01', NULL, '1', '2024-11-15 20:02:37', '0000-00-00 00:00:00', NULL),
(19, 19, 2, '2024-01-01', NULL, '1', '2024-11-15 20:02:37', '0000-00-00 00:00:00', NULL),
(20, 20, 2, '2024-01-01', NULL, '1', '2024-11-15 20:02:37', '0000-00-00 00:00:00', NULL),
(21, 21, 2, '2024-01-01', NULL, '1', '2024-11-15 20:02:37', '0000-00-00 00:00:00', NULL),
(22, 22, 2, '2024-01-01', NULL, '1', '2024-11-15 20:02:37', '0000-00-00 00:00:00', NULL),
(23, 23, 2, '2024-01-01', NULL, '1', '2024-11-15 20:02:37', '0000-00-00 00:00:00', NULL),
(24, 24, 1, '2024-01-01', NULL, '1', '2024-11-15 20:02:37', '0000-00-00 00:00:00', NULL),
(25, 25, 4, '2024-01-01', NULL, '1', '2024-11-15 20:02:37', '0000-00-00 00:00:00', NULL),
(26, 26, 4, '2024-01-01', NULL, '1', '2024-11-15 20:02:37', '0000-00-00 00:00:00', NULL),
(27, 27, 4, '2024-01-01', NULL, '1', '2024-11-15 20:02:37', '0000-00-00 00:00:00', NULL),
(28, 28, 4, '2024-01-01', NULL, '1', '2024-11-15 20:02:37', '0000-00-00 00:00:00', NULL),
(29, 29, 4, '2024-01-01', NULL, '1', '2024-11-15 20:02:37', '0000-00-00 00:00:00', NULL),
(30, 30, 4, '2024-01-01', NULL, '1', '2024-11-15 20:02:37', '0000-00-00 00:00:00', NULL),
(31, 31, 4, '2024-01-01', NULL, '1', '2024-11-15 20:02:37', '0000-00-00 00:00:00', NULL),
(32, 32, 4, '2024-01-01', NULL, '1', '2024-11-15 20:02:37', '0000-00-00 00:00:00', NULL),
(33, 33, 4, '2024-01-01', NULL, '1', '2024-11-15 20:02:37', '0000-00-00 00:00:00', NULL),
(34, 34, 4, '2024-01-01', NULL, '1', '2024-11-15 20:02:37', '0000-00-00 00:00:00', NULL),
(35, 35, 4, '2024-01-01', NULL, '1', '2024-11-15 20:02:37', '0000-00-00 00:00:00', NULL),
(36, 36, 1, '2024-01-01', NULL, '1', '2024-11-15 20:02:37', '0000-00-00 00:00:00', NULL),
(37, 37, 9, '2024-01-01', NULL, '1', '2024-11-15 20:02:37', '0000-00-00 00:00:00', NULL),
(38, 38, 3, '2024-01-01', NULL, '1', '2024-11-15 20:02:37', '0000-00-00 00:00:00', NULL),
(39, 39, 3, '2024-01-01', NULL, '1', '2024-11-15 20:02:37', '0000-00-00 00:00:00', NULL),
(40, 40, 9, '2024-01-01', NULL, '1', '2024-11-15 20:02:37', '0000-00-00 00:00:00', NULL),
(41, 41, 2, '2024-01-01', NULL, '1', '2024-11-15 20:02:37', '0000-00-00 00:00:00', NULL),
(42, 42, 2, '2024-01-01', NULL, '1', '2024-11-15 20:02:37', '0000-00-00 00:00:00', NULL),
(43, 43, 3, '2024-01-01', NULL, '1', '2024-11-15 20:02:37', '0000-00-00 00:00:00', NULL),
(44, 44, 3, '2024-01-01', NULL, '1', '2024-11-15 20:02:37', '0000-00-00 00:00:00', NULL),
(45, 45, 3, '2024-01-01', NULL, '1', '2024-11-15 20:02:37', '0000-00-00 00:00:00', NULL),
(46, 46, 3, '2024-01-01', NULL, '1', '2024-11-15 20:02:37', '0000-00-00 00:00:00', NULL),
(47, 47, 3, '2024-01-01', NULL, '1', '2024-11-15 20:02:37', '0000-00-00 00:00:00', NULL),
(48, 48, 3, '2024-01-01', NULL, '1', '2024-11-15 20:02:37', '0000-00-00 00:00:00', NULL),
(49, 49, 5, '2024-01-01', NULL, '1', '2024-11-15 20:02:37', '0000-00-00 00:00:00', NULL),
(50, 50, 5, '2024-01-01', NULL, '1', '2024-11-15 20:02:37', '0000-00-00 00:00:00', NULL),
(51, 51, 5, '2024-01-01', NULL, '1', '2024-11-15 20:02:37', '0000-00-00 00:00:00', NULL),
(52, 52, 6, '2024-01-01', NULL, '1', '2024-11-15 20:02:37', '0000-00-00 00:00:00', NULL),
(53, 53, 6, '2024-01-01', NULL, '1', '2024-11-15 20:02:37', '0000-00-00 00:00:00', NULL),
(54, 54, 6, '2024-01-01', NULL, '1', '2024-11-15 20:02:37', '0000-00-00 00:00:00', NULL),
(55, 55, 5, '2024-01-01', NULL, '1', '2024-11-15 20:02:37', '0000-00-00 00:00:00', NULL),
(56, 56, 5, '2024-01-01', NULL, '1', '2024-11-15 20:02:37', '0000-00-00 00:00:00', NULL),
(57, 57, 5, '2024-01-01', NULL, '1', '2024-11-15 20:02:37', '0000-00-00 00:00:00', NULL),
(58, 58, 5, '2024-01-01', NULL, '1', '2024-11-15 20:02:37', '0000-00-00 00:00:00', NULL),
(59, 59, 4, '2024-01-01', NULL, '1', '2024-11-15 20:02:37', '0000-00-00 00:00:00', NULL),
(60, 60, 6, '2024-01-01', NULL, '1', '2024-11-15 20:02:37', '0000-00-00 00:00:00', NULL),
(61, 61, 6, '2024-01-01', NULL, '1', '2024-11-15 20:02:37', '0000-00-00 00:00:00', NULL),
(62, 62, 6, '2024-01-01', NULL, '1', '2024-11-15 20:02:37', '0000-00-00 00:00:00', NULL),
(63, 63, 6, '2024-01-01', NULL, '1', '2024-11-15 20:02:37', '0000-00-00 00:00:00', NULL),
(64, 64, 6, '2024-01-01', NULL, '1', '2024-11-15 20:02:37', '0000-00-00 00:00:00', NULL),
(65, 65, 6, '2024-01-01', NULL, '1', '2024-11-15 20:02:37', '0000-00-00 00:00:00', NULL),
(66, 66, 8, '2024-01-01', NULL, '1', '2024-11-15 20:02:37', '0000-00-00 00:00:00', NULL),
(67, 67, 8, '2024-01-01', NULL, '1', '2024-11-15 20:02:37', '0000-00-00 00:00:00', NULL),
(68, 68, 8, '2024-01-01', NULL, '1', '2024-11-15 20:02:37', '0000-00-00 00:00:00', NULL),
(69, 69, 8, '2024-01-01', NULL, '1', '2024-11-15 20:02:37', '0000-00-00 00:00:00', NULL),
(70, 70, 9, '2024-01-01', NULL, '1', '2024-11-15 20:02:37', '0000-00-00 00:00:00', NULL),
(71, 71, 7, '2024-01-01', NULL, '1', '2024-11-15 20:02:37', '0000-00-00 00:00:00', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `configuracions`
--

CREATE TABLE `configuracions` (
  `id` bigint(11) NOT NULL,
  `numero` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `configuracions`
--

INSERT INTO `configuracions` (`id`, `numero`, `created_at`) VALUES
(1, '127.0.0.1', '2024-10-14 21:44:12');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `distritos`
--

CREATE TABLE `distritos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `provincia_id` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(250) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `distritos`
--

INSERT INTO `distritos` (`id`, `provincia_id`, `nombre`, `deleted_at`) VALUES
(1, 1, 'BAGUA', NULL),
(2, 1, 'BAGUA', NULL),
(3, 1, 'BAGUA GRANDE', NULL),
(4, 1, 'BONGARA', NULL),
(5, 1, 'CHACHAPOYAS', NULL),
(6, 1, 'CONDORCANQUI', NULL),
(7, 1, 'COROSHA', NULL),
(8, 1, 'EL CENEPA', NULL),
(9, 1, 'EL MILAGRO', NULL),
(10, 1, 'JAZAN', NULL),
(11, 1, 'LUYA', NULL),
(12, 1, 'NIEVA', NULL),
(13, 1, 'RODRIGUEZ DE MENDOZA', NULL),
(14, 1, 'SAN NICOLAS', NULL),
(15, 1, 'UTCUBAMBA', NULL),
(16, 2, 'AIJA', NULL),
(17, 2, 'ANTONIO RAYMONDI', NULL),
(18, 2, 'ASUNCION', NULL),
(19, 2, 'BOLOGNESI', NULL),
(20, 2, 'CARAZ', NULL),
(21, 2, 'CARHUAZ', NULL),
(22, 2, 'CARLOS FERMIN FITZCARRALD', NULL),
(23, 2, 'CASCA', NULL),
(24, 2, 'CASMA', NULL),
(25, 2, 'CHAVIN DE HUANTAR', NULL),
(26, 2, 'CHIMBOTE', NULL),
(27, 2, 'COISHCO', NULL),
(28, 2, 'CORONGO', NULL),
(29, 2, 'HUARAZ', NULL),
(30, 2, 'HUARI', NULL),
(31, 2, 'HUARMEY', NULL),
(32, 2, 'HUAYLAS', NULL),
(33, 2, 'INDEPENDENCIA', NULL),
(34, 2, 'MACATE', NULL),
(35, 2, 'MARISCAL LUZURIAGA', NULL),
(37, 2, 'NUEVO CHIMBOTE', NULL),
(38, 2, 'OCROS', NULL),
(39, 2, 'PALLASCA', NULL),
(40, 2, 'PAMPAROMAS', NULL),
(41, 2, 'POMABAMBA', NULL),
(42, 2, 'RECUAY', NULL),
(43, 2, 'SAN MARCOS', NULL),
(44, 2, 'SANTA', NULL),
(45, 2, 'SANTA', NULL),
(46, 2, 'SIHUAS', NULL),
(47, 2, 'YUNGAR', NULL),
(48, 2, 'YUNGAY', NULL),
(49, 2, 'YURACMARCA', NULL),
(50, 3, 'ABANCAY', NULL),
(51, 3, 'ANCO-HUALLO', NULL),
(52, 3, 'ANDAHUAYLAS', NULL),
(53, 3, 'ANTABAMBA', NULL),
(54, 3, 'AYMARAES', NULL),
(55, 3, 'CHALHUANCA', NULL),
(56, 3, 'CHALLHUAHUACHO', NULL),
(57, 3, 'CHINCHEROS', NULL),
(58, 3, 'CHUQUIBAMBILLA', NULL),
(59, 3, 'COTABAMBAS', NULL),
(60, 3, 'GRAU', NULL),
(61, 4, 'ACARI', NULL),
(62, 4, 'ALTO SELVA ALEGRE', NULL),
(63, 4, 'APLAO', NULL),
(64, 4, 'AREQUIPA', NULL),
(65, 4, 'ATIQUIPA', NULL),
(66, 4, 'BELLA UNION', NULL),
(67, 4, 'CAMANA', NULL),
(68, 4, 'CARAVELI', NULL),
(69, 4, 'CASTILLA', NULL),
(70, 4, 'CAYLLOMA', NULL),
(71, 4, 'CAYLLOMA', NULL),
(72, 4, 'CAYMA', NULL),
(73, 4, 'CERRO COLORADO', NULL),
(74, 4, 'CHALA', NULL),
(75, 4, 'CHAPARRA', NULL),
(76, 4, 'CHARACATO', NULL),
(77, 4, 'CHIVAY', NULL),
(78, 4, 'COCACHACRA', NULL),
(79, 4, 'CONDESUYOS', NULL),
(80, 4, 'ISLAY', NULL),
(81, 4, 'ISLAY', NULL),
(82, 4, 'JACOBO HUNTER', NULL),
(83, 4, 'JOSE LUIS BUSTAMANTE Y RIVERO', NULL),
(84, 4, 'LA JOYA', NULL),
(85, 4, 'LA UNION', NULL),
(86, 4, 'MARIANO MELGAR', NULL),
(87, 4, 'MARIANO NICOLAS VALCARCEL', NULL),
(88, 4, 'MOLLENDO', NULL),
(90, 4, 'ORCOPAMPA', NULL),
(91, 4, 'SABANDIA', NULL),
(92, 4, 'SACHACA', NULL),
(93, 4, 'SANTA RITA DE SIGUAS', NULL),
(94, 4, 'SOCABAYA', NULL),
(95, 4, 'TIABAYA', NULL),
(96, 4, 'YANAHUARA', NULL),
(97, 4, 'YAUCA', NULL),
(98, 4, 'YURA', NULL),
(99, 5, 'AYACUCHO', NULL),
(100, 5, 'AYAHUANCO', NULL),
(101, 5, 'CANGALLO', NULL),
(102, 5, 'CORACORA', NULL),
(103, 5, 'HUAMANGA', NULL),
(104, 5, 'HUAMANGUILLA', NULL),
(105, 5, 'HUANCA SANCOS', NULL),
(106, 5, 'HUANTA', NULL),
(107, 5, 'HUANTA', NULL),
(108, 5, 'JESUS NAZARENO', NULL),
(109, 5, 'LA MAR', NULL),
(110, 5, 'LUCANAS', NULL),
(111, 5, 'LUCANAS', NULL),
(112, 5, 'OYOLO', NULL),
(113, 5, 'PARINACOCHAS', NULL),
(114, 5, 'PAUCAR DEL SARA SARA', NULL),
(115, 5, 'PULLO', NULL),
(116, 5, 'PUQUIO', NULL),
(117, 5, 'SAMUGARI', NULL),
(118, 5, 'SAN PEDRO', NULL),
(119, 5, 'SAN PEDRO DE PALCO', NULL),
(120, 5, 'SANCOS', NULL),
(121, 5, 'SUCRE', NULL),
(122, 5, 'TAMBO', NULL),
(123, 5, 'VICTOR FAJARDO', NULL),
(124, 5, 'VILCAS HUAMAN', NULL),
(125, 6, 'BAMBAMARCA', NULL),
(126, 6, 'BELLAVISTA', NULL),
(127, 6, 'CAJABAMBA', NULL),
(128, 6, 'CAJABAMBA', NULL),
(129, 6, 'CAJAMARCA', NULL),
(130, 6, 'CELENDIN', NULL),
(131, 6, 'CHANCAY', NULL),
(132, 6, 'CHOTA', NULL),
(133, 6, 'CONTUMAZA', NULL),
(134, 6, 'CUTERVO', NULL),
(135, 6, 'HUALGAYOC', NULL),
(136, 6, 'JAEN', NULL),
(137, 6, 'JAEN', NULL),
(138, 6, 'LA ESPERANZA', NULL),
(140, 6, 'PEDRO GALVEZ', NULL),
(141, 6, 'PUCARA', NULL),
(142, 6, 'SAN IGNACIO', NULL),
(143, 6, 'SAN MARCOS', NULL),
(144, 6, 'SAN MIGUEL', NULL),
(145, 6, 'SAN PABLO', NULL),
(146, 6, 'SANTA CRUZ', NULL),
(147, 6, 'SANTA CRUZ DE TOLED', NULL),
(148, 7, 'BELLAVISTA', NULL),
(149, 7, 'CALLAO', NULL),
(150, 7, 'CARMEN DE LA LEGUA', NULL),
(151, 7, 'LA PERLA', NULL),
(152, 7, 'LA PUNTA', NULL),
(153, 7, 'VENTANILLA', NULL),
(154, 8, 'ACOMAYO', NULL),
(155, 8, 'ANCAHUASI', NULL),
(156, 8, 'ANTA', NULL),
(157, 8, 'ANTA', NULL),
(158, 8, 'CACHIMAYO', NULL),
(159, 8, 'CALCA', NULL),
(160, 8, 'CANAS', NULL),
(161, 8, 'CANCHIS', NULL),
(162, 8, 'CHINCHERO', NULL),
(163, 8, 'CHUMBIVILCAS', NULL),
(164, 8, 'CUSCO', NULL),
(165, 8, 'ECHARATE', NULL),
(166, 8, 'ESPINAR', NULL),
(167, 8, 'HUAYLLABAMBA', NULL),
(168, 8, 'LA CONVENCION', NULL),
(169, 8, 'MACHUPICCHU', NULL),
(170, 8, 'OLLANTAYTAMBO', NULL),
(171, 8, 'PARURO', NULL),
(172, 8, 'PAUCARTAMBO', NULL),
(173, 8, 'QUISPICANCHI', NULL),
(174, 8, 'SAN JERONIMO', NULL),
(175, 8, 'SAN SEBASTIAN', NULL),
(176, 8, 'SANTA TERESA', NULL),
(177, 8, 'SANTIAGO', NULL),
(178, 8, 'SANTO TOMAS', NULL),
(179, 8, 'SAYLLA', NULL),
(180, 8, 'SICUANI', NULL),
(181, 8, 'URUBAMBA', NULL),
(182, 8, 'URUBAMBA', NULL),
(183, 8, 'VELILLE', NULL),
(184, 8, 'WANCHAQ', NULL),
(185, 9, 'ACOBAMBA', NULL),
(186, 9, 'ANGARAES', NULL),
(187, 9, 'CASTROVIRREYNA', NULL),
(188, 9, 'CHURCAMPA', NULL),
(189, 9, 'COSME', NULL),
(190, 9, 'HUACHOCOLPA', NULL),
(191, 9, 'HUANCAVELICA', NULL),
(192, 9, 'HUAYTARA', NULL),
(193, 9, 'IZCUCHACA', NULL),
(194, 9, 'LA MERCED', NULL),
(195, 9, 'LIRCAY', NULL),
(196, 9, 'PAMPAS', NULL),
(197, 9, 'PAUCARA', NULL),
(198, 9, 'SANTA ANA', NULL),
(199, 9, 'TAYACAJA', NULL),
(200, 10, 'AMARILIS', NULL),
(201, 10, 'AMBO', NULL),
(202, 10, 'CONCHAMARCA', NULL),
(203, 10, 'DOS DE MAYO', NULL),
(204, 10, 'HUACAYBAMBA', NULL),
(205, 10, 'HUAMALIES', NULL),
(206, 10, 'HUANUCO', NULL),
(207, 10, 'LAURICOCHA', NULL),
(208, 10, 'LEONCIO PRADO', NULL),
(209, 10, 'LLATA', NULL),
(211, 10, 'MIRAFLORES', NULL),
(212, 10, 'MONZON', NULL),
(213, 10, 'PACHITEA', NULL),
(214, 10, 'PANAO', NULL),
(215, 10, 'PUERTO INCA', NULL),
(216, 10, 'RUPA-RUPA', NULL),
(217, 10, 'TINGO MARIA', NULL),
(218, 10, 'YACUS', NULL),
(219, 10, 'YAROWILCA', NULL),
(220, 11, 'ALTO LARAN', NULL),
(221, 11, 'CHINCHA', NULL),
(222, 11, 'CHINCHA ALTA', NULL),
(223, 11, 'CHINCHA BAJA', NULL),
(224, 11, 'GROCIO PRADO', NULL),
(225, 11, 'HUANCANO', NULL),
(226, 11, 'ICA', NULL),
(227, 11, 'INDEPENDENCIA', NULL),
(229, 11, 'LOS AQUIJES', NULL),
(230, 11, 'MARCONA', NULL),
(231, 11, 'NAZCA', NULL),
(232, 11, 'NAZCA', NULL),
(233, 11, 'PALPA', NULL),
(234, 11, 'PARACAS', NULL),
(235, 11, 'PARCONA', NULL),
(236, 11, 'PISCO', NULL),
(237, 11, 'PISCO', NULL),
(238, 11, 'PUEBLO NUEVO', NULL),
(239, 11, 'SAN ANDRES', NULL),
(240, 11, 'SAN JOSE DE LOS MOLINOS', NULL),
(241, 11, 'SAN JUAN BAUTISTA', NULL),
(242, 11, 'SUBTANJALLA', NULL),
(243, 11, 'SUNAMPE', NULL),
(244, 11, 'TAMBO DE MORA', NULL),
(245, 12, 'CARHUAMAYO', NULL),
(246, 12, 'CHANCHAMAYO', NULL),
(247, 12, 'CHUPACA', NULL),
(248, 12, 'CHUPURO', NULL),
(249, 12, 'CONCEPCION', NULL),
(250, 12, 'EL TAMBO', NULL),
(251, 12, 'HUANCAYO', NULL),
(252, 12, 'HUAY-HUAY', NULL),
(253, 12, 'JAUJA', NULL),
(254, 12, 'JUNIN', NULL),
(255, 12, 'LA OROYA', NULL),
(256, 12, 'LA UNION', NULL),
(257, 12, 'MOROCOCHA', NULL),
(258, 12, 'PANGOA', NULL),
(259, 12, 'PERENE', NULL),
(260, 12, 'PICHANAQUI', NULL),
(261, 12, 'RIO TAMBO', NULL),
(262, 12, 'SAN JERONIMO DE TUNAN', NULL),
(263, 12, 'SAN RAMON', NULL),
(264, 12, 'SANTA BARBARA DE CARHUACAYAN', NULL),
(265, 12, 'SATIPO', NULL),
(266, 12, 'SICAYA', NULL),
(267, 12, 'TARMA', NULL),
(268, 12, 'YAULI', NULL),
(269, 12, 'YAULI', NULL),
(270, 12, 'YAUYOS', NULL),
(271, 13, 'ASCOPE', NULL),
(272, 13, 'BOLIVAR', NULL),
(273, 13, 'CACHICADAN', NULL),
(274, 13, 'CASA GRANDE', NULL),
(275, 13, 'CASCAS', NULL),
(276, 13, 'CHAO', NULL),
(277, 13, 'CHEPEN', NULL),
(278, 13, 'CHICAMA', NULL),
(279, 13, 'CHOCOPE', NULL),
(280, 13, 'CURGOS', NULL),
(281, 13, 'FLORENCIA DE MORA', NULL),
(282, 13, 'GRAN CHIMU', NULL),
(283, 13, 'GUADALUPE', NULL),
(284, 13, 'HUAMACHUCO', NULL),
(285, 13, 'HUANCHACO', NULL),
(286, 13, 'JULCAN', NULL),
(287, 13, 'LAREDO', NULL),
(288, 13, 'MOCHE', NULL),
(289, 13, 'OTUZCO', NULL),
(290, 13, 'PACASMAYO', NULL),
(291, 13, 'PACASMAYO', NULL),
(292, 13, 'PARCOY', NULL),
(293, 13, 'PATAZ', NULL),
(294, 13, 'PATAZ', NULL),
(295, 13, 'RAZURI', NULL),
(296, 13, 'SALAVERRY', NULL),
(297, 13, 'SAN JOSE', NULL),
(298, 13, 'SAN PEDRO DE LLOC', NULL),
(299, 13, 'SANCHEZ CARRION', NULL),
(300, 13, 'SANTIAGO DE CAO', NULL),
(301, 13, 'SANTIAGO DE CHUCO', NULL),
(302, 13, 'TRUJILLO', NULL),
(303, 13, 'USQUIL', NULL),
(304, 13, 'VICTOR LARCO HERRERA', NULL),
(305, 13, 'VIRU', NULL),
(306, 14, 'CHICLAYO', NULL),
(307, 14, 'CHONGOYAPE', NULL),
(309, 14, 'JAYANCA', NULL),
(310, 14, 'JOSE LEONARDO ORTIZ', NULL),
(311, 14, 'LA VICTORIA', NULL),
(312, 14, 'LAMBAYEQUE', NULL),
(313, 14, 'MORROPE', NULL),
(314, 14, 'MOTUPE', NULL),
(315, 14, 'OLMOS', NULL),
(316, 14, 'PIMENTEL', NULL),
(317, 14, 'POMALCA', NULL),
(318, 14, 'SALAS', NULL),
(320, 15, 'AMBAR', '2022-03-13 14:21:20'),
(321, 15, 'ANCÓN', NULL),
(322, 15, 'ASIA', '2022-03-13 14:21:28'),
(323, 15, 'ATAVILLOS BAJO', '2022-03-13 14:21:32'),
(324, 15, 'ATE VITARTE', NULL),
(325, 27, 'BARRANCA', NULL),
(326, 15, 'BREÑA', NULL),
(327, 15, 'BARRANCO', NULL),
(329, 27, 'CAJATAMBO', NULL),
(330, 27, 'CANTA', NULL),
(332, 15, 'CARABAYLLO', NULL),
(333, 15, 'CERRO AZUL', '2022-03-13 14:22:23'),
(334, 15, 'CHACLACAYO', NULL),
(335, 15, 'CERCADO DE LIMA', NULL),
(336, 27, 'CAÑETE', NULL),
(337, 15, 'CHILCA', '2022-03-13 14:23:23'),
(338, 15, 'CHORRILLOS', NULL),
(339, 15, 'CIENEGUILLA', NULL),
(340, 15, 'COMAS', NULL),
(341, 15, 'EL AGUSTINO', NULL),
(342, 27, 'HUARAL', NULL),
(343, 27, 'HUAROCHIRÍ', NULL),
(344, 27, 'HUAURA', NULL),
(345, 15, 'HUAURA', '2022-03-13 14:23:59'),
(346, 15, 'IMPERIAL', '2022-03-13 14:24:01'),
(347, 15, 'INDEPENDENCIA', NULL),
(348, 15, 'JESÚS MARÍA', NULL),
(349, 15, 'LA MOLINA', NULL),
(350, 15, 'LA VICTORIA', NULL),
(351, 15, 'LAMPIAN', '2022-03-13 14:24:23'),
(352, 15, 'LIMA', '2022-03-13 14:24:26'),
(353, 15, 'LINCE', NULL),
(354, 15, 'LOS OLIVOS', NULL),
(355, 15, 'LUNAHUANA', '2022-03-13 14:24:35'),
(356, 15, 'LURIGANCHO', NULL),
(357, 15, 'LURÍN', NULL),
(358, 15, 'MAGDALENA DEL MAR', NULL),
(359, 15, 'MALA', '2022-03-13 14:24:57'),
(360, 15, 'MATUCANA', '2022-03-13 14:25:03'),
(361, 15, 'MIRAFLORES', NULL),
(362, 15, 'NUEVO IMPERIAL', '2022-03-13 14:25:16'),
(363, 27, 'OYÓN', NULL),
(364, 15, 'PACHACAMAC', NULL),
(365, 15, 'PARAMONGA', '2022-03-13 14:25:21'),
(366, 15, 'PATIVILCA', '2022-03-13 14:25:24'),
(367, 26, 'PUCUSANA', NULL),
(368, 15, 'PUEBLO LIBRE', NULL),
(369, 15, 'PUENTE PIEDRA', NULL),
(370, 26, 'PUNTA HERMOSA', NULL),
(371, 26, 'PUNTA NEGRA', NULL),
(372, 15, 'QUILMANA', '2022-03-13 14:25:42'),
(373, 15, 'RÍMAC', NULL),
(374, 26, 'SAN BARTOLO', NULL),
(375, 15, 'SAN BORJA', NULL),
(376, 15, 'SAN ISIDRO', NULL),
(377, 15, 'SAN JUAN DE LURIGANCHO', NULL),
(378, 15, 'SAN JUAN DE MIRAFLORES', NULL),
(379, 15, 'SAN LUIS', NULL),
(380, 15, 'SAN MARTIN DE PORRES', NULL),
(381, 15, 'SAN MATEO', '2022-03-13 14:26:16'),
(382, 15, 'SAN MIGUEL', NULL),
(384, 15, 'SANTA ANITA', NULL),
(385, 26, 'SANTA MARÍA DEL MAR', NULL),
(386, 15, 'SANTA ROSA', NULL),
(387, 15, 'SANTIAGO DE SURCO', NULL),
(388, 15, 'SANTIAGO DE TUNA', '2022-03-13 14:26:34'),
(389, 15, 'SUPE', '2022-03-13 14:26:36'),
(390, 15, 'SUPE PUERTO', '2022-03-13 14:26:39'),
(391, 15, 'SURQUILLO', NULL),
(392, 15, 'VILLA EL SALVADOR', NULL),
(393, 15, 'VILLA MARIA DEL TRIUNFO', NULL),
(394, 27, 'YAUYOS', NULL),
(395, 16, 'ALTO AMAZONAS', NULL),
(396, 16, 'BARRANCA', NULL),
(398, 16, 'IQUITOS', NULL),
(399, 16, 'LORETO', NULL),
(400, 16, 'MARISCAL RAMON CASTILLA', NULL),
(401, 16, 'MAYNAS', NULL),
(402, 16, 'NAUTA', NULL),
(403, 16, 'PUNCHANA', NULL),
(404, 16, 'REQUENA', NULL),
(405, 16, 'UCAYALI', NULL),
(406, 16, 'YURIMAGUAS', NULL),
(407, 17, 'IBERIA', NULL),
(409, 17, 'MADRE DE DIOS    ', NULL),
(410, 17, 'MANU', NULL),
(411, 17, 'MANU    ', NULL),
(412, 17, 'TAHUAMANU', NULL),
(413, 17, 'TAMBOPATA', NULL),
(414, 18, 'GENERAL SANCHEZ CERRO', NULL),
(416, 18, 'ILO', NULL),
(417, 18, 'MARISCAL NIETO', NULL),
(418, 18, 'MOQUEGUA', NULL),
(419, 18, 'OMATE', NULL),
(420, 18, 'SAMEGUA', NULL),
(421, 18, 'TORATA', NULL),
(422, 19, 'CHACAYAN', NULL),
(423, 19, 'CHONTABAMBA', NULL),
(425, 19, 'DANIEL ALCIDES CARRION', NULL),
(426, 19, 'GOYLLARISQUIZGA', NULL),
(427, 19, 'HUACHON', NULL),
(428, 19, 'HUARIACA', NULL),
(429, 19, 'HUAYLLAY', NULL),
(430, 19, 'OXAPAMPA', NULL),
(431, 19, 'PALCAZU', NULL),
(432, 19, 'PASCO', NULL),
(433, 19, 'PAUCAR', NULL),
(434, 19, 'SAN FRANCISCO DE ASIS DE YARUSYACAN', NULL),
(435, 19, 'SANTA ANA DE TUSI', NULL),
(436, 19, 'SIMON BOLIVAR', NULL),
(437, 19, 'TINYAHUARCO', NULL),
(438, 19, 'VILLA RICA', NULL),
(439, 19, 'YANACANCHA', NULL),
(440, 19, 'YANAHUANCA', NULL),
(441, 20, 'AYABACA', NULL),
(442, 20, 'CASTILLA', NULL),
(443, 20, 'CATACAOS', NULL),
(444, 20, 'CHULUCANAS', NULL),
(445, 20, 'EL ALTO', NULL),
(446, 20, 'HUANCABAMBA', NULL),
(447, 20, 'HUARMACA', NULL),
(448, 20, 'LA BREA', NULL),
(449, 20, 'LA MATANZA', NULL),
(450, 20, 'LA UNION', NULL),
(451, 20, 'LOS ORGANOS', NULL),
(452, 20, 'MANCORA', NULL),
(453, 20, 'MORROPON', NULL),
(454, 20, 'MORROPON', NULL),
(455, 20, 'PAITA', NULL),
(457, 20, 'PIURA', NULL),
(458, 20, 'RINCONADA LLICUAR', NULL),
(459, 20, 'SECHURA', NULL),
(460, 20, 'SONDORILLO', NULL),
(461, 20, 'SULLANA', NULL),
(462, 20, 'TALARA', NULL),
(463, 20, 'TAMBO GRANDE', NULL),
(464, 21, 'AJOYANI', NULL),
(465, 21, 'ANTAUTA', NULL),
(466, 21, 'ASILLO', NULL),
(467, 21, 'AYAVIRI', NULL),
(468, 21, 'AZANGARO', NULL),
(469, 21, 'AZANGARO', NULL),
(470, 21, 'CABANILLAS', NULL),
(471, 21, 'CARABAYA', NULL),
(472, 21, 'CARACOTO', NULL),
(473, 21, 'CHUCUITO', NULL),
(474, 21, 'COATA', NULL),
(475, 21, 'DESAGUADERO', NULL),
(476, 21, 'EL COLLAO', NULL),
(477, 21, 'HUANCANE', NULL),
(478, 21, 'ILAVE', NULL),
(479, 21, 'JULI', NULL),
(480, 21, 'JULIACA', NULL),
(481, 21, 'LAMPA', NULL),
(482, 21, 'MACUSANI', NULL),
(484, 21, 'MELGAR', NULL),
(485, 21, 'MOHO', NULL),
(487, 21, 'OLLACHEA', NULL),
(488, 21, 'PUNO', NULL),
(489, 21, 'PUTINA', NULL),
(490, 21, 'SAN ANTONIO DE PUTINA', NULL),
(491, 21, 'SAN GABAN', NULL),
(492, 21, 'SAN ROMAN', NULL),
(493, 21, 'SANDIA', NULL),
(494, 21, 'TARACO', NULL),
(495, 21, 'YUNGUYO', NULL),
(496, 21, 'YUNGUYO', NULL),
(497, 22, 'BELLAVISTA', NULL),
(498, 22, 'EL DORADO', NULL),
(499, 22, 'EL PORVENIR', NULL),
(500, 22, 'HUALLAGA', NULL),
(501, 22, 'JUANJUI', NULL),
(502, 22, 'LAMAS', NULL),
(503, 22, 'MARISCAL CACERES', NULL),
(504, 22, 'MOYOBAMBA', NULL),
(505, 22, 'NUEVA CAJAMARCA', NULL),
(506, 22, 'PICOTA', NULL),
(507, 22, 'PICOTA', NULL),
(508, 22, 'RIOJA', NULL),
(509, 22, 'RIOJA', NULL),
(510, 22, 'SAN JOSE DE SISA', NULL),
(511, 22, 'SAN MARTIN', NULL),
(512, 22, 'TARAPOTO', NULL),
(513, 22, 'TOCACHE', NULL),
(514, 22, 'UCHIZA', NULL),
(515, 23, 'CANDARAVE', NULL),
(516, 23, 'CORONEL GREGORIO ALBARRACIN LANCHIPA', NULL),
(517, 23, 'ESTIQUE', NULL),
(518, 23, 'ILABAYA', NULL),
(519, 23, 'JORGE BASADRE', NULL),
(520, 23, 'PACHIA', NULL),
(521, 23, 'PALCA', NULL),
(522, 23, 'TACNA', NULL),
(523, 23, 'TARATA', NULL),
(524, 24, 'CONTRALMIRANTE VILLAR', NULL),
(525, 24, 'TUMBES', NULL),
(526, 24, 'ZARUMILLA', NULL),
(527, 25, 'ATALAYA', NULL),
(528, 25, 'CORONEL PORTILLO', NULL),
(529, 25, 'PADRE ABAD', NULL),
(530, 25, 'PURUS', NULL),
(531, 7, 'MI PERÚ', NULL),
(532, 28, 'OTROS', NULL),
(533, 15, 'VENTANILLA', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(200) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2021_02_27_213110_create_alumnos_table', 1),
(4, '2021_02_27_213535_create_alumno_avisos_table', 1),
(5, '2021_02_27_213551_create_alumno_habilidads_table', 1),
(6, '2021_02_27_215354_create_avisos_table', 1),
(7, '2021_02_27_215407_create_empresas_table', 1),
(8, '2021_02_27_215445_create_estados_table', 1),
(9, '2021_02_27_215500_create_experiencia_laborals_table', 1),
(10, '2021_02_27_215522_create_habilidads_table', 1),
(11, '2021_02_27_215542_create_referencias_table', 1),
(12, '2021_03_08_214534_create_areas_table', 1),
(13, '2021_03_08_214723_create_provincias_table', 1),
(14, '2021_03_08_214745_create_distritos_table', 1),
(15, '2021_03_08_214812_create_horarios_table', 1),
(16, '2021_03_09_081132_create_modalidads_table', 1),
(17, '2021_03_09_081202_create_condicions_table', 1),
(18, '2021_03_09_150419_create_cargos_table', 2),
(19, '2021_03_11_225431_create_educacions_table', 3),
(20, '2021_03_11_225531_create_referencia_laborals_table', 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `opinions`
--

CREATE TABLE `opinions` (
  `id` bigint(11) NOT NULL,
  `opinion` varchar(250) NOT NULL,
  `rating` varchar(10) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(200) NOT NULL,
  `token` varchar(200) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `profiles`
--

CREATE TABLE `profiles` (
  `id` bigint(20) NOT NULL,
  `name` varchar(250) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Volcado de datos para la tabla `profiles`
--

INSERT INTO `profiles` (`id`, `name`, `deleted_at`) VALUES
(1, 'DESARROLLADOR', NULL),
(2, 'ADMINISTRADOR', NULL),
(3, 'LIDER', NULL),
(4, 'TIMOTEO', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `programas`
--

CREATE TABLE `programas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `registro` varchar(250) DEFAULT NULL,
  `tipo_programa` varchar(250) NOT NULL DEFAULT '1',
  `empresa` varchar(250) DEFAULT NULL,
  `puestouno` varchar(250) DEFAULT NULL,
  `puestodos` varchar(250) DEFAULT NULL,
  `puestotres` varchar(250) DEFAULT NULL,
  `puestocuatro` varchar(250) DEFAULT NULL,
  `responsable` varchar(250) NOT NULL DEFAULT '1',
  `postulantes` varchar(250) DEFAULT NULL,
  `evaluando` varchar(250) DEFAULT NULL,
  `contratados` varchar(250) DEFAULT NULL,
  `descartado` varchar(250) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `programas`
--

INSERT INTO `programas` (`id`, `registro`, `tipo_programa`, `empresa`, `puestouno`, `puestodos`, `puestotres`, `puestocuatro`, `responsable`, `postulantes`, `evaluando`, `contratados`, `descartado`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '2024-08-23', 'Feria laboral', 'prueba', 'prueba', NULL, NULL, NULL, 'Bryan Julcamoro', '1', '1', '1', '1', '2024-07-18 16:32:19', '2024-07-18 16:32:19', NULL),
(2, '2024-09-06', 'Feria laboral', 'a', 'a', 'a', NULL, NULL, 'Bryan Julcamoro', NULL, NULL, NULL, NULL, '2024-09-05 21:31:32', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `provincias`
--

CREATE TABLE `provincias` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(250) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `provincias`
--

INSERT INTO `provincias` (`id`, `nombre`, `deleted_at`) VALUES
(1, 'AMAZONAS', '2022-03-13 07:00:00'),
(2, 'ANCASH', '2022-03-13 07:00:00'),
(3, 'APURIMAC', '2022-03-13 07:00:00'),
(4, 'AREQUIPA', '2022-03-13 07:00:00'),
(5, 'AYACUCHO', '2022-03-13 07:00:00'),
(6, 'CAJAMARCA', '2022-03-13 07:00:00'),
(7, 'CALLAO', NULL),
(8, 'CUSCO', '2022-03-13 07:00:00'),
(9, 'HUANCAVELICA', '2022-03-13 07:00:00'),
(10, 'HUÁNUCO', '2022-03-13 07:00:00'),
(11, 'ICA', '2022-03-13 07:00:00'),
(12, 'JUNÍN', '2022-03-13 07:00:00'),
(13, 'LA LIBERTAD', '2022-03-13 07:00:00'),
(14, 'LAMBAYEQUE', '2022-03-13 07:00:00'),
(15, 'LIMA METROPOLITANA', NULL),
(16, 'LORETO', '2022-03-13 07:00:00'),
(17, 'MADRE DE DIOS', '2022-03-13 07:00:00'),
(18, 'MOQUEGUA', '2022-03-13 07:00:00'),
(19, 'PASCO', '2022-03-13 07:00:00'),
(20, 'PIURA', '2022-03-13 07:00:00'),
(21, 'PUNO', '2022-03-13 07:00:00'),
(22, 'SAN MARTIN', '2022-03-13 07:00:00'),
(23, 'TACNA', '2022-03-13 07:00:00'),
(24, 'TUMBES', '2022-03-13 07:00:00'),
(25, 'UCAYALI', '2022-03-13 07:00:00'),
(26, 'LIMA BALNEARIOS', NULL),
(27, 'LIMA PROVINCIA', NULL),
(28, 'OTROS', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `seguimiento`
--

CREATE TABLE `seguimiento` (
  `id` bigint(20) NOT NULL,
  `celula_id` int(11) NOT NULL,
  `asistente_id` int(11) NOT NULL,
  `fecha_contacto` varchar(50) NOT NULL,
  `tipo_contacto` varchar(50) NOT NULL,
  `detalle` varchar(250) DEFAULT NULL,
  `oracion` varchar(250) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `seguimiento`
--

INSERT INTO `seguimiento` (`id`, `celula_id`, `asistente_id`, `fecha_contacto`, `tipo_contacto`, `detalle`, `oracion`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 2, 18, '2024-09-28', 'Mensaje', 'Aviso de la reunión  de célula aniñándola que participe.', 'Por estudios', '2024-09-29 16:21:48', NULL, NULL),
(2, 2, 19, '2024-09-19', 'Mensaje', 'Recordatorio bíblico y seguimiento de su vida dándole ánimos.', 'Por sus estudios y disponibilidad de tiempo.', '2024-09-29 16:23:07', NULL, NULL),
(3, 2, 22, '2024-09-28', 'Mensaje', 'Aviso de la reunión  de célula aniñándola que participe.', 'Por sus tiempos y estudios.', '2024-09-29 16:24:05', NULL, NULL),
(4, 2, 23, '2024-09-28', 'Mensaje', 'Aviso de la reunión  de célula animandola que participe', 'Por sus tesis y vida espiritual', '2024-09-29 16:24:47', NULL, NULL),
(5, 2, 41, '2024-09-28', 'Mensaje', 'Aviso de la reunión  de célula animandola que participe y apoye en los temas.', 'Por su mudanza y salud.', '2024-09-29 16:25:38', NULL, NULL),
(6, 3, 39, '2024-10-02', 'Mensaje', 'Conversamos de cómo se encontraba', 'Por su nuevo trabajo y por sus tiempos.', '2024-10-02 22:31:35', NULL, NULL),
(7, 3, 47, '2024-10-01', 'Mensaje', 'Conversamos sobre una oportunidad de viaje de trabajó', 'Por sabiduría para saber si el viaje de trabajó es lo correcto.', '2024-10-02 22:33:04', NULL, NULL),
(8, 3, 48, '2024-10-02', 'Llamada', 'Conversamos sobre sus tiempos del trabajo', 'Por su vida espiritual y sus tiempos para el servicio', '2024-10-02 22:34:51', NULL, NULL),
(9, 1, 5, '2024-10-01', 'Mensaje', 'Estuvimos hablando.. y está pasando por problemas con su familia, pagos y su relacion con Dios.. me contó sus cosas para que pueda aliviarse', 'Por su vida espiritual, su corazon y su familia', '2024-10-03 12:16:34', NULL, NULL),
(10, 1, 6, '2024-10-03', 'Mensaje', 'Le hice preguntas de como esta, le compartí, me comento que Estaba a full con sus tiempos por su trabajo', 'Por su mamá que está mal de su rodilla y esta llevando tratamiento', '2024-10-03 21:06:51', NULL, NULL),
(11, 1, 4, '2024-10-03', 'Mensaje', 'Hablamos sobre el versículo proverbios 16:9', 'Por su abuela que se encuentra un poco mal de salud, está hospitalizada.', '2024-10-03 21:08:48', NULL, NULL),
(12, 2, 41, '2024-10-04', 'Mensaje', 'Animandola a que participe del aniversario de Jac', 'Motivos personales de salud y casa.', '2024-10-07 17:31:17', NULL, NULL),
(13, 2, 42, '2024-10-05', 'reunion', 'Visita sobre la restauración en su vida, y animandola a que pueda buscar más del Señor y próximamente que lleve sus clases de Mi nueva Alianza', 'Por su salud sufre de epilepsia, por motivos personales y emocionales y espiritual.', '2024-10-07 17:33:21', NULL, NULL),
(14, 2, 23, '2024-10-06', 'Mensaje', 'Conversación de su vida espiritual', 'Por su próximo bautizo este domingo 13, su tesis y paz en su familia.', '2024-10-07 17:34:23', NULL, NULL),
(15, 2, 42, '2024-11-01', 'Mensaje', 'Seguimiento de cómo iba su proceso de salud', 'Orar por su salud y crisis de epilepsia', '2024-11-03 22:39:55', NULL, NULL),
(16, 6, 74, '2024-11-11', 'reunion', '-', '-', '2024-11-21 13:46:02', NULL, NULL),
(17, 6, 63, '2024-10-06', 'Llamada', '-', '-', '2024-11-21 13:47:21', NULL, NULL),
(18, 6, 53, '2024-10-11', 'Llamada', '-', '-', '2024-11-21 13:48:46', NULL, NULL),
(19, 3, 77, '2024-11-24', 'Mensaje', 'Conversacion de su inasistencia y explicación de su motivo', 'Poder orar por su vida espiritual que el señor fortalezca sus emociones y que sus ojos estén puestos en el señor.', '2024-11-25 20:03:07', NULL, NULL),
(20, 3, 47, '2024-11-23', 'reunion', 'Conversamos antes de la reunión de celula', 'Por sus tiempos para que pueda estar presente en las reuniones de JAC.', '2024-11-25 20:03:50', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_personas`
--

CREATE TABLE `tipo_personas` (
  `id` int(11) NOT NULL,
  `tipo` varchar(250) NOT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `tipo_personas`
--

INSERT INTO `tipo_personas` (`id`, `tipo`, `deleted_at`) VALUES
(1, 'PERSONA JURIDICA', NULL),
(2, 'PERSONA NATURAL', NULL),
(3, 'PERSONA NATURAL CON EMPRESA', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_programas`
--

CREATE TABLE `tipo_programas` (
  `id` bigint(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `estado` varchar(20) NOT NULL DEFAULT 'Activo',
  `created_` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `update_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tipo_programas`
--

INSERT INTO `tipo_programas` (`id`, `nombre`, `estado`, `created_`, `update_at`, `deleted_at`) VALUES
(1, 'EVANGELIZACION', 'Activo', '2024-09-11 15:27:52', NULL, NULL),
(2, 'JAC UNIDO', 'Activo', '2024-09-11 15:28:06', NULL, NULL),
(3, 'CELULAS', 'Activo', '2024-09-11 15:28:29', NULL, NULL),
(4, 'AYUNO', 'Activo', '2024-09-11 15:28:55', NULL, NULL),
(5, 'HOMOGENEO', 'Activo', '2024-09-11 15:30:11', NULL, NULL),
(6, 'OTRO', 'Activo', '2024-09-11 15:30:23', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `profile_id` bigint(20) NOT NULL,
  `nombres` varchar(250) NOT NULL,
  `email` varchar(250) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(200) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `estado` varchar(11) NOT NULL DEFAULT '1',
  `online` varchar(5) DEFAULT '0',
  `inicio_sesion` varchar(250) DEFAULT NULL,
  `cerrar_sesion` varchar(250) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `profile_id`, `nombres`, `email`, `email_verified_at`, `password`, `remember_token`, `estado`, `online`, `inicio_sesion`, `cerrar_sesion`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 'Sebastian Vásquez', 'admin', NULL, '$2y$10$KABbWAD63KNjBVg/eIbNzeg7JzwT7bpwTeERNxV54seGFWWO/Zwea', NULL, '1', '1', '24-12-05 03:49:06', '24-11-13 08:18:13', NULL, '2024-12-05 15:49:06', NULL),
(2, 2, 'Pablo Vera', 'pablo', NULL, '$2y$10$e8EiL7ra1yVEmgnCBjdxF.3euOOFmrHU5mo1ukwkjHiom5swOnemi', NULL, '1', '0', NULL, NULL, '2024-09-18 08:23:27', '2024-09-19 10:49:07', NULL),
(3, 2, 'Belén Llanos', 'belen', NULL, '$2y$10$zvohZLo.vpWMRZVy1uL0WuZ0EWZiCleqHSVbSaMuAI2k76uf25Tni', NULL, '1', '1', '24-11-24 09:58:58', '24-10-04 12:09:25', '2024-09-19 10:49:31', '2024-11-24 21:58:58', NULL),
(4, 3, 'Graciela Becerra', 'graciela', NULL, '$2y$10$wrIbQTe5hZyOsi36XKPhJOt5mJBBIZCwjVOMWpVyZFMV.776plcuC', NULL, '1', '1', '24-11-18 09:59:43', NULL, '2024-09-19 10:49:59', '2024-11-18 21:59:43', NULL),
(5, 3, 'Margiorie Cabrera', 'margiorie', NULL, '$2y$10$euJ.cj5.uFNVXMk78qQCvOUmlNrD9Ncwwr96mdLUOItx8aUx7j/rO', NULL, '1', '1', '24-11-21 08:37:03', NULL, '2024-09-19 10:50:21', '2024-11-21 08:37:03', NULL),
(6, 3, 'Naty Ichigo', 'naty', NULL, '$2y$10$bWyhqmxl4HVvvSB0p3pG9OZoEfnFtI/4YznUTkqLBa8aTAV.5jhcq', NULL, '1', '1', '24-11-16 06:07:52', '24-09-29 10:32:59', '2024-09-19 10:50:41', '2024-11-16 18:07:52', NULL),
(7, 3, 'Angela Salirrosas', 'angela', NULL, '$2y$10$IIvKk3.spiW/L23SpyELUuwaFgVmy6voSRKjH58CLsVnw.GUHyFUK', NULL, '1', '1', '24-11-17 01:04:01', NULL, '2024-09-19 10:51:00', '2024-11-17 01:04:01', NULL),
(8, 3, 'Miguel Ramón', 'miguel', NULL, '$2y$10$OwXL8vbANnR5J/xV9IvP/eNTcKt3Wurxu2ekxmu1DSSrUpSSFTwWu', NULL, '1', '1', '24-11-25 02:51:47', NULL, '2024-09-19 10:51:17', '2024-11-25 14:51:47', NULL),
(9, 3, 'John Trujillo', 'john', NULL, '$2y$10$JZEl/uE.mY.OBA2y3I1MGuA9MRPNlB7g9ZQCwFcgA8vGHmQcJx2Cq', NULL, '1', '1', '24-11-16 06:43:26', NULL, '2024-09-19 10:51:32', '2024-11-16 18:43:26', NULL),
(10, 3, 'Jerry Caramantin', 'jerry', NULL, '$2y$10$BMLY39sw73k4gX4rAgbrieeVOWnAQgPH2IZpx..ByVMOiAvezYA7i', NULL, '1', '1', '24-11-20 08:23:09', '24-11-16 09:17:10', '2024-09-19 10:51:52', '2024-11-20 08:23:09', NULL),
(11, 2, 'Isaí Garay', 'isai', NULL, '$2y$10$fqOCjVRiyB1gm0pBCq9zNuGGLA4n1aYnKJXnD8qwdpX9rgDlpug3m', NULL, '1', '1', '24-11-18 08:44:52', NULL, '2024-09-19 10:52:37', '2024-11-18 20:44:52', NULL),
(12, 3, 'Gabriela Gamarra', 'gabriela', NULL, '$2y$10$N8ZKELdFRKQ1p99/Wt/FeO9jxpll0qEr//gcX9B0TlS9emeymsLa6', NULL, '1', '0', NULL, NULL, '2024-10-04 19:04:48', '2024-10-04 19:04:48', NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `aniversarios`
--
ALTER TABLE `aniversarios`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `asistencias`
--
ALTER TABLE `asistencias`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `asistentes`
--
ALTER TABLE `asistentes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `calendarios`
--
ALTER TABLE `calendarios`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `celulas`
--
ALTER TABLE `celulas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `celula_asistente`
--
ALTER TABLE `celula_asistente`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `configuracions`
--
ALTER TABLE `configuracions`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `distritos`
--
ALTER TABLE `distritos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `distritos_provincia_id_foreign` (`provincia_id`);

--
-- Indices de la tabla `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `opinions`
--
ALTER TABLE `opinions`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indices de la tabla `profiles`
--
ALTER TABLE `profiles`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `programas`
--
ALTER TABLE `programas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `provincias`
--
ALTER TABLE `provincias`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `seguimiento`
--
ALTER TABLE `seguimiento`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tipo_personas`
--
ALTER TABLE `tipo_personas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tipo_programas`
--
ALTER TABLE `tipo_programas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `aniversarios`
--
ALTER TABLE `aniversarios`
  MODIFY `id` bigint(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;

--
-- AUTO_INCREMENT de la tabla `asistencias`
--
ALTER TABLE `asistencias`
  MODIFY `id` bigint(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=283;

--
-- AUTO_INCREMENT de la tabla `asistentes`
--
ALTER TABLE `asistentes`
  MODIFY `id` bigint(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT de la tabla `calendarios`
--
ALTER TABLE `calendarios`
  MODIFY `id` bigint(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT de la tabla `celulas`
--
ALTER TABLE `celulas`
  MODIFY `id` bigint(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `celula_asistente`
--
ALTER TABLE `celula_asistente`
  MODIFY `id` bigint(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT de la tabla `configuracions`
--
ALTER TABLE `configuracions`
  MODIFY `id` bigint(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `distritos`
--
ALTER TABLE `distritos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=534;

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `opinions`
--
ALTER TABLE `opinions`
  MODIFY `id` bigint(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `profiles`
--
ALTER TABLE `profiles`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `programas`
--
ALTER TABLE `programas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `provincias`
--
ALTER TABLE `provincias`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT de la tabla `seguimiento`
--
ALTER TABLE `seguimiento`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `tipo_personas`
--
ALTER TABLE `tipo_personas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `tipo_programas`
--
ALTER TABLE `tipo_programas`
  MODIFY `id` bigint(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
