-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Nov 02, 2025 at 05:49 AM
-- Server version: 5.7.40
-- PHP Version: 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `metalcraft_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_users`
--

DROP TABLE IF EXISTS `admin_users`;
CREATE TABLE IF NOT EXISTS `admin_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(150) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `footer_settings`
--

DROP TABLE IF EXISTS `footer_settings`;
CREATE TABLE IF NOT EXISTS `footer_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company_name` varchar(255) DEFAULT NULL,
  `description` text,
  `address` text,
  `phone1` varchar(50) DEFAULT NULL,
  `phone2` varchar(50) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `facebook` varchar(255) DEFAULT NULL,
  `linkedin` varchar(255) DEFAULT NULL,
  `instagram` varchar(255) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `footer_settings`
--

INSERT INTO `footer_settings` (`id`, `company_name`, `description`, `address`, `phone1`, `phone2`, `email`, `facebook`, `linkedin`, `instagram`, `updated_at`) VALUES
(1, 'Kanchava Brass Components', 'Precision metal components for industries that demand excellence since 1991.', 'ShivamPark 4 Plotno.7/3 Dared, Jamnagar, Gujarat, India', '+91 9428051768', '+91 8488951635', 'kanchavabrasscomponents@gmail.com', 'http://facebook.com/people/Mital-Engineering/100075935785838/?mibextid=ZbWKwL', 'https://www.linkedin.com/in/mital-engineering/', 'https://www.instagram.com/mital.engineering/#', '2025-10-28 15:18:00');

-- --------------------------------------------------------

--
-- Table structure for table `industries`
--

DROP TABLE IF EXISTS `industries`;
CREATE TABLE IF NOT EXISTS `industries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `description` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `industries`
--

INSERT INTO `industries` (`id`, `name`, `icon`, `description`, `created_at`) VALUES
(1, 'Automotive', 'truck', 'Components for automotive industry', '2025-10-14 12:27:45'),
(2, 'Electrical', 'zap', 'Electrical connectors and fittings', '2025-10-14 12:27:45'),
(3, 'Sanitary', 'droplet', 'Plumbing and sanitary fittings', '2025-10-14 12:27:45'),
(10, 'Solar', 'sun', 'Precision mounting and conductive components for solar panel systems.', '2025-10-28 10:19:49'),
(6, 'HVAC', 'wind', 'Precision-engineered components for HVAC systems ensuring optimal heating, cooling, and air flow efficiency.', '2025-10-27 09:57:17'),
(8, 'Electronics', 'cpu', 'Precision components for electronic devices and systems', '2025-10-27 12:55:56'),
(9, 'Agriculture', 'sun', 'Durable metal parts and fittings for agricultural machinery', '2025-10-27 12:55:56');

-- --------------------------------------------------------

--
-- Table structure for table `inquiries`
--

DROP TABLE IF EXISTS `inquiries`;
CREATE TABLE IF NOT EXISTS `inquiries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `message` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `product_id` (`product_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `materials`
--

DROP TABLE IF EXISTS `materials`;
CREATE TABLE IF NOT EXISTS `materials` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `description` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `materials`
--

INSERT INTO `materials` (`id`, `name`, `icon`, `description`, `created_at`) VALUES
(1, 'Brass', 'hexagon', 'High-quality brass material used for precision components', '2025-10-14 12:27:45'),
(2, 'Copper', 'activity', 'Pure copper for electrical applications', '2025-10-14 12:27:45'),
(3, 'Aluminum', 'feather', 'Lightweight metal used in general engineering', '2025-10-14 12:27:45'),
(4, 'Stainless Steel', 'tool', 'High-strength metal for demanding applications.', '2025-10-15 05:04:42'),
(5, 'Mild Steel', 'shield', 'Strong metal used in general engineering.', '2025-10-15 10:14:00');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  `description` text,
  `image_url` varchar(255) DEFAULT NULL,
  `material_id` int(10) UNSIGNED DEFAULT NULL,
  `industry_id` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `material_id` (`material_id`),
  KEY `industry_id` (`industry_id`)
) ENGINE=MyISAM AUTO_INCREMENT=57 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `image_url`, `material_id`, `industry_id`, `created_at`) VALUES
(35, 'Modern Brass Chrome Angle Valve', 'High-quality, lead-free brass construction with a polished chrome finish, offering both aesthetic appeal and robust performance. Ideal for contemporary bathroom and kitchen installations.', 'uploads/1761651172_Gemini_Generated_Image_peb2cwpeb2cwpeb2.png', 1, 3, '2025-10-28 11:32:52'),
(28, 'Premium Quality Brass Couplers and Spacers', 'A set of heavy-duty brass fittings, featuring an external hex for easy installation. Essential components for extending pipe length or connecting different female threads.', 'uploads/1761648739_Gemini_Generated_Image_3mp8ts3mp8ts3mp8.png', 1, 9, '2025-10-28 10:52:19'),
(3, 'Brass Valve', 'Precision-engineered brass valve for fluid control.', 'uploads/1760504385_619ycPhnzRL.png', 1, 3, '2025-10-14 16:54:15'),
(4, 'Stainless Steel Nut & Bolt Set', 'Set of stainless steel nuts and bolts for aerospace applications.', 'uploads/1760504610_fb725d26-01c5-429d-9610-81f4a4e3444a.png', 4, 2, '2025-10-14 16:54:15'),
(8, 'Brass Elbow', 'Brass Elbow ', 'uploads/1760509917_forged-brass-tee-500x500-250x250.png', 1, 3, '2025-10-15 05:14:21'),
(9, 'Brass Bush ', 'High Precision Brass Bush for automotive industries', 'uploads/1760510743_WhatsApp Image 2025-10-15 at 12.12.27 PM.jpeg', 1, 1, '2025-10-15 06:45:43'),
(10, 'Brass Valve', 'Precision Brass Valve for the Gas  industries  ', 'uploads/1761559217_WhatsApp Image 2025-10-15 at 12.02.56 PM.jpeg', 1, 6, '2025-10-27 10:00:17'),
(11, 'Brass Fitting part', 'High Precision sanitary parts', 'uploads/1761642540_WhatsApp Image 2025-10-27 at 8.17.49 PM.jpeg', 1, 3, '2025-10-28 09:09:00'),
(12, 'SS Valves ', 'Precision Stainless Steel valves with the Assembly', 'uploads/1761642699_WhatsApp Image 2025-10-27 at 8.32.17 PM.jpeg', 4, 3, '2025-10-28 09:11:39'),
(13, 'Brass Regulator  Spindle  ', 'High Precision Brass Regulator Spindle for the HAVC Industry', 'uploads/1761643691_WhatsApp Image 2025-10-27 at 8.18.04 PM.jpeg', 1, 6, '2025-10-28 09:28:11'),
(14, 'SS Components', 'High precision SS Components for Sanitary industry', 'uploads/1761643834_WhatsApp Image 2025-10-27 at 8.19.26 PM.jpeg', 4, 3, '2025-10-28 09:30:34'),
(29, 'Solid Brass Plumbing Spacers with Hex Head', 'Versatile brass component for various liquid system applications, featuring both internal and external threading for maximum compatibility and ease of installation.', 'uploads/1761648918_Gemini_Generated_Image_muw9aqmuw9aqmuw9.png', 1, 3, '2025-10-28 10:55:18'),
(16, 'Precision Brass Componennts', 'High Precision Brass Components of Various types', 'uploads/1761644018_WhatsApp Image 2025-10-27 at 8.19.39 PM.jpeg', 1, 0, '2025-10-28 09:33:38'),
(17, 'Precision Engineered Copper  Shaft', 'High precision Copper Shaft for the Automotive Industries ', 'uploads/1761644371_Gemini_Generated_Image_jkcr74jkcr74jkcr.png', 2, 1, '2025-10-28 09:39:31'),
(18, 'Assortment of Brass Plumbing Fittings', 'gleaming brass sanitary and plumbing fittings, including valves, elbows, connectors, and reducers', 'uploads/1761644633_Gemini_Generated_Image_7udw1j7udw1j7udw.png', 1, 3, '2025-10-28 09:43:53'),
(19, 'Assorted Brass Threaded Inserts for Molding', ': A wide array of small, intricate brass threaded inserts in various knurled and grooved patterns, designed for heat-set or press-fit applications , displayed on a white surface', 'uploads/1761644778_WhatsApp Image 2025-10-27 at 8.12.39 PM (1).jpeg', 1, 1, '2025-10-28 09:46:18'),
(20, 'Precision Brass Flow Control Nozzles', 'Distinct brass components, one a conical nozzle with multiple perforations and the other a cylindrical adaptor with dual orifices', 'uploads/1761645173_Gemini_Generated_Image_48uo3h48uo3h48uo.png', 1, 1, '2025-10-28 09:52:53'),
(21, 'Machined Brass Rods and Connectors', 'A set of four highly polished brass componentsâ€”two cylindrical rods and two threaded connectors', 'uploads/1761645357_Gemini_Generated_Image_v7yjspv7yjspv7yj.png', 1, 6, '2025-10-28 09:55:57'),
(22, 'Precision Brass and Metal Hex Nuts Assortment', 'A various sizes and types of precision hex nuts and compression caps, showcasing the quality of brass and chrome-plated machining', 'uploads/1761645592_WhatsApp Image 2025-10-15 at 12.15.33 PM.jpeg', 1, 1, '2025-10-28 09:59:52'),
(24, 'Solar Panel Mounting Essentials', 'Aluminum L-brackets, mid/end clamps (T-slot nuts), and stainless steel bolts essential for securing solar panels on a racking system', 'uploads/1761647030_Gemini_Generated_Image_sk7y62sk7y62sk7y.png', 3, 10, '2025-10-28 10:23:50'),
(26, '1.8mm Link Disconnector', 'Precision-engineered component for reliable circuit isolation and protection. Essential for safe electrical maintenance', 'uploads/1761647498_Gemini_Generated_Image_g7i0w3g7i0w3g7i0.png', 0, 2, '2025-10-28 10:31:38'),
(30, 'Brass Water Mixer Valve Cartridge Insert', 'Precision-machined solid brass component designed for high-flow control in faucets and mixing valves. Features a threaded base for secure mounting and drilled ports for water direction.', 'uploads/1761649348_Gemini_Generated_Image_xhjdz7xhjdz7xhjd.png', 1, 3, '2025-10-28 11:02:28'),
(31, 'Universal Brass Male Pipe to Female Swivel Connector', 'A versatile brass adapter providing a secure and flexible connection between different pipe or hose types', 'uploads/1761649559_Gemini_Generated_Image_vlwhbjvlwhbjvlwh.png', 1, 3, '2025-10-28 11:05:59'),
(32, 'Heavy-Duty Brass All-Bush', 'Precision-machined, through-hole brass tube with full external threading. Ideal for use as a structural spacer, extension piece, or conduit in lighting and plumbing assemblies.', 'uploads/1761650243_Gemini_Generated_Image_cf73h4cf73h4cf73.png', 1, 1, '2025-10-28 11:17:23'),
(33, 'Heavy-Duty Power Distribution Bus Bar', 'High-capacity terminal blocks designed for secure and organized electrical connections. Features multiple screw terminals for reliable grounding or neutral distribution in electrical panels', 'uploads/1761650570_Gemini_Generated_Image_mxotu1mxotu1mxot.png', 3, 2, '2025-10-28 11:22:50'),
(34, 'Sintered Bronze/Brass Plain Bushings', 'High-precision, self-lubricating brass/bronze bushings designed for smooth rotational or linear motion. Ideal for reducing friction and wear in various mechanical applications.', 'uploads/1761650838_Gemini_Generated_Image_svs3xmsvs3xmsvs3.png', 1, 9, '2025-10-28 11:27:18'),
(36, 'Brass Insert', 'High precision brass insert for the automotive industries', 'uploads/1761651899_Gemini_Generated_Image_jwkhfkjwkhfkjwkh.png', 1, 9, '2025-10-28 11:44:59'),
(37, 'Lead-Free Brass Male x Female Elbow Connector', 'Durable and corrosion-resistant brass elbow with male (NPT) and female (NPT) threads, ideal for changing direction in plumbing and piping systems at a tight 90-degree angle.', 'uploads/1761652052_Gemini_Generated_Image_26hk6a26hk6a26hk (1).png', 1, 3, '2025-10-28 11:47:32'),
(38, 'Aluminum Metal Moulding Component', 'Precision-engineered aluminum casting designed', 'uploads/1761652209_Gemini_Generated_Image_mlrig8mlrig8mlri.png', 3, 1, '2025-10-28 11:50:09'),
(39, 'Precision Nut Bolt ', 'High-tolerance metal roller component designed for use in heavy-duty machinery, conveyors, or bearing assemblies. Ensures smooth rotation and long service life under high load.', 'uploads/1761657878_Gemini_Generated_Image_9gfkta9gfkta9gfk (1).png', 5, 1, '2025-10-28 13:24:38'),
(40, 'Heavy-Duty Mild Steel Flange-to-Thread Fitting', 'High-quality Mild steel adapter featuring a male NPT threaded end and a flanged (likely Tri-Clamp compatible) end', 'uploads/1761658293_Gemini_Generated_Image_qugxksqugxksqugx.png', 5, 3, '2025-10-28 13:31:33'),
(41, 'High Precision Mild Steel Nipple ', 'High Quality Mild Steel Nipple For the Sanitary Industries ', 'uploads/1761658547_Gemini_Generated_Image_bg2rcobg2rcobg2r.png', 5, 3, '2025-10-28 13:35:47'),
(42, 'High Quality Electronic Component', 'Precision-machined brass component featuring one large input port and multiple smaller threaded output ports', 'uploads/1761659084_Gemini_Generated_Image_4frkk04frkk04frk.png', 1, 8, '2025-10-28 13:44:44'),
(43, 'High Quality Electronic Component', 'Precision-machined brass component featuring one large input port and multiple smaller threaded output ports', 'uploads/1761659154_WhatsApp Image 2025-10-28 at 6.03.01 PM.jpeg', 1, 8, '2025-10-28 13:45:54'),
(44, 'High Quality Electronic Component', 'Precision-machined brass component featuring one large input port ', 'uploads/1761659192_WhatsApp Image 2025-10-28 at 6.03.09 PM.jpeg', 1, 8, '2025-10-28 13:46:32'),
(45, 'High Quality Threaded Insert', 'High Quality Threaded Brass Insert for the Electrical industries \\r\\n', 'uploads/1761659298_WhatsApp Image 2025-10-28 at 6.03.23 PM.jpeg', 1, 2, '2025-10-28 13:48:18'),
(46, 'Earthing and Lightning Protection System Components', 'A collection of copper and brass terminals, clamps, connectors, and a lightning arrestor rod', 'uploads/1761661379_Gemini_Generated_Image_qrra7mqrra7mqrra.png', 1, 2, '2025-10-28 13:54:32'),
(48, 'Brass Electrical Pin and Socket Components', 'A variety of precision-machined brass pins, sleeves, terminals, and contacts used as conductive components within electrical plugs, sockets, and various connectors.', 'uploads/1761659777_WhatsApp Image 2025-10-28 at 6.04.45 PM.jpeg', 1, 2, '2025-10-28 13:56:17'),
(49, 'Machined Brass Threaded Bushing', 'A precision-machined brass fitting featuring external pipe threads (male) and an internal opening, typically used as an adapter to connect components', 'uploads/1761659932_Gemini_Generated_Image_6g5h9f6g5h9f6g5h.png', 1, 6, '2025-10-28 13:58:52'),
(50, 'Brass Compression Fitting Components (Nut and Body)', 'These precision-machined brass parts are used to create a leak-proof seal when joining tubing', 'uploads/1761660132_Gemini_Generated_Image_l427w0l427w0l427.png', 1, 6, '2025-10-28 14:02:12'),
(51, 'Precision Machined Brass Hex Nut', 'A finely crafted brass hex nut, showcasing its smooth finish and internal threading.', 'uploads/1761660341_Gemini_Generated_Image_1k8h4h1k8h4h1k8h.png', 1, 6, '2025-10-28 14:05:41'),
(52, 'Heavy-Duty Brass Hex Coupling Valve', 'A premium, large-diameter brass hex nut engineered for durable, high-pressure coupling applications, highlighting the precise internal thread machining.', 'uploads/1761660459_Gemini_Generated_Image_72lew272lew272le.png', 1, 0, '2025-10-28 14:07:39'),
(53, 'Corrosion-Resistant Brass Pipe Coupling Nut', 'A close-up of a high-quality, large-diameter brass hex nut, emphasizing its precise internal threading and smooth finish for reliable fluid or gas line coupling applications.', 'uploads/1761660547_Gemini_Generated_Image_w3xgg8w3xgg8w3xg.png', 1, 0, '2025-10-28 14:09:07'),
(54, 'Brass Valve Body with Integrated Mounting Bracket', 'A robust brass valve component featuring an angled main body, internal threading, and a convenient side bracket for secure installation, designed for fluid control applications.', 'uploads/1761660831_Gemini_Generated_Image_g8ltobg8ltobg8lt.png', 1, 0, '2025-10-28 14:13:51'),
(55, 'Precision-Machined Brass Hexagonal Insert', 'A durable, medium-gauge brass component with a finely threaded core, ideal for creating strong, corrosion-resistant connections in fittings and assemblies.', 'uploads/1761661166_Gemini_Generated_Image_dfcznvdfcznvdfcz.png', 1, 6, '2025-10-28 14:19:26'),
(56, 'Assorted Switch-Mode Power Supplies (SMPS) and Chargers', 'A collection of compact, high-efficiency switch-mode power supplies and chargers from Jupiter, Flawmax, and Voltro, designed to deliver reliable power for diverse electronic applications.', 'uploads/1761661604_Gemini_Generated_Image_nzbd8wnzbd8wnzbd.png', 0, 8, '2025-10-28 14:26:44');

-- --------------------------------------------------------

--
-- Table structure for table `testimonials`
--

DROP TABLE IF EXISTS `testimonials`;
CREATE TABLE IF NOT EXISTS `testimonials` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `quote` text NOT NULL,
  `author` varchar(255) NOT NULL,
  `company` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `testimonials`
--

INSERT INTO `testimonials` (`id`, `quote`, `author`, `company`) VALUES
(1, 'The quality and precision of the components we received were outstanding. Their team was professional and delivered ahead of schedule.', 'Jayveer Sinh', 'proprietor, Mital Engineering');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
