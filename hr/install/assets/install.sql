-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Sep 20, 2017 at 09:56 AM
-- Server version: 10.1.13-MariaDB
-- PHP Version: 5.6.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `eoffice`
--

-- --------------------------------------------------------

--
-- Table structure for table `account`
--

CREATE TABLE `account` (
  `id` int(11) NOT NULL,
  `account` varchar(100) CHARACTER SET latin1 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `account`
--

INSERT INTO `account` (`id`, `account`) VALUES
(1, 'Asset'),
(2, 'Liability'),
(3, 'Equity'),
(4, 'Revenue'),
(5, 'Expense');

-- --------------------------------------------------------

--
-- Table structure for table `account_head`
--

CREATE TABLE `account_head` (
  `id` int(11) NOT NULL,
  `account_title` varchar(100) NOT NULL,
  `account_number` varchar(100) NOT NULL,
  `description` varchar(100) NOT NULL,
  `phone` varchar(100) NOT NULL,
  `address` text NOT NULL,
  `account_type_id` int(5) NOT NULL,
  `balance` decimal(13,2) NOT NULL DEFAULT '0.00',
  `sys` tinyint(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `account_head`
--

INSERT INTO `account_head` (`id`, `account_title`, `account_number`, `description`, `phone`, `address`, `account_type_id`, `balance`, `sys`) VALUES
(1, 'Pety Cash', '', 'Cash and cash equivalents', '', '', 1, '0.00', 0),
(2, 'Accounts Receivable (A/R)', '', 'Accounts Receivable (A/R)', '', '', 2, '0.00', 0),
(4, 'Accounts Payable (A/P)', '', 'Accounts Payable (A/P)', '', '', 5, '0.00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `account_type`
--

CREATE TABLE `account_type` (
  `id` int(11) NOT NULL,
  `account_type` varchar(100) NOT NULL,
  `account_id` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `account_type`
--

INSERT INTO `account_type` (`id`, `account_type`, `account_id`) VALUES
(1, 'Cash and cash equivalents', 1),
(2, 'Accounts receivable (A/R)', 1),
(3, 'Current assets', 1),
(4, 'Fixed assets', 1),
(5, 'Accounts payable (A/P)', 2),
(6, 'Current liabilities', 2),
(7, 'Owner''s equity', 3),
(8, 'Income', 4),
(9, 'Cost of sales', 5),
(10, 'Expenses', 5);

-- --------------------------------------------------------

--
-- Table structure for table `admin_groups`
--

CREATE TABLE `admin_groups` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `name` varchar(20) NOT NULL,
  `description` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `admin_groups`
--

INSERT INTO `admin_groups` (`id`, `name`, `description`) VALUES
(1, 'admin', 'Administrator'),
(2, 'hr', 'HR Manager'),
(3, 'accounts', 'Accounts Manager'),
(4, 'staff', 'HR Staff'),
(5, 'sales', 'Sales Staff');

-- --------------------------------------------------------

--
-- Table structure for table `admin_login_attempts`
--

CREATE TABLE `admin_login_attempts` (
  `id` int(11) UNSIGNED NOT NULL,
  `ip_address` varchar(15) NOT NULL,
  `login` varchar(100) NOT NULL,
  `time` int(11) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `admin_users`
--

CREATE TABLE `admin_users` (
  `id` int(11) UNSIGNED NOT NULL,
  `ip_address` varchar(15) NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `salt` varchar(255) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `activation_code` varchar(40) DEFAULT NULL,
  `forgotten_password_code` varchar(40) DEFAULT NULL,
  `forgotten_password_time` int(11) UNSIGNED DEFAULT NULL,
  `remember_code` varchar(40) DEFAULT NULL,
  `created_on` int(11) UNSIGNED NOT NULL,
  `last_login` int(11) UNSIGNED DEFAULT NULL,
  `active` tinyint(1) UNSIGNED DEFAULT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `type` varchar(10) NOT NULL DEFAULT 'admin'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `admin_users`
--

INSERT INTO `admin_users` (`id`, `ip_address`, `username`, `password`, `salt`, `email`, `activation_code`, `forgotten_password_code`, `forgotten_password_time`, `remember_code`, `created_on`, `last_login`, `active`, `first_name`, `last_name`, `type`) VALUES
(2, '127.0.0.1', 'admin', '$2y$08$cM1mOrdVoCs9Euvq7pkEUO27eItEiyVUiMDP2im9RlGrdKRWxnADK', NULL, 'admin@admin.com', NULL, NULL, NULL, 'LZPAsjX0iOrkpOh.itgKee', 1451900228, 1505894033, 1, 'Shawn', 'Wendt', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `admin_users_groups`
--

CREATE TABLE `admin_users_groups` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `group_id` mediumint(8) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `admin_users_groups`
--

INSERT INTO `admin_users_groups` (`id`, `user_id`, `group_id`) VALUES
(2, 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `assets`
--

CREATE TABLE `assets` (
  `id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `purchase_year` date NOT NULL,
  `cost` decimal(13,2) NOT NULL,
  `lifespan` int(3) NOT NULL,
  `salvage_value` decimal(13,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32;

-- --------------------------------------------------------

--
-- Table structure for table `ci_sessions`
--

CREATE TABLE `ci_sessions` (
  `id` varchar(40) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `data` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ci_sessions`
--

INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES
('9d677af32d69d4a90a8bd986da76d959a78a007e', '::1', 1502770208, 0x5f5f63695f6c6173745f726567656e65726174657c693a313530323737303230323b6964656e746974797c733a353a2261646d696e223b757365726e616d657c733a353a2261646d696e223b656d61696c7c733a31353a2261646d696e4061646d696e2e636f6d223b757365725f69647c733a313a2232223b6f6c645f6c6173745f6c6f67696e7c733a31303a2231353032373131373433223b),
('6a4748755106496854ea02f72425060a3008d89a', '::1', 1505894113, 0x5f5f63695f6c6173745f726567656e65726174657c693a313530353839343032363b6964656e746974797c733a353a2261646d696e223b757365726e616d657c733a353a2261646d696e223b656d61696c7c733a31353a2261646d696e4061646d696e2e636f6d223b757365725f69647c733a313a2232223b6f6c645f6c6173745f6c6f67696e7c733a31303a2231353032373730323036223b);

-- --------------------------------------------------------

--
-- Table structure for table `component`
--

CREATE TABLE `component` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `component_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE `countries` (
  `id` int(5) NOT NULL,
  `country_code` char(2) NOT NULL DEFAULT '',
  `country` varchar(45) NOT NULL DEFAULT '',
  `currency_code` char(3) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`id`, `country_code`, `country`, `currency_code`) VALUES
(1, 'AD', 'Andorra', 'EUR'),
(2, 'AE', 'United Arab Emirates', 'AED'),
(3, 'AF', 'Afghanistan', 'AFN'),
(4, 'AG', 'Antigua and Barbuda', 'XCD'),
(5, 'AI', 'Anguilla', 'XCD'),
(6, 'AL', 'Albania', 'ALL'),
(7, 'AM', 'Armenia', 'AMD'),
(8, 'AO', 'Angola', 'AOA'),
(9, 'AQ', 'Antarctica', ''),
(10, 'AR', 'Argentina', 'ARS'),
(11, 'AS', 'American Samoa', 'USD'),
(12, 'AT', 'Austria', 'EUR'),
(13, 'AU', 'Australia', 'AUD'),
(14, 'AW', 'Aruba', 'AWG'),
(15, 'AX', 'Åland', 'EUR'),
(16, 'AZ', 'Azerbaijan', 'AZN'),
(17, 'BA', 'Bosnia and Herzegovina', 'BAM'),
(18, 'BB', 'Barbados', 'BBD'),
(19, 'BD', 'Bangladesh', 'BDT'),
(20, 'BE', 'Belgium', 'EUR'),
(21, 'BF', 'Burkina Faso', 'XOF'),
(22, 'BG', 'Bulgaria', 'BGN'),
(23, 'BH', 'Bahrain', 'BHD'),
(24, 'BI', 'Burundi', 'BIF'),
(25, 'BJ', 'Benin', 'XOF'),
(26, 'BL', 'Saint Barthélemy', 'EUR'),
(27, 'BM', 'Bermuda', 'BMD'),
(28, 'BN', 'Brunei', 'BND'),
(29, 'BO', 'Bolivia', 'BOB'),
(30, 'BQ', 'Bonaire', 'USD'),
(31, 'BR', 'Brazil', 'BRL'),
(32, 'BS', 'Bahamas', 'BSD'),
(33, 'BT', 'Bhutan', 'BTN'),
(34, 'BV', 'Bouvet Island', 'NOK'),
(35, 'BW', 'Botswana', 'BWP'),
(36, 'BY', 'Belarus', 'BYR'),
(37, 'BZ', 'Belize', 'BZD'),
(38, 'CA', 'Canada', 'CAD'),
(39, 'CC', 'Cocos [Keeling] Islands', 'AUD'),
(40, 'CD', 'Democratic Republic of the Congo', 'CDF'),
(41, 'CF', 'Central African Republic', 'XAF'),
(42, 'CG', 'Republic of the Congo', 'XAF'),
(43, 'CH', 'Switzerland', 'CHF'),
(44, 'CI', 'Ivory Coast', 'XOF'),
(45, 'CK', 'Cook Islands', 'NZD'),
(46, 'CL', 'Chile', 'CLP'),
(47, 'CM', 'Cameroon', 'XAF'),
(48, 'CN', 'China', 'CNY'),
(49, 'CO', 'Colombia', 'COP'),
(50, 'CR', 'Costa Rica', 'CRC'),
(51, 'CU', 'Cuba', 'CUP'),
(52, 'CV', 'Cape Verde', 'CVE'),
(53, 'CW', 'Curacao', 'ANG'),
(54, 'CX', 'Christmas Island', 'AUD'),
(55, 'CY', 'Cyprus', 'EUR'),
(56, 'CZ', 'Czech Republic', 'CZK'),
(57, 'DE', 'Germany', 'EUR'),
(58, 'DJ', 'Djibouti', 'DJF'),
(59, 'DK', 'Denmark', 'DKK'),
(60, 'DM', 'Dominica', 'XCD'),
(61, 'DO', 'Dominican Republic', 'DOP'),
(62, 'DZ', 'Algeria', 'DZD'),
(63, 'EC', 'Ecuador', 'USD'),
(64, 'EE', 'Estonia', 'EUR'),
(65, 'EG', 'Egypt', 'EGP'),
(66, 'EH', 'Western Sahara', 'MAD'),
(67, 'ER', 'Eritrea', 'ERN'),
(68, 'ES', 'Spain', 'EUR'),
(69, 'ET', 'Ethiopia', 'ETB'),
(70, 'FI', 'Finland', 'EUR'),
(71, 'FJ', 'Fiji', 'FJD'),
(72, 'FK', 'Falkland Islands', 'FKP'),
(73, 'FM', 'Micronesia', 'USD'),
(74, 'FO', 'Faroe Islands', 'DKK'),
(75, 'FR', 'France', 'EUR'),
(76, 'GA', 'Gabon', 'XAF'),
(77, 'GB', 'United Kingdom', 'GBP'),
(78, 'GD', 'Grenada', 'XCD'),
(79, 'GE', 'Georgia', 'GEL'),
(80, 'GF', 'French Guiana', 'EUR'),
(81, 'GG', 'Guernsey', 'GBP'),
(82, 'GH', 'Ghana', 'GHS'),
(83, 'GI', 'Gibraltar', 'GIP'),
(84, 'GL', 'Greenland', 'DKK'),
(85, 'GM', 'Gambia', 'GMD'),
(86, 'GN', 'Guinea', 'GNF'),
(87, 'GP', 'Guadeloupe', 'EUR'),
(88, 'GQ', 'Equatorial Guinea', 'XAF'),
(89, 'GR', 'Greece', 'EUR'),
(90, 'GS', 'South Georgia and the South Sandwich Islands', 'GBP'),
(91, 'GT', 'Guatemala', 'GTQ'),
(92, 'GU', 'Guam', 'USD'),
(93, 'GW', 'Guinea-Bissau', 'XOF'),
(94, 'GY', 'Guyana', 'GYD'),
(95, 'HK', 'Hong Kong', 'HKD'),
(96, 'HM', 'Heard Island and McDonald Islands', 'AUD'),
(97, 'HN', 'Honduras', 'HNL'),
(98, 'HR', 'Croatia', 'HRK'),
(99, 'HT', 'Haiti', 'HTG'),
(100, 'HU', 'Hungary', 'HUF'),
(101, 'ID', 'Indonesia', 'IDR'),
(102, 'IE', 'Ireland', 'EUR'),
(103, 'IL', 'Israel', 'ILS'),
(104, 'IM', 'Isle of Man', 'GBP'),
(105, 'IN', 'India', 'INR'),
(106, 'IO', 'British Indian Ocean Territory', 'USD'),
(107, 'IQ', 'Iraq', 'IQD'),
(108, 'IR', 'Iran', 'IRR'),
(109, 'IS', 'Iceland', 'ISK'),
(110, 'IT', 'Italy', 'EUR'),
(111, 'JE', 'Jersey', 'GBP'),
(112, 'JM', 'Jamaica', 'JMD'),
(113, 'JO', 'Jordan', 'JOD'),
(114, 'JP', 'Japan', 'JPY'),
(115, 'KE', 'Kenya', 'KES'),
(116, 'KG', 'Kyrgyzstan', 'KGS'),
(117, 'KH', 'Cambodia', 'KHR'),
(118, 'KI', 'Kiribati', 'AUD'),
(119, 'KM', 'Comoros', 'KMF'),
(120, 'KN', 'Saint Kitts and Nevis', 'XCD'),
(121, 'KP', 'North Korea', 'KPW'),
(122, 'KR', 'South Korea', 'KRW'),
(123, 'KW', 'Kuwait', 'KWD'),
(124, 'KY', 'Cayman Islands', 'KYD'),
(125, 'KZ', 'Kazakhstan', 'KZT'),
(126, 'LA', 'Laos', 'LAK'),
(127, 'LB', 'Lebanon', 'LBP'),
(128, 'LC', 'Saint Lucia', 'XCD'),
(129, 'LI', 'Liechtenstein', 'CHF'),
(130, 'LK', 'Sri Lanka', 'LKR'),
(131, 'LR', 'Liberia', 'LRD'),
(132, 'LS', 'Lesotho', 'LSL'),
(133, 'LT', 'Lithuania', 'EUR'),
(134, 'LU', 'Luxembourg', 'EUR'),
(135, 'LV', 'Latvia', 'EUR'),
(136, 'LY', 'Libya', 'LYD'),
(137, 'MA', 'Morocco', 'MAD'),
(138, 'MC', 'Monaco', 'EUR'),
(139, 'MD', 'Moldova', 'MDL'),
(140, 'ME', 'Montenegro', 'EUR'),
(141, 'MF', 'Saint Martin', 'EUR'),
(142, 'MG', 'Madagascar', 'MGA'),
(143, 'MH', 'Marshall Islands', 'USD'),
(144, 'MK', 'Macedonia', 'MKD'),
(145, 'ML', 'Mali', 'XOF'),
(146, 'MM', 'Myanmar [Burma]', 'MMK'),
(147, 'MN', 'Mongolia', 'MNT'),
(148, 'MO', 'Macao', 'MOP'),
(149, 'MP', 'Northern Mariana Islands', 'USD'),
(150, 'MQ', 'Martinique', 'EUR'),
(151, 'MR', 'Mauritania', 'MRO'),
(152, 'MS', 'Montserrat', 'XCD'),
(153, 'MT', 'Malta', 'EUR'),
(154, 'MU', 'Mauritius', 'MUR'),
(155, 'MV', 'Maldives', 'MVR'),
(156, 'MW', 'Malawi', 'MWK'),
(157, 'MX', 'Mexico', 'MXN'),
(158, 'MY', 'Malaysia', 'MYR'),
(159, 'MZ', 'Mozambique', 'MZN'),
(160, 'NA', 'Namibia', 'NAD'),
(161, 'NC', 'New Caledonia', 'XPF'),
(162, 'NE', 'Niger', 'XOF'),
(163, 'NF', 'Norfolk Island', 'AUD'),
(164, 'NG', 'Nigeria', 'NGN'),
(165, 'NI', 'Nicaragua', 'NIO'),
(166, 'NL', 'Netherlands', 'EUR'),
(167, 'NO', 'Norway', 'NOK'),
(168, 'NP', 'Nepal', 'NPR'),
(169, 'NR', 'Nauru', 'AUD'),
(170, 'NU', 'Niue', 'NZD'),
(171, 'NZ', 'New Zealand', 'NZD'),
(172, 'OM', 'Oman', 'OMR'),
(173, 'PA', 'Panama', 'PAB'),
(174, 'PE', 'Peru', 'PEN'),
(175, 'PF', 'French Polynesia', 'XPF'),
(176, 'PG', 'Papua New Guinea', 'PGK'),
(177, 'PH', 'Philippines', 'PHP'),
(178, 'PK', 'Pakistan', 'PKR'),
(179, 'PL', 'Poland', 'PLN'),
(180, 'PM', 'Saint Pierre and Miquelon', 'EUR'),
(181, 'PN', 'Pitcairn Islands', 'NZD'),
(182, 'PR', 'Puerto Rico', 'USD'),
(183, 'PS', 'Palestine', 'ILS'),
(184, 'PT', 'Portugal', 'EUR'),
(185, 'PW', 'Palau', 'USD'),
(186, 'PY', 'Paraguay', 'PYG'),
(187, 'QA', 'Qatar', 'QAR'),
(188, 'RE', 'Réunion', 'EUR'),
(189, 'RO', 'Romania', 'RON'),
(190, 'RS', 'Serbia', 'RSD'),
(191, 'RU', 'Russia', 'RUB'),
(192, 'RW', 'Rwanda', 'RWF'),
(193, 'SA', 'Saudi Arabia', 'SAR'),
(194, 'SB', 'Solomon Islands', 'SBD'),
(195, 'SC', 'Seychelles', 'SCR'),
(196, 'SD', 'Sudan', 'SDG'),
(197, 'SE', 'Sweden', 'SEK'),
(198, 'SG', 'Singapore', 'SGD'),
(199, 'SH', 'Saint Helena', 'SHP'),
(200, 'SI', 'Slovenia', 'EUR'),
(201, 'SJ', 'Svalbard and Jan Mayen', 'NOK'),
(202, 'SK', 'Slovakia', 'EUR'),
(203, 'SL', 'Sierra Leone', 'SLL'),
(204, 'SM', 'San Marino', 'EUR'),
(205, 'SN', 'Senegal', 'XOF'),
(206, 'SO', 'Somalia', 'SOS'),
(207, 'SR', 'Suriname', 'SRD'),
(208, 'SS', 'South Sudan', 'SSP'),
(209, 'ST', 'São Tomé and Príncipe', 'STD'),
(210, 'SV', 'El Salvador', 'USD'),
(211, 'SX', 'Sint Maarten', 'ANG'),
(212, 'SY', 'Syria', 'SYP'),
(213, 'SZ', 'Swaziland', 'SZL'),
(214, 'TC', 'Turks and Caicos Islands', 'USD'),
(215, 'TD', 'Chad', 'XAF'),
(216, 'TF', 'French Southern Territories', 'EUR'),
(217, 'TG', 'Togo', 'XOF'),
(218, 'TH', 'Thailand', 'THB'),
(219, 'TJ', 'Tajikistan', 'TJS'),
(220, 'TK', 'Tokelau', 'NZD'),
(221, 'TL', 'East Timor', 'USD'),
(222, 'TM', 'Turkmenistan', 'TMT'),
(223, 'TN', 'Tunisia', 'TND'),
(224, 'TO', 'Tonga', 'TOP'),
(225, 'TR', 'Turkey', 'TRY'),
(226, 'TT', 'Trinidad and Tobago', 'TTD'),
(227, 'TV', 'Tuvalu', 'AUD'),
(228, 'TW', 'Taiwan', 'TWD'),
(229, 'TZ', 'Tanzania', 'TZS'),
(230, 'UA', 'Ukraine', 'UAH'),
(231, 'UG', 'Uganda', 'UGX'),
(232, 'UM', 'U.S. Minor Outlying Islands', 'USD'),
(233, 'US', 'United States', 'USD'),
(234, 'UY', 'Uruguay', 'UYU'),
(235, 'UZ', 'Uzbekistan', 'UZS'),
(236, 'VA', 'Vatican City', 'EUR'),
(237, 'VC', 'Saint Vincent and the Grenadines', 'XCD'),
(238, 'VE', 'Venezuela', 'VEF'),
(239, 'VG', 'British Virgin Islands', 'USD'),
(240, 'VI', 'U.S. Virgin Islands', 'USD'),
(241, 'VN', 'Vietnam', 'VND'),
(242, 'VU', 'Vanuatu', 'VUV'),
(243, 'WF', 'Wallis and Futuna', 'XPF'),
(244, 'WS', 'Samoa', 'WST'),
(245, 'XK', 'Kosovo', 'EUR'),
(246, 'YE', 'Yemen', 'YER'),
(247, 'YT', 'Mayotte', 'EUR'),
(248, 'ZA', 'South Africa', 'ZAR'),
(249, 'ZM', 'Zambia', 'ZMW'),
(250, 'ZW', 'Zimbabwe', 'ZWL');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `id` int(11) NOT NULL,
  `customer_code` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `company_name` varchar(100) NOT NULL,
  `phone` varchar(100) NOT NULL,
  `fax` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `website` varchar(100) NOT NULL,
  `b_address` text NOT NULL,
  `s_address` text NOT NULL,
  `note` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `id` int(11) NOT NULL,
  `department` varchar(100) NOT NULL,
  `description` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `depreciation`
--

CREATE TABLE `depreciation` (
  `id` int(11) NOT NULL,
  `asset_id` int(11) NOT NULL,
  `year` varchar(10) NOT NULL,
  `beginning_value` decimal(13,2) NOT NULL,
  `depreciate_cost` decimal(13,2) NOT NULL,
  `depreciate_rate` decimal(13,2) NOT NULL,
  `depreciation_expense` decimal(13,2) NOT NULL,
  `accumulated` decimal(13,2) NOT NULL,
  `ending_value` decimal(13,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32;

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE `employee` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `marital_status` enum('Singel','Married','','') NOT NULL,
  `date_of_birth` varchar(100) NOT NULL,
  `country` varchar(100) NOT NULL,
  `blood_group` enum('None','A','B','AB','O') NOT NULL,
  `id_number` varchar(100) NOT NULL,
  `religious` enum('Christians','Muslims','Hindus','Buddhists','Jews') NOT NULL,
  `gender` enum('Male','Female') NOT NULL,
  `photo` varchar(100) NOT NULL,
  `joined_date` date NOT NULL,
  `probation_end_date` date NOT NULL,
  `date_of_permanency` date NOT NULL,
  `personal_attachment` longtext NOT NULL,
  `contact_details` longtext NOT NULL,
  `emergency_contact` longtext NOT NULL,
  `dependents` longtext NOT NULL,
  `department` int(11) DEFAULT NULL,
  `title` int(11) DEFAULT NULL,
  `category` int(11) DEFAULT NULL,
  `employment_status` int(11) DEFAULT NULL,
  `work_shift` int(11) DEFAULT NULL,
  `deposit` text NOT NULL,
  `date_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `termination` tinyint(2) NOT NULL DEFAULT '1',
  `termination_note` text NOT NULL,
  `soft_delete` tinyint(2) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `employee_award`
--

CREATE TABLE `employee_award` (
  `id` int(11) NOT NULL,
  `award_name` varchar(200) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `department_id` int(11) NOT NULL,
  `gift_item` varchar(100) NOT NULL,
  `award_amount` decimal(13,2) NOT NULL,
  `award_month` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `emp_status`
--

CREATE TABLE `emp_status` (
  `id` int(11) NOT NULL,
  `status_name` varchar(128) CHARACTER SET latin1 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `color` varchar(7) DEFAULT NULL,
  `start` datetime NOT NULL,
  `end` datetime DEFAULT NULL,
  `employee_id` int(11) NOT NULL,
  `type` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `name` varchar(20) NOT NULL,
  `description` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`id`, `name`, `description`) VALUES
(1, 'members', 'General User');

-- --------------------------------------------------------

--
-- Table structure for table `holidays`
--

CREATE TABLE `holidays` (
  `holiday_id` int(11) NOT NULL,
  `event_name` varchar(128) NOT NULL,
  `description` text NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `inbox`
--

CREATE TABLE `inbox` (
  `id` int(11) NOT NULL,
  `to_emp_id` int(11) NOT NULL,
  `to_type` enum('admin','employee') NOT NULL,
  `from_emp_id` int(11) NOT NULL,
  `from_type` enum('admin','employee') NOT NULL,
  `cc` text NOT NULL,
  `sender_name` varchar(200) NOT NULL,
  `subject` varchar(200) NOT NULL,
  `msg` text NOT NULL,
  `attachment` text NOT NULL,
  `attachment_id` varchar(200) NOT NULL,
  `rating` tinyint(2) NOT NULL DEFAULT '0',
  `reading` tinyint(2) NOT NULL DEFAULT '0',
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `job_category`
--

CREATE TABLE `job_category` (
  `id` int(11) NOT NULL,
  `category_name` varchar(128) CHARACTER SET latin1 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `job_history`
--

CREATE TABLE `job_history` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `effective_from` date NOT NULL,
  `department` int(5) NOT NULL,
  `title` int(5) NOT NULL,
  `category` int(5) NOT NULL,
  `employment_status` int(5) NOT NULL,
  `work_shift` int(5) NOT NULL,
  `status` tinyint(2) NOT NULL DEFAULT '0',
  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `job_title`
--

CREATE TABLE `job_title` (
  `id` int(11) NOT NULL,
  `job_title` varchar(100) NOT NULL,
  `description` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `language`
--

CREATE TABLE `language` (
  `id` int(5) NOT NULL,
  `code` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `icon` varchar(255) NOT NULL,
  `active` tinyint(2) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `language`
--

INSERT INTO `language` (`id`, `code`, `name`, `icon`, `active`) VALUES
(1, 'en', 'english', 'us', 1);

-- --------------------------------------------------------

--
-- Table structure for table `leave_application`
--

CREATE TABLE `leave_application` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `leave_ctegory_id` int(11) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `reason` varchar(250) NOT NULL,
  `status` enum('Pending','Accepted','Rejected','') NOT NULL DEFAULT 'Pending',
  `application_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `leave_application_type`
--

CREATE TABLE `leave_application_type` (
  `id` int(11) NOT NULL,
  `leave_category` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `leave_category`
--

CREATE TABLE `leave_category` (
  `leave_category_id` int(2) NOT NULL,
  `category` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `locales`
--

CREATE TABLE `locales` (
  `locale` varchar(10) NOT NULL,
  `code` varchar(10) DEFAULT NULL,
  `language` varchar(100) DEFAULT NULL,
  `name` varchar(250) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `locales`
--

INSERT INTO `locales` (`locale`, `code`, `language`, `name`) VALUES
('aa_DJ', 'aa', 'afar', 'Afar (Djibouti)'),
('aa_ER', 'aa', 'afar', 'Afar (Eritrea)'),
('aa_ET', 'aa', 'afar', 'Afar (Ethiopia)'),
('af_ZA', 'af', 'afrikaans', 'Afrikaans (South Africa)'),
('am_ET', 'am', 'amharic', 'Amharic (Ethiopia)'),
('an_ES', 'an', 'aragonese', 'Aragonese (Spain)'),
('ar_AE', 'ar', 'arabic', 'Arabic (United Arab Emirates)'),
('ar_BH', 'ar', 'arabic', 'Arabic (Bahrain)'),
('ar_DZ', 'ar', 'arabic', 'Arabic (Algeria)'),
('ar_EG', 'ar', 'arabic', 'Arabic (Egypt)'),
('ar_IN', 'ar', 'arabic', 'Arabic (India)'),
('ar_IQ', 'ar', 'arabic', 'Arabic (Iraq)'),
('ar_JO', 'ar', 'arabic', 'Arabic (Jordan)'),
('ar_KW', 'ar', 'arabic', 'Arabic (Kuwait)'),
('ar_LB', 'ar', 'arabic', 'Arabic (Lebanon)'),
('ar_LY', 'ar', 'arabic', 'Arabic (Libya)'),
('ar_MA', 'ar', 'arabic', 'Arabic (Morocco)'),
('ar_OM', 'ar', 'arabic', 'Arabic (Oman)'),
('ar_QA', 'ar', 'arabic', 'Arabic (Qatar)'),
('ar_SA', 'ar', 'arabic', 'Arabic (Saudi Arabia)'),
('ar_SD', 'ar', 'arabic', 'Arabic (Sudan)'),
('ar_SY', 'ar', 'arabic', 'Arabic (Syria)'),
('ar_TN', 'ar', 'arabic', 'Arabic (Tunisia)'),
('ar_YE', 'ar', 'arabic', 'Arabic (Yemen)'),
('ast_ES', 'ast', 'asturian', 'Asturian (Spain)'),
('as_IN', 'as', 'assamese', 'Assamese (India)'),
('az_AZ', 'az', 'azerbaijani', 'Azerbaijani (Azerbaijan)'),
('az_TR', 'az', 'azerbaijani', 'Azerbaijani (Turkey)'),
('bem_ZM', 'bem', 'bemba', 'Bemba (Zambia)'),
('ber_DZ', 'ber', 'berber', 'Berber (Algeria)'),
('ber_MA', 'ber', 'berber', 'Berber (Morocco)'),
('be_BY', 'be', 'belarusian', 'Belarusian (Belarus)'),
('bg_BG', 'bg', 'bulgarian', 'Bulgarian (Bulgaria)'),
('bn_BD', 'bn', 'bengali', 'Bengali (Bangladesh)'),
('bn_IN', 'bn', 'bengali', 'Bengali (India)'),
('bo_CN', 'bo', 'tibetan', 'Tibetan (China)'),
('bo_IN', 'bo', 'tibetan', 'Tibetan (India)'),
('br_FR', 'br', 'breton', 'Breton (France)'),
('bs_BA', 'bs', 'bosnian', 'Bosnian (Bosnia and Herzegovina)'),
('byn_ER', 'byn', 'blin', 'Blin (Eritrea)'),
('ca_AD', 'ca', 'catalan', 'Catalan (Andorra)'),
('ca_ES', 'ca', 'catalan', 'Catalan (Spain)'),
('ca_FR', 'ca', 'catalan', 'Catalan (France)'),
('ca_IT', 'ca', 'catalan', 'Catalan (Italy)'),
('crh_UA', 'crh', 'crimean turkish', 'Crimean Turkish (Ukraine)'),
('csb_PL', 'csb', 'kashubian', 'Kashubian (Poland)'),
('cs_CZ', 'cs', 'czech', 'Czech (Czech Republic)'),
('cv_RU', 'cv', 'chuvash', 'Chuvash (Russia)'),
('cy_GB', 'cy', 'welsh', 'Welsh (United Kingdom)'),
('da_DK', 'da', 'danish', 'Danish (Denmark)'),
('de_AT', 'de', 'german', 'German (Austria)'),
('de_BE', 'de', 'german', 'German (Belgium)'),
('de_CH', 'de', 'german', 'German (Switzerland)'),
('de_DE', 'de', 'german', 'German (Germany)'),
('de_LI', 'de', 'german', 'German (Liechtenstein)'),
('de_LU', 'de', 'german', 'German (Luxembourg)'),
('dv_MV', 'dv', 'divehi', 'Divehi (Maldives)'),
('dz_BT', 'dz', 'dzongkha', 'Dzongkha (Bhutan)'),
('ee_GH', 'ee', 'ewe', 'Ewe (Ghana)'),
('el_CY', 'el', 'greek', 'Greek (Cyprus)'),
('el_GR', 'el', 'greek', 'Greek (Greece)'),
('en_AG', 'en', 'english', 'English (Antigua and Barbuda)'),
('en_AS', 'en', 'english', 'English (American Samoa)'),
('en_AU', 'en', 'english', 'English (Australia)'),
('en_BW', 'en', 'english', 'English (Botswana)'),
('en_CA', 'en', 'english', 'English (Canada)'),
('en_DK', 'en', 'english', 'English (Denmark)'),
('en_GB', 'en', 'english', 'English (United Kingdom)'),
('en_GU', 'en', 'english', 'English (Guam)'),
('en_HK', 'en', 'english', 'English (Hong Kong SAR China)'),
('en_IE', 'en', 'english', 'English (Ireland)'),
('en_IN', 'en', 'english', 'English (India)'),
('en_JM', 'en', 'english', 'English (Jamaica)'),
('en_MH', 'en', 'english', 'English (Marshall Islands)'),
('en_MP', 'en', 'english', 'English (Northern Mariana Islands)'),
('en_MU', 'en', 'english', 'English (Mauritius)'),
('en_NG', 'en', 'english', 'English (Nigeria)'),
('en_NZ', 'en', 'english', 'English (New Zealand)'),
('en_PH', 'en', 'english', 'English (Philippines)'),
('en_SG', 'en', 'english', 'English (Singapore)'),
('en_TT', 'en', 'english', 'English (Trinidad and Tobago)'),
('en_US', 'en', 'english', 'English (United States)'),
('en_VI', 'en', 'english', 'English (Virgin Islands)'),
('en_ZA', 'en', 'english', 'English (South Africa)'),
('en_ZM', 'en', 'english', 'English (Zambia)'),
('en_ZW', 'en', 'english', 'English (Zimbabwe)'),
('eo', 'eo', 'esperanto', 'Esperanto'),
('es_AR', 'es', 'spanish', 'Spanish (Argentina)'),
('es_BO', 'es', 'spanish', 'Spanish (Bolivia)'),
('es_CL', 'es', 'spanish', 'Spanish (Chile)'),
('es_CO', 'es', 'spanish', 'Spanish (Colombia)'),
('es_CR', 'es', 'spanish', 'Spanish (Costa Rica)'),
('es_DO', 'es', 'spanish', 'Spanish (Dominican Republic)'),
('es_EC', 'es', 'spanish', 'Spanish (Ecuador)'),
('es_ES', 'es', 'spanish', 'Spanish (Spain)'),
('es_GT', 'es', 'spanish', 'Spanish (Guatemala)'),
('es_HN', 'es', 'spanish', 'Spanish (Honduras)'),
('es_MX', 'es', 'spanish', 'Spanish (Mexico)'),
('es_NI', 'es', 'spanish', 'Spanish (Nicaragua)'),
('es_PA', 'es', 'spanish', 'Spanish (Panama)'),
('es_PE', 'es', 'spanish', 'Spanish (Peru)'),
('es_PR', 'es', 'spanish', 'Spanish (Puerto Rico)'),
('es_PY', 'es', 'spanish', 'Spanish (Paraguay)'),
('es_SV', 'es', 'spanish', 'Spanish (El Salvador)'),
('es_US', 'es', 'spanish', 'Spanish (United States)'),
('es_UY', 'es', 'spanish', 'Spanish (Uruguay)'),
('es_VE', 'es', 'spanish', 'Spanish (Venezuela)'),
('et_EE', 'et', 'estonian', 'Estonian (Estonia)'),
('eu_ES', 'eu', 'basque', 'Basque (Spain)'),
('eu_FR', 'eu', 'basque', 'Basque (France)'),
('fa_AF', 'fa', 'persian', 'Persian (Afghanistan)'),
('fa_IR', 'fa', 'persian', 'Persian (Iran)'),
('ff_SN', 'ff', 'fulah', 'Fulah (Senegal)'),
('fil_PH', 'fil', 'filipino', 'Filipino (Philippines)'),
('fi_FI', 'fi', 'finnish', 'Finnish (Finland)'),
('fo_FO', 'fo', 'faroese', 'Faroese (Faroe Islands)'),
('fr_BE', 'fr', 'french', 'French (Belgium)'),
('fr_BF', 'fr', 'french', 'French (Burkina Faso)'),
('fr_BI', 'fr', 'french', 'French (Burundi)'),
('fr_BJ', 'fr', 'french', 'French (Benin)'),
('fr_CA', 'fr', 'french', 'French (Canada)'),
('fr_CF', 'fr', 'french', 'French (Central African Republic)'),
('fr_CG', 'fr', 'french', 'French (Congo)'),
('fr_CH', 'fr', 'french', 'French (Switzerland)'),
('fr_CM', 'fr', 'french', 'French (Cameroon)'),
('fr_FR', 'fr', 'french', 'French (France)'),
('fr_GA', 'fr', 'french', 'French (Gabon)'),
('fr_GN', 'fr', 'french', 'French (Guinea)'),
('fr_GP', 'fr', 'french', 'French (Guadeloupe)'),
('fr_GQ', 'fr', 'french', 'French (Equatorial Guinea)'),
('fr_KM', 'fr', 'french', 'French (Comoros)'),
('fr_LU', 'fr', 'french', 'French (Luxembourg)'),
('fr_MC', 'fr', 'french', 'French (Monaco)'),
('fr_MG', 'fr', 'french', 'French (Madagascar)'),
('fr_ML', 'fr', 'french', 'French (Mali)'),
('fr_MQ', 'fr', 'french', 'French (Martinique)'),
('fr_NE', 'fr', 'french', 'French (Niger)'),
('fr_SN', 'fr', 'french', 'French (Senegal)'),
('fr_TD', 'fr', 'french', 'French (Chad)'),
('fr_TG', 'fr', 'french', 'French (Togo)'),
('fur_IT', 'fur', 'friulian', 'Friulian (Italy)'),
('fy_DE', 'fy', 'western frisian', 'Western Frisian (Germany)'),
('fy_NL', 'fy', 'western frisian', 'Western Frisian (Netherlands)'),
('ga_IE', 'ga', 'irish', 'Irish (Ireland)'),
('gd_GB', 'gd', 'scottish gaelic', 'Scottish Gaelic (United Kingdom)'),
('gez_ER', 'gez', 'geez', 'Geez (Eritrea)'),
('gez_ET', 'gez', 'geez', 'Geez (Ethiopia)'),
('gl_ES', 'gl', 'galician', 'Galician (Spain)'),
('gu_IN', 'gu', 'gujarati', 'Gujarati (India)'),
('gv_GB', 'gv', 'manx', 'Manx (United Kingdom)'),
('ha_NG', 'ha', 'hausa', 'Hausa (Nigeria)'),
('he_IL', 'he', 'hebrew', 'Hebrew (Israel)'),
('hi_IN', 'hi', 'hindi', 'Hindi (India)'),
('hr_HR', 'hr', 'croatian', 'Croatian (Croatia)'),
('hsb_DE', 'hsb', 'upper sorbian', 'Upper Sorbian (Germany)'),
('ht_HT', 'ht', 'haitian', 'Haitian (Haiti)'),
('hu_HU', 'hu', 'hungarian', 'Hungarian (Hungary)'),
('hy_AM', 'hy', 'armenian', 'Armenian (Armenia)'),
('ia', 'ia', 'interlingua', 'Interlingua'),
('id_ID', 'id', 'indonesian', 'Indonesian (Indonesia)'),
('ig_NG', 'ig', 'igbo', 'Igbo (Nigeria)'),
('ik_CA', 'ik', 'inupiaq', 'Inupiaq (Canada)'),
('is_IS', 'is', 'icelandic', 'Icelandic (Iceland)'),
('it_CH', 'it', 'italian', 'Italian (Switzerland)'),
('it_IT', 'it', 'italian', 'Italian (Italy)'),
('iu_CA', 'iu', 'inuktitut', 'Inuktitut (Canada)'),
('ja_JP', 'ja', 'japanese', 'Japanese (Japan)'),
('ka_GE', 'ka', 'georgian', 'Georgian (Georgia)'),
('kk_KZ', 'kk', 'kazakh', 'Kazakh (Kazakhstan)'),
('kl_GL', 'kl', 'kalaallisut', 'Kalaallisut (Greenland)'),
('km_KH', 'km', 'khmer', 'Khmer (Cambodia)'),
('kn_IN', 'kn', 'kannada', 'Kannada (India)'),
('kok_IN', 'kok', 'konkani', 'Konkani (India)'),
('ko_KR', 'ko', 'korean', 'Korean (South Korea)'),
('ks_IN', 'ks', 'kashmiri', 'Kashmiri (India)'),
('ku_TR', 'ku', 'kurdish', 'Kurdish (Turkey)'),
('kw_GB', 'kw', 'cornish', 'Cornish (United Kingdom)'),
('ky_KG', 'ky', 'kirghiz', 'Kirghiz (Kyrgyzstan)'),
('lg_UG', 'lg', 'ganda', 'Ganda (Uganda)'),
('li_BE', 'li', 'limburgish', 'Limburgish (Belgium)'),
('li_NL', 'li', 'limburgish', 'Limburgish (Netherlands)'),
('lo_LA', 'lo', 'lao', 'Lao (Laos)'),
('lt_LT', 'lt', 'lithuanian', 'Lithuanian (Lithuania)'),
('lv_LV', 'lv', 'latvian', 'Latvian (Latvia)'),
('mai_IN', 'mai', 'maithili', 'Maithili (India)'),
('mg_MG', 'mg', 'malagasy', 'Malagasy (Madagascar)'),
('mi_NZ', 'mi', 'maori', 'Maori (New Zealand)'),
('mk_MK', 'mk', 'macedonian', 'Macedonian (Macedonia)'),
('ml_IN', 'ml', 'malayalam', 'Malayalam (India)'),
('mn_MN', 'mn', 'mongolian', 'Mongolian (Mongolia)'),
('mr_IN', 'mr', 'marathi', 'Marathi (India)'),
('ms_BN', 'ms', 'malay', 'Malay (Brunei)'),
('ms_MY', 'ms', 'malay', 'Malay (Malaysia)'),
('mt_MT', 'mt', 'maltese', 'Maltese (Malta)'),
('my_MM', 'my', 'burmese', 'Burmese (Myanmar)'),
('naq_NA', 'naq', 'namibia', 'Namibia'),
('nb_NO', 'nb', 'norwegian bokm?l', 'Norwegian Bokm?l (Norway)'),
('nds_DE', 'nds', 'low german', 'Low German (Germany)'),
('nds_NL', 'nds', 'low german', 'Low German (Netherlands)'),
('ne_NP', 'ne', 'nepali', 'Nepali (Nepal)'),
('nl_AW', 'nl', 'dutch', 'Dutch (Aruba)'),
('nl_BE', 'nl', 'dutch', 'Dutch (Belgium)'),
('nl_NL', 'nl', 'dutch', 'Dutch (Netherlands)'),
('nn_NO', 'nn', 'norwegian nynorsk', 'Norwegian Nynorsk (Norway)'),
('no_NO', 'no', 'norwegian', 'Norwegian (Norway)'),
('nr_ZA', 'nr', 'south ndebele', 'South Ndebele (South Africa)'),
('nso_ZA', 'nso', 'northern sotho', 'Northern Sotho (South Africa)'),
('oc_FR', 'oc', 'occitan', 'Occitan (France)'),
('om_ET', 'om', 'oromo', 'Oromo (Ethiopia)'),
('om_KE', 'om', 'oromo', 'Oromo (Kenya)'),
('or_IN', 'or', 'oriya', 'Oriya (India)'),
('os_RU', 'os', 'ossetic', 'Ossetic (Russia)'),
('pap_AN', 'pap', 'papiamento', 'Papiamento (Netherlands Antilles)'),
('pa_IN', 'pa', 'punjabi', 'Punjabi (India)'),
('pa_PK', 'pa', 'punjabi', 'Punjabi (Pakistan)'),
('pl_PL', 'pl', 'polish', 'Polish (Poland)'),
('ps_AF', 'ps', 'pashto', 'Pashto (Afghanistan)'),
('pt_BR', 'pt', 'portuguese', 'Portuguese (Brazil)'),
('pt_GW', 'pt', 'portuguese', 'Portuguese (Guinea-Bissau)'),
('pt_PT', 'pt', 'portuguese', 'Portuguese (Portugal)'),
('ro_MD', 'ro', 'romanian', 'Romanian (Moldova)'),
('ro_RO', 'ro', 'romanian', 'Romanian (Romania)'),
('ru_RU', 'ru', 'russian', 'Russian (Russia)'),
('ru_UA', 'ru', 'russian', 'Russian (Ukraine)'),
('rw_RW', 'rw', 'kinyarwanda', 'Kinyarwanda (Rwanda)'),
('sa_IN', 'sa', 'sanskrit', 'Sanskrit (India)'),
('sc_IT', 'sc', 'sardinian', 'Sardinian (Italy)'),
('sd_IN', 'sd', 'sindhi', 'Sindhi (India)'),
('seh_MZ', 'seh', 'sena', 'Sena (Mozambique)'),
('se_NO', 'se', 'northern sami', 'Northern Sami (Norway)'),
('sid_ET', 'sid', 'sidamo', 'Sidamo (Ethiopia)'),
('si_LK', 'si', 'sinhala', 'Sinhala (Sri Lanka)'),
('sk_SK', 'sk', 'slovak', 'Slovak (Slovakia)'),
('sl_SI', 'sl', 'slovenian', 'Slovenian (Slovenia)'),
('sn_ZW', 'sn', 'shona', 'Shona (Zimbabwe)'),
('so_DJ', 'so', 'somali', 'Somali (Djibouti)'),
('so_ET', 'so', 'somali', 'Somali (Ethiopia)'),
('so_KE', 'so', 'somali', 'Somali (Kenya)'),
('so_SO', 'so', 'somali', 'Somali (Somalia)'),
('sq_AL', 'sq', 'albanian', 'Albanian (Albania)'),
('sq_MK', 'sq', 'albanian', 'Albanian (Macedonia)'),
('sr_BA', 'sr', 'serbian', 'Serbian (Bosnia and Herzegovina)'),
('sr_ME', 'sr', 'serbian', 'Serbian (Montenegro)'),
('sr_RS', 'sr', 'serbian', 'Serbian (Serbia)'),
('ss_ZA', 'ss', 'swati', 'Swati (South Africa)'),
('st_ZA', 'st', 'southern sotho', 'Southern Sotho (South Africa)'),
('sv_FI', 'sv', 'swedish', 'Swedish (Finland)'),
('sv_SE', 'sv', 'swedish', 'Swedish (Sweden)'),
('sw_KE', 'sw', 'swahili', 'Swahili (Kenya)'),
('sw_TZ', 'sw', 'swahili', 'Swahili (Tanzania)'),
('ta_IN', 'ta', 'tamil', 'Tamil (India)'),
('teo_UG', 'teo', 'teso', 'Teso (Uganda)'),
('te_IN', 'te', 'telugu', 'Telugu (India)'),
('tg_TJ', 'tg', 'tajik', 'Tajik (Tajikistan)'),
('th_TH', 'th', 'thai', 'Thai (Thailand)'),
('tig_ER', 'tig', 'tigre', 'Tigre (Eritrea)'),
('ti_ER', 'ti', 'tigrinya', 'Tigrinya (Eritrea)'),
('ti_ET', 'ti', 'tigrinya', 'Tigrinya (Ethiopia)'),
('tk_TM', 'tk', 'turkmen', 'Turkmen (Turkmenistan)'),
('tl_PH', 'tl', 'tagalog', 'Tagalog (Philippines)'),
('tn_ZA', 'tn', 'tswana', 'Tswana (South Africa)'),
('to_TO', 'to', 'tongan', 'Tongan (Tonga)'),
('tr_CY', 'tr', 'turkish', 'Turkish (Cyprus)'),
('tr_TR', 'tr', 'turkish', 'Turkish (Turkey)'),
('ts_ZA', 'ts', 'tsonga', 'Tsonga (South Africa)'),
('tt_RU', 'tt', 'tatar', 'Tatar (Russia)'),
('ug_CN', 'ug', 'uighur', 'Uighur (China)'),
('uk_UA', 'uk', 'ukrainian', 'Ukrainian (Ukraine)'),
('ur_PK', 'ur', 'urdu', 'Urdu (Pakistan)'),
('uz_UZ', 'uz', 'uzbek', 'Uzbek (Uzbekistan)'),
('ve_ZA', 've', 'venda', 'Venda (South Africa)'),
('vi_VN', 'vi', 'vietnamese', 'Vietnamese (Vietnam)'),
('wa_BE', 'wa', 'walloon', 'Walloon (Belgium)'),
('wo_SN', 'wo', 'wolof', 'Wolof (Senegal)'),
('xh_ZA', 'xh', 'xhosa', 'Xhosa (South Africa)'),
('yi_US', 'yi', 'yiddish', 'Yiddish (United States)'),
('yo_NG', 'yo', 'yoruba', 'Yoruba (Nigeria)'),
('zh_CN', 'zh', 'chinese', 'Chinese (China)'),
('zh_HK', 'zh', 'chinese', 'Chinese (Hong Kong SAR China)'),
('zh_SG', 'zh', 'chinese', 'Chinese (Singapore)'),
('zh_TW', 'zh', 'chinese', 'Chinese (Taiwan)'),
('zu_ZA', 'zu', 'zulu', 'Zulu (South Africa)');

-- --------------------------------------------------------

--
-- Table structure for table `login_attempts`
--

CREATE TABLE `login_attempts` (
  `id` int(11) UNSIGNED NOT NULL,
  `ip_address` varchar(15) NOT NULL,
  `login` varchar(100) NOT NULL,
  `time` int(11) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `notice`
--

CREATE TABLE `notice` (
  `id` int(11) NOT NULL,
  `title` varchar(150) NOT NULL,
  `short` varchar(300) NOT NULL,
  `description` text NOT NULL,
  `status` enum('Published','UnPublished') NOT NULL DEFAULT 'UnPublished',
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `options`
--

CREATE TABLE `options` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `value` longtext
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `options`
--

INSERT INTO `options` (`id`, `name`, `value`) VALUES
(1, 'company_name', 'eOffice Manager'),
(2, 'address', '360 Edgefield Circle  Butte, MT 59701'),
(3, 'email', 'support@codeslab.net'),
(4, 'city', 'Stamford'),
(5, 'postal_code', '46556'),
(6, 'phone', '203-962-5164'),
(7, 'company_logo', 'codeslab-logo.jpg'),
(8, 'icon', 'favicon.ico'),
(9, 'country', 'United States'),
(10, 'time_zone', 'Asia/Dhaka'),
(11, 'default_currency', 'USD'),
(12, 'currency_symbol', '$'),
(13, 'currency_format', '2'),
(14, 'date_format', 'd M Y'),
(15, 'invoice_prefix', 'Invoice #'),
(16, 'order_prefix', 'Purchase Ref#'),
(17, 'invoice_text', '<p>Thanks for Doing Business with us.<br></p>'),
(18, 'invoice_logo', 'codeslab-logo1.jpg'),
(19, 'smtp_host', 'SMTP Host'),
(20, 'smtp_username', 'company@email.com'),
(21, 'smtp_password', 'SMTP Password'),
(22, 'smtp_port', 'SMTP Port'),
(23, 'mail_sender', 'Codes Lab'),
(24, 'invoice_mail_from', 'sales@codeslab.net'),
(25, 'campaign_mail_from', 'no-replay@codeslab.net'),
(26, 'recovery_mail_from', 'no-replay@codeslab.net'),
(27, 'all_other_mails_from', 'no-replay@codeslab.net'),
(28, 'email_send_option', 'smtp'),
(29, 'login_logo', 'eoffice_logo.png'),
(30, 'login_title', 'Ultimate HRM & Accounts Features '),
(31, 'login_description', 'eOffice is an office management software where you can easily manage your Employee, Accounts, Business Transaction, Manage product, customer, Vendor, Sales and Purchase etc.'),
(32, 'brand', 'eOffice');

-- --------------------------------------------------------

--
-- Table structure for table `order_details`
--

CREATE TABLE `order_details` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_name` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `purchase_cost` decimal(13,2) NOT NULL,
  `sales_cost` decimal(13,2) NOT NULL,
  `tax_amount` decimal(13,2) NOT NULL,
  `qty` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `outbox`
--

CREATE TABLE `outbox` (
  `id` int(11) NOT NULL,
  `from_emp_id` int(11) NOT NULL,
  `from_type` enum('admin','employee') NOT NULL,
  `cc` text NOT NULL,
  `subject` varchar(200) NOT NULL,
  `msg` text NOT NULL,
  `attachment` text NOT NULL,
  `attachment_id` varchar(200) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `id` int(11) NOT NULL,
  `payment_date` varchar(100) NOT NULL,
  `order_id` int(11) NOT NULL,
  `order_ref` varchar(100) NOT NULL,
  `amount` decimal(13,2) NOT NULL,
  `method` varchar(11) NOT NULL,
  `payment_method` varchar(100) NOT NULL,
  `cc_name` varchar(100) DEFAULT NULL,
  `cc_number` varchar(100) DEFAULT NULL,
  `cc_type` varchar(100) DEFAULT NULL,
  `cc_month` varchar(100) DEFAULT NULL,
  `cc_year` varchar(100) DEFAULT NULL,
  `cvc` varchar(100) DEFAULT NULL,
  `payment_ref` varchar(100) DEFAULT NULL,
  `attachment` varchar(100) DEFAULT NULL,
  `received_by` varchar(11) NOT NULL,
  `type` enum('Sales','Purchase') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `payroll`
--

CREATE TABLE `payroll` (
  `id` int(11) NOT NULL,
  `month` varchar(50) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `department_id` int(11) NOT NULL,
  `gross_salary` decimal(13,2) NOT NULL DEFAULT '0.00',
  `deduction` decimal(13,2) NOT NULL DEFAULT '0.00',
  `net_salary` decimal(13,2) NOT NULL DEFAULT '0.00',
  `award` longtext NOT NULL,
  `fine_deduction` decimal(13,2) NOT NULL DEFAULT '0.00',
  `bonus` decimal(13,2) NOT NULL DEFAULT '0.00',
  `payment_method` varchar(100) NOT NULL,
  `note` text NOT NULL,
  `net_payment` decimal(13,2) NOT NULL DEFAULT '0.00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `persons`
--

CREATE TABLE `persons` (
  `id` int(11) UNSIGNED NOT NULL,
  `firstName` varchar(100) DEFAULT NULL,
  `lastName` varchar(100) DEFAULT NULL,
  `gender` enum('male','female') DEFAULT NULL,
  `address` varchar(200) DEFAULT NULL,
  `dob` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `sku` varchar(100) NOT NULL,
  `category_id` int(3) DEFAULT NULL,
  `sales_info` varchar(255) DEFAULT NULL,
  `sales_cost` decimal(13,2) NOT NULL DEFAULT '0.00',
  `buying_info` varchar(255) DEFAULT NULL,
  `buying_cost` decimal(13,2) NOT NULL DEFAULT '0.00',
  `tax_id` int(11) NOT NULL,
  `inventory` int(11) DEFAULT '0',
  `bundle` longtext,
  `p_image` varchar(150) DEFAULT NULL,
  `type` enum('Inventory','Non-Inventory','Service','Bundle') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `product_category`
--

CREATE TABLE `product_category` (
  `id` int(11) NOT NULL,
  `category` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `purchase_details`
--

CREATE TABLE `purchase_details` (
  `id` int(11) NOT NULL,
  `purchase_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_name` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `qty` int(11) NOT NULL,
  `total_received` int(11) NOT NULL DEFAULT '0',
  `return_qty` int(11) NOT NULL,
  `unit_price` decimal(13,2) NOT NULL,
  `sub_total` decimal(13,2) NOT NULL,
  `ref` int(11) NOT NULL,
  `type` enum('Purchase','Return') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `purchase_order`
--

CREATE TABLE `purchase_order` (
  `id` int(11) NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `vendor_name` varchar(100) NOT NULL,
  `email` varchar(100) CHARACTER SET utf8 NOT NULL,
  `b_address` text CHARACTER SET utf8 NOT NULL,
  `cart` longtext CHARACTER SET utf8 NOT NULL,
  `cart_total` decimal(13,2) NOT NULL,
  `discount` decimal(13,2) NOT NULL,
  `tax` decimal(13,2) NOT NULL,
  `shipping` decimal(13,2) NOT NULL,
  `grand_total` decimal(13,2) NOT NULL,
  `paid_amount` decimal(13,2) NOT NULL,
  `due_payment` decimal(13,2) NOT NULL,
  `order_note` text NOT NULL,
  `status` enum('Pending','Partial') CHARACTER SET utf8 NOT NULL,
  `sales_person` varchar(50) NOT NULL,
  `ref` varchar(100) NOT NULL,
  `type` enum('Purchase','Return') NOT NULL,
  `return_ref` int(11) DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `received_product`
--

CREATE TABLE `received_product` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `vendor_name` varchar(100) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_name` varchar(100) NOT NULL,
  `qty` int(11) NOT NULL,
  `receiver` varchar(100) NOT NULL,
  `date_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `salary`
--

CREATE TABLE `salary` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `grade_id` int(11) NOT NULL,
  `comment` longtext NOT NULL,
  `total_payable` double NOT NULL,
  `total_cost_company` double NOT NULL,
  `total_deduction` double NOT NULL,
  `component` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `salary_component`
--

CREATE TABLE `salary_component` (
  `id` int(11) NOT NULL,
  `component_name` varchar(128) CHARACTER SET latin1 NOT NULL,
  `type` int(2) NOT NULL COMMENT '1= Earning; 2= Deduction ',
  `total_payable` int(1) DEFAULT '0',
  `cost_company` int(1) DEFAULT '0',
  `value_type` int(2) NOT NULL COMMENT '1= Amount ; 2= Percentage ',
  `flag` tinyint(2) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `salary_component`
--

INSERT INTO `salary_component` (`id`, `component_name`, `type`, `total_payable`, `cost_company`, `value_type`, `flag`) VALUES
(1, 'Basic Payment', 1, 1, 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `salary_grade`
--

CREATE TABLE `salary_grade` (
  `id` int(11) NOT NULL,
  `grade_name` varchar(100) NOT NULL,
  `min_salary` float NOT NULL,
  `max_salary` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sales_order`
--

CREATE TABLE `sales_order` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `customer_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `b_address` text NOT NULL,
  `s_address` text NOT NULL,
  `invoice_date` varchar(20) NOT NULL,
  `due_date` varchar(20) NOT NULL,
  `cart` longtext NOT NULL,
  `cart_total` decimal(13,2) NOT NULL,
  `grand_total` decimal(13,2) NOT NULL,
  `tax` decimal(13,2) NOT NULL,
  `discount` decimal(13,2) NOT NULL,
  `amount_received` decimal(13,2) NOT NULL,
  `due_payment` decimal(13,2) NOT NULL,
  `payment_method` varchar(100) NOT NULL,
  `p_reference` varchar(100) NOT NULL,
  `order_note` text NOT NULL,
  `type` enum('Invoice','Quotation') NOT NULL,
  `status` enum('Close','Cancel','Open','Pending') NOT NULL,
  `history` text NOT NULL,
  `sales_person` varchar(50) NOT NULL,
  `cancel_note` text,
  `delivery_status` enum('Processing Order','Awaiting Delivery','Done','') NOT NULL,
  `tracking` varchar(100) DEFAULT NULL,
  `delivery_person` varchar(100) DEFAULT NULL,
  `delivery_date` varchar(100) DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `subordinate`
--

CREATE TABLE `subordinate` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `subordinate_id` int(11) NOT NULL,
  `department_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `supervisor`
--

CREATE TABLE `supervisor` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `supervisor_id` int(11) NOT NULL,
  `department_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tax`
--

CREATE TABLE `tax` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `rate` decimal(13,2) NOT NULL,
  `type` tinyint(2) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_attendance`
--

CREATE TABLE `tbl_attendance` (
  `attendance_id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `leave_category_id` int(11) DEFAULT NULL,
  `date` date NOT NULL,
  `attendance_status` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'status 1=present 0=absen and 3= onleave',
  `in_time` time NOT NULL,
  `out_time` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` int(11) NOT NULL,
  `transaction_id` int(11) NOT NULL,
  `transaction_type_id` tinyint(2) NOT NULL COMMENT '1=Deposit, 2=Expense, 3=AP, 4=AR, 5= Account Transfer',
  `transaction_type` varchar(100) NOT NULL,
  `account_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `amount` decimal(13,2) NOT NULL DEFAULT '0.00',
  `description` varchar(200) NOT NULL,
  `payment_method` varchar(100) NOT NULL,
  `ref` varchar(150) NOT NULL,
  `balance` decimal(13,2) NOT NULL DEFAULT '0.00',
  `date_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `transfer_ref` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `transaction_category`
--

CREATE TABLE `transaction_category` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` varchar(100) NOT NULL,
  `type` tinyint(2) NOT NULL COMMENT '1=deposit; 2=expense'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
  `employee_id` int(11) NOT NULL,
  `ip_address` varchar(15) NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `salt` varchar(255) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `activation_code` varchar(40) DEFAULT NULL,
  `forgotten_password_code` varchar(40) DEFAULT NULL,
  `forgotten_password_time` int(11) UNSIGNED DEFAULT NULL,
  `remember_code` varchar(40) DEFAULT NULL,
  `created_on` int(11) UNSIGNED NOT NULL,
  `last_login` int(11) UNSIGNED DEFAULT NULL,
  `active` tinyint(1) UNSIGNED DEFAULT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `company` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `type` varchar(10) NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `users_groups`
--

CREATE TABLE `users_groups` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `group_id` mediumint(8) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `vendor`
--

CREATE TABLE `vendor` (
  `id` int(11) NOT NULL,
  `vendor_code` int(11) NOT NULL,
  `name` varchar(100) CHARACTER SET utf8 NOT NULL,
  `company_name` varchar(100) CHARACTER SET utf8 NOT NULL,
  `phone` varchar(100) CHARACTER SET utf8 COLLATE utf8_estonian_ci NOT NULL,
  `fax` varchar(100) CHARACTER SET utf8 NOT NULL,
  `email` varchar(100) CHARACTER SET utf8 NOT NULL,
  `website` varchar(100) CHARACTER SET utf8 NOT NULL,
  `b_address` text CHARACTER SET utf8 NOT NULL,
  `note` text CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `working_days`
--

CREATE TABLE `working_days` (
  `id` int(10) NOT NULL,
  `days` varchar(50) NOT NULL,
  `flag` tinyint(2) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `working_days`
--

INSERT INTO `working_days` (`id`, `days`, `flag`) VALUES
(1, 'Saturday', 0),
(2, 'Sunday', 0),
(3, 'Monday', 1),
(4, 'Tuesday', 1),
(5, 'Wednesday', 1),
(6, 'Thursday', 1),
(7, 'Friday', 1);

-- --------------------------------------------------------

--
-- Table structure for table `work_shift`
--

CREATE TABLE `work_shift` (
  `id` int(11) NOT NULL,
  `shift_name` varchar(100) CHARACTER SET latin1 NOT NULL,
  `shift_form` varchar(50) CHARACTER SET latin1 NOT NULL,
  `shift_to` varchar(50) CHARACTER SET latin1 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `account_head`
--
ALTER TABLE `account_head`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `account_type`
--
ALTER TABLE `account_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin_groups`
--
ALTER TABLE `admin_groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin_login_attempts`
--
ALTER TABLE `admin_login_attempts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin_users`
--
ALTER TABLE `admin_users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin_users_groups`
--
ALTER TABLE `admin_users_groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `assets`
--
ALTER TABLE `assets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ci_sessions`
--
ALTER TABLE `ci_sessions`
  ADD KEY `ci_sessions_timestamp` (`timestamp`);

--
-- Indexes for table `component`
--
ALTER TABLE `component`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `depreciation`
--
ALTER TABLE `depreciation`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employee_award`
--
ALTER TABLE `employee_award`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `emp_status`
--
ALTER TABLE `emp_status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `holidays`
--
ALTER TABLE `holidays`
  ADD PRIMARY KEY (`holiday_id`);

--
-- Indexes for table `inbox`
--
ALTER TABLE `inbox`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `job_category`
--
ALTER TABLE `job_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `job_history`
--
ALTER TABLE `job_history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `job_title`
--
ALTER TABLE `job_title`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `language`
--
ALTER TABLE `language`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `leave_application`
--
ALTER TABLE `leave_application`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `leave_application_type`
--
ALTER TABLE `leave_application_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `leave_category`
--
ALTER TABLE `leave_category`
  ADD PRIMARY KEY (`leave_category_id`);

--
-- Indexes for table `locales`
--
ALTER TABLE `locales`
  ADD PRIMARY KEY (`locale`);

--
-- Indexes for table `login_attempts`
--
ALTER TABLE `login_attempts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notice`
--
ALTER TABLE `notice`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `options`
--
ALTER TABLE `options`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `outbox`
--
ALTER TABLE `outbox`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payroll`
--
ALTER TABLE `payroll`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `persons`
--
ALTER TABLE `persons`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_category`
--
ALTER TABLE `product_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchase_details`
--
ALTER TABLE `purchase_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchase_order`
--
ALTER TABLE `purchase_order`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `received_product`
--
ALTER TABLE `received_product`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `salary`
--
ALTER TABLE `salary`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `salary_component`
--
ALTER TABLE `salary_component`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `salary_grade`
--
ALTER TABLE `salary_grade`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sales_order`
--
ALTER TABLE `sales_order`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subordinate`
--
ALTER TABLE `subordinate`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `supervisor`
--
ALTER TABLE `supervisor`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tax`
--
ALTER TABLE `tax`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_attendance`
--
ALTER TABLE `tbl_attendance`
  ADD PRIMARY KEY (`attendance_id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transaction_category`
--
ALTER TABLE `transaction_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users_groups`
--
ALTER TABLE `users_groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vendor`
--
ALTER TABLE `vendor`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `working_days`
--
ALTER TABLE `working_days`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `work_shift`
--
ALTER TABLE `work_shift`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `account`
--
ALTER TABLE `account`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `account_head`
--
ALTER TABLE `account_head`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `account_type`
--
ALTER TABLE `account_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `admin_groups`
--
ALTER TABLE `admin_groups`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `admin_login_attempts`
--
ALTER TABLE `admin_login_attempts`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `admin_users`
--
ALTER TABLE `admin_users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `admin_users_groups`
--
ALTER TABLE `admin_users_groups`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `assets`
--
ALTER TABLE `assets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `component`
--
ALTER TABLE `component`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=251;
--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `department`
--
ALTER TABLE `department`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `depreciation`
--
ALTER TABLE `depreciation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `employee`
--
ALTER TABLE `employee`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `employee_award`
--
ALTER TABLE `employee_award`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `emp_status`
--
ALTER TABLE `emp_status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `holidays`
--
ALTER TABLE `holidays`
  MODIFY `holiday_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `inbox`
--
ALTER TABLE `inbox`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `job_category`
--
ALTER TABLE `job_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `job_history`
--
ALTER TABLE `job_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `job_title`
--
ALTER TABLE `job_title`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `language`
--
ALTER TABLE `language`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `leave_application`
--
ALTER TABLE `leave_application`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `leave_application_type`
--
ALTER TABLE `leave_application_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `leave_category`
--
ALTER TABLE `leave_category`
  MODIFY `leave_category_id` int(2) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `login_attempts`
--
ALTER TABLE `login_attempts`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `notice`
--
ALTER TABLE `notice`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `options`
--
ALTER TABLE `options`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;
--
-- AUTO_INCREMENT for table `order_details`
--
ALTER TABLE `order_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `outbox`
--
ALTER TABLE `outbox`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `payroll`
--
ALTER TABLE `payroll`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `persons`
--
ALTER TABLE `persons`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `product_category`
--
ALTER TABLE `product_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `purchase_details`
--
ALTER TABLE `purchase_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `purchase_order`
--
ALTER TABLE `purchase_order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `received_product`
--
ALTER TABLE `received_product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `salary`
--
ALTER TABLE `salary`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `salary_component`
--
ALTER TABLE `salary_component`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `salary_grade`
--
ALTER TABLE `salary_grade`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `sales_order`
--
ALTER TABLE `sales_order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `subordinate`
--
ALTER TABLE `subordinate`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `supervisor`
--
ALTER TABLE `supervisor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tax`
--
ALTER TABLE `tax`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tbl_attendance`
--
ALTER TABLE `tbl_attendance`
  MODIFY `attendance_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `transaction_category`
--
ALTER TABLE `transaction_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users_groups`
--
ALTER TABLE `users_groups`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `vendor`
--
ALTER TABLE `vendor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `working_days`
--
ALTER TABLE `working_days`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `work_shift`
--
ALTER TABLE `work_shift`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;