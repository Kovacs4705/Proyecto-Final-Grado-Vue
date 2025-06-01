-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 20, 2025 at 03:16 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kale`
--

-- --------------------------------------------------------

--
-- Table structure for table `biblioteca`
--

CREATE TABLE `biblioteca` (
  `dni_usuario` varchar(9) NOT NULL,
  `id_juego` int(11) NOT NULL,
  `horas_jugadas` int(11) DEFAULT 0,
  `ultima_vez_jugado` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `compra`
--

CREATE TABLE `compra` (
  `id_compra` int(11) NOT NULL,
  `dni_usuario` varchar(9) NOT NULL,
  `id_juego` int(11) NOT NULL,
  `fecha_compra` timestamp NOT NULL DEFAULT current_timestamp(),
  `precio_final` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `compra`
--

INSERT INTO `compra` (`id_compra`, `dni_usuario`, `id_juego`, `fecha_compra`, `precio_final`) VALUES
(10, '12345678A', 6, '2025-03-20 14:11:06', 14.99),
(11, '87654321B', 8, '2025-03-20 14:11:06', 22.49),
(12, '56781234C', 9, '2025-03-20 14:11:06', 18.99),
(13, '43218765D', 7, '2025-03-20 14:11:06', 4.99),
(14, '13572468E', 6, '2025-03-20 14:11:06', 14.99),
(15, '24681357F', 8, '2025-03-20 14:11:06', 22.49),
(16, '19283746G', 9, '2025-03-20 14:11:06', 18.99),
(17, '91827364H', 7, '2025-03-20 14:11:06', 4.99),
(18, '56783920J', 6, '2025-03-20 14:11:06', 14.99),
(19, '90817263K', 8, '2025-03-20 14:11:06', 22.49),
(20, '12345678A', 6, '2025-03-20 14:12:39', 14.99),
(21, '87654321B', 8, '2025-03-20 14:12:39', 22.49),
(22, '56781234C', 9, '2025-03-20 14:12:39', 18.99),
(23, '43218765D', 7, '2025-03-20 14:12:39', 4.99),
(24, '13572468E', 6, '2025-03-20 14:12:39', 14.99),
(25, '24681357F', 8, '2025-03-20 14:12:39', 22.49),
(26, '19283746G', 9, '2025-03-20 14:12:39', 18.99),
(27, '91827364H', 7, '2025-03-20 14:12:39', 4.99),
(28, '56783920J', 6, '2025-03-20 14:12:39', 14.99),
(29, '90817263K', 8, '2025-03-20 14:12:39', 22.49),
(30, '12345678A', 6, '2025-03-20 14:12:49', 14.99),
(31, '87654321B', 8, '2025-03-20 14:12:49', 22.49),
(32, '56781234C', 9, '2025-03-20 14:12:49', 18.99),
(33, '43218765D', 7, '2025-03-20 14:12:49', 4.99),
(34, '13572468E', 6, '2025-03-20 14:12:49', 14.99),
(35, '24681357F', 8, '2025-03-20 14:12:49', 22.49),
(36, '19283746G', 9, '2025-03-20 14:12:49', 18.99),
(37, '91827364H', 7, '2025-03-20 14:12:49', 4.99),
(38, '56783920J', 6, '2025-03-20 14:12:49', 14.99),
(39, '90817263K', 8, '2025-03-20 14:12:49', 22.49);

-- --------------------------------------------------------

--
-- Table structure for table `genero`
--

CREATE TABLE `genero` (
  `id_genero` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `genero`
--

INSERT INTO `genero` (`id_genero`, `nombre`) VALUES
(1, 'Acción'),
(2, 'Aventura'),
(4, 'Carreras'),
(8, 'Cartas'),
(3, 'Estrategia'),
(6, 'Metroidvania'),
(7, 'Roguelike'),
(5, 'Terror');

-- --------------------------------------------------------

--
-- Table structure for table `juego`
--

CREATE TABLE `juego` (
  `id_juego` int(11) NOT NULL,
  `nombre` varchar(150) NOT NULL,
  `desarrollador` varchar(100) DEFAULT NULL,
  `editor` varchar(100) DEFAULT NULL,
  `fecha_lanzamiento` date DEFAULT NULL,
  `precio` decimal(10,2) NOT NULL,
  `descuento` decimal(5,2) DEFAULT 0.00 CHECK (`descuento` between 0 and 100)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `juego`
--

INSERT INTO `juego` (`id_juego`, `nombre`, `desarrollador`, `editor`, `fecha_lanzamiento`, `precio`, `descuento`) VALUES
(1, 'CyberQuest', 'TechSoft', 'GameHouse', '2023-06-15', 49.99, 10.00),
(2, 'Medieval Wars', 'Knight Games', 'FantasyCorp', '2022-12-01', 39.99, 5.00),
(3, 'Racing Pro', 'Speed Studios', 'TrackMania', '2024-03-10', 59.99, 15.00),
(4, 'Zombie Attack', 'HorrorSoft', 'ScareGames', '2021-10-31', 19.99, 20.00),
(5, 'Space Conqueror', 'Galactic Devs', 'StarPlay', '2023-09-20', 29.99, 8.00),
(6, 'Hollow Knight', 'Team Cherry', 'Team Cherry', '2017-02-24', 14.99, 0.00),
(7, 'Vampire Survivors', 'poncle', 'poncle', '2022-10-20', 4.99, 0.00),
(8, 'Hades', 'Supergiant Games', 'Supergiant Games', '2020-09-17', 24.99, 10.00),
(9, 'Balatro', 'LocalThunk', 'Playstack', '2024-02-20', 19.99, 5.00);

-- --------------------------------------------------------

--
-- Table structure for table `juego_genero`
--

CREATE TABLE `juego_genero` (
  `id_juego` int(11) NOT NULL,
  `id_genero` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `juego_genero`
--

INSERT INTO `juego_genero` (`id_juego`, `id_genero`) VALUES
(1, 1),
(1, 2),
(2, 3),
(3, 4),
(4, 5),
(5, 1),
(6, 6),
(7, 7),
(8, 7),
(9, 8);

-- --------------------------------------------------------

--
-- Table structure for table `juego_imagen`
--

CREATE TABLE `juego_imagen` (
  `id_imagen` int(11) NOT NULL,
  `id_juego` int(11) NOT NULL,
  `url` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `juego_video`
--

CREATE TABLE `juego_video` (
  `id_video` int(11) NOT NULL,
  `id_juego` int(11) NOT NULL,
  `url` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `logro`
--

CREATE TABLE `logro` (
  `id_logro` int(11) NOT NULL,
  `id_juego` int(11) NOT NULL,
  `nombre` varchar(150) NOT NULL,
  `descripcion` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `logro`
--

INSERT INTO `logro` (`id_logro`, `id_juego`, `nombre`, `descripcion`) VALUES
(1, 1, 'Primer nivel completado', 'Supera el primer nivel del juego.'),
(2, 2, 'Maestro estratega', 'Gana 10 partidas en modo difícil.'),
(3, 3, 'Velocidad máxima', 'Alcanza los 300 km/h en una carrera.'),
(4, 4, 'Superviviente', 'Sobrevive 10 minutos en el modo horda.'),
(5, 5, 'Conquistador del espacio', 'Captura 5 planetas enemigos.'),
(6, 6, 'Rey de Hallownest', 'Derrota a todos los jefes.'),
(7, 7, 'Invencible', 'Sobrevive 30 minutos en una partida.'),
(8, 8, 'Hijo del inframundo', 'Escapa del Hades.'),
(9, 9, 'Apuesta maestra', 'Gana una ronda con una mano perfecta.');

-- --------------------------------------------------------

--
-- Table structure for table `reseña`
--

CREATE TABLE `reseña` (
  `id_reseña` int(11) NOT NULL,
  `dni_usuario` varchar(9) NOT NULL,
  `id_juego` int(11) NOT NULL,
  `calificación` int(11) DEFAULT NULL CHECK (`calificación` between 1 and 5),
  `comentario` text DEFAULT NULL,
  `fecha_publicacion` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reseña`
--

INSERT INTO `reseña` (`id_reseña`, `dni_usuario`, `id_juego`, `calificación`, `comentario`, `fecha_publicacion`) VALUES
(10, '12345678A', 6, 5, 'Un metroidvania increíble, gran exploración.', '2025-03-20 14:14:55'),
(11, '87654321B', 8, 4, 'Hades es adictivo y desafiante.', '2025-03-20 14:14:55'),
(12, '56781234C', 9, 5, 'Balatro es el mejor juego de cartas que he jugado.', '2025-03-20 14:14:55'),
(13, '43218765D', 7, 4, 'Divertido y simple, muy entretenido.', '2025-03-20 14:14:55'),
(14, '13572468E', 6, 5, 'Arte y música maravillosos.', '2025-03-20 14:14:55'),
(15, '24681357F', 8, 5, 'Historia atrapante y combate fluido.', '2025-03-20 14:14:55'),
(16, '19283746G', 9, 4, 'Muy divertido, pero podría tener más contenido.', '2025-03-20 14:14:55'),
(17, '91827364H', 7, 4, 'Perfecto para partidas cortas.', '2025-03-20 14:14:55'),
(18, '56783920J', 6, 5, 'No puedo dejar de jugarlo.', '2025-03-20 14:14:55'),
(19, '90817263K', 8, 5, 'Rejugabilidad infinita.', '2025-03-20 14:14:55');

-- --------------------------------------------------------

--
-- Table structure for table `usuario`
--

CREATE TABLE `usuario` (
  `dni_usuario` varchar(9) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `contraseña` varchar(255) NOT NULL,
  `saldo` decimal(10,2) DEFAULT 0.00,
  `avatar` text DEFAULT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp(),
  `rol` enum('usuario','administrador') DEFAULT 'usuario'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `usuario`
--

INSERT INTO `usuario` (`dni_usuario`, `nombre`, `email`, `contraseña`, `saldo`, `avatar`, `fecha_registro`, `rol`) VALUES
('12345678A', 'Luis Fernández', 'luis.fernandez@example.com', 'password1', 50.00, NULL, '2025-03-20 14:07:08', 'usuario'),
('13572468E', 'Javier Díaz', 'javier.diaz@example.com', 'password5', 30.00, NULL, '2025-03-20 14:07:08', 'usuario'),
('19283746G', 'Pablo Gómez', 'pablo.gomez@example.com', 'password7', 85.00, NULL, '2025-03-20 14:07:08', 'usuario'),
('19283746M', 'Andrea Castillo', 'andrea.castillo@example.com', 'password12', 90.00, NULL, '2025-03-20 14:07:08', 'usuario'),
('24681357F', 'Elena Pérez', 'elena.perez@example.com', 'password6', 60.00, NULL, '2025-03-20 14:07:08', 'usuario'),
('43218765D', 'Ana Martín', 'ana.martin@example.com', 'password4', 95.00, NULL, '2025-03-20 14:07:08', 'usuario'),
('47583920O', 'Marta Herrera', 'marta.herrera@example.com', 'password14', 125.00, NULL, '2025-03-20 14:07:08', 'usuario'),
('56473829N', 'Sergio Morales', 'sergio.morales@example.com', 'password13', 110.00, NULL, '2025-03-20 14:07:08', 'usuario'),
('56781234C', 'Carlos Sánchez', 'carlos.sanchez@example.com', 'password3', 120.00, NULL, '2025-03-20 14:07:08', 'usuario'),
('56783920J', 'Raúl Ortega', 'raul.ortega@example.com', 'password9', 55.00, NULL, '2025-03-20 14:07:08', 'usuario'),
('72931728Q', 'Alejandro Solar', 'alejandro.solar@example.com', 'adminpass2', 200.00, NULL, '2025-03-20 14:02:19', 'administrador'),
('82736455L', 'Fernando Ruiz', 'fernando.ruiz@example.com', 'password11', 35.00, NULL, '2025-03-20 14:07:08', 'usuario'),
('84736291P', 'David Torres', 'david.torres@example.com', 'password15', 20.00, NULL, '2025-03-20 14:07:08', 'usuario'),
('87654321B', 'María López', 'maria.lopez@example.com', 'password2', 75.50, NULL, '2025-03-20 14:07:08', 'usuario'),
('90817263K', 'Natalia Romero', 'natalia.romero@example.com', 'password10', 70.00, NULL, '2025-03-20 14:07:08', 'usuario'),
('91827364H', 'Laura Jiménez', 'laura.jimenez@example.com', 'password8', 40.00, NULL, '2025-03-20 14:07:08', 'usuario'),
('X9613206B', 'David Kovacs', 'david.kovacs@example.com', 'adminpass1', 150.00, NULL, '2025-03-20 14:02:19', 'administrador');

-- --------------------------------------------------------

--
-- Table structure for table `usuario_logro`
--

CREATE TABLE `usuario_logro` (
  `dni_usuario` varchar(9) NOT NULL,
  `id_logro` int(11) NOT NULL,
  `fecha_obtencion` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `usuario_logro`
--

INSERT INTO `usuario_logro` (`dni_usuario`, `id_logro`, `fecha_obtencion`) VALUES
('12345678A', 6, '2025-03-20 14:12:39'),
('13572468E', 6, '2025-03-20 14:12:39'),
('19283746G', 9, '2025-03-20 14:12:39'),
('24681357F', 8, '2025-03-20 14:12:39'),
('43218765D', 7, '2025-03-20 14:12:39'),
('56781234C', 9, '2025-03-20 14:12:39'),
('56783920J', 6, '2025-03-20 14:12:39'),
('87654321B', 8, '2025-03-20 14:12:39'),
('90817263K', 8, '2025-03-20 14:12:39'),
('91827364H', 7, '2025-03-20 14:12:39');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `biblioteca`
--
ALTER TABLE `biblioteca`
  ADD PRIMARY KEY (`dni_usuario`,`id_juego`),
  ADD KEY `id_juego` (`id_juego`);

--
-- Indexes for table `compra`
--
ALTER TABLE `compra`
  ADD PRIMARY KEY (`id_compra`),
  ADD KEY `dni_usuario` (`dni_usuario`),
  ADD KEY `id_juego` (`id_juego`);

--
-- Indexes for table `genero`
--
ALTER TABLE `genero`
  ADD PRIMARY KEY (`id_genero`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Indexes for table `juego`
--
ALTER TABLE `juego`
  ADD PRIMARY KEY (`id_juego`);

--
-- Indexes for table `juego_genero`
--
ALTER TABLE `juego_genero`
  ADD PRIMARY KEY (`id_juego`,`id_genero`),
  ADD KEY `id_genero` (`id_genero`);

--
-- Indexes for table `juego_imagen`
--
ALTER TABLE `juego_imagen`
  ADD PRIMARY KEY (`id_imagen`),
  ADD KEY `id_juego` (`id_juego`);

--
-- Indexes for table `juego_video`
--
ALTER TABLE `juego_video`
  ADD PRIMARY KEY (`id_video`),
  ADD KEY `id_juego` (`id_juego`);

--
-- Indexes for table `logro`
--
ALTER TABLE `logro`
  ADD PRIMARY KEY (`id_logro`),
  ADD KEY `id_juego` (`id_juego`);

--
-- Indexes for table `reseña`
--
ALTER TABLE `reseña`
  ADD PRIMARY KEY (`id_reseña`),
  ADD UNIQUE KEY `dni_usuario` (`dni_usuario`,`id_juego`),
  ADD KEY `id_juego` (`id_juego`);

--
-- Indexes for table `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`dni_usuario`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `usuario_logro`
--
ALTER TABLE `usuario_logro`
  ADD PRIMARY KEY (`dni_usuario`,`id_logro`),
  ADD KEY `id_logro` (`id_logro`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `compra`
--
ALTER TABLE `compra`
  MODIFY `id_compra` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `genero`
--
ALTER TABLE `genero`
  MODIFY `id_genero` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `juego`
--
ALTER TABLE `juego`
  MODIFY `id_juego` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `juego_imagen`
--
ALTER TABLE `juego_imagen`
  MODIFY `id_imagen` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `juego_video`
--
ALTER TABLE `juego_video`
  MODIFY `id_video` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `logro`
--
ALTER TABLE `logro`
  MODIFY `id_logro` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `reseña`
--
ALTER TABLE `reseña`
  MODIFY `id_reseña` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `biblioteca`
--
ALTER TABLE `biblioteca`
  ADD CONSTRAINT `biblioteca_ibfk_1` FOREIGN KEY (`dni_usuario`) REFERENCES `usuario` (`dni_usuario`) ON DELETE CASCADE,
  ADD CONSTRAINT `biblioteca_ibfk_2` FOREIGN KEY (`id_juego`) REFERENCES `juego` (`id_juego`) ON DELETE CASCADE;

--
-- Constraints for table `compra`
--
ALTER TABLE `compra`
  ADD CONSTRAINT `compra_ibfk_1` FOREIGN KEY (`dni_usuario`) REFERENCES `usuario` (`dni_usuario`) ON DELETE CASCADE,
  ADD CONSTRAINT `compra_ibfk_2` FOREIGN KEY (`id_juego`) REFERENCES `juego` (`id_juego`) ON DELETE CASCADE;

--
-- Constraints for table `juego_genero`
--
ALTER TABLE `juego_genero`
  ADD CONSTRAINT `juego_genero_ibfk_1` FOREIGN KEY (`id_juego`) REFERENCES `juego` (`id_juego`) ON DELETE CASCADE,
  ADD CONSTRAINT `juego_genero_ibfk_2` FOREIGN KEY (`id_genero`) REFERENCES `genero` (`id_genero`) ON DELETE CASCADE;

--
-- Constraints for table `juego_imagen`
--
ALTER TABLE `juego_imagen`
  ADD CONSTRAINT `juego_imagen_ibfk_1` FOREIGN KEY (`id_juego`) REFERENCES `juego` (`id_juego`) ON DELETE CASCADE;

--
-- Constraints for table `juego_video`
--
ALTER TABLE `juego_video`
  ADD CONSTRAINT `juego_video_ibfk_1` FOREIGN KEY (`id_juego`) REFERENCES `juego` (`id_juego`) ON DELETE CASCADE;

--
-- Constraints for table `logro`
--
ALTER TABLE `logro`
  ADD CONSTRAINT `logro_ibfk_1` FOREIGN KEY (`id_juego`) REFERENCES `juego` (`id_juego`) ON DELETE CASCADE;

--
-- Constraints for table `reseña`
--
ALTER TABLE `reseña`
  ADD CONSTRAINT `reseña_ibfk_1` FOREIGN KEY (`dni_usuario`) REFERENCES `usuario` (`dni_usuario`) ON DELETE CASCADE,
  ADD CONSTRAINT `reseña_ibfk_2` FOREIGN KEY (`id_juego`) REFERENCES `juego` (`id_juego`) ON DELETE CASCADE;

--
-- Constraints for table `usuario_logro`
--
ALTER TABLE `usuario_logro`
  ADD CONSTRAINT `usuario_logro_ibfk_1` FOREIGN KEY (`dni_usuario`) REFERENCES `usuario` (`dni_usuario`) ON DELETE CASCADE,
  ADD CONSTRAINT `usuario_logro_ibfk_2` FOREIGN KEY (`id_logro`) REFERENCES `logro` (`id_logro`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
