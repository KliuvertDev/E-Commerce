-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 08-07-2025 a las 18:06:26
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
-- Base de datos: `ecommerce_db`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(4, 'Calzado'),
(2, 'Electrodomésticos'),
(3, 'Ropa'),
(1, 'Tecnología');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `status` enum('pending','paid','shipped','cancelled') DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `total`, `status`, `created_at`) VALUES
(5, 7, 89.00, 'pending', '2025-07-08 06:59:26'),
(6, 7, 29.00, 'pending', '2025-07-08 06:59:37'),
(7, 7, 87.00, 'pending', '2025-07-08 07:00:06'),
(8, 1, 29.00, 'pending', '2025-07-08 12:37:16'),
(9, 1, 189.00, 'pending', '2025-07-08 12:37:24'),
(10, 1, 59.00, 'pending', '2025-07-08 15:39:56'),
(11, 1, 297.00, 'pending', '2025-07-08 15:58:42');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`, `price`) VALUES
(2, 5, 3, 1, 89.00),
(3, 6, 13, 1, 29.00),
(4, 7, 13, 3, 29.00),
(5, 8, 13, 1, 29.00),
(6, 9, 9, 1, 189.00),
(7, 10, 16, 1, 59.00),
(8, 11, 2, 3, 59.00),
(9, 11, 8, 1, 120.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `stock` int(11) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `stock`, `image`, `created_at`) VALUES
(2, 'Tenis Urbanos Classic	', 'Tenis de uso diario con diseño casual y cómodo	', 59.00, 50, 'uploads/686cbd0c63f8f_Tenis.jpg', '2025-07-08 06:39:08'),
(3, 'Botas Montañeras Pro	', 'Botas impermeables para terreno difícil	', 89.00, 30, 'uploads/686cbd2bda7eb_Botas.webp', '2025-07-08 06:39:39'),
(4, 'Sandalias Confort Plus	', 'Sandalias de espuma viscoelástica	', 25.00, 80, 'uploads/686cbdf34ec03_sandalias.jpg', '2025-07-08 06:42:59'),
(5, 'Zapatillas Running X1	', 'Zapatillas deportivas de alto rendimiento	', 110.00, 25, 'uploads/686cbe1171ec7_zapatillas.webp', '2025-07-08 06:43:29'),
(6, 'Licuadora 500W Pro', 'Licuadora de 3 velocidades con vaso de vidrio', 49.00, 40, 'uploads/686cbee9ce33d_Licuadora.jpg', '2025-07-08 06:47:05'),
(8, 'Microondas Compacto', 'Microondas con panel digital y 5 niveles de potencia', 120.00, 20, 'uploads/686cbf8ae94d3_Microondas.jpg', '2025-07-08 06:49:46'),
(9, 'Cafetera Espresso 20Bar', 'Cafetera profesional con vaporizador de leche', 189.00, 15, 'uploads/686cbfaf29ab6_Cafetera.webp', '2025-07-08 06:50:23'),
(10, 'Plancha a Vapor MaxHeat', 'Plancha de vapor con base antiadherente', 39.00, 60, 'uploads/686cbfc96e6cf_Plancha.webp', '2025-07-08 06:50:49'),
(11, 'Camiseta Básica Hombre', 'Camiseta 100% algodón, varios colores disponibles', 19.00, 70, 'uploads/686cc0bcc3432_Camiseta.jpg', '2025-07-08 06:54:52'),
(12, 'Pantalón Jeans Slim', 'Jeans corte slim, mezclilla flexible', 45.00, 50, 'uploads/686cc0debbc82_Jean.jpg', '2025-07-08 06:55:26'),
(13, 'Blusa Manga Corta', 'Blusa elegante de tela suave', 29.00, 40, 'uploads/686cc0fc32852_Blusa.jpg', '2025-07-08 06:55:56'),
(14, 'Chaqueta Rompevientos', 'Chaqueta ligera a prueba de viento y agua', 59.00, 30, 'uploads/686cc1168e9b6_Chaqueta.jpg', '2025-07-08 06:56:22'),
(15, 'Laptop Intel i5 8GB', 'Laptop para oficina con SSD de 256GB', 749.00, 10, 'uploads/686cc135808d4_laptop.jpg', '2025-07-08 06:56:53'),
(16, 'Audífonos Bluetooth TWS', 'Audífonos con estuche de carga y reducción de ruido', 59.00, 40, 'uploads/686cc14f3c7d5_audifonos.jpg', '2025-07-08 06:57:19'),
(17, 'Mouse Inalámbrico Pro', 'Mouse ergonómico con batería recargable', 19.00, 60, 'uploads/686cc1894eec4_Mouse.jpg', '2025-07-08 06:58:17'),
(18, 'Monitor 24\" Full HD', 'Monitor LED con entrada HDMI y VGA', 149.00, 20, 'uploads/686cc19dcb202_Monitor.jpg', '2025-07-08 06:58:37');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `product_category`
--

CREATE TABLE `product_category` (
  `product_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `product_category`
--

INSERT INTO `product_category` (`product_id`, `category_id`) VALUES
(2, 4),
(3, 4),
(4, 4),
(5, 4),
(6, 2),
(8, 2),
(9, 2),
(10, 2),
(11, 3),
(12, 3),
(13, 3),
(14, 3),
(15, 1),
(16, 1),
(17, 1),
(18, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` enum('user','admin') DEFAULT 'user',
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `created_at`) VALUES
(1, 'kliuvert carcamo', 'kliuver97@gmail.com', '$2y$10$t4UQvVc0EygvoI39jpHebeuMWw5cEowUb9EuN4zs5FatpX.ZKzQtG', 'admin', '2025-07-08 00:40:52'),
(7, 'kene', 'kene@gmail.com', '$2y$10$uhkJwx.rctdNrn2fDEnGPOjpy0ozBp17j3RAY5eW1zlGj6zGWiL6.', 'user', '2025-07-08 03:07:14');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indices de la tabla `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indices de la tabla `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indices de la tabla `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `product_category`
--
ALTER TABLE `product_category`
  ADD PRIMARY KEY (`product_id`,`category_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Filtros para la tabla `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Filtros para la tabla `product_category`
--
ALTER TABLE `product_category`
  ADD CONSTRAINT `product_category_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `product_category_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
