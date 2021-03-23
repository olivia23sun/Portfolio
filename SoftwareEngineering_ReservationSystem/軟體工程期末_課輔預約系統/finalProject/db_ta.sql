-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- 主機： 127.0.0.1
-- 產生時間： 
-- 伺服器版本： 10.1.38-MariaDB
-- PHP 版本： 7.3.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 資料庫： `db_ta`
--
CREATE DATABASE IF NOT EXISTS `db_ta` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `db_ta`;

-- --------------------------------------------------------

--
-- 資料表結構 `course`
--

CREATE TABLE `course` (
  `cname` varchar(50) NOT NULL,
  `taname1` varchar(50) NOT NULL,
  `taname2` varchar(50) DEFAULT NULL,
  `professor` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 傾印資料表的資料 `course`
--

INSERT INTO `course` (`cname`, `taname1`, `taname2`, `professor`) VALUES
('108-1YAYA', '123', '', '林義凱'),
('108-1圖形理論', '嘿嘿嘿', '', '王朱福'),
('108-1大數據分析', '孫浩倫', '', 'YYYY'),
('108-1深度學習', '孫浩倫', NULL, '林義凱'),
('108-1物件導向程式設計', 'A', 'A', 'A'),
('108-1程式設計', '孫芷榆', NULL, '林義凱'),
('108-1資料結構', '孫浩倫', '', 'AAAA'),
('108-2test', '孫芷榆', '', '?'),
('108-2try', '孫浩倫', '', 'XXX'),
('108-2國防', '孫浩倫', 'A', '孫浩倫'),
('108-2機器學習', '孫浩倫', '', '?'),
('108-2深度學習', '孫浩倫', '孫浩倫', '林義凱'),
('108-2網頁設計', '孫浩倫', '', 'XXXX'),
('108-2英文', '孫浩倫', '', '孫浩倫');

-- --------------------------------------------------------

--
-- 資料表結構 `courseinfo`
--

CREATE TABLE `courseinfo` (
  `no` int(50) NOT NULL,
  `cname` varchar(50) NOT NULL,
  `TAID` varchar(50) NOT NULL,
  `time` datetime NOT NULL,
  `place` varchar(50) NOT NULL,
  `amount` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 傾印資料表的資料 `courseinfo`
--

INSERT INTO `courseinfo` (`no`, `cname`, `TAID`, `time`, `place`, `amount`) VALUES
(13, '108-1大數據分析', 'TACBE105004', '2020-01-08 13:00:00', '五育樓電A', 3),
(14, '108-1大數據分析', 'TACBE105004', '2020-01-24 14:00:00', '五育樓電C', 3),
(15, '108-1深度學習', 'TACBE105004', '2020-01-08 19:00:00', '五育樓電A', 2),
(16, '108-1資料結構', 'TACBE105004', '2020-01-09 10:00:00', '專題討論室', 1),
(17, '108-2深度學習', 'TACBE105004', '2020-01-10 21:00:00', '五育樓電A', 1),
(18, '108-2英文', 'TACBE105004', '2020-01-10 03:00:00', '五203', 0),
(19, '108-1程式設計', 'TACBE105044', '2020-01-29 19:00:00', '五育樓電A', 0),
(20, '108-1程式設計', 'TACBE105044', '2020-01-15 19:00:00', '五育樓電A', 2),
(21, '108-2test', 'TACBE105044', '2020-01-11 16:00:00', '五視聽4', 2);

-- --------------------------------------------------------

--
-- 資料表結構 `seats`
--

CREATE TABLE `seats` (
  `no` int(11) NOT NULL,
  `ID` varchar(50) NOT NULL,
  `cname` varchar(50) NOT NULL,
  `time` datetime NOT NULL,
  `place` varchar(50) NOT NULL,
  `valid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 傾印資料表的資料 `seats`
--

INSERT INTO `seats` (`no`, `ID`, `cname`, `time`, `place`, `valid`) VALUES
(1, 'CBE105100', '108-2test', '2020-01-11 16:00:00', '五視聽4', 0),
(2, 'CBE105100', '108-1大數據分析', '2020-01-08 13:00:00', '五育樓電A', 1),
(3, 'CBE105100', '108-1大數據分析', '2020-01-24 14:00:00', '五育樓電C', 1),
(4, 'CBE105100', '108-1深度學習', '2020-01-08 19:00:00', '五育樓電A', 1),
(5, 'CBE105100', '108-1資料結構', '2020-01-09 10:00:00', '專題討論室', 1),
(6, 'CBE105100', '108-1程式設計', '2020-01-15 19:00:00', '五育樓電A', 1),
(7, 'CBE123456', '108-1大數據分析', '2020-01-08 13:00:00', '五育樓電A', 1),
(8, 'CBE123456', '108-2test', '2020-01-11 16:00:00', '五視聽4', 1),
(9, 'CBE123456', '108-1大數據分析', '2020-01-24 14:00:00', '五育樓電C', 1),
(10, 'CBE123456', '108-2深度學習', '2020-01-10 21:00:00', '五育樓電A', 1),
(11, 'CBE123456', '108-1程式設計', '2020-01-15 19:00:00', '五育樓電A', 1),
(12, 'CBE105000', '108-1深度學習', '2020-01-08 19:00:00', '五育樓電A', 1),
(13, 'CBE105000', '108-2test', '2020-01-11 16:00:00', '五視聽4', 1),
(14, 'CBE105000', '108-2深度學習', '2020-01-10 21:00:00', '五育樓電A', 0),
(15, 'CBE105000', '108-1大數據分析', '2020-01-08 13:00:00', '五育樓電A', 1),
(16, 'CBE105000', '108-1大數據分析', '2020-01-24 14:00:00', '五育樓電C', 1);

-- --------------------------------------------------------

--
-- 資料表結構 `student`
--

CREATE TABLE `student` (
  `ID` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `classno` varchar(50) NOT NULL,
  `phone` int(32) NOT NULL,
  `email` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 傾印資料表的資料 `student`
--

INSERT INTO `student` (`ID`, `password`, `name`, `classno`, `phone`, `email`) VALUES
('CBE105000', 'CBE105000', 'test', 'test', 912345678, 'test@test.com'),
('CBE105100', 'CBE105100', '哈哈哈', '資科四甲', 912365487, 'haha@gmail.com'),
('CBE105123', 'A123456789', '孫帥哥', '資科四甲', 2147483647, 'zxc@gmail.com'),
('CBE105999', 'CBE105999', 'TRYTRY', '資科0甲', 912365478, 'TRY@g.com'),
('CBE123456', 'A', 'A', 'A', 123456, 'A'),
('cei105039', '0966083603', '林瘦鳥', '應化四甲', 966083603, '5656546546');

-- --------------------------------------------------------

--
-- 資料表結構 `teacher`
--

CREATE TABLE `teacher` (
  `ID` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `classno` varchar(50) NOT NULL,
  `phone` int(11) NOT NULL,
  `email` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 傾印資料表的資料 `teacher`
--

INSERT INTO `teacher` (`ID`, `password`, `name`, `classno`, `phone`, `email`) VALUES
('TACBE105004', 'NPTU', '孫浩倫', '資科四甲', 912345678, 'handsome@yahoo.com.tw'),
('TACBE105044', 'smile', '孫芷榆', '資科四甲', 912345678, 'smile@gmail.com');

--
-- 已傾印資料表的索引
--

--
-- 資料表索引 `course`
--
ALTER TABLE `course`
  ADD PRIMARY KEY (`cname`);

--
-- 資料表索引 `courseinfo`
--
ALTER TABLE `courseinfo`
  ADD PRIMARY KEY (`no`);

--
-- 資料表索引 `seats`
--
ALTER TABLE `seats`
  ADD PRIMARY KEY (`no`);

--
-- 資料表索引 `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`ID`);

--
-- 資料表索引 `teacher`
--
ALTER TABLE `teacher`
  ADD PRIMARY KEY (`ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
