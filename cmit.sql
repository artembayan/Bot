-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Апр 17 2020 г., 00:37
-- Версия сервера: 10.3.13-MariaDB-log
-- Версия PHP: 7.1.32

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `cmit`
--

-- --------------------------------------------------------

--
-- Структура таблицы `courses`
--

CREATE TABLE `courses` (
  `course_ID` int(11) NOT NULL,
  `name` varchar(50) CHARACTER SET utf8 NOT NULL,
  `price` int(10) NOT NULL,
  `schedule` varchar(255) CHARACTER SET utf8 NOT NULL,
  `teacher` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `courses`
--

INSERT INTO `courses` (`course_ID`, `name`, `price`, `schedule`, `teacher`) VALUES
(1, '3D анимация', 2800, 'пн-чт 13:00-16:00', 4),
(2, 'Робошкола', 2600, 'вт-пт 12:00-15:00', 2),
(3, 'Программирование', 2280, 'пн-ср 16:00-18:00', 3);

-- --------------------------------------------------------

--
-- Структура таблицы `products`
--

CREATE TABLE `products` (
  `product_ID` int(11) NOT NULL,
  `Name` varchar(30) CHARACTER SET utf8 NOT NULL,
  `Price` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `products`
--

INSERT INTO `products` (`product_ID`, `Name`, `Price`) VALUES
(1, 'Изделие#1', 2650),
(2, 'Изделие#2', 1500),
(3, 'Изделие#3', 3500);

-- --------------------------------------------------------

--
-- Структура таблицы `requisites`
--

CREATE TABLE `requisites` (
  `req_ID` int(11) NOT NULL,
  `requisites` text CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `requisites`
--

INSERT INTO `requisites` (`req_ID`, `requisites`) VALUES
(1, 'ИНН: 3444262162\r\n\r\nКПП: 344401001\r\n\r\nОКПО: 06022534\r\n\r\nОГРН: 1163443083759\r\n\r\nОКФС: 41 - Смешанная российская собственность с долей федеральной собственности\r\n\r\nОКОГУ: 4210014 - Организации, учрежденные юридическими лицами или гражданами, или юридическими лицами и гражданами совместно\r\n\r\nОКОПФ: 12300 - Общества с ограниченной ответственностью\r\n\r\nОКТМО: 18701000001\r\n\r\nОКАТО: 18401395 - Центральный, Волгоград, Города областного подчинения Волгоградской области, Волгоградская область');

-- --------------------------------------------------------

--
-- Структура таблицы `services`
--

CREATE TABLE `services` (
  `service_ID` int(11) NOT NULL,
  `service_name` varchar(30) CHARACTER SET utf8 NOT NULL,
  `service_price` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `services`
--

INSERT INTO `services` (`service_ID`, `service_name`, `service_price`) VALUES
(1, 'Прототипирование', 2600),
(2, 'Сканирование', 3200),
(3, 'Восстановление детали', 1500);

-- --------------------------------------------------------

--
-- Структура таблицы `staff`
--

CREATE TABLE `staff` (
  `staff_ID` int(11) NOT NULL,
  `FIO` varchar(70) CHARACTER SET utf8 NOT NULL,
  `post` varchar(50) CHARACTER SET utf8 NOT NULL,
  `email` varchar(30) CHARACTER SET utf8 DEFAULT NULL,
  `phone` varchar(20) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `staff`
--

INSERT INTO `staff` (`staff_ID`, `FIO`, `post`, `email`, `phone`) VALUES
(2, 'Ивлев Павел Николаевич', 'Техник', 'techno@gmail.com', '+79616695846'),
(3, 'Иванов Иван Иванович', 'Аспирант', 'iviviv@mail.ru', '+79655584625'),
(4, 'Жмешенко Валерий Альбертович', 'Специалист', 'name@mail.ru', '+79615584632');

-- --------------------------------------------------------

--
-- Структура таблицы `tracking`
--

CREATE TABLE `tracking` (
  `order_ID` int(11) NOT NULL,
  `service` int(11) DEFAULT NULL,
  `employee` int(11) DEFAULT NULL,
  `status` varchar(255) CHARACTER SET utf8 NOT NULL,
  `ready_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `tracking`
--

INSERT INTO `tracking` (`order_ID`, `service`, `employee`, `status`, `ready_date`) VALUES
(2, 2, 3, 'В разработке', '2020-03-15'),
(3, 1, 4, 'Готово к выдаче', '2020-02-18');

-- --------------------------------------------------------

--
-- Структура таблицы `working_hours`
--

CREATE TABLE `working_hours` (
  `hours_ID` int(11) NOT NULL,
  `hours` text CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `working_hours`
--

INSERT INTO `working_hours` (`hours_ID`, `hours`) VALUES
(1, 'пн. - чт. : 12:00 - 19:00\r\nпт. : открытый день с 17:00 - 19:00 (рекомендуется для первого посещения).\r\nсб. - вс. : 13:00 - 18:00');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`course_ID`),
  ADD KEY `courses_ibfk_1` (`teacher`);

--
-- Индексы таблицы `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_ID`);

--
-- Индексы таблицы `requisites`
--
ALTER TABLE `requisites`
  ADD PRIMARY KEY (`req_ID`);

--
-- Индексы таблицы `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`service_ID`);

--
-- Индексы таблицы `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`staff_ID`);

--
-- Индексы таблицы `tracking`
--
ALTER TABLE `tracking`
  ADD PRIMARY KEY (`order_ID`),
  ADD KEY `employee` (`employee`),
  ADD KEY `service` (`service`);

--
-- Индексы таблицы `working_hours`
--
ALTER TABLE `working_hours`
  ADD PRIMARY KEY (`hours_ID`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `courses`
--
ALTER TABLE `courses`
  MODIFY `course_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `products`
--
ALTER TABLE `products`
  MODIFY `product_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `requisites`
--
ALTER TABLE `requisites`
  MODIFY `req_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `services`
--
ALTER TABLE `services`
  MODIFY `service_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `staff`
--
ALTER TABLE `staff`
  MODIFY `staff_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `tracking`
--
ALTER TABLE `tracking`
  MODIFY `order_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `working_hours`
--
ALTER TABLE `working_hours`
  MODIFY `hours_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `courses`
--
ALTER TABLE `courses`
  ADD CONSTRAINT `courses_ibfk_1` FOREIGN KEY (`teacher`) REFERENCES `staff` (`staff_ID`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Ограничения внешнего ключа таблицы `tracking`
--
ALTER TABLE `tracking`
  ADD CONSTRAINT `tracking_ibfk_1` FOREIGN KEY (`employee`) REFERENCES `staff` (`staff_ID`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `tracking_ibfk_2` FOREIGN KEY (`service`) REFERENCES `services` (`service_ID`) ON DELETE SET NULL ON UPDATE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
