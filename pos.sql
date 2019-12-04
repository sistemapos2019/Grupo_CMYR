-- phpMyAdmin SQL Dump
-- version 4.6.6
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 03-12-2019 a las 07:16:17
-- Versión del servidor: 5.7.17-log
-- Versión de PHP: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `pos`
--

DELIMITER $$
--
-- Procedimientos
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `calcularTotalOrden` (`LidOrden` INT)  BEGIN

update orden set total=(select sum(d.precioUnitario * d.cantidad) from detalleorden d where d.idOrden=LidOrden) where id=LidOrden;

END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bitacora`
--

CREATE TABLE `bitacora` (
  `id` int(11) NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `fecha` datetime DEFAULT NULL,
  `suceso` varchar(245) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `bitacora`
--

INSERT INTO `bitacora` (`id`, `idUsuario`, `fecha`, `suceso`) VALUES
(1, 1, '2019-12-03 01:15:44', 'Ingresó al sistema');

--
-- Disparadores `bitacora`
--
DELIMITER $$
CREATE TRIGGER `bitacora_BEFORE_INSERT` BEFORE INSERT ON `bitacora` FOR EACH ROW BEGIN
SET NEW.fecha = now();
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

CREATE TABLE `categoria` (
  `id` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compra`
--

CREATE TABLE `compra` (
  `id` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `Ndocumento` varchar(45) DEFAULT NULL,
  `NRC` varchar(45) DEFAULT NULL,
  `NITDUI` varchar(45) DEFAULT NULL,
  `nombreProveedor` varchar(145) NOT NULL,
  `montoInterno` decimal(10,4) NOT NULL,
  `iva` decimal(8,2) NOT NULL,
  `percepcion` decimal(8,2) NOT NULL,
  `total` decimal(8,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `dashboardllevar`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `dashboardllevar` (
`IdOrden` int(11)
,`Mesero` varchar(145)
,`Cliente` varchar(145)
,`Total` decimal(8,2)
,`Estado` varchar(2)
,`TiempoPreparado` decimal(17,1)
,`Preparado` varchar(8)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `dashboardprincipal`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `dashboardprincipal` (
`IdOrden` int(11)
,`Mesa` int(11)
,`Mesero` varchar(145)
,`Cliente` varchar(145)
,`Total` decimal(8,2)
,`Estado` varchar(2)
,`llevar` int(11)
,`TiempoPreparado` decimal(17,1)
,`Preparado` varchar(8)
,`TiempoRapido` decimal(17,1)
,`Rapido` varchar(8)
,`tipo` varchar(6)
);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detallecompra`
--

CREATE TABLE `detallecompra` (
  `idCompra` int(11) NOT NULL,
  `idProducto` int(11) NOT NULL,
  `cantidad` decimal(8,2) NOT NULL,
  `precioUnitario` decimal(8,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Disparadores `detallecompra`
--
DELIMITER $$
CREATE TRIGGER `detallecompra_AFTER_INSERT` AFTER INSERT ON `detallecompra` FOR EACH ROW BEGIN
update producto set inventario=inventario+new.cantidad where id=new.idProducto;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalleorden`
--

CREATE TABLE `detalleorden` (
  `idOrden` int(11) NOT NULL,
  `idProducto` int(11) NOT NULL,
  `cantidad` decimal(5,1) NOT NULL,
  `precioUnitario` decimal(8,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Disparadores `detalleorden`
--
DELIMITER $$
CREATE TRIGGER `detalleorden_AFTER_DELETE` AFTER DELETE ON `detalleorden` FOR EACH ROW BEGIN
call calcularTotalOrden(old.idOrden);
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `detalleorden_AFTER_INSERT` AFTER INSERT ON `detalleorden` FOR EACH ROW BEGIN
declare tipoP int;
declare Linventario int;
	set tipoP=(select preparado from producto where id=new.idProducto);
	if tipoP=1 then
		update orden set tiempoPreparado=now() where id=new.idOrden;
    else
    		update orden set tiempoRapido=now() where id=new.idOrden;
    end if;
    set Linventario=(select inventario from producto where id=new.idProducto);
    set Linventario=Linventario - new.cantidad;
    if Linventario<0 then
		set Linventario=0;
	end if;
    update producto set inventario=Linventario where id=new.idProducto;
    call calcularTotalOrden(new.idOrden);
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `detalleorden_AFTER_UPDATE` AFTER UPDATE ON `detalleorden` FOR EACH ROW BEGIN
declare tipoP int;
	set tipoP=(select preparado from producto where id=new.idProducto);
	if tipoP=1 then
		update orden set tiempoPreparado=now() where id=new.idOrden;
    else
    		update orden set tiempoRapido=now() where id=new.idOrden;
    end if;
    
    call calcularTotalOrden(new.idOrden);
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `detalleorden_BEFORE_UPDATE` BEFORE UPDATE ON `detalleorden` FOR EACH ROW BEGIN
declare Linventario int;
set Linventario=(select inventario from producto where id=new.idProducto);
    set Linventario=Linventario - (new.cantidad - old.cantidad);
    if Linventario<0 then
		set Linventario=0;
	end if;
    update producto set inventario=Linventario where id=new.idProducto;

END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mesa`
--

CREATE TABLE `mesa` (
  `id` int(11) NOT NULL,
  `mesa` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `orden`
--

CREATE TABLE `orden` (
  `id` int(11) NOT NULL,
  `idMesa` int(11) DEFAULT NULL COMMENT 'Cuando la orden es para llevar, la mesa es NULL',
  `idUsuario` int(11) NOT NULL,
  `fecha` date DEFAULT NULL,
  `llevar` int(11) NOT NULL DEFAULT '0',
  `estado` varchar(2) NOT NULL COMMENT 'CC -- Cobrado y Cerrado\nCP -- Cobrado en preparacion\nAA -- Activa sin Cobrar',
  `observacion` varchar(245) DEFAULT NULL,
  `tiempoPreparado` datetime DEFAULT NULL,
  `tiempoRapido` datetime DEFAULT NULL,
  `total` decimal(8,2) DEFAULT '0.00',
  `propina` decimal(8,2) DEFAULT '0.00',
  `formaPago` varchar(1) DEFAULT 'E' COMMENT 'Indica la forma de pago:\nE--Efectivo\nT--Tarjeta de Credito',
  `cliente` varchar(145) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Disparadores `orden`
--
DELIMITER $$
CREATE TRIGGER `orden_BEFORE_INSERT` BEFORE INSERT ON `orden` FOR EACH ROW BEGIN
SET NEW.fecha = now();
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `parametro`
--

CREATE TABLE `parametro` (
  `id` int(11) NOT NULL,
  `nombre` varchar(145) NOT NULL,
  `valor` varchar(245) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `parametro`
--

INSERT INTO `parametro` (`id`, `nombre`, `valor`) VALUES
(1, 'ModoEntorno', 'MESA'),
(2, 'Nombre', 'Negocio la Bendición de Dios'),
(3, 'Descripcion', 'Servicios de Cafetería y restaurante'),
(4, 'Telefono', '(503) 2453-5478'),
(5, 'NIT', '0524-045374-102-8'),
(6, 'Giro', 'Restaurante'),
(7, 'Direccion', 'Barrio El Calvario calle libertad N23 Santa Ana'),
(8, 'Imprimir Ticket de productos preparados', 'SI'),
(9, 'Imprimir Ticket de productos NO preparados o rapidos', 'SI'),
(10, 'Tiempo maximo ordenes RAPIDAS (minutos)', '5'),
(11, 'Tiempo maximo Preparacion de Orden', '15'),
(12, 'Loggin en cada pantalla', '1'),
(13, 'Propina', '10%');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `id` int(11) NOT NULL,
  `nombre` varchar(145) NOT NULL,
  `precio` decimal(8,2) NOT NULL DEFAULT '0.00',
  `inventario` int(11) NOT NULL DEFAULT '0',
  `preparado` int(11) NOT NULL DEFAULT '1',
  `idCategoria` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id` int(11) NOT NULL,
  `nombreCompleto` varchar(145) NOT NULL,
  `login` varchar(45) NOT NULL,
  `clave` varchar(245) NOT NULL,
  `pin` varchar(5) NOT NULL,
  `rol` varchar(1) NOT NULL DEFAULT 'M' COMMENT 'G--Gerente\nM--Mesero'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id`, `nombreCompleto`, `login`, `clave`, `pin`, `rol`) VALUES
(1, 'Administrador', 'admin', '90b9aa7e25f80cf4f64e990b78a9fc5ebd6cecad', '12345', 'G');

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vistafecha`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vistafecha` (
`now()` datetime
);

-- --------------------------------------------------------

--
-- Estructura para la vista `dashboardllevar`
--
DROP TABLE IF EXISTS `dashboardllevar`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `dashboardllevar`  AS  select `o`.`id` AS `IdOrden`,`u`.`nombreCompleto` AS `Mesero`,ifnull(`o`.`cliente`,'') AS `Cliente`,`o`.`total` AS `Total`,`o`.`estado` AS `Estado`,round(((now() - `o`.`tiempoPreparado`) / 60),1) AS `TiempoPreparado`,if(`o`.`tiempoPreparado`,ifnull(if((round(((now() - `o`.`tiempoPreparado`) / 60),1) > (select `parametro`.`valor` from `parametro` where (`parametro`.`id` = 11))),'ROJO',NULL),if((((select `parametro`.`valor` from `parametro` where (`parametro`.`id` = 11)) - round(((now() - `o`.`tiempoPreparado`) / 60),1)) > 1.5),'VERDE','AMARILLO')),NULL) AS `Preparado` from (`orden` `o` join `usuario` `u` on((`o`.`idUsuario` = `u`.`id`))) where ((`o`.`estado` <> 'CC') and (`o`.`llevar` = 1)) order by `o`.`id` ;

-- --------------------------------------------------------

--
-- Estructura para la vista `dashboardprincipal`
--
DROP TABLE IF EXISTS `dashboardprincipal`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `dashboardprincipal`  AS  select `o`.`id` AS `IdOrden`,`o`.`idMesa` AS `Mesa`,`u`.`nombreCompleto` AS `Mesero`,ifnull(`o`.`cliente`,'') AS `Cliente`,`o`.`total` AS `Total`,`o`.`estado` AS `Estado`,`o`.`llevar` AS `llevar`,round(((now() - `o`.`tiempoPreparado`) / 60),1) AS `TiempoPreparado`,if(`o`.`tiempoPreparado`,ifnull(if((round(((now() - `o`.`tiempoPreparado`) / 60),1) > (select `parametro`.`valor` from `parametro` where (`parametro`.`id` = 11))),'ROJO',NULL),if((((select `parametro`.`valor` from `parametro` where (`parametro`.`id` = 11)) - round(((now() - `o`.`tiempoPreparado`) / 60),1)) > 1.5),'VERDE','AMARILLO')),NULL) AS `Preparado`,round(((now() - `o`.`tiempoRapido`) / 60),1) AS `TiempoRapido`,if(`o`.`tiempoRapido`,ifnull(if((round(((now() - `o`.`tiempoRapido`) / 60),1) > (select `parametro`.`valor` from `parametro` where (`parametro`.`id` = 10))),'ROJO',NULL),if((((select `parametro`.`valor` from `parametro` where (`parametro`.`id` = 10)) - round(((now() - `o`.`tiempoRapido`) / 60),1)) > 1.5),'VERDE','AMARILLO')),NULL) AS `Rapido`,if((`o`.`llevar` = 1),'LLEVAR','AQUI') AS `tipo` from (`orden` `o` join `usuario` `u` on((`o`.`idUsuario` = `u`.`id`))) where (`o`.`estado` <> 'CC') order by `o`.`id` ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vistafecha`
--
DROP TABLE IF EXISTS `vistafecha`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vistafecha`  AS  select now() AS `now()` ;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `bitacora`
--
ALTER TABLE `bitacora`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_bitacora_usuario_idx` (`idUsuario`);

--
-- Indices de la tabla `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `compra`
--
ALTER TABLE `compra`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `detallecompra`
--
ALTER TABLE `detallecompra`
  ADD PRIMARY KEY (`idCompra`,`idProducto`),
  ADD KEY `fk_detallecompra_producto_idx` (`idProducto`);

--
-- Indices de la tabla `detalleorden`
--
ALTER TABLE `detalleorden`
  ADD PRIMARY KEY (`idOrden`,`idProducto`),
  ADD KEY `fk_detalle_producto_idx` (`idProducto`);

--
-- Indices de la tabla `mesa`
--
ALTER TABLE `mesa`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `orden`
--
ALTER TABLE `orden`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_orden_usuario1_idx` (`idUsuario`),
  ADD KEY `fk_orden_mesa_idx` (`idMesa`);

--
-- Indices de la tabla `parametro`
--
ALTER TABLE `parametro`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_producto_categoria_idx` (`idCategoria`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `loggin_UNIQUE` (`login`),
  ADD UNIQUE KEY `pin_UNIQUE` (`pin`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `bitacora`
--
ALTER TABLE `bitacora`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `categoria`
--
ALTER TABLE `categoria`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `compra`
--
ALTER TABLE `compra`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `mesa`
--
ALTER TABLE `mesa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `orden`
--
ALTER TABLE `orden`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `bitacora`
--
ALTER TABLE `bitacora`
  ADD CONSTRAINT `fk_bitacora_usuario` FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `detallecompra`
--
ALTER TABLE `detallecompra`
  ADD CONSTRAINT `fk_detallecompra_compra` FOREIGN KEY (`idCompra`) REFERENCES `compra` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_detallecompra_producto` FOREIGN KEY (`idProducto`) REFERENCES `producto` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `detalleorden`
--
ALTER TABLE `detalleorden`
  ADD CONSTRAINT `fk_detalle_orden` FOREIGN KEY (`idOrden`) REFERENCES `orden` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_detalle_producto` FOREIGN KEY (`idProducto`) REFERENCES `producto` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `orden`
--
ALTER TABLE `orden`
  ADD CONSTRAINT `fk_orden_mesa` FOREIGN KEY (`idMesa`) REFERENCES `mesa` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_orden_usuario1` FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `producto`
--
ALTER TABLE `producto`
  ADD CONSTRAINT `fk_producto_categoria` FOREIGN KEY (`idCategoria`) REFERENCES `categoria` (`id`) ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
