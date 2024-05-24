-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 24, 2024 at 05:12 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dityamain_db_new`
--

-- --------------------------------------------------------

--
-- Table structure for table `bank_details`
--

CREATE TABLE `bank_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `bank_name` varchar(255) NOT NULL,
  `branch` varchar(255) NOT NULL,
  `account_holder_name` varchar(255) NOT NULL,
  `account_no` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bank_details`
--

INSERT INTO `bank_details` (`id`, `user_id`, `bank_name`, `branch`, `account_holder_name`, `account_no`, `created_at`, `updated_at`) VALUES
(1, 6, 'Nic Aia', 'Itahari', 'Saroj Sardar', '1234542214765434', '2024-04-21 05:39:30', '2024-04-21 05:39:30'),
(2, 7, 'Nic Aia', 'Itahari', 'Saroj Sardar', '1234542214765434', '2024-04-22 08:47:43', '2024-04-22 08:47:43');

-- --------------------------------------------------------

--
-- Table structure for table `candidates`
--

CREATE TABLE `candidates` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `mobile_no` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `created_at`, `updated_at`) VALUES
(1, 'furniture', 'furniture', '2024-04-18 09:17:41', '2024-04-18 09:17:41'),
(2, 'factory_worker', 'factory-worker', '2024-04-18 09:17:41', '2024-04-18 09:17:41'),
(3, 'labour', 'labour', '2024-04-18 09:17:41', '2024-04-18 09:17:41');

-- --------------------------------------------------------

--
-- Table structure for table `category_company`
--

CREATE TABLE `category_company` (
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `category_company`
--

INSERT INTO `category_company` (`company_id`, `category_id`, `user_id`) VALUES
(2, 1, 5),
(2, 3, 5);

-- --------------------------------------------------------

--
-- Table structure for table `category_details`
--

CREATE TABLE `category_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `category_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `category_details`
--

INSERT INTO `category_details` (`id`, `user_id`, `category_id`, `created_at`, `updated_at`) VALUES
(1, 6, 1, '2024-04-21 05:39:34', '2024-04-21 05:39:34'),
(2, 6, 2, '2024-04-21 05:39:34', '2024-04-21 05:39:34'),
(3, 7, 1, '2024-04-22 08:47:47', '2024-04-22 08:47:47'),
(4, 7, 2, '2024-04-22 08:47:47', '2024-04-22 08:47:47');

-- --------------------------------------------------------

--
-- Table structure for table `client_messages`
--

CREATE TABLE `client_messages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `contact` varchar(255) NOT NULL,
  `message` longtext NOT NULL,
  `read_status` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `comment` longtext NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `user_id`, `comment`, `created_at`, `updated_at`) VALUES
(1, 6, 'fsdfsad', '2024-04-21 08:21:26', '2024-04-21 08:21:26');

-- --------------------------------------------------------

--
-- Table structure for table `companies`
--

CREATE TABLE `companies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `logo` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `companies`
--

INSERT INTO `companies` (`id`, `user_id`, `name`, `address`, `logo`, `country`, `created_at`, `updated_at`) VALUES
(2, 5, 'Tukaatu Online', 'Kuala Lumpur, Malaysia', '1713677121-logo.png', '154', '2024-04-21 05:25:21', '2024-04-21 05:25:21');

-- --------------------------------------------------------

--
-- Table structure for table `company_candidates`
--

CREATE TABLE `company_candidates` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `demand_id` int(11) DEFAULT NULL,
  `demand_status` varchar(255) NOT NULL,
  `interview_status` varchar(255) NOT NULL DEFAULT '0',
  `medical_status` varchar(255) DEFAULT NULL,
  `pro_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `company_candidates`
--

INSERT INTO `company_candidates` (`id`, `user_id`, `company_id`, `demand_id`, `demand_status`, `interview_status`, `medical_status`, `pro_id`, `created_at`, `updated_at`) VALUES
(7, 7, 2, 1, 'Interview', 'Selected', 'New', NULL, '2024-05-24 03:20:59', '2024-05-24 04:42:31'),
(8, 6, 2, 1, 'Interview', 'Selected', NULL, NULL, '2024-05-24 10:33:49', '2024-05-24 10:47:45');

-- --------------------------------------------------------

--
-- Table structure for table `company_demands`
--

CREATE TABLE `company_demands` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` int(11) NOT NULL,
  `demand_code` varchar(255) NOT NULL,
  `quota` varchar(255) NOT NULL,
  `gender` varchar(255) NOT NULL,
  `age_from` varchar(255) NOT NULL,
  `age_to` varchar(255) NOT NULL,
  `height` varchar(255) NOT NULL,
  `weight` varchar(255) NOT NULL,
  `experience_year` varchar(255) NOT NULL,
  `education` varchar(255) NOT NULL,
  `edu_level` int(11) NOT NULL,
  `demand_letter` longtext NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `company_demands`
--

INSERT INTO `company_demands` (`id`, `company_id`, `demand_code`, `quota`, `gender`, `age_from`, `age_to`, `height`, `weight`, `experience_year`, `education`, `edu_level`, `demand_letter`, `created_at`, `updated_at`, `status`) VALUES
(1, 5, 'DMD-000001', '40', 'male', '25', '55', '5.3', '55', '2', 'see', 2, '1713677791-0.png', '2024-04-21 05:36:31', '2024-04-21 05:36:31', 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `company_demand_language`
--

CREATE TABLE `company_demand_language` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_demand_id` bigint(20) UNSIGNED NOT NULL,
  `language_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `company_demand_language`
--

INSERT INTO `company_demand_language` (`id`, `company_demand_id`, `language_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, NULL, NULL),
(2, 1, 2, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE `countries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`id`, `name`, `code`, `created_at`, `updated_at`) VALUES
(1, 'Afghanistan', 'AF', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(2, 'land Islands', 'AX', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(3, 'Albania', 'AL', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(4, 'Algeria', 'DZ', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(5, 'American Samoa', 'AS', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(6, 'AndorrA', 'AD', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(7, 'Angola', 'AO', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(8, 'Anguilla', 'AI', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(9, 'Antarctica', 'AQ', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(10, 'Antigua and Barbuda', 'AG', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(11, 'Argentina', 'AR', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(12, 'Armenia', 'AM', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(13, 'Aruba', 'AW', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(14, 'Australia', 'AU', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(15, 'Austria', 'AT', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(16, 'Azerbaijan', 'AZ', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(17, 'Bahamas', 'BS', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(18, 'Bahrain', 'BH', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(19, 'Bangladesh', 'BD', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(20, 'Barbados', 'BB', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(21, 'Belarus', 'BY', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(22, 'Belgium', 'BE', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(23, 'Belize', 'BZ', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(24, 'Benin', 'BJ', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(25, 'Bermuda', 'BM', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(26, 'Bhutan', 'BT', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(27, 'Bolivia', 'BO', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(28, 'Bosnia and Herzegovina', 'BA', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(29, 'Botswana', 'BW', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(30, 'Bouvet Island', 'BV', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(31, 'Brazil', 'BR', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(32, 'British Indian Ocean Territory', 'IO', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(33, 'Brunei Darussalam', 'BN', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(34, 'Bulgaria', 'BG', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(35, 'Burkina Faso', 'BF', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(36, 'Burundi', 'BI', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(37, 'Cambodia', 'KH', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(38, 'Cameroon', 'CM', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(39, 'Canada', 'CA', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(40, 'Cape Verde', 'CV', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(41, 'Cayman Islands', 'KY', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(42, 'Central African Republic', 'CF', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(43, 'Chad', 'TD', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(44, 'Chile', 'CL', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(45, 'China', 'CN', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(46, 'Christmas Island', 'CX', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(47, 'Cocos (Keeling) Islands', 'CC', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(48, 'Colombia', 'CO', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(49, 'Comoros', 'KM', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(50, 'Congo', 'CG', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(51, 'Congo, The Democratic Republic of the', 'CD', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(52, 'Cook Islands', 'CK', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(53, 'Costa Rica', 'CR', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(54, 'Cote D\"Ivoire', 'CI', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(55, 'Croatia', 'HR', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(56, 'Cuba', 'CU', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(57, 'Cyprus', 'CY', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(58, 'Czech Republic', 'CZ', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(59, 'Denmark', 'DK', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(60, 'Djibouti', 'DJ', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(61, 'Dominica', 'DM', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(62, 'Dominican Republic', 'DO', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(63, 'Ecuador', 'EC', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(64, 'Egypt', 'EG', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(65, 'El Salvador', 'SV', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(66, 'Equatorial Guinea', 'GQ', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(67, 'Eritrea', 'ER', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(68, 'Estonia', 'EE', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(69, 'Ethiopia', 'ET', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(70, 'Falkland Islands (Malvinas)', 'FK', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(71, 'Faroe Islands', 'FO', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(72, 'Fiji', 'FJ', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(73, 'Finland', 'FI', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(74, 'France', 'FR', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(75, 'French Guiana', 'GF', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(76, 'French Polynesia', 'PF', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(77, 'French Southern Territories', 'TF', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(78, 'Gabon', 'GA', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(79, 'Gambia', 'GM', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(80, 'Georgia', 'GE', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(81, 'Germany', 'DE', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(82, 'Ghana', 'GH', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(83, 'Gibraltar', 'GI', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(84, 'Greece', 'GR', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(85, 'Greenland', 'GL', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(86, 'Grenada', 'GD', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(87, 'Guadeloupe', 'GP', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(88, 'Guam', 'GU', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(89, 'Guatemala', 'GT', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(90, 'Guernsey', 'GG', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(91, 'Guinea', 'GN', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(92, 'Guinea-Bissau', 'GW', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(93, 'Guyana', 'GY', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(94, 'Haiti', 'HT', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(95, 'Heard Island and Mcdonald Islands', 'HM', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(96, 'Holy See (Vatican City State)', 'VA', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(97, 'Honduras', 'HN', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(98, 'Hong Kong', 'HK', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(99, 'Hungary', 'HU', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(100, 'Iceland', 'IS', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(101, 'India', 'IN', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(102, 'Indonesia', 'ID', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(103, 'Iran, Islamic Republic Of', 'IR', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(104, 'Iraq', 'IQ', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(105, 'Ireland', 'IE', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(106, 'Isle of Man', 'IM', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(107, 'Israel', 'IL', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(108, 'Italy', 'IT', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(109, 'Jamaica', 'JM', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(110, 'Japan', 'JP', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(111, 'Jersey', 'JE', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(112, 'Jordan', 'JO', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(113, 'Kazakhstan', 'KZ', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(114, 'Kenya', 'KE', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(115, 'Kiribati', 'KI', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(116, 'Korea, Democratic People\"S Republic of', 'KP', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(117, 'Korea, Republic of', 'KR', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(118, 'Kuwait', 'KW', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(119, 'Kyrgyzstan', 'KG', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(120, 'Lao People\"S Democratic Republic', 'LA', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(121, 'Latvia', 'LV', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(122, 'Lebanon', 'LB', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(123, 'Lesotho', 'LS', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(124, 'Liberia', 'LR', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(125, 'Libyan Arab Jamahiriya', 'LY', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(126, 'Liechtenstein', 'LI', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(127, 'Lithuania', 'LT', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(128, 'Luxembourg', 'LU', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(129, 'Macao', 'MO', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(130, 'Macedonia, The Former Yugoslav Republic of', 'MK', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(131, 'Madagascar', 'MG', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(132, 'Malawi', 'MW', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(133, 'Malaysia', 'MY', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(134, 'Maldives', 'MV', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(135, 'Mali', 'ML', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(136, 'Malta', 'MT', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(137, 'Marshall Islands', 'MH', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(138, 'Martinique', 'MQ', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(139, 'Mauritania', 'MR', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(140, 'Mauritius', 'MU', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(141, 'Mayotte', 'YT', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(142, 'Mexico', 'MX', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(143, 'Micronesia, Federated States of', 'FM', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(144, 'Moldova, Republic of', 'MD', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(145, 'Monaco', 'MC', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(146, 'Mongolia', 'MN', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(147, 'Montenegro', 'ME', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(148, 'Montserrat', 'MS', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(149, 'Morocco', 'MA', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(150, 'Mozambique', 'MZ', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(151, 'Myanmar', 'MM', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(152, 'Namibia', 'NA', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(153, 'Nauru', 'NR', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(154, 'Nepal', 'NP', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(155, 'Netherlands', 'NL', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(156, 'Netherlands Antilles', 'AN', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(157, 'New Caledonia', 'NC', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(158, 'New Zealand', 'NZ', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(159, 'Nicaragua', 'NI', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(160, 'Niger', 'NE', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(161, 'Nigeria', 'NG', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(162, 'Niue', 'NU', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(163, 'Norfolk Island', 'NF', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(164, 'Northern Mariana Islands', 'MP', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(165, 'Norway', 'NO', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(166, 'Oman', 'OM', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(167, 'Pakistan', 'PK', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(168, 'Palau', 'PW', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(169, 'Palestinian Territory, Occupied', 'PS', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(170, 'Panama', 'PA', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(171, 'Papua New Guinea', 'PG', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(172, 'Paraguay', 'PY', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(173, 'Peru', 'PE', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(174, 'Philippines', 'PH', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(175, 'Pitcairn', 'PN', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(176, 'Poland', 'PL', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(177, 'Portugal', 'PT', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(178, 'Puerto Rico', 'PR', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(179, 'Qatar', 'QA', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(180, 'Reunion', 'RE', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(181, 'Romania', 'RO', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(182, 'Russian Federation', 'RU', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(183, 'RWANDA', 'RW', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(184, 'Saint Helena', 'SH', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(185, 'Saint Kitts and Nevis', 'KN', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(186, 'Saint Lucia', 'LC', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(187, 'Saint Pierre and Miquelon', 'PM', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(188, 'Saint Vincent and the Grenadines', 'VC', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(189, 'Samoa', 'WS', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(190, 'San Marino', 'SM', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(191, 'Sao Tome and Principe', 'ST', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(192, 'Saudi Arabia', 'SA', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(193, 'Senegal', 'SN', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(194, 'Serbia', 'RS', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(195, 'Seychelles', 'SC', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(196, 'Sierra Leone', 'SL', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(197, 'Singapore', 'SG', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(198, 'Slovakia', 'SK', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(199, 'Slovenia', 'SI', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(200, 'Solomon Islands', 'SB', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(201, 'Somalia', 'SO', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(202, 'South Africa', 'ZA', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(203, 'South Georgia and the South Sandwich Islands', 'GS', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(204, 'Spain', 'ES', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(205, 'Sri Lanka', 'LK', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(206, 'Sudan', 'SD', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(207, 'Suriname', 'SR', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(208, 'Svalbard and Jan Mayen', 'SJ', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(209, 'Swaziland', 'SZ', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(210, 'Sweden', 'SE', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(211, 'Switzerland', 'CH', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(212, 'Syrian Arab Republic', 'SY', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(213, 'Taiwan, Province of China', 'TW', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(214, 'Tajikistan', 'TJ', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(215, 'Tanzania, United Republic of', 'TZ', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(216, 'Thailand', 'TH', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(217, 'Timor-Leste', 'TL', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(218, 'Togo', 'TG', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(219, 'Tokelau', 'TK', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(220, 'Tonga', 'TO', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(221, 'Trinidad and Tobago', 'TT', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(222, 'Tunisia', 'TN', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(223, 'Turkey', 'TR', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(224, 'Turkmenistan', 'TM', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(225, 'Turks and Caicos Islands', 'TC', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(226, 'Tuvalu', 'TV', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(227, 'Uganda', 'UG', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(228, 'Ukraine', 'UA', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(229, 'United Arab Emirates', 'AE', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(230, 'United Kingdom', 'GB', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(231, 'United States', 'US', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(232, 'United States Minor Outlying Islands', 'UM', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(233, 'Uruguay', 'UY', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(234, 'Uzbekistan', 'UZ', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(235, 'Vanuatu', 'VU', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(236, 'Venezuela', 'VE', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(237, 'Viet Nam', 'VN', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(238, 'Virgin Islands, British', 'VG', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(239, 'Virgin Islands, U.S.', 'VI', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(240, 'Wallis and Futuna', 'WF', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(241, 'Western Sahara', 'EH', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(242, 'Yemen', 'YE', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(243, 'Zambia', 'ZM', '2024-04-18 09:17:40', '2024-04-18 09:17:40'),
(244, 'Zimbabwe', 'ZW', '2024-04-18 09:17:40', '2024-04-18 09:17:40');

-- --------------------------------------------------------

--
-- Table structure for table `educational_documents`
--

CREATE TABLE `educational_documents` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `edu_doc` varchar(255) DEFAULT NULL,
  `level` varchar(255) NOT NULL,
  `edu_level` varchar(255) NOT NULL,
  `school_college_name` varchar(255) NOT NULL,
  `pass_year` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `educational_documents`
--

INSERT INTO `educational_documents` (`id`, `user_id`, `edu_doc`, `level`, `edu_level`, `school_college_name`, `pass_year`, `created_at`, `updated_at`) VALUES
(1, 6, '1713677956-eticket.pdf', 'SEE', '2', 'Sun Shine', '2016', '2024-04-21 05:39:16', '2024-04-21 05:39:16'),
(2, 7, '1713775653-eticket.pdf', 'SEE', '2', 'Sun Shine', '2016', '2024-04-22 08:47:33', '2024-04-22 08:47:33');

-- --------------------------------------------------------

--
-- Table structure for table `education_types`
--

CREATE TABLE `education_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `edu_level` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `education_types`
--

INSERT INTO `education_types` (`id`, `name`, `slug`, `edu_level`, `created_at`, `updated_at`) VALUES
(1, 'under_see', 'under_see', 1, '2024-04-18 09:17:41', '2024-04-18 09:17:41'),
(2, 'see', 'see', 2, '2024-04-18 09:17:41', '2024-04-18 09:17:41'),
(3, '+2', '+2', 3, '2024-04-18 09:17:41', '2024-04-18 09:17:41');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gallery_categories`
--

CREATE TABLE `gallery_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `thumbnail` varchar(255) NOT NULL,
  `category_name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `active_status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gallery_images`
--

CREATE TABLE `gallery_images` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `filename` varchar(255) NOT NULL,
  `original_filename` varchar(255) NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `genders`
--

CREATE TABLE `genders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `genders`
--

INSERT INTO `genders` (`id`, `name`, `slug`, `created_at`, `updated_at`) VALUES
(1, 'male', 'male', '2024-04-18 09:17:41', '2024-04-18 09:17:41'),
(2, 'female', 'female', '2024-04-18 09:17:41', '2024-04-18 09:17:41');

-- --------------------------------------------------------

--
-- Table structure for table `interviews`
--

CREATE TABLE `interviews` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `interview_date` varchar(255) DEFAULT NULL,
  `interview_time` varchar(255) DEFAULT NULL,
  `interview_venue` varchar(255) DEFAULT NULL,
  `reschedule_date` varchar(255) DEFAULT NULL,
  `reschedule_time` varchar(255) DEFAULT NULL,
  `reschedule_venue` varchar(255) DEFAULT NULL,
  `reschedule_reason` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `interviews`
--

INSERT INTO `interviews` (`id`, `user_id`, `interview_date`, `interview_time`, `interview_venue`, `reschedule_date`, `reschedule_time`, `reschedule_venue`, `reschedule_reason`, `created_at`, `updated_at`) VALUES
(1, 6, '2024-05-31', '04:24 PM', 'Ditya ko Office', NULL, NULL, NULL, NULL, '2024-04-21 05:40:46', '2024-05-24 10:37:08'),
(2, 7, '2024-05-31', '04:24 PM', 'Ditya ko Office', NULL, NULL, NULL, NULL, '2024-04-22 10:06:27', '2024-05-24 10:37:09');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `jobs`
--

INSERT INTO `jobs` (`id`, `queue`, `payload`, `attempts`, `reserved_at`, `available_at`, `created_at`) VALUES
(58, 'default', '{\"uuid\":\"9b91f948-765c-45aa-87b1-27b85177243f\",\"displayName\":\"App\\\\Jobs\\\\SendReInterviewSms\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\SendReInterviewSms\",\"command\":\"O:27:\\\"App\\\\Jobs\\\\SendReInterviewSms\\\":5:{s:11:\\\"\\u0000*\\u0000mobileNo\\\";s:10:\\\"9802343491\\\";s:7:\\\"\\u0000*\\u0000date\\\";s:10:\\\"2024-05-31\\\";s:7:\\\"\\u0000*\\u0000time\\\";s:8:\\\"04:24 PM\\\";s:8:\\\"\\u0000*\\u0000venue\\\";s:15:\\\"Ditya ko Office\\\";s:14:\\\"\\u0000*\\u0000companyName\\\";s:14:\\\"Tukaatu Online\\\";}\"}}', 0, NULL, 1716547029, 1716547029),
(59, 'default', '{\"uuid\":\"ef2ba288-4b12-46cc-a70c-5f2f96d24765\",\"displayName\":\"App\\\\Jobs\\\\SendReInterviewSms\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\SendReInterviewSms\",\"command\":\"O:27:\\\"App\\\\Jobs\\\\SendReInterviewSms\\\":5:{s:11:\\\"\\u0000*\\u0000mobileNo\\\";s:10:\\\"9815310063\\\";s:7:\\\"\\u0000*\\u0000date\\\";s:10:\\\"2024-05-31\\\";s:7:\\\"\\u0000*\\u0000time\\\";s:8:\\\"04:24 PM\\\";s:8:\\\"\\u0000*\\u0000venue\\\";s:15:\\\"Ditya ko Office\\\";s:14:\\\"\\u0000*\\u0000companyName\\\";s:14:\\\"Tukaatu Online\\\";}\"}}', 0, NULL, 1716547029, 1716547029);

-- --------------------------------------------------------

--
-- Table structure for table `languages`
--

CREATE TABLE `languages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `languages`
--

INSERT INTO `languages` (`id`, `name`, `slug`, `created_at`, `updated_at`) VALUES
(1, 'english', 'english', '2024-04-18 09:17:41', '2024-04-18 09:17:41'),
(2, 'hindi', 'hindi', '2024-04-18 09:17:41', '2024-04-18 09:17:41'),
(3, 'malay', 'malay', '2024-04-18 09:17:41', '2024-04-18 09:17:41');

-- --------------------------------------------------------

--
-- Table structure for table `language_details`
--

CREATE TABLE `language_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `language_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `language_details`
--

INSERT INTO `language_details` (`id`, `user_id`, `language_name`, `created_at`, `updated_at`) VALUES
(1, 6, '1', '2024-04-21 05:39:22', '2024-04-21 05:39:22'),
(2, 6, '2', '2024-04-21 05:39:22', '2024-04-21 05:39:22'),
(3, 7, '1', '2024-04-22 08:47:37', '2024-04-22 08:47:37'),
(4, 7, '2', '2024-04-22 08:47:37', '2024-04-22 08:47:37');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(734, '2014_10_12_000000_create_users_table', 1),
(735, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(736, '2019_08_19_000000_create_failed_jobs_table', 1),
(737, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(738, '2023_06_30_091858_create_site_settings_table', 1),
(739, '2023_06_30_100451_create_sliders_table', 1),
(740, '2023_07_03_101624_create_services_table', 1),
(741, '2023_07_03_144417_create_portfolios_table', 1),
(742, '2023_08_07_170737_create_web_contents_table', 1),
(743, '2023_08_11_093012_create_gallery_categories_table', 1),
(744, '2023_08_11_140440_create_gallery_images_table', 1),
(745, '2023_08_11_175259_create_news_table', 1),
(746, '2023_08_12_120031_create_client_messages_table', 1),
(747, '2023_08_12_125822_create_testimonials_table', 1),
(748, '2023_08_12_161107_add_column_on_settings', 1),
(749, '2023_11_27_082017_create_permission_tables', 1),
(750, '2023_11_27_082619_create_user_information_table', 1),
(751, '2023_11_27_083024_create_companies_table', 1),
(752, '2023_12_03_182654_create_countries_table', 1),
(753, '2023_12_09_094653_create_categories_table', 1),
(754, '2023_12_09_094841_create_category_company_table', 1),
(755, '2023_12_09_103404_create_company_demands_table', 1),
(756, '2024_01_04_120535_create_education_types_table', 1),
(757, '2024_01_11_190444_create_languages_table', 1),
(758, '2024_01_11_190656_create_genders_table', 1),
(759, '2024_01_12_122740_create_candidates_table', 1),
(760, '2024_01_31_084709_create_user_details_table', 1),
(761, '2024_01_31_230929_create_upload_photos_table', 1),
(762, '2024_02_01_003832_create_passport_details_table', 1),
(763, '2024_02_01_091159_create_resume_details_table', 1),
(764, '2024_02_01_161929_create_work_experiences_table', 1),
(765, '2024_02_02_050639_create_bank_details_table', 1),
(766, '2024_02_02_090006_create_educational_documents_table', 1),
(767, '2024_02_02_094728_create_language_details_table', 1),
(768, '2024_02_02_104619_create_category_details_table', 1),
(769, '2024_02_19_193524_create_years_table', 1),
(770, '2024_02_20_124210_add_total_work_experience_to_users_table', 1),
(771, '2024_02_20_143416_create_splashes_table', 1),
(772, '2024_02_20_155555_create_company_demand_language_table', 1),
(773, '2024_02_29_113449_create_password_resets_table', 1),
(774, '2024_02_29_132432_add_status_to_company_demands_table', 1),
(775, '2024_03_29_091343_create_interviews_table', 1),
(776, '2024_04_02_160955_create_comments_table', 1),
(777, '2024_04_03_125851_create_company_candidates_table', 1),
(778, '2024_04_21_153530_create_jobs_table', 2);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 1),
(4, 'App\\Models\\User', 2),
(4, 'App\\Models\\User', 5),
(5, 'App\\Models\\User', 4),
(7, 'App\\Models\\User', 3),
(8, 'App\\Models\\User', 8);

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE `news` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `slug` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `thumbnail` varchar(255) NOT NULL,
  `content` longtext NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `passport_details`
--

CREATE TABLE `passport_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `passport_image` varchar(255) DEFAULT NULL,
  `passport_number` varchar(255) NOT NULL,
  `expiry_date` varchar(255) NOT NULL,
  `issue_place` varchar(255) NOT NULL,
  `passport_issue_date` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `passport_details`
--

INSERT INTO `passport_details` (`id`, `user_id`, `passport_image`, `passport_number`, `expiry_date`, `issue_place`, `passport_issue_date`, `created_at`, `updated_at`) VALUES
(1, 6, '1713677939-5Fe5mjDx6u.jpg', '123456', '2023/11/20', 'Sunsari', '2023/11/20', '2024-04-21 05:38:59', '2024-04-21 05:38:59'),
(2, 7, '1713775650-5Fe5mjDx6u.jpg', '123456', '2023/11/20', 'Sunsari', '2023/11/20', '2024-04-22 08:47:27', '2024-04-22 08:47:30');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `mobile_no` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'settings-create', 'web', NULL, NULL),
(2, 'settings-read', 'web', NULL, NULL),
(3, 'settings-update', 'web', NULL, NULL),
(4, 'settings-delete', 'web', NULL, NULL),
(5, 'company-create', 'web', NULL, NULL),
(6, 'company-read', 'web', NULL, NULL),
(7, 'company-update', 'web', NULL, NULL),
(8, 'company-delete', 'web', NULL, NULL),
(9, 'staff-create', 'web', NULL, NULL),
(10, 'staff-read', 'web', NULL, NULL),
(11, 'staff-update', 'web', NULL, NULL),
(12, 'staff-delete', 'web', NULL, NULL),
(13, 'demand-create', 'web', NULL, NULL),
(14, 'demand-read', 'web', NULL, NULL),
(15, 'demand-update', 'web', NULL, NULL),
(16, 'demand-delete', 'web', NULL, NULL),
(17, 'candidate-create', 'web', NULL, NULL),
(18, 'candidate-read', 'web', NULL, NULL),
(19, 'candidate-update', 'web', NULL, NULL),
(20, 'candidate-delete', 'web', NULL, NULL),
(21, 'role-create', 'web', NULL, NULL),
(22, 'role-read', 'web', NULL, NULL),
(23, 'role-update', 'web', NULL, NULL),
(24, 'role-delete', 'web', NULL, NULL),
(25, 'interview-approve', 'web', NULL, NULL),
(26, 'interview-reject', 'web', NULL, NULL),
(27, 'interview-comment', 'web', NULL, NULL),
(28, 'interview-read', 'web', NULL, NULL),
(29, 'document-read', 'web', NULL, NULL),
(30, 'document-approve', 'web', NULL, NULL),
(31, 'document-reject', 'web', NULL, NULL),
(32, 'document-update', 'web', NULL, NULL),
(33, 'webContent-create', 'web', NULL, NULL),
(34, 'webContent-read', 'web', NULL, NULL),
(35, 'webContent-update', 'web', NULL, NULL),
(36, 'webContent-delete', 'web', NULL, NULL),
(37, 'medical-create', 'web', NULL, NULL),
(38, 'medical-read', 'web', NULL, NULL),
(39, 'medical-update', 'web', NULL, NULL),
(40, 'medical-delete', 'web', NULL, NULL),
(41, 'pettyCash-request', 'web', NULL, NULL),
(42, 'pettyCash-read', 'web', NULL, NULL),
(43, 'pettyCash-reject', 'web', NULL, NULL),
(44, 'pettyCash-approve', 'web', NULL, NULL),
(45, 'invoice-request', 'web', NULL, NULL),
(46, 'invoice-read', 'web', NULL, NULL),
(47, 'invoice-update', 'web', NULL, NULL),
(48, 'invoice-delete', 'web', NULL, NULL),
(49, 'expense-create', 'web', NULL, NULL),
(50, 'expense-delete', 'web', NULL, NULL),
(51, 'expense-read', 'web', NULL, NULL),
(52, 'expense-statement', 'web', NULL, NULL),
(53, 'all-demand-read', 'web', NULL, NULL),
(54, 'manager-company-read', 'web', NULL, NULL),
(55, 'manager-demand-read', 'web', NULL, NULL),
(56, 'manager-candidate-read', 'web', NULL, NULL),
(57, 'receptionist-company-read', 'web', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
(1, 'App\\Models\\User', 6, 'mobile-app-token', 'a9963e8701a446efbe4a81cbcc530918985f4e59011b16c56c247757460e874b', '[\"*\"]', '2024-04-21 10:46:14', NULL, '2024-04-21 05:37:52', '2024-04-21 10:46:14'),
(2, 'App\\Models\\User', 7, 'mobile-app-token', '1f91b5eed5f753d51c5e8d1f1a95550b5a6d1cb593f72ce17a0390b35c6d9ee0', '[\"*\"]', '2024-04-22 08:47:47', NULL, '2024-04-22 08:47:05', '2024-04-22 08:47:47'),
(3, 'App\\Models\\User', 7, 'mobile-app-token', '56cddddbe3174655db712b31190ada5e123fe49b9a6404b30bff781906cf1df8', '[\"*\"]', '2024-05-24 10:40:45', NULL, '2024-04-22 09:45:36', '2024-05-24 10:40:45');

-- --------------------------------------------------------

--
-- Table structure for table `portfolios`
--

CREATE TABLE `portfolios` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `image` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `resume_details`
--

CREATE TABLE `resume_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `resume_file` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `resume_details`
--

INSERT INTO `resume_details` (`id`, `user_id`, `resume_file`, `created_at`, `updated_at`) VALUES
(1, 6, '1713677951-Saroj_sardar.pdf', '2024-04-21 05:39:11', '2024-04-21 05:39:11'),
(2, 7, '1713779164-Saroj_sardar.pdf', '2024-04-22 09:46:04', '2024-04-22 09:46:04');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'CEO', 'web', '2024-04-18 09:17:39', '2024-04-18 09:17:39'),
(2, 'HR', 'web', '2024-04-18 09:17:39', '2024-04-18 09:17:39'),
(3, 'PRO', 'web', '2024-04-18 09:17:39', '2024-04-18 09:17:39'),
(4, 'Company', 'web', '2024-04-18 09:17:39', '2024-04-18 09:17:39'),
(5, 'Receptionist', 'web', '2024-04-18 09:17:39', '2024-04-18 09:17:39'),
(6, 'Document-Officer', 'web', '2024-04-18 09:17:39', '2024-04-18 09:17:39'),
(7, 'Manager', 'web', '2024-04-18 09:17:39', '2024-04-18 09:17:39'),
(8, 'Medical-Officer', 'web', '2024-04-18 09:17:39', '2024-04-18 09:17:39'),
(9, 'Accountant', 'web', '2024-04-18 09:17:39', '2024-04-18 09:17:39');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 1),
(2, 1),
(3, 1),
(4, 1),
(5, 1),
(6, 1),
(7, 1),
(8, 1),
(9, 1),
(10, 1),
(11, 1),
(12, 1),
(13, 4),
(14, 4),
(15, 4),
(16, 4),
(17, 1),
(17, 3),
(17, 4),
(18, 1),
(18, 3),
(18, 4),
(18, 7),
(19, 1),
(19, 3),
(19, 4),
(20, 1),
(20, 3),
(20, 4),
(21, 1),
(22, 1),
(23, 1),
(24, 1),
(25, 1),
(26, 1),
(27, 1),
(28, 1),
(29, 1),
(29, 6),
(30, 1),
(30, 6),
(31, 1),
(31, 6),
(32, 1),
(32, 6),
(33, 1),
(34, 1),
(35, 1),
(36, 1),
(37, 1),
(37, 8),
(38, 1),
(38, 8),
(39, 1),
(39, 8),
(40, 1),
(40, 8),
(41, 1),
(41, 9),
(42, 1),
(42, 9),
(43, 1),
(44, 1),
(45, 1),
(45, 9),
(46, 1),
(46, 9),
(47, 1),
(47, 9),
(48, 1),
(48, 9),
(49, 1),
(49, 9),
(50, 1),
(50, 9),
(51, 1),
(51, 9),
(52, 1),
(52, 9),
(53, 4),
(54, 7),
(55, 7),
(56, 7),
(57, 5);

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `image` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `site_settings`
--

CREATE TABLE `site_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `site_name` varchar(255) DEFAULT NULL,
  `site_logo` varchar(255) DEFAULT NULL,
  `site_logo_sm` varchar(255) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `map` longtext DEFAULT NULL,
  `description` longtext DEFAULT NULL,
  `terms_and_condition` longtext DEFAULT NULL,
  `contact` varchar(255) DEFAULT NULL,
  `fb_link` varchar(255) DEFAULT NULL,
  `insta_link` varchar(255) DEFAULT NULL,
  `official_email` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `tiktok_link` varchar(255) DEFAULT NULL,
  `whatsapp` varchar(255) DEFAULT NULL,
  `privacy_and_policy` longtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `site_settings`
--

INSERT INTO `site_settings` (`id`, `site_name`, `site_logo`, `site_logo_sm`, `location`, `map`, `description`, `terms_and_condition`, `contact`, `fb_link`, `insta_link`, `official_email`, `created_at`, `updated_at`, `tiktok_link`, `whatsapp`, `privacy_and_policy`) VALUES
(1, 'Ditya International Private Limited', '', '', 'Sinamangal-9, Manpower Bazar, Kathmandu, Nepal', NULL, NULL, NULL, '+977 1-5912818', 'https://www.facebook.com/dityainternational/', NULL, 'info@dityainternational.com.np', '2023-07-20 00:30:25', '2023-08-16 05:35:32', NULL, '+97715912818', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sliders`
--

CREATE TABLE `sliders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `splashes`
--

CREATE TABLE `splashes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `testimonials`
--

CREATE TABLE `testimonials` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `designation` varchar(255) NOT NULL,
  `message` longtext NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `upload_photos`
--

CREATE TABLE `upload_photos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `passport_photo` varchar(255) DEFAULT NULL,
  `full_photo` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `upload_photos`
--

INSERT INTO `upload_photos` (`id`, `user_id`, `passport_photo`, `full_photo`, `created_at`, `updated_at`) VALUES
(1, 6, '1713677934-CzQe9ItDAL.jpg', '1713677934-5Fe5mjDx6u.jpg', '2024-04-21 05:38:54', '2024-04-21 05:38:54'),
(2, 7, '1713775644-CzQe9ItDAL.jpg', '1713775644-5Fe5mjDx6u.jpg', '2024-04-22 08:47:24', '2024-04-22 08:47:24');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `user_type` enum('1','2','3') NOT NULL DEFAULT '1',
  `mobile_no` varchar(255) DEFAULT NULL,
  `code` int(11) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `status` int(11) NOT NULL,
  `demand_status` varchar(255) NOT NULL DEFAULT 'New',
  `reference_id` varchar(255) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `total_work_experience` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `user_type`, `mobile_no`, `code`, `email_verified_at`, `password`, `status`, `demand_status`, `reference_id`, `remember_token`, `created_at`, `updated_at`, `total_work_experience`) VALUES
(1, 'DityaMain', 'info@dityainternational.com', '1', '', NULL, NULL, '$2y$12$6KA/p5gyJfD4DeVAgGbg4OZ0IdvJPcfsI0gX.HnbiD2BlIERZwRL6', 1, 'New', NULL, NULL, '2024-04-18 09:17:40', '2024-04-18 09:17:40', 0),
(3, 'saroj4301', 'sarojsardar255@gmail.com', '1', NULL, NULL, NULL, '$2y$12$QNJGXzvJ/VC.JoMe2x4vw..dhyJF5CbTKyLjD1C/E0L/uGPF1GrmG', 1, 'New', NULL, NULL, '2024-04-21 05:17:57', '2024-04-21 05:17:57', 0),
(4, 'rabina4885', 'rabinasardar@gmail.com', '1', NULL, NULL, NULL, '$2y$12$S3QpUOMAlX7Vz0lIJmCUROdp81EWz8cYOOab/zJidF0x7h1RytaUS', 1, 'New', NULL, NULL, '2024-04-21 05:18:33', '2024-04-21 05:18:33', 0),
(5, 'Tukaatu00008342', 'sarojsardar25@gmail.com', '2', NULL, NULL, NULL, '$2y$10$0abjWgCyrrTiQAimlbgPFO.Zj1sKSMshEzHGMlIQ0vIIZ1qGbaQy2', 1, 'New', NULL, NULL, '2024-04-21 05:25:21', '2024-04-21 05:25:21', 0),
(6, NULL, NULL, '3', '9802343491', NULL, NULL, '$2y$10$IZFSBsky.Q3sygMTT3ZFR.tujkyzuzSzHzl8QFr9nUNXo3ICo/Xu.', 1, 'New', 'DIT-0009', NULL, '2024-04-21 05:37:05', '2024-05-24 10:33:49', 4),
(7, NULL, NULL, '3', '9815310063', NULL, NULL, '$2y$12$cst19L50372hTY4B8E5hmuKLzyuGfIZwFB95NyAzoJC2HFhL.ng5a', 1, 'New', 'DIT-0008', NULL, '2024-04-22 08:46:17', '2024-05-24 03:20:59', 4),
(8, 'medical10196', 'hitecvision.k@gmail.com', '1', NULL, NULL, NULL, '$2y$12$czU15M9RavswZ4JuwdUlAeoZi0fhV8yvDbBC7BY98b7yomtDMFXxC', 1, 'New', NULL, NULL, '2024-05-20 08:03:46', '2024-05-20 08:03:46', 0);

-- --------------------------------------------------------

--
-- Table structure for table `user_details`
--

CREATE TABLE `user_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `full_name` varchar(255) DEFAULT NULL,
  `permanent_address` varchar(255) DEFAULT NULL,
  `temporary_address` varchar(255) DEFAULT NULL,
  `father_name` varchar(255) NOT NULL,
  `mother_name` varchar(255) NOT NULL,
  `marital_status` varchar(255) NOT NULL,
  `spouse_name` varchar(255) DEFAULT NULL,
  `gender` varchar(255) NOT NULL,
  `height` varchar(255) NOT NULL,
  `weight` varchar(255) NOT NULL,
  `dob` varchar(255) NOT NULL,
  `age` int(11) NOT NULL,
  `has_relatives_in_malaysia` tinyint(1) NOT NULL DEFAULT 0,
  `has_been_in_accident` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_details`
--

INSERT INTO `user_details` (`id`, `user_id`, `full_name`, `permanent_address`, `temporary_address`, `father_name`, `mother_name`, `marital_status`, `spouse_name`, `gender`, `height`, `weight`, `dob`, `age`, `has_relatives_in_malaysia`, `has_been_in_accident`, `created_at`, `updated_at`) VALUES
(1, 6, 'Ashsish Giri', 'Itahari', 'Kathmandu', 'Father', 'Mother', 'Married', 'Spouse', 'male', '5.4', '60', '1995/03/04', 29, 0, 0, '2024-04-21 05:38:45', '2024-04-21 05:38:45'),
(2, 7, 'Saroj Sardar', 'Itahari', 'Kathmandu', 'Ahsaram', 'Shiv Kumari', 'Married', 'Rabina', 'male', '5.4', '60', '1995/03/04', 29, 0, 0, '2024-04-22 08:47:21', '2024-04-22 08:47:21');

-- --------------------------------------------------------

--
-- Table structure for table `user_information`
--

CREATE TABLE `user_information` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `middle_name` varchar(255) DEFAULT NULL,
  `full_address` varchar(255) DEFAULT NULL,
  `contact` varchar(255) DEFAULT NULL,
  `father_name` varchar(255) DEFAULT NULL,
  `dob` varchar(255) DEFAULT NULL,
  `profile_picture` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_information`
--

INSERT INTO `user_information` (`id`, `user_id`, `first_name`, `last_name`, `middle_name`, `full_address`, `contact`, `father_name`, `dob`, `profile_picture`, `created_at`, `updated_at`) VALUES
(1, 3, 'Saroj', 'Sardar', '', 'Itahari,Sunsari', '9815310064', NULL, NULL, '1713676676-.png', '2024-04-21 05:17:57', '2024-04-21 05:17:57'),
(2, 4, 'Rabina', 'Sardar', '', 'Itahari,Sunsari', '9823607718', NULL, NULL, '1713676713-.png', '2024-04-21 05:18:33', '2024-04-21 05:18:33'),
(3, 8, 'Medical1', 'Center', '', 'Itahari,Sunsari', '+9779851203349', NULL, NULL, '1716192225-.png', '2024-05-20 08:03:46', '2024-05-20 08:03:46'),
(4, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1716196520-.png', '2024-05-20 09:15:20', '2024-05-20 09:15:20');

-- --------------------------------------------------------

--
-- Table structure for table `web_contents`
--

CREATE TABLE `web_contents` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `chairman_name` varchar(255) DEFAULT NULL,
  `chairman_profile` varchar(255) DEFAULT NULL,
  `chairman_message` longtext DEFAULT NULL,
  `about_us_banner` varchar(255) DEFAULT NULL,
  `about_us_side_banner` varchar(255) DEFAULT NULL,
  `about_us_title` varchar(255) DEFAULT NULL,
  `about_us_content` longtext DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `work_experiences`
--

CREATE TABLE `work_experiences` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `address` varchar(255) NOT NULL,
  `company_name` varchar(255) NOT NULL,
  `position` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `country` varchar(255) NOT NULL,
  `no_of_years` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `work_experiences`
--

INSERT INTO `work_experiences` (`id`, `user_id`, `address`, `company_name`, `position`, `description`, `country`, `no_of_years`, `created_at`, `updated_at`) VALUES
(1, 6, 'Kathmandu', 'Dailomaa', 'Web Developer', 'Frontend Developer', 'Nepal', '2', '2024-04-21 05:39:26', '2024-04-21 05:39:26'),
(2, 6, 'Itahari', 'Kafals Inc', 'Full Stack', 'Full Stack Web Developer', 'Nepal', '2', '2024-04-21 05:39:26', '2024-04-21 05:39:26'),
(3, 7, 'Kathmandu', 'Dailomaa', 'Web Developer', 'Frontend Developer', 'Nepal', '2', '2024-04-22 08:47:39', '2024-04-22 08:47:39'),
(4, 7, 'Itahari', 'Kafals Inc', 'Full Stack', 'Full Stack Web Developer', 'Nepal', '2', '2024-04-22 08:47:39', '2024-04-22 08:47:39');

-- --------------------------------------------------------

--
-- Table structure for table `years`
--

CREATE TABLE `years` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `years`
--

INSERT INTO `years` (`id`, `name`, `slug`, `created_at`, `updated_at`) VALUES
(1, '1', '1', '2024-04-18 09:17:41', '2024-04-18 09:17:41'),
(2, '2', '2', '2024-04-18 09:17:41', '2024-04-18 09:17:41'),
(3, '3', '3', '2024-04-18 09:17:41', '2024-04-18 09:17:41'),
(4, '4', '4', '2024-04-18 09:17:41', '2024-04-18 09:17:41'),
(5, '5', '5', '2024-04-18 09:17:41', '2024-04-18 09:17:41'),
(6, '6', '6', '2024-04-18 09:17:41', '2024-04-18 09:17:41'),
(7, '7', '7', '2024-04-18 09:17:41', '2024-04-18 09:17:41'),
(8, '8', '8', '2024-04-18 09:17:41', '2024-04-18 09:17:41'),
(9, '9', '9', '2024-04-18 09:17:41', '2024-04-18 09:17:41'),
(10, '10', '10', '2024-04-18 09:17:41', '2024-04-18 09:17:41');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bank_details`
--
ALTER TABLE `bank_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bank_details_user_id_foreign` (`user_id`);

--
-- Indexes for table `candidates`
--
ALTER TABLE `candidates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `category_company`
--
ALTER TABLE `category_company`
  ADD PRIMARY KEY (`company_id`,`category_id`),
  ADD KEY `category_company_category_id_foreign` (`category_id`);

--
-- Indexes for table `category_details`
--
ALTER TABLE `category_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_details_user_id_foreign` (`user_id`);

--
-- Indexes for table `client_messages`
--
ALTER TABLE `client_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `comments_user_id_foreign` (`user_id`);

--
-- Indexes for table `companies`
--
ALTER TABLE `companies`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `companies_name_unique` (`name`),
  ADD KEY `companies_user_id_foreign` (`user_id`);

--
-- Indexes for table `company_candidates`
--
ALTER TABLE `company_candidates`
  ADD PRIMARY KEY (`id`),
  ADD KEY `company_candidates_user_id_foreign` (`user_id`),
  ADD KEY `company_candidates_company_id_foreign` (`company_id`);

--
-- Indexes for table `company_demands`
--
ALTER TABLE `company_demands`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `company_demand_language`
--
ALTER TABLE `company_demand_language`
  ADD PRIMARY KEY (`id`),
  ADD KEY `company_demand_language_company_demand_id_foreign` (`company_demand_id`),
  ADD KEY `company_demand_language_language_id_foreign` (`language_id`);

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `educational_documents`
--
ALTER TABLE `educational_documents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `educational_documents_user_id_foreign` (`user_id`);

--
-- Indexes for table `education_types`
--
ALTER TABLE `education_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `gallery_categories`
--
ALTER TABLE `gallery_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gallery_images`
--
ALTER TABLE `gallery_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `gallery_images_category_id_foreign` (`category_id`);

--
-- Indexes for table `genders`
--
ALTER TABLE `genders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `interviews`
--
ALTER TABLE `interviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `interviews_user_id_foreign` (`user_id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `languages`
--
ALTER TABLE `languages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `language_details`
--
ALTER TABLE `language_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `language_details_user_id_foreign` (`user_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `passport_details`
--
ALTER TABLE `passport_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `passport_details_user_id_foreign` (`user_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_mobile_no_index` (`mobile_no`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `portfolios`
--
ALTER TABLE `portfolios`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `resume_details`
--
ALTER TABLE `resume_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `resume_details_user_id_foreign` (`user_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `site_settings`
--
ALTER TABLE `site_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sliders`
--
ALTER TABLE `sliders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `splashes`
--
ALTER TABLE `splashes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `testimonials`
--
ALTER TABLE `testimonials`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `upload_photos`
--
ALTER TABLE `upload_photos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `upload_photos_user_id_foreign` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `user_details`
--
ALTER TABLE `user_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_details_user_id_foreign` (`user_id`);

--
-- Indexes for table `user_information`
--
ALTER TABLE `user_information`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_information_user_id_foreign` (`user_id`);

--
-- Indexes for table `web_contents`
--
ALTER TABLE `web_contents`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `work_experiences`
--
ALTER TABLE `work_experiences`
  ADD PRIMARY KEY (`id`),
  ADD KEY `work_experiences_user_id_foreign` (`user_id`);

--
-- Indexes for table `years`
--
ALTER TABLE `years`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bank_details`
--
ALTER TABLE `bank_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `candidates`
--
ALTER TABLE `candidates`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `category_details`
--
ALTER TABLE `category_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `client_messages`
--
ALTER TABLE `client_messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `companies`
--
ALTER TABLE `companies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `company_candidates`
--
ALTER TABLE `company_candidates`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `company_demands`
--
ALTER TABLE `company_demands`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `company_demand_language`
--
ALTER TABLE `company_demand_language`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=245;

--
-- AUTO_INCREMENT for table `educational_documents`
--
ALTER TABLE `educational_documents`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `education_types`
--
ALTER TABLE `education_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gallery_categories`
--
ALTER TABLE `gallery_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gallery_images`
--
ALTER TABLE `gallery_images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `genders`
--
ALTER TABLE `genders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `interviews`
--
ALTER TABLE `interviews`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT for table `languages`
--
ALTER TABLE `languages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `language_details`
--
ALTER TABLE `language_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=779;

--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `passport_details`
--
ALTER TABLE `passport_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `portfolios`
--
ALTER TABLE `portfolios`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `resume_details`
--
ALTER TABLE `resume_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `site_settings`
--
ALTER TABLE `site_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `sliders`
--
ALTER TABLE `sliders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `splashes`
--
ALTER TABLE `splashes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `testimonials`
--
ALTER TABLE `testimonials`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `upload_photos`
--
ALTER TABLE `upload_photos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `user_details`
--
ALTER TABLE `user_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user_information`
--
ALTER TABLE `user_information`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `web_contents`
--
ALTER TABLE `web_contents`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `work_experiences`
--
ALTER TABLE `work_experiences`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `years`
--
ALTER TABLE `years`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bank_details`
--
ALTER TABLE `bank_details`
  ADD CONSTRAINT `bank_details_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `category_company`
--
ALTER TABLE `category_company`
  ADD CONSTRAINT `category_company_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`),
  ADD CONSTRAINT `category_company_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`);

--
-- Constraints for table `category_details`
--
ALTER TABLE `category_details`
  ADD CONSTRAINT `category_details_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `companies`
--
ALTER TABLE `companies`
  ADD CONSTRAINT `companies_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `company_candidates`
--
ALTER TABLE `company_candidates`
  ADD CONSTRAINT `company_candidates_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `company_candidates_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `company_demand_language`
--
ALTER TABLE `company_demand_language`
  ADD CONSTRAINT `company_demand_language_company_demand_id_foreign` FOREIGN KEY (`company_demand_id`) REFERENCES `company_demands` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `company_demand_language_language_id_foreign` FOREIGN KEY (`language_id`) REFERENCES `languages` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `educational_documents`
--
ALTER TABLE `educational_documents`
  ADD CONSTRAINT `educational_documents_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `gallery_images`
--
ALTER TABLE `gallery_images`
  ADD CONSTRAINT `gallery_images_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `gallery_categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `interviews`
--
ALTER TABLE `interviews`
  ADD CONSTRAINT `interviews_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `language_details`
--
ALTER TABLE `language_details`
  ADD CONSTRAINT `language_details_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `passport_details`
--
ALTER TABLE `passport_details`
  ADD CONSTRAINT `passport_details_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `resume_details`
--
ALTER TABLE `resume_details`
  ADD CONSTRAINT `resume_details_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `upload_photos`
--
ALTER TABLE `upload_photos`
  ADD CONSTRAINT `upload_photos_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_details`
--
ALTER TABLE `user_details`
  ADD CONSTRAINT `user_details_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_information`
--
ALTER TABLE `user_information`
  ADD CONSTRAINT `user_information_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `work_experiences`
--
ALTER TABLE `work_experiences`
  ADD CONSTRAINT `work_experiences_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
