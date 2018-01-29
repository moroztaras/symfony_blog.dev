-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Час створення: Січ 29 2018 р., 18:02
-- Версія сервера: 5.7.20-0ubuntu0.16.04.1
-- Версія PHP: 7.1.8-2+ubuntu16.04.1+deb.sury.org+4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База даних: `blog_2017`
--

-- --------------------------------------------------------

--
-- Структура таблиці `blog`
--

CREATE TABLE `blog` (
  `id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `summary` longtext COLLATE utf8_unicode_ci,
  `body` longtext COLLATE utf8_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `views` int(11) NOT NULL,
  `tags` longtext COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп даних таблиці `blog`
--

INSERT INTO `blog` (`id`, `title`, `summary`, `body`, `created`, `slug`, `views`, `tags`) VALUES
(57, 'Перший тестовий пост. Запуск блогу "Блог 2018"', 'Цей блог було створено спеціально для удосконалення поглиблиблених знань на framework Symfony3. \r\n        При розробці архітектури цього проекту, блог було розроблено три інтерфейси: \r\nfront end -інтефейс користува;\r\nback end - програмно-апаратна частина.\r\nАдмін панель створено два вида: custom admin panel; SonataAdmin', 'Цей блог було створено спеціально для удосконалення поглиблиблених знань на framework Symfony3.\r\nПри розробці архітектури цього проекту, блог було розроблено три інтерфейси: \r\nfront end -інтефейс користува;\r\nback end - програмно-апаратна частина.\r\nАдмін панель створено два вида: custom admin panel; SonataAdmin', '2018-01-20 12:32:20', 'pershyy-testovyy-post-apusk-blohu-bloh-2018', 8, 'блог 2018, перша стаття, запуск блога, тестовий пост');

-- --------------------------------------------------------

--
-- Структура таблиці `comment`
--

CREATE TABLE `comment` (
  `id` int(11) NOT NULL,
  `blog_id` int(11) DEFAULT NULL,
  `user` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `comment` longtext COLLATE utf8_unicode_ci NOT NULL,
  `approved` tinyint(1) NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп даних таблиці `comment`
--

INSERT INTO `comment` (`id`, `blog_id`, `user`, `comment`, `approved`, `created`, `updated`) VALUES
(2, 57, 'Мороз Тарас', 'Тестовий коментарія для поста!', 1, '2018-01-29 17:58:59', '2018-01-29 17:58:59');

-- --------------------------------------------------------

--
-- Структура таблиці `file`
--

CREATE TABLE `file` (
  `id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `file_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `file_size` int(11) NOT NULL,
  `file_mime` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` smallint(6) NOT NULL,
  `created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблиці `fos_user`
--

CREATE TABLE `fos_user` (
  `id` int(11) NOT NULL,
  `username` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
  `username_canonical` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
  `email_canonical` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
  `enabled` tinyint(1) NOT NULL,
  `salt` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `confirmation_token` varchar(180) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password_requested_at` datetime DEFAULT NULL,
  `roles` longtext COLLATE utf8_unicode_ci NOT NULL COMMENT '(DC2Type:array)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблиці `message`
--

CREATE TABLE `message` (
  `id` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `message` longtext COLLATE utf8_unicode_ci NOT NULL,
  `created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблиці `migration_versions`
--

CREATE TABLE `migration_versions` (
  `version` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп даних таблиці `migration_versions`
--

INSERT INTO `migration_versions` (`version`) VALUES
('20171004163255'),
('20171004173546'),
('20171005184814'),
('20171005190018'),
('20171009103846'),
('20171202204836'),
('20171219210536'),
('20171229220133'),
('20180104203606'),
('20180104203945'),
('20180104204302'),
('20180104212849'),
('20180110204059'),
('20180115193008'),
('20180116091042'),
('20180116091910');

-- --------------------------------------------------------

--
-- Структура таблиці `role`
--

CREATE TABLE `role` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп даних таблиці `role`
--

INSERT INTO `role` (`id`, `name`, `role`) VALUES
(6, 'ROLE USER', 'ROLE_USER'),
(7, 'ROLE ADMIN', 'ROLE_ADMIN');

-- --------------------------------------------------------

--
-- Структура таблиці `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(40) NOT NULL,
  `salt` varchar(255) NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  `status` smallint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп даних таблиці `user`
--

INSERT INTO `user` (`id`, `username`, `email`, `password`, `salt`, `created`, `updated`, `status`) VALUES
(9, '84ea4d5c9880ddda2d4f83ccbdd9dccd', 'moroztaras@i.ua', '8a10dd973c3a48af45e53f4619c378948e947c59', '5dd912276ada1ac2c1f47f76bc5e6f09', '2018-01-20 12:39:21', '2018-01-20 12:39:21', 1),
(10, '804e326c290cbf993d7eabb6f303c591', 'test@i.ua', '5b803151febf12c6df1bc4ba125a3c556fb8c0ae', '3df6468a46520e7c106c0a32e98c9cae', '2018-01-22 15:52:53', '2018-01-22 15:52:53', 1),
(11, '50e796ee1a6c2c6bda627de062311e25', 'test2@i.ua', 'c47f611696b9809ddec27d7695895fb52c935c54', 'ae39be5ece619b47cbb79d95dfab61ac', '2018-01-22 16:46:16', '2018-01-22 16:46:16', 1),
(12, '43622e6725b9c671d32c338d86eb787f', 'test3@i.ua', '09617db90d768637cc7801cfad2c789402064845', '4f780b388aba4158a4e5c0342b05f77b', '2018-01-22 16:51:09', '2018-01-22 16:51:09', 1),
(14, '70252332940c21921dff191d4a0238c5', 'test5@i.ua', '05328a643e76d45cf386603fc4c0686952ccad2f', '216bbe9fa6276fc6b601e361a8b7de44', '2018-01-22 16:56:05', '2018-01-22 16:56:05', 1),
(15, 'a018f4f9ca730cdf13fab7996b25a251', 'test7@i.ua', 'b20c29b1cbb519cb1d8c02d7c9fd7340229a8d2a', 'b0ef79c2051f1c92f9cb1fb3fa1856dc', '2018-01-22 16:59:21', '2018-01-22 16:59:21', 1),
(16, '4babd227da7aa8836ef46e0218f4dc61', 'mt@i.ua', 'ef882dedbafbb121f47cd6b21a8d6241aeea8ca0', '6ea3586b22ddacf3d7747abc45486d03', '2018-01-22 17:04:57', '2018-01-22 17:04:57', 1),
(17, 'b1b81c67865342c849f4f884cdd7857a', 'test10@i.ua', 'a2dfffe1dc087402a3b437bb7fa14256c56ae5d9', 'f2464257527f8438cbe53dabc0f34bde', '2018-01-22 17:08:57', '2018-01-22 17:08:57', 1),
(19, 'd840904866e7e5685345c8115eb72239', 'test111@i.ua', '4680ce17169c0521594d60c24bc74d0c8334011c', '082156dcc3f3c3fe078cc871913f5628', '2018-01-22 17:10:55', '2018-01-22 17:10:55', 1),
(20, '4c421dc21782a3ff1d0eb7cea363d41c', 'test8@i.ua', '739ec8a22851ad31d04d06aae56fca3f4ab2ff0f', '9e72cd3e5a82f70efe4f50df7c393f42', '2018-01-22 17:57:37', '2018-01-22 17:57:37', 1);

-- --------------------------------------------------------

--
-- Структура таблиці `users_roles`
--

CREATE TABLE `users_roles` (
  `user_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп даних таблиці `users_roles`
--

INSERT INTO `users_roles` (`user_id`, `role_id`) VALUES
(9, 7);

-- --------------------------------------------------------

--
-- Структура таблиці `user_account`
--

CREATE TABLE `user_account` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `birthday` datetime NOT NULL,
  `region` varchar(255) NOT NULL,
  `token_recover` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп даних таблиці `user_account`
--

INSERT INTO `user_account` (`id`, `user_id`, `first_name`, `last_name`, `birthday`, `region`, `token_recover`) VALUES
(6, 9, 'Тарас', 'Мороз', '1986-07-15 00:00:00', 'UA', 'null'),
(15, 20, 'Тест11', 'Тест11', '1898-01-01 00:00:00', 'AF', NULL);

--
-- Індекси збережених таблиць
--

--
-- Індекси таблиці `blog`
--
ALTER TABLE `blog`
  ADD PRIMARY KEY (`id`);

--
-- Індекси таблиці `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_9474526CDAE07E97` (`blog_id`);

--
-- Індекси таблиці `file`
--
ALTER TABLE `file`
  ADD PRIMARY KEY (`id`);

--
-- Індекси таблиці `fos_user`
--
ALTER TABLE `fos_user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_957A647992FC23A8` (`username_canonical`),
  ADD UNIQUE KEY `UNIQ_957A6479A0D96FBF` (`email_canonical`),
  ADD UNIQUE KEY `UNIQ_957A6479C05FB297` (`confirmation_token`);

--
-- Індекси таблиці `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`id`);

--
-- Індекси таблиці `migration_versions`
--
ALTER TABLE `migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Індекси таблиці `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_57698A6A57698A6A` (`role`);

--
-- Індекси таблиці `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_8D93D649F85E0677` (`username`),
  ADD UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`);

--
-- Індекси таблиці `users_roles`
--
ALTER TABLE `users_roles`
  ADD PRIMARY KEY (`user_id`,`role_id`),
  ADD KEY `IDX_51498A8EA76ED395` (`user_id`),
  ADD KEY `IDX_51498A8ED60322AC` (`role_id`);

--
-- Індекси таблиці `user_account`
--
ALTER TABLE `user_account`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_253B48AEA76ED395` (`user_id`);

--
-- AUTO_INCREMENT для збережених таблиць
--

--
-- AUTO_INCREMENT для таблиці `blog`
--
ALTER TABLE `blog`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;
--
-- AUTO_INCREMENT для таблиці `comment`
--
ALTER TABLE `comment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT для таблиці `file`
--
ALTER TABLE `file`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблиці `fos_user`
--
ALTER TABLE `fos_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблиці `message`
--
ALTER TABLE `message`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблиці `role`
--
ALTER TABLE `role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT для таблиці `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT для таблиці `user_account`
--
ALTER TABLE `user_account`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- Обмеження зовнішнього ключа збережених таблиць
--

--
-- Обмеження зовнішнього ключа таблиці `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `FK_9474526CDAE07E97` FOREIGN KEY (`blog_id`) REFERENCES `blog` (`id`) ON DELETE SET NULL;

--
-- Обмеження зовнішнього ключа таблиці `users_roles`
--
ALTER TABLE `users_roles`
  ADD CONSTRAINT `FK_51498A8EA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_51498A8ED60322AC` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`) ON DELETE CASCADE;

--
-- Обмеження зовнішнього ключа таблиці `user_account`
--
ALTER TABLE `user_account`
  ADD CONSTRAINT `FK_253B48AEA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
