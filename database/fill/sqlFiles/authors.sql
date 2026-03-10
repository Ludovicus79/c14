-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 20-04-2016 a las 12:59:45
-- Versión del servidor: 10.1.10-MariaDB
-- Versión de PHP: 5.6.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `c13db`
--

--
-- Volcado de datos para la tabla `autores`
--

INSERT INTO `authors` (`id`, `author`, `email`, `country`, `organization`) VALUES
(1, 'José Luis López Pérez', 'lopez@usal.es', 'Spain', 'University of Salamanca'),
(2, 'Álvaro Montes Benito', 'alvaromb@usal.es', 'Spain', 'University of Salamanca'),
(3, 'Álvaro Corral Alaejos', 'alvarofarmacia@usal.es', 'Spain', 'University of Salamanca'),
(4, 'Zaida de Blas Arribas', 'zaidadb13@hotmail.com', 'Spain', 'University of Salamanca'),
(5, 'Victor Herrero', 'victorherrerom@hotmail.com', 'Spain', 'University of Salamanca'),
(6, 'Vanessa Rodríguez Sánchez', 'vrs_1988@hotmail.com', 'Spain', 'University of Salamanca'),
(7, 'Tamara Álvarez Martín', 'tamara_am_89@hotmail.com', 'Spain', 'University of Salamanca'),
(8, 'Sofía Sánchez Hernández', 'sofy_sanz@hotmail.com', 'Spain', 'University of Salamanca'),
(9, 'Silvia Menegatti', 'silvia.menegatti@student.unife.it', 'Italy', 'University of Ferrara'),
(10, 'Sergio Dosantos Vara', 'sergiopoch@usal.es', 'Spain', 'University of Salamanca'),
(11, 'Sara Sánchez Moreno', 'sarasanchez@usal.es', 'Spain', 'University of Salamanca'),
(12, 'Sara Santos Sánchez', 'sarasantos@usal.es', 'Spain', 'University of Salamanca'),
(13, 'Raquel Moreno Mayordomo', 'raquelmoreno@usal.es', 'Spain', 'University of Salamanca'),
(14, 'Marta Sánchez García', 'u97110@usal.es', 'Spain', 'University of Salamanca'),
(15, 'Marta García Hernández', 'martagarcia@usal.es', 'Spain', 'University of Salamanca'),
(16, 'María Monsalvo González', 'maryoboe@usal.es', 'Spain', 'University of Salamanca'),
(17, 'Marcos Real Martínez', 'mreal@usal.es', 'Spain', 'University of Salamanca'),
(18, 'M. Inmaculada Campos Calamonte', 'inmacampos@usal.es', 'Spain', 'University of Salamanca'),
(19, 'M. Eugenia Calvo Aragüete', 'enacalvo@hotmail.com', 'Spain', 'University of Salamanca'),
(20, 'Luz Carmen Martín Sánchez', 'luzcarmen@usal.es', 'Spain', 'University of Salamanca'),
(21, 'Julio Alconada Calles', 'julio_89@usal.es', 'Spain', 'University of Salamanca'),
(22, 'Judith Alonso', 'judith_ah-08@hotmail.com', 'Spain', 'University of Salamanca'),
(23, 'José Juan Sánchez Calero', 'jj-alange@hotmail.com', 'Spain', 'University of Salamanca'),
(24, 'Joana Carvalho Morgado', 'pintas_morgado@hotmail.com', 'Spain', 'University of Salamanca'),
(25, 'Javier Martínez Benavides', 'javi_farmacia@hotmail.com', 'Spain', 'University of Salamanca'),
(26, 'Fernando Usón Manzanares', 'u98106@usal.es', 'Spain', 'University of Salamanca'),
(27, 'Enrique García Ramos', 'heinrich_67888@hotmail.com', 'Spain', 'University of Salamanca'),
(28, 'Dionisio Antonio Olmedo', 'olmedod@latinmail.com', 'Panama', 'University of Panama'),
(29, 'Daniel Briegas Morera', 'danielbriegas@usal.es', 'Spain', 'University of Salamanca'),
(30, 'Cecilia María Mañanes Esteban', 'ceciliamaes@usal.es', 'Spain', 'University of Salamanca'),
(31, 'Carolina Vallina Granada', 'cvallina@usal.es', 'Spain', 'University of Salamanca'),
(32, 'Carlos Álvaro Lebrero Giraldo', 'carloslebrero1989@hotmail.com', 'Spain', 'University of Salamanca'),
(33, 'Beatríz Gómez San Martín', 'bea_gsm@usal.es', 'Spain', 'University of Salamanca'),
(34, 'Bartomeu Amengual Riera', 'u98447@usal.es', 'Spain', 'University of Salamanca'),
(35, 'Arturo Benito Domínguez Iglesias', 'arturobenito@usal.es', 'Spain', 'University of Salamanca'),
(36, 'Antonio Lorenzo García', 'gominolo50@hotmail.com', 'Spain', 'University of Salamanca'),
(37, 'Ana María Fernández Díez', 'afdz@usal.es', 'Spain', 'University of Salamanca'),
(38, 'Ana María Alonso-Calvo González', 'aacgi@usal.es', 'Spain', 'University of Salamanca'),
(39, 'Ana Belén Alonso Vidal', 'anaalonso@usal.es', 'Spain', 'University of Salamanca'),
(40, 'Alessandra Mautone', 'alessandra.mautone@student.unife.it', 'Italy', 'University of Ferrara'),
(41, 'Aída Pérez Merino', 'aidapm@usal.es', 'Spain', 'University of Salamanca'),
(42, 'Aída Alonso de La Iglesia', 'helora13@hotmail.com', 'Spain', 'University of Salamanca'),
(45, 'Arturo Jiménez Borreguero', 'arjibor@hotmail.com', 'Spain', 'University of Salamanca'),
(46, 'Luis Antonio Bustos González', 'lubustos@alumnos.unap.cl', 'Chile', 'Arturo Prat University'),
(47, 'Angela Datcu', 'calotaangela@yahoo.com', 'Spain', 'University of Salamanca'),
(48, 'Ignacio Villanueva Fierro', 'ifierro62@yahoo.com', 'México', 'CIIDIR-IPN Unidad Durango'),
(49, 'Daniel Hernandez Velázquez', 'daniel.spice4dan@gmail.com', 'México', 'CIIDIR-IPN Unidad Durango'),
(50, 'Marie Jazmín Sarabia Sánchez', 'marie_sarabia@hotmail.com', 'México', 'Universidad Juárez'),
(51, 'Gerardo Pérez Sánchez', 'gperezs@yahoo.com', 'México', 'CIIDIR-IPN Unidad Durango'),
(52, 'Karen L. Lang', 'karenluise@gmail.com', 'Brasil', 'Universidade Federal de Santa Catarina'),
(53, 'Daniela Beck da Silva Marcondes', 'danielabsmarcondes@gmai.com', 'Brasil', 'Universidade Federal do Paraná'),
(54, 'Marlon Cordeiro', 'cordeiro.qmc@gmail.com', 'Brasil', 'Universidade Federal de Santa Catarina'),
(55, 'Naeba Pomeda Matellanes', 'naebap@gmail.com', 'Spain', 'University of Salamanca');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
