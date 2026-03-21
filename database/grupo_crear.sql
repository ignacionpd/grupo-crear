-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 12-02-2026 a las 16:43:43
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12


--
-- Base de datos: `grupo_crear`
--
CREATE DATABASE IF NOT EXISTS `grupo_crear` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `grupo_crear`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios_data`
--

CREATE TABLE IF NOT EXISTS `usuarios_data` (
  `id_usuario` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(30) NOT NULL,
  `apellido` varchar(30) NOT NULL,
  `email` varchar(40) NOT NULL,
  `telefono` varchar(11) NOT NULL,
  PRIMARY KEY (`id_usuario`)
) ENGINE=InnoDB;

-- --------------------------------------------------------

-- Estructura de tabla para la tabla `usuarios_login`

CREATE TABLE IF NOT EXISTS `usuarios_login` (
  `id_login` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) NOT NULL UNIQUE,
  `usuario` varchar(10) NOT NULL UNIQUE,
  `contrasena` varchar(255) NOT NULL,
  PRIMARY KEY (`id_login`),
  FOREIGN KEY (`id_usuario`) 
    REFERENCES `usuarios_data` (`id_usuario`) 
    ON DELETE CASCADE 
    ON UPDATE CASCADE
) ENGINE=InnoDB;

-- RELACIONES PARA LA TABLA `usuarios_login`:
--   `id_usuario`
--       `usuarios_data` -> `id_usuario`
--


-- --------------------------------------------------------

-- Estructura de tabla para la tabla `empleados`

CREATE TABLE IF NOT EXISTS `empleados` (
  `id_empleado` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(20) NOT NULL,
  `apellido` varchar(20) NOT NULL,
  `dni` varchar(8) NOT NULL UNIQUE,
  `cuit` varchar(11) NOT NULL UNIQUE,
  `fecha_nacimiento` date NOT NULL,
  `telefono` varchar(11) NOT NULL,
  `direccion` varchar(50) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `contacto_emergencia` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`id_empleado`)
) ENGINE=InnoDB;


-- --------------------------------------------------------

-- Estructura de tabla para la tabla `solicitudes_contacto`

CREATE TABLE IF NOT EXISTS `solicitudes_contacto` (
  `id_solicitud` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(30) NOT NULL,
  `apellido` varchar(30) NOT NULL,
  `telefono` varchar(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `direccion` varchar(50) NOT NULL,
  `texto` varchar(250) NOT NULL,
  `estado` enum('Pendiente','Respondido') NOT NULL DEFAULT 'Pendiente',
  `observaciones` varchar(250) DEFAULT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `fecha_solicitud` date DEFAULT NULL,
  `fecha_cierre` date DEFAULT NULL,
  PRIMARY KEY (`id_solicitud`),
  FOREIGN KEY (`id_usuario`) 
    REFERENCES `usuarios_data` (`id_usuario`) 
    ON DELETE SET NULL 
    ON UPDATE CASCADE
) ENGINE=InnoDB;

--
-- RELACIONES PARA LA TABLA `solicitudes_contacto`:
--   `id_usuario`
--       `usuarios_data` -> `id_usuario`
--


-- Aquí generamos el usuario "admin" ingresando los datos de manera manual, con previo hasheo de password generado en registrarAdmin.php en la carpeta views.

INSERT INTO `usuarios_data` (`id_usuario`, `nombre`, `apellido`, `email`, `telefono`) VALUES
(1, 'administracion', 'grupo crear', 'grupocrear@live.com', '44519161');

INSERT INTO `usuarios_login` (`id_login`, `id_usuario`, `usuario`, `contrasena`) VALUES
(1, 1, 'admin', '$2y$10$zpUesWgGjsR9FnHqaiyTGOGQCRIyx4AZ/sco/PsyKL5Bnd4XpIfxe');