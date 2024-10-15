-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 15-10-2024 a las 04:58:12
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
-- Base de datos: `bdproyect`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `administrador`
--

CREATE TABLE `administrador` (
  `ID` int(11) NOT NULL,
  `Correo` varchar(255) NOT NULL,
  `Contrasena` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `administrador`
--

INSERT INTO `administrador` (`ID`, `Correo`, `Contrasena`) VALUES
(1, 'gabriela@gmail.com', '$2y$10$FVjhFdRhIXOXGuaIqv2xQ.wEu5WSwmLhFlskI.qy3jyXqi2uzYCvq'),
(2, 'sofia@gmail.com', '$2y$10$k7Nds9IXUdOCyiv1Wu.o9eOwIwmOQMJwY8RZYd7OKbjgJA2lezREa'),
(3, 'isabella@gmail.com', '$2y$10$PLtpYE8/nzLNtSYGOde7zOqifoFN0uAv1LUrnsLC0UJx2VaQUkDgu');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE `cliente` (
  `ID` int(11) NOT NULL,
  `Correo` varchar(255) NOT NULL,
  `Contrasena` varchar(255) NOT NULL,
  `Nombre` varchar(100) NOT NULL,
  `Documento` int(11) DEFAULT NULL,
  `Telefono` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Disparadores `cliente`
--
DELIMITER $$
CREATE TRIGGER `after_cliente_update` AFTER UPDATE ON `cliente` FOR EACH ROW BEGIN
    -- Actualiza la tabla registro con los nuevos valores
    UPDATE registro 
    SET nombre = NEW.nombre, 
        documento = NEW.documento, 
        telefono = NEW.telefono
    WHERE correo = OLD.correo; -- Usamos el correo viejo como referencia

END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `factura`
--

CREATE TABLE `factura` (
  `ID` int(11) NOT NULL,
  `Cantidad` int(11) DEFAULT NULL,
  `Precio` int(10) DEFAULT NULL,
  `Nombre` varchar(255) DEFAULT NULL,
  `Documento` varchar(50) DEFAULT NULL,
  `Telefono` varchar(15) DEFAULT NULL,
  `Codigo_Producto` varchar(50) DEFAULT NULL,
  `Imagen` varchar(255) DEFAULT NULL,
  `Total` decimal(10,2) DEFAULT NULL,
  `Correo` varchar(255) DEFAULT NULL,
  `pedido_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inicio_sesion`
--

CREATE TABLE `inicio_sesion` (
  `Correo` varchar(255) NOT NULL,
  `Contrasena` varchar(255) NOT NULL,
  `Rol` enum('administrador','cliente') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `inicio_sesion`
--

INSERT INTO `inicio_sesion` (`Correo`, `Contrasena`, `Rol`) VALUES
('gabriela@gmail.com', '$2y$10$FVjhFdRhIXOXGuaIqv2xQ.wEu5WSwmLhFlskI.qy3jyXqi2uzYCvq', 'administrador'),
('isabella@gmail.com', '$2y$10$PLtpYE8/nzLNtSYGOde7zOqifoFN0uAv1LUrnsLC0UJx2VaQUkDgu', 'administrador'),
('sofia@gmail.com', '$2y$10$k7Nds9IXUdOCyiv1Wu.o9eOwIwmOQMJwY8RZYd7OKbjgJA2lezREa', 'administrador');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inventario`
--

CREATE TABLE `inventario` (
  `ID` int(11) NOT NULL,
  `Codigo_Producto` varchar(50) NOT NULL,
  `Tipo` varchar(255) DEFAULT NULL,
  `Precio` int(10) DEFAULT NULL,
  `Administrador_ID` int(11) DEFAULT NULL,
  `Imagen` varchar(255) DEFAULT NULL,
  `productos_disponibles` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedido`
--

CREATE TABLE `pedido` (
  `ID` int(11) NOT NULL,
  `Codigo_Producto` varchar(50) DEFAULT NULL,
  `Cantidad` int(11) DEFAULT NULL,
  `Precio` int(10) DEFAULT NULL,
  `Imagen` varchar(255) DEFAULT NULL,
  `correo` varchar(255) DEFAULT NULL,
  `Total` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Disparadores `pedido`
--
DELIMITER $$
CREATE TRIGGER `after_insert_pedido` AFTER INSERT ON `pedido` FOR EACH ROW BEGIN
    DECLARE nombre_cliente VARCHAR(100);
    DECLARE documento_cliente VARCHAR(20);
    DECLARE telefono_cliente VARCHAR(20);

    -- Obtener los datos del cliente de la tabla registro
    SELECT nombre, documento, telefono 
    INTO nombre_cliente, documento_cliente, telefono_cliente
    FROM registro 
    WHERE correo = NEW.correo;  -- NEW.correo es el correo del pedido recién insertado

    -- Verificar si se obtuvieron datos del cliente
    IF nombre_cliente IS NOT NULL THEN
        -- Insertar en la tabla factura
        INSERT INTO factura (pedido_id, nombre, documento, telefono, correo, Codigo_Producto, Cantidad, Precio, Imagen, Total)
        VALUES (NEW.ID, nombre_cliente, documento_cliente, telefono_cliente, NEW.correo, NEW.Codigo_Producto, NEW.Cantidad, NEW.Precio, NEW.Imagen, NEW.Total);
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `restar_inventario` AFTER INSERT ON `pedido` FOR EACH ROW BEGIN
    UPDATE inventario
    SET productos_disponibles = productos_disponibles - NEW.Cantidad
    WHERE Codigo_Producto = NEW.Codigo_Producto;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `registro`
--

CREATE TABLE `registro` (
  `ID` int(11) NOT NULL,
  `Correo` varchar(255) NOT NULL,
  `Contrasena` varchar(255) NOT NULL,
  `Rol` enum('administrador','cliente') NOT NULL,
  `Nombre` varchar(100) NOT NULL,
  `Documento` int(11) DEFAULT NULL,
  `Telefono` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `registro`
--

INSERT INTO `registro` (`ID`, `Correo`, `Contrasena`, `Rol`, `Nombre`, `Documento`, `Telefono`) VALUES
(1, 'gabriela@gmail.com', '$2y$10$FVjhFdRhIXOXGuaIqv2xQ.wEu5WSwmLhFlskI.qy3jyXqi2uzYCvq', 'administrador', '', 0, 0),
(2, 'sofia@gmail.com', '$2y$10$k7Nds9IXUdOCyiv1Wu.o9eOwIwmOQMJwY8RZYd7OKbjgJA2lezREa', 'administrador', '', 0, 0),
(3, 'isabella@gmail.com', '$2y$10$PLtpYE8/nzLNtSYGOde7zOqifoFN0uAv1LUrnsLC0UJx2VaQUkDgu', 'administrador', '', 0, 0);

--
-- Disparadores `registro`
--
DELIMITER $$
CREATE TRIGGER `after_insert_registro` AFTER INSERT ON `registro` FOR EACH ROW BEGIN
    -- Inserta primero en inicio_sesion
    INSERT INTO inicio_sesion (Correo, Contrasena, Rol) 
    VALUES (NEW.Correo, NEW.Contrasena, NEW.Rol);

    -- Luego inserta en cliente
    INSERT INTO cliente (Nombre, Documento, Telefono, Correo, Contrasena) 
    VALUES (NEW.Nombre, NEW.Documento, NEW.Telefono, NEW.Correo, NEW.Contrasena);
END
$$
DELIMITER ;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `administrador`
--
ALTER TABLE `administrador`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `Correo` (`Correo`);

--
-- Indices de la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `Correo` (`Correo`),
  ADD UNIQUE KEY `Documento` (`Documento`),
  ADD UNIQUE KEY `UC_correo` (`Correo`);

--
-- Indices de la tabla `factura`
--
ALTER TABLE `factura`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `fk_pedido` (`pedido_id`);

--
-- Indices de la tabla `inicio_sesion`
--
ALTER TABLE `inicio_sesion`
  ADD PRIMARY KEY (`Correo`),
  ADD UNIQUE KEY `Correo` (`Correo`);

--
-- Indices de la tabla `inventario`
--
ALTER TABLE `inventario`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `Codigo_Producto` (`Codigo_Producto`),
  ADD KEY `Administrador_ID` (`Administrador_ID`);

--
-- Indices de la tabla `pedido`
--
ALTER TABLE `pedido`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `Codigo_Producto` (`Codigo_Producto`),
  ADD KEY `FK_Pedido_Cliente_Correo` (`correo`);

--
-- Indices de la tabla `registro`
--
ALTER TABLE `registro`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `Correo` (`Correo`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `administrador`
--
ALTER TABLE `administrador`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `cliente`
--
ALTER TABLE `cliente`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `factura`
--
ALTER TABLE `factura`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `inventario`
--
ALTER TABLE `inventario`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `pedido`
--
ALTER TABLE `pedido`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `registro`
--
ALTER TABLE `registro`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `administrador`
--
ALTER TABLE `administrador`
  ADD CONSTRAINT `administrador_ibfk_1` FOREIGN KEY (`Correo`) REFERENCES `inicio_sesion` (`Correo`);

--
-- Filtros para la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD CONSTRAINT `cliente_ibfk_1` FOREIGN KEY (`Correo`) REFERENCES `inicio_sesion` (`Correo`);

--
-- Filtros para la tabla `factura`
--
ALTER TABLE `factura`
  ADD CONSTRAINT `fk_pedido` FOREIGN KEY (`pedido_id`) REFERENCES `pedido` (`ID`) ON DELETE CASCADE;

--
-- Filtros para la tabla `inicio_sesion`
--
ALTER TABLE `inicio_sesion`
  ADD CONSTRAINT `inicio_sesion_ibfk_1` FOREIGN KEY (`Correo`) REFERENCES `registro` (`Correo`);

--
-- Filtros para la tabla `inventario`
--
ALTER TABLE `inventario`
  ADD CONSTRAINT `inventario_ibfk_1` FOREIGN KEY (`Administrador_ID`) REFERENCES `administrador` (`ID`);

--
-- Filtros para la tabla `pedido`
--
ALTER TABLE `pedido`
  ADD CONSTRAINT `FK_Pedido_Cliente_Correo` FOREIGN KEY (`correo`) REFERENCES `cliente` (`Correo`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pedido_ibfk_1` FOREIGN KEY (`Codigo_Producto`) REFERENCES `inventario` (`Codigo_Producto`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
