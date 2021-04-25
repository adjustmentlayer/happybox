-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Апр 25 2021 г., 08:41
-- Версия сервера: 10.4.15-MariaDB
-- Версия PHP: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `u804181069_mysurprisebox`
--

-- --------------------------------------------------------

--
-- Структура таблицы `boxes`
--

CREATE TABLE `boxes` (
  `id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `price` int(11) NOT NULL,
  `image` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `boxes`
--

INSERT INTO `boxes` (`id`, `name`, `price`, `image`) VALUES
(1, 'My Surprise Box S', 250, 'mysuprisebox.png'),
(2, 'My Surprise Box M', 550, 'mysuprisebox.png'),
(3, 'My Surprise Box L', 850, 'mysuprisebox.png');

-- --------------------------------------------------------

--
-- Структура таблицы `boxes_have_products`
--

CREATE TABLE `boxes_have_products` (
  `id` int(11) NOT NULL,
  `box_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `boxes_have_products`
--

INSERT INTO `boxes_have_products` (`id`, `box_id`, `product_id`) VALUES
(1, 3, 1),
(2, 3, 2),
(3, 3, 3),
(4, 1, 4),
(5, 1, 5),
(6, 1, 6),
(7, 1, 7),
(8, 1, 8),
(9, 1, 9),
(10, 1, 10),
(11, 1, 11),
(12, 1, 12),
(13, 1, 27),
(14, 1, 28),
(15, 1, 29),
(17, 2, 17),
(18, 2, 22),
(19, 2, 21),
(20, 2, 10),
(21, 2, 25),
(22, 2, 9),
(23, 2, 30),
(24, 3, 33),
(25, 3, 4),
(26, 3, 24),
(27, 3, 26),
(28, 3, 9),
(29, 3, 14),
(30, 3, 16),
(31, 3, 18),
(32, 2, 12);

-- --------------------------------------------------------

--
-- Структура таблицы `photos`
--

CREATE TABLE `photos` (
  `photo_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `photos`
--

INSERT INTO `photos` (`photo_id`) VALUES
(1),
(2),
(3),
(4),
(5),
(6),
(7),
(8),
(9),
(10),
(11),
(12),
(13),
(14),
(15),
(16),
(17),
(18),
(19);

-- --------------------------------------------------------

--
-- Структура таблицы `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `product_name` varchar(50) NOT NULL,
  `product_img` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `products`
--

INSERT INTO `products` (`product_id`, `product_name`, `product_img`) VALUES
(1, 'iPhone 7', 'iphone7.png'),
(2, 'iPhone 6', 'iphone6.png'),
(3, 'iPhone 5', 'iphone5.png'),
(4, 'Телефон на Андроиде', 'redmi-note-8-4914998_640.png'),
(5, 'Повер банк Сяоми', 'xiaomi-power-bank.png'),
(6, 'Bluetooth колонка', 'bluetooth.png'),
(7, 'USB кабель', '3usb-cable.png'),
(8, 'Селфи Кольца', 'circle.png'),
(9, 'Экшн камера', 'gopro640.png'),
(10, 'Фитнес трекер', 'xiaomi_mi_smart_band_4_black_0.png'),
(11, 'Визитница', 'visit.png'),
(12, 'Беспроводной караоке микрофон', 'wireless-micro.png'),
(14, 'Планшет', 'planshet.png\r\n'),
(16, 'Xiaomi MiBand\'s 5', 'miBand5.png'),
(17, 'JBL Колонка', 'jbl.png'),
(18, 'Колонка Hopestar', 'hopestar.png'),
(21, 'Фонарь-шокер', 'fonar.png'),
(22, 'Приставка sup games box', 'computer.png'),
(23, 'Часы ArmyWatch', 'army watch.png'),
(24, 'Часы AppleWatch', 'AppleWatch.png'),
(25, 'Наушники Android', 'android.png'),
(26, 'Наушники AirPods 2', 'airpods2.png'),
(27, 'Часы(класические)', 'classic.png'),
(28, 'Флешка', 'flash2.png'),
(29, 'Вентилятор(usb)', 'vent2.png'),
(30, 'Очки виртуальной реальности', 'vr-box.png'),
(33, 'Iphone X', 'iphoneX-640.png');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `boxes`
--
ALTER TABLE `boxes`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `boxes_have_products`
--
ALTER TABLE `boxes_have_products`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `photos`
--
ALTER TABLE `photos`
  ADD PRIMARY KEY (`photo_id`);

--
-- Индексы таблицы `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `boxes`
--
ALTER TABLE `boxes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `boxes_have_products`
--
ALTER TABLE `boxes_have_products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT для таблицы `photos`
--
ALTER TABLE `photos`
  MODIFY `photo_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT для таблицы `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
