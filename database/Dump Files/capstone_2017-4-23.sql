-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 24-04-2017 a las 02:35:26
-- Versión del servidor: 10.1.21-MariaDB
-- Versión de PHP: 7.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `capstone`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `accountants`
--

DROP TABLE IF EXISTS `accountants`;
CREATE TABLE `accountants` (
  `accountant_id` int(10) UNSIGNED NOT NULL,
  `roles_id` int(10) UNSIGNED NOT NULL,
  `user_info_id` char(255) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `accountants`
--

INSERT INTO `accountants` (`accountant_id`, `roles_id`, `user_info_id`) VALUES
(3, 2, '11'),
(4, 2, '7'),
(5, 2, '3'),
(6, 2, '12');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `accountants_timestamps`
--

DROP TABLE IF EXISTS `accountants_timestamps`;
CREATE TABLE `accountants_timestamps` (
  `at_id` int(11) UNSIGNED NOT NULL,
  `role` varchar(20) NOT NULL DEFAULT 'Accountant',
  `action` varchar(20) NOT NULL DEFAULT '',
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `transaction_id` int(11) UNSIGNED DEFAULT NULL,
  `accountant_id` int(11) UNSIGNED DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `accountants_timestamps`
--

INSERT INTO `accountants_timestamps` (`at_id`, `role`, `action`, `timestamp`, `transaction_id`, `accountant_id`, `name`) VALUES
(4, 'Accountant', 'approve', '2017-04-13 17:27:36', 2, 3, 'Joan Ortiz'),
(5, 'Accountant', 'Assigned Transaction', '2017-04-23 23:00:45', 6, 3, 'Joan Ortiz');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comments`
--

DROP TABLE IF EXISTS `comments`;
CREATE TABLE `comments` (
  `comment_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `body_of_comment` varchar(255) CHARACTER SET utf8 NOT NULL,
  `transaction_id` int(10) UNSIGNED NOT NULL,
  `accountant_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `comments`
--

INSERT INTO `comments` (`comment_id`, `created_at`, `updated_at`, `body_of_comment`, `transaction_id`, `accountant_id`) VALUES
(1, '2017-03-02 04:00:00', '2017-03-02 04:00:00', 'Not justified', 2, 3),
(2, '2017-03-02 04:00:00', '2017-03-02 04:00:00', 'Items cannot be approved', 2, 3),
(3, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Hola', 2, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `credit_card`
--

DROP TABLE IF EXISTS `credit_card`;
CREATE TABLE `credit_card` (
  `cc_id` int(10) UNSIGNED NOT NULL,
  `credit_card_number` varchar(16) NOT NULL,
  `name_on_card` varchar(20) NOT NULL,
  `researcher_id` int(10) UNSIGNED NOT NULL,
  `expiration_date` date NOT NULL,
  `is_active` tinyint(4) DEFAULT NULL,
  `reason` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `credit_card`
--

INSERT INTO `credit_card` (`cc_id`, `credit_card_number`, `name_on_card`, `researcher_id`, `expiration_date`, `is_active`, `reason`) VALUES
(1, '1001', 'Jose Perez', 1, '2017-03-01', 0, NULL),
(2, '1002', 'Luis Negron', 2, '2017-03-07', 1, NULL),
(3, '1003', 'Victor Beltran', 3, '2017-03-06', 1, NULL),
(4, '1004', 'Maria Rolon', 4, '2017-03-18', 1, NULL),
(5, '1005', 'Juan Ortega', 5, '2017-03-17', 1, NULL),
(6, '1006', 'Coral Suazo', 6, '2017-03-24', 1, NULL),
(7, '1007', 'Christian Rivera', 7, '2017-03-17', 1, NULL),
(8, '1008', 'Luz Calderon', 8, '2017-03-09', 1, NULL),
(9, '1009', 'Michelle Velez', 9, '2017-03-18', 1, NULL),
(10, '1010', 'Jose Perez', 1, '2016-04-13', 0, NULL),
(11, '4549635936541236', 'Jose Perez', 1, '2017-04-11', 1, 'because yes');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `images`
--

DROP TABLE IF EXISTS `images`;
CREATE TABLE `images` (
  `image_id` bigint(20) NOT NULL,
  `image_path` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `images`
--

INSERT INTO `images` (`image_id`, `image_path`) VALUES
(1, '?PNG\r\n\Z\n\0\0\0\rIHDR\0\0?\0\0?\0\0\0:?$?\0\0\0sRGB\0???\0\0\0gAMA\0\0???a\0\0\0	pHYs\0\0?\0\0??o?d\0\0??IDATx^??|T?????[?5W??֫?:???r?녪??W?v	{??+?`n?,6?R?V???T\Z??J!V?q??Ͷ\nۤ??6E,?(?D???1?i6?!????6???d&̄	3	?Lf漞???03g?L?|?g?y?????????(??(??(??(??2??z{{EQEQEQEQEQ?'),
(2, '../../../storage/uploads/ER.PNG'),
(3, '../../../storage/uploads/sladfkj.PNG'),
(4, '../../../storage/uploads/system_arch.PNG'),
(5, '../../../storage/uploads/ER.PNG'),
(6, '../../../storage/uploads/sladfkj.PNG'),
(7, '../../../storage/uploads/system_arch.PNG'),
(8, '../../../storage/uploads/ER.PNG'),
(9, '../../../storage/uploads/sladfkj.PNG'),
(10, '../../../storage/uploads/system_arch.PNG'),
(11, '../../../storage/uploads/ER.PNG'),
(12, '../../../storage/uploads/sladfkj.PNG'),
(13, '../../../storage/uploads/system_arch.PNG');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `items`
--

DROP TABLE IF EXISTS `items`;
CREATE TABLE `items` (
  `item_id` int(10) UNSIGNED NOT NULL,
  `item_name` varchar(255) NOT NULL,
  `item_price` double NOT NULL,
  `quantity` int(11) NOT NULL,
  `transaction_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `items`
--

INSERT INTO `items` (`item_id`, `item_name`, `item_price`, `quantity`, `transaction_id`) VALUES
(1, 'book', 50, 2, 2),
(2, 'markers', 10, 1, 2),
(3, 'BEST ITEM', 25.25, 4483, 2),
(5, 'BEST ITEM', 25.25, 4483, 2),
(6, 'BEST ITEM', 25.25, 4483, 2),
(7, 'MAMA MIA', 5, 52, 29),
(8, 'MAMA MIA', 5, 52, 30);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `items_paid_from`
--

DROP TABLE IF EXISTS `items_paid_from`;
CREATE TABLE `items_paid_from` (
  `ipf_id` int(10) UNSIGNED NOT NULL,
  `ra_id` int(10) UNSIGNED NOT NULL,
  `item_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `items_paid_from`
--

INSERT INTO `items_paid_from` (`ipf_id`, `ra_id`, `item_id`) VALUES
(1, 0, 1),
(2, 1, 2),
(3, 3, 2),
(4, 3, 3),
(10, 2, 6),
(11, 3, 6),
(12, 4, 6),
(13, 5, 6),
(14, 0, 7),
(15, 1, 7),
(16, 23, 7),
(17, 0, 8),
(18, 1, 8),
(19, 23, 8);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2017_03_14_221153_create_roles_table', 1),
(2, '2017_03_14_233115_create_user_info_table', 1),
(3, '2017_03_14_2453602_create_accountant', 1),
(4, '2017_03_15_170126_create_researcher_table', 1),
(5, '2017_03_15_170924_create_credit_card_table', 1),
(6, '2017_03_15_192008_create_research_accounts_table', 1),
(7, '2017_03_15_192943_create_researcher_has_accounts_table', 1),
(8, '2017_03_15_194219_create_transactions_table', 1),
(9, '2017_03_15_200656_create_transaction_info_table', 1),
(10, '2017_03_15_201410_create_items_table', 1),
(11, '2017_03_15_201707_create_items_paid_from_table', 1),
(12, '2017_03_15_202021_create_comments_table', 1),
(13, '2017_03_15_202906_create_notifications_table', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notes`
--

DROP TABLE IF EXISTS `notes`;
CREATE TABLE `notes` (
  `note_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `body_of_note` varchar(255) NOT NULL,
  `accountant_id` int(10) UNSIGNED NOT NULL,
  `transaction_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notifications`
--

DROP TABLE IF EXISTS `notifications`;
CREATE TABLE `notifications` (
  `notification_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `notification_text` varchar(255) NOT NULL,
  `researcher_id` int(10) UNSIGNED NOT NULL,
  `accountant_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `researchers`
--

DROP TABLE IF EXISTS `researchers`;
CREATE TABLE `researchers` (
  `researcher_id` int(10) UNSIGNED NOT NULL,
  `roles_id` int(10) UNSIGNED NOT NULL,
  `user_info_id` char(255) NOT NULL,
  `amex_account_id` varchar(50) NOT NULL,
  `employee_id` varchar(20) NOT NULL,
  `accountant_id` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `researchers`
--

INSERT INTO `researchers` (`researcher_id`, `roles_id`, `user_info_id`, `amex_account_id`, `employee_id`, `accountant_id`) VALUES
(1, 3, '0', '1234', '100', 3),
(2, 3, '1', '4321', '101', 4),
(3, 3, '2', '2345', '102', 5),
(4, 3, '4', '5432', '103', 6),
(5, 3, '5', '3456', '104', 6),
(6, 3, '6', '3787-963022-33009', '105', 5),
(7, 3, '8', '4567', '106', 4),
(8, 3, '9', '7654', '107', 3),
(9, 3, '10', '5678', '108', 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `researchers_timestamps`
--

DROP TABLE IF EXISTS `researchers_timestamps`;
CREATE TABLE `researchers_timestamps` (
  `ct_id` int(11) UNSIGNED NOT NULL,
  `role` varchar(20) NOT NULL DEFAULT 'Researcher',
  `action` varchar(20) NOT NULL DEFAULT '',
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `transaction_id` int(11) UNSIGNED DEFAULT NULL,
  `researcher_id` int(11) UNSIGNED DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `researchers_timestamps`
--

INSERT INTO `researchers_timestamps` (`ct_id`, `role`, `action`, `timestamp`, `transaction_id`, `researcher_id`, `name`) VALUES
(3, 'Researcher', 'edit', '2017-04-13 17:28:06', 2, 1, 'Jose Perez'),
(4, 'Researcher', 'create', '2017-04-13 17:28:12', 2, 1, 'Jose Perez'),
(5, 'Researcher', 'deletion', '2017-04-13 17:28:34', 3, 2, 'Luis Negron');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `researcher_has_accounts`
--

DROP TABLE IF EXISTS `researcher_has_accounts`;
CREATE TABLE `researcher_has_accounts` (
  `rha_id` int(10) UNSIGNED NOT NULL,
  `ra_id` int(10) UNSIGNED NOT NULL,
  `researcher_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `researcher_has_accounts`
--

INSERT INTO `researcher_has_accounts` (`rha_id`, `ra_id`, `researcher_id`) VALUES
(0, 0, 1),
(1, 1, 1),
(2, 2, 2),
(3, 3, 2),
(4, 4, 3),
(5, 5, 3),
(6, 6, 4),
(7, 7, 4),
(8, 8, 5),
(9, 9, 5),
(10, 10, 6),
(11, 11, 6),
(12, 12, 7),
(13, 13, 7),
(14, 14, 8),
(15, 15, 8),
(16, 16, 9),
(17, 17, 9),
(18, 17, 1),
(19, 14, 1),
(31, 23, 1),
(32, 23, 2),
(33, 23, 3),
(34, 23, 4),
(35, 23, 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `researcher_notifications`
--

DROP TABLE IF EXISTS `researcher_notifications`;
CREATE TABLE `researcher_notifications` (
  `rn_id` bigint(20) UNSIGNED NOT NULL,
  `notifiaction_body` varchar(60) NOT NULL,
  `marked_as_read` tinyint(1) UNSIGNED NOT NULL,
  `at_id` int(11) UNSIGNED NOT NULL,
  `researcher_id` int(10) UNSIGNED NOT NULL,
  `transaction_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `research_accounts`
--

DROP TABLE IF EXISTS `research_accounts`;
CREATE TABLE `research_accounts` (
  `ra_id` int(10) UNSIGNED NOT NULL,
  `research_nickname` varchar(255) NOT NULL,
  `ufis_account_number` varchar(255) NOT NULL,
  `frs_account_number` varchar(255) DEFAULT NULL,
  `unofficial_budget` double DEFAULT NULL,
  `budget_remaining` double DEFAULT NULL,
  `principal_investigator` varchar(255) NOT NULL,
  `be_notified` smallint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `research_accounts`
--

INSERT INTO `research_accounts` (`ra_id`, `research_nickname`, `ufis_account_number`, `frs_account_number`, `unofficial_budget`, `budget_remaining`, `principal_investigator`, `be_notified`) VALUES
(0, 'account0', '100', '100', 1000, 1000, 'Jose Perez', 1),
(1, 'account1', '101', '101', 1001, 1001, 'Jose Perez', 1),
(2, 'account2', '102', '102', 1002, 1002, 'Luis Negron', 0),
(3, 'account3', '103', '103', 1003, 1003, 'Luis Negron', 0),
(4, 'account4', '104', '104', 1004, 1004, 'Victor Beltran', 0),
(5, 'account5', '105', '105', 1005, 1005, 'Victor Beltran', 0),
(6, 'account6', '106', '106', 1006, 1006, 'Maria Rolon', 0),
(7, 'account7', '107', '107', 1007, 1007, 'Maria Rolon', 0),
(8, 'account8', '108', '108', 1008, 1008, 'Juan Ortega', 0),
(9, 'account9', '109', '109', 1009, 1009, 'Juan Ortega', 0),
(10, 'account10', '110', '110', 1010, 1010, 'Coral Suazo', 0),
(11, 'account11', '111', '111', 1011, 1011, 'Coral Suazo', 0),
(12, 'account12', '112', '112', 1012, 1012, 'Christian Rivera', 0),
(13, 'account13', '113', '113', 1013, 1013, 'Christian Rivera', 0),
(14, 'account14', '114', '114', 1014, 1014, 'Luz Calderon', 0),
(15, 'account15', '115', '115', 1015, 1015, 'Luz Calderon', 0),
(16, 'account16', '116', '116', 1016, 1016, 'Michelle velez', 0),
(17, 'account17', '117', '117', 1017, 1017, 'Michelle Velez', 0),
(23, 'TI', '065146541', '654654', 4483.5, 505.5, 'Jose Perez', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles` (
  `roles_id` int(10) UNSIGNED NOT NULL,
  `system_roles` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`roles_id`, `system_roles`) VALUES
(1, 'administrator'),
(2, 'accountant'),
(3, 'researcher'),
(4, 'administrator accountant');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `transactions`
--

DROP TABLE IF EXISTS `transactions`;
CREATE TABLE `transactions` (
  `transaction_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` varchar(20) NOT NULL,
  `billing_cycle` date NOT NULL,
  `is_reconciliated` tinyint(1) NOT NULL,
  `researcher_id` int(10) UNSIGNED NOT NULL,
  `accountant_id` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `transactions`
--

INSERT INTO `transactions` (`transaction_id`, `created_at`, `updated_at`, `status`, `billing_cycle`, `is_reconciliated`, `researcher_id`, `accountant_id`) VALUES
(2, '2017-03-02 04:00:00', '2017-03-14 20:00:00', 'approved', '2017-03-22', 0, 1, 4),
(3, '2017-03-02 04:00:00', '2017-03-22 11:00:00', 'approved', '2017-04-18', 1, 6, 4),
(4, '2017-03-02 04:00:00', '2017-03-08 12:00:00', 'approved', '2017-03-01', 1, 6, 3),
(5, '2017-03-18 13:00:00', '2017-03-04 15:00:00', 'in_progress', '2017-03-14', 0, 2, 3),
(6, '2017-03-02 04:00:00', '2017-03-28 07:00:00', 'in progress', '2017-03-03', 0, 2, 3),
(7, '2017-03-02 04:00:00', '2017-03-31 17:00:00', 'denied', '2017-03-21', 0, 1, 3),
(8, '2017-03-02 04:00:00', '2017-03-20 11:00:00', 'escalated', '2017-03-18', 0, 1, 3),
(9, '2017-03-02 04:00:00', '2017-03-25 04:00:00', 'escalated', '2017-03-27', 1, 6, 3),
(10, '2017-03-02 04:00:00', '2017-03-18 16:00:00', 'unathorized charge', '2017-03-03', 1, 6, 5),
(11, '2017-03-02 04:00:00', '2017-03-24 12:00:00', 'unathorized charge', '2017-03-01', 1, 6, 3),
(12, '2017-03-02 04:00:00', '2017-03-23 08:00:00', 'unassigned', '2017-03-11', 0, 1, 6),
(13, '2017-03-02 04:00:00', '2017-03-11 04:00:00', 'unassigned', '2017-03-01', 0, 1, 3),
(18, '2017-04-02 02:56:21', NULL, 'approved', '0000-00-00', 1, 6, 4),
(19, NULL, NULL, 'approved', '0000-00-00', 1, 6, 4),
(20, NULL, NULL, 'approved', '0000-00-00', 1, 6, 4),
(21, NULL, NULL, 'approved', '0000-00-00', 1, 6, 4),
(27, '2017-04-03 04:27:39', NULL, 'in_progress', '0000-00-00', 0, 1, NULL),
(28, '2017-04-03 04:31:38', NULL, 'in_progress', '0000-00-00', 0, 1, NULL),
(29, '2017-04-03 04:32:23', NULL, 'in_progress', '0000-00-00', 0, 1, NULL),
(30, '2017-04-03 04:32:31', NULL, 'in_progress', '0000-00-00', 0, 1, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `transactions_info`
--

DROP TABLE IF EXISTS `transactions_info`;
CREATE TABLE `transactions_info` (
  `tinfo_id` int(10) UNSIGNED NOT NULL,
  `transaction_number` varchar(255) DEFAULT NULL,
  `receipt_number` varchar(255) DEFAULT NULL,
  `receipt_image_path` varchar(255) DEFAULT NULL,
  `date_bought` date NOT NULL,
  `company_name` varchar(255) NOT NULL,
  `description_justification` varchar(255) NOT NULL,
  `total` double NOT NULL,
  `transaction_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `transactions_info`
--

INSERT INTO `transactions_info` (`tinfo_id`, `transaction_number`, `receipt_number`, `receipt_image_path`, `date_bought`, `company_name`, `description_justification`, `total`, `transaction_id`) VALUES
(1, '1234567890', '0987654321', NULL, '2017-03-01', 'Walmart', 'Needed materials for lab.', 50, 2),
(2, '5416545616', '65165654', NULL, '2017-03-17', 'JETBLUE AIRWAYS', 'TESTING PURPOSES', 25, 3),
(3, '123450712', '12301230', NULL, '2017-03-17', 'COMFORT INN', 'Necesitamos comidas para los invitados', 1232.04, 4),
(4, '2567479652', '21854005678', NULL, '2017-03-28', 'Kmart', 'School supplies for tutoring', 300, 5),
(5, '123450712', '12301230', NULL, '2017-03-30', 'Supermercados Econo', 'Necesitamos comidas para los invitados', 500, 6),
(6, '2567479652', '21854005678', NULL, '2017-03-28', 'Kmart', 'School supplies for tutoring', 300, 7),
(7, '25213502678', '236400185', NULL, '2017-03-14', 'Home Depot', 'Needed screws and stuff for construction of project prototype', 20, 8),
(8, '2348943127419', '12318413213', NULL, '2017-03-17', 'COMFORT INN', 'Ordered supplies for project', 1232.04, 9),
(9, '25213502678', '236400185', NULL, '2017-03-03', 'PRAXAIR PR BV', 'Needed screws and stuff for construction of project prototype', 205, 10),
(10, '2348943127419', '12318413213', NULL, '2017-03-06', 'GILMAN CORPORATION', 'Ordered supplies for project', 241.71, 11),
(11, '123840315951464', '5655081807', NULL, '2017-03-27', 'Office Depot', 'Supplies for upcoming prototype', 200, 12),
(12, '326502681', '3900685020', NULL, '2017-03-18', 'Office Max', 'Mouses and keyboards for programming ', 50, 13),
(15, '26258432', '49856151', NULL, '2017-03-13', 'AA PUERTO RICO MCCY USD ANCILLARY', '', 25, 18),
(16, '98546123', '23156489', NULL, '2017-02-23', 'AMAZON.COM LLC', 'SDTGFCVHJ', 35.18, 19),
(17, '89456', '4916', NULL, '2017-02-23', 'AMAZON.COM LLC', 'YES', 51.96, 20),
(18, '98416595', '6365458', NULL, '2017-03-07', 'SMARTSHEET.COM', 'LLEVAMEEEEEE', 99, 21),
(19, '789456', '4561', NULL, '2017-02-03', 'PLEASE', 'miiiiii', 25.25, 27),
(20, '789456', '4561', NULL, '2017-02-03', 'PLEASE', 'miiiiii', 25.25, 28),
(21, '789456', '4561', NULL, '2017-02-03', 'PLEASE', 'miiiiii', 25.25, 29),
(22, '789456', '4561', NULL, '2017-02-03', 'PLEASE', 'miiiiii', 25.25, 30);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `transaction_images`
--

DROP TABLE IF EXISTS `transaction_images`;
CREATE TABLE `transaction_images` (
  `transaction_image_id` bigint(20) NOT NULL,
  `image_id` bigint(20) NOT NULL,
  `tinfo_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `transaction_images`
--

INSERT INTO `transaction_images` (`transaction_image_id`, `image_id`, `tinfo_id`) VALUES
(1, 5, 20),
(2, 6, 20),
(3, 7, 20),
(4, 8, 21),
(5, 9, 21),
(6, 10, 21),
(7, 11, 22),
(8, 12, 22),
(9, 13, 22);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user_info`
--

DROP TABLE IF EXISTS `user_info`;
CREATE TABLE `user_info` (
  `user_info_id` char(36) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `department` varchar(30) NOT NULL,
  `office` varchar(6) NOT NULL,
  `phone_number` varchar(13) NOT NULL,
  `job_title` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `user_info`
--

INSERT INTO `user_info` (`user_info_id`, `first_name`, `last_name`, `department`, `office`, `phone_number`, `job_title`, `email`, `password`, `created_at`, `updated_at`) VALUES
('0', 'Jose', 'Perez', 'ECE', 'S-113', '1234567890', 'Professor', 'jose.perez@upr.edu', 'test', '2017-03-22 04:00:00', '2017-03-22 04:00:00'),
('1', 'Luis', 'Negron', 'ECE', 'S-222', '1234567890', 'Professor', 'luis.negron@upr.edu', 'test', '2017-03-22 04:00:00', '2017-03-22 04:00:00'),
('10', 'Michelle', 'Velez', 'ECE', 'S-409', '1234567890', 'Professor', 'michelle.velez@upr.edu', 'test', '2017-03-22 04:00:00', '2017-03-22 04:00:00'),
('11', 'Joan', 'Ortiz', 'ECE', 'S-410', '123', 'Accountant', 'joan.ortiz@upr.edu', 'test', '2017-03-22 04:00:00', '2017-03-22 04:00:00'),
('12', 'Unassigned', 'Accountant', '', '', '', '', '', '', '2017-03-22 04:00:00', '2017-03-22 04:00:00'),
('2', 'Victor', 'Beltran', 'ECE', 'S-403', '1234567890', 'Professor', 'victor.beltran@upr.edu', 'test', '2017-03-22 04:00:00', '2017-03-22 04:00:00'),
('3', 'Carlos', 'Rodriguez', 'ECE', 'S-401', '1234567890', 'Accountant', 'carlos.rodriguez@upr.edu', 'test', '2017-03-22 04:00:00', '2017-03-22 04:00:00'),
('4', 'Maria', 'Rolon', 'ECE', 'S-402', '1234567890', 'Professor', 'maria.rolon@upr.edu', 'test', '2017-03-22 04:00:00', '2017-03-22 04:00:00'),
('5', 'Juan', 'Ortega', 'ECE', 'S-404', '1234567890', 'Professor', 'juan.ortega@upr.edu', 'test', '2017-03-22 04:00:00', '2017-03-22 04:00:00'),
('6', 'Coral', 'Suazo', 'ECE', 'S-405', '1234567890', 'Professor', 'coral.suazo@upr.edu', 'test', '2017-03-22 04:00:00', '2017-03-22 04:00:00'),
('7', 'Bryan', 'Matos', 'ECE', 'S-406', '1234567890', 'Accountant', 'bryan.matos@upr.edu', 'test', '2017-03-22 04:00:00', '2017-03-22 04:00:00'),
('8', 'Christian', 'Rivera', 'ECE', 'S-407', '1234567890', 'Professor', 'christian.rivera@upr.edu', 'test', '2017-03-22 04:00:00', '2017-03-22 04:00:00'),
('9', 'Luz', 'Calderon', 'ECE', 'S-408', '1234567890', 'Professor', 'luz.calderon@upr.edu', 'test', '2017-03-22 04:00:00', '2017-03-22 04:00:00');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `accountants`
--
ALTER TABLE `accountants`
  ADD PRIMARY KEY (`accountant_id`),
  ADD KEY `accountants_roles_id_foreign` (`roles_id`),
  ADD KEY `accountants_user_info_id_foreign` (`user_info_id`);

--
-- Indices de la tabla `accountants_timestamps`
--
ALTER TABLE `accountants_timestamps`
  ADD PRIMARY KEY (`at_id`),
  ADD KEY `transaction_FK` (`transaction_id`),
  ADD KEY `researcher_FK` (`accountant_id`);

--
-- Indices de la tabla `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`comment_id`),
  ADD KEY `comments_transaction_id_foreign` (`transaction_id`),
  ADD KEY `comments_accountant_id_foreign` (`accountant_id`);

--
-- Indices de la tabla `credit_card`
--
ALTER TABLE `credit_card`
  ADD PRIMARY KEY (`cc_id`),
  ADD KEY `credit_card_researcher_id_foreign` (`researcher_id`);

--
-- Indices de la tabla `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`image_id`);

--
-- Indices de la tabla `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`item_id`),
  ADD KEY `items_transaction_id_foreign` (`transaction_id`);

--
-- Indices de la tabla `items_paid_from`
--
ALTER TABLE `items_paid_from`
  ADD PRIMARY KEY (`ipf_id`),
  ADD KEY `items_paid_from_item_id_foreign` (`item_id`),
  ADD KEY `items_paid_from_ra_id_foreign` (`ra_id`);

--
-- Indices de la tabla `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `notes`
--
ALTER TABLE `notes`
  ADD PRIMARY KEY (`note_id`),
  ADD KEY `accountant_id` (`accountant_id`),
  ADD KEY `transaction_id` (`transaction_id`);

--
-- Indices de la tabla `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`notification_id`),
  ADD KEY `notifications_researcher_id_foreign` (`researcher_id`),
  ADD KEY `notifications_accountant_id_foreign` (`accountant_id`);

--
-- Indices de la tabla `researchers`
--
ALTER TABLE `researchers`
  ADD PRIMARY KEY (`researcher_id`),
  ADD KEY `researchers_roles_id_foreign` (`roles_id`),
  ADD KEY `researchers_user_info_id_foreign` (`user_info_id`),
  ADD KEY `researchers_accountant_id_foreign` (`accountant_id`);

--
-- Indices de la tabla `researchers_timestamps`
--
ALTER TABLE `researchers_timestamps`
  ADD PRIMARY KEY (`ct_id`),
  ADD KEY `transaction_FK` (`transaction_id`),
  ADD KEY `researcher_FK` (`researcher_id`);

--
-- Indices de la tabla `researcher_has_accounts`
--
ALTER TABLE `researcher_has_accounts`
  ADD PRIMARY KEY (`rha_id`),
  ADD KEY `researcher_has_accounts_researcher_id_foreign` (`researcher_id`),
  ADD KEY `researcher_has_accounts_ra_id_foreign` (`ra_id`);

--
-- Indices de la tabla `researcher_notifications`
--
ALTER TABLE `researcher_notifications`
  ADD PRIMARY KEY (`rn_id`),
  ADD KEY `researcher_notifications_researcher_id` (`researcher_id`),
  ADD KEY `researcher_notifications_at_id` (`at_id`),
  ADD KEY `researcher_notifications_transaction_id` (`transaction_id`);

--
-- Indices de la tabla `research_accounts`
--
ALTER TABLE `research_accounts`
  ADD PRIMARY KEY (`ra_id`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`roles_id`);

--
-- Indices de la tabla `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`transaction_id`),
  ADD KEY `transactions_researcher_id_foreign` (`researcher_id`),
  ADD KEY `transactions_accountant_id_foreign` (`accountant_id`);

--
-- Indices de la tabla `transactions_info`
--
ALTER TABLE `transactions_info`
  ADD PRIMARY KEY (`tinfo_id`),
  ADD KEY `transactions_info_transaction_id_foreign` (`transaction_id`);

--
-- Indices de la tabla `transaction_images`
--
ALTER TABLE `transaction_images`
  ADD PRIMARY KEY (`transaction_image_id`),
  ADD KEY `transaction_images_image_id_foreign` (`image_id`),
  ADD KEY `transaction_images_tinfo_id_foreign` (`tinfo_id`);

--
-- Indices de la tabla `user_info`
--
ALTER TABLE `user_info`
  ADD PRIMARY KEY (`user_info_id`),
  ADD UNIQUE KEY `user_info_email_unique` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `accountants`
--
ALTER TABLE `accountants`
  MODIFY `accountant_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT de la tabla `accountants_timestamps`
--
ALTER TABLE `accountants_timestamps`
  MODIFY `at_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT de la tabla `comments`
--
ALTER TABLE `comments`
  MODIFY `comment_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla `credit_card`
--
ALTER TABLE `credit_card`
  MODIFY `cc_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT de la tabla `images`
--
ALTER TABLE `images`
  MODIFY `image_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT de la tabla `items`
--
ALTER TABLE `items`
  MODIFY `item_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT de la tabla `items_paid_from`
--
ALTER TABLE `items_paid_from`
  MODIFY `ipf_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT de la tabla `notes`
--
ALTER TABLE `notes`
  MODIFY `note_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `notifications`
--
ALTER TABLE `notifications`
  MODIFY `notification_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `researchers`
--
ALTER TABLE `researchers`
  MODIFY `researcher_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT de la tabla `researchers_timestamps`
--
ALTER TABLE `researchers_timestamps`
  MODIFY `ct_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT de la tabla `researcher_has_accounts`
--
ALTER TABLE `researcher_has_accounts`
  MODIFY `rha_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;
--
-- AUTO_INCREMENT de la tabla `researcher_notifications`
--
ALTER TABLE `researcher_notifications`
  MODIFY `rn_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `research_accounts`
--
ALTER TABLE `research_accounts`
  MODIFY `ra_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `roles_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT de la tabla `transactions`
--
ALTER TABLE `transactions`
  MODIFY `transaction_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;
--
-- AUTO_INCREMENT de la tabla `transactions_info`
--
ALTER TABLE `transactions_info`
  MODIFY `tinfo_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
--
-- AUTO_INCREMENT de la tabla `transaction_images`
--
ALTER TABLE `transaction_images`
  MODIFY `transaction_image_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `accountants`
--
ALTER TABLE `accountants`
  ADD CONSTRAINT `accountants_roles_id_foreign` FOREIGN KEY (`roles_id`) REFERENCES `roles` (`roles_id`),
  ADD CONSTRAINT `accountants_user_info_id_foreign` FOREIGN KEY (`user_info_id`) REFERENCES `user_info` (`user_info_id`);

--
-- Filtros para la tabla `accountants_timestamps`
--
ALTER TABLE `accountants_timestamps`
  ADD CONSTRAINT `accountant_FK` FOREIGN KEY (`accountant_id`) REFERENCES `accountants` (`accountant_id`),
  ADD CONSTRAINT `accountants_timestamps_ibfk_2` FOREIGN KEY (`transaction_id`) REFERENCES `transactions` (`transaction_id`);

--
-- Filtros para la tabla `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_accountant_id_foreign` FOREIGN KEY (`accountant_id`) REFERENCES `accountants` (`accountant_id`),
  ADD CONSTRAINT `comments_transaction_id_foreign` FOREIGN KEY (`transaction_id`) REFERENCES `transactions` (`transaction_id`);

--
-- Filtros para la tabla `credit_card`
--
ALTER TABLE `credit_card`
  ADD CONSTRAINT `credit_card_researcher_id_foreign` FOREIGN KEY (`researcher_id`) REFERENCES `researchers` (`researcher_id`);

--
-- Filtros para la tabla `items`
--
ALTER TABLE `items`
  ADD CONSTRAINT `items_transaction_id_foreign` FOREIGN KEY (`transaction_id`) REFERENCES `transactions` (`transaction_id`);

--
-- Filtros para la tabla `items_paid_from`
--
ALTER TABLE `items_paid_from`
  ADD CONSTRAINT `items_paid_from_item_id_foreign` FOREIGN KEY (`item_id`) REFERENCES `items` (`item_id`),
  ADD CONSTRAINT `items_paid_from_ra_id_foreign` FOREIGN KEY (`ra_id`) REFERENCES `research_accounts` (`ra_id`);

--
-- Filtros para la tabla `notes`
--
ALTER TABLE `notes`
  ADD CONSTRAINT `notes_ibfk_1` FOREIGN KEY (`accountant_id`) REFERENCES `accountants` (`accountant_id`),
  ADD CONSTRAINT `notes_ibfk_2` FOREIGN KEY (`transaction_id`) REFERENCES `transactions` (`transaction_id`);

--
-- Filtros para la tabla `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_accountant_id_foreign` FOREIGN KEY (`accountant_id`) REFERENCES `accountants` (`accountant_id`),
  ADD CONSTRAINT `notifications_researcher_id_foreign` FOREIGN KEY (`researcher_id`) REFERENCES `researchers` (`researcher_id`);

--
-- Filtros para la tabla `researchers`
--
ALTER TABLE `researchers`
  ADD CONSTRAINT `researchers_accountant_id_foreign` FOREIGN KEY (`accountant_id`) REFERENCES `accountants` (`accountant_id`),
  ADD CONSTRAINT `researchers_roles_id_foreign` FOREIGN KEY (`roles_id`) REFERENCES `roles` (`roles_id`),
  ADD CONSTRAINT `researchers_user_info_id_foreign` FOREIGN KEY (`user_info_id`) REFERENCES `user_info` (`user_info_id`);

--
-- Filtros para la tabla `researchers_timestamps`
--
ALTER TABLE `researchers_timestamps`
  ADD CONSTRAINT `researcher_FK` FOREIGN KEY (`researcher_id`) REFERENCES `researchers` (`researcher_id`),
  ADD CONSTRAINT `transaction_FK` FOREIGN KEY (`transaction_id`) REFERENCES `transactions` (`transaction_id`);

--
-- Filtros para la tabla `researcher_has_accounts`
--
ALTER TABLE `researcher_has_accounts`
  ADD CONSTRAINT `researcher_has_accounts_ra_id_foreign` FOREIGN KEY (`ra_id`) REFERENCES `research_accounts` (`ra_id`),
  ADD CONSTRAINT `researcher_has_accounts_researcher_id_foreign` FOREIGN KEY (`researcher_id`) REFERENCES `researchers` (`researcher_id`);

--
-- Filtros para la tabla `researcher_notifications`
--
ALTER TABLE `researcher_notifications`
  ADD CONSTRAINT `researcher_notifications_at_id` FOREIGN KEY (`at_id`) REFERENCES `accountants_timestamps` (`at_id`),
  ADD CONSTRAINT `researcher_notifications_researcher_id` FOREIGN KEY (`researcher_id`) REFERENCES `researchers` (`researcher_id`),
  ADD CONSTRAINT `researcher_notifications_transaction_id` FOREIGN KEY (`transaction_id`) REFERENCES `transactions` (`transaction_id`);

--
-- Filtros para la tabla `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_accountant_id_foreign` FOREIGN KEY (`accountant_id`) REFERENCES `accountants` (`accountant_id`),
  ADD CONSTRAINT `transactions_researcher_id_foreign` FOREIGN KEY (`researcher_id`) REFERENCES `researchers` (`researcher_id`);

--
-- Filtros para la tabla `transactions_info`
--
ALTER TABLE `transactions_info`
  ADD CONSTRAINT `transactions_info_transaction_id_foreign` FOREIGN KEY (`transaction_id`) REFERENCES `transactions` (`transaction_id`);

--
-- Filtros para la tabla `transaction_images`
--
ALTER TABLE `transaction_images`
  ADD CONSTRAINT `transaction_images_image_id_foreign` FOREIGN KEY (`image_id`) REFERENCES `images` (`image_id`),
  ADD CONSTRAINT `transaction_images_tinfo_id_foreign` FOREIGN KEY (`tinfo_id`) REFERENCES `transactions_info` (`tinfo_id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
