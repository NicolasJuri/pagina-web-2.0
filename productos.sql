-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 08-07-2023 a las 18:50:48
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `sitio`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `precio` int(11) NOT NULL,
  `categoria` varchar(255) NOT NULL,
  `comentarios` varchar(255) NOT NULL,
  `imagen` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `nombre`, `precio`, `categoria`, `comentarios`, `imagen`) VALUES
(49, 'Aceite de oliva y girasol Reino de León (Sin T.A.C.C.) x 500 ml', 700, 'Aceites', 'aceite de oliva virgen extra y aceite de girasol, envase PET', '1688572972_nico.png'),
(159, 'Arroz yamaní x 25 kg', 10000, 'Arroz', '', 'yamani-slider.png'),
(160, 'Azucar negra de fantasías x 1Kg', 950, 'Azucar', 'oferta', '1688597179_azucar-negra_1.png'),
(161, 'Almendras guara x 1 kg', 15000, 'Frutos secos', 'OFERTA', '1688597232_almendras-nom-pareil-.png'),
(162, 'Pistacho con cascara x kg', 4000, 'Frutos secos', '', '1688619009_pistacho-cascara.png'),
(163, 'Pistachos pelados x kg', 6000, 'Frutos secos', 'Oferta', '1688619143_pistacho-pelado.png'),
(166, 'Nuez pelada entera x kg', 23121, 'Aceites', '', 'imagen.jpg'),
(167, 'Nuez pecan pelada x kg', 5000, 'Frutos secos', '', '1688620790_nuez-pecan.jpg'),
(169, 'Cafe verde semilla x kg', 3000, 'Granos', '', '1688621896_cafe-verde.jpg'),
(170, 'Almendras con chocolate x kg', 4000, 'Bañados en chocolate', '', '1688655895_almendras-chocolate.png'),
(171, 'Almendras', 6, 'Frutos secos', 'Almendras frescas y crujientes', '1688656634_almendras-nom-pareil-.png');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=176;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
