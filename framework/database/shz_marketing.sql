-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 23, 2020 at 05:41 PM
-- Server version: 10.1.37-MariaDB
-- PHP Version: 7.2.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `shz_marketing`
--

-- --------------------------------------------------------

--
-- Table structure for table `blog`
--

CREATE TABLE `blog` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(100) NOT NULL,
  `slug` varchar(200) NOT NULL,
  `image` text NOT NULL,
  `abstract` varchar(200) NOT NULL,
  `body` text NOT NULL,
  `category_id` int(11) NOT NULL,
  `created_by` int(10) UNSIGNED NOT NULL,
  `updated_by` int(10) UNSIGNED DEFAULT NULL,
  `keywords` text NOT NULL,
  `view` bigint(20) UNSIGNED NOT NULL,
  `publish` tinyint(1) UNSIGNED NOT NULL DEFAULT '1',
  `created_at` int(11) UNSIGNED NOT NULL,
  `updated_at` int(11) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `blog_categories`
--

CREATE TABLE `blog_categories` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL,
  `publish` tinyint(1) UNSIGNED NOT NULL DEFAULT '1',
  `show_in_side` tinyint(1) UNSIGNED NOT NULL DEFAULT '1',
  `created_at` int(11) UNSIGNED NOT NULL,
  `updated_at` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL,
  `parent_id` int(10) UNSIGNED NOT NULL,
  `icon` varchar(100) NOT NULL,
  `created_at` int(11) UNSIGNED NOT NULL,
  `updated_at` int(11) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

CREATE TABLE `cities` (
  `id` int(10) UNSIGNED NOT NULL,
  `province_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(50) COLLATE utf8_persian_ci NOT NULL,
  `insert_at` int(11) NOT NULL DEFAULT '0',
  `last_update` int(11) NOT NULL DEFAULT '0',
  `delete` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

--
-- Dumping data for table `cities`
--

INSERT INTO `cities` (`id`, `province_id`, `name`, `insert_at`, `last_update`, `delete`) VALUES
(1, 1, 'تبریز', 0, 0, 0),
(2, 1, 'کندوان', 0, 0, 0),
(3, 1, 'بندر شرفخانه', 0, 0, 0),
(4, 1, 'مراغه', 0, 0, 0),
(5, 1, 'میانه', 0, 0, 0),
(6, 1, 'شبستر', 0, 0, 0),
(7, 1, 'مرند', 0, 0, 0),
(8, 1, 'جلفا', 0, 0, 0),
(9, 1, 'سراب', 0, 0, 0),
(10, 1, 'هادیشهر', 0, 0, 0),
(11, 1, 'بناب', 0, 0, 0),
(12, 1, 'کلیبر', 0, 0, 0),
(13, 1, 'تسوج', 0, 0, 0),
(14, 1, 'اهر', 0, 0, 0),
(15, 1, 'هریس', 0, 0, 0),
(16, 1, 'عجبشیر', 0, 0, 0),
(17, 1, 'هشترود', 0, 0, 0),
(18, 1, 'ملکان', 0, 0, 0),
(19, 1, 'بستان آباد', 0, 0, 0),
(20, 1, 'ورزقان', 0, 0, 0),
(21, 1, 'اسکو', 0, 0, 0),
(22, 1, 'آذر شهر', 0, 0, 0),
(23, 1, 'قره آغاج', 0, 0, 0),
(24, 1, 'ممقان', 0, 0, 0),
(25, 1, 'صوفیان', 0, 0, 0),
(26, 1, 'ایلخچی', 0, 0, 0),
(27, 1, 'خسروشهر', 0, 0, 0),
(28, 1, 'باسمنج', 0, 0, 0),
(29, 1, 'سهند', 0, 0, 0),
(30, 2, 'ارومیه', 0, 0, 0),
(31, 2, 'نقده', 0, 0, 0),
(32, 2, 'ماکو', 0, 0, 0),
(33, 2, 'تکاب', 0, 0, 0),
(34, 2, 'خوی', 0, 0, 0),
(35, 2, 'مهاباد', 0, 0, 0),
(36, 2, 'سر دشت', 0, 0, 0),
(37, 2, 'چالدران', 0, 0, 0),
(38, 2, 'بوکان', 0, 0, 0),
(39, 2, 'میاندوآب', 0, 0, 0),
(40, 2, 'سلماس', 0, 0, 0),
(41, 2, 'شاهین دژ', 0, 0, 0),
(42, 2, 'پیرانشهر', 0, 0, 0),
(43, 2, 'سیه چشمه', 0, 0, 0),
(44, 2, 'اشنویه', 0, 0, 0),
(45, 2, 'چایپاره', 0, 0, 0),
(46, 2, 'پلدشت', 0, 0, 0),
(47, 2, 'شوط', 0, 0, 0),
(48, 3, 'اردبیل', 0, 0, 0),
(49, 3, 'سرعین', 0, 0, 0),
(50, 3, 'بیله سوار', 0, 0, 0),
(51, 3, 'پارس آباد', 0, 0, 0),
(52, 3, 'خلخال', 0, 0, 0),
(53, 3, 'مشگین شهر', 0, 0, 0),
(54, 3, 'مغان', 0, 0, 0),
(55, 3, 'نمین', 0, 0, 0),
(56, 3, 'نیر', 0, 0, 0),
(57, 3, 'کوثر', 0, 0, 0),
(58, 3, 'کیوی', 0, 0, 0),
(59, 3, 'گرمی', 0, 0, 0),
(60, 4, 'اصفهان', 0, 0, 0),
(61, 4, 'فریدن', 0, 0, 0),
(62, 4, 'فریدون شهر', 0, 0, 0),
(63, 4, 'فلاورجان', 0, 0, 0),
(64, 4, 'گلپایگان', 0, 0, 0),
(65, 4, 'دهاقان', 0, 0, 0),
(66, 4, 'نطنز', 0, 0, 0),
(67, 4, 'نایین', 0, 0, 0),
(68, 4, 'تیران', 0, 0, 0),
(69, 4, 'کاشان', 0, 0, 0),
(70, 4, 'فولاد شهر', 0, 0, 0),
(71, 4, 'اردستان', 0, 0, 0),
(72, 4, 'سمیرم', 0, 0, 0),
(73, 4, 'درچه', 0, 0, 0),
(74, 4, 'کوهپایه', 0, 0, 0),
(75, 4, 'مبارکه', 0, 0, 0),
(76, 4, 'شهرضا', 0, 0, 0),
(77, 4, 'خمینی شهر', 0, 0, 0),
(78, 4, 'شاهین شهر', 0, 0, 0),
(79, 4, 'نجف آباد', 0, 0, 0),
(80, 4, 'دولت آباد', 0, 0, 0),
(81, 4, 'زرین شهر', 0, 0, 0),
(82, 4, 'آران و بیدگل', 0, 0, 0),
(83, 4, 'باغ بهادران', 0, 0, 0),
(84, 4, 'خوانسار', 0, 0, 0),
(85, 4, 'مهردشت', 0, 0, 0),
(86, 4, 'علویجه', 0, 0, 0),
(87, 4, 'عسگران', 0, 0, 0),
(88, 4, 'نهضت آباد', 0, 0, 0),
(89, 4, 'حاجی آباد', 0, 0, 0),
(90, 4, 'تودشک', 0, 0, 0),
(91, 4, 'ورزنه', 0, 0, 0),
(92, 6, 'ایلام', 0, 0, 0),
(93, 6, 'مهران', 0, 0, 0),
(94, 6, 'دهلران', 0, 0, 0),
(95, 6, 'آبدانان', 0, 0, 0),
(96, 6, 'شیروان چرداول', 0, 0, 0),
(97, 6, 'دره شهر', 0, 0, 0),
(98, 6, 'ایوان', 0, 0, 0),
(99, 6, 'سرابله', 0, 0, 0),
(100, 7, 'بوشهر', 0, 0, 0),
(101, 7, 'تنگستان', 0, 0, 0),
(102, 7, 'دشتستان', 0, 0, 0),
(103, 7, 'دیر', 0, 0, 0),
(104, 7, 'دیلم', 0, 0, 0),
(105, 7, 'کنگان', 0, 0, 0),
(106, 7, 'گناوه', 0, 0, 0),
(107, 7, 'ریشهر', 0, 0, 0),
(108, 7, 'دشتی', 0, 0, 0),
(109, 7, 'خورموج', 0, 0, 0),
(110, 7, 'اهرم', 0, 0, 0),
(111, 7, 'برازجان', 0, 0, 0),
(112, 7, 'خارک', 0, 0, 0),
(113, 7, 'جم', 0, 0, 0),
(114, 7, 'کاکی', 0, 0, 0),
(115, 7, 'عسلویه', 0, 0, 0),
(116, 7, 'بردخون', 0, 0, 0),
(117, 8, 'تهران', 0, 0, 0),
(118, 8, 'ورامین', 0, 0, 0),
(119, 8, 'فیروزکوه', 0, 0, 0),
(120, 8, 'ری', 0, 0, 0),
(121, 8, 'دماوند', 0, 0, 0),
(122, 8, 'اسلامشهر', 0, 0, 0),
(123, 8, 'رودهن', 0, 0, 0),
(124, 8, 'لواسان', 0, 0, 0),
(125, 8, 'بومهن', 0, 0, 0),
(126, 8, 'تجریش', 0, 0, 0),
(127, 8, 'فشم', 0, 0, 0),
(128, 8, 'کهریزک', 0, 0, 0),
(129, 8, 'پاکدشت', 0, 0, 0),
(130, 8, 'چهاردانگه', 0, 0, 0),
(131, 8, 'شریف آباد', 0, 0, 0),
(132, 8, 'قرچک', 0, 0, 0),
(133, 8, 'باقرشهر', 0, 0, 0),
(134, 8, 'شهریار', 0, 0, 0),
(135, 8, 'رباط کریم', 0, 0, 0),
(136, 8, 'قدس', 0, 0, 0),
(137, 8, 'ملارد', 0, 0, 0),
(138, 9, 'شهرکرد', 0, 0, 0),
(139, 9, 'فارسان', 0, 0, 0),
(140, 9, 'بروجن', 0, 0, 0),
(141, 9, 'چلگرد', 0, 0, 0),
(142, 9, 'اردل', 0, 0, 0),
(143, 9, 'لردگان', 0, 0, 0),
(144, 9, 'سامان', 0, 0, 0),
(145, 10, 'قائن', 0, 0, 0),
(146, 10, 'فردوس', 0, 0, 0),
(147, 10, 'بیرجند', 0, 0, 0),
(148, 10, 'نهبندان', 0, 0, 0),
(149, 10, 'سربیشه', 0, 0, 0),
(150, 10, 'طبس مسینا', 0, 0, 0),
(151, 10, 'قهستان', 0, 0, 0),
(152, 10, 'درمیان', 0, 0, 0),
(153, 11, 'مشهد', 0, 0, 0),
(154, 11, 'نیشابور', 0, 0, 0),
(155, 11, 'سبزوار', 0, 0, 0),
(156, 11, 'کاشمر', 0, 0, 0),
(157, 11, 'گناباد', 0, 0, 0),
(158, 11, 'طبس', 0, 0, 0),
(159, 11, 'تربت حیدریه', 0, 0, 0),
(160, 11, 'خواف', 0, 0, 0),
(161, 11, 'تربت جام', 0, 0, 0),
(162, 11, 'تایباد', 0, 0, 0),
(163, 11, 'قوچان', 0, 0, 0),
(164, 11, 'سرخس', 0, 0, 0),
(165, 11, 'بردسکن', 0, 0, 0),
(166, 11, 'فریمان', 0, 0, 0),
(167, 11, 'چناران', 0, 0, 0),
(168, 11, 'درگز', 0, 0, 0),
(169, 11, 'کلات', 0, 0, 0),
(170, 11, 'طرقبه', 0, 0, 0),
(171, 11, 'سر ولایت', 0, 0, 0),
(172, 12, 'بجنورد', 0, 0, 0),
(173, 12, 'اسفراین', 0, 0, 0),
(174, 12, 'جاجرم', 0, 0, 0),
(175, 12, 'شیروان', 0, 0, 0),
(176, 12, 'آشخانه', 0, 0, 0),
(177, 12, 'گرمه', 0, 0, 0),
(178, 12, 'ساروج', 0, 0, 0),
(179, 13, 'اهواز', 0, 0, 0),
(180, 13, 'ایرانشهر', 0, 0, 0),
(181, 13, 'شوش', 0, 0, 0),
(182, 13, 'آبادان', 0, 0, 0),
(183, 13, 'خرمشهر', 0, 0, 0),
(184, 13, 'مسجد سلیمان', 0, 0, 0),
(185, 13, 'ایذه', 0, 0, 0),
(186, 13, 'شوشتر', 0, 0, 0),
(187, 13, 'اندیمشک', 0, 0, 0),
(188, 13, 'سوسنگرد', 0, 0, 0),
(189, 13, 'هویزه', 0, 0, 0),
(190, 13, 'دزفول', 0, 0, 0),
(191, 13, 'شادگان', 0, 0, 0),
(192, 13, 'بندر ماهشهر', 0, 0, 0),
(193, 13, 'بندر امام خمینی', 0, 0, 0),
(194, 13, 'امیدیه', 0, 0, 0),
(195, 13, 'بهبهان', 0, 0, 0),
(196, 13, 'رامهرمز', 0, 0, 0),
(197, 13, 'باغ ملک', 0, 0, 0),
(198, 13, 'هندیجان', 0, 0, 0),
(199, 13, 'لالی', 0, 0, 0),
(200, 13, 'رامشیر', 0, 0, 0),
(201, 13, 'حمیدیه', 0, 0, 0),
(202, 13, 'دغاغله', 0, 0, 0),
(203, 13, 'ملاثانی', 0, 0, 0),
(204, 13, 'شادگان', 0, 0, 0),
(205, 13, 'ویسی', 0, 0, 0),
(206, 14, 'زنجان', 0, 0, 0),
(207, 14, 'ابهر', 0, 0, 0),
(208, 14, 'خدابنده', 0, 0, 0),
(209, 14, 'طارم', 0, 0, 0),
(210, 14, 'ماهنشان', 0, 0, 0),
(211, 14, 'خرمدره', 0, 0, 0),
(212, 14, 'ایجرود', 0, 0, 0),
(213, 14, 'زرین آباد', 0, 0, 0),
(214, 14, 'آب بر', 0, 0, 0),
(215, 14, 'قیدار', 0, 0, 0),
(216, 15, 'سمنان', 0, 0, 0),
(217, 15, 'شاهرود', 0, 0, 0),
(218, 15, 'گرمسار', 0, 0, 0),
(219, 15, 'ایوانکی', 0, 0, 0),
(220, 15, 'دامغان', 0, 0, 0),
(221, 15, 'بسطام', 0, 0, 0),
(222, 16, 'زاهدان', 0, 0, 0),
(223, 16, 'چابهار', 0, 0, 0),
(224, 16, 'خاش', 0, 0, 0),
(225, 16, 'سراوان', 0, 0, 0),
(226, 16, 'زابل', 0, 0, 0),
(227, 16, 'سرباز', 0, 0, 0),
(228, 16, 'نیکشهر', 0, 0, 0),
(229, 16, 'ایرانشهر', 0, 0, 0),
(230, 16, 'راسک', 0, 0, 0),
(231, 16, 'میرجاوه', 0, 0, 0),
(232, 17, 'شیراز', 0, 0, 0),
(233, 17, 'اقلید', 0, 0, 0),
(234, 17, 'داراب', 0, 0, 0),
(235, 17, 'فسا', 0, 0, 0),
(236, 17, 'مرودشت', 0, 0, 0),
(237, 17, 'خرم بید', 0, 0, 0),
(238, 17, 'آباده', 0, 0, 0),
(239, 17, 'کازرون', 0, 0, 0),
(240, 17, 'ممسنی', 0, 0, 0),
(241, 17, 'سپیدان', 0, 0, 0),
(242, 17, 'لار', 0, 0, 0),
(243, 17, 'فیروز آباد', 0, 0, 0),
(244, 17, 'جهرم', 0, 0, 0),
(245, 17, 'نی ریز', 0, 0, 0),
(246, 17, 'استهبان', 0, 0, 0),
(247, 17, 'لامرد', 0, 0, 0),
(248, 17, 'مهر', 0, 0, 0),
(249, 17, 'حاجی آباد', 0, 0, 0),
(250, 17, 'نورآباد', 0, 0, 0),
(251, 17, 'اردکان', 0, 0, 0),
(252, 17, 'صفاشهر', 0, 0, 0),
(253, 17, 'ارسنجان', 0, 0, 0),
(254, 17, 'قیروکارزین', 0, 0, 0),
(255, 17, 'سوریان', 0, 0, 0),
(256, 17, 'فراشبند', 0, 0, 0),
(257, 17, 'سروستان', 0, 0, 0),
(258, 17, 'ارژن', 0, 0, 0),
(259, 17, 'گویم', 0, 0, 0),
(260, 17, 'داریون', 0, 0, 0),
(261, 17, 'زرقان', 0, 0, 0),
(262, 17, 'خان زنیان', 0, 0, 0),
(263, 17, 'کوار', 0, 0, 0),
(264, 17, 'ده بید', 0, 0, 0),
(265, 17, 'باب انار/خفر', 0, 0, 0),
(266, 17, 'بوانات', 0, 0, 0),
(267, 17, 'خرامه', 0, 0, 0),
(268, 17, 'خنج', 0, 0, 0),
(269, 17, 'سیاخ دارنگون', 0, 0, 0),
(270, 18, 'قزوین', 0, 0, 0),
(271, 18, 'تاکستان', 0, 0, 0),
(272, 18, 'آبیک', 0, 0, 0),
(273, 18, 'بوئین زهرا', 0, 0, 0),
(274, 19, 'قم', 0, 0, 0),
(275, 5, 'طالقان', 0, 0, 0),
(276, 5, 'نظرآباد', 0, 0, 0),
(277, 5, 'اشتهارد', 0, 0, 0),
(278, 5, 'هشتگرد', 0, 0, 0),
(279, 5, 'کن', 0, 0, 0),
(280, 5, 'آسارا', 0, 0, 0),
(281, 5, 'شهرک گلستان', 0, 0, 0),
(282, 5, 'اندیشه', 0, 0, 0),
(283, 5, 'کرج', 0, 0, 0),
(284, 5, 'نظر آباد', 0, 0, 0),
(285, 5, 'گوهردشت', 0, 0, 0),
(286, 5, 'ماهدشت', 0, 0, 0),
(287, 5, 'مشکین دشت', 0, 0, 0),
(288, 20, 'سنندج', 0, 0, 0),
(289, 20, 'دیواندره', 0, 0, 0),
(290, 20, 'بانه', 0, 0, 0),
(291, 20, 'بیجار', 0, 0, 0),
(292, 20, 'سقز', 0, 0, 0),
(293, 20, 'کامیاران', 0, 0, 0),
(294, 20, 'قروه', 0, 0, 0),
(295, 20, 'مریوان', 0, 0, 0),
(296, 20, 'صلوات آباد', 0, 0, 0),
(297, 20, 'حسن آباد', 0, 0, 0),
(298, 21, 'کرمان', 0, 0, 0),
(299, 21, 'راور', 0, 0, 0),
(300, 21, 'بابک', 0, 0, 0),
(301, 21, 'انار', 0, 0, 0),
(302, 21, 'کوهبنان', 0, 0, 0),
(303, 21, 'رفسنجان', 0, 0, 0),
(304, 21, 'بافت', 0, 0, 0),
(305, 21, 'سیرجان', 0, 0, 0),
(306, 21, 'کهنوج', 0, 0, 0),
(307, 21, 'زرند', 0, 0, 0),
(308, 21, 'بم', 0, 0, 0),
(309, 21, 'جیرفت', 0, 0, 0),
(310, 21, 'بردسیر', 0, 0, 0),
(311, 22, 'کرمانشاه', 0, 0, 0),
(312, 22, 'اسلام آباد غرب', 0, 0, 0),
(313, 22, 'سر پل ذهاب', 0, 0, 0),
(314, 22, 'کنگاور', 0, 0, 0),
(315, 22, 'سنقر', 0, 0, 0),
(316, 22, 'قصر شیرین', 0, 0, 0),
(317, 22, 'گیلان غرب', 0, 0, 0),
(318, 22, 'هرسین', 0, 0, 0),
(319, 22, 'صحنه', 0, 0, 0),
(320, 22, 'پاوه', 0, 0, 0),
(321, 22, 'جوانرود', 0, 0, 0),
(322, 22, 'شاهو', 0, 0, 0),
(323, 23, 'یاسوج', 0, 0, 0),
(324, 23, 'گچساران', 0, 0, 0),
(325, 23, 'دنا', 0, 0, 0),
(326, 23, 'دوگنبدان', 0, 0, 0),
(327, 23, 'سی سخت', 0, 0, 0),
(328, 23, 'دهدشت', 0, 0, 0),
(329, 23, 'لیکک', 0, 0, 0),
(330, 24, 'گرگان', 0, 0, 0),
(331, 24, 'آق قلا', 0, 0, 0),
(332, 24, 'گنبد کاووس', 0, 0, 0),
(333, 24, 'علی آباد کتول', 0, 0, 0),
(334, 24, 'مینو دشت', 0, 0, 0),
(335, 24, 'ترکمن', 0, 0, 0),
(336, 24, 'کردکوی', 0, 0, 0),
(337, 24, 'بندر گز', 0, 0, 0),
(338, 24, 'کلاله', 0, 0, 0),
(339, 24, 'آزاد شهر', 0, 0, 0),
(340, 24, 'رامیان', 0, 0, 0),
(341, 25, 'رشت', 0, 0, 0),
(342, 25, 'منجیل', 0, 0, 0),
(343, 25, 'لنگرود', 0, 0, 0),
(344, 25, 'رود سر', 0, 0, 0),
(345, 25, 'تالش', 0, 0, 0),
(346, 25, 'آستارا', 0, 0, 0),
(347, 25, 'ماسوله', 0, 0, 0),
(348, 25, 'آستانه اشرفیه', 0, 0, 0),
(349, 25, 'رودبار', 0, 0, 0),
(350, 25, 'فومن', 0, 0, 0),
(351, 25, 'صومعه سرا', 0, 0, 0),
(352, 25, 'بندرانزلی', 0, 0, 0),
(353, 25, 'کلاچای', 0, 0, 0),
(354, 25, 'هشتپر', 0, 0, 0),
(355, 25, 'رضوان شهر', 0, 0, 0),
(356, 25, 'ماسال', 0, 0, 0),
(357, 25, 'شفت', 0, 0, 0),
(358, 25, 'سیاهکل', 0, 0, 0),
(359, 25, 'املش', 0, 0, 0),
(360, 25, 'لاهیجان', 0, 0, 0),
(361, 25, 'خشک بیجار', 0, 0, 0),
(362, 25, 'خمام', 0, 0, 0),
(363, 25, 'لشت نشا', 0, 0, 0),
(364, 25, 'بندر کیاشهر', 0, 0, 0),
(365, 26, 'خرم آباد', 0, 0, 0),
(366, 26, 'ماهشهر', 0, 0, 0),
(367, 26, 'دزفول', 0, 0, 0),
(368, 26, 'بروجرد', 0, 0, 0),
(369, 26, 'دورود', 0, 0, 0),
(370, 26, 'الیگودرز', 0, 0, 0),
(371, 26, 'ازنا', 0, 0, 0),
(372, 26, 'نور آباد', 0, 0, 0),
(373, 26, 'کوهدشت', 0, 0, 0),
(374, 26, 'الشتر', 0, 0, 0),
(375, 26, 'پلدختر', 0, 0, 0),
(376, 27, 'ساری', 0, 0, 0),
(377, 27, 'آمل', 0, 0, 0),
(378, 27, 'بابل', 0, 0, 0),
(379, 27, 'بابلسر', 0, 0, 0),
(380, 27, 'بهشهر', 0, 0, 0),
(381, 27, 'تنکابن', 0, 0, 0),
(382, 27, 'جویبار', 0, 0, 0),
(383, 27, 'چالوس', 0, 0, 0),
(384, 27, 'رامسر', 0, 0, 0),
(385, 27, 'سواد کوه', 0, 0, 0),
(386, 27, 'قائم شهر', 0, 0, 0),
(387, 27, 'نکا', 0, 0, 0),
(388, 27, 'نور', 0, 0, 0),
(389, 27, 'بلده', 0, 0, 0),
(390, 27, 'نوشهر', 0, 0, 0),
(391, 27, 'پل سفید', 0, 0, 0),
(392, 27, 'محمود آباد', 0, 0, 0),
(393, 27, 'فریدون کنار', 0, 0, 0),
(394, 28, 'اراک', 0, 0, 0),
(395, 28, 'آشتیان', 0, 0, 0),
(396, 28, 'تفرش', 0, 0, 0),
(397, 28, 'خمین', 0, 0, 0),
(398, 28, 'دلیجان', 0, 0, 0),
(399, 28, 'ساوه', 0, 0, 0),
(400, 28, 'سربند', 0, 0, 0),
(401, 28, 'محلات', 0, 0, 0),
(402, 28, 'شازند', 0, 0, 0),
(403, 29, 'بندرعباس', 0, 0, 0),
(404, 29, 'قشم', 0, 0, 0),
(405, 29, 'کیش', 0, 0, 0),
(406, 29, 'بندر لنگه', 0, 0, 0),
(407, 29, 'بستک', 0, 0, 0),
(408, 29, 'حاجی آباد', 0, 0, 0),
(409, 29, 'دهبارز', 0, 0, 0),
(410, 29, 'انگهران', 0, 0, 0),
(411, 29, 'میناب', 0, 0, 0),
(412, 29, 'ابوموسی', 0, 0, 0),
(413, 29, 'بندر جاسک', 0, 0, 0),
(414, 29, 'تنب بزرگ', 0, 0, 0),
(415, 29, 'بندر خمیر', 0, 0, 0),
(416, 29, 'پارسیان', 0, 0, 0),
(417, 29, 'قشم', 0, 0, 0),
(418, 30, 'همدان', 0, 0, 0),
(419, 30, 'ملایر', 0, 0, 0),
(420, 30, 'تویسرکان', 0, 0, 0),
(421, 30, 'نهاوند', 0, 0, 0),
(422, 30, 'کبودر اهنگ', 0, 0, 0),
(423, 30, 'رزن', 0, 0, 0),
(424, 30, 'اسدآباد', 0, 0, 0),
(425, 30, 'بهار', 0, 0, 0),
(426, 31, 'یزد', 0, 0, 0),
(427, 31, 'تفت', 0, 0, 0),
(428, 31, 'اردکان', 0, 0, 0),
(429, 31, 'ابرکوه', 0, 0, 0),
(430, 31, 'میبد', 0, 0, 0),
(431, 31, 'طبس', 0, 0, 0),
(432, 31, 'بافق', 0, 0, 0),
(433, 31, 'مهریز', 0, 0, 0),
(434, 31, 'اشکذر', 0, 0, 0),
(435, 31, 'هرات', 0, 0, 0),
(436, 31, 'خضرآباد', 0, 0, 0),
(437, 31, 'شاهدیه', 0, 0, 0),
(438, 31, 'حمیدیه شهر', 0, 0, 0),
(439, 31, 'سید میرزا', 0, 0, 0),
(440, 31, 'زارچ', 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `complaints`
--

CREATE TABLE `complaints` (
  `id` int(10) UNSIGNED NOT NULL,
  `first_name` varchar(30) NOT NULL,
  `last_name` varchar(30) NOT NULL,
  `mobile` varchar(11) NOT NULL,
  `email` varchar(300) NOT NULL,
  `title` varchar(300) NOT NULL,
  `body` text NOT NULL,
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `created_at` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `contact_us`
--

CREATE TABLE `contact_us` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_code` varchar(8) NOT NULL,
  `first_name` varchar(30) NOT NULL,
  `last_name` varchar(30) NOT NULL,
  `mobile` varchar(11) NOT NULL,
  `email` varchar(300) NOT NULL,
  `title` varchar(300) NOT NULL,
  `body` int(11) NOT NULL,
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `created_at` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `faq`
--

CREATE TABLE `faq` (
  `id` int(10) UNSIGNED NOT NULL,
  `question` text NOT NULL,
  `answer` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `gateway_idpay`
--

CREATE TABLE `gateway_idpay` (
  `id` int(11) NOT NULL,
  `factor_code` varchar(20) NOT NULL,
  `payment_code` varchar(20) NOT NULL,
  `payment_id` varchar(300) NOT NULL,
  `payment_link` text NOT NULL,
  `status` tinyint(3) DEFAULT NULL,
  `track_id` varchar(100) NOT NULL,
  `msg` text NOT NULL,
  `mask_card_number` varchar(16) NOT NULL,
  `exportation_type` tinyint(1) UNSIGNED NOT NULL,
  `payment_date` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `gateway_mabna`
--

CREATE TABLE `gateway_mabna` (
  `id` int(11) NOT NULL,
  `factor_code` varchar(20) NOT NULL,
  `payment_code` varchar(20) NOT NULL,
  `payment_id` varchar(300) NOT NULL,
  `payment_link` text NOT NULL,
  `status` tinyint(3) DEFAULT NULL,
  `track_id` varchar(100) NOT NULL,
  `msg` text NOT NULL,
  `mask_card_number` varchar(16) NOT NULL,
  `exportation_type` tinyint(1) UNSIGNED NOT NULL,
  `payment_date` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `gateway_zarinpal`
--

CREATE TABLE `gateway_zarinpal` (
  `authority` varchar(100) NOT NULL,
  `factor_code` varchar(20) NOT NULL,
  `payment_code` varchar(20) NOT NULL,
  `status` tinyint(3) DEFAULT NULL,
  `exportation_type` tinyint(1) UNSIGNED NOT NULL,
  `payment_date` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `icons`
--

CREATE TABLE `icons` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `main_sliders`
--

CREATE TABLE `main_sliders` (
  `id` int(10) UNSIGNED NOT NULL,
  `image` text NOT NULL,
  `link` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(10) UNSIGNED NOT NULL,
  `order_code` varchar(20) NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `first_name` varchar(30) NOT NULL,
  `last_name` varchar(30) NOT NULL,
  `mobile` varchar(11) NOT NULL,
  `receipt_code` varchar(100) NOT NULL,
  `receipt_date` int(11) UNSIGNED NOT NULL,
  `product_type` tinyint(1) UNSIGNED NOT NULL,
  `payment_method` tinyint(1) UNSIGNED NOT NULL,
  `payment_status` tinyint(1) NOT NULL,
  `send_status` int(10) UNSIGNED NOT NULL,
  `amount` varchar(20) NOT NULL,
  `final_price` varchar(20) NOT NULL,
  `shipping_price` varchar(20) NOT NULL,
  `province` varchar(50) NOT NULL,
  `city` varchar(50) NOT NULL,
  `destination_place` varchar(50) NOT NULL,
  `payment_date` int(11) UNSIGNED DEFAULT NULL,
  `shipping_date` int(11) UNSIGNED DEFAULT NULL,
  `order_date` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `order_item`
--

CREATE TABLE `order_item` (
  `id` int(10) UNSIGNED NOT NULL,
  `order_code` varchar(20) NOT NULL,
  `product_id` int(10) UNSIGNED NOT NULL,
  `product_count` int(10) UNSIGNED NOT NULL,
  `product_unit_price` varchar(20) NOT NULL,
  `product_price` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `order_reserved`
--

CREATE TABLE `order_reserved` (
  `id` int(10) UNSIGNED NOT NULL,
  `order_code` varchar(20) NOT NULL,
  `expire_time` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` int(10) UNSIGNED NOT NULL,
  `description` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `description`) VALUES
(1, 'create'),
(2, 'read'),
(3, 'update'),
(4, 'delete');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(90) NOT NULL,
  `image` text NOT NULL,
  `city` varchar(30) NOT NULL,
  `place` varchar(50) NOT NULL,
  `category_id` int(10) UNSIGNED NOT NULL,
  `price` varchar(20) NOT NULL,
  `off` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `off_until` int(11) UNSIGNED NOT NULL,
  `reward` tinyint(3) UNSIGNED NOT NULL,
  `product_type` tinyint(1) UNSIGNED NOT NULL,
  `description` text NOT NULL,
  `properties` text NOT NULL,
  `related` text NOT NULL,
  `stock_count` int(10) UNSIGNED NOT NULL,
  `max_cart_count` int(10) UNSIGNED NOT NULL DEFAULT '100',
  `sold_count` int(10) UNSIGNED NOT NULL,
  `is_special` tinyint(1) UNSIGNED NOT NULL,
  `publish` tinyint(1) UNSIGNED NOT NULL DEFAULT '1',
  `available` tinyint(1) UNSIGNED NOT NULL DEFAULT '1',
  `created_by` int(10) UNSIGNED NOT NULL,
  `updated_by` int(10) UNSIGNED NOT NULL,
  `created_at` int(11) UNSIGNED NOT NULL,
  `updated_at` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `product_gallery`
--

CREATE TABLE `product_gallery` (
  `id` int(10) UNSIGNED NOT NULL,
  `product_id` int(10) UNSIGNED NOT NULL,
  `image` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `provinces`
--

CREATE TABLE `provinces` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(50) COLLATE utf8_persian_ci NOT NULL,
  `insert_at` int(11) NOT NULL DEFAULT '0',
  `last_update` int(11) NOT NULL DEFAULT '0',
  `delete` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

--
-- Dumping data for table `provinces`
--

INSERT INTO `provinces` (`id`, `name`, `insert_at`, `last_update`, `delete`) VALUES
(1, 'آذربایجان شرقی', 0, 0, 0),
(2, 'آذربایجان غربی', 0, 0, 0),
(3, 'اردبیل', 0, 0, 0),
(4, 'اصفهان', 0, 0, 0),
(5, 'البرز', 0, 0, 0),
(6, 'ایلام', 0, 0, 0),
(7, 'بوشهر', 0, 0, 0),
(8, 'تهران', 0, 0, 0),
(9, 'چهارمحال بختیاری', 0, 0, 0),
(10, 'خراسان جنوبی', 0, 0, 0),
(11, 'خراسان رضوی', 0, 0, 0),
(12, 'خراسان شمالی', 0, 0, 0),
(13, 'خوزستان', 0, 0, 0),
(14, 'زنجان', 0, 0, 0),
(15, 'سمنان', 0, 0, 0),
(16, 'سیستان و بلوچستان', 0, 0, 0),
(17, 'فارس', 0, 0, 0),
(18, 'قزوین', 0, 0, 0),
(19, 'قم', 0, 0, 0),
(20, 'کردستان', 0, 0, 0),
(21, 'کرمان', 0, 0, 0),
(22, 'کرمانشاه', 0, 0, 0),
(23, 'کهکیلویه و بویراحمد', 0, 0, 0),
(24, 'گلستان', 0, 0, 0),
(25, 'گیلان', 0, 0, 0),
(26, 'لرستان', 0, 0, 0),
(27, 'مازندران', 0, 0, 0),
(28, 'مرکزی', 0, 0, 0),
(29, 'هرمزگان', 0, 0, 0),
(30, 'همدان', 0, 0, 0),
(31, 'یزد', 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `return_order`
--

CREATE TABLE `return_order` (
  `id` int(10) UNSIGNED NOT NULL,
  `order_code` varchar(20) NOT NULL,
  `description` text NOT NULL,
  `status` tinyint(1) UNSIGNED NOT NULL,
  `created_at` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(20) DEFAULT NULL,
  `description` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `description`) VALUES
(1, 'superUser', NULL),
(2, 'admin', NULL),
(3, 'writer', NULL),
(4, 'marketer', NULL),
(5, 'user', NULL),
(6, 'guest', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `roles_pages_perms`
--

CREATE TABLE `roles_pages_perms` (
  `id` int(10) UNSIGNED NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL,
  `page_id` int(10) UNSIGNED NOT NULL,
  `perm_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `send_status`
--

CREATE TABLE `send_status` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `badge` varchar(100) NOT NULL,
  `priority` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `send_status`
--

INSERT INTO `send_status` (`id`, `name`, `badge`, `priority`) VALUES
(1, 'در صف بررسی', 'bg-slate', 1),
(3, 'خروج از انبار', 'label-info', 4),
(4, 'تحویل به پست', 'bg-purple', 5),
(5, 'تایید نشده', 'label-danger', 2),
(6, 'تحویل به مشتری', 'label-primary', 6),
(7, 'آماده سازی سفارش', 'label-success', 3),
(8, 'لغو شده', 'label-danger', 8),
(9, 'مرجوع شده', 'bg-pink', 7);

-- --------------------------------------------------------

--
-- Table structure for table `static_pages`
--

CREATE TABLE `static_pages` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(100) NOT NULL,
  `body` text NOT NULL,
  `url_name` varchar(50) NOT NULL,
  `created_at` int(11) UNSIGNED NOT NULL,
  `updated_at` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_code` varchar(8) DEFAULT NULL,
  `subset_of` varchar(8) DEFAULT NULL,
  `mobile` varchar(11) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(128) DEFAULT NULL,
  `first_name` varchar(30) DEFAULT NULL,
  `last_name` varchar(30) DEFAULT NULL,
  `n_code` varchar(10) NOT NULL,
  `province` varchar(50) DEFAULT NULL,
  `city` varchar(50) DEFAULT NULL,
  `address` text,
  `postal_code` varchar(10) DEFAULT NULL,
  `image` varchar(100) DEFAULT NULL,
  `credit_card_number` int(11) NOT NULL,
  `father_name` varchar(30) NOT NULL,
  `gender` tinyint(1) UNSIGNED NOT NULL,
  `military_status` tinyint(1) UNSIGNED NOT NULL,
  `birth_certificate_code` varchar(10) NOT NULL,
  `birth_certificate_code_place` varchar(30) NOT NULL,
  `question1` text NOT NULL,
  `question2` text NOT NULL,
  `question3` text NOT NULL,
  `question4` text NOT NULL,
  `question5` text NOT NULL,
  `question6` text NOT NULL,
  `question7` text NOT NULL,
  `description` text NOT NULL,
  `flag_buy` tinyint(3) UNSIGNED NOT NULL,
  `flag_info` tinyint(3) UNSIGNED NOT NULL,
  `active` tinyint(1) DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `activation_code` varchar(255) DEFAULT NULL,
  `activation_code_time` int(11) UNSIGNED NOT NULL,
  `forgotten_password_code` varchar(255) DEFAULT NULL,
  `forgotten_password_time` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `user_code`, `subset_of`, `mobile`, `email`, `password`, `first_name`, `last_name`, `n_code`, `province`, `city`, `address`, `postal_code`, `image`, `credit_card_number`, `father_name`, `gender`, `military_status`, `birth_certificate_code`, `birth_certificate_code_place`, `question1`, `question2`, `question3`, `question4`, `question5`, `question6`, `question7`, `description`, `flag_buy`, `flag_info`, `active`, `ip_address`, `activation_code`, `activation_code_time`, `forgotten_password_code`, `forgotten_password_time`, `created_at`) VALUES
(1, NULL, NULL, '09139518055', 'saeedgerami72@gmail.com', '$2y$10$SJJmXLT3/IlhEi3WBXPB0OBSprsz61BKeioRnPMN62gNQb5ZkIzTq', 'سعید', 'گرامی فر', '4420440392', NULL, NULL, NULL, NULL, 'user-default.png', 0, '', 0, 0, '', '', '', '', '', '', '', '', '', '', 0, 0, 1, '::1', NULL, 0, NULL, NULL, 1584977257);

-- --------------------------------------------------------

--
-- Table structure for table `users_pages_perms`
--

CREATE TABLE `users_pages_perms` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `page_id` int(10) UNSIGNED NOT NULL,
  `perm_id` int(10) UNSIGNED NOT NULL,
  `allow` int(1) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `users_roles`
--

CREATE TABLE `users_roles` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users_roles`
--

INSERT INTO `users_roles` (`id`, `user_id`, `role_id`) VALUES
(1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_accounts`
--

CREATE TABLE `user_accounts` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `account_balance` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `user_account_deposit`
--

CREATE TABLE `user_account_deposit` (
  `id` int(10) UNSIGNED NOT NULL,
  `deposit_code` varchar(20) NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `payer_id` int(10) UNSIGNED DEFAULT NULL,
  `deposit_price` varchar(20) NOT NULL,
  `description` varchar(300) NOT NULL,
  `deposit_type` tinyint(1) UNSIGNED NOT NULL,
  `deposit_date` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `user_bank_accounts`
--

CREATE TABLE `user_bank_accounts` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `bank_name` varchar(100) NOT NULL,
  `bank_branch` varchar(100) NOT NULL,
  `account_number` varchar(100) NOT NULL,
  `card_number` varchar(16) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `blog`
--
ALTER TABLE `blog`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `blog_categories`
--
ALTER TABLE `blog_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cities`
--
ALTER TABLE `cities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `province_id` (`province_id`),
  ADD KEY `name_2` (`name`);

--
-- Indexes for table `complaints`
--
ALTER TABLE `complaints`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact_us`
--
ALTER TABLE `contact_us`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `faq`
--
ALTER TABLE `faq`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gateway_idpay`
--
ALTER TABLE `gateway_idpay`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_idpay_factors` (`factor_code`);

--
-- Indexes for table `gateway_mabna`
--
ALTER TABLE `gateway_mabna`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_mabna_factors` (`factor_code`);

--
-- Indexes for table `gateway_zarinpal`
--
ALTER TABLE `gateway_zarinpal`
  ADD PRIMARY KEY (`authority`),
  ADD KEY `fk_zarinpal_factors` (`factor_code`);

--
-- Indexes for table `icons`
--
ALTER TABLE `icons`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `main_sliders`
--
ALTER TABLE `main_sliders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_item`
--
ALTER TABLE `order_item`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_reserved`
--
ALTER TABLE `order_reserved`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_gallery`
--
ALTER TABLE `product_gallery`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `provinces`
--
ALTER TABLE `provinces`
  ADD PRIMARY KEY (`id`),
  ADD KEY `name_2` (`name`);

--
-- Indexes for table `return_order`
--
ALTER TABLE `return_order`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles_pages_perms`
--
ALTER TABLE `roles_pages_perms`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_rpp_r` (`role_id`),
  ADD KEY `fk_rpp_pa` (`page_id`),
  ADD KEY `fk_rpp_p` (`perm_id`);

--
-- Indexes for table `send_status`
--
ALTER TABLE `send_status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `static_pages`
--
ALTER TABLE `static_pages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users_pages_perms`
--
ALTER TABLE `users_pages_perms`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_upp_u` (`user_id`),
  ADD KEY `fk_upp_pa` (`page_id`),
  ADD KEY `fk_upp_pe` (`perm_id`);

--
-- Indexes for table `users_roles`
--
ALTER TABLE `users_roles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_urp_u` (`user_id`),
  ADD KEY `fk_urp_r` (`role_id`);

--
-- Indexes for table `user_accounts`
--
ALTER TABLE `user_accounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_account_deposit`
--
ALTER TABLE `user_account_deposit`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_bank_accounts`
--
ALTER TABLE `user_bank_accounts`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `blog`
--
ALTER TABLE `blog`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `blog_categories`
--
ALTER TABLE `blog_categories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cities`
--
ALTER TABLE `cities`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=441;

--
-- AUTO_INCREMENT for table `complaints`
--
ALTER TABLE `complaints`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `contact_us`
--
ALTER TABLE `contact_us`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `faq`
--
ALTER TABLE `faq`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gateway_idpay`
--
ALTER TABLE `gateway_idpay`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gateway_mabna`
--
ALTER TABLE `gateway_mabna`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `icons`
--
ALTER TABLE `icons`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `main_sliders`
--
ALTER TABLE `main_sliders`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_item`
--
ALTER TABLE `order_item`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_reserved`
--
ALTER TABLE `order_reserved`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_gallery`
--
ALTER TABLE `product_gallery`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `provinces`
--
ALTER TABLE `provinces`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `return_order`
--
ALTER TABLE `return_order`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `roles_pages_perms`
--
ALTER TABLE `roles_pages_perms`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `send_status`
--
ALTER TABLE `send_status`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `static_pages`
--
ALTER TABLE `static_pages`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users_pages_perms`
--
ALTER TABLE `users_pages_perms`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users_roles`
--
ALTER TABLE `users_roles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user_accounts`
--
ALTER TABLE `user_accounts`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_account_deposit`
--
ALTER TABLE `user_account_deposit`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_bank_accounts`
--
ALTER TABLE `user_bank_accounts`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cities`
--
ALTER TABLE `cities`
  ADD CONSTRAINT `cities_ibfk_1` FOREIGN KEY (`province_id`) REFERENCES `provinces` (`id`);

--
-- Constraints for table `roles_pages_perms`
--
ALTER TABLE `roles_pages_perms`
  ADD CONSTRAINT `fk_rpp_p` FOREIGN KEY (`perm_id`) REFERENCES `permissions` (`id`),
  ADD CONSTRAINT `fk_rpp_pa` FOREIGN KEY (`page_id`) REFERENCES `pages` (`id`),
  ADD CONSTRAINT `fk_rpp_r` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`);

--
-- Constraints for table `users_pages_perms`
--
ALTER TABLE `users_pages_perms`
  ADD CONSTRAINT `fk_upp_pa` FOREIGN KEY (`page_id`) REFERENCES `pages` (`id`),
  ADD CONSTRAINT `fk_upp_pe` FOREIGN KEY (`perm_id`) REFERENCES `permissions` (`id`),
  ADD CONSTRAINT `fk_upp_u` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `users_roles`
--
ALTER TABLE `users_roles`
  ADD CONSTRAINT `fk_urp_r` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`),
  ADD CONSTRAINT `fk_urp_u` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
