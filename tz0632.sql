-- phpMyAdmin SQL Dump
-- version 4.1.8
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: 2015-08-13 17:53:06
-- 服务器版本： 5.6.21-log
-- PHP Version: 5.5.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `tz0632`
--

-- --------------------------------------------------------

--
-- 表的结构 `ad_pic`
--

CREATE TABLE IF NOT EXISTS `ad_pic` (
  `id` tinyint(2) unsigned NOT NULL AUTO_INCREMENT,
  `url` varchar(255) DEFAULT NULL,
  `path` varchar(255) DEFAULT NULL,
  `end_time` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- 转存表中的数据 `ad_pic`
--

INSERT INTO `ad_pic` (`id`, `url`, `path`, `end_time`) VALUES
(1, 'http://tzuuu.com/', NULL, NULL),
(2, 'http://tzuuu.com/', NULL, NULL),
(3, 'http://tzuuu.com/', NULL, NULL),
(4, 'http://tzuuu.com/', '', NULL),
(5, 'http://tzuuu.com/', '', NULL),
(6, 'http://tzuuu.com/', '', NULL);

-- --------------------------------------------------------

--
-- 表的结构 `infos`
--

CREATE TABLE IF NOT EXISTS `infos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content` varchar(180) NOT NULL,
  `pic` varchar(180) DEFAULT NULL,
  `labels` varchar(255) DEFAULT NULL,
  `create_time` int(10) unsigned DEFAULT NULL,
  `end_time` int(10) unsigned DEFAULT NULL,
  `recommend` tinyint(2) unsigned DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- 转存表中的数据 `infos`
--

INSERT INTO `infos` (`id`, `content`, `pic`, `labels`, `create_time`, `end_time`, `recommend`) VALUES
(3, '买女士打底系列联系qq370631365厂家一手货源，批发零售，春秋新款夏装上市', '/uploads/2015/03/a26ade504387f82abea96c09119207e5.jpg', '31,28', 1425243206, 1427918903, 1),
(4, '优惠房源，幸福城小区，105平方三居室，两厅，一楼超低价位销售，16万，欲购从速！电话：13062068234', '', '18,19', 1425370008, 1428081045, 1),
(5, '幸福街级索新城嘉苑东门与韩庄社区交接处商业房超低价销售，88平方，25万元。联系电话：13062068234', '', '18,19', 1425370201, 1428081049, 1),
(6, '大量要A B C证，有驾驶证快到期的抓紧卖了，现金结账，电话18363251991   13563283129   QQ群 131129929', '', '1', 1425388084, 1456924084, 0),
(7, '在家闲着带孩子都可以加入我们团队只要一部手机一个微机一个微信号，可以让你月入几千，做微商卖印度神油需要加微信 15269776982', '', '16,31,30', 1425388577, 1426598177, 0),
(8, '全国诚招代理，各位亲都可以来做的，宝妈们在家看孩子，也可以月收入几千，微商很简单只要你有一部手机，一个微信号，一个陌陌号，了解产品加微信:haoyi110226', '', '31', 1425474723, 1426684323, 0);

-- --------------------------------------------------------

--
-- 表的结构 `labels`
--

CREATE TABLE IF NOT EXISTS `labels` (
  `lid` mediumint(5) unsigned NOT NULL AUTO_INCREMENT,
  `lname` varchar(10) NOT NULL,
  `hot` int(10) unsigned DEFAULT '0',
  `type` tinyint(2) unsigned DEFAULT '2' COMMENT '1:地区  2:分类',
  PRIMARY KEY (`lid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=32 ;

--
-- 转存表中的数据 `labels`
--

INSERT INTO `labels` (`lid`, `lname`, `hot`, `type`) VALUES
(1, '市区', 0, 1),
(2, '界河', 0, 1),
(3, '滨湖', 0, 1),
(4, '大坞', 0, 1),
(5, '龙阳', 0, 1),
(6, '东郭', 0, 1),
(7, '姜屯', 0, 1),
(8, '东沙河', 0, 1),
(9, '南沙河', 0, 1),
(10, '洪绪', 0, 1),
(11, '西港', 0, 1),
(12, '鲍沟', 0, 1),
(13, '木石', 0, 1),
(14, '羊庄', 0, 1),
(15, '官桥', 0, 1),
(16, '张旺', 0, 1),
(17, '柴胡店', 0, 1),
(18, '级索', 0, 1),
(19, '住房', 0, 2),
(20, '工作', 0, 2),
(21, '服务', 0, 2),
(22, '全新', 0, 2),
(23, '二手', 0, 2),
(24, '婚恋', 0, 2),
(25, '交友', 0, 2),
(26, '车辆', 0, 2),
(27, '求购', 0, 2),
(28, '出售', 0, 2),
(29, '宠物', 0, 2),
(30, '公告', 0, 2),
(31, '不限', 0, 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
