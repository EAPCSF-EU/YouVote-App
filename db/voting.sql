-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Мар 22 2019 г., 09:39
-- Версия сервера: 5.7.20
-- Версия PHP: 7.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `voting`
--

-- --------------------------------------------------------

--
-- Структура таблицы `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `contest_id` int(11) NOT NULL,
  `title_ru` varchar(250) NOT NULL,
  `title_en` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `contest`
--

CREATE TABLE `contest` (
  `id` int(11) NOT NULL,
  `title_en` varchar(250) NOT NULL,
  `description_en` text NOT NULL,
  `title_ru` varchar(250) NOT NULL,
  `description_ru` text NOT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `public` tinyint(1) NOT NULL,
  `result_panel` tinyint(1) NOT NULL,
  `voters_limit` int(11) NOT NULL,
  `range` tinyint(4) NOT NULL COMMENT 'range for example [1-10]',
  `permalink` varchar(50) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `contest`
--

INSERT INTO `contest` (`id`, `title_en`, `description_en`, `title_ru`, `description_ru`, `start_date`, `end_date`, `public`, `result_panel`, `voters_limit`, `range`, `permalink`, `created_at`, `updated_at`) VALUES
(1, 'sdf', 'sdfsd', 'sfs', 'sdf', '2019-03-21 10:25:00', '2019-03-22 10:25:00', 1, 0, 12, 12, 'https://facebook.com', '2019-03-20 16:46:45', '2019-03-20 18:23:46'),
(2, 'Test', 'Test', 'Test', 'T', '1899-12-14 10:50:00', '2019-03-04 13:10:00', 0, 0, 1, 1, 'https://facebook.com', '2019-03-20 22:47:34', '2019-03-20 18:33:32'),
(3, 'sdf', 'sdf', 'sdf', 'sdfs', '2019-03-01 22:35:00', '2019-03-07 11:45:00', 1, 1, 1, 1, 'https://facebook.com', '2019-03-20 22:52:28', '2019-03-20 17:52:28');

--
-- Триггеры `contest`
--
DELIMITER $$
CREATE TRIGGER `set_created_at_contest` BEFORE INSERT ON `contest` FOR EACH ROW SET new.created_at=NOW()
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Структура таблицы `migration`
--

CREATE TABLE `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `migration`
--

INSERT INTO `migration` (`version`, `apply_time`) VALUES
('m000000_000000_base', 1553018537),
('m130524_201442_init', 1553018540);

-- --------------------------------------------------------

--
-- Структура таблицы `project`
--

CREATE TABLE `project` (
  `id` int(11) NOT NULL,
  `contest_id` int(11) NOT NULL,
  `title_en` varchar(250) NOT NULL,
  `title_ru` varchar(250) NOT NULL,
  `content_en` text NOT NULL,
  `content_ru` text NOT NULL,
  `image` varchar(1024) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `project`
--

INSERT INTO `project` (`id`, `contest_id`, `title_en`, `title_ru`, `content_en`, `content_ru`, `image`, `created_at`, `updated_at`) VALUES
(2, 2, 'rrrr', 'rrrrrr', 'rrrrrrrrrr', 'rrrrrrr', '5c93b00cd136b.jpg', '2019-03-21 20:38:40', '2019-03-21 15:38:54'),
(3, 2, 'asdasfas', 'asffasfas', 'fasfa', 'sfasfsa', '5c93b6e628566.png', '2019-03-21 21:08:08', '2019-03-21 16:08:08');

--
-- Триггеры `project`
--
DELIMITER $$
CREATE TRIGGER `set_created_at_project` BEFORE INSERT ON `project` FOR EACH ROW SET new.created_at=NOW()
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Структура таблицы `team`
--

CREATE TABLE `team` (
  `id` int(11) NOT NULL,
  `title_en` varchar(250) NOT NULL,
  `title_ru` varchar(250) NOT NULL,
  `project_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `team`
--

INSERT INTO `team` (`id`, `title_en`, `title_ru`, `project_id`) VALUES
(1, 'ffffffffff', 'fffffffffffffffff', 2),
(2, 'sdfsdf s', ' sdf sdf sdf', 3);

-- --------------------------------------------------------

--
-- Структура таблицы `voter`
--

CREATE TABLE `voter` (
  `id` int(11) NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `team_id` int(11) DEFAULT NULL,
  `auth_key` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password_reset_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` smallint(6) NOT NULL DEFAULT '10',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `role` tinyint(4) NOT NULL DEFAULT '2'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `voter`
--

INSERT INTO `voter` (`id`, `username`, `name`, `team_id`, `auth_key`, `password_hash`, `password_reset_token`, `email`, `status`, `created_at`, `updated_at`, `role`) VALUES
(1, 'admin', 'Davron Raximov', NULL, 'LDjuyI6nON2AfpgJUYPVGgxh8UnWYUeH', '$2y$13$UtZI/wAKWvLUQlLcC8oisuQkp59ONK5PpUCiIzMD6hU8h0o8C2DXu', NULL, 'admin@admin.admin', 10, 1553018543, 1553018543, 1),
(2, 'Alijon', NULL, NULL, 'CM1gCZ-7VLEJqjqkUs4HT_uZUzHU9ubI', '$2y$13$r4CLeqh5GeFqsDqjbQvS6OxqZqQaEeXaKw7wFioJ/eMYPuPK7CKo.', NULL, 'Alijon@mail.ru', 10, 1553200549, 1553200549, 2),
(3, 'Alijon2', 'Alijon Bozorboyev', 2, 'SFqj5KU4D_xdHQFr7XhzXoqgcidayQV7', '$2y$13$pSwlvKGKsdFLA8.on.QGheOLr3WkgV4nBqF0bvvhS2qtRA.p20ONO', NULL, 'Alijon@mail.ru2', 10, 1553200665, 1553200665, 2);

-- --------------------------------------------------------

--
-- Структура таблицы `votes`
--

CREATE TABLE `votes` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `contest_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `score` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`),
  ADD KEY `categories_fk0` (`contest_id`);

--
-- Индексы таблицы `contest`
--
ALTER TABLE `contest`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `migration`
--
ALTER TABLE `migration`
  ADD PRIMARY KEY (`version`);

--
-- Индексы таблицы `project`
--
ALTER TABLE `project`
  ADD PRIMARY KEY (`id`),
  ADD KEY `contentder_fk0` (`contest_id`);

--
-- Индексы таблицы `team`
--
ALTER TABLE `team`
  ADD PRIMARY KEY (`id`),
  ADD KEY `team_contender` (`project_id`);

--
-- Индексы таблицы `voter`
--
ALTER TABLE `voter`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `password_reset_token` (`password_reset_token`),
  ADD KEY `team_id` (`team_id`);

--
-- Индексы таблицы `votes`
--
ALTER TABLE `votes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `votes_fk0` (`user_id`),
  ADD KEY `votes_category` (`category_id`),
  ADD KEY `votes_contest` (`contest_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `contest`
--
ALTER TABLE `contest`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `project`
--
ALTER TABLE `project`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `team`
--
ALTER TABLE `team`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `voter`
--
ALTER TABLE `voter`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `votes`
--
ALTER TABLE `votes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `category`
--
ALTER TABLE `category`
  ADD CONSTRAINT `categories_fk0` FOREIGN KEY (`contest_id`) REFERENCES `contest` (`id`);

--
-- Ограничения внешнего ключа таблицы `project`
--
ALTER TABLE `project`
  ADD CONSTRAINT `contentder_fk0` FOREIGN KEY (`contest_id`) REFERENCES `contest` (`id`);

--
-- Ограничения внешнего ключа таблицы `team`
--
ALTER TABLE `team`
  ADD CONSTRAINT `team_contender` FOREIGN KEY (`project_id`) REFERENCES `project` (`id`);

--
-- Ограничения внешнего ключа таблицы `voter`
--
ALTER TABLE `voter`
  ADD CONSTRAINT `voter_ibfk_1` FOREIGN KEY (`team_id`) REFERENCES `team` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `votes`
--
ALTER TABLE `votes`
  ADD CONSTRAINT `votes_category` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`),
  ADD CONSTRAINT `votes_contest` FOREIGN KEY (`contest_id`) REFERENCES `contest` (`id`),
  ADD CONSTRAINT `votes_fk0` FOREIGN KEY (`user_id`) REFERENCES `voter` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

ALTER TABLE `contest` ADD `image` VARCHAR(255) NULL AFTER `permalink`;


-- update ---

ALTER TABLE `voter`  DROP `team_id`;


CREATE TABLE `project_to_user` (
  `project_id` int(11) NOT NULL,
  `voter_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `project_to_user`
--
ALTER TABLE `project_to_user`
  ADD KEY `project_to_user_project` (`project_id`),
  ADD KEY `project_to_user_voter` (`voter_id`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `project_to_user`
--
ALTER TABLE `project_to_user`
  ADD CONSTRAINT `project_to_user_project` FOREIGN KEY (`project_id`) REFERENCES `project` (`id`),
  ADD CONSTRAINT `project_to_user_voter` FOREIGN KEY (`voter_id`) REFERENCES `voter` (`id`);

ALTER TABLE `project_to_user` ADD UNIQUE `project_user_unique` (`project_id`, `voter_id`);

ALTER TABLE `contest` CHANGE `voters_limit` `voters_limit` INT(11) NULL, CHANGE `permalink` `permalink` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL;


-------
ALTER TABLE `votes` ADD `project_id` INT NOT NULL AFTER `user_id`;

-- Reference: votes_project (table: votes)
ALTER TABLE votes ADD CONSTRAINT votes_project FOREIGN KEY votes_project (project_id)
   REFERENCES project (id);

ALTER TABLE `project` CHANGE `content_en` `content_en` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL, CHANGE `content_ru` `content_ru` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL, CHANGE `image` `image` VARCHAR(1024) CHARACTER SET utf8 COLLATE utf8_general_ci NULL;


-- update
ALTER TABLE `contest` CHANGE `voters_limit` `voters_limit` INT(11) NULL;
ALTER TABLE `contest` CHANGE `permalink` `permalink` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL;

