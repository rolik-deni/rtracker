-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Хост: localhost:3306
-- Время создания: Июн 26 2019 г., 03:30
-- Версия сервера: 10.1.40-MariaDB-0ubuntu0.18.04.1
-- Версия PHP: 7.3.6-1+ubuntu18.04.1+deb.sury.org+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `tracker`
--

-- --------------------------------------------------------

--
-- Структура таблицы `country`
--

CREATE TABLE `country` (
  `id` smallint(5) UNSIGNED NOT NULL COMMENT 'Идентификатор',
  `title` varchar(45) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Название',
  `code` varchar(3) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Идентификационный код'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `country`
--

INSERT INTO `country` (`id`, `title`, `code`) VALUES
(10, 'США', 'us'),
(11, 'Австралия', 'au'),
(12, 'Великобритания', 'gb'),
(13, 'Италия', 'it'),
(14, 'Канада', 'ca'),
(15, 'Норвегия', 'no'),
(16, 'Россия', 'ru'),
(17, 'Ирландия', 'ie'),
(18, 'Франция', 'fr');

-- --------------------------------------------------------

--
-- Структура таблицы `episode`
--

CREATE TABLE `episode` (
  `id` smallint(5) UNSIGNED NOT NULL COMMENT 'Идентификатор',
  `serial_id` smallint(5) UNSIGNED DEFAULT NULL COMMENT 'Идентификатор',
  `title` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Название',
  `original_title` varchar(45) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Оригинальное название',
  `number` smallint(5) UNSIGNED NOT NULL COMMENT 'Номер серии',
  `season_number` smallint(5) UNSIGNED NOT NULL COMMENT 'Номер сезона',
  `release_date` datetime NOT NULL COMMENT 'Дата выхода'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `episode`
--

INSERT INTO `episode` (`id`, `serial_id`, `title`, `original_title`, `number`, `season_number`, `release_date`) VALUES
(1, 1, 'Эпизод #1.1', '', 1, 1, '2012-12-06 00:00:00'),
(3, 1, 'Эпизод #1.2', '', 2, 1, '2012-12-13 00:00:00'),
(4, 1, 'Эпизод #1.3', '', 3, 1, '2012-12-20 00:00:00'),
(5, 1, 'Эпизод #1.4', '', 4, 1, '2012-12-27 00:00:00'),
(6, 1, 'Эпизод #2.1', '', 1, 2, '2013-11-21 00:00:00'),
(7, 1, 'Эпизод #2.2', '', 2, 2, '2013-11-28 00:00:00'),
(8, 1, 'Эпизод #2.3', '', 3, 2, '2013-12-05 00:00:00'),
(9, 1, 'Эпизод #2.4', '', 4, 2, '2013-12-12 00:00:00'),
(10, 2, 'Эпизод #1.1', '', 1, 1, '2016-02-21 00:00:00'),
(11, 2, 'Эпизод #1.2', '', 2, 1, '2016-02-28 00:00:00'),
(12, 2, 'Эпизод #1.3', '', 3, 1, '2016-03-06 00:00:00'),
(13, 2, 'Эпизод #1.4', '', 4, 1, '2016-03-13 00:00:00'),
(14, 2, 'Эпизод #1.5', '', 5, 1, '2016-03-20 00:00:00'),
(15, 2, 'Эпизод #1.6', '', 6, 1, '2016-03-27 00:00:00'),
(16, 3, 'Часть 1', '', 1, 1, '2013-10-29 00:00:00'),
(17, 3, 'Часть 2', '', 2, 1, '2013-11-05 00:00:00'),
(18, 3, 'Часть 3', '', 3, 1, '2013-11-12 00:00:00'),
(19, 4, NULL, 'The Overlords', 1, 1, '2015-12-14 00:00:00'),
(20, 4, NULL, 'The Deceivers', 2, 1, '2015-12-15 00:00:00'),
(21, 4, NULL, 'The Children', 3, 1, '2015-12-16 00:00:00'),
(22, 5, NULL, 'The Fort', 1, 1, '2015-11-15 00:00:00'),
(23, 5, NULL, 'Fist Like a Bullet', 2, 1, '2015-11-22 00:00:00'),
(24, 5, NULL, 'White Stork Spreads Wings', 3, 1, '2015-11-29 00:00:00'),
(25, 5, NULL, 'Two Tigers Subdue Dragons', 4, 1, '2015-12-06 00:00:00'),
(26, 5, NULL, 'Snake Creeps Down', 5, 1, '2015-12-13 00:00:00'),
(27, 5, 'Hand of Five Poisons', '', 6, 1, '2015-12-20 00:00:00'),
(28, 5, 'Tiger Pushes Mountain', '', 1, 2, '2017-03-19 00:00:00'),
(29, 5, NULL, 'Force of Eagle\'s Claw', 2, 2, '2017-03-26 00:00:00'),
(30, 5, NULL, 'Red Sun, Silver Moon', 3, 2, '2017-04-02 00:00:00'),
(31, 5, NULL, 'Palm of the Iron Fox', 4, 2, '2017-04-09 00:00:00'),
(32, 5, NULL, 'Monkey Leaps Through Mist', 5, 2, '2017-04-16 00:00:00'),
(33, 5, NULL, 'Leopard Stalks in Snow', 6, 2, '2017-04-23 00:00:00'),
(34, 5, NULL, 'Black Heart, White Mountain', 7, 2, '2017-04-30 00:00:00'),
(35, 5, NULL, 'Sting of the Scorpion\'s Tail', 8, 2, '2017-05-07 00:00:00'),
(36, 5, NULL, 'Nightingale Sings No More', 9, 2, '2017-05-14 00:00:00'),
(37, 5, NULL, 'Wolf\'s Breath, Dragon Fire', 10, 2, '2017-05-21 00:00:00');

-- --------------------------------------------------------

--
-- Структура таблицы `genre`
--

CREATE TABLE `genre` (
  `id` smallint(5) UNSIGNED NOT NULL COMMENT 'Идентификатор',
  `title` varchar(45) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Название'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `genre`
--

INSERT INTO `genre` (`id`, `title`) VALUES
(4, 'боевик'),
(1, 'драма'),
(2, 'комедия'),
(6, 'приключение'),
(3, 'триллер'),
(5, 'фантастика');

-- --------------------------------------------------------

--
-- Структура таблицы `serial`
--

CREATE TABLE `serial` (
  `id` smallint(5) UNSIGNED NOT NULL COMMENT 'Идентификатор',
  `tv_network_id` smallint(5) UNSIGNED DEFAULT NULL COMMENT 'Идентификатор',
  `validation_status_id` smallint(5) UNSIGNED DEFAULT NULL COMMENT 'Идентификатор',
  `title` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Название',
  `original_title` varchar(45) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Оригинальное название',
  `description` longtext COLLATE utf8_unicode_ci COMMENT 'Описание',
  `year_start` smallint(5) UNSIGNED DEFAULT NULL COMMENT 'Дата начала выхода серий',
  `year_end` smallint(5) UNSIGNED DEFAULT NULL COMMENT 'Дата завершения выхода серий',
  `actor` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Список актёров',
  `poster322` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Постер с шириной 322 px',
  `poster72` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Постер с шириной 72 px',
  `imdb_id` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Идентификатор на imdb.com',
  `kinopoisk_id` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Идентификатор на kinopoisk.ru',
  `season_number` smallint(5) UNSIGNED DEFAULT NULL COMMENT 'Число сезонов',
  `episode_number` smallint(5) UNSIGNED DEFAULT NULL COMMENT 'Число эпизодов',
  `url` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Ссылка на сериал'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `serial`
--

INSERT INTO `serial` (`id`, `tv_network_id`, `validation_status_id`, `title`, `original_title`, `description`, `year_start`, `year_end`, `actor`, `poster322`, `poster72`, `imdb_id`, `kinopoisk_id`, `season_number`, `episode_number`, `url`) VALUES
(1, 1, 1, 'Записки юного врача', 'A Young Doctor\'s Notebook', 'В неспокойное революционное время юный врач Бомгард Владимир прибыл в маленькую деревушку, где принялся лечить местных жителей. Главному герою сериала приходится весьма нелегко, ведь он вынужден сталкиваться с трудностями своей профессии, а также постоянными суевериями своих пациентов.', 2012, 2013, 'Дэниэл Рэдклифф, Джон Хэмм, Рози Кавальеро, Адам Годли, Вики Пеппердин, Дэниэл Серкера, Тим Стид, Шон Пай, Маргарет Клуни, Чарльз Эдвардс', 'young_doctor-s_notebook.322x436.jpg', 'young_doctor-s_notebook.72x94.jpg', 'tt2164430', '687812', 2, 8, ''),
(2, 2, 1, 'Ночной администратор', 'The Night Manager', 'Бывший британский солдат Джонатан Пайн (Том Хиддлстон) нанят сотрудницей разведки Бёрр (Оливия Колман). Между двумя разведывательными организациями, базирующимися в Уайтхолле и Вашингтоне, существует альянс, который отправляет Пайна в синдикат по торговле оружием. Он должен втереться в доверие торговца оружием Ричарда Ропера (Хью Лори), его девушки Джед (Элизабет Дебики) и подручного Коркорана (Том Холландер).', 2016, 2016, 'Том Хиддлстон, Хью Лори, Элизабет Дебики, Оливия Колман, Том Холландер, Майкл Нардон, Алистэр Петри, Дуглас Ходж, Дэвид Хэрвуд, Тобайас Мензис', 'night_manager.322x436.jpg', 'night_manager.72x94.jpg', 'tt1399664', '462649', 1, 6, ''),
(3, 3, 1, 'Мастер побега', 'The Escape Artist', 'Уилл Бертон — талантливый младший адвокат, обладающий несравненным интеллектом и невероятным обаянием. Он специализируется на делах по тяжким уголовным преступлениям. Как адвокат, он пользуется большим спросом, так как не проиграл ни одного дела. Но он оправдывает главного подозреваемого в деле об ужасном убийстве, и это приводит к неожиданным пугающим последствиям.', 2013, 2013, 'Дэвид Теннант, Тоби Кеббелл, Тони Гарднер, Эшли Дженсен, Софи Оконедо, Джини Спарк, Роксанна Грегори, Аарон Нилс, Гас Барри, Брид Бреннан', 'escape_artist.322x436.jpg', 'escape_artist.72x94.jpg', 'tt2649522', '771193', 1, 3, ''),
(4, 4, 1, ' Конец детства', 'Childhood\'s End', 'Сериал расскажет о мирном вторжении пришельцев на Землю: прибытие инопланетных гостей привело к немедленному прекращению войн и превратило планету практически в утопию.', 2015, 2015, 'Майк Фогель, Ози Икхайл, Дэйзи Беттс, Джорджина Хэйг, Чарльз Дэнс, Эшли Цукерман, Хейли Магнус, Шарлотта Никдао, Яэль Стоун, Лачлан Роланд-Кенн', 'childhood-s_end.322x436.jpg', 'childhood-s_end.72x94.jpg', 'tt4146128', '844223', 1, 3, ''),
(5, 2, 1, ' В пустыне смерти', 'Into the Badlands', 'Сериал про воина по имени Санни, сопровождающего в пути по бесплодным землям юного мальчика.', 2015, NULL, 'Эмили Бичем, Сара Болгер, Орла Брэйди, Мартон Чокаш, Элли Иоаннидес, Арамис Найт, Мадлен Манток, Майкл Сил, Оливер Старк, Дэниэл Ву', 'into_the_badlands.322x436.jpg', 'into_the_badlands.72x94.jpg', 'tt3865236', '891611', 2, 16, '');

-- --------------------------------------------------------

--
-- Структура таблицы `serial_has_country`
--

CREATE TABLE `serial_has_country` (
  `serial_id` smallint(5) UNSIGNED NOT NULL COMMENT 'Идентификатор',
  `country_id` smallint(5) UNSIGNED NOT NULL COMMENT 'Идентификатор'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `serial_has_country`
--

INSERT INTO `serial_has_country` (`serial_id`, `country_id`) VALUES
(1, 12),
(2, 10),
(2, 12),
(3, 12),
(4, 10),
(5, 10);

-- --------------------------------------------------------

--
-- Структура таблицы `serial_has_genre`
--

CREATE TABLE `serial_has_genre` (
  `serial_id` smallint(5) UNSIGNED NOT NULL COMMENT 'Идентификатор',
  `genre_id` smallint(5) UNSIGNED NOT NULL COMMENT 'Идентификатор'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `serial_has_genre`
--

INSERT INTO `serial_has_genre` (`serial_id`, `genre_id`) VALUES
(1, 1),
(1, 2),
(2, 1),
(2, 3),
(2, 4),
(3, 1),
(3, 3),
(4, 1),
(4, 3),
(4, 5),
(5, 1),
(5, 4),
(5, 6);

-- --------------------------------------------------------

--
-- Структура таблицы `track_serial`
--

CREATE TABLE `track_serial` (
  `user_id` smallint(5) UNSIGNED NOT NULL COMMENT 'Идентификатор',
  `serial_id` smallint(5) UNSIGNED NOT NULL COMMENT 'Идентификатор'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `tv_network`
--

CREATE TABLE `tv_network` (
  `id` smallint(5) UNSIGNED NOT NULL COMMENT 'Идентификатор',
  `title` varchar(45) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Название'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `tv_network`
--

INSERT INTO `tv_network` (`id`, `title`) VALUES
(2, 'AMC'),
(3, 'BBC'),
(1, 'Sky Arts'),
(4, 'SyFy');

-- --------------------------------------------------------

--
-- Структура таблицы `user`
--

CREATE TABLE `user` (
  `id` smallint(5) UNSIGNED NOT NULL COMMENT 'Идентификатор',
  `email` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Эл. почта',
  `password` varchar(150) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Пароль',
  `registration_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Дата регистрации',
  `is_active` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `validation_status`
--

CREATE TABLE `validation_status` (
  `id` smallint(5) UNSIGNED NOT NULL COMMENT 'Идентификатор',
  `title` varchar(45) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Название'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `validation_status`
--

INSERT INTO `validation_status` (`id`, `title`) VALUES
(1, 'Проверено'),
(2, 'Не проверено');

-- --------------------------------------------------------

--
-- Структура таблицы `view_episode`
--

CREATE TABLE `view_episode` (
  `user_id` smallint(5) UNSIGNED NOT NULL COMMENT 'Идентификатор',
  `episode_id` smallint(5) UNSIGNED NOT NULL COMMENT 'Идентификатор'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `country`
--
ALTER TABLE `country`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_5373C9662B36786B` (`title`),
  ADD UNIQUE KEY `UNIQ_5373C96677153098` (`code`);

--
-- Индексы таблицы `episode`
--
ALTER TABLE `episode`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_DDAA1CDAAF82D095` (`serial_id`);

--
-- Индексы таблицы `genre`
--
ALTER TABLE `genre`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_835033F82B36786B` (`title`);

--
-- Индексы таблицы `serial`
--
ALTER TABLE `serial`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_serial_tv_network_id` (`tv_network_id`),
  ADD KEY `idx_serial_validation_status_id` (`validation_status_id`);

--
-- Индексы таблицы `serial_has_country`
--
ALTER TABLE `serial_has_country`
  ADD PRIMARY KEY (`serial_id`,`country_id`),
  ADD KEY `IDX_3B4521C5AF82D095` (`serial_id`),
  ADD KEY `IDX_3B4521C5F92F3E70` (`country_id`);

--
-- Индексы таблицы `serial_has_genre`
--
ALTER TABLE `serial_has_genre`
  ADD PRIMARY KEY (`serial_id`,`genre_id`),
  ADD KEY `IDX_D63DDE3DAF82D095` (`serial_id`),
  ADD KEY `IDX_D63DDE3D4296D31F` (`genre_id`);

--
-- Индексы таблицы `track_serial`
--
ALTER TABLE `track_serial`
  ADD PRIMARY KEY (`user_id`,`serial_id`),
  ADD KEY `IDX_9BB60835A76ED395` (`user_id`),
  ADD KEY `IDX_9BB60835AF82D095` (`serial_id`);

--
-- Индексы таблицы `tv_network`
--
ALTER TABLE `tv_network`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_EE7F4E632B36786B` (`title`);

--
-- Индексы таблицы `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`);

--
-- Индексы таблицы `validation_status`
--
ALTER TABLE `validation_status`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `view_episode`
--
ALTER TABLE `view_episode`
  ADD PRIMARY KEY (`user_id`,`episode_id`),
  ADD KEY `IDX_F4F70920A76ED395` (`user_id`),
  ADD KEY `IDX_F4F70920362B62A0` (`episode_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `country`
--
ALTER TABLE `country`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Идентификатор', AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT для таблицы `episode`
--
ALTER TABLE `episode`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Идентификатор', AUTO_INCREMENT=38;
--
-- AUTO_INCREMENT для таблицы `genre`
--
ALTER TABLE `genre`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Идентификатор', AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT для таблицы `serial`
--
ALTER TABLE `serial`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Идентификатор', AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT для таблицы `tv_network`
--
ALTER TABLE `tv_network`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Идентификатор', AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT для таблицы `user`
--
ALTER TABLE `user`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Идентификатор';
--
-- AUTO_INCREMENT для таблицы `validation_status`
--
ALTER TABLE `validation_status`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Идентификатор', AUTO_INCREMENT=3;
--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `episode`
--
ALTER TABLE `episode`
  ADD CONSTRAINT `FK_DDAA1CDAAF82D095` FOREIGN KEY (`serial_id`) REFERENCES `serial` (`id`);

--
-- Ограничения внешнего ключа таблицы `serial`
--
ALTER TABLE `serial`
  ADD CONSTRAINT `FK_D374C9DC8290BE81` FOREIGN KEY (`tv_network_id`) REFERENCES `tv_network` (`id`),
  ADD CONSTRAINT `FK_D374C9DCE0AE11FF` FOREIGN KEY (`validation_status_id`) REFERENCES `validation_status` (`id`);

--
-- Ограничения внешнего ключа таблицы `serial_has_country`
--
ALTER TABLE `serial_has_country`
  ADD CONSTRAINT `FK_3B4521C5AF82D095` FOREIGN KEY (`serial_id`) REFERENCES `serial` (`id`),
  ADD CONSTRAINT `FK_3B4521C5F92F3E70` FOREIGN KEY (`country_id`) REFERENCES `country` (`id`);

--
-- Ограничения внешнего ключа таблицы `serial_has_genre`
--
ALTER TABLE `serial_has_genre`
  ADD CONSTRAINT `FK_D63DDE3D4296D31F` FOREIGN KEY (`genre_id`) REFERENCES `genre` (`id`),
  ADD CONSTRAINT `FK_D63DDE3DAF82D095` FOREIGN KEY (`serial_id`) REFERENCES `serial` (`id`);

--
-- Ограничения внешнего ключа таблицы `track_serial`
--
ALTER TABLE `track_serial`
  ADD CONSTRAINT `FK_9BB60835A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `FK_9BB60835AF82D095` FOREIGN KEY (`serial_id`) REFERENCES `serial` (`id`);

--
-- Ограничения внешнего ключа таблицы `view_episode`
--
ALTER TABLE `view_episode`
  ADD CONSTRAINT `FK_F4F70920362B62A0` FOREIGN KEY (`episode_id`) REFERENCES `episode` (`id`),
  ADD CONSTRAINT `FK_F4F70920A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
