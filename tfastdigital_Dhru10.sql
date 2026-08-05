-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Mar 22, 2023 at 08:40 PM
-- Server version: 10.3.38-MariaDB
-- PHP Version: 7.4.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ahmedfen_Dhru10`
--

-- --------------------------------------------------------

--
-- Table structure for table `crypto_payments`
--

CREATE TABLE `crypto_payments` (
  `paymentID` int(11) UNSIGNED NOT NULL,
  `boxID` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `boxType` enum('paymentbox','captchabox') NOT NULL,
  `orderID` varchar(50) NOT NULL DEFAULT '',
  `userID` varchar(50) NOT NULL DEFAULT '',
  `countryID` varchar(3) NOT NULL DEFAULT '',
  `coinLabel` varchar(6) NOT NULL DEFAULT '',
  `amount` double(20,8) NOT NULL DEFAULT 0.00000000,
  `amountUSD` double(20,8) NOT NULL DEFAULT 0.00000000,
  `unrecognised` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `addr` varchar(34) NOT NULL DEFAULT '',
  `txID` char(64) NOT NULL DEFAULT '',
  `txDate` datetime DEFAULT NULL,
  `txConfirmed` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `txCheckDate` datetime DEFAULT NULL,
  `processed` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `processedDate` datetime DEFAULT NULL,
  `recordCreated` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `tblAggregatorTransaction`
--

CREATE TABLE `tblAggregatorTransaction` (
  `aggregatortransid` int(11) NOT NULL,
  `date` date DEFAULT NULL,
  `time` varchar(50) DEFAULT NULL,
  `data` text DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL,
  `invoiceid` int(11) DEFAULT NULL,
  `transactionid` varchar(100) DEFAULT NULL,
  `receivedamount` decimal(14,2) DEFAULT 0.00,
  `receivedcurrency` varchar(10) DEFAULT NULL,
  `gateway` varchar(50) DEFAULT NULL,
  `aggregatorid` int(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tblItemPrice`
--

CREATE TABLE `tblItemPrice` (
  `itempriceid` int(11) NOT NULL,
  `itemid` int(11) NOT NULL,
  `pricing` decimal(16,4) NOT NULL,
  `pricingtemplateid` int(5) NOT NULL,
  `pricingmon` decimal(16,4) NOT NULL,
  `pricingqua` decimal(16,4) NOT NULL,
  `pricingsemi` decimal(16,4) NOT NULL,
  `pricingann` decimal(16,4) NOT NULL,
  `pricingbia` decimal(16,4) NOT NULL,
  `pricingtria` decimal(16,4) NOT NULL,
  `pricingdays` decimal(16,4) NOT NULL,
  `currencyid` int(11) NOT NULL,
  `customdays` int(4) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tblItems`
--

CREATE TABLE `tblItems` (
  `itemid` int(11) NOT NULL,
  `itemname` varchar(150) NOT NULL,
  `itemtype` varchar(100) NOT NULL,
  `itemgroupid` int(11) NOT NULL,
  `itemdescription` varchar(512) NOT NULL,
  `itemstatus` tinyint(1) NOT NULL,
  `itemdisplayorder` int(5) NOT NULL,
  `itemconfig` text NOT NULL,
  `pricingtype` varchar(80) NOT NULL,
  `itemmasterid` int(11) NOT NULL,
  `itemupgradewith` varchar(250) NOT NULL,
  `allowmultipleorders` tinyint(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tblItemsGroups`
--

CREATE TABLE `tblItemsGroups` (
  `itemgroupid` int(11) NOT NULL,
  `itemgroupname` varchar(250) NOT NULL,
  `itemgroupmid` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tblLoginDevices`
--

CREATE TABLE `tblLoginDevices` (
  `id` int(11) NOT NULL,
  `deviceid` varchar(250) NOT NULL,
  `adminid` int(11) NOT NULL,
  `time` varchar(40) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblLoginDevices`
--

INSERT INTO `tblLoginDevices` (`id`, `deviceid`, `adminid`, `time`) VALUES
(1, 'DhruFusion63e2af1cd20039.17407052', 1, '1675800348'),
(2, 'DhruFusion63e2b6bb1f86d9.21690586', 1, '1675802299'),
(3, 'DhruFusion63e2bbaf2558d3.24790528', 1, '1675803567'),
(4, 'DhruFusion6403b597ed1e54.17900445', 1, '1677964696'),
(5, 'DhruFusion6403b6624b4d50.21138576', 1, '1677964898'),
(6, 'DhruFusion6403b6bb951e77.54847835', 1, '1677964987'),
(7, 'DhruFusion6403d855a3ac82.74614241', 1, '1677973589'),
(8, 'DhruFusion6403d9ab3d8744.76640391', 1, '1677973931'),
(9, 'DhruFusion641ae4db365299.11221188', 1, '1679484123'),
(10, 'DhruFusion641aeb65e893d0.75986427', 1, '1679485797');

-- --------------------------------------------------------

--
-- Table structure for table `tblPaymentAggregator`
--

CREATE TABLE `tblPaymentAggregator` (
  `aggregatorid` int(5) NOT NULL,
  `aggregatorname` varchar(100) DEFAULT NULL,
  `gateway` text DEFAULT NULL,
  `apikey` varchar(250) DEFAULT NULL,
  `ip` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tblPriceLog`
--

CREATE TABLE `tblPriceLog` (
  `id` int(11) NOT NULL,
  `date` varchar(50) NOT NULL,
  `time` varchar(50) NOT NULL,
  `server` text NOT NULL,
  `request` text NOT NULL,
  `session` text NOT NULL,
  `event` varchar(50) NOT NULL,
  `groupid` int(11) NOT NULL,
  `serviceid` int(11) NOT NULL,
  `userid` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tblPricingTemplate`
--

CREATE TABLE `tblPricingTemplate` (
  `pricingtemplateid` int(11) NOT NULL,
  `pricingtemplatename` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tblTransferFee`
--

CREATE TABLE `tblTransferFee` (
  `feeid` int(11) NOT NULL,
  `uid` int(11) DEFAULT NULL,
  `fee` decimal(10,2) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `time` varchar(50) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tblUsers`
--

CREATE TABLE `tblUsers` (
  `id` int(11) NOT NULL,
  `block_reason` varchar(555) DEFAULT NULL,
  `canactive` int(11) NOT NULL DEFAULT 0,
  `is_registered` int(11) NOT NULL DEFAULT 0,
  `access_key` varchar(255) DEFAULT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `avtar` varchar(1000) DEFAULT NULL,
  `company` varchar(255) DEFAULT NULL,
  `contact` varchar(25) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `tmp_password` varchar(255) DEFAULT NULL,
  `tmp_pass_time` varchar(255) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `address` varchar(1000) DEFAULT NULL,
  `address2` varchar(555) DEFAULT NULL,
  `otheraddress` mediumtext DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `zip` varchar(50) DEFAULT NULL,
  `country` varchar(50) DEFAULT NULL,
  `phonenumber` varchar(20) DEFAULT NULL,
  `usertype` int(11) NOT NULL DEFAULT 0,
  `userstatus` int(11) NOT NULL DEFAULT 0,
  `enc_login` varchar(255) DEFAULT NULL,
  `sndlogin` varchar(50) DEFAULT NULL,
  `random_key` varchar(255) DEFAULT NULL,
  `last_login` varchar(50) DEFAULT NULL,
  `last_login_ip` varchar(50) DEFAULT NULL,
  `ac_create_dt` varchar(25) DEFAULT NULL,
  `imei_service_access` int(11) NOT NULL DEFAULT 0,
  `imei_services` mediumtext DEFAULT NULL,
  `file_service_access` int(11) NOT NULL DEFAULT 0,
  `file_services` mediumtext DEFAULT NULL,
  `server_log_access` int(11) NOT NULL DEFAULT 0,
  `server_logs` mediumtext DEFAULT NULL,
  `shop_service_access` varchar(25) DEFAULT NULL,
  `shop_services` varchar(255) DEFAULT NULL,
  `default_theme` varchar(50) DEFAULT NULL,
  `default_lang` varchar(25) DEFAULT NULL,
  `default_currency` int(11) NOT NULL DEFAULT 0,
  `credit_left` decimal(25,3) NOT NULL,
  `credit_used` decimal(30,3) NOT NULL,
  `credit_inprocess` decimal(25,3) NOT NULL,
  `sell_credit_limit` decimal(35,3) NOT NULL,
  `note` mediumtext DEFAULT NULL,
  `activation_key` varchar(50) DEFAULT NULL,
  `reseller_id` int(11) NOT NULL DEFAULT 0,
  `admin_id` int(11) NOT NULL DEFAULT 0,
  `sms_credit_left` varchar(10) DEFAULT NULL,
  `sms_credit_used` varchar(10) DEFAULT NULL,
  `sms_country_code` int(11) NOT NULL DEFAULT 0,
  `api_access` int(11) NOT NULL DEFAULT 0,
  `api_key` varchar(555) DEFAULT NULL,
  `api_ip` mediumtext DEFAULT NULL,
  `ip_range1` varchar(100) DEFAULT NULL,
  `ip_range` mediumtext DEFAULT NULL,
  `ip_range2` varchar(100) DEFAULT NULL,
  `ip_range3` varchar(100) DEFAULT NULL,
  `ip_range4` varchar(100) DEFAULT NULL,
  `ip_range5` varchar(100) DEFAULT NULL,
  `login_country` varchar(50) DEFAULT NULL,
  `language` varchar(70) DEFAULT NULL,
  `auto_recharge` mediumtext DEFAULT NULL,
  `paypal_verified` int(11) NOT NULL DEFAULT 0,
  `news_letter` int(11) NOT NULL DEFAULT 0,
  `time_zone` varchar(255) DEFAULT NULL,
  `credit_validity` int(11) NOT NULL DEFAULT 0,
  `credit_date` varchar(50) DEFAULT NULL,
  `last_credit_notification` varchar(50) DEFAULT NULL,
  `last_invoice_notification` varchar(50) DEFAULT NULL,
  `last_activity_notification` varchar(50) DEFAULT NULL,
  `shopping_user` int(11) NOT NULL DEFAULT 0,
  `credit_transfer` int(11) NOT NULL DEFAULT 0,
  `credit_reseller_id` int(11) NOT NULL DEFAULT 0,
  `current_session_id` int(11) NOT NULL DEFAULT 0,
  `current_login_time` varchar(50) DEFAULT NULL,
  `online_status` int(11) NOT NULL DEFAULT 0,
  `question_id` varchar(55) DEFAULT NULL,
  `question_answer` mediumtext DEFAULT NULL,
  `reset_key` varchar(255) DEFAULT NULL,
  `login_failed_atoms` int(11) NOT NULL DEFAULT 0,
  `reseller_can_setupstore` int(11) NOT NULL DEFAULT 0,
  `message` mediumtext DEFAULT NULL,
  `lastloginalert` varchar(50) DEFAULT NULL,
  `lowcredit` varchar(50) DEFAULT NULL,
  `creditvalidity` varchar(50) DEFAULT NULL,
  `client_group` int(11) NOT NULL DEFAULT 0,
  `storeownerid` int(11) NOT NULL DEFAULT 0,
  `rechargeblock` int(11) NOT NULL DEFAULT 0,
  `master_pin` varchar(100) DEFAULT NULL,
  `lastpassreset` varchar(100) DEFAULT NULL,
  `notdiscounteduser` int(11) NOT NULL DEFAULT 0,
  `fraud_protection` int(11) NOT NULL DEFAULT 0,
  `mobverify` varchar(50) DEFAULT NULL,
  `verified` int(11) NOT NULL DEFAULT 0,
  `wishlist` mediumtext DEFAULT NULL,
  `affiliate` int(11) NOT NULL DEFAULT 0,
  `affiliate_visitors` int(11) NOT NULL DEFAULT 0,
  `affiliate_signup` int(11) NOT NULL DEFAULT 0,
  `affiliate_balance` varchar(255) DEFAULT NULL,
  `affiliate_payout` varchar(255) DEFAULT NULL,
  `affiliate_payout_type` int(11) NOT NULL DEFAULT 0,
  `customize_email` int(11) NOT NULL DEFAULT 0,
  `cardtype` varchar(255) DEFAULT NULL,
  `cardname` varchar(555) DEFAULT NULL,
  `cardlastfour` varchar(10) DEFAULT NULL,
  `cardnum` blob DEFAULT NULL,
  `startdate` blob DEFAULT NULL,
  `expdate` blob DEFAULT NULL,
  `ccv` blob DEFAULT NULL,
  `inact` int(11) NOT NULL DEFAULT 0,
  `signupby` varchar(255) DEFAULT NULL,
  `group_start` varchar(50) DEFAULT NULL,
  `group_end` varchar(50) DEFAULT NULL,
  `products` mediumtext DEFAULT NULL,
  `overdrive` varchar(10) DEFAULT NULL,
  `allowoverdrive` int(11) NOT NULL DEFAULT 0,
  `imeifrequent` mediumtext DEFAULT NULL,
  `guest` int(11) NOT NULL DEFAULT 0,
  `gcmid` varchar(555) DEFAULT NULL,
  `pricechange` int(1) NOT NULL DEFAULT 0,
  `messagedate` varchar(25) NOT NULL,
  `maxcredit` decimal(12,3) NOT NULL,
  `ordersms` int(1) NOT NULL DEFAULT 0,
  `creditlimit` decimal(12,3) NOT NULL,
  `closeac` int(1) NOT NULL DEFAULT 0,
  `newserver_services` mediumtext NOT NULL,
  `allowcountry` int(1) NOT NULL,
  `paypalaccount` varchar(555) NOT NULL,
  `allowedcountry` varchar(255) NOT NULL,
  `messengerid` varchar(100) NOT NULL,
  `themesettings` text NOT NULL,
  `minaddfund` varchar(20) NOT NULL,
  `maxaddfund` varchar(20) NOT NULL,
  `idverification` int(1) NOT NULL,
  `increaseby` varchar(30) NOT NULL,
  `increaseval` decimal(12,2) NOT NULL,
  `customgateway` int(1) NOT NULL,
  `fileincrease` decimal(10,2) NOT NULL,
  `fileincreaseby` varchar(20) NOT NULL,
  `serverincrease` decimal(10,2) NOT NULL,
  `serverincreaseby` varchar(20) NOT NULL,
  `otpfordirect` int(1) NOT NULL,
  `remote_services` text DEFAULT NULL,
  `alow_remoteservices` int(1) DEFAULT NULL,
  `remoteincrease` decimal(10,2) DEFAULT NULL,
  `remoteincreaseby` varchar(20) DEFAULT NULL,
  `transferfee` decimal(10,2) DEFAULT 0.00,
  `unsubscribe` tinyint(1) DEFAULT 0,
  `data` text DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `tblUsers`
--

INSERT INTO `tblUsers` (`id`, `block_reason`, `canactive`, `is_registered`, `access_key`, `first_name`, `last_name`, `avtar`, `company`, `contact`, `username`, `password`, `tmp_password`, `tmp_pass_time`, `email`, `address`, `address2`, `otheraddress`, `state`, `city`, `zip`, `country`, `phonenumber`, `usertype`, `userstatus`, `enc_login`, `sndlogin`, `random_key`, `last_login`, `last_login_ip`, `ac_create_dt`, `imei_service_access`, `imei_services`, `file_service_access`, `file_services`, `server_log_access`, `server_logs`, `shop_service_access`, `shop_services`, `default_theme`, `default_lang`, `default_currency`, `credit_left`, `credit_used`, `credit_inprocess`, `sell_credit_limit`, `note`, `activation_key`, `reseller_id`, `admin_id`, `sms_credit_left`, `sms_credit_used`, `sms_country_code`, `api_access`, `api_key`, `api_ip`, `ip_range1`, `ip_range`, `ip_range2`, `ip_range3`, `ip_range4`, `ip_range5`, `login_country`, `language`, `auto_recharge`, `paypal_verified`, `news_letter`, `time_zone`, `credit_validity`, `credit_date`, `last_credit_notification`, `last_invoice_notification`, `last_activity_notification`, `shopping_user`, `credit_transfer`, `credit_reseller_id`, `current_session_id`, `current_login_time`, `online_status`, `question_id`, `question_answer`, `reset_key`, `login_failed_atoms`, `reseller_can_setupstore`, `message`, `lastloginalert`, `lowcredit`, `creditvalidity`, `client_group`, `storeownerid`, `rechargeblock`, `master_pin`, `lastpassreset`, `notdiscounteduser`, `fraud_protection`, `mobverify`, `verified`, `wishlist`, `affiliate`, `affiliate_visitors`, `affiliate_signup`, `affiliate_balance`, `affiliate_payout`, `affiliate_payout_type`, `customize_email`, `cardtype`, `cardname`, `cardlastfour`, `cardnum`, `startdate`, `expdate`, `ccv`, `inact`, `signupby`, `group_start`, `group_end`, `products`, `overdrive`, `allowoverdrive`, `imeifrequent`, `guest`, `gcmid`, `pricechange`, `messagedate`, `maxcredit`, `ordersms`, `creditlimit`, `closeac`, `newserver_services`, `allowcountry`, `paypalaccount`, `allowedcountry`, `messengerid`, `themesettings`, `minaddfund`, `maxaddfund`, `idverification`, `increaseby`, `increaseval`, `customgateway`, `fileincrease`, `fileincreaseby`, `serverincrease`, `serverincreaseby`, `otpfordirect`, `remote_services`, `alow_remoteservices`, `remoteincrease`, `remoteincreaseby`, `transferfee`, `unsubscribe`, `data`) VALUES
(1, '', 0, 1, '9423c74c9dc4ec2a483a2a05f8c2a533', '', '', '', '', '', 'demodemo', '616e28901427afba7fc1a23f37b9440b', '28328511', '1677976491', 'demo@demo.com', '', '', '', '', '', '', 'US', '', 0, 0, '11fddb2b0cbf246614187d6be074b745', '', 'ee35005e2a04d672f19b5cebbd8bbae1', '1677976486', '188.80.69.14', '1677976461', 1, 'ALL', 1, 'ALL', 1, '', '', '', 'default', '', 1, '4.980', '0.020', '0.020', '0.000', '', '', 0, 1, '', '', 0, 1, '', '', '', '', '', '', '', '', 'PT', 'English', '', 0, 1, '', 0, '', '', '', '', 0, 1, 0, 3, '1677977285', 0, '', '', '', 0, 0, '', '1677976461', '', '', 0, 0, 0, 'MA==', '', 1, 0, '', 0, '', 0, 0, 0, '', '', 0, 0, '', '', '', '', '', '', '', 0, '', '', '', '', '', 0, '', 0, '', 0, '', '0.000', 0, '0.000', 0, 'ALL', 0, '', '', '', '{\"orderstyle\":\"2\",\"mode\":\"light\",\"column\":\"Array\"}', '', '', 0, '', '0.00', 0, '0.00', '', '0.00', '', 0, 'ALL', 1, '0.00', '', '0.00', 0, '{\"data\":\"\",\"defaultaddress\":[{\"latitude\":null,\"longitude\":null,\"country_code\":null,\"city_code\":null,\"state_code\":null}]}'),
(2, '', 0, 1, '4ffe6dc46578dc0b1cf1a87c73334b0c', 'DM', 'RAKOLIY', '', '', '', 'ahmedunllock', '8f58ee1802a9217c6f148f4cd6dc4d30', '72634422', '1679504864', 'ahmed.el.andam@gmail.com', 'Azli3000', 'Azli3000\r\nazko', '', 'New York', 'Adams', '4000', 'US', '4578975', 0, 0, '0b9dfa94f1a37d780903f18dde5daec9', '', '4d71c6c699bac42a345a5b917f702763', '1679504712', '177.54.147.116', '1679489067', 1, 'ALL', 1, 'ALL', 1, '', '', '', '', '', 1, '0.000', '0.000', '0.000', '0.000', '', '', 0, 0, '', '', 0, 1, '', '', '', '', '', '', '', '', 'MA', 'English', '', 0, 0, '', 0, '', '', '', '', 0, 1, 0, 2147483647, '1679506624', 1, '', '', '', 0, 0, '', '1679489067', '', '', 0, 0, 0, 'MA==', '', 1, 0, '', 0, '', 0, 0, 0, '', '', 0, 0, '', '', '', '', '', '', '', 0, '', '', '', '', '', 0, '', 0, '', 0, '', '0.000', 0, '0.000', 0, 'ALL', 0, '', '', '', '{\"orderstyle\":\"1\",\"mode\":\"light\",\"column\":\"Array\"}', '', '', 0, '', '0.00', 0, '0.00', '', '0.00', '', 0, 'ALL', 1, '0.00', '', '0.00', 0, '{\"data\":\"\",\"defaultaddress\":[{\"latitude\":\"43.80923000\",\"longitude\":\"-76.02409000\",\"country_code\":\"US\",\"city_code\":\"111014\",\"state_code\":\"NY\"}]}');

-- --------------------------------------------------------

--
-- Table structure for table `tblWalletTransaction`
--

CREATE TABLE `tblWalletTransaction` (
  `transid` int(11) NOT NULL,
  `amount` decimal(14,2) DEFAULT 0.00,
  `refid` int(11) DEFAULT 0,
  `date` date DEFAULT NULL,
  `time` varchar(20) DEFAULT NULL,
  `data` text DEFAULT NULL,
  `gateway` varchar(50) DEFAULT NULL,
  `userid` int(11) DEFAULT NULL,
  `merchantid` int(11) DEFAULT NULL,
  `status` varchar(10) DEFAULT NULL,
  `transactionid` varchar(50) DEFAULT NULL,
  `fee` decimal(9,2) DEFAULT 0.00,
  `domain` varchar(100) DEFAULT NULL,
  `customid` varchar(200) DEFAULT NULL,
  `receivedamount` decimal(15,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_activity_log`
--

CREATE TABLE `tbl_activity_log` (
  `id` int(10) NOT NULL,
  `date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `description` mediumtext NOT NULL,
  `type` varchar(50) DEFAULT NULL,
  `eventon` int(5) DEFAULT NULL,
  `eventby` int(5) DEFAULT NULL,
  `user` varchar(50) NOT NULL,
  `ip` varchar(50) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_add_management`
--

CREATE TABLE `tbl_add_management` (
  `id` int(3) NOT NULL,
  `p_id` varchar(2) NOT NULL,
  `type` varchar(30) NOT NULL,
  `html_code` mediumtext NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `tbl_add_management`
--

INSERT INTO `tbl_add_management` (`id`, `p_id`, `type`, `html_code`) VALUES
(1, '1', 'global', ''),
(2, '2', 'global', ''),
(3, '4', 'global', ''),
(5, '3', 'global', ''),
(12, '1', 'index', ''),
(8, '1', 'productdetails', ''),
(9, '2', 'productdetails', ''),
(10, '3', 'productdetails', ''),
(11, '4', 'productdetails', ''),
(13, '4', 'index', ''),
(14, '4', 'login', ''),
(16, '5', 'productdetails', 'F'),
(15, '5', 'login', ''),
(19, '3', 'index', 'below right sidebar'),
(17, '2', 'index', 'below banner'),
(18, '3', 'login', '');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_admin`
--

CREATE TABLE `tbl_admin` (
  `id` int(11) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `api_key` varchar(100) DEFAULT NULL,
  `api_ip` mediumtext DEFAULT NULL,
  `api_access` int(11) NOT NULL DEFAULT 0,
  `firstname` varchar(100) DEFAULT NULL,
  `lastname` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `signature` mediumtext DEFAULT NULL,
  `notes` mediumtext DEFAULT NULL,
  `supportdepts` mediumtext DEFAULT NULL,
  `group_id` int(11) NOT NULL DEFAULT 0,
  `status` int(11) NOT NULL DEFAULT 0,
  `enc_login` varchar(255) DEFAULT NULL,
  `reminder` longtext DEFAULT NULL,
  `language` varchar(15) DEFAULT NULL,
  `template` varchar(15) DEFAULT NULL,
  `support_department` mediumtext DEFAULT NULL,
  `online` int(11) NOT NULL DEFAULT 0,
  `online_time` varchar(100) DEFAULT NULL,
  `chatdepartment` varchar(500) DEFAULT NULL,
  `onlinestatus` varchar(250) DEFAULT NULL,
  `contact` varchar(50) DEFAULT NULL,
  `credit` varchar(50) DEFAULT NULL,
  `mywarehouse` int(11) NOT NULL DEFAULT 0,
  `google` int(11) NOT NULL DEFAULT 0,
  `ip_range` varchar(555) DEFAULT NULL,
  `seclogin` varchar(255) DEFAULT NULL,
  `theme` varchar(100) NOT NULL,
  `salesreport` int(1) NOT NULL,
  `rejectorder` int(1) DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `tbl_admin`
--

INSERT INTO `tbl_admin` (`id`, `username`, `password`, `api_key`, `api_ip`, `api_access`, `firstname`, `lastname`, `email`, `signature`, `notes`, `supportdepts`, `group_id`, `status`, `enc_login`, `reminder`, `language`, `template`, `support_department`, `online`, `online_time`, `chatdepartment`, `onlinestatus`, `contact`, `credit`, `mywarehouse`, `google`, `ip_range`, `seclogin`, `theme`, `salesreport`, `rejectorder`) VALUES
(1, 'admin', '9fda6e93f83e05e0f8323d806cde4008', NULL, NULL, 0, 'AbdulKadir', 'Taşkıran', 'admin@appunlockbayi.com', '', NULL, NULL, 1, 0, NULL, NULL, '', 'default', '11,12', 1, '1679506733', '11,12', 'available', '', '', 0, 0, NULL, NULL, 'light', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_admin_access`
--

CREATE TABLE `tbl_admin_access` (
  `id` int(5) NOT NULL,
  `page_name` varchar(255) NOT NULL,
  `page_description` varchar(255) NOT NULL,
  `groupname` mediumtext NOT NULL,
  `shop` int(1) NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `tbl_admin_access`
--

INSERT INTO `tbl_admin_access` (`id`, `page_name`, `page_description`, `groupname`, `shop`) VALUES
(1, 'serverorder.report.php', 'Serverorder Report', 'report', 0),
(2, 'imeiservice.list.php', 'Imeiservice List', 'service', 0),
(4, 'edituser.imeiservice.php', 'Edituser Imeiservice', 'user', 0),
(6, 'salesbyproduct.php', 'Salesbyproduct', 'report', 1),
(8, 'utilities.onlineusers.php', 'Utilities Onlineusers', 'utilities', 1),
(10, 'editsupplier.imei.php', 'Editsupplier Imei', 'supplier', 0),
(11, 'addknowledgebase.php', 'Addknowledgebase', 'cms', 1),
(12, 'createpage.php', 'Createpage', 'cms', 1),
(13, 'apisetting.edit.php', 'Apisetting Edit', 'settings', 0),
(14, 'edituser.apisettings.php', 'Edituser Apisettings', 'user', 0),
(22, 'imeiorder.verification.php', 'Imeiorder Verification', 'order', 0),
(23, 'emailtemplate.edit.php', 'Emailtemplate Edit', 'settings', 1),
(26, 'addservergroup.php', 'Addservergroup', 'service', 0),
(29, 'emailtemplate.add.php', 'Emailtemplate Add', 'settings', 1),
(30, 'edituser.serverorder.php', 'Edituser Serverorder', 'user', 0),
(32, 'settinggeneral.php', 'Settinggeneral', 'settings', 1),
(33, 'editblogauthor.php', 'Editblogauthor', 'blog', 1),
(34, 'imeiservice.viewgroup.php', 'Imeiservice Viewgroup', 'service', 0),
(35, 'editsupplier.profile.php', 'Editsupplier Profile', 'supplier', 1),
(36, 'serverorder.replied.php', 'Serverorder Replied', 'order', 0),
(39, 'fileorder.verification.php', 'Fileorder Verification', 'order', 0),
(42, 'editimeiservice.retailinfo.php', 'Editimeiservice Retailinfo', 'service', 0),
(328, 'help.supportrequest.php', 'help supportrequest', 'help', 1),
(47, 'edituser.overview.php', 'Edituser Overview', 'user', 1),
(51, 'editservergroup.php', 'Editservergroup', 'service', 0),
(52, 'generalsettings.php', 'Generalsettings', 'settings', 1),
(55, 'editadminaccessgroup.php', 'Editadminaccessgroup', 'settings', 0),
(56, 'addtestimonial.php', 'Addtestimonial', 'cms', 1),
(60, 'editimeiservice.retailpurchase.php', 'Editimeiservice Retailpurchase', 'service', 0),
(61, 'addnewclient.php', 'Addnewclient', 'user', 1),
(63, 'paymentgateway.php', 'Paymentgateway', 'settings', 1),
(67, 'knowledgebasecatadd.php', 'Knowledgebasecatadd', 'cms', 1),
(71, 'editfilegroup.php', 'Editfilegroup', 'service', 0),
(73, 'editserverservice.retailinfo.php', 'Editserverservice Retailinfo', 'service', 0),
(75, 'fileservice.viewgroup.php', 'Fileservice Viewgroup', 'service', 0),
(76, 'imeiservice.addnew.php', 'Imeiservice Addnew', 'service', 0),
(78, 'serverservice.list.php', 'Serverservice List', 'service', 0),
(79, 'blogcategoryadd.php', 'Blogcategoryadd', 'blog', 1),
(81, 'acceptedorder.php', 'Acceptedorder', 'order', 1),
(83, 'editsupplier.imeihistory.php', 'Editsupplier Imeihistory', 'supplier', 0),
(84, 'imeiorder.history.php', 'Imeiorder History', 'order', 0),
(86, 'indexcontent.php', 'Indexcontent', 'cms', 1),
(88, 'fileorder.repllied.php', 'Fileorder Repllied', 'order', 0),
(89, 'editsupplier.server.php', 'Editsupplier Server', 'supplier', 0),
(90, 'edituser.editfileorder.php', 'Edituser Editfileorder', 'user', 0),
(91, 'editpage.php', 'Editpage', 'cms', 1),
(94, 'editbanner.php', 'Editbanner', 'cms', 1),
(95, 'editimeiservice.field.php', 'Editimeiservice Field', 'service', 0),
(329, 'help.license.php', 'help license', 'help', 1),
(97, 'viewimeiorder.accepted.php', 'Viewimeiorder Accepted', 'order', 0),
(99, 'editsupplier.serverhistory.php', 'Editsupplier Serverhistory', 'supplier', 0),
(100, 'imeiorder.report.php', 'Imeiorder Report', 'order', 0),
(101, 'utilities.systemcleanup.php', 'Utilities Systemcleanup', 'utilities', 1),
(103, 'serverservice.addnew.php', 'Serverservice Addnew', 'service', 0),
(104, 'utilities.comments.php', 'Utilities Comments', 'utilities', 1),
(106, 'blogcategorylist.php', 'Blogcategorylist', 'blog', 1),
(110, 'resellerstatement.php', 'Resellerstatement', 'report', 1),
(111, 'imeiorder.accepted.php', 'Imeiorder Accepted', 'order', 0),
(112, 'addnewsupplier.php', 'Addnewsupplier', 'supplier', 1),
(113, 'languagetools.php', 'Languagetools', 'utilities', 1),
(397, 'viewproductorder.new.php', 'View Product Order New', 'order', 1),
(119, 'editknowledgebase.php', 'Editknowledgebase', 'cms', 1),
(121, 'fileorder.report.php', 'Fileorder Report', 'order', 0),
(122, 'addfilegroup.php', 'Addfilegroup', 'service', 0),
(123, 'serverorder.history.php', 'Serverorder History', 'order', 0),
(125, 'mailsettings.basic.php', 'Mailsettings Basic', 'settings', 1),
(128, 'edituser.invoice.php', 'Edituser View Invoice', 'user', 1),
(130, 'editfileservice.inventory.php', 'Editfileservice Inventory', 'service', 0),
(132, 'editsupplier.statement.php', 'Editsupplier Statement', 'supplier', 1),
(134, 'apisetting.php', 'Apisetting', 'settings', 1),
(137, 'imeiorder.replied.php', 'Imeiorder Replied', 'order', 0),
(141, 'listtestimonial.php', 'Listtestimonial', 'cms', 1),
(144, 'editadmin.php', 'Editadmin', 'settings', 1),
(145, 'viewfileorder.new.php', 'Viewfileorder New', 'order', 0),
(147, 'securitysettings.php', 'Securitysettings', 'settings', 1),
(148, 'editfileservice.overview.php', 'Editfileservice Overview', 'service', 0),
(151, 'addip.php', 'Addip', 'utilities', 1),
(153, 'serverorder.new.php', 'Serverorder New', 'order', 0),
(154, 'edittestimonial.php', 'Edittestimonial', 'cms', 1),
(159, 'fileorder.summery.php', 'Fileorder Summery', 'order', 0),
(163, 'fileservice.addnew.php', 'Fileservice Addnew', 'service', 0),
(164, 'edituser.editinvoice.php', 'Edituser Edit invoice', 'user', 1),
(166, 'editfileservice.field.php', 'Editfileservice Field', 'service', 0),
(167, 'blockedip.php', 'Blockedip', 'utilities', 1),
(168, 'adminroles.php', 'Adminroles', 'settings', 1),
(169, 'edituser.mailhistory.php', 'Edituser Mailhistory', 'user', 1),
(171, 'editserverservice.overview.php', 'Editserverservice Overview', 'service', 0),
(172, 'editimeiservice.apiconnection.php', 'Editimeiservice Apiconnection', 'service', 0),
(175, 'fileorder.new.php', 'Fileorder New', 'order', 0),
(179, 'editsupplier.filehistory.php', 'Editsupplier Filehistory', 'supplier', 0),
(180, 'newblog.php', 'Newblog', 'blog', 1),
(181, 'editknowledgebasecat.php', 'Editknowledgebasecat', 'cms', 1),
(182, 'settingregistration.php', 'Settingregistration', 'settings', 1),
(183, 'edituser.editserverorder.php', 'Edituser Editserverorder', 'user', 0),
(185, 'userstatement.php', 'Userstatement', 'report', 1),
(186, 'edituser.editimeiorder.php', 'Edituser Editimeiorder', 'user', 0),
(187, 'editblogs.php', 'Editblogs', 'blog', 1),
(188, 'settingreseller.php', 'Settingreseller', 'settings', 1),
(189, 'fileorder.history.php', 'Fileorder History', 'order', 0),
(191, 'settinglocalisation.php', 'Settinglocalisation', 'settings', 1),
(192, 'edituser.fileorder.php', 'Edituser Fileorder', 'user', 0),
(193, 'viewimeiorder.verif.php', 'Viewimeiorder Verif', 'order', 0),
(195, 'utilities.databasestatus.php', 'Utilities Databasestatus', 'utilities', 1),
(196, 'editsupplier.overview.php', 'Editsupplier Overview', 'supplier', 1),
(197, 'viewimeiorder.new.php', 'Viewimeiorder New', 'order', 0),
(198, 'edituser.notes.php', 'Edituser Notes', 'user', 1),
(201, 'settinginvoice.php', 'Settinginvoice', 'settings', 1),
(204, 'editsupplier.file.php', 'Editsupplier File', 'supplier', 0),
(207, 'editsupplier.account.php', 'Editsupplier Account', 'supplier', 0),
(208, 'viewblog.php', 'Viewblog', 'blog', 1),
(209, 'editimeiservice.inventory.php', 'Editimeiservice Inventory', 'service', 0),
(210, 'acceptedorderserver.php', 'Acceptedorderserver', 'order', 0),
(212, 'edituser.loginiprange.php', 'Edituser Loginiprange', 'user', 1),
(213, 'edituser.accountfinancial.php', 'Edituser Accountfinancial', 'user', 1),
(214, 'edituser.fileservice.php', 'Edituser Fileservice', 'user', 0),
(216, 'editserverservice.retailpurchase.php', 'Editserverservice Retailpurchase', 'service', 0),
(220, 'edituser.profile.php', 'Edituser Profile', 'user', 1),
(225, 'edituser.serverservice.php', 'Edituser Serverservice', 'user', 0),
(228, 'appearancesetting.php', 'Appearancesetting', 'settings', 1),
(231, 'settingorder.php', 'Settingorder', 'settings', 1),
(233, 'edituser.viewemailhistory.php', 'Edituser Viewemailhistory', 'user', 1),
(234, 'viewserverorder.new.php', 'Viewserverorder New', 'order', 0),
(236, 'monthlyorder.php', 'Monthlyorder', 'report', 1),
(238, 'currencies.list.php', 'Currencies List', 'settings', 1),
(241, 'editimeiservice.happyhours.php', 'Editimeiservice Happyhours', 'service', 0),
(244, 'editblogcat.php', 'Editblogcat', 'blog', 1),
(245, 'lang.settings.php', 'Lang Settings', 'settings', 1),
(338, 'utilities.resellershop.php', 'Utilities Reseller Shop', 'utilities', 1),
(249, 'evariablesimei.php', 'Email Variables', '', 1),
(251, 'editserverservice.happyhours.php', 'Editserverservice Happyhours', 'service', 0),
(252, 'edituser.statement.php', 'Edituser Statement', 'user', 1),
(253, 'addnewadmin.php', 'Addnewadmin', 'settings', 1),
(254, 'addnewadminrole.php', 'Addnewadminrole', 'settings', 1),
(255, 'clientlist.php', 'Clientlist', 'user', 1),
(256, 'viewfileorder.verif.php', 'Viewfileorder Verif', 'order', 0),
(258, 'mailsettings.send.php', 'Mailsettings Send', 'settings', 1),
(259, 'editimeigroup.php', 'Editimeigroup', 'service', 0),
(261, 'editserverservice.inventory.php', 'Editserverservice Inventory', 'service', 0),
(263, 'editserverservice.apiconnection.php', 'Editserverservice Apiconnection', 'service', 0),
(265, 'indexbanner.php', 'Indexbanner', 'cms', 1),
(266, 'imeiorder.bulk.php', 'Imeiorder Bulk', 'order', 0),
(330, 'utilities.userstatus.php', 'new registered users', 'dashboard', 1),
(331, 'utilities.useractivities.php', 'User Login Log', 'dashboard', 1),
(332, 'utilities.adminactivities.php', 'Admin Login Log', 'dashboard', 1),
(273, 'editserverservice.field.php', 'Editserverservice Field', 'service', 0),
(275, 'edituser.otherservice.php', 'Edituser Otherservice', 'user', 1),
(277, 'mailsetting.php', 'Mailsetting', 'settings', 1),
(279, 'emailtemplate.list.php', 'Emailtemplate List', 'settings', 1),
(283, 'settingappear.php', 'Settingappear', 'settings', 1),
(284, 'editfileservice.apiconnection.php', 'Editfileservice Apiconnection', 'service', 0),
(285, 'supplierlist.php', 'Supplierlist', 'supplier', 1),
(287, 'editfileservice.happyhours.php', 'Editfileservice Happyhours', 'service', 0),
(289, 'imeiorder.new.php', 'Imeiorder New', 'order', 0),
(290, 'imeiorder.summery.php', 'Imeiorder Summery', 'report', 0),
(292, 'userbyincome.php', 'Userbyincome', 'report', 1),
(294, 'maintenance.php', 'Maintenance', 'settings', 1),
(296, 'addcurrency.php', 'Addcurrency', 'settings', 1),
(298, 'home.php', 'Home', 'dashboard', 1),
(299, 'adminlist.php', 'Adminlist', 'settings', 1),
(300, 'knowledgebasecatlist.php', 'Knowledgebasecatlist', 'cms', 1),
(305, 'editfileservice.retailpurchase.php', 'Editfileservice Retailpurchase', 'service', 0),
(309, 'settingautomation.php', 'Settingautomation', 'settings', 1),
(310, 'serverservice.viewgroup.php', 'Serverservice Viewgroup', 'service', 0),
(312, 'serverorder.verification.php', 'Serverorder Verification', 'order', 0),
(315, 'editimeiservice.overview.php', 'Editimeiservice Overview', 'service', 0),
(317, 'serverorder.summery.php', 'Serverorder Summery', 'order', 0),
(318, 'acceptedorderfile.php', 'Acceptedorderfile', 'order', 0),
(319, 'apisetting.comm.php', 'Apisetting Comm', 'settings', 1),
(320, 'fileservice.list.php', 'Fileservice List', 'service', 0),
(321, 'edituser.imeiorder.php', 'Edituser Imeiorder', 'user', 0),
(322, 'viewserverorder.verif.php', 'Viewserverorder Verif', 'order', 0),
(323, 'addimeigroup.php', 'Addimeigroup', 'service', 0),
(327, 'knowledgebase.php', 'Knowledgebase', 'cms', 1),
(333, 'edituser.closeaccount.php', 'Edit User  Close Account', 'user', 1),
(334, 'sendMail.php', 'Mass Mailing', 'utilities', 1),
(335, 'viewpage.php', 'View Pages', 'cms', 1),
(336, 'menumanagermain.php', 'List Menu', 'cms', 1),
(337, 'addmenu.php', 'Add New Menu', 'cms', 1),
(339, 'import.php', 'Import data', 'utilities', 0),
(340, 'utilities.databasebackup.php', 'Database backup', 'utilities', 1),
(341, 'clientgroup.php', 'Client group', 'user', 0),
(376, 'dashboard.testimonial.php', 'Dashboard Testimonial ', 'dashboard', 1),
(377, 'editblogauthor.php', 'Edit Blog Author', 'blog', 1),
(344, 'mep.php', 'MEP Field', 'settings', 0),
(345, 'livechat', 'Live Chat', 'utilities', 1),
(346, 'editproduct.overview.php', 'edit product overview', 'service', 1),
(347, 'editproduct.field.php', 'edit product field', 'service', 1),
(348, 'editproduct.inventory.php', 'edit product inventory', 'service', 1),
(349, 'editproduct.happyhours.php', 'edit product happy hours', 'service', 1),
(350, 'unpaidinvoice.php', 'Unpaid Invoice', 'dashboard', 1),
(351, 'editproduct.imagelink.php', 'edit product  image link', 'service', 1),
(352, 'product.list.php', 'Product List', 'service', 1),
(353, 'manufacturelist.php', 'Manufacture List', 'settings', 1),
(354, 'warehouselist.php', 'Warehouse List', 'settings', 1),
(355, 'editproductgroup.php', 'edit product group', 'service', 1),
(356, 'providerlist.php', 'Provider List', 'settings', 1),
(357, 'editproduct.apiconnection.php', 'Edit Product API Connection', 'service', 1),
(358, 'productorder.replied.php', 'Product Order Replied', 'order', 1),
(359, 'productorder.new.php', 'Product Order New', 'order', 1),
(360, 'product.viewgroup.php', 'Product View Group', 'service', 1),
(361, 'product.addnew.php', 'Product Add New ', 'service', 1),
(362, 'countrylist.php', 'Country List', 'settings', 0),
(363, 'serverquick.edit.php', 'Server Quick Edit', 'service', 0),
(364, 'filequick.edit.php', 'File Quick Edit', 'service', 0),
(365, 'imeiquick.edit.php', 'IMEI Quick Edit', 'service', 0),
(366, 'imeiquickaccept.php', 'IMEI Quick Accept', 'order', 0),
(367, 'filequickaccept.php', 'File Quick Accept', 'order', 0),
(368, 'serverquickaccept.php', 'Server Quick Accept', 'order', 0),
(369, 'quickreply.php', 'Quick Reply', 'order', 0),
(370, 'quickserverreply.php', 'Quick Server Reply', 'order', 0),
(371, 'brandlist.php', 'Brand List', 'settings', 0),
(372, 'modellist.php', 'Model List', 'settings', 0),
(373, 'productorder.history.php', 'Product Order History', 'order', 1),
(374, 'acceptedproductorder.php', 'Accept Product Order', 'order', 1),
(375, 'apisync.php', 'API Synchonization', 'settings', 0),
(378, 'editcountry.php', 'Edit Country', 'settings', 0),
(398, 'edituser.productorder.php', 'Edir User Product Order', 'order', 1),
(380, 'editmanufacture.php', 'Edit Manufacture', 'settings', 0),
(381, 'editmenu.php', 'Edit Menu', 'cms', 1),
(382, 'editmep.php', 'Edit MEP', 'settings', 0),
(383, 'editmodel.php', 'Edit Model', 'settings', 0),
(384, 'editprovider.php', 'Edit Provider', 'settings', 0),
(385, 'editwarehouse.php', 'Edit Warehouse', 'settings', 1),
(386, 'filegroupprice.php', 'File Group Price', 'service', 0),
(387, 'fileorderhistory.php', 'File Order History', 'order', 0),
(388, 'imeigroupprice.php', 'IMEI Group Price', 'service', 0),
(389, 'newpage.php', 'New Page', 'cms', 1),
(390, 'productquickaccept.php', 'Product Quick Accept', 'order', 1),
(391, 'quickacceptedfileorder.php', 'Quick Accept File Order', 'order', 0),
(392, 'quickacceptedorder.php', 'Quick Accept Order', 'order', 0),
(393, 'quickacceptedproductorder.php', 'Quick Accept Product Order', 'order', 1),
(394, 'quickacceptedserverorder.php', 'Quick Accept Server Order', 'order', 0),
(395, 'servergroupprice.php', 'Server Group Price', 'service', 0),
(396, 'utilities.chathistory.php', 'Chat History', 'settings', 1),
(399, 'edituser.editproductorder.php', 'Edit User Edit Product Order', 'user', 1),
(400, 'recharge.php', 'Recharge Voucher Page', 'settings', 1),
(401, 'codelist.php', 'Recharge Voucher Code List', 'settings', 1),
(402, 'clientgroup.php', 'Client Group', 'user', 1),
(403, 'editimeiservice.resetdiscount.php', 'Edit IMEI Service Reset Discount', 'service', 0),
(404, 'editifileservice.resetdiscount.php', 'Edit File Service Reset Discount', 'service', 0),
(405, 'editserverservice.resetdiscount.php', 'Edit Server Service Reset Discount', 'service', 0),
(406, 'imeigroupprice.php', 'IMEI Group Price', 'user', 0),
(407, 'filegroupprice.php', 'File Group Price', 'user', 0),
(408, 'servergroupprice.php', 'Server Group Price', 'user', 0),
(409, 'clientgroupmember.php', 'Client Group member list', 'user', 1),
(411, 'utilities.systemsummary.php', 'Utilities System Summary', 'dashboard', 1),
(412, 'edituser.subscription.php', 'Edit User Subscribed User ', 'user', 1),
(413, 'editimeiservice.subscribe.php', 'Edit IMEI service subscription settings', 'service', 0),
(414, 'editimeiservice.subscribeduser.php', 'IMEI Service subscribed user', 'service', 0),
(415, 'editfileservice.subscribe.php', 'File service subscription setting', 'service', 0),
(416, 'editfileservice.subscribeduser.php', 'File service subscribed user', 'service', 0),
(417, 'editserverservice.subscribe.php', 'Server Log Subscription settings', 'service', 0),
(418, 'editserverservice.subscribeduser.php', 'Server Log Subscribed User', 'service', 0),
(419, 'editproduct.subscribe.php', 'Product Subscription settings', 'service', 1),
(420, 'editproduct.subscribeduser.php', 'Product Subscribed User', 'service', 1),
(421, 'updatemultipalclient.php', 'Update Multipal Client', 'user', 1),
(422, 'addproductgroup.php', 'Add Product Group', 'service', 1),
(423, 'apilog.php', 'API Log', 'report', 0),
(424, 'gatewaylog.php', 'Gateway Log', 'report', 1),
(425, 'utilities.supplierlog.php', 'Supplier Loging Log', 'utilities', 1),
(426, 'recentmenu.php', 'Recent Menu', 'cms', 1),
(427, 'utilities.discountcheck.php', 'Check Discount By Sservice', 'utilities', 1),
(428, 'shippingateway.list.php', 'Shipping Gateway List', 'settings', 1),
(429, 'shippingateway.conf.php', 'Shipping Gateway Configuration', 'settings', 1),
(430, 'shippingatewaycustom.php', 'Custom Shipping Gateway', 'settings', 1),
(431, 'utilities.templateeditor.php', 'Utilities Template Editor', 'utilities', 1),
(432, 'templatelist.php', 'Template List', 'utilities', 1),
(433, 'support.department.php', 'Support Tickets department', 'support', 1),
(434, 'support.status.php', 'Support Ticket Status', 'support', 1),
(435, 'support.priority.php', 'Support Ticket priority', 'support', 1),
(436, 'support.open.php', 'Support tickets', 'support', 1),
(437, 'systemlog.php', 'System Activity', 'report', 1),
(438, 'softwarekey.php', 'add new software key', 'settings', 1),
(439, 'softwarekey.list.php', 'List software key', 'settings', 1),
(440, 'editsoftwatekey.php', 'Edit software key', 'settings', 1),
(441, 'advertisement.php', 'Advertisement Setting', 'cms', 1),
(442, 'imeiprofit.php', 'IMEI Profit', 'report', 0),
(443, 'fileprofit.php', 'File Profit', 'report', 0),
(444, 'serverprofit.php', 'Server Profit', 'report', 0),
(445, 'promotion.php', 'Add Promotion Code', 'settings', 1),
(446, 'usedpromotion.php', 'Used Promotion Code', 'settings', 1),
(447, 'pendingpromotion.php', 'Pending Promotion code', 'settings', 1),
(449, 'pendingcodelist.php', 'Pending Code List', 'settings', 1),
(450, 'utilities.review.php', 'Customer Review', 'dashboard', 1),
(452, 'settingsmenu.php', 'Settings Menu', 'settings', 1),
(453, 'productprofit.php', 'Product Profit', 'report', 1),
(454, 'productorder.report.php', 'Product Order Report', 'report', 0),
(456, 'graph.php', 'Graph', 'report', 1),
(457, 'monthlysummery.php', 'Monthly Summary', 'report', 1),
(458, 'support.tag.php', 'Support Tag', 'support', 1),
(459, 'product.listgroup.php', 'Product List Group', 'service', 1),
(460, 'productorder.summery.php', 'Product Order Summary', 'order', 1),
(461, 'whiteip.php', 'White IP', 'utilities', 1),
(465, 'productfeature.add.php', 'Product Feature Add', 'service', 1),
(468, 'chat.settings.php', 'Chat Setting', 'settings', 1),
(469, 'softwarekeygroup.php', 'Software Key Group', 'utilities', 1),
(471, 'emailtemplate.notification.php', 'Email Template Notification', 'settings', 1),
(475, 'filequickaccept.php', 'File order Quick Accept', 'order', 0),
(476, 'livechat.php', 'Live Chat', 'dashboard', 1),
(477, 'newsletter.php', 'Newsletter Subscribers', 'utilities', 1),
(478, 'smsgateway.clickatell.php', 'SMS Gateway Clickatell Settings', 'settings', 1),
(479, 'smsgateway.customapi.php', 'SMS Custom API settings', 'settings', 1),
(480, 'smslog.php', 'SMS Gatway Log', 'utilities', 1),
(481, 'editimeiservice.review.php', 'IMEI Service Review', 'service', 0),
(482, 'utilities.pendingquick.php', 'Quick checkout Pending order', 'utilities', 1),
(483, 'stockreport.php', 'Stock Report', 'report', 1),
(484, 'edituser.affiliate.php', 'Affiliate system for user', 'user', 1),
(485, 'affiliate.php', 'Affiliate Settings', 'settings', 1),
(486, 'pos.manage.php', 'POS Product Manager', 'pos', 1),
(487, 'pos.sales.php', 'POS Sale Panel', 'pos', 1),
(488, 'pos.report.sales.php', 'POS Sales Report', 'pos', 1),
(489, 'pos.report.sold.php', 'POS Sold Item report', 'pos', 1),
(490, 'pos.report.payment.php', 'POS Payment Report', 'pos', 1),
(491, 'pos.report.inventory.php', 'POS Inventory Report', 'pos', 1),
(492, 'userstatements.php', 'User Statement', 'report', 1),
(493, 'creditreport.php', 'User Credit Summary ', 'report', 1),
(494, 'pos.stock.transfer.php', 'POS Stock transfer from one warehouse to other', 'pos', 1),
(495, 'homepagegroup,php', 'Home Page Product grouping', 'service', 1),
(496, 'utilities.seo.xml.php', 'SEO xml sitemap generator', 'utilities', 1),
(497, 'utilities.language.php', 'Language Editor', 'utilities', 1),
(498, 'utilities.withdrawal.php', 'Utilities Withdrawal Request', 'utilities', 0),
(499, 'promotionalusage.php', 'Promotional Usage', 'report', 1),
(500, 'sendSMS.php', 'Send Mass SMS', 'utilities', 1),
(501, 'utilities.config.php', 'Backup Options', 'utilities', 1),
(502, 'providermodelmep.php', 'Provider Model Mep', 'settings', 1),
(505, 'utilities.seo.google.php', 'SEO Google base generator', 'utilities', 1),
(506, 'imeiorder.pending.php', 'IMEI Pending Payment Order', 'order', 0),
(507, 'serverorder.pending.php', 'Server Pending Payment Order', 'order', 0),
(508, 'productorder.pending.php', 'Product Pending Payment Order', 'order', 1),
(509, 'utilities.ccprocess.php', 'Credit Card Offline Process', 'utilities', 1),
(510, 'productorder.return.php', 'Product Order Return ', 'order', 1),
(511, 'productdraw.php', 'Product Lucky Draw', 'order', 1),
(512, 'menumaster.php', 'Master Navigation management', 'cms', 1),
(513, 'servicestatus.php', 'Service Status', 'report', 0),
(514, 'refundreport.php', 'Refund Report', 'report', 1),
(515, 'apioptimise.php', 'API Optimisation', 'utilities', 0),
(516, 'survey.php', 'Survey managerment', 'utilities', 1),
(517, 'prd.php', 'PRD Field Settings', 'settings', 0),
(518, 'suppliersorder.php', 'Suppliers Order report', 'report', 1),
(519, 'ebayorder.php', 'IMEI Direct Order', 'utilities', 0),
(520, 'storeselling.php', 'Resellers Store selling Report', 'report', 1),
(521, 'download.php', 'Download Manager', 'support', 1),
(523, 'edituser.editinvoice.php', 'Edit Invoice', 'order', 1),
(524, 'stock.php', 'Remove Stock', 'pos', 0),
(525, 'pos.sales.php', 'Can Change Warehouse', 'pos', 0),
(527, 'settingother.php', 'Download Client List and Statement', 'settings', 0),
(528, 'help.selfupdate.php', 'Self Updates', 'help', 0),
(529, 'ipsearch.php', 'IP search', 'dashboard', 0),
(530, 'unpaidoffline.php', 'Offline gateway Unpaid Invoices', 'dashboard', 0),
(531, 'template.editor.php', 'Template Editor', 'cms', 0),
(532, 'blackemail.php', 'Email Blacklist', 'utilities', 0),
(533, 'fraudcage.php', 'Fraud Cage', 'utilities', 0),
(534, 'fraudprotection.php', 'Fraud Protection Settings', 'settings', 0),
(535, 'emailtemplate.sheduled.php', 'Scheduled Email', 'email', 0),
(536, 'support.create.php', 'Create Support Ticket', 'support', 0),
(537, 'gallery.php', 'Image Gallery', 'cms', 0),
(538, 'cloudbanner.php', 'Store Banner', 'store', 0),
(539, 'cloudtheme.php', 'Store Theme', 'store', 0),
(540, 'contactuscontent.php', 'Contact Us content', 'cms', 0),
(541, 'emailtemplate.layout.php', 'Email Template Layout', 'settings', 0),
(542, 'staffsummary.php', 'Staff Summary', 'report', 0),
(543, 'mailicontact.php', 'iContact Email', 'utilities', 0),
(544, 'mailchimp.php', 'MailChimp Email', 'utilities', 0),
(545, 'zoho.php', 'Zoho Email', 'utilities', 0),
(546, 'activitylog.php', 'Activity Log', 'utilities', 0),
(547, 'productquick.edit.php', 'Product Quick Edit', 'service', 0),
(548, 'smsgateway.settings.php', 'SMS Gateway Settings', 'utilities', 0),
(549, 'smsgateway.messages.php', 'SMS Templates', 'utilities', 0),
(550, 'header.php', 'Intelligent Search', 'settings', 0),
(551, 'slack.php', 'Telegram / Slack Integration', 'utilities', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_admin_access_group`
--

CREATE TABLE `tbl_admin_access_group` (
  `id` int(11) NOT NULL,
  `group_name` varchar(100) NOT NULL,
  `access` longtext NOT NULL,
  `system` tinyint(1) NOT NULL DEFAULT 0,
  `account` tinyint(1) NOT NULL DEFAULT 0,
  `support` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `tbl_admin_access_group`
--

INSERT INTO `tbl_admin_access_group` (`id`, `group_name`, `access`, `system`, `account`, `support`) VALUES
(1, 'Full Access', '1,6,110,185,236,290,292,423,424,437,442,443,444,453,454,456,457,483,492,493,499,513,514,518,520,542,2,26,34,42,51,60,71,73,75,76,78,95,103,122,130,148,163,166,171,172,209,216,241,251,259,261,263,273,284,287,305,310,315,320,323,346,347,348,349,351,352,355,357,360,361,363,364,365,386,388,395,403,404,405,413,414,415,416,417,418,419,420,422,459,465,481,495,547,4,14,30,47,61,90,128,164,169,183,186,192,198,212,213,214,220,225,233,252,255,275,321,333,341,399,402,406,407,408,409,412,421,484,8,101,104,113,151,167,195,338,334,339,340,345,425,427,431,432,461,469,477,480,482,496,497,498,500,501,505,509,515,516,519,532,533,543,544,545,546,548,549,551,10,35,83,89,99,112,132,179,196,204,207,285,11,12,56,67,86,91,94,119,141,154,181,265,300,327,335,336,337,381,389,426,441,512,531,537,540,13,23,29,32,52,63,125,134,144,147,182,188,191,201,228,231,238,245,253,254,258,277,279,283,294,296,299,309,319,344,353,354,356,362,371,372,375,378,380,382,383,384,385,396,400,401,428,429,430,438,439,440,445,446,447,449,452,468,471,478,479,485,502,517,527,534,541,550,22,36,39,81,84,88,97,100,111,397,121,123,137,145,153,159,175,189,193,197,210,234,256,266,289,312,317,318,322,358,359,366,367,368,369,370,373,374,398,387,390,391,392,393,394,460,475,506,507,508,510,511,523,33,79,106,180,187,208,244,377,328,329,528,249,330,331,332,298,376,350,411,450,476,529,530,433,434,435,436,458,521,536,486,487,488,489,490,491,494,524,525,535,538,539,168,55,9999', 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_admin_activity`
--

CREATE TABLE `tbl_admin_activity` (
  `id` int(10) NOT NULL,
  `date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `description` mediumtext NOT NULL,
  `user` mediumtext NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_admin_fund_log`
--

CREATE TABLE `tbl_admin_fund_log` (
  `id` int(11) NOT NULL,
  `aid` int(11) NOT NULL DEFAULT 0,
  `desc` mediumtext NOT NULL,
  `date` varchar(50) NOT NULL,
  `amount` varchar(20) NOT NULL,
  `type` varchar(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_admin_info`
--

CREATE TABLE `tbl_admin_info` (
  `id` int(9) NOT NULL,
  `name` varchar(25) NOT NULL,
  `value` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_advertisement_banners`
--

CREATE TABLE `tbl_advertisement_banners` (
  `id` int(10) NOT NULL,
  `img` mediumtext NOT NULL,
  `img_title` mediumtext NOT NULL,
  `info` mediumtext NOT NULL,
  `readmore_link` mediumtext NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_affiliate_banner`
--

CREATE TABLE `tbl_affiliate_banner` (
  `id` int(11) NOT NULL,
  `banner` varchar(1000) NOT NULL,
  `name` varchar(555) NOT NULL,
  `width` varchar(50) NOT NULL,
  `height` varchar(50) NOT NULL,
  `alttag` varchar(255) NOT NULL,
  `description` varchar(555) NOT NULL,
  `type` varchar(50) NOT NULL,
  `group_id` int(11) NOT NULL DEFAULT 0,
  `service_id` int(11) NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_affiliate_history`
--

CREATE TABLE `tbl_affiliate_history` (
  `id` int(11) NOT NULL,
  `aid` int(11) NOT NULL DEFAULT 0,
  `uid` int(11) NOT NULL DEFAULT 0,
  `oid` int(11) NOT NULL DEFAULT 0,
  `amount` varchar(255) NOT NULL,
  `comission` varchar(255) NOT NULL,
  `type` varchar(50) NOT NULL,
  `date` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_affiliate_payout`
--

CREATE TABLE `tbl_affiliate_payout` (
  `id` int(11) NOT NULL,
  `aid` int(11) NOT NULL DEFAULT 0,
  `amount` varchar(255) NOT NULL,
  `ptype` varchar(255) NOT NULL,
  `time` varchar(50) NOT NULL,
  `transactionid` varchar(150) NOT NULL,
  `note` mediumtext NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_affiliate_text`
--

CREATE TABLE `tbl_affiliate_text` (
  `id` int(11) NOT NULL,
  `name` varchar(555) NOT NULL,
  `description` varchar(555) NOT NULL,
  `type` varchar(50) NOT NULL,
  `group_id` int(11) NOT NULL DEFAULT 0,
  `service_id` int(11) NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_annoucement_disabled`
--

CREATE TABLE `tbl_annoucement_disabled` (
  `id` int(11) NOT NULL,
  `annoucemnt` int(11) NOT NULL,
  `uid` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_apilog`
--

CREATE TABLE `tbl_apilog` (
  `id` int(10) NOT NULL,
  `date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `gateway` varchar(100) NOT NULL,
  `data` mediumtext NOT NULL,
  `result` varchar(50) NOT NULL,
  `orderid` int(11) NOT NULL,
  `apiserviceid` varchar(500) NOT NULL,
  `send` int(1) NOT NULL,
  `connections` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `tbl_apilog`
--

INSERT INTO `tbl_apilog` (`id`, `date`, `gateway`, `data`, `result`, `orderid`, `apiserviceid`, `send`, `connections`) VALUES
(1, '2023-03-04 18:43:25', 'fusion13', 'OrderID => 1 UserID => 1 ERROR => ValidationError123<li>SERIAL NUMBER Required or Invalid</li> MESSAGE => ValidationError123<li>SERIAL NUMBER Required or Invalid</li>,SERIAL NUMBER Required or Invalid ', 'ValidationError123<li>SERIAL NUMBER Required or In', 1, '2390', 1, 'Primary : APPLE SERIAL INFO =>');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_apiservers`
--

CREATE TABLE `tbl_apiservers` (
  `gateway` varchar(50) NOT NULL,
  `setting` varchar(55) NOT NULL,
  `value` varchar(1555) NOT NULL,
  `order` int(1) NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `tbl_apiservers`
--

INSERT INTO `tbl_apiservers` (`gateway`, `setting`, `value`, `order`) VALUES
('fusion13', 'apiurl', 'https://i-imei.com/', 0),
('fusion13', 'apikey', 'MAU-ADF-K38-PE-3MR-R9L-1N-QEQ', 0),
('fusion13', 'username', 'myicloud', 0),
('fusion13', 'notes', 'Connect Other Fusion site ', 0),
('fusion13', 'customname', 'i-imei.com', 0),
('fusion13', 'name', 'Other Fusion 13', 0),
('fusion13', 'active', '1', 0),
('fusion13', 'LastError', 'ValidationError123<li>SERIAL NUMBER Required or Invalid</li>', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_apiserversservices`
--

CREATE TABLE `tbl_apiserversservices` (
  `apiserverid` int(11) NOT NULL,
  `gateway` varchar(50) NOT NULL,
  `type` varchar(50) NOT NULL,
  `name` mediumtext NOT NULL,
  `id` varchar(100) NOT NULL,
  `credits` mediumtext NOT NULL,
  `message` mediumtext NOT NULL,
  `delivery` mediumtext NOT NULL,
  `requires_network` mediumtext NOT NULL,
  `requires_mobile` mediumtext NOT NULL,
  `requires_provider` mediumtext NOT NULL,
  `requires_pin` mediumtext NOT NULL,
  `requires_kbh` mediumtext NOT NULL,
  `requires_mep` mediumtext NOT NULL,
  `requires_prd` mediumtext NOT NULL,
  `requires_reference` mediumtext NOT NULL,
  `requires_servicetag` mediumtext NOT NULL,
  `requires_type` mediumtext NOT NULL,
  `requires_locks` mediumtext NOT NULL,
  `requires_SN` mediumtext NOT NULL,
  `requires_SecRO` mediumtext NOT NULL,
  `group` mediumtext NOT NULL,
  `assigned_network` mediumtext NOT NULL,
  `assigned_country` mediumtext NOT NULL,
  `assigned_brands` mediumtext NOT NULL,
  `assigned_mobiles` mediumtext NOT NULL,
  `assigned_mep` mediumtext NOT NULL,
  `order` int(1) NOT NULL DEFAULT 0,
  `servicetype` varchar(10) NOT NULL,
  `currency` varchar(10) NOT NULL,
  `credittmp` decimal(14,2) NOT NULL,
  `flagprice` int(1) NOT NULL DEFAULT 0,
  `useasserver` int(1) NOT NULL DEFAULT 0,
  `qnt` int(1) NOT NULL DEFAULT 0,
  `requires_custom` text NOT NULL,
  `type_id` varchar(50) NOT NULL,
  `guiid` varchar(50) NOT NULL,
  `suid` int(11) NOT NULL,
  `qntoptions` varchar(150) NOT NULL,
  `minqnt` int(4) NOT NULL,
  `maxqnt` int(4) NOT NULL,
  `imeifield` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `tbl_apiserversservices`
--

INSERT INTO `tbl_apiserversservices` (`apiserverid`, `gateway`, `type`, `name`, `id`, `credits`, `message`, `delivery`, `requires_network`, `requires_mobile`, `requires_provider`, `requires_pin`, `requires_kbh`, `requires_mep`, `requires_prd`, `requires_reference`, `requires_servicetag`, `requires_type`, `requires_locks`, `requires_SN`, `requires_SecRO`, `group`, `assigned_network`, `assigned_country`, `assigned_brands`, `assigned_mobiles`, `assigned_mep`, `order`, `servicetype`, `currency`, `credittmp`, `flagprice`, `useasserver`, `qnt`, `requires_custom`, `type_id`, `guiid`, `suid`, `qntoptions`, `minqnt`, `maxqnt`, `imeifield`) VALUES
(446, 'fusion13', 'Tool', 'INSTANT SLOVAKIA ORANGE/T-MOBILE iPHONE UNLOCK', '455', '1', '', '1-10 Minutes', 'None', 'None', 'None', 'None', 'None', 'None', 'None', 'None', '', 'None', 'None', 'None', 'None', 'BEST OFFER', '', '', '', '', '', 0, '', '', '1.00', 0, 0, 0, '', '', '22e0f60ac93f49a067ec7f12e9c3e040', 0, '', 0, 0, '{\"allow\":\"0\",\"bulk\":\"1\",\"customname\":\"\",\"custominfo\":\"\",\"customlen\":\"0\",\"maxlength\":\"0\",\"regex\":\"\",\"isalpha\":\"0\"}'),
(445, 'fusion13', 'Tool', 'INSTANT DENMARK HUTCHINSON iPHONE UNLOCK', '446', '1', '', '1-10 Minutes', 'None', 'None', 'None', 'None', 'None', 'None', 'None', 'None', '', 'None', 'None', 'None', 'None', 'BEST OFFER', '', '', '', '', '', 0, '', '', '1.00', 0, 0, 0, '', '', 'b011ce4178f278d678b997b14d1ec2b8', 0, '', 0, 0, '{\"allow\":\"0\",\"bulk\":\"1\",\"customname\":\"\",\"custominfo\":\"\",\"customlen\":\"0\",\"maxlength\":\"0\",\"regex\":\"\",\"isalpha\":\"0\"}'),
(443, 'fusion13', 'Group', 'BEST OFFER', 'BEST OFFER', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0, '', '', '0.00', 0, 0, 0, '', '', '', 0, '', 0, 0, ''),
(444, 'fusion13', 'Tool', 'INSTANT FRANCE BOUYGUES iPHONE UNLOCK', '473', '1', '', '1-3 Minutes', 'None', 'None', 'None', 'None', 'None', 'None', 'None', 'None', '', 'None', 'None', 'None', 'None', 'BEST OFFER', '', '', '', '', '', 0, '', '', '1.00', 0, 0, 0, '', '', '5f4c8c0a8a0f06de49cf57054318b845', 0, '', 0, 0, '{\"allow\":\"0\",\"bulk\":\"1\",\"customname\":\"\",\"custominfo\":\"\",\"customlen\":\"0\",\"maxlength\":\"0\",\"regex\":\"\",\"isalpha\":\"0\"}'),
(442, 'fusion13', 'Tool', 'MEXICO MOVISTAR / NEXTEL / IUSACELL / UNEFON GENERIC ALL BRANDS (NOKIA SONY ETC)', '2255', '2.5', '', '1-7 Days', 'None', 'None', 'None', 'None', 'None', 'None', 'None', 'None', '', 'None', 'None', 'None', 'None', 'GENERIC UNLOCK', '', '', '', '', '', 0, '', '', '2.50', 0, 0, 0, '', '', '649c8224925835631762703ce41fa8a3', 0, '', 0, 0, '{\"allow\":\"0\",\"bulk\":\"1\",\"customname\":\"\",\"custominfo\":\"\",\"customlen\":\"0\",\"maxlength\":\"0\",\"regex\":\"\",\"isalpha\":\"0\"}'),
(441, 'fusion13', 'Tool', 'MOVISTAR MEXICO GENERIC ALL BRANDS (NOKIA SONY ETC)', '1490', '2.5', '', '1-24 Hours', 'None', 'None', 'None', 'None', 'None', 'None', 'None', 'None', '', 'None', 'None', 'None', 'None', 'GENERIC UNLOCK', '', '', '', '', '', 0, '', '', '2.50', 0, 0, 0, '', '', 'f400ee81c0746a8a198a521dc990fb12', 0, '', 0, 0, '{\"allow\":\"0\",\"bulk\":\"1\",\"customname\":\"\",\"custominfo\":\"\",\"customlen\":\"0\",\"maxlength\":\"0\",\"regex\":\"\",\"isalpha\":\"0\"}'),
(440, 'fusion13', 'Tool', 'NEXTEL MEXICO GENERIC ALL BRANDS (NOKIA SONY ETC)', '1499', '3', '', '1-2 Days', 'None', 'None', 'None', 'None', 'None', 'None', 'None', 'None', '', 'None', 'None', 'None', 'None', 'GENERIC UNLOCK', '', '', '', '', '', 0, '', '', '3.00', 0, 0, 0, '', '', '26f13b3dd0b735a547d62b17232a6aa4', 0, '', 0, 0, '{\"allow\":\"0\",\"bulk\":\"1\",\"customname\":\"\",\"custominfo\":\"\",\"customlen\":\"0\",\"maxlength\":\"0\",\"regex\":\"\",\"isalpha\":\"0\"}'),
(439, 'fusion13', 'Tool', 'LG INTERNATIONAL ALL MODELS &amp; ALL LEVEL - UNTIL 2019 (NOT FOUND)', '1850', '6.8', '', '1-60 Minutes', 'None', 'None', 'None', 'None', 'None', 'None', 'None', 'None', '', 'None', 'None', 'None', 'None', 'GENERIC UNLOCK', '', '', '', '', '', 0, '', '', '6.80', 0, 0, 0, '', '', '3fee2e204e344892781cf66f00adcabd', 0, '', 0, 0, '{\"allow\":\"0\",\"bulk\":\"1\",\"customname\":\"\",\"custominfo\":\"\",\"customlen\":\"0\",\"maxlength\":\"0\",\"regex\":\"\",\"isalpha\":\"0\"}'),
(438, 'fusion13', 'Tool', 'LG INTERNATIONAL ALL MODELS &amp; ALL LEVEL - PREMIUM 2020', '1796', '15', '', '1-20 Minutes', 'None', 'None', 'None', 'None', 'None', 'None', 'None', 'None', '', 'None', 'None', 'None', 'None', 'GENERIC UNLOCK', '', '', '', '', '', 0, '', '', '15.00', 0, 0, 0, '', '', '2096bdfcec43ab1e31a844fd270dd700', 0, '', 0, 0, '{\"allow\":\"0\",\"bulk\":\"1\",\"customname\":\"\",\"custominfo\":\"\",\"customlen\":\"0\",\"maxlength\":\"0\",\"regex\":\"\",\"isalpha\":\"0\"}'),
(437, 'fusion13', 'Tool', 'LG INTERNATIONAL ALL MODELS &amp; ALL LEVEL - UNTIL 2019 ', '1535', '6.4', '', '1-15 Minutes', 'None', 'None', 'None', 'None', 'None', 'None', 'None', 'None', '', 'None', 'None', 'None', 'None', 'GENERIC UNLOCK', '', '', '', '', '', 0, '', '', '6.40', 0, 0, 0, '', '', '658ca5f0997b86f007471e25150d61b7', 0, '', 0, 0, '{\"allow\":\"0\",\"bulk\":\"1\",\"customname\":\"\",\"custominfo\":\"\",\"customlen\":\"0\",\"maxlength\":\"0\",\"regex\":\"\",\"isalpha\":\"0\"}'),
(436, 'fusion13', 'Tool', 'ALCATEL WORLDWIDE UNLOCK - SPD FACTORY CODE', '2903', '1.1', '', '1-12 Hours', 'None', 'None', 'None', 'None', 'None', 'None', 'None', 'None', '', 'None', 'None', 'None', 'None', 'GENERIC UNLOCK', '', '', '', '', '', 0, '', '', '1.10', 0, 0, 0, '', '', '46bedf35e4171edce8416747bbc882e7', 0, '', 0, 0, '{\"allow\":\"0\",\"bulk\":\"1\",\"customname\":\"\",\"custominfo\":\"\",\"customlen\":\"0\",\"maxlength\":\"0\",\"regex\":\"\",\"isalpha\":\"0\"}'),
(435, 'fusion13', 'Tool', 'ALCATEL WORLDWIDE UNLOCK - DATABASE 2', '2894', '1.2', '', '1-12 Hours', 'None', 'None', 'None', 'None', 'None', 'None', 'None', 'None', '', 'None', 'None', 'None', 'None', 'GENERIC UNLOCK', '', '', '', '', '', 0, '', '', '1.20', 0, 0, 0, '', '', '35e7928f791db6e52407a4147f808803', 0, '', 0, 0, '{\"allow\":\"0\",\"bulk\":\"1\",\"customname\":\"\",\"custominfo\":\"\",\"customlen\":\"0\",\"maxlength\":\"0\",\"regex\":\"\",\"isalpha\":\"0\"}'),
(434, 'fusion13', 'Tool', 'ALCATEL WORLDWIDE UNLOCK - DATABASE 1', '1121', '1', '', '1-12 Hours', 'None', 'None', 'None', 'None', 'None', 'None', 'None', 'None', '', 'None', 'None', 'None', 'None', 'GENERIC UNLOCK', '', '', '', '', '', 0, '', '', '1.00', 0, 0, 0, '', '', 'dcdb3223db7b03f14ed976cdd1357913', 0, '', 0, 0, '{\"allow\":\"0\",\"bulk\":\"1\",\"customname\":\"\",\"custominfo\":\"\",\"customlen\":\"0\",\"maxlength\":\"0\",\"regex\":\"\",\"isalpha\":\"0\"}'),
(433, 'fusion13', 'Tool', 'HTC FACTORY UNLOCK CODES - NEW MODELS &amp; NOT FOUND', '500', '2.2', '', '1-10 Minutes', 'None', 'None', 'None', 'None', 'None', 'None', 'None', 'None', '', 'None', 'None', 'None', 'None', 'GENERIC UNLOCK', '', '', '', '', '', 0, '', '', '2.20', 0, 0, 0, '', '', 'c7899919640dc490b728c36bc9a6bcd4', 0, '', 0, 0, '{\"allow\":\"0\",\"bulk\":\"1\",\"customname\":\"\",\"custominfo\":\"\",\"customlen\":\"0\",\"maxlength\":\"0\",\"regex\":\"\",\"isalpha\":\"0\"}'),
(432, 'fusion13', 'Tool', 'HTC FACTORY UNLOCK CODES - DATABASE 2', '2147', '1.6', '', '1-10 Minutes', 'None', 'None', 'None', 'None', 'None', 'None', 'None', 'None', '', 'None', 'None', 'None', 'None', 'GENERIC UNLOCK', '', '', '', '', '', 0, '', '', '1.60', 0, 0, 0, '', '', 'c5f90f12356315ecbcf5e971f45717c3', 0, '', 0, 0, '{\"allow\":\"0\",\"bulk\":\"1\",\"customname\":\"\",\"custominfo\":\"\",\"customlen\":\"0\",\"maxlength\":\"0\",\"regex\":\"\",\"isalpha\":\"0\"}'),
(431, 'fusion13', 'Tool', 'HTC FACTORY UNLOCK CODES - DATABASE 1', '491', '1', '', '1-10 Minutes', 'None', 'None', 'None', 'None', 'None', 'None', 'None', 'None', '', 'None', 'None', 'None', 'None', 'GENERIC UNLOCK', '', '', '', '', '', 0, '', '', '1.00', 0, 0, 0, '', '', 'e7e5224208ef8af9e8601398acdf60d1', 0, '', 0, 0, '{\"allow\":\"0\",\"bulk\":\"1\",\"customname\":\"\",\"custominfo\":\"\",\"customlen\":\"0\",\"maxlength\":\"0\",\"regex\":\"\",\"isalpha\":\"0\"}'),
(430, 'fusion13', 'Tool', 'LENOVO WORLDWIDE UNLOCK - DATABASE 2', '2921', '5.8', '', '1-4 Days', 'None', 'None', 'None', 'None', 'None', 'None', 'None', 'None', '', 'None', 'None', 'None', 'None', 'GENERIC UNLOCK', '', '', '', '', '', 0, '', '', '5.80', 0, 0, 0, '', '', '91a8c058ec648a17435e9b6187a51757', 0, '', 0, 0, '{\"allow\":\"0\",\"bulk\":\"1\",\"customname\":\"\",\"custominfo\":\"\",\"customlen\":\"0\",\"maxlength\":\"0\",\"regex\":\"\",\"isalpha\":\"0\"}'),
(429, 'fusion13', 'Tool', 'LENOVO WORLDWIDE UNLOCK - DATABASE 1', '2912', '5.8', '', '1-4 Days', 'None', 'None', 'None', 'None', 'None', 'None', 'None', 'None', '', 'None', 'None', 'None', 'None', 'GENERIC UNLOCK', '', '', '', '', '', 0, '', '', '5.80', 0, 0, 0, '', '', 'c7c26e476fbebd690ec1f94ddf6bddaf', 0, '', 0, 0, '{\"allow\":\"0\",\"bulk\":\"1\",\"customname\":\"\",\"custominfo\":\"\",\"customlen\":\"0\",\"maxlength\":\"0\",\"regex\":\"\",\"isalpha\":\"0\"}'),
(428, 'fusion13', 'Tool', 'ORANGE FRANCE GENERIC ALL BRANDS (NOKIA SONY ETC) - NOT FOUND', '1805', '16', '', '1-3 Days', 'None', 'None', 'None', 'None', 'None', 'None', 'None', 'None', '', 'None', 'None', 'None', 'None', 'GENERIC UNLOCK', '', '', '', '', '', 0, '', '', '16.00', 0, 0, 0, '', '', 'f857342824fa3d390a519843afaec03a', 0, '', 0, 0, '{\"allow\":\"0\",\"bulk\":\"0\",\"customname\":\"\",\"custominfo\":\"\",\"customlen\":\"0\",\"maxlength\":\"0\",\"regex\":\"\",\"isalpha\":\"0\"}'),
(427, 'fusion13', 'Tool', 'ORANGE FRANCE GENERIC ALL BRANDS (NOKIA SONY ETC) - CLEAN', '950', '5', '', '1-3 Hours', 'None', 'None', 'None', 'None', 'None', 'None', 'None', 'None', '', 'None', 'None', 'None', 'None', 'GENERIC UNLOCK', '', '', '', '', '', 0, '', '', '5.00', 0, 0, 0, '', '', '91846579eb063c24330303f36cb7a310', 0, '', 0, 0, '{\"allow\":\"0\",\"bulk\":\"1\",\"customname\":\"\",\"custominfo\":\"\",\"customlen\":\"0\",\"maxlength\":\"0\",\"regex\":\"\",\"isalpha\":\"0\"}'),
(426, 'fusion13', 'Tool', 'SFR FRANCE GENERIC ALL BRANDS (NOKIA SONY ETC) - PREMIUM', '194', '7.6', '', '1-12 Hours', 'None', 'None', 'None', 'None', 'None', 'None', 'None', 'None', '', 'None', 'None', 'None', 'None', 'GENERIC UNLOCK', '', '', '', '', '', 0, '', '', '7.60', 0, 0, 0, '', '', '3fcffb16731db7bcd8cea1f7b8c2fdab', 0, '', 0, 0, '{\"allow\":\"0\",\"bulk\":\"1\",\"customname\":\"\",\"custominfo\":\"\",\"customlen\":\"0\",\"maxlength\":\"0\",\"regex\":\"\",\"isalpha\":\"0\"}'),
(425, 'fusion13', 'Tool', 'SFR FRANCE GENERIC ALL BRANDS (NOKIA SONY ETC) - CLEAN', '1310', '7', '', '0-20 Minutes', 'None', 'None', 'None', 'None', 'None', 'None', 'None', 'None', '', 'None', 'None', 'None', 'None', 'GENERIC UNLOCK', '', '', '', '', '', 0, '', '', '7.00', 0, 0, 0, '', '', '13b2efde2371d0c2357cc82f30ac3e09', 0, '', 0, 0, '{\"allow\":\"0\",\"bulk\":\"1\",\"customname\":\"\",\"custominfo\":\"\",\"customlen\":\"0\",\"maxlength\":\"0\",\"regex\":\"\",\"isalpha\":\"0\"}'),
(423, 'fusion13', 'Tool', '3 HUTCHISON UK GENERIC ALL MODELS (EXCEPT iPHONE)', '2507', '8.4', '', '1-5 Days', 'None', 'None', 'None', 'None', 'None', 'None', 'None', 'None', '', 'None', 'None', 'None', 'None', 'GENERIC UNLOCK', '', '', '', '', '', 0, '', '', '8.40', 0, 0, 0, '', '', 'b2ed1b4d12e7353cddf2c1f969dcc09d', 0, '', 0, 0, '{\"allow\":\"0\",\"bulk\":\"1\",\"customname\":\"\",\"custominfo\":\"\",\"customlen\":\"0\",\"maxlength\":\"0\",\"regex\":\"\",\"isalpha\":\"0\"}'),
(424, 'fusion13', 'Tool', 'BOUYGUES FRANCE GENERIC ALL BRANDS (NOKIA SONY ETC)', '1166', '4', '', '1-3 Hours', 'None', 'None', 'None', 'None', 'None', 'None', 'None', 'None', '', 'None', 'None', 'None', 'None', 'GENERIC UNLOCK', '', '', '', '', '', 0, '', '', '4.00', 0, 0, 0, '', '', 'c8dd375f609b5feb9df91763bdb7b777', 0, '', 0, 0, '{\"allow\":\"0\",\"bulk\":\"1\",\"customname\":\"\",\"custominfo\":\"\",\"customlen\":\"0\",\"maxlength\":\"0\",\"regex\":\"\",\"isalpha\":\"0\"}'),
(422, 'fusion13', 'Tool', 'O2 UK GENERIC ALL MODELS (EXCEPT iPHONE) - CLEAN', '644', '3.2', '', '4-8 days', 'None', 'None', 'None', 'None', 'None', 'None', 'None', 'None', '', 'None', 'None', 'None', 'None', 'GENERIC UNLOCK', '', '', '', '', '', 0, '', '', '3.20', 0, 0, 0, '', '', '1336886740a0cfee8bb5beb7754f30e9', 0, '', 0, 0, '{\"allow\":\"0\",\"bulk\":\"1\",\"customname\":\"\",\"custominfo\":\"\",\"customlen\":\"0\",\"maxlength\":\"0\",\"regex\":\"\",\"isalpha\":\"0\"}'),
(421, 'fusion13', 'Tool', 'SONY &amp; XPERIA UNITED KINGDOM NETWORKS UNLOCK', '2678', '18', '', '1-6 Days', 'None', 'None', 'None', 'None', 'None', 'None', 'None', 'None', '', 'None', 'None', 'None', 'None', 'GENERIC UNLOCK', '', '', '', '', '', 0, '', '', '18.00', 0, 0, 0, '', '', 'e4e2035d8f98b4022b076adc38b7d593', 0, '', 0, 0, '{\"allow\":\"0\",\"bulk\":\"1\",\"customname\":\"\",\"custominfo\":\"\",\"customlen\":\"0\",\"maxlength\":\"0\",\"regex\":\"\",\"isalpha\":\"0\"}'),
(420, 'fusion13', 'Tool', 'VODAFONE SPAIN GENERIC ALL BRANDS (NOKIA SONY ETC) - CLEAN', '2021', '16', '', '1-5 days', 'None', 'None', 'None', 'None', 'None', 'None', 'None', 'None', '', 'None', 'None', 'None', 'None', 'GENERIC UNLOCK', '', '', '', '', '', 0, '', '', '16.00', 0, 0, 0, '', '', 'cbe9e13858205c354badce0e68c6dfdc', 0, '', 0, 0, '{\"allow\":\"0\",\"bulk\":\"1\",\"customname\":\"\",\"custominfo\":\"\",\"customlen\":\"0\",\"maxlength\":\"0\",\"regex\":\"\",\"isalpha\":\"0\"}'),
(418, 'fusion13', 'Tool', 'TELSTRA AUSTRALIA GENERIC ALL BRANDS (NOKIA SONY ETC)', '2129', '12', '', '1-4 Days', 'None', 'None', 'None', 'None', 'None', 'None', 'None', 'None', '', 'None', 'None', 'None', 'None', 'GENERIC UNLOCK', '', '', '', '', '', 0, '', '', '12.00', 0, 0, 0, '', '', 'a6533919098eda304eaeb39c2e937da7', 0, '', 0, 0, '{\"allow\":\"0\",\"bulk\":\"0\",\"customname\":\"\",\"custominfo\":\"\",\"customlen\":\"0\",\"maxlength\":\"0\",\"regex\":\"\",\"isalpha\":\"0\"}'),
(419, 'fusion13', 'Tool', 'MOVISTAR SPAIN GENERIC ALL BRANDS (NOKIA SONY ETC) ', '1706', '7.5', '', '1-2 days', 'None', 'None', 'None', 'None', 'None', 'None', 'None', 'None', '', 'None', 'None', 'None', 'None', 'GENERIC UNLOCK', '', '', '', '', '', 0, '', '', '7.50', 0, 0, 0, '', '', '94955000653a91f1b5d69dc11f46a406', 0, '', 0, 0, '{\"allow\":\"0\",\"bulk\":\"0\",\"customname\":\"\",\"custominfo\":\"\",\"customlen\":\"0\",\"maxlength\":\"0\",\"regex\":\"\",\"isalpha\":\"0\"}'),
(417, 'fusion13', 'Tool', 'FIDO &amp; ROGERS CANADA GENERIC ALL BRANDS (NOKIA SONY ETC)', '1958', '5.5', '', '1-2 Days', 'None', 'None', 'None', 'None', 'None', 'None', 'None', 'None', '', 'None', 'None', 'None', 'None', 'GENERIC UNLOCK', '', '', '', '', '', 0, '', '', '5.50', 0, 0, 0, '', '', '5b24eec41ee274f469bbc668bc74d037', 0, '', 0, 0, '{\"allow\":\"0\",\"bulk\":\"0\",\"customname\":\"\",\"custominfo\":\"\",\"customlen\":\"0\",\"maxlength\":\"0\",\"regex\":\"\",\"isalpha\":\"0\"}'),
(416, 'fusion13', 'Tool', 'TELUS/KOODO CANADA GENERIC ALL BRANDS (NOKIA SONY ETC)', '1967', '2', '', '1-2 Days', 'None', 'None', 'None', 'None', 'None', 'None', 'None', 'None', '', 'None', 'None', 'None', 'None', 'GENERIC UNLOCK', '', '', '', '', '', 0, '', '', '2.00', 0, 0, 0, '', '', '6bf593c3e9177761c236298caeed98f0', 0, '', 0, 0, '{\"allow\":\"0\",\"bulk\":\"0\",\"customname\":\"\",\"custominfo\":\"\",\"customlen\":\"0\",\"maxlength\":\"0\",\"regex\":\"\",\"isalpha\":\"0\"}'),
(414, 'fusion13', 'Tool', 'ORANGE ROMANIA GENERIC ALL BRANDS (NOKIA SONY ETC) - 2 YEARS OLD', '1373', '16.5', '', '1-14 Hours', 'None', 'None', 'None', 'None', 'None', 'None', 'None', 'None', '', 'None', 'None', 'None', 'None', 'GENERIC UNLOCK', '', '', '', '', '', 0, '', '', '16.50', 0, 0, 0, '', '', '276db90a7e9945f02500c724bf6ec26c', 0, '', 0, 0, '{\"allow\":\"0\",\"bulk\":\"1\",\"customname\":\"\",\"custominfo\":\"\",\"customlen\":\"0\",\"maxlength\":\"0\",\"regex\":\"\",\"isalpha\":\"0\"}'),
(415, 'fusion13', 'Tool', 'A1 MOBILKOM AUSTRIA GENERIC UNLOCK - NOKIA &amp; HUAWEI', '2012', '64', '', '1-3 Hours', 'None', 'None', 'None', 'None', 'None', 'None', 'None', 'None', '', 'None', 'None', 'None', 'None', 'GENERIC UNLOCK', '', '', '', '', '', 0, '', '', '64.00', 0, 0, 0, '', '', 'ad6324638b36b84f06d0648e0ce9d5c6', 0, '', 0, 0, '{\"allow\":\"0\",\"bulk\":\"1\",\"customname\":\"\",\"custominfo\":\"\",\"customlen\":\"0\",\"maxlength\":\"0\",\"regex\":\"\",\"isalpha\":\"0\"}'),
(413, 'fusion13', 'Tool', 'VODAFONE ROMANIA GENERIC ALL BRANDS (NOKIA SONY ETC)', '1328', '14', '', '1-3 days', 'None', 'None', 'None', 'None', 'None', 'None', 'None', 'None', '', 'None', 'None', 'None', 'None', 'GENERIC UNLOCK', '', '', '', '', '', 0, '', '', '14.00', 0, 0, 0, '', '', '55c8c0bc53b1208f529e284d81e77ac1', 0, '', 0, 0, '{\"allow\":\"0\",\"bulk\":\"0\",\"customname\":\"\",\"custominfo\":\"\",\"customlen\":\"0\",\"maxlength\":\"0\",\"regex\":\"\",\"isalpha\":\"0\"}'),
(412, 'fusion13', 'Tool', 'MOTOROLA WORLDWIDE UNLOCK - INSTANT', '1985', '3', '', '1-15 Minutes', 'None', 'None', 'None', 'None', 'None', 'None', 'None', 'None', '', 'None', 'None', 'None', 'None', 'GENERIC UNLOCK', '', '', '', '', '', 0, '', '', '3.00', 0, 0, 0, '', '', '23d4ed270b8e5d68dc43919718c74373', 0, '', 0, 0, '{\"allow\":\"0\",\"bulk\":\"1\",\"customname\":\"\",\"custominfo\":\"\",\"customlen\":\"0\",\"maxlength\":\"0\",\"regex\":\"\",\"isalpha\":\"0\"}'),
(411, 'fusion13', 'Tool', 'HUAWEI ROMANIA FACTORY CODES - PREMIUM', '545', '13', '', '1-4 Days', 'None', 'None', 'None', 'None', 'None', 'None', 'None', 'None', '', 'None', 'None', 'None', 'None', 'GENERIC UNLOCK', '', '', '', '', '', 0, '', '', '13.00', 0, 0, 0, '', '', '7c2d9552ba6c087317a98f58fb9d9ff0', 0, '', 0, 0, '{\"allow\":\"0\",\"bulk\":\"1\",\"customname\":\"\",\"custominfo\":\"\",\"customlen\":\"0\",\"maxlength\":\"0\",\"regex\":\"\",\"isalpha\":\"0\"}'),
(410, 'fusion13', 'Tool', 'SAMSUNG USA AT&amp;T / CRICKET / XFINITY / SPECTRUM (GALAXY A SERIES/S20/S20+/S20 ULTRA/Z FLIP/Z FOLD) ALL LEVEL UNLOCK CODES [PREMIUM]', '2003', '30', '', '1-3 days', 'None', 'None', 'None', 'None', 'None', 'None', 'None', 'None', '', 'None', 'None', 'None', 'None', 'GENERIC UNLOCK', '', '', '', '', '', 0, '', '', '30.00', 0, 0, 0, '', '', 'fdf76a9e8f15e995c1187d305e59a833', 0, '', 0, 0, '{\"allow\":\"0\",\"bulk\":\"1\",\"customname\":\"\",\"custominfo\":\"\",\"customlen\":\"0\",\"maxlength\":\"0\",\"regex\":\"\",\"isalpha\":\"0\"}'),
(409, 'fusion13', 'Tool', 'SAMSUNG USA AT&amp;T / CRICKET / XFINITY / SPECTRUM (GALAXY NOTE 20/NOTE 20 ULTRA/Z FOLD 2/TAB S7/PLUS) ALL LEVEL UNLOCK CODES [PREMIUM]', '2957', '33', '', '1-3 days', 'None', 'None', 'None', 'None', 'None', 'None', 'None', 'None', '', 'None', 'None', 'None', 'None', 'GENERIC UNLOCK', '', '', '', '', '', 0, '', '', '33.00', 0, 0, 0, '', '', '8d69ff4fc6bf03b6714de6cdf9eb16a9', 0, '', 0, 0, '{\"allow\":\"0\",\"bulk\":\"1\",\"customname\":\"\",\"custominfo\":\"\",\"customlen\":\"0\",\"maxlength\":\"0\",\"regex\":\"\",\"isalpha\":\"0\"}'),
(408, 'fusion13', 'Tool', 'SAMSUNG USA AT&amp;T / CRICKET / XFINITY / SPECTRUM (GALAXY S21 / S21+ / S21 ULTRA) ALL LEVEL UNLOCK CODES [PREMIUM]', '2966', '36', '', '1-5 days', 'None', 'None', 'None', 'None', 'None', 'None', 'None', 'None', '', 'None', 'None', 'None', 'None', 'GENERIC UNLOCK', '', '', '', '', '', 0, '', '', '36.00', 0, 0, 0, '', '', 'db4f766f9ade3534c288f512a5507f02', 0, '', 0, 0, '{\"allow\":\"0\",\"bulk\":\"1\",\"customname\":\"\",\"custominfo\":\"\",\"customlen\":\"0\",\"maxlength\":\"0\",\"regex\":\"\",\"isalpha\":\"0\"}'),
(407, 'fusion13', 'Tool', 'SAMSUNG USA AT&amp;T / CRICKET / XFINITY / SPECTRUM (GALAXY NOTE 10 +/S10 +/S10E &amp; OLDER MODELS) ALL LEVEL UNLOCK CODES [PREMIUM]', '2948', '29', '', '1-5 days', 'None', 'None', 'None', 'None', 'None', 'None', 'None', 'None', '', 'None', 'None', 'None', 'None', 'GENERIC UNLOCK', '', '', '', '', '', 0, '', '', '29.00', 0, 0, 0, '', '', '7005279ceeff3644124a86d7de69324c', 0, '', 0, 0, '{\"allow\":\"0\",\"bulk\":\"1\",\"customname\":\"\",\"custominfo\":\"\",\"customlen\":\"12\",\"maxlength\":\"0\",\"regex\":\"\",\"isalpha\":\"0\"}'),
(406, 'fusion13', 'Tool', 'SAMSUNG ROMANIA - NCK &amp; MCK', '1571', '14', '', '1-12 Hours', 'None', 'None', 'None', 'None', 'None', 'None', 'None', 'None', '', 'None', 'None', 'None', 'None', 'GENERIC UNLOCK', '', '', '', '', '', 0, '', '', '14.00', 0, 0, 0, '', '', 'bb8b388310fb8b8de2bb6545a54b402c', 0, '', 0, 0, '{\"allow\":\"0\",\"bulk\":\"1\",\"customname\":\"\",\"custominfo\":\"\",\"customlen\":\"0\",\"maxlength\":\"0\",\"regex\":\"\",\"isalpha\":\"0\"}'),
(405, 'fusion13', 'Tool', 'SAMSUNG AUSTRIA - NCK &amp; MCK', '2876', '10', '', '1-30 Minutes', 'None', 'None', 'None', 'None', 'None', 'None', 'None', 'None', '', 'None', 'None', 'None', 'None', 'GENERIC UNLOCK', '', '', '', '', '', 0, '', '', '10.00', 0, 0, 0, '', '', '6579b3ca31a8c7727c678a863f2a6e57', 0, '', 0, 0, '{\"allow\":\"0\",\"bulk\":\"1\",\"customname\":\"\",\"custominfo\":\"\",\"customlen\":\"0\",\"maxlength\":\"0\",\"regex\":\"\",\"isalpha\":\"0\"}'),
(404, 'fusion13', 'Tool', 'ORANGE/T-MOBILE/EE UK GENERIC ALL MODELS (EXCEPT iPHONE) - CLEAN', '2759', '3', '', '1-8 Days', 'None', 'None', 'None', 'None', 'None', 'None', 'None', 'None', '', 'None', 'None', 'None', 'None', 'GENERIC UNLOCK', '', '', '', '', '', 0, '', '', '3.00', 0, 0, 0, '', '', '3ee7c6488043a08b83389926fcd83146', 0, '', 0, 0, '{\"allow\":\"0\",\"bulk\":\"1\",\"customname\":\"\",\"custominfo\":\"\",\"customlen\":\"0\",\"maxlength\":\"0\",\"regex\":\"\",\"isalpha\":\"0\"}'),
(403, 'fusion13', 'Tool', 'SAMSUNG CANADA - NCK &amp; MCK', '2867', '12', '', '1-3 Days', 'None', 'None', 'None', 'None', 'None', 'None', 'None', 'None', '', 'None', 'None', 'None', 'None', 'GENERIC UNLOCK', '', '', '', '', '', 0, '', '', '12.00', 0, 0, 0, '', '', '6ee5c6e17f0c72a7914bcfd8c546e655', 0, '', 0, 0, '{\"allow\":\"0\",\"bulk\":\"1\",\"customname\":\"\",\"custominfo\":\"\",\"customlen\":\"0\",\"maxlength\":\"0\",\"regex\":\"\",\"isalpha\":\"0\"}'),
(402, 'fusion13', 'Tool', 'SAMSUNG CANADA - NCK ONLY', '1598', '6', '', '1-3 Days', 'None', 'None', 'None', 'None', 'None', 'None', 'None', 'None', '', 'None', 'None', 'None', 'None', 'GENERIC UNLOCK', '', '', '', '', '', 0, '', '', '6.00', 0, 0, 0, '', '', '7f1b6c3c6ea95bb2bfac126f1fbdfd97', 0, '', 0, 0, '{\"allow\":\"0\",\"bulk\":\"1\",\"customname\":\"\",\"custominfo\":\"\",\"customlen\":\"0\",\"maxlength\":\"0\",\"regex\":\"\",\"isalpha\":\"0\"}'),
(401, 'fusion13', 'Tool', 'SAMSUNG UNITED KINGDOM &amp; IRELAND - NCK &amp; MCK &amp; RGCK', '2291', '18.5', '', '1-24 Hours', 'None', 'None', 'None', 'None', 'None', 'None', 'None', 'None', '', 'None', 'None', 'None', 'None', 'GENERIC UNLOCK', '', '', '', '', '', 0, '', '', '18.50', 0, 0, 0, '', '', '4e9826176a68ee38992c104c8d673193', 0, '', 0, 0, '{\"allow\":\"0\",\"bulk\":\"1\",\"customname\":\"\",\"custominfo\":\"\",\"customlen\":\"0\",\"maxlength\":\"0\",\"regex\":\"\",\"isalpha\":\"0\"}'),
(400, 'fusion13', 'Tool', 'SAMSUNG UNITED KINGDOM & IRELAND - NCK & MCK', '1859', '12', '', '1-3 days', 'None', 'None', 'None', 'None', 'None', 'None', 'None', 'None', '', 'None', 'None', 'None', 'None', 'GENERIC UNLOCK', '', '', '', '', '', 0, '', '', '12.00', 0, 0, 0, '', '', '00ebb3fda6a62adade480e4948f49082', 0, '', 0, 0, '{\"allow\":\"0\",\"bulk\":\"1\",\"customname\":\"\",\"custominfo\":\"\",\"customlen\":\"0\",\"maxlength\":\"0\",\"regex\":\"\",\"isalpha\":\"0\"}'),
(399, 'fusion13', 'Tool', 'SAMSUNG WORLDWIDE ALL MODELS &amp; CARRIER - ALL LEVEL', '3101', '62', '', '1-8 days', 'None', 'None', 'None', 'None', 'None', 'None', 'None', 'None', '', 'None', 'None', 'None', 'None', 'GENERIC UNLOCK', '', '', '', '', '', 0, '', '', '62.00', 0, 0, 0, '', '', '2457846d8e3c89af4b669025c85ca2b0', 0, '', 0, 0, '{\"allow\":\"0\",\"bulk\":\"1\",\"customname\":\"\",\"custominfo\":\"\",\"customlen\":\"1\",\"maxlength\":\"20\",\"regex\":\"\",\"isalpha\":\"0\"}'),
(398, 'fusion13', 'Tool', 'SAMSUNG ASIA / AUSTRALIA / UAE [ALL LEVELS] ', '2849', '33.5', '', '1-5 Days', 'None', 'None', 'None', 'None', 'None', 'None', 'None', 'None', '', 'None', 'None', 'None', 'None', 'GENERIC UNLOCK', '', '', '', '', '', 0, '', '', '33.50', 0, 0, 0, '', '', 'd88be59738242f75efdee22b76fab728', 0, '', 0, 0, '{\"allow\":\"0\",\"bulk\":\"0\",\"customname\":\"\",\"custominfo\":\"\",\"customlen\":\"0\",\"maxlength\":\"0\",\"regex\":\"\",\"isalpha\":\"0\"}'),
(397, 'fusion13', 'Tool', 'SAMSUNG USA AT&amp;T / CRICKET / XFINITY / SPECTRUM (GALAXY S22 / S22 ULTRA / Z FLIP 3 / Z FOLD 3) ALL LEVEL UNLOCK CODES [PREMIUM]', '2219', '48', '', '1-7 days', 'None', 'None', 'None', 'None', 'None', 'None', 'None', 'None', '', 'None', 'None', 'None', 'None', 'GENERIC UNLOCK', '', '', '', '', '', 0, '', '', '48.00', 0, 0, 0, '', '', 'aaab2d0d58b1c39eaf4739a73287c852', 0, '', 0, 0, '{\"allow\":\"0\",\"bulk\":\"1\",\"customname\":\"\",\"custominfo\":\"\",\"customlen\":\"1\",\"maxlength\":\"20\",\"regex\":\"\",\"isalpha\":\"0\"}'),
(395, 'fusion13', 'Tool', 'VODAFONE UK GENERIC ALL MODELS (EXCEPT iPHONE) - FAST', '1877', '2.7', '', '1-4 Days', 'None', 'None', 'None', 'None', 'None', 'None', 'None', 'None', '', 'None', 'None', 'None', 'None', 'GENERIC UNLOCK', '', '', '', '', '', 0, '', '', '2.70', 0, 0, 0, '', '', '76833fff0aa4a81ece90950482c1744e', 0, '', 0, 0, '{\"allow\":\"0\",\"bulk\":\"0\",\"customname\":\"\",\"custominfo\":\"\",\"customlen\":\"0\",\"maxlength\":\"0\",\"regex\":\"\",\"isalpha\":\"0\"}'),
(396, 'fusion13', 'Tool', 'SAMSUNG EUROPE ALL MODELS &amp; CARRIER - NCK &amp; MCK', '1724', '20', '', '1-3 days', 'None', 'None', 'None', 'None', 'None', 'None', 'None', 'None', '', 'None', 'None', 'None', 'None', 'GENERIC UNLOCK', '', '', '', '', '', 0, '', '', '20.00', 0, 0, 0, '', '', '86b8e9ae6dfdb214951f6dcdd612cfc0', 0, '', 0, 0, '{\"allow\":\"0\",\"bulk\":\"1\",\"customname\":\"\",\"custominfo\":\"\",\"customlen\":\"0\",\"maxlength\":\"0\",\"regex\":\"\",\"isalpha\":\"0\"}'),
(394, 'fusion13', 'Tool', 'SAMSUNG EUROPE LIMITED COUNTRY - PREMIUM 2021', '1976', '14', '', '3-15 Minutes', 'None', 'None', 'None', 'None', 'None', 'None', 'None', 'None', '', 'None', 'None', 'None', 'None', 'GENERIC UNLOCK', '', '', '', '', '', 0, '', '', '14.00', 0, 0, 0, '', '', 'bfa8b694aaded959ed973de89ff8f2de', 0, '', 0, 0, '{\"allow\":\"0\",\"bulk\":\"1\",\"customname\":\"\",\"custominfo\":\"\",\"customlen\":\"0\",\"maxlength\":\"0\",\"regex\":\"\",\"isalpha\":\"0\"}'),
(392, 'fusion13', 'Tool', 'BELL/VIRGIN/SOLO CANADA GENERIC ALL BRANDS (NOKIA SONY ETC)', '1940', '4', '', '1-3 Miniutes', 'None', 'None', 'None', 'None', 'None', 'None', 'None', 'None', '', 'None', 'None', 'None', 'None', 'GENERIC UNLOCK', '', '', '', '', '', 0, '', '', '4.00', 0, 0, 0, '', '', '808ebafadc4fe9099f7c088f0b515332', 0, '', 0, 0, '{\"allow\":\"0\",\"bulk\":\"0\",\"customname\":\"\",\"custominfo\":\"\",\"customlen\":\"0\",\"maxlength\":\"0\",\"regex\":\"\",\"isalpha\":\"0\"}'),
(393, 'fusion13', 'Tool', 'SAMSUNG EUROPE LIMITED COUNTRY - NOT FOUND', '2831', '15', '', '1-24 Hours', 'None', 'None', 'None', 'None', 'None', 'None', 'None', 'None', '', 'None', 'None', 'None', 'None', 'GENERIC UNLOCK', '', '', '', '', '', 0, '', '', '15.00', 0, 0, 0, '', '', '494e1d7b67f8e877f7dc180131f337c8', 0, '', 0, 0, '{\"allow\":\"0\",\"bulk\":\"1\",\"customname\":\"\",\"custominfo\":\"\",\"customlen\":\"0\",\"maxlength\":\"0\",\"regex\":\"\",\"isalpha\":\"0\"}'),
(391, 'fusion13', 'Tool', 'SAMSUNG EUROPE LIMITED COUNTRY - DATABASE 3', '896', '9', '', '3-5 Minutes', 'None', 'None', 'None', 'None', 'None', 'None', 'None', 'None', '', 'None', 'None', 'None', 'None', 'GENERIC UNLOCK', '', '', '', '', '', 0, '', '', '9.00', 0, 0, 0, '', '', 'fb478ec1ccc1667c4f723a6924aabe15', 0, '', 0, 0, '{\"allow\":\"0\",\"bulk\":\"1\",\"customname\":\"\",\"custominfo\":\"\",\"customlen\":\"0\",\"maxlength\":\"0\",\"regex\":\"\",\"isalpha\":\"0\"}'),
(389, 'fusion13', 'Tool', 'SAMSUNG EUROPE LIMITED COUNTRY - DATABASE 1', '1868', '5', '', '3-5 Minutes', 'None', 'None', 'None', 'None', 'None', 'None', 'None', 'None', '', 'None', 'None', 'None', 'None', 'GENERIC UNLOCK', '', '', '', '', '', 0, '', '', '5.00', 0, 0, 0, '', '', '9c52ce4749af2af659f58ad87ec2e3e6', 0, '', 0, 0, '{\"allow\":\"0\",\"bulk\":\"1\",\"customname\":\"\",\"custominfo\":\"\",\"customlen\":\"0\",\"maxlength\":\"0\",\"regex\":\"\",\"isalpha\":\"0\"}'),
(390, 'fusion13', 'Tool', 'SAMSUNG EUROPE LIMITED COUNTRY - DATABASE 2', '2345', '7', '', '3-5 Minutes', 'None', 'None', 'None', 'None', 'None', 'None', 'None', 'None', '', 'None', 'None', 'None', 'None', 'GENERIC UNLOCK', '', '', '', '', '', 0, '', '', '7.00', 0, 0, 0, '', '', 'fd2f1d7f1f6a2f03c26414c774179d5b', 0, '', 0, 0, '{\"allow\":\"0\",\"bulk\":\"1\",\"customname\":\"\",\"custominfo\":\"\",\"customlen\":\"0\",\"maxlength\":\"0\",\"regex\":\"\",\"isalpha\":\"0\"}'),
(388, 'fusion13', 'Tool', 'ZTE WORLDWIDE FACTORY NCK CODE', '3182', '17', '', '3-8 days', 'None', 'None', 'None', 'None', 'None', 'None', 'None', 'None', '', 'None', 'None', 'None', 'None', 'GENERIC UNLOCK', '', '', '', '', '', 0, '', '', '17.00', 0, 0, 0, '', '', '762a5a4fdaab9bff92473a20aea1bb11', 0, '', 0, 0, '{\"allow\":\"0\",\"bulk\":\"1\",\"customname\":\"\",\"custominfo\":\"\",\"customlen\":\"1\",\"maxlength\":\"20\",\"regex\":\"\",\"isalpha\":\"0\"}'),
(386, 'fusion13', 'Group', 'GENERIC UNLOCK', 'GENERIC UNLOCK', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0, '', '', '0.00', 0, 0, 0, '', '', '', 0, '', 0, 0, ''),
(387, 'fusion13', 'Tool', 'HUAWEI WORLDWIDE FACTORY NCK CODE', '3074', '31', '', '3-10 days', 'None', 'None', 'None', 'None', 'None', 'None', 'None', 'None', '', 'None', 'None', 'None', 'None', 'GENERIC UNLOCK', '', '', '', '', '', 0, '', '', '31.00', 0, 0, 0, '', '', '07a25efef039ba305f2ed40575337039', 0, '', 0, 0, '{\"allow\":\"0\",\"bulk\":\"1\",\"customname\":\"\",\"custominfo\":\"\",\"customlen\":\"1\",\"maxlength\":\"20\",\"regex\":\"\",\"isalpha\":\"0\"}'),
(385, 'fusion13', 'Tool', 'ORANGE FRANCE iPHONE UNLOCK - CLEAN', '680', '3', '', '1-12 Hours', 'None', 'None', 'None', 'None', 'None', 'None', 'None', 'None', '', 'None', 'None', 'None', 'None', 'UNLOCK SERVICES', '', '', '', '', '', 0, '', '', '3.00', 0, 0, 0, '', '', '57378c8be2d5fb16e72b98e4fbd538af', 0, '', 0, 0, '{\"allow\":\"0\",\"bulk\":\"1\",\"customname\":\"\",\"custominfo\":\"\",\"customlen\":\"0\",\"maxlength\":\"0\",\"regex\":\"\",\"isalpha\":\"0\"}'),
(384, 'fusion13', 'Tool', '3 HUTCHISON SWEDEN ALL IPHONE UNLOCK - PREMIUM', '752', '60', '', '1-8 Days', 'None', 'None', 'None', 'None', 'None', 'None', 'None', 'None', '', 'None', 'None', 'None', 'None', 'UNLOCK SERVICES', '', '', '', '', '', 0, '', '', '60.00', 0, 0, 0, '', '', 'ce8c55d5516e10e42c6e318024f91c98', 0, '', 0, 0, '{\"allow\":\"0\",\"bulk\":\"1\",\"customname\":\"\",\"custominfo\":\"\",\"customlen\":\"0\",\"maxlength\":\"0\",\"regex\":\"\",\"isalpha\":\"0\"}'),
(383, 'fusion13', 'Tool', '3 HUTCHISON SWEDEN ALL iPHONE UNLOCK - CLEAN', '698', '23', '', '1-12 Hours', 'None', 'None', 'None', 'None', 'None', 'None', 'None', 'None', '', 'None', 'None', 'None', 'None', 'UNLOCK SERVICES', '', '', '', '', '', 0, '', '', '23.00', 0, 0, 0, '', '', 'f5628e83c2bc4cf0a61aabcccfb8c2a8', 0, '', 0, 0, '{\"allow\":\"0\",\"bulk\":\"1\",\"customname\":\"\",\"custominfo\":\"\",\"customlen\":\"0\",\"maxlength\":\"0\",\"regex\":\"\",\"isalpha\":\"0\"}'),
(382, 'fusion13', 'Tool', 'ORANGE ROMANIA iPHONE UNLOCK - OUT OF CONTRACT', '824', '14', '', '1-24 Hours', 'None', 'None', 'None', 'None', 'None', 'None', 'None', 'None', '', 'None', 'None', 'None', 'None', 'UNLOCK SERVICES', '', '', '', '', '', 0, '', '', '14.00', 0, 0, 0, '', '', '483a2c6e1b7acf8cf7bd739068ab551b', 0, '', 0, 0, '{\"allow\":\"0\",\"bulk\":\"1\",\"customname\":\"\",\"custominfo\":\"\",\"customlen\":\"0\",\"maxlength\":\"0\",\"regex\":\"\",\"isalpha\":\"0\"}'),
(381, 'fusion13', 'Tool', 'ORANGE ROMANIA ALL iPHONE UNLOCK - PREMIUM', '833', '50', '', '1-24 Hours', 'None', 'None', 'None', 'None', 'None', 'None', 'None', 'None', '', 'None', 'None', 'None', 'None', 'UNLOCK SERVICES', '', '', '', '', '', 0, '', '', '50.00', 0, 0, 0, '', '', 'a9d636b1b8ff73443fa2114e7abd92ff', 0, '', 0, 0, '{\"allow\":\"0\",\"bulk\":\"1\",\"customname\":\"\",\"custominfo\":\"\",\"customlen\":\"0\",\"maxlength\":\"0\",\"regex\":\"\",\"isalpha\":\"0\"}'),
(379, 'fusion13', 'Tool', 'TELUS &amp; KOODO CANADA ALL iPHONE UNLOCK - CLEAN', '815', '1', '', '1-36 Hours', 'None', 'None', 'None', 'None', 'None', 'None', 'None', 'None', '', 'None', 'None', 'None', 'None', 'UNLOCK SERVICES', '', '', '', '', '', 0, '', '', '1.00', 0, 0, 0, '', '', 'ce304ecf2cb5ec9145c819e20de8d6b9', 0, '', 0, 0, '{\"allow\":\"0\",\"bulk\":\"1\",\"customname\":\"\",\"custominfo\":\"\",\"customlen\":\"0\",\"maxlength\":\"0\",\"regex\":\"\",\"isalpha\":\"0\"}'),
(380, 'fusion13', 'Tool', 'VODAFONE ROMANIA iPHONE UNLOCK - PREMIUM', '770', '17', '', '1-5 Days', 'None', 'None', 'None', 'None', 'None', 'None', 'None', 'None', '', 'None', 'None', 'None', 'None', 'UNLOCK SERVICES', '', '', '', '', '', 0, '', '', '17.00', 0, 0, 0, '', '', '18d700e89cec8f0a8664c35f19cb1d31', 0, '', 0, 0, '{\"allow\":\"0\",\"bulk\":\"1\",\"customname\":\"\",\"custominfo\":\"\",\"customlen\":\"0\",\"maxlength\":\"0\",\"regex\":\"\",\"isalpha\":\"0\"}'),
(378, 'fusion13', 'Tool', 'FIDO &amp; ROGERS CANADA ALL iPHONE UNLOCK - CLEAN', '806', '13', '', '1-9 days', 'None', 'None', 'None', 'None', 'None', 'None', 'None', 'None', '', 'None', 'None', 'None', 'None', 'UNLOCK SERVICES', '', '', '', '', '', 0, '', '', '13.00', 0, 0, 0, '', '', '8d099857e6396b458f7d31d84695927f', 0, '', 0, 0, '{\"allow\":\"0\",\"bulk\":\"1\",\"customname\":\"\",\"custominfo\":\"\",\"customlen\":\"0\",\"maxlength\":\"0\",\"regex\":\"\",\"isalpha\":\"0\"}'),
(377, 'fusion13', 'Tool', 'SASKTEL CANADA ALL iPHONE UNLOCK - CLEAN', '212', '12', '', '1-3 days', 'None', 'None', 'None', 'None', 'None', 'None', 'None', 'None', '', 'None', 'None', 'None', 'None', 'UNLOCK SERVICES', '', '', '', '', '', 0, '', '', '12.00', 0, 0, 0, '', '', '02a1844d5e6b8bbe61b797d76adde45b', 0, '', 0, 0, '{\"allow\":\"0\",\"bulk\":\"0\",\"customname\":\"\",\"custominfo\":\"\",\"customlen\":\"0\",\"maxlength\":\"0\",\"regex\":\"\",\"isalpha\":\"0\"}'),
(376, 'fusion13', 'Tool', 'NTT DOCOMO JAPAN ALL IPHONE MODELS UNLOCK - CLEAN', '2732', '1.2', '', '0-3 days', 'None', 'None', 'None', 'None', 'None', 'None', 'None', 'None', '', 'None', 'None', 'None', 'None', 'UNLOCK SERVICES', '', '', '', '', '', 0, '', '', '1.20', 0, 0, 0, '', '', '5f1fc35291097daf41fd2c3fafef794c', 0, '', 0, 0, '{\"allow\":\"0\",\"bulk\":\"1\",\"customname\":\"\",\"custominfo\":\"\",\"customlen\":\"0\",\"maxlength\":\"0\",\"regex\":\"\",\"isalpha\":\"0\"}'),
(375, 'fusion13', 'Tool', 'AU KDDI JAPAN ALL IPHONE MODELS UNLOCK - CLEAN', '2102', '4', '', '1-2 Days', 'None', 'None', 'None', 'None', 'None', 'None', 'None', 'None', '', 'None', 'None', 'None', 'None', 'UNLOCK SERVICES', '', '', '', '', '', 0, '', '', '4.00', 0, 0, 0, '', '', 'bbf2fc1250cc1c04b8a8a392b7153a17', 0, '', 0, 0, '{\"allow\":\"0\",\"bulk\":\"1\",\"customname\":\"\",\"custominfo\":\"\",\"customlen\":\"0\",\"maxlength\":\"0\",\"regex\":\"\",\"isalpha\":\"0\"}'),
(374, 'fusion13', 'Tool', 'CLARO ALL COUNTRIES iPHONE 3GS/4/4S/5/5S/5SE/5C/6/6+/6S/6S+/7/7+/8/8+ UNLOCK - PREMIUM', '2516', '18', '', '1-7 days', 'None', 'None', 'None', 'None', 'None', 'None', 'None', 'None', '', 'None', 'None', 'None', 'None', 'UNLOCK SERVICES', '', '', '', '', '', 0, '', '', '18.00', 0, 0, 0, '', '', 'eeefc6bd84f00e5e42daba46b9212ba4', 0, '', 0, 0, '{\"allow\":\"0\",\"bulk\":\"1\",\"customname\":\"\",\"custominfo\":\"\",\"customlen\":\"0\",\"maxlength\":\"0\",\"regex\":\"\",\"isalpha\":\"0\"}'),
(373, 'fusion13', 'Tool', 'CLARO ALL COUNTRIES iPHONE SE 2020/X/XR/XS/XS MAX/11/11 PRO/11 PRO MAX UNLOCK - PREMIUM', '1832', '29', '', '1-7 days', 'None', 'None', 'None', 'None', 'None', 'None', 'None', 'None', '', 'None', 'None', 'None', 'None', 'UNLOCK SERVICES', '', '', '', '', '', 0, '', '', '29.00', 0, 0, 0, '', '', '835c0704edc276d151ec23e0edd023d7', 0, '', 0, 0, '{\"allow\":\"0\",\"bulk\":\"1\",\"customname\":\"\",\"custominfo\":\"\",\"customlen\":\"0\",\"maxlength\":\"0\",\"regex\":\"\",\"isalpha\":\"0\"}'),
(372, 'fusion13', 'Tool', 'MOVISTAR CHILE ALL iPHONE MODELS PREMIUM UNLOCK', '2534', '72', '', '4-10 Days', 'None', 'None', 'None', 'None', 'None', 'None', 'None', 'None', '', 'None', 'None', 'None', 'None', 'UNLOCK SERVICES', '', '', '', '', '', 0, '', '', '72.00', 0, 0, 0, '', '', 'e9b8eb82e2657c9ab6047c66a40c824a', 0, '', 0, 0, '{\"allow\":\"0\",\"bulk\":\"1\",\"customname\":\"\",\"custominfo\":\"\",\"customlen\":\"0\",\"maxlength\":\"0\",\"regex\":\"\",\"isalpha\":\"0\"}'),
(371, 'fusion13', 'Tool', 'CLARO ALL COUNTRIES iPHONE 12/12 MINI/12 PRO/12 PRO MAX/13/13 MINI/13 PRO/13 PRO MAX UNLOCK - PREMIUM', '1922', '47', '', '1-7 days', 'None', 'None', 'None', 'None', 'None', 'None', 'None', 'None', '', 'None', 'None', 'None', 'None', 'UNLOCK SERVICES', '', '', '', '', '', 0, '', '', '47.00', 0, 0, 0, '', '', '6f1642d6fc9dc611edc23475b48d5d82', 0, '', 0, 0, '{\"allow\":\"0\",\"bulk\":\"0\",\"customname\":\"\",\"custominfo\":\"\",\"customlen\":\"0\",\"maxlength\":\"0\",\"regex\":\"\",\"isalpha\":\"0\"}'),
(370, 'fusion13', 'Tool', 'SUNRISE SWITZERLAND iPHONE UNLOCK - NOT FOUND', '1040', '19', '', '1-5 Days', 'None', 'None', 'None', 'None', 'None', 'None', 'None', 'None', '', 'None', 'None', 'None', 'None', 'UNLOCK SERVICES', '', '', '', '', '', 0, '', '', '19.00', 0, 0, 0, '', '', '447d289e56d55aea73cf62e7742ae633', 0, '', 0, 0, '{\"allow\":\"0\",\"bulk\":\"0\",\"customname\":\"\",\"custominfo\":\"\",\"customlen\":\"0\",\"maxlength\":\"0\",\"regex\":\"\",\"isalpha\":\"0\"}'),
(368, 'fusion13', 'Tool', 'A1 MOBILKOM AUSTRIA ALL iPHONE MODELS UNLOCK - PREMIUM', '2480', '200', '', '1-10 days', 'None', 'None', 'None', 'None', 'None', 'None', 'None', 'None', '', 'None', 'None', 'None', 'None', 'UNLOCK SERVICES', '', '', '', '', '', 0, '', '', '200.00', 0, 0, 0, '', '', '7ea148b55702fd3d9e51d31f06f3e27e', 0, '', 0, 0, '{\"allow\":\"0\",\"bulk\":\"1\",\"customname\":\"\",\"custominfo\":\"\",\"customlen\":\"0\",\"maxlength\":\"0\",\"regex\":\"\",\"isalpha\":\"0\"}'),
(369, 'fusion13', 'Tool', 'A1 MOBILKOM AUSTRIA iPHONE 5 &lt;&gt; 11 UNLOCK - OUT OF CONTRACT', '2489', '105', '', '1-10 days', 'None', 'None', 'None', 'None', 'None', 'None', 'None', 'None', '', 'None', 'None', 'None', 'None', 'UNLOCK SERVICES', '', '', '', '', '', 0, '', '', '105.00', 0, 0, 0, '', '', '838ad47d414fc5b2066ba9a8caf95ddc', 0, '', 0, 0, '{\"allow\":\"0\",\"bulk\":\"1\",\"customname\":\"\",\"custominfo\":\"\",\"customlen\":\"0\",\"maxlength\":\"0\",\"regex\":\"\",\"isalpha\":\"0\"}'),
(367, 'fusion13', 'Tool', 'TELERING AUSTRIA iPHONE ALL MODELS UNLOCK - PREMIUM', '1211', '39', '', '1-5 Days', 'None', 'None', 'None', 'None', 'None', 'None', 'None', 'None', '', 'None', 'None', 'None', 'None', 'UNLOCK SERVICES', '', '', '', '', '', 0, '', '', '39.00', 0, 0, 0, '', '', 'd7e70e98255a7c85717f307d423c3898', 0, '', 0, 0, '{\"allow\":\"0\",\"bulk\":\"1\",\"customname\":\"\",\"custominfo\":\"\",\"customlen\":\"0\",\"maxlength\":\"0\",\"regex\":\"\",\"isalpha\":\"0\"}'),
(366, 'fusion13', 'Tool', 'VODAFONE UK iPHONE &amp; IPAD ALL MODELS UNLOCK - CLEAN FAST', '2156', '11', '', '1-9 days', 'None', 'None', 'None', 'None', 'None', 'None', 'None', 'None', '', 'None', 'None', 'None', 'None', 'UNLOCK SERVICES', '', '', '', '', '', 0, '', '', '11.00', 0, 0, 0, '', '', '362a69a258b7c81cfab7ce034f9f8f59', 0, '', 0, 0, '{\"allow\":\"0\",\"bulk\":\"1\",\"customname\":\"\",\"custominfo\":\"\",\"customlen\":\"0\",\"maxlength\":\"0\",\"regex\":\"\",\"isalpha\":\"0\"}'),
(365, 'fusion13', 'Tool', 'O2 TESCO UK iPHONE ALL MODELS UNLOCK - CLEAN', '2687', '1.5', '', '1-4 days', 'None', 'None', 'None', 'None', 'None', 'None', 'None', 'None', '', 'None', 'None', 'None', 'None', 'UNLOCK SERVICES', '', '', '', '', '', 0, '', '', '1.50', 0, 0, 0, '', '', '15c3e4d1cfa31ad28a458d6e0e3bb4ca', 0, '', 0, 0, '{\"allow\":\"0\",\"bulk\":\"1\",\"customname\":\"\",\"custominfo\":\"\",\"customlen\":\"0\",\"maxlength\":\"0\",\"regex\":\"\",\"isalpha\":\"0\"}'),
(364, 'fusion13', 'Tool', 'T-MOBILE AUSTRIA iPHONE ALL MODELS UNLOCK - PREMIUM', '1220', '39', '', '1-5 Days', 'None', 'None', 'None', 'None', 'None', 'None', 'None', 'None', '', 'None', 'None', 'None', 'None', 'UNLOCK SERVICES', '', '', '', '', '', 0, '', '', '39.00', 0, 0, 0, '', '', 'a4f2c3c9f2339bbb44d431f5f6cf2f64', 0, '', 0, 0, '{\"allow\":\"0\",\"bulk\":\"1\",\"customname\":\"\",\"custominfo\":\"\",\"customlen\":\"0\",\"maxlength\":\"0\",\"regex\":\"\",\"isalpha\":\"0\"}'),
(363, 'fusion13', 'Tool', 'GLOBE PHILIPPINES UNLOCK iPHONE XR/XS/XS MAX/11/11P/11PM/12/12P/12PM/13/13P/13PM/14/14+/14P/14PM', '986', '28', '', '3-15 days', 'None', 'None', 'None', 'None', 'None', 'None', 'None', 'None', '', 'None', 'None', 'None', 'None', 'UNLOCK SERVICES', '', '', '', '', '', 0, '', '', '28.00', 0, 0, 0, '', '', '27ac33fb5f8de4556d8094382ed401a4', 0, '', 0, 0, '{\"allow\":\"0\",\"bulk\":\"1\",\"customname\":\"\",\"custominfo\":\"\",\"customlen\":\"0\",\"maxlength\":\"0\",\"regex\":\"\",\"isalpha\":\"0\"}'),
(361, 'fusion13', 'Tool', 'EMEA SERVICE iPHONE UNLOCK - PREMIUM EXPRESS', '635', '1.5', '', '1-48 Hours', 'None', 'None', 'None', 'None', 'None', 'None', 'None', 'None', '', 'None', 'None', 'None', 'None', 'UNLOCK SERVICES', '', '', '', '', '', 0, '', '', '1.50', 0, 0, 0, '', '', 'ba6c2cc6aac60e9d0d9a36d9a67ffcf4', 0, '', 0, 0, '{\"allow\":\"0\",\"bulk\":\"1\",\"customname\":\"\",\"custominfo\":\"\",\"customlen\":\"0\",\"maxlength\":\"0\",\"regex\":\"\",\"isalpha\":\"0\"}'),
(362, 'fusion13', 'Tool', 'ORANGE/T-MOBILE/EE UNITED KINGDOM ALL iPHONE MODELS UNLOCK - SEMI PREMIUM', '1715', '3', '', '1-12 Hours', 'None', 'None', 'None', 'None', 'None', 'None', 'None', 'None', '', 'None', 'None', 'None', 'None', 'UNLOCK SERVICES', '', '', '', '', '', 0, '', '', '3.00', 0, 0, 0, '', '', '4243093b91196296903c65f4fab2a88e', 0, '', 0, 0, '{\"allow\":\"0\",\"bulk\":\"1\",\"customname\":\"\",\"custominfo\":\"\",\"customlen\":\"0\",\"maxlength\":\"0\",\"regex\":\"\",\"isalpha\":\"0\"}'),
(359, 'fusion13', 'Tool', 'US GSM & US CARRIER & US RESELLER iPHONE UNLOCK - CLEAN', '1742', '24', '', '1-7 days', 'None', 'None', 'None', 'None', 'None', 'None', 'None', 'None', '', 'None', 'None', 'None', 'None', 'UNLOCK SERVICES', '', '', '', '', '', 0, '', '', '24.00', 0, 0, 0, '', '', 'ff77a3677cf31bdc0cbf8ae8deea4a64', 0, '', 0, 0, '{\"allow\":\"0\",\"bulk\":\"1\",\"customname\":\"\",\"custominfo\":\"\",\"customlen\":\"0\",\"maxlength\":\"0\",\"regex\":\"\",\"isalpha\":\"0\"}'),
(360, 'fusion13', 'Tool', 'VERIZON USA ALL IPHONE MODELS UNLOCK - PREMIUM', '1823', '15', '', '1-5 days', 'None', 'None', 'None', 'None', 'None', 'None', 'None', 'None', '', 'None', 'None', 'None', 'None', 'UNLOCK SERVICES', '', '', '', '', '', 0, '', '', '15.00', 0, 0, 0, '', '', '63a3bedc104a882130aa2ad06e1c8511', 0, '', 0, 0, '{\"allow\":\"0\",\"bulk\":\"1\",\"customname\":\"\",\"custominfo\":\"\",\"customlen\":\"0\",\"maxlength\":\"0\",\"regex\":\"\",\"isalpha\":\"0\"}'),
(357, 'fusion13', 'Tool', 'CRICKET USA ALL iPHONE & ANDROID MODELS UNLOCK - CLEAN & 180 DAYS ACTIVE', '3173', '10', '', '1-7 days', 'None', 'None', 'None', 'None', 'None', 'None', 'None', 'None', '', 'None', 'None', 'None', 'None', 'UNLOCK SERVICES', '', '', '', '', '', 0, '', '', '10.00', 0, 0, 0, '', '', '2b2fb776a56a772babc6bbc1cc8c0afa', 0, '', 0, 0, '{\"allow\":\"0\",\"bulk\":\"1\",\"customname\":\"\",\"custominfo\":\"\",\"customlen\":\"1\",\"maxlength\":\"20\",\"regex\":\"\",\"isalpha\":\"0\"}'),
(356, 'fusion13', 'Tool', 'CLARO ALL COUNTRIES iPHONE 14/14+/14 PRO/14 PRO MAX MAX UNLOCK - PREMIUM', '3200', '70', '', '1-8 days', 'None', 'None', 'None', 'None', 'None', 'None', 'None', 'None', '', 'None', 'None', 'None', 'None', 'UNLOCK SERVICES', '', '', '', '', '', 0, '', '', '70.00', 0, 0, 0, '', '', 'a46396600ca4a163d9fb544745a0c804', 0, '', 0, 0, '{\"allow\":\"0\",\"bulk\":\"1\",\"customname\":\"\",\"custominfo\":\"\",\"customlen\":\"1\",\"maxlength\":\"20\",\"regex\":\"\",\"isalpha\":\"0\"}'),
(358, 'fusion13', 'Tool', 'SOFTBANK JAPAN ALL IPHONE MODELS UNLOCK - CLEAN', '3164', '2', '', '0-3 days', 'None', 'None', 'None', 'None', 'None', 'None', 'None', 'None', '', 'None', 'None', 'None', 'None', 'UNLOCK SERVICES', '', '', '', '', '', 0, '', '', '2.00', 0, 0, 0, '', '', 'f686a00e10ef5facb4c699dc6b9397ae', 0, '', 0, 0, '{\"allow\":\"0\",\"bulk\":\"0\",\"customname\":\"\",\"custominfo\":\"\",\"customlen\":\"0\",\"maxlength\":\"0\",\"regex\":\"\",\"isalpha\":\"0\"}'),
(355, 'fusion13', 'Group', 'UNLOCK SERVICES', 'UNLOCK SERVICES', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0, '', '', '0.00', 0, 0, 0, '', '', '', 0, '', 0, 0, ''),
(354, 'fusion13', 'Tool', 'XIAOMI MI ACCOUNT REMOVAL SERVICE - EUROPE (CLEAN)', '311', '17', '', '1-48 Hours', 'None', 'None', 'None', 'None', 'None', 'None', 'None', 'None', '', 'None', 'None', 'None', 'None', 'OTHER TOOLS', '', '', '', '', '', 0, '', '', '17.00', 0, 0, 0, '', '', '3da666eee33aecba39f6c6b7f7845d0f', 0, '', 0, 0, '{\"allow\":\"1\",\"bulk\":\"1\",\"customname\":\"IMEI or LOCK CODE\",\"custominfo\":\"IMEI or LOCK CODE\",\"customlen\":\"8\",\"maxlength\":\"20\",\"regex\":\"\",\"isalpha\":\"1\"}'),
(353, 'fusion13', 'Tool', 'MDM IOS BYPASS iACTIVATE TOOL → IMEI/SERIAL', '1238', '15', '', ' Instant', 'None', 'None', 'None', 'None', 'None', 'None', 'None', 'None', '', 'None', 'None', 'None', 'None', 'OTHER TOOLS', '', '', '', '', '', 0, '', '', '15.00', 0, 0, 0, '', '', 'c6b23e459cef46a95903d7b72622c290', 0, '', 0, 0, '{\"allow\":\"1\",\"bulk\":\"1\",\"customname\":\"IMEI OR SERIAL\",\"custominfo\":\"IMEI OR SERIAL\",\"customlen\":\"8\",\"maxlength\":\"15\",\"regex\":\"\",\"isalpha\":\"1\"}'),
(352, 'fusion13', 'Tool', 'GSMA.DB BLACKLISTING SERVICE - REPORT DEVICE STOLEN BY T-MOBILE USA', '2795', '2', '', ' Instant', 'None', 'None', 'None', 'None', 'None', 'None', 'None', 'None', '', 'None', 'None', 'None', 'None', 'OTHER TOOLS', '', '', '', '', '', 0, '', '', '2.00', 0, 0, 0, '', '', '7b1c847770d07779a66ab2e61fb12326', 0, '', 0, 0, '{\"allow\":\"0\",\"bulk\":\"1\",\"customname\":\"\",\"custominfo\":\"\",\"customlen\":\"0\",\"maxlength\":\"0\",\"regex\":\"\",\"isalpha\":\"0\"}'),
(350, 'fusion13', 'Group', 'OTHER TOOLS', 'OTHER TOOLS', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0, '', '', '0.00', 0, 0, 0, '', '', '', 0, '', 0, 0, ''),
(351, 'fusion13', 'Tool', 'ADMIN PRIVATE SERVICE', '3056', '999', '', ' Instant', 'None', 'None', 'None', 'None', 'None', 'None', 'None', 'None', '', 'None', 'None', 'None', 'None', 'OTHER TOOLS', '', '', '', '', '', 0, '', '', '999.00', 0, 0, 0, '', '', 'd4c87f03687fc34167a8b39e645484cb', 0, '', 0, 0, '{\"allow\":\"1\",\"bulk\":\"1\",\"customname\":\"SN or IMEI\",\"custominfo\":\"SN or IMEI\",\"customlen\":\"10\",\"maxlength\":\"15\",\"regex\":\"\",\"isalpha\":\"1\"}'),
(349, 'fusion13', 'Tool', 'APPLE SERIAL INFO', '2390', '0.02', '', ' Instant', 'None', 'None', 'None', 'None', 'None', 'None', 'None', 'None', '', 'None', 'None', 'None', 'None', 'IMEI CHECK', '', '', '', '', '', 0, '', '', '0.02', 0, 0, 0, '', '', '78d27d3e71b3dddb9c802342a650388b', 0, '', 0, 0, '{\"allow\":\"1\",\"bulk\":\"1\",\"customname\":\"SERIAL NUMBER\",\"custominfo\":\"SERIAL NUMBER\",\"customlen\":\"11\",\"maxlength\":\"12\",\"regex\":\"\",\"isalpha\":\"1\"}'),
(348, 'fusion13', 'Tool', 'GOOGLE PIXEL IMEI CHECK INFO', '95', '0.1', '', ' Instant', 'None', 'None', 'None', 'None', 'None', 'None', 'None', 'None', '', 'None', 'None', 'None', 'None', 'IMEI CHECK', '', '', '', '', '', 0, '', '', '0.10', 0, 0, 0, '', '', '2f64760320e32fecb137686e05dca752', 0, '', 0, 0, '{\"allow\":\"0\",\"bulk\":\"1\",\"customname\":\"\",\"custominfo\":\"\",\"customlen\":\"0\",\"maxlength\":\"0\",\"regex\":\"\",\"isalpha\":\"0\"}'),
(347, 'fusion13', 'Tool', 'HONOR IMEI/SN CHECK INFO', '167', '0.12', '', ' Instant', 'None', 'None', 'None', 'None', 'None', 'None', 'None', 'None', '', 'None', 'None', 'None', 'None', 'IMEI CHECK', '', '', '', '', '', 0, '', '', '0.12', 0, 0, 0, '', '', 'bad281887907dd234b3d478e96f108f3', 0, '', 0, 0, '{\"allow\":\"1\",\"bulk\":\"1\",\"customname\":\"IMEI or SN\",\"custominfo\":\"IMEI or SN\",\"customlen\":\"15\",\"maxlength\":\"20\",\"regex\":\"\",\"isalpha\":\"1\"}'),
(346, 'fusion13', 'Tool', 'MOTOROLA &amp; LENOVO IMEI CHECK INFO', '1688', '0.1', '', ' Instant', 'None', 'None', 'None', 'None', 'None', 'None', 'None', 'None', '', 'None', 'None', 'None', 'None', 'IMEI CHECK', '', '', '', '', '', 0, '', '', '0.10', 0, 0, 0, '', '', '1fdf20448165d67ee9cfdec530a5dc78', 0, '', 0, 0, '{\"allow\":\"0\",\"bulk\":\"1\",\"customname\":\"\",\"custominfo\":\"\",\"customlen\":\"0\",\"maxlength\":\"0\",\"regex\":\"\",\"isalpha\":\"0\"}'),
(345, 'fusion13', 'Tool', 'SAMSUNG CHECK INFO - IMEI/SN', '1580', '0.1', '', ' Instant', 'None', 'None', 'None', 'None', 'None', 'None', 'None', 'None', '', 'None', 'None', 'None', 'None', 'IMEI CHECK', '', '', '', '', '', 0, '', '', '0.10', 0, 0, 0, '', '', '5d01ee8c1c6b818099bb2f49da18374f', 0, '', 0, 0, '{\"allow\":\"1\",\"bulk\":\"1\",\"customname\":\"IMEI or SERIAL\",\"custominfo\":\"IMEI or SERIAL\",\"customlen\":\"10\",\"maxlength\":\"15\",\"regex\":\"\",\"isalpha\":\"1\"}'),
(344, 'fusion13', 'Tool', 'ONEPLUS IMEI CHECK INFO', '2993', '0.04', '', ' Instant', 'None', 'None', 'None', 'None', 'None', 'None', 'None', 'None', '', 'None', 'None', 'None', 'None', 'IMEI CHECK', '', '', '', '', '', 0, '', '', '0.04', 0, 0, 0, '', '', '44124401d0752e4a5a86195e868d0e69', 0, '', 0, 0, '{\"allow\":\"0\",\"bulk\":\"1\",\"customname\":\"\",\"custominfo\":\"\",\"customlen\":\"0\",\"maxlength\":\"0\",\"regex\":\"\",\"isalpha\":\"0\"}');
INSERT INTO `tbl_apiserversservices` (`apiserverid`, `gateway`, `type`, `name`, `id`, `credits`, `message`, `delivery`, `requires_network`, `requires_mobile`, `requires_provider`, `requires_pin`, `requires_kbh`, `requires_mep`, `requires_prd`, `requires_reference`, `requires_servicetag`, `requires_type`, `requires_locks`, `requires_SN`, `requires_SecRO`, `group`, `assigned_network`, `assigned_country`, `assigned_brands`, `assigned_mobiles`, `assigned_mep`, `order`, `servicetype`, `currency`, `credittmp`, `flagprice`, `useasserver`, `qnt`, `requires_custom`, `type_id`, `guiid`, `suid`, `qntoptions`, `minqnt`, `maxqnt`, `imeifield`) VALUES
(343, 'fusion13', 'Tool', 'KYOCERA IMEI CHECK INFO', '3047', '0.05', '', ' Instant', 'None', 'None', 'None', 'None', 'None', 'None', 'None', 'None', '', 'None', 'None', 'None', 'None', 'IMEI CHECK', '', '', '', '', '', 0, '', '', '0.05', 0, 0, 0, '', '', 'bb53b905855b974ebfcddca504831fea', 0, '', 0, 0, '{\"allow\":\"0\",\"bulk\":\"1\",\"customname\":\"\",\"custominfo\":\"\",\"customlen\":\"1\",\"maxlength\":\"20\",\"regex\":\"\",\"isalpha\":\"0\"}'),
(341, 'fusion13', 'Tool', 'NOKIA IMEI CHECK INFO', '1229', '0.08', '', ' Instant', 'None', 'None', 'None', 'None', 'None', 'None', 'None', 'None', '', 'None', 'None', 'None', 'None', 'IMEI CHECK', '', '', '', '', '', 0, '', '', '0.08', 0, 0, 0, '', '', 'f08d36f4c202235c22df2f1393fc2ac1', 0, '', 0, 0, '{\"allow\":\"0\",\"bulk\":\"1\",\"customname\":\"\",\"custominfo\":\"\",\"customlen\":\"0\",\"maxlength\":\"0\",\"regex\":\"\",\"isalpha\":\"0\"}'),
(342, 'fusion13', 'Tool', 'HUAWEI IMEI/SN CHECK INFO', '2318', '0.12', '', ' Instant', 'None', 'None', 'None', 'None', 'None', 'None', 'None', 'None', '', 'None', 'None', 'None', 'None', 'IMEI CHECK', '', '', '', '', '', 0, '', '', '0.12', 0, 0, 0, '', '', '40f3ba22016f48b33f1ed90d2a4ce332', 0, '', 0, 0, '{\"allow\":\"1\",\"bulk\":\"1\",\"customname\":\"IMEI or SERIAL\",\"custominfo\":\"IMEI or SERIAL\",\"customlen\":\"15\",\"maxlength\":\"16\",\"regex\":\"\",\"isalpha\":\"1\"}'),
(340, 'fusion13', 'Tool', 'ACER IMEI CHECK INFO', '3011', '0.06', '', ' Instant', 'None', 'None', 'None', 'None', 'None', 'None', 'None', 'None', '', 'None', 'None', 'None', 'None', 'IMEI CHECK', '', '', '', '', '', 0, '', '', '0.06', 0, 0, 0, '', '', '808aceae6724408ee4d7dc1889555a75', 0, '', 0, 0, '{\"allow\":\"0\",\"bulk\":\"1\",\"customname\":\"\",\"custominfo\":\"\",\"customlen\":\"1\",\"maxlength\":\"20\",\"regex\":\"\",\"isalpha\":\"0\"}'),
(339, 'fusion13', 'Tool', 'OPPO IMEI CHECK INFO', '3029', '0.04', '', ' Instant', 'None', 'None', 'None', 'None', 'None', 'None', 'None', 'None', '', 'None', 'None', 'None', 'None', 'IMEI CHECK', '', '', '', '', '', 0, '', '', '0.04', 0, 0, 0, '', '', '0cd94339250cd2097b7b96ffb05b5d59', 0, '', 0, 0, '{\"allow\":\"0\",\"bulk\":\"1\",\"customname\":\"\",\"custominfo\":\"\",\"customlen\":\"1\",\"maxlength\":\"20\",\"regex\":\"\",\"isalpha\":\"0\"}'),
(338, 'fusion13', 'Tool', 'ZTE IMEI CHECK INFO', '2372', '0.05', '', ' Instant', 'None', 'None', 'None', 'None', 'None', 'None', 'None', 'None', '', 'None', 'None', 'None', 'None', 'IMEI CHECK', '', '', '', '', '', 0, '', '', '0.05', 0, 0, 0, '', '', '49b39d2d8c733c62c2332844f568417e', 0, '', 0, 0, '{\"allow\":\"0\",\"bulk\":\"1\",\"customname\":\"\",\"custominfo\":\"\",\"customlen\":\"0\",\"maxlength\":\"0\",\"regex\":\"\",\"isalpha\":\"0\"}'),
(336, 'fusion13', 'Tool', 'VERIZON USA CLEAN/BLOCKED/UNPAID STATUS - SIMPLE', '1103', '0.05', '', ' Instant', 'None', 'None', 'None', 'None', 'None', 'None', 'None', 'None', '', 'None', 'None', 'None', 'None', 'IMEI CHECK', '', '', '', '', '', 0, '', '', '0.05', 0, 0, 0, '', '', '6340b02aca5bd2b89608b74deef0f98e', 0, '', 0, 0, '{\"allow\":\"0\",\"bulk\":\"1\",\"customname\":\"\",\"custominfo\":\"\",\"customlen\":\"0\",\"maxlength\":\"0\",\"regex\":\"\",\"isalpha\":\"0\"}'),
(337, 'fusion13', 'Tool', 'LG IMEI CHECK INFO', '2786', '0.06', '', ' Instant', 'None', 'None', 'None', 'None', 'None', 'None', 'None', 'None', '', 'None', 'None', 'None', 'None', 'IMEI CHECK', '', '', '', '', '', 0, '', '', '0.06', 0, 0, 0, '', '', '1de8c283e60ce4c38a07135ab0fb6256', 0, '', 0, 0, '{\"allow\":\"0\",\"bulk\":\"1\",\"customname\":\"\",\"custominfo\":\"\",\"customlen\":\"0\",\"maxlength\":\"0\",\"regex\":\"\",\"isalpha\":\"0\"}'),
(335, 'fusion13', 'Tool', 'WORLDWIDE GSMA CLEAN/BLACKLIST STATUS - PRO', '1661', '0.16', '', ' Instant', 'None', 'None', 'None', 'None', 'None', 'None', 'None', 'None', '', 'None', 'None', 'None', 'None', 'IMEI CHECK', '', '', '', '', '', 0, '', '', '0.16', 0, 0, 0, '', '', '91093bd48e179b23f884151dc2a38c65', 0, '', 0, 0, '{\"allow\":\"0\",\"bulk\":\"1\",\"customname\":\"\",\"custominfo\":\"\",\"customlen\":\"0\",\"maxlength\":\"0\",\"regex\":\"\",\"isalpha\":\"0\"}'),
(334, 'fusion13', 'Tool', 'FIND MY iPHONE/iPAD ON/OFF → SERIAL', '599', '0.05', '', ' Instant', 'None', 'None', 'None', 'None', 'None', 'None', 'None', 'None', '', 'None', 'None', 'None', 'None', 'IMEI CHECK', '', '', '', '', '', 0, '', '', '0.05', 0, 0, 0, '', '', '7a0fe964baac218a743d6d6f7d8d2df8', 0, '', 0, 0, '{\"allow\":\"1\",\"bulk\":\"1\",\"customname\":\"IMEI or SN\",\"custominfo\":\"IMEI or SN\",\"customlen\":\"8\",\"maxlength\":\"15\",\"regex\":\"\",\"isalpha\":\"1\"}'),
(333, 'fusion13', 'Tool', 'FIND MY iPHONE/iPAD ON/OFF → IMEI', '671', '0.08', '', ' Instant', 'None', 'None', 'None', 'None', 'None', 'None', 'None', 'None', '', 'None', 'None', 'None', 'None', 'IMEI CHECK', '', '', '', '', '', 0, '', '', '0.08', 0, 0, 0, '', '', '8ff2d6d1f392666e89f0fe1c6ef24d03', 0, '', 0, 0, '{\"allow\":\"1\",\"bulk\":\"1\",\"customname\":\"IMEI or SN\",\"custominfo\":\"IMEI or SN\",\"customlen\":\"8\",\"maxlength\":\"15\",\"regex\":\"\",\"isalpha\":\"1\"}'),
(332, 'fusion13', 'Tool', 'iCLOUD CLEAN/LOST STATUS → IMEI', '851', '0.07', '', ' Instant', 'None', 'None', 'None', 'None', 'None', 'None', 'None', 'None', '', 'None', 'None', 'None', 'None', 'IMEI CHECK', '', '', '', '', '', 0, '', '', '0.07', 0, 0, 0, '', '', 'b28c16aedceedaf45ecac2019cbbb3d7', 0, '', 0, 0, '{\"allow\":\"0\",\"bulk\":\"1\",\"customname\":\"\",\"custominfo\":\"\",\"customlen\":\"0\",\"maxlength\":\"0\",\"regex\":\"\",\"isalpha\":\"0\"}'),
(330, 'fusion13', 'Tool', 'MACBOOK / iMAC iCLOUD ON/OFF & CLEAN/LOST STATUS', '86', '1.1', '', ' Instant', 'None', 'None', 'None', 'None', 'None', 'None', 'None', 'None', '', 'None', 'None', 'None', 'None', 'IMEI CHECK', '', '', '', '', '', 0, '', '', '1.10', 0, 0, 0, '', '', 'e642f5c545f35b8101ccd7eb4dd7e605', 0, '', 0, 0, '{\"allow\":\"1\",\"bulk\":\"1\",\"customname\":\"IMEI or SN\",\"custominfo\":\"IMEI or SN\",\"customlen\":\"8\",\"maxlength\":\"15\",\"regex\":\"\",\"isalpha\":\"1\"}'),
(331, 'fusion13', 'Tool', 'APPLE GSX CASES & REPAIRS HISTORY → IMEI/SN', '1778', '2', '', ' Instant', 'None', 'None', 'None', 'None', 'None', 'None', 'None', 'None', '', 'None', 'None', 'None', 'None', 'IMEI CHECK', '', '', '', '', '', 0, '', '', '2.00', 0, 0, 0, '', '', '03291e31b2e8b278d464e80aa597fedd', 0, '', 0, 0, '{\"allow\":\"1\",\"bulk\":\"1\",\"customname\":\"IMEI or SERIAL NUMBER\",\"custominfo\":\"IMEI or SERIAL NUMBER\",\"customlen\":\"10\",\"maxlength\":\"15\",\"regex\":\"\",\"isalpha\":\"1\"}'),
(329, 'fusion13', 'Tool', 'APPLE iPHONE SIM-LOCK STATUS → IMEI/SN', '2570', '0.08', '', ' Instant', 'None', 'None', 'None', 'None', 'None', 'None', 'None', 'None', '', 'None', 'None', 'None', 'None', 'IMEI CHECK', '', '', '', '', '', 0, '', '', '0.08', 0, 0, 0, '', '', '7d87639c52b022c5f7f751acf94b8e21', 0, '', 0, 0, '{\"allow\":\"1\",\"bulk\":\"1\",\"customname\":\"IMEI or SERIAL\",\"custominfo\":\"IMEI or SERIAL\",\"customlen\":\"8\",\"maxlength\":\"15\",\"regex\":\"\",\"isalpha\":\"1\"}'),
(328, 'fusion13', 'Tool', 'APPLE iPHONE CARRIER + SIM-LOCK → IMEI/SN⚡', '1769', '0.1', '', ' Instant', 'None', 'None', 'None', 'None', 'None', 'None', 'None', 'None', '', 'None', 'None', 'None', 'None', 'IMEI CHECK', '', '', '', '', '', 0, '', '', '0.10', 0, 0, 0, '', '', '90ce2ed2f4b88a0cf1dac1649065b692', 0, '', 0, 0, '{\"allow\":\"1\",\"bulk\":\"1\",\"customname\":\"IMEI or SN\",\"custominfo\":\"IMEI or SN\",\"customlen\":\"8\",\"maxlength\":\"15\",\"regex\":\"\",\"isalpha\":\"1\"}'),
(327, 'fusion13', 'Tool', 'APPLE iPAD/iPHONE BASIC INFO → SERIAL', '509', '0.08', '', ' Instant', 'None', 'None', 'None', 'None', 'None', 'None', 'None', 'None', '', 'None', 'None', 'None', 'None', 'IMEI CHECK', '', '', '', '', '', 0, '', '', '0.08', 0, 0, 0, '', '', 'd34f892565c4597ce0249db6da46eaf6', 0, '', 0, 0, '{\"allow\":\"1\",\"bulk\":\"1\",\"customname\":\"IMEI or SN\",\"custominfo\":\"IMEI or SN\",\"customlen\":\"8\",\"maxlength\":\"15\",\"regex\":\"\",\"isalpha\":\"1\"}'),
(326, 'fusion13', 'Tool', 'WORLDWIDE GSMA CLEAN/BLACKLIST STATUS', '2426', '0.04', '', ' Instant', 'None', 'None', 'None', 'None', 'None', 'None', 'None', 'None', '', 'None', 'None', 'None', 'None', 'IMEI CHECK', '', '', '', '', '', 0, '', '', '0.04', 0, 0, 0, '', '', '7b227582c7ee7eaf48598e6b6cb3e3fe', 0, '', 0, 0, '{\"allow\":\"0\",\"bulk\":\"1\",\"customname\":\"SERIAL NUMBER\",\"custominfo\":\"SERIAL NUMBER - 12 CHARS LONG\",\"customlen\":\"10\",\"maxlength\":\"0\",\"regex\":\"\",\"isalpha\":\"1\"}'),
(325, 'fusion13', 'Tool', 'APPLE iPHONE CARRIER + FMI + COVERAGE → IMEI/SN⚡', '2606', '0.16', '', ' Instant', 'None', 'None', 'None', 'None', 'None', 'None', 'None', 'None', '', 'None', 'None', 'None', 'None', 'IMEI CHECK', '', '', '', '', '', 0, '', '', '0.16', 0, 0, 0, '', '', '5c132ccf70de3217c8a98f1e6db800a4', 0, '', 0, 0, '{\"allow\":\"1\",\"bulk\":\"1\",\"customname\":\"IMEI or SERIAL\",\"custominfo\":\"IMEI or SERIAL\",\"customlen\":\"10\",\"maxlength\":\"15\",\"regex\":\"\",\"isalpha\":\"1\"}'),
(324, 'fusion13', 'Tool', 'APPLE iPAD/iPHONE BASIC INFO → IMEI', '41', '0.08', '', ' Instant', 'None', 'None', 'None', 'None', 'None', 'None', 'None', 'None', '', 'None', 'None', 'None', 'None', 'IMEI CHECK', '', '', '', '', '', 0, '', '', '0.08', 0, 0, 0, '', '', '05b4b0f452effdc6afd9ce42b56c7bb1', 0, '', 0, 0, '{\"allow\":\"1\",\"bulk\":\"1\",\"customname\":\"IMEI or SN\",\"custominfo\":\"IMEI or SN\",\"customlen\":\"8\",\"maxlength\":\"15\",\"regex\":\"\",\"isalpha\":\"1\"}'),
(323, 'fusion13', 'Tool', 'T-MOBILE USA GENERIC SIMLOCK &amp; UNLOCK ELIGIBILITY STATUS - PRO', '725', '0.1', '', ' Instant', 'None', 'None', 'None', 'None', 'None', 'None', 'None', 'None', '', 'None', 'None', 'None', 'None', 'IMEI CHECK', '', '', '', '', '', 0, '', '', '0.10', 0, 0, 0, '', '', 'a0c7ce86c60c81acc90741d2ee6c823e', 0, '', 0, 0, '{\"allow\":\"0\",\"bulk\":\"1\",\"customname\":\"\",\"custominfo\":\"\",\"customlen\":\"0\",\"maxlength\":\"0\",\"regex\":\"\",\"isalpha\":\"0\"}'),
(320, 'fusion13', 'Tool', 'APPLE iOS / MacOS MDM STATUS → IMEI/SN', '3155', '2.4', '', ' Instant', 'None', 'None', 'None', 'None', 'None', 'None', 'None', 'None', '', 'None', 'None', 'None', 'None', 'IMEI CHECK', '', '', '', '', '', 0, '', '', '2.40', 0, 0, 0, '', '', '6b9753abae37cc25f7c3ae347d478c4d', 0, '', 0, 0, '{\"allow\":\"1\",\"bulk\":\"1\",\"customname\":\"IMEI or SERIAL\",\"custominfo\":\"IMEI or SERIAL\",\"customlen\":\"8\",\"maxlength\":\"15\",\"regex\":\"\",\"isalpha\":\"1\"}'),
(321, 'fusion13', 'Tool', 'APPLE iPHONE CARRIER + FMI + COVERAGE + GSMA → IMEI/SN⚡', '2939', '0.22', '', ' Instant', 'None', 'None', 'None', 'None', 'None', 'None', 'None', 'None', '', 'None', 'None', 'None', 'None', 'IMEI CHECK', '', '', '', '', '', 0, '', '', '0.22', 0, 0, 0, '', '', '857200748d193d5c9da4c61f42a7263c', 0, '', 0, 0, '{\"allow\":\"1\",\"bulk\":\"1\",\"customname\":\"IMEI or SN\",\"custominfo\":\"IMEI or SN\",\"customlen\":\"8\",\"maxlength\":\"15\",\"regex\":\"\",\"isalpha\":\"1\"}'),
(322, 'fusion13', 'Tool', 'IPHONE FULL GSX + REPLACEMENT + WIFI MAC + POLICY → IMEI/SERIAL - INSTANT', '2579', '2.5', '', ' Instant', 'None', 'None', 'None', 'None', 'None', 'None', 'None', 'None', '', 'None', 'None', 'None', 'None', 'IMEI CHECK', '', '', '', '', '', 0, '', '', '2.50', 0, 0, 0, '', '', '9052580bc8f6004f09937319d5a404a2', 0, '', 0, 0, '{\"allow\":\"1\",\"bulk\":\"1\",\"customname\":\"Serial or IMEI\",\"custominfo\":\"Serial or IMEI\",\"customlen\":\"10\",\"maxlength\":\"15\",\"regex\":\"\",\"isalpha\":\"1\"}'),
(319, 'fusion13', 'Tool', 'XIAOMI MI CHECK INFO - IMEI/SN/KEY', '221', '0.1', '', ' Instant', 'None', 'None', 'None', 'None', 'None', 'None', 'None', 'None', '', 'None', 'None', 'None', 'None', 'IMEI CHECK', '', '', '', '', '', 0, '', '', '0.10', 0, 0, 0, '', '', '43d0f047a5cf9c531b5b55cfd8d7cb64', 0, '', 0, 0, '{\"allow\":\"1\",\"bulk\":\"1\",\"customname\":\"IMEI Number\",\"custominfo\":\"IMEI Number\",\"customlen\":\"12\",\"maxlength\":\"20\",\"regex\":\"\",\"isalpha\":\"1\"}'),
(318, 'fusion13', 'Tool', 'T-MOBILE USA CLEAN/BLOCKED/UNPAID STATUS - PRO', '1625', '0.08', '', ' Instant', 'None', 'None', 'None', 'None', 'None', 'None', 'None', 'None', '', 'None', 'None', 'None', 'None', 'IMEI CHECK', '', '', '', '', '', 0, '', '', '0.08', 0, 0, 0, '', '', '926a91bb3a2de43ad0c5cd5ae47a3da7', 0, '', 0, 0, '{\"allow\":\"0\",\"bulk\":\"1\",\"customname\":\"\",\"custominfo\":\"\",\"customlen\":\"0\",\"maxlength\":\"0\",\"regex\":\"\",\"isalpha\":\"0\"}'),
(317, 'fusion13', 'Tool', 'APPLE iOS / MacOS MDM PRO STATUS → IMEI/SN', '761', '3.8', '', ' Instant', 'None', 'None', 'None', 'None', 'None', 'None', 'None', 'None', '', 'None', 'None', 'None', 'None', 'IMEI CHECK', '', '', '', '', '', 0, '', '', '3.80', 0, 0, 0, '', '', '5727dbd11e455dff048582c34b5e7638', 0, '', 0, 0, '{\"allow\":\"1\",\"bulk\":\"1\",\"customname\":\"IMEI or SN\",\"custominfo\":\"IMEI or SN\",\"customlen\":\"8\",\"maxlength\":\"15\",\"regex\":\"\",\"isalpha\":\"1\"}'),
(316, 'fusion13', 'Tool', ' iPHONE SOLD-BY &amp; COVERAGE **HOT** → IMEI/SN', '2597', '2', '', ' Instant', 'None', 'None', 'None', 'None', 'None', 'None', 'None', 'None', '', 'None', 'None', 'None', 'None', 'IMEI CHECK', '', '', '', '', '', 0, '', '', '2.00', 0, 0, 0, '', '', 'd256ec1b527687655fe160c0e5fcd1a6', 0, '', 0, 0, '{\"allow\":\"1\",\"bulk\":\"1\",\"customname\":\"SERIAL or IMEI\",\"custominfo\":\"SERIAL or IMEI\",\"customlen\":\"8\",\"maxlength\":\"15\",\"regex\":\"\",\"isalpha\":\"1\"}'),
(315, 'fusion13', 'Tool', 'MACBOOK / iMAC iCLOUD ON/OFF STATUS', '2399', '0.7', '', ' Instant', 'None', 'None', 'None', 'None', 'None', 'None', 'None', 'None', '', 'None', 'None', 'None', 'None', 'IMEI CHECK', '', '', '', '', '', 0, '', '', '0.70', 0, 0, 0, '', '', 'c18663d70d1650f9c0a5a7dca376e12d', 0, '', 0, 0, '{\"allow\":\"1\",\"bulk\":\"1\",\"customname\":\"IMEI or SERIAL\",\"custominfo\":\"IMEI or SERIAL\",\"customlen\":\"10\",\"maxlength\":\"15\",\"regex\":\"\",\"isalpha\":\"1\"}'),
(314, 'fusion13', 'Tool', 'APPLE IPHONE MDM STATUS → IMEI', '3083', '0.6', '', ' Instant', 'None', 'None', 'None', 'None', 'None', 'None', 'None', 'None', '', 'None', 'None', 'None', 'None', 'IMEI CHECK', '', '', '', '', '', 0, '', '', '0.60', 0, 0, 0, '', '', '1095b8fc7aa2c2733db0e0b8d7890705', 0, '', 0, 0, '{\"allow\":\"0\",\"bulk\":\"1\",\"customname\":\"IMEI or SERIAL\",\"custominfo\":\"IMEI or SERIAL\",\"customlen\":\"10\",\"maxlength\":\"15\",\"regex\":\"\",\"isalpha\":\"1\"}'),
(312, 'fusion13', 'Group', 'IMEI CHECK', 'IMEI CHECK', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0, '', '', '0.00', 0, 0, 0, '', '', '', 0, '', 0, 0, ''),
(313, 'fusion13', 'Tool', 'APPLE GSX CASES ID INFO', '3191', '2.2', '', ' Instant', 'None', 'None', 'None', 'None', 'None', 'None', 'None', 'None', '', 'None', 'None', 'None', 'None', 'IMEI CHECK', '', '', '', '', '', 0, '', '', '2.20', 0, 0, 0, '', '', '36d2d1267ba44626b746178b9baad6f8', 0, '', 0, 0, '{\"allow\":\"1\",\"bulk\":\"1\",\"customname\":\"GSX CASE ID\",\"custominfo\":\"GSX CASE ID\",\"customlen\":\"10\",\"maxlength\":\"15\",\"regex\":\"\",\"isalpha\":\"0\"}');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_api_sync_log`
--

CREATE TABLE `tbl_api_sync_log` (
  `id` int(11) NOT NULL,
  `server` varchar(200) NOT NULL,
  `time` varchar(50) NOT NULL,
  `ip` varchar(50) NOT NULL,
  `adminid` int(11) NOT NULL DEFAULT 0,
  `event` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_api_sync_log`
--

INSERT INTO `tbl_api_sync_log` (`id`, `server`, `time`, `ip`, `adminid`, `event`) VALUES
(1, 'fusion60', '1675803925', '45.139.199.136', 1, 'sync start'),
(2, 'fusion60', '1675803951', '45.139.199.136', 1, 'sync start'),
(3, 'fusion30', '1675804259', '45.139.199.136', 1, 'sync start'),
(4, 'fusion30', '1675804281', '45.139.199.136', 1, 'sync start'),
(5, 'fusion30', '1675804315', '45.139.199.136', 1, 'sync start'),
(6, 'fusion30', '1675804332', '45.139.199.136', 1, 'sync start'),
(7, 'fusion30', '1675804344', '45.139.199.136', 1, 'sync start'),
(8, 'fusion30', '1675804357', '45.139.199.136', 1, 'sync start'),
(9, 'fusion30', '1675804363', '45.139.199.136', 1, 'sync start'),
(10, 'fusion30', '1675804364', '45.139.199.136', 1, 'sync start'),
(11, 'fusion30', '1675804402', '45.139.199.136', 1, 'sync start'),
(12, 'fusion30', '1675804410', '45.139.199.136', 1, 'sync start'),
(13, 'fusion30', '1675804413', '45.139.199.136', 1, 'sync start'),
(14, 'fusion30', '1675804414', '45.139.199.136', 1, 'sync start'),
(15, 'fusion30', '1675804415', '45.139.199.136', 1, 'sync start'),
(16, 'fusion30', '1675804415', '45.139.199.136', 1, 'sync start'),
(17, 'fusion30', '1675804439', '45.139.199.136', 1, 'sync start'),
(18, 'fusion13', '1677974698', '188.80.69.14', 1, 'sync start'),
(19, 'fusion13', '1677974707', '188.80.69.14', 1, 'sync start'),
(20, 'fusion13', '1677974726', '77.67.210.5', 1, 'sync start'),
(21, 'fusion13', '1677974731', '188.80.69.14', 1, 'sync start'),
(22, 'fusion13', '1677974793', '188.80.69.14', 1, 'sync start'),
(23, 'fusion13', '1677974806', '77.67.210.5', 1, 'sync start'),
(24, 'fusion13', '1677974968', '188.80.69.14', 1, 'sync start'),
(25, 'fusion13', '1677975036', '188.80.69.14', 1, 'sync start'),
(26, 'berryunlocks', '1677975139', '188.80.69.14', 1, 'sync start'),
(27, 'berryunlocks', '1677975139', '188.80.69.14', 1, 'account info'),
(28, 'berryunlocks', '1677975139', '188.80.69.14', 1, 'sync start'),
(29, 'berryunlocks', '1677975139', '188.80.69.14', 1, 'services'),
(30, 'fusion13', '1677975343', '188.80.69.14', 1, 'sync start'),
(31, 'fusion13', '1677975600', '188.80.69.14', 1, 'sync start'),
(32, 'fusion13', '1677975601', '188.80.69.14', 1, 'account info'),
(33, 'fusion13', '1677975601', '188.80.69.14', 1, 'sync start'),
(34, 'fusion13', '1677975604', '188.80.69.14', 1, 'services'),
(35, 'fusion13', '1677975868', '188.80.69.14', 1, 'sync start'),
(36, 'fusion13', '1677975868', '188.80.69.14', 1, 'account info'),
(37, 'fusion13', '1677975868', '188.80.69.14', 1, 'sync start'),
(38, 'fusion13', '1677975869', '188.80.69.14', 1, 'services'),
(39, 'fusion13', '1677976014', '188.80.69.14', 1, 'sync start'),
(40, 'fusion13', '1677976016', '188.80.69.14', 1, 'services'),
(41, 'fusion13', '1677976048', '188.80.69.14', 1, 'sync start'),
(42, 'fusion13', '1677976048', '188.80.69.14', 1, 'account info'),
(43, 'fusion13', '1677976048', '188.80.69.14', 1, 'sync start'),
(44, 'fusion13', '1677976050', '188.80.69.14', 1, 'services'),
(45, 'fusion13', '1677976050', '188.80.69.14', 1, 'sync start'),
(46, 'fusion13', '1677976050', '188.80.69.14', 1, 'sync start'),
(47, 'fusion13', '1677976050', '188.80.69.14', 1, 'sync start'),
(48, 'fusion13', '1677976050', '188.80.69.14', 1, 'sync start'),
(49, 'fusion13', '1677976050', '188.80.69.14', 1, 'sync start'),
(50, 'fusion13', '1677976184', '188.80.69.14', 1, 'sync start'),
(51, 'fusion13', '1677976186', '188.80.69.14', 1, 'services'),
(52, 'fusion13', '1677976547', '188.80.69.14', 1, 'sync start'),
(53, 'fusion13', '1677976548', '188.80.69.14', 1, 'account info'),
(54, 'fusion13', '1677976548', '188.80.69.14', 1, 'sync start'),
(55, 'fusion13', '1677976549', '188.80.69.14', 1, 'services'),
(56, 'fusion13', '1677976599', '188.80.69.14', 1, 'sync start'),
(57, 'fusion13', '1677976600', '188.80.69.14', 1, 'services'),
(58, 'fusion13', '1677977010', '188.80.69.14', 1, 'sync start'),
(59, 'fusion13', '1677977011', '188.80.69.14', 1, 'services'),
(60, 'fusion13', '1677977056', '188.80.69.14', 1, 'sync start'),
(61, 'fusion13', '1677977058', '188.80.69.14', 1, 'services');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_bannedips`
--

CREATE TABLE `tbl_bannedips` (
  `id` int(10) NOT NULL,
  `ip` mediumtext NOT NULL,
  `reason` mediumtext NOT NULL,
  `expires` datetime NOT NULL,
  `country` int(1) NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_bannerslider`
--

CREATE TABLE `tbl_bannerslider` (
  `id` int(11) NOT NULL,
  `attribute` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `tbl_bannerslider`
--

INSERT INTO `tbl_bannerslider` (`id`, `attribute`, `value`) VALUES
(128, 'duration', '5000'),
(129, 'auto', 'false'),
(148, 'info_box_effect', ''),
(134, 'mainWidth', '1920'),
(135, 'easing', 'easeInElastic'),
(146, 'transition', 'random'),
(137, 'mainHeight', ''),
(145, 'nav_auto_hide', ''),
(144, 'display_side_buttons', ''),
(143, 'cp-pos', 'inside'),
(142, 'cpalignments', 'topRight'),
(150, 'fullWidth', '1'),
(151, 'thumbnails', 'bullet'),
(152, 'timer', 'pie'),
(153, 'navbuttons', 'large');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_bannerslider_banners`
--

CREATE TABLE `tbl_bannerslider_banners` (
  `fontcolor` varchar(50) NOT NULL,
  `id` int(10) NOT NULL,
  `img` text NOT NULL,
  `img_title` mediumtext NOT NULL,
  `info_header` mediumtext NOT NULL,
  `info` mediumtext NOT NULL,
  `readmore_link` mediumtext NOT NULL,
  `store` int(11) NOT NULL DEFAULT 0,
  `infox_box_width` varchar(10) NOT NULL,
  `po_top` varchar(10) NOT NULL,
  `po_left` varchar(10) NOT NULL,
  `bgcolor` varchar(50) NOT NULL,
  `sort` int(11) NOT NULL DEFAULT 0,
  `backgroundimage` text NOT NULL,
  `other_html` text NOT NULL,
  `cloud` int(1) NOT NULL DEFAULT 0,
  `data` text DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `tbl_bannerslider_banners`
--

INSERT INTO `tbl_bannerslider_banners` (`fontcolor`, `id`, `img`, `img_title`, `info_header`, `info`, `readmore_link`, `store`, `infox_box_width`, `po_top`, `po_left`, `bgcolor`, `sort`, `backgroundimage`, `other_html`, `cloud`, `data`) VALUES
('1', 1, '', 'Theme Default', '', '&lt;h1 class=&quot;h0&quot; style=&quot;text-align: center;&quot;&gt;&lt;span style=&quot;color: #ffffff;&quot;&gt;&lt;span class=&quot;animated fadeInLeftBig&quot; style=&quot;animation-delay: 0.2s;&quot;&gt; An &lt;/span&gt;&lt;span style=&quot;font-size: 24pt;&quot;&gt; exciting &lt;/span&gt; &lt;span class=&quot;animated fadeInRightBig&quot; style=&quot;animation-delay: 0.4s;&quot;&gt; place &lt;/span&gt; &lt;span style=&quot;font-size: 24pt;&quot;&gt; to &lt;/span&gt;&lt;/span&gt; &lt;span style=&quot;color: #ffffff;&quot;&gt;&lt;span style=&quot;font-size: 24pt;&quot;&gt; grow &lt;/span&gt; &lt;span class=&quot;animated fadeInUp&quot; style=&quot;animation-delay: 1s;&quot;&gt; your business!&lt;/span&gt;&lt;/span&gt;&lt;/h1&gt;\r\n&lt;p style=&quot;text-align: center;&quot;&gt;&lt;span style=&quot;color: #ffffff;&quot;&gt;&lt;span class=&quot;animated fadeInUp&quot; style=&quot;animation-delay: 1s;&quot;&gt;&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;\r\n&lt;p style=&quot;text-align: center;&quot;&gt;&lt;span style=&quot;color: #ffffff;&quot;&gt;&lt;span class=&quot;animated fadeInUp&quot; style=&quot;animation-delay: 1s;&quot;&gt;...&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;\r\n&lt;p style=&quot;text-align: center;&quot;&gt;&lt;span style=&quot;color: #ffffff;&quot;&gt;&lt;span class=&quot;animated fadeInUp&quot; style=&quot;animation-delay: 1s;&quot;&gt;&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;', '', 0, '', '', '', '', 1, '', '', 0, '{\"id\":\"1\",\"title\":\"Theme Default\",\"bg\":\"themedefault\",\"backgroundImage\":\"\",\"backgroundSVG\":\"\",\"backgroundColor\":\"\",\"readmore\":\"\",\"info\":\"&lt;h1 class=&quot;h0&quot; style=&quot;text-align: center;&quot;&gt;&lt;span style=&quot;color: #ffffff;&quot;&gt;&lt;span class=&quot;animated fadeInLeftBig&quot; style=&quot;animation-delay: 0.2s;&quot;&gt; An &lt;\\/span&gt;&lt;span style=&quot;font-size: 24pt;&quot;&gt; exciting &lt;\\/span&gt; &lt;span class=&quot;animated fadeInRightBig&quot; style=&quot;animation-delay: 0.4s;&quot;&gt; place &lt;\\/span&gt; &lt;span style=&quot;font-size: 24pt;&quot;&gt; to &lt;\\/span&gt;&lt;\\/span&gt; &lt;span style=&quot;color: #ffffff;&quot;&gt;&lt;span style=&quot;font-size: 24pt;&quot;&gt; grow &lt;\\/span&gt; &lt;span class=&quot;animated fadeInUp&quot; style=&quot;animation-delay: 1s;&quot;&gt; your business!&lt;\\/span&gt;&lt;\\/span&gt;&lt;\\/h1&gt;\\r\\n&lt;p style=&quot;text-align: center;&quot;&gt;&lt;span style=&quot;color: #ffffff;&quot;&gt;&lt;span class=&quot;animated fadeInUp&quot; style=&quot;animation-delay: 1s;&quot;&gt;&lt;\\/span&gt;&lt;\\/span&gt;&lt;\\/p&gt;\\r\\n&lt;p style=&quot;text-align: center;&quot;&gt;&lt;span style=&quot;color: #ffffff;&quot;&gt;&lt;span class=&quot;animated fadeInUp&quot; style=&quot;animation-delay: 1s;&quot;&gt;...&lt;\\/span&gt;&lt;\\/span&gt;&lt;\\/p&gt;\\r\\n&lt;p style=&quot;text-align: center;&quot;&gt;&lt;span style=&quot;color: #ffffff;&quot;&gt;&lt;span class=&quot;animated fadeInUp&quot; style=&quot;animation-delay: 1s;&quot;&gt;&lt;\\/span&gt;&lt;\\/span&gt;&lt;\\/p&gt;\"}');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_bannerslider_banners_default`
--

CREATE TABLE `tbl_bannerslider_banners_default` (
  `id` int(10) NOT NULL,
  `fontcolor` varchar(50) DEFAULT NULL,
  `img` text DEFAULT NULL,
  `img_title` mediumtext DEFAULT NULL,
  `info_header` mediumtext DEFAULT NULL,
  `info` mediumtext DEFAULT NULL,
  `readmore_link` mediumtext DEFAULT NULL,
  `store` int(11) DEFAULT 0,
  `infox_box_width` varchar(10) DEFAULT NULL,
  `po_top` varchar(10) DEFAULT NULL,
  `po_left` varchar(10) DEFAULT NULL,
  `bgcolor` varchar(50) DEFAULT NULL,
  `sort` int(11) DEFAULT NULL,
  `backgroundimage` text DEFAULT NULL,
  `other_html` text DEFAULT NULL,
  `cloud` int(1) DEFAULT NULL,
  `data` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_blacklist_imei`
--

CREATE TABLE `tbl_blacklist_imei` (
  `id` int(11) NOT NULL,
  `imei` varchar(100) NOT NULL,
  `service_id` int(11) NOT NULL,
  `reason` varchar(200) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_blockchain_payments`
--

CREATE TABLE `tbl_blockchain_payments` (
  `invoice_id` int(11) NOT NULL,
  `amount` float(11,8) NOT NULL,
  `address` varchar(64) NOT NULL,
  `secret` varchar(64) NOT NULL,
  `confirmations` int(11) NOT NULL,
  `status` enum('unpaid','confirming','paid') NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_blogcats`
--

CREATE TABLE `tbl_blogcats` (
  `id` int(8) NOT NULL,
  `name` mediumtext NOT NULL,
  `sort` int(11) NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_blogcomments`
--

CREATE TABLE `tbl_blogcomments` (
  `id` int(10) NOT NULL,
  `post` mediumtext NOT NULL,
  `author` mediumtext NOT NULL,
  `email` mediumtext NOT NULL,
  `authorurl` mediumtext NOT NULL,
  `comment` mediumtext NOT NULL,
  `date` datetime NOT NULL,
  `status` mediumtext NOT NULL,
  `ip` mediumtext NOT NULL,
  `client` mediumtext NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_blogposts`
--

CREATE TABLE `tbl_blogposts` (
  `id` int(10) NOT NULL,
  `cat` mediumtext NOT NULL,
  `title` mediumtext NOT NULL,
  `author` mediumtext NOT NULL,
  `post` mediumtext NOT NULL,
  `date` datetime NOT NULL,
  `status` mediumtext NOT NULL,
  `comments` mediumtext NOT NULL,
  `teaser` mediumtext NOT NULL,
  `type` mediumtext NOT NULL,
  `icon` mediumtext NOT NULL,
  `sort` mediumtext NOT NULL,
  `permalink` mediumtext NOT NULL,
  `showblog` int(1) NOT NULL DEFAULT 0,
  `startdate` varchar(50) NOT NULL,
  `enddate` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_blogs`
--

CREATE TABLE `tbl_blogs` (
  `id` int(11) NOT NULL,
  `news_id` int(11) NOT NULL DEFAULT 0,
  `date` varchar(50) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(555) NOT NULL,
  `comments` text NOT NULL,
  `status` int(1) NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_campaign`
--

CREATE TABLE `tbl_campaign` (
  `id` int(11) NOT NULL,
  `title` varchar(250) NOT NULL,
  `date` date NOT NULL,
  `createdby` int(11) NOT NULL,
  `subject` varchar(500) NOT NULL,
  `message` mediumtext NOT NULL,
  `status` varchar(50) NOT NULL,
  `completed` int(5) NOT NULL,
  `total` int(5) NOT NULL,
  `users` varchar(500) NOT NULL,
  `mailserver` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_campaign_users`
--

CREATE TABLE `tbl_campaign_users` (
  `id` int(11) NOT NULL,
  `campaignid` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `userid` int(11) NOT NULL,
  `status` int(1) NOT NULL,
  `date` date NOT NULL,
  `opencount` int(4) NOT NULL,
  `md5id` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_chat`
--

CREATE TABLE `tbl_chat` (
  `id` int(10) UNSIGNED NOT NULL,
  `from` varchar(255) NOT NULL DEFAULT '',
  `to` varchar(255) NOT NULL DEFAULT '',
  `message` mediumtext NOT NULL,
  `sent` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `recd` int(10) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_chatdepartment`
--

CREATE TABLE `tbl_chatdepartment` (
  `id` int(11) NOT NULL,
  `department` varchar(555) NOT NULL,
  `login` int(1) NOT NULL DEFAULT 0,
  `email` varchar(555) NOT NULL,
  `info` mediumtext NOT NULL,
  `status` int(1) NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_chat_visitor`
--

CREATE TABLE `tbl_chat_visitor` (
  `username` varchar(100) NOT NULL,
  `current_login_time` varchar(50) NOT NULL,
  `ip` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_client_group`
--

CREATE TABLE `tbl_client_group` (
  `id` int(11) NOT NULL,
  `groupname` varchar(255) NOT NULL,
  `fee` varchar(15) NOT NULL,
  `days` int(5) DEFAULT NULL,
  `type` int(1) NOT NULL DEFAULT 0,
  `showon` int(1) NOT NULL DEFAULT 0,
  `paymentgateway` text NOT NULL,
  `maxcredit` decimal(12,2) NOT NULL,
  `displayorder` int(2) NOT NULL,
  `retail` int(1) NOT NULL,
  `maxaddfund` varchar(20) NOT NULL,
  `minaddfund` varchar(20) NOT NULL,
  `idverification` int(1) NOT NULL,
  `settings` text DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_client_group_price`
--

CREATE TABLE `tbl_client_group_price` (
  `group_id` int(11) NOT NULL DEFAULT 0,
  `service_type` varchar(11) NOT NULL,
  `service_id` int(11) NOT NULL DEFAULT 0,
  `discount` decimal(15,3) NOT NULL,
  `currency_id` int(11) NOT NULL DEFAULT 0,
  `fee` varchar(15) DEFAULT NULL,
  `days` int(5) DEFAULT NULL,
  `type` int(1) DEFAULT NULL,
  `price` decimal(20,3) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_cms_pages`
--

CREATE TABLE `tbl_cms_pages` (
  `id` int(10) UNSIGNED NOT NULL,
  `urlname` varchar(255) NOT NULL,
  `parenturlname` varchar(255) NOT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `status` varchar(16) NOT NULL,
  `publish_time` timestamp NULL DEFAULT NULL,
  `view` varchar(10) NOT NULL,
  `meta_keys` text NOT NULL,
  `meta_desc` text NOT NULL,
  `iframe` int(1) NOT NULL DEFAULT 0,
  `plain` int(1) NOT NULL DEFAULT 0,
  `fullwidth` int(1) NOT NULL DEFAULT 0,
  `login_req` int(1) NOT NULL DEFAULT 0,
  `navigation` int(1) NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `tbl_cms_pages`
--

INSERT INTO `tbl_cms_pages` (`id`, `urlname`, `parenturlname`, `icon`, `status`, `publish_time`, `view`, `meta_keys`, `meta_desc`, `iframe`, `plain`, `fullwidth`, `login_req`, `navigation`) VALUES
(1, 'index', '', '', 'published', '2010-12-24 07:11:42', 'all', '', '', 0, 0, 0, 0, 0),
(2, 'error404', '', '', 'published', '2010-12-24 07:11:42', 'all', '', '', 0, 0, 0, 0, 0),
(3, 'error201', '', NULL, 'published', '2010-12-24 07:11:42', 'all', '', '', 0, 0, 0, 0, 0),
(4, 'toc', '', NULL, 'published', '2010-12-24 07:11:42', 'all', '', '', 0, 0, 0, 0, 0),
(1000, 'storefeatures', '', NULL, 'published', '2013-04-26 16:54:16', 'all', '', '', 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_cms_pages_store`
--

CREATE TABLE `tbl_cms_pages_store` (
  `id` int(10) UNSIGNED NOT NULL,
  `urlname` varchar(255) NOT NULL,
  `title` varchar(555) NOT NULL,
  `breadcrumb` varchar(255) NOT NULL,
  `parenturlname` varchar(255) NOT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `status` varchar(16) NOT NULL,
  `publish_time` timestamp NULL DEFAULT NULL,
  `view` varchar(10) NOT NULL,
  `meta_keys` text NOT NULL,
  `meta_desc` text NOT NULL,
  `iframe` int(1) NOT NULL DEFAULT 0,
  `plain` int(1) NOT NULL DEFAULT 0,
  `fullwidth` int(1) NOT NULL DEFAULT 0,
  `login_req` int(1) NOT NULL DEFAULT 0,
  `body` text NOT NULL,
  `hits` int(11) NOT NULL DEFAULT 0,
  `store` int(11) NOT NULL DEFAULT 0,
  `navigation` int(1) NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_cms_page_language`
--

CREATE TABLE `tbl_cms_page_language` (
  `id` int(10) UNSIGNED NOT NULL,
  `relid` int(10) UNSIGNED NOT NULL,
  `store` int(11) NOT NULL DEFAULT 0,
  `title` varchar(255) NOT NULL,
  `breadcrumb` varchar(255) NOT NULL,
  `parentbreadcrumb` varchar(255) DEFAULT NULL,
  `loggedincode` text DEFAULT NULL,
  `smartvalues` text DEFAULT NULL,
  `body` text NOT NULL,
  `hits` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `language` varchar(64) NOT NULL DEFAULT 'English'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `tbl_cms_page_language`
--

INSERT INTO `tbl_cms_page_language` (`id`, `relid`, `store`, `title`, `breadcrumb`, `parentbreadcrumb`, `loggedincode`, `smartvalues`, `body`, `hits`, `language`) VALUES
(1, 4, 0, 'Terms &amp; Conditions', '', NULL, NULL, NULL, '&lt;p&gt;USER AGREEMENT&lt;/p&gt;\r\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\r\n&lt;p&gt;USER AGREEMENT is set forth below. Please ensure that you have read and interpret the entire agreement before accepting it.&lt;/p&gt;\r\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\r\n&lt;p&gt;TERMS;&lt;/p&gt;\r\n&lt;p&gt;&quot;End User&quot; hereinafter referred to as &quot;Customer&quot;&lt;/p&gt;\r\n&lt;p&gt;&quot;domain.com&quot; hereinafter referred to as &quot;Seller&quot;&lt;/p&gt;\r\n&lt;p&gt;&quot;Buyer &amp;amp; Seller&quot; hereinafter referred to as &quot;Parties&quot;&lt;/p&gt;\r\n&lt;p&gt;&quot;Suppliers&quot; hereinafter referred to as &quot;Third Party Service Provider(s)&quot;&lt;/p&gt;\r\n&lt;p&gt;Third Party Service(s)&amp;nbsp; hereinafter referred to as &amp;acirc;&amp;euro;&amp;oelig;Service(s)&lt;/p&gt;\r\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\r\n&lt;p&gt;ACCEPTANCE OF TERMS;&lt;/p&gt;\r\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\r\n&lt;p&gt;1)&quot;Customer&quot; consents to use of electronic agreement to govern use of services. &quot;Customer&quot; consents to receiving all notices hereunder in electronic form, provided this consent may be withdrawn at any time by notice at the address set forth above (though, in some situations, we may have no other means of providing notices to &quot;Customer&quot;, so termination of &quot;Customer&quot; account may result from a request from &quot;Customer&quot; not to available receive notices in electronic form).&lt;/p&gt;\r\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\r\n&lt;p&gt;2. The &quot;Parties&quot; expressly agree that all performance under this Agreement and the resolution of disputes shall be conducted through mediation in the jurisdiction ed by &quot;Seller&quot;.&lt;/p&gt;\r\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\r\n&lt;p&gt;3. If a translation of this Agreement into any other language is required by law, the English version will prevail to the extent that there is any conflict or discrepancy in meaning between the English version and any translation thereof. &quot;Seller&quot; should not be held liable in any case whatsoever.&lt;/p&gt;\r\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\r\n&lt;p&gt;4.&quot;Seller&quot; is not affiliated with any network provider, carriers, or manufactures. The logos, images, and trademarks used are copyrights and property of their respected owners.&lt;/p&gt;\r\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\r\n&lt;p&gt;5. All Services offered for use by &quot;Seller&quot; to &quot;Buyer&quot; are provided through &quot;Third Party Service Provider(s)&quot; and &quot;Buyer&quot; shall be subject to Terms &amp;amp; Conditions with such &quot;Third Party Service Provider(s)&quot;. Except to the extent specifically prohibited by applicable law in &quot;Buyer&quot; jurisdiction. &quot;Seller&quot; shall have no liability whatsoever to &quot;Buyer&quot; or any Third Party claiming by or through &quot;Buyer&quot;. For any issue relating to the &quot;Third Party Service Provider(s)&quot;, Linked Sites, Other Sites Or Third Party Information, including without limitation; the accuracy, timeliness or continued availability of such &quot;Third Party Service Provider(s)&quot; or the continued interoperability of the &quot;Third Party Service Provider(s)&quot;.&lt;/p&gt;\r\n&lt;p&gt;6.&quot;Seller&quot; reserves the right to change the Terms &amp;amp; Conditions at anytime. Any such changes will take effect upon posting. It is the customer\'s responsibility to read the Terms &amp;amp; Conditions on each purchase. The continued use of our service shall signify the acceptance of the latest Terms &amp;amp; Conditions&lt;/p&gt;\r\n&lt;p&gt;7. &quot;Seller&quot; is committed to protecting the privacy of the &quot;Customer&quot;. &quot;Seller&quot; will only use the information collected about the &quot;Customer&quot; lawfully (in accordance with the Data Protection Act 1998). &quot;Seller&quot; will never collect sensitive information about the &quot;Customer&quot; without explicit consent. The personal information which &quot;Seller&quot; holds will be held securely in accordance with internal security policy and the law.&lt;/p&gt;\r\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\r\n&lt;p&gt;8. In the event that the &quot;Third Party Service Provider(s)&quot;, cannot complete the transaction the order will be returned as &quot;Not Found&quot; and full credit will be automatically issued for specific transaction.&lt;/p&gt;\r\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\r\n&lt;p&gt;9. In the event that the &quot;Service(s)&amp;acirc;&amp;euro; are completed but not accepted by the cellular device, the &quot;Buyer&quot; must notify the &quot;Seller&quot; within 7 days of receipt. Additional information will be requested from the &quot;Buyer&quot; in order to verify the &amp;acirc;&amp;euro;&amp;oelig;Service(s)&amp;acirc;&amp;euro; were not accepted by the cellular device as follows;&lt;/p&gt;\r\n&lt;p&gt;1) Video Proof must be presented&lt;/p&gt;\r\n&lt;p&gt;2) The Video must be continuous without any interruptions, delays, or segments&lt;/p&gt;\r\n&lt;p&gt;3) The Cellular device shall never be removed from line of site of the Video&lt;/p&gt;\r\n&lt;p&gt;4) The Video must show the IMEI identification #&lt;/p&gt;\r\n&lt;p&gt;5) The Video must show &amp;acirc;&amp;euro;&amp;oelig;Service(s)&amp;acirc;&amp;euro; being entered into the mobile device and error message afterwards&lt;/p&gt;\r\n&lt;p&gt;6) If the &quot;Third Party Service Provider(s)&quot;, produce multiple &amp;acirc;&amp;euro;&amp;oelig;Service(s)&amp;acirc;&amp;euro; from a single IMEI submission, one or multiple Video Requests may be subject to this agreement.&lt;/p&gt;\r\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\r\n&lt;p&gt;In addition, returns will not be accepted if one or more of any events below occurs;&lt;/p&gt;\r\n&lt;p&gt;1) The IMEI # provided was incorrect and a &amp;acirc;&amp;euro;&amp;oelig;Service(s)&amp;acirc;&amp;euro; were produced&lt;/p&gt;\r\n&lt;p&gt;2) Video Proof of claim is not produced&lt;/p&gt;\r\n&lt;p&gt;3) Buyer does not notify seller of claim within 7 days of receipt&lt;/p&gt;\r\n&lt;p&gt;4) The cellular device is Hard-Locked&lt;/p&gt;\r\n&lt;p&gt;5) The retrieval of the &amp;acirc;&amp;euro;&amp;oelig;Service(s)&amp;acirc;&amp;euro; exceeded delivery time&lt;/p&gt;\r\n&lt;p&gt;6) The &amp;acirc;&amp;euro;&amp;oelig;Service(s)&amp;acirc;&amp;euro; were purchased from another &amp;acirc;&amp;euro;&amp;oelig;Seller&amp;acirc;&amp;euro; before the results of &quot;Third Party Service Provider(s)&quot;, were returned&lt;/p&gt;\r\n&lt;p&gt;7) The cellular device accepted &amp;acirc;&amp;euro;&amp;oelig;Service(s)&amp;acirc;&amp;euro; but is not compatible with the desired network of the &amp;acirc;&amp;euro;&amp;oelig;Buyer&amp;acirc;&amp;euro;&lt;/p&gt;\r\n&lt;p&gt;8) The cellular device accepted &amp;acirc;&amp;euro;&amp;oelig;Service(s)&amp;acirc;&amp;euro; but internet or wifi is not functioning&lt;/p&gt;\r\n&lt;p&gt;9) The cellular device will not allow unlock code to be entered or phone is defective&lt;/p&gt;\r\n&lt;p&gt;This site is in accordance with The Digital Millennium Copyright Act valid until July 1997.&lt;/p&gt;\r\n&lt;p&gt;If &quot;Buyer&quot; disagrees with any content, &quot;Buyer&quot; shall not proceed with Registration. By completing Registration &quot;Buyer&quot; Accepts and fully understands all content listed herein.&lt;/p&gt;', 8773, 'English'),
(1000, 1000, 0, '', '', NULL, NULL, NULL, '&lt;ul class=&quot;nav nav-pills&quot;&gt;\r\n&lt;li class=&quot;nav-item&quot;&gt;&lt;a class=&quot;nav-link active&quot; href=&quot;#tab1&quot; data-toggle=&quot;tab&quot;&gt; Store Features &lt;/a&gt;&lt;/li&gt;\r\n&lt;li class=&quot;nav-item&quot;&gt;&lt;a class=&quot;nav-link&quot; href=&quot;#tab2&quot; data-toggle=&quot;tab&quot;&gt; Store Setup Help &lt;/a&gt;&lt;/li&gt;\r\n&lt;/ul&gt;\r\n&lt;div id=&quot;gallery&quot; class=&quot;tab-content&quot;&gt;\r\n&lt;div id=&quot;tab1&quot; class=&quot;tab-pane active&quot;&gt;\r\n&lt;div class=&quot;row&quot;&gt;\r\n&lt;div class=&quot;col-lg-4&quot;&gt;&lt;a class=&quot;gallery&quot; href=&quot;images/gallery/resellerstore/setupstore.gif&quot;&gt; &lt;img style=&quot;width: 230px;&quot; src=&quot;images/gallery/resellerstore/setupstore.gif&quot; alt=&quot;&quot; /&gt; &lt;/a&gt;&lt;/div&gt;\r\n&lt;div class=&quot;col-lg-8&quot;&gt;\r\n&lt;h4 class=&quot;display-4 h4&quot;&gt;Open your own cellphone unlocking site today&lt;/h4&gt;\r\n&lt;hr /&gt;\r\n&lt;p&gt;We provide you a complete easy to use and ready to work online unlocking store. All the latest up to date solutions included, support worldwide networks covering most of the phones on the international market. Best delivery time and unlock rate guaranteed. Included Monthly plans and Free unlock solutions, Content management system and lots of unique features that you can find only here. Receive payment from your customers directly to your account using your own paypal account. Focus on your sales and customers and stop losing your time with emails, excel and wrong suppliers. Do you already have a website running? You can use easy import system to move your clients here, and Experience a new way selling unlock codes on internet. Give unique features to your customers. Enjoy the most advanced online unlocking store.&lt;/p&gt;\r\n&lt;/div&gt;\r\n&lt;/div&gt;\r\n&lt;br /&gt; &lt;br /&gt;\r\n&lt;div class=&quot;row&quot;&gt;\r\n&lt;div class=&quot;col-lg-8&quot;&gt;\r\n&lt;h4 class=&quot;display-4 h4&quot;&gt;Powerfull and easy to use&lt;/h4&gt;\r\n&lt;hr /&gt;\r\n&lt;p&gt;A very easy to use CMS (Content Management System) for you to manage your website. Many advanced options on the Store control panel. Store overview to take a quick look at your sales, users registration, and services. Activate/Inactive services as you need for your store and set price as you wish. Manage your orders and customers easily. Offer special prices for each customers following the services they needs. Enjoy advanced affiliate program for your customers and much more....&lt;/p&gt;\r\n&lt;ul style=&quot;font-size: 10px;&quot;&gt;\r\n&lt;li&gt;Use your own &lt;strong&gt;domain/Sub-domain&lt;/strong&gt; name and Brand name&lt;/li&gt;\r\n&lt;li&gt;&lt;strong&gt;Can setup&lt;/strong&gt; your store with your own style, payment details and enable services you need&lt;/li&gt;\r\n&lt;li&gt;Your store is ready to accept orders and all requests will be &lt;strong&gt;processed automatically&lt;/strong&gt;&lt;/li&gt;\r\n&lt;li&gt;You can &lt;strong&gt;deposit money&lt;/strong&gt; to your account by online payment gateway&lt;/li&gt;\r\n&lt;li&gt;You do not have to worry about paying different suppliers here is &lt;strong&gt;only one&lt;/strong&gt;&lt;/li&gt;\r\n&lt;li&gt;Everything in one place with best services and best prices including a stunning online store&lt;/li&gt;\r\n&lt;li&gt;All our prices can be &lt;strong&gt;negotiated&lt;/strong&gt; following the volume your store is doing&lt;/li&gt;\r\n&lt;li&gt;Content updates and online support including &lt;strong&gt;Experts&lt;/strong&gt; available&lt;/li&gt;\r\n&lt;li&gt;Can setup custom mail template with your &lt;strong&gt;brand name&lt;/strong&gt;&lt;/li&gt;\r\n&lt;li&gt;Offer &lt;strong&gt;payapl payment&lt;/strong&gt; methods to your customers.&lt;/li&gt;\r\n&lt;/ul&gt;\r\n&lt;/div&gt;\r\n&lt;div class=&quot;col-lg-4&quot;&gt;&lt;a class=&quot;gallery&quot; href=&quot;images/gallery/resellerstore/overview.gif&quot;&gt; &lt;img src=&quot;images/gallery/resellerstore/overview.gif&quot; alt=&quot;&quot; /&gt; &lt;/a&gt; &lt;a class=&quot;gallery&quot; href=&quot;images/gallery/resellerstore/emailtemplate.gif&quot;&gt; &lt;img src=&quot;images/gallery/resellerstore/emailtemplate.gif&quot; alt=&quot;&quot; /&gt; &lt;/a&gt; &lt;a class=&quot;gallery&quot; href=&quot;images/gallery/resellerstore/addbanner.gif&quot;&gt; &lt;img src=&quot;images/gallery/resellerstore/addbanner.gif&quot; alt=&quot;&quot; /&gt; &lt;/a&gt; &lt;a class=&quot;gallery&quot; href=&quot;images/gallery/resellerstore/addcustompage.gif&quot;&gt; &lt;img src=&quot;images/gallery/resellerstore/addcustompage.gif&quot; alt=&quot;&quot; /&gt; &lt;/a&gt; &lt;a class=&quot;gallery&quot; href=&quot;images/gallery/resellerstore/cms.gif&quot;&gt; &lt;img src=&quot;images/gallery/resellerstore/cms.gif&quot; alt=&quot;&quot; /&gt; &lt;/a&gt;&lt;/div&gt;\r\n&lt;/div&gt;\r\n&lt;br /&gt; &lt;br /&gt;\r\n&lt;div class=&quot;row&quot;&gt;\r\n&lt;div class=&quot;col-lg-4&quot;&gt;&lt;a class=&quot;gallery&quot; href=&quot;images/gallery/resellerstore/retailselling.gif&quot;&gt; &lt;img style=&quot;width: 230px;&quot; src=&quot;images/gallery/resellerstore/retailselling.gif&quot; alt=&quot;&quot; /&gt; &lt;/a&gt;&lt;/div&gt;\r\n&lt;div class=&quot;col-lg-8&quot;&gt;\r\n&lt;h4 class=&quot;display-4 h4&quot;&gt;Exclusive solutions, tools and services&lt;/h4&gt;\r\n&lt;hr /&gt;\r\n&lt;p&gt;Enable/Disable the services you want to sale on your store. You can setup different prices for retail cart or for whole sell customers. Whenever a service is updated on our side you will get notified instantly on your store control panel. It is very easy to activate or disable any services on your store. Some solutions offer monthly plans, this means your customer can subscribe to this monthly plan and use that solution as much as he need. also can setup custom prices for each customers by each services as you need .&lt;/p&gt;\r\n&lt;/div&gt;\r\n&lt;/div&gt;\r\n&lt;br /&gt; &lt;br /&gt;\r\n&lt;div class=&quot;row&quot;&gt;\r\n&lt;div class=&quot;col-lg-8&quot;&gt;\r\n&lt;h4 class=&quot;display-4 h4&quot;&gt;Customize as you love to see your store&lt;/h4&gt;\r\n&lt;hr /&gt;\r\n&lt;p&gt;We have unique live template editor, It is very easy to customize with your own design the look of your website. Adding your own logo, description about your company, Facebook and Twitter links. You can also add your own Google analysts code to keep records of your site stats. Add your own banners for the home page. Customize the SEO of every single page on your site to increase the search engine power. Change the background, the main color of your website or the menu by adding some patterns. You can also customize any single email sent from your store to your customers. There is unlimited possibility to customize your unlocking store.Can also create custom pages via built in CMS . Be creative!&lt;/p&gt;\r\n&lt;/div&gt;\r\n&lt;div class=&quot;col-lg-4&quot;&gt;&lt;a class=&quot;gallery&quot; href=&quot;images/gallery/resellerstore/editor.gif&quot;&gt; &lt;img style=&quot;width: 230px;&quot; src=&quot;images/gallery/resellerstore/editor.gif&quot; alt=&quot;&quot; /&gt; &lt;/a&gt;&lt;/div&gt;\r\n&lt;/div&gt;\r\n&lt;br /&gt; &lt;br /&gt;\r\n&lt;div class=&quot;row&quot;&gt;\r\n&lt;div class=&quot;col-lg-4&quot;&gt;&lt;a class=&quot;gallery&quot; href=&quot;images/gallery/resellerstore/userlist.gif&quot;&gt; &lt;img src=&quot;images/gallery/resellerstore/userlist.gif&quot; alt=&quot;&quot; /&gt; &lt;/a&gt; &lt;a class=&quot;gallery&quot; href=&quot;images/gallery/resellerstore/addneruser.gif&quot;&gt; &lt;img src=&quot;images/gallery/resellerstore/addneruser.gif&quot; alt=&quot;&quot; /&gt; &lt;/a&gt; &lt;a class=&quot;gallery&quot; href=&quot;images/gallery/resellerstore/edituser.gif&quot;&gt; &lt;img src=&quot;images/gallery/resellerstore/edituser.gif&quot; alt=&quot;&quot; /&gt; &lt;/a&gt; &lt;a class=&quot;gallery&quot; href=&quot;images/gallery/resellerstore/myuserstatement.jpg&quot;&gt; &lt;img src=&quot;images/gallery/resellerstore/myuserstatement.jpg&quot; alt=&quot;&quot; /&gt; &lt;/a&gt; &lt;a class=&quot;gallery&quot; href=&quot;images/gallery/resellerstore/addcredit.gif&quot;&gt; &lt;img src=&quot;images/gallery/resellerstore/addcredit.gif&quot; alt=&quot;&quot; /&gt; &lt;/a&gt; &lt;a class=&quot;gallery&quot; href=&quot;images/gallery/resellerstore/credittransfer.gif&quot;&gt; &lt;img src=&quot;images/gallery/resellerstore/credittransfer.gif&quot; alt=&quot;&quot; /&gt; &lt;/a&gt;&lt;/div&gt;\r\n&lt;div class=&quot;col-lg-8&quot;&gt;\r\n&lt;h4 class=&quot;display-4 h4&quot;&gt;Manage your customers&lt;/h4&gt;\r\n&lt;hr /&gt;\r\n&lt;p&gt;Manage your customers easily. Get a comlete details of their account. We also have added amazing features. Enable transfers, Block a customer or Erase the credits. We also included special features as CUSTOM PRICES for EACH customers. This means you can setup a UNIQUE custom price for every single customers of your store. You can apply a general discount for all solutions as well.&lt;/p&gt;\r\n&lt;/div&gt;\r\n&lt;/div&gt;\r\n&lt;/div&gt;\r\n&lt;div id=&quot;tab2&quot; class=&quot;tab-pane&quot;&gt;\r\n&lt;h3 class=&quot;display-4 h3&quot;&gt;Step 1 : Login with your reseller account&lt;/h3&gt;\r\n&lt;img src=&quot;images/gallery/resellerstore/step1-login.jpg&quot; alt=&quot;&quot; /&gt;&lt;hr /&gt;\r\n&lt;h3 class=&quot;display-4 h3&quot;&gt;Step 2 : After login click on My Personal site store in reseller tab&lt;/h3&gt;\r\n&lt;img src=&quot;images/gallery/resellerstore/step2-reseller.jpg&quot; alt=&quot;&quot; /&gt;&lt;hr /&gt;\r\n&lt;h3 class=&quot;display-4 h3&quot;&gt;Step 3 : Your domain name must point to this ip&lt;/h3&gt;\r\n&lt;img src=&quot;images/gallery/resellerstore/step3-notmatchdomain.jpg&quot; alt=&quot;&quot; /&gt; &lt;br /&gt; &lt;br /&gt; &lt;strong&gt;Damion name Pointed with &quot; A Record &quot; &lt;/strong&gt;&lt;br /&gt; &lt;a style=&quot;text-decoration: underline;&quot; href=&quot;http://docs.cpanel.net/twiki/bin/view/AllDocumentation/WHMDocs/EditZone&quot; target=&quot;_blank&quot;&gt; How to point in cPanel ? &lt;/a&gt; &lt;br /&gt; &lt;a style=&quot;text-decoration: underline;&quot; href=&quot;http://support.godaddy.com/help/article/680/managing-dns-for-your-domain-names&quot; target=&quot;_blank&quot;&gt; How to point with domain name registered with Godaddy ? &lt;/a&gt; &lt;br /&gt; &lt;a style=&quot;text-decoration: underline;&quot; href=&quot;https://my.bluehost.com/cgi/help/559&quot; target=&quot;_blank&quot;&gt; How to point in Bluehost ? &lt;/a&gt; &lt;br /&gt; &lt;strong&gt; after change DNS you need to allow up to 48 hour to update&lt;/strong&gt;&lt;hr /&gt;\r\n&lt;h3 class=&quot;display-4 h3&quot;&gt;Step 5 : After point check ping your domain name from command prompt is pointed perfectly&lt;/h3&gt;\r\n&lt;img src=&quot;images/gallery/resellerstore/step4-pingdomain.jpg&quot; alt=&quot;&quot; /&gt;&lt;hr /&gt;&lt;br /&gt; &lt;br /&gt;\r\n&lt;h2&gt;Edit Template&lt;/h2&gt;\r\n&lt;h3 class=&quot;display-4 h3&quot;&gt;Step 1 : Go to store overview&lt;/h3&gt;\r\n&lt;img src=&quot;images/gallery/resellerstore/step5-overview.jpg&quot; alt=&quot;&quot; /&gt;\r\n&lt;h3 class=&quot;display-4 h3&quot;&gt;Step 2 : Click to view your store for edit&lt;/h3&gt;\r\n&lt;img src=&quot;images/gallery/resellerstore/step7-linkeditor.jpg&quot; alt=&quot;&quot; /&gt;&lt;hr /&gt;\r\n&lt;h3 class=&quot;display-4 h3&quot;&gt;Step 3 : Click to active editor&lt;/h3&gt;\r\n&lt;img src=&quot;images/gallery/resellerstore/step8-activeeditor.jpg&quot; alt=&quot;&quot; /&gt;&lt;hr /&gt;\r\n&lt;h3 class=&quot;display-4 h3&quot;&gt;Step 4 : Select any element which you want to change&lt;/h3&gt;\r\n&lt;img src=&quot;images/gallery/resellerstore/step9-selectelement.jpg&quot; alt=&quot;&quot; /&gt;&lt;hr /&gt;\r\n&lt;h3 class=&quot;display-4 h3&quot;&gt;Step 5 : After seletion editor border color has been blue, select property from editor and apply it&lt;/h3&gt;\r\n&lt;img src=&quot;images/gallery/resellerstore/step10-useeditor.jpg&quot; alt=&quot;&quot; /&gt;&lt;hr /&gt;&lt;/div&gt;\r\n&lt;/div&gt;', 1775, 'English');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_config`
--

CREATE TABLE `tbl_config` (
  `id` int(11) NOT NULL,
  `type` varchar(50) NOT NULL,
  `attribute` varchar(250) NOT NULL,
  `value` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_config`
--

INSERT INTO `tbl_config` (`id`, `type`, `attribute`, `value`) VALUES
(1, 'config', 'live_chat_online_time', '1679506733'),
(2, 'config', 'live_chat_online_username', 'admin'),
(3, 'config', 'loginfailed', '0'),
(4, 'config', 'online_status', 'online'),
(5, 'config', 'cronpreference', '2'),
(6, 'config', 'seperatecron', '1'),
(7, 'config', 'cron_password', ''),
(8, 'config', 'cronsendbatchorder', '100'),
(9, 'config', 'crongetbatchorder', '1000');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_configer`
--

CREATE TABLE `tbl_configer` (
  `id` int(11) NOT NULL,
  `attribute` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_config_default`
--

CREATE TABLE `tbl_config_default` (
  `configid` int(11) NOT NULL,
  `configtype` varchar(50) DEFAULT NULL,
  `attribute` varchar(150) DEFAULT NULL,
  `value` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_config_default`
--

INSERT INTO `tbl_config_default` (`configid`, `configtype`, `attribute`, `value`) VALUES
(1, 'config', 'token', '6a66924e80a00df348bf7b4e6e68c1e6ebd69524'),
(2, 'config', 'companyname', 'Company Name'),
(3, 'config', 'config_site_name', 'Site Name'),
(4, 'config', 'logo_link', ''),
(5, 'config', 'site_address', 'http://appunlockbayi.com/'),
(6, 'config', 'config_ssl_allow', ''),
(7, 'config', 'cms_seofriendly', 'on'),
(8, 'config', 'page_title_format', ''),
(9, 'config', 'site_description', 'SEO WORDS FOR GOOGLE'),
(10, 'config', 'sitekeywords', 'KEYWORDS, UNLOCK, iphone, blackberry , Samsung'),
(11, 'config', 'testimonial', '0'),
(12, 'config', 'contactus', '1'),
(13, 'config', 'blog', '0'),
(14, 'config', 'faq', '0'),
(15, 'config', 'supportticketservice', '0'),
(16, 'config', 'displayprice', '1'),
(17, 'config', 'facebooklike', '0'),
(18, 'config', 'mail_history', '0'),
(19, 'config', 'ccdetails', '1'),
(20, 'config', 'installapp', '0'),
(21, 'config', 'allowoverdrive', '0'),
(22, 'config', 'quicknews', '0'),
(23, 'config', 'contactus_mail', 'contact@yoursite.com'),
(24, 'config', 'support_email', ''),
(25, 'config', 'Index_page_redirect', ''),
(26, 'config', 'logout_page_redirect', ''),
(27, 'config', 'addfund', '1'),
(28, 'config', 'AddFundsMinimum', '10'),
(29, 'config', 'AddFundsMaximum', '100'),
(30, 'config', 'AddFundsMaximumBalance', '10000000'),
(31, 'config', 'cart_page_limit', '50'),
(32, 'config', 'adminlistlimit', ''),
(33, 'config', 'default_page_limit', '50'),
(34, 'config', 'BlogPostsperpage', '50'),
(35, 'config', 'ActivityLogLimit', '1000'),
(36, 'config', 'AddFunds_taxenabled', '1'),
(37, 'config', 'gravatar', '0'),
(38, 'config', 'faster_browsing_mode', '1'),
(39, 'config', 'voucher', '0'),
(40, 'config', 'trackorder', '0'),
(41, 'config', 'downloads', '0'),
(42, 'config', 'config_recent_menu', '0'),
(43, 'config', 'eucookielaw', '1'),
(44, 'config', 'livehelpservice', '0'),
(45, 'config', 'googlelike', '0'),
(46, 'config', 'affiliate', '0'),
(47, 'config', 'wikihelp', '0'),
(48, 'config', 'litedashboard', '0'),
(49, 'config', 'giftcerti', '0'),
(50, 'config', 'giftvoucher_tax', '0'),
(51, 'config', 'withdrawal_req', '0'),
(52, 'config', 'RemoveBranding', ''),
(53, 'config', 'reseller_can_setup_store', '1'),
(54, 'config', 'live_chat', '1'),
(55, 'config', 'shoppingcart', '1'),
(56, 'config', 'POS', '1'),
(57, 'config', 'mobileaddon', '1'),
(58, 'config', 'slacksubscription', '1'),
(59, 'config', 'online_status', 'online'),
(60, 'config', 'live_chat_online_time', '1597328241'),
(61, 'config', 'live_chat_online_username', 'admin'),
(62, 'config', 'loginfailed', '0'),
(63, 'config', 'template', 'default'),
(64, 'config', 'template_afterlogin', 'default'),
(65, 'config', 'applys', 'on'),
(66, 'config', 'afterlogin_apply', '1'),
(67, 'config', 'template_mobile', 'default'),
(68, 'config', 'carttpl', 'default'),
(69, 'config', 'cron_password', ''),
(70, 'config', 'cronsendbatchorder', '100'),
(71, 'config', 'crongetbatchorder', '1000'),
(72, 'config', 'seperatecron', '1'),
(73, 'config', 'slacktoken', ''),
(74, 'config', 'messenger', 'telegram'),
(75, 'config', 'mail_sending_type', '2'),
(76, 'config', 'mailperbatch', '50'),
(77, 'config', 'config_admin_mail', 'system@sitename.com'),
(78, 'config', 'BCC_Messages', ''),
(79, 'config', 'config_admin_name', 'system'),
(80, 'config', 'adminsignature', 'Admin Signature'),
(81, 'config', 'ds', 's1'),
(82, 'config', 'mail_type', 'php'),
(102, 'config', 'default_service_imei', '1'),
(103, 'config', 'default_service_file', '1'),
(104, 'config', 'default_service_server', '1'),
(105, 'config', 'config_self_cancel', '1'),
(106, 'config', 'usercan_cancel_order_within_min', '60'),
(107, 'config', 'usercan_verify_order_within_min', '60'),
(108, 'config', 'showimeiupdate', '48'),
(109, 'config', 'duplicateimei', '1'),
(110, 'config', 'happyhours', '0'),
(111, 'config', 'tooltip', '0'),
(112, 'config', 'ordercomments', '0'),
(113, 'config', 'orderemail', '0'),
(114, 'config', 'averagedeliverytime', '1'),
(115, 'config', 'clientorderalert', '0'),
(116, 'config', 'deliverycount', ''),
(117, 'config', 'placeordertype', '1'),
(118, 'config', 'infopos', '1'),
(119, 'config', 'subscribe_reminder', '10'),
(120, 'config', 'directorderinfo', ''),
(121, 'config', 'orderreplyword', 'No Code Found\r\nWrong Details'),
(122, 'config', 'orderdisplay', '2'),
(123, 'config', 'quick_checkout', 'disable'),
(124, 'config', 'directunverified', '1'),
(125, 'config', 'encryptedorderid', '0'),
(126, 'config', 'masterpin', '0'),
(127, 'config', 'ordernotes', '0'),
(128, 'config', 'orderno', '0'),
(130, 'config', 'admintheme_menu', 'open'),
(132, 'config', 'slack_usernotification', '1'),
(149, 'config', 'avatarapi', ''),
(150, 'config', 'gcmapikey', ''),
(151, 'config', 'tracking_code', ''),
(152, 'config', 'gcmkey', ''),
(153, 'config', 'gcmappid', ''),
(154, 'config', 'ip_location', 'https://geo.dhru.com/?ip='),
(155, 'config', 'twitter', ''),
(156, 'config', 'facebook_link', 'https://facebook.com/'),
(157, 'config', 'linkedln', 'https://Linkedin.com/'),
(158, 'config', 'consumer_key', ''),
(159, 'config', 'consumer_secret', ''),
(160, 'config', 'access_token', ''),
(161, 'config', 'token_secret', ''),
(162, 'config', 'googlelanguageapi', ''),
(163, 'config', 'androidlink', 'https://play.google.com/store/apps/details?id=com.dhru.fusionclient'),
(164, 'config', 'analyticsecommerce', ''),
(165, 'config', 'gcmnotification', ''),
(166, 'config', 'taxenabled', '1'),
(167, 'config', 'taxtype', 'Exclusive'),
(168, 'config', 'invoicepayto', '401, Alien street, Red Planet. 444123.'),
(169, 'config', 'cronpreference', '1'),
(170, 'config', 'gatewayiconpaypal', ''),
(171, 'config', 'precision', '3'),
(172, 'config', 'bannersizes', 'box'),
(173, 'config', 'bannershape', 'svg'),
(174, 'config', 'themecolor', 'theme1'),
(175, 'config', 'menubackground', 'transparent'),
(176, 'config', 'menubgs', ''),
(177, 'config', 'navbar', 'color'),
(178, 'config', 'bannercontent', 'checkout'),
(179, 'config', 'announcementpopup', 'false'),
(180, 'config', 'lock_username', 'username'),
(181, 'config', 'lock_email', 'email'),
(182, 'config', 'registration_type', '2'),
(183, 'config', 'minregistration', '0'),
(184, 'config', 'phonerequired', '1'),
(185, 'config', 'registration_expire', '365'),
(186, 'config', 'registration_currency', ''),
(187, 'config', 'google', 'google'),
(188, 'config', 'yahoo', ''),
(189, 'config', 'facebook', 'facebook'),
(190, 'config', 'captcha_registration', '0'),
(191, 'config', 'registration_terms', '1'),
(192, 'config', 'googleclientid', ''),
(193, 'config', 'googleclientsecret', ''),
(194, 'config', 'facebookappid', ''),
(195, 'config', 'facebookappsecret', ''),
(196, 'config', 'facebookaccesstoken', ''),
(197, 'config', 'registration_api', '1'),
(198, 'config', 'registration_affiliate', '0'),
(199, 'config', 'customize_email', '0'),
(200, 'config', 'fraud_protection', '0'),
(201, 'config', 'default_signupgroup', '0'),
(202, 'config', 'retailclientgroup', '0'),
(203, 'config', 'customfield', ''),
(204, 'config', 'registration_lockfields', 'username,email'),
(205, 'config', 'usercan_signup', ''),
(206, 'config', 'newsletter_registration', '0'),
(207, 'config', 'captcha_login', '1'),
(208, 'config', 'captcha_forget', '0'),
(209, 'config', 'cronpassword', ''),
(210, 'config', 'firstinvoice_due', '0'),
(211, 'config', 'secondinvoice_due', '0'),
(212, 'config', 'thirdinvoice_due', '0'),
(213, 'config', 'cancelinvoice_due', ''),
(214, 'config', 'groupexpiryremind', ''),
(215, 'config', 'deleteinvoice_due', '15'),
(216, 'config', 'lastloginalert', '30'),
(217, 'config', 'lowcreditreminder', '10'),
(218, 'config', 'lowcreditnotification', ''),
(219, 'config', 'creditvalidityremider', '10'),
(220, 'config', 'ticketclosed', ''),
(221, 'config', 'reorderlevel', ''),
(222, 'config', 'quickcheckoutorder', ''),
(223, 'config', 'autodeletequicknews', ''),
(224, 'config', 'dontdiscconect', '0'),
(225, 'config', 'currencyupdate', '1'),
(226, 'config', 'countryupdate', '1'),
(227, 'config', 'pricechange', ''),
(228, 'config', 'autoarchive', '27'),
(229, 'config', 'dailyemailbackup', ''),
(230, 'config', 'imeisummary', ''),
(231, 'config', 'dailysitemap', ''),
(232, 'config', 'lowstockalert', ''),
(233, 'config', 'removecc', '0'),
(234, 'config', 'newimeiavailable', '1'),
(235, 'config', 'currencyupdatetime', '1577206148'),
(236, 'config', 'bannerposition', 'middle'),
(237, 'config', 'testtoemail', ''),
(238, 'config', 'disablestartup', '1'),
(239, 'config', 'faviconicon', ''),
(240, 'config', 'popbefenable', ''),
(241, 'config', 'popafenable', ''),
(242, 'config', 'instagram', 'https://Instagram.com/'),
(243, 'config', 'fundtax', 'on'),
(244, 'config', 'lock_address', 'address'),
(245, 'config', 'lock_address2', 'address2'),
(246, 'config', 'lock_city', 'city'),
(247, 'config', 'lock_state', 'state'),
(248, 'config', 'lock_country', 'country'),
(249, 'config', 'lock_zip', 'zip'),
(250, 'config', 'gatewayminlimitstripe', '2'),
(251, 'config', 'gatewaymaxlimitstripe', '22'),
(252, 'config', 'gatewayminlimitcoinbase', '10'),
(253, 'config', 'gatewaymaxlimitcoinbase', '500'),
(254, 'config', 'gatewayminlimitbitcoin', '5'),
(255, 'config', 'gatewaymaxlimitbitcoin', '500'),
(256, 'config', 'captchaoncontact', '0'),
(257, 'config', 'autofraudclose', '0'),
(258, 'config', 'fraudcage', '1'),
(259, 'config', 'mobile_verification', '0'),
(260, 'config', 'captchaonnewsletter', '1'),
(261, 'config', 'paypalemailautopay', '0'),
(262, 'config', 'mobverbysms', '0'),
(263, 'config', 'mobverbycall', '0'),
(264, 'smsgateway', 'token', ''),
(265, 'smsgateway', 'addbeforenumber', ''),
(266, 'smsgateway', 'httpgeturl', ''),
(267, 'smsgateway', 'toparameter', ''),
(268, 'smsgateway', 'textparameter', ''),
(269, 'smsgateway', 'usernameparameter', ''),
(270, 'smsgateway', 'passwordparameter', ''),
(271, 'smsgateway', 'smsgatwayusername', ''),
(272, 'smsgateway', 'smsgatwaypassword', ''),
(273, 'smsgateway', 'customparameter1', ''),
(274, 'smsgateway', 'customparameter1value', ''),
(275, 'smsgateway', 'customparameter2', ''),
(276, 'smsgateway', 'customparameter2value', ''),
(277, 'smsgateway', 'customparameter3', ''),
(278, 'smsgateway', 'customparameter3value', ''),
(279, 'smsgateway', 'customparameter4', ''),
(280, 'smsgateway', 'customparameter4value', ''),
(281, 'smsgateway', 'customparameter5', ''),
(282, 'smsgateway', 'customparameter5value', ''),
(283, 'config', 'tinyvalue', ''),
(284, 'config', 'smsgateway', 'customgateway'),
(285, 'config', 'idverification', '0'),
(286, 'config', 'defaultgroupverification', '1'),
(287, 'config', 'clientgroup', ''),
(288, 'config', 'otpfordirectfund', '1'),
(289, 'config', 'singupgateway', '2'),
(290, 'config', 'signupgateway', '0'),
(291, 'config', 'gateway', ''),
(292, 'config', 'defaultgateway', ''),
(293, 'config', 'ebaypaypaluser', ''),
(294, 'config', 'ebaypaypalpass', ''),
(295, 'config', 'ebaypaypalsignature', ''),
(296, 'config', 'cartforstore', '1'),
(297, 'config', 'shippingcost', '1'),
(298, 'config', 'compareproduct', '1'),
(299, 'config', 'displayproducttype', '1'),
(300, 'config', 'defaultproductview', '1'),
(301, 'config', 'shoppingcart1', '0'),
(302, 'config', 'retailmenu', '0'),
(303, 'config', 'base_currency', 'USD'),
(304, 'config', 'DefaultCountry', 'US'),
(305, 'config', 'charset', 'UTF-8'),
(306, 'config', 'admincharset', 'UTF-8'),
(307, 'config', 'dateformat', 'MM/DD/YYYY'),
(308, 'config', 'language', 'English'),
(309, 'config', 'time_zone', '546'),
(310, 'config', 'language_chnage', '0'),
(311, 'config', 'smtp_port', '465'),
(312, 'config', 'smtp_host', ''),
(313, 'config', 'smtp_username', ''),
(314, 'config', 'smtp_password', ''),
(315, 'config', 'aggregatorlink', ''),
(316, 'config', 'mailgundomain', ''),
(317, 'config', 'aggregatorapi', ''),
(318, 'config', 'mail_type1', 'php'),
(319, 'config', 'smtp_port1', ''),
(320, 'config', 'smtp_host1', ''),
(321, 'config', 'smtp_enc1', '1'),
(322, 'config', 'smtp_username1', ''),
(323, 'config', 'smtp_password1', ''),
(324, 'config', 'mail_type2', 'php'),
(325, 'config', 'smtp_port2', ''),
(326, 'config', 'smtp_host2', ''),
(327, 'config', 'smtp_username2', ''),
(328, 'config', 'smtp_password2', ''),
(329, 'config', 'smtp_enc', ''),
(330, 'config', 'default_service_remote', '1'),
(331, 'config', 'slacktokenuser', ''),
(332, 'config', 'telegramuserbot', ''),
(333, 'config', 'allowtelegramreg', '1'),
(334, 'config', 'autoverifycredits', '0'),
(335, 'config', 'rewardpoint', '0'),
(336, 'config', 'addfundpoints', '{\"base\":{\"1\":\"2\",\"2\":\"2\",\"3\":\"\",\"20\":\"\",\"21\":\"\",\"30\":\"\",\"29\":\"7\",\"31\":\"\"},\"18\":{\"1\":\"3\",\"2\":\"\",\"3\":\"4\",\"20\":\"\",\"21\":\"0.5\",\"30\":\"6\",\"29\":\"\",\"31\":\"\"},\"19\":{\"1\":\"4\",\"2\":\"\",\"3\":\"\",\"20\":\"5\",\"21\":\"5\",\"30\":\"\",\"29\":\"\",\"31\":\"\"}}'),
(337, 'config', 'geodate', '05-03-2020'),
(338, 'config', 'MaxLoginFailedAttempts', '10'),
(339, 'config', 'password_expired', '0'),
(340, 'config', 'adminblocknotice', '1'),
(341, 'config', 'allowed', ' all'),
(342, 'config', 'passwordsecurity', 'high'),
(343, 'config', 'userapiip', '0'),
(344, 'config', 'sendcountrymail', '0'),
(345, 'config', 'usertmppassword', '0'),
(346, 'config', 'block_ac_on_country_mismatch', '0'),
(347, 'config', 'walletfee', '5'),
(348, 'config', 'allowtransfer', '1'),
(349, 'config', 'notdiscounteduser', '1'),
(350, 'config', 'otherfundlimit', '{\"baokim\":{\"maxlimit\":\"\",\"minlimit\":\"1\"},\"cash\":{\"maxlimit\":\"200\",\"minlimit\":\"2\"},\"cc\":{\"maxlimit\":\"230\",\"minlimit\":\"3\"},\"ccavenue\":{\"maxlimit\":\"140\",\"minlimit\":\"4\"},\"cod\":{\"minlimit\":\"4\",\"maxlimit\":\"\"},\"paypal\":{\"minlimit\":\"5\",\"maxlimit\":\"100\"},\"alipay\":{\"maxlimit\":\"\"},\"authorizenet\":{\"maxlimit\":\"\"},\"bitcoin\":{\"maxlimit\":\"\"},\"bitmap\":{\"maxlimit\":\"\"},\"bitmapdirect\":{\"maxlimit\":\"\"},\"coinbase\":{\"maxlimit\":\"\"},\"dalpay\":{\"maxlimit\":\"\"},\"dc\":{\"maxlimit\":\"\"},\"dhrumerchant\":{\"maxlimit\":\"\"},\"directpaypal1\":{\"maxlimit\":\"\"},\"directpaypal2\":{\"maxlimit\":\"\"},\"fawry\":{\"maxlimit\":\"\"},\"gourlio\":{\"maxlimit\":\"\"},\"networkae_ngenius\":{\"maxlimit\":\"\"},\"offlinepayments\":{\"maxlimit\":\"\"},\"offlinepayments1\":{\"maxlimit\":\"\"},\"offlinepayments5\":{\"maxlimit\":\"\"},\"offlinepayments9\":{\"maxlimit\":\"\"},\"paymentaggregator\":{\"maxlimit\":\"\"},\"paypal2\":{\"maxlimit\":\"\"},\"paypal3\":{\"maxlimit\":\"\"},\"paypalexpress\":{\"maxlimit\":\"\"},\"paypal_mass_pay\":{\"maxlimit\":\"\"},\"payumoney\":{\"maxlimit\":\"\"},\"quickpay\":{\"maxlimit\":\"\"},\"rakbankpay\":{\"maxlimit\":\"\"},\"rave\":{\"maxlimit\":\"\"},\"razorpay\":{\"maxlimit\":\"\"},\"squareup\":{\"maxlimit\":\"\"},\"stripe\":{\"maxlimit\":\"\"},\"vnpay\":{\"maxlimit\":\"\"},\"walletes\":{\"maxlimit\":\"\"},\"zarin\":{\"maxlimit\":\"\"}}'),
(351, 'config', 'contactusphone', '9999999999'),
(352, 'config', 'contactusaddress', '401, Alien street, Red Planet. 444123.'),
(353, 'config', 'locationlatitude', '40.712776'),
(354, 'config', 'locationlongitude', '-74.005974'),
(355, 'config', 'maintenancebacktime', '1593250258'),
(356, 'config', 'config_is_under_maintanance', '0'),
(357, 'config', 'maintenancetime', ''),
(358, 'config', 'securityemails', '0'),
(359, 'config', 'lock_first_name', 'firstname'),
(360, 'config', 'lock_last_name', 'lastname'),
(361, 'config', 'invoiceprefix', ''),
(362, 'config', 'invoiceincrement', '1'),
(363, 'config', 'can_change_invoice_gateway', '1'),
(364, 'config', 'contactby', '0'),
(365, 'config', 'contactusdisplayemail', 'contactus@yoursite.com'),
(366, 'config', 'contactusemail', ''),
(367, 'config', 'slack_test', ''),
(368, 'config', 'slack_adminloginfailed', ''),
(369, 'config', 'slack_suspiousaccess', ''),
(370, 'config', 'slack_ordernotification', '1275637135'),
(371, 'config', 'slack_serverordernotification', ''),
(372, 'config', 'slack_shopordernotification', ''),
(373, 'config', 'slack_adminaddcredit', ''),
(374, 'config', 'slack_newusersignup', ''),
(375, 'config', 'slack_invoicepaid', ''),
(376, 'config', 'slack_manualinvoicepaid', ''),
(377, 'config', 'slack_fraudinvoice', ''),
(378, 'config', 'slack_directinvoicestatus', ''),
(379, 'config', 'slack_apilowcredit', ''),
(380, 'config', 'slack_notenoughkey', ''),
(381, 'config', 'slack_idverification', ''),
(382, 'config', 'slack_fundtransfer', '799273847'),
(383, 'config', 'slack_servicestat', 'tdhru'),
(384, 'config', 'slack_pricechange', 'tdhru'),
(385, 'config', 'backup_users', '1'),
(386, 'config', 'backup_service', '1'),
(387, 'config', 'backup_config', '1'),
(388, 'config', 'backup_order', '1'),
(389, 'config', 'backup_email', '1'),
(390, 'config', 'backupmailto', ''),
(391, 'config', 'cloudflarezoneid', ''),
(392, 'config', 'cloudflareemail', ''),
(393, 'config', 'cloudflareapikey', '');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_country_language`
--

CREATE TABLE `tbl_country_language` (
  `country_id` varchar(3) NOT NULL,
  `language` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_currencies`
--

CREATE TABLE `tbl_currencies` (
  `id` int(10) NOT NULL,
  `code` mediumtext NOT NULL,
  `prefix` varchar(20) NOT NULL,
  `suffix` mediumtext NOT NULL,
  `format` int(1) NOT NULL DEFAULT 0,
  `rate` decimal(15,5) NOT NULL DEFAULT 1.00000,
  `default` int(1) NOT NULL DEFAULT 0,
  `client` int(1) NOT NULL,
  `dontupdate` tinyint(1) DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `tbl_currencies`
--

INSERT INTO `tbl_currencies` (`id`, `code`, `prefix`, `suffix`, `format`, `rate`, `default`, `client`, `dontupdate`) VALUES
(1, 'USD', '$', '', 2, '1.00000', 1, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_customfieldconfig`
--

CREATE TABLE `tbl_customfieldconfig` (
  `cid` int(11) NOT NULL DEFAULT 0,
  `currency_id` int(11) NOT NULL DEFAULT 0,
  `credit` mediumtext NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_customfields`
--

CREATE TABLE `tbl_customfields` (
  `id` int(10) NOT NULL,
  `type` mediumtext NOT NULL,
  `relid` int(10) NOT NULL DEFAULT 0,
  `fieldname` mediumtext NOT NULL,
  `fieldtype` mediumtext NOT NULL,
  `description` mediumtext NOT NULL,
  `fieldoptions` mediumtext NOT NULL,
  `regexpr` mediumtext NOT NULL,
  `adminonly` mediumtext NOT NULL,
  `required` mediumtext NOT NULL,
  `showorder` mediumtext NOT NULL,
  `sortorder` int(10) NOT NULL DEFAULT 0,
  `enc` mediumtext NOT NULL,
  `fieldother` text DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_customfieldsvalues`
--

CREATE TABLE `tbl_customfieldsvalues` (
  `fieldid` int(10) NOT NULL,
  `relid` int(10) NOT NULL,
  `value` mediumtext NOT NULL,
  `fieldname` varchar(50) DEFAULT NULL,
  `servicetype` varchar(12) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_customgatewayprice`
--

CREATE TABLE `tbl_customgatewayprice` (
  `id` int(11) NOT NULL,
  `weight` double NOT NULL,
  `gid` int(11) NOT NULL DEFAULT 0,
  `currency_id` int(11) NOT NULL DEFAULT 0,
  `credit` decimal(25,2) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_custom_page`
--

CREATE TABLE `tbl_custom_page` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `content` longtext NOT NULL,
  `login` int(1) NOT NULL DEFAULT 0,
  `show_top` int(1) NOT NULL DEFAULT 0,
  `page_name` varchar(255) NOT NULL,
  `language` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `tbl_custom_page`
--

INSERT INTO `tbl_custom_page` (`id`, `title`, `type`, `content`, `login`, `show_top`, `page_name`, `language`) VALUES
(4, 'Index Page', 'index', '&lt;div class=&quot;row&quot;&gt;\r\n&lt;div class=&quot;col card mw-320  wow bounceIn&quot;&gt;\r\n&lt;div class=&quot;text-center &quot;&gt;&lt;i class=&quot;fal fa-life-ring big-icon&quot;&gt;&lt;/i&gt;\r\n&lt;h2 class=&quot;m-2&quot;&gt;24 Hours Support&lt;/h2&gt;\r\n&lt;p&gt;Support 24 hours / 7 days-a-week. {$companyname} operates a 24 hour/7 day-a-week email &amp;amp; remote support services that is staffed to handle any issue or question for the systems that we develop or support. Handled directly by our knowledgeable staff ensuring a quick and accurate response&lt;/p&gt;\r\n&lt;/div&gt;\r\n&lt;/div&gt;\r\n&lt;div class=&quot;col card mw-320  wow bounceIn&quot;&gt;\r\n&lt;div class=&quot;rounded-20 text-center highlighted h-100&quot;&gt;&lt;i class=&quot;fal fa-tags big-icon&quot;&gt;&lt;/i&gt;\r\n&lt;h2 class=&quot;m-2&quot;&gt;Attractive Prices&lt;/h2&gt;\r\n&lt;p&gt;If you find a cheaper price from our competitors but you still want to use {$companyname} services, please feel free to contact us. all our advertised prices can be negotoated and we can always beat the competition&lt;/p&gt;\r\n&lt;/div&gt;\r\n&lt;/div&gt;\r\n&lt;div class=&quot;col  card mw-320  wow bounceIn&quot;&gt;\r\n&lt;div class=&quot;text-center &quot;&gt;&lt;i class=&quot;fal fa-info big-icon&quot;&gt;&lt;/i&gt;\r\n&lt;h2 class=&quot;m-2&quot;&gt;Simple Instruction&lt;/h2&gt;\r\n&lt;p&gt;Our instructions are easy to follow and only require that you can enter the unlocking code using your keypad. if you can dial a telephone number, then you can enter the code!&lt;/p&gt;\r\n&lt;/div&gt;\r\n&lt;/div&gt;\r\n&lt;div class=&quot;m-0 row&quot;&gt;\r\n&lt;div class=&quot;col card mw-320  wow bounceIn&quot;&gt;\r\n&lt;div class=&quot;rounded-20 text-center highlighted h-100&quot;&gt;&lt;i class=&quot;fal fa-lock big-icon&quot;&gt;&lt;/i&gt;\r\n&lt;h2 class=&quot;m-2&quot;&gt;Absolutely Safe&lt;/h2&gt;\r\n&lt;p&gt;Completely safe, with no risk to your phone or hardware. No software downloads are required. Alongside opening, your money are completely secure as well. &amp;nbsp; &amp;nbsp;&lt;/p&gt;\r\n&lt;/div&gt;\r\n&lt;/div&gt;\r\n&lt;div class=&quot;col card mw-320  wow bounceIn&quot;&gt;\r\n&lt;div class=&quot;text-center &quot;&gt;&lt;i class=&quot;fal fa-dollar-sign big-icon&quot;&gt;&lt;/i&gt;\r\n&lt;h2 class=&quot;m-2&quot;&gt;Money Back Guarantee&lt;/h2&gt;\r\n&lt;p&gt;All of the services on our websites are covered by our&amp;nbsp;100% Money Back Guarantee. We provide such a guarantee to give honest customers the reassurance that the opening service&amp;nbsp;they are ordering will be delivered in good faith.&lt;/p&gt;\r\n&lt;/div&gt;\r\n&lt;/div&gt;\r\n&lt;div class=&quot;col card mw-320  wow bounceIn&quot;&gt;\r\n&lt;div class=&quot;rounded-20 text-center highlighted h-100&quot;&gt;&lt;i class=&quot;fal fa-envelope big-icon&quot;&gt;&lt;/i&gt;\r\n&lt;h2 class=&quot;m-2&quot;&gt;Expeditious Delivery&lt;/h2&gt;\r\n&lt;p&gt;All open codes and open confirmations are sent by e-mail to the e-mail address that the customer provides on the order form. We make sure the delivery of opening codes is time-efficient.&amp;nbsp;If delayed, we\'ll&amp;nbsp;inform our clients / resellers via e-mail.&lt;/p&gt;\r\n&lt;/div&gt;\r\n&lt;/div&gt;\r\n&lt;/div&gt;\r\n&lt;/div&gt;', 1, 1, '', 'English'),
(5, 'terms&amp;condition', 'terms', '<p><strong>terms and condition of using gsmbackbase</strong></p>', 0, 0, 'terms &amp; conditions', ''),
(6, 'Contact Us', 'contact', '', 0, 0, '', '');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_dhrucredit_history`
--

CREATE TABLE `tbl_dhrucredit_history` (
  `historyid` int(20) NOT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `response` text DEFAULT NULL,
  `credit` varchar(10) DEFAULT NULL,
  `status` varchar(10) DEFAULT NULL,
  `date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_disabledemail`
--

CREATE TABLE `tbl_disabledemail` (
  `id` int(11) NOT NULL,
  `uid` int(11) NOT NULL DEFAULT 0,
  `tid` int(11) NOT NULL DEFAULT 0,
  `mailtype` varchar(20) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_discount_file`
--

CREATE TABLE `tbl_discount_file` (
  `user_id` int(11) NOT NULL DEFAULT 0,
  `service_id` int(11) NOT NULL DEFAULT 0,
  `discount` decimal(20,3) DEFAULT NULL,
  `price` decimal(20,3) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_discount_imei`
--

CREATE TABLE `tbl_discount_imei` (
  `user_id` int(11) NOT NULL DEFAULT 0,
  `service_id` int(11) NOT NULL DEFAULT 0,
  `discount` decimal(20,3) DEFAULT 0.000,
  `price` decimal(20,3) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_discount_product`
--

CREATE TABLE `tbl_discount_product` (
  `user_id` int(5) NOT NULL,
  `service_id` int(5) NOT NULL,
  `discount` decimal(20,2) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_discount_server_log`
--

CREATE TABLE `tbl_discount_server_log` (
  `user_id` int(11) NOT NULL DEFAULT 0,
  `service_id` int(11) NOT NULL DEFAULT 0,
  `discount` decimal(20,2) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_document`
--

CREATE TABLE `tbl_document` (
  `id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `contact` varchar(20) NOT NULL,
  `city` varchar(50) NOT NULL,
  `state` varchar(25) NOT NULL,
  `pin` varchar(25) NOT NULL,
  `doctype` varchar(20) NOT NULL,
  `document` varchar(150) NOT NULL,
  `notes` varchar(255) NOT NULL,
  `other` varchar(255) NOT NULL,
  `country` varchar(50) NOT NULL,
  `status` int(1) NOT NULL,
  `reason` varchar(250) NOT NULL,
  `lastupdate` varchar(25) NOT NULL,
  `statement` varchar(200) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_download`
--

CREATE TABLE `tbl_download` (
  `id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL DEFAULT 0,
  `filename` varchar(555) NOT NULL,
  `external` varchar(555) NOT NULL,
  `file` mediumtext NOT NULL,
  `description` mediumtext NOT NULL,
  `reqlogin` int(1) NOT NULL DEFAULT 0,
  `forproduct` int(1) NOT NULL DEFAULT 0,
  `donotshow` int(1) NOT NULL DEFAULT 0,
  `counter` int(11) NOT NULL DEFAULT 0,
  `size` varchar(555) NOT NULL,
  `date` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_downloadcat`
--

CREATE TABLE `tbl_downloadcat` (
  `id` int(11) NOT NULL,
  `category` varchar(255) NOT NULL,
  `info` mediumtext NOT NULL,
  `mid` int(11) NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_download_log`
--

CREATE TABLE `tbl_download_log` (
  `id` int(11) NOT NULL,
  `ip` varchar(50) NOT NULL,
  `username` varchar(255) NOT NULL,
  `time` varchar(50) NOT NULL,
  `did` int(11) NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_emailtemplates`
--

CREATE TABLE `tbl_emailtemplates` (
  `id` int(10) NOT NULL,
  `type` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `name` varchar(555) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `subject` blob NOT NULL,
  `message` blob NOT NULL,
  `fromname` mediumtext CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `fromemail` mediumtext CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `disabled` mediumtext CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `custom` mediumtext CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `language` mediumtext CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `copyto` mediumtext CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `plaintext` int(1) NOT NULL DEFAULT 0,
  `for_reseller` int(1) NOT NULL DEFAULT 0,
  `template_variable` mediumtext CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `newsletter_default` int(1) NOT NULL DEFAULT 0,
  `scheduled` int(1) NOT NULL DEFAULT 0,
  `mailserv` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `layoutid` int(11) NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Dumping data for table `tbl_emailtemplates`
--

INSERT INTO `tbl_emailtemplates` (`id`, `type`, `name`, `subject`, `message`, `fromname`, `fromemail`, `disabled`, `custom`, `language`, `copyto`, `plaintext`, `for_reseller`, `template_variable`, `newsletter_default`, `scheduled`, `mailserv`, `layoutid`) VALUES
(1, 'general', 'Registration Confirmation (Manual)', 0x7b24636f6d70616e796e616d657d204163636f756e7420526567697374726174696f6e, 0x3c703e2044656172207b24757365726e616d657d3c2f703e0d0a3c703e3c2f703e0d0a3c703e5468616e6b20796f7520666f7220796f757220696e74657265737420696e207b24636f6d70616e796e616d657d2e3c2f703e0d0a3c703e3c2f703e0d0a3c703e496e206f7264657220746f20636f6d706c6574652061637469766174696f6e206f6e20796f7572206163636f756e74206120726570726573656e7461746976652077696c6c20636f6e7461637420796f752073686f72746c7920746f2061646a75737420796f7572206163636f756e74206163636f7264696e676c792e3c2f703e0d0a3c703e496620796f75207769736820746f20636f6d706c6574652061637469766174696f6e20736f6f6e657220796f75206d61792073656e6420757320616e20656d61696c20746f207b2461646d696e6d61696c7d20287375626a656374207469746c65203a204143544956415445204143434f554e54292e3c2f703e0d0a3c703e496e2074686520656d61696c20706c656173652070726f7669646520796f757220557365726e616d6520616e642077652077696c6c20636f6d706c657465207468652070726f6365737320666f7220796f7520736f20796f752063616e207374617274206f72646572696e6720696d6d6564696174656c792e3c2f703e0d0a3c703e3c2f703e0d0a3c703e7b2461646d696e7369676e61747572657d3c2f703e, '', '', '0', '', '', '', 0, 1, '', 0, 0, '', 0),
(2, 'general', 'Registration Confirmation (Automatic)', 0x7b24636f6d70616e796e616d657d204163636f756e7420526567697374726174696f6e, 0x3c703e44656172207b24757365726e616d657d3c2f703e0d0a3c703e5468616e6b20796f7520666f7220796f757220696e74657265737420696e207b24636f6d70616e796e616d657d2e3c2f703e0d0a3c703e496e206f7264657220746f20636f6e74696e7565207265676973746572696e6720796f75722064657461696c732c20706c6561736520636c69636b2074686520666f6c6c6f77696e67206c696e6b3a203d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3c2f703e0d0a3c703e7b246c696e6b7d3c2f703e0d0a3c703e3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3c2f703e0d0a3c703e496620796f7520646964206e6f7420726567697374657220666f72207468697320736572766963652e2e2e3c2f703e0d0a3c703e5468697320656d61696c20686173206265656e2073656e7420746f20796f7520626563617573652061207b24636f6d70616e796e616d657d206163636f756e7420686173206265656e2063726561746564207573696e67207468697320656d61696c20616464726573732e20496620796f7520646964206e6f7420726567697374657220666f72207468697320736572766963652c20706c6561736520636f6e7461637420437573746f6d657220537570706f72742061742074686520666f6c6c6f77696e6720616464726573733a207b2461646d696e6d61696c7d205765206c6f6f6b20666f727761726420746f20736565696e6720796f7520696e2074686520776f726c64206f66207b24636f6d70616e796e616d657d3c2f703e0d0a3c703e7b2461646d696e7369676e61747572657d3c2f703e, '', '', '0', '', '', '', 0, 1, '{$link}-Account activation link', 0, 0, '', 1),
(3, 'general', 'Password Reset Request', 0x7b24636f6d70616e796e616d657d202d2052657365742050617373776f7264, 0x20202020200d0a44656172207b24757365726e616d657d20200d0a0d0a536f6d656f6e6520686173207265717565737465642074686174207468652070617373776f726420666f7220796f7572206163636f756e742c2062652072657365742e0d0a0d0a496620796f7520646964206e6f74206d616b65207468697320726571756573742c20706c656173652073696d706c7920646973726567617264207468697320652d6d61696c2e0d0a0d0a49742069732073656e74206f6e6c7920746f207468652061646472657373206f6e2066696c6520666f7220796f7572206163636f756e7420616e642077696c6c206265636f6d6520696e76616c696420616674657220343820686f7572732c20736f20796f7520646f206e6f74206861766520746f20776f7272792061626f757420796f7572206163636f756e74206265696e672074616b656e206f7665722e20200d0a0d0a506c6561736520676f20746f2074686520666f6c6c6f77696e672055524c20203a20200d0a3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d0d0a0d0a7b246c696e6b7d200d0a0d0a3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d0d0a0d0a0d0a7b2461646d696e7369676e61747572657d202020, '', '', '0', '', '', '', 1, 1, '{$link}-Password Reset link', 0, 0, '', 4),
(4, 'general', 'Successful Password Change Confirmation', 0x7b24636f6d70616e796e616d657d202d2050617373776f7264206368616e6765, 0x3c703e44656172207b24757365726e616d657d3c2f703e0d0a3c703e3c2f703e0d0a3c703e596f75722070617373776f726420666f72206f7572206c6f6720696e2073797374656d20686173206265656e207375636365737366756c6c79206368616e6765642e3c2f703e0d0a3c703e546865206e65772070617373776f7264206973206e6f74207072696e746564206865726520746f2070726f7465637420796f7572207072697661637920616e6420796f75722075736572206e616d6520697320636f6e6669726d65642062656c6f772e3c2f703e0d0a3c70207374796c653d2270616464696e672d6c6566743a20363070783b223e3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3c2f703e0d0a3c70207374796c653d2270616464696e672d6c6566743a20363070783b223e557365726e616d65203a207b24757365726e616d657d3c2f703e0d0a3c70207374796c653d2270616464696e672d6c6566743a20363070783b223e50617373776f7264203a202a2a2a48494444454e2a2a2a3c2f703e0d0a3c70207374796c653d2270616464696e672d6c6566743a20363070783b223e3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3c2f703e0d0a3c703e496620796f752068617665206e6f74207265717565737465642074686973206368616e67652c20796f7572206163636f756e74206d6f7374206c696b656c792068617320616c7265616479206265656e20636f6d70726f6d697365642e20596f752073686f756c6420696d6d6564696174656c7920636f6e746163742075732e3c2f703e0d0a3c703e3c2f703e0d0a3c703e7b2461646d696e7369676e61747572657d3c2f703e, '', '', '0', '', '', '', 0, 1, '', 0, 0, '', 0),
(5, 'general', 'Account block notice', 0x596f7572206163636f756e7420686173206265656e20626c6f636b6564, 0x20200d0a596f7572206163636f756e7420686173206265656e20626c6f636b65642064756520746f200d0a0d0a3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d0d0a0d0a7b24626c6f636b7265736f6e7d0d0a0d0a3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d0d0a0d0a7b2461646d696e7369676e61747572657d20, '', '', '', '', '', '', 1, 1, '{$blockreson}-Account block Reason', 0, 0, '', 0),
(6, 'imeiorder', 'IMEI Order Cancelled ', 0x4f726465722050726f63657373696e67204661696c757265, 0x20202020200d0a44656172207b24757365726e616d657d0d0a0d0a596f7572206f7264657220666f72207b24736572766963657d202d207b24696d65697d206861732070726f63657373696e67206661696c757265202e0d0a526561736f6e20203a20207b24726561736f6e7d20200d0a0d0a0d0a0d0a7b2461646d696e7369676e61747572657d202020, '', '', '0', '', '', '', 1, 1, '{$service}- Service name,\r\n{$imei}- IMEI,\r\n{$reason}- Order Cancel Reason', 0, 0, '', 0),
(7, 'general', 'Successful Security Question Confirmation ', 0x7b24636f6d70616e796e616d657d202d205365637572697479205175657374696f6e204368616e6765, 0x202020200d0a44656172207b24757365726e616d657d0d0a0d0a596f7572207365637572697479207175657374696f6e20666f72206f7572206c6f6720696e2073797374656d20686173206265656e207375636365737366756c6c79206368616e6765642e0d0a546865206e65772070617373776f7264206973206e6f74207072696e746564206865726520746f2070726f7465637420796f7572207072697661637920616e6420796f75722075736572206e616d6520697320636f6e6669726d65642062656c6f772e0d0a0d0a3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d0d0a0d0a557365726e616d65203a207b24757365726e616d657d0d0a50617373776f726420203a202a2a2a48494444454e2a2a2a0d0a0d0a3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d0d0a0d0a0d0a496620796f752068617665206e6f74207265717565737465642074686973206368616e67652c20796f7572206163636f756e74206d6f7374206c696b656c792068617320616c7265616479206265656e20636f6d70726f6d697365642e2020596f752073686f756c6420696d6d6564696174656c7920636f6e746163742075732e0d0a0d0a0d0a7b2461646d696e7369676e61747572657d202020, '', '', '', '', '', '', 1, 1, '', 0, 0, '', 0),
(8, 'general', 'Account balance Created / Debited Conformation', 0x596f7572204163636f756e742062616c616e63652075706461746564, 0x202020202020202020202020200d0a44656172207b24757365726e616d657d0d0a0d0a5468616e6b20796f7520666f722066756e64696e6720796f7572207b24636f6d70616e796e616d657d20206163636f756e74202e0d0a0d0a3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d0d0a7b696620202463726564697461646465647d43726564697420416464656420696e20596f7572204163636f756e74203a207b2463726564697461646465647d200d0a3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d0d0a7b2f69667d200d0a7b6966202024637265646974726562617465647d43726564697420526562617465642046726f6d20596f7572204163636f756e74203a207b24637265646974726562617465647d0d0a3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d0d0a7b2f69667d0d0a7b696620202473656c6c63726564697461646465647d2053656c6c2043726564697420416464656420696e20596f7572204163636f756e74203a207b2473656c6c63726564697461646465647d0d0a3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d0d0a7b2f69667d0d0a7b696620202473656c6c637265646974726562617465647d2053656c6c2043726564697420526562617465642046726f6d20596f7572204163636f756e74203a207b2473656c6c637265646974726562617465647d0d0a3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d0d0a7b2f69667d0d0a0d0a4163636f756e742062616c616e63652061667465722046756e64696e67203a207b246372656469742e6372656469747d0d0a7b6966202473656c6c6372656469746164646564206f72202473656c6c637265646974726562617465647d20546f74616c20417661696c61626c652053656c6c20437265646974203a207b246372656469742e73656c6c696e675f6c696d69747d20207b2f69667d0d0a0d0a3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d0d0a7b24757365726e6f74657d0d0a5472616e73616374696f6e204944207b247472616e73616374696f6e69647d0d0a0d0a0d0a7b2461646d696e7369676e61747572657d20202020202020202020, '', '', '0', '', '', '', 1, 1, '{$creditadded}-Added new credit,\r\n{$sellcreditadded}- Added new sell credit,\r\n{$creditrebated}-Rebated Credit,\r\n{$sellcreditrebated}-Rebated Sell credit,\r\n{$credit.selling_limit}-Sell Credit Limit ', 0, 0, '', 0),
(9, 'general', 'Welcome Email', 0x57656c636f6d6520746f207b24636f6d70616e796e616d657d, 0x20200d0a44656172207b24757365726e616d657d0d0a0d0a5468616e6b20796f7520666f72207369676e696e6720757020666f722061207b24636f6d70616e796e616d657d206163636f756e742e0d0a0d0a596f752077696c6c2066696e64206120636f7079206f6620796f757220726567697374726174696f6e2064657461696c732062656c6f7720616e642061206c696e6b20746f20746865207465726d73207768696368206170706c7920746f20796f757220726567697374726174696f6e2e20506c65617365207072696e74207468657365206f666620616e64206b65657020696e2061207361666520706c61636520666f7220667574757265207265666572656e63652e0d0a0d0a3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d0d0a526567697374726174696f6e2064657461696c732028706c65617365206b6565702073616665290d0a557365726e616d65203a207b24757365726e616d657d0d0a50617373776f72642020203a207b6966202470617373776f72645f756e63727970747d207b2470617373776f72645f756e63727970747d207b656c73657d202a2a48494444454e2a2a207b2f69667d202020202020200d0a4d61737465722050696e20203a207b2470696e7d0d0a3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d0d0a0d0a596f752077696c6c206e65656420746f20656e74657220796f757220557365726e616d6520616e642050617373776f7264207768656e6576657220796f752075736520796f7572207b24636f6d70616e796e616d657d206163636f756e742e0d0a0d0a546f20726576696577206f722075706461746520796f757220726567697374726174696f6e2064657461696c732c207369676e20696e20746f20796f7572207b24636f6d70616e796e616d657d206163636f756e74206f6e2061207b2473697465616464726573737d202e0d0a0d0a7b2461646d696e7369676e61747572657d202020202020202020, '', '', '0', '', '', '', 1, 1, '{$password_uncrypt}- Unencrypted Password', 0, 0, '', 0),
(10, 'general', 'Password Reset by Admin', 0x7b24636f6d70616e796e616d657d202d20596f75722061636365737320696e666f726d6174696f6e, 0x3c703e44656172207b24757365726e616d657d3c2f703e0d0a3c703e203c2f703e0d0a3c703e203c2f703e0d0a3c703e596f7520686176652072657175657374656420796f75722070617373776f72642e3c2f703e0d0a3c703e203c2f703e0d0a3c703e3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3c2f703e0d0a3c703e596f7572206c6f67696e20646174612069733a3c2f703e0d0a3c703e596f7572204e65772050617373776f7264206973203a207b2470617373776f72647d3c2f703e0d0a3c703e3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3c2f703e0d0a3c703e7b2461646d696e7369676e61747572657d3c2f703e, '', '', '0', '', '', '', 0, 1, '{$password}-User Password', 0, 0, '', 0),
(11, 'general', 'API Access Details', 0x7b24636f6d70616e796e616d657d202d204150692061636365737320696e666f726d6174696f6e, 0x3c703e44656172207b24757365726e616d657d3c2f703e0d0a3c703e5468652072656d6f74652041504920616c6c6f777320796f7520746f207265717565737420636f6465732c20676574206163636f756e7420696e666f726d6174696f6e20616e6420636865636b2074686520737461747573206f6620796f7572206f726465727320776974686f757420686176696e6720746865206e65656420746f206c6f67696e20746f20746865206f757220736974652e3c2f703e0d0a3c703e5468697320616c6c6f777320796f7520746f20696e7465677261746520796f7572206f776e20736974652077697468206f7572732e3c2f703e0d0a3c703e57652068617665206d616465206f75722072656d6f74652041504920696e746572666163652072656c61746976656c792073696d706c7920746f2075736520736f20616e796f6e65207769746820616e792061206c6974746c6520584d4c20616e642050485020657870657269656e63652073686f756c642062652061626c6520746f20696d706c656d656e7420616e6420646576656c6f7020612073797374656d20746f20757365206f6e20746865697220736974652e3c2f703e0d0a3c703e596f752063616e20616c736f20446f776e6c6f61642041706920646f63756d656e74203a207b2473697465616464726573737d6170692e7a69703c2f703e0d0a3c703e3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3c2f703e0d0a3c703e596f75722041504920416363657373204b6579203a207b246170696163636573736b65797d3c2f703e0d0a3c703e3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3c2f703e0d0a3c703e7b2461646d696e7369676e61747572657d3c2f703e, '', '', '0', '', '', '', 0, 0, '{$apiaccesskey} - API Access Key', 0, 0, '', 0),
(14, 'imeiorder', 'IMEI Order success notification', 0x596f757220756e6c6f636b20636f6465, 0x202020202020202020200d0a44656172207b24757365726e616d657d0d0a0d0a596f757220756e6c6f636b20636f646520666f7220796f7572206d6f62696c652070686f6e6520494d4549203a207b24696d65697d20686173207375636365737366756c6c79206265656e2063616c63756c617465642e0d0a7b6966202024636f6d6d656e74737d2a2a207b24636f6d6d656e74737d7b2f69667d0d0a0d0a3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d0d0a556e6c6f636b20636f6465203a20207b247265706c797d0d0a3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d0d0a4f72646572732064657461696c730d0a4f72646572204944203a207b246f7264657269647d0d0a53657276696365204e616d65203a207b24736572766963657d0d0a437265646974203a207b246f726465726372656469747d0d0a7b696620246d6f64656c7d204d6f64656c203a207b246d6f64656c7d7b2f69667d0d0a7b6966202470726f76696465727d50726f7669646572203a207b2470726f76696465727d7b2f69667d0d0a7b696620246d65707d4d4550203a207b246d65707d7b2f69667d0d0a7b6966202470696e7d50494e20203a207b2470696e7d7b2f69667d0d0a7b696620246b62687d4b4248203a207b246b62687d7b2f69667d0d0a7b696620247072647d505244203a207b247072647d7b2f69667d0d0a7b69662024747970657d54797065203a207b24747970657d7b2f69667d0d0a7b696620247265666572656e63657d5265666572656e636520203a20207b247265666572656e63657d7b2f69667d0d0a7b696620246c6f636b737d4c6f636b7320203a20207b246c6f636b737d7b2f69667d0d0a7b666f72656163682066726f6d3d24637573746f6d206b65793d6964206974656d3d6373747d0d0a7b696620246373742e76616c75657d7b246373742e6e616d657d203a207b246373742e76616c75657d7b2f69667d0d0a7b2f666f72656163687d0d0a0d0a3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d0d0a0d0a0d0a0d0a7b2461646d696e7369676e61747572657d20202020, '', '', '0', '', '', '', 1, 1, '{$orderid}- Order ID , {$imei} - IMEI No, {$note} - Notes , {$comments} - Comments , {$ordercredit} - Credit For Order , {$model} - Model Name , {$provider} - Provider Name , {$mep} - MEP , {$pin} - PIN Number , {$kbh} - KBH , {$prd} - PRD , {$type}- Type ,{$reference} - Reference , {$locks} - Locks ,{$comments}- User Comments,\n{$reply}- Admin Reply', 0, 0, '', 0),
(15, 'general', 'orders send to supplier', 0x7b24636f6d70616e796e616d657d202d204e6577206f7264657273, 0x3c703e596f7520676f74206e6577206f72646572732066726f6d207b24636f6d70616e796e616d657d3c2f703e0d0a3c703e4f72646572732066696c6520686173206265656e2061747461636865642062656c6f77202e3c2f703e0d0a3c703e7b246f726465726c6973747d3c2f703e0d0a3c703e3c6272202f3e7b2461646d696e7369676e61747572657d3c2f703e, '', '', '0', '', '', '', 0, 0, '', 0, 0, '', 0),
(16, 'fileorder', 'File Order success', 0x4f726465722063616c63756c61746564207375636365737366756c6c79, 0x202020202020202020202020202020200d0a44656172207b24757365726e616d657d0d0a0d0a596f7572206f7264657220666f72207b24736572766963657d20686173207375636365737366756c6c79206265656e2063616c63756c617465642e0d0a7b6966202024636f6d6d656e74737d2a2a207b24636f6d6d656e74737d7b2f69667d0d0a0d0a3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d0d0a7b696620247265706c797d20436f6465203a20207b247265706c797d20202020207b656c73657d20596f75722066696c652069732061747461636865642068657265202e207b2f69667d2020200d0a3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d0d0a0d0a4f72646572732064657461696c730d0a53657276696365203a207b24736572766963657d0d0a437265646974203a207b246f726465726372656469747d0d0a7b666f72656163682066726f6d3d24637573746f6d206b65793d6964206974656d3d6373747d0d0a7b696620246373742e76616c75657d7b246373742e6e616d657d203a207b246373742e76616c75657d7b2f69667d0d0a7b2f666f72656163687d0d0a0d0a3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d0d0a0d0a0d0a0d0a7b2461646d696e7369676e61747572657d2020202020202020, '', '', '0', '', '', '', 1, 1, '{$service}- Service Name, {$ordercredit} - Credit of Order,{$notes} - Notes , {$comments} - Comments', 0, 1, '', 0),
(17, 'serverorder', 'Server Order successfull', 0x4f726465722063616c63756c61746564207375636365737366756c6c79, 0x2020202020202020202020200a44656172207b24757365726e616d657d0a0a596f7572206f7264657220666f72207b24736572766963657d20686173207375636365737366756c6c79206265656e2063616c63756c617465642e0a7b6966202024636f6d6d656e74737d2a2a207b24636f6d6d656e74737d7b2f69667d0a0a3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d0a7b247265706c797d0a3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d0a4f72646572732064657461696c730a5365727669636520203a207b24736572766963657d0a437265646974203a207b246f726465726372656469747d0a7b666f72656163682066726f6d3d24637573746f6d206b65793d6964206974656d3d6373747d0a7b246373742e6e616d657d203a20207b246373742e76616c75657d0a7b2f666f72656163687d200a0a3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d0a0a0a0a7b24666565646261636b6c696e6b7d0a0a0a7b2461646d696e7369676e61747572657d2020202020, '', '', '0', '', '', '', 1, 1, '{$service}- Service Name, {$ordercredit} - Credit of Order,{$notes} - Notes , {$comments} - Comments,\r\n{$feedbacklink}-Order feedback link', 0, 0, '', 0),
(31, 'invoice', 'invoice generated', 0x496e766f69636520237b24696e766f69636569647d, 0x44656172207b24757365726e616d657d0d0a0d0a546869732069732061206e6f74696365207468617420616e20696e766f69636520237b24696e766f69636569647d20686173206265656e2067656e6572617465642e0d0a0d0a0d0a0d0a7b2461646d696e7369676e61747572657d, '', '', '', '', '', '', 1, 1, '{$invoiceid}- Invoice Number', 0, 0, '', 0),
(30, 'invoice', 'Payment received confirmation', 0x5061796d656e7420726563656976656420636f6e6669726d6174696f6e, 0x44656172207b24757365726e616d657d20200d0a0d0a0d0a5061796d656e7420726563656976656420636f6e6669726d6174696f6e202e0d0a5468616e6b20796f7520666f72207061796d656e74202e0d0a496e766f696365203a207b24696e766f6963657d0d0a416d6f756e7420203a207b247061796d656e747d0d0a0d0a0d0a0d0a0d0a7b2461646d696e7369676e61747572657d20202020, '', '', '0', '', '', '', 1, 1, '', 0, 0, '', 0),
(46, 'newsletter', 'Monthly News Letter ', 0x4d6f6e74686c79204e657773204c657474657220, 0x4e65772053657276696365730d0a0d0a507269636520446f776e0d0a0d0a4f666665727320, '', '', '0', '', '', '', 1, 0, '', 0, 0, '', 0),
(38, 'invoice', 'First Notification for Unpaid Invoice', 0x466972737420496e766f696365204f766572647565204e6f74696365, 0x44656172207b24757365727d0d0a0d0a20202020202020202020205468697320697320612062696c6c696e67206e6f74696365207468617420796f757220696e766f696365206e6f2e207b24696e7669647d206973206e6f77206f7665726475652e0d0a0d0a0d0a7b2461646d696e7369676e61747572657d2020, '', '', '', '', '', '', 1, 1, '{$invid}-Invoice ID', 0, 0, '', 0),
(39, 'invoice', 'Second Notification for Unpaid Invoice', 0x5365636f6e6420496e766f696365204f766572647565204e6f74696365, 0x2044656172207b24757365727d0d0a0d0a20202020202020202020205468697320697320746865207365636f6e642062696c6c696e67206e6f74696365207468617420796f757220696e766f6963652023207b24696e7669647d206973206e6f77206f7665726475652e0d0a0d0a0d0a7b2461646d696e7369676e61747572657d202020, '', '', '', '', '', '', 1, 1, '{$invid}-Invoice Number', 0, 0, '', 0),
(40, 'invoice', 'Third Notification for Unpaid Invoice', 0x546869726420496e766f696365204f766572647565204e6f74696365, 0x44656172207b24757365727d0d0a0d0a2020202020202020202020546869732069732074686520746869726420616e642066696e616c2062696c6c696e67206e6f74696365207468617420796f757220696e766f6963652023207b24696e7669647d206973206e6f77206f7665726475652e200d0a0d0a0d0a7b2461646d696e7369676e61747572657d2020202020, '', '', '0', '', '', '', 1, 1, '{$invid}-Invoice Number', 0, 0, '', 0),
(41, 'general', 'We are Missing', 0x7b24636f6d70616e796e616d657d204d697373696e6720796f75, 0x20202020200d0a44656172207b24757365726e616d657d0d0a0d0a202020202020202046726f6d206c617374206c6f6e672074696d6520796f7520617265206e6f7420617070656172206f6e206f75722073697465202c2063616e20692068656c7020796f752077697468207072696365206f7220616e79206d6174746572203f0d0a0d0a7b2461646d696e7369676e61747572657d2020, '', '', '0', '', '', '', 1, 1, '', 0, 0, '', 0),
(42, 'general', 'Low credit limit', 0x555247454e543a204c6f772062616c616e636520696e20796f7572204163636f756e7420, 0x202020200d0a44656172207b24757365726e616d657d0d0a0d0a5468697320697320746f206e6f7469667920796f7520746861742046756e647320756e64657220796f757220526573656c6c6572206163636f756e7420686176652064726f707065642062656c6f7720796f7572207468726573686f6c64206c6576656c206f662055534420313020596f7520617265206164766973656420746f20696d6d6564696174656c792072656d69742066756e647320736f207468617420796f757220437573746f6d6572732f5375622d526573656c6c65727320616e6420796f752063616e20636f6e74696e756520746f20706c616365204f72646572732e20506c6561736520666f6c6c6f77207468652070726f636573732062656c6f7720666f7220616464696e672066756e647320746f20796f7572206163636f756e742e0d0a0d0a312e204c6f67696e20746f203a207b2473697465616464726573737d0d0a0d0a322e20436c69636b206f6e204164642046756e6473200d0a0d0a0d0a7b2461646d696e7369676e61747572657d2020200d0a0d0a0d0a0d0a, '', '', '', '', '', '', 1, 1, '', 0, 0, '', 0),
(43, 'general', 'Credit validity expires', 0x4372656469742076616c69646974792065787069726174696f6e20706572696f64206973206e656172, 0x202044656172207b24757365726e616d657d0d0a0d0a506c656173652075706461746520796f7572206372656469742065787069726174696f6e2074696d65202e0d0a0d0a0d0a7b2461646d696e7369676e61747572657d2020202020, '', '', '0', '', '', '', 1, 1, '', 0, 0, '', 0),
(44, 'fileorder', 'File Order Cancelled', 0x4f726465722050726f63657373696e67204661696c757265, 0x20202020202020200d0a44656172207b24757365726e616d657d0d0a0d0a596f7572206f7264657220666f72207b24736572766963657d20206861732070726f63657373696e67206661696c757265202e0d0a526561736f6e20203a20207b24726561736f6e7d20200d0a0d0a0d0a0d0a7b2461646d696e7369676e61747572657d202020202020, '', '', '', '', '', '', 1, 1, '{$service}- Service Name,\r\n{$reason}- Order failure reason', 0, 1, '', 0),
(45, 'serverorder', 'Server Order Cancelled', 0x4f726465722050726f63657373696e67204661696c757265, 0x202020202020200d0a44656172207b24757365726e616d657d0d0a0d0a596f7572206f7264657220666f72207b24736572766963657d206861732070726f63657373696e67206661696c757265202e0d0a526561736f6e20203a20207b24726561736f6e7d20200d0a0d0a0d0a0d0a7b2461646d696e7369676e61747572657d2020202020, '', '', '', '', '', '', 1, 1, '{$service}- Service Name,\r\n{$reason}- Order failure reason', 0, 1, '', 0),
(49, 'product', 'Send shipping details', 0x596f7572206f7264657220686173206265656e2073686970706564, 0x20202020202020202020202020200d0a44656172207b24757365726e616d657d0d0a0d0a0d0a596f7572206f7264657220686173206265656e2073686970706564206279207b247368697070696e675f6761747761797d2020616e6420796f757220747261636b696e6720696420207b24747261636b696e69647d0d0a547261636b696e672055524c203a207b24747261636b696e6775726c7d0d0a0d0a3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d0d0a4f72646572732064657461696c730d0a4f72646572204944203a207b246f7264657269647d0d0a4974656d203a207b24736572766963657d0d0a0d0a0d0a7b666f72656163682066726f6d3d24637573746f6d206b65793d6964206974656d3d6373747d0d0a7b696620246373742e76616c75657d7b246373742e6e616d657d203a207b246373742e76616c75657d7b2f69667d0d0a7b2f666f72656163687d0d0a0d0a3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d0d0a0d0a7b24666565646261636b6c696e6b7d0d0a0d0a7b696620246c696e6b7d0d0a436c69636b206f6e2074686973207b246c696e6b7d20746f206769766520796f757220666565646261636b0d0a7b2f69667d0d0a7b2461646d696e7369676e61747572657d2020202020, '', '', '0', '', '', '', 1, 1, '{$trackinid}-Order Tracking ID,\r\n{$trackingurl}-Shipping order tracking URL,\r\n{$orderid}- Order ID,\r\n{$service}-Item Name,\r\n{$feedbacklink}-Order Feedback link', 0, 0, '', 0),
(50, 'product', 'Shop Order Rejected', 0x596f75722053686f7070696e67204f726465722052656a6563746564, 0x2020202020200d0a44656172207b24757365726e616d657d0d0a0d0a596f7572206f7264657220666f72207b24736572766963657d206861732070726f63657373696e67206661696c757265202e0d0a526561736f6e20203a20207b24726561736f6e7d20200d0a0d0a0d0a2a2a20726566756e6420616d6f756e7420637265646974656420696e20796f7572206163636f756e74202a2a0d0a0d0a0d0a7b2461646d696e7369676e61747572657d2020, '', '', '', '', '', '', 1, 1, '{$service}-Item or Service Name,\r\n{$reason}-Order failure reason', 0, 0, '', 0),
(51, 'general', 'Security Warning [Country login mismatch]', 0x5365637572697479205761726e696e67205b436f756e747279206c6f67696e206d69736d617463685d, 0x20202020200d0a44656172207b24757365726e616d657d0d0a0d0a57652068617665206465746563746564206120737573706963696f7573206163746976697479206f6e20796f7572206163636f756e742e0d0a0d0a496620796f7520617265206e6f74206c6f67696e2066726f6d207b246c6f67696e69707d202d207b246c6f67696e636f756e7472797d287b246c6f67696e636f756e747279636f64657d2920706c6561736520636f6e7461637420757320617320736f6f6e20617320706f737369626c652e0d0a596f75206d61792062652076696374696d206f66206163636f756e742074686566742c20616e64207765206e65656420746f20636865636b20796f75722073656375726974792e0d0a0d0a0d0a57652061706f6c6f67697a6520666f722074686520686974636820616e6420686f706520796f7520756e6465727374616e64207468697320697320746f206265747465722070726f7465637420796f7572206163636f756e742e2020200d0a0d0a0d0a7b2461646d696e7369676e61747572657d2020, '', '', '0', '', '', '', 1, 0, '{$loginip}- Login IP,\r\n{$logincountry}- Login Country,\r\n{$logincountrycode}- Login Country Code', 0, 0, '1', 0),
(52, 'general', 'Subscription Start notice', 0x596f757220537562736372697074696f6e20666f72207b24747970657d, 0x2020200d0a44656172207b24757365726e616d657d0d0a0d0a202020202020202020596f757220537562736372697074696f6e206973206e6f772061637469766174656420666f722073657276696365207b24747970657d2066726f6d20746f646179207b24737562736372697074696f6e5f73746172747d20616e642077696c6c2065787069726564206f6e207b24737562736372697074696f6e5f656e647d20616674657220207b24646179737d2064617973202e0d0a0d0a7b2461646d696e7369676e61747572657d0d0a202020202020, '', '', '', '', '', '', 1, 1, '{$type} - Service Name,\r\n{$subscription_start} - Subscription Start Date,\r\n{$subscription_end} - Subscription End Date,\r\n{$days} - No of days between subscription start and end', 0, 0, '', 0),
(53, 'general', 'Subscription expired', 0x596f757220737562736372697074696f6e206578706972656420746f646179, 0x2020202020200d0a44656172207b24757365726e616d657d0d0a0d0a20202020202020202020596f757220537562736372697074696f6e20666f72207b24747970657d206973206578706972656420746f646179202e20666f722072656e657720706c6561736520636f6e74616374207573202e0d0a0d0a7b2461646d696e7369676e61747572657d2020, '', '', '', '', '', '', 1, 1, '{$type} - Service Name,\r\n{$subscription_start} - Subscription Start Date,\r\n{$subscription_end} - Subscription End Date,\r\n{$days} - No of days between subscription start and end', 0, 0, '', 0),
(54, 'general', 'Subscription Reminder', 0x537562736372697074696f6e204578706972792052656d696e646572, 0x200d0a44656172207b24757365726e616d657d0d0a0d0a20202020202020202020202020596f757220737562736372697074696f6e20666f72207b24747970657d2065787069726564206f6e207b24737562736372697074696f6e5f656e647d202c20506c6561736520636f6e7461637420796f757220737570706c69657220746f2072656e6577206974202e0d0a0d0a7b2461646d696e7369676e61747572657d, '', '', '', '', '', '', 1, 1, '{$type} -Subscribed service name,\r\n{$subscription_start} - Subscription Start Date,\r\n{$subscription_end} - Subscription End Date,\r\n{$days} - No of days between subscription start and end', 0, 0, '', 0),
(55, 'general', 'Security Warning [ Common ]', 0x5365637572697479205761726e696e672046726f6d207b24636f6d70616e796e616d657d, 0x20200d0a44656172207b24757365726e616d657d0d0a0d0a20546869732069732061207365637572697479206e6f7469636520746f206c657420796f75206b6e6f7720746861742074686520666f6c6c6f77696e67206576656e74206f63637572726564206f6e20796f7572206163636f756e743a200d0a203d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d0d0a207b246576656e747d200d0a203d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d0d0a0d0a20496620796f7520646964206e6f7420696e6974696174652074686973206576656e742c20706c6561736520636f6e7461637420757320617320736f6f6e20617320706f737369626c652e0d0a20596f75206d61792062652076696374696d206f66206163636f756e742074686566742c20616e64207765206e65656420746f20636865636b20796f75722073656375726974792e0d0a0d0a207b2461646d696e7369676e61747572657d202020, '', '', '', '', '', '', 1, 0, '{$event} - Perticular events information when this sercurity mail generated ', 0, 0, '', 0),
(56, 'general', 'New Maser Pin', 0x4e6577204d617365722050696e20666f72207b24636f6d70616e796e616d657d, 0x2020200d0a44656172207b24757365726e616d657d0d0a200d0a596f7572204d61737465722050696e2069732075706461746564202c200d0a3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d0d0a596f7572206e6577206d61737465722070696e206973203a207b246d617374657270696e7d200d0a3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d0d0a0d0a7b2461646d696e7369676e61747572657d202020, '', '', '', '', '', '', 1, 0, '{$masterpin} - Master Pin number', 0, 0, '', 0),
(76, 'imeiorder', 'New order placed', 0x4e657720494d4549206f7264657220706c616365642066726f6d20796f7572206163636f756e74, 0x202044656172207b24757365726e616d657d0d0a0d0a0d0a202020202020204e6577206f72646572206f66207b24736572766963657d20706c616365642066726f6d20796f7572206163636f756e74200d0a200d0a7b24696d65696c6973747d0d0a0d0a7b2461646d696e7369676e61747572657d2020, '', '', '0', '', '', '', 1, 0, '', 0, 0, '', 0),
(69, 'invoice', 'Invoice Transaction Refund', 0x596f757220526566756e6420666f7220496e766f696365203a207b24696e766f69636569647d, 0x44656172207b24757365726e616d657d0d0a0d0a596f7572206163636f756e7420726566756e646564207769746820616d6f756e74207b24616d6f756e747d20666f7220496e766f696365203a207b24696e766f6963657d0d0a0d0a20, '', '', '0', '', '', '', 1, 0, '', 0, 0, '', 0),
(57, 'supportticket', 'New ticket open', 0x7b247375626a6563747d, 0x20200a3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d5245504c592041424f56452054484953204c494e453d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d0a0a44656172207b24757365726e616d657d2c0a0a5468616e6b20796f7520666f7220636f6e74616374696e67206f757220737570706f7274207465616d2e204120737570706f7274207469636b657420686173206e6f77206265656e206f70656e656420666f7220796f757220726571756573742e20596f752077696c6c206265206e6f746966696564207768656e206120726573706f6e7365206973206d61646520627920656d61696c2e205468652064657461696c73206f6620796f7572207469636b6574206172652073686f776e2062656c6f772e0a0a5375626a6563743a207b247469636b65747375626a6563747d0a5374617475733a204f70656e0a0a596f752063616e207669657720746865207469636b657420617420616e792074696d65206174207b24766965777469636b65746c696e6b7d0a0a7b2461646d696e7369676e61747572657d0a2020, '', '', '', '', '', '', 1, 0, '{$ticketsubject}-Ticket subject,{$viewticketlink}-View ticket link ', 0, 0, '', 0),
(58, 'supportticket', 'Reply ticket', 0x7b247375626a6563747d, 0x2020200d0a3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d5245504c592041424f56452054484953204c494e453d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d0d0a0d0a7b247469636b65747265706c797d0d0a0d0a0d0a0d0a3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d0d0a5469636b65742049443a20237b247469636b657469647d0d0a5375626a6563743a207b247469636b65747375626a6563747d0d0a5374617475733a20416e7377657265640d0a5469636b65742055524c3a207b24766965777469636b65746c696e6b7d0d0a3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d0d0a0d0a0d0a7b2473746166667369676e61747572657d0d0a0d0a7b2461646d696e7369676e61747572657d202020, '', '', '', '', '', '', 1, 0, '{$ticketreply}- Reply of staff,{$ticketid}-Ticket ID,{$ticketsubject}-Ticket Subject,{$viewticketlink}- View ticket Link on site,{$staffsignature}- Answered staff signature\r\n', 0, 0, '', 0),
(59, 'product', 'When Resellers User complete order', 0x596f75722055736572206d616465206f72646572207375636365737366756c6c79, 0x20436f6e67726174756c6174696f6e202c0d0a0d0a0d0a20202020202020202020202020596f7572205573657220706c61636564206f7264657220616e64207061796d656e7420636f6d706c65746564202e200d0a0d0a20202020202020202020202020416e6420796f757220636f6d6d697373696f6e207b24616d6f756e747d20637265646974656420696e20796f7572206163636f756e742e0d0a0d0a0d0a0d0a0d0a0d0a7b2461646d696e7369676e61747572657d, '', '', '', '', '', '', 1, 0, '{$amount}-Amount of order placed by resellers user', 0, 0, '', 0),
(60, 'supportticket', 'Ticket auto closed', 0x596f7572205469636b6574205b7b247469636b657469647d5d20636c6f736564, 0x2044656172207b24757365726e616d657d0d0a0d0a2020202020202020202020596f7572205469636b6574207b247469636b657469647d20636c6f736564206175746f6d61746963616c6c79202062656361757365206e6f74207265706c6965642066726f6d206c617374207b24686f7572737d20686f7572730d0a200d0a2020202020202020202020202020200d0a20202020202020202020202020, '', '', '', '', '', '', 1, 0, '{$ticketid}-Support Ticket Id,{$hours}-No of hours before closed', 0, 0, '', 0),
(61, 'affiliate', 'Affiliate Commission ', 0x436f6e67726174756c6174696f6e20796f7572205573657220686173206d616465206f72646572, 0x3c703e436f6e67726174756c6174696f6e732120596f752068617665206265656e20637265646974656420726566657272616c20616d6f756e74207b24636f6d6d697373696f6e7d20666f7220796f757220726566657272616c2e3c6272202f3e3c6272202f3e3c6272202f3e3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3c2f703e0d0a3c703e5349474e55502044455441494c533c6272202f3e557365726e616d65203a207b24757365726e616d657d3c6272202f3e50726f64756374203a207b2470726f647563747d3c6272202f3e3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3c6272202f3e3c6272202f3e3c6272202f3e526566657272696e672066726f6d20706167653a203c6120687265663d22687474703a2f2f646872752e636f6d2f22207461726765743d225f626c616e6b222072656c3d226e6f6f70656e6572223e687474703a2f2f796f7572776562736974652e636f6d2f3c2f613e3c6272202f3e3c6272202f3e596f752063616e206c6f67696e20746f20796f757220616666696c69617465206d616e6167656d656e742063656e746572206174203a2053797374656d205572693c6272202f3e746f2073656520796f757220616666696c6961746520636f6e76657273696f6e207374617469737469637320616e642070656e64696e67207061796d656e74732e3c6272202f3e3c6272202f3e3c6272202f3e3c61207374796c653d22746578742d6465636f726174696f6e3a206e6f6e653b223e7b2461646d696e7369676e61747572657d3c2f613e3c2f703e, '', '', '0', '0', '', '', 0, 0, '{$commission}-Referral commission amount,\r\n{$username}-Registered Username,\r\n{$product}-Purchased Product', 0, 0, '', 0),
(62, 'resellerstore', 'Add fund Error', 0x596f7520686176656e742073756666696369656e742062616c616e6365, 0x44656172207b24757365726e616d657d0d0a0d0a200d0a0d0a596f75722075736572207b24757365727d206861732070617920796f752062792050617970616c0d0a0d0a416d6f756e74203a207b24616d6f756e747d0d0a0d0a5472616e73616374696f6e204944203a207b247472616e73616374696f6e69647d0d0a0d0a200d0a0d0a42757420796f7520686176656e27742073756666696369656e742062616c616e636520736f20706c7320636f6d706c6574652070726f63657373206d616e75616c6c790d0a0d0a200d0a0d0a7b2461646d696e7369676e61747572657d, '', '', '0', '', '', '', 1, 0, '{$amount}-Amount Transffered,\r\n{$transactionid}-Transaction ID', 0, 0, '', 0),
(63, 'resellerstore', 'Add Fund success', 0x55736572206d616465207061796d656e74, 0x44656172207b24757365726e616d657d0d0a0d0a200d0a0d0a7b24757365727d20686173206d616465207061796d656e742062792070617970616c20746f20796f7572206163636f756e7420666f72206164642066756e640d0a0d0a200d0a0d0a3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d0d0a0d0a416d6f756e74203a207b24616d6f756e747d0d0a0d0a3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d0d0a0d0a200d0a0d0a200d0a0d0a7b2461646d696e7369676e61747572657d, '', '', '0', '', '', '', 1, 0, '{$amount}- Fund amount', 0, 0, '', 0),
(64, 'imeiorderbulk', 'Bulk reply in single mail', 0x596f757220756e6c6f636b20636f6465, 0x202044656172207b24757365726e616d657d0d0a0d0a596f757220756e6c6f636b20636f646520686173206265656e207375636365737366756c6c792063616c63756c617465642e0d0a0d0a7b666f72656163682066726f6d3d247265706c7961727279206974656d3d7265706c797d0d0a203d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d0d0a494d4549203a207b247265706c792e696d65697d0d0a556e6c6f636b20636f6465203a20207b247265706c792e7265706c797d0d0a4f72646572732064657461696c730d0a4f72646572204944203a207b247265706c792e6f7264657269647d0d0a53657276696365204e616d65203a207b247265706c792e736572766963657d0d0a437265646974203a207b247265706c792e6f726465726372656469747d0d0a7b696620247265706c792e6d6f64656c7d204d6f64656c203a207b247265706c792e6d6f64656c7d7b2f69667d0d0a7b696620247265706c792e70726f76696465727d50726f7669646572203a207b247265706c792e70726f76696465727d7b2f69667d0d0a7b696620247265706c792e6d65707d4d4550203a207b247265706c792e6d65707d7b2f69667d0d0a7b696620247265706c792e70696e7d50494e20203a207b247265706c792e70696e7d7b2f69667d0d0a7b696620247265706c792e6b62687d4b4248203a207b247265706c792e6b62687d7b2f69667d0d0a7b696620247265706c792e7072647d505244203a207b247265706c792e7072647d7b2f69667d0d0a7b696620247265706c792e747970657d54797065203a207b247265706c792e747970657d7b2f69667d0d0a7b696620247265706c792e7265666572656e63657d5265666572656e636520203a20207b247265706c792e7265666572656e63657d7b2f69667d0d0a7b696620247265706c792e6c6f636b737d4c6f636b7320203a20207b247265706c792e6c6f636b737d7b2f69667d0d0a7b666f72656163682066726f6d3d247265706c792e637573746f6d206b65793d6964206974656d3d6373747d0d0a7b696620246373742e76616c75657d7b246373742e6e616d657d203a207b246373742e76616c75657d7b2f69667d0d0a7b2f666f72656163687d0d0a0d0a7b69662020247265706c792e636f6d6d656e74737d2a2a207b247265706c792e636f6d6d656e74737d207b2f69667d0d0a0d0a3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d0d0a0d0a7b2f666f72656163687d0d0a0d0a0d0a0d0a7b2461646d696e7369676e61747572657d202020, '', '', '0', '', '', '', 1, 1, '{$orderid}- Order ID , {$imei} - IMEI No, {$note} - Notes , {$comments} - Comments , {$ordercredit} - Credit For Order , {$model} - Model Name , {$provider} - Provider Name , {$mep} - MEP , {$pin} - PIN Number , {$kbh} - KBH , {$prd} - PRD , {$type}- Type ,{$reference} - Reference , {$locks} - Locks ,{$comments}- User Comments,\r\n{$reply}- Admin Reply', 0, 0, '', 0),
(65, 'resellerstore', 'New User registered on Store', 0x4e657720557365722072656769737465726564206f6e20796f75722073746f7265, 0x44656172207b24757365727d0d0a0d0a200d0a0d0a4e65772075736572206a757374207369676e207570206f6e20796f757220736974650d0a0d0a44657461696c730d0a0d0a3d3d3d3d3d3d3d3d3d3d0d0a0d0a557365726e616d65203a207b24757365726e616d657d0d0a0d0a4669727374204e616d653a207b2466697273746e616d657d0d0a0d0a4c617374204e616d65203a207b246c6173746e616d657d0d0a0d0a50686f6e65204e6f203a207b2470686f6e656e756d6265727d0d0a0d0a456d61696c203a207b24656d61696c7d, '', '', '0', '', '', '', 1, 0, '{$username}-Registered users Username,\r\n{$firstname}-Registered users Firstname,\r\n{$lastname}-Registered users Last Name,\r\n{$phonenumber}-Reistered users Phonenumber,\r\n{$email}-Reistered users E-mail', 0, 0, '', 0),
(68, 'general', 'When direct order placed', 0x596f7572206f7264657220666f72207b24736572766963657d20686173206265656e2070726f63657373207375636365737366756c6c79, 0x4465617220437573746f6d65720d0a0d0a202020202020202020596f7572206f7264657220666f72207b24736572766963657d20686173206265656e2070726f63657373207375636365737366756c6c790d0a202020202020202020746f20636f6d706c65746520796f7572206f72646572206f70656e2074686973206c696e6b207b246c696e6b7d0d0a202020202020202020616e64207375626d697420667572746865722064657461696c73206c696b6520796f757220494d4549206d6164652020286469616c202a2330362320746f206765742074686520494d4549290d0a206574632e2e0d0a0d0a20202020202020202077652070726f6365737320796f7572206f726465722073686f72746c79206f6e636520776520676f7420796f75722064657461696c73202e0d0a0d0a202020202020202020696620796f7520617265206e6f7420206f70656e206c696e6b206469726563746c79206a75737420636f707920616e6420706573742074686973206c696e6b20696e20796f75722062726f777365720d0a0d0a0d0a0d0a7b2461646d696e7369676e61747572657d2020202020, '', '', '0', '', '', '', 1, 0, '', 0, 0, '', 0),
(70, 'general', 'Return request for order', 0x52657475726e2052657175657374, 0x3c703e44656172207b24757365726e616d657d3c2f703e0d0a3c703e203c2f703e0d0a3c703e52657475726e205265717565737420666f7220796f7572206f726465723c2f703e0d0a3c703e64657461696c7320617265202e2e2e3c2f703e0d0a3c703e203c2f703e0d0a3c703e4974656d73203a207b2470726f647563747d3c2f703e0d0a3c703e526561736f6e3a207b24726561736f6e7d3c2f703e0d0a3c703e416374696f6e203a207b24616374696f6e7d3c2f703e0d0a3c703e436f6d6d656e743a207b24636f6d6d656e747d3c2f703e0d0a3c703e506c656173652073656e64204974656d20746f203a3c2f703e0d0a3c703e52657475726e204964203a207b2472656669647d3c2f703e0d0a3c703e3c7370616e3e7b24616464726573737d3c2f7370616e3e3c2f703e0d0a7b696620247374617475737d0d0a537461747573203a207b247374617475737d0d0a7b2f69667d0d0a3c703e203c2f703e, '', '', '', '', '', '', 0, 0, '', 0, 0, '', 0),
(67, 'general', 'Withdrawal Request Accepted', 0x5769746864726177616c205265717565737420686173206265656e2070726f636573736564, 0x44656172207b24757365727d0d0a0d0a596f7572207769746864726177616c205265717565737420666f7220616d6f756e74207b24616d6f756e747d2020686173206265656e2070726f6365737365640d0a0d0a44657461696c73200d0a3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d0d0a416d6f756e74202020202020202020203a207b24616d6f756e747d0d0a5472616e73616374696f6e204944203a207b247472616e73616374696f6e69647d0d0a47617465776179202020202020202020203a207b24676174657761797d0d0a202020202020, '', '', '0', '', '', '', 1, 0, '{$amount}-Withdrawal Amount,($transactionid}- Withdraw transaction ID,{$gatewa}- Payment Gateway used for withdraw', 0, 0, '', 0),
(66, 'general', 'Withdrawal Request Rejected', 0x5769746864726177616c20526571756573742052656a6563746564, 0x44656172207b24757365727d0d0a0d0a0d0a596f7572205769746864726177616c20526571756573742052656a65637465642062656361757365207b24726561736f6e7d, '', '', '', '', '', '', 1, 0, '{$reason}-Withdrawal request rejected reason', 0, 0, '', 0),
(71, 'general', 'Gift Certificate', 0x596f757220676f7420476966742066726f6d207b2466726f6d7d, 0x200d0a44656172207b24757365726e616d657d0d0a0d0a596f75722047696674206365727469666963617465206f6620616d6f756e74202d207b24616d6f756e747d0d0a596f757220436f75706f6e20436f6465202d207b24636f75706f6e7d0d0a7b246d6573736167657d0d0a0d0a20, '', '', '', '', '', '', 1, 0, '', 0, 0, '', 0),
(72, 'product', 'Product Reorder', 0x50726f647563742072656f7264657220, 0x44656172207b24757365726e616d657d0d0a0d0a596f7572206e6577206f726465722067656e657261746564202e0d0a496e766f69636520496420203a207b24696e766f69636569647d0d0a0d0a4974656d204c697374203a0d0a7b2464657461696c7d20200d0a0d0a7b2461646d696e7369676e61747572657d202020, '', '', '0', '', '', '', 1, 0, '', 0, 0, '', 0),
(73, 'product', 'Price update notification', 0x4974656d732050726963652055706461746564, 0x3c7461626c65207374796c653d2277696474683a20313030253b20626f726465722d636f6c6c617073653a20636f6c6c617073653b206261636b67726f756e643a20236634663466343b223e0d0a3c74626f64793e0d0a3c74723e0d0a3c74643e0d0a3c646976207374796c653d226d617267696e3a20307078206175746f20343070783b2077696474683a2036353070783b206261636b67726f756e643a2077686974653b223e0d0a3c646976207374796c653d22746578742d616c69676e3a2063656e7465723b2070616464696e673a20313570783b223e0d0a3c6831207374796c653d226d617267696e3a20303b223e7b24636f6d70616e796e616d657d3c2f68313e0d0a3c736d616c6c207374796c653d22666f6e742d73697a653a20313570783b223e205b7b24646174657d5d203c2f736d616c6c3e3c2f6469763e0d0a3c646976207374796c653d226261636b67726f756e642d636f6c6f723a20233066303135653b206261636b67726f756e642d696d6167653a2072616469616c2d6772616469656e742866617274686573742d636f726e65722061742035302520313030252c2072676261283132332c32322c3235352c302e3735292c2330463031354520293b2070616464696e673a20323070783b20746578742d616c69676e3a2063656e7465723b223e0d0a3c6831207374796c653d22666f6e742d73697a653a20333070783b20636f6c6f723a2077686974653b20666f6e742d7765696768743a206e6f726d616c3b223e466f6c6c6f77696e67204974656d73205072696365206368616e67656420746f6461793c2f68313e0d0a3c6832207374796c653d22666f6e742d73697a653a20313670783b20636f6c6f723a2077686974653b20666f6e742d7765696768743a206e6f726d616c3b223e44656172207b24757365726e616d657d2c20506c6561736520636865636b206e65772070726963653c2f68323e0d0a3c2f6469763e0d0a3c646976207374796c653d2270616464696e673a20323070783b223e0d0a3c7461626c65207374796c653d2277696474683a20313030253b20626f726465722d636f6c6c617073653a20636f6c6c617073653b223e0d0a3c74686561643e0d0a3c74723e3c7468207374796c653d2277686974652d73706163653a206e6f777261703b2070616464696e673a203130707820303b20626f726465722d626f74746f6d3a202365656520736f6c6964203170783b20746578742d616c69676e3a206c6566743b223e53657276696365204e616d653c2f74683e3c7468207374796c653d2277686974652d73706163653a206e6f777261703b2070616464696e673a203130707820303b20626f726465722d626f74746f6d3a202365656520736f6c6964203170783b20746578742d616c69676e3a2072696768743b223e5072696365203c736d616c6c207374796c653d22666f6e742d7765696768743a206e6f726d616c3b223e7b2463757272656e6379636f64657d3c2f736d616c6c3e3c2f74683e3c2f74723e0d0a3c2f74686561643e0d0a3c2f7461626c653e0d0a7b666f72656163682066726f6d3d246974656d6c697374206b65793d6964206974656d3d736572766963657d0d0a3c7461626c65207374796c653d2277696474683a20313030253b20626f726465722d636f6c6c617073653a20636f6c6c617073653b223e0d0a3c74626f64793e0d0a3c74723e0d0a3c7464207374796c653d2270616464696e673a20377078203070783b20626f726465722d626f74746f6d3a202365656520736f6c6964203170783b223e7b24736572766963652e6e616d657d3c2f74643e0d0a3c7464207374796c653d2270616464696e673a20377078203070783b20626f726465722d626f74746f6d3a202365656520736f6c6964203170783b20746578742d616c69676e3a2072696768743b20666f6e742d73697a653a20313470783b20666f6e742d7765696768743a20626f6c643b20636f6c6f723a20233066303135653b223e7b24736572766963652e70726963657d207b24736572766963652e7374617475737d3c2f74643e0d0a3c2f74723e0d0a3c2f74626f64793e0d0a3c2f7461626c653e0d0a7b2f666f72656163687d0d0a3c646976207374796c653d22746578742d616c69676e3a2063656e7465723b20636f6c6f723a20233932393739623b2070616464696e673a203230707820303b20666f6e742d73697a653a20313370783b223e0d0a3c6469763e496620796f7520646f6e27742077616e7420746f207265636569766520746865736520656d61696c7320696e20746865206675747572652c20796f75206d61792075706461746520796f757220737562736372697074696f6e20707265666572656e636573206f72203c61207374796c653d22746578742d6465636f726174696f6e3a206e6f6e653b2220687265663d227b2473697465616464726573737d2f696e6465782e7068703f753d7b24656e637d223e556e7375627363726962653c2f613e2066726f6d20616c6c20656d61696c732e3c2f6469763e0d0a3c646976207374796c653d2270616464696e673a203130707820303b20666f6e742d73697a653a20313370783b223e26636f70793b7b24636f6d70616e796e616d657d2e20416c6c205269676874732052657365727665643c2f6469763e0d0a3c646976207374796c653d22746578742d616c69676e3a2063656e7465723b223e7b69662024747769747465727d207b2f69667d207b6966202466616365626f6f6b7d207b2f69667d207b696620246c696e6b6564696e7d207b2f69667d207b69662024726573656c6c657273746f72657d207b2f69667d3c2f6469763e0d0a3c646976207374796c653d22636c6561723a20626f74683b223e203c2f6469763e0d0a3c2f6469763e0d0a3c2f6469763e0d0a3c2f6469763e0d0a3c2f74643e0d0a3c2f74723e0d0a3c2f74626f64793e0d0a3c2f7461626c653e, '', '', '0', '', '', '', 0, 0, '', 0, 0, '', 0),
(74, 'general', 'Group subscription expiry reminder', 0x596f757220737562736372697074696f6e2065787069726564206f6e207b24646174657d, 0x44656172207b24757365726e616d657d0d0a0d0a596f757220737562736372697074696f6e20666f72207b2467726f75707d2065787069726564206f6e207b24646174657d, '', '', '', '', '', '', 1, 0, '', 0, 0, '', 0),
(75, 'invoice', 'Offline Payment Gateway Updates', 0x5765207265636569766564205061796d656e742064657461696c73, 0x2044656172207b24757365726e616d657d0d0a0d0a576520526563656976656420796f7572205061796d656e742044657461696c7320666f7220496e766f696365204e756d626572203a207b24696e766f69636569647d0d0a0d0a5061796d656e7420697320756e6465722070726f636573732e0d0a0d0a0d0a7b2461646d696e7369676e61747572657d20, '', '', '0', '', '', '', 1, 0, '', 0, 0, '', 0),
(77, 'general', 'New service available', 0x4e6577205365727669636520417661696c61626c65207b24747970657d, 0x3c703e44656172207b24757365727d2c3c2f703e0d0a3c703e3c2f703e0d0a3c703e5468697320697320616e6e6f756e63656d656e7420666f72206e6577207365727669636520617661696c61626c653c2f703e0d0a3c703e7b2473657276696365736c6973747d3c2f703e, '', '', '0', '', '', '', 0, 0, '', 0, 0, '', 0);
INSERT INTO `tbl_emailtemplates` (`id`, `type`, `name`, `subject`, `message`, `fromname`, `fromemail`, `disabled`, `custom`, `language`, `copyto`, `plaintext`, `for_reseller`, `template_variable`, `newsletter_default`, `scheduled`, `mailserv`, `layoutid`) VALUES
(78, 'general', 'Security Question reset by Admin', 0x596f7572207365637572697479205175657374696f6e2072657365742062792041646d696e, 0x44656172207b24757365726e616d657d200d0a596f75207365637572697479207175657374696f6e20666f72207b24636f6d70616e796e616d657d2072657365742062792041646d696e2e20596f752063616e206368616e6765206f7220736574206e6577207175657374696f6e20616e6420616e7377657220696620796f752077616e742e2020, '', '', '0', '', '', '', 1, 0, '', 0, 0, '', 0),
(79, 'general', 'Confirm your email', 0x596f752061726520737562736372696265206174207b24636f6d70616e796e616d657d, 0x596f757220656d61696c20737562736372696265206174207b24636f6d70616e796e616d657d2e20506c6561736520636c69636b207b246c696e6b7d20746f2076657269667920796f757220656d61696c206163636f756e742e0d0a0d0a5468616e6b20796f75, '', '', '', '', '', '', 1, 0, '', 0, 0, '', 0),
(80, 'general', 'Service List', 0x53657276696365204c697374, 0x4465617220437573746f6d65720d0a506c656173652066696e64206174746163686564207365727669636573206c6973740d0a7b2461646d696e7369676e61747572657d, '', '', '', '', '', '', 1, 0, '', 0, 0, '', 0),
(81, 'general', 'ID/KYC verification status update', 0xf09f98904b59432f494420726571756573742075706461746564202d7b247374617475737d, 0x3c703e44656172207b24757365726e616d657d3c2f703e0d0a3c703e596f75722049442f4b594320766572696669636174696f6e2072657175657374206973207570646174656420616e642063757272656e7420737461747573206973207b247374617475737d2e3c2f703e0d0a3c703e3c2f703e0d0a3c703e7b2472656a656374726561736f6e7d3c2f703e, '', '', '0', '', '', '', 0, 0, '', 0, 0, '', 0),
(82, 'general', 'Paypal OTP', 0x4f545020666f7220646972656374207472616e73616374696f6e, 0x44656172207b24757365726e616d657d200d0a0d0a5468697320697320796f7572207b246f74707d20666f722050617950616c20446972656374205472616e73616374696f6e2e0d0a, '', '', '', '', '', '', 1, 0, '', 0, 0, '', 0),
(83, 'imeiorderbulk', 'Bulk reject in single mail', 0x596f7572204f726465722052656a6563746564, 0x44656172207b24757365726e616d657d0d0a0d0a466f6c6c6f77696e67204f726465722072656a65637465642e0d0a0d0a7b666f7265616368202066726f6d3d2473657276696365206b65793d6b206974656d3d736572766963656974656d7d0d0a0d0a7b24736572766963656974656d7d203a20237b246f72646572735b246b5d7d20494d45493a207b24696d65695b246b5d7d20526561736f6e3a207b24726561736f6e5b246b5d7d0d0a0d0a7b2f666f72656163687d202020, '', '', '0', '', '', '', 1, 1, '{$orderid}- Order ID , {$imei} - IMEI No, {$note} - Notes , {$comments} - Comments , {$ordercredit} - Credit For Order , {$model} - Model Name , {$provider} - Provider Name , {$mep} - MEP , {$pin} - PIN Number , {$kbh} - KBH , {$prd} - PRD , {$type}- Type ,{$reference} - Reference , {$locks} - Locks ,{$comments}- User Comments,\r\n{$reply}- Admin Reply', 0, 0, '', 0),
(84, 'remoteorder', 'Remote order success', 0x4f726465722063616c63756c61746564207375636365737366756c6c79, 0x266c743b702667743b44656172207b24757365726e616d657d266c743b2f702667743b0d0a266c743b702667743b266c743b2f702667743b0d0a266c743b702667743b596f7572206f7264657220666f72207b24736572766963657d20686173207375636365737366756c6c79206265656e2063616c63756c617465642e266c743b2f702667743b0d0a266c743b702667743b7b69662024636f6d6d656e74737d2a2a207b24636f6d6d656e74737d7b2f69667d266c743b2f702667743b0d0a266c743b702667743b266c743b2f702667743b0d0a266c743b702667743b3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d266c743b2f702667743b0d0a266c743b702667743b7b247265706c797d266c743b2f702667743b0d0a266c743b702667743b3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d266c743b2f702667743b0d0a266c743b702667743b4f72646572732064657461696c73266c743b2f702667743b0d0a266c743b702667743b5365727669636526616d703b6e6273703b203a207b24736572766963657d266c743b2f702667743b0d0a266c743b702667743b437265646974203a207b246f726465726372656469747d266c743b2f702667743b0d0a266c743b702667743b7b666f72656163682066726f6d3d24637573746f6d206b65793d6964206974656d3d6373747d266c743b2f702667743b0d0a266c743b702667743b7b246373742e6e616d657d203a26616d703b6e6273703b207b246373742e76616c75657d266c743b2f702667743b0d0a266c743b702667743b7b2f666f72656163687d26616d703b6e6273703b266c743b2f702667743b0d0a266c743b702667743b266c743b2f702667743b0d0a266c743b702667743b3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d266c743b2f702667743b0d0a266c743b702667743b7b24666565646261636b6c696e6b7d266c743b2f702667743b0d0a266c743b702667743b7b2461646d696e7369676e61747572657d26616d703b6e6273703b2026616d703b6e6273703b2026616d703b6e6273703b266c743b2f702667743b, '', '', '0', '0', '', '', 0, 0, '', 0, 0, '', 0),
(85, 'remoteorder', 'Remote order reject', 0x52656d6f7465204f726465722052656a6563746564202f2043616e63656c6c6564, 0x266c743b702667743b44656172207b24757365726e616d657d266c743b2f702667743b0d0a266c743b702667743b596f7572206f7264657220666f72207b24736572766963657d206861732070726f63657373696e67206661696c757265202e266c743b2f702667743b0d0a266c743b702667743b526561736f6e203a207b24726561736f6e7d266c743b2f702667743b0d0a266c743b702667743b7b2461646d696e7369676e61747572657d266c743b2f702667743b, '', '', '0', '0', '', '', 0, 0, '', 0, 0, '', 0),
(86, 'remoteorder', 'New Remote order', 0x4e65772052656d6f7465206f7264657220706c61636564, 0x266c743b702667743b44656172207b24757365726e616d657d266c743b2f702667743b0d0a266c743b702667743b4e6577206f72646572206f66207b24736572766963657d20706c616365642066726f6d20796f7572206163636f756e742e266c743b2f702667743b0d0a266c743b702667743b266c743b2f702667743b0d0a266c743b702667743b7b2461646d696e7369676e61747572657d266c743b2f702667743b, '', '', '0', '0', '', '', 0, 0, '', 0, 0, '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_emailtemplates_backup`
--

CREATE TABLE `tbl_emailtemplates_backup` (
  `id` int(10) NOT NULL,
  `type` varchar(255) NOT NULL,
  `name` varchar(555) NOT NULL,
  `subject` blob NOT NULL,
  `message` blob NOT NULL,
  `fromname` mediumtext NOT NULL,
  `fromemail` mediumtext NOT NULL,
  `disabled` mediumtext NOT NULL,
  `custom` mediumtext NOT NULL,
  `language` mediumtext NOT NULL,
  `copyto` mediumtext NOT NULL,
  `plaintext` int(1) NOT NULL DEFAULT 0,
  `for_reseller` int(1) NOT NULL DEFAULT 0,
  `template_variable` mediumtext NOT NULL,
  `newsletter_default` int(1) NOT NULL DEFAULT 0,
  `scheduled` int(1) NOT NULL DEFAULT 0,
  `mailserv` varchar(50) NOT NULL,
  `layoutid` int(11) NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `tbl_emailtemplates_backup`
--

INSERT INTO `tbl_emailtemplates_backup` (`id`, `type`, `name`, `subject`, `message`, `fromname`, `fromemail`, `disabled`, `custom`, `language`, `copyto`, `plaintext`, `for_reseller`, `template_variable`, `newsletter_default`, `scheduled`, `mailserv`, `layoutid`) VALUES
(1, 'general', 'Registration Confirmation (Manual)', 0x7b24636f6d70616e796e616d657d204163636f756e7420526567697374726174696f6e, 0x3c703e2044656172207b24757365726e616d657d3c2f703e0d0a3c703e3c2f703e0d0a3c703e5468616e6b20796f7520666f7220796f757220696e74657265737420696e207b24636f6d70616e796e616d657d2e3c2f703e0d0a3c703e3c2f703e0d0a3c703e496e206f7264657220746f20636f6d706c6574652061637469766174696f6e206f6e20796f7572206163636f756e74206120726570726573656e7461746976652077696c6c20636f6e7461637420796f752073686f72746c7920746f2061646a75737420796f7572206163636f756e74206163636f7264696e676c792e3c2f703e0d0a3c703e496620796f75207769736820746f20636f6d706c6574652061637469766174696f6e20736f6f6e657220796f75206d61792073656e6420757320616e20656d61696c20746f207b2461646d696e6d61696c7d20287375626a656374207469746c65203a204143544956415445204143434f554e54292e3c2f703e0d0a3c703e496e2074686520656d61696c20706c656173652070726f7669646520796f757220557365726e616d6520616e642077652077696c6c20636f6d706c657465207468652070726f6365737320666f7220796f7520736f20796f752063616e207374617274206f72646572696e6720696d6d6564696174656c792e3c2f703e0d0a3c703e3c2f703e0d0a3c703e7b2461646d696e7369676e61747572657d3c2f703e, '', '', '0', '', '', '', 0, 1, '', 0, 0, '', 0),
(2, 'general', 'Registration Confirmation (Automatic)', 0x7b24636f6d70616e796e616d657d204163636f756e7420526567697374726174696f6e, 0x3c703e44656172207b24757365726e616d657d3c2f703e0d0a3c703e5468616e6b20796f7520666f7220796f757220696e74657265737420696e207b24636f6d70616e796e616d657d2e3c2f703e0d0a3c703e496e206f7264657220746f20636f6e74696e7565207265676973746572696e6720796f75722064657461696c732c20706c6561736520636c69636b2074686520666f6c6c6f77696e67206c696e6b3a203d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3c2f703e0d0a3c703e7b246c696e6b7d3c2f703e0d0a3c703e3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3c2f703e0d0a3c703e496620796f7520646964206e6f7420726567697374657220666f72207468697320736572766963652e2e2e3c2f703e0d0a3c703e5468697320656d61696c20686173206265656e2073656e7420746f20796f7520626563617573652061207b24636f6d70616e796e616d657d206163636f756e7420686173206265656e2063726561746564207573696e67207468697320656d61696c20616464726573732e20496620796f7520646964206e6f7420726567697374657220666f72207468697320736572766963652c20706c6561736520636f6e7461637420437573746f6d657220537570706f72742061742074686520666f6c6c6f77696e6720616464726573733a207b2461646d696e6d61696c7d205765206c6f6f6b20666f727761726420746f20736565696e6720796f7520696e2074686520776f726c64206f66207b24636f6d70616e796e616d657d3c2f703e0d0a3c703e7b2461646d696e7369676e61747572657d3c2f703e, '', '', '0', '', '', '', 0, 1, '{$link}-Account activation link', 0, 0, '', 1),
(3, 'general', 'Password Reset Request', 0x7b24636f6d70616e796e616d657d202d2052657365742050617373776f7264, 0x20202020200d0a44656172207b24757365726e616d657d20200d0a0d0a536f6d656f6e6520686173207265717565737465642074686174207468652070617373776f726420666f7220796f7572206163636f756e742c2062652072657365742e0d0a0d0a496620796f7520646964206e6f74206d616b65207468697320726571756573742c20706c656173652073696d706c7920646973726567617264207468697320652d6d61696c2e0d0a0d0a49742069732073656e74206f6e6c7920746f207468652061646472657373206f6e2066696c6520666f7220796f7572206163636f756e7420616e642077696c6c206265636f6d6520696e76616c696420616674657220343820686f7572732c20736f20796f7520646f206e6f74206861766520746f20776f7272792061626f757420796f7572206163636f756e74206265696e672074616b656e206f7665722e20200d0a0d0a506c6561736520676f20746f2074686520666f6c6c6f77696e672055524c20203a20200d0a3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d0d0a0d0a7b246c696e6b7d200d0a0d0a3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d0d0a0d0a0d0a7b2461646d696e7369676e61747572657d202020, '', '', '0', '', '', '', 1, 1, '{$link}-Password Reset link', 0, 0, '', 4),
(4, 'general', 'Successful Password Change Confirmation', 0x7b24636f6d70616e796e616d657d202d2050617373776f7264206368616e6765, 0x3c703e44656172207b24757365726e616d657d3c2f703e0d0a3c703e3c2f703e0d0a3c703e596f75722070617373776f726420666f72206f7572206c6f6720696e2073797374656d20686173206265656e207375636365737366756c6c79206368616e6765642e3c2f703e0d0a3c703e546865206e65772070617373776f7264206973206e6f74207072696e746564206865726520746f2070726f7465637420796f7572207072697661637920616e6420796f75722075736572206e616d6520697320636f6e6669726d65642062656c6f772e3c2f703e0d0a3c70207374796c653d2270616464696e672d6c6566743a20363070783b223e3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3c2f703e0d0a3c70207374796c653d2270616464696e672d6c6566743a20363070783b223e557365726e616d65203a207b24757365726e616d657d3c2f703e0d0a3c70207374796c653d2270616464696e672d6c6566743a20363070783b223e50617373776f7264203a202a2a2a48494444454e2a2a2a3c2f703e0d0a3c70207374796c653d2270616464696e672d6c6566743a20363070783b223e3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3c2f703e0d0a3c703e496620796f752068617665206e6f74207265717565737465642074686973206368616e67652c20796f7572206163636f756e74206d6f7374206c696b656c792068617320616c7265616479206265656e20636f6d70726f6d697365642e20596f752073686f756c6420696d6d6564696174656c7920636f6e746163742075732e3c2f703e0d0a3c703e3c2f703e0d0a3c703e7b2461646d696e7369676e61747572657d3c2f703e, '', '', '0', '', '', '', 0, 1, '', 0, 0, '', 0),
(5, 'general', 'Account block notice', 0x596f7572206163636f756e7420686173206265656e20626c6f636b6564, 0x20200d0a596f7572206163636f756e7420686173206265656e20626c6f636b65642064756520746f200d0a0d0a3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d0d0a0d0a7b24626c6f636b7265736f6e7d0d0a0d0a3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d0d0a0d0a7b2461646d696e7369676e61747572657d20, '', '', '', '', '', '', 1, 1, '{$blockreson}-Account block Reason', 0, 0, '', 0),
(6, 'imeiorder', 'IMEI Order Cancelled ', 0x4f726465722050726f63657373696e67204661696c757265, 0x20202020200d0a44656172207b24757365726e616d657d0d0a0d0a596f7572206f7264657220666f72207b24736572766963657d202d207b24696d65697d206861732070726f63657373696e67206661696c757265202e0d0a526561736f6e20203a20207b24726561736f6e7d20200d0a0d0a0d0a0d0a7b2461646d696e7369676e61747572657d202020, '', '', '0', '', '', '', 1, 1, '{$service}- Service name,\r\n{$imei}- IMEI,\r\n{$reason}- Order Cancel Reason', 0, 0, '', 0),
(7, 'general', 'Successful Security Question Confirmation ', 0x7b24636f6d70616e796e616d657d202d205365637572697479205175657374696f6e204368616e6765, 0x202020200d0a44656172207b24757365726e616d657d0d0a0d0a596f7572207365637572697479207175657374696f6e20666f72206f7572206c6f6720696e2073797374656d20686173206265656e207375636365737366756c6c79206368616e6765642e0d0a546865206e65772070617373776f7264206973206e6f74207072696e746564206865726520746f2070726f7465637420796f7572207072697661637920616e6420796f75722075736572206e616d6520697320636f6e6669726d65642062656c6f772e0d0a0d0a3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d0d0a0d0a557365726e616d65203a207b24757365726e616d657d0d0a50617373776f726420203a202a2a2a48494444454e2a2a2a0d0a0d0a3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d0d0a0d0a0d0a496620796f752068617665206e6f74207265717565737465642074686973206368616e67652c20796f7572206163636f756e74206d6f7374206c696b656c792068617320616c7265616479206265656e20636f6d70726f6d697365642e2020596f752073686f756c6420696d6d6564696174656c7920636f6e746163742075732e0d0a0d0a0d0a7b2461646d696e7369676e61747572657d202020, '', '', '', '', '', '', 1, 1, '', 0, 0, '', 0),
(8, 'general', 'Account balance Created / Debited Conformation', 0x596f7572204163636f756e742062616c616e63652075706461746564, 0x202020202020202020202020200d0a44656172207b24757365726e616d657d0d0a0d0a5468616e6b20796f7520666f722066756e64696e6720796f7572207b24636f6d70616e796e616d657d20206163636f756e74202e0d0a0d0a3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d0d0a7b696620202463726564697461646465647d43726564697420416464656420696e20596f7572204163636f756e74203a207b2463726564697461646465647d200d0a3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d0d0a7b2f69667d200d0a7b6966202024637265646974726562617465647d43726564697420526562617465642046726f6d20596f7572204163636f756e74203a207b24637265646974726562617465647d0d0a3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d0d0a7b2f69667d0d0a7b696620202473656c6c63726564697461646465647d2053656c6c2043726564697420416464656420696e20596f7572204163636f756e74203a207b2473656c6c63726564697461646465647d0d0a3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d0d0a7b2f69667d0d0a7b696620202473656c6c637265646974726562617465647d2053656c6c2043726564697420526562617465642046726f6d20596f7572204163636f756e74203a207b2473656c6c637265646974726562617465647d0d0a3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d0d0a7b2f69667d0d0a0d0a4163636f756e742062616c616e63652061667465722046756e64696e67203a207b246372656469742e6372656469747d0d0a7b6966202473656c6c6372656469746164646564206f72202473656c6c637265646974726562617465647d20546f74616c20417661696c61626c652053656c6c20437265646974203a207b246372656469742e73656c6c696e675f6c696d69747d20207b2f69667d0d0a0d0a3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d0d0a7b24757365726e6f74657d0d0a5472616e73616374696f6e204944207b247472616e73616374696f6e69647d0d0a0d0a0d0a7b2461646d696e7369676e61747572657d20202020202020202020, '', '', '0', '', '', '', 1, 1, '{$creditadded}-Added new credit,\r\n{$sellcreditadded}- Added new sell credit,\r\n{$creditrebated}-Rebated Credit,\r\n{$sellcreditrebated}-Rebated Sell credit,\r\n{$credit.selling_limit}-Sell Credit Limit ', 0, 0, '', 0),
(9, 'general', 'Welcome Email', 0x57656c636f6d6520746f207b24636f6d70616e796e616d657d, 0x20200d0a44656172207b24757365726e616d657d0d0a0d0a5468616e6b20796f7520666f72207369676e696e6720757020666f722061207b24636f6d70616e796e616d657d206163636f756e742e0d0a0d0a596f752077696c6c2066696e64206120636f7079206f6620796f757220726567697374726174696f6e2064657461696c732062656c6f7720616e642061206c696e6b20746f20746865207465726d73207768696368206170706c7920746f20796f757220726567697374726174696f6e2e20506c65617365207072696e74207468657365206f666620616e64206b65657020696e2061207361666520706c61636520666f7220667574757265207265666572656e63652e0d0a0d0a3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d0d0a526567697374726174696f6e2064657461696c732028706c65617365206b6565702073616665290d0a557365726e616d65203a207b24757365726e616d657d0d0a50617373776f72642020203a207b6966202470617373776f72645f756e63727970747d207b2470617373776f72645f756e63727970747d207b656c73657d202a2a48494444454e2a2a207b2f69667d202020202020200d0a4d61737465722050696e20203a207b2470696e7d0d0a3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d0d0a0d0a596f752077696c6c206e65656420746f20656e74657220796f757220557365726e616d6520616e642050617373776f7264207768656e6576657220796f752075736520796f7572207b24636f6d70616e796e616d657d206163636f756e742e0d0a0d0a546f20726576696577206f722075706461746520796f757220726567697374726174696f6e2064657461696c732c207369676e20696e20746f20796f7572207b24636f6d70616e796e616d657d206163636f756e74206f6e2061207b2473697465616464726573737d202e0d0a0d0a7b2461646d696e7369676e61747572657d202020202020202020, '', '', '0', '', '', '', 1, 1, '{$password_uncrypt}- Unencrypted Password', 0, 0, '', 0),
(10, 'general', 'Password Reset by Admin', 0x7b24636f6d70616e796e616d657d202d20596f75722061636365737320696e666f726d6174696f6e, 0x3c703e44656172207b24757365726e616d657d3c2f703e0d0a3c703e203c2f703e0d0a3c703e203c2f703e0d0a3c703e596f7520686176652072657175657374656420796f75722070617373776f72642e3c2f703e0d0a3c703e203c2f703e0d0a3c703e3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3c2f703e0d0a3c703e596f7572206c6f67696e20646174612069733a3c2f703e0d0a3c703e596f7572204e65772050617373776f7264206973203a207b2470617373776f72647d3c2f703e0d0a3c703e3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3c2f703e0d0a3c703e7b2461646d696e7369676e61747572657d3c2f703e, '', '', '0', '', '', '', 0, 1, '{$password}-User Password', 0, 0, '', 0),
(11, 'general', 'API Access Details', 0x7b24636f6d70616e796e616d657d202d204150692061636365737320696e666f726d6174696f6e, 0x3c703e44656172207b24757365726e616d657d3c2f703e0d0a3c703e5468652072656d6f74652041504920616c6c6f777320796f7520746f207265717565737420636f6465732c20676574206163636f756e7420696e666f726d6174696f6e20616e6420636865636b2074686520737461747573206f6620796f7572206f726465727320776974686f757420686176696e6720746865206e65656420746f206c6f67696e20746f20746865206f757220736974652e3c2f703e0d0a3c703e5468697320616c6c6f777320796f7520746f20696e7465677261746520796f7572206f776e20736974652077697468206f7572732e3c2f703e0d0a3c703e57652068617665206d616465206f75722072656d6f74652041504920696e746572666163652072656c61746976656c792073696d706c7920746f2075736520736f20616e796f6e65207769746820616e792061206c6974746c6520584d4c20616e642050485020657870657269656e63652073686f756c642062652061626c6520746f20696d706c656d656e7420616e6420646576656c6f7020612073797374656d20746f20757365206f6e20746865697220736974652e3c2f703e0d0a3c703e596f752063616e20616c736f20446f776e6c6f61642041706920646f63756d656e74203a207b2473697465616464726573737d6170692e7a69703c2f703e0d0a3c703e3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3c2f703e0d0a3c703e596f75722041504920416363657373204b6579203a207b246170696163636573736b65797d3c2f703e0d0a3c703e3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3c2f703e0d0a3c703e7b2461646d696e7369676e61747572657d3c2f703e, '', '', '0', '', '', '', 0, 0, '{$apiaccesskey} - API Access Key', 0, 0, '', 0),
(14, 'imeiorder', 'IMEI Order success notification', 0x596f757220756e6c6f636b20636f6465, 0x202020202020202020200d0a44656172207b24757365726e616d657d0d0a0d0a596f757220756e6c6f636b20636f646520666f7220796f7572206d6f62696c652070686f6e6520494d4549203a207b24696d65697d20686173207375636365737366756c6c79206265656e2063616c63756c617465642e0d0a7b6966202024636f6d6d656e74737d2a2a207b24636f6d6d656e74737d7b2f69667d0d0a0d0a3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d0d0a556e6c6f636b20636f6465203a20207b247265706c797d0d0a3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d0d0a4f72646572732064657461696c730d0a4f72646572204944203a207b246f7264657269647d0d0a53657276696365204e616d65203a207b24736572766963657d0d0a437265646974203a207b246f726465726372656469747d0d0a7b696620246d6f64656c7d204d6f64656c203a207b246d6f64656c7d7b2f69667d0d0a7b6966202470726f76696465727d50726f7669646572203a207b2470726f76696465727d7b2f69667d0d0a7b696620246d65707d4d4550203a207b246d65707d7b2f69667d0d0a7b6966202470696e7d50494e20203a207b2470696e7d7b2f69667d0d0a7b696620246b62687d4b4248203a207b246b62687d7b2f69667d0d0a7b696620247072647d505244203a207b247072647d7b2f69667d0d0a7b69662024747970657d54797065203a207b24747970657d7b2f69667d0d0a7b696620247265666572656e63657d5265666572656e636520203a20207b247265666572656e63657d7b2f69667d0d0a7b696620246c6f636b737d4c6f636b7320203a20207b246c6f636b737d7b2f69667d0d0a7b666f72656163682066726f6d3d24637573746f6d206b65793d6964206974656d3d6373747d0d0a7b696620246373742e76616c75657d7b246373742e6e616d657d203a207b246373742e76616c75657d7b2f69667d0d0a7b2f666f72656163687d0d0a0d0a3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d0d0a0d0a0d0a0d0a7b2461646d696e7369676e61747572657d20202020, '', '', '0', '', '', '', 1, 1, '{$orderid}- Order ID , {$imei} - IMEI No, {$note} - Notes , {$comments} - Comments , {$ordercredit} - Credit For Order , {$model} - Model Name , {$provider} - Provider Name , {$mep} - MEP , {$pin} - PIN Number , {$kbh} - KBH , {$prd} - PRD , {$type}- Type ,{$reference} - Reference , {$locks} - Locks ,{$comments}- User Comments,\n{$reply}- Admin Reply', 0, 0, '', 0),
(15, 'general', 'orders send to supplier', 0x7b24636f6d70616e796e616d657d202d204e6577206f7264657273, 0x3c703e596f7520676f74206e6577206f72646572732066726f6d207b24636f6d70616e796e616d657d3c2f703e0d0a3c703e4f72646572732066696c6520686173206265656e2061747461636865642062656c6f77202e3c2f703e0d0a3c703e7b246f726465726c6973747d3c2f703e0d0a3c703e3c6272202f3e7b2461646d696e7369676e61747572657d3c2f703e, '', '', '0', '', '', '', 0, 0, '', 0, 0, '', 0),
(16, 'fileorder', 'File Order success', 0x4f726465722063616c63756c61746564207375636365737366756c6c79, 0x202020202020202020202020202020200d0a44656172207b24757365726e616d657d0d0a0d0a596f7572206f7264657220666f72207b24736572766963657d20686173207375636365737366756c6c79206265656e2063616c63756c617465642e0d0a7b6966202024636f6d6d656e74737d2a2a207b24636f6d6d656e74737d7b2f69667d0d0a0d0a3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d0d0a7b696620247265706c797d20436f6465203a20207b247265706c797d20202020207b656c73657d20596f75722066696c652069732061747461636865642068657265202e207b2f69667d2020200d0a3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d0d0a0d0a4f72646572732064657461696c730d0a53657276696365203a207b24736572766963657d0d0a437265646974203a207b246f726465726372656469747d0d0a7b666f72656163682066726f6d3d24637573746f6d206b65793d6964206974656d3d6373747d0d0a7b696620246373742e76616c75657d7b246373742e6e616d657d203a207b246373742e76616c75657d7b2f69667d0d0a7b2f666f72656163687d0d0a0d0a3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d0d0a0d0a0d0a0d0a7b2461646d696e7369676e61747572657d2020202020202020, '', '', '0', '', '', '', 1, 1, '{$service}- Service Name, {$ordercredit} - Credit of Order,{$notes} - Notes , {$comments} - Comments', 0, 1, '', 0),
(17, 'serverorder', 'Server Order successfull', 0x4f726465722063616c63756c61746564207375636365737366756c6c79, 0x2020202020202020202020200a44656172207b24757365726e616d657d0a0a596f7572206f7264657220666f72207b24736572766963657d20686173207375636365737366756c6c79206265656e2063616c63756c617465642e0a7b6966202024636f6d6d656e74737d2a2a207b24636f6d6d656e74737d7b2f69667d0a0a3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d0a7b247265706c797d0a3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d0a4f72646572732064657461696c730a5365727669636520203a207b24736572766963657d0a437265646974203a207b246f726465726372656469747d0a7b666f72656163682066726f6d3d24637573746f6d206b65793d6964206974656d3d6373747d0a7b246373742e6e616d657d203a20207b246373742e76616c75657d0a7b2f666f72656163687d200a0a3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d0a0a0a0a7b24666565646261636b6c696e6b7d0a0a0a7b2461646d696e7369676e61747572657d2020202020, '', '', '0', '', '', '', 1, 1, '{$service}- Service Name, {$ordercredit} - Credit of Order,{$notes} - Notes , {$comments} - Comments,\r\n{$feedbacklink}-Order feedback link', 0, 0, '', 0),
(31, 'invoice', 'invoice generated', 0x496e766f69636520237b24696e766f69636569647d, 0x44656172207b24757365726e616d657d0d0a0d0a546869732069732061206e6f74696365207468617420616e20696e766f69636520237b24696e766f69636569647d20686173206265656e2067656e6572617465642e0d0a0d0a0d0a0d0a7b2461646d696e7369676e61747572657d, '', '', '', '', '', '', 1, 1, '{$invoiceid}- Invoice Number', 0, 0, '', 0),
(30, 'invoice', 'Payment received confirmation', 0x5061796d656e7420726563656976656420636f6e6669726d6174696f6e, 0x44656172207b24757365726e616d657d20200d0a0d0a0d0a5061796d656e7420726563656976656420636f6e6669726d6174696f6e202e0d0a5468616e6b20796f7520666f72207061796d656e74202e0d0a496e766f696365203a207b24696e766f6963657d0d0a416d6f756e7420203a207b247061796d656e747d0d0a0d0a0d0a0d0a0d0a7b2461646d696e7369676e61747572657d20202020, '', '', '0', '', '', '', 1, 1, '', 0, 0, '', 0),
(46, 'newsletter', 'Monthly News Letter ', 0x4d6f6e74686c79204e657773204c657474657220, 0x4e65772053657276696365730d0a0d0a507269636520446f776e0d0a0d0a4f666665727320, '', '', '0', '', '', '', 1, 0, '', 0, 0, '', 0),
(38, 'invoice', 'First Notification for Unpaid Invoice', 0x466972737420496e766f696365204f766572647565204e6f74696365, 0x44656172207b24757365727d0d0a0d0a20202020202020202020205468697320697320612062696c6c696e67206e6f74696365207468617420796f757220696e766f696365206e6f2e207b24696e7669647d206973206e6f77206f7665726475652e0d0a0d0a0d0a7b2461646d696e7369676e61747572657d2020, '', '', '', '', '', '', 1, 1, '{$invid}-Invoice ID', 0, 0, '', 0),
(39, 'invoice', 'Second Notification for Unpaid Invoice', 0x5365636f6e6420496e766f696365204f766572647565204e6f74696365, 0x2044656172207b24757365727d0d0a0d0a20202020202020202020205468697320697320746865207365636f6e642062696c6c696e67206e6f74696365207468617420796f757220696e766f6963652023207b24696e7669647d206973206e6f77206f7665726475652e0d0a0d0a0d0a7b2461646d696e7369676e61747572657d202020, '', '', '', '', '', '', 1, 1, '{$invid}-Invoice Number', 0, 0, '', 0),
(40, 'invoice', 'Third Notification for Unpaid Invoice', 0x546869726420496e766f696365204f766572647565204e6f74696365, 0x44656172207b24757365727d0d0a0d0a2020202020202020202020546869732069732074686520746869726420616e642066696e616c2062696c6c696e67206e6f74696365207468617420796f757220696e766f6963652023207b24696e7669647d206973206e6f77206f7665726475652e200d0a0d0a0d0a7b2461646d696e7369676e61747572657d2020202020, '', '', '0', '', '', '', 1, 1, '{$invid}-Invoice Number', 0, 0, '', 0),
(41, 'general', 'We are Missing', 0x7b24636f6d70616e796e616d657d204d697373696e6720796f75, 0x20202020200d0a44656172207b24757365726e616d657d0d0a0d0a202020202020202046726f6d206c617374206c6f6e672074696d6520796f7520617265206e6f7420617070656172206f6e206f75722073697465202c2063616e20692068656c7020796f752077697468207072696365206f7220616e79206d6174746572203f0d0a0d0a7b2461646d696e7369676e61747572657d2020, '', '', '0', '', '', '', 1, 1, '', 0, 0, '', 0),
(42, 'general', 'Low credit limit', 0x555247454e543a204c6f772062616c616e636520696e20796f7572204163636f756e7420, 0x202020200d0a44656172207b24757365726e616d657d0d0a0d0a5468697320697320746f206e6f7469667920796f7520746861742046756e647320756e64657220796f757220526573656c6c6572206163636f756e7420686176652064726f707065642062656c6f7720796f7572207468726573686f6c64206c6576656c206f662055534420313020596f7520617265206164766973656420746f20696d6d6564696174656c792072656d69742066756e647320736f207468617420796f757220437573746f6d6572732f5375622d526573656c6c65727320616e6420796f752063616e20636f6e74696e756520746f20706c616365204f72646572732e20506c6561736520666f6c6c6f77207468652070726f636573732062656c6f7720666f7220616464696e672066756e647320746f20796f7572206163636f756e742e0d0a0d0a312e204c6f67696e20746f203a207b2473697465616464726573737d0d0a0d0a322e20436c69636b206f6e204164642046756e6473200d0a0d0a0d0a7b2461646d696e7369676e61747572657d2020200d0a0d0a0d0a0d0a, '', '', '', '', '', '', 1, 1, '', 0, 0, '', 0),
(43, 'general', 'Credit validity expires', 0x4372656469742076616c69646974792065787069726174696f6e20706572696f64206973206e656172, 0x202044656172207b24757365726e616d657d0d0a0d0a506c656173652075706461746520796f7572206372656469742065787069726174696f6e2074696d65202e0d0a0d0a0d0a7b2461646d696e7369676e61747572657d2020202020, '', '', '0', '', '', '', 1, 1, '', 0, 0, '', 0),
(44, 'fileorder', 'File Order Cancelled', 0x4f726465722050726f63657373696e67204661696c757265, 0x20202020202020200d0a44656172207b24757365726e616d657d0d0a0d0a596f7572206f7264657220666f72207b24736572766963657d20206861732070726f63657373696e67206661696c757265202e0d0a526561736f6e20203a20207b24726561736f6e7d20200d0a0d0a0d0a0d0a7b2461646d696e7369676e61747572657d202020202020, '', '', '', '', '', '', 1, 1, '{$service}- Service Name,\r\n{$reason}- Order failure reason', 0, 1, '', 0),
(45, 'serverorder', 'Server Order Cancelled', 0x4f726465722050726f63657373696e67204661696c757265, 0x202020202020200d0a44656172207b24757365726e616d657d0d0a0d0a596f7572206f7264657220666f72207b24736572766963657d206861732070726f63657373696e67206661696c757265202e0d0a526561736f6e20203a20207b24726561736f6e7d20200d0a0d0a0d0a0d0a7b2461646d696e7369676e61747572657d2020202020, '', '', '', '', '', '', 1, 1, '{$service}- Service Name,\r\n{$reason}- Order failure reason', 0, 1, '', 0),
(49, 'product', 'Send shipping details', 0x596f7572206f7264657220686173206265656e2073686970706564, 0x20202020202020202020202020200d0a44656172207b24757365726e616d657d0d0a0d0a0d0a596f7572206f7264657220686173206265656e2073686970706564206279207b247368697070696e675f6761747761797d2020616e6420796f757220747261636b696e6720696420207b24747261636b696e69647d0d0a547261636b696e672055524c203a207b24747261636b696e6775726c7d0d0a0d0a3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d0d0a4f72646572732064657461696c730d0a4f72646572204944203a207b246f7264657269647d0d0a4974656d203a207b24736572766963657d0d0a0d0a0d0a7b666f72656163682066726f6d3d24637573746f6d206b65793d6964206974656d3d6373747d0d0a7b696620246373742e76616c75657d7b246373742e6e616d657d203a207b246373742e76616c75657d7b2f69667d0d0a7b2f666f72656163687d0d0a0d0a3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d0d0a0d0a7b24666565646261636b6c696e6b7d0d0a0d0a7b696620246c696e6b7d0d0a436c69636b206f6e2074686973207b246c696e6b7d20746f206769766520796f757220666565646261636b0d0a7b2f69667d0d0a7b2461646d696e7369676e61747572657d2020202020, '', '', '0', '', '', '', 1, 1, '{$trackinid}-Order Tracking ID,\r\n{$trackingurl}-Shipping order tracking URL,\r\n{$orderid}- Order ID,\r\n{$service}-Item Name,\r\n{$feedbacklink}-Order Feedback link', 0, 0, '', 0),
(50, 'product', 'Shop Order Rejected', 0x596f75722053686f7070696e67204f726465722052656a6563746564, 0x2020202020200d0a44656172207b24757365726e616d657d0d0a0d0a596f7572206f7264657220666f72207b24736572766963657d206861732070726f63657373696e67206661696c757265202e0d0a526561736f6e20203a20207b24726561736f6e7d20200d0a0d0a0d0a2a2a20726566756e6420616d6f756e7420637265646974656420696e20796f7572206163636f756e74202a2a0d0a0d0a0d0a7b2461646d696e7369676e61747572657d2020, '', '', '', '', '', '', 1, 1, '{$service}-Item or Service Name,\r\n{$reason}-Order failure reason', 0, 0, '', 0),
(51, 'general', 'Security Warning [Country login mismatch]', 0x5365637572697479205761726e696e67205b436f756e747279206c6f67696e206d69736d617463685d, 0x20202020200d0a44656172207b24757365726e616d657d0d0a0d0a57652068617665206465746563746564206120737573706963696f7573206163746976697479206f6e20796f7572206163636f756e742e0d0a0d0a496620796f7520617265206e6f74206c6f67696e2066726f6d207b246c6f67696e69707d202d207b246c6f67696e636f756e7472797d287b246c6f67696e636f756e747279636f64657d2920706c6561736520636f6e7461637420757320617320736f6f6e20617320706f737369626c652e0d0a596f75206d61792062652076696374696d206f66206163636f756e742074686566742c20616e64207765206e65656420746f20636865636b20796f75722073656375726974792e0d0a0d0a0d0a57652061706f6c6f67697a6520666f722074686520686974636820616e6420686f706520796f7520756e6465727374616e64207468697320697320746f206265747465722070726f7465637420796f7572206163636f756e742e2020200d0a0d0a0d0a7b2461646d696e7369676e61747572657d2020, '', '', '0', '', '', '', 1, 0, '{$loginip}- Login IP,\r\n{$logincountry}- Login Country,\r\n{$logincountrycode}- Login Country Code', 0, 0, '1', 0),
(52, 'general', 'Subscription Start notice', 0x596f757220537562736372697074696f6e20666f72207b24747970657d, 0x2020200d0a44656172207b24757365726e616d657d0d0a0d0a202020202020202020596f757220537562736372697074696f6e206973206e6f772061637469766174656420666f722073657276696365207b24747970657d2066726f6d20746f646179207b24737562736372697074696f6e5f73746172747d20616e642077696c6c2065787069726564206f6e207b24737562736372697074696f6e5f656e647d20616674657220207b24646179737d2064617973202e0d0a0d0a7b2461646d696e7369676e61747572657d0d0a202020202020, '', '', '', '', '', '', 1, 1, '{$type} - Service Name,\r\n{$subscription_start} - Subscription Start Date,\r\n{$subscription_end} - Subscription End Date,\r\n{$days} - No of days between subscription start and end', 0, 0, '', 0),
(53, 'general', 'Subscription expired', 0x596f757220737562736372697074696f6e206578706972656420746f646179, 0x2020202020200d0a44656172207b24757365726e616d657d0d0a0d0a20202020202020202020596f757220537562736372697074696f6e20666f72207b24747970657d206973206578706972656420746f646179202e20666f722072656e657720706c6561736520636f6e74616374207573202e0d0a0d0a7b2461646d696e7369676e61747572657d2020, '', '', '', '', '', '', 1, 1, '{$type} - Service Name,\r\n{$subscription_start} - Subscription Start Date,\r\n{$subscription_end} - Subscription End Date,\r\n{$days} - No of days between subscription start and end', 0, 0, '', 0),
(54, 'general', 'Subscription Reminder', 0x537562736372697074696f6e204578706972792052656d696e646572, 0x200d0a44656172207b24757365726e616d657d0d0a0d0a20202020202020202020202020596f757220737562736372697074696f6e20666f72207b24747970657d2065787069726564206f6e207b24737562736372697074696f6e5f656e647d202c20506c6561736520636f6e7461637420796f757220737570706c69657220746f2072656e6577206974202e0d0a0d0a7b2461646d696e7369676e61747572657d, '', '', '', '', '', '', 1, 1, '{$type} -Subscribed service name,\r\n{$subscription_start} - Subscription Start Date,\r\n{$subscription_end} - Subscription End Date,\r\n{$days} - No of days between subscription start and end', 0, 0, '', 0),
(55, 'general', 'Security Warning [ Common ]', 0x5365637572697479205761726e696e672046726f6d207b24636f6d70616e796e616d657d, 0x20200d0a44656172207b24757365726e616d657d0d0a0d0a20546869732069732061207365637572697479206e6f7469636520746f206c657420796f75206b6e6f7720746861742074686520666f6c6c6f77696e67206576656e74206f63637572726564206f6e20796f7572206163636f756e743a200d0a203d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d0d0a207b246576656e747d200d0a203d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d0d0a0d0a20496620796f7520646964206e6f7420696e6974696174652074686973206576656e742c20706c6561736520636f6e7461637420757320617320736f6f6e20617320706f737369626c652e0d0a20596f75206d61792062652076696374696d206f66206163636f756e742074686566742c20616e64207765206e65656420746f20636865636b20796f75722073656375726974792e0d0a0d0a207b2461646d696e7369676e61747572657d202020, '', '', '', '', '', '', 1, 0, '{$event} - Perticular events information when this sercurity mail generated ', 0, 0, '', 0),
(56, 'general', 'New Maser Pin', 0x4e6577204d617365722050696e20666f72207b24636f6d70616e796e616d657d, 0x2020200d0a44656172207b24757365726e616d657d0d0a200d0a596f7572204d61737465722050696e2069732075706461746564202c200d0a3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d0d0a596f7572206e6577206d61737465722070696e206973203a207b246d617374657270696e7d200d0a3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d0d0a0d0a7b2461646d696e7369676e61747572657d202020, '', '', '', '', '', '', 1, 0, '{$masterpin} - Master Pin number', 0, 0, '', 0),
(76, 'imeiorder', 'New order placed', 0x4e657720494d4549206f7264657220706c616365642066726f6d20796f7572206163636f756e74, 0x202044656172207b24757365726e616d657d0d0a0d0a0d0a202020202020204e6577206f72646572206f66207b24736572766963657d20706c616365642066726f6d20796f7572206163636f756e74200d0a200d0a7b24696d65696c6973747d0d0a0d0a7b2461646d696e7369676e61747572657d2020, '', '', '0', '', '', '', 1, 0, '', 0, 0, '', 0),
(69, 'invoice', 'Invoice Transaction Refund', 0x596f757220526566756e6420666f7220496e766f696365203a207b24696e766f69636569647d, 0x44656172207b24757365726e616d657d0d0a0d0a596f7572206163636f756e7420726566756e646564207769746820616d6f756e74207b24616d6f756e747d20666f7220496e766f696365203a207b24696e766f6963657d0d0a0d0a20, '', '', '0', '', '', '', 1, 0, '', 0, 0, '', 0),
(57, 'supportticket', 'New ticket open', 0x7b247375626a6563747d, 0x20200a3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d5245504c592041424f56452054484953204c494e453d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d0a0a44656172207b24757365726e616d657d2c0a0a5468616e6b20796f7520666f7220636f6e74616374696e67206f757220737570706f7274207465616d2e204120737570706f7274207469636b657420686173206e6f77206265656e206f70656e656420666f7220796f757220726571756573742e20596f752077696c6c206265206e6f746966696564207768656e206120726573706f6e7365206973206d61646520627920656d61696c2e205468652064657461696c73206f6620796f7572207469636b6574206172652073686f776e2062656c6f772e0a0a5375626a6563743a207b247469636b65747375626a6563747d0a5374617475733a204f70656e0a0a596f752063616e207669657720746865207469636b657420617420616e792074696d65206174207b24766965777469636b65746c696e6b7d0a0a7b2461646d696e7369676e61747572657d0a2020, '', '', '', '', '', '', 1, 0, '{$ticketsubject}-Ticket subject,{$viewticketlink}-View ticket link ', 0, 0, '', 0),
(58, 'supportticket', 'Reply ticket', 0x7b247375626a6563747d, 0x2020200d0a3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d5245504c592041424f56452054484953204c494e453d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d0d0a0d0a7b247469636b65747265706c797d0d0a0d0a0d0a0d0a3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d0d0a5469636b65742049443a20237b247469636b657469647d0d0a5375626a6563743a207b247469636b65747375626a6563747d0d0a5374617475733a20416e7377657265640d0a5469636b65742055524c3a207b24766965777469636b65746c696e6b7d0d0a3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d0d0a0d0a0d0a7b2473746166667369676e61747572657d0d0a0d0a7b2461646d696e7369676e61747572657d202020, '', '', '', '', '', '', 1, 0, '{$ticketreply}- Reply of staff,{$ticketid}-Ticket ID,{$ticketsubject}-Ticket Subject,{$viewticketlink}- View ticket Link on site,{$staffsignature}- Answered staff signature\r\n', 0, 0, '', 0),
(59, 'product', 'When Resellers User complete order', 0x596f75722055736572206d616465206f72646572207375636365737366756c6c79, 0x20436f6e67726174756c6174696f6e202c0d0a0d0a0d0a20202020202020202020202020596f7572205573657220706c61636564206f7264657220616e64207061796d656e7420636f6d706c65746564202e200d0a0d0a20202020202020202020202020416e6420796f757220636f6d6d697373696f6e207b24616d6f756e747d20637265646974656420696e20796f7572206163636f756e742e0d0a0d0a0d0a0d0a0d0a0d0a7b2461646d696e7369676e61747572657d, '', '', '', '', '', '', 1, 0, '{$amount}-Amount of order placed by resellers user', 0, 0, '', 0),
(60, 'supportticket', 'Ticket auto closed', 0x596f7572205469636b6574205b7b247469636b657469647d5d20636c6f736564, 0x2044656172207b24757365726e616d657d0d0a0d0a2020202020202020202020596f7572205469636b6574207b247469636b657469647d20636c6f736564206175746f6d61746963616c6c79202062656361757365206e6f74207265706c6965642066726f6d206c617374207b24686f7572737d20686f7572730d0a200d0a2020202020202020202020202020200d0a20202020202020202020202020, '', '', '', '', '', '', 1, 0, '{$ticketid}-Support Ticket Id,{$hours}-No of hours before closed', 0, 0, '', 0),
(61, 'affiliate', 'Affiliate Commission ', 0x436f6e67726174756c6174696f6e20796f7572205573657220686173206d616465206f72646572, 0x3c703e436f6e67726174756c6174696f6e732120596f752068617665206265656e20637265646974656420726566657272616c20616d6f756e74207b24636f6d6d697373696f6e7d20666f7220796f757220726566657272616c2e3c6272202f3e3c6272202f3e3c6272202f3e3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3c2f703e0d0a3c703e5349474e55502044455441494c533c6272202f3e557365726e616d65203a207b24757365726e616d657d3c6272202f3e50726f64756374203a207b2470726f647563747d3c6272202f3e3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3c6272202f3e3c6272202f3e3c6272202f3e526566657272696e672066726f6d20706167653a203c6120687265663d22687474703a2f2f646872752e636f6d2f22207461726765743d225f626c616e6b222072656c3d226e6f6f70656e6572223e687474703a2f2f796f7572776562736974652e636f6d2f3c2f613e3c6272202f3e3c6272202f3e596f752063616e206c6f67696e20746f20796f757220616666696c69617465206d616e6167656d656e742063656e746572206174203a2053797374656d205572693c6272202f3e746f2073656520796f757220616666696c6961746520636f6e76657273696f6e207374617469737469637320616e642070656e64696e67207061796d656e74732e3c6272202f3e3c6272202f3e3c6272202f3e3c61207374796c653d22746578742d6465636f726174696f6e3a206e6f6e653b223e7b2461646d696e7369676e61747572657d3c2f613e3c2f703e, '', '', '0', '0', '', '', 0, 0, '{$commission}-Referral commission amount,\r\n{$username}-Registered Username,\r\n{$product}-Purchased Product', 0, 0, '', 0),
(62, 'resellerstore', 'Add fund Error', 0x596f7520686176656e742073756666696369656e742062616c616e6365, 0x44656172207b24757365726e616d657d0d0a0d0a200d0a0d0a596f75722075736572207b24757365727d206861732070617920796f752062792050617970616c0d0a0d0a416d6f756e74203a207b24616d6f756e747d0d0a0d0a5472616e73616374696f6e204944203a207b247472616e73616374696f6e69647d0d0a0d0a200d0a0d0a42757420796f7520686176656e27742073756666696369656e742062616c616e636520736f20706c7320636f6d706c6574652070726f63657373206d616e75616c6c790d0a0d0a200d0a0d0a7b2461646d696e7369676e61747572657d, '', '', '0', '', '', '', 1, 0, '{$amount}-Amount Transffered,\r\n{$transactionid}-Transaction ID', 0, 0, '', 0),
(63, 'resellerstore', 'Add Fund success', 0x55736572206d616465207061796d656e74, 0x44656172207b24757365726e616d657d0d0a0d0a200d0a0d0a7b24757365727d20686173206d616465207061796d656e742062792070617970616c20746f20796f7572206163636f756e7420666f72206164642066756e640d0a0d0a200d0a0d0a3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d0d0a0d0a416d6f756e74203a207b24616d6f756e747d0d0a0d0a3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d0d0a0d0a200d0a0d0a200d0a0d0a7b2461646d696e7369676e61747572657d, '', '', '0', '', '', '', 1, 0, '{$amount}- Fund amount', 0, 0, '', 0),
(64, 'imeiorderbulk', 'Bulk reply in single mail', 0x596f757220756e6c6f636b20636f6465, 0x202044656172207b24757365726e616d657d0d0a0d0a596f757220756e6c6f636b20636f646520686173206265656e207375636365737366756c6c792063616c63756c617465642e0d0a0d0a7b666f72656163682066726f6d3d247265706c7961727279206974656d3d7265706c797d0d0a203d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d0d0a494d4549203a207b247265706c792e696d65697d0d0a556e6c6f636b20636f6465203a20207b247265706c792e7265706c797d0d0a4f72646572732064657461696c730d0a4f72646572204944203a207b247265706c792e6f7264657269647d0d0a53657276696365204e616d65203a207b247265706c792e736572766963657d0d0a437265646974203a207b247265706c792e6f726465726372656469747d0d0a7b696620247265706c792e6d6f64656c7d204d6f64656c203a207b247265706c792e6d6f64656c7d7b2f69667d0d0a7b696620247265706c792e70726f76696465727d50726f7669646572203a207b247265706c792e70726f76696465727d7b2f69667d0d0a7b696620247265706c792e6d65707d4d4550203a207b247265706c792e6d65707d7b2f69667d0d0a7b696620247265706c792e70696e7d50494e20203a207b247265706c792e70696e7d7b2f69667d0d0a7b696620247265706c792e6b62687d4b4248203a207b247265706c792e6b62687d7b2f69667d0d0a7b696620247265706c792e7072647d505244203a207b247265706c792e7072647d7b2f69667d0d0a7b696620247265706c792e747970657d54797065203a207b247265706c792e747970657d7b2f69667d0d0a7b696620247265706c792e7265666572656e63657d5265666572656e636520203a20207b247265706c792e7265666572656e63657d7b2f69667d0d0a7b696620247265706c792e6c6f636b737d4c6f636b7320203a20207b247265706c792e6c6f636b737d7b2f69667d0d0a7b666f72656163682066726f6d3d247265706c792e637573746f6d206b65793d6964206974656d3d6373747d0d0a7b696620246373742e76616c75657d7b246373742e6e616d657d203a207b246373742e76616c75657d7b2f69667d0d0a7b2f666f72656163687d0d0a0d0a7b69662020247265706c792e636f6d6d656e74737d2a2a207b247265706c792e636f6d6d656e74737d207b2f69667d0d0a0d0a3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d0d0a0d0a7b2f666f72656163687d0d0a0d0a0d0a0d0a7b2461646d696e7369676e61747572657d202020, '', '', '0', '', '', '', 1, 1, '{$orderid}- Order ID , {$imei} - IMEI No, {$note} - Notes , {$comments} - Comments , {$ordercredit} - Credit For Order , {$model} - Model Name , {$provider} - Provider Name , {$mep} - MEP , {$pin} - PIN Number , {$kbh} - KBH , {$prd} - PRD , {$type}- Type ,{$reference} - Reference , {$locks} - Locks ,{$comments}- User Comments,\r\n{$reply}- Admin Reply', 0, 0, '', 0),
(65, 'resellerstore', 'New User registered on Store', 0x4e657720557365722072656769737465726564206f6e20796f75722073746f7265, 0x44656172207b24757365727d0d0a0d0a200d0a0d0a4e65772075736572206a757374207369676e207570206f6e20796f757220736974650d0a0d0a44657461696c730d0a0d0a3d3d3d3d3d3d3d3d3d3d0d0a0d0a557365726e616d65203a207b24757365726e616d657d0d0a0d0a4669727374204e616d653a207b2466697273746e616d657d0d0a0d0a4c617374204e616d65203a207b246c6173746e616d657d0d0a0d0a50686f6e65204e6f203a207b2470686f6e656e756d6265727d0d0a0d0a456d61696c203a207b24656d61696c7d, '', '', '0', '', '', '', 1, 0, '{$username}-Registered users Username,\r\n{$firstname}-Registered users Firstname,\r\n{$lastname}-Registered users Last Name,\r\n{$phonenumber}-Reistered users Phonenumber,\r\n{$email}-Reistered users E-mail', 0, 0, '', 0),
(68, 'general', 'When direct order placed', 0x596f7572206f7264657220666f72207b24736572766963657d20686173206265656e2070726f63657373207375636365737366756c6c79, 0x4465617220437573746f6d65720d0a0d0a202020202020202020596f7572206f7264657220666f72207b24736572766963657d20686173206265656e2070726f63657373207375636365737366756c6c790d0a202020202020202020746f20636f6d706c65746520796f7572206f72646572206f70656e2074686973206c696e6b207b246c696e6b7d0d0a202020202020202020616e64207375626d697420667572746865722064657461696c73206c696b6520796f757220494d4549206d6164652020286469616c202a2330362320746f206765742074686520494d4549290d0a206574632e2e0d0a0d0a20202020202020202077652070726f6365737320796f7572206f726465722073686f72746c79206f6e636520776520676f7420796f75722064657461696c73202e0d0a0d0a202020202020202020696620796f7520617265206e6f7420206f70656e206c696e6b206469726563746c79206a75737420636f707920616e6420706573742074686973206c696e6b20696e20796f75722062726f777365720d0a0d0a0d0a0d0a7b2461646d696e7369676e61747572657d2020202020, '', '', '0', '', '', '', 1, 0, '', 0, 0, '', 0),
(70, 'general', 'Return request for order', 0x52657475726e2052657175657374, 0x3c703e44656172207b24757365726e616d657d3c2f703e0d0a3c703e203c2f703e0d0a3c703e52657475726e205265717565737420666f7220796f7572206f726465723c2f703e0d0a3c703e64657461696c7320617265202e2e2e3c2f703e0d0a3c703e203c2f703e0d0a3c703e4974656d73203a207b2470726f647563747d3c2f703e0d0a3c703e526561736f6e3a207b24726561736f6e7d3c2f703e0d0a3c703e416374696f6e203a207b24616374696f6e7d3c2f703e0d0a3c703e436f6d6d656e743a207b24636f6d6d656e747d3c2f703e0d0a3c703e506c656173652073656e64204974656d20746f203a3c2f703e0d0a3c703e52657475726e204964203a207b2472656669647d3c2f703e0d0a3c703e3c7370616e3e7b24616464726573737d3c2f7370616e3e3c2f703e0d0a7b696620247374617475737d0d0a537461747573203a207b247374617475737d0d0a7b2f69667d0d0a3c703e203c2f703e, '', '', '', '', '', '', 0, 0, '', 0, 0, '', 0),
(67, 'general', 'Withdrawal Request Accepted', 0x5769746864726177616c205265717565737420686173206265656e2070726f636573736564, 0x44656172207b24757365727d0d0a0d0a596f7572207769746864726177616c205265717565737420666f7220616d6f756e74207b24616d6f756e747d2020686173206265656e2070726f6365737365640d0a0d0a44657461696c73200d0a3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d0d0a416d6f756e74202020202020202020203a207b24616d6f756e747d0d0a5472616e73616374696f6e204944203a207b247472616e73616374696f6e69647d0d0a47617465776179202020202020202020203a207b24676174657761797d0d0a202020202020, '', '', '0', '', '', '', 1, 0, '{$amount}-Withdrawal Amount,($transactionid}- Withdraw transaction ID,{$gatewa}- Payment Gateway used for withdraw', 0, 0, '', 0),
(66, 'general', 'Withdrawal Request Rejected', 0x5769746864726177616c20526571756573742052656a6563746564, 0x44656172207b24757365727d0d0a0d0a0d0a596f7572205769746864726177616c20526571756573742052656a65637465642062656361757365207b24726561736f6e7d, '', '', '', '', '', '', 1, 0, '{$reason}-Withdrawal request rejected reason', 0, 0, '', 0),
(71, 'general', 'Gift Certificate', 0x596f757220676f7420476966742066726f6d207b2466726f6d7d, 0x200d0a44656172207b24757365726e616d657d0d0a0d0a596f75722047696674206365727469666963617465206f6620616d6f756e74202d207b24616d6f756e747d0d0a596f757220436f75706f6e20436f6465202d207b24636f75706f6e7d0d0a7b246d6573736167657d0d0a0d0a20, '', '', '', '', '', '', 1, 0, '', 0, 0, '', 0),
(72, 'product', 'Product Reorder', 0x50726f647563742072656f7264657220, 0x44656172207b24757365726e616d657d0d0a0d0a596f7572206e6577206f726465722067656e657261746564202e0d0a496e766f69636520496420203a207b24696e766f69636569647d0d0a0d0a4974656d204c697374203a0d0a7b2464657461696c7d20200d0a0d0a7b2461646d696e7369676e61747572657d202020, '', '', '0', '', '', '', 1, 0, '', 0, 0, '', 0),
(73, 'product', 'Price update notification', 0x4974656d732050726963652055706461746564, 0x3c7461626c65207374796c653d2277696474683a20313030253b20626f726465722d636f6c6c617073653a20636f6c6c617073653b206261636b67726f756e643a20236634663466343b223e0d0a3c74626f64793e0d0a3c74723e0d0a3c74643e0d0a3c646976207374796c653d226d617267696e3a20307078206175746f20343070783b2077696474683a2036353070783b206261636b67726f756e643a2077686974653b223e0d0a3c646976207374796c653d22746578742d616c69676e3a2063656e7465723b2070616464696e673a20313570783b223e0d0a3c6831207374796c653d226d617267696e3a20303b223e7b24636f6d70616e796e616d657d3c2f68313e0d0a3c736d616c6c207374796c653d22666f6e742d73697a653a20313570783b223e205b7b24646174657d5d203c2f736d616c6c3e3c2f6469763e0d0a3c646976207374796c653d226261636b67726f756e642d636f6c6f723a20233066303135653b206261636b67726f756e642d696d6167653a2072616469616c2d6772616469656e742866617274686573742d636f726e65722061742035302520313030252c2072676261283132332c32322c3235352c302e3735292c2330463031354520293b2070616464696e673a20323070783b20746578742d616c69676e3a2063656e7465723b223e0d0a3c6831207374796c653d22666f6e742d73697a653a20333070783b20636f6c6f723a2077686974653b20666f6e742d7765696768743a206e6f726d616c3b223e466f6c6c6f77696e67204974656d73205072696365206368616e67656420746f6461793c2f68313e0d0a3c6832207374796c653d22666f6e742d73697a653a20313670783b20636f6c6f723a2077686974653b20666f6e742d7765696768743a206e6f726d616c3b223e44656172207b24757365726e616d657d2c20506c6561736520636865636b206e65772070726963653c2f68323e0d0a3c2f6469763e0d0a3c646976207374796c653d2270616464696e673a20323070783b223e0d0a3c7461626c65207374796c653d2277696474683a20313030253b20626f726465722d636f6c6c617073653a20636f6c6c617073653b223e0d0a3c74686561643e0d0a3c74723e3c7468207374796c653d2277686974652d73706163653a206e6f777261703b2070616464696e673a203130707820303b20626f726465722d626f74746f6d3a202365656520736f6c6964203170783b20746578742d616c69676e3a206c6566743b223e53657276696365204e616d653c2f74683e3c7468207374796c653d2277686974652d73706163653a206e6f777261703b2070616464696e673a203130707820303b20626f726465722d626f74746f6d3a202365656520736f6c6964203170783b20746578742d616c69676e3a2072696768743b223e5072696365203c736d616c6c207374796c653d22666f6e742d7765696768743a206e6f726d616c3b223e7b2463757272656e6379636f64657d3c2f736d616c6c3e3c2f74683e3c2f74723e0d0a3c2f74686561643e0d0a3c2f7461626c653e0d0a7b666f72656163682066726f6d3d246974656d6c697374206b65793d6964206974656d3d736572766963657d0d0a3c7461626c65207374796c653d2277696474683a20313030253b20626f726465722d636f6c6c617073653a20636f6c6c617073653b223e0d0a3c74626f64793e0d0a3c74723e0d0a3c7464207374796c653d2270616464696e673a20377078203070783b20626f726465722d626f74746f6d3a202365656520736f6c6964203170783b223e7b24736572766963652e6e616d657d3c2f74643e0d0a3c7464207374796c653d2270616464696e673a20377078203070783b20626f726465722d626f74746f6d3a202365656520736f6c6964203170783b20746578742d616c69676e3a2072696768743b20666f6e742d73697a653a20313470783b20666f6e742d7765696768743a20626f6c643b20636f6c6f723a20233066303135653b223e7b24736572766963652e70726963657d207b24736572766963652e7374617475737d3c2f74643e0d0a3c2f74723e0d0a3c2f74626f64793e0d0a3c2f7461626c653e0d0a7b2f666f72656163687d0d0a3c646976207374796c653d22746578742d616c69676e3a2063656e7465723b20636f6c6f723a20233932393739623b2070616464696e673a203230707820303b20666f6e742d73697a653a20313370783b223e0d0a3c6469763e496620796f7520646f6e27742077616e7420746f207265636569766520746865736520656d61696c7320696e20746865206675747572652c20796f75206d61792075706461746520796f757220737562736372697074696f6e20707265666572656e636573206f72203c61207374796c653d22746578742d6465636f726174696f6e3a206e6f6e653b2220687265663d227b2473697465616464726573737d2f696e6465782e7068703f753d7b24656e637d223e556e7375627363726962653c2f613e2066726f6d20616c6c20656d61696c732e3c2f6469763e0d0a3c646976207374796c653d2270616464696e673a203130707820303b20666f6e742d73697a653a20313370783b223e26636f70793b7b24636f6d70616e796e616d657d2e20416c6c205269676874732052657365727665643c2f6469763e0d0a3c646976207374796c653d22746578742d616c69676e3a2063656e7465723b223e7b69662024747769747465727d207b2f69667d207b6966202466616365626f6f6b7d207b2f69667d207b696620246c696e6b6564696e7d207b2f69667d207b69662024726573656c6c657273746f72657d207b2f69667d3c2f6469763e0d0a3c646976207374796c653d22636c6561723a20626f74683b223e203c2f6469763e0d0a3c2f6469763e0d0a3c2f6469763e0d0a3c2f6469763e0d0a3c2f74643e0d0a3c2f74723e0d0a3c2f74626f64793e0d0a3c2f7461626c653e, '', '', '0', '', '', '', 0, 0, '', 0, 0, '', 0),
(74, 'general', 'Group subscription expiry reminder', 0x596f757220737562736372697074696f6e2065787069726564206f6e207b24646174657d, 0x44656172207b24757365726e616d657d0d0a0d0a596f757220737562736372697074696f6e20666f72207b2467726f75707d2065787069726564206f6e207b24646174657d, '', '', '', '', '', '', 1, 0, '', 0, 0, '', 0),
(75, 'invoice', 'Offline Payment Gateway Updates', 0x5765207265636569766564205061796d656e742064657461696c73, 0x2044656172207b24757365726e616d657d0d0a0d0a576520526563656976656420796f7572205061796d656e742044657461696c7320666f7220496e766f696365204e756d626572203a207b24696e766f69636569647d0d0a0d0a5061796d656e7420697320756e6465722070726f636573732e0d0a0d0a0d0a7b2461646d696e7369676e61747572657d20, '', '', '0', '', '', '', 1, 0, '', 0, 0, '', 0),
(77, 'general', 'New service available', 0x4e6577205365727669636520417661696c61626c65207b24747970657d, 0x3c703e44656172207b24757365727d2c3c2f703e0d0a3c703e3c2f703e0d0a3c703e5468697320697320616e6e6f756e63656d656e7420666f72206e6577207365727669636520617661696c61626c653c2f703e0d0a3c703e7b2473657276696365736c6973747d3c2f703e, '', '', '0', '', '', '', 0, 0, '', 0, 0, '', 0);
INSERT INTO `tbl_emailtemplates_backup` (`id`, `type`, `name`, `subject`, `message`, `fromname`, `fromemail`, `disabled`, `custom`, `language`, `copyto`, `plaintext`, `for_reseller`, `template_variable`, `newsletter_default`, `scheduled`, `mailserv`, `layoutid`) VALUES
(78, 'general', 'Security Question reset by Admin', 0x596f7572207365637572697479205175657374696f6e2072657365742062792041646d696e, 0x44656172207b24757365726e616d657d200d0a596f75207365637572697479207175657374696f6e20666f72207b24636f6d70616e796e616d657d2072657365742062792041646d696e2e20596f752063616e206368616e6765206f7220736574206e6577207175657374696f6e20616e6420616e7377657220696620796f752077616e742e2020, '', '', '0', '', '', '', 1, 0, '', 0, 0, '', 0),
(79, 'general', 'Confirm your email', 0x596f752061726520737562736372696265206174207b24636f6d70616e796e616d657d, 0x596f757220656d61696c20737562736372696265206174207b24636f6d70616e796e616d657d2e20506c6561736520636c69636b207b246c696e6b7d20746f2076657269667920796f757220656d61696c206163636f756e742e0d0a0d0a5468616e6b20796f75, '', '', '', '', '', '', 1, 0, '', 0, 0, '', 0),
(80, 'general', 'Service List', 0x53657276696365204c697374, 0x4465617220437573746f6d65720d0a506c656173652066696e64206174746163686564207365727669636573206c6973740d0a7b2461646d696e7369676e61747572657d, '', '', '', '', '', '', 1, 0, '', 0, 0, '', 0),
(81, 'general', 'ID/KYC verification status update', 0xf09f98904b59432f494420726571756573742075706461746564202d7b247374617475737d, 0x3c703e44656172207b24757365726e616d657d3c2f703e0d0a3c703e596f75722049442f4b594320766572696669636174696f6e2072657175657374206973207570646174656420616e642063757272656e7420737461747573206973207b247374617475737d2e3c2f703e0d0a3c703e3c2f703e0d0a3c703e7b2472656a656374726561736f6e7d3c2f703e, '', '', '0', '', '', '', 0, 0, '', 0, 0, '', 0),
(82, 'general', 'Paypal OTP', 0x4f545020666f7220646972656374207472616e73616374696f6e, 0x44656172207b24757365726e616d657d200d0a0d0a5468697320697320796f7572207b246f74707d20666f722050617950616c20446972656374205472616e73616374696f6e2e0d0a, '', '', '', '', '', '', 1, 0, '', 0, 0, '', 0),
(83, 'imeiorderbulk', 'Bulk reject in single mail', 0x596f7572204f726465722052656a6563746564, 0x44656172207b24757365726e616d657d0d0a0d0a466f6c6c6f77696e67204f726465722072656a65637465642e0d0a0d0a7b666f7265616368202066726f6d3d2473657276696365206b65793d6b206974656d3d736572766963656974656d7d0d0a0d0a7b24736572766963656974656d7d203a20237b246f72646572735b246b5d7d20494d45493a207b24696d65695b246b5d7d20526561736f6e3a207b24726561736f6e5b246b5d7d0d0a0d0a7b2f666f72656163687d202020, '', '', '0', '', '', '', 1, 1, '{$orderid}- Order ID , {$imei} - IMEI No, {$note} - Notes , {$comments} - Comments , {$ordercredit} - Credit For Order , {$model} - Model Name , {$provider} - Provider Name , {$mep} - MEP , {$pin} - PIN Number , {$kbh} - KBH , {$prd} - PRD , {$type}- Type ,{$reference} - Reference , {$locks} - Locks ,{$comments}- User Comments,\r\n{$reply}- Admin Reply', 0, 0, '', 0),
(84, 'remoteorder', 'Remote order success', 0x4f726465722063616c63756c61746564207375636365737366756c6c79, 0x266c743b702667743b44656172207b24757365726e616d657d266c743b2f702667743b0d0a266c743b702667743b266c743b2f702667743b0d0a266c743b702667743b596f7572206f7264657220666f72207b24736572766963657d20686173207375636365737366756c6c79206265656e2063616c63756c617465642e266c743b2f702667743b0d0a266c743b702667743b7b69662024636f6d6d656e74737d2a2a207b24636f6d6d656e74737d7b2f69667d266c743b2f702667743b0d0a266c743b702667743b266c743b2f702667743b0d0a266c743b702667743b3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d266c743b2f702667743b0d0a266c743b702667743b7b247265706c797d266c743b2f702667743b0d0a266c743b702667743b3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d266c743b2f702667743b0d0a266c743b702667743b4f72646572732064657461696c73266c743b2f702667743b0d0a266c743b702667743b5365727669636526616d703b6e6273703b203a207b24736572766963657d266c743b2f702667743b0d0a266c743b702667743b437265646974203a207b246f726465726372656469747d266c743b2f702667743b0d0a266c743b702667743b7b666f72656163682066726f6d3d24637573746f6d206b65793d6964206974656d3d6373747d266c743b2f702667743b0d0a266c743b702667743b7b246373742e6e616d657d203a26616d703b6e6273703b207b246373742e76616c75657d266c743b2f702667743b0d0a266c743b702667743b7b2f666f72656163687d26616d703b6e6273703b266c743b2f702667743b0d0a266c743b702667743b266c743b2f702667743b0d0a266c743b702667743b3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d3d266c743b2f702667743b0d0a266c743b702667743b7b24666565646261636b6c696e6b7d266c743b2f702667743b0d0a266c743b702667743b7b2461646d696e7369676e61747572657d26616d703b6e6273703b2026616d703b6e6273703b2026616d703b6e6273703b266c743b2f702667743b, '', '', '0', '0', '', '', 0, 0, '', 0, 0, '', 0),
(85, 'remoteorder', 'Remote order reject', 0x52656d6f7465204f726465722052656a6563746564202f2043616e63656c6c6564, 0x266c743b702667743b44656172207b24757365726e616d657d266c743b2f702667743b0d0a266c743b702667743b596f7572206f7264657220666f72207b24736572766963657d206861732070726f63657373696e67206661696c757265202e266c743b2f702667743b0d0a266c743b702667743b526561736f6e203a207b24726561736f6e7d266c743b2f702667743b0d0a266c743b702667743b7b2461646d696e7369676e61747572657d266c743b2f702667743b, '', '', '0', '0', '', '', 0, 0, '', 0, 0, '', 0),
(86, 'remoteorder', 'New Remote order', 0x4e65772052656d6f7465206f7264657220706c61636564, 0x266c743b702667743b44656172207b24757365726e616d657d266c743b2f702667743b0d0a266c743b702667743b4e6577206f72646572206f66207b24736572766963657d20706c616365642066726f6d20796f7572206163636f756e742e266c743b2f702667743b0d0a266c743b702667743b266c743b2f702667743b0d0a266c743b702667743b7b2461646d696e7369676e61747572657d266c743b2f702667743b, '', '', '0', '0', '', '', 0, 0, '', 0, 0, '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_emailtemplates_reseller`
--

CREATE TABLE `tbl_emailtemplates_reseller` (
  `id` int(10) NOT NULL,
  `template_id` int(11) NOT NULL DEFAULT 0,
  `uid` int(11) NOT NULL DEFAULT 0,
  `type` varchar(255) NOT NULL,
  `name` varchar(555) NOT NULL,
  `subject` mediumtext NOT NULL,
  `message` mediumtext NOT NULL,
  `fromname` mediumtext NOT NULL,
  `fromemail` mediumtext NOT NULL,
  `disabled` mediumtext NOT NULL,
  `custom` mediumtext NOT NULL,
  `language` mediumtext NOT NULL,
  `copyto` mediumtext NOT NULL,
  `plaintext` int(1) NOT NULL DEFAULT 0,
  `flag` int(1) NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_emailtemplate_language`
--

CREATE TABLE `tbl_emailtemplate_language` (
  `id` int(11) NOT NULL,
  `template_id` int(11) NOT NULL DEFAULT 0,
  `language` varchar(555) NOT NULL,
  `subject` varchar(1000) NOT NULL,
  `message` mediumtext NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_email_blacklist`
--

CREATE TABLE `tbl_email_blacklist` (
  `id` int(11) NOT NULL,
  `email` varchar(555) NOT NULL,
  `reason` varchar(1555) NOT NULL,
  `status` int(1) NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_email_history`
--

CREATE TABLE `tbl_email_history` (
  `id` int(10) NOT NULL,
  `userid` int(10) NOT NULL,
  `subject` mediumtext NOT NULL,
  `message` mediumtext NOT NULL,
  `date` datetime DEFAULT NULL,
  `to` mediumtext DEFAULT NULL,
  `cc` mediumtext DEFAULT NULL,
  `bcc` mediumtext DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_email_layout`
--

CREATE TABLE `tbl_email_layout` (
  `id` int(11) NOT NULL,
  `header` mediumtext NOT NULL,
  `footer` mediumtext NOT NULL,
  `name` varchar(5555) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `tbl_email_layout`
--

INSERT INTO `tbl_email_layout` (`id`, `header`, `footer`, `name`) VALUES
(1, '&lt;!DOCTYPE html PUBLIC &quot;-//W3C//DTD XHTML 1.0 Transitional//EN&quot; &quot;http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd&quot;&gt;\r\n&lt;html xmlns=&quot;http://www.w3.org/1999/xhtml&quot;&gt;\r\n&lt;head&gt;\r\n&lt;title&gt;{$companeyname}&lt;/title&gt;\r\n&lt;meta http-equiv=&quot;Content-Type&quot; content=&quot;text/html; charset=UTF-8&quot; /&gt;\r\n&lt;/head&gt;\r\n&lt;body style=&quot;margin:0;background: #f4f4f4;&quot;&gt;\r\n\r\n&lt;div class=&quot;bg&quot;&gt;\r\n\r\n&lt;table  style=&quot;color:#153643;font-size:14px;width:100%;font-family: Open Sans, Helvetica, Arial, sans-serif;border:none;border-spacing:0;&quot;&gt;&lt;tr&gt;&lt;td&gt;\r\n{literal}\r\n&lt;style&gt;\r\n    .bg {\r\n		background: #f4f4f4;\r\n		padding:20px;\r\n		margin:50px 0;\r\n    }     \r\n    @media only screen and (max-width: 600px)\r\n    {\r\n		.bg {\r\n			background: #fff;\r\n			padding:0;\r\n		}   \r\n    }\r\n&lt;/style&gt;\r\n{/literal}\r\n	&lt;div  style=&quot;margin-left: auto;  margin-right: auto;  max-width:850px;background: #ffffff;&quot;&gt;\r\n		&lt;div style=&quot;background-color: #0F015E;background-image: radial-gradient(farthest-corner at 50% 100%, rgba(123,22,255,0.75),#0F015E );&quot;&gt;\r\n	 \r\n			&lt;div  style=&quot;padding:40px;text-align:center;color:#153643;font-weight: normal;font-size:20px;&quot;&gt;\r\n				&lt;h3 style=&quot;margin:0;color:white&quot;&gt;\r\n					{$companyname}\r\n				&lt;/h3&gt;\r\n			&lt;/div&gt;\r\n			 \r\n		&lt;/div&gt;\r\n		\r\n		\r\n		&lt;div   style=&quot;padding:20px;&quot;&gt;\r\n		 \r\n		  ', ' &lt;/div&gt;\r\n		&lt;div class=&quot;footer&quot; style=&quot;color:#777;padding:20px;background: #fff;text-align:center;font-size:13px&quot;&gt;			\r\n			&lt;div style=&quot;border-top:#ddd solid 1px;&quot;&gt;\r\n			\r\n			&lt;div style=&quot;max-width:500px;margin:auto;text-align:center&quot;&gt;\r\n			&lt;div style=&quot;padding:20px&quot;&gt;\r\n				&lt;ul style=&quot;padding:0;margin:0;&quot;&gt;\r\n					&lt;li style=&quot;list-style: none;display: inline-block;font-weight: bold;&quot;&gt;\r\n						&lt;a href=&quot;{$siteaddress}&quot; target=&quot;_blank&quot; style=&quot;text-decoration: none;color:#0F015E;padding:10px&quot;&gt;\r\n							Home\r\n						&lt;/a&gt;\r\n					&lt;/li&gt;\r\n					&lt;li style=&quot;list-style: none;display: inline-block;font-weight: bold;&quot;&gt;\r\n						&lt;a style=&quot;text-decoration: none;color:#0F015E;padding:10px&quot; href=&quot;{$siteaddress}/contact.php&quot;  target=&quot;_blank&quot;&gt;\r\n							Contact Us\r\n						&lt;/a&gt;\r\n					&lt;/li&gt;\r\n				&lt;/ul&gt;\r\n			&lt;/div&gt;\r\n			\r\n			 \r\n				&lt;div&gt;                    \r\n               If you don\'t want to receive these emails in the future, you may update your subscription preferences or   &lt;a href=&quot;{$siteaddress}/index.php?u={$enc}&quot; style=&quot;text-decoration: none;color:#999&quot;&gt;Unsubscribe&lt;/a&gt; from all emails. \r\n            &lt;/div&gt;\r\n			\r\n			\r\n			&lt;div style=&quot;padding:10px&quot;&gt;\r\n				&amp;copy;{$companyname} 	all rights reserved. 			\r\n			&lt;/div&gt;	\r\n						 \r\n			 \r\n			&lt;div   style=&quot;text-align:center;&quot;&gt;\r\n				{if $twitter} &lt;span&gt;\r\n				&lt;a href=&quot;http://www.twitter.com/{$twitter}&quot;   style=&quot;background-position:-68px 0;background-image:url(\'{$siteaddress}/images/social-icon.png \');background-repeat:no-repeat;display:inline-block;height:35px;margin:2px;width:35px;&quot;&gt;\r\n				&lt;/a&gt;\r\n				&lt;/span&gt;{/if}                                                   \r\n				{if $facebook} &lt;span&gt;\r\n				&lt;a href=&quot;http://www.facebook.com/{$facebook}&quot;   style=&quot;background-position:-35px 0;background-image:url(\'{$siteaddress}/images/social-icon.png \');background-repeat:no-repeat;display:inline-block;height:35px;margin:2px;width:35px;&quot;&gt;\r\n				&lt;/a&gt;\r\n				&lt;/span&gt;{/if}           \r\n				{if $linkedin} &lt;span&gt;\r\n				&lt;a href=&quot;{$linkedin}&quot;  style=&quot;background-position:-102px 0;background-image:url(\'{$siteaddress}/images/social-icon.png \');background-repeat:no-repeat;display:inline-block;height:35px;margin:2px;width:35px;&quot;&gt;\r\n				&lt;/a&gt;\r\n				&lt;/span&gt;{/if}  \r\n				{if $resellerstore} &lt;span&gt;\r\n				&lt;a href=&quot;viewrss.php&quot;   style=&quot;background-position:-3px 0;background-image:url(\'{$siteaddress}/images/social-icon.png \');background-repeat:no-repeat;display:inline-block;height:35px;margin:2px;width:35px;&quot;&gt;\r\n				&lt;/a&gt;\r\n				&lt;/span&gt;{/if}\r\n			&lt;/div&gt;\r\n		&lt;/div&gt;\r\n		\r\n		&lt;/div&gt;\r\n		\r\n		&lt;/div&gt;\r\n	&lt;/div&gt;\r\n	\r\n	\r\n	&lt;/td&gt;&lt;/tr&gt;&lt;/table&gt;\r\n	\r\n&lt;/div&gt;\r\n	\r\n&lt;/body&gt;\r\n&lt;/html&gt;\r\n ', 'default');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_email_layout_default`
--

CREATE TABLE `tbl_email_layout_default` (
  `id` int(11) NOT NULL,
  `header` mediumtext NOT NULL,
  `footer` mediumtext NOT NULL,
  `name` varchar(5555) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_features`
--

CREATE TABLE `tbl_features` (
  `id` int(10) NOT NULL,
  `group_id` int(11) NOT NULL DEFAULT 0,
  `type` mediumtext NOT NULL,
  `relid` int(10) NOT NULL DEFAULT 0,
  `fieldname` mediumtext NOT NULL,
  `fieldtype` mediumtext NOT NULL,
  `description` mediumtext NOT NULL,
  `fieldoptions` mediumtext NOT NULL,
  `regexpr` mediumtext NOT NULL,
  `adminonly` mediumtext NOT NULL,
  `required` mediumtext NOT NULL,
  `showorder` mediumtext NOT NULL,
  `sortorder` int(10) NOT NULL DEFAULT 0,
  `quickinfo` int(1) NOT NULL DEFAULT 0,
  `filter` int(1) NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_featuresvalues`
--

CREATE TABLE `tbl_featuresvalues` (
  `fieldid` int(4) NOT NULL,
  `relid` int(5) NOT NULL,
  `value` varchar(555) NOT NULL,
  `id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_feedback`
--

CREATE TABLE `tbl_feedback` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `uid` int(11) NOT NULL DEFAULT 0,
  `type` varchar(255) NOT NULL,
  `oid` varchar(50) NOT NULL,
  `feedback` mediumtext NOT NULL,
  `date` varchar(50) NOT NULL,
  `status` int(1) NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_file_credit`
--

CREATE TABLE `tbl_file_credit` (
  `service_id` int(11) NOT NULL DEFAULT 0,
  `currency_id` int(11) NOT NULL DEFAULT 0,
  `credit` decimal(25,3) DEFAULT NULL,
  `credit_subscribe` varchar(15) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_file_group`
--

CREATE TABLE `tbl_file_group` (
  `id` int(11) NOT NULL,
  `group_name` varchar(100) DEFAULT NULL,
  `active` int(11) NOT NULL DEFAULT 0,
  `display_order` int(11) NOT NULL DEFAULT 0,
  `imagelink` mediumtext DEFAULT NULL,
  `description` mediumtext DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_fraud`
--

CREATE TABLE `tbl_fraud` (
  `id` int(11) NOT NULL,
  `invoiceid` int(11) NOT NULL DEFAULT 0,
  `data` text NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_gatewaylog`
--

CREATE TABLE `tbl_gatewaylog` (
  `id` int(10) NOT NULL,
  `date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `gateway` mediumtext NOT NULL,
  `data` mediumtext NOT NULL,
  `result` mediumtext NOT NULL,
  `type` varchar(50) NOT NULL,
  `relid` int(11) NOT NULL DEFAULT 0,
  `userid` int(11) NOT NULL DEFAULT 0,
  `refid` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_generatedlink`
--

CREATE TABLE `tbl_generatedlink` (
  `id` int(11) NOT NULL,
  `type` varchar(50) NOT NULL,
  `link` mediumtext NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_gift_coupon`
--

CREATE TABLE `tbl_gift_coupon` (
  `id` int(11) NOT NULL COMMENT ' ',
  `uid` int(11) NOT NULL DEFAULT 0,
  `to` varchar(555) NOT NULL,
  `message` mediumtext NOT NULL,
  `amount` varchar(50) NOT NULL,
  `status` int(1) NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_group_api_price`
--

CREATE TABLE `tbl_group_api_price` (
  `id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL,
  `price` decimal(12,3) NOT NULL,
  `group_id` varchar(50) NOT NULL,
  `increaseby` varchar(50) NOT NULL,
  `pricingqntid` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_homepagegroup`
--

CREATE TABLE `tbl_homepagegroup` (
  `id` int(11) NOT NULL,
  `group` varchar(255) NOT NULL,
  `pid` mediumtext NOT NULL,
  `viewmore` int(12) NOT NULL,
  `sort` int(11) NOT NULL DEFAULT 0,
  `mid` int(6) DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_imei_credit`
--

CREATE TABLE `tbl_imei_credit` (
  `service_id` int(11) NOT NULL DEFAULT 0,
  `currency_id` int(11) NOT NULL DEFAULT 0,
  `credit` decimal(25,3) DEFAULT NULL,
  `credit_subscribe` varchar(15) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_imei_group`
--

CREATE TABLE `tbl_imei_group` (
  `id` int(11) NOT NULL,
  `group_name` varchar(260) NOT NULL,
  `active` int(1) NOT NULL DEFAULT 0,
  `display_order` int(5) NOT NULL DEFAULT 0,
  `imagelink` mediumtext DEFAULT NULL,
  `description` mediumtext DEFAULT NULL,
  `mid` int(11) NOT NULL DEFAULT 0,
  `server` int(1) NOT NULL DEFAULT 0,
  `hideguest` int(1) NOT NULL,
  `disabletelegram` tinyint(1) DEFAULT 0,
  `showonhome` int(11) DEFAULT NULL,
  `showonhomepage` tinyint(1) DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `tbl_imei_group`
--

INSERT INTO `tbl_imei_group` (`id`, `group_name`, `active`, `display_order`, `imagelink`, `description`, `mid`, `server`, `hideguest`, `disabletelegram`, `showonhome`, `showonhomepage`) VALUES
(1, 'IMEI CHECK', 1, 0, '', '', 0, 0, 0, 0, 0, 0),
(2, 'OTHER TOOLS', 1, 0, '', '', 0, 0, 0, 0, 0, 0),
(3, 'UNLOCK SERVICES', 1, 0, '', '', 0, 0, 0, 0, 0, 0),
(4, 'GENERIC UNLOCK', 1, 0, '', '', 0, 0, 0, 0, 0, 0),
(5, 'BEST OFFER', 1, 0, '', '', 0, 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_invoiceitems`
--

CREATE TABLE `tbl_invoiceitems` (
  `id` int(10) NOT NULL,
  `invoiceid` int(10) NOT NULL DEFAULT 0,
  `warehouseid` int(11) NOT NULL DEFAULT 0,
  `userid` int(10) NOT NULL,
  `type` mediumtext NOT NULL,
  `relid` int(10) NOT NULL,
  `description` mediumtext NOT NULL,
  `amount` decimal(15,3) NOT NULL,
  `taxed` int(1) NOT NULL DEFAULT 0,
  `shippingtax` decimal(10,2) NOT NULL,
  `duedate` date DEFAULT NULL,
  `paymentmethod` mediumtext NOT NULL,
  `notes` mediumtext NOT NULL,
  `qnt` varchar(50) NOT NULL,
  `promotion` varchar(50) NOT NULL,
  `promotion_code` varchar(250) NOT NULL,
  `pos` int(1) NOT NULL DEFAULT 0,
  `bundleid` int(11) NOT NULL DEFAULT 0,
  `warehouse` int(11) NOT NULL DEFAULT 0,
  `serviceid` int(11) NOT NULL DEFAULT 0,
  `service` varchar(255) NOT NULL,
  `used` int(1) NOT NULL DEFAULT 0,
  `serial` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_invoices`
--

CREATE TABLE `tbl_invoices` (
  `id` int(10) NOT NULL,
  `userid` int(10) NOT NULL,
  `invoicenum` mediumtext NOT NULL,
  `date` date DEFAULT NULL,
  `duedate` date DEFAULT NULL,
  `datepaid` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `subtotal` decimal(12,3) NOT NULL,
  `credit` decimal(12,3) NOT NULL,
  `tax` decimal(12,3) NOT NULL,
  `tax2` decimal(12,3) NOT NULL,
  `shippingtax` decimal(12,3) NOT NULL,
  `total` decimal(12,3) NOT NULL,
  `taxrate` decimal(12,3) NOT NULL,
  `taxrate2` decimal(12,3) NOT NULL,
  `status` varchar(255) NOT NULL,
  `paymentmethod` varchar(555) NOT NULL,
  `notice` int(1) NOT NULL DEFAULT 0,
  `notes` mediumtext NOT NULL,
  `adminid` varchar(50) NOT NULL,
  `promotion` varchar(250) NOT NULL,
  `pos` int(1) NOT NULL DEFAULT 0,
  `posdiscount` varchar(50) NOT NULL,
  `bundleid` int(11) NOT NULL DEFAULT 0,
  `discount` varchar(20) NOT NULL,
  `warehouse` int(11) NOT NULL DEFAULT 0,
  `screenshot` varchar(1000) NOT NULL,
  `screenshotenc` varchar(1000) NOT NULL,
  `businessid` varchar(555) NOT NULL,
  `offline` int(1) NOT NULL DEFAULT 0,
  `mask` int(11) NOT NULL DEFAULT 0,
  `onhold` tinyint(1) DEFAULT 0,
  `receivedamount` decimal(14,2) DEFAULT 0.00,
  `retail` tinyint(1) DEFAULT 0,
  `time` varchar(50) DEFAULT NULL,
  `orderstatus` varchar(20) DEFAULT NULL,
  `onholdreason` text DEFAULT NULL,
  `exorderid` varchar(100) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_keygroup`
--

CREATE TABLE `tbl_keygroup` (
  `id` int(11) NOT NULL,
  `group` varchar(555) NOT NULL,
  `codetable` varchar(150) NOT NULL,
  `codeimei` varchar(150) NOT NULL,
  `codereply` varchar(100) NOT NULL,
  `exlcludestart` int(5) NOT NULL,
  `exludeend` int(5) NOT NULL,
  `replysprintf` varchar(150) NOT NULL,
  `autoreject` int(1) NOT NULL,
  `displayorder` int(5) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_knowledgebase`
--

CREATE TABLE `tbl_knowledgebase` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `group_id` int(11) NOT NULL DEFAULT 0,
  `content` longtext NOT NULL,
  `date` date NOT NULL,
  `viewer` int(10) NOT NULL,
  `login` int(1) NOT NULL DEFAULT 0,
  `displayorder` int(11) NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_knowledgebasecat`
--

CREATE TABLE `tbl_knowledgebasecat` (
  `id` int(11) NOT NULL,
  `category` varchar(255) NOT NULL,
  `info` mediumtext NOT NULL,
  `sort` int(1) NOT NULL DEFAULT 0,
  `image` varchar(250) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_label_printer`
--

CREATE TABLE `tbl_label_printer` (
  `id` int(11) NOT NULL,
  `width` varchar(20) NOT NULL,
  `height` varchar(20) NOT NULL,
  `sticker` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_license`
--

CREATE TABLE `tbl_license` (
  `id` int(5) NOT NULL,
  `local_key` longtext NOT NULL,
  `license_key` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `tbl_license`
--

INSERT INTO `tbl_license` (`id`, `local_key`, `license_key`) VALUES
(1, '', '');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_license_default`
--

CREATE TABLE `tbl_license_default` (
  `id` int(5) NOT NULL,
  `local_key` longtext NOT NULL,
  `license_key` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_livehelp_conversation`
--

CREATE TABLE `tbl_livehelp_conversation` (
  `id` int(20) NOT NULL,
  `adminid` int(11) NOT NULL DEFAULT 0,
  `chatid` int(100) NOT NULL,
  `department` int(11) NOT NULL DEFAULT 0,
  `name` varchar(500) NOT NULL,
  `email` varchar(250) NOT NULL,
  `subject` varchar(1000) NOT NULL,
  `message` mediumtext NOT NULL,
  `ip` varchar(255) NOT NULL,
  `time` varchar(100) NOT NULL,
  `view` int(1) NOT NULL DEFAULT 0,
  `adminview` int(1) NOT NULL DEFAULT 0,
  `status` int(1) NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_loginlog_admin`
--

CREATE TABLE `tbl_loginlog_admin` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `ip` varchar(50) NOT NULL,
  `time` varchar(100) NOT NULL,
  `userid` int(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `tbl_loginlog_admin`
--

INSERT INTO `tbl_loginlog_admin` (`id`, `username`, `ip`, `time`, `userid`) VALUES
(1, 'admin', '45.139.199.136', '1675800348', 1),
(2, 'admin', '5.229.106.93', '1675802299', 1),
(3, 'admin', '45.139.199.136', '1675803567', 1),
(4, 'admin', '77.67.201.71', '1677964695', 1),
(5, 'admin', '188.80.69.14', '1677964898', 1),
(6, 'admin', '188.80.69.14', '1677964987', 1),
(7, 'admin', '188.80.69.14', '1677973589', 1),
(8, 'admin', '77.67.210.5', '1677973931', 1),
(9, 'admin', '188.80.69.14', '1677974423', 1),
(10, 'admin', '77.67.210.5', '1677974715', 1),
(11, 'admin', '188.80.69.14', '1678045847', 1),
(12, 'admin', '85.153.224.187', '1679484123', 1),
(13, 'admin', '196.121.154.57', '1679485797', 1),
(14, 'admin', '196.121.154.57', '1679498327', 1),
(15, 'admin', '196.121.154.57', '1679502838', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_loginlog_user`
--

CREATE TABLE `tbl_loginlog_user` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `ip` varchar(50) NOT NULL,
  `time` varchar(100) NOT NULL,
  `userid` int(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `tbl_loginlog_user`
--

INSERT INTO `tbl_loginlog_user` (`id`, `username`, `ip`, `time`, `userid`) VALUES
(1, 'demo@demo.com', '188.80.69.14', '1677976486', 1),
(2, 'ahmed.el.andam@gmail.com', '196.121.154.57', '1679498485', 2),
(3, 'Ahmed.el.andam@gmail.com', '177.54.147.116', '1679504712', 2);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_mail_batch`
--

CREATE TABLE `tbl_mail_batch` (
  `id` int(11) NOT NULL,
  `date` date NOT NULL,
  `template` int(11) NOT NULL,
  `mailserver` int(4) NOT NULL,
  `layout` int(4) NOT NULL,
  `batch` int(10) NOT NULL,
  `users` varchar(254) NOT NULL,
  `subject` varchar(200) NOT NULL,
  `message` text NOT NULL,
  `total` int(11) NOT NULL,
  `status` int(1) NOT NULL,
  `pending` int(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_manufacture`
--

CREATE TABLE `tbl_manufacture` (
  `id` int(9) NOT NULL,
  `name` varchar(100) NOT NULL,
  `image_link` varchar(200) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_massmail`
--

CREATE TABLE `tbl_massmail` (
  `id` int(11) NOT NULL,
  `message` mediumtext NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_membership_fee`
--

CREATE TABLE `tbl_membership_fee` (
  `id` int(11) NOT NULL,
  `gid` int(11) NOT NULL DEFAULT 0,
  `cid` int(11) NOT NULL DEFAULT 0,
  `fee` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_mep`
--

CREATE TABLE `tbl_mep` (
  `id` int(11) NOT NULL,
  `mep` varchar(50) NOT NULL,
  `api` mediumtext NOT NULL,
  `apiid` mediumtext NOT NULL,
  `listing` int(2) NOT NULL,
  `N_ID` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_mepserver`
--

CREATE TABLE `tbl_mepserver` (
  `id` int(11) NOT NULL,
  `imei` varchar(15) NOT NULL,
  `brand` int(11) NOT NULL DEFAULT 0,
  `phone_model` int(11) NOT NULL DEFAULT 0,
  `country` int(11) NOT NULL DEFAULT 0,
  `operator` int(11) NOT NULL DEFAULT 0,
  `mep` int(11) NOT NULL DEFAULT 0,
  `email` varchar(255) NOT NULL,
  `unlock_code` varchar(255) NOT NULL,
  `network_code` varchar(255) NOT NULL,
  `network_subset_code` varchar(255) NOT NULL,
  `service_provider_code` varchar(255) NOT NULL,
  `corporate_code` varchar(255) NOT NULL,
  `sim_code` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_message`
--

CREATE TABLE `tbl_message` (
  `id` int(11) NOT NULL,
  `to` int(11) NOT NULL DEFAULT 0,
  `from` int(11) NOT NULL DEFAULT 0,
  `subject` varchar(555) NOT NULL,
  `message` mediumtext NOT NULL,
  `status` int(1) NOT NULL DEFAULT 0,
  `date` varchar(50) NOT NULL,
  `tid` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_mobile`
--

CREATE TABLE `tbl_mobile` (
  `ID` int(11) NOT NULL,
  `B_ID` varchar(15) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `api` varchar(255) NOT NULL,
  `apiid` mediumtext NOT NULL,
  `N_ID` varchar(255) NOT NULL,
  `Photo` varchar(555) NOT NULL,
  `listing` int(2) NOT NULL,
  `image_link` varchar(555) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_model_brand`
--

CREATE TABLE `tbl_model_brand` (
  `ID` int(11) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `api` varchar(255) NOT NULL,
  `apiid` mediumtext NOT NULL,
  `N_ID` varchar(15) NOT NULL,
  `listing` mediumtext NOT NULL,
  `B_ID` varchar(255) NOT NULL,
  `image_link` varchar(555) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_navigation`
--

CREATE TABLE `tbl_navigation` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `languagevar` varchar(255) NOT NULL,
  `groupid` int(11) NOT NULL DEFAULT 0,
  `order` int(11) NOT NULL DEFAULT 0,
  `link` mediumtext NOT NULL,
  `linkphp` mediumtext NOT NULL,
  `display` int(1) NOT NULL DEFAULT 0,
  `req_login` int(1) NOT NULL DEFAULT 0,
  `mid` int(11) NOT NULL DEFAULT 0,
  `master` int(1) NOT NULL DEFAULT 0,
  `locked` int(1) NOT NULL DEFAULT 0,
  `afterloginshow` int(1) NOT NULL DEFAULT 0,
  `external` int(1) NOT NULL DEFAULT 0,
  `newwindow` int(1) NOT NULL DEFAULT 0,
  `icon` varchar(555) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `tbl_navigation`
--

INSERT INTO `tbl_navigation` (`id`, `name`, `languagevar`, `groupid`, `order`, `link`, `linkphp`, `display`, `req_login`, `mid`, `master`, `locked`, `afterloginshow`, `external`, `newwindow`, `icon`) VALUES
(1112, 'Server Orders', 'serverorders', 1012, 3, 'orders/action/newserver/status/all', '', 1, 1, 0, 1, 1, 1, 0, 0, ''),
(1100, 'Remote Service', 'remoteservice', 1011, 3, 'resellerplaceorder/remote', '', 1, 0, 0, 1, 1, 1, 0, 0, 'flaticon-game2'),
(1020, 'IMEI Service', 'imeiservice', 1006, 1, 'resellerpricing/imei', '', 1, 0, 0, 1, 1, 1, 0, 0, 'flaticon-bag1'),
(1021, 'Server Service', 'serverservice', 1006, 2, 'resellerpricing/server', '', 1, 0, 0, 1, 1, 1, 0, 0, 'flaticon-about'),
(1019, 'File Service', 'fileservice', 1006, 4, 'resellerpricing/file', '', 1, 0, 0, 1, 1, 0, 0, 0, ''),
(1114, 'Remote Orders', 'remoteorders', 1012, 4, 'orders/action/remote/status/all', '', 1, 1, 0, 1, 1, 1, 0, 0, ''),
(1017, 'File services', 'fileservice', 1011, 4, 'resellerplaceorder/file', '', 1, 0, 0, 1, 1, 1, 0, 0, 'flaticon-web1'),
(1018, 'Server Services', 'serverservice', 1011, 2, 'resellerplaceorder/server', '', 1, 0, 0, 1, 1, 1, 0, 0, 'flaticon-game2'),
(1015, 'Registration', 'registration', 0, 6, 'register', '', 1, 0, 0, 1, 1, 0, 0, 0, 'flaticon-about'),
(1016, 'IMEI Service', 'imeiservice', 1011, 1, 'resellerplaceorder/imei', '', 1, 0, 0, 1, 1, 1, 0, 0, 'flaticon-buying4'),
(1013, 'Track Order', 'trackorder', 0, 4, 'trackorder', '', 0, 0, 0, 0, 1, 1, 0, 0, 'flaticon-blank'),
(1014, 'Downloads', 'downloads', 0, 5, 'downloads', '', 0, 0, 0, 0, 1, 1, 0, 0, 'flaticon-blank'),
(1010, 'Client Area', 'clientarea', 0, 3, 'main', '', 1, 1, 0, 1, 1, 1, 0, 0, 'flaticon-web4'),
(1011, 'Place Order', 'placeorder', 0, 4, 'resellerplaceorder/imei', '', 1, 1, 0, 1, 1, 1, 0, 0, 'flaticon-buying4'),
(1012, 'Order History', 'orderhistory', 0, 5, 'orders/imei', '', 1, 1, 0, 1, 1, 1, 0, 0, 'flaticon-history'),
(1006, 'Reseller Pricing', 'resellerpricing', 0, 2, 'productsandservices/imei', '', 1, 0, 0, 1, 1, 0, 0, 0, ''),
(1007, 'Home', 'home', 0, 1, 'index', '', 1, 0, 0, 1, 1, 0, 0, 0, 'flaticon-bag1'),
(1111, 'File Orders', 'fileorders', 1012, 2, 'orders/action/file/status/all', '', 1, 1, 0, 1, 1, 1, 0, 0, ''),
(1002, 'Testimonial', 'testimonials', 0, 3, 'testimonials', '', 0, 0, 0, 0, 1, 1, 0, 0, 'flaticon-blank'),
(1003, 'Knowledgebase', 'knowledgebase', 0, 1, 'knowledgebase', '', 0, 0, 0, 0, 1, 1, 0, 0, 'flaticon-blank'),
(1004, 'Contact Us', 'contact', 0, 6, 'contactus', '', 1, 0, 0, 0, 1, 1, 0, 0, 'flaticon-blank'),
(1110, 'IMEI Orders', 'imeiorders', 1012, 1, 'orders/imei/status/all', '', 1, 1, 0, 1, 1, 1, 0, 0, ''),
(1001, 'Blog', 'blog', 0, 2, 'blog', '', 0, 0, 0, 0, 1, 1, 0, 0, ''),
(1101, 'Remote Service', 'remoteservice', 1006, 3, 'resellerpricing/remote', '', 1, 0, 0, 1, 1, 1, 0, 0, ''),
(105, 'Reward Points', 'placeorderreward', 1011, 5, 'placeorder/reward/1', '', 1, 1, 0, 1, 1, 1, 0, 0, ''),
(1115, 'Advanced History', 'advancedhistory', 1012, 6, 'orders/action/advance', '', 1, 1, 0, 1, 1, 1, 0, 0, ''),
(1113, 'Retail Orders', 'shoporders', 1012, 5, 'ordershopping', '', 1, 1, 0, 1, 1, 1, 0, 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_navigation_default`
--

CREATE TABLE `tbl_navigation_default` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `languagevar` varchar(255) NOT NULL,
  `groupid` int(11) NOT NULL DEFAULT 0,
  `order` int(11) NOT NULL DEFAULT 0,
  `link` mediumtext NOT NULL,
  `linkphp` mediumtext NOT NULL,
  `display` int(1) NOT NULL DEFAULT 0,
  `req_login` int(1) NOT NULL DEFAULT 0,
  `mid` int(11) NOT NULL DEFAULT 0,
  `master` int(1) NOT NULL DEFAULT 0,
  `locked` int(1) NOT NULL DEFAULT 0,
  `afterloginshow` int(1) NOT NULL DEFAULT 0,
  `external` int(1) NOT NULL DEFAULT 0,
  `newwindow` int(1) NOT NULL DEFAULT 0,
  `icon` varchar(555) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_newsletter`
--

CREATE TABLE `tbl_newsletter` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `IP` varchar(25) NOT NULL,
  `active` int(1) NOT NULL DEFAULT 0,
  `time` varchar(25) NOT NULL,
  `pid` varchar(211) NOT NULL,
  `lastsend` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_order_file`
--

CREATE TABLE `tbl_order_file` (
  `order_id` int(5) NOT NULL,
  `service_id` int(11) NOT NULL DEFAULT 0,
  `user_id` int(11) NOT NULL DEFAULT 0,
  `file` varchar(255) DEFAULT NULL,
  `file_enc` varchar(555) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `time` varchar(25) DEFAULT NULL,
  `note` varchar(255) DEFAULT NULL,
  `comments` varchar(255) DEFAULT NULL,
  `credit` decimal(12,3) DEFAULT NULL,
  `discount` decimal(12,3) DEFAULT NULL,
  `user_can_c` int(11) NOT NULL DEFAULT 0,
  `is_by_sms` varchar(15) DEFAULT NULL,
  `reply` text DEFAULT NULL,
  `reply_enc` text DEFAULT NULL,
  `reply_time` varchar(50) DEFAULT NULL,
  `reply_by_admin` int(11) NOT NULL DEFAULT 0,
  `reply_by_sup` int(11) NOT NULL DEFAULT 0,
  `reply_by_api` varchar(100) NOT NULL DEFAULT '0',
  `reason` varchar(555) DEFAULT NULL,
  `verified_by_admin` int(11) NOT NULL DEFAULT 0,
  `verified_by_sup` int(11) NOT NULL DEFAULT 0,
  `rejected_reason` varchar(300) DEFAULT NULL,
  `reply_type` int(11) NOT NULL DEFAULT 0,
  `pass_key` varchar(100) DEFAULT NULL,
  `verified` int(11) NOT NULL DEFAULT 0,
  `retail_shop` int(11) NOT NULL DEFAULT 0,
  `invoice_id` varchar(255) DEFAULT NULL,
  `reseller_id` int(11) NOT NULL DEFAULT 0,
  `reseller_credit` decimal(13,3) DEFAULT NULL,
  `reseller_discount` decimal(13,3) DEFAULT NULL,
  `ip` varchar(255) DEFAULT NULL,
  `purchase_cost` varchar(10) DEFAULT NULL,
  `profit` varchar(10) DEFAULT NULL,
  `response_email` varchar(555) DEFAULT NULL,
  `currency_id` int(11) NOT NULL DEFAULT 0,
  `responseno` varchar(15) DEFAULT NULL,
  `subscribe` int(11) NOT NULL DEFAULT 0,
  `reply_date` varchar(50) DEFAULT NULL,
  `ex_oid` varchar(100) DEFAULT NULL,
  `acceptedby` int(11) NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_order_imei`
--

CREATE TABLE `tbl_order_imei` (
  `order_id` int(11) NOT NULL,
  `service_id` int(5) NOT NULL DEFAULT 0,
  `user_id` int(5) NOT NULL DEFAULT 0,
  `imei` varchar(50) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `time` varchar(25) DEFAULT NULL,
  `note` varchar(1000) DEFAULT NULL,
  `comments` varchar(255) DEFAULT NULL,
  `credit` decimal(12,3) DEFAULT NULL,
  `custom` varchar(100) DEFAULT NULL,
  `discount` decimal(12,3) DEFAULT NULL,
  `user_can_c` int(1) NOT NULL DEFAULT 0,
  `reply` mediumtext DEFAULT NULL,
  `reply_time` varchar(50) DEFAULT NULL,
  `reply_by_admin` int(11) NOT NULL DEFAULT 0,
  `reply_by_sup` int(11) NOT NULL DEFAULT 0,
  `verified_by_admin` int(11) NOT NULL DEFAULT 0,
  `verified_by_sup` int(11) NOT NULL DEFAULT 0,
  `reply_by_api` varchar(100) DEFAULT NULL,
  `pass_key` varchar(100) DEFAULT NULL,
  `is_by_sms` varchar(15) DEFAULT NULL,
  `model_id` int(10) NOT NULL DEFAULT 0,
  `provider_id` int(10) NOT NULL DEFAULT 0,
  `network_id` int(10) NOT NULL DEFAULT 0,
  `ex_oid` mediumtext DEFAULT NULL,
  `verified` int(1) NOT NULL DEFAULT 0,
  `mep` varchar(20) DEFAULT NULL,
  `provider_c_id` varchar(50) DEFAULT NULL,
  `PIN` varchar(255) DEFAULT NULL,
  `KBH` varchar(255) DEFAULT NULL,
  `PRD` varchar(255) DEFAULT NULL,
  `Type` varchar(255) DEFAULT NULL,
  `Reference` varchar(50) DEFAULT NULL,
  `Locks` varchar(50) DEFAULT NULL,
  `ICloudEmail` varchar(50) DEFAULT NULL,
  `ICloudPhone` varchar(50) DEFAULT NULL,
  `retail_shop` int(1) NOT NULL DEFAULT 0,
  `invoice_id` varchar(255) DEFAULT NULL,
  `reseller_id` int(11) NOT NULL DEFAULT 0,
  `reseller_credit` decimal(13,3) DEFAULT NULL,
  `reseller_discount` decimal(13,3) DEFAULT NULL,
  `purchase_cost` varchar(10) DEFAULT NULL,
  `profit` varchar(10) DEFAULT NULL,
  `tmp_status` int(1) NOT NULL DEFAULT 0,
  `ip` varchar(255) DEFAULT NULL,
  `response_email` varchar(555) DEFAULT NULL,
  `currency_id` int(11) NOT NULL DEFAULT 0,
  `responseno` varchar(15) DEFAULT NULL,
  `subscribe` int(1) NOT NULL DEFAULT 0,
  `aid` int(11) NOT NULL DEFAULT 0,
  `tax` varchar(55) DEFAULT NULL,
  `ebay` int(11) NOT NULL DEFAULT 0,
  `reply_date` varchar(50) DEFAULT NULL,
  `gateway` varchar(255) DEFAULT NULL,
  `apilogreferenceid` varchar(10) DEFAULT NULL,
  `invoiceid` int(11) NOT NULL DEFAULT 0,
  `encnum` varchar(50) DEFAULT NULL,
  `acceptedby` int(11) NOT NULL DEFAULT 0,
  `refunded` int(1) NOT NULL DEFAULT 0,
  `SN` varchar(255) DEFAULT NULL,
  `SecRO` varchar(255) DEFAULT NULL,
  `fetchapitime` varchar(50) DEFAULT NULL,
  `autosend` int(1) NOT NULL DEFAULT 0,
  `adminnote` varchar(500) NOT NULL,
  `server` int(1) NOT NULL DEFAULT 0,
  `qnt` int(3) NOT NULL,
  `placedfrom` int(1) NOT NULL DEFAULT 0,
  `ORDERAPI` varchar(100) NOT NULL,
  `ORDERAPI_ID` varchar(255) NOT NULL,
  `ORDERAPI_TYPEID` varchar(150) NOT NULL,
  `verifyreject` int(1) NOT NULL,
  `verifydata` text NOT NULL,
  `apierror` varchar(500) NOT NULL,
  `acceptedtime` varchar(25) NOT NULL,
  `pricefrom` varchar(20) DEFAULT NULL,
  `posterminalid` int(5) DEFAULT NULL,
  `points` decimal(20,2) DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `tbl_order_imei`
--

INSERT INTO `tbl_order_imei` (`order_id`, `service_id`, `user_id`, `imei`, `date`, `time`, `note`, `comments`, `credit`, `custom`, `discount`, `user_can_c`, `reply`, `reply_time`, `reply_by_admin`, `reply_by_sup`, `verified_by_admin`, `verified_by_sup`, `reply_by_api`, `pass_key`, `is_by_sms`, `model_id`, `provider_id`, `network_id`, `ex_oid`, `verified`, `mep`, `provider_c_id`, `PIN`, `KBH`, `PRD`, `Type`, `Reference`, `Locks`, `ICloudEmail`, `ICloudPhone`, `retail_shop`, `invoice_id`, `reseller_id`, `reseller_credit`, `reseller_discount`, `purchase_cost`, `profit`, `tmp_status`, `ip`, `response_email`, `currency_id`, `responseno`, `subscribe`, `aid`, `tax`, `ebay`, `reply_date`, `gateway`, `apilogreferenceid`, `invoiceid`, `encnum`, `acceptedby`, `refunded`, `SN`, `SecRO`, `fetchapitime`, `autosend`, `adminnote`, `server`, `qnt`, `placedfrom`, `ORDERAPI`, `ORDERAPI_ID`, `ORDERAPI_TYPEID`, `verifyreject`, `verifydata`, `apierror`, `acceptedtime`, `pricefrom`, `posterminalid`, `points`, `status`) VALUES
(1, 47, 1, '359217071401076', '2023-03-04', '1677976983', '', '', '0.020', '', '0.000', 0, '', '', 0, 0, 0, 0, '', '2427610e7f42b63b802c16d0321983c5', '', 0, 0, 0, '', 0, '', '', '', '', '', '', '', '', '', '', 0, '', 0, '0.000', '0.000', '', '', 0, '188.80.69.14', '', 1, '', 0, 0, '', 0, '', '', '', 0, '3', 0, 0, '', '', '1677998605', 0, '', 0, 1, 0, 'fusion13', '2390', '', 0, '', 'ValidationError123<li>SERIAL NUMBER Required or Invalid</li>:ValidationError123<li>SERIAL NUMBER Required or Invalid</li>,SERIAL NUMBER Required or Invalid', '', 'Client Group', 0, '0.00', '');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_order_imei_archive`
--

CREATE TABLE `tbl_order_imei_archive` (
  `order_id` int(11) NOT NULL,
  `service_id` int(5) NOT NULL DEFAULT 0,
  `user_id` int(5) NOT NULL DEFAULT 0,
  `imei` varchar(50) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `time` varchar(25) DEFAULT NULL,
  `note` varchar(1000) DEFAULT NULL,
  `comments` varchar(255) DEFAULT NULL,
  `credit` decimal(12,3) DEFAULT NULL,
  `custom` varchar(100) DEFAULT NULL,
  `discount` decimal(12,3) DEFAULT NULL,
  `user_can_c` int(1) NOT NULL DEFAULT 0,
  `reply` mediumtext DEFAULT NULL,
  `reply_time` varchar(50) DEFAULT NULL,
  `reply_by_admin` int(11) NOT NULL DEFAULT 0,
  `reply_by_sup` int(11) NOT NULL DEFAULT 0,
  `verified_by_admin` int(11) NOT NULL DEFAULT 0,
  `verified_by_sup` int(11) NOT NULL DEFAULT 0,
  `reply_by_api` varchar(100) DEFAULT NULL,
  `pass_key` varchar(100) DEFAULT NULL,
  `is_by_sms` varchar(15) DEFAULT NULL,
  `model_id` int(10) NOT NULL DEFAULT 0,
  `provider_id` int(10) NOT NULL DEFAULT 0,
  `network_id` int(10) NOT NULL DEFAULT 0,
  `ex_oid` mediumtext DEFAULT NULL,
  `verified` int(1) NOT NULL DEFAULT 0,
  `mep` varchar(20) DEFAULT NULL,
  `provider_c_id` varchar(50) DEFAULT NULL,
  `PIN` varchar(255) DEFAULT NULL,
  `KBH` varchar(255) DEFAULT NULL,
  `PRD` varchar(255) DEFAULT NULL,
  `Type` varchar(255) DEFAULT NULL,
  `Reference` varchar(50) DEFAULT NULL,
  `Locks` varchar(50) DEFAULT NULL,
  `ICloudEmail` varchar(50) DEFAULT NULL,
  `ICloudPhone` varchar(50) DEFAULT NULL,
  `retail_shop` int(1) NOT NULL DEFAULT 0,
  `invoice_id` varchar(255) DEFAULT NULL,
  `reseller_id` int(11) NOT NULL DEFAULT 0,
  `reseller_credit` decimal(13,3) DEFAULT NULL,
  `reseller_discount` decimal(13,3) DEFAULT NULL,
  `purchase_cost` varchar(10) DEFAULT NULL,
  `profit` varchar(10) DEFAULT NULL,
  `tmp_status` int(1) NOT NULL DEFAULT 0,
  `ip` varchar(255) DEFAULT NULL,
  `response_email` varchar(555) DEFAULT NULL,
  `currency_id` int(11) NOT NULL DEFAULT 0,
  `responseno` varchar(15) DEFAULT NULL,
  `subscribe` int(1) NOT NULL DEFAULT 0,
  `aid` int(11) NOT NULL DEFAULT 0,
  `tax` varchar(55) DEFAULT NULL,
  `ebay` int(11) NOT NULL DEFAULT 0,
  `reply_date` varchar(50) DEFAULT NULL,
  `gateway` varchar(255) DEFAULT NULL,
  `apilogreferenceid` varchar(10) DEFAULT NULL,
  `invoiceid` int(11) NOT NULL DEFAULT 0,
  `encnum` varchar(50) DEFAULT NULL,
  `acceptedby` int(11) NOT NULL DEFAULT 0,
  `refunded` int(1) NOT NULL DEFAULT 0,
  `SN` varchar(255) DEFAULT NULL,
  `SecRO` varchar(255) DEFAULT NULL,
  `fetchapitime` varchar(50) DEFAULT NULL,
  `autosend` int(1) NOT NULL DEFAULT 0,
  `adminnote` varchar(500) NOT NULL,
  `server` int(1) NOT NULL DEFAULT 0,
  `qnt` int(3) NOT NULL,
  `placedfrom` int(1) NOT NULL DEFAULT 0,
  `ORDERAPI` varchar(100) NOT NULL,
  `ORDERAPI_ID` varchar(255) NOT NULL,
  `ORDERAPI_TYPEID` varchar(150) NOT NULL,
  `verifyreject` int(1) NOT NULL,
  `verifydata` text NOT NULL,
  `apierror` varchar(500) NOT NULL,
  `acceptedtime` varchar(25) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_order_log`
--

CREATE TABLE `tbl_order_log` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `time` varchar(30) NOT NULL,
  `adminid` int(11) NOT NULL,
  `api` varchar(50) NOT NULL,
  `status` int(1) NOT NULL,
  `process` varchar(120) NOT NULL,
  `ip` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_order_product`
--

CREATE TABLE `tbl_order_product` (
  `order_id` int(5) NOT NULL,
  `service_id` int(5) NOT NULL,
  `user_id` int(5) NOT NULL,
  `imei` varchar(15) NOT NULL,
  `date` date NOT NULL,
  `time` varchar(25) NOT NULL,
  `note` varchar(255) NOT NULL,
  `comments` varchar(255) NOT NULL,
  `credit` decimal(12,2) NOT NULL,
  `custom` varchar(100) NOT NULL,
  `discount` decimal(7,2) NOT NULL,
  `user_can_c` int(1) NOT NULL DEFAULT 0,
  `reply` varchar(255) NOT NULL,
  `reply_by` varchar(255) NOT NULL,
  `reply_time` varchar(50) NOT NULL,
  `reply_by_admin` int(11) NOT NULL DEFAULT 0,
  `reply_by_sup` int(11) NOT NULL DEFAULT 0,
  `verified_by_admin` int(11) NOT NULL DEFAULT 0,
  `verified_by_sup` int(11) NOT NULL DEFAULT 0,
  `reply_by_api` varchar(100) NOT NULL,
  `pass_key` varchar(100) NOT NULL,
  `is_by_sms` varchar(15) NOT NULL,
  `model_id` int(10) NOT NULL,
  `provider_id` int(10) NOT NULL,
  `network_id` int(10) NOT NULL,
  `ex_oid` mediumtext NOT NULL,
  `verified` int(1) NOT NULL DEFAULT 0,
  `mep` varchar(20) NOT NULL,
  `provider_c_id` varchar(50) NOT NULL,
  `PIN` varchar(255) NOT NULL,
  `KBH` varchar(255) NOT NULL,
  `PRD` varchar(255) NOT NULL,
  `Type` varchar(255) NOT NULL,
  `Reference` varchar(50) NOT NULL,
  `Locks` varchar(50) NOT NULL,
  `retail_shop` int(1) NOT NULL DEFAULT 0,
  `invoice_id` varchar(255) NOT NULL,
  `reseller_id` int(11) NOT NULL DEFAULT 0,
  `reseller_credit` decimal(12,2) NOT NULL,
  `reseller_discount` decimal(12,2) NOT NULL,
  `purchase_cost` varchar(10) NOT NULL,
  `profit` varchar(10) NOT NULL,
  `tmp_status` int(1) NOT NULL DEFAULT 0,
  `ip` varchar(255) NOT NULL,
  `response_email` varchar(555) NOT NULL,
  `sh_email` varchar(255) NOT NULL,
  `sh_contact` varchar(155) NOT NULL,
  `sh_firstname` varchar(555) NOT NULL,
  `sh_lastname` varchar(555) NOT NULL,
  `sh_address1` mediumtext NOT NULL,
  `sh_address2` mediumtext NOT NULL,
  `sh_city` varchar(555) NOT NULL,
  `sh_zip` varchar(50) NOT NULL,
  `sh_state` varchar(555) NOT NULL,
  `sh_country` varchar(555) NOT NULL,
  `shipped_by` varchar(255) NOT NULL,
  `currency_id` int(11) NOT NULL DEFAULT 0,
  `gift` int(1) NOT NULL DEFAULT 0,
  `gatway` int(11) NOT NULL DEFAULT 0,
  `promotionstock` int(1) NOT NULL DEFAULT 0,
  `invoiceid` varchar(50) NOT NULL,
  `remove` int(1) NOT NULL DEFAULT 0,
  `wholesale` int(1) NOT NULL DEFAULT 0,
  `buyadvance` int(1) NOT NULL DEFAULT 0,
  `subscribe` int(11) NOT NULL DEFAULT 0,
  `aid` int(11) NOT NULL DEFAULT 0,
  `pos` int(1) NOT NULL DEFAULT 0,
  `reply_date` varchar(50) NOT NULL,
  `warehouse` int(11) NOT NULL DEFAULT 0,
  `request` int(11) NOT NULL DEFAULT 0,
  `winner` int(1) NOT NULL DEFAULT 0,
  `feedback` int(1) NOT NULL DEFAULT 0,
  `requestsend` int(1) NOT NULL DEFAULT 0,
  `serial` varchar(255) NOT NULL,
  `data` text DEFAULT NULL,
  `tracking` varchar(255) DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL,
  `sh_preference` varchar(100) DEFAULT NULL,
  `sh_landmark` varchar(100) DEFAULT NULL,
  `latitude` varchar(200) DEFAULT NULL,
  `longitude` varchar(200) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_order_server`
--

CREATE TABLE `tbl_order_server` (
  `order_id` int(5) NOT NULL,
  `service_id` int(11) NOT NULL DEFAULT 0,
  `user_id` int(11) NOT NULL DEFAULT 0,
  `server` varchar(255) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `time` varchar(25) DEFAULT NULL,
  `note` varchar(255) DEFAULT NULL,
  `comments` varchar(255) DEFAULT NULL,
  `credit` decimal(10,2) DEFAULT NULL,
  `discount` decimal(10,2) DEFAULT NULL,
  `is_by_sms` varchar(15) DEFAULT NULL,
  `user_can_c` int(11) NOT NULL DEFAULT 0,
  `reply` varchar(255) DEFAULT NULL,
  `reply_time` varchar(50) DEFAULT NULL,
  `reply_by_admin` int(11) NOT NULL DEFAULT 0,
  `reply_by_sup` int(11) NOT NULL DEFAULT 0,
  `reply_by_api` int(11) NOT NULL DEFAULT 0,
  `verified_by_admin` int(11) NOT NULL DEFAULT 0,
  `verified_by_sup` int(11) NOT NULL DEFAULT 0,
  `reply_type` int(11) NOT NULL DEFAULT 0,
  `pass_key` varchar(100) DEFAULT NULL,
  `verified` int(11) NOT NULL DEFAULT 0,
  `retail_shop` int(11) NOT NULL DEFAULT 0,
  `invoice_id` varchar(255) DEFAULT NULL,
  `reseller_id` int(11) NOT NULL DEFAULT 0,
  `reseller_credit` decimal(12,2) DEFAULT NULL,
  `reseller_discount` decimal(12,2) DEFAULT NULL,
  `tmp_status` int(11) NOT NULL DEFAULT 0,
  `ip` varchar(255) DEFAULT NULL,
  `purchase_cost` varchar(10) DEFAULT NULL,
  `profit` varchar(10) DEFAULT NULL,
  `response_email` varchar(555) DEFAULT NULL,
  `currency_id` int(11) NOT NULL DEFAULT 0,
  `responseno` varchar(15) DEFAULT NULL,
  `subscribe` int(11) NOT NULL DEFAULT 0,
  `aid` int(11) NOT NULL DEFAULT 0,
  `reply_date` varchar(50) DEFAULT NULL,
  `invoiceid` int(11) NOT NULL DEFAULT 0,
  `acceptedby` int(11) NOT NULL DEFAULT 0,
  `qnt` int(11) NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_paymentgateways`
--

CREATE TABLE `tbl_paymentgateways` (
  `gateway` mediumtext NOT NULL,
  `setting` mediumtext NOT NULL,
  `value` mediumtext NOT NULL,
  `order` int(1) NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_pos_setting`
--

CREATE TABLE `tbl_pos_setting` (
  `id` int(11) NOT NULL,
  `papertype` int(2) NOT NULL,
  `template` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_pos_terminal`
--

CREATE TABLE `tbl_pos_terminal` (
  `posterminalid` int(5) NOT NULL,
  `devicename` varchar(250) DEFAULT NULL,
  `serialno` varchar(50) DEFAULT NULL,
  `devicestatus` tinyint(1) DEFAULT NULL,
  `userid` int(11) DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT 0,
  `date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_prd`
--

CREATE TABLE `tbl_prd` (
  `id` int(10) NOT NULL,
  `prd` varchar(50) NOT NULL,
  `mep` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_pricing_qnt`
--

CREATE TABLE `tbl_pricing_qnt` (
  `pricingqntid` int(10) NOT NULL,
  `start` int(5) DEFAULT NULL,
  `end` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_private_order`
--

CREATE TABLE `tbl_private_order` (
  `id` int(11) NOT NULL,
  `sid` varchar(255) NOT NULL,
  `uid` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `cid` varchar(11) NOT NULL,
  `qnt` int(11) NOT NULL DEFAULT 0,
  `status` int(1) NOT NULL DEFAULT 0,
  `date` varchar(555) NOT NULL,
  `chargeable` int(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_productbundle`
--

CREATE TABLE `tbl_productbundle` (
  `id` int(11) NOT NULL,
  `bundle` mediumtext NOT NULL,
  `currency_id` int(11) NOT NULL DEFAULT 0,
  `price` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_products`
--

CREATE TABLE `tbl_products` (
  `id` int(20) NOT NULL,
  `imei_single` tinyint(1) NOT NULL DEFAULT 0,
  `sort` int(11) NOT NULL DEFAULT 0,
  `imei_bulk` tinyint(1) NOT NULL DEFAULT 0,
  `imei_custom` tinyint(1) NOT NULL DEFAULT 0,
  `imei_custom_len` int(11) NOT NULL DEFAULT 0,
  `service_name` varchar(255) NOT NULL,
  `custom_name` varchar(50) NOT NULL,
  `custom_type` int(1) NOT NULL DEFAULT 0,
  `custom_required` int(1) NOT NULL DEFAULT 0,
  `credit` decimal(12,2) NOT NULL,
  `time` varchar(50) NOT NULL,
  `status` int(1) NOT NULL DEFAULT 0,
  `group_id` int(5) NOT NULL,
  `info` mediumtext NOT NULL,
  `notification_mail` varchar(255) NOT NULL,
  `model` tinyint(1) NOT NULL DEFAULT 0,
  `provider` tinyint(1) NOT NULL DEFAULT 0,
  `network` tinyint(1) NOT NULL DEFAULT 0,
  `assigned_brand` longtext NOT NULL,
  `bysupplier` int(11) NOT NULL DEFAULT 0,
  `gtin` varchar(50) NOT NULL,
  `assigned_model` longtext NOT NULL,
  `assigned_country` longtext NOT NULL,
  `assigned_provider` longtext NOT NULL,
  `assigned_network` longtext NOT NULL,
  `assigned_mep` longtext NOT NULL,
  `Requires_Type` varchar(255) NOT NULL,
  `Locks` tinyint(1) NOT NULL DEFAULT 0,
  `active` int(1) NOT NULL DEFAULT 0,
  `API` varchar(100) NOT NULL,
  `API_ID` varchar(100) NOT NULL,
  `info_file_name` varchar(255) NOT NULL,
  `download_link` varchar(555) NOT NULL,
  `faq_id` varchar(5) NOT NULL,
  `mep` tinyint(1) NOT NULL DEFAULT 0,
  `upc` varchar(255) NOT NULL,
  `mpn` varchar(255) NOT NULL,
  `listing` varchar(500) NOT NULL,
  `PIN` tinyint(1) NOT NULL DEFAULT 0,
  `KBH` tinyint(1) NOT NULL DEFAULT 0,
  `PRD` tinyint(1) NOT NULL DEFAULT 0,
  `Type` tinyint(1) NOT NULL DEFAULT 0,
  `Reference` tinyint(1) NOT NULL DEFAULT 0,
  `icon_link` varchar(555) NOT NULL,
  `retail` int(1) NOT NULL DEFAULT 0,
  `gatway` varchar(255) NOT NULL,
  `image_link1` varchar(555) NOT NULL,
  `image_link2` varchar(555) NOT NULL,
  `image_link3` varchar(555) NOT NULL,
  `image_link4` varchar(555) NOT NULL,
  `image_link5` varchar(555) NOT NULL,
  `image_hotdeal` varchar(100) NOT NULL,
  `default_image` int(1) NOT NULL DEFAULT 0,
  `retail_info` longtext NOT NULL,
  `verification` int(1) NOT NULL DEFAULT 0,
  `verifiable` int(1) NOT NULL DEFAULT 0,
  `usercan_cancel` int(1) NOT NULL DEFAULT 0,
  `fields` varchar(10) NOT NULL,
  `purchase_cost` varchar(10) NOT NULL,
  `stock` int(10) NOT NULL,
  `stock_allow` int(1) NOT NULL DEFAULT 0,
  `service_type` int(11) NOT NULL DEFAULT 0,
  `reply_type` int(2) NOT NULL,
  `imei_custom_name` varchar(255) NOT NULL,
  `imei_custom_info` varchar(555) NOT NULL,
  `promotiondis` varchar(10) NOT NULL,
  `happy_hours_start` varchar(100) NOT NULL,
  `happy_hours_end` varchar(100) NOT NULL,
  `happy_hours_repetation` varchar(100) NOT NULL,
  `happy_hours_weekdays` mediumtext NOT NULL,
  `hot` varchar(1) NOT NULL,
  `template_id1` int(11) NOT NULL DEFAULT 0,
  `template_id2` int(11) NOT NULL DEFAULT 0,
  `taxed` int(1) NOT NULL DEFAULT 0,
  `virtual` int(1) NOT NULL DEFAULT 0,
  `show_onhome` int(1) NOT NULL DEFAULT 0,
  `weight` varchar(100) NOT NULL,
  `manufacture_id` int(3) NOT NULL,
  `warehouse_id` int(3) NOT NULL,
  `availability_date` varchar(50) NOT NULL,
  `subscribe_days` varchar(10) NOT NULL,
  `subscribe_credit` varchar(15) NOT NULL,
  `subscribe` int(1) NOT NULL DEFAULT 0,
  `height` varchar(100) NOT NULL,
  `width` varchar(100) NOT NULL,
  `depth` varchar(100) NOT NULL,
  `images` mediumtext NOT NULL,
  `videos` mediumtext NOT NULL,
  `extratag` varchar(1000) NOT NULL,
  `relproduct` mediumtext NOT NULL,
  `relaccess` mediumtext NOT NULL,
  `promotion_stock` varchar(25) NOT NULL,
  `resellerdisctype` int(1) NOT NULL DEFAULT 0,
  `resellerdisc` varchar(25) NOT NULL,
  `store` int(1) NOT NULL DEFAULT 0,
  `othergroup` mediumtext NOT NULL,
  `freeship` int(1) NOT NULL DEFAULT 0,
  `bundle` int(11) NOT NULL DEFAULT 0,
  `rating` varchar(10) NOT NULL,
  `key_selling` int(11) NOT NULL,
  `short_info` mediumtext NOT NULL,
  `ebay_code` varchar(250) NOT NULL,
  `notificationemail` int(1) NOT NULL DEFAULT 0,
  `viewer` int(11) NOT NULL DEFAULT 0,
  `review` int(1) NOT NULL DEFAULT 0,
  `outofstock` int(1) NOT NULL DEFAULT 0,
  `minqnt` int(5) NOT NULL,
  `maxqnt` int(5) NOT NULL,
  `zeropriceaction` int(1) NOT NULL DEFAULT 0,
  `format` varchar(555) NOT NULL,
  `isbn` varchar(555) NOT NULL,
  `audio_format` varchar(555) NOT NULL,
  `subscriptionorderlimit` int(11) NOT NULL DEFAULT 0,
  `affiliate_comission` varchar(255) NOT NULL,
  `reorder_level` int(11) NOT NULL DEFAULT 0,
  `reorder_notify` varchar(50) NOT NULL,
  `daily_deal` int(1) NOT NULL DEFAULT 0,
  `bundle_list` mediumtext NOT NULL,
  `seo_title` varchar(555) NOT NULL,
  `seo_description` mediumtext NOT NULL,
  `google_product_type` mediumtext NOT NULL,
  `product_type` int(1) NOT NULL DEFAULT 0,
  `draw` int(1) NOT NULL DEFAULT 0,
  `return_days` int(11) NOT NULL DEFAULT 0,
  `prev_price` varchar(255) NOT NULL,
  `callforpricing` int(1) NOT NULL DEFAULT 0,
  `download_id` varchar(555) NOT NULL,
  `allowreseller` mediumtext NOT NULL,
  `seo_keywords` mediumtext NOT NULL,
  `customhtml` mediumtext NOT NULL,
  `nav_icon` varchar(555) NOT NULL,
  `pos` int(1) NOT NULL DEFAULT 0,
  `sku` varchar(50) NOT NULL,
  `ean` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_productsignup`
--

CREATE TABLE `tbl_productsignup` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `fname` varchar(255) NOT NULL,
  `lname` varchar(255) NOT NULL,
  `pid` int(11) NOT NULL DEFAULT 0,
  `date` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_product_credit`
--

CREATE TABLE `tbl_product_credit` (
  `service_id` int(11) NOT NULL DEFAULT 0,
  `currency_id` int(11) NOT NULL DEFAULT 0,
  `credit` decimal(25,2) NOT NULL,
  `credit_subscribe` varchar(15) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_product_group`
--

CREATE TABLE `tbl_product_group` (
  `id` int(11) NOT NULL,
  `group_name` varchar(100) NOT NULL,
  `active` int(1) NOT NULL DEFAULT 0,
  `display_order` int(5) NOT NULL,
  `imagelink` mediumtext NOT NULL,
  `iconlink` mediumtext NOT NULL,
  `description` mediumtext NOT NULL,
  `mid` int(11) NOT NULL DEFAULT 0,
  `seotitle` varchar(200) DEFAULT NULL,
  `seodescription` text DEFAULT NULL,
  `showonhomepage` tinyint(1) DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_promotion`
--

CREATE TABLE `tbl_promotion` (
  `id` int(11) NOT NULL,
  `code` mediumtext NOT NULL,
  `name` varchar(255) NOT NULL,
  `amount` varchar(50) NOT NULL,
  `type` int(1) NOT NULL DEFAULT 0,
  `uid` mediumtext NOT NULL,
  `currency` int(11) NOT NULL DEFAULT 0,
  `vali_start` varchar(100) NOT NULL,
  `vali_end` varchar(100) NOT NULL,
  `used` int(11) NOT NULL DEFAULT 0,
  `product` mediumtext NOT NULL,
  `product_type` varchar(255) NOT NULL,
  `total` varchar(50) NOT NULL,
  `newsignup` int(1) NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_provider`
--

CREATE TABLE `tbl_provider` (
  `ID` int(11) NOT NULL,
  `C_ID` varchar(15) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `api` mediumtext NOT NULL,
  `apiid` mediumtext NOT NULL,
  `N_ID` varchar(15) NOT NULL,
  `listing` int(2) NOT NULL,
  `mep_new` varchar(500) NOT NULL,
  `mep_old` varchar(500) NOT NULL,
  `image_link` varchar(555) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_provider_country`
--

CREATE TABLE `tbl_provider_country` (
  `ID` int(11) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `api` mediumtext NOT NULL,
  `apiid` mediumtext NOT NULL,
  `N_ID` varchar(15) NOT NULL,
  `listing` int(2) NOT NULL,
  `image_link` varchar(555) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_provider_model_mep`
--

CREATE TABLE `tbl_provider_model_mep` (
  `id` int(10) NOT NULL,
  `pid` varchar(10) NOT NULL,
  `mid` varchar(10) NOT NULL,
  `mep` varchar(500) NOT NULL,
  `mepl` varchar(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_purchase_cost`
--

CREATE TABLE `tbl_purchase_cost` (
  `id` int(11) NOT NULL,
  `cid` int(11) NOT NULL DEFAULT 0,
  `sid` int(11) NOT NULL DEFAULT 0,
  `price` varchar(50) NOT NULL,
  `type` varchar(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_quick_news`
--

CREATE TABLE `tbl_quick_news` (
  `id` int(11) NOT NULL,
  `news` mediumtext NOT NULL,
  `status` int(1) NOT NULL DEFAULT 0,
  `date` varchar(50) NOT NULL,
  `scroll` int(1) NOT NULL DEFAULT 0,
  `beforelogin` int(1) NOT NULL DEFAULT 0,
  `beforedate` varchar(50) NOT NULL,
  `userid` int(11) NOT NULL DEFAULT 0,
  `serviceid` int(11) NOT NULL DEFAULT 0,
  `groupid` int(11) NOT NULL DEFAULT 0,
  `pricechange` int(11) NOT NULL DEFAULT 0,
  `currencyid` int(11) NOT NULL DEFAULT 0,
  `newprice` decimal(12,2) NOT NULL,
  `oldprice` decimal(12,2) NOT NULL,
  `notification` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_recent_menu`
--

CREATE TABLE `tbl_recent_menu` (
  `id` int(10) NOT NULL,
  `page_id` int(10) NOT NULL,
  `listing` int(10) NOT NULL,
  `admin_id` int(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_recent_pages`
--

CREATE TABLE `tbl_recent_pages` (
  `id` int(10) NOT NULL,
  `pagename` varchar(100) NOT NULL,
  `pagetitle` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `tbl_recent_pages`
--

INSERT INTO `tbl_recent_pages` (`id`, `pagename`, `pagetitle`) VALUES
(1, 'home', 'Dashboard'),
(2, 'unpaidinvoice', 'Unpaid Invoices'),
(3, 'utilities.systemsummary', 'System Summary'),
(4, 'utilities.comments', 'Comments'),
(5, 'dashboard.testimonial', 'Testimonial'),
(6, 'utilities.adminactivities', 'Admin Activities'),
(7, 'utilities.useractivities', 'User Activities'),
(8, 'utilities.supplierlog', 'Supplier Log'),
(9, 'utilities.userstatus', 'New Registered Users'),
(10, 'utilities.resellershop', 'Reseller Shop'),
(11, 'clientlist', 'Clients'),
(12, 'addnewclient', 'Add New Client'),
(13, 'clientgroup', 'Client Group'),
(14, 'updatemultipalclient', 'Update Multipal Account'),
(15, 'supplierlist', 'Suppliers'),
(16, 'addnewsupplier', 'Add New Supplier'),
(17, 'imeiservice', 'IMEI Service'),
(18, 'fileservice', 'File Service'),
(19, 'serverservice', 'Server Service'),
(20, 'catlog', 'Catlog / Shopping Cart'),
(21, 'imeiorder', 'IMEI Orders'),
(22, 'fileorder', 'File Orders'),
(23, 'serverorder', 'Server Orders'),
(24, 'productorder', 'Product Order'),
(25, 'viewpage', 'Create New Pages'),
(26, 'knowledgebasemain', 'Knowledge Base'),
(27, 'indexpage', 'Index Content'),
(28, 'menumanager', 'Menu Manager'),
(29, 'viewblog', 'View Post'),
(30, 'newblog', 'New Post'),
(31, 'blogcategory', 'Blog Category'),
(32, 'userstatement', 'User Statement'),
(33, 'resellerstatement', 'Reseller Statement'),
(34, 'userbyincome', 'Top User by Income'),
(35, 'salesbyproduct', 'Sales By Product'),
(36, 'apilog', 'Api Log'),
(37, 'gatewaylog', 'Gateway Log'),
(38, 'monthlyorder', 'Monthly Orders'),
(39, 'ordersummery', 'Order Summary'),
(40, 'utilities.chathistory', 'Chat History'),
(41, 'sendMail', 'Send Mass Mail'),
(42, 'utilities.databasebackup', 'Database Backup'),
(43, 'utilities.databasestatus', 'Database Status'),
(44, 'utilities.systemcleanup', 'System Cleanup'),
(45, 'utilities.onlineusers', 'Online User'),
(46, 'blockedipmain', 'Blocked IP'),
(47, 'languagetools', 'Language Tools'),
(48, 'import', 'Import'),
(49, 'generalsettings', 'General Settings'),
(50, 'mailsetting', 'E-Mail Settings'),
(51, 'securitysettings', 'Security'),
(52, 'settingautomation', 'Automation'),
(53, 'currencies', 'Currencies'),
(54, 'paymentgateway', 'Payment Gatways'),
(55, 'apisetting', 'API Settings'),
(56, 'administrator', 'System Administrator'),
(57, 'countryprovider', 'Country - Provider'),
(58, 'brandmodel', 'Brand - Model'),
(59, 'mep', 'MEP'),
(60, 'manufacturewarehouse', 'Manufacture - Warehouse'),
(61, 'rechargemain', 'Recharge Voucher'),
(62, 'maintenance', 'Maintenance Mode'),
(63, 'help.license', 'License Information'),
(64, 'help.selfupdate', 'Auto Update'),
(65, 'help.supportrequest', 'Request For Support');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_reseller_payout`
--

CREATE TABLE `tbl_reseller_payout` (
  `id` int(11) NOT NULL,
  `userid` int(11) NOT NULL DEFAULT 0,
  `reseller` int(11) NOT NULL DEFAULT 0,
  `status` varchar(5) NOT NULL,
  `date` varchar(50) NOT NULL,
  `amount` decimal(15,2) NOT NULL,
  `note` mediumtext NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_reseller_price`
--

CREATE TABLE `tbl_reseller_price` (
  `id` int(11) NOT NULL,
  `supplier` int(11) NOT NULL DEFAULT 0,
  `service` varchar(50) NOT NULL,
  `sid` int(11) NOT NULL DEFAULT 0,
  `price` decimal(25,3) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_reseller_statement`
--

CREATE TABLE `tbl_reseller_statement` (
  `id` int(11) NOT NULL,
  `rid` int(5) NOT NULL,
  `sid` int(5) NOT NULL,
  `type` varchar(50) NOT NULL,
  `uid` int(5) NOT NULL,
  `date` varchar(50) NOT NULL,
  `amount` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_return_request`
--

CREATE TABLE `tbl_return_request` (
  `id` int(11) NOT NULL,
  `oid` int(11) NOT NULL DEFAULT 0,
  `date` varchar(50) NOT NULL,
  `status` int(1) NOT NULL DEFAULT 0,
  `uid` varchar(10) NOT NULL,
  `reason` mediumtext NOT NULL,
  `action` mediumtext NOT NULL,
  `comment` mediumtext NOT NULL,
  `sendbyuid` int(11) NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_review`
--

CREATE TABLE `tbl_review` (
  `id` mediumint(11) NOT NULL,
  `pid` int(11) NOT NULL DEFAULT 0,
  `sid` int(11) NOT NULL DEFAULT 0,
  `lid` int(11) NOT NULL DEFAULT 0,
  `name` varchar(255) NOT NULL,
  `email` varchar(555) NOT NULL,
  `comment` mediumtext NOT NULL,
  `rate` varchar(10) NOT NULL,
  `date` varchar(50) NOT NULL,
  `status` int(1) NOT NULL DEFAULT 0,
  `supplier` int(11) NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_security_question`
--

CREATE TABLE `tbl_security_question` (
  `id` int(11) NOT NULL,
  `question` mediumtext NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `tbl_security_question`
--

INSERT INTO `tbl_security_question` (`id`, `question`, `status`) VALUES
(1, '(CaSe Sensitive) What is the make and model of your first car?', 1),
(2, '(CaSe Sensitive) What is the name of your childhood best friend?', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_seo_links`
--

CREATE TABLE `tbl_seo_links` (
  `id` int(11) NOT NULL,
  `link` mediumtext NOT NULL,
  `status` int(1) NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_serial_list`
--

CREATE TABLE `tbl_serial_list` (
  `id` int(11) NOT NULL,
  `serial` varchar(100) NOT NULL,
  `pid` int(11) NOT NULL DEFAULT 0,
  `wid` int(11) NOT NULL DEFAULT 0,
  `status` int(1) NOT NULL DEFAULT 0,
  `date` varchar(50) NOT NULL,
  `aid` int(5) NOT NULL,
  `transist` varchar(20) NOT NULL,
  `refund` int(1) NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_server_credit`
--

CREATE TABLE `tbl_server_credit` (
  `service_id` int(11) NOT NULL DEFAULT 0,
  `currency_id` int(11) NOT NULL DEFAULT 0,
  `credit` decimal(25,2) DEFAULT NULL,
  `credit_subscribe` varchar(15) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_server_group`
--

CREATE TABLE `tbl_server_group` (
  `id` int(11) NOT NULL,
  `group_name` varchar(100) DEFAULT NULL,
  `active` int(11) NOT NULL DEFAULT 0,
  `display_order` int(11) NOT NULL DEFAULT 0,
  `imagelink` mediumtext DEFAULT NULL,
  `description` mediumtext DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_server_log`
--

CREATE TABLE `tbl_server_log` (
  `id` int(20) NOT NULL,
  `service_name` varchar(255) DEFAULT NULL,
  `custom_name` varchar(100) DEFAULT NULL,
  `custom_type` int(11) NOT NULL DEFAULT 0,
  `custom_required` int(11) NOT NULL DEFAULT 0,
  `credit` decimal(12,2) DEFAULT NULL,
  `retail_credit` varchar(100) DEFAULT NULL,
  `time` varchar(50) DEFAULT NULL,
  `info` longtext DEFAULT NULL,
  `group_id` int(11) NOT NULL DEFAULT 0,
  `active` int(11) NOT NULL DEFAULT 0,
  `info_file_name` varchar(255) DEFAULT NULL,
  `download_link` varchar(555) DEFAULT NULL,
  `icon_link` varchar(200) DEFAULT NULL,
  `faq_id` varchar(5) DEFAULT NULL,
  `notification_mail` varchar(255) DEFAULT NULL,
  `verification` int(11) NOT NULL DEFAULT 0,
  `usercan_cancel` int(11) NOT NULL DEFAULT 0,
  `retail` int(11) NOT NULL DEFAULT 0,
  `retail_info` mediumtext DEFAULT NULL,
  `image_link` varchar(555) DEFAULT NULL,
  `image_hotdeal` varchar(200) DEFAULT NULL,
  `API` varchar(100) DEFAULT NULL,
  `API_ID` varchar(100) DEFAULT NULL,
  `purchase_cost` varchar(10) DEFAULT NULL,
  `stock` varchar(10) DEFAULT NULL,
  `stock_allow` int(11) NOT NULL DEFAULT 0,
  `promotiondis` varchar(10) DEFAULT NULL,
  `happy_hours_start` varchar(100) DEFAULT NULL,
  `happy_hours_end` varchar(100) DEFAULT NULL,
  `happy_hours_repetation` varchar(100) DEFAULT NULL,
  `happy_hours_weekdays` mediumtext DEFAULT NULL,
  `verifiable` int(11) NOT NULL DEFAULT 0,
  `hot` varchar(100) DEFAULT NULL,
  `template_id1` int(11) NOT NULL DEFAULT 0,
  `template_id2` int(11) NOT NULL DEFAULT 0,
  `taxed` int(11) NOT NULL DEFAULT 0,
  `show_onhome` int(11) NOT NULL DEFAULT 0,
  `subscribe_days` varchar(10) DEFAULT NULL,
  `subscribe_credit` varchar(15) DEFAULT NULL,
  `subscribe` int(11) NOT NULL DEFAULT 0,
  `key_selling` int(11) NOT NULL DEFAULT 0,
  `notificationemail` int(11) NOT NULL DEFAULT 0,
  `sort` int(11) NOT NULL DEFAULT 0,
  `smsnotification` int(11) NOT NULL DEFAULT 0,
  `subscriptionorderlimit` int(11) NOT NULL DEFAULT 0,
  `affiliate_comission` varchar(255) DEFAULT NULL,
  `review` int(11) NOT NULL DEFAULT 0,
  `seo_title` varchar(555) DEFAULT NULL,
  `seo_description` mediumtext DEFAULT NULL,
  `viewer` int(11) NOT NULL DEFAULT 0,
  `prev_price` varchar(50) DEFAULT NULL,
  `store` int(11) NOT NULL DEFAULT 0,
  `resellerdisctype` int(11) NOT NULL DEFAULT 0,
  `resellerdisc` varchar(25) DEFAULT NULL,
  `allowreseller` mediumtext DEFAULT NULL,
  `seo_keywords` mediumtext DEFAULT NULL,
  `customhtml` mediumtext DEFAULT NULL,
  `qnt` int(11) NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_services_file`
--

CREATE TABLE `tbl_services_file` (
  `id` int(20) NOT NULL,
  `service_name` varchar(255) DEFAULT NULL,
  `credit` decimal(12,3) DEFAULT NULL,
  `time` varchar(50) DEFAULT NULL,
  `time_unit` varchar(500) DEFAULT NULL,
  `group_id` int(11) NOT NULL DEFAULT 0,
  `reply_type` int(11) NOT NULL DEFAULT 0,
  `info` longtext DEFAULT NULL,
  `active` int(11) NOT NULL DEFAULT 0,
  `info_file_name` varchar(100) DEFAULT NULL,
  `download_link` varchar(555) DEFAULT NULL,
  `icon_link` varchar(200) DEFAULT NULL,
  `faq_id` varchar(5) DEFAULT NULL,
  `notification_mail` varchar(255) DEFAULT NULL,
  `verification` int(11) NOT NULL DEFAULT 0,
  `verifiable` int(11) NOT NULL DEFAULT 0,
  `usercan_cancel` int(11) NOT NULL DEFAULT 0,
  `retail_info` text DEFAULT NULL,
  `image_link` varchar(555) DEFAULT NULL,
  `image_hotdeal` varchar(200) DEFAULT NULL,
  `retail` int(11) NOT NULL DEFAULT 0,
  `purchase_cost` varchar(10) DEFAULT NULL,
  `stock` varchar(10) DEFAULT NULL,
  `stock_allow` int(11) NOT NULL DEFAULT 0,
  `allow_extension` mediumtext DEFAULT NULL,
  `file_format` varchar(255) DEFAULT NULL,
  `bulk_reply` int(11) NOT NULL DEFAULT 0,
  `API` varchar(100) DEFAULT NULL,
  `API_ID` varchar(100) DEFAULT NULL,
  `promotiondis` varchar(10) DEFAULT NULL,
  `happy_hours_start` varchar(100) DEFAULT NULL,
  `happy_hours_end` varchar(100) DEFAULT NULL,
  `happy_hours_repetation` varchar(100) DEFAULT NULL,
  `happy_hours_weekdays` mediumtext DEFAULT NULL,
  `hot` varchar(100) DEFAULT NULL,
  `template_id1` int(11) NOT NULL DEFAULT 0,
  `template_id2` int(11) NOT NULL DEFAULT 0,
  `subscribe_days` varchar(10) DEFAULT NULL,
  `subscribe_credit` varchar(15) DEFAULT NULL,
  `subscribe` int(11) NOT NULL DEFAULT 0,
  `key_selling` varchar(11) DEFAULT NULL,
  `notificationemail` int(11) NOT NULL DEFAULT 0,
  `sort` int(11) NOT NULL DEFAULT 0,
  `smsnotification` int(11) NOT NULL DEFAULT 0,
  `subscriptionorderlimit` int(11) NOT NULL DEFAULT 0,
  `errormsg` varchar(500) DEFAULT NULL,
  `seo_title` varchar(555) DEFAULT NULL,
  `seo_description` mediumtext DEFAULT NULL,
  `prev_price` varchar(50) DEFAULT NULL,
  `store` int(11) NOT NULL DEFAULT 0,
  `resellerdisctype` int(11) NOT NULL DEFAULT 0,
  `resellerdisc` varchar(25) DEFAULT NULL,
  `customhtml` mediumtext DEFAULT NULL,
  `colortag` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_services_imei`
--

CREATE TABLE `tbl_services_imei` (
  `id` int(20) NOT NULL,
  `imei_single` tinyint(4) NOT NULL DEFAULT 0,
  `imei_bulk` tinyint(4) NOT NULL DEFAULT 0,
  `imei_custom` tinyint(4) NOT NULL DEFAULT 0,
  `imei_custom_len` int(11) NOT NULL DEFAULT 0,
  `service_name` varchar(255) DEFAULT NULL,
  `custom_name` varchar(50) DEFAULT NULL,
  `custom_type` int(11) NOT NULL DEFAULT 0,
  `custom_required` int(11) NOT NULL DEFAULT 0,
  `credit` decimal(13,3) DEFAULT NULL,
  `retail_credit` decimal(15,3) DEFAULT NULL,
  `time` varchar(50) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `group_id` int(11) NOT NULL DEFAULT 0,
  `info` longtext DEFAULT NULL,
  `review` int(11) NOT NULL DEFAULT 0,
  `notification_mail` varchar(255) DEFAULT NULL,
  `model` tinyint(4) NOT NULL DEFAULT 0,
  `provider` tinyint(4) NOT NULL DEFAULT 0,
  `network` tinyint(4) NOT NULL DEFAULT 0,
  `assigned_brand` mediumtext DEFAULT NULL,
  `assigned_model` mediumtext DEFAULT NULL,
  `assigned_country` mediumtext DEFAULT NULL,
  `assigned_provider` mediumtext DEFAULT NULL,
  `assigned_network` mediumtext DEFAULT NULL,
  `assigned_mep` mediumtext DEFAULT NULL,
  `Requires_Type` varchar(255) DEFAULT NULL,
  `Locks` tinyint(4) NOT NULL DEFAULT 0,
  `active` int(11) NOT NULL DEFAULT 0,
  `API` varchar(100) DEFAULT NULL,
  `manualverification` int(11) NOT NULL DEFAULT 0,
  `API_ID` varchar(100) DEFAULT NULL,
  `info_file_name` varchar(255) DEFAULT NULL,
  `download_link` varchar(555) DEFAULT NULL,
  `faq_id` varchar(5) DEFAULT NULL,
  `mep` tinyint(4) NOT NULL DEFAULT 0,
  `listing` varchar(500) DEFAULT NULL,
  `PIN` tinyint(4) NOT NULL DEFAULT 0,
  `KBH` tinyint(4) NOT NULL DEFAULT 0,
  `PRD` tinyint(4) NOT NULL DEFAULT 0,
  `Type` tinyint(4) NOT NULL DEFAULT 0,
  `Reference` tinyint(4) NOT NULL DEFAULT 0,
  `icon_link` varchar(555) DEFAULT NULL,
  `image_hotdeal` varchar(200) DEFAULT NULL,
  `retail` int(11) NOT NULL DEFAULT 0,
  `gatway` varchar(255) DEFAULT NULL,
  `image_link` varchar(555) DEFAULT NULL,
  `retail_info` mediumtext DEFAULT NULL,
  `verification` int(11) NOT NULL DEFAULT 0,
  `verifiable` int(11) NOT NULL DEFAULT 0,
  `usercan_cancel` int(11) NOT NULL DEFAULT 0,
  `fields` varchar(10) DEFAULT NULL,
  `purchase_cost` varchar(10) DEFAULT NULL,
  `stock` varchar(10) DEFAULT NULL,
  `stock_allow` int(11) NOT NULL DEFAULT 0,
  `service_type` int(11) NOT NULL DEFAULT 0,
  `reply_type` int(11) NOT NULL DEFAULT 0,
  `imei_custom_name` varchar(255) DEFAULT NULL,
  `imei_custom_info` varchar(555) DEFAULT NULL,
  `promotiondis` varchar(10) DEFAULT NULL,
  `happy_hours_start` varchar(100) DEFAULT NULL,
  `happy_hours_end` varchar(100) DEFAULT NULL,
  `happy_hours_repetation` varchar(100) DEFAULT NULL,
  `happy_hours_weekdays` mediumtext DEFAULT NULL,
  `hot` varchar(1) DEFAULT NULL,
  `template_id1` int(11) NOT NULL DEFAULT 0,
  `template_id2` int(11) NOT NULL DEFAULT 0,
  `taxed` int(11) NOT NULL DEFAULT 0,
  `show_onhome` int(11) NOT NULL DEFAULT 0,
  `subscribe_days` varchar(10) DEFAULT NULL,
  `subscribe_credit` varchar(15) DEFAULT NULL,
  `subscribe` int(11) NOT NULL DEFAULT 0,
  `key_selling` varchar(50) DEFAULT NULL,
  `ebay_code` mediumtext DEFAULT NULL,
  `notificationemail` int(11) NOT NULL DEFAULT 0,
  `sort` int(11) NOT NULL DEFAULT 0,
  `mid` int(11) NOT NULL DEFAULT 0,
  `smsnotification` int(11) NOT NULL DEFAULT 0,
  `subscriptionorderlimit` int(11) NOT NULL DEFAULT 0,
  `affiliate_comission` varchar(255) DEFAULT NULL,
  `seo_title` varchar(555) DEFAULT NULL,
  `seo_description` mediumtext DEFAULT NULL,
  `viewer` int(11) NOT NULL DEFAULT 0,
  `prev_price` decimal(20,3) DEFAULT NULL,
  `store` int(11) NOT NULL DEFAULT 0,
  `resellerdisctype` int(11) NOT NULL DEFAULT 0,
  `resellerdisc` varchar(25) DEFAULT NULL,
  `allowreseller` mediumtext DEFAULT NULL,
  `seo_keywords` mediumtext DEFAULT NULL,
  `isalpha` int(11) NOT NULL DEFAULT 0,
  `features` mediumtext DEFAULT NULL,
  `customhtml` mediumtext DEFAULT NULL,
  `autoreply` int(11) NOT NULL DEFAULT 0,
  `SN` int(11) NOT NULL DEFAULT 0,
  `SecRO` int(11) NOT NULL DEFAULT 0,
  `retail_name` varchar(255) DEFAULT NULL,
  `acceptterms` int(11) NOT NULL DEFAULT 0,
  `sku` varchar(50) NOT NULL,
  `newservice` int(1) NOT NULL DEFAULT 0,
  `lastupdatedtime` varchar(50) NOT NULL,
  `apilower` decimal(12,3) NOT NULL,
  `useasserver` int(1) NOT NULL DEFAULT 0,
  `validateimei` int(1) NOT NULL DEFAULT 0,
  `qnt` int(1) NOT NULL DEFAULT 0,
  `knowledgebaseas` int(1) NOT NULL,
  `maxlength` int(5) NOT NULL,
  `imeiregex` varchar(250) NOT NULL,
  `colortag` varchar(50) NOT NULL,
  `priceslack` varchar(150) NOT NULL,
  `orderslack` varchar(150) NOT NULL,
  `autoapi` int(1) NOT NULL,
  `API_TYPEID` varchar(50) NOT NULL,
  `inactivebyapi` int(1) NOT NULL,
  `apiincrease` varchar(20) NOT NULL,
  `apiincreasetype` varchar(20) NOT NULL,
  `knowledgebase` varchar(255) NOT NULL,
  `qntoptions` varchar(250) NOT NULL,
  `minqnt` int(4) NOT NULL,
  `maxqnt` int(4) NOT NULL,
  `apiserverid` int(11) NOT NULL,
  `verifyforreject` int(1) NOT NULL,
  `verificationdays` int(2) NOT NULL,
  `autoreplycompleted` int(1) NOT NULL,
  `avgdeliverytime` varchar(50) NOT NULL,
  `avgexetime` varchar(50) NOT NULL,
  `retailincrease` decimal(10,2) NOT NULL,
  `retailincreaseby` varchar(20) NOT NULL,
  `autorejectduplicate` int(1) NOT NULL,
  `maxresponsetime` int(5) NOT NULL,
  `hideguest` int(1) NOT NULL,
  `lasteditedby` int(11) NOT NULL,
  `free` int(1) DEFAULT 0,
  `rejectqnt` int(1) DEFAULT 0,
  `reward` int(1) DEFAULT 0,
  `point` decimal(10,2) DEFAULT 0.00,
  `purchasepoint` decimal(20,2) DEFAULT NULL,
  `howtoinfo` text DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `tbl_services_imei`
--

INSERT INTO `tbl_services_imei` (`id`, `imei_single`, `imei_bulk`, `imei_custom`, `imei_custom_len`, `service_name`, `custom_name`, `custom_type`, `custom_required`, `credit`, `retail_credit`, `time`, `status`, `group_id`, `info`, `review`, `notification_mail`, `model`, `provider`, `network`, `assigned_brand`, `assigned_model`, `assigned_country`, `assigned_provider`, `assigned_network`, `assigned_mep`, `Requires_Type`, `Locks`, `active`, `API`, `manualverification`, `API_ID`, `info_file_name`, `download_link`, `faq_id`, `mep`, `listing`, `PIN`, `KBH`, `PRD`, `Type`, `Reference`, `icon_link`, `image_hotdeal`, `retail`, `gatway`, `image_link`, `retail_info`, `verification`, `verifiable`, `usercan_cancel`, `fields`, `purchase_cost`, `stock`, `stock_allow`, `service_type`, `reply_type`, `imei_custom_name`, `imei_custom_info`, `promotiondis`, `happy_hours_start`, `happy_hours_end`, `happy_hours_repetation`, `happy_hours_weekdays`, `hot`, `template_id1`, `template_id2`, `taxed`, `show_onhome`, `subscribe_days`, `subscribe_credit`, `subscribe`, `key_selling`, `ebay_code`, `notificationemail`, `sort`, `mid`, `smsnotification`, `subscriptionorderlimit`, `affiliate_comission`, `seo_title`, `seo_description`, `viewer`, `prev_price`, `store`, `resellerdisctype`, `resellerdisc`, `allowreseller`, `seo_keywords`, `isalpha`, `features`, `customhtml`, `autoreply`, `SN`, `SecRO`, `retail_name`, `acceptterms`, `sku`, `newservice`, `lastupdatedtime`, `apilower`, `useasserver`, `validateimei`, `qnt`, `knowledgebaseas`, `maxlength`, `imeiregex`, `colortag`, `priceslack`, `orderslack`, `autoapi`, `API_TYPEID`, `inactivebyapi`, `apiincrease`, `apiincreasetype`, `knowledgebase`, `qntoptions`, `minqnt`, `maxqnt`, `apiserverid`, `verifyforreject`, `verificationdays`, `autoreplycompleted`, `avgdeliverytime`, `avgexetime`, `retailincrease`, `retailincreaseby`, `autorejectduplicate`, `maxresponsetime`, `hideguest`, `lasteditedby`, `free`, `rejectqnt`, `reward`, `point`, `purchasepoint`, `howtoinfo`) VALUES
(19, 0, 0, 0, 0, 'APPLE iPHONE CARRIER + FMI + COVERAGE + GSMA → IMEI/SN⚡', '', 0, 0, '0.220', '0.000', ' Instant', 1, 1, '', 0, '', 0, 0, 0, '', '', '', '', '', '', '', 0, 1, 'fusion13', 0, '2939', '', '', '', 0, '', 0, 0, 0, 0, 0, '', '', 0, '', '', '', 0, 0, 0, '', '', '', 0, 0, 0, '', '', '', '', '', '', '', '', 0, 0, 0, 0, '', '', 0, '', '', 0, 0, 0, 0, 0, '', '', '', 0, '0.000', 0, 0, '', '', '', 0, '', '', 0, 0, 0, '', 0, '', 1, '', '0.000', 0, 0, 0, 0, 0, '', '', '', '', 0, '', 0, '', '', '', '', 0, 0, 0, 0, 0, 0, '', '', '0.00', '', 0, 0, 0, 0, 0, 0, 0, '0.00', '0.00', ''),
(18, 0, 0, 0, 0, 'APPLE iOS / MacOS MDM STATUS → IMEI/SN', '', 0, 0, '2.400', '0.000', ' Instant', 1, 1, '', 0, '', 0, 0, 0, '', '', '', '', '', '', '', 0, 1, 'fusion13', 0, '3155', '', '', '', 0, '', 0, 0, 0, 0, 0, '', '', 0, '', '', '', 0, 0, 0, '', '', '', 0, 0, 0, '', '', '', '', '', '', '', '', 0, 0, 0, 0, '', '', 0, '', '', 0, 0, 0, 0, 0, '', '', '', 0, '0.000', 0, 0, '', '', '', 0, '', '', 0, 0, 0, '', 0, '', 1, '', '0.000', 0, 0, 0, 0, 0, '', '', '', '', 0, '', 0, '', '', '', '', 0, 0, 0, 0, 0, 0, '', '', '0.00', '', 0, 0, 0, 0, 0, 0, 0, '0.00', '0.00', ''),
(17, 0, 0, 0, 0, 'XIAOMI MI CHECK INFO - IMEI/SN/KEY', '', 0, 0, '0.100', '0.000', ' Instant', 1, 1, '', 0, '', 0, 0, 0, '', '', '', '', '', '', '', 0, 1, 'fusion13', 0, '221', '', '', '', 0, '', 0, 0, 0, 0, 0, '', '', 0, '', '', '', 0, 0, 0, '', '', '', 0, 0, 0, '', '', '', '', '', '', '', '', 0, 0, 0, 0, '', '', 0, '', '', 0, 0, 0, 0, 0, '', '', '', 0, '0.000', 0, 0, '', '', '', 0, '', '', 0, 0, 0, '', 0, '', 1, '', '0.000', 0, 0, 0, 0, 0, '', '', '', '', 0, '', 0, '', '', '', '', 0, 0, 0, 0, 0, 0, '', '', '0.00', '', 0, 0, 0, 0, 0, 0, 0, '0.00', '0.00', ''),
(16, 0, 0, 0, 0, 'T-MOBILE USA CLEAN/BLOCKED/UNPAID STATUS - PRO', '', 0, 0, '0.080', '0.000', ' Instant', 1, 1, '', 0, '', 0, 0, 0, '', '', '', '', '', '', '', 0, 1, 'fusion13', 0, '1625', '', '', '', 0, '', 0, 0, 0, 0, 0, '', '', 0, '', '', '', 0, 0, 0, '', '', '', 0, 0, 0, '', '', '', '', '', '', '', '', 0, 0, 0, 0, '', '', 0, '', '', 0, 0, 0, 0, 0, '', '', '', 0, '0.000', 0, 0, '', '', '', 0, '', '', 0, 0, 0, '', 0, '', 1, '', '0.000', 0, 0, 0, 0, 0, '', '', '', '', 0, '', 0, '', '', '', '', 0, 0, 0, 0, 0, 0, '', '', '0.00', '', 0, 0, 0, 0, 0, 0, 0, '0.00', '0.00', ''),
(15, 0, 0, 0, 0, 'APPLE iOS / MacOS MDM PRO STATUS → IMEI/SN', '', 0, 0, '3.800', '0.000', ' Instant', 1, 1, '', 0, '', 0, 0, 0, '', '', '', '', '', '', '', 0, 1, 'fusion13', 0, '761', '', '', '', 0, '', 0, 0, 0, 0, 0, '', '', 0, '', '', '', 0, 0, 0, '', '', '', 0, 0, 0, '', '', '', '', '', '', '', '', 0, 0, 0, 0, '', '', 0, '', '', 0, 0, 0, 0, 0, '', '', '', 0, '0.000', 0, 0, '', '', '', 0, '', '', 0, 0, 0, '', 0, '', 1, '', '0.000', 0, 0, 0, 0, 0, '', '', '', '', 0, '', 0, '', '', '', '', 0, 0, 0, 0, 0, 0, '', '', '0.00', '', 0, 0, 0, 0, 0, 0, 0, '0.00', '0.00', ''),
(14, 0, 0, 0, 0, ' iPHONE SOLD-BY &amp; COVERAGE **HOT** → IMEI/SN', '', 0, 0, '2.000', '0.000', ' Instant', 1, 1, '', 0, '', 0, 0, 0, '', '', '', '', '', '', '', 0, 1, 'fusion13', 0, '2597', '', '', '', 0, '', 0, 0, 0, 0, 0, '', '', 0, '', '', '', 0, 0, 0, '', '', '', 0, 0, 0, '', '', '', '', '', '', '', '', 0, 0, 0, 0, '', '', 0, '', '', 0, 0, 0, 0, 0, '', '', '', 0, '0.000', 0, 0, '', '', '', 0, '', '', 0, 0, 0, '', 0, '', 1, '', '0.000', 0, 0, 0, 0, 0, '', '', '', '', 0, '', 0, '', '', '', '', 0, 0, 0, 0, 0, 0, '', '', '0.00', '', 0, 0, 0, 0, 0, 0, 0, '0.00', '0.00', ''),
(13, 0, 0, 0, 0, 'MACBOOK / iMAC iCLOUD ON/OFF STATUS', '', 0, 0, '0.700', '0.000', ' Instant', 1, 1, '', 0, '', 0, 0, 0, '', '', '', '', '', '', '', 0, 1, 'fusion13', 0, '2399', '', '', '', 0, '', 0, 0, 0, 0, 0, '', '', 0, '', '', '', 0, 0, 0, '', '', '', 0, 0, 0, '', '', '', '', '', '', '', '', 0, 0, 0, 0, '', '', 0, '', '', 0, 0, 0, 0, 0, '', '', '', 0, '0.000', 0, 0, '', '', '', 0, '', '', 0, 0, 0, '', 0, '', 1, '', '0.000', 0, 0, 0, 0, 0, '', '', '', '', 0, '', 0, '', '', '', '', 0, 0, 0, 0, 0, 0, '', '', '0.00', '', 0, 0, 0, 0, 0, 0, 0, '0.00', '0.00', ''),
(12, 0, 0, 0, 0, 'APPLE IPHONE MDM STATUS → IMEI', '', 0, 0, '0.600', '0.000', ' Instant', 1, 1, '', 0, '', 0, 0, 0, '', '', '', '', '', '', '', 0, 1, 'fusion13', 0, '3083', '', '', '', 0, '', 0, 0, 0, 0, 0, '', '', 0, '', '', '', 0, 0, 0, '', '', '', 0, 0, 0, '', '', '', '', '', '', '', '', 0, 0, 0, 0, '', '', 0, '', '', 0, 0, 0, 0, 0, '', '', '', 0, '0.000', 0, 0, '', '', '', 0, '', '', 0, 0, 0, '', 0, '', 1, '', '0.000', 0, 0, 0, 0, 0, '', '', '', '', 0, '', 0, '', '', '', '', 0, 0, 0, 0, 0, 0, '', '', '0.00', '', 0, 0, 0, 0, 0, 0, 0, '0.00', '0.00', ''),
(11, 0, 0, 0, 0, 'APPLE GSX CASES ID INFO', '', 0, 0, '2.200', '0.000', ' Instant', 1, 1, '', 0, '', 0, 0, 0, '', '', '', '', '', '', '', 0, 1, 'fusion13', 0, '3191', '', '', '', 0, '', 0, 0, 0, 0, 0, '', '', 0, '', '', '', 0, 0, 0, '', '', '', 0, 0, 0, '', '', '', '', '', '', '', '', 0, 0, 0, 0, '', '', 0, '', '', 0, 0, 0, 0, 0, '', '', '', 0, '0.000', 0, 0, '', '', '', 0, '', '', 0, 0, 0, '', 0, '', 1, '', '0.000', 0, 0, 0, 0, 0, '', '', '', '', 0, '', 0, '', '', '', '', 0, 0, 0, 0, 0, 0, '', '', '0.00', '', 0, 0, 0, 0, 0, 0, 0, '0.00', '0.00', ''),
(20, 0, 0, 0, 0, 'IPHONE FULL GSX + REPLACEMENT + WIFI MAC + POLICY → IMEI/SERIAL - INSTANT', '', 0, 0, '2.500', '0.000', ' Instant', 1, 1, '', 0, '', 0, 0, 0, '', '', '', '', '', '', '', 0, 1, 'fusion13', 0, '2579', '', '', '', 0, '', 0, 0, 0, 0, 0, '', '', 0, '', '', '', 0, 0, 0, '', '', '', 0, 0, 0, '', '', '', '', '', '', '', '', 0, 0, 0, 0, '', '', 0, '', '', 0, 0, 0, 0, 0, '', '', '', 0, '0.000', 0, 0, '', '', '', 0, '', '', 0, 0, 0, '', 0, '', 1, '', '0.000', 0, 0, 0, 0, 0, '', '', '', '', 0, '', 0, '', '', '', '', 0, 0, 0, 0, 0, 0, '', '', '0.00', '', 0, 0, 0, 0, 0, 0, 0, '0.00', '0.00', ''),
(21, 0, 0, 0, 0, 'T-MOBILE USA GENERIC SIMLOCK &amp; UNLOCK ELIGIBILITY STATUS - PRO', '', 0, 0, '0.100', '0.000', ' Instant', 1, 1, '', 0, '', 0, 0, 0, '', '', '', '', '', '', '', 0, 1, 'fusion13', 0, '725', '', '', '', 0, '', 0, 0, 0, 0, 0, '', '', 0, '', '', '', 0, 0, 0, '', '', '', 0, 0, 0, '', '', '', '', '', '', '', '', 0, 0, 0, 0, '', '', 0, '', '', 0, 0, 0, 0, 0, '', '', '', 0, '0.000', 0, 0, '', '', '', 0, '', '', 0, 0, 0, '', 0, '', 1, '', '0.000', 0, 0, 0, 0, 0, '', '', '', '', 0, '', 0, '', '', '', '', 0, 0, 0, 0, 0, 0, '', '', '0.00', '', 0, 0, 0, 0, 0, 0, 0, '0.00', '0.00', ''),
(22, 0, 0, 0, 0, 'APPLE iPAD/iPHONE BASIC INFO → IMEI', '', 0, 0, '0.080', '0.000', ' Instant', 1, 1, '', 0, '', 0, 0, 0, '', '', '', '', '', '', '', 0, 1, 'fusion13', 0, '41', '', '', '', 0, '', 0, 0, 0, 0, 0, '', '', 0, '', '', '', 0, 0, 0, '', '', '', 0, 0, 0, '', '', '', '', '', '', '', '', 0, 0, 0, 0, '', '', 0, '', '', 0, 0, 0, 0, 0, '', '', '', 0, '0.000', 0, 0, '', '', '', 0, '', '', 0, 0, 0, '', 0, '', 1, '', '0.000', 0, 0, 0, 0, 0, '', '', '', '', 0, '', 0, '', '', '', '', 0, 0, 0, 0, 0, 0, '', '', '0.00', '', 0, 0, 0, 0, 0, 0, 0, '0.00', '0.00', ''),
(23, 0, 0, 0, 0, 'APPLE iPHONE CARRIER + FMI + COVERAGE → IMEI/SN⚡', '', 0, 0, '0.160', '0.000', ' Instant', 1, 1, '', 0, '', 0, 0, 0, '', '', '', '', '', '', '', 0, 1, 'fusion13', 0, '2606', '', '', '', 0, '', 0, 0, 0, 0, 0, '', '', 0, '', '', '', 0, 0, 0, '', '', '', 0, 0, 0, '', '', '', '', '', '', '', '', 0, 0, 0, 0, '', '', 0, '', '', 0, 0, 0, 0, 0, '', '', '', 0, '0.000', 0, 0, '', '', '', 0, '', '', 0, 0, 0, '', 0, '', 1, '', '0.000', 0, 0, 0, 0, 0, '', '', '', '', 0, '', 0, '', '', '', '', 0, 0, 0, 0, 0, 0, '', '', '0.00', '', 0, 0, 0, 0, 0, 0, 0, '0.00', '0.00', ''),
(24, 0, 0, 0, 0, 'WORLDWIDE GSMA CLEAN/BLACKLIST STATUS', '', 0, 0, '0.040', '0.000', ' Instant', 1, 1, '', 0, '', 0, 0, 0, '', '', '', '', '', '', '', 0, 1, 'fusion13', 0, '2426', '', '', '', 0, '', 0, 0, 0, 0, 0, '', '', 0, '', '', '', 0, 0, 0, '', '', '', 0, 0, 0, '', '', '', '', '', '', '', '', 0, 0, 0, 0, '', '', 0, '', '', 0, 0, 0, 0, 0, '', '', '', 0, '0.000', 0, 0, '', '', '', 0, '', '', 0, 0, 0, '', 0, '', 1, '', '0.000', 0, 0, 0, 0, 0, '', '', '', '', 0, '', 0, '', '', '', '', 0, 0, 0, 0, 0, 0, '', '', '0.00', '', 0, 0, 0, 0, 0, 0, 0, '0.00', '0.00', ''),
(25, 0, 0, 0, 0, 'APPLE iPAD/iPHONE BASIC INFO → SERIAL', '', 0, 0, '0.080', '0.000', ' Instant', 1, 1, '', 0, '', 0, 0, 0, '', '', '', '', '', '', '', 0, 1, 'fusion13', 0, '509', '', '', '', 0, '', 0, 0, 0, 0, 0, '', '', 0, '', '', '', 0, 0, 0, '', '', '', 0, 0, 0, '', '', '', '', '', '', '', '', 0, 0, 0, 0, '', '', 0, '', '', 0, 0, 0, 0, 0, '', '', '', 0, '0.000', 0, 0, '', '', '', 0, '', '', 0, 0, 0, '', 0, '', 1, '', '0.000', 0, 0, 0, 0, 0, '', '', '', '', 0, '', 0, '', '', '', '', 0, 0, 0, 0, 0, 0, '', '', '0.00', '', 0, 0, 0, 0, 0, 0, 0, '0.00', '0.00', ''),
(26, 0, 0, 0, 0, 'APPLE iPHONE CARRIER + SIM-LOCK → IMEI/SN⚡', '', 0, 0, '0.100', '0.000', ' Instant', 1, 1, '', 0, '', 0, 0, 0, '', '', '', '', '', '', '', 0, 1, 'fusion13', 0, '1769', '', '', '', 0, '', 0, 0, 0, 0, 0, '', '', 0, '', '', '', 0, 0, 0, '', '', '', 0, 0, 0, '', '', '', '', '', '', '', '', 0, 0, 0, 0, '', '', 0, '', '', 0, 0, 0, 0, 0, '', '', '', 0, '0.000', 0, 0, '', '', '', 0, '', '', 0, 0, 0, '', 0, '', 1, '', '0.000', 0, 0, 0, 0, 0, '', '', '', '', 0, '', 0, '', '', '', '', 0, 0, 0, 0, 0, 0, '', '', '0.00', '', 0, 0, 0, 0, 0, 0, 0, '0.00', '0.00', ''),
(27, 0, 0, 0, 0, 'APPLE iPHONE SIM-LOCK STATUS → IMEI/SN', '', 0, 0, '0.080', '0.000', ' Instant', 1, 1, '', 0, '', 0, 0, 0, '', '', '', '', '', '', '', 0, 1, 'fusion13', 0, '2570', '', '', '', 0, '', 0, 0, 0, 0, 0, '', '', 0, '', '', '', 0, 0, 0, '', '', '', 0, 0, 0, '', '', '', '', '', '', '', '', 0, 0, 0, 0, '', '', 0, '', '', 0, 0, 0, 0, 0, '', '', '', 0, '0.000', 0, 0, '', '', '', 0, '', '', 0, 0, 0, '', 0, '', 1, '', '0.000', 0, 0, 0, 0, 0, '', '', '', '', 0, '', 0, '', '', '', '', 0, 0, 0, 0, 0, 0, '', '', '0.00', '', 0, 0, 0, 0, 0, 0, 0, '0.00', '0.00', ''),
(28, 0, 0, 0, 0, 'MACBOOK / iMAC iCLOUD ON/OFF & CLEAN/LOST STATUS', '', 0, 0, '1.100', '0.000', ' Instant', 1, 1, '', 0, '', 0, 0, 0, '', '', '', '', '', '', '', 0, 1, 'fusion13', 0, '86', '', '', '', 0, '', 0, 0, 0, 0, 0, '', '', 0, '', '', '', 0, 0, 0, '', '', '', 0, 0, 0, '', '', '', '', '', '', '', '', 0, 0, 0, 0, '', '', 0, '', '', 0, 0, 0, 0, 0, '', '', '', 0, '0.000', 0, 0, '', '', '', 0, '', '', 0, 0, 0, '', 0, '', 1, '', '0.000', 0, 0, 0, 0, 0, '', '', '', '', 0, '', 0, '', '', '', '', 0, 0, 0, 0, 0, 0, '', '', '0.00', '', 0, 0, 0, 0, 0, 0, 0, '0.00', '0.00', ''),
(29, 0, 0, 0, 0, 'APPLE GSX CASES & REPAIRS HISTORY → IMEI/SN', '', 0, 0, '2.000', '0.000', ' Instant', 1, 1, '', 0, '', 0, 0, 0, '', '', '', '', '', '', '', 0, 1, 'fusion13', 0, '1778', '', '', '', 0, '', 0, 0, 0, 0, 0, '', '', 0, '', '', '', 0, 0, 0, '', '', '', 0, 0, 0, '', '', '', '', '', '', '', '', 0, 0, 0, 0, '', '', 0, '', '', 0, 0, 0, 0, 0, '', '', '', 0, '0.000', 0, 0, '', '', '', 0, '', '', 0, 0, 0, '', 0, '', 1, '', '0.000', 0, 0, 0, 0, 0, '', '', '', '', 0, '', 0, '', '', '', '', 0, 0, 0, 0, 0, 0, '', '', '0.00', '', 0, 0, 0, 0, 0, 0, 0, '0.00', '0.00', ''),
(30, 0, 0, 0, 0, 'iCLOUD CLEAN/LOST STATUS → IMEI', '', 0, 0, '0.070', '0.000', ' Instant', 1, 1, '', 0, '', 0, 0, 0, '', '', '', '', '', '', '', 0, 1, 'fusion13', 0, '851', '', '', '', 0, '', 0, 0, 0, 0, 0, '', '', 0, '', '', '', 0, 0, 0, '', '', '', 0, 0, 0, '', '', '', '', '', '', '', '', 0, 0, 0, 0, '', '', 0, '', '', 0, 0, 0, 0, 0, '', '', '', 0, '0.000', 0, 0, '', '', '', 0, '', '', 0, 0, 0, '', 0, '', 1, '', '0.000', 0, 0, 0, 0, 0, '', '', '', '', 0, '', 0, '', '', '', '', 0, 0, 0, 0, 0, 0, '', '', '0.00', '', 0, 0, 0, 0, 0, 0, 0, '0.00', '0.00', ''),
(31, 0, 0, 0, 0, 'FIND MY iPHONE/iPAD ON/OFF → IMEI', '', 0, 0, '0.080', '0.000', ' Instant', 1, 1, '', 0, '', 0, 0, 0, '', '', '', '', '', '', '', 0, 1, 'fusion13', 0, '671', '', '', '', 0, '', 0, 0, 0, 0, 0, '', '', 0, '', '', '', 0, 0, 0, '', '', '', 0, 0, 0, '', '', '', '', '', '', '', '', 0, 0, 0, 0, '', '', 0, '', '', 0, 0, 0, 0, 0, '', '', '', 0, '0.000', 0, 0, '', '', '', 0, '', '', 0, 0, 0, '', 0, '', 1, '', '0.000', 0, 0, 0, 0, 0, '', '', '', '', 0, '', 0, '', '', '', '', 0, 0, 0, 0, 0, 0, '', '', '0.00', '', 0, 0, 0, 0, 0, 0, 0, '0.00', '0.00', ''),
(32, 0, 0, 0, 0, 'FIND MY iPHONE/iPAD ON/OFF → SERIAL', '', 0, 0, '0.050', '0.000', ' Instant', 1, 1, '', 0, '', 0, 0, 0, '', '', '', '', '', '', '', 0, 1, 'fusion13', 0, '599', '', '', '', 0, '', 0, 0, 0, 0, 0, '', '', 0, '', '', '', 0, 0, 0, '', '', '', 0, 0, 0, '', '', '', '', '', '', '', '', 0, 0, 0, 0, '', '', 0, '', '', 0, 0, 0, 0, 0, '', '', '', 0, '0.000', 0, 0, '', '', '', 0, '', '', 0, 0, 0, '', 0, '', 1, '', '0.000', 0, 0, 0, 0, 0, '', '', '', '', 0, '', 0, '', '', '', '', 0, 0, 0, 0, 0, 0, '', '', '0.00', '', 0, 0, 0, 0, 0, 0, 0, '0.00', '0.00', ''),
(33, 0, 0, 0, 0, 'WORLDWIDE GSMA CLEAN/BLACKLIST STATUS - PRO', '', 0, 0, '0.160', '0.000', ' Instant', 1, 1, '', 0, '', 0, 0, 0, '', '', '', '', '', '', '', 0, 1, 'fusion13', 0, '1661', '', '', '', 0, '', 0, 0, 0, 0, 0, '', '', 0, '', '', '', 0, 0, 0, '', '', '', 0, 0, 0, '', '', '', '', '', '', '', '', 0, 0, 0, 0, '', '', 0, '', '', 0, 0, 0, 0, 0, '', '', '', 0, '0.000', 0, 0, '', '', '', 0, '', '', 0, 0, 0, '', 0, '', 1, '', '0.000', 0, 0, 0, 0, 0, '', '', '', '', 0, '', 0, '', '', '', '', 0, 0, 0, 0, 0, 0, '', '', '0.00', '', 0, 0, 0, 0, 0, 0, 0, '0.00', '0.00', ''),
(34, 0, 0, 0, 0, 'VERIZON USA CLEAN/BLOCKED/UNPAID STATUS - SIMPLE', '', 0, 0, '0.050', '0.000', ' Instant', 1, 1, '', 0, '', 0, 0, 0, '', '', '', '', '', '', '', 0, 1, 'fusion13', 0, '1103', '', '', '', 0, '', 0, 0, 0, 0, 0, '', '', 0, '', '', '', 0, 0, 0, '', '', '', 0, 0, 0, '', '', '', '', '', '', '', '', 0, 0, 0, 0, '', '', 0, '', '', 0, 0, 0, 0, 0, '', '', '', 0, '0.000', 0, 0, '', '', '', 0, '', '', 0, 0, 0, '', 0, '', 1, '', '0.000', 0, 0, 0, 0, 0, '', '', '', '', 0, '', 0, '', '', '', '', 0, 0, 0, 0, 0, 0, '', '', '0.00', '', 0, 0, 0, 0, 0, 0, 0, '0.00', '0.00', ''),
(35, 0, 0, 0, 0, 'LG IMEI CHECK INFO', '', 0, 0, '0.060', '0.000', ' Instant', 1, 1, '', 0, '', 0, 0, 0, '', '', '', '', '', '', '', 0, 1, 'fusion13', 0, '2786', '', '', '', 0, '', 0, 0, 0, 0, 0, '', '', 0, '', '', '', 0, 0, 0, '', '', '', 0, 0, 0, '', '', '', '', '', '', '', '', 0, 0, 0, 0, '', '', 0, '', '', 0, 0, 0, 0, 0, '', '', '', 0, '0.000', 0, 0, '', '', '', 0, '', '', 0, 0, 0, '', 0, '', 1, '', '0.000', 0, 0, 0, 0, 0, '', '', '', '', 0, '', 0, '', '', '', '', 0, 0, 0, 0, 0, 0, '', '', '0.00', '', 0, 0, 0, 0, 0, 0, 0, '0.00', '0.00', ''),
(36, 0, 0, 0, 0, 'ZTE IMEI CHECK INFO', '', 0, 0, '0.050', '0.000', ' Instant', 1, 1, '', 0, '', 0, 0, 0, '', '', '', '', '', '', '', 0, 1, 'fusion13', 0, '2372', '', '', '', 0, '', 0, 0, 0, 0, 0, '', '', 0, '', '', '', 0, 0, 0, '', '', '', 0, 0, 0, '', '', '', '', '', '', '', '', 0, 0, 0, 0, '', '', 0, '', '', 0, 0, 0, 0, 0, '', '', '', 0, '0.000', 0, 0, '', '', '', 0, '', '', 0, 0, 0, '', 0, '', 1, '', '0.000', 0, 0, 0, 0, 0, '', '', '', '', 0, '', 0, '', '', '', '', 0, 0, 0, 0, 0, 0, '', '', '0.00', '', 0, 0, 0, 0, 0, 0, 0, '0.00', '0.00', ''),
(37, 0, 0, 0, 0, 'OPPO IMEI CHECK INFO', '', 0, 0, '0.040', '0.000', ' Instant', 1, 1, '', 0, '', 0, 0, 0, '', '', '', '', '', '', '', 0, 1, 'fusion13', 0, '3029', '', '', '', 0, '', 0, 0, 0, 0, 0, '', '', 0, '', '', '', 0, 0, 0, '', '', '', 0, 0, 0, '', '', '', '', '', '', '', '', 0, 0, 0, 0, '', '', 0, '', '', 0, 0, 0, 0, 0, '', '', '', 0, '0.000', 0, 0, '', '', '', 0, '', '', 0, 0, 0, '', 0, '', 1, '', '0.000', 0, 0, 0, 0, 0, '', '', '', '', 0, '', 0, '', '', '', '', 0, 0, 0, 0, 0, 0, '', '', '0.00', '', 0, 0, 0, 0, 0, 0, 0, '0.00', '0.00', ''),
(38, 0, 0, 0, 0, 'ACER IMEI CHECK INFO', '', 0, 0, '0.060', '0.000', ' Instant', 1, 1, '', 0, '', 0, 0, 0, '', '', '', '', '', '', '', 0, 1, 'fusion13', 0, '3011', '', '', '', 0, '', 0, 0, 0, 0, 0, '', '', 0, '', '', '', 0, 0, 0, '', '', '', 0, 0, 0, '', '', '', '', '', '', '', '', 0, 0, 0, 0, '', '', 0, '', '', 0, 0, 0, 0, 0, '', '', '', 0, '0.000', 0, 0, '', '', '', 0, '', '', 0, 0, 0, '', 0, '', 1, '', '0.000', 0, 0, 0, 0, 0, '', '', '', '', 0, '', 0, '', '', '', '', 0, 0, 0, 0, 0, 0, '', '', '0.00', '', 0, 0, 0, 0, 0, 0, 0, '0.00', '0.00', ''),
(39, 0, 0, 0, 0, 'NOKIA IMEI CHECK INFO', '', 0, 0, '0.080', '0.000', ' Instant', 1, 1, '', 0, '', 0, 0, 0, '', '', '', '', '', '', '', 0, 1, 'fusion13', 0, '1229', '', '', '', 0, '', 0, 0, 0, 0, 0, '', '', 0, '', '', '', 0, 0, 0, '', '', '', 0, 0, 0, '', '', '', '', '', '', '', '', 0, 0, 0, 0, '', '', 0, '', '', 0, 0, 0, 0, 0, '', '', '', 0, '0.000', 0, 0, '', '', '', 0, '', '', 0, 0, 0, '', 0, '', 1, '', '0.000', 0, 0, 0, 0, 0, '', '', '', '', 0, '', 0, '', '', '', '', 0, 0, 0, 0, 0, 0, '', '', '0.00', '', 0, 0, 0, 0, 0, 0, 0, '0.00', '0.00', ''),
(40, 0, 0, 0, 0, 'HUAWEI IMEI/SN CHECK INFO', '', 0, 0, '0.120', '0.000', ' Instant', 1, 1, '', 0, '', 0, 0, 0, '', '', '', '', '', '', '', 0, 1, 'fusion13', 0, '2318', '', '', '', 0, '', 0, 0, 0, 0, 0, '', '', 0, '', '', '', 0, 0, 0, '', '', '', 0, 0, 0, '', '', '', '', '', '', '', '', 0, 0, 0, 0, '', '', 0, '', '', 0, 0, 0, 0, 0, '', '', '', 0, '0.000', 0, 0, '', '', '', 0, '', '', 0, 0, 0, '', 0, '', 1, '', '0.000', 0, 0, 0, 0, 0, '', '', '', '', 0, '', 0, '', '', '', '', 0, 0, 0, 0, 0, 0, '', '', '0.00', '', 0, 0, 0, 0, 0, 0, 0, '0.00', '0.00', ''),
(41, 0, 0, 0, 0, 'KYOCERA IMEI CHECK INFO', '', 0, 0, '0.050', '0.000', ' Instant', 1, 1, '', 0, '', 0, 0, 0, '', '', '', '', '', '', '', 0, 1, 'fusion13', 0, '3047', '', '', '', 0, '', 0, 0, 0, 0, 0, '', '', 0, '', '', '', 0, 0, 0, '', '', '', 0, 0, 0, '', '', '', '', '', '', '', '', 0, 0, 0, 0, '', '', 0, '', '', 0, 0, 0, 0, 0, '', '', '', 0, '0.000', 0, 0, '', '', '', 0, '', '', 0, 0, 0, '', 0, '', 1, '', '0.000', 0, 0, 0, 0, 0, '', '', '', '', 0, '', 0, '', '', '', '', 0, 0, 0, 0, 0, 0, '', '', '0.00', '', 0, 0, 0, 0, 0, 0, 0, '0.00', '0.00', ''),
(42, 0, 0, 0, 0, 'ONEPLUS IMEI CHECK INFO', '', 0, 0, '0.040', '0.000', ' Instant', 1, 1, '', 0, '', 0, 0, 0, '', '', '', '', '', '', '', 0, 1, 'fusion13', 0, '2993', '', '', '', 0, '', 0, 0, 0, 0, 0, '', '', 0, '', '', '', 0, 0, 0, '', '', '', 0, 0, 0, '', '', '', '', '', '', '', '', 0, 0, 0, 0, '', '', 0, '', '', 0, 0, 0, 0, 0, '', '', '', 0, '0.000', 0, 0, '', '', '', 0, '', '', 0, 0, 0, '', 0, '', 1, '', '0.000', 0, 0, 0, 0, 0, '', '', '', '', 0, '', 0, '', '', '', '', 0, 0, 0, 0, 0, 0, '', '', '0.00', '', 0, 0, 0, 0, 0, 0, 0, '0.00', '0.00', ''),
(43, 0, 0, 0, 0, 'SAMSUNG CHECK INFO - IMEI/SN', '', 0, 0, '0.100', '0.000', ' Instant', 1, 1, '', 0, '', 0, 0, 0, '', '', '', '', '', '', '', 0, 1, 'fusion13', 0, '1580', '', '', '', 0, '', 0, 0, 0, 0, 0, '', '', 0, '', '', '', 0, 0, 0, '', '', '', 0, 0, 0, '', '', '', '', '', '', '', '', 0, 0, 0, 0, '', '', 0, '', '', 0, 0, 0, 0, 0, '', '', '', 0, '0.000', 0, 0, '', '', '', 0, '', '', 0, 0, 0, '', 0, '', 1, '', '0.000', 0, 0, 0, 0, 0, '', '', '', '', 0, '', 0, '', '', '', '', 0, 0, 0, 0, 0, 0, '', '', '0.00', '', 0, 0, 0, 0, 0, 0, 0, '0.00', '0.00', ''),
(44, 0, 0, 0, 0, 'MOTOROLA &amp; LENOVO IMEI CHECK INFO', '', 0, 0, '0.100', '0.000', ' Instant', 1, 1, '', 0, '', 0, 0, 0, '', '', '', '', '', '', '', 0, 1, 'fusion13', 0, '1688', '', '', '', 0, '', 0, 0, 0, 0, 0, '', '', 0, '', '', '', 0, 0, 0, '', '', '', 0, 0, 0, '', '', '', '', '', '', '', '', 0, 0, 0, 0, '', '', 0, '', '', 0, 0, 0, 0, 0, '', '', '', 0, '0.000', 0, 0, '', '', '', 0, '', '', 0, 0, 0, '', 0, '', 1, '', '0.000', 0, 0, 0, 0, 0, '', '', '', '', 0, '', 0, '', '', '', '', 0, 0, 0, 0, 0, 0, '', '', '0.00', '', 0, 0, 0, 0, 0, 0, 0, '0.00', '0.00', ''),
(45, 0, 0, 0, 0, 'HONOR IMEI/SN CHECK INFO', '', 0, 0, '0.120', '0.000', ' Instant', 1, 1, '', 0, '', 0, 0, 0, '', '', '', '', '', '', '', 0, 1, 'fusion13', 0, '167', '', '', '', 0, '', 0, 0, 0, 0, 0, '', '', 0, '', '', '', 0, 0, 0, '', '', '', 0, 0, 0, '', '', '', '', '', '', '', '', 0, 0, 0, 0, '', '', 0, '', '', 0, 0, 0, 0, 0, '', '', '', 0, '0.000', 0, 0, '', '', '', 0, '', '', 0, 0, 0, '', 0, '', 1, '', '0.000', 0, 0, 0, 0, 0, '', '', '', '', 0, '', 0, '', '', '', '', 0, 0, 0, 0, 0, 0, '', '', '0.00', '', 0, 0, 0, 0, 0, 0, 0, '0.00', '0.00', ''),
(46, 0, 0, 0, 0, 'GOOGLE PIXEL IMEI CHECK INFO', '', 0, 0, '0.100', '0.000', ' Instant', 1, 1, '', 0, '', 0, 0, 0, '', '', '', '', '', '', '', 0, 1, 'fusion13', 0, '95', '', '', '', 0, '', 0, 0, 0, 0, 0, '', '', 0, '', '', '', 0, 0, 0, '', '', '', 0, 0, 0, '', '', '', '', '', '', '', '', 0, 0, 0, 0, '', '', 0, '', '', 0, 0, 0, 0, 0, '', '', '', 0, '0.000', 0, 0, '', '', '', 0, '', '', 0, 0, 0, '', 0, '', 1, '', '0.000', 0, 0, 0, 0, 0, '', '', '', '', 0, '', 0, '', '', '', '', 0, 0, 0, 0, 0, 0, '', '', '0.00', '', 0, 0, 0, 0, 0, 0, 0, '0.00', '0.00', ''),
(47, 0, 0, 0, 0, 'APPLE SERIAL INFO', '', 0, 0, '0.020', '0.000', ' Instant', 1, 1, '', 0, '', 0, 0, 0, '', '', '', '', '', '', '', 0, 1, 'fusion13', 0, '2390', '', '', '', 0, '', 0, 0, 0, 0, 0, '', '', 0, '', '', '', 0, 0, 0, '', '', '', 0, 0, 0, '', '', '', '', '', '', '', '', 0, 0, 0, 0, '', '', 0, '', '', 0, 0, 0, 0, 0, '', '', '', 0, '0.000', 0, 0, '', '', '', 0, '', '', 0, 0, 0, '', 0, '', 1, '', '0.000', 0, 0, 0, 0, 0, '', '', '', '', 0, '', 0, '', '', '', '', 0, 0, 0, 0, 0, 0, '', '', '0.00', '', 0, 0, 0, 0, 0, 0, 0, '0.00', '0.00', ''),
(48, 0, 0, 0, 0, 'ADMIN PRIVATE SERVICE', '', 0, 0, '999.000', '0.000', ' Instant', 1, 2, '', 0, '', 0, 0, 0, '', '', '', '', '', '', '', 0, 1, 'fusion13', 0, '3056', '', '', '', 0, '', 0, 0, 0, 0, 0, '', '', 0, '', '', '', 0, 0, 0, '', '', '', 0, 0, 0, '', '', '', '', '', '', '', '', 0, 0, 0, 0, '', '', 0, '', '', 0, 0, 0, 0, 0, '', '', '', 0, '0.000', 0, 0, '', '', '', 0, '', '', 0, 0, 0, '', 0, '', 1, '', '0.000', 0, 0, 0, 0, 0, '', '', '', '', 0, '', 0, '', '', '', '', 0, 0, 0, 0, 0, 0, '', '', '0.00', '', 0, 0, 0, 0, 0, 0, 0, '0.00', '0.00', ''),
(49, 0, 0, 0, 0, 'GSMA.DB BLACKLISTING SERVICE - REPORT DEVICE STOLEN BY T-MOBILE USA', '', 0, 0, '2.000', '0.000', ' Instant', 1, 2, '', 0, '', 0, 0, 0, '', '', '', '', '', '', '', 0, 1, 'fusion13', 0, '2795', '', '', '', 0, '', 0, 0, 0, 0, 0, '', '', 0, '', '', '', 0, 0, 0, '', '', '', 0, 0, 0, '', '', '', '', '', '', '', '', 0, 0, 0, 0, '', '', 0, '', '', 0, 0, 0, 0, 0, '', '', '', 0, '0.000', 0, 0, '', '', '', 0, '', '', 0, 0, 0, '', 0, '', 1, '', '0.000', 0, 0, 0, 0, 0, '', '', '', '', 0, '', 0, '', '', '', '', 0, 0, 0, 0, 0, 0, '', '', '0.00', '', 0, 0, 0, 0, 0, 0, 0, '0.00', '0.00', ''),
(50, 0, 0, 0, 0, 'MDM IOS BYPASS iACTIVATE TOOL → IMEI/SERIAL', '', 0, 0, '15.000', '0.000', ' Instant', 1, 2, '', 0, '', 0, 0, 0, '', '', '', '', '', '', '', 0, 1, 'fusion13', 0, '1238', '', '', '', 0, '', 0, 0, 0, 0, 0, '', '', 0, '', '', '', 0, 0, 0, '', '', '', 0, 0, 0, '', '', '', '', '', '', '', '', 0, 0, 0, 0, '', '', 0, '', '', 0, 0, 0, 0, 0, '', '', '', 0, '0.000', 0, 0, '', '', '', 0, '', '', 0, 0, 0, '', 0, '', 1, '', '0.000', 0, 0, 0, 0, 0, '', '', '', '', 0, '', 0, '', '', '', '', 0, 0, 0, 0, 0, 0, '', '', '0.00', '', 0, 0, 0, 0, 0, 0, 0, '0.00', '0.00', ''),
(51, 0, 0, 0, 0, 'XIAOMI MI ACCOUNT REMOVAL SERVICE - EUROPE (CLEAN)', '', 0, 0, '17.000', '0.000', '1-48 Hours', 1, 2, '', 0, '', 0, 0, 0, '', '', '', '', '', '', '', 0, 1, 'fusion13', 0, '311', '', '', '', 0, '', 0, 0, 0, 0, 0, '', '', 0, '', '', '', 0, 0, 0, '', '', '', 0, 0, 0, '', '', '', '', '', '', '', '', 0, 0, 0, 0, '', '', 0, '', '', 0, 0, 0, 0, 0, '', '', '', 0, '0.000', 0, 0, '', '', '', 0, '', '', 0, 0, 0, '', 0, '', 1, '', '0.000', 0, 0, 0, 0, 0, '', '', '', '', 0, '', 0, '', '', '', '', 0, 0, 0, 0, 0, 0, '', '', '0.00', '', 0, 0, 0, 0, 0, 0, 0, '0.00', '0.00', ''),
(52, 0, 0, 0, 0, 'CLARO ALL COUNTRIES iPHONE 14/14+/14 PRO/14 PRO MAX MAX UNLOCK - PREMIUM', '', 0, 0, '70.000', '0.000', '1-8 days', 1, 3, '', 0, '', 0, 0, 0, '', '', '', '', '', '', '', 0, 1, 'fusion13', 0, '3200', '', '', '', 0, '', 0, 0, 0, 0, 0, '', '', 0, '', '', '', 0, 0, 0, '', '', '', 0, 0, 0, '', '', '', '', '', '', '', '', 0, 0, 0, 0, '', '', 0, '', '', 0, 0, 0, 0, 0, '', '', '', 0, '0.000', 0, 0, '', '', '', 0, '', '', 0, 0, 0, '', 0, '', 1, '', '0.000', 0, 0, 0, 0, 0, '', '', '', '', 0, '', 0, '', '', '', '', 0, 0, 0, 0, 0, 0, '', '', '0.00', '', 0, 0, 0, 0, 0, 0, 0, '0.00', '0.00', ''),
(53, 0, 0, 0, 0, 'CRICKET USA ALL iPHONE & ANDROID MODELS UNLOCK - CLEAN & 180 DAYS ACTIVE', '', 0, 0, '10.000', '0.000', '1-7 days', 1, 3, '', 0, '', 0, 0, 0, '', '', '', '', '', '', '', 0, 1, 'fusion13', 0, '3173', '', '', '', 0, '', 0, 0, 0, 0, 0, '', '', 0, '', '', '', 0, 0, 0, '', '', '', 0, 0, 0, '', '', '', '', '', '', '', '', 0, 0, 0, 0, '', '', 0, '', '', 0, 0, 0, 0, 0, '', '', '', 0, '0.000', 0, 0, '', '', '', 0, '', '', 0, 0, 0, '', 0, '', 1, '', '0.000', 0, 0, 0, 0, 0, '', '', '', '', 0, '', 0, '', '', '', '', 0, 0, 0, 0, 0, 0, '', '', '0.00', '', 0, 0, 0, 0, 0, 0, 0, '0.00', '0.00', ''),
(54, 0, 0, 0, 0, 'SOFTBANK JAPAN ALL IPHONE MODELS UNLOCK - CLEAN', '', 0, 0, '2.000', '0.000', '0-3 days', 1, 3, '', 0, '', 0, 0, 0, '', '', '', '', '', '', '', 0, 1, 'fusion13', 0, '3164', '', '', '', 0, '', 0, 0, 0, 0, 0, '', '', 0, '', '', '', 0, 0, 0, '', '', '', 0, 0, 0, '', '', '', '', '', '', '', '', 0, 0, 0, 0, '', '', 0, '', '', 0, 0, 0, 0, 0, '', '', '', 0, '0.000', 0, 0, '', '', '', 0, '', '', 0, 0, 0, '', 0, '', 1, '', '0.000', 0, 0, 0, 0, 0, '', '', '', '', 0, '', 0, '', '', '', '', 0, 0, 0, 0, 0, 0, '', '', '0.00', '', 0, 0, 0, 0, 0, 0, 0, '0.00', '0.00', ''),
(55, 0, 0, 0, 0, 'US GSM & US CARRIER & US RESELLER iPHONE UNLOCK - CLEAN', '', 0, 0, '24.000', '0.000', '1-7 days', 1, 3, '', 0, '', 0, 0, 0, '', '', '', '', '', '', '', 0, 1, 'fusion13', 0, '1742', '', '', '', 0, '', 0, 0, 0, 0, 0, '', '', 0, '', '', '', 0, 0, 0, '', '', '', 0, 0, 0, '', '', '', '', '', '', '', '', 0, 0, 0, 0, '', '', 0, '', '', 0, 0, 0, 0, 0, '', '', '', 0, '0.000', 0, 0, '', '', '', 0, '', '', 0, 0, 0, '', 0, '', 1, '', '0.000', 0, 0, 0, 0, 0, '', '', '', '', 0, '', 0, '', '', '', '', 0, 0, 0, 0, 0, 0, '', '', '0.00', '', 0, 0, 0, 0, 0, 0, 0, '0.00', '0.00', ''),
(56, 0, 0, 0, 0, 'VERIZON USA ALL IPHONE MODELS UNLOCK - PREMIUM', '', 0, 0, '15.000', '0.000', '1-5 days', 1, 3, '', 0, '', 0, 0, 0, '', '', '', '', '', '', '', 0, 1, 'fusion13', 0, '1823', '', '', '', 0, '', 0, 0, 0, 0, 0, '', '', 0, '', '', '', 0, 0, 0, '', '', '', 0, 0, 0, '', '', '', '', '', '', '', '', 0, 0, 0, 0, '', '', 0, '', '', 0, 0, 0, 0, 0, '', '', '', 0, '0.000', 0, 0, '', '', '', 0, '', '', 0, 0, 0, '', 0, '', 1, '', '0.000', 0, 0, 0, 0, 0, '', '', '', '', 0, '', 0, '', '', '', '', 0, 0, 0, 0, 0, 0, '', '', '0.00', '', 0, 0, 0, 0, 0, 0, 0, '0.00', '0.00', ''),
(57, 0, 0, 0, 0, 'EMEA SERVICE iPHONE UNLOCK - PREMIUM EXPRESS', '', 0, 0, '1.500', '0.000', '1-48 Hours', 1, 3, '', 0, '', 0, 0, 0, '', '', '', '', '', '', '', 0, 1, 'fusion13', 0, '635', '', '', '', 0, '', 0, 0, 0, 0, 0, '', '', 0, '', '', '', 0, 0, 0, '', '', '', 0, 0, 0, '', '', '', '', '', '', '', '', 0, 0, 0, 0, '', '', 0, '', '', 0, 0, 0, 0, 0, '', '', '', 0, '0.000', 0, 0, '', '', '', 0, '', '', 0, 0, 0, '', 0, '', 1, '', '0.000', 0, 0, 0, 0, 0, '', '', '', '', 0, '', 0, '', '', '', '', 0, 0, 0, 0, 0, 0, '', '', '0.00', '', 0, 0, 0, 0, 0, 0, 0, '0.00', '0.00', ''),
(58, 0, 0, 0, 0, 'ORANGE/T-MOBILE/EE UNITED KINGDOM ALL iPHONE MODELS UNLOCK - SEMI PREMIUM', '', 0, 0, '3.000', '0.000', '1-12 Hours', 1, 3, '', 0, '', 0, 0, 0, '', '', '', '', '', '', '', 0, 1, 'fusion13', 0, '1715', '', '', '', 0, '', 0, 0, 0, 0, 0, '', '', 0, '', '', '', 0, 0, 0, '', '', '', 0, 0, 0, '', '', '', '', '', '', '', '', 0, 0, 0, 0, '', '', 0, '', '', 0, 0, 0, 0, 0, '', '', '', 0, '0.000', 0, 0, '', '', '', 0, '', '', 0, 0, 0, '', 0, '', 1, '', '0.000', 0, 0, 0, 0, 0, '', '', '', '', 0, '', 0, '', '', '', '', 0, 0, 0, 0, 0, 0, '', '', '0.00', '', 0, 0, 0, 0, 0, 0, 0, '0.00', '0.00', ''),
(59, 0, 0, 0, 0, 'GLOBE PHILIPPINES UNLOCK iPHONE XR/XS/XS MAX/11/11P/11PM/12/12P/12PM/13/13P/13PM/14/14+/14P/14PM', '', 0, 0, '28.000', '0.000', '3-15 days', 1, 3, '', 0, '', 0, 0, 0, '', '', '', '', '', '', '', 0, 1, 'fusion13', 0, '986', '', '', '', 0, '', 0, 0, 0, 0, 0, '', '', 0, '', '', '', 0, 0, 0, '', '', '', 0, 0, 0, '', '', '', '', '', '', '', '', 0, 0, 0, 0, '', '', 0, '', '', 0, 0, 0, 0, 0, '', '', '', 0, '0.000', 0, 0, '', '', '', 0, '', '', 0, 0, 0, '', 0, '', 1, '', '0.000', 0, 0, 0, 0, 0, '', '', '', '', 0, '', 0, '', '', '', '', 0, 0, 0, 0, 0, 0, '', '', '0.00', '', 0, 0, 0, 0, 0, 0, 0, '0.00', '0.00', ''),
(60, 0, 0, 0, 0, 'T-MOBILE AUSTRIA iPHONE ALL MODELS UNLOCK - PREMIUM', '', 0, 0, '39.000', '0.000', '1-5 Days', 1, 3, '', 0, '', 0, 0, 0, '', '', '', '', '', '', '', 0, 1, 'fusion13', 0, '1220', '', '', '', 0, '', 0, 0, 0, 0, 0, '', '', 0, '', '', '', 0, 0, 0, '', '', '', 0, 0, 0, '', '', '', '', '', '', '', '', 0, 0, 0, 0, '', '', 0, '', '', 0, 0, 0, 0, 0, '', '', '', 0, '0.000', 0, 0, '', '', '', 0, '', '', 0, 0, 0, '', 0, '', 1, '', '0.000', 0, 0, 0, 0, 0, '', '', '', '', 0, '', 0, '', '', '', '', 0, 0, 0, 0, 0, 0, '', '', '0.00', '', 0, 0, 0, 0, 0, 0, 0, '0.00', '0.00', ''),
(61, 0, 0, 0, 0, 'O2 TESCO UK iPHONE ALL MODELS UNLOCK - CLEAN', '', 0, 0, '1.500', '0.000', '1-4 days', 1, 3, '', 0, '', 0, 0, 0, '', '', '', '', '', '', '', 0, 1, 'fusion13', 0, '2687', '', '', '', 0, '', 0, 0, 0, 0, 0, '', '', 0, '', '', '', 0, 0, 0, '', '', '', 0, 0, 0, '', '', '', '', '', '', '', '', 0, 0, 0, 0, '', '', 0, '', '', 0, 0, 0, 0, 0, '', '', '', 0, '0.000', 0, 0, '', '', '', 0, '', '', 0, 0, 0, '', 0, '', 1, '', '0.000', 0, 0, 0, 0, 0, '', '', '', '', 0, '', 0, '', '', '', '', 0, 0, 0, 0, 0, 0, '', '', '0.00', '', 0, 0, 0, 0, 0, 0, 0, '0.00', '0.00', ''),
(62, 0, 0, 0, 0, 'VODAFONE UK iPHONE &amp; IPAD ALL MODELS UNLOCK - CLEAN FAST', '', 0, 0, '11.000', '0.000', '1-9 days', 1, 3, '', 0, '', 0, 0, 0, '', '', '', '', '', '', '', 0, 1, 'fusion13', 0, '2156', '', '', '', 0, '', 0, 0, 0, 0, 0, '', '', 0, '', '', '', 0, 0, 0, '', '', '', 0, 0, 0, '', '', '', '', '', '', '', '', 0, 0, 0, 0, '', '', 0, '', '', 0, 0, 0, 0, 0, '', '', '', 0, '0.000', 0, 0, '', '', '', 0, '', '', 0, 0, 0, '', 0, '', 1, '', '0.000', 0, 0, 0, 0, 0, '', '', '', '', 0, '', 0, '', '', '', '', 0, 0, 0, 0, 0, 0, '', '', '0.00', '', 0, 0, 0, 0, 0, 0, 0, '0.00', '0.00', ''),
(63, 0, 0, 0, 0, 'TELERING AUSTRIA iPHONE ALL MODELS UNLOCK - PREMIUM', '', 0, 0, '39.000', '0.000', '1-5 Days', 1, 3, '', 0, '', 0, 0, 0, '', '', '', '', '', '', '', 0, 1, 'fusion13', 0, '1211', '', '', '', 0, '', 0, 0, 0, 0, 0, '', '', 0, '', '', '', 0, 0, 0, '', '', '', 0, 0, 0, '', '', '', '', '', '', '', '', 0, 0, 0, 0, '', '', 0, '', '', 0, 0, 0, 0, 0, '', '', '', 0, '0.000', 0, 0, '', '', '', 0, '', '', 0, 0, 0, '', 0, '', 1, '', '0.000', 0, 0, 0, 0, 0, '', '', '', '', 0, '', 0, '', '', '', '', 0, 0, 0, 0, 0, 0, '', '', '0.00', '', 0, 0, 0, 0, 0, 0, 0, '0.00', '0.00', ''),
(64, 0, 0, 0, 0, 'A1 MOBILKOM AUSTRIA ALL iPHONE MODELS UNLOCK - PREMIUM', '', 0, 0, '200.000', '0.000', '1-10 days', 1, 3, '', 0, '', 0, 0, 0, '', '', '', '', '', '', '', 0, 1, 'fusion13', 0, '2480', '', '', '', 0, '', 0, 0, 0, 0, 0, '', '', 0, '', '', '', 0, 0, 0, '', '', '', 0, 0, 0, '', '', '', '', '', '', '', '', 0, 0, 0, 0, '', '', 0, '', '', 0, 0, 0, 0, 0, '', '', '', 0, '0.000', 0, 0, '', '', '', 0, '', '', 0, 0, 0, '', 0, '', 1, '', '0.000', 0, 0, 0, 0, 0, '', '', '', '', 0, '', 0, '', '', '', '', 0, 0, 0, 0, 0, 0, '', '', '0.00', '', 0, 0, 0, 0, 0, 0, 0, '0.00', '0.00', ''),
(65, 0, 0, 0, 0, 'A1 MOBILKOM AUSTRIA iPHONE 5 &lt;&gt; 11 UNLOCK - OUT OF CONTRACT', '', 0, 0, '105.000', '0.000', '1-10 days', 1, 3, '', 0, '', 0, 0, 0, '', '', '', '', '', '', '', 0, 1, 'fusion13', 0, '2489', '', '', '', 0, '', 0, 0, 0, 0, 0, '', '', 0, '', '', '', 0, 0, 0, '', '', '', 0, 0, 0, '', '', '', '', '', '', '', '', 0, 0, 0, 0, '', '', 0, '', '', 0, 0, 0, 0, 0, '', '', '', 0, '0.000', 0, 0, '', '', '', 0, '', '', 0, 0, 0, '', 0, '', 1, '', '0.000', 0, 0, 0, 0, 0, '', '', '', '', 0, '', 0, '', '', '', '', 0, 0, 0, 0, 0, 0, '', '', '0.00', '', 0, 0, 0, 0, 0, 0, 0, '0.00', '0.00', ''),
(66, 0, 0, 0, 0, 'SUNRISE SWITZERLAND iPHONE UNLOCK - NOT FOUND', '', 0, 0, '19.000', '0.000', '1-5 Days', 1, 3, '', 0, '', 0, 0, 0, '', '', '', '', '', '', '', 0, 1, 'fusion13', 0, '1040', '', '', '', 0, '', 0, 0, 0, 0, 0, '', '', 0, '', '', '', 0, 0, 0, '', '', '', 0, 0, 0, '', '', '', '', '', '', '', '', 0, 0, 0, 0, '', '', 0, '', '', 0, 0, 0, 0, 0, '', '', '', 0, '0.000', 0, 0, '', '', '', 0, '', '', 0, 0, 0, '', 0, '', 1, '', '0.000', 0, 0, 0, 0, 0, '', '', '', '', 0, '', 0, '', '', '', '', 0, 0, 0, 0, 0, 0, '', '', '0.00', '', 0, 0, 0, 0, 0, 0, 0, '0.00', '0.00', ''),
(67, 0, 0, 0, 0, 'CLARO ALL COUNTRIES iPHONE 12/12 MINI/12 PRO/12 PRO MAX/13/13 MINI/13 PRO/13 PRO MAX UNLOCK - PREMIUM', '', 0, 0, '47.000', '0.000', '1-7 days', 1, 3, '', 0, '', 0, 0, 0, '', '', '', '', '', '', '', 0, 1, 'fusion13', 0, '1922', '', '', '', 0, '', 0, 0, 0, 0, 0, '', '', 0, '', '', '', 0, 0, 0, '', '', '', 0, 0, 0, '', '', '', '', '', '', '', '', 0, 0, 0, 0, '', '', 0, '', '', 0, 0, 0, 0, 0, '', '', '', 0, '0.000', 0, 0, '', '', '', 0, '', '', 0, 0, 0, '', 0, '', 1, '', '0.000', 0, 0, 0, 0, 0, '', '', '', '', 0, '', 0, '', '', '', '', 0, 0, 0, 0, 0, 0, '', '', '0.00', '', 0, 0, 0, 0, 0, 0, 0, '0.00', '0.00', ''),
(68, 0, 0, 0, 0, 'MOVISTAR CHILE ALL iPHONE MODELS PREMIUM UNLOCK', '', 0, 0, '72.000', '0.000', '4-10 Days', 1, 3, '', 0, '', 0, 0, 0, '', '', '', '', '', '', '', 0, 1, 'fusion13', 0, '2534', '', '', '', 0, '', 0, 0, 0, 0, 0, '', '', 0, '', '', '', 0, 0, 0, '', '', '', 0, 0, 0, '', '', '', '', '', '', '', '', 0, 0, 0, 0, '', '', 0, '', '', 0, 0, 0, 0, 0, '', '', '', 0, '0.000', 0, 0, '', '', '', 0, '', '', 0, 0, 0, '', 0, '', 1, '', '0.000', 0, 0, 0, 0, 0, '', '', '', '', 0, '', 0, '', '', '', '', 0, 0, 0, 0, 0, 0, '', '', '0.00', '', 0, 0, 0, 0, 0, 0, 0, '0.00', '0.00', ''),
(69, 0, 0, 0, 0, 'CLARO ALL COUNTRIES iPHONE SE 2020/X/XR/XS/XS MAX/11/11 PRO/11 PRO MAX UNLOCK - PREMIUM', '', 0, 0, '29.000', '0.000', '1-7 days', 1, 3, '', 0, '', 0, 0, 0, '', '', '', '', '', '', '', 0, 1, 'fusion13', 0, '1832', '', '', '', 0, '', 0, 0, 0, 0, 0, '', '', 0, '', '', '', 0, 0, 0, '', '', '', 0, 0, 0, '', '', '', '', '', '', '', '', 0, 0, 0, 0, '', '', 0, '', '', 0, 0, 0, 0, 0, '', '', '', 0, '0.000', 0, 0, '', '', '', 0, '', '', 0, 0, 0, '', 0, '', 1, '', '0.000', 0, 0, 0, 0, 0, '', '', '', '', 0, '', 0, '', '', '', '', 0, 0, 0, 0, 0, 0, '', '', '0.00', '', 0, 0, 0, 0, 0, 0, 0, '0.00', '0.00', ''),
(70, 0, 0, 0, 0, 'CLARO ALL COUNTRIES iPHONE 3GS/4/4S/5/5S/5SE/5C/6/6+/6S/6S+/7/7+/8/8+ UNLOCK - PREMIUM', '', 0, 0, '18.000', '0.000', '1-7 days', 1, 3, '', 0, '', 0, 0, 0, '', '', '', '', '', '', '', 0, 1, 'fusion13', 0, '2516', '', '', '', 0, '', 0, 0, 0, 0, 0, '', '', 0, '', '', '', 0, 0, 0, '', '', '', 0, 0, 0, '', '', '', '', '', '', '', '', 0, 0, 0, 0, '', '', 0, '', '', 0, 0, 0, 0, 0, '', '', '', 0, '0.000', 0, 0, '', '', '', 0, '', '', 0, 0, 0, '', 0, '', 1, '', '0.000', 0, 0, 0, 0, 0, '', '', '', '', 0, '', 0, '', '', '', '', 0, 0, 0, 0, 0, 0, '', '', '0.00', '', 0, 0, 0, 0, 0, 0, 0, '0.00', '0.00', ''),
(71, 0, 0, 0, 0, 'AU KDDI JAPAN ALL IPHONE MODELS UNLOCK - CLEAN', '', 0, 0, '4.000', '0.000', '1-2 Days', 1, 3, '', 0, '', 0, 0, 0, '', '', '', '', '', '', '', 0, 1, 'fusion13', 0, '2102', '', '', '', 0, '', 0, 0, 0, 0, 0, '', '', 0, '', '', '', 0, 0, 0, '', '', '', 0, 0, 0, '', '', '', '', '', '', '', '', 0, 0, 0, 0, '', '', 0, '', '', 0, 0, 0, 0, 0, '', '', '', 0, '0.000', 0, 0, '', '', '', 0, '', '', 0, 0, 0, '', 0, '', 1, '', '0.000', 0, 0, 0, 0, 0, '', '', '', '', 0, '', 0, '', '', '', '', 0, 0, 0, 0, 0, 0, '', '', '0.00', '', 0, 0, 0, 0, 0, 0, 0, '0.00', '0.00', ''),
(72, 0, 0, 0, 0, 'NTT DOCOMO JAPAN ALL IPHONE MODELS UNLOCK - CLEAN', '', 0, 0, '1.200', '0.000', '0-3 days', 1, 3, '', 0, '', 0, 0, 0, '', '', '', '', '', '', '', 0, 1, 'fusion13', 0, '2732', '', '', '', 0, '', 0, 0, 0, 0, 0, '', '', 0, '', '', '', 0, 0, 0, '', '', '', 0, 0, 0, '', '', '', '', '', '', '', '', 0, 0, 0, 0, '', '', 0, '', '', 0, 0, 0, 0, 0, '', '', '', 0, '0.000', 0, 0, '', '', '', 0, '', '', 0, 0, 0, '', 0, '', 1, '', '0.000', 0, 0, 0, 0, 0, '', '', '', '', 0, '', 0, '', '', '', '', 0, 0, 0, 0, 0, 0, '', '', '0.00', '', 0, 0, 0, 0, 0, 0, 0, '0.00', '0.00', ''),
(73, 0, 0, 0, 0, 'SASKTEL CANADA ALL iPHONE UNLOCK - CLEAN', '', 0, 0, '12.000', '0.000', '1-3 days', 1, 3, '', 0, '', 0, 0, 0, '', '', '', '', '', '', '', 0, 1, 'fusion13', 0, '212', '', '', '', 0, '', 0, 0, 0, 0, 0, '', '', 0, '', '', '', 0, 0, 0, '', '', '', 0, 0, 0, '', '', '', '', '', '', '', '', 0, 0, 0, 0, '', '', 0, '', '', 0, 0, 0, 0, 0, '', '', '', 0, '0.000', 0, 0, '', '', '', 0, '', '', 0, 0, 0, '', 0, '', 1, '', '0.000', 0, 0, 0, 0, 0, '', '', '', '', 0, '', 0, '', '', '', '', 0, 0, 0, 0, 0, 0, '', '', '0.00', '', 0, 0, 0, 0, 0, 0, 0, '0.00', '0.00', ''),
(74, 0, 0, 0, 0, 'FIDO &amp; ROGERS CANADA ALL iPHONE UNLOCK - CLEAN', '', 0, 0, '13.000', '0.000', '1-9 days', 1, 3, '', 0, '', 0, 0, 0, '', '', '', '', '', '', '', 0, 1, 'fusion13', 0, '806', '', '', '', 0, '', 0, 0, 0, 0, 0, '', '', 0, '', '', '', 0, 0, 0, '', '', '', 0, 0, 0, '', '', '', '', '', '', '', '', 0, 0, 0, 0, '', '', 0, '', '', 0, 0, 0, 0, 0, '', '', '', 0, '0.000', 0, 0, '', '', '', 0, '', '', 0, 0, 0, '', 0, '', 1, '', '0.000', 0, 0, 0, 0, 0, '', '', '', '', 0, '', 0, '', '', '', '', 0, 0, 0, 0, 0, 0, '', '', '0.00', '', 0, 0, 0, 0, 0, 0, 0, '0.00', '0.00', ''),
(75, 0, 0, 0, 0, 'TELUS &amp; KOODO CANADA ALL iPHONE UNLOCK - CLEAN', '', 0, 0, '1.000', '0.000', '1-36 Hours', 1, 3, '', 0, '', 0, 0, 0, '', '', '', '', '', '', '', 0, 1, 'fusion13', 0, '815', '', '', '', 0, '', 0, 0, 0, 0, 0, '', '', 0, '', '', '', 0, 0, 0, '', '', '', 0, 0, 0, '', '', '', '', '', '', '', '', 0, 0, 0, 0, '', '', 0, '', '', 0, 0, 0, 0, 0, '', '', '', 0, '0.000', 0, 0, '', '', '', 0, '', '', 0, 0, 0, '', 0, '', 1, '', '0.000', 0, 0, 0, 0, 0, '', '', '', '', 0, '', 0, '', '', '', '', 0, 0, 0, 0, 0, 0, '', '', '0.00', '', 0, 0, 0, 0, 0, 0, 0, '0.00', '0.00', ''),
(76, 0, 0, 0, 0, 'VODAFONE ROMANIA iPHONE UNLOCK - PREMIUM', '', 0, 0, '17.000', '0.000', '1-5 Days', 1, 3, '', 0, '', 0, 0, 0, '', '', '', '', '', '', '', 0, 1, 'fusion13', 0, '770', '', '', '', 0, '', 0, 0, 0, 0, 0, '', '', 0, '', '', '', 0, 0, 0, '', '', '', 0, 0, 0, '', '', '', '', '', '', '', '', 0, 0, 0, 0, '', '', 0, '', '', 0, 0, 0, 0, 0, '', '', '', 0, '0.000', 0, 0, '', '', '', 0, '', '', 0, 0, 0, '', 0, '', 1, '', '0.000', 0, 0, 0, 0, 0, '', '', '', '', 0, '', 0, '', '', '', '', 0, 0, 0, 0, 0, 0, '', '', '0.00', '', 0, 0, 0, 0, 0, 0, 0, '0.00', '0.00', ''),
(77, 0, 0, 0, 0, 'ORANGE ROMANIA ALL iPHONE UNLOCK - PREMIUM', '', 0, 0, '50.000', '0.000', '1-24 Hours', 1, 3, '', 0, '', 0, 0, 0, '', '', '', '', '', '', '', 0, 1, 'fusion13', 0, '833', '', '', '', 0, '', 0, 0, 0, 0, 0, '', '', 0, '', '', '', 0, 0, 0, '', '', '', 0, 0, 0, '', '', '', '', '', '', '', '', 0, 0, 0, 0, '', '', 0, '', '', 0, 0, 0, 0, 0, '', '', '', 0, '0.000', 0, 0, '', '', '', 0, '', '', 0, 0, 0, '', 0, '', 1, '', '0.000', 0, 0, 0, 0, 0, '', '', '', '', 0, '', 0, '', '', '', '', 0, 0, 0, 0, 0, 0, '', '', '0.00', '', 0, 0, 0, 0, 0, 0, 0, '0.00', '0.00', ''),
(78, 0, 0, 0, 0, 'ORANGE ROMANIA iPHONE UNLOCK - OUT OF CONTRACT', '', 0, 0, '14.000', '0.000', '1-24 Hours', 1, 3, '', 0, '', 0, 0, 0, '', '', '', '', '', '', '', 0, 1, 'fusion13', 0, '824', '', '', '', 0, '', 0, 0, 0, 0, 0, '', '', 0, '', '', '', 0, 0, 0, '', '', '', 0, 0, 0, '', '', '', '', '', '', '', '', 0, 0, 0, 0, '', '', 0, '', '', 0, 0, 0, 0, 0, '', '', '', 0, '0.000', 0, 0, '', '', '', 0, '', '', 0, 0, 0, '', 0, '', 1, '', '0.000', 0, 0, 0, 0, 0, '', '', '', '', 0, '', 0, '', '', '', '', 0, 0, 0, 0, 0, 0, '', '', '0.00', '', 0, 0, 0, 0, 0, 0, 0, '0.00', '0.00', ''),
(79, 0, 0, 0, 0, '3 HUTCHISON SWEDEN ALL iPHONE UNLOCK - CLEAN', '', 0, 0, '23.000', '0.000', '1-12 Hours', 1, 3, '', 0, '', 0, 0, 0, '', '', '', '', '', '', '', 0, 1, 'fusion13', 0, '698', '', '', '', 0, '', 0, 0, 0, 0, 0, '', '', 0, '', '', '', 0, 0, 0, '', '', '', 0, 0, 0, '', '', '', '', '', '', '', '', 0, 0, 0, 0, '', '', 0, '', '', 0, 0, 0, 0, 0, '', '', '', 0, '0.000', 0, 0, '', '', '', 0, '', '', 0, 0, 0, '', 0, '', 1, '', '0.000', 0, 0, 0, 0, 0, '', '', '', '', 0, '', 0, '', '', '', '', 0, 0, 0, 0, 0, 0, '', '', '0.00', '', 0, 0, 0, 0, 0, 0, 0, '0.00', '0.00', ''),
(80, 0, 0, 0, 0, '3 HUTCHISON SWEDEN ALL IPHONE UNLOCK - PREMIUM', '', 0, 0, '60.000', '0.000', '1-8 Days', 1, 3, '', 0, '', 0, 0, 0, '', '', '', '', '', '', '', 0, 1, 'fusion13', 0, '752', '', '', '', 0, '', 0, 0, 0, 0, 0, '', '', 0, '', '', '', 0, 0, 0, '', '', '', 0, 0, 0, '', '', '', '', '', '', '', '', 0, 0, 0, 0, '', '', 0, '', '', 0, 0, 0, 0, 0, '', '', '', 0, '0.000', 0, 0, '', '', '', 0, '', '', 0, 0, 0, '', 0, '', 1, '', '0.000', 0, 0, 0, 0, 0, '', '', '', '', 0, '', 0, '', '', '', '', 0, 0, 0, 0, 0, 0, '', '', '0.00', '', 0, 0, 0, 0, 0, 0, 0, '0.00', '0.00', ''),
(81, 0, 0, 0, 0, 'ORANGE FRANCE iPHONE UNLOCK - CLEAN', '', 0, 0, '3.000', '0.000', '1-12 Hours', 1, 3, '', 0, '', 0, 0, 0, '', '', '', '', '', '', '', 0, 1, 'fusion13', 0, '680', '', '', '', 0, '', 0, 0, 0, 0, 0, '', '', 0, '', '', '', 0, 0, 0, '', '', '', 0, 0, 0, '', '', '', '', '', '', '', '', 0, 0, 0, 0, '', '', 0, '', '', 0, 0, 0, 0, 0, '', '', '', 0, '0.000', 0, 0, '', '', '', 0, '', '', 0, 0, 0, '', 0, '', 1, '', '0.000', 0, 0, 0, 0, 0, '', '', '', '', 0, '', 0, '', '', '', '', 0, 0, 0, 0, 0, 0, '', '', '0.00', '', 0, 0, 0, 0, 0, 0, 0, '0.00', '0.00', ''),
(82, 0, 0, 0, 0, 'HUAWEI WORLDWIDE FACTORY NCK CODE', '', 0, 0, '31.000', '0.000', '3-10 days', 1, 4, '', 0, '', 0, 0, 0, '', '', '', '', '', '', '', 0, 1, 'fusion13', 0, '3074', '', '', '', 0, '', 0, 0, 0, 0, 0, '', '', 0, '', '', '', 0, 0, 0, '', '', '', 0, 0, 0, '', '', '', '', '', '', '', '', 0, 0, 0, 0, '', '', 0, '', '', 0, 0, 0, 0, 0, '', '', '', 0, '0.000', 0, 0, '', '', '', 0, '', '', 0, 0, 0, '', 0, '', 1, '', '0.000', 0, 0, 0, 0, 0, '', '', '', '', 0, '', 0, '', '', '', '', 0, 0, 0, 0, 0, 0, '', '', '0.00', '', 0, 0, 0, 0, 0, 0, 0, '0.00', '0.00', ''),
(83, 0, 0, 0, 0, 'ZTE WORLDWIDE FACTORY NCK CODE', '', 0, 0, '17.000', '0.000', '3-8 days', 1, 4, '', 0, '', 0, 0, 0, '', '', '', '', '', '', '', 0, 1, 'fusion13', 0, '3182', '', '', '', 0, '', 0, 0, 0, 0, 0, '', '', 0, '', '', '', 0, 0, 0, '', '', '', 0, 0, 0, '', '', '', '', '', '', '', '', 0, 0, 0, 0, '', '', 0, '', '', 0, 0, 0, 0, 0, '', '', '', 0, '0.000', 0, 0, '', '', '', 0, '', '', 0, 0, 0, '', 0, '', 1, '', '0.000', 0, 0, 0, 0, 0, '', '', '', '', 0, '', 0, '', '', '', '', 0, 0, 0, 0, 0, 0, '', '', '0.00', '', 0, 0, 0, 0, 0, 0, 0, '0.00', '0.00', ''),
(84, 0, 0, 0, 0, 'SAMSUNG EUROPE LIMITED COUNTRY - DATABASE 1', '', 0, 0, '5.000', '0.000', '3-5 Minutes', 1, 4, '', 0, '', 0, 0, 0, '', '', '', '', '', '', '', 0, 1, 'fusion13', 0, '1868', '', '', '', 0, '', 0, 0, 0, 0, 0, '', '', 0, '', '', '', 0, 0, 0, '', '', '', 0, 0, 0, '', '', '', '', '', '', '', '', 0, 0, 0, 0, '', '', 0, '', '', 0, 0, 0, 0, 0, '', '', '', 0, '0.000', 0, 0, '', '', '', 0, '', '', 0, 0, 0, '', 0, '', 1, '', '0.000', 0, 0, 0, 0, 0, '', '', '', '', 0, '', 0, '', '', '', '', 0, 0, 0, 0, 0, 0, '', '', '0.00', '', 0, 0, 0, 0, 0, 0, 0, '0.00', '0.00', ''),
(85, 0, 0, 0, 0, 'SAMSUNG EUROPE LIMITED COUNTRY - DATABASE 2', '', 0, 0, '7.000', '0.000', '3-5 Minutes', 1, 4, '', 0, '', 0, 0, 0, '', '', '', '', '', '', '', 0, 1, 'fusion13', 0, '2345', '', '', '', 0, '', 0, 0, 0, 0, 0, '', '', 0, '', '', '', 0, 0, 0, '', '', '', 0, 0, 0, '', '', '', '', '', '', '', '', 0, 0, 0, 0, '', '', 0, '', '', 0, 0, 0, 0, 0, '', '', '', 0, '0.000', 0, 0, '', '', '', 0, '', '', 0, 0, 0, '', 0, '', 1, '', '0.000', 0, 0, 0, 0, 0, '', '', '', '', 0, '', 0, '', '', '', '', 0, 0, 0, 0, 0, 0, '', '', '0.00', '', 0, 0, 0, 0, 0, 0, 0, '0.00', '0.00', ''),
(86, 0, 0, 0, 0, 'SAMSUNG EUROPE LIMITED COUNTRY - DATABASE 3', '', 0, 0, '9.000', '0.000', '3-5 Minutes', 1, 4, '', 0, '', 0, 0, 0, '', '', '', '', '', '', '', 0, 1, 'fusion13', 0, '896', '', '', '', 0, '', 0, 0, 0, 0, 0, '', '', 0, '', '', '', 0, 0, 0, '', '', '', 0, 0, 0, '', '', '', '', '', '', '', '', 0, 0, 0, 0, '', '', 0, '', '', 0, 0, 0, 0, 0, '', '', '', 0, '0.000', 0, 0, '', '', '', 0, '', '', 0, 0, 0, '', 0, '', 1, '', '0.000', 0, 0, 0, 0, 0, '', '', '', '', 0, '', 0, '', '', '', '', 0, 0, 0, 0, 0, 0, '', '', '0.00', '', 0, 0, 0, 0, 0, 0, 0, '0.00', '0.00', ''),
(87, 0, 0, 0, 0, 'BELL/VIRGIN/SOLO CANADA GENERIC ALL BRANDS (NOKIA SONY ETC)', '', 0, 0, '4.000', '0.000', '1-3 Miniutes', 1, 4, '', 0, '', 0, 0, 0, '', '', '', '', '', '', '', 0, 1, 'fusion13', 0, '1940', '', '', '', 0, '', 0, 0, 0, 0, 0, '', '', 0, '', '', '', 0, 0, 0, '', '', '', 0, 0, 0, '', '', '', '', '', '', '', '', 0, 0, 0, 0, '', '', 0, '', '', 0, 0, 0, 0, 0, '', '', '', 0, '0.000', 0, 0, '', '', '', 0, '', '', 0, 0, 0, '', 0, '', 1, '', '0.000', 0, 0, 0, 0, 0, '', '', '', '', 0, '', 0, '', '', '', '', 0, 0, 0, 0, 0, 0, '', '', '0.00', '', 0, 0, 0, 0, 0, 0, 0, '0.00', '0.00', ''),
(88, 0, 0, 0, 0, 'SAMSUNG EUROPE LIMITED COUNTRY - NOT FOUND', '', 0, 0, '15.000', '0.000', '1-24 Hours', 1, 4, '', 0, '', 0, 0, 0, '', '', '', '', '', '', '', 0, 1, 'fusion13', 0, '2831', '', '', '', 0, '', 0, 0, 0, 0, 0, '', '', 0, '', '', '', 0, 0, 0, '', '', '', 0, 0, 0, '', '', '', '', '', '', '', '', 0, 0, 0, 0, '', '', 0, '', '', 0, 0, 0, 0, 0, '', '', '', 0, '0.000', 0, 0, '', '', '', 0, '', '', 0, 0, 0, '', 0, '', 1, '', '0.000', 0, 0, 0, 0, 0, '', '', '', '', 0, '', 0, '', '', '', '', 0, 0, 0, 0, 0, 0, '', '', '0.00', '', 0, 0, 0, 0, 0, 0, 0, '0.00', '0.00', ''),
(89, 0, 0, 0, 0, 'SAMSUNG EUROPE LIMITED COUNTRY - PREMIUM 2021', '', 0, 0, '14.000', '0.000', '3-15 Minutes', 1, 4, '', 0, '', 0, 0, 0, '', '', '', '', '', '', '', 0, 1, 'fusion13', 0, '1976', '', '', '', 0, '', 0, 0, 0, 0, 0, '', '', 0, '', '', '', 0, 0, 0, '', '', '', 0, 0, 0, '', '', '', '', '', '', '', '', 0, 0, 0, 0, '', '', 0, '', '', 0, 0, 0, 0, 0, '', '', '', 0, '0.000', 0, 0, '', '', '', 0, '', '', 0, 0, 0, '', 0, '', 1, '', '0.000', 0, 0, 0, 0, 0, '', '', '', '', 0, '', 0, '', '', '', '', 0, 0, 0, 0, 0, 0, '', '', '0.00', '', 0, 0, 0, 0, 0, 0, 0, '0.00', '0.00', ''),
(90, 0, 0, 0, 0, 'VODAFONE UK GENERIC ALL MODELS (EXCEPT iPHONE) - FAST', '', 0, 0, '2.700', '0.000', '1-4 Days', 1, 4, '', 0, '', 0, 0, 0, '', '', '', '', '', '', '', 0, 1, 'fusion13', 0, '1877', '', '', '', 0, '', 0, 0, 0, 0, 0, '', '', 0, '', '', '', 0, 0, 0, '', '', '', 0, 0, 0, '', '', '', '', '', '', '', '', 0, 0, 0, 0, '', '', 0, '', '', 0, 0, 0, 0, 0, '', '', '', 0, '0.000', 0, 0, '', '', '', 0, '', '', 0, 0, 0, '', 0, '', 1, '', '0.000', 0, 0, 0, 0, 0, '', '', '', '', 0, '', 0, '', '', '', '', 0, 0, 0, 0, 0, 0, '', '', '0.00', '', 0, 0, 0, 0, 0, 0, 0, '0.00', '0.00', ''),
(91, 0, 0, 0, 0, 'SAMSUNG EUROPE ALL MODELS &amp; CARRIER - NCK &amp; MCK', '', 0, 0, '20.000', '0.000', '1-3 days', 1, 4, '', 0, '', 0, 0, 0, '', '', '', '', '', '', '', 0, 1, 'fusion13', 0, '1724', '', '', '', 0, '', 0, 0, 0, 0, 0, '', '', 0, '', '', '', 0, 0, 0, '', '', '', 0, 0, 0, '', '', '', '', '', '', '', '', 0, 0, 0, 0, '', '', 0, '', '', 0, 0, 0, 0, 0, '', '', '', 0, '0.000', 0, 0, '', '', '', 0, '', '', 0, 0, 0, '', 0, '', 1, '', '0.000', 0, 0, 0, 0, 0, '', '', '', '', 0, '', 0, '', '', '', '', 0, 0, 0, 0, 0, 0, '', '', '0.00', '', 0, 0, 0, 0, 0, 0, 0, '0.00', '0.00', ''),
(92, 0, 0, 0, 0, 'SAMSUNG USA AT&amp;T / CRICKET / XFINITY / SPECTRUM (GALAXY S22 / S22 ULTRA / Z FLIP 3 / Z FOLD 3) ALL LEVEL UNLOCK CODES [PREMIUM]', '', 0, 0, '48.000', '0.000', '1-7 days', 1, 4, '', 0, '', 0, 0, 0, '', '', '', '', '', '', '', 0, 1, 'fusion13', 0, '2219', '', '', '', 0, '', 0, 0, 0, 0, 0, '', '', 0, '', '', '', 0, 0, 0, '', '', '', 0, 0, 0, '', '', '', '', '', '', '', '', 0, 0, 0, 0, '', '', 0, '', '', 0, 0, 0, 0, 0, '', '', '', 0, '0.000', 0, 0, '', '', '', 0, '', '', 0, 0, 0, '', 0, '', 1, '', '0.000', 0, 0, 0, 0, 0, '', '', '', '', 0, '', 0, '', '', '', '', 0, 0, 0, 0, 0, 0, '', '', '0.00', '', 0, 0, 0, 0, 0, 0, 0, '0.00', '0.00', '');
INSERT INTO `tbl_services_imei` (`id`, `imei_single`, `imei_bulk`, `imei_custom`, `imei_custom_len`, `service_name`, `custom_name`, `custom_type`, `custom_required`, `credit`, `retail_credit`, `time`, `status`, `group_id`, `info`, `review`, `notification_mail`, `model`, `provider`, `network`, `assigned_brand`, `assigned_model`, `assigned_country`, `assigned_provider`, `assigned_network`, `assigned_mep`, `Requires_Type`, `Locks`, `active`, `API`, `manualverification`, `API_ID`, `info_file_name`, `download_link`, `faq_id`, `mep`, `listing`, `PIN`, `KBH`, `PRD`, `Type`, `Reference`, `icon_link`, `image_hotdeal`, `retail`, `gatway`, `image_link`, `retail_info`, `verification`, `verifiable`, `usercan_cancel`, `fields`, `purchase_cost`, `stock`, `stock_allow`, `service_type`, `reply_type`, `imei_custom_name`, `imei_custom_info`, `promotiondis`, `happy_hours_start`, `happy_hours_end`, `happy_hours_repetation`, `happy_hours_weekdays`, `hot`, `template_id1`, `template_id2`, `taxed`, `show_onhome`, `subscribe_days`, `subscribe_credit`, `subscribe`, `key_selling`, `ebay_code`, `notificationemail`, `sort`, `mid`, `smsnotification`, `subscriptionorderlimit`, `affiliate_comission`, `seo_title`, `seo_description`, `viewer`, `prev_price`, `store`, `resellerdisctype`, `resellerdisc`, `allowreseller`, `seo_keywords`, `isalpha`, `features`, `customhtml`, `autoreply`, `SN`, `SecRO`, `retail_name`, `acceptterms`, `sku`, `newservice`, `lastupdatedtime`, `apilower`, `useasserver`, `validateimei`, `qnt`, `knowledgebaseas`, `maxlength`, `imeiregex`, `colortag`, `priceslack`, `orderslack`, `autoapi`, `API_TYPEID`, `inactivebyapi`, `apiincrease`, `apiincreasetype`, `knowledgebase`, `qntoptions`, `minqnt`, `maxqnt`, `apiserverid`, `verifyforreject`, `verificationdays`, `autoreplycompleted`, `avgdeliverytime`, `avgexetime`, `retailincrease`, `retailincreaseby`, `autorejectduplicate`, `maxresponsetime`, `hideguest`, `lasteditedby`, `free`, `rejectqnt`, `reward`, `point`, `purchasepoint`, `howtoinfo`) VALUES
(93, 0, 0, 0, 0, 'SAMSUNG ASIA / AUSTRALIA / UAE [ALL LEVELS] ', '', 0, 0, '33.500', '0.000', '1-5 Days', 1, 4, '', 0, '', 0, 0, 0, '', '', '', '', '', '', '', 0, 1, 'fusion13', 0, '2849', '', '', '', 0, '', 0, 0, 0, 0, 0, '', '', 0, '', '', '', 0, 0, 0, '', '', '', 0, 0, 0, '', '', '', '', '', '', '', '', 0, 0, 0, 0, '', '', 0, '', '', 0, 0, 0, 0, 0, '', '', '', 0, '0.000', 0, 0, '', '', '', 0, '', '', 0, 0, 0, '', 0, '', 1, '', '0.000', 0, 0, 0, 0, 0, '', '', '', '', 0, '', 0, '', '', '', '', 0, 0, 0, 0, 0, 0, '', '', '0.00', '', 0, 0, 0, 0, 0, 0, 0, '0.00', '0.00', ''),
(94, 0, 0, 0, 0, 'SAMSUNG WORLDWIDE ALL MODELS &amp; CARRIER - ALL LEVEL', '', 0, 0, '62.000', '0.000', '1-8 days', 1, 4, '', 0, '', 0, 0, 0, '', '', '', '', '', '', '', 0, 1, 'fusion13', 0, '3101', '', '', '', 0, '', 0, 0, 0, 0, 0, '', '', 0, '', '', '', 0, 0, 0, '', '', '', 0, 0, 0, '', '', '', '', '', '', '', '', 0, 0, 0, 0, '', '', 0, '', '', 0, 0, 0, 0, 0, '', '', '', 0, '0.000', 0, 0, '', '', '', 0, '', '', 0, 0, 0, '', 0, '', 1, '', '0.000', 0, 0, 0, 0, 0, '', '', '', '', 0, '', 0, '', '', '', '', 0, 0, 0, 0, 0, 0, '', '', '0.00', '', 0, 0, 0, 0, 0, 0, 0, '0.00', '0.00', ''),
(95, 0, 0, 0, 0, 'SAMSUNG UNITED KINGDOM & IRELAND - NCK & MCK', '', 0, 0, '12.000', '0.000', '1-3 days', 1, 4, '', 0, '', 0, 0, 0, '', '', '', '', '', '', '', 0, 1, 'fusion13', 0, '1859', '', '', '', 0, '', 0, 0, 0, 0, 0, '', '', 0, '', '', '', 0, 0, 0, '', '', '', 0, 0, 0, '', '', '', '', '', '', '', '', 0, 0, 0, 0, '', '', 0, '', '', 0, 0, 0, 0, 0, '', '', '', 0, '0.000', 0, 0, '', '', '', 0, '', '', 0, 0, 0, '', 0, '', 1, '', '0.000', 0, 0, 0, 0, 0, '', '', '', '', 0, '', 0, '', '', '', '', 0, 0, 0, 0, 0, 0, '', '', '0.00', '', 0, 0, 0, 0, 0, 0, 0, '0.00', '0.00', ''),
(96, 0, 0, 0, 0, 'SAMSUNG UNITED KINGDOM &amp; IRELAND - NCK &amp; MCK &amp; RGCK', '', 0, 0, '18.500', '0.000', '1-24 Hours', 1, 4, '', 0, '', 0, 0, 0, '', '', '', '', '', '', '', 0, 1, 'fusion13', 0, '2291', '', '', '', 0, '', 0, 0, 0, 0, 0, '', '', 0, '', '', '', 0, 0, 0, '', '', '', 0, 0, 0, '', '', '', '', '', '', '', '', 0, 0, 0, 0, '', '', 0, '', '', 0, 0, 0, 0, 0, '', '', '', 0, '0.000', 0, 0, '', '', '', 0, '', '', 0, 0, 0, '', 0, '', 1, '', '0.000', 0, 0, 0, 0, 0, '', '', '', '', 0, '', 0, '', '', '', '', 0, 0, 0, 0, 0, 0, '', '', '0.00', '', 0, 0, 0, 0, 0, 0, 0, '0.00', '0.00', ''),
(97, 0, 0, 0, 0, 'SAMSUNG CANADA - NCK ONLY', '', 0, 0, '6.000', '0.000', '1-3 Days', 1, 4, '', 0, '', 0, 0, 0, '', '', '', '', '', '', '', 0, 1, 'fusion13', 0, '1598', '', '', '', 0, '', 0, 0, 0, 0, 0, '', '', 0, '', '', '', 0, 0, 0, '', '', '', 0, 0, 0, '', '', '', '', '', '', '', '', 0, 0, 0, 0, '', '', 0, '', '', 0, 0, 0, 0, 0, '', '', '', 0, '0.000', 0, 0, '', '', '', 0, '', '', 0, 0, 0, '', 0, '', 1, '', '0.000', 0, 0, 0, 0, 0, '', '', '', '', 0, '', 0, '', '', '', '', 0, 0, 0, 0, 0, 0, '', '', '0.00', '', 0, 0, 0, 0, 0, 0, 0, '0.00', '0.00', ''),
(98, 0, 0, 0, 0, 'SAMSUNG CANADA - NCK &amp; MCK', '', 0, 0, '12.000', '0.000', '1-3 Days', 1, 4, '', 0, '', 0, 0, 0, '', '', '', '', '', '', '', 0, 1, 'fusion13', 0, '2867', '', '', '', 0, '', 0, 0, 0, 0, 0, '', '', 0, '', '', '', 0, 0, 0, '', '', '', 0, 0, 0, '', '', '', '', '', '', '', '', 0, 0, 0, 0, '', '', 0, '', '', 0, 0, 0, 0, 0, '', '', '', 0, '0.000', 0, 0, '', '', '', 0, '', '', 0, 0, 0, '', 0, '', 1, '', '0.000', 0, 0, 0, 0, 0, '', '', '', '', 0, '', 0, '', '', '', '', 0, 0, 0, 0, 0, 0, '', '', '0.00', '', 0, 0, 0, 0, 0, 0, 0, '0.00', '0.00', ''),
(99, 0, 0, 0, 0, 'ORANGE/T-MOBILE/EE UK GENERIC ALL MODELS (EXCEPT iPHONE) - CLEAN', '', 0, 0, '3.000', '0.000', '1-8 Days', 1, 4, '', 0, '', 0, 0, 0, '', '', '', '', '', '', '', 0, 1, 'fusion13', 0, '2759', '', '', '', 0, '', 0, 0, 0, 0, 0, '', '', 0, '', '', '', 0, 0, 0, '', '', '', 0, 0, 0, '', '', '', '', '', '', '', '', 0, 0, 0, 0, '', '', 0, '', '', 0, 0, 0, 0, 0, '', '', '', 0, '0.000', 0, 0, '', '', '', 0, '', '', 0, 0, 0, '', 0, '', 1, '', '0.000', 0, 0, 0, 0, 0, '', '', '', '', 0, '', 0, '', '', '', '', 0, 0, 0, 0, 0, 0, '', '', '0.00', '', 0, 0, 0, 0, 0, 0, 0, '0.00', '0.00', ''),
(100, 0, 0, 0, 0, 'SAMSUNG AUSTRIA - NCK &amp; MCK', '', 0, 0, '10.000', '0.000', '1-30 Minutes', 1, 4, '', 0, '', 0, 0, 0, '', '', '', '', '', '', '', 0, 1, 'fusion13', 0, '2876', '', '', '', 0, '', 0, 0, 0, 0, 0, '', '', 0, '', '', '', 0, 0, 0, '', '', '', 0, 0, 0, '', '', '', '', '', '', '', '', 0, 0, 0, 0, '', '', 0, '', '', 0, 0, 0, 0, 0, '', '', '', 0, '0.000', 0, 0, '', '', '', 0, '', '', 0, 0, 0, '', 0, '', 1, '', '0.000', 0, 0, 0, 0, 0, '', '', '', '', 0, '', 0, '', '', '', '', 0, 0, 0, 0, 0, 0, '', '', '0.00', '', 0, 0, 0, 0, 0, 0, 0, '0.00', '0.00', ''),
(101, 0, 0, 0, 0, 'SAMSUNG ROMANIA - NCK &amp; MCK', '', 0, 0, '14.000', '0.000', '1-12 Hours', 1, 4, '', 0, '', 0, 0, 0, '', '', '', '', '', '', '', 0, 1, 'fusion13', 0, '1571', '', '', '', 0, '', 0, 0, 0, 0, 0, '', '', 0, '', '', '', 0, 0, 0, '', '', '', 0, 0, 0, '', '', '', '', '', '', '', '', 0, 0, 0, 0, '', '', 0, '', '', 0, 0, 0, 0, 0, '', '', '', 0, '0.000', 0, 0, '', '', '', 0, '', '', 0, 0, 0, '', 0, '', 1, '', '0.000', 0, 0, 0, 0, 0, '', '', '', '', 0, '', 0, '', '', '', '', 0, 0, 0, 0, 0, 0, '', '', '0.00', '', 0, 0, 0, 0, 0, 0, 0, '0.00', '0.00', ''),
(102, 0, 0, 0, 0, 'SAMSUNG USA AT&amp;T / CRICKET / XFINITY / SPECTRUM (GALAXY NOTE 10 +/S10 +/S10E &amp; OLDER MODELS) ALL LEVEL UNLOCK CODES [PREMIUM]', '', 0, 0, '29.000', '0.000', '1-5 days', 1, 4, '', 0, '', 0, 0, 0, '', '', '', '', '', '', '', 0, 1, 'fusion13', 0, '2948', '', '', '', 0, '', 0, 0, 0, 0, 0, '', '', 0, '', '', '', 0, 0, 0, '', '', '', 0, 0, 0, '', '', '', '', '', '', '', '', 0, 0, 0, 0, '', '', 0, '', '', 0, 0, 0, 0, 0, '', '', '', 0, '0.000', 0, 0, '', '', '', 0, '', '', 0, 0, 0, '', 0, '', 1, '', '0.000', 0, 0, 0, 0, 0, '', '', '', '', 0, '', 0, '', '', '', '', 0, 0, 0, 0, 0, 0, '', '', '0.00', '', 0, 0, 0, 0, 0, 0, 0, '0.00', '0.00', ''),
(103, 0, 0, 0, 0, 'SAMSUNG USA AT&amp;T / CRICKET / XFINITY / SPECTRUM (GALAXY S21 / S21+ / S21 ULTRA) ALL LEVEL UNLOCK CODES [PREMIUM]', '', 0, 0, '36.000', '0.000', '1-5 days', 1, 4, '', 0, '', 0, 0, 0, '', '', '', '', '', '', '', 0, 1, 'fusion13', 0, '2966', '', '', '', 0, '', 0, 0, 0, 0, 0, '', '', 0, '', '', '', 0, 0, 0, '', '', '', 0, 0, 0, '', '', '', '', '', '', '', '', 0, 0, 0, 0, '', '', 0, '', '', 0, 0, 0, 0, 0, '', '', '', 0, '0.000', 0, 0, '', '', '', 0, '', '', 0, 0, 0, '', 0, '', 1, '', '0.000', 0, 0, 0, 0, 0, '', '', '', '', 0, '', 0, '', '', '', '', 0, 0, 0, 0, 0, 0, '', '', '0.00', '', 0, 0, 0, 0, 0, 0, 0, '0.00', '0.00', ''),
(104, 0, 0, 0, 0, 'SAMSUNG USA AT&amp;T / CRICKET / XFINITY / SPECTRUM (GALAXY NOTE 20/NOTE 20 ULTRA/Z FOLD 2/TAB S7/PLUS) ALL LEVEL UNLOCK CODES [PREMIUM]', '', 0, 0, '33.000', '0.000', '1-3 days', 1, 4, '', 0, '', 0, 0, 0, '', '', '', '', '', '', '', 0, 1, 'fusion13', 0, '2957', '', '', '', 0, '', 0, 0, 0, 0, 0, '', '', 0, '', '', '', 0, 0, 0, '', '', '', 0, 0, 0, '', '', '', '', '', '', '', '', 0, 0, 0, 0, '', '', 0, '', '', 0, 0, 0, 0, 0, '', '', '', 0, '0.000', 0, 0, '', '', '', 0, '', '', 0, 0, 0, '', 0, '', 1, '', '0.000', 0, 0, 0, 0, 0, '', '', '', '', 0, '', 0, '', '', '', '', 0, 0, 0, 0, 0, 0, '', '', '0.00', '', 0, 0, 0, 0, 0, 0, 0, '0.00', '0.00', ''),
(105, 0, 0, 0, 0, 'SAMSUNG USA AT&amp;T / CRICKET / XFINITY / SPECTRUM (GALAXY A SERIES/S20/S20+/S20 ULTRA/Z FLIP/Z FOLD) ALL LEVEL UNLOCK CODES [PREMIUM]', '', 0, 0, '30.000', '0.000', '1-3 days', 1, 4, '', 0, '', 0, 0, 0, '', '', '', '', '', '', '', 0, 1, 'fusion13', 0, '2003', '', '', '', 0, '', 0, 0, 0, 0, 0, '', '', 0, '', '', '', 0, 0, 0, '', '', '', 0, 0, 0, '', '', '', '', '', '', '', '', 0, 0, 0, 0, '', '', 0, '', '', 0, 0, 0, 0, 0, '', '', '', 0, '0.000', 0, 0, '', '', '', 0, '', '', 0, 0, 0, '', 0, '', 1, '', '0.000', 0, 0, 0, 0, 0, '', '', '', '', 0, '', 0, '', '', '', '', 0, 0, 0, 0, 0, 0, '', '', '0.00', '', 0, 0, 0, 0, 0, 0, 0, '0.00', '0.00', ''),
(106, 0, 0, 0, 0, 'HUAWEI ROMANIA FACTORY CODES - PREMIUM', '', 0, 0, '13.000', '0.000', '1-4 Days', 1, 4, '', 0, '', 0, 0, 0, '', '', '', '', '', '', '', 0, 1, 'fusion13', 0, '545', '', '', '', 0, '', 0, 0, 0, 0, 0, '', '', 0, '', '', '', 0, 0, 0, '', '', '', 0, 0, 0, '', '', '', '', '', '', '', '', 0, 0, 0, 0, '', '', 0, '', '', 0, 0, 0, 0, 0, '', '', '', 0, '0.000', 0, 0, '', '', '', 0, '', '', 0, 0, 0, '', 0, '', 1, '', '0.000', 0, 0, 0, 0, 0, '', '', '', '', 0, '', 0, '', '', '', '', 0, 0, 0, 0, 0, 0, '', '', '0.00', '', 0, 0, 0, 0, 0, 0, 0, '0.00', '0.00', ''),
(107, 0, 0, 0, 0, 'MOTOROLA WORLDWIDE UNLOCK - INSTANT', '', 0, 0, '3.000', '0.000', '1-15 Minutes', 1, 4, '', 0, '', 0, 0, 0, '', '', '', '', '', '', '', 0, 1, 'fusion13', 0, '1985', '', '', '', 0, '', 0, 0, 0, 0, 0, '', '', 0, '', '', '', 0, 0, 0, '', '', '', 0, 0, 0, '', '', '', '', '', '', '', '', 0, 0, 0, 0, '', '', 0, '', '', 0, 0, 0, 0, 0, '', '', '', 0, '0.000', 0, 0, '', '', '', 0, '', '', 0, 0, 0, '', 0, '', 1, '', '0.000', 0, 0, 0, 0, 0, '', '', '', '', 0, '', 0, '', '', '', '', 0, 0, 0, 0, 0, 0, '', '', '0.00', '', 0, 0, 0, 0, 0, 0, 0, '0.00', '0.00', ''),
(108, 0, 0, 0, 0, 'VODAFONE ROMANIA GENERIC ALL BRANDS (NOKIA SONY ETC)', '', 0, 0, '14.000', '0.000', '1-3 days', 1, 4, '', 0, '', 0, 0, 0, '', '', '', '', '', '', '', 0, 1, 'fusion13', 0, '1328', '', '', '', 0, '', 0, 0, 0, 0, 0, '', '', 0, '', '', '', 0, 0, 0, '', '', '', 0, 0, 0, '', '', '', '', '', '', '', '', 0, 0, 0, 0, '', '', 0, '', '', 0, 0, 0, 0, 0, '', '', '', 0, '0.000', 0, 0, '', '', '', 0, '', '', 0, 0, 0, '', 0, '', 1, '', '0.000', 0, 0, 0, 0, 0, '', '', '', '', 0, '', 0, '', '', '', '', 0, 0, 0, 0, 0, 0, '', '', '0.00', '', 0, 0, 0, 0, 0, 0, 0, '0.00', '0.00', ''),
(109, 0, 0, 0, 0, 'ORANGE ROMANIA GENERIC ALL BRANDS (NOKIA SONY ETC) - 2 YEARS OLD', '', 0, 0, '16.500', '0.000', '1-14 Hours', 1, 4, '', 0, '', 0, 0, 0, '', '', '', '', '', '', '', 0, 1, 'fusion13', 0, '1373', '', '', '', 0, '', 0, 0, 0, 0, 0, '', '', 0, '', '', '', 0, 0, 0, '', '', '', 0, 0, 0, '', '', '', '', '', '', '', '', 0, 0, 0, 0, '', '', 0, '', '', 0, 0, 0, 0, 0, '', '', '', 0, '0.000', 0, 0, '', '', '', 0, '', '', 0, 0, 0, '', 0, '', 1, '', '0.000', 0, 0, 0, 0, 0, '', '', '', '', 0, '', 0, '', '', '', '', 0, 0, 0, 0, 0, 0, '', '', '0.00', '', 0, 0, 0, 0, 0, 0, 0, '0.00', '0.00', ''),
(110, 0, 0, 0, 0, 'A1 MOBILKOM AUSTRIA GENERIC UNLOCK - NOKIA &amp; HUAWEI', '', 0, 0, '64.000', '0.000', '1-3 Hours', 1, 4, '', 0, '', 0, 0, 0, '', '', '', '', '', '', '', 0, 1, 'fusion13', 0, '2012', '', '', '', 0, '', 0, 0, 0, 0, 0, '', '', 0, '', '', '', 0, 0, 0, '', '', '', 0, 0, 0, '', '', '', '', '', '', '', '', 0, 0, 0, 0, '', '', 0, '', '', 0, 0, 0, 0, 0, '', '', '', 0, '0.000', 0, 0, '', '', '', 0, '', '', 0, 0, 0, '', 0, '', 1, '', '0.000', 0, 0, 0, 0, 0, '', '', '', '', 0, '', 0, '', '', '', '', 0, 0, 0, 0, 0, 0, '', '', '0.00', '', 0, 0, 0, 0, 0, 0, 0, '0.00', '0.00', ''),
(111, 0, 0, 0, 0, 'TELUS/KOODO CANADA GENERIC ALL BRANDS (NOKIA SONY ETC)', '', 0, 0, '2.000', '0.000', '1-2 Days', 1, 4, '', 0, '', 0, 0, 0, '', '', '', '', '', '', '', 0, 1, 'fusion13', 0, '1967', '', '', '', 0, '', 0, 0, 0, 0, 0, '', '', 0, '', '', '', 0, 0, 0, '', '', '', 0, 0, 0, '', '', '', '', '', '', '', '', 0, 0, 0, 0, '', '', 0, '', '', 0, 0, 0, 0, 0, '', '', '', 0, '0.000', 0, 0, '', '', '', 0, '', '', 0, 0, 0, '', 0, '', 1, '', '0.000', 0, 0, 0, 0, 0, '', '', '', '', 0, '', 0, '', '', '', '', 0, 0, 0, 0, 0, 0, '', '', '0.00', '', 0, 0, 0, 0, 0, 0, 0, '0.00', '0.00', ''),
(112, 0, 0, 0, 0, 'FIDO &amp; ROGERS CANADA GENERIC ALL BRANDS (NOKIA SONY ETC)', '', 0, 0, '5.500', '0.000', '1-2 Days', 1, 4, '', 0, '', 0, 0, 0, '', '', '', '', '', '', '', 0, 1, 'fusion13', 0, '1958', '', '', '', 0, '', 0, 0, 0, 0, 0, '', '', 0, '', '', '', 0, 0, 0, '', '', '', 0, 0, 0, '', '', '', '', '', '', '', '', 0, 0, 0, 0, '', '', 0, '', '', 0, 0, 0, 0, 0, '', '', '', 0, '0.000', 0, 0, '', '', '', 0, '', '', 0, 0, 0, '', 0, '', 1, '', '0.000', 0, 0, 0, 0, 0, '', '', '', '', 0, '', 0, '', '', '', '', 0, 0, 0, 0, 0, 0, '', '', '0.00', '', 0, 0, 0, 0, 0, 0, 0, '0.00', '0.00', ''),
(113, 0, 0, 0, 0, 'TELSTRA AUSTRALIA GENERIC ALL BRANDS (NOKIA SONY ETC)', '', 0, 0, '12.000', '0.000', '1-4 Days', 1, 4, '', 0, '', 0, 0, 0, '', '', '', '', '', '', '', 0, 1, 'fusion13', 0, '2129', '', '', '', 0, '', 0, 0, 0, 0, 0, '', '', 0, '', '', '', 0, 0, 0, '', '', '', 0, 0, 0, '', '', '', '', '', '', '', '', 0, 0, 0, 0, '', '', 0, '', '', 0, 0, 0, 0, 0, '', '', '', 0, '0.000', 0, 0, '', '', '', 0, '', '', 0, 0, 0, '', 0, '', 1, '', '0.000', 0, 0, 0, 0, 0, '', '', '', '', 0, '', 0, '', '', '', '', 0, 0, 0, 0, 0, 0, '', '', '0.00', '', 0, 0, 0, 0, 0, 0, 0, '0.00', '0.00', ''),
(114, 0, 0, 0, 0, 'MOVISTAR SPAIN GENERIC ALL BRANDS (NOKIA SONY ETC) ', '', 0, 0, '7.500', '0.000', '1-2 days', 1, 4, '', 0, '', 0, 0, 0, '', '', '', '', '', '', '', 0, 1, 'fusion13', 0, '1706', '', '', '', 0, '', 0, 0, 0, 0, 0, '', '', 0, '', '', '', 0, 0, 0, '', '', '', 0, 0, 0, '', '', '', '', '', '', '', '', 0, 0, 0, 0, '', '', 0, '', '', 0, 0, 0, 0, 0, '', '', '', 0, '0.000', 0, 0, '', '', '', 0, '', '', 0, 0, 0, '', 0, '', 1, '', '0.000', 0, 0, 0, 0, 0, '', '', '', '', 0, '', 0, '', '', '', '', 0, 0, 0, 0, 0, 0, '', '', '0.00', '', 0, 0, 0, 0, 0, 0, 0, '0.00', '0.00', ''),
(115, 0, 0, 0, 0, 'VODAFONE SPAIN GENERIC ALL BRANDS (NOKIA SONY ETC) - CLEAN', '', 0, 0, '16.000', '0.000', '1-5 days', 1, 4, '', 0, '', 0, 0, 0, '', '', '', '', '', '', '', 0, 1, 'fusion13', 0, '2021', '', '', '', 0, '', 0, 0, 0, 0, 0, '', '', 0, '', '', '', 0, 0, 0, '', '', '', 0, 0, 0, '', '', '', '', '', '', '', '', 0, 0, 0, 0, '', '', 0, '', '', 0, 0, 0, 0, 0, '', '', '', 0, '0.000', 0, 0, '', '', '', 0, '', '', 0, 0, 0, '', 0, '', 1, '', '0.000', 0, 0, 0, 0, 0, '', '', '', '', 0, '', 0, '', '', '', '', 0, 0, 0, 0, 0, 0, '', '', '0.00', '', 0, 0, 0, 0, 0, 0, 0, '0.00', '0.00', ''),
(116, 0, 0, 0, 0, 'SONY &amp; XPERIA UNITED KINGDOM NETWORKS UNLOCK', '', 0, 0, '18.000', '0.000', '1-6 Days', 1, 4, '', 0, '', 0, 0, 0, '', '', '', '', '', '', '', 0, 1, 'fusion13', 0, '2678', '', '', '', 0, '', 0, 0, 0, 0, 0, '', '', 0, '', '', '', 0, 0, 0, '', '', '', 0, 0, 0, '', '', '', '', '', '', '', '', 0, 0, 0, 0, '', '', 0, '', '', 0, 0, 0, 0, 0, '', '', '', 0, '0.000', 0, 0, '', '', '', 0, '', '', 0, 0, 0, '', 0, '', 1, '', '0.000', 0, 0, 0, 0, 0, '', '', '', '', 0, '', 0, '', '', '', '', 0, 0, 0, 0, 0, 0, '', '', '0.00', '', 0, 0, 0, 0, 0, 0, 0, '0.00', '0.00', ''),
(117, 0, 0, 0, 0, 'O2 UK GENERIC ALL MODELS (EXCEPT iPHONE) - CLEAN', '', 0, 0, '3.200', '0.000', '4-8 days', 1, 4, '', 0, '', 0, 0, 0, '', '', '', '', '', '', '', 0, 1, 'fusion13', 0, '644', '', '', '', 0, '', 0, 0, 0, 0, 0, '', '', 0, '', '', '', 0, 0, 0, '', '', '', 0, 0, 0, '', '', '', '', '', '', '', '', 0, 0, 0, 0, '', '', 0, '', '', 0, 0, 0, 0, 0, '', '', '', 0, '0.000', 0, 0, '', '', '', 0, '', '', 0, 0, 0, '', 0, '', 1, '', '0.000', 0, 0, 0, 0, 0, '', '', '', '', 0, '', 0, '', '', '', '', 0, 0, 0, 0, 0, 0, '', '', '0.00', '', 0, 0, 0, 0, 0, 0, 0, '0.00', '0.00', ''),
(118, 0, 0, 0, 0, '3 HUTCHISON UK GENERIC ALL MODELS (EXCEPT iPHONE)', '', 0, 0, '8.400', '0.000', '1-5 Days', 1, 4, '', 0, '', 0, 0, 0, '', '', '', '', '', '', '', 0, 1, 'fusion13', 0, '2507', '', '', '', 0, '', 0, 0, 0, 0, 0, '', '', 0, '', '', '', 0, 0, 0, '', '', '', 0, 0, 0, '', '', '', '', '', '', '', '', 0, 0, 0, 0, '', '', 0, '', '', 0, 0, 0, 0, 0, '', '', '', 0, '0.000', 0, 0, '', '', '', 0, '', '', 0, 0, 0, '', 0, '', 1, '', '0.000', 0, 0, 0, 0, 0, '', '', '', '', 0, '', 0, '', '', '', '', 0, 0, 0, 0, 0, 0, '', '', '0.00', '', 0, 0, 0, 0, 0, 0, 0, '0.00', '0.00', ''),
(119, 0, 0, 0, 0, 'BOUYGUES FRANCE GENERIC ALL BRANDS (NOKIA SONY ETC)', '', 0, 0, '4.000', '0.000', '1-3 Hours', 1, 4, '', 0, '', 0, 0, 0, '', '', '', '', '', '', '', 0, 1, 'fusion13', 0, '1166', '', '', '', 0, '', 0, 0, 0, 0, 0, '', '', 0, '', '', '', 0, 0, 0, '', '', '', 0, 0, 0, '', '', '', '', '', '', '', '', 0, 0, 0, 0, '', '', 0, '', '', 0, 0, 0, 0, 0, '', '', '', 0, '0.000', 0, 0, '', '', '', 0, '', '', 0, 0, 0, '', 0, '', 1, '', '0.000', 0, 0, 0, 0, 0, '', '', '', '', 0, '', 0, '', '', '', '', 0, 0, 0, 0, 0, 0, '', '', '0.00', '', 0, 0, 0, 0, 0, 0, 0, '0.00', '0.00', ''),
(120, 0, 0, 0, 0, 'SFR FRANCE GENERIC ALL BRANDS (NOKIA SONY ETC) - CLEAN', '', 0, 0, '7.000', '0.000', '0-20 Minutes', 1, 4, '', 0, '', 0, 0, 0, '', '', '', '', '', '', '', 0, 1, 'fusion13', 0, '1310', '', '', '', 0, '', 0, 0, 0, 0, 0, '', '', 0, '', '', '', 0, 0, 0, '', '', '', 0, 0, 0, '', '', '', '', '', '', '', '', 0, 0, 0, 0, '', '', 0, '', '', 0, 0, 0, 0, 0, '', '', '', 0, '0.000', 0, 0, '', '', '', 0, '', '', 0, 0, 0, '', 0, '', 1, '', '0.000', 0, 0, 0, 0, 0, '', '', '', '', 0, '', 0, '', '', '', '', 0, 0, 0, 0, 0, 0, '', '', '0.00', '', 0, 0, 0, 0, 0, 0, 0, '0.00', '0.00', ''),
(121, 0, 0, 0, 0, 'SFR FRANCE GENERIC ALL BRANDS (NOKIA SONY ETC) - PREMIUM', '', 0, 0, '7.600', '0.000', '1-12 Hours', 1, 4, '', 0, '', 0, 0, 0, '', '', '', '', '', '', '', 0, 1, 'fusion13', 0, '194', '', '', '', 0, '', 0, 0, 0, 0, 0, '', '', 0, '', '', '', 0, 0, 0, '', '', '', 0, 0, 0, '', '', '', '', '', '', '', '', 0, 0, 0, 0, '', '', 0, '', '', 0, 0, 0, 0, 0, '', '', '', 0, '0.000', 0, 0, '', '', '', 0, '', '', 0, 0, 0, '', 0, '', 1, '', '0.000', 0, 0, 0, 0, 0, '', '', '', '', 0, '', 0, '', '', '', '', 0, 0, 0, 0, 0, 0, '', '', '0.00', '', 0, 0, 0, 0, 0, 0, 0, '0.00', '0.00', ''),
(122, 0, 0, 0, 0, 'ORANGE FRANCE GENERIC ALL BRANDS (NOKIA SONY ETC) - CLEAN', '', 0, 0, '5.000', '0.000', '1-3 Hours', 1, 4, '', 0, '', 0, 0, 0, '', '', '', '', '', '', '', 0, 1, 'fusion13', 0, '950', '', '', '', 0, '', 0, 0, 0, 0, 0, '', '', 0, '', '', '', 0, 0, 0, '', '', '', 0, 0, 0, '', '', '', '', '', '', '', '', 0, 0, 0, 0, '', '', 0, '', '', 0, 0, 0, 0, 0, '', '', '', 0, '0.000', 0, 0, '', '', '', 0, '', '', 0, 0, 0, '', 0, '', 1, '', '0.000', 0, 0, 0, 0, 0, '', '', '', '', 0, '', 0, '', '', '', '', 0, 0, 0, 0, 0, 0, '', '', '0.00', '', 0, 0, 0, 0, 0, 0, 0, '0.00', '0.00', ''),
(123, 0, 0, 0, 0, 'ORANGE FRANCE GENERIC ALL BRANDS (NOKIA SONY ETC) - NOT FOUND', '', 0, 0, '16.000', '0.000', '1-3 Days', 1, 4, '', 0, '', 0, 0, 0, '', '', '', '', '', '', '', 0, 1, 'fusion13', 0, '1805', '', '', '', 0, '', 0, 0, 0, 0, 0, '', '', 0, '', '', '', 0, 0, 0, '', '', '', 0, 0, 0, '', '', '', '', '', '', '', '', 0, 0, 0, 0, '', '', 0, '', '', 0, 0, 0, 0, 0, '', '', '', 0, '0.000', 0, 0, '', '', '', 0, '', '', 0, 0, 0, '', 0, '', 1, '', '0.000', 0, 0, 0, 0, 0, '', '', '', '', 0, '', 0, '', '', '', '', 0, 0, 0, 0, 0, 0, '', '', '0.00', '', 0, 0, 0, 0, 0, 0, 0, '0.00', '0.00', ''),
(124, 0, 0, 0, 0, 'LENOVO WORLDWIDE UNLOCK - DATABASE 1', '', 0, 0, '5.800', '0.000', '1-4 Days', 1, 4, '', 0, '', 0, 0, 0, '', '', '', '', '', '', '', 0, 1, 'fusion13', 0, '2912', '', '', '', 0, '', 0, 0, 0, 0, 0, '', '', 0, '', '', '', 0, 0, 0, '', '', '', 0, 0, 0, '', '', '', '', '', '', '', '', 0, 0, 0, 0, '', '', 0, '', '', 0, 0, 0, 0, 0, '', '', '', 0, '0.000', 0, 0, '', '', '', 0, '', '', 0, 0, 0, '', 0, '', 1, '', '0.000', 0, 0, 0, 0, 0, '', '', '', '', 0, '', 0, '', '', '', '', 0, 0, 0, 0, 0, 0, '', '', '0.00', '', 0, 0, 0, 0, 0, 0, 0, '0.00', '0.00', ''),
(125, 0, 0, 0, 0, 'LENOVO WORLDWIDE UNLOCK - DATABASE 2', '', 0, 0, '5.800', '0.000', '1-4 Days', 1, 4, '', 0, '', 0, 0, 0, '', '', '', '', '', '', '', 0, 1, 'fusion13', 0, '2921', '', '', '', 0, '', 0, 0, 0, 0, 0, '', '', 0, '', '', '', 0, 0, 0, '', '', '', 0, 0, 0, '', '', '', '', '', '', '', '', 0, 0, 0, 0, '', '', 0, '', '', 0, 0, 0, 0, 0, '', '', '', 0, '0.000', 0, 0, '', '', '', 0, '', '', 0, 0, 0, '', 0, '', 1, '', '0.000', 0, 0, 0, 0, 0, '', '', '', '', 0, '', 0, '', '', '', '', 0, 0, 0, 0, 0, 0, '', '', '0.00', '', 0, 0, 0, 0, 0, 0, 0, '0.00', '0.00', ''),
(126, 0, 0, 0, 0, 'HTC FACTORY UNLOCK CODES - DATABASE 1', '', 0, 0, '1.000', '0.000', '1-10 Minutes', 1, 4, '', 0, '', 0, 0, 0, '', '', '', '', '', '', '', 0, 1, 'fusion13', 0, '491', '', '', '', 0, '', 0, 0, 0, 0, 0, '', '', 0, '', '', '', 0, 0, 0, '', '', '', 0, 0, 0, '', '', '', '', '', '', '', '', 0, 0, 0, 0, '', '', 0, '', '', 0, 0, 0, 0, 0, '', '', '', 0, '0.000', 0, 0, '', '', '', 0, '', '', 0, 0, 0, '', 0, '', 1, '', '0.000', 0, 0, 0, 0, 0, '', '', '', '', 0, '', 0, '', '', '', '', 0, 0, 0, 0, 0, 0, '', '', '0.00', '', 0, 0, 0, 0, 0, 0, 0, '0.00', '0.00', ''),
(127, 0, 0, 0, 0, 'HTC FACTORY UNLOCK CODES - DATABASE 2', '', 0, 0, '1.600', '0.000', '1-10 Minutes', 1, 4, '', 0, '', 0, 0, 0, '', '', '', '', '', '', '', 0, 1, 'fusion13', 0, '2147', '', '', '', 0, '', 0, 0, 0, 0, 0, '', '', 0, '', '', '', 0, 0, 0, '', '', '', 0, 0, 0, '', '', '', '', '', '', '', '', 0, 0, 0, 0, '', '', 0, '', '', 0, 0, 0, 0, 0, '', '', '', 0, '0.000', 0, 0, '', '', '', 0, '', '', 0, 0, 0, '', 0, '', 1, '', '0.000', 0, 0, 0, 0, 0, '', '', '', '', 0, '', 0, '', '', '', '', 0, 0, 0, 0, 0, 0, '', '', '0.00', '', 0, 0, 0, 0, 0, 0, 0, '0.00', '0.00', ''),
(128, 0, 0, 0, 0, 'HTC FACTORY UNLOCK CODES - NEW MODELS &amp; NOT FOUND', '', 0, 0, '2.200', '0.000', '1-10 Minutes', 1, 4, '', 0, '', 0, 0, 0, '', '', '', '', '', '', '', 0, 1, 'fusion13', 0, '500', '', '', '', 0, '', 0, 0, 0, 0, 0, '', '', 0, '', '', '', 0, 0, 0, '', '', '', 0, 0, 0, '', '', '', '', '', '', '', '', 0, 0, 0, 0, '', '', 0, '', '', 0, 0, 0, 0, 0, '', '', '', 0, '0.000', 0, 0, '', '', '', 0, '', '', 0, 0, 0, '', 0, '', 1, '', '0.000', 0, 0, 0, 0, 0, '', '', '', '', 0, '', 0, '', '', '', '', 0, 0, 0, 0, 0, 0, '', '', '0.00', '', 0, 0, 0, 0, 0, 0, 0, '0.00', '0.00', ''),
(129, 0, 0, 0, 0, 'ALCATEL WORLDWIDE UNLOCK - DATABASE 1', '', 0, 0, '1.000', '0.000', '1-12 Hours', 1, 4, '', 0, '', 0, 0, 0, '', '', '', '', '', '', '', 0, 1, 'fusion13', 0, '1121', '', '', '', 0, '', 0, 0, 0, 0, 0, '', '', 0, '', '', '', 0, 0, 0, '', '', '', 0, 0, 0, '', '', '', '', '', '', '', '', 0, 0, 0, 0, '', '', 0, '', '', 0, 0, 0, 0, 0, '', '', '', 0, '0.000', 0, 0, '', '', '', 0, '', '', 0, 0, 0, '', 0, '', 1, '', '0.000', 0, 0, 0, 0, 0, '', '', '', '', 0, '', 0, '', '', '', '', 0, 0, 0, 0, 0, 0, '', '', '0.00', '', 0, 0, 0, 0, 0, 0, 0, '0.00', '0.00', ''),
(130, 0, 0, 0, 0, 'ALCATEL WORLDWIDE UNLOCK - DATABASE 2', '', 0, 0, '1.200', '0.000', '1-12 Hours', 1, 4, '', 0, '', 0, 0, 0, '', '', '', '', '', '', '', 0, 1, 'fusion13', 0, '2894', '', '', '', 0, '', 0, 0, 0, 0, 0, '', '', 0, '', '', '', 0, 0, 0, '', '', '', 0, 0, 0, '', '', '', '', '', '', '', '', 0, 0, 0, 0, '', '', 0, '', '', 0, 0, 0, 0, 0, '', '', '', 0, '0.000', 0, 0, '', '', '', 0, '', '', 0, 0, 0, '', 0, '', 1, '', '0.000', 0, 0, 0, 0, 0, '', '', '', '', 0, '', 0, '', '', '', '', 0, 0, 0, 0, 0, 0, '', '', '0.00', '', 0, 0, 0, 0, 0, 0, 0, '0.00', '0.00', ''),
(131, 0, 0, 0, 0, 'ALCATEL WORLDWIDE UNLOCK - SPD FACTORY CODE', '', 0, 0, '1.100', '0.000', '1-12 Hours', 1, 4, '', 0, '', 0, 0, 0, '', '', '', '', '', '', '', 0, 1, 'fusion13', 0, '2903', '', '', '', 0, '', 0, 0, 0, 0, 0, '', '', 0, '', '', '', 0, 0, 0, '', '', '', 0, 0, 0, '', '', '', '', '', '', '', '', 0, 0, 0, 0, '', '', 0, '', '', 0, 0, 0, 0, 0, '', '', '', 0, '0.000', 0, 0, '', '', '', 0, '', '', 0, 0, 0, '', 0, '', 1, '', '0.000', 0, 0, 0, 0, 0, '', '', '', '', 0, '', 0, '', '', '', '', 0, 0, 0, 0, 0, 0, '', '', '0.00', '', 0, 0, 0, 0, 0, 0, 0, '0.00', '0.00', ''),
(132, 0, 0, 0, 0, 'LG INTERNATIONAL ALL MODELS &amp; ALL LEVEL - UNTIL 2019 ', '', 0, 0, '6.400', '0.000', '1-15 Minutes', 1, 4, '', 0, '', 0, 0, 0, '', '', '', '', '', '', '', 0, 1, 'fusion13', 0, '1535', '', '', '', 0, '', 0, 0, 0, 0, 0, '', '', 0, '', '', '', 0, 0, 0, '', '', '', 0, 0, 0, '', '', '', '', '', '', '', '', 0, 0, 0, 0, '', '', 0, '', '', 0, 0, 0, 0, 0, '', '', '', 0, '0.000', 0, 0, '', '', '', 0, '', '', 0, 0, 0, '', 0, '', 1, '', '0.000', 0, 0, 0, 0, 0, '', '', '', '', 0, '', 0, '', '', '', '', 0, 0, 0, 0, 0, 0, '', '', '0.00', '', 0, 0, 0, 0, 0, 0, 0, '0.00', '0.00', ''),
(133, 0, 0, 0, 0, 'LG INTERNATIONAL ALL MODELS &amp; ALL LEVEL - PREMIUM 2020', '', 0, 0, '15.000', '0.000', '1-20 Minutes', 1, 4, '', 0, '', 0, 0, 0, '', '', '', '', '', '', '', 0, 1, 'fusion13', 0, '1796', '', '', '', 0, '', 0, 0, 0, 0, 0, '', '', 0, '', '', '', 0, 0, 0, '', '', '', 0, 0, 0, '', '', '', '', '', '', '', '', 0, 0, 0, 0, '', '', 0, '', '', 0, 0, 0, 0, 0, '', '', '', 0, '0.000', 0, 0, '', '', '', 0, '', '', 0, 0, 0, '', 0, '', 1, '', '0.000', 0, 0, 0, 0, 0, '', '', '', '', 0, '', 0, '', '', '', '', 0, 0, 0, 0, 0, 0, '', '', '0.00', '', 0, 0, 0, 0, 0, 0, 0, '0.00', '0.00', ''),
(134, 0, 0, 0, 0, 'LG INTERNATIONAL ALL MODELS &amp; ALL LEVEL - UNTIL 2019 (NOT FOUND)', '', 0, 0, '6.800', '0.000', '1-60 Minutes', 1, 4, '', 0, '', 0, 0, 0, '', '', '', '', '', '', '', 0, 1, 'fusion13', 0, '1850', '', '', '', 0, '', 0, 0, 0, 0, 0, '', '', 0, '', '', '', 0, 0, 0, '', '', '', 0, 0, 0, '', '', '', '', '', '', '', '', 0, 0, 0, 0, '', '', 0, '', '', 0, 0, 0, 0, 0, '', '', '', 0, '0.000', 0, 0, '', '', '', 0, '', '', 0, 0, 0, '', 0, '', 1, '', '0.000', 0, 0, 0, 0, 0, '', '', '', '', 0, '', 0, '', '', '', '', 0, 0, 0, 0, 0, 0, '', '', '0.00', '', 0, 0, 0, 0, 0, 0, 0, '0.00', '0.00', ''),
(135, 0, 0, 0, 0, 'NEXTEL MEXICO GENERIC ALL BRANDS (NOKIA SONY ETC)', '', 0, 0, '3.000', '0.000', '1-2 Days', 1, 4, '', 0, '', 0, 0, 0, '', '', '', '', '', '', '', 0, 1, 'fusion13', 0, '1499', '', '', '', 0, '', 0, 0, 0, 0, 0, '', '', 0, '', '', '', 0, 0, 0, '', '', '', 0, 0, 0, '', '', '', '', '', '', '', '', 0, 0, 0, 0, '', '', 0, '', '', 0, 0, 0, 0, 0, '', '', '', 0, '0.000', 0, 0, '', '', '', 0, '', '', 0, 0, 0, '', 0, '', 1, '', '0.000', 0, 0, 0, 0, 0, '', '', '', '', 0, '', 0, '', '', '', '', 0, 0, 0, 0, 0, 0, '', '', '0.00', '', 0, 0, 0, 0, 0, 0, 0, '0.00', '0.00', ''),
(136, 0, 0, 0, 0, 'MOVISTAR MEXICO GENERIC ALL BRANDS (NOKIA SONY ETC)', '', 0, 0, '2.500', '0.000', '1-24 Hours', 1, 4, '', 0, '', 0, 0, 0, '', '', '', '', '', '', '', 0, 1, 'fusion13', 0, '1490', '', '', '', 0, '', 0, 0, 0, 0, 0, '', '', 0, '', '', '', 0, 0, 0, '', '', '', 0, 0, 0, '', '', '', '', '', '', '', '', 0, 0, 0, 0, '', '', 0, '', '', 0, 0, 0, 0, 0, '', '', '', 0, '0.000', 0, 0, '', '', '', 0, '', '', 0, 0, 0, '', 0, '', 1, '', '0.000', 0, 0, 0, 0, 0, '', '', '', '', 0, '', 0, '', '', '', '', 0, 0, 0, 0, 0, 0, '', '', '0.00', '', 0, 0, 0, 0, 0, 0, 0, '0.00', '0.00', ''),
(137, 0, 0, 0, 0, 'MEXICO MOVISTAR / NEXTEL / IUSACELL / UNEFON GENERIC ALL BRANDS (NOKIA SONY ETC)', '', 0, 0, '2.500', '0.000', '1-7 Days', 1, 4, '', 0, '', 0, 0, 0, '', '', '', '', '', '', '', 0, 1, 'fusion13', 0, '2255', '', '', '', 0, '', 0, 0, 0, 0, 0, '', '', 0, '', '', '', 0, 0, 0, '', '', '', 0, 0, 0, '', '', '', '', '', '', '', '', 0, 0, 0, 0, '', '', 0, '', '', 0, 0, 0, 0, 0, '', '', '', 0, '0.000', 0, 0, '', '', '', 0, '', '', 0, 0, 0, '', 0, '', 1, '', '0.000', 0, 0, 0, 0, 0, '', '', '', '', 0, '', 0, '', '', '', '', 0, 0, 0, 0, 0, 0, '', '', '0.00', '', 0, 0, 0, 0, 0, 0, 0, '0.00', '0.00', ''),
(138, 0, 0, 0, 0, 'INSTANT FRANCE BOUYGUES iPHONE UNLOCK', '', 0, 0, '1.000', '0.000', '1-3 Minutes', 1, 5, '', 0, '', 0, 0, 0, '', '', '', '', '', '', '', 0, 1, 'fusion13', 0, '473', '', '', '', 0, '', 0, 0, 0, 0, 0, '', '', 0, '', '', '', 0, 0, 0, '', '', '', 0, 0, 0, '', '', '', '', '', '', '', '', 0, 0, 0, 0, '', '', 0, '', '', 0, 0, 0, 0, 0, '', '', '', 0, '0.000', 0, 0, '', '', '', 0, '', '', 0, 0, 0, '', 0, '', 1, '', '0.000', 0, 0, 0, 0, 0, '', '', '', '', 0, '', 0, '', '', '', '', 0, 0, 0, 0, 0, 0, '', '', '0.00', '', 0, 0, 0, 0, 0, 0, 0, '0.00', '0.00', ''),
(139, 0, 0, 0, 0, 'INSTANT DENMARK HUTCHINSON iPHONE UNLOCK', '', 0, 0, '1.000', '0.000', '1-10 Minutes', 1, 5, '', 0, '', 0, 0, 0, '', '', '', '', '', '', '', 0, 1, 'fusion13', 0, '446', '', '', '', 0, '', 0, 0, 0, 0, 0, '', '', 0, '', '', '', 0, 0, 0, '', '', '', 0, 0, 0, '', '', '', '', '', '', '', '', 0, 0, 0, 0, '', '', 0, '', '', 0, 0, 0, 0, 0, '', '', '', 0, '0.000', 0, 0, '', '', '', 0, '', '', 0, 0, 0, '', 0, '', 1, '', '0.000', 0, 0, 0, 0, 0, '', '', '', '', 0, '', 0, '', '', '', '', 0, 0, 0, 0, 0, 0, '', '', '0.00', '', 0, 0, 0, 0, 0, 0, 0, '0.00', '0.00', ''),
(140, 0, 0, 0, 0, 'INSTANT SLOVAKIA ORANGE/T-MOBILE iPHONE UNLOCK', '', 0, 0, '1.000', '0.000', '1-10 Minutes', 1, 5, '', 0, '', 0, 0, 0, '', '', '', '', '', '', '', 0, 1, 'fusion13', 0, '455', '', '', '', 0, '', 0, 0, 0, 0, 0, '', '', 0, '', '', '', 0, 0, 0, '', '', '', 0, 0, 0, '', '', '', '', '', '', '', '', 0, 0, 0, 0, '', '', 0, '', '', 0, 0, 0, 0, 0, '', '', '', 0, '0.000', 0, 0, '', '', '', 0, '', '', 0, 0, 0, '', 0, '', 1, '', '0.000', 0, 0, 0, 0, 0, '', '', '', '', 0, '', 0, '', '', '', '', 0, 0, 0, 0, 0, 0, '', '', '0.00', '', 0, 0, 0, 0, 0, 0, 0, '0.00', '0.00', '');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_services_imei_api`
--

CREATE TABLE `tbl_services_imei_api` (
  `id` int(11) NOT NULL,
  `sid` int(11) NOT NULL DEFAULT 0,
  `api_server` varchar(150) NOT NULL,
  `api_server_id` varchar(50) NOT NULL,
  `sort` int(11) NOT NULL DEFAULT 0,
  `auto` int(1) NOT NULL,
  `guiid` int(11) NOT NULL,
  `api_server_typeid` varchar(50) NOT NULL,
  `apiserverid` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_service_pricing`
--

CREATE TABLE `tbl_service_pricing` (
  `pricingid` int(11) NOT NULL,
  `currencyid` int(5) DEFAULT NULL,
  `groupid` varchar(50) DEFAULT NULL,
  `price` decimal(14,3) DEFAULT NULL,
  `serviceid` int(11) DEFAULT NULL,
  `pricingqntid` int(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_service_pricing`
--

INSERT INTO `tbl_service_pricing` (`pricingid`, `currencyid`, `groupid`, `price`, `serviceid`, `pricingqntid`) VALUES
(11, 1, 'base', '2.200', 11, 0),
(12, 1, 'base', '0.600', 12, 0),
(13, 1, 'base', '0.700', 13, 0),
(14, 1, 'base', '2.000', 14, 0),
(15, 1, 'base', '3.800', 15, 0),
(16, 1, 'base', '0.080', 16, 0),
(17, 1, 'base', '0.100', 17, 0),
(18, 1, 'base', '2.400', 18, 0),
(19, 1, 'base', '0.220', 19, 0),
(20, 1, 'base', '2.500', 20, 0),
(21, 1, 'base', '0.100', 21, 0),
(22, 1, 'base', '0.080', 22, 0),
(23, 1, 'base', '0.160', 23, 0),
(24, 1, 'base', '0.040', 24, 0),
(25, 1, 'base', '0.080', 25, 0),
(26, 1, 'base', '0.100', 26, 0),
(27, 1, 'base', '0.080', 27, 0),
(28, 1, 'base', '1.100', 28, 0),
(29, 1, 'base', '2.000', 29, 0),
(30, 1, 'base', '0.070', 30, 0),
(31, 1, 'base', '0.080', 31, 0),
(32, 1, 'base', '0.050', 32, 0),
(33, 1, 'base', '0.160', 33, 0),
(34, 1, 'base', '0.050', 34, 0),
(35, 1, 'base', '0.060', 35, 0),
(36, 1, 'base', '0.050', 36, 0),
(37, 1, 'base', '0.040', 37, 0),
(38, 1, 'base', '0.060', 38, 0),
(39, 1, 'base', '0.080', 39, 0),
(40, 1, 'base', '0.120', 40, 0),
(41, 1, 'base', '0.050', 41, 0),
(42, 1, 'base', '0.040', 42, 0),
(43, 1, 'base', '0.100', 43, 0),
(44, 1, 'base', '0.100', 44, 0),
(45, 1, 'base', '0.120', 45, 0),
(46, 1, 'base', '0.100', 46, 0),
(47, 1, 'base', '0.020', 47, 0),
(48, 1, 'base', '999.000', 48, 0),
(49, 1, 'base', '2.000', 49, 0),
(50, 1, 'base', '15.000', 50, 0),
(51, 1, 'base', '17.000', 51, 0),
(52, 1, 'base', '70.000', 52, 0),
(53, 1, 'base', '10.000', 53, 0),
(54, 1, 'base', '2.000', 54, 0),
(55, 1, 'base', '24.000', 55, 0),
(56, 1, 'base', '15.000', 56, 0),
(57, 1, 'base', '1.500', 57, 0),
(58, 1, 'base', '3.000', 58, 0),
(59, 1, 'base', '28.000', 59, 0),
(60, 1, 'base', '39.000', 60, 0),
(61, 1, 'base', '1.500', 61, 0),
(62, 1, 'base', '11.000', 62, 0),
(63, 1, 'base', '39.000', 63, 0),
(64, 1, 'base', '200.000', 64, 0),
(65, 1, 'base', '105.000', 65, 0),
(66, 1, 'base', '19.000', 66, 0),
(67, 1, 'base', '47.000', 67, 0),
(68, 1, 'base', '72.000', 68, 0),
(69, 1, 'base', '29.000', 69, 0),
(70, 1, 'base', '18.000', 70, 0),
(71, 1, 'base', '4.000', 71, 0),
(72, 1, 'base', '1.200', 72, 0),
(73, 1, 'base', '12.000', 73, 0),
(74, 1, 'base', '13.000', 74, 0),
(75, 1, 'base', '1.000', 75, 0),
(76, 1, 'base', '17.000', 76, 0),
(77, 1, 'base', '50.000', 77, 0),
(78, 1, 'base', '14.000', 78, 0),
(79, 1, 'base', '23.000', 79, 0),
(80, 1, 'base', '60.000', 80, 0),
(81, 1, 'base', '3.000', 81, 0),
(82, 1, 'base', '31.000', 82, 0),
(83, 1, 'base', '17.000', 83, 0),
(84, 1, 'base', '5.000', 84, 0),
(85, 1, 'base', '7.000', 85, 0),
(86, 1, 'base', '9.000', 86, 0),
(87, 1, 'base', '4.000', 87, 0),
(88, 1, 'base', '15.000', 88, 0),
(89, 1, 'base', '14.000', 89, 0),
(90, 1, 'base', '2.700', 90, 0),
(91, 1, 'base', '20.000', 91, 0),
(92, 1, 'base', '48.000', 92, 0),
(93, 1, 'base', '33.500', 93, 0),
(94, 1, 'base', '62.000', 94, 0),
(95, 1, 'base', '12.000', 95, 0),
(96, 1, 'base', '18.500', 96, 0),
(97, 1, 'base', '6.000', 97, 0),
(98, 1, 'base', '12.000', 98, 0),
(99, 1, 'base', '3.000', 99, 0),
(100, 1, 'base', '10.000', 100, 0),
(101, 1, 'base', '14.000', 101, 0),
(102, 1, 'base', '29.000', 102, 0),
(103, 1, 'base', '36.000', 103, 0),
(104, 1, 'base', '33.000', 104, 0),
(105, 1, 'base', '30.000', 105, 0),
(106, 1, 'base', '13.000', 106, 0),
(107, 1, 'base', '3.000', 107, 0),
(108, 1, 'base', '14.000', 108, 0),
(109, 1, 'base', '16.500', 109, 0),
(110, 1, 'base', '64.000', 110, 0),
(111, 1, 'base', '2.000', 111, 0),
(112, 1, 'base', '5.500', 112, 0),
(113, 1, 'base', '12.000', 113, 0),
(114, 1, 'base', '7.500', 114, 0),
(115, 1, 'base', '16.000', 115, 0),
(116, 1, 'base', '18.000', 116, 0),
(117, 1, 'base', '3.200', 117, 0),
(118, 1, 'base', '8.400', 118, 0),
(119, 1, 'base', '4.000', 119, 0),
(120, 1, 'base', '7.000', 120, 0),
(121, 1, 'base', '7.600', 121, 0),
(122, 1, 'base', '5.000', 122, 0),
(123, 1, 'base', '16.000', 123, 0),
(124, 1, 'base', '5.800', 124, 0),
(125, 1, 'base', '5.800', 125, 0),
(126, 1, 'base', '1.000', 126, 0),
(127, 1, 'base', '1.600', 127, 0),
(128, 1, 'base', '2.200', 128, 0),
(129, 1, 'base', '1.000', 129, 0),
(130, 1, 'base', '1.200', 130, 0),
(131, 1, 'base', '1.100', 131, 0),
(132, 1, 'base', '6.400', 132, 0),
(133, 1, 'base', '15.000', 133, 0),
(134, 1, 'base', '6.800', 134, 0),
(135, 1, 'base', '3.000', 135, 0),
(136, 1, 'base', '2.500', 136, 0),
(137, 1, 'base', '2.500', 137, 0),
(138, 1, 'base', '1.000', 138, 0),
(139, 1, 'base', '1.000', 139, 0),
(140, 1, 'base', '1.000', 140, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_service_status`
--

CREATE TABLE `tbl_service_status` (
  `servicestatusid` int(11) NOT NULL,
  `groupid` varchar(20) DEFAULT NULL,
  `serviceid` int(11) DEFAULT NULL,
  `status` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_service_status`
--

INSERT INTO `tbl_service_status` (`servicestatusid`, `groupid`, `serviceid`, `status`) VALUES
(11, 'base', 11, 1),
(12, 'base', 12, 1),
(13, 'base', 13, 1),
(14, 'base', 14, 1),
(15, 'base', 15, 1),
(16, 'base', 16, 1),
(17, 'base', 17, 1),
(18, 'base', 18, 1),
(19, 'base', 19, 1),
(20, 'base', 20, 1),
(21, 'base', 21, 1),
(22, 'base', 22, 1),
(23, 'base', 23, 1),
(24, 'base', 24, 1),
(25, 'base', 25, 1),
(26, 'base', 26, 1),
(27, 'base', 27, 1),
(28, 'base', 28, 1),
(29, 'base', 29, 1),
(30, 'base', 30, 1),
(31, 'base', 31, 1),
(32, 'base', 32, 1),
(33, 'base', 33, 1),
(34, 'base', 34, 1),
(35, 'base', 35, 1),
(36, 'base', 36, 1),
(37, 'base', 37, 1),
(38, 'base', 38, 1),
(39, 'base', 39, 1),
(40, 'base', 40, 1),
(41, 'base', 41, 1),
(42, 'base', 42, 1),
(43, 'base', 43, 1),
(44, 'base', 44, 1),
(45, 'base', 45, 1),
(46, 'base', 46, 1),
(47, 'base', 47, 1),
(48, 'base', 48, 1),
(49, 'base', 49, 1),
(50, 'base', 50, 1),
(51, 'base', 51, 1),
(52, 'base', 52, 1),
(53, 'base', 53, 1),
(54, 'base', 54, 1),
(55, 'base', 55, 1),
(56, 'base', 56, 1),
(57, 'base', 57, 1),
(58, 'base', 58, 1),
(59, 'base', 59, 1),
(60, 'base', 60, 1),
(61, 'base', 61, 1),
(62, 'base', 62, 1),
(63, 'base', 63, 1),
(64, 'base', 64, 1),
(65, 'base', 65, 1),
(66, 'base', 66, 1),
(67, 'base', 67, 1),
(68, 'base', 68, 1),
(69, 'base', 69, 1),
(70, 'base', 70, 1),
(71, 'base', 71, 1),
(72, 'base', 72, 1),
(73, 'base', 73, 1),
(74, 'base', 74, 1),
(75, 'base', 75, 1),
(76, 'base', 76, 1),
(77, 'base', 77, 1),
(78, 'base', 78, 1),
(79, 'base', 79, 1),
(80, 'base', 80, 1),
(81, 'base', 81, 1),
(82, 'base', 82, 1),
(83, 'base', 83, 1),
(84, 'base', 84, 1),
(85, 'base', 85, 1),
(86, 'base', 86, 1),
(87, 'base', 87, 1),
(88, 'base', 88, 1),
(89, 'base', 89, 1),
(90, 'base', 90, 1),
(91, 'base', 91, 1),
(92, 'base', 92, 1),
(93, 'base', 93, 1),
(94, 'base', 94, 1),
(95, 'base', 95, 1),
(96, 'base', 96, 1),
(97, 'base', 97, 1),
(98, 'base', 98, 1),
(99, 'base', 99, 1),
(100, 'base', 100, 1),
(101, 'base', 101, 1),
(102, 'base', 102, 1),
(103, 'base', 103, 1),
(104, 'base', 104, 1),
(105, 'base', 105, 1),
(106, 'base', 106, 1),
(107, 'base', 107, 1),
(108, 'base', 108, 1),
(109, 'base', 109, 1),
(110, 'base', 110, 1),
(111, 'base', 111, 1),
(112, 'base', 112, 1),
(113, 'base', 113, 1),
(114, 'base', 114, 1),
(115, 'base', 115, 1),
(116, 'base', 116, 1),
(117, 'base', 117, 1),
(118, 'base', 118, 1),
(119, 'base', 119, 1),
(120, 'base', 120, 1),
(121, 'base', 121, 1),
(122, 'base', 122, 1),
(123, 'base', 123, 1),
(124, 'base', 124, 1),
(125, 'base', 125, 1),
(126, 'base', 126, 1),
(127, 'base', 127, 1),
(128, 'base', 128, 1),
(129, 'base', 129, 1),
(130, 'base', 130, 1),
(131, 'base', 131, 1),
(132, 'base', 132, 1),
(133, 'base', 133, 1),
(134, 'base', 134, 1),
(135, 'base', 135, 1),
(136, 'base', 136, 1),
(137, 'base', 137, 1),
(138, 'base', 138, 1),
(139, 'base', 139, 1),
(140, 'base', 140, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_service_type`
--

CREATE TABLE `tbl_service_type` (
  `id` int(11) NOT NULL,
  `type` varchar(555) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `tbl_service_type`
--

INSERT INTO `tbl_service_type` (`id`, `type`) VALUES
(1, 'Database'),
(2, 'Calculator'),
(3, 'Other');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_settings`
--

CREATE TABLE `tbl_settings` (
  `attribute` varchar(100) NOT NULL,
  `value` mediumtext NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `tbl_settings`
--

INSERT INTO `tbl_settings` (`attribute`, `value`) VALUES
('maintanance', 'System is under Maintenance'),
('htmlcode', ''),
('smsgateway', ''),
('config', 'a:337:{s:5:\"token\";s:40:\"6a66924e80a00df348bf7b4e6e68c1e6ebd69524\";s:11:\"companyname\";s:12:\"Company Name\";s:16:\"config_site_name\";s:9:\"Site Name\";s:9:\"logo_link\";s:0:\"\";s:12:\"site_address\";s:25:\"http://appunlockbayi.com/\";s:16:\"config_ssl_allow\";s:0:\"\";s:15:\"cms_seofriendly\";s:2:\"on\";s:17:\"page_title_format\";s:0:\"\";s:16:\"site_description\";s:20:\"SEO WORDS FOR GOOGLE\";s:12:\"sitekeywords\";s:46:\"KEYWORDS, UNLOCK, iphone, blackberry , Samsung\";s:11:\"testimonial\";s:1:\"0\";s:9:\"contactus\";s:1:\"1\";s:4:\"blog\";s:1:\"0\";s:3:\"faq\";s:1:\"0\";s:20:\"supportticketservice\";s:1:\"0\";s:12:\"displayprice\";s:1:\"1\";s:12:\"facebooklike\";s:1:\"0\";s:12:\"mail_history\";s:1:\"0\";s:9:\"ccdetails\";s:1:\"1\";s:10:\"installapp\";s:1:\"0\";s:14:\"allowoverdrive\";s:1:\"0\";s:9:\"quicknews\";s:1:\"0\";s:14:\"contactus_mail\";s:20:\"contact@yoursite.com\";s:13:\"support_email\";s:0:\"\";s:19:\"Index_page_redirect\";s:0:\"\";s:20:\"logout_page_redirect\";s:0:\"\";s:7:\"addfund\";s:1:\"1\";s:15:\"AddFundsMinimum\";s:2:\"10\";s:15:\"AddFundsMaximum\";s:3:\"100\";s:22:\"AddFundsMaximumBalance\";s:8:\"10000000\";s:15:\"cart_page_limit\";s:2:\"50\";s:14:\"adminlistlimit\";s:0:\"\";s:18:\"default_page_limit\";s:2:\"50\";s:16:\"BlogPostsperpage\";s:2:\"50\";s:16:\"ActivityLogLimit\";s:4:\"1000\";s:19:\"AddFunds_taxenabled\";s:1:\"1\";s:8:\"gravatar\";s:1:\"0\";s:20:\"faster_browsing_mode\";s:1:\"1\";s:7:\"voucher\";s:1:\"0\";s:10:\"trackorder\";s:1:\"0\";s:9:\"downloads\";s:1:\"0\";s:18:\"config_recent_menu\";s:1:\"0\";s:11:\"eucookielaw\";s:1:\"1\";s:15:\"livehelpservice\";s:1:\"0\";s:10:\"googlelike\";s:1:\"0\";s:9:\"affiliate\";s:1:\"0\";s:8:\"wikihelp\";s:1:\"0\";s:13:\"litedashboard\";s:1:\"0\";s:9:\"giftcerti\";s:1:\"0\";s:15:\"giftvoucher_tax\";s:1:\"0\";s:14:\"withdrawal_req\";s:1:\"0\";s:14:\"RemoveBranding\";s:0:\"\";s:24:\"reseller_can_setup_store\";s:1:\"1\";s:9:\"live_chat\";s:1:\"1\";s:12:\"shoppingcart\";s:1:\"1\";s:3:\"POS\";s:1:\"1\";s:11:\"mobileaddon\";s:1:\"1\";s:17:\"slacksubscription\";s:1:\"1\";s:13:\"online_status\";s:6:\"online\";s:21:\"live_chat_online_time\";s:10:\"1679506733\";s:25:\"live_chat_online_username\";s:5:\"admin\";s:11:\"loginfailed\";s:1:\"0\";s:8:\"template\";s:7:\"default\";s:19:\"template_afterlogin\";s:7:\"default\";s:6:\"applys\";s:2:\"on\";s:16:\"afterlogin_apply\";s:1:\"1\";s:15:\"template_mobile\";s:7:\"default\";s:7:\"carttpl\";s:7:\"default\";s:13:\"cron_password\";s:0:\"\";s:18:\"cronsendbatchorder\";s:3:\"100\";s:17:\"crongetbatchorder\";s:4:\"1000\";s:12:\"seperatecron\";s:1:\"1\";s:10:\"slacktoken\";s:0:\"\";s:9:\"messenger\";s:8:\"telegram\";s:17:\"mail_sending_type\";s:1:\"2\";s:12:\"mailperbatch\";s:2:\"50\";s:17:\"config_admin_mail\";s:19:\"system@sitename.com\";s:12:\"BCC_Messages\";s:0:\"\";s:17:\"config_admin_name\";s:6:\"system\";s:14:\"adminsignature\";s:15:\"Admin Signature\";s:2:\"ds\";s:2:\"s1\";s:9:\"mail_type\";s:3:\"php\";s:20:\"default_service_imei\";s:1:\"1\";s:20:\"default_service_file\";s:1:\"1\";s:22:\"default_service_server\";s:1:\"1\";s:18:\"config_self_cancel\";s:1:\"1\";s:31:\"usercan_cancel_order_within_min\";s:2:\"60\";s:31:\"usercan_verify_order_within_min\";s:2:\"60\";s:14:\"showimeiupdate\";s:2:\"48\";s:13:\"duplicateimei\";s:1:\"1\";s:10:\"happyhours\";s:1:\"0\";s:7:\"tooltip\";s:1:\"0\";s:13:\"ordercomments\";s:1:\"0\";s:10:\"orderemail\";s:1:\"0\";s:19:\"averagedeliverytime\";s:1:\"1\";s:16:\"clientorderalert\";s:1:\"0\";s:13:\"deliverycount\";s:0:\"\";s:14:\"placeordertype\";s:1:\"1\";s:7:\"infopos\";s:1:\"1\";s:18:\"subscribe_reminder\";s:2:\"10\";s:15:\"directorderinfo\";s:0:\"\";s:14:\"orderreplyword\";s:28:\"No Code Found\r\nWrong Details\";s:12:\"orderdisplay\";s:1:\"2\";s:14:\"quick_checkout\";s:7:\"disable\";s:16:\"directunverified\";s:1:\"1\";s:16:\"encryptedorderid\";s:1:\"0\";s:9:\"masterpin\";s:1:\"0\";s:10:\"ordernotes\";s:1:\"0\";s:7:\"orderno\";s:1:\"0\";s:15:\"admintheme_menu\";s:4:\"open\";s:22:\"slack_usernotification\";s:1:\"1\";s:9:\"avatarapi\";s:0:\"\";s:9:\"gcmapikey\";s:0:\"\";s:13:\"tracking_code\";s:0:\"\";s:6:\"gcmkey\";s:0:\"\";s:8:\"gcmappid\";s:0:\"\";s:11:\"ip_location\";s:25:\"https://geo.dhru.com/?ip=\";s:7:\"twitter\";s:0:\"\";s:13:\"facebook_link\";s:21:\"https://facebook.com/\";s:8:\"linkedln\";s:21:\"https://Linkedin.com/\";s:12:\"consumer_key\";s:0:\"\";s:15:\"consumer_secret\";s:0:\"\";s:12:\"access_token\";s:0:\"\";s:12:\"token_secret\";s:0:\"\";s:17:\"googlelanguageapi\";s:0:\"\";s:11:\"androidlink\";s:67:\"https://play.google.com/store/apps/details?id=com.dhru.fusionclient\";s:18:\"analyticsecommerce\";s:0:\"\";s:15:\"gcmnotification\";s:0:\"\";s:10:\"taxenabled\";s:1:\"1\";s:7:\"taxtype\";s:9:\"Exclusive\";s:12:\"invoicepayto\";s:38:\"401, Alien street, Red Planet. 444123.\";s:14:\"cronpreference\";s:1:\"2\";s:17:\"gatewayiconpaypal\";s:0:\"\";s:9:\"precision\";s:1:\"3\";s:11:\"bannersizes\";s:3:\"box\";s:11:\"bannershape\";s:3:\"svg\";s:10:\"themecolor\";s:6:\"theme1\";s:14:\"menubackground\";s:11:\"transparent\";s:7:\"menubgs\";s:0:\"\";s:6:\"navbar\";s:5:\"color\";s:13:\"bannercontent\";s:8:\"checkout\";s:17:\"announcementpopup\";s:5:\"false\";s:13:\"lock_username\";s:8:\"username\";s:10:\"lock_email\";s:5:\"email\";s:17:\"registration_type\";s:1:\"2\";s:15:\"minregistration\";s:1:\"0\";s:13:\"phonerequired\";s:1:\"1\";s:19:\"registration_expire\";s:3:\"365\";s:21:\"registration_currency\";s:0:\"\";s:6:\"google\";s:6:\"google\";s:5:\"yahoo\";s:0:\"\";s:8:\"facebook\";s:8:\"facebook\";s:20:\"captcha_registration\";s:1:\"0\";s:18:\"registration_terms\";s:1:\"1\";s:14:\"googleclientid\";s:0:\"\";s:18:\"googleclientsecret\";s:0:\"\";s:13:\"facebookappid\";s:0:\"\";s:17:\"facebookappsecret\";s:0:\"\";s:19:\"facebookaccesstoken\";s:0:\"\";s:16:\"registration_api\";s:1:\"1\";s:22:\"registration_affiliate\";s:1:\"0\";s:15:\"customize_email\";s:1:\"0\";s:16:\"fraud_protection\";s:1:\"0\";s:19:\"default_signupgroup\";s:1:\"0\";s:17:\"retailclientgroup\";s:1:\"0\";s:11:\"customfield\";s:0:\"\";s:23:\"registration_lockfields\";s:14:\"username,email\";s:14:\"usercan_signup\";s:0:\"\";s:23:\"newsletter_registration\";s:1:\"0\";s:13:\"captcha_login\";s:1:\"1\";s:14:\"captcha_forget\";s:1:\"0\";s:12:\"cronpassword\";s:0:\"\";s:16:\"firstinvoice_due\";s:1:\"0\";s:17:\"secondinvoice_due\";s:1:\"0\";s:16:\"thirdinvoice_due\";s:1:\"0\";s:17:\"cancelinvoice_due\";s:0:\"\";s:17:\"groupexpiryremind\";s:0:\"\";s:17:\"deleteinvoice_due\";s:2:\"15\";s:14:\"lastloginalert\";s:2:\"30\";s:17:\"lowcreditreminder\";s:2:\"10\";s:21:\"lowcreditnotification\";s:0:\"\";s:21:\"creditvalidityremider\";s:2:\"10\";s:12:\"ticketclosed\";s:0:\"\";s:12:\"reorderlevel\";s:0:\"\";s:18:\"quickcheckoutorder\";s:0:\"\";s:19:\"autodeletequicknews\";s:0:\"\";s:14:\"dontdiscconect\";s:1:\"0\";s:14:\"currencyupdate\";s:1:\"1\";s:13:\"countryupdate\";s:1:\"1\";s:11:\"pricechange\";s:0:\"\";s:11:\"autoarchive\";s:2:\"27\";s:16:\"dailyemailbackup\";s:0:\"\";s:11:\"imeisummary\";s:0:\"\";s:12:\"dailysitemap\";s:0:\"\";s:13:\"lowstockalert\";s:0:\"\";s:8:\"removecc\";s:1:\"0\";s:16:\"newimeiavailable\";s:1:\"1\";s:18:\"currencyupdatetime\";s:10:\"1577206148\";s:14:\"bannerposition\";s:6:\"middle\";s:11:\"testtoemail\";s:0:\"\";s:14:\"disablestartup\";s:1:\"1\";s:11:\"faviconicon\";s:0:\"\";s:12:\"popbefenable\";s:0:\"\";s:11:\"popafenable\";s:0:\"\";s:9:\"instagram\";s:22:\"https://Instagram.com/\";s:7:\"fundtax\";s:2:\"on\";s:12:\"lock_address\";s:7:\"address\";s:13:\"lock_address2\";s:8:\"address2\";s:9:\"lock_city\";s:4:\"city\";s:10:\"lock_state\";s:5:\"state\";s:12:\"lock_country\";s:7:\"country\";s:8:\"lock_zip\";s:3:\"zip\";s:21:\"gatewayminlimitstripe\";s:1:\"2\";s:21:\"gatewaymaxlimitstripe\";s:2:\"22\";s:23:\"gatewayminlimitcoinbase\";s:2:\"10\";s:23:\"gatewaymaxlimitcoinbase\";s:3:\"500\";s:22:\"gatewayminlimitbitcoin\";s:1:\"5\";s:22:\"gatewaymaxlimitbitcoin\";s:3:\"500\";s:16:\"captchaoncontact\";s:1:\"0\";s:14:\"autofraudclose\";s:1:\"0\";s:9:\"fraudcage\";s:1:\"1\";s:19:\"mobile_verification\";s:1:\"0\";s:19:\"captchaonnewsletter\";s:1:\"1\";s:18:\"paypalemailautopay\";s:1:\"0\";s:11:\"mobverbysms\";s:1:\"0\";s:12:\"mobverbycall\";s:1:\"0\";s:9:\"tinyvalue\";s:0:\"\";s:10:\"smsgateway\";s:13:\"customgateway\";s:14:\"idverification\";s:1:\"0\";s:24:\"defaultgroupverification\";s:1:\"1\";s:11:\"clientgroup\";s:0:\"\";s:16:\"otpfordirectfund\";s:1:\"1\";s:13:\"singupgateway\";s:1:\"2\";s:13:\"signupgateway\";s:1:\"0\";s:7:\"gateway\";s:0:\"\";s:14:\"defaultgateway\";s:0:\"\";s:14:\"ebaypaypaluser\";s:0:\"\";s:14:\"ebaypaypalpass\";s:0:\"\";s:19:\"ebaypaypalsignature\";s:0:\"\";s:12:\"cartforstore\";s:1:\"1\";s:12:\"shippingcost\";s:1:\"1\";s:14:\"compareproduct\";s:1:\"1\";s:18:\"displayproducttype\";s:1:\"1\";s:18:\"defaultproductview\";s:1:\"1\";s:13:\"shoppingcart1\";s:1:\"0\";s:10:\"retailmenu\";s:1:\"0\";s:13:\"base_currency\";s:3:\"USD\";s:14:\"DefaultCountry\";s:2:\"US\";s:7:\"charset\";s:5:\"UTF-8\";s:12:\"admincharset\";s:5:\"UTF-8\";s:10:\"dateformat\";s:10:\"MM/DD/YYYY\";s:8:\"language\";s:7:\"English\";s:9:\"time_zone\";s:3:\"546\";s:15:\"language_chnage\";s:1:\"0\";s:9:\"smtp_port\";s:3:\"465\";s:9:\"smtp_host\";s:0:\"\";s:13:\"smtp_username\";s:0:\"\";s:13:\"smtp_password\";s:0:\"\";s:14:\"aggregatorlink\";s:0:\"\";s:13:\"mailgundomain\";s:0:\"\";s:13:\"aggregatorapi\";s:0:\"\";s:10:\"mail_type1\";s:3:\"php\";s:10:\"smtp_port1\";s:0:\"\";s:10:\"smtp_host1\";s:0:\"\";s:9:\"smtp_enc1\";s:1:\"1\";s:14:\"smtp_username1\";s:0:\"\";s:14:\"smtp_password1\";s:0:\"\";s:10:\"mail_type2\";s:3:\"php\";s:10:\"smtp_port2\";s:0:\"\";s:10:\"smtp_host2\";s:0:\"\";s:14:\"smtp_username2\";s:0:\"\";s:14:\"smtp_password2\";s:0:\"\";s:8:\"smtp_enc\";s:0:\"\";s:22:\"default_service_remote\";s:1:\"1\";s:14:\"slacktokenuser\";s:0:\"\";s:15:\"telegramuserbot\";s:0:\"\";s:16:\"allowtelegramreg\";s:1:\"1\";s:17:\"autoverifycredits\";s:1:\"0\";s:11:\"rewardpoint\";s:1:\"0\";s:13:\"addfundpoints\";s:219:\"{\"base\":{\"1\":\"2\",\"2\":\"2\",\"3\":\"\",\"20\":\"\",\"21\":\"\",\"30\":\"\",\"29\":\"7\",\"31\":\"\"},\"18\":{\"1\":\"3\",\"2\":\"\",\"3\":\"4\",\"20\":\"\",\"21\":\"0.5\",\"30\":\"6\",\"29\":\"\",\"31\":\"\"},\"19\":{\"1\":\"4\",\"2\":\"\",\"3\":\"\",\"20\":\"5\",\"21\":\"5\",\"30\":\"\",\"29\":\"\",\"31\":\"\"}}\";s:7:\"geodate\";s:10:\"05-03-2020\";s:22:\"MaxLoginFailedAttempts\";s:2:\"10\";s:16:\"password_expired\";s:1:\"0\";s:16:\"adminblocknotice\";s:1:\"1\";s:7:\"allowed\";s:4:\" all\";s:16:\"passwordsecurity\";s:4:\"high\";s:9:\"userapiip\";s:1:\"0\";s:15:\"sendcountrymail\";s:1:\"0\";s:15:\"usertmppassword\";s:1:\"0\";s:28:\"block_ac_on_country_mismatch\";s:1:\"0\";s:9:\"walletfee\";s:1:\"5\";s:13:\"allowtransfer\";s:1:\"1\";s:17:\"notdiscounteduser\";s:1:\"1\";s:14:\"otherfundlimit\";s:1192:\"{\"baokim\":{\"maxlimit\":\"\",\"minlimit\":\"1\"},\"cash\":{\"maxlimit\":\"200\",\"minlimit\":\"2\"},\"cc\":{\"maxlimit\":\"230\",\"minlimit\":\"3\"},\"ccavenue\":{\"maxlimit\":\"140\",\"minlimit\":\"4\"},\"cod\":{\"minlimit\":\"4\",\"maxlimit\":\"\"},\"paypal\":{\"minlimit\":\"5\",\"maxlimit\":\"100\"},\"alipay\":{\"maxlimit\":\"\"},\"authorizenet\":{\"maxlimit\":\"\"},\"bitcoin\":{\"maxlimit\":\"\"},\"bitmap\":{\"maxlimit\":\"\"},\"bitmapdirect\":{\"maxlimit\":\"\"},\"coinbase\":{\"maxlimit\":\"\"},\"dalpay\":{\"maxlimit\":\"\"},\"dc\":{\"maxlimit\":\"\"},\"dhrumerchant\":{\"maxlimit\":\"\"},\"directpaypal1\":{\"maxlimit\":\"\"},\"directpaypal2\":{\"maxlimit\":\"\"},\"fawry\":{\"maxlimit\":\"\"},\"gourlio\":{\"maxlimit\":\"\"},\"networkae_ngenius\":{\"maxlimit\":\"\"},\"offlinepayments\":{\"maxlimit\":\"\"},\"offlinepayments1\":{\"maxlimit\":\"\"},\"offlinepayments5\":{\"maxlimit\":\"\"},\"offlinepayments9\":{\"maxlimit\":\"\"},\"paymentaggregator\":{\"maxlimit\":\"\"},\"paypal2\":{\"maxlimit\":\"\"},\"paypal3\":{\"maxlimit\":\"\"},\"paypalexpress\":{\"maxlimit\":\"\"},\"paypal_mass_pay\":{\"maxlimit\":\"\"},\"payumoney\":{\"maxlimit\":\"\"},\"quickpay\":{\"maxlimit\":\"\"},\"rakbankpay\":{\"maxlimit\":\"\"},\"rave\":{\"maxlimit\":\"\"},\"razorpay\":{\"maxlimit\":\"\"},\"squareup\":{\"maxlimit\":\"\"},\"stripe\":{\"maxlimit\":\"\"},\"vnpay\":{\"maxlimit\":\"\"},\"walletes\":{\"maxlimit\":\"\"},\"zarin\":{\"maxlimit\":\"\"}}\";s:14:\"contactusphone\";s:10:\"9999999999\";s:16:\"contactusaddress\";s:38:\"401, Alien street, Red Planet. 444123.\";s:16:\"locationlatitude\";s:9:\"40.712776\";s:17:\"locationlongitude\";s:10:\"-74.005974\";s:19:\"maintenancebacktime\";s:10:\"1593250258\";s:27:\"config_is_under_maintanance\";s:1:\"0\";s:15:\"maintenancetime\";s:0:\"\";s:14:\"securityemails\";s:1:\"0\";s:15:\"lock_first_name\";s:9:\"firstname\";s:14:\"lock_last_name\";s:8:\"lastname\";s:13:\"invoiceprefix\";s:0:\"\";s:16:\"invoiceincrement\";s:1:\"1\";s:26:\"can_change_invoice_gateway\";s:1:\"1\";s:9:\"contactby\";s:1:\"0\";s:21:\"contactusdisplayemail\";s:22:\"contactus@yoursite.com\";s:14:\"contactusemail\";s:0:\"\";s:10:\"slack_test\";s:0:\"\";s:22:\"slack_adminloginfailed\";s:0:\"\";s:20:\"slack_suspiousaccess\";s:0:\"\";s:23:\"slack_ordernotification\";s:10:\"1275637135\";s:29:\"slack_serverordernotification\";s:0:\"\";s:27:\"slack_shopordernotification\";s:0:\"\";s:20:\"slack_adminaddcredit\";s:0:\"\";s:19:\"slack_newusersignup\";s:0:\"\";s:17:\"slack_invoicepaid\";s:0:\"\";s:23:\"slack_manualinvoicepaid\";s:0:\"\";s:18:\"slack_fraudinvoice\";s:0:\"\";s:25:\"slack_directinvoicestatus\";s:0:\"\";s:18:\"slack_apilowcredit\";s:0:\"\";s:18:\"slack_notenoughkey\";s:0:\"\";s:20:\"slack_idverification\";s:0:\"\";s:18:\"slack_fundtransfer\";s:9:\"799273847\";s:17:\"slack_servicestat\";s:5:\"tdhru\";s:17:\"slack_pricechange\";s:5:\"tdhru\";s:12:\"backup_users\";s:1:\"1\";s:14:\"backup_service\";s:1:\"1\";s:13:\"backup_config\";s:1:\"1\";s:12:\"backup_order\";s:1:\"1\";s:12:\"backup_email\";s:1:\"1\";s:12:\"backupmailto\";s:0:\"\";s:16:\"cloudflarezoneid\";s:0:\"\";s:15:\"cloudflareemail\";s:0:\"\";s:16:\"cloudflareapikey\";s:0:\"\";}');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_settings_default`
--

CREATE TABLE `tbl_settings_default` (
  `attribute` varchar(100) NOT NULL,
  `value` mediumtext NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_sheduledmail`
--

CREATE TABLE `tbl_sheduledmail` (
  `id` int(11) NOT NULL,
  `subject` varchar(1000) NOT NULL,
  `message` mediumtext NOT NULL,
  `fromname` varchar(555) NOT NULL,
  `fromemail` varchar(555) NOT NULL,
  `attachment` mediumtext NOT NULL,
  `attachname` varchar(1000) NOT NULL,
  `priority` int(11) NOT NULL DEFAULT 0,
  `userid` int(11) NOT NULL DEFAULT 0,
  `to` varchar(255) NOT NULL,
  `cc` varchar(255) NOT NULL,
  `bcc` varchar(255) NOT NULL,
  `replyto` varchar(255) NOT NULL,
  `response_email` varchar(255) NOT NULL,
  `plaintext` int(1) NOT NULL DEFAULT 0,
  `history` int(1) NOT NULL DEFAULT 0,
  `mailserv` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_shipping_gatway`
--

CREATE TABLE `tbl_shipping_gatway` (
  `gateway` mediumtext NOT NULL,
  `setting` mediumtext NOT NULL,
  `value` mediumtext NOT NULL,
  `order` int(1) NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_shipping_services`
--

CREATE TABLE `tbl_shipping_services` (
  `id` int(11) NOT NULL,
  `gateway` mediumtext NOT NULL,
  `setting` mediumtext NOT NULL,
  `value` mediumtext NOT NULL,
  `order` int(1) NOT NULL DEFAULT 0,
  `status` int(1) NOT NULL DEFAULT 0,
  `cost` varchar(50) NOT NULL,
  `country` mediumtext NOT NULL,
  `trackingurl` mediumtext NOT NULL,
  `deliverytime` varchar(255) NOT NULL,
  `shippingicon` varchar(200) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `tbl_shipping_services`
--

INSERT INTO `tbl_shipping_services` (`id`, `gateway`, `setting`, `value`, `order`, `status`, `cost`, `country`, `trackingurl`, `deliverytime`, `shippingicon`) VALUES
(34, 'custom', 'dhl399', 'UPS', 0, 1, '210', 'AX,AL,DZ,AS,AD,AO,AI,AQ,AG,AR,AM,AW,AU,AT,AZ,BS,BH,BD,BB,BY,BE,BZ,BJ,BM,BT,BO,BA,BW,BV,BR,IO,BN,BG,BF,BI,KH,CM,CA,CV,KY,CF,TD,CL,CN,CX,CC,CO,KM,CG,CD,CK,CR,CI,HR,CU,CY,CZ,DK,DJ,DM,DO,EC,EG,SV,GQ,ER,EE,ET,FK,FO,FJ,FI,FR,GF,PF,TF,GA,GM,GE,DE,GH,GI,GR,GL,GD,GP,GU,GT,GG,GN,GW,GY,HT,HM,VA,HN,HK,HU,IS,IN,ID,IR,IQ,IE,IM,IL,IT,JM,JP,JE,JO,KZ,KE,KI,KR,XK,KW,KG,LA,LV,LB,LS,LR,LY,LI,LT,LU,MO,MK,MG,MW,MY,MV,ML,MT,MH,MQ,MR,MU,YT,MX,FM,MD,MC,MN,ME,MS,MA,MZ,MM,NA,NR,NP,NL,AN,NC,NZ,NI,NE,NG,NU,NF,MP,NO,OM,PK,PW,PS,PA,PG,PY,PE,PH,PN,PL,PT,PR,QA,RE,RO,RU,RW,BL,SH,KN,LC,MF,PM,VC,WS,SM,ST,SA,SN,RS,SC,SL,SG,SK,SI,SB,SO,ZA,GS,ES,LK,SD,SR,SJ,SZ,SE,CH,SY,TW,TJ,TZ,TH,TL,TG,TK,TO,TT,TN,TR,TM,TC,TV,UG,UA,AE,GB,US,UM,UY,UZ,VU,VE,VN,VG,VI,WF,EH,YE,ZM,ZW', 'http://dhl.com/trackmy.php?id=3993', '', NULL),
(35, 'custom', '', 'DHL', 0, 1, '', 'AX,AL,DZ,AS,AD,AO,AI,AQ,AG,AR,AM,AW,AU,AT,AZ,BS,BH,BD,BB,BY,BE,BZ,BJ,BM,BT,BO,BA,BW,BV,BR,IO,BN,BG,BF,BI,KH,CM,CA,CV,KY,CF,TD,CL,CN,CX,CC,CO,KM,CG,CD,CK,CR,CI,HR,CU,CY,CZ,DK,DJ,DM,DO,EC,EG,SV,GQ,ER,EE,ET,FK,FO,FJ,FI,FR,GF,PF,TF,GA,GM,GE,DE,GH,GI,GR,GL,GD,GP,GU,GT,GG,GN,GW,GY,HT,HM,VA,HN,HK,HU,IS,IN,ID,IR,IQ,IE,IM,IL,IT,JM,JP,JE,JO,KZ,KE,KI,KR,XK,KW,KG,LA,LV,LB,LS,LR,LY,LI,LT,LU,MO,MK,MG,MW,MY,MV,ML,MT,MH,MQ,MR,MU,YT,MX,FM,MD,MC,MN,ME,MS,MA,MZ,MM,NA,NR,NP,NL,AN,NC,NZ,NI,NE,NG,NU,NF,MP,NO,OM,PK,PW,PS,PA,PG,PY,PE,PH,PN,PL,PT,PR,QA,RE,RO,RU,RW,BL,SH,KN,LC,MF,PM,VC,WS,SM,ST,SA,SN,RS,SC,SL,SG,SK,SI,SB,SO,ZA,GS,ES,LK,SD,SR,SJ,SZ,SE,CH,SY,TW,TJ,TZ,TH,TL,TG,TK,TO,TT,TN,TR,TM,TC,TV,UG,UA,AE,GB,US,UM,UY,UZ,VU,VE,VN,VG,VI,WF,EH,YE,ZM,ZW', '', '', NULL),
(36, 'custom', '', 'Fedex international', 0, 1, '', 'AX,AL,DZ,AS,AD,AO,AI,AQ,AG,AR,AM,AW,AU,AT,AZ,BS,BH,BD,BB,BY,BE,BZ,BJ,BM,BT,BO,BA,BW,BV,BR,IO,BN,BG,BF,BI,KH,CM,CA,CV,KY,CF,TD,CL,CN,CX,CC,CO,KM,CG,CD,CK,CR,CI,HR,CU,CY,CZ,DK,DJ,DM,DO,EC,EG,SV,GQ,ER,EE,ET,FK,FO,FJ,FI,FR,GF,PF,TF,GA,GM,GE,DE,GH,GI,GR,GL,GD,GP,GU,GT,GG,GN,GW,GY,HT,HM,VA,HN,HK,HU,IS,IN,ID,IR,IQ,IE,IM,IL,IT,JM,JP,JE,JO,KZ,KE,KI,KR,XK,KW,KG,LA,LV,LB,LS,LR,LY,LI,LT,LU,MO,MK,MG,MW,MY,MV,ML,MT,MH,MQ,MR,MU,YT,MX,FM,MD,MC,MN,ME,MS,MA,MZ,MM,NA,NR,NP,NL,AN,NC,NZ,NI,NE,NG,NU,NF,MP,NO,OM,PK,PW,PS,PA,PG,PY,PE,PH,PN,PL,PT,PR,QA,RE,RO,RU,RW,BL,SH,KN,LC,MF,PM,VC,WS,SM,ST,SA,SN,RS,SC,SL,SG,SK,SI,SB,SO,ZA,GS,ES,LK,SD,SR,SJ,SZ,SE,CH,SY,TW,TJ,TZ,TH,TL,TG,TK,TO,TT,TN,TR,TM,TC,TV,UG,UA,AE,GB,US,UM,UY,UZ,VU,VE,VN,VG,VI,WF,EH,YE,ZM,ZW', '', '', NULL),
(37, 'custom', '', 'Bluedart', 0, 1, '', 'AX,AL,DZ,AS,AD,AO,AI,AQ,AG,AR,AM,AW,AU,AT,AZ,BS,BH,BD,BB,BY,BE,BZ,BJ,BM,BT,BO,BA,BW,BV,BR,IO,BN,BG,BF,BI,KH,CM,CA,CV,KY,CF,TD,CL,CN,CX,CC,CO,KM,CG,CD,CK,CR,CI,HR,CU,CY,CZ,DK,DJ,DM,DO,EC,EG,SV,GQ,ER,EE,ET,FK,FO,FJ,FI,FR,GF,PF,TF,GA,GM,GE,DE,GH,GI,GR,GL,GD,GP,GU,GT,GG,GN,GW,GY,HT,HM,VA,HN,HK,HU,IS,IN,ID,IR,IQ,IE,IM,IL,IT,JM,JP,JE,JO,KZ,KE,KI,KR,XK,KW,KG,LA,LV,LB,LS,LR,LY,LI,LT,LU,MO,MK,MG,MW,MY,MV,ML,MT,MH,MQ,MR,MU,YT,MX,FM,MD,MC,MN,ME,MS,MA,MZ,MM,NA,NR,NP,NL,AN,NC,NZ,NI,NE,NG,NU,NF,MP,NO,OM,PK,PW,PS,PA,PG,PY,PE,PH,PN,PL,PT,PR,QA,RE,RO,RU,RW,BL,SH,KN,LC,MF,PM,VC,WS,SM,ST,SA,SN,RS,SC,SL,SG,SK,SI,SB,SO,ZA,GS,ES,LK,SD,SR,SJ,SZ,SE,CH,SY,TW,TJ,TZ,TH,TL,TG,TK,TO,TT,TN,TR,TM,TC,TV,UG,UA,AE,GB,US,UM,UY,UZ,VU,VE,VN,VG,VI,WF,EH,YE,ZM,ZW', '', '', NULL),
(38, 'custom', '', 'Fedex USA', 0, 1, '', 'AX,AL,DZ,AS,AD,AO,AI,AQ,AG,AR,AM,AW,AU,AT,AZ,BS,BH,BD,BB,BY,BE,BZ,BJ,BM,BT,BO,BA,BW,BV,BR,IO,BN,BG,BF,BI,KH,CM,CA,CV,KY,CF,TD,CL,CN,CX,CC,CO,KM,CG,CD,CK,CR,CI,HR,CU,CY,CZ,DK,DJ,DM,DO,EC,EG,SV,GQ,ER,EE,ET,FK,FO,FJ,FI,FR,GF,PF,TF,GA,GM,GE,DE,GH,GI,GR,GL,GD,GP,GU,GT,GG,GN,GW,GY,HT,HM,VA,HN,HK,HU,IS,IN,ID,IR,IQ,IE,IM,IL,IT,JM,JP,JE,JO,KZ,KE,KI,KR,XK,KW,KG,LA,LV,LB,LS,LR,LY,LI,LT,LU,MO,MK,MG,MW,MY,MV,ML,MT,MH,MQ,MR,MU,YT,MX,FM,MD,MC,MN,ME,MS,MA,MZ,MM,NA,NR,NP,NL,AN,NC,NZ,NI,NE,NG,NU,NF,MP,NO,OM,PK,PW,PS,PA,PG,PY,PE,PH,PN,PL,PT,PR,QA,RE,RO,RU,RW,BL,SH,KN,LC,MF,PM,VC,WS,SM,ST,SA,SN,RS,SC,SL,SG,SK,SI,SB,SO,ZA,GS,ES,LK,SD,SR,SJ,SZ,SE,CH,SY,TW,TJ,TZ,TH,TL,TG,TK,TO,TT,TN,TR,TM,TC,TV,UG,UA,AE,GB,US,UM,UY,UZ,VU,VE,VN,VG,VI,WF,EH,YE,ZM,ZW', '', '5-7 Days', NULL),
(39, 'custom', '', 'USPS', 0, 1, '', 'AX,AL,DZ,AS,AD,AO,AI,AQ,AG,AR,AM,AW,AU,AT,AZ,BS,BH,BD,BB,BY,BE,BZ,BJ,BM,BT,BO,BA,BW,BV,BR,IO,BN,BG,BF,BI,KH,CM,CA,CV,KY,CF,TD,CL,CN,CX,CC,CO,KM,CG,CD,CK,CR,CI,HR,CU,CY,CZ,DK,DJ,DM,DO,EC,EG,SV,GQ,ER,EE,ET,FK,FO,FJ,FI,FR,GF,PF,TF,GA,GM,GE,DE,GH,GI,GR,GL,GD,GP,GU,GT,GG,GN,GW,GY,HT,HM,VA,HN,HK,HU,IS,IN,ID,IR,IQ,IE,IM,IL,IT,JM,JP,JE,JO,KZ,KE,KI,KR,XK,KW,KG,LA,LV,LB,LS,LR,LY,LI,LT,LU,MO,MK,MG,MW,MY,MV,ML,MT,MH,MQ,MR,MU,YT,MX,FM,MD,MC,MN,ME,MS,MA,MZ,MM,NA,NR,NP,NL,AN,NC,NZ,NI,NE,NG,NU,NF,MP,NO,OM,PK,PW,PS,PA,PG,PY,PE,PH,PN,PL,PT,PR,QA,RE,RO,RU,RW,BL,SH,KN,LC,MF,PM,VC,WS,SM,ST,SA,SN,RS,SC,SL,SG,SK,SI,SB,SO,ZA,GS,ES,LK,SD,SR,SJ,SZ,SE,CH,SY,TW,TJ,TZ,TH,TL,TG,TK,TO,TT,TN,TR,TM,TC,TV,UG,UA,AE,GB,US,UM,UY,UZ,VU,VE,VN,VG,VI,WF,EH,YE,ZM,ZW', '', '1-5 Days', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_site_settings`
--

CREATE TABLE `tbl_site_settings` (
  `id` int(11) NOT NULL,
  `term_conditions` longtext NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_smsgatewaylog`
--

CREATE TABLE `tbl_smsgatewaylog` (
  `id` int(10) NOT NULL,
  `date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `gateway` mediumtext NOT NULL,
  `data` mediumtext NOT NULL,
  `result` mediumtext NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_smstemplate`
--

CREATE TABLE `tbl_smstemplate` (
  `id` int(11) NOT NULL,
  `name` varchar(555) NOT NULL,
  `message` mediumtext NOT NULL,
  `status` int(1) NOT NULL DEFAULT 0,
  `mass` int(1) NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `tbl_smstemplate`
--

INSERT INTO `tbl_smstemplate` (`id`, `name`, `message`, `status`, `mass`) VALUES
(1, 'When Order Reply (Success/Reject)', 'Your Order Processed {$ORDER} : {$REPLY}', 1, 0),
(2, 'Client password change notification', 'Your password changed  and new password is : {$PASSWORD}', 1, 0),
(3, 'Client mobile number confirmation', 'Your Confirmation code is : {$CODE}', 1, 0),
(4, 'New order notification to admin', 'New order placed for {$SERVICE}', 1, 0),
(5, 'Mass SMS', '', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_smstemplate_language`
--

CREATE TABLE `tbl_smstemplate_language` (
  `id` int(11) NOT NULL,
  `template_id` int(11) NOT NULL DEFAULT 0,
  `language` varchar(555) NOT NULL,
  `message` varchar(1000) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_statement_points`
--

CREATE TABLE `tbl_statement_points` (
  `pointid` int(20) NOT NULL,
  `uid` int(11) DEFAULT 0,
  `cr` decimal(10,2) DEFAULT 0.00,
  `dr` decimal(10,2) DEFAULT 0.00,
  `orderid` int(11) DEFAULT 0,
  `date` date DEFAULT NULL,
  `time` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_statement_supplier`
--

CREATE TABLE `tbl_statement_supplier` (
  `id` int(10) NOT NULL,
  `supplier_id` int(10) NOT NULL,
  `stype` varchar(100) NOT NULL,
  `date` date NOT NULL,
  `time` varchar(25) NOT NULL,
  `description` varchar(555) NOT NULL,
  `type` enum('CR','DR') NOT NULL,
  `amount` varchar(10) NOT NULL,
  `relid` int(10) NOT NULL,
  `sell_credit` int(1) NOT NULL DEFAULT 0,
  `ptype` varchar(100) NOT NULL,
  `note` varchar(1000) NOT NULL,
  `tid` varchar(50) NOT NULL,
  `imei` int(1) NOT NULL DEFAULT 0,
  `file` int(1) NOT NULL DEFAULT 0,
  `server` int(1) NOT NULL DEFAULT 0,
  `shop` int(1) NOT NULL DEFAULT 0,
  `ip` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_statement_user`
--

CREATE TABLE `tbl_statement_user` (
  `id` int(10) NOT NULL,
  `uid` int(10) NOT NULL,
  `stype` varchar(100) NOT NULL,
  `date` date NOT NULL,
  `time` varchar(25) NOT NULL,
  `description` varchar(555) NOT NULL,
  `admin_note` mediumtext NOT NULL,
  `type` enum('CR','DR') NOT NULL,
  `amount` decimal(15,3) NOT NULL,
  `relid` int(10) NOT NULL,
  `adminid` int(11) NOT NULL DEFAULT 0,
  `sell_credit` int(1) NOT NULL DEFAULT 0,
  `imei` int(1) NOT NULL DEFAULT 0,
  `file` int(1) NOT NULL DEFAULT 0,
  `server` int(1) NOT NULL DEFAULT 0,
  `shop` int(1) NOT NULL DEFAULT 0,
  `ip` varchar(50) NOT NULL,
  `user_note` mediumtext NOT NULL,
  `balance` varchar(50) NOT NULL,
  `transferfee` decimal(14,2) DEFAULT 0.00,
  `data` text DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `tbl_statement_user`
--

INSERT INTO `tbl_statement_user` (`id`, `uid`, `stype`, `date`, `time`, `description`, `admin_note`, `type`, `amount`, `relid`, `adminid`, `sell_credit`, `imei`, `file`, `server`, `shop`, `ip`, `user_note`, `balance`, `transferfee`, `data`) VALUES
(1, 1, '', '2023-03-04', '1677976954', '+ Add Funds', '', 'CR', '5.000', 0, 1, 0, 0, 0, 0, 0, '188.80.69.14', '', '5', '0.00', ''),
(2, 1, 'imei', '2023-03-04', '1677976983', 'New Order Placed', '', 'DR', '0.020', 1, 0, 0, 0, 0, 0, 0, '188.80.69.14', '', '4.98', '0.00', '');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_stock`
--

CREATE TABLE `tbl_stock` (
  `id` int(11) NOT NULL,
  `stock_group_id` int(11) NOT NULL DEFAULT 0,
  `info` varchar(1000) NOT NULL,
  `reply_date` varchar(50) NOT NULL,
  `order_id` int(11) NOT NULL DEFAULT 0,
  `date` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_stockgroup`
--

CREATE TABLE `tbl_stockgroup` (
  `id` int(11) NOT NULL,
  `group_name` varchar(255) NOT NULL,
  `stock_notification` int(1) NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_stock_history`
--

CREATE TABLE `tbl_stock_history` (
  `id` int(11) NOT NULL,
  `qnt` int(11) NOT NULL DEFAULT 0,
  `date` varchar(50) NOT NULL,
  `time` varchar(50) NOT NULL,
  `pid` int(11) NOT NULL DEFAULT 0,
  `sid` int(11) NOT NULL DEFAULT 0,
  `note` varchar(1000) NOT NULL,
  `wid` int(11) NOT NULL DEFAULT 0,
  `aid` int(11) NOT NULL DEFAULT 0,
  `status` varchar(25) NOT NULL,
  `remove` int(1) NOT NULL DEFAULT 0,
  `relid` int(11) NOT NULL DEFAULT 0,
  `supplier` int(11) NOT NULL DEFAULT 0,
  `bill_date` varchar(50) NOT NULL,
  `bill_no` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_store_config`
--

CREATE TABLE `tbl_store_config` (
  `uid` int(10) NOT NULL,
  `attribute` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_store_fund_history`
--

CREATE TABLE `tbl_store_fund_history` (
  `id` int(11) NOT NULL,
  `sid` int(11) NOT NULL DEFAULT 0,
  `uid` int(11) NOT NULL DEFAULT 0,
  `tid` varchar(50) NOT NULL,
  `amount` varchar(50) NOT NULL,
  `date` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_store_pages`
--

CREATE TABLE `tbl_store_pages` (
  `uid` int(10) NOT NULL,
  `attribute` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_store_pricing`
--

CREATE TABLE `tbl_store_pricing` (
  `id` int(11) NOT NULL,
  `resellerid` int(11) NOT NULL,
  `serviceid` int(11) NOT NULL,
  `servicetype` varchar(10) NOT NULL,
  `increaseby` varchar(20) NOT NULL,
  `increase` decimal(10,3) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_subscribers`
--

CREATE TABLE `tbl_subscribers` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT 0,
  `type` varchar(155) NOT NULL,
  `service_id` int(11) NOT NULL DEFAULT 0,
  `subscribe_start` varchar(50) NOT NULL,
  `subscribe_end` varchar(50) NOT NULL,
  `count` int(11) NOT NULL DEFAULT 0,
  `status` varchar(255) NOT NULL DEFAULT 'active',
  `used` int(11) NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_supplier`
--

CREATE TABLE `tbl_supplier` (
  `id` int(11) NOT NULL,
  `access_key` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(155) NOT NULL,
  `address` varchar(255) NOT NULL,
  `country` varchar(50) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `userstatus` int(1) NOT NULL DEFAULT 0,
  `enc_login` varchar(255) NOT NULL,
  `last_login` varchar(50) NOT NULL,
  `ac_create_dt` varchar(50) NOT NULL,
  `imei_service_access` int(1) NOT NULL DEFAULT 0,
  `imei_services` mediumtext NOT NULL,
  `file_service_access` int(1) NOT NULL DEFAULT 0,
  `file_services` mediumtext NOT NULL,
  `server_log_access` int(1) NOT NULL DEFAULT 0,
  `server_logs` mediumtext NOT NULL,
  `shop_service_access` varchar(25) NOT NULL,
  `shop_services` varchar(255) NOT NULL,
  `admin` varchar(255) NOT NULL,
  `imei_limit_left` varchar(11) NOT NULL,
  `imei_limit_used` varchar(11) NOT NULL,
  `file_limit_left` varchar(11) NOT NULL,
  `file_limit_used` varchar(11) NOT NULL,
  `server_limit_left` varchar(11) NOT NULL,
  `server_limit_used` varchar(11) NOT NULL,
  `last_notification` varchar(70) NOT NULL,
  `notification` varchar(10) NOT NULL,
  `note` longtext NOT NULL,
  `mywarehouse` int(11) NOT NULL DEFAULT 0,
  `credit` varchar(10) NOT NULL,
  `success` int(11) NOT NULL DEFAULT 0,
  `reject` int(11) NOT NULL DEFAULT 0,
  `logindays` mediumtext NOT NULL,
  `start_time` varchar(255) NOT NULL,
  `end_time` varchar(255) NOT NULL,
  `payoutnotes` text NOT NULL,
  `remote_service_access` int(1) DEFAULT 0,
  `remote_services` mediumtext DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `tbl_supplier`
--

INSERT INTO `tbl_supplier` (`id`, `access_key`, `username`, `first_name`, `last_name`, `password`, `email`, `address`, `country`, `phone`, `userstatus`, `enc_login`, `last_login`, `ac_create_dt`, `imei_service_access`, `imei_services`, `file_service_access`, `file_services`, `server_log_access`, `server_logs`, `shop_service_access`, `shop_services`, `admin`, `imei_limit_left`, `imei_limit_used`, `file_limit_left`, `file_limit_used`, `server_limit_left`, `server_limit_used`, `last_notification`, `notification`, `note`, `mywarehouse`, `credit`, `success`, `reject`, `logindays`, `start_time`, `end_time`, `payoutnotes`, `remote_service_access`, `remote_services`) VALUES
(1, 'c514c91e4ed341f263e458d44b3bb0a7', 'demodemo', '', '', '616e28901427afba7fc1a23f37b9440b', 'demo@demo.com', '', 'US', '55656565656565', 1, '', '', '1677976277', 1, '', 1, '', 1, '', '', '', '1', '', '', '', '', '', '', '', '', '', 0, '', 0, 0, '', '', '', '', 1, '');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_supplier_log`
--

CREATE TABLE `tbl_supplier_log` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `login` varchar(100) NOT NULL,
  `ip` varchar(50) NOT NULL,
  `time` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_supplier_payout`
--

CREATE TABLE `tbl_supplier_payout` (
  `id` int(11) NOT NULL,
  `supplier_id` int(11) NOT NULL DEFAULT 0,
  `credit` varchar(11) NOT NULL,
  `ptype` varchar(100) NOT NULL,
  `note` varchar(1000) NOT NULL,
  `tid` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_support_department`
--

CREATE TABLE `tbl_support_department` (
  `id` int(11) NOT NULL,
  `department` varchar(555) NOT NULL,
  `login` int(1) NOT NULL DEFAULT 0,
  `email` varchar(555) NOT NULL,
  `iconlink` varchar(255) NOT NULL,
  `info` mediumtext NOT NULL,
  `pophost` varchar(555) NOT NULL,
  `popport` varchar(20) NOT NULL,
  `popuser` varchar(555) NOT NULL,
  `poppass` varchar(555) NOT NULL,
  `status` int(1) NOT NULL DEFAULT 0,
  `livehelp` int(1) NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_support_priority`
--

CREATE TABLE `tbl_support_priority` (
  `id` int(11) NOT NULL,
  `priority` varchar(255) NOT NULL,
  `color` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `tbl_support_priority`
--

INSERT INTO `tbl_support_priority` (`id`, `priority`, `color`) VALUES
(1, 'High', '#f35959'),
(3, 'Low', '#CCCCCC'),
(2, 'Medium', '#ffcf7f');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_support_status`
--

CREATE TABLE `tbl_support_status` (
  `id` int(11) NOT NULL,
  `status` varchar(255) NOT NULL,
  `color` varchar(100) NOT NULL,
  `custom` int(1) NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `tbl_support_status`
--

INSERT INTO `tbl_support_status` (`id`, `status`, `color`, `custom`) VALUES
(1, 'Open', '#779500', 0),
(3, 'Answered', '#000000', 0),
(2, 'Close', '#888888', 0),
(4, 'Customer-reply', '#ff6600', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_support_tickets`
--

CREATE TABLE `tbl_support_tickets` (
  `id` int(11) NOT NULL,
  `tid` varchar(255) NOT NULL,
  `uid` int(11) NOT NULL DEFAULT 0,
  `aid` int(11) NOT NULL DEFAULT 0,
  `email` varchar(555) NOT NULL,
  `name` varchar(555) NOT NULL,
  `did` int(11) NOT NULL DEFAULT 0,
  `subject` mediumtext NOT NULL,
  `pid` int(11) NOT NULL DEFAULT 0,
  `sid` int(11) NOT NULL DEFAULT 0,
  `message` mediumtext NOT NULL,
  `attchment` mediumtext NOT NULL,
  `date` datetime NOT NULL,
  `import` int(1) NOT NULL DEFAULT 0,
  `ip` varchar(50) NOT NULL,
  `lastreply` varchar(50) NOT NULL,
  `admin_read` mediumtext NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_survey`
--

CREATE TABLE `tbl_survey` (
  `id` int(11) NOT NULL,
  `title` varchar(555) NOT NULL,
  `detail` mediumtext NOT NULL,
  `status` int(1) NOT NULL DEFAULT 0,
  `captcha` int(1) NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_survey_detail`
--

CREATE TABLE `tbl_survey_detail` (
  `id` int(11) NOT NULL,
  `srid` int(11) NOT NULL DEFAULT 0,
  `uid` int(11) NOT NULL DEFAULT 0,
  `name` varchar(555) NOT NULL,
  `email` varchar(255) NOT NULL,
  `date` varchar(50) NOT NULL,
  `ip` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_suspended_sale`
--

CREATE TABLE `tbl_suspended_sale` (
  `id` int(11) NOT NULL,
  `cid` int(11) NOT NULL DEFAULT 0,
  `pid` varchar(1000) NOT NULL,
  `price` mediumtext NOT NULL,
  `disc` mediumtext NOT NULL,
  `qnt` varchar(1000) NOT NULL,
  `dtype` int(1) NOT NULL DEFAULT 0,
  `date` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_swkey`
--

CREATE TABLE `tbl_swkey` (
  `id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL DEFAULT 0,
  `key` mediumtext NOT NULL,
  `uid` int(11) NOT NULL DEFAULT 0,
  `status` int(1) NOT NULL DEFAULT 0,
  `oid` int(11) NOT NULL DEFAULT 0,
  `date` varchar(50) NOT NULL,
  `expiredon` varchar(50) NOT NULL,
  `addedon` date NOT NULL,
  `qnt` int(11) NOT NULL DEFAULT 0,
  `used` int(11) NOT NULL,
  `code2` text DEFAULT NULL,
  `purchase` decimal(10,2) DEFAULT 0.00
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_system_activity`
--

CREATE TABLE `tbl_system_activity` (
  `id` int(10) NOT NULL,
  `date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `description` mediumtext NOT NULL,
  `user` mediumtext NOT NULL,
  `type` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_tax`
--

CREATE TABLE `tbl_tax` (
  `id` int(10) NOT NULL,
  `level` int(1) NOT NULL DEFAULT 0,
  `name` mediumtext NOT NULL,
  `state` mediumtext NOT NULL,
  `country` mediumtext NOT NULL,
  `taxrate` decimal(10,2) NOT NULL,
  `gateway` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `tbl_tax`
--

INSERT INTO `tbl_tax` (`id`, `level`, `name`, `state`, `country`, `taxrate`, `gateway`) VALUES
(8, 1, 'Gateway fee', '', '', '5.00', '');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_templates`
--

CREATE TABLE `tbl_templates` (
  `id` int(11) NOT NULL,
  `tpl` varchar(555) NOT NULL,
  `name` varchar(555) NOT NULL,
  `group` varchar(255) NOT NULL,
  `info` varchar(1000) NOT NULL,
  `sort` int(6) NOT NULL,
  `shop` int(1) NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `tbl_templates`
--

INSERT INTO `tbl_templates` (`id`, `tpl`, `name`, `group`, `info`, `sort`, `shop`) VALUES
(1, 'client_settings_question', 'Security Question', 'client', 'Security Question Settings', 0, 0),
(2, 'client_contact', 'Item Inquiry', 'client', 'Request for cart item inquiry', 0, 0),
(3, 'client_settings_profile', 'Client Profile', 'client', 'Client Profile management', 0, 0),
(4, 'client_reseller_edituser', 'Edit Resellers User ', 'client', 'Edit Resellers User. Add Credit , profile , set pricing etc', 0, 0),
(5, 'blog', 'Blog', 'system', 'Blog Post', 0, 0),
(6, 'cart_storebanned', 'ResellerStore Message', 'reseller', 'Shopping Cart message for Reseller Store', 0, 0),
(7, 'undermaintanance', 'Under Maintenance ', 'system', 'System Under Maintenance Message', 0, 0),
(8, 'client_order_imei_getservicedetails', 'IMEI Order Details', 'order', 'IMEI Orders Service Details e.g. imei number , Model , Brand , Country , Provider etc', 0, 0),
(9, 'client_settings_emailsetting', 'Email Content', 'client', 'Change Email format , content , restore default template', 0, 0),
(10, 'client_reseller_statement', 'Reseller Statement', 'client', 'Resellers Statement related to credit and his user', 0, 0),
(11, 'client_returnrequest', 'Item Return Request', 'cart', 'Shopping item return request', 0, 0),
(12, 'config.php', 'config.php', 'client', '', 0, 0),
(13, 'client_common_rightmenu', 'Common Rightmenu', 'system', 'After Login Common Menu for Client', 0, 0),
(14, 'client_reseller_shoporder', 'Reseller Shop Commision', 'reseller', 'Userwise earning by shopping order', 0, 0),
(15, 'client_productandservice_rightmenu', 'Products & Services Rightmenu', 'system', 'Before Login Products & Services Rightmenu', 0, 0),
(16, 'viewmail', 'Viewmail', 'client', 'View email from history', 0, 0),
(17, 'client_reseller_imeipricelist', 'Reseller IMEI Pricing', 'reseller', 'Resellers Store IMEI Pricing', 0, 0),
(18, 'client_settings_statement_details', 'Client Statement', 'client', 'Clients detailed statement', 0, 0),
(19, 'cart_item_config', 'Item Add to Cart', 'cart', 'Add to cart Item configuration for Product , IMEI and server', 0, 0),
(20, 'viewinvoice', 'View Invoice', 'client', 'View Invoice', 0, 0),
(21, 'footer', 'Footer', 'system', 'Site Common Footer page', 0, 0),
(22, 'client_settings_gift', 'Send Gift', 'client', 'Send Gift Credit to other client buy it through payment gateway', 0, 0),
(23, 'viewticket', 'View Support Ticket', 'client', 'View Support Ticket', 0, 0),
(24, 'client_reseller_imeiorders', 'Resellers IMEI Order', 'reseller', 'Resellers user IMEI order history', 0, 0),
(25, 'client_search_knowledgebase', 'Knowledge-base Search Result', 'system', 'Knowledge-base Search Result category wise', 0, 0),
(26, 'client_ordersdtl_server', 'Server Order History', 'order', 'Server Order History', 0, 0),
(27, 'client_reseller_myuserorder', 'Reselles User Order', 'reseller', 'Resellers User order (IMEI, File , Server)', 0, 0),
(28, 'client_ordersdtl_imei', 'IMEI Order History', 'order', 'IMEI Order History', 0, 0),
(29, 'cart_dailydeal', 'Daily Deal', 'cart', 'Daily Deal', 0, 0),
(30, 'client_settings_mail', 'Mail History', 'client', 'Client Email History', 0, 0),
(31, 'client_activeaccount', 'Mobile Verification', 'client', 'Verify Client Mobile ', 0, 0),
(32, 'client_feedback', 'Product Feedback', 'cart', 'Client Product Feedback for reseller', 0, 0),
(33, 'client_settings_transfer', 'Transfer Credit', 'client', 'Transfer credit to other client', 0, 0),
(34, 'cart_addon', 'Item Price Cycle', 'cart', 'Pay for Cart Item as cycle annually , semiannually , monthly  ', 0, 0),
(35, 'client_settings_cc', 'Account Credit Card', 'client', 'Reset Credit Card or save Credit Card Details', 0, 0),
(36, 'client_order_server', 'Place Server Order', 'order', 'Place Server Order By group or By Service', 0, 0),
(37, 'newsletter', 'Newsletter', 'system', 'Newsletter Message', 0, 0),
(38, 'client_orderdtl_rightmenu', 'Order Rightmenu', 'order', 'After Login Order history rightmenu', 0, 0),
(39, 'client_feedback_service', 'Retail Shop Feedback', 'cart', 'Customer feedback for retail shopping', 0, 0),
(40, 'client_reseller_myuser', 'Resellers User', 'reseller', 'Reseller User management', 0, 0),
(41, 'cart_checkoutreload', 'Checkout Reload', 'cart', 'Reload shipping charge , promotion etc at checkout', 0, 0),
(42, 'client_settings_logins', 'Client Login IP ', 'client', 'Set IP Range for login', 0, 0),
(43, 'paymentnotice', 'Payment Notice', 'cart', 'Payment Success / Fail Notice after redirected from payment gateway', 0, 0),
(44, 'client_reseller_summary', 'Reseller Store Summary', 'reseller', 'Reseller store summary order status, users , store link etc', 0, 0),
(45, 'client_reseller_serverorders', 'Resellers User Server Order', 'reseller', 'Resellers User server order. User wise filtration ', 0, 0),
(46, 'client_reseller_template', 'Resellers Email Template', 'reseller', 'Resellers email template list for customize', 0, 0),
(47, 'fileservices', 'File service list', 'order', 'Products & Services - File service list', 0, 0),
(48, 'client_vieworder', 'IMEI Order Detail', 'order', 'IMEI Order Details IMEI no , PIN , PRD , Reference , type , Model , Brand , Country , Provider etc', 0, 0),
(49, 'client_reseller_fileservices', 'Reseller Commission for File', 'reseller', 'File Service Commission for store', 0, 0),
(50, 'client_survey', 'Survey', 'system', 'Survey Form', 0, 0),
(51, 'cart2', 'Cart Old', 'cart', 'Old Cart System', 0, 0),
(52, 'client_registration', 'Registration', 'system', 'Client Registration', 0, 0),
(53, 'cart_review', 'Cart Item Review', 'cart', 'Cart Item Review', 0, 0),
(54, 'client_order_imei', 'IMEI Order', 'order', 'Place IMEI Order', 0, 0),
(55, 'client_reseller_setpricing', 'Resellers Service Set Price', 'reseller', 'Resellers Service set pricing main page', 0, 0),
(56, 'client_settings_license', 'Recurring Product License', 'client', 'Recurring items license renewal , expiration time', 0, 0),
(57, 'client_settings_affiliate', 'Product Affiliation', 'client', 'Item Affiliation system commission', 0, 0),
(58, 'client_order_file', 'File Order', 'order', 'Client File Order', 0, 0),
(59, 'client_profile_rightmenu', 'Profile Rightmenu', 'client', 'Client Profile Rightmenu', 0, 0),
(60, 'client_addfunds', 'Add Fund', 'client', 'Client Add fund', 0, 0),
(61, 'client_reseller_fileorders', 'Resellers File Order', 'reseller', 'Resellers File Order for store', 0, 0),
(62, 'knowledgebase', 'Knowledge-base Articles', 'system', 'Knowledge-base Article List ,search article', 0, 0),
(63, 'client_settings_mailnotification', 'Client email Enable/Disable', 'client', 'Enable or disable email notification for client', 0, 0),
(64, 'cms_index', 'CMS Main Page', 'system', 'Custom Page main page', 0, 0),
(65, 'footer-old', 'Old Footer', 'client', '', 0, 0),
(66, 'client_retailorder', 'IMEI Retail Order', 'order', 'Retail order for IMEI', 0, 0),
(67, 'servicelist', 'IMEI Service List/Search', 'system', 'Products and services IMEI Service List and search service from brand model etc', 0, 0),
(68, 'client_reseller_rightmenu', 'Reseller Rightmenu', 'reseller', 'Reseller Right menu', 0, 0),
(69, 'client_order_file_getservicedetails', 'File Order Service Details', 'order', 'Get File service details while place order', 0, 0),
(70, 'client_reseller_imeiservices', 'Resellers IMEI Service List', 'reseller', 'IMEI Service List of Resellers store', 0, 0),
(71, 'client_settings_password', 'Change Password', 'client', 'Client Change Password', 0, 0),
(72, 'cart_checkout', 'Cart Checkout', 'cart', 'Cart  Checkout Page', 0, 0),
(73, 'client_settings_services', 'Client Service List And Status', 'client', 'Clients allowed services and its price', 0, 0),
(74, 'client_news', 'Blog Post', 'system', 'Blog Post / News', 0, 0),
(75, 'client_settings_package', 'Client Subscription List', 'client', 'Client service subscription list', 0, 0),
(76, 'cart_bundle', 'Cart Item Bundle', 'cart', 'Cart Item Bundle', 0, 0),
(77, 'cart_comparelist', 'Cart Item Compare', 'cart', 'Cart Item Compare List', 0, 0),
(78, 'client_settings_pin', 'Client Pin Number', 'client', 'Pin number settings', 0, 0),
(79, 'knowledgebase_rightmenu', 'Knowledge base right menu', 'system', 'Knowledge base Right Menu', 0, 0),
(80, 'cart_view_mini', 'Cart Top View', 'cart', 'Cart top item summary', 0, 0),
(81, 'client_resetpass', 'Forget Password', 'client', 'Client Forget Password', 0, 0),
(82, 'downloadfile', 'Download File', 'system', 'Download FIle', 0, 0),
(83, 'error', 'Error Messages', 'system', 'System Error Messages 404, 401 , 403 , 405,406,500,503', 0, 0),
(84, 'suggestedprice', 'Suggested Price', 'cart', 'Shopping cart suggested price', 0, 0),
(85, 'client_reseller_usersorder', 'Resellers User Order', 'reseller', 'Resellers Store order of his user', 0, 0),
(86, 'client_shoporders', 'Shop Order List', 'cart', 'Shopping cart order list and status', 0, 0),
(87, 'client_search_products', 'Search Product', 'cart', 'Search Products', 0, 0),
(88, 'client_directorder_imei', 'IMEI Direct Order', 'order', 'IMEI Direct order from link', 0, 0),
(89, 'compareproduct', 'Product Features Comparision', 'cart', 'Cart Products features comparision', 0, 0),
(90, 'client_reseller_overview', 'Reseller store Overview', 'reseller', 'Resellers store overview / dashboard', 0, 0),
(91, 'client_settings_voucher', 'Credit Voucher', 'client', 'Redeem Credit Voucher', 0, 0),
(92, 'client_order_server_getservicedetails', 'Server Order Details', 'order', 'Server service get details while place order', 0, 0),
(93, 'client_order_product_getservicedetails', 'Product Order Details', 'cart', 'Products get details while buy', 0, 0),
(94, 'header', 'Site Header', 'system', 'Site common Header', 0, 0),
(95, 'client_reseller_mysubuser', 'Resellers Regular User', 'reseller', 'Resellers User for regular system', 0, 0),
(96, 'client_mobileverify', 'Mobile Verification ', 'client', 'Client Mobile verification', 0, 0),
(97, 'trackservice', 'Track Order', 'order', 'Track order by id without login', 0, 0),
(98, 'client_shoppingorder', 'Shop Order List', 'cart', 'Client Shop Order List and filter', 0, 0),
(99, 'client_login_log', 'Client Login Log', 'client', 'Login Log', 0, 0),
(100, 'download_rightmenu', 'Downloads Rightmenu', 'system', 'Downloads category / Rightmenu', 0, 0),
(101, 'style.css.php', 'style.css.php', 'client', '', 0, 0),
(102, 'cart_getfeatures', 'Item Features', 'cart', 'Cart Item Features List', 0, 0),
(103, 'testimonial', 'Testimonial', 'system', 'Add Testimonial and list testimonial', 0, 0),
(104, 'client_settings_invoice', 'Invoice List', 'client', 'Client Invoice List', 0, 0),
(105, 'client_viewgroup', 'Client Group Status', 'client', 'Client group for client area', 0, 0),
(106, 'client_settings_myorder', 'Client Orders Main page', 'client', '', 0, 0),
(107, 'client_getservice_groupwise', 'IMEI service group Order', 'order', 'List service by order for IMEI ', 0, 0),
(108, 'client_reseller_payout', 'Reseller Payout', 'reseller', 'Resellers Payout', 0, 0),
(109, 'serverservices', 'Server service list', 'system', 'Server services for Products and services', 0, 0),
(110, 'client_settings_support', 'Support Ticket', 'client', 'Client Support Ticket', 0, 0),
(111, 'client_reseller_imeipricing', 'Reseller IMEI Pricing', 'reseller', 'Reseller IMEI Pricing for store', 0, 0),
(112, 'client_reseller_editemail', 'Reseller Customize Email', 'reseller', 'Customize Email for store', 0, 0),
(113, 'client_vieworderproduct', 'View Product Order Detail', 'client', 'View Product orders details', 0, 0),
(114, 'cart_wishlist', 'Wishlist', 'cart', 'Cart Item wishlist', 0, 0),
(115, 'client_reseller_pricelist', 'Reseller Pricelist Main', 'reseller', 'Reseller Price list main tab page ', 0, 0),
(116, 'client_reseller_services', 'Resellers Services Main', 'reseller', 'Resellers allowed service main tab page', 0, 0),
(117, 'cart_view', 'Cart View', 'cart', 'View Cart Summary', 0, 0),
(118, 'login', 'Login', 'system', 'Client Login', 0, 0),
(119, 'client_settings_subscription', 'Item Subscription', 'client', 'Client Item subscription', 0, 0),
(120, 'client_settings_myservices', 'Clients Service Main page', 'client', 'Clients allowed services main tab page', 0, 0),
(121, 'loginoptions', 'Login Options', 'system', 'Site Login options facebook , google', 0, 0),
(122, 'client_logout', 'Logout', 'system', '', 0, 0),
(123, 'cart', 'Cart Main Page', 'cart', 'Cart display items', 0, 0),
(124, 'client_reseller_addcredit', 'Reseller Add Credit', 'reseller', 'Add Credit to resellers user', 0, 0),
(125, 'client_reseller_fund', 'Resellers user fund', 'reseller', 'Resellers user fund summary', 0, 0),
(126, 'client_settings_tmppass', 'Generate Temporary Password', 'client', 'Client Temporary Password', 0, 0),
(127, 'cart_videos', 'Cart Videos', 'cart', 'Shopping Cart Youtube Videos', 0, 0),
(128, 'cart_rightmenu', 'Cart Rightmenu', 'cart', 'Shopping Cart Category Menu', 0, 0),
(129, 'client_reseller_setting', 'Resellers Store Manage', 'reseller', 'Resellers Store management Custom page , System emails, index content', 0, 0),
(130, 'client_reseller_store', 'Store Setup', 'reseller', 'Reseller Store setup', 0, 0),
(131, 'client_settings_statement', 'Client Statement', 'client', 'Client statement', 0, 0),
(132, 'client_settings_withdrawal', 'Withdrawal request', 'client', 'Credit withdrawal request', 0, 0),
(133, 'toc', 'Terms & Conditions', 'system', 'Terms & Conditions', 0, 0),
(134, 'index_', 'index_', 'client', '', 0, 0),
(135, 'client_vieworderfile', 'File Order detail', 'order', 'File Order details for order history', 0, 0),
(136, 'client_reseller_serverpricing', 'Reseller Server pricing', 'reseller', 'Resellers store server service pricing', 0, 0),
(137, 'cart_buy_addon', 'Cart Buy Addon', 'cart', 'Buy Addon', 0, 0),
(138, 'client_reseller_product', 'Reseller product commision', 'reseller', 'Reseller commission for store', 0, 0),
(139, 'client_shoporderdetail', 'Shop Order detail', 'order', 'Shop Order detail/reorder', 0, 0),
(140, 'cart_quick_view', 'Cart Quick View', 'cart', 'Cart Quick View', 0, 0),
(141, 'client_settings_affiliateitem', 'Affiliate Iitems', 'client', 'Affiliate items generate code', 0, 0),
(142, 'imeiservices', 'IMEI Services', 'system', 'Products and services IMEI service', 0, 0),
(143, 'cart_recentview', 'Recent Product', 'cart', 'Recently Viewed Products', 0, 0),
(144, 'client_accessdenied', 'Client Access Denied', 'client', 'Access denied for restricted page or access', 0, 0),
(145, 'client_ordersdtl_product', 'Shop Order detail', 'order', 'Get detail of shop order', 0, 0),
(146, 'client_reseller_emailsettings', 'Reseller Email Settings', 'reseller', 'Email settings SMTP or Php , templates management', 0, 0),
(147, 'client_reseller_adduser', 'Add new user', 'reseller', 'Add new user to reseller account', 0, 0),
(148, 'client_reseller_orders', 'Resellers Order main page', 'reseller', 'Resellers orders main page', 0, 0),
(149, 'client_reseller_filepricing', 'Reseller File Pricing', 'reseller', 'File Pricing for store', 0, 0),
(150, 'cart_productinfo', 'Cart Products Info', 'cart', 'Cart Products info on detail page', 0, 0),
(151, 'homepagegroup', 'Cart Home Page Group', 'cart', 'Home Page Group of Products', 0, 0),
(152, 'client_reseller_smtp', 'Reselelr SMTP Settings', 'reseller', 'SMTP enable disable and settings', 0, 0),
(153, 'client_reseller_shoporders', 'Reseller shop order', 'reseller', 'Resellers store shop order list', 0, 0),
(154, 'client_order_imei_groupwise', 'IMEI Order Goupwise', 'client', 'Gropuwise IMEI Order', 0, 0),
(155, 'client_reseller_index', 'Store Index Content', 'reseller', 'Resellers store Index content', 0, 0),
(156, 'client_signup_rightmenu', 'Signup Rightmenu', 'system', 'Signup/Registration Rightmenu', 0, 0),
(157, 'client_order_rightmenu', 'Order Rightmenu', 'client', 'Order Right menu IMEI,File and server order', 0, 0),
(158, 'cart_extraimages', 'Cart Extra Images', 'cart', 'Cart Extra images', 0, 0),
(159, 'client_reseller_serverservices', 'Reseller server services', 'reseller', 'Reseller store server services', 0, 0),
(160, 'client_vieworderserver', 'Server Order detail', 'order', 'Server order details custom field etc', 0, 0),
(161, 'client_home', 'Clientarea Page', 'client', 'Client area - client summary , orders ', 0, 0),
(162, 'client_ordersdtl_file', 'File Order detail', 'order', 'File order details for history', 0, 0),
(163, 'client_export', 'Export Order', 'order', 'Export orders to excel', 0, 0),
(164, 'hotdeal', 'Hot Deal', 'cart', 'Hot Deal', 0, 0),
(165, 'client_viewinvoice', 'View Invoice', 'client', 'View invoice', 0, 0),
(166, 'index', 'Home/Index', 'system', 'Site First Page', 0, 0),
(167, 'searchservices', 'Search services', 'system', 'Search services in products and services', 0, 0),
(168, 'client_settings_tickets', 'Support Ticket List', 'client', 'Support Ticket List', 0, 0),
(169, 'support', 'Support Department', 'client', 'Select Support Department to place ticket', 0, 0),
(170, 'client_settings_other', 'Shipping Detail', 'cart', 'Shipping details', 0, 0),
(171, 'client_template_images', 'Client Menu Icon', 'client', 'Client menu icons', 0, 0),
(172, 'twitterfeed', 'Twitter Feed', 'system', 'Twitter Feed', 0, 0),
(173, 'client_settings_api', 'API Settings', 'client', 'Client API renew / settings', 0, 0),
(174, 'header-old', 'header-old', 'client', '', 0, 0),
(175, 'cart/default/cart_checkout', 'Checkout', 'Cart Default', 'Cart Checkout Default style', 0, 0),
(176, 'cart/default/cart_view', 'Cart View Detail', 'Cart Default', 'Cart View details', 0, 0),
(177, 'cart/default/cart_view_mini', 'Top cart summary', 'Cart Default', 'Cart Top summary for items and pricing', 0, 0),
(178, 'cart/SingalPage/cart_checkout', 'Checkout', 'Cart Single Page', 'Cart Checkout Default style', 0, 0),
(179, 'cart/SingalPage/cart_view', 'Cart View Detail', 'Cart Single Page', 'Cart View details', 0, 0),
(180, 'cart/SingalPage/cart_view_mini', 'Top cart summary', 'Cart Single Page', 'Cart Top summary for items and pricing', 0, 0),
(181, 'cart/Steps/cart_checkout', 'Checkout', 'Cart Steps', 'Cart Checkout Default style', 0, 0),
(182, 'cart/Steps/cart_view', 'Cart View Detail', 'Cart Steps', 'Cart View details', 0, 0),
(183, 'cart/Steps/cart_view_mini', 'Top cart summary', 'Cart Steps', 'Cart Top summary for items and pricing', 0, 0),
(184, 'css/main.css', 'Main CSS', 'css', 'Main css', 0, 0),
(185, 'css/style.css', 'Style CSS', 'css', 'design class', 0, 0),
(186, 'css/theme.css', 'Theme CSS', 'css', 'Template css', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_testimonial`
--

CREATE TABLE `tbl_testimonial` (
  `id` int(11) NOT NULL,
  `author` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `comment` mediumtext NOT NULL,
  `date` date NOT NULL,
  `status` varchar(255) NOT NULL,
  `ip` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_theme`
--

CREATE TABLE `tbl_theme` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `cloud` int(11) NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_timezone_1`
--

CREATE TABLE `tbl_timezone_1` (
  `Name` char(64) NOT NULL,
  `Time_zone_id` int(10) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci COMMENT='Time zone names';

--
-- Dumping data for table `tbl_timezone_1`
--

INSERT INTO `tbl_timezone_1` (`Name`, `Time_zone_id`) VALUES
('Africa/Abidjan', 1),
('Africa/Accra', 2),
('Africa/Addis_Ababa', 3),
('Africa/Algiers', 4),
('Africa/Asmara', 5),
('Africa/Asmera', 6),
('Africa/Bamako', 7),
('Africa/Bangui', 8),
('Africa/Banjul', 9),
('Africa/Bissau', 10),
('Africa/Blantyre', 11),
('Africa/Brazzaville', 12),
('Africa/Bujumbura', 13),
('Africa/Cairo', 14),
('Africa/Casablanca', 15),
('Africa/Ceuta', 16),
('Africa/Conakry', 17),
('Africa/Dakar', 18),
('Africa/Dar_es_Salaam', 19),
('Africa/Djibouti', 20),
('Africa/Douala', 21),
('Africa/El_Aaiun', 22),
('Africa/Freetown', 23),
('Africa/Gaborone', 24),
('Africa/Harare', 25),
('Africa/Johannesburg', 26),
('Africa/Kampala', 27),
('Africa/Khartoum', 28),
('Africa/Kigali', 29),
('Africa/Kinshasa', 30),
('Africa/Lagos', 31),
('Africa/Libreville', 32),
('Africa/Lome', 33),
('Africa/Luanda', 34),
('Africa/Lubumbashi', 35),
('Africa/Lusaka', 36),
('Africa/Malabo', 37),
('Africa/Maputo', 38),
('Africa/Maseru', 39),
('Africa/Mbabane', 40),
('Africa/Mogadishu', 41),
('Africa/Monrovia', 42),
('Africa/Nairobi', 43),
('Africa/Ndjamena', 44),
('Africa/Niamey', 45),
('Africa/Nouakchott', 46),
('Africa/Ouagadougou', 47),
('Africa/Porto-Novo', 48),
('Africa/Sao_Tome', 49),
('Africa/Timbuktu', 50),
('Africa/Tripoli', 51),
('Africa/Tunis', 52),
('Africa/Windhoek', 53),
('America/Adak', 54),
('America/Anchorage', 55),
('America/Anguilla', 56),
('America/Antigua', 57),
('America/Araguaina', 58),
('America/Argentina/Buenos_Aires', 59),
('America/Argentina/Catamarca', 60),
('America/Argentina/ComodRivadavia', 61),
('America/Argentina/Cordoba', 62),
('America/Argentina/Jujuy', 63),
('America/Argentina/La_Rioja', 64),
('America/Argentina/Mendoza', 65),
('America/Argentina/Rio_Gallegos', 66),
('America/Argentina/Salta', 67),
('America/Argentina/San_Juan', 68),
('America/Argentina/San_Luis', 69),
('America/Argentina/Tucuman', 70),
('America/Argentina/Ushuaia', 71),
('America/Aruba', 72),
('America/Asuncion', 73),
('America/Atikokan', 74),
('America/Atka', 75),
('America/Bahia', 76),
('America/Barbados', 77),
('America/Belem', 78),
('America/Belize', 79),
('America/Blanc-Sablon', 80),
('America/Boa_Vista', 81),
('America/Bogota', 82),
('America/Boise', 83),
('America/Buenos_Aires', 84),
('America/Cambridge_Bay', 85),
('America/Campo_Grande', 86),
('America/Cancun', 87),
('America/Caracas', 88),
('America/Catamarca', 89),
('America/Cayenne', 90),
('America/Cayman', 91),
('America/Chicago', 92),
('America/Chihuahua', 93),
('America/Coral_Harbour', 94),
('America/Cordoba', 95),
('America/Costa_Rica', 96),
('America/Cuiaba', 97),
('America/Curacao', 98),
('America/Danmarkshavn', 99),
('America/Dawson', 100),
('America/Dawson_Creek', 101),
('America/Denver', 102),
('America/Detroit', 103),
('America/Dominica', 104),
('America/Edmonton', 105),
('America/Eirunepe', 106),
('America/El_Salvador', 107),
('America/Ensenada', 108),
('America/Fort_Wayne', 109),
('America/Fortaleza', 110),
('America/Glace_Bay', 111),
('America/Godthab', 112),
('America/Goose_Bay', 113),
('America/Grand_Turk', 114),
('America/Grenada', 115),
('America/Guadeloupe', 116),
('America/Guatemala', 117),
('America/Guayaquil', 118),
('America/Guyana', 119),
('America/Halifax', 120),
('America/Havana', 121),
('America/Hermosillo', 122),
('America/Indiana/Indianapolis', 123),
('America/Indiana/Knox', 124),
('America/Indiana/Marengo', 125),
('America/Indiana/Petersburg', 126),
('America/Indiana/Tell_City', 127),
('America/Indiana/Vevay', 128),
('America/Indiana/Vincennes', 129),
('America/Indiana/Winamac', 130),
('America/Indianapolis', 131),
('America/Inuvik', 132),
('America/Iqaluit', 133),
('America/Jamaica', 134),
('America/Jujuy', 135),
('America/Juneau', 136),
('America/Kentucky/Louisville', 137),
('America/Kentucky/Monticello', 138),
('America/Knox_IN', 139),
('America/La_Paz', 140),
('America/Lima', 141),
('America/Los_Angeles', 142),
('America/Louisville', 143),
('America/Maceio', 144),
('America/Managua', 145),
('America/Manaus', 146),
('America/Marigot', 147),
('America/Martinique', 148),
('America/Mazatlan', 149),
('America/Mendoza', 150),
('America/Menominee', 151),
('America/Merida', 152),
('America/Mexico_City', 153),
('America/Miquelon', 154),
('America/Moncton', 155),
('America/Monterrey', 156),
('America/Montevideo', 157),
('America/Montreal', 158),
('America/Montserrat', 159),
('America/Nassau', 160),
('America/New_York', 161),
('America/Nipigon', 162),
('America/Nome', 163),
('America/Noronha', 164),
('America/North_Dakota/Center', 165),
('America/North_Dakota/New_Salem', 166),
('America/Panama', 167),
('America/Pangnirtung', 168),
('America/Paramaribo', 169),
('America/Phoenix', 170),
('America/Port-au-Prince', 171),
('America/Port_of_Spain', 172),
('America/Porto_Acre', 173),
('America/Porto_Velho', 174),
('America/Puerto_Rico', 175),
('America/Rainy_River', 176),
('America/Rankin_Inlet', 177),
('America/Recife', 178),
('America/Regina', 179),
('America/Resolute', 180),
('America/Rio_Branco', 181),
('America/Rosario', 182),
('America/Santarem', 183),
('America/Santiago', 184),
('America/Santo_Domingo', 185),
('America/Sao_Paulo', 186),
('America/Scoresbysund', 187),
('America/Shiprock', 188),
('America/St_Barthelemy', 189),
('America/St_Johns', 190),
('America/St_Kitts', 191),
('America/St_Lucia', 192),
('America/St_Thomas', 193),
('America/St_Vincent', 194),
('America/Swift_Current', 195),
('America/Tegucigalpa', 196),
('America/Thule', 197),
('America/Thunder_Bay', 198),
('America/Tijuana', 199),
('America/Toronto', 200),
('America/Tortola', 201),
('America/Vancouver', 202),
('America/Virgin', 203),
('America/Whitehorse', 204),
('America/Winnipeg', 205),
('America/Yakutat', 206),
('America/Yellowknife', 207),
('Antarctica/Casey', 208),
('Antarctica/Davis', 209),
('Antarctica/DumontDUrville', 210),
('Antarctica/Mawson', 211),
('Antarctica/McMurdo', 212),
('Antarctica/Palmer', 213),
('Antarctica/Rothera', 214),
('Antarctica/South_Pole', 215),
('Antarctica/Syowa', 216),
('Antarctica/Vostok', 217),
('Arctic/Longyearbyen', 218),
('Asia/Aden', 219),
('Asia/Almaty', 220),
('Asia/Amman', 221),
('Asia/Anadyr', 222),
('Asia/Aqtau', 223),
('Asia/Aqtobe', 224),
('Asia/Ashgabat', 225),
('Asia/Ashkhabad', 226),
('Asia/Baghdad', 227),
('Asia/Bahrain', 228),
('Asia/Baku', 229),
('Asia/Bangkok', 230),
('Asia/Beirut', 231),
('Asia/Bishkek', 232),
('Asia/Brunei', 233),
('Asia/Calcutta', 234),
('Asia/Choibalsan', 235),
('Asia/Chongqing', 236),
('Asia/Chungking', 237),
('Asia/Colombo', 238),
('Asia/Dacca', 239),
('Asia/Damascus', 240),
('Asia/Dhaka', 241),
('Asia/Dili', 242),
('Asia/Dubai', 243),
('Asia/Dushanbe', 244),
('Asia/Gaza', 245),
('Asia/Harbin', 246),
('Asia/Ho_Chi_Minh', 247),
('Asia/Hong_Kong', 248),
('Asia/Hovd', 249),
('Asia/Irkutsk', 250),
('Asia/Istanbul', 251),
('Asia/Jakarta', 252),
('Asia/Jayapura', 253),
('Asia/Jerusalem', 254),
('Asia/Kabul', 255),
('Asia/Kamchatka', 256),
('Asia/Karachi', 257),
('Asia/Kashgar', 258),
('Asia/Kathmandu', 259),
('Asia/Katmandu', 260),
('Asia/Kolkata', 261),
('Asia/Krasnoyarsk', 262),
('Asia/Kuala_Lumpur', 263),
('Asia/Kuching', 264),
('Asia/Kuwait', 265),
('Asia/Macao', 266),
('Asia/Macau', 267),
('Asia/Magadan', 268),
('Asia/Makassar', 269),
('Asia/Manila', 270),
('Asia/Muscat', 271),
('Asia/Nicosia', 272),
('Asia/Novosibirsk', 273),
('Asia/Omsk', 274),
('Asia/Oral', 275),
('Asia/Phnom_Penh', 276),
('Asia/Pontianak', 277),
('Asia/Pyongyang', 278),
('Asia/Qatar', 279),
('Asia/Qyzylorda', 280),
('Asia/Rangoon', 281),
('Asia/Riyadh', 282),
('Asia/Saigon', 283),
('Asia/Sakhalin', 284),
('Asia/Samarkand', 285),
('Asia/Seoul', 286),
('Asia/Shanghai', 287),
('Asia/Singapore', 288),
('Asia/Taipei', 289),
('Asia/Tashkent', 290),
('Asia/Tbilisi', 291),
('Asia/Tehran', 292),
('Asia/Tel_Aviv', 293),
('Asia/Thimbu', 294),
('Asia/Thimphu', 295),
('Asia/Tokyo', 296),
('Asia/Ujung_Pandang', 297),
('Asia/Ulaanbaatar', 298),
('Asia/Ulan_Bator', 299),
('Asia/Urumqi', 300),
('Asia/Vientiane', 301),
('Asia/Vladivostok', 302),
('Asia/Yakutsk', 303),
('Asia/Yekaterinburg', 304),
('Asia/Yerevan', 305),
('Atlantic/Azores', 306),
('Atlantic/Bermuda', 307),
('Atlantic/Canary', 308),
('Atlantic/Cape_Verde', 309),
('Atlantic/Faeroe', 310),
('Atlantic/Faroe', 311),
('Atlantic/Jan_Mayen', 312),
('Atlantic/Madeira', 313),
('Atlantic/Reykjavik', 314),
('Atlantic/South_Georgia', 315),
('Atlantic/St_Helena', 316),
('Atlantic/Stanley', 317),
('Australia/ACT', 318),
('Australia/Adelaide', 319),
('Australia/Brisbane', 320),
('Australia/Broken_Hill', 321),
('Australia/Canberra', 322),
('Australia/Currie', 323),
('Australia/Darwin', 324),
('Australia/Eucla', 325),
('Australia/Hobart', 326),
('Australia/LHI', 327),
('Australia/Lindeman', 328),
('Australia/Lord_Howe', 329),
('Australia/Melbourne', 330),
('Australia/NSW', 331),
('Australia/North', 332),
('Australia/Perth', 333),
('Australia/Queensland', 334),
('Australia/South', 335),
('Australia/Sydney', 336),
('Australia/Tasmania', 337),
('Australia/Victoria', 338),
('Australia/West', 339),
('Australia/Yancowinna', 340),
('Brazil/Acre', 341),
('Brazil/DeNoronha', 342),
('Brazil/East', 343),
('Brazil/West', 344),
('CET', 345),
('CST6CDT', 346),
('Canada/Atlantic', 347),
('Canada/Central', 348),
('Canada/East-Saskatchewan', 349),
('Canada/Eastern', 350),
('Canada/Mountain', 351),
('Canada/Newfoundland', 352),
('Canada/Pacific', 353),
('Canada/Saskatchewan', 354),
('Canada/Yukon', 355),
('Chile/Continental', 356),
('Chile/EasterIsland', 357),
('Cuba', 358),
('EET', 359),
('EST', 360),
('EST5EDT', 361),
('Egypt', 362),
('Eire', 363),
('Etc/GMT', 364),
('Etc/GMT+0', 365),
('Etc/GMT+1', 366),
('Etc/GMT+10', 367),
('Etc/GMT+11', 368),
('Etc/GMT+12', 369),
('Etc/GMT+2', 370),
('Etc/GMT+3', 371),
('Etc/GMT+4', 372),
('Etc/GMT+5', 373),
('Etc/GMT+6', 374),
('Etc/GMT+7', 375),
('Etc/GMT+8', 376),
('Etc/GMT+9', 377),
('Etc/GMT-0', 378),
('Etc/GMT-1', 379),
('Etc/GMT-10', 380),
('Etc/GMT-11', 381),
('Etc/GMT-12', 382),
('Etc/GMT-13', 383),
('Etc/GMT-14', 384),
('Etc/GMT-2', 385),
('Etc/GMT-3', 386),
('Etc/GMT-4', 387),
('Etc/GMT-5', 388),
('Etc/GMT-6', 389),
('Etc/GMT-7', 390),
('Etc/GMT-8', 391),
('Etc/GMT-9', 392),
('Etc/GMT0', 393),
('Etc/Greenwich', 394),
('Etc/UCT', 395),
('Etc/UTC', 396),
('Etc/Universal', 397),
('Etc/Zulu', 398),
('Europe/Amsterdam', 399),
('Europe/Andorra', 400),
('Europe/Athens', 401),
('Europe/Belfast', 402),
('Europe/Belgrade', 403),
('Europe/Berlin', 404),
('Europe/Bratislava', 405),
('Europe/Brussels', 406),
('Europe/Bucharest', 407),
('Europe/Budapest', 408),
('Europe/Chisinau', 409),
('Europe/Copenhagen', 410),
('Europe/Dublin', 411),
('Europe/Gibraltar', 412),
('Europe/Guernsey', 413),
('Europe/Helsinki', 414),
('Europe/Isle_of_Man', 415),
('Europe/Istanbul', 416),
('Europe/Jersey', 417),
('Europe/Kaliningrad', 418),
('Europe/Kiev', 419),
('Europe/Lisbon', 420),
('Europe/Ljubljana', 421),
('Europe/London', 422),
('Europe/Luxembourg', 423),
('Europe/Madrid', 424),
('Europe/Malta', 425),
('Europe/Mariehamn', 426),
('Europe/Minsk', 427),
('Europe/Monaco', 428),
('Europe/Moscow', 429),
('Europe/Nicosia', 430),
('Europe/Oslo', 431),
('Europe/Paris', 432),
('Europe/Podgorica', 433),
('Europe/Prague', 434),
('Europe/Riga', 435),
('Europe/Rome', 436),
('Europe/Samara', 437),
('Europe/San_Marino', 438),
('Europe/Sarajevo', 439),
('Europe/Simferopol', 440),
('Europe/Skopje', 441),
('Europe/Sofia', 442),
('Europe/Stockholm', 443),
('Europe/Tallinn', 444),
('Europe/Tirane', 445),
('Europe/Tiraspol', 446),
('Europe/Uzhgorod', 447),
('Europe/Vaduz', 448),
('Europe/Vatican', 449),
('Europe/Vienna', 450),
('Europe/Vilnius', 451),
('Europe/Volgograd', 452),
('Europe/Warsaw', 453),
('Europe/Zagreb', 454),
('Europe/Zaporozhye', 455),
('Europe/Zurich', 456),
('Factory', 457),
('GB', 458),
('GB-Eire', 459),
('GMT', 460),
('GMT+0', 461),
('GMT-0', 462),
('GMT0', 463),
('Greenwich', 464),
('HST', 465),
('Hongkong', 466),
('Iceland', 467),
('Indian/Antananarivo', 468),
('Indian/Chagos', 469),
('Indian/Christmas', 470),
('Indian/Cocos', 471),
('Indian/Comoro', 472),
('Indian/Kerguelen', 473),
('Indian/Mahe', 474),
('Indian/Maldives', 475),
('Indian/Mauritius', 476),
('Indian/Mayotte', 477),
('Indian/Reunion', 478),
('Iran', 479),
('Israel', 480),
('Jamaica', 481),
('Japan', 482),
('Kwajalein', 483),
('Libya', 484),
('MET', 485),
('MST', 486),
('MST7MDT', 487),
('Mexico/BajaNorte', 488),
('Mexico/BajaSur', 489),
('Mexico/General', 490),
('NZ', 491),
('NZ-CHAT', 492),
('Navajo', 493),
('PRC', 494),
('PST8PDT', 495),
('Pacific/Apia', 496),
('Pacific/Auckland', 497),
('Pacific/Chatham', 498),
('Pacific/Easter', 499),
('Pacific/Efate', 500),
('Pacific/Enderbury', 501),
('Pacific/Fakaofo', 502),
('Pacific/Fiji', 503),
('Pacific/Funafuti', 504),
('Pacific/Galapagos', 505),
('Pacific/Gambier', 506),
('Pacific/Guadalcanal', 507),
('Pacific/Guam', 508),
('Pacific/Honolulu', 509),
('Pacific/Johnston', 510),
('Pacific/Kiritimati', 511),
('Pacific/Kosrae', 512),
('Pacific/Kwajalein', 513),
('Pacific/Majuro', 514),
('Pacific/Marquesas', 515),
('Pacific/Midway', 516),
('Pacific/Nauru', 517),
('Pacific/Niue', 518),
('Pacific/Norfolk', 519),
('Pacific/Noumea', 520),
('Pacific/Pago_Pago', 521),
('Pacific/Palau', 522),
('Pacific/Pitcairn', 523),
('Pacific/Ponape', 524),
('Pacific/Port_Moresby', 525),
('Pacific/Rarotonga', 526),
('Pacific/Saipan', 527),
('Pacific/Samoa', 528),
('Pacific/Tahiti', 529),
('Pacific/Tarawa', 530),
('Pacific/Tongatapu', 531),
('Pacific/Truk', 532),
('Pacific/Wake', 533),
('Pacific/Wallis', 534),
('Pacific/Yap', 535),
('Poland', 536),
('Portugal', 537),
('ROC', 538),
('ROK', 539),
('Singapore', 540),
('Turkey', 541),
('UCT', 542),
('US/Alaska', 543),
('US/Aleutian', 544),
('US/Arizona', 545),
('US/Central', 546),
('US/East-Indiana', 547),
('US/Eastern', 548),
('US/Hawaii', 549),
('US/Indiana-Starke', 550),
('US/Michigan', 551),
('US/Mountain', 552),
('US/Pacific', 553),
('US/Pacific-New', 554),
('US/Samoa', 555),
('UTC', 556),
('Universal', 557),
('W-SU', 558),
('WET', 559),
('Zulu', 560);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_tmp`
--

CREATE TABLE `tbl_tmp` (
  `id` int(11) NOT NULL,
  `data` mediumtext NOT NULL,
  `uniqueid` varchar(100) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_tmpconfiger`
--

CREATE TABLE `tbl_tmpconfiger` (
  `id` int(11) NOT NULL,
  `attribute` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_transaction`
--

CREATE TABLE `tbl_transaction` (
  `id` int(10) NOT NULL,
  `userid` int(10) NOT NULL,
  `currency` int(10) NOT NULL,
  `gateway` mediumtext NOT NULL,
  `date` datetime DEFAULT NULL,
  `description` mediumtext NOT NULL,
  `amountin` decimal(10,2) NOT NULL DEFAULT 0.00,
  `fees` decimal(10,2) NOT NULL DEFAULT 0.00,
  `amountout` decimal(10,2) NOT NULL DEFAULT 0.00,
  `rate` decimal(10,5) NOT NULL DEFAULT 1.00000,
  `transid` mediumtext NOT NULL,
  `invoiceid` int(10) NOT NULL DEFAULT 0,
  `refundid` int(10) NOT NULL DEFAULT 0,
  `adminid` int(11) NOT NULL DEFAULT 0,
  `note` varchar(2000) NOT NULL,
  `payerid` varchar(250) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_used_key`
--

CREATE TABLE `tbl_used_key` (
  `id` int(11) NOT NULL,
  `userid` int(11) NOT NULL DEFAULT 0,
  `orderid` int(11) NOT NULL DEFAULT 0,
  `type` varchar(50) NOT NULL,
  `keyid` int(11) NOT NULL DEFAULT 0,
  `qnt` int(5) NOT NULL DEFAULT 0,
  `date` date NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user_gateway`
--

CREATE TABLE `tbl_user_gateway` (
  `id` int(11) NOT NULL,
  `userid` int(11) NOT NULL DEFAULT 0,
  `payment` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_visitors`
--

CREATE TABLE `tbl_visitors` (
  `id` int(11) NOT NULL,
  `visitor` varchar(555) NOT NULL,
  `title` varchar(555) NOT NULL,
  `sessionid` varchar(250) NOT NULL,
  `uid` int(11) NOT NULL DEFAULT 0,
  `ip` varchar(50) NOT NULL,
  `status` varchar(255) NOT NULL,
  `time` varchar(50) NOT NULL,
  `referalurl` varchar(555) NOT NULL,
  `url` mediumtext NOT NULL,
  `invite` int(1) NOT NULL DEFAULT 0,
  `invite_msg` mediumtext NOT NULL,
  `os` varchar(255) NOT NULL,
  `browser` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_voucher`
--

CREATE TABLE `tbl_voucher` (
  `id` int(11) NOT NULL,
  `code` mediumtext NOT NULL,
  `amount` varchar(50) NOT NULL,
  `uid` mediumtext NOT NULL,
  `currency` int(11) NOT NULL DEFAULT 0,
  `vali_start` varchar(100) NOT NULL,
  `vali_end` varchar(100) NOT NULL,
  `used` int(11) NOT NULL DEFAULT 0,
  `reseller` int(11) DEFAULT 0,
  `fixcurrency` tinyint(1) DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_warehouse`
--

CREATE TABLE `tbl_warehouse` (
  `id` int(9) NOT NULL,
  `name` varchar(200) NOT NULL,
  `address` mediumtext NOT NULL,
  `state` varchar(555) NOT NULL,
  `zip` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_warehousestock`
--

CREATE TABLE `tbl_warehousestock` (
  `id` int(11) NOT NULL,
  `wid` int(11) NOT NULL DEFAULT 0,
  `pid` int(11) NOT NULL DEFAULT 0,
  `stockin` int(11) NOT NULL DEFAULT 0,
  `stockout` int(11) NOT NULL DEFAULT 0,
  `transferby` varchar(555) NOT NULL,
  `time` varchar(50) NOT NULL,
  `days` varchar(20) NOT NULL,
  `date` varchar(20) NOT NULL,
  `status` int(1) NOT NULL DEFAULT 0,
  `transferto` int(5) NOT NULL,
  `notes` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_whiteips`
--

CREATE TABLE `tbl_whiteips` (
  `id` int(10) NOT NULL,
  `ip` mediumtext NOT NULL,
  `reason` mediumtext NOT NULL,
  `expires` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_wholesaleprice`
--

CREATE TABLE `tbl_wholesaleprice` (
  `qnt` int(11) NOT NULL DEFAULT 0,
  `pid` int(11) NOT NULL DEFAULT 0,
  `currency_id` int(11) NOT NULL DEFAULT 0,
  `credit` decimal(25,2) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_withdrawal`
--

CREATE TABLE `tbl_withdrawal` (
  `id` int(11) NOT NULL,
  `uid` int(11) NOT NULL DEFAULT 0,
  `amount` varchar(25) NOT NULL,
  `date` varchar(25) NOT NULL,
  `gateway` varchar(50) NOT NULL,
  `transactionid` varchar(50) NOT NULL,
  `note` varchar(1000) NOT NULL,
  `reason` varchar(1000) NOT NULL,
  `accept_date` varchar(50) NOT NULL,
  `status` int(1) NOT NULL DEFAULT 0,
  `account` varchar(555) NOT NULL,
  `fee` decimal(10,2) DEFAULT 0.00
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_withdrawal_transaction`
--

CREATE TABLE `tbl_withdrawal_transaction` (
  `id` int(10) NOT NULL,
  `userid` int(10) NOT NULL,
  `currency` int(10) NOT NULL,
  `gateway` mediumtext NOT NULL,
  `date` varchar(255) NOT NULL,
  `description` mediumtext NOT NULL,
  `amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `transid` longtext NOT NULL,
  `wid` int(11) NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `crypto_payments`
--
ALTER TABLE `crypto_payments`
  ADD PRIMARY KEY (`paymentID`),
  ADD UNIQUE KEY `key3` (`boxID`,`orderID`,`userID`,`txID`,`amount`,`addr`),
  ADD KEY `boxID` (`boxID`),
  ADD KEY `boxType` (`boxType`),
  ADD KEY `userID` (`userID`),
  ADD KEY `countryID` (`countryID`),
  ADD KEY `orderID` (`orderID`),
  ADD KEY `amount` (`amount`),
  ADD KEY `amountUSD` (`amountUSD`),
  ADD KEY `coinLabel` (`coinLabel`),
  ADD KEY `unrecognised` (`unrecognised`),
  ADD KEY `addr` (`addr`),
  ADD KEY `txID` (`txID`),
  ADD KEY `txDate` (`txDate`),
  ADD KEY `txConfirmed` (`txConfirmed`),
  ADD KEY `txCheckDate` (`txCheckDate`),
  ADD KEY `processed` (`processed`),
  ADD KEY `processedDate` (`processedDate`),
  ADD KEY `recordCreated` (`recordCreated`),
  ADD KEY `key1` (`boxID`,`orderID`),
  ADD KEY `key2` (`boxID`,`orderID`,`userID`);

--
-- Indexes for table `tblAggregatorTransaction`
--
ALTER TABLE `tblAggregatorTransaction`
  ADD PRIMARY KEY (`aggregatortransid`);

--
-- Indexes for table `tblItemPrice`
--
ALTER TABLE `tblItemPrice`
  ADD PRIMARY KEY (`itempriceid`);

--
-- Indexes for table `tblItems`
--
ALTER TABLE `tblItems`
  ADD PRIMARY KEY (`itemid`);

--
-- Indexes for table `tblItemsGroups`
--
ALTER TABLE `tblItemsGroups`
  ADD PRIMARY KEY (`itemgroupid`);

--
-- Indexes for table `tblLoginDevices`
--
ALTER TABLE `tblLoginDevices`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblPaymentAggregator`
--
ALTER TABLE `tblPaymentAggregator`
  ADD PRIMARY KEY (`aggregatorid`);

--
-- Indexes for table `tblPriceLog`
--
ALTER TABLE `tblPriceLog`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblPricingTemplate`
--
ALTER TABLE `tblPricingTemplate`
  ADD PRIMARY KEY (`pricingtemplateid`);

--
-- Indexes for table `tblTransferFee`
--
ALTER TABLE `tblTransferFee`
  ADD PRIMARY KEY (`feeid`);

--
-- Indexes for table `tblUsers`
--
ALTER TABLE `tblUsers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `userstatus` (`userstatus`),
  ADD KEY `is_registered` (`is_registered`),
  ADD KEY `credit_left` (`credit_left`),
  ADD KEY `credit_date` (`credit_date`),
  ADD KEY `usertype` (`usertype`),
  ADD KEY `online_status` (`online_status`),
  ADD KEY `client_group` (`client_group`),
  ADD KEY `email` (`email`),
  ADD KEY `registe` (`userstatus`,`is_registered`),
  ADD KEY `usertypewithid` (`id`,`usertype`);

--
-- Indexes for table `tblWalletTransaction`
--
ALTER TABLE `tblWalletTransaction`
  ADD PRIMARY KEY (`transid`);

--
-- Indexes for table `tbl_activity_log`
--
ALTER TABLE `tbl_activity_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `date` (`date`);

--
-- Indexes for table `tbl_add_management`
--
ALTER TABLE `tbl_add_management`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_admin_access`
--
ALTER TABLE `tbl_admin_access`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `id_index` (`id`);

--
-- Indexes for table `tbl_admin_access_group`
--
ALTER TABLE `tbl_admin_access_group`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_admin_activity`
--
ALTER TABLE `tbl_admin_activity`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_admin_fund_log`
--
ALTER TABLE `tbl_admin_fund_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_admin_info`
--
ALTER TABLE `tbl_admin_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_advertisement_banners`
--
ALTER TABLE `tbl_advertisement_banners`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_affiliate_banner`
--
ALTER TABLE `tbl_affiliate_banner`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_affiliate_history`
--
ALTER TABLE `tbl_affiliate_history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_affiliate_payout`
--
ALTER TABLE `tbl_affiliate_payout`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_affiliate_text`
--
ALTER TABLE `tbl_affiliate_text`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_annoucement_disabled`
--
ALTER TABLE `tbl_annoucement_disabled`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_apilog`
--
ALTER TABLE `tbl_apilog`
  ADD PRIMARY KEY (`id`),
  ADD KEY `apisendingcounter` (`gateway`,`orderid`,`result`);

--
-- Indexes for table `tbl_apiservers`
--
ALTER TABLE `tbl_apiservers`
  ADD KEY `value` (`value`(333)),
  ADD KEY `setting` (`setting`),
  ADD KEY `gateway` (`gateway`);

--
-- Indexes for table `tbl_apiserversservices`
--
ALTER TABLE `tbl_apiserversservices`
  ADD PRIMARY KEY (`apiserverid`),
  ADD KEY `apiserver_setting` (`gateway`(32),`type`(32)),
  ADD KEY `setting_value` (`type`(32),`name`(32)),
  ADD KEY `gateway` (`gateway`,`id`),
  ADD KEY `cpgat` (`gateway`,`id`),
  ADD KEY `price` (`gateway`,`type_id`,`type`,`useasserver`);

--
-- Indexes for table `tbl_api_sync_log`
--
ALTER TABLE `tbl_api_sync_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_bannedips`
--
ALTER TABLE `tbl_bannedips`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ip` (`ip`(32));

--
-- Indexes for table `tbl_bannerslider`
--
ALTER TABLE `tbl_bannerslider`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_bannerslider_banners`
--
ALTER TABLE `tbl_bannerslider_banners`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_bannerslider_banners_default`
--
ALTER TABLE `tbl_bannerslider_banners_default`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_blacklist_imei`
--
ALTER TABLE `tbl_blacklist_imei`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_blockchain_payments`
--
ALTER TABLE `tbl_blockchain_payments`
  ADD PRIMARY KEY (`invoice_id`);

--
-- Indexes for table `tbl_blogcats`
--
ALTER TABLE `tbl_blogcats`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_blogcomments`
--
ALTER TABLE `tbl_blogcomments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `date` (`date`);

--
-- Indexes for table `tbl_blogposts`
--
ALTER TABLE `tbl_blogposts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `date` (`date`);

--
-- Indexes for table `tbl_blogs`
--
ALTER TABLE `tbl_blogs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `date` (`date`),
  ADD KEY `status` (`status`);

--
-- Indexes for table `tbl_campaign`
--
ALTER TABLE `tbl_campaign`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_campaign_users`
--
ALTER TABLE `tbl_campaign_users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_chat`
--
ALTER TABLE `tbl_chat`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_chatdepartment`
--
ALTER TABLE `tbl_chatdepartment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_chat_visitor`
--
ALTER TABLE `tbl_chat_visitor`
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `tbl_client_group`
--
ALTER TABLE `tbl_client_group`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `tbl_client_group_price`
--
ALTER TABLE `tbl_client_group_price`
  ADD KEY `cpall` (`group_id`,`service_type`,`service_id`),
  ADD KEY `gprices` (`group_id`,`service_type`,`service_id`,`currency_id`);

--
-- Indexes for table `tbl_cms_pages`
--
ALTER TABLE `tbl_cms_pages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_cms_pages_store`
--
ALTER TABLE `tbl_cms_pages_store`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_cms_page_language`
--
ALTER TABLE `tbl_cms_page_language`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_config`
--
ALTER TABLE `tbl_config`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_configer`
--
ALTER TABLE `tbl_configer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_config_default`
--
ALTER TABLE `tbl_config_default`
  ADD PRIMARY KEY (`configid`);

--
-- Indexes for table `tbl_currencies`
--
ALTER TABLE `tbl_currencies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_customfields`
--
ALTER TABLE `tbl_customfields`
  ADD PRIMARY KEY (`id`),
  ADD KEY `serviceid` (`relid`);

--
-- Indexes for table `tbl_customfieldsvalues`
--
ALTER TABLE `tbl_customfieldsvalues`
  ADD KEY `fieldid_relid` (`fieldid`,`relid`),
  ADD KEY `forhistory` (`servicetype`,`relid`);

--
-- Indexes for table `tbl_customgatewayprice`
--
ALTER TABLE `tbl_customgatewayprice`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_custom_page`
--
ALTER TABLE `tbl_custom_page`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_dhrucredit_history`
--
ALTER TABLE `tbl_dhrucredit_history`
  ADD PRIMARY KEY (`historyid`);

--
-- Indexes for table `tbl_disabledemail`
--
ALTER TABLE `tbl_disabledemail`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_discount_file`
--
ALTER TABLE `tbl_discount_file`
  ADD KEY `user_id` (`user_id`,`service_id`);

--
-- Indexes for table `tbl_discount_imei`
--
ALTER TABLE `tbl_discount_imei`
  ADD KEY `NEWIN` (`user_id`,`service_id`);

--
-- Indexes for table `tbl_discount_product`
--
ALTER TABLE `tbl_discount_product`
  ADD KEY `user_id` (`user_id`,`service_id`);

--
-- Indexes for table `tbl_discount_server_log`
--
ALTER TABLE `tbl_discount_server_log`
  ADD KEY `user_id` (`user_id`),
  ADD KEY `service_id` (`service_id`),
  ADD KEY `user_id_2` (`user_id`,`service_id`);

--
-- Indexes for table `tbl_document`
--
ALTER TABLE `tbl_document`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_download`
--
ALTER TABLE `tbl_download`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_downloadcat`
--
ALTER TABLE `tbl_downloadcat`
  ADD KEY `id` (`id`);

--
-- Indexes for table `tbl_download_log`
--
ALTER TABLE `tbl_download_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_emailtemplates`
--
ALTER TABLE `tbl_emailtemplates`
  ADD PRIMARY KEY (`id`),
  ADD KEY `type` (`type`(32)),
  ADD KEY `name` (`name`(64));

--
-- Indexes for table `tbl_emailtemplates_backup`
--
ALTER TABLE `tbl_emailtemplates_backup`
  ADD PRIMARY KEY (`id`),
  ADD KEY `type` (`type`(32)),
  ADD KEY `name` (`name`(64));

--
-- Indexes for table `tbl_emailtemplates_reseller`
--
ALTER TABLE `tbl_emailtemplates_reseller`
  ADD PRIMARY KEY (`id`),
  ADD KEY `type` (`type`(32)),
  ADD KEY `name` (`name`(64));

--
-- Indexes for table `tbl_emailtemplate_language`
--
ALTER TABLE `tbl_emailtemplate_language`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_email_blacklist`
--
ALTER TABLE `tbl_email_blacklist`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_email_history`
--
ALTER TABLE `tbl_email_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `userid` (`userid`);

--
-- Indexes for table `tbl_email_layout`
--
ALTER TABLE `tbl_email_layout`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_email_layout_default`
--
ALTER TABLE `tbl_email_layout_default`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_features`
--
ALTER TABLE `tbl_features`
  ADD PRIMARY KEY (`id`),
  ADD KEY `serviceid` (`relid`);

--
-- Indexes for table `tbl_featuresvalues`
--
ALTER TABLE `tbl_featuresvalues`
  ADD PRIMARY KEY (`id`),
  ADD KEY `allfie` (`fieldid`,`relid`,`value`),
  ADD KEY `fierel` (`fieldid`,`relid`);

--
-- Indexes for table `tbl_feedback`
--
ALTER TABLE `tbl_feedback`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_file_credit`
--
ALTER TABLE `tbl_file_credit`
  ADD KEY `service_id` (`service_id`),
  ADD KEY `currency_id` (`currency_id`),
  ADD KEY `credit` (`credit`);

--
-- Indexes for table `tbl_file_group`
--
ALTER TABLE `tbl_file_group`
  ADD PRIMARY KEY (`id`),
  ADD KEY `group_name` (`group_name`),
  ADD KEY `active` (`active`);

--
-- Indexes for table `tbl_fraud`
--
ALTER TABLE `tbl_fraud`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_gatewaylog`
--
ALTER TABLE `tbl_gatewaylog`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_generatedlink`
--
ALTER TABLE `tbl_generatedlink`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_gift_coupon`
--
ALTER TABLE `tbl_gift_coupon`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_group_api_price`
--
ALTER TABLE `tbl_group_api_price`
  ADD PRIMARY KEY (`id`),
  ADD KEY `service_id` (`service_id`,`group_id`),
  ADD KEY `service_id_2` (`service_id`);

--
-- Indexes for table `tbl_homepagegroup`
--
ALTER TABLE `tbl_homepagegroup`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_imei_credit`
--
ALTER TABLE `tbl_imei_credit`
  ADD KEY `service_id` (`service_id`),
  ADD KEY `currency_id` (`currency_id`),
  ADD KEY `credit` (`credit`);

--
-- Indexes for table `tbl_imei_group`
--
ALTER TABLE `tbl_imei_group`
  ADD PRIMARY KEY (`id`),
  ADD KEY `group_name` (`group_name`),
  ADD KEY `active` (`active`),
  ADD KEY `group_name_2` (`group_name`,`server`),
  ADD KEY `active_2` (`active`,`server`),
  ADD KEY `servicestatus` (`server`,`active`);

--
-- Indexes for table `tbl_invoiceitems`
--
ALTER TABLE `tbl_invoiceitems`
  ADD PRIMARY KEY (`id`),
  ADD KEY `invoiceid` (`invoiceid`),
  ADD KEY `userid` (`userid`),
  ADD KEY `relid` (`relid`);

--
-- Indexes for table `tbl_invoices`
--
ALTER TABLE `tbl_invoices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `userid` (`userid`),
  ADD KEY `date` (`date`),
  ADD KEY `datepaid` (`datepaid`),
  ADD KEY `status` (`status`),
  ADD KEY `paymentmethod` (`paymentmethod`(333)),
  ADD KEY `pos` (`pos`),
  ADD KEY `duedate` (`duedate`),
  ADD KEY `total` (`total`),
  ADD KEY `adminid` (`adminid`),
  ADD KEY `subtotal` (`subtotal`),
  ADD KEY `credit` (`credit`),
  ADD KEY `tax` (`tax`),
  ADD KEY `tax2` (`tax2`),
  ADD KEY `notice` (`notice`),
  ADD KEY `invstatus` (`status`,`total`,`adminid`);

--
-- Indexes for table `tbl_keygroup`
--
ALTER TABLE `tbl_keygroup`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_knowledgebase`
--
ALTER TABLE `tbl_knowledgebase`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_knowledgebasecat`
--
ALTER TABLE `tbl_knowledgebasecat`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

--
-- Indexes for table `tbl_label_printer`
--
ALTER TABLE `tbl_label_printer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_license`
--
ALTER TABLE `tbl_license`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_license_default`
--
ALTER TABLE `tbl_license_default`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_livehelp_conversation`
--
ALTER TABLE `tbl_livehelp_conversation`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_loginlog_admin`
--
ALTER TABLE `tbl_loginlog_admin`
  ADD PRIMARY KEY (`id`),
  ADD KEY `username` (`username`),
  ADD KEY `time` (`time`),
  ADD KEY `userid` (`userid`);

--
-- Indexes for table `tbl_loginlog_user`
--
ALTER TABLE `tbl_loginlog_user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `username` (`username`),
  ADD KEY `time` (`time`),
  ADD KEY `userid` (`userid`);

--
-- Indexes for table `tbl_mail_batch`
--
ALTER TABLE `tbl_mail_batch`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_manufacture`
--
ALTER TABLE `tbl_manufacture`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_massmail`
--
ALTER TABLE `tbl_massmail`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_membership_fee`
--
ALTER TABLE `tbl_membership_fee`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_mep`
--
ALTER TABLE `tbl_mep`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_mepserver`
--
ALTER TABLE `tbl_mepserver`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_message`
--
ALTER TABLE `tbl_message`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_mobile`
--
ALTER TABLE `tbl_mobile`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `B_ID` (`B_ID`),
  ADD KEY `Name` (`Name`),
  ADD KEY `N_ID` (`N_ID`),
  ADD KEY `ID` (`ID`,`api`),
  ADD KEY `B_ID_2` (`B_ID`,`api`),
  ADD KEY `ID_2` (`ID`,`B_ID`,`api`),
  ADD KEY `tmbp` (`B_ID`,`api`),
  ADD KEY `tmibp` (`ID`,`B_ID`,`api`);

--
-- Indexes for table `tbl_model_brand`
--
ALTER TABLE `tbl_model_brand`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `Name` (`Name`),
  ADD KEY `N_ID` (`N_ID`),
  ADD KEY `B_ID` (`B_ID`),
  ADD KEY `ID` (`ID`,`api`);

--
-- Indexes for table `tbl_navigation`
--
ALTER TABLE `tbl_navigation`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_navigation_default`
--
ALTER TABLE `tbl_navigation_default`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_newsletter`
--
ALTER TABLE `tbl_newsletter`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_order_file`
--
ALTER TABLE `tbl_order_file`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `service_id` (`service_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `file` (`file`),
  ADD KEY `date` (`date`),
  ADD KEY `time` (`time`),
  ADD KEY `credit` (`credit`),
  ADD KEY `discount` (`discount`),
  ADD KEY `currency_id` (`currency_id`),
  ADD KEY `purchase_cost` (`purchase_cost`),
  ADD KEY `reply_time` (`reply_time`),
  ADD KEY `verified` (`verified`),
  ADD KEY `profit` (`profit`),
  ADD KEY `reply_date` (`reply_date`),
  ADD KEY `user_can_c` (`user_can_c`),
  ADD KEY `fileuser` (`user_id`,`user_can_c`),
  ADD KEY `filetime` (`time`,`user_can_c`),
  ADD KEY `filereplyorder` (`reply_date`,`user_can_c`);

--
-- Indexes for table `tbl_order_imei`
--
ALTER TABLE `tbl_order_imei`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `verified` (`verified`),
  ADD KEY `service_id` (`service_id`),
  ADD KEY `date` (`date`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `invoiceid` (`invoiceid`),
  ADD KEY `reply_time` (`reply_time`),
  ADD KEY `imei` (`imei`),
  ADD KEY `time` (`time`),
  ADD KEY `credit` (`credit`),
  ADD KEY `currency_id` (`currency_id`),
  ADD KEY `profit` (`profit`),
  ADD KEY `purchase_cost` (`purchase_cost`),
  ADD KEY `retail_shop` (`retail_shop`),
  ADD KEY `gateway` (`gateway`),
  ADD KEY `reply_by_admin` (`reply_by_admin`),
  ADD KEY `reply_date` (`reply_date`),
  ADD KEY `user_can_c_2` (`user_can_c`,`purchase_cost`,`currency_id`),
  ADD KEY `service_id_2` (`service_id`,`user_can_c`),
  ADD KEY `search` (`service_id`,`imei`),
  ADD KEY `service_id_3` (`service_id`,`user_id`,`imei`),
  ADD KEY `user_can_c` (`user_can_c`),
  ADD KEY `yearwise` (`date`,`user_can_c`),
  ADD KEY `reply_by_sup` (`reply_by_sup`),
  ADD KEY `netprofit` (`purchase_cost`,`user_can_c`,`currency_id`),
  ADD KEY `orderatuser` (`user_id`,`user_can_c`),
  ADD KEY `ordertime` (`user_can_c`,`time`),
  ADD KEY `imeireplyorder` (`reply_date`,`user_can_c`),
  ADD KEY `timeserver` (`time`,`server`),
  ADD KEY `dtcanserverservice` (`date`,`user_can_c`,`server`,`service_id`),
  ADD KEY `servercantime` (`user_can_c`,`time`,`server`),
  ADD KEY `replyserver` (`reply_date`,`user_can_c`,`server`),
  ADD KEY `currencyserver` (`currency_id`,`user_can_c`,`server`),
  ADD KEY `onlcycurrency` (`currency_id`,`server`),
  ADD KEY `yearserver` (`date`,`user_can_c`,`server`),
  ADD KEY `replybyserver` (`reply_by_admin`,`server`),
  ADD KEY `replybysupserver` (`reply_by_sup`,`server`),
  ADD KEY `onlycans` (`user_can_c`,`server`),
  ADD KEY `serververvice` (`service_id`,`server`),
  ADD KEY `userserver` (`user_id`,`server`),
  ADD KEY `user_id_2` (`user_id`,`user_can_c`,`server`),
  ADD KEY `cron` (`fetchapitime`(17),`user_can_c`,`ORDERAPI`(20),`ORDERAPI_ID`(20),`service_id`,`autosend`),
  ADD KEY `new2019` (`date`,`user_can_c`,`server`),
  ADD KEY `new2020` (`user_id`,`imei`,`service_id`,`user_can_c`),
  ADD KEY `funfetch` (`imei`,`user_can_c`,`service_id`,`order_id`),
  ADD KEY `avddel` (`user_can_c`,`service_id`,`time`);

--
-- Indexes for table `tbl_order_imei_archive`
--
ALTER TABLE `tbl_order_imei_archive`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `verified` (`verified`),
  ADD KEY `service_id` (`service_id`),
  ADD KEY `date` (`date`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `invoiceid` (`invoiceid`),
  ADD KEY `reply_time` (`reply_time`),
  ADD KEY `imei` (`imei`),
  ADD KEY `time` (`time`),
  ADD KEY `credit` (`credit`),
  ADD KEY `currency_id` (`currency_id`),
  ADD KEY `profit` (`profit`),
  ADD KEY `purchase_cost` (`purchase_cost`),
  ADD KEY `retail_shop` (`retail_shop`),
  ADD KEY `gateway` (`gateway`),
  ADD KEY `reply_by_admin` (`reply_by_admin`),
  ADD KEY `reply_date` (`reply_date`),
  ADD KEY `user_can_c_2` (`user_can_c`,`purchase_cost`,`currency_id`),
  ADD KEY `service_id_2` (`service_id`,`user_can_c`),
  ADD KEY `search` (`service_id`,`imei`),
  ADD KEY `service_id_3` (`service_id`,`user_id`,`imei`),
  ADD KEY `user_can_c` (`user_can_c`),
  ADD KEY `yearwise` (`date`,`user_can_c`),
  ADD KEY `reply_by_sup` (`reply_by_sup`),
  ADD KEY `netprofit` (`purchase_cost`,`user_can_c`,`currency_id`),
  ADD KEY `orderatuser` (`user_id`,`user_can_c`),
  ADD KEY `ordertime` (`user_can_c`,`time`),
  ADD KEY `imeireplyorder` (`reply_date`,`user_can_c`),
  ADD KEY `timeserver` (`time`,`server`),
  ADD KEY `dtcanserverservice` (`date`,`user_can_c`,`server`,`service_id`),
  ADD KEY `servercantime` (`user_can_c`,`time`,`server`),
  ADD KEY `replyserver` (`reply_date`,`user_can_c`,`server`),
  ADD KEY `currencyserver` (`currency_id`,`user_can_c`,`server`),
  ADD KEY `onlcycurrency` (`currency_id`,`server`),
  ADD KEY `yearserver` (`date`,`user_can_c`,`server`),
  ADD KEY `replybyserver` (`reply_by_admin`,`server`),
  ADD KEY `replybysupserver` (`reply_by_sup`,`server`),
  ADD KEY `onlycans` (`user_can_c`,`server`),
  ADD KEY `serververvice` (`service_id`,`server`),
  ADD KEY `userserver` (`user_id`,`server`),
  ADD KEY `user_id_2` (`user_id`,`user_can_c`,`server`);

--
-- Indexes for table `tbl_order_log`
--
ALTER TABLE `tbl_order_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_order_product`
--
ALTER TABLE `tbl_order_product`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `service_id` (`service_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `date` (`date`),
  ADD KEY `time` (`time`),
  ADD KEY `credit` (`credit`),
  ADD KEY `verified` (`verified`),
  ADD KEY `user_can_c` (`user_can_c`),
  ADD KEY `invoiceid` (`invoiceid`),
  ADD KEY `reply_date` (`reply_date`);

--
-- Indexes for table `tbl_order_server`
--
ALTER TABLE `tbl_order_server`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `service_id` (`service_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `credit` (`credit`),
  ADD KEY `user_can_c` (`user_can_c`),
  ADD KEY `reply` (`reply`),
  ADD KEY `reply_time` (`reply_time`),
  ADD KEY `invoiceid` (`invoiceid`),
  ADD KEY `reply_date` (`reply_date`),
  ADD KEY `verified` (`verified`),
  ADD KEY `servertime` (`time`,`user_can_c`),
  ADD KEY `serverreplyorder` (`reply_date`,`user_can_c`);

--
-- Indexes for table `tbl_paymentgateways`
--
ALTER TABLE `tbl_paymentgateways`
  ADD KEY `gateway_setting` (`gateway`(32),`setting`(32)),
  ADD KEY `setting_value` (`setting`(32),`value`(32));

--
-- Indexes for table `tbl_pos_setting`
--
ALTER TABLE `tbl_pos_setting`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_pos_terminal`
--
ALTER TABLE `tbl_pos_terminal`
  ADD PRIMARY KEY (`posterminalid`);

--
-- Indexes for table `tbl_prd`
--
ALTER TABLE `tbl_prd`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_pricing_qnt`
--
ALTER TABLE `tbl_pricing_qnt`
  ADD PRIMARY KEY (`pricingqntid`);

--
-- Indexes for table `tbl_private_order`
--
ALTER TABLE `tbl_private_order`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sid` (`sid`),
  ADD KEY `uid` (`uid`),
  ADD KEY `cid` (`cid`),
  ADD KEY `status` (`status`),
  ADD KEY `date` (`date`(333));

--
-- Indexes for table `tbl_productbundle`
--
ALTER TABLE `tbl_productbundle`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_products`
--
ALTER TABLE `tbl_products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `service_name` (`service_name`),
  ADD KEY `credit` (`credit`),
  ADD KEY `status` (`status`),
  ADD KEY `group_id` (`group_id`),
  ADD KEY `review` (`review`),
  ADD KEY `bysupplier` (`bysupplier`),
  ADD KEY `active` (`active`),
  ADD KEY `manufacture_id` (`manufacture_id`),
  ADD KEY `service_name_2` (`service_name`,`active`);

--
-- Indexes for table `tbl_productsignup`
--
ALTER TABLE `tbl_productsignup`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_product_credit`
--
ALTER TABLE `tbl_product_credit`
  ADD KEY `service_id` (`service_id`),
  ADD KEY `currency_id` (`currency_id`),
  ADD KEY `credit` (`credit`);

--
-- Indexes for table `tbl_product_group`
--
ALTER TABLE `tbl_product_group`
  ADD PRIMARY KEY (`id`),
  ADD KEY `group_name` (`group_name`),
  ADD KEY `active` (`active`),
  ADD KEY `mid` (`mid`);

--
-- Indexes for table `tbl_promotion`
--
ALTER TABLE `tbl_promotion`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_provider`
--
ALTER TABLE `tbl_provider`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `C_ID` (`C_ID`),
  ADD KEY `Name` (`Name`),
  ADD KEY `N_ID` (`N_ID`);

--
-- Indexes for table `tbl_provider_country`
--
ALTER TABLE `tbl_provider_country`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `Name` (`Name`),
  ADD KEY `N_ID` (`N_ID`);

--
-- Indexes for table `tbl_provider_model_mep`
--
ALTER TABLE `tbl_provider_model_mep`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_purchase_cost`
--
ALTER TABLE `tbl_purchase_cost`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_quick_news`
--
ALTER TABLE `tbl_quick_news`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_recent_menu`
--
ALTER TABLE `tbl_recent_menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_recent_pages`
--
ALTER TABLE `tbl_recent_pages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_reseller_payout`
--
ALTER TABLE `tbl_reseller_payout`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_reseller_price`
--
ALTER TABLE `tbl_reseller_price`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_reseller_statement`
--
ALTER TABLE `tbl_reseller_statement`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_return_request`
--
ALTER TABLE `tbl_return_request`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oid` (`oid`),
  ADD KEY `date` (`date`),
  ADD KEY `status` (`status`),
  ADD KEY `uid` (`uid`);

--
-- Indexes for table `tbl_review`
--
ALTER TABLE `tbl_review`
  ADD PRIMARY KEY (`id`),
  ADD KEY `status` (`status`),
  ADD KEY `pid` (`pid`),
  ADD KEY `sid` (`sid`),
  ADD KEY `lid` (`lid`);

--
-- Indexes for table `tbl_security_question`
--
ALTER TABLE `tbl_security_question`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_seo_links`
--
ALTER TABLE `tbl_seo_links`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_serial_list`
--
ALTER TABLE `tbl_serial_list`
  ADD PRIMARY KEY (`id`),
  ADD KEY `serial` (`serial`,`pid`,`wid`);

--
-- Indexes for table `tbl_server_credit`
--
ALTER TABLE `tbl_server_credit`
  ADD KEY `service_id` (`service_id`),
  ADD KEY `currency_id` (`currency_id`),
  ADD KEY `credit` (`credit`);

--
-- Indexes for table `tbl_server_group`
--
ALTER TABLE `tbl_server_group`
  ADD PRIMARY KEY (`id`),
  ADD KEY `group_name` (`group_name`),
  ADD KEY `active` (`active`);

--
-- Indexes for table `tbl_server_log`
--
ALTER TABLE `tbl_server_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `service_name` (`service_name`),
  ADD KEY `credit` (`credit`),
  ADD KEY `time` (`time`),
  ADD KEY `group_id` (`group_id`),
  ADD KEY `active` (`active`),
  ADD KEY `API` (`API`),
  ADD KEY `purchase_cost` (`purchase_cost`),
  ADD KEY `retail` (`retail`),
  ADD KEY `store` (`store`),
  ADD KEY `show_onhome` (`show_onhome`);

--
-- Indexes for table `tbl_services_file`
--
ALTER TABLE `tbl_services_file`
  ADD PRIMARY KEY (`id`),
  ADD KEY `service_name` (`service_name`),
  ADD KEY `credit` (`credit`),
  ADD KEY `time` (`time`),
  ADD KEY `group_id` (`group_id`),
  ADD KEY `active` (`active`),
  ADD KEY `purchase_cost` (`purchase_cost`),
  ADD KEY `hot` (`hot`);

--
-- Indexes for table `tbl_services_imei`
--
ALTER TABLE `tbl_services_imei`
  ADD PRIMARY KEY (`id`),
  ADD KEY `group_id` (`group_id`),
  ADD KEY `status` (`status`),
  ADD KEY `service_name` (`service_name`),
  ADD KEY `active` (`active`),
  ADD KEY `API` (`API`),
  ADD KEY `API_ID` (`API_ID`),
  ADD KEY `retail` (`retail`),
  ADD KEY `store` (`store`),
  ADD KEY `model` (`model`),
  ADD KEY `provider` (`provider`),
  ADD KEY `network` (`network`),
  ADD KEY `hot` (`hot`),
  ADD KEY `purchase_cost` (`purchase_cost`),
  ADD KEY `retail_credit` (`retail_credit`),
  ADD KEY `review` (`review`),
  ADD KEY `id` (`id`,`group_id`,`active`),
  ADD KEY `API_2` (`API`,`API_ID`,`inactivebyapi`),
  ADD KEY `inactiveapi` (`API`,`API_ID`,`inactivebyapi`),
  ADD KEY `API_3` (`API`,`API_ID`,`API_TYPEID`),
  ADD KEY `groupactive` (`group_id`,`active`),
  ADD KEY `homepage` (`show_onhome`);

--
-- Indexes for table `tbl_services_imei_api`
--
ALTER TABLE `tbl_services_imei_api`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_service_pricing`
--
ALTER TABLE `tbl_service_pricing`
  ADD PRIMARY KEY (`pricingid`),
  ADD KEY `newpricingindex` (`currencyid`,`groupid`,`serviceid`),
  ADD KEY `serviceid` (`serviceid`);

--
-- Indexes for table `tbl_service_status`
--
ALTER TABLE `tbl_service_status`
  ADD PRIMARY KEY (`servicestatusid`);

--
-- Indexes for table `tbl_service_type`
--
ALTER TABLE `tbl_service_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_settings`
--
ALTER TABLE `tbl_settings`
  ADD PRIMARY KEY (`attribute`);

--
-- Indexes for table `tbl_settings_default`
--
ALTER TABLE `tbl_settings_default`
  ADD PRIMARY KEY (`attribute`);

--
-- Indexes for table `tbl_sheduledmail`
--
ALTER TABLE `tbl_sheduledmail`
  ADD PRIMARY KEY (`id`),
  ADD KEY `userid` (`userid`);

--
-- Indexes for table `tbl_shipping_gatway`
--
ALTER TABLE `tbl_shipping_gatway`
  ADD KEY `apiserver_setting` (`gateway`(32),`setting`(32)),
  ADD KEY `setting_value` (`setting`(32),`value`(32));

--
-- Indexes for table `tbl_shipping_services`
--
ALTER TABLE `tbl_shipping_services`
  ADD PRIMARY KEY (`id`),
  ADD KEY `apiserver_setting` (`gateway`(32),`setting`(32)),
  ADD KEY `setting_value` (`setting`(32),`value`(32));

--
-- Indexes for table `tbl_site_settings`
--
ALTER TABLE `tbl_site_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_smsgatewaylog`
--
ALTER TABLE `tbl_smsgatewaylog`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_smstemplate`
--
ALTER TABLE `tbl_smstemplate`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_smstemplate_language`
--
ALTER TABLE `tbl_smstemplate_language`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_statement_points`
--
ALTER TABLE `tbl_statement_points`
  ADD PRIMARY KEY (`pointid`);

--
-- Indexes for table `tbl_statement_supplier`
--
ALTER TABLE `tbl_statement_supplier`
  ADD PRIMARY KEY (`id`),
  ADD KEY `supplier_id` (`supplier_id`),
  ADD KEY `stype` (`stype`),
  ADD KEY `date` (`date`),
  ADD KEY `time` (`time`),
  ADD KEY `type` (`type`),
  ADD KEY `relid` (`relid`),
  ADD KEY `tid` (`tid`);

--
-- Indexes for table `tbl_statement_user`
--
ALTER TABLE `tbl_statement_user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `uid` (`uid`),
  ADD KEY `stype` (`stype`),
  ADD KEY `date` (`date`),
  ADD KEY `time` (`time`),
  ADD KEY `type` (`type`),
  ADD KEY `amount` (`amount`),
  ADD KEY `relid` (`relid`),
  ADD KEY `adminid` (`adminid`),
  ADD KEY `imei` (`imei`),
  ADD KEY `file` (`file`),
  ADD KEY `server` (`server`),
  ADD KEY `shop` (`shop`),
  ADD KEY `balance` (`balance`);

--
-- Indexes for table `tbl_stock`
--
ALTER TABLE `tbl_stock`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_stockgroup`
--
ALTER TABLE `tbl_stockgroup`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_stock_history`
--
ALTER TABLE `tbl_stock_history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_store_fund_history`
--
ALTER TABLE `tbl_store_fund_history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_store_pricing`
--
ALTER TABLE `tbl_store_pricing`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_subscribers`
--
ALTER TABLE `tbl_subscribers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_supplier`
--
ALTER TABLE `tbl_supplier`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_supplier_log`
--
ALTER TABLE `tbl_supplier_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_supplier_payout`
--
ALTER TABLE `tbl_supplier_payout`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_support_department`
--
ALTER TABLE `tbl_support_department`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_support_priority`
--
ALTER TABLE `tbl_support_priority`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_support_status`
--
ALTER TABLE `tbl_support_status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_support_tickets`
--
ALTER TABLE `tbl_support_tickets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `did` (`did`),
  ADD KEY `uid` (`uid`),
  ADD KEY `sid` (`sid`),
  ADD KEY `date` (`date`),
  ADD KEY `tid` (`tid`);

--
-- Indexes for table `tbl_survey`
--
ALTER TABLE `tbl_survey`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_survey_detail`
--
ALTER TABLE `tbl_survey_detail`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_suspended_sale`
--
ALTER TABLE `tbl_suspended_sale`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_swkey`
--
ALTER TABLE `tbl_swkey`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_system_activity`
--
ALTER TABLE `tbl_system_activity`
  ADD PRIMARY KEY (`id`),
  ADD KEY `date` (`date`);

--
-- Indexes for table `tbl_tax`
--
ALTER TABLE `tbl_tax`
  ADD PRIMARY KEY (`id`),
  ADD KEY `state_country` (`state`(32),`country`(2));

--
-- Indexes for table `tbl_templates`
--
ALTER TABLE `tbl_templates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_testimonial`
--
ALTER TABLE `tbl_testimonial`
  ADD PRIMARY KEY (`id`),
  ADD KEY `status` (`status`);

--
-- Indexes for table `tbl_theme`
--
ALTER TABLE `tbl_theme`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_timezone_1`
--
ALTER TABLE `tbl_timezone_1`
  ADD PRIMARY KEY (`Name`);

--
-- Indexes for table `tbl_tmp`
--
ALTER TABLE `tbl_tmp`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_tmpconfiger`
--
ALTER TABLE `tbl_tmpconfiger`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_transaction`
--
ALTER TABLE `tbl_transaction`
  ADD PRIMARY KEY (`id`),
  ADD KEY `invoiceid` (`invoiceid`),
  ADD KEY `userid` (`userid`),
  ADD KEY `date` (`date`),
  ADD KEY `transid` (`transid`(32)),
  ADD KEY `currency` (`currency`),
  ADD KEY `amountin` (`amountin`),
  ADD KEY `amountout` (`amountout`);

--
-- Indexes for table `tbl_used_key`
--
ALTER TABLE `tbl_used_key`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_user_gateway`
--
ALTER TABLE `tbl_user_gateway`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_visitors`
--
ALTER TABLE `tbl_visitors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_voucher`
--
ALTER TABLE `tbl_voucher`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_warehouse`
--
ALTER TABLE `tbl_warehouse`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_warehousestock`
--
ALTER TABLE `tbl_warehousestock`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_whiteips`
--
ALTER TABLE `tbl_whiteips`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ip` (`ip`(32));

--
-- Indexes for table `tbl_withdrawal`
--
ALTER TABLE `tbl_withdrawal`
  ADD PRIMARY KEY (`id`),
  ADD KEY `uid` (`uid`),
  ADD KEY `amount` (`amount`),
  ADD KEY `date` (`date`),
  ADD KEY `status` (`status`);

--
-- Indexes for table `tbl_withdrawal_transaction`
--
ALTER TABLE `tbl_withdrawal_transaction`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `crypto_payments`
--
ALTER TABLE `crypto_payments`
  MODIFY `paymentID` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblAggregatorTransaction`
--
ALTER TABLE `tblAggregatorTransaction`
  MODIFY `aggregatortransid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblItemPrice`
--
ALTER TABLE `tblItemPrice`
  MODIFY `itempriceid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblItems`
--
ALTER TABLE `tblItems`
  MODIFY `itemid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblItemsGroups`
--
ALTER TABLE `tblItemsGroups`
  MODIFY `itemgroupid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblLoginDevices`
--
ALTER TABLE `tblLoginDevices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tblPaymentAggregator`
--
ALTER TABLE `tblPaymentAggregator`
  MODIFY `aggregatorid` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblPriceLog`
--
ALTER TABLE `tblPriceLog`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblPricingTemplate`
--
ALTER TABLE `tblPricingTemplate`
  MODIFY `pricingtemplateid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblTransferFee`
--
ALTER TABLE `tblTransferFee`
  MODIFY `feeid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblUsers`
--
ALTER TABLE `tblUsers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tblWalletTransaction`
--
ALTER TABLE `tblWalletTransaction`
  MODIFY `transid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_activity_log`
--
ALTER TABLE `tbl_activity_log`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_add_management`
--
ALTER TABLE `tbl_add_management`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_admin_access`
--
ALTER TABLE `tbl_admin_access`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=552;

--
-- AUTO_INCREMENT for table `tbl_admin_access_group`
--
ALTER TABLE `tbl_admin_access_group`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_admin_activity`
--
ALTER TABLE `tbl_admin_activity`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_admin_fund_log`
--
ALTER TABLE `tbl_admin_fund_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_admin_info`
--
ALTER TABLE `tbl_admin_info`
  MODIFY `id` int(9) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_advertisement_banners`
--
ALTER TABLE `tbl_advertisement_banners`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_affiliate_banner`
--
ALTER TABLE `tbl_affiliate_banner`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_affiliate_history`
--
ALTER TABLE `tbl_affiliate_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_affiliate_payout`
--
ALTER TABLE `tbl_affiliate_payout`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_affiliate_text`
--
ALTER TABLE `tbl_affiliate_text`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_annoucement_disabled`
--
ALTER TABLE `tbl_annoucement_disabled`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_apilog`
--
ALTER TABLE `tbl_apilog`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_apiserversservices`
--
ALTER TABLE `tbl_apiserversservices`
  MODIFY `apiserverid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=447;

--
-- AUTO_INCREMENT for table `tbl_api_sync_log`
--
ALTER TABLE `tbl_api_sync_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT for table `tbl_bannedips`
--
ALTER TABLE `tbl_bannedips`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_bannerslider`
--
ALTER TABLE `tbl_bannerslider`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=154;

--
-- AUTO_INCREMENT for table `tbl_bannerslider_banners`
--
ALTER TABLE `tbl_bannerslider_banners`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_bannerslider_banners_default`
--
ALTER TABLE `tbl_bannerslider_banners_default`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_blacklist_imei`
--
ALTER TABLE `tbl_blacklist_imei`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_blogcats`
--
ALTER TABLE `tbl_blogcats`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_blogcomments`
--
ALTER TABLE `tbl_blogcomments`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_blogposts`
--
ALTER TABLE `tbl_blogposts`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_blogs`
--
ALTER TABLE `tbl_blogs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_campaign`
--
ALTER TABLE `tbl_campaign`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_campaign_users`
--
ALTER TABLE `tbl_campaign_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_chat`
--
ALTER TABLE `tbl_chat`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_chatdepartment`
--
ALTER TABLE `tbl_chatdepartment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_client_group`
--
ALTER TABLE `tbl_client_group`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_cms_pages`
--
ALTER TABLE `tbl_cms_pages`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1001;

--
-- AUTO_INCREMENT for table `tbl_cms_pages_store`
--
ALTER TABLE `tbl_cms_pages_store`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_cms_page_language`
--
ALTER TABLE `tbl_cms_page_language`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1001;

--
-- AUTO_INCREMENT for table `tbl_config`
--
ALTER TABLE `tbl_config`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tbl_configer`
--
ALTER TABLE `tbl_configer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_config_default`
--
ALTER TABLE `tbl_config_default`
  MODIFY `configid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=394;

--
-- AUTO_INCREMENT for table `tbl_currencies`
--
ALTER TABLE `tbl_currencies`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_customfields`
--
ALTER TABLE `tbl_customfields`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_customgatewayprice`
--
ALTER TABLE `tbl_customgatewayprice`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_custom_page`
--
ALTER TABLE `tbl_custom_page`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tbl_dhrucredit_history`
--
ALTER TABLE `tbl_dhrucredit_history`
  MODIFY `historyid` int(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_disabledemail`
--
ALTER TABLE `tbl_disabledemail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_document`
--
ALTER TABLE `tbl_document`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_download`
--
ALTER TABLE `tbl_download`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_downloadcat`
--
ALTER TABLE `tbl_downloadcat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_download_log`
--
ALTER TABLE `tbl_download_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_emailtemplates`
--
ALTER TABLE `tbl_emailtemplates`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=87;

--
-- AUTO_INCREMENT for table `tbl_emailtemplates_backup`
--
ALTER TABLE `tbl_emailtemplates_backup`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=87;

--
-- AUTO_INCREMENT for table `tbl_emailtemplates_reseller`
--
ALTER TABLE `tbl_emailtemplates_reseller`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_emailtemplate_language`
--
ALTER TABLE `tbl_emailtemplate_language`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_email_blacklist`
--
ALTER TABLE `tbl_email_blacklist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_email_history`
--
ALTER TABLE `tbl_email_history`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_email_layout`
--
ALTER TABLE `tbl_email_layout`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_email_layout_default`
--
ALTER TABLE `tbl_email_layout_default`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_features`
--
ALTER TABLE `tbl_features`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_featuresvalues`
--
ALTER TABLE `tbl_featuresvalues`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_feedback`
--
ALTER TABLE `tbl_feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_file_group`
--
ALTER TABLE `tbl_file_group`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_fraud`
--
ALTER TABLE `tbl_fraud`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_gatewaylog`
--
ALTER TABLE `tbl_gatewaylog`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_generatedlink`
--
ALTER TABLE `tbl_generatedlink`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_gift_coupon`
--
ALTER TABLE `tbl_gift_coupon`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT ' ';

--
-- AUTO_INCREMENT for table `tbl_group_api_price`
--
ALTER TABLE `tbl_group_api_price`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_homepagegroup`
--
ALTER TABLE `tbl_homepagegroup`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_imei_group`
--
ALTER TABLE `tbl_imei_group`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbl_invoiceitems`
--
ALTER TABLE `tbl_invoiceitems`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_invoices`
--
ALTER TABLE `tbl_invoices`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_keygroup`
--
ALTER TABLE `tbl_keygroup`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_knowledgebase`
--
ALTER TABLE `tbl_knowledgebase`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_knowledgebasecat`
--
ALTER TABLE `tbl_knowledgebasecat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_label_printer`
--
ALTER TABLE `tbl_label_printer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_livehelp_conversation`
--
ALTER TABLE `tbl_livehelp_conversation`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_loginlog_admin`
--
ALTER TABLE `tbl_loginlog_admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `tbl_loginlog_user`
--
ALTER TABLE `tbl_loginlog_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_mail_batch`
--
ALTER TABLE `tbl_mail_batch`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_manufacture`
--
ALTER TABLE `tbl_manufacture`
  MODIFY `id` int(9) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_massmail`
--
ALTER TABLE `tbl_massmail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_membership_fee`
--
ALTER TABLE `tbl_membership_fee`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_mep`
--
ALTER TABLE `tbl_mep`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_mepserver`
--
ALTER TABLE `tbl_mepserver`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_message`
--
ALTER TABLE `tbl_message`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_mobile`
--
ALTER TABLE `tbl_mobile`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_model_brand`
--
ALTER TABLE `tbl_model_brand`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_navigation`
--
ALTER TABLE `tbl_navigation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1116;

--
-- AUTO_INCREMENT for table `tbl_navigation_default`
--
ALTER TABLE `tbl_navigation_default`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_newsletter`
--
ALTER TABLE `tbl_newsletter`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_order_file`
--
ALTER TABLE `tbl_order_file`
  MODIFY `order_id` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_order_imei`
--
ALTER TABLE `tbl_order_imei`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_order_imei_archive`
--
ALTER TABLE `tbl_order_imei_archive`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_order_log`
--
ALTER TABLE `tbl_order_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_order_product`
--
ALTER TABLE `tbl_order_product`
  MODIFY `order_id` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_order_server`
--
ALTER TABLE `tbl_order_server`
  MODIFY `order_id` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_pos_setting`
--
ALTER TABLE `tbl_pos_setting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_pos_terminal`
--
ALTER TABLE `tbl_pos_terminal`
  MODIFY `posterminalid` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_prd`
--
ALTER TABLE `tbl_prd`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_pricing_qnt`
--
ALTER TABLE `tbl_pricing_qnt`
  MODIFY `pricingqntid` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_private_order`
--
ALTER TABLE `tbl_private_order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_productbundle`
--
ALTER TABLE `tbl_productbundle`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_products`
--
ALTER TABLE `tbl_products`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_productsignup`
--
ALTER TABLE `tbl_productsignup`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_product_group`
--
ALTER TABLE `tbl_product_group`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_promotion`
--
ALTER TABLE `tbl_promotion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_provider`
--
ALTER TABLE `tbl_provider`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_provider_country`
--
ALTER TABLE `tbl_provider_country`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_provider_model_mep`
--
ALTER TABLE `tbl_provider_model_mep`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_purchase_cost`
--
ALTER TABLE `tbl_purchase_cost`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_quick_news`
--
ALTER TABLE `tbl_quick_news`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_recent_menu`
--
ALTER TABLE `tbl_recent_menu`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_recent_pages`
--
ALTER TABLE `tbl_recent_pages`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT for table `tbl_reseller_payout`
--
ALTER TABLE `tbl_reseller_payout`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_reseller_price`
--
ALTER TABLE `tbl_reseller_price`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_reseller_statement`
--
ALTER TABLE `tbl_reseller_statement`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_return_request`
--
ALTER TABLE `tbl_return_request`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_review`
--
ALTER TABLE `tbl_review`
  MODIFY `id` mediumint(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_security_question`
--
ALTER TABLE `tbl_security_question`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_seo_links`
--
ALTER TABLE `tbl_seo_links`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_serial_list`
--
ALTER TABLE `tbl_serial_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_server_group`
--
ALTER TABLE `tbl_server_group`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_server_log`
--
ALTER TABLE `tbl_server_log`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_services_file`
--
ALTER TABLE `tbl_services_file`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_services_imei`
--
ALTER TABLE `tbl_services_imei`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=141;

--
-- AUTO_INCREMENT for table `tbl_services_imei_api`
--
ALTER TABLE `tbl_services_imei_api`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tbl_service_pricing`
--
ALTER TABLE `tbl_service_pricing`
  MODIFY `pricingid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=141;

--
-- AUTO_INCREMENT for table `tbl_service_status`
--
ALTER TABLE `tbl_service_status`
  MODIFY `servicestatusid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=141;

--
-- AUTO_INCREMENT for table `tbl_service_type`
--
ALTER TABLE `tbl_service_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_sheduledmail`
--
ALTER TABLE `tbl_sheduledmail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_shipping_services`
--
ALTER TABLE `tbl_shipping_services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `tbl_site_settings`
--
ALTER TABLE `tbl_site_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_smsgatewaylog`
--
ALTER TABLE `tbl_smsgatewaylog`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_smstemplate`
--
ALTER TABLE `tbl_smstemplate`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbl_smstemplate_language`
--
ALTER TABLE `tbl_smstemplate_language`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_statement_points`
--
ALTER TABLE `tbl_statement_points`
  MODIFY `pointid` int(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_statement_supplier`
--
ALTER TABLE `tbl_statement_supplier`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_statement_user`
--
ALTER TABLE `tbl_statement_user`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_stock`
--
ALTER TABLE `tbl_stock`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_stockgroup`
--
ALTER TABLE `tbl_stockgroup`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_stock_history`
--
ALTER TABLE `tbl_stock_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_store_fund_history`
--
ALTER TABLE `tbl_store_fund_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_store_pricing`
--
ALTER TABLE `tbl_store_pricing`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_subscribers`
--
ALTER TABLE `tbl_subscribers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_supplier`
--
ALTER TABLE `tbl_supplier`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_supplier_log`
--
ALTER TABLE `tbl_supplier_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_supplier_payout`
--
ALTER TABLE `tbl_supplier_payout`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_support_department`
--
ALTER TABLE `tbl_support_department`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_support_priority`
--
ALTER TABLE `tbl_support_priority`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_support_status`
--
ALTER TABLE `tbl_support_status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_support_tickets`
--
ALTER TABLE `tbl_support_tickets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_survey`
--
ALTER TABLE `tbl_survey`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_survey_detail`
--
ALTER TABLE `tbl_survey_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_suspended_sale`
--
ALTER TABLE `tbl_suspended_sale`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_swkey`
--
ALTER TABLE `tbl_swkey`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_system_activity`
--
ALTER TABLE `tbl_system_activity`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_tax`
--
ALTER TABLE `tbl_tax`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tbl_templates`
--
ALTER TABLE `tbl_templates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=187;

--
-- AUTO_INCREMENT for table `tbl_testimonial`
--
ALTER TABLE `tbl_testimonial`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_theme`
--
ALTER TABLE `tbl_theme`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_tmp`
--
ALTER TABLE `tbl_tmp`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_tmpconfiger`
--
ALTER TABLE `tbl_tmpconfiger`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_transaction`
--
ALTER TABLE `tbl_transaction`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_used_key`
--
ALTER TABLE `tbl_used_key`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_user_gateway`
--
ALTER TABLE `tbl_user_gateway`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_visitors`
--
ALTER TABLE `tbl_visitors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_voucher`
--
ALTER TABLE `tbl_voucher`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_warehouse`
--
ALTER TABLE `tbl_warehouse`
  MODIFY `id` int(9) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_warehousestock`
--
ALTER TABLE `tbl_warehousestock`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_whiteips`
--
ALTER TABLE `tbl_whiteips`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_withdrawal`
--
ALTER TABLE `tbl_withdrawal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_withdrawal_transaction`
--
ALTER TABLE `tbl_withdrawal_transaction`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
