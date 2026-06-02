cd-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Июн 02 2026 г., 20:45
-- Версия сервера: 5.6.51
-- Версия PHP: 7.4.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `network_accounting_db`
--

-- --------------------------------------------------------

--
-- Структура таблицы `defects`
--

CREATE TABLE `defects` (
  `id` int(11) NOT NULL,
  `point_id` int(11) NOT NULL,
  `category` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `severity` enum('high','medium','low') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `status` enum('open','in_progress','closed') COLLATE utf8mb4_unicode_ci DEFAULT 'open',
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `defects`
--

INSERT INTO `defects` (`id`, `point_id`, `category`, `severity`, `description`, `status`, `created_by`, `created_at`) VALUES
(1, 1, 'Скрутка', 'high', 'Самодельная скрутка на 2 розетки, провода оголены', 'open', 2, '2026-06-02 17:35:29'),
(2, 2, 'Крепление', 'high', 'Розетка не закреплена, валяется на полу, без маркировки', 'open', 3, '2026-06-02 17:35:29'),
(3, 3, 'Кабель', 'medium', 'Старая розетка со скотчем, провода без короба', 'open', 4, '2026-06-02 17:35:29'),
(4, 4, 'Механический', 'high', 'Корпус сломан, плата вывалилась', 'in_progress', 5, '2026-06-02 17:35:29'),
(5, 5, 'Электрический', 'high', 'Голая плата на трубе отопления, оголённые провода', 'open', 2, '2026-06-02 17:35:29'),
(6, 6, 'Кабель', 'high', 'Огромный ком из кабелей под столами', 'open', 6, '2026-06-02 17:35:29'),
(7, 7, 'Электрический', 'high', 'Розетка без крышки за трубами воды', 'open', 1, '2026-06-02 17:35:29'),
(8, 8, 'Электрический', '', 'Оголённые непромаркированные провода', 'open', 3, '2026-06-02 17:35:29');

-- --------------------------------------------------------

--
-- Структура таблицы `logs`
--

CREATE TABLE `logs` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `action` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `target_table` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `target_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `logs`
--

INSERT INTO `logs` (`id`, `user_id`, `action`, `target_table`, `target_id`, `created_at`) VALUES
(1, 1, 'Вход в систему', 'users', 1, '2026-06-01 06:00:00'),
(2, 2, 'Добавление', 'network_points', 9, '2026-06-01 06:30:00'),
(3, 3, 'Редактирование', 'defects', 4, '2026-06-01 07:15:00'),
(4, 4, 'Фиксация расхода', 'material_usage', 1, '2026-06-01 08:00:00'),
(5, 5, 'Удаление', 'network_points', 10, '2026-06-01 11:00:00'),
(6, 6, 'Экспорт отчёта', 'report', NULL, '2026-06-02 06:00:00'),
(7, 1, 'Закрытие дефекта', 'defects', 1, '2026-06-02 08:00:00'),
(8, 2, 'Просмотр логов', 'logs', NULL, '2026-06-02 09:00:00');

-- --------------------------------------------------------

--
-- Структура таблицы `materials`
--

CREATE TABLE `materials` (
  `id` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` enum('cable','connector','socket','fastener','other') COLLATE utf8mb4_unicode_ci NOT NULL,
  `unit` enum('m','pcs') COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `materials`
--

INSERT INTO `materials` (`id`, `name`, `type`, `unit`) VALUES
(1, 'Кабель UTP cat5e', 'cable', 'm'),
(2, 'Кабель UTP cat6', 'cable', 'm'),
(3, 'Коннектор RJ45', 'connector', 'pcs'),
(4, 'Розетка RJ45 двойная', 'socket', 'pcs'),
(5, 'Розетка RJ45 одинарная', 'socket', 'pcs'),
(6, 'Кабель-канал 20x10', 'fastener', 'm'),
(7, 'Стяжки кабельные', 'fastener', 'pcs'),
(8, 'Дюбель-хомуты', 'fastener', 'pcs'),
(9, 'Патч-корд 0.5м', 'other', 'pcs'),
(10, 'Патч-корд 1м', 'other', 'pcs'),
(11, 'Изолента ПВХ', 'other', 'pcs'),
(12, 'Коробка подрозетник', 'other', 'pcs');

-- --------------------------------------------------------

--
-- Структура таблицы `material_usage`
--

CREATE TABLE `material_usage` (
  `id` int(11) NOT NULL,
  `material_id` int(11) NOT NULL,
  `quantity` decimal(10,2) NOT NULL,
  `point_id` int(11) DEFAULT NULL,
  `defect_id` int(11) DEFAULT NULL,
  `used_by` int(11) NOT NULL,
  `used_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `comment` text COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `material_usage`
--

INSERT INTO `material_usage` (`id`, `material_id`, `quantity`, `point_id`, `defect_id`, `used_by`, `used_at`, `comment`) VALUES
(15, 1, '25.50', 3, 3, 2, '2026-05-31 10:00:00', 'Заменили повреждённый участок кабеля'),
(16, 3, '8.00', 1, 1, 3, '2026-05-31 11:30:00', 'Переобжали концы на новые коннекторы'),
(17, 4, '3.00', 4, 4, 4, '2026-06-01 09:00:00', 'Установили новые двойные розетки'),
(18, 6, '10.00', 6, 6, 5, '2026-06-01 14:00:00', 'Проложили кабель-канал'),
(19, 7, '20.00', NULL, NULL, 1, '2026-06-02 08:00:00', 'Закупили на склад для ремонта'),
(20, 2, '50.00', 8, 8, 2, '2026-06-02 10:00:00', 'Проложили новый кабель cat6'),
(21, 10, '5.00', NULL, NULL, 3, '2026-06-02 12:00:00', 'Патч-корды для свитча');

-- --------------------------------------------------------

--
-- Структура таблицы `network_points`
--

CREATE TABLE `network_points` (
  `id` int(11) NOT NULL,
  `label` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` enum('socket','switch','cable_run','patch_cord') COLLATE utf8mb4_unicode_ci NOT NULL,
  `location` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('active','defect','decommissioned') COLLATE utf8mb4_unicode_ci DEFAULT 'active',
  `last_check` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `network_points`
--

INSERT INTO `network_points` (`id`, `label`, `type`, `location`, `status`, `last_check`) VALUES
(1, 'ROOM319-1', 'socket', 'над плинтусом', 'defect', '2026-05-30'),
(2, 'ROOM319-2', 'socket', 'на полу у плинтуса', 'defect', '2026-05-30'),
(3, 'ROOM319-3', 'cable_run', 'на полу, старая розетка', 'defect', '2026-05-30'),
(4, 'ROOM319-4', 'socket', 'на стене, сломана', 'defect', '2026-05-30'),
(5, 'ROOM319-5', 'socket', 'на трубе отопления', 'defect', '2026-05-30'),
(6, 'ROOM319-6', 'cable_run', 'под столами, куча кабелей', 'defect', '2026-05-30'),
(7, 'ROOM319-7', 'socket', 'за трубами воды', 'defect', '2026-05-30'),
(8, 'ROOM319-8', 'cable_run', 'оголённые провода', 'defect', '2026-05-30');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `login` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('admin','operator') COLLATE utf8mb4_unicode_ci DEFAULT 'operator'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `login`, `password_hash`, `role`) VALUES
(1, 'nikita', '2213125345343', 'admin'),
(2, 'kirill', '3543534534', 'operator'),
(3, 'timur', '342432432432', 'operator'),
(4, 'yaroslav', '324433443', 'operator'),
(5, 'vladislava', '32424432', 'operator'),
(6, 'almira', '3432432423432', 'operator'),
(7, 'ilya', '6546456', 'operator');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `defects`
--
ALTER TABLE `defects`
  ADD PRIMARY KEY (`id`),
  ADD KEY `point_id` (`point_id`),
  ADD KEY `created_by` (`created_by`);

--
-- Индексы таблицы `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Индексы таблицы `materials`
--
ALTER TABLE `materials`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `material_usage`
--
ALTER TABLE `material_usage`
  ADD PRIMARY KEY (`id`),
  ADD KEY `material_id` (`material_id`),
  ADD KEY `point_id` (`point_id`),
  ADD KEY `defect_id` (`defect_id`),
  ADD KEY `used_by` (`used_by`);

--
-- Индексы таблицы `network_points`
--
ALTER TABLE `network_points`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `label` (`label`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `login` (`login`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `defects`
--
ALTER TABLE `defects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT для таблицы `logs`
--
ALTER TABLE `logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT для таблицы `materials`
--
ALTER TABLE `materials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT для таблицы `material_usage`
--
ALTER TABLE `material_usage`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT для таблицы `network_points`
--
ALTER TABLE `network_points`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `defects`
--
ALTER TABLE `defects`
  ADD CONSTRAINT `defects_ibfk_1` FOREIGN KEY (`point_id`) REFERENCES `network_points` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `defects_ibfk_2` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`);

--
-- Ограничения внешнего ключа таблицы `logs`
--
ALTER TABLE `logs`
  ADD CONSTRAINT `logs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Ограничения внешнего ключа таблицы `material_usage`
--
ALTER TABLE `material_usage`
  ADD CONSTRAINT `material_usage_ibfk_1` FOREIGN KEY (`material_id`) REFERENCES `materials` (`id`),
  ADD CONSTRAINT `material_usage_ibfk_2` FOREIGN KEY (`point_id`) REFERENCES `network_points` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `material_usage_ibfk_3` FOREIGN KEY (`defect_id`) REFERENCES `defects` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `material_usage_ibfk_4` FOREIGN KEY (`used_by`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
