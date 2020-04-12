-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 11, 2020 at 11:46 PM
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
  `category_id` int(10) UNSIGNED NOT NULL,
  `keywords` text NOT NULL,
  `view_count` bigint(20) UNSIGNED NOT NULL,
  `publish` tinyint(1) UNSIGNED NOT NULL DEFAULT '1',
  `created_by` int(10) UNSIGNED NOT NULL,
  `updated_by` int(10) UNSIGNED DEFAULT NULL,
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
  `slug` varchar(300) NOT NULL,
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
  `slug` varchar(300) NOT NULL,
  `parent_id` int(10) UNSIGNED NOT NULL,
  `image` text NOT NULL,
  `icon` varchar(100) NOT NULL,
  `publish` tinyint(1) UNSIGNED NOT NULL DEFAULT '1',
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
  `delete` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

--
-- Dumping data for table `cities`
--

INSERT INTO `cities` (`id`, `province_id`, `name`, `delete`) VALUES
(1, 1, 'تبریز', 0),
(2, 1, 'کندوان', 0),
(3, 1, 'بندر شرفخانه', 0),
(4, 1, 'مراغه', 0),
(5, 1, 'میانه', 0),
(6, 1, 'شبستر', 0),
(7, 1, 'مرند', 0),
(8, 1, 'جلفا', 0),
(9, 1, 'سراب', 0),
(10, 1, 'هادیشهر', 0),
(11, 1, 'بناب', 0),
(12, 1, 'کلیبر', 0),
(13, 1, 'تسوج', 0),
(14, 1, 'اهر', 0),
(15, 1, 'هریس', 0),
(16, 1, 'عجبشیر', 0),
(17, 1, 'هشترود', 0),
(18, 1, 'ملکان', 0),
(19, 1, 'بستان آباد', 0),
(20, 1, 'ورزقان', 0),
(21, 1, 'اسکو', 0),
(22, 1, 'آذر شهر', 0),
(23, 1, 'قره آغاج', 0),
(24, 1, 'ممقان', 0),
(25, 1, 'صوفیان', 0),
(26, 1, 'ایلخچی', 0),
(27, 1, 'خسروشهر', 0),
(28, 1, 'باسمنج', 0),
(29, 1, 'سهند', 0),
(30, 2, 'ارومیه', 0),
(31, 2, 'نقده', 0),
(32, 2, 'ماکو', 0),
(33, 2, 'تکاب', 0),
(34, 2, 'خوی', 0),
(35, 2, 'مهاباد', 0),
(36, 2, 'سر دشت', 0),
(37, 2, 'چالدران', 0),
(38, 2, 'بوکان', 0),
(39, 2, 'میاندوآب', 0),
(40, 2, 'سلماس', 0),
(41, 2, 'شاهین دژ', 0),
(42, 2, 'پیرانشهر', 0),
(43, 2, 'سیه چشمه', 0),
(44, 2, 'اشنویه', 0),
(45, 2, 'چایپاره', 0),
(46, 2, 'پلدشت', 0),
(47, 2, 'شوط', 0),
(48, 3, 'اردبیل', 0),
(49, 3, 'سرعین', 0),
(50, 3, 'بیله سوار', 0),
(51, 3, 'پارس آباد', 0),
(52, 3, 'خلخال', 0),
(53, 3, 'مشگین شهر', 0),
(54, 3, 'مغان', 0),
(55, 3, 'نمین', 0),
(56, 3, 'نیر', 0),
(57, 3, 'کوثر', 0),
(58, 3, 'کیوی', 0),
(59, 3, 'گرمی', 0),
(60, 4, 'اصفهان', 0),
(61, 4, 'فریدن', 0),
(62, 4, 'فریدون شهر', 0),
(63, 4, 'فلاورجان', 0),
(64, 4, 'گلپایگان', 0),
(65, 4, 'دهاقان', 0),
(66, 4, 'نطنز', 0),
(67, 4, 'نایین', 0),
(68, 4, 'تیران', 0),
(69, 4, 'کاشان', 0),
(70, 4, 'فولاد شهر', 0),
(71, 4, 'اردستان', 0),
(72, 4, 'سمیرم', 0),
(73, 4, 'درچه', 0),
(74, 4, 'کوهپایه', 0),
(75, 4, 'مبارکه', 0),
(76, 4, 'شهرضا', 0),
(77, 4, 'خمینی شهر', 0),
(78, 4, 'شاهین شهر', 0),
(79, 4, 'نجف آباد', 0),
(80, 4, 'دولت آباد', 0),
(81, 4, 'زرین شهر', 0),
(82, 4, 'آران و بیدگل', 0),
(83, 4, 'باغ بهادران', 0),
(84, 4, 'خوانسار', 0),
(85, 4, 'مهردشت', 0),
(86, 4, 'علویجه', 0),
(87, 4, 'عسگران', 0),
(88, 4, 'نهضت آباد', 0),
(89, 4, 'حاجی آباد', 0),
(90, 4, 'تودشک', 0),
(91, 4, 'ورزنه', 0),
(92, 6, 'ایلام', 0),
(93, 6, 'مهران', 0),
(94, 6, 'دهلران', 0),
(95, 6, 'آبدانان', 0),
(96, 6, 'شیروان چرداول', 0),
(97, 6, 'دره شهر', 0),
(98, 6, 'ایوان', 0),
(99, 6, 'سرابله', 0),
(100, 7, 'بوشهر', 0),
(101, 7, 'تنگستان', 0),
(102, 7, 'دشتستان', 0),
(103, 7, 'دیر', 0),
(104, 7, 'دیلم', 0),
(105, 7, 'کنگان', 0),
(106, 7, 'گناوه', 0),
(107, 7, 'ریشهر', 0),
(108, 7, 'دشتی', 0),
(109, 7, 'خورموج', 0),
(110, 7, 'اهرم', 0),
(111, 7, 'برازجان', 0),
(112, 7, 'خارک', 0),
(113, 7, 'جم', 0),
(114, 7, 'کاکی', 0),
(115, 7, 'عسلویه', 0),
(116, 7, 'بردخون', 0),
(117, 8, 'تهران', 0),
(118, 8, 'ورامین', 0),
(119, 8, 'فیروزکوه', 0),
(120, 8, 'ری', 0),
(121, 8, 'دماوند', 0),
(122, 8, 'اسلامشهر', 0),
(123, 8, 'رودهن', 0),
(124, 8, 'لواسان', 0),
(125, 8, 'بومهن', 0),
(126, 8, 'تجریش', 0),
(127, 8, 'فشم', 0),
(128, 8, 'کهریزک', 0),
(129, 8, 'پاکدشت', 0),
(130, 8, 'چهاردانگه', 0),
(131, 8, 'شریف آباد', 0),
(132, 8, 'قرچک', 0),
(133, 8, 'باقرشهر', 0),
(134, 8, 'شهریار', 0),
(135, 8, 'رباط کریم', 0),
(136, 8, 'قدس', 0),
(137, 8, 'ملارد', 0),
(138, 9, 'شهرکرد', 0),
(139, 9, 'فارسان', 0),
(140, 9, 'بروجن', 0),
(141, 9, 'چلگرد', 0),
(142, 9, 'اردل', 0),
(143, 9, 'لردگان', 0),
(144, 9, 'سامان', 0),
(145, 10, 'قائن', 0),
(146, 10, 'فردوس', 0),
(147, 10, 'بیرجند', 0),
(148, 10, 'نهبندان', 0),
(149, 10, 'سربیشه', 0),
(150, 10, 'طبس مسینا', 0),
(151, 10, 'قهستان', 0),
(152, 10, 'درمیان', 0),
(153, 11, 'مشهد', 0),
(154, 11, 'نیشابور', 0),
(155, 11, 'سبزوار', 0),
(156, 11, 'کاشمر', 0),
(157, 11, 'گناباد', 0),
(158, 11, 'طبس', 0),
(159, 11, 'تربت حیدریه', 0),
(160, 11, 'خواف', 0),
(161, 11, 'تربت جام', 0),
(162, 11, 'تایباد', 0),
(163, 11, 'قوچان', 0),
(164, 11, 'سرخس', 0),
(165, 11, 'بردسکن', 0),
(166, 11, 'فریمان', 0),
(167, 11, 'چناران', 0),
(168, 11, 'درگز', 0),
(169, 11, 'کلات', 0),
(170, 11, 'طرقبه', 0),
(171, 11, 'سر ولایت', 0),
(172, 12, 'بجنورد', 0),
(173, 12, 'اسفراین', 0),
(174, 12, 'جاجرم', 0),
(175, 12, 'شیروان', 0),
(176, 12, 'آشخانه', 0),
(177, 12, 'گرمه', 0),
(178, 12, 'ساروج', 0),
(179, 13, 'اهواز', 0),
(180, 13, 'ایرانشهر', 0),
(181, 13, 'شوش', 0),
(182, 13, 'آبادان', 0),
(183, 13, 'خرمشهر', 0),
(184, 13, 'مسجد سلیمان', 0),
(185, 13, 'ایذه', 0),
(186, 13, 'شوشتر', 0),
(187, 13, 'اندیمشک', 0),
(188, 13, 'سوسنگرد', 0),
(189, 13, 'هویزه', 0),
(190, 13, 'دزفول', 0),
(191, 13, 'شادگان', 0),
(192, 13, 'بندر ماهشهر', 0),
(193, 13, 'بندر امام خمینی', 0),
(194, 13, 'امیدیه', 0),
(195, 13, 'بهبهان', 0),
(196, 13, 'رامهرمز', 0),
(197, 13, 'باغ ملک', 0),
(198, 13, 'هندیجان', 0),
(199, 13, 'لالی', 0),
(200, 13, 'رامشیر', 0),
(201, 13, 'حمیدیه', 0),
(202, 13, 'دغاغله', 0),
(203, 13, 'ملاثانی', 0),
(204, 13, 'شادگان', 0),
(205, 13, 'ویسی', 0),
(206, 14, 'زنجان', 0),
(207, 14, 'ابهر', 0),
(208, 14, 'خدابنده', 0),
(209, 14, 'طارم', 0),
(210, 14, 'ماهنشان', 0),
(211, 14, 'خرمدره', 0),
(212, 14, 'ایجرود', 0),
(213, 14, 'زرین آباد', 0),
(214, 14, 'آب بر', 0),
(215, 14, 'قیدار', 0),
(216, 15, 'سمنان', 0),
(217, 15, 'شاهرود', 0),
(218, 15, 'گرمسار', 0),
(219, 15, 'ایوانکی', 0),
(220, 15, 'دامغان', 0),
(221, 15, 'بسطام', 0),
(222, 16, 'زاهدان', 0),
(223, 16, 'چابهار', 0),
(224, 16, 'خاش', 0),
(225, 16, 'سراوان', 0),
(226, 16, 'زابل', 0),
(227, 16, 'سرباز', 0),
(228, 16, 'نیکشهر', 0),
(229, 16, 'ایرانشهر', 0),
(230, 16, 'راسک', 0),
(231, 16, 'میرجاوه', 0),
(232, 17, 'شیراز', 0),
(233, 17, 'اقلید', 0),
(234, 17, 'داراب', 0),
(235, 17, 'فسا', 0),
(236, 17, 'مرودشت', 0),
(237, 17, 'خرم بید', 0),
(238, 17, 'آباده', 0),
(239, 17, 'کازرون', 0),
(240, 17, 'ممسنی', 0),
(241, 17, 'سپیدان', 0),
(242, 17, 'لار', 0),
(243, 17, 'فیروز آباد', 0),
(244, 17, 'جهرم', 0),
(245, 17, 'نی ریز', 0),
(246, 17, 'استهبان', 0),
(247, 17, 'لامرد', 0),
(248, 17, 'مهر', 0),
(249, 17, 'حاجی آباد', 0),
(250, 17, 'نورآباد', 0),
(251, 17, 'اردکان', 0),
(252, 17, 'صفاشهر', 0),
(253, 17, 'ارسنجان', 0),
(254, 17, 'قیروکارزین', 0),
(255, 17, 'سوریان', 0),
(256, 17, 'فراشبند', 0),
(257, 17, 'سروستان', 0),
(258, 17, 'ارژن', 0),
(259, 17, 'گویم', 0),
(260, 17, 'داریون', 0),
(261, 17, 'زرقان', 0),
(262, 17, 'خان زنیان', 0),
(263, 17, 'کوار', 0),
(264, 17, 'ده بید', 0),
(265, 17, 'باب انار/خفر', 0),
(266, 17, 'بوانات', 0),
(267, 17, 'خرامه', 0),
(268, 17, 'خنج', 0),
(269, 17, 'سیاخ دارنگون', 0),
(270, 18, 'قزوین', 0),
(271, 18, 'تاکستان', 0),
(272, 18, 'آبیک', 0),
(273, 18, 'بوئین زهرا', 0),
(274, 19, 'قم', 0),
(275, 5, 'طالقان', 0),
(276, 5, 'نظرآباد', 0),
(277, 5, 'اشتهارد', 0),
(278, 5, 'هشتگرد', 0),
(279, 5, 'کن', 0),
(280, 5, 'آسارا', 0),
(281, 5, 'شهرک گلستان', 0),
(282, 5, 'اندیشه', 0),
(283, 5, 'کرج', 0),
(284, 5, 'نظر آباد', 0),
(285, 5, 'گوهردشت', 0),
(286, 5, 'ماهدشت', 0),
(287, 5, 'مشکین دشت', 0),
(288, 20, 'سنندج', 0),
(289, 20, 'دیواندره', 0),
(290, 20, 'بانه', 0),
(291, 20, 'بیجار', 0),
(292, 20, 'سقز', 0),
(293, 20, 'کامیاران', 0),
(294, 20, 'قروه', 0),
(295, 20, 'مریوان', 0),
(296, 20, 'صلوات آباد', 0),
(297, 20, 'حسن آباد', 0),
(298, 21, 'کرمان', 0),
(299, 21, 'راور', 0),
(300, 21, 'بابک', 0),
(301, 21, 'انار', 0),
(302, 21, 'کوهبنان', 0),
(303, 21, 'رفسنجان', 0),
(304, 21, 'بافت', 0),
(305, 21, 'سیرجان', 0),
(306, 21, 'کهنوج', 0),
(307, 21, 'زرند', 0),
(308, 21, 'بم', 0),
(309, 21, 'جیرفت', 0),
(310, 21, 'بردسیر', 0),
(311, 22, 'کرمانشاه', 0),
(312, 22, 'اسلام آباد غرب', 0),
(313, 22, 'سر پل ذهاب', 0),
(314, 22, 'کنگاور', 0),
(315, 22, 'سنقر', 0),
(316, 22, 'قصر شیرین', 0),
(317, 22, 'گیلان غرب', 0),
(318, 22, 'هرسین', 0),
(319, 22, 'صحنه', 0),
(320, 22, 'پاوه', 0),
(321, 22, 'جوانرود', 0),
(322, 22, 'شاهو', 0),
(323, 23, 'یاسوج', 0),
(324, 23, 'گچساران', 0),
(325, 23, 'دنا', 0),
(326, 23, 'دوگنبدان', 0),
(327, 23, 'سی سخت', 0),
(328, 23, 'دهدشت', 0),
(329, 23, 'لیکک', 0),
(330, 24, 'گرگان', 0),
(331, 24, 'آق قلا', 0),
(332, 24, 'گنبد کاووس', 0),
(333, 24, 'علی آباد کتول', 0),
(334, 24, 'مینو دشت', 0),
(335, 24, 'ترکمن', 0),
(336, 24, 'کردکوی', 0),
(337, 24, 'بندر گز', 0),
(338, 24, 'کلاله', 0),
(339, 24, 'آزاد شهر', 0),
(340, 24, 'رامیان', 0),
(341, 25, 'رشت', 0),
(342, 25, 'منجیل', 0),
(343, 25, 'لنگرود', 0),
(344, 25, 'رود سر', 0),
(345, 25, 'تالش', 0),
(346, 25, 'آستارا', 0),
(347, 25, 'ماسوله', 0),
(348, 25, 'آستانه اشرفیه', 0),
(349, 25, 'رودبار', 0),
(350, 25, 'فومن', 0),
(351, 25, 'صومعه سرا', 0),
(352, 25, 'بندرانزلی', 0),
(353, 25, 'کلاچای', 0),
(354, 25, 'هشتپر', 0),
(355, 25, 'رضوان شهر', 0),
(356, 25, 'ماسال', 0),
(357, 25, 'شفت', 0),
(358, 25, 'سیاهکل', 0),
(359, 25, 'املش', 0),
(360, 25, 'لاهیجان', 0),
(361, 25, 'خشک بیجار', 0),
(362, 25, 'خمام', 0),
(363, 25, 'لشت نشا', 0),
(364, 25, 'بندر کیاشهر', 0),
(365, 26, 'خرم آباد', 0),
(366, 26, 'ماهشهر', 0),
(367, 26, 'دزفول', 0),
(368, 26, 'بروجرد', 0),
(369, 26, 'دورود', 0),
(370, 26, 'الیگودرز', 0),
(371, 26, 'ازنا', 0),
(372, 26, 'نور آباد', 0),
(373, 26, 'کوهدشت', 0),
(374, 26, 'الشتر', 0),
(375, 26, 'پلدختر', 0),
(376, 27, 'ساری', 0),
(377, 27, 'آمل', 0),
(378, 27, 'بابل', 0),
(379, 27, 'بابلسر', 0),
(380, 27, 'بهشهر', 0),
(381, 27, 'تنکابن', 0),
(382, 27, 'جویبار', 0),
(383, 27, 'چالوس', 0),
(384, 27, 'رامسر', 0),
(385, 27, 'سواد کوه', 0),
(386, 27, 'قائم شهر', 0),
(387, 27, 'نکا', 0),
(388, 27, 'نور', 0),
(389, 27, 'بلده', 0),
(390, 27, 'نوشهر', 0),
(391, 27, 'پل سفید', 0),
(392, 27, 'محمود آباد', 0),
(393, 27, 'فریدون کنار', 0),
(394, 28, 'اراک', 0),
(395, 28, 'آشتیان', 0),
(396, 28, 'تفرش', 0),
(397, 28, 'خمین', 0),
(398, 28, 'دلیجان', 0),
(399, 28, 'ساوه', 0),
(400, 28, 'سربند', 0),
(401, 28, 'محلات', 0),
(402, 28, 'شازند', 0),
(403, 29, 'بندرعباس', 0),
(404, 29, 'قشم', 0),
(405, 29, 'کیش', 0),
(406, 29, 'بندر لنگه', 0),
(407, 29, 'بستک', 0),
(408, 29, 'حاجی آباد', 0),
(409, 29, 'دهبارز', 0),
(410, 29, 'انگهران', 0),
(411, 29, 'میناب', 0),
(412, 29, 'ابوموسی', 0),
(413, 29, 'بندر جاسک', 0),
(414, 29, 'تنب بزرگ', 0),
(415, 29, 'بندر خمیر', 0),
(416, 29, 'پارسیان', 0),
(417, 29, 'قشم', 0),
(418, 30, 'همدان', 0),
(419, 30, 'ملایر', 0),
(420, 30, 'تویسرکان', 0),
(421, 30, 'نهاوند', 0),
(422, 30, 'کبودر اهنگ', 0),
(423, 30, 'رزن', 0),
(424, 30, 'اسدآباد', 0),
(425, 30, 'بهار', 0),
(426, 31, 'یزد', 0),
(427, 31, 'تفت', 0),
(428, 31, 'اردکان', 0),
(429, 31, 'ابرکوه', 0),
(430, 31, 'میبد', 0),
(431, 31, 'طبس', 0),
(432, 31, 'بافق', 0),
(433, 31, 'مهریز', 0),
(434, 31, 'اشکذر', 0),
(435, 31, 'هرات', 0),
(436, 31, 'خضرآباد', 0),
(437, 31, 'شاهدیه', 0),
(438, 31, 'حمیدیه شهر', 0),
(439, 31, 'سید میرزا', 0),
(440, 31, 'زارچ', 0);

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
  `user_code` varchar(10) NOT NULL,
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
-- Table structure for table `coupons`
--

CREATE TABLE `coupons` (
  `id` int(10) UNSIGNED NOT NULL,
  `coupon_code` varchar(20) NOT NULL,
  `title` varchar(300) NOT NULL,
  `price` varchar(20) NOT NULL,
  `min_price` varchar(20) NOT NULL,
  `max_price` varchar(20) DEFAULT NULL,
  `expire_time` int(11) UNSIGNED DEFAULT NULL,
  `publish` tinyint(1) UNSIGNED NOT NULL,
  `created_by` int(10) UNSIGNED NOT NULL,
  `updated_by` int(10) UNSIGNED DEFAULT NULL,
  `created_at` int(11) UNSIGNED NOT NULL,
  `updated_at` int(11) UNSIGNED DEFAULT NULL
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
  `order_code` varchar(20) NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `price` bigint(20) UNSIGNED NOT NULL,
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
  `order_code` varchar(20) NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `price` bigint(20) UNSIGNED NOT NULL,
  `payment_code` varchar(20) NOT NULL,
  `payment_id` varchar(300) NOT NULL,
  `digitalreceipt` text NOT NULL,
  `status` tinyint(3) DEFAULT NULL,
  `rnn` varchar(100) NOT NULL,
  `msg` text NOT NULL,
  `bank_name` text NOT NULL,
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
  `order_code` varchar(20) NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `price` bigint(20) UNSIGNED NOT NULL,
  `payment_code` varchar(20) NOT NULL,
  `status` tinyint(3) DEFAULT NULL,
  `msg` text NOT NULL,
  `exportation_type` tinyint(1) UNSIGNED NOT NULL,
  `payment_date` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `hits`
--

CREATE TABLE `hits` (
  `pageid` varchar(100) NOT NULL,
  `isunique` tinyint(1) NOT NULL,
  `hitcount` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `icons`
--

CREATE TABLE `icons` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `icons`
--

INSERT INTO `icons` (`id`, `name`) VALUES
(1, 'lab la-accessible-icon'),
(2, 'las la-american-sign-language-interpreting'),
(3, 'las la-assistive-listening-systems'),
(4, 'las la-audio-description'),
(5, 'las la-blind'),
(6, 'las la-braille'),
(7, 'las la-closed-captioning'),
(8, 'las la-deaf'),
(9, 'las la-low-vision'),
(10, 'las la-phone-volume'),
(11, 'las la-question-circle'),
(12, 'las la-sign-language'),
(13, 'las la-tty'),
(14, 'las la-universal-access'),
(15, 'las la-wheelchair'),
(16, 'las la-bell'),
(17, 'las la-bell-slash'),
(18, 'las la-exclamation'),
(19, 'las la-exclamation-circle'),
(20, 'las la-exclamation-triangle'),
(21, 'las la-radiation'),
(22, 'las la-radiation-alt'),
(23, 'las la-skull-crossbones'),
(24, 'las la-cat'),
(25, 'las la-crow'),
(26, 'las la-dog'),
(27, 'las la-dove'),
(28, 'las la-dragon'),
(29, 'las la-feather'),
(30, 'las la-feather-alt'),
(31, 'las la-fish'),
(32, 'las la-frog'),
(33, 'las la-hippo'),
(34, 'las la-horse'),
(35, 'las la-horse-head'),
(36, 'las la-kiwi-bird'),
(37, 'las la-otter'),
(38, 'las la-paw'),
(39, 'las la-spider'),
(40, 'las la-angle-double-down'),
(41, 'las la-angle-double-left'),
(42, 'las la-angle-double-right'),
(43, 'las la-angle-double-up'),
(44, 'las la-angle-down'),
(45, 'las la-angle-left'),
(46, 'las la-angle-right'),
(47, 'las la-angle-up'),
(48, 'las la-arrow-alt-circle-down'),
(49, 'las la-arrow-alt-circle-left'),
(50, 'las la-arrow-alt-circle-right'),
(51, 'las la-arrow-alt-circle-up'),
(52, 'las la-arrow-circle-down'),
(53, 'las la-arrow-circle-left'),
(54, 'las la-arrow-circle-right'),
(55, 'las la-arrow-circle-up'),
(56, 'las la-arrow-down'),
(57, 'las la-arrow-left'),
(58, 'las la-arrow-right'),
(59, 'las la-arrow-up'),
(60, 'las la-arrows-alt'),
(61, 'las la-arrows-alt-h'),
(62, 'las la-arrows-alt-v'),
(63, 'las la-caret-down'),
(64, 'las la-caret-left'),
(65, 'las la-caret-right'),
(66, 'las la-caret-square-down'),
(67, 'las la-caret-square-left'),
(68, 'las la-caret-square-right'),
(69, 'las la-caret-square-up'),
(70, 'las la-caret-up'),
(71, 'las la-cart-arrow-down'),
(72, 'las la-chart-line'),
(73, 'las la-chevron-circle-down'),
(74, 'las la-chevron-circle-left'),
(75, 'las la-chevron-circle-right'),
(76, 'las la-chevron-circle-up'),
(77, 'las la-chevron-down'),
(78, 'las la-chevron-left'),
(79, 'las la-chevron-right'),
(80, 'las la-chevron-up'),
(81, 'las la-cloud-download-alt'),
(82, 'las la-cloud-upload-alt'),
(83, 'las la-compress-arrows-alt'),
(84, 'las la-download'),
(85, 'las la-exchange-alt'),
(86, 'las la-expand-arrows-alt'),
(87, 'las la-external-link-alt'),
(88, 'las la-external-link-square-alt'),
(89, 'las la-hand-point-down'),
(90, 'las la-hand-point-left'),
(91, 'las la-hand-point-right'),
(92, 'las la-hand-point-up'),
(93, 'las la-hand-pointer'),
(94, 'las la-history'),
(95, 'las la-level-down-alt'),
(96, 'las la-level-up-alt'),
(97, 'las la-location-arrow'),
(98, 'las la-long-arrow-alt-down'),
(99, 'las la-long-arrow-alt-left'),
(100, 'las la-long-arrow-alt-right'),
(101, 'las la-long-arrow-alt-up'),
(102, 'las la-mouse-pointer'),
(103, 'las la-play'),
(104, 'las la-random'),
(105, 'las la-recycle'),
(106, 'las la-redo'),
(107, 'las la-redo-alt'),
(108, 'las la-reply'),
(109, 'las la-reply-all'),
(110, 'las la-retweet'),
(111, 'las la-share'),
(112, 'las la-share-square'),
(113, 'las la-sign-in-alt'),
(114, 'las la-sign-out-alt'),
(115, 'las la-sort'),
(116, 'las la-sort-alpha-down'),
(117, 'las la-sort-alpha-down-alt'),
(118, 'las la-sort-alpha-up'),
(119, 'las la-sort-alpha-up-alt'),
(120, 'las la-sort-amount-down'),
(121, 'las la-sort-amount-down-alt'),
(122, 'las la-sort-amount-up'),
(123, 'las la-sort-amount-up-alt'),
(124, 'las la-sort-down'),
(125, 'las la-sort-numeric-down'),
(126, 'las la-sort-numeric-down-alt'),
(127, 'las la-sort-numeric-up'),
(128, 'las la-sort-numeric-up-alt'),
(129, 'las la-sort-up'),
(130, 'las la-sync'),
(131, 'las la-text-height'),
(132, 'las la-text-width'),
(133, 'las la-undo'),
(134, 'las la-undo-alt'),
(135, 'las la-upload'),
(136, 'las la-backward'),
(137, 'las la-broadcast-tower'),
(138, 'las la-circle'),
(139, 'las la-compress'),
(140, 'las la-compress-arrows-alt'),
(141, 'las la-eject'),
(142, 'las la-expand'),
(143, 'las la-expand-arrows-alt'),
(144, 'las la-fast-backward'),
(145, 'las la-fast-forward'),
(146, 'las la-file-audio'),
(147, 'las la-file-video'),
(148, 'las la-film'),
(149, 'las la-headphones'),
(150, 'las la-microphone'),
(151, 'las la-microphone-alt'),
(152, 'las la-microphone-alt-slash'),
(153, 'las la-microphone-slash'),
(154, 'las la-music'),
(155, 'las la-pause'),
(156, 'las la-pause-circle'),
(157, 'las la-phone-volume'),
(158, 'las la-photo-video'),
(159, 'las la-play'),
(160, 'las la-play-circle'),
(161, 'las la-podcast'),
(162, 'las la-random'),
(163, 'las la-redo'),
(164, 'las la-redo-alt'),
(165, 'las la-rss'),
(166, 'las la-rss-square'),
(167, 'las la-step-backward'),
(168, 'las la-step-forward'),
(169, 'las la-stop'),
(170, 'las la-stop-circle'),
(171, 'las la-tv'),
(172, 'las la-video'),
(173, 'las la-volume-down'),
(174, 'las la-volume-mute'),
(175, 'las la-volume-up'),
(176, 'lab la-youtube'),
(177, 'las la-air-freshener'),
(178, 'las la-ambulance'),
(179, 'las la-bus'),
(180, 'las la-bus-alt'),
(181, 'las la-car'),
(182, 'las la-car-alt'),
(183, 'las la-car-battery'),
(184, 'las la-car-crash'),
(185, 'las la-car-side'),
(186, 'las la-charging-station'),
(187, 'las la-gas-pump'),
(188, 'las la-motorcycle'),
(189, 'las la-oil-can'),
(190, 'las la-shuttle-van'),
(191, 'las la-tachometer-alt'),
(192, 'las la-taxi'),
(193, 'las la-truck'),
(194, 'las la-truck-monster'),
(195, 'las la-truck-pickup'),
(196, 'las la-apple-alt'),
(197, 'las la-campground'),
(198, 'las la-cloud-sun'),
(199, 'las la-drumstick-bite'),
(200, 'las la-football-ball'),
(201, 'las la-hiking'),
(202, 'las la-mountain'),
(203, 'las la-tractor'),
(204, 'las la-tree'),
(205, 'las la-wind'),
(206, 'las la-wine-bottle'),
(207, 'las la-beer'),
(208, 'las la-blender'),
(209, 'las la-cocktail'),
(210, 'las la-cocktail'),
(211, 'las la-flask'),
(212, 'las la-glass-cheers'),
(213, 'las la-glass-martini'),
(214, 'las la-glass-martini-alt'),
(215, 'las la-glass-whiskey'),
(216, 'las la-mug-hot'),
(217, 'las la-wine-bottle'),
(218, 'las la-wine-glass'),
(219, 'las la-wine-glass-alt'),
(220, 'lab la-500px'),
(221, 'lab la-accusoft'),
(222, 'lab la-adn'),
(223, 'lab la-adobe'),
(224, 'lab la-adversal'),
(225, 'lab la-affiliatetheme'),
(226, 'lab la-airbnb'),
(227, 'lab la-algolia'),
(228, 'lab la-amazon'),
(229, 'lab la-amilia'),
(230, 'lab la-android'),
(231, 'lab la-angellist'),
(232, 'lab la-angrycreative'),
(233, 'lab la-angular'),
(234, 'lab la-app-store'),
(235, 'lab la-app-store-ios'),
(236, 'lab la-apper'),
(237, 'lab la-apple'),
(238, 'lab la-artstation'),
(239, 'lab la-asymmetrik'),
(240, 'lab la-atlassian'),
(241, 'lab la-audible'),
(242, 'lab la-autoprefixer'),
(243, 'lab la-avianex'),
(244, 'lab la-aviato'),
(245, 'lab la-aws'),
(246, 'lab la-bandcamp'),
(247, 'lab la-battle-net'),
(248, 'lab la-behance'),
(249, 'lab la-behance-square'),
(250, 'lab la-bimobject'),
(251, 'lab la-bitbucket'),
(252, 'lab la-bity'),
(253, 'lab la-black-tie'),
(254, 'lab la-blackberry'),
(255, 'lab la-blogger'),
(256, 'lab la-blogger-b'),
(257, 'lab la-bootstrap'),
(258, 'lab la-buffer'),
(259, 'lab la-buromobelexperte'),
(260, 'lab la-buy-n-large'),
(261, 'lab la-buysellads'),
(262, 'lab la-canadian-maple-leaf'),
(263, 'lab la-centercode'),
(264, 'lab la-centos'),
(265, 'lab la-chrome'),
(266, 'lab la-chromecast'),
(267, 'lab la-cloudscale'),
(268, 'lab la-cloudsmith'),
(269, 'lab la-cloudversify'),
(270, 'lab la-codepen'),
(271, 'lab la-codiepie'),
(272, 'lab la-confluence'),
(273, 'lab la-connectdevelop'),
(274, 'lab la-contao'),
(275, 'lab la-cotton-bureau'),
(276, 'lab la-cpanel'),
(277, 'lab la-cpanel'),
(278, 'lab la-creative-commons-by'),
(279, 'lab la-creative-commons-nc'),
(280, 'lab la-creative-commons-nc-eu'),
(281, 'lab la-creative-commons-nc-jp'),
(282, 'lab la-creative-commons-nd'),
(283, 'lab la-creative-commons-pd'),
(284, 'lab la-creative-commons-pd-alt'),
(285, 'lab la-creative-commons-remix'),
(286, 'lab la-creative-commons-sa'),
(287, 'lab la-creative-commons-sampling'),
(288, 'lab la-creative-commons-sampling-plus'),
(289, 'lab la-creative-commons-share'),
(290, 'lab la-creative-commons-zero'),
(291, 'lab la-css3'),
(292, 'lab la-css3-alt'),
(293, 'lab la-cuttlefish'),
(294, 'lab la-dashcube'),
(295, 'lab la-delicious'),
(296, 'lab la-deploydog'),
(297, 'lab la-deskpro'),
(298, 'lab la-dev'),
(299, 'lab la-deviantart'),
(300, 'lab la-dhl'),
(301, 'lab la-diaspora'),
(302, 'lab la-digg'),
(303, 'lab la-digital-ocean'),
(304, 'lab la-discord'),
(305, 'lab la-discourse'),
(306, 'lab la-dochub'),
(307, 'lab la-docker'),
(308, 'lab la-draft2digital'),
(309, 'lab la-dribbble'),
(310, 'lab la-dribbble-square'),
(311, 'lab la-dropbox'),
(312, 'lab la-drupal'),
(313, 'lab la-dyalog'),
(314, 'lab la-earlybirds'),
(315, 'lab la-ebay'),
(316, 'lab la-edge'),
(317, 'lab la-elementor'),
(318, 'lab la-ello'),
(319, 'lab la-ember'),
(320, 'lab la-empire'),
(321, 'lab la-envira'),
(322, 'lab la-erlang'),
(323, 'lab la-etsy'),
(324, 'lab la-evernote'),
(325, 'lab la-expeditedssl'),
(326, 'lab la-facebook'),
(327, 'lab la-facebook-f'),
(328, 'lab la-facebook-messenger'),
(329, 'lab la-facebook-square'),
(330, 'lab la-fedex'),
(331, 'lab la-fedora'),
(332, 'lab la-figma'),
(333, 'lab la-firefox'),
(334, 'lab la-first-order'),
(335, 'lab la-first-order-alt'),
(336, 'lab la-firstdraft'),
(337, 'lab la-flickr'),
(338, 'lab la-flipboard'),
(339, 'lab la-fly'),
(340, 'lab la-font-awesome'),
(341, 'lab la-font-awesome-flag'),
(342, 'lab la-fonticons'),
(343, 'lab la-fort-awesome'),
(344, 'lab la-fort-awesome-alt'),
(345, 'lab la-forumbee'),
(346, 'lab la-foursquare'),
(347, 'lab la-free-code-camp'),
(348, 'lab la-freebsd'),
(349, 'lab la-fulcrum'),
(350, 'lab la-get-pocket'),
(351, 'lab la-git'),
(352, 'lab la-git-square'),
(353, 'lab la-github'),
(354, 'lab la-github-alt'),
(355, 'lab la-github-square'),
(356, 'lab la-gitkraken'),
(357, 'lab la-gitlab'),
(358, 'lab la-gitter'),
(359, 'lab la-glide'),
(360, 'lab la-glide-g'),
(361, 'lab la-gofore'),
(362, 'lab la-goodreads'),
(363, 'lab la-goodreads-g'),
(364, 'lab la-google'),
(365, 'lab la-google-drive'),
(366, 'lab la-google-play'),
(367, 'lab la-google-plus'),
(368, 'lab la-google-plus-square'),
(369, 'lab la-google-plus-square'),
(370, 'lab la-grav'),
(371, 'lab la-gripfire'),
(372, 'lab la-grunt'),
(373, 'lab la-gulp'),
(374, 'lab la-hacker-news'),
(375, 'lab la-hackerrank'),
(376, 'lab la-hips'),
(377, 'lab la-hire-a-helper'),
(378, 'lab la-hooli'),
(379, 'lab la-hornbill'),
(380, 'lab la-hotjar'),
(381, 'lab la-houzz'),
(382, 'lab la-html5'),
(383, 'lab la-hubspot'),
(384, 'lab la-imdb'),
(385, 'lab la-instagram'),
(386, 'lab la-intercom'),
(387, 'lab la-internet-explorer'),
(388, 'lab la-invision'),
(389, 'lab la-ioxhost'),
(390, 'lab la-itch-io'),
(391, 'lab la-itunes'),
(392, 'lab la-itunes-note'),
(393, 'lab la-java'),
(394, 'lab la-jenkins'),
(395, 'lab la-jira'),
(396, 'lab la-joget'),
(397, 'lab la-joomla'),
(398, 'lab la-js'),
(399, 'lab la-js-square'),
(400, 'lab la-jsfiddle'),
(401, 'lab la-kaggle'),
(402, 'lab la-keybase'),
(403, 'lab la-keycdn'),
(404, 'lab la-kickstarter'),
(405, 'lab la-kickstarter-k'),
(406, 'lab la-korvue'),
(407, 'lab la-laravel'),
(408, 'lab la-lastfm'),
(409, 'lab la-lastfm-square'),
(410, 'lab la-leanpub'),
(411, 'lab la-less'),
(412, 'lab la-line'),
(413, 'lab la-linkedin'),
(414, 'lab la-linkedin-in'),
(415, 'lab la-linode'),
(416, 'lab la-linux'),
(417, 'lab la-lyft'),
(418, 'lab la-magento'),
(419, 'lab la-mailchimp'),
(420, 'lab la-mandalorian'),
(421, 'lab la-markdown'),
(422, 'lab la-mastodon'),
(423, 'lab la-maxcdn'),
(424, 'lab la-mdb'),
(425, 'lab la-medapps'),
(426, 'lab la-medium'),
(427, 'lab la-medrt'),
(428, 'lab la-meetup'),
(429, 'lab la-megaport'),
(430, 'lab la-mendeley'),
(431, 'lab la-microsoft'),
(432, 'lab la-mix'),
(433, 'lab la-mixcloud'),
(434, 'lab la-mizuni'),
(435, 'lab la-modx'),
(436, 'lab la-monero'),
(437, 'lab la-neos'),
(438, 'lab la-nimblr'),
(439, 'lab la-node'),
(440, 'lab la-node-js'),
(441, 'lab la-npm'),
(442, 'lab la-ns8'),
(443, 'lab la-nutritionix'),
(444, 'lab la-odnoklassniki'),
(445, 'lab la-odnoklassniki-square'),
(446, 'lab la-opencart'),
(447, 'lab la-openid'),
(448, 'lab la-opera'),
(449, 'lab la-optin-monster'),
(450, 'lab la-orcid'),
(451, 'lab la-osi'),
(452, 'lab la-page4'),
(453, 'lab la-pagelines'),
(454, 'lab la-palfed'),
(455, 'lab la-patreon'),
(456, 'lab la-periscope'),
(457, 'lab la-phabricator'),
(458, 'lab la-phoenix-framework'),
(459, 'lab la-phoenix-squadron'),
(460, 'lab la-php'),
(461, 'lab la-pied-piper'),
(462, 'lab la-pied-piper-alt'),
(463, 'lab la-pied-piper-hat'),
(464, 'lab la-pied-piper-pp'),
(465, 'lab la-pinterest'),
(466, 'lab la-pinterest-p'),
(467, 'lab la-pinterest-square'),
(468, 'lab la-product-hunt'),
(469, 'lab la-pushed'),
(470, 'lab la-python'),
(471, 'lab la-qq'),
(472, 'lab la-quinscape'),
(473, 'lab la-quora'),
(474, 'lab la-r-project'),
(475, 'lab la-raspberry-pi'),
(476, 'lab la-raspberry-pi'),
(477, 'lab la-react'),
(478, 'lab la-reacteurope'),
(479, 'lab la-readme'),
(480, 'lab la-rebel'),
(481, 'lab la-red-river'),
(482, 'lab la-reddit'),
(483, 'lab la-reddit-square'),
(484, 'lab la-redhat'),
(485, 'lab la-renren'),
(486, 'lab la-replyd'),
(487, 'lab la-researchgate'),
(488, 'lab la-resolving'),
(489, 'lab la-rev'),
(490, 'lab la-rocketchat'),
(491, 'lab la-rockrms'),
(492, 'lab la-safari'),
(493, 'lab la-salesforce'),
(494, 'lab la-sass'),
(495, 'lab la-schlix'),
(496, 'lab la-scribd'),
(497, 'lab la-searchengin'),
(498, 'lab la-sellcast'),
(499, 'lab la-sellsy'),
(500, 'lab la-servicestack'),
(501, 'lab la-shirtsinbulk'),
(502, 'lab la-shopware'),
(503, 'lab la-simplybuilt'),
(504, 'lab la-sistrix'),
(505, 'lab la-sith'),
(506, 'lab la-sketch'),
(507, 'lab la-skyatlas'),
(508, 'lab la-skype'),
(509, 'lab la-slack'),
(510, 'lab la-slideshare'),
(511, 'lab la-snapchat'),
(512, 'lab la-snapchat-square'),
(513, 'lab la-sourcetree'),
(514, 'lab la-speakap'),
(515, 'lab la-speaker-deck'),
(516, 'lab la-squarespace'),
(517, 'lab la-stack-exchange'),
(518, 'lab la-stack-overflow'),
(519, 'lab la-stackpath'),
(520, 'lab la-staylinked'),
(521, 'lab la-sticker-mule'),
(522, 'lab la-strava'),
(523, 'lab la-strava'),
(524, 'lab la-stumbleupon'),
(525, 'lab la-stumbleupon-circle'),
(526, 'lab la-superpowers'),
(527, 'lab la-supple'),
(528, 'lab la-suse'),
(529, 'lab la-swift'),
(530, 'lab la-symfony'),
(531, 'lab la-teamspeak'),
(532, 'lab la-telegram'),
(533, 'lab la-tencent-weibo'),
(534, 'lab la-the-red-yeti'),
(535, 'lab la-themeco'),
(536, 'lab la-themeisle'),
(537, 'lab la-think-peaks'),
(538, 'lab la-trade-federation'),
(539, 'lab la-trello'),
(540, 'lab la-tripadvisor'),
(541, 'lab la-tumblr'),
(542, 'lab la-tumblr-square'),
(543, 'lab la-twitter'),
(544, 'lab la-twitter-square'),
(545, 'lab la-typo3'),
(546, 'lab la-uber'),
(547, 'lab la-ubuntu'),
(548, 'lab la-uikit'),
(549, 'lab la-umbraco'),
(550, 'lab la-uniregistry'),
(551, 'lab la-untappd'),
(552, 'lab la-ups'),
(553, 'lab la-usb'),
(554, 'lab la-usps'),
(555, 'lab la-ussunnah'),
(556, 'lab la-vaadin'),
(557, 'lab la-viacoin'),
(558, 'lab la-viadeo'),
(559, 'lab la-viadeo-square'),
(560, 'lab la-viber'),
(561, 'lab la-vimeo'),
(562, 'lab la-vimeo-square'),
(563, 'lab la-vine'),
(564, 'lab la-vk'),
(565, 'lab la-vnv'),
(566, 'lab la-vuejs'),
(567, 'lab la-waze'),
(568, 'lab la-weebly'),
(569, 'lab la-weibo'),
(570, 'lab la-weixin'),
(571, 'lab la-whatsapp'),
(572, 'lab la-whatsapp-square'),
(573, 'lab la-whmcs'),
(574, 'lab la-wikipedia-w'),
(575, 'lab la-windows'),
(576, 'lab la-wix'),
(577, 'lab la-wolf-pack-battalion'),
(578, 'lab la-wordpress'),
(579, 'lab la-wordpress-simple'),
(580, 'lab la-wpbeginner'),
(581, 'lab la-wpexplorer'),
(582, 'lab la-wpforms'),
(583, 'lab la-wpressr'),
(584, 'lab la-xing'),
(585, 'lab la-xing-square'),
(586, 'lab la-y-combinator'),
(587, 'lab la-yahoo'),
(588, 'lab la-yammer'),
(589, 'lab la-yandex'),
(590, 'lab la-yandex-international'),
(591, 'lab la-yandex-international'),
(592, 'lab la-yelp'),
(593, 'lab la-yoast'),
(594, 'lab la-youtube-square'),
(595, 'lab la-zhihu'),
(596, 'las la-archway'),
(597, 'las la-building'),
(598, 'las la-campground'),
(599, 'las la-church'),
(600, 'las la-city'),
(601, 'las la-clinic-medical'),
(602, 'las la-dungeon'),
(603, 'las la-gopuram'),
(604, 'las la-home'),
(605, 'las la-hospital'),
(606, 'las la-hospital-alt'),
(607, 'las la-hotel'),
(608, 'las la-house-damage'),
(609, 'las la-igloo'),
(610, 'las la-industry'),
(611, 'las la-kaaba'),
(612, 'las la-landmark'),
(613, 'las la-monument'),
(614, 'las la-mosque'),
(615, 'las la-place-of-worship'),
(616, 'las la-school'),
(617, 'las la-store'),
(618, 'las la-store-alt'),
(619, 'las la-synagogue'),
(620, 'las la-torii-gate'),
(621, 'las la-university'),
(622, 'las la-vihara'),
(623, 'las la-warehouse'),
(624, 'las la-address-book'),
(625, 'las la-address-card'),
(626, 'las la-archive'),
(627, 'las la-balance-scale'),
(628, 'las la-balance-scale-left'),
(629, 'las la-balance-scale-right'),
(630, 'las la-birthday-cake'),
(631, 'las la-book'),
(632, 'las la-briefcase'),
(633, 'las la-bullhorn'),
(634, 'las la-bullseye'),
(635, 'las la-business-time'),
(636, 'las la-calculator'),
(637, 'las la-calendar'),
(638, 'las la-certificate'),
(639, 'las la-chart-area'),
(640, 'las la-chart-bar'),
(641, 'las la-chart-line'),
(642, 'las la-chart-pie'),
(643, 'las la-city'),
(644, 'las la-clipboard'),
(645, 'las la-coffee'),
(646, 'las la-columns'),
(647, 'las la-compass'),
(648, 'las la-copy'),
(649, 'las la-copyright'),
(650, 'las la-cut'),
(651, 'las la-edit'),
(652, 'las la-envelope'),
(653, 'las la-envelope-open'),
(654, 'las la-envelope-square'),
(655, 'las la-eraser'),
(656, 'las la-fax'),
(657, 'las la-file'),
(658, 'las la-file-alt'),
(659, 'las la-folder'),
(660, 'las la-folder-minus'),
(661, 'las la-folder-open'),
(662, 'las la-folder-plus'),
(663, 'las la-glasses'),
(664, 'las la-globe'),
(665, 'las la-highlighter'),
(666, 'las la-industry'),
(667, 'las la-paperclip'),
(668, 'las la-paste'),
(669, 'las la-pen'),
(670, 'las la-pen-alt'),
(671, 'las la-pen-fancy'),
(672, 'las la-pen-nib'),
(673, 'las la-pen-square'),
(674, 'las la-pencil-alt'),
(675, 'las la-percent'),
(676, 'las la-phone'),
(677, 'las la-phone-alt'),
(678, 'las la-phone-slash'),
(679, 'las la-phone-square'),
(680, 'las la-phone-square-alt'),
(681, 'las la-phone-volume'),
(682, 'las la-print'),
(683, 'las la-project-diagram'),
(684, 'las la-registered'),
(685, 'las la-save'),
(686, 'las la-sitemap'),
(687, 'las la-socks'),
(688, 'las la-sticky-note'),
(689, 'las la-stream'),
(690, 'las la-table'),
(691, 'las la-tag'),
(692, 'las la-tags'),
(693, 'las la-tasks'),
(694, 'las la-thumbtack'),
(695, 'las la-trademark'),
(696, 'las la-wallet'),
(697, 'las la-binoculars'),
(698, 'las la-campground'),
(699, 'las la-compass'),
(700, 'las la-fire'),
(701, 'las la-fire-alt'),
(702, 'las la-first-aid'),
(703, 'las la-map'),
(704, 'las la-map-marked'),
(705, 'las la-map-marked-alt'),
(706, 'las la-map-signs'),
(707, 'las la-mountain'),
(708, 'las la-route'),
(709, 'las la-toilet-paper'),
(710, 'las la-dollar-sign'),
(711, 'las la-donate'),
(712, 'las la-gift'),
(713, 'las la-hand-holding-heart'),
(714, 'las la-hand-holding-usd'),
(715, 'las la-hands-helping'),
(716, 'las la-handshake'),
(717, 'las la-heart'),
(718, 'las la-leaf'),
(719, 'las la-parachute-box'),
(720, 'las la-piggy-bank'),
(721, 'las la-ribbon'),
(722, 'las la-seedling'),
(723, 'las la-comment'),
(724, 'las la-comment-alt'),
(725, 'las la-comment-dots'),
(726, 'las la-comment-medical'),
(727, 'las la-comment-slash'),
(728, 'las la-comments'),
(729, 'las la-frown'),
(730, 'las la-icons'),
(731, 'las la-meh'),
(732, 'las la-phone-alt'),
(733, 'las la-phone-alt'),
(734, 'las la-quote-left'),
(735, 'las la-quote-right'),
(736, 'las la-smile'),
(737, 'las la-sms'),
(738, 'las la-video'),
(739, 'las la-video-slash'),
(740, 'las la-chess'),
(741, 'las la-chess-bishop'),
(742, 'las la-chess-board'),
(743, 'las la-chess-king'),
(744, 'las la-chess-knight'),
(745, 'las la-chess-pawn'),
(746, 'las la-chess-queen'),
(747, 'las la-chess-rook'),
(748, 'las la-square-full'),
(749, 'las la-baby'),
(750, 'las la-baby-carriage'),
(751, 'las la-bath'),
(752, 'las la-biking'),
(753, 'las la-birthday-cake'),
(754, 'las la-cookie'),
(755, 'las la-cookie-bite'),
(756, 'las la-gamepad'),
(757, 'las la-ice-cream'),
(758, 'las la-mitten'),
(759, 'las la-robot'),
(760, 'las la-school'),
(761, 'las la-shapes'),
(762, 'las la-snowman'),
(763, 'las la-graduation-cap'),
(764, 'las la-hat-cowboy'),
(765, 'las la-hat-cowboy-side'),
(766, 'las la-hat-wizard'),
(767, 'las la-mitten'),
(768, 'las la-shoe-prints'),
(769, 'las la-tshirt'),
(770, 'las la-user-tie'),
(771, 'las la-barcode'),
(772, 'las la-bug'),
(773, 'las la-code'),
(774, 'las la-code-branch'),
(775, 'las la-file-alt'),
(776, 'las la-file-code'),
(777, 'las la-filter'),
(778, 'las la-fire-extinguisher'),
(779, 'las la-keyboard'),
(780, 'las la-laptop-code'),
(781, 'las la-microchip'),
(782, 'las la-project-diagram'),
(783, 'las la-qrcode'),
(784, 'las la-shield-alt'),
(785, 'las la-sitemap'),
(786, 'las la-terminal'),
(787, 'las la-user-secret'),
(788, 'las la-window-close'),
(789, 'las la-window-maximize'),
(790, 'las la-window-minimize'),
(791, 'las la-window-restore'),
(792, 'las la-address-book'),
(793, 'las la-address-card'),
(794, 'las la-american-sign-language-interpreting'),
(795, 'las la-assistive-listening-systems'),
(796, 'las la-at'),
(797, 'las la-bell'),
(798, 'las la-bell-slash'),
(799, 'lab la-bluetooth'),
(800, 'lab la-bluetooth-b'),
(801, 'las la-broadcast-tower'),
(802, 'las la-bullhorn'),
(803, 'las la-chalkboard'),
(804, 'las la-comments'),
(805, 'las la-envelope-square'),
(806, 'las la-fax'),
(807, 'las la-inbox'),
(808, 'las lala-language'),
(809, 'las la-mobile'),
(810, 'las la-paper-plane'),
(811, 'las la-phone-square'),
(812, 'las la-phone-square-alt'),
(813, 'las la-voicemail'),
(814, 'las la-wifi'),
(815, 'las la-database'),
(816, 'las la-ethernet'),
(817, 'las la-hdd'),
(818, 'las la-keyboard'),
(819, 'las la-memory'),
(820, 'las la-mouse'),
(821, 'las la-plug'),
(822, 'las la-power-off'),
(823, 'las la-print'),
(824, 'las la-satellite'),
(825, 'las la-satellite-dish'),
(826, 'las la-save'),
(827, 'las la-sd-card'),
(828, 'las la-server'),
(829, 'las la-sim-card'),
(830, 'las la-tablet'),
(831, 'las la-brush'),
(832, 'las la-drafting-compass'),
(833, 'las la-dumpster'),
(834, 'las la-hammer'),
(835, 'las la-hard-hat'),
(836, 'las la-paint-roller'),
(837, 'las la-pencil-alt'),
(838, 'las la-pencil-ruler'),
(839, 'las la-ruler'),
(840, 'las la-ruler-combined'),
(841, 'las la-ruler-horizontal'),
(842, 'las la-ruler-vertical'),
(843, 'las la-screwdriver'),
(844, 'las la-toolbox'),
(845, 'las la-tools'),
(846, 'las la-truck-pickup'),
(847, 'las la-wrench'),
(848, 'lab la-bitcoin'),
(849, 'las la-dollar-sign'),
(850, 'lab la-ethereum'),
(851, 'las la-euro-sign'),
(852, 'lab la-gg'),
(853, 'lab la-gg-circle'),
(854, 'las la-hryvnia'),
(855, 'las la-lira-sign'),
(856, 'las la-money-bill'),
(857, 'las la-money-bill-alt'),
(858, 'las la-money-bill-wave'),
(859, 'las la-money-bill-wave-alt'),
(860, 'las la-money-check'),
(861, 'las la-money-check-alt'),
(862, 'las la-pound-sign'),
(863, 'las la-ruble-sign'),
(864, 'las la-rupee-sign'),
(865, 'las la-shekel-sign'),
(866, 'las la-won-sign'),
(867, 'las la-yen-sign'),
(868, 'las la-calendar'),
(869, 'las la-calendar-check'),
(870, 'las la-calendar-minus'),
(871, 'las la-calendar-plus'),
(872, 'las la-calendar-times'),
(873, 'las la-clock'),
(874, 'las la-hourglass'),
(875, 'las la-hourglass-end'),
(876, 'las la-hourglass-half'),
(877, 'las la-hourglass-start'),
(878, 'las la-stopwatch'),
(879, 'las la-adjust'),
(880, 'las la-bezier-curve'),
(881, 'las la-brush'),
(882, 'las la-clone'),
(883, 'las la-crop'),
(884, 'las la-crop-alt'),
(885, 'las la-crosshairs'),
(886, 'las la-cut'),
(887, 'las la-drafting-compass'),
(888, 'las la-draw-polygon'),
(889, 'las la-edit'),
(890, 'las la-eraser'),
(891, 'las la-eye'),
(892, 'las la-eye-dropper'),
(893, 'las la-eye-slash'),
(894, 'las la-fill'),
(895, 'las la-fill-drip'),
(896, 'las la-highlighter'),
(897, 'las la-icons'),
(898, 'las la-layer-group'),
(899, 'las la-magic'),
(900, 'las la-object-group'),
(901, 'las la-object-ungroup'),
(902, 'las la-paint-brush'),
(903, 'las la-paint-roller'),
(904, 'las la-palette'),
(905, 'las la-pen'),
(906, 'las la-pen-alt'),
(907, 'las la-pen-fancy'),
(908, 'las la-pen-nib'),
(909, 'las la-pencil-alt'),
(910, 'las la-pencil-ruler'),
(911, 'las la-splotch'),
(912, 'las la-spray-can'),
(913, 'las la-stamp'),
(914, 'las la-swatchbook'),
(915, 'las la-tint'),
(916, 'las la-tint-slash'),
(917, 'las la-vector-square'),
(918, 'las la-align-center'),
(919, 'las la-align-justify'),
(920, 'las la-align-left'),
(921, 'las la-align-right'),
(922, 'las la-bold'),
(923, 'las la-border-all'),
(924, 'las la-border-none'),
(925, 'las la-border-style'),
(926, 'las la-columns'),
(927, 'las la-font'),
(928, 'las la-glasses'),
(929, 'las la-heading'),
(930, 'las la-i-cursor'),
(931, 'las la-indent'),
(932, 'las la-italic'),
(933, 'las la-link'),
(934, 'las la-list'),
(935, 'las la-list-alt'),
(936, 'las la-list-ol'),
(937, 'las la-outdent'),
(938, 'las la-paperclip'),
(939, 'las la-paper-plane'),
(940, 'las la-paragraph'),
(941, 'las la-quote-left'),
(942, 'las la-quote-right'),
(943, 'las la-remove-format'),
(944, 'las la-spell-check'),
(945, 'las la-strikethrough'),
(946, 'las la-subscript'),
(947, 'las la-superscript'),
(948, 'las la-sync'),
(949, 'las la-table'),
(950, 'las la-text-height'),
(951, 'las la-text-width'),
(952, 'las la-th-list'),
(953, 'las la-trash'),
(954, 'las la-trash-alt'),
(955, 'las la-trash-restore'),
(956, 'las la-trash-restore-alt'),
(957, 'las la-underline'),
(958, 'las la-unlink'),
(959, 'las la-atom'),
(960, 'las la-award'),
(961, 'las la-book-open'),
(962, 'las la-book-reader'),
(963, 'las la-chalkboard'),
(964, 'las la-chalkboard-teacher'),
(965, 'las la-graduation-cap'),
(966, 'las la-laptop-code'),
(967, 'las la-microscope'),
(968, 'las la-shapes'),
(969, 'las la-theater-masks'),
(970, 'las la-user-graduate'),
(971, 'las la-angry'),
(972, 'las la-dizzy'),
(973, 'las la-flushed'),
(974, 'las la-flushed'),
(975, 'las la-frown-open'),
(976, 'las la-grimace'),
(977, 'las la-grin'),
(978, 'las la-grin-alt'),
(979, 'las la-grin-beam'),
(980, 'las la-grin-beam-sweat'),
(981, 'las la-grin-hearts'),
(982, 'las la-grin-squint'),
(983, 'las la-grin-squint-tears'),
(984, 'las la-grin-stars'),
(985, 'las la-grin-tears'),
(986, 'las la-grin-tongue'),
(987, 'las la-grin-tongue-squint'),
(988, 'las la-grin-tongue-wink'),
(989, 'las la-grin-wink'),
(990, 'las la-kiss'),
(991, 'las la-kiss-beam'),
(992, 'las la-kiss-wink-heart'),
(993, 'las la-laugh'),
(994, 'las la-laugh-wink'),
(995, 'las la-meh-blank'),
(996, 'las la-meh-rolling-eyes'),
(997, 'las la-sad-cry'),
(998, 'las la-sad-tear'),
(999, 'las la-smile'),
(1000, 'las la-smile-beam'),
(1001, 'las la-surprise'),
(1002, 'las la-tired'),
(1003, 'las la-atom'),
(1004, 'las la-battery-empty'),
(1005, 'las la-battery-full'),
(1006, 'las la-battery-half'),
(1007, 'las la-battery-quarter'),
(1008, 'las la-battery-three-quarters'),
(1009, 'las la-broadcast-tower'),
(1010, 'las la-burn'),
(1011, 'las la-industry'),
(1012, 'las la-lightbulb'),
(1013, 'las la-plug'),
(1014, 'las la-poop'),
(1015, 'las la-power-off'),
(1016, 'las la-seedling'),
(1017, 'las la-radiation'),
(1018, 'las la-solar-panel'),
(1019, 'las la-sun'),
(1020, 'las la-water'),
(1021, 'las la-wind');

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
-- Table structure for table `nodupes`
--

CREATE TABLE `nodupes` (
  `ids_hash` char(64) NOT NULL,
  `time` bigint(20) UNSIGNED NOT NULL
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
  `receipt_date` int(11) UNSIGNED DEFAULT NULL,
  `method_code` varchar(20) NOT NULL,
  `payment_method` tinyint(1) UNSIGNED NOT NULL,
  `payment_title` text NOT NULL,
  `payment_status` tinyint(1) NOT NULL,
  `coupon_code` varchar(20) NOT NULL,
  `coupon_title` varchar(300) NOT NULL,
  `coupon_amount` varchar(20) NOT NULL,
  `send_status` int(10) UNSIGNED NOT NULL,
  `amount` varchar(20) NOT NULL,
  `discount_price` varchar(20) NOT NULL,
  `final_price` varchar(20) NOT NULL,
  `shipping_price` varchar(20) NOT NULL,
  `receiver_name` varchar(100) NOT NULL,
  `receiver_phone` varchar(11) NOT NULL,
  `province` varchar(50) NOT NULL,
  `city` varchar(50) NOT NULL,
  `postal_code` varchar(10) NOT NULL,
  `address` text NOT NULL,
  `got_reward` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
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

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `name`) VALUES
(1, 'setting');

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
  `slug` varchar(300) NOT NULL,
  `image` text NOT NULL,
  `city_id` int(10) UNSIGNED NOT NULL,
  `place` varchar(50) NOT NULL,
  `category_id` int(10) UNSIGNED NOT NULL,
  `price` varchar(20) NOT NULL,
  `discount_price` bigint(20) UNSIGNED NOT NULL,
  `discount_until` int(11) UNSIGNED NOT NULL,
  `reward` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `product_type` tinyint(1) UNSIGNED NOT NULL,
  `description` text NOT NULL,
  `keywords` text NOT NULL,
  `properties` text NOT NULL,
  `related` text NOT NULL,
  `stock_count` int(10) UNSIGNED NOT NULL,
  `max_cart_count` int(10) UNSIGNED NOT NULL DEFAULT '20',
  `sold_count` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `is_special` tinyint(1) UNSIGNED NOT NULL,
  `publish` tinyint(1) UNSIGNED NOT NULL DEFAULT '1',
  `available` tinyint(1) UNSIGNED NOT NULL DEFAULT '1',
  `view_count` bigint(20) UNSIGNED NOT NULL DEFAULT '0',
  `created_by` int(10) UNSIGNED NOT NULL,
  `updated_by` int(10) UNSIGNED DEFAULT NULL,
  `created_at` int(11) UNSIGNED NOT NULL,
  `updated_at` int(11) UNSIGNED DEFAULT NULL,
  `delete` tinyint(1) UNSIGNED NOT NULL DEFAULT '0'
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
  `delete` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

--
-- Dumping data for table `provinces`
--

INSERT INTO `provinces` (`id`, `name`, `delete`) VALUES
(1, 'آذربایجان شرقی', 0),
(2, 'آذربایجان غربی', 0),
(3, 'اردبیل', 0),
(4, 'اصفهان', 0),
(5, 'البرز', 0),
(6, 'ایلام', 0),
(7, 'بوشهر', 0),
(8, 'تهران', 0),
(9, 'چهارمحال بختیاری', 0),
(10, 'خراسان جنوبی', 0),
(11, 'خراسان رضوی', 0),
(12, 'خراسان شمالی', 0),
(13, 'خوزستان', 0),
(14, 'زنجان', 0),
(15, 'سمنان', 0),
(16, 'سیستان و بلوچستان', 0),
(17, 'فارس', 0),
(18, 'قزوین', 0),
(19, 'قم', 0),
(20, 'کردستان', 0),
(21, 'کرمان', 0),
(22, 'کرمانشاه', 0),
(23, 'کهکیلویه و بویراحمد', 0),
(24, 'گلستان', 0),
(25, 'گیلان', 0),
(26, 'لرستان', 0),
(27, 'مازندران', 0),
(28, 'مرکزی', 0),
(29, 'هرمزگان', 0),
(30, 'همدان', 0),
(31, 'یزد', 0);

-- --------------------------------------------------------

--
-- Table structure for table `return_order`
--

CREATE TABLE `return_order` (
  `id` int(10) UNSIGNED NOT NULL,
  `order_code` varchar(20) NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `description` text NOT NULL,
  `respond` text NOT NULL,
  `status` tinyint(1) UNSIGNED NOT NULL,
  `is_closed` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `respond_at` int(11) UNSIGNED DEFAULT NULL,
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
(1, 'superUser', 'کاربر ویژه'),
(2, 'admin', 'ادمین'),
(3, 'writer', 'نویسنده'),
(4, 'marketer', 'بازاریاب'),
(5, 'user', 'کاربر'),
(6, 'guest', 'مهمان');

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

--
-- Dumping data for table `roles_pages_perms`
--

INSERT INTO `roles_pages_perms` (`id`, `role_id`, `page_id`, `perm_id`) VALUES
(1, 1, 1, 1),
(2, 1, 1, 2),
(3, 1, 1, 3),
(4, 1, 1, 4),
(5, 2, 1, 1),
(6, 2, 1, 2),
(7, 2, 1, 3),
(8, 2, 1, 4);

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
(3, 'خروج از انبار', 'bg-info', 4),
(4, 'تحویل به پست', 'bg-purple', 5),
(5, 'تایید نشده', 'bg-danger', 2),
(6, 'تحویل به مشتری', 'bg-primary', 6),
(7, 'آماده سازی سفارش', 'bg-success', 3),
(8, 'لغو شده', 'bg-danger', 8),
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
  `created_by` int(10) UNSIGNED NOT NULL,
  `updated_by` int(10) UNSIGNED NOT NULL,
  `created_at` int(11) UNSIGNED NOT NULL,
  `updated_at` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_code` varchar(10) DEFAULT NULL,
  `subset_of` varchar(8) DEFAULT NULL,
  `mobile` varchar(11) NOT NULL,
  `password` varchar(128) NOT NULL,
  `first_name` varchar(30) NOT NULL,
  `last_name` varchar(30) NOT NULL,
  `n_code` varchar(10) NOT NULL,
  `province` varchar(50) NOT NULL,
  `city` varchar(50) NOT NULL,
  `address` text NOT NULL,
  `postal_code` varchar(10) NOT NULL,
  `image` varchar(100) NOT NULL,
  `credit_card_number` varchar(16) NOT NULL,
  `father_name` varchar(30) NOT NULL,
  `gender` tinyint(1) UNSIGNED DEFAULT NULL,
  `military_status` tinyint(1) UNSIGNED DEFAULT NULL,
  `birth_certificate_code` varchar(10) NOT NULL,
  `birth_certificate_code_place` varchar(30) NOT NULL,
  `birth_date` int(11) UNSIGNED DEFAULT NULL,
  `question1` text NOT NULL,
  `question2` text NOT NULL,
  `question3` text NOT NULL,
  `question4` text NOT NULL,
  `question5` text NOT NULL,
  `question6` text NOT NULL,
  `question7` text NOT NULL,
  `description` text NOT NULL,
  `is_in_team` tinyint(1) UNSIGNED NOT NULL,
  `flag_marketer_request` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `flag_info` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `active` tinyint(1) DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `activation_code` varchar(255) DEFAULT NULL,
  `activation_code_time` int(11) UNSIGNED DEFAULT NULL,
  `forgotten_password_code` varchar(255) DEFAULT NULL,
  `forgotten_password_time` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `user_code`, `subset_of`, `mobile`, `password`, `first_name`, `last_name`, `n_code`, `province`, `city`, `address`, `postal_code`, `image`, `credit_card_number`, `father_name`, `gender`, `military_status`, `birth_certificate_code`, `birth_certificate_code_place`, `birth_date`, `question1`, `question2`, `question3`, `question4`, `question5`, `question6`, `question7`, `description`, `is_in_team`, `flag_marketer_request`, `flag_info`, `active`, `ip_address`, `activation_code`, `activation_code_time`, `forgotten_password_code`, `forgotten_password_time`, `created_at`) VALUES
(1, 'U-1000001', NULL, '09139518055', '$2y$10$SJJmXLT3/IlhEi3WBXPB0OBSprsz61BKeioRnPMN62gNQb5ZkIzTq', 'سعید', 'گرامی فر', '4420440392', '', '', '', '', 'public/fe/images/user-default.jpg', '', '', NULL, NULL, '', '', NULL, '', '', '', '', '', '', '', '', 0, 0, 0, 1, '::1', NULL, NULL, NULL, NULL, 1584977257),
(4, 'U-1000002', '-1', '09179516271', '$2y$10$j7/CmRVsqtSPAcBc/P3goe0JPX9G8EuTjWTnQztOc6Nu9uvls9soG', 'محمد مهدی', 'دهقان', '', 'فارس', 'آباده', '', '', 'public/uploads/users/profileImages/09179516271.jpg', '', '', 0, 0, '', '', 1586621880, '', '', '', '', '', '', '', '', 0, 0, 0, 1, '::1', '', 1586533029, NULL, NULL, 1586533029);

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
(1, 1, 1),
(2, 1, 4),
(5, 4, 5);

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
-- Table structure for table `user_accounts_buy`
--

CREATE TABLE `user_accounts_buy` (
  `id` int(10) UNSIGNED NOT NULL,
  `order_code` varchar(20) NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `price` bigint(20) UNSIGNED NOT NULL,
  `payment_date` int(11) UNSIGNED NOT NULL
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
-- Indexes for table `coupons`
--
ALTER TABLE `coupons`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `coupon_code` (`coupon_code`);

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
  ADD KEY `fk_idpay_factors` (`order_code`);

--
-- Indexes for table `gateway_mabna`
--
ALTER TABLE `gateway_mabna`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_mabna_factors` (`order_code`);

--
-- Indexes for table `gateway_zarinpal`
--
ALTER TABLE `gateway_zarinpal`
  ADD PRIMARY KEY (`authority`),
  ADD KEY `fk_zarinpal_factors` (`order_code`);

--
-- Indexes for table `hits`
--
ALTER TABLE `hits`
  ADD PRIMARY KEY (`pageid`,`isunique`),
  ADD KEY `pageid` (`pageid`);

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
-- Indexes for table `nodupes`
--
ALTER TABLE `nodupes`
  ADD PRIMARY KEY (`ids_hash`);

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
-- Indexes for table `user_accounts_buy`
--
ALTER TABLE `user_accounts_buy`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_account_deposit`
--
ALTER TABLE `user_account_deposit`
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
-- AUTO_INCREMENT for table `coupons`
--
ALTER TABLE `coupons`
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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1022;

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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users_pages_perms`
--
ALTER TABLE `users_pages_perms`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users_roles`
--
ALTER TABLE `users_roles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `user_accounts`
--
ALTER TABLE `user_accounts`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_accounts_buy`
--
ALTER TABLE `user_accounts_buy`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_account_deposit`
--
ALTER TABLE `user_account_deposit`
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
