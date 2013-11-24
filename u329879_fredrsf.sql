-- phpMyAdmin SQL Dump
-- version 
-- http://www.phpmyadmin.net
--
-- Хост: u329879.mysql.masterhost.ru
-- Время создания: Ноя 24 2013 г., 16:41
-- Версия сервера: 5.5.28
-- Версия PHP: 5.3.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `u329879_fredrsf`
--

-- --------------------------------------------------------

--
-- Структура таблицы `AuthAssignment`
--

CREATE TABLE IF NOT EXISTS `AuthAssignment` (
  `itemname` varchar(64) NOT NULL,
  `userid` varchar(64) NOT NULL,
  `bizrule` text,
  `data` text,
  PRIMARY KEY (`itemname`,`userid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `AuthAssignment`
--

INSERT INTO `AuthAssignment` (`itemname`, `userid`, `bizrule`, `data`) VALUES
('admin', '1', NULL, 'N;'),
('partner', '2', NULL, 'N;'),
('partner', '3', NULL, 'N;'),
('partner', '4', NULL, 'N;');

-- --------------------------------------------------------

--
-- Структура таблицы `AuthItem`
--

CREATE TABLE IF NOT EXISTS `AuthItem` (
  `name` varchar(64) NOT NULL,
  `type` int(11) NOT NULL,
  `description` text,
  `bizrule` text,
  `data` text,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `AuthItem`
--

INSERT INTO `AuthItem` (`name`, `type`, `description`, `bizrule`, `data`) VALUES
('admin', 2, 'Администратор', NULL, 'N;'),
('partner', 2, 'Партнер', NULL, 'N;'),
('readOwnStatistics', 1, 'Может видеть только свою статистику', 'return Yii::app()->user->id==$model->user_id;', 'N;'),
('readStatistics', 0, '', NULL, 'N;');

-- --------------------------------------------------------

--
-- Структура таблицы `AuthItemChild`
--

CREATE TABLE IF NOT EXISTS `AuthItemChild` (
  `parent` varchar(64) NOT NULL,
  `child` varchar(64) NOT NULL,
  PRIMARY KEY (`parent`,`child`),
  KEY `child` (`child`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `AuthItemChild`
--

INSERT INTO `AuthItemChild` (`parent`, `child`) VALUES
('partner', 'readOwnStatistics'),
('admin', 'readStatistics'),
('readOwnStatistics', 'readStatistics');

-- --------------------------------------------------------

--
-- Структура таблицы `statistics`
--

CREATE TABLE IF NOT EXISTS `statistics` (
  `statistics_id` int(11) NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `status_id` int(11) NOT NULL,
  `partner_id` int(11) NOT NULL,
  PRIMARY KEY (`statistics_id`),
  KEY `status_id` (`status_id`),
  KEY `partner_id` (`partner_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=22 ;

--
-- Дамп данных таблицы `statistics`
--

INSERT INTO `statistics` (`statistics_id`, `date`, `status_id`, `partner_id`) VALUES
(1, '2013-11-23', 1, 2),
(2, '2013-11-23', 2, 2),
(3, '2013-11-23', 2, 2),
(4, '2013-11-23', 3, 3),
(5, '2013-11-23', 3, 3),
(6, '2013-11-23', 3, 4),
(7, '2013-11-23', 1, 3),
(8, '2013-11-23', 3, 4),
(9, '2013-11-23', 2, 3),
(10, '2013-11-24', 1, 3),
(11, '2013-11-24', 2, 3),
(12, '2013-11-24', 3, 2),
(13, '2013-11-24', 2, 3),
(14, '2013-11-24', 3, 4),
(15, '2013-11-24', 1, 4),
(16, '2013-11-24', 2, 4),
(17, '2013-11-24', 2, 4),
(18, '2013-11-24', 2, 4),
(19, '2013-11-24', 3, 3),
(20, '2013-11-24', 3, 3),
(21, '2013-11-24', 3, 3);

-- --------------------------------------------------------

--
-- Структура таблицы `status`
--

CREATE TABLE IF NOT EXISTS `status` (
  `status_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`status_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Дамп данных таблицы `status`
--

INSERT INTO `status` (`status_id`, `name`) VALUES
(1, 'Уникальный'),
(2, 'Зачтенный'),
(3, 'Незачтенный');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `referral` varchar(255) NOT NULL,
  `is_active` enum('0','1') NOT NULL DEFAULT '1',
  PRIMARY KEY (`user_id`),
  KEY `referral` (`referral`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`user_id`, `login`, `password`, `referral`, `is_active`) VALUES
(1, 'admin', '$1$FsqJXFg6$wfPRSYrdCFQTGIitxS.UK0', '21232f297a57a5a743894a0e4a801fc3', '1'),
(2, 'dsk', '$1$egTVcTth$cnTF4TxuMmV87aEDS5G3E0', '6398a5d89dcecbbcb7ae7e1a7f5bf809', '1'),
(3, 'pik', '$1$uFdNjAPC$U0rkUxZRlgZ/cjI.R6bYe1', 'dd0541a25a51efc0399fb4fefe396d18', '1'),
(4, 'gvsu', '$1$T4FW2yNG$U6AeX5w4odAQvvpGRONt/1', '3dd767c72a819558071fc86decd68c9d', '1');

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `AuthAssignment`
--
ALTER TABLE `AuthAssignment`
  ADD CONSTRAINT `AuthAssignment_ibfk_1` FOREIGN KEY (`itemname`) REFERENCES `AuthItem` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `AuthItemChild`
--
ALTER TABLE `AuthItemChild`
  ADD CONSTRAINT `AuthItemChild_ibfk_2` FOREIGN KEY (`child`) REFERENCES `AuthItem` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `AuthItemChild_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `AuthItem` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `statistics`
--
ALTER TABLE `statistics`
  ADD CONSTRAINT `statistics_ibfk_1` FOREIGN KEY (`status_id`) REFERENCES `status` (`status_id`),
  ADD CONSTRAINT `statistics_ibfk_2` FOREIGN KEY (`partner_id`) REFERENCES `users` (`user_id`);
