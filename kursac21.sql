-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1
-- Время создания: Май 26 2014 г., 15:35
-- Версия сервера: 5.5.25
-- Версия PHP: 5.3.13

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `kursac`
--

-- --------------------------------------------------------

--
-- Структура таблицы `articles`
--

CREATE TABLE IF NOT EXISTS `articles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `text` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Дамп данных таблицы `articles`
--

INSERT INTO `articles` (`id`, `title`, `description`, `text`) VALUES
(1, 'Рецепт капучино', 'Как приготовить капучино', '<img src="/images/titles/capucino.jpg" style="margin: 0px 15px 0px 0px; float: left;">На 2 порции: кофе тонкого помола - 1 ст. ложка, вода - 2½ чашки, холодное молоко 2%-жирности - ½ чашки, тертый шоколад – щепотка, сахар - 2 кусочка (по желанию)\r\nДля получения кофе необходима электрическая эспрессо-машина. Сварить кофе <a href="http://shop.com/index.php?page=articles&art_id=2">эспрессо.</a> Когда он будет готов, направить наконечник кофеварки в сосуд с холодным молоком и взбивать паром молоко в пену в течение минуты. Налить кофе в чашки, сверху положить пену, посыпать тертым шоколадом. Ваше капучино готово.'),
(2, 'Рецепт эспрессо', 'Как приготовить эспрессо', '<img src="/images/titles/espresso.jpg" style="margin: 0px 15px 0px 0px;float: left;">На 2 порции: 2-2,5 чашки воды, 1 столовая ложка кофе эспресс-помола , 2 куска сахара (по желанию), 2 ломтика лимона (по желанию).\r\nДля этого рецепта вам понадобится электрическая эспресс-кофеварка. Налейте 2 чашки воды в резервуар эспресс-кофеварки и завинтите крышку. Насыпьте кофе в кофейный фильтр и со щелчком поставьте на место. Включите кофеварку в сеть. Кофе сварится в течении 2-4 минут. Подавайте его в маленьких чашечках. Сахар и лимон добавляйте по вкусу.');

-- --------------------------------------------------------

--
-- Структура таблицы `category`
--

CREATE TABLE IF NOT EXISTS `category` (
  `cat_id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `podcat_id` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `img` varchar(255) NOT NULL DEFAULT 'kryzka.jpg',
  PRIMARY KEY (`cat_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Дамп данных таблицы `category`
--

INSERT INTO `category` (`cat_id`, `name`, `podcat_id`, `img`) VALUES
(1, 'Чай', 0, 'kryzka.jpg'),
(2, 'Кофе', 0, 'kryzka.jpg'),
(3, 'Черный', 1, 'kryzka.jpg'),
(4, 'Зерновой', 2, 'kryzka.jpg'),
(5, 'Аксессуары', 0, 'kryzka.jpg'),
(6, 'Трава', 0, 'kryzka.jpg'),
(7, 'Зеленый', 1, 'kryzka.jpg');

-- --------------------------------------------------------

--
-- Структура таблицы `customers`
--

CREATE TABLE IF NOT EXISTS `customers` (
  `customer_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `address` varchar(255) NOT NULL,
  `login` varchar(20) NOT NULL,
  `password` varchar(32) NOT NULL,
  PRIMARY KEY (`customer_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Дамп данных таблицы `customers`
--

INSERT INTO `customers` (`customer_id`, `name`, `email`, `phone`, `address`, `login`, `password`) VALUES
(1, 'Олег Безверхий', 'oleg_bezverhii@mail.ru', '79619509213', 'Трудовая, 9', 'Bizonozubr', 'a86f4498d4547ba21bf1aca7bb15f2da'),
(2, 'холодильник2', '12@ga.ru', '2313', 'ул. Трудовая 8, комната 167', '9619509214', 'e10adc3949ba59abbe56e057f20f883e');

-- --------------------------------------------------------

--
-- Структура таблицы `goods`
--

CREATE TABLE IF NOT EXISTS `goods` (
  `goods_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `img` varchar(255) NOT NULL,
  `text` text NOT NULL,
  `price` float NOT NULL DEFAULT '0',
  `visible` enum('0','1') NOT NULL DEFAULT '1',
  `cat_id` tinyint(3) unsigned NOT NULL,
  `inv` varchar(255) NOT NULL,
  PRIMARY KEY (`goods_id`),
  FULLTEXT KEY `ft_key_name` (`name`),
  FULLTEXT KEY `text` (`text`),
  FULLTEXT KEY `name` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Дамп данных таблицы `goods`
--

INSERT INTO `goods` (`goods_id`, `name`, `img`, `text`, `price`, `visible`, `cat_id`, `inv`) VALUES
(1, 'Копи Лувак', '1234.jpg', 'Относится к кофе разряда Speciality Exclusive. Объем производства кофе этой группы крайне ограничен и рассчитан на истинных ценителей. Существованию этого дорогого и редкого вида мир обязан зверьку пальмовая циветта, которая питается свежими ягодами кофейного дерева. Мякоть, окружающая кофейные зерна, переваривается, а непереваренные зерна проходят через пищеварительную систему зверька и претерпевают обработку его энзимами. В результате вкус зерен меняется, после чего зерна тщательно очищаются. Этот сорт обладает редким карамельным оттенком и пахнет шоколадом. Масса Нетто - 125 г', 6287, '1', 3, '1 шт.'),
(2, 'Кофейный кофиек', '2345.jpg', 'Такой кофе, Вася, прям пью не на пьюсь. Пакетик по 100 грамм', 30, '1', 4, '1 шт.'),
(3, 'Кофейный набор', '23453.jpg', 'Кофейный набор для заварки кофе', 200, '1', 5, '1 шт.'),
(4, 'ллала', '1234.jpg', 'выппвапвап', 23, '1', 3, '1 шт.'),
(5, 'Кокаин', '14343.jpeg', '', 1000, '1', 3, '1 гр.');

-- --------------------------------------------------------

--
-- Структура таблицы `news`
--

CREATE TABLE IF NOT EXISTS `news` (
  `news_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `anons` text NOT NULL,
  `text` text NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`news_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Дамп данных таблицы `news`
--

INSERT INTO `news` (`news_id`, `title`, `anons`, `text`, `date`) VALUES
(1, 'Скидки к Первому Мая', '1 мая открывается наше летнее кафе, ждём вас!', '1 мая открывается летнее кафе, ждём вас! В честь праздника и данного события мы делаем скидку 15% всем посетителям нашего кафе. Ждем вас!!! Акция действует с 1 по 4 мая.', '2014-05-01'),
(2, 'С Днем Победы!!!', 'Поздравляем всех с Днём Победы!', 'Поздравляем всех с Днём Победы! В честь этого события всем покупателям скидка 10% на любой товар нашей кофейни, плюс подарок - плитка шоколада.', '2014-05-09');

-- --------------------------------------------------------

--
-- Структура таблицы `orders`
--

CREATE TABLE IF NOT EXISTS `orders` (
  `order_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `customer_id` int(10) unsigned NOT NULL,
  `date` datetime NOT NULL,
  `status` enum('0','1') NOT NULL DEFAULT '0',
  `prim` text NOT NULL,
  PRIMARY KEY (`order_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `recept`
--

CREATE TABLE IF NOT EXISTS `recept` (
  `recept_id` int(10) NOT NULL,
  `title` varchar(255) NOT NULL,
  `text` text NOT NULL,
  `img` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `zakaz_tovar`
--

CREATE TABLE IF NOT EXISTS `zakaz_tovar` (
  `zakaz_tovar_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `orders_id` int(10) unsigned NOT NULL,
  `goods_id` int(10) unsigned NOT NULL,
  `quantity` tinyint(3) unsigned NOT NULL,
  PRIMARY KEY (`zakaz_tovar_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
