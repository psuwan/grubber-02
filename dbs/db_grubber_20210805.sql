-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.18 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             11.3.0.6295
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Dumping structure for table db_grubber.tbl_buytype
CREATE TABLE IF NOT EXISTS `tbl_buytype` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `buytype_code` char(4) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `buytype_name` char(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `buytype_details` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table db_grubber.tbl_buytype: ~6 rows (approximately)
DELETE FROM `tbl_buytype`;
/*!40000 ALTER TABLE `tbl_buytype` DISABLE KEYS */;
INSERT INTO `tbl_buytype` (`id`, `buytype_code`, `buytype_name`, `buytype_details`) VALUES
	(1, '0001', 'ซื้อสด', NULL),
	(2, '0002', 'ซื้อเชื่อ', NULL),
	(3, '0003', 'ซื้อล่วงหน้า', ''),
	(4, '0004', 'ซื้อฝาก (ไม่เบิกเงิน)', NULL),
	(5, '0005', 'ซื้อฝาก (เบิกเงิน)', NULL),
	(6, '0006', 'ประมูล', NULL);
/*!40000 ALTER TABLE `tbl_buytype` ENABLE KEYS */;

-- Dumping structure for table db_grubber.tbl_customers
CREATE TABLE IF NOT EXISTS `tbl_customers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cust_code` char(6) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `cust_category` char(4) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `cust_name` varchar(150) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `cust_surname` varchar(150) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `cust_phone` varchar(22) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `cust_line` char(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `cust_email` char(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `cust_details` text CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `cust_createdAt` timestamp NULL DEFAULT NULL,
  `cust_updatedAt` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table db_grubber.tbl_customers: ~0 rows (approximately)
DELETE FROM `tbl_customers`;
/*!40000 ALTER TABLE `tbl_customers` DISABLE KEYS */;
INSERT INTO `tbl_customers` (`id`, `cust_code`, `cust_category`, `cust_name`, `cust_surname`, `cust_phone`, `cust_line`, `cust_email`, `cust_details`, `cust_createdAt`, `cust_updatedAt`) VALUES
	(1, '000001', '0002', 'น.ส.กนกนันท์', 'หัตถินาท', '0854375869', '', '', 'รายละเอียดอื่นลูกค้า                ', '2020-11-21 16:42:19', '2020-11-21 16:42:19');
/*!40000 ALTER TABLE `tbl_customers` ENABLE KEYS */;

-- Dumping structure for table db_grubber.tbl_custtypes
CREATE TABLE IF NOT EXISTS `tbl_custtypes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `custtype_code` char(4) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `custtype_name` char(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `custtype_createdAt` timestamp NULL DEFAULT NULL,
  `custtype_updatedAt` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tbl_custtypes_custtype_code_uindex` (`custtype_code`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table db_grubber.tbl_custtypes: ~2 rows (approximately)
DELETE FROM `tbl_custtypes`;
/*!40000 ALTER TABLE `tbl_custtypes` DISABLE KEYS */;
INSERT INTO `tbl_custtypes` (`id`, `custtype_code`, `custtype_name`, `custtype_createdAt`, `custtype_updatedAt`) VALUES
	(1, '0001', 'บริษัท', '2020-11-09 17:38:07', '2020-11-09 17:38:07'),
	(2, '0002', 'ร้านยาง', '2020-11-09 17:51:09', '2020-11-09 17:51:09');
/*!40000 ALTER TABLE `tbl_custtypes` ENABLE KEYS */;

-- Dumping structure for table db_grubber.tbl_helpme
CREATE TABLE IF NOT EXISTS `tbl_helpme` (
  `name4table` char(50) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `name4colcode` char(50) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `name4colname` char(50) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table db_grubber.tbl_helpme: ~7 rows (approximately)
DELETE FROM `tbl_helpme`;
/*!40000 ALTER TABLE `tbl_helpme` DISABLE KEYS */;
INSERT INTO `tbl_helpme` (`name4table`, `name4colcode`, `name4colname`) VALUES
	('tbl_locations', 'loc_code', 'loc_name'),
	('tbl_buytype', 'buytype_code', 'buytype_name'),
	('tbl_paytype', 'paytype_code', 'paytype_name'),
	('tbl_prdtypes', 'prdtype_code', 'prdtype_name'),
	('tbl_supptypes', 'supptype_code', 'supptype_name'),
	('tbl_vehicletype', 'vehicletype_code', 'vehicletype_name'),
	('tbl_custtypes', 'custtype_code', 'custtype_name');
/*!40000 ALTER TABLE `tbl_helpme` ENABLE KEYS */;

-- Dumping structure for table db_grubber.tbl_locations
CREATE TABLE IF NOT EXISTS `tbl_locations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `loc_code` char(4) DEFAULT NULL,
  `loc_name` varchar(250) NOT NULL DEFAULT '0',
  `loc_status` tinyint(1) NOT NULL DEFAULT '0',
  `loc_createdAt` timestamp NULL DEFAULT NULL,
  `loc_updatedAt` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `loc_code` (`loc_code`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- Dumping data for table db_grubber.tbl_locations: ~0 rows (approximately)
DELETE FROM `tbl_locations`;
/*!40000 ALTER TABLE `tbl_locations` DISABLE KEYS */;
INSERT INTO `tbl_locations` (`id`, `loc_code`, `loc_name`, `loc_status`, `loc_createdAt`, `loc_updatedAt`) VALUES
	(1, '0001', 'โกดังบริษัท', 1, '2020-10-07 13:53:44', '2020-10-08 11:50:37');
/*!40000 ALTER TABLE `tbl_locations` ENABLE KEYS */;

-- Dumping structure for table db_grubber.tbl_paytype
CREATE TABLE IF NOT EXISTS `tbl_paytype` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `paytype_code` char(4) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `paytype_name` char(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `paytype_createdAt` timestamp NULL DEFAULT NULL,
  `paytype_updatedAt` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC;

-- Dumping data for table db_grubber.tbl_paytype: ~3 rows (approximately)
DELETE FROM `tbl_paytype`;
/*!40000 ALTER TABLE `tbl_paytype` DISABLE KEYS */;
INSERT INTO `tbl_paytype` (`id`, `paytype_code`, `paytype_name`, `paytype_createdAt`, `paytype_updatedAt`) VALUES
	(1, '0001', 'สด', '2020-05-20 19:32:23', NULL),
	(2, '0002', 'เชื่อ', '2020-05-20 19:38:12', NULL),
	(3, '0003', 'โอน', '2020-05-27 09:11:11', NULL);
/*!40000 ALTER TABLE `tbl_paytype` ENABLE KEYS */;

-- Dumping structure for table db_grubber.tbl_poprices
CREATE TABLE IF NOT EXISTS `tbl_poprices` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `poprice_ponumber` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `poprice_product` char(4) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `poprice_weight` float DEFAULT NULL,
  `poprice_wgpallet` float DEFAULT NULL,
  `poprice_buyprice` float DEFAULT '0' COMMENT 'price per kg',
  `poprice_percentwater` float DEFAULT '0',
  `poprice_createdAt` timestamp NULL DEFAULT NULL,
  `poprice_updatedAt` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table db_grubber.tbl_poprices: ~11 rows (approximately)
DELETE FROM `tbl_poprices`;
/*!40000 ALTER TABLE `tbl_poprices` DISABLE KEYS */;
INSERT INTO `tbl_poprices` (`id`, `poprice_ponumber`, `poprice_product`, `poprice_weight`, `poprice_wgpallet`, `poprice_buyprice`, `poprice_percentwater`, `poprice_createdAt`, `poprice_updatedAt`) VALUES
	(1, '25631003001', '0001', 2146, 146, 54, 95, '2020-10-03 16:29:03', '2020-10-05 13:56:36'),
	(2, '25631003001', '0002', 1073, 73, 49.5, 97, '2020-10-03 16:29:30', '2020-10-07 09:56:55'),
	(3, '25631003001', '0003', 5565, 565, 53, 94, '2020-10-03 16:29:45', '2020-10-07 09:57:13'),
	(4, '25631003002', '0001', 8441, 511, 54, 96.8, '2020-10-03 18:50:13', '2020-10-05 09:24:22'),
	(5, '25631003002', '0002', 1210, 73, 49.5, 97, '2020-10-03 18:50:35', '2020-10-05 09:49:20'),
	(6, '25631003002', '0003', 6055, 438, 53, 96.4, '2020-10-03 18:50:48', NULL),
	(7, '25631007002', '0003', 2950, 219, 51.8, 96.4, '2020-10-07 16:26:29', NULL),
	(8, '25631007002', '0002', 1837, 146, 48, 0, '2020-10-07 16:27:16', NULL),
	(9, '25631007002', '0001', 5989, 365, 52.8, 96.8, '2020-10-07 16:27:36', NULL),
	(10, '25631007003', '0001', 2146, 146, 54, 96.8, '2020-10-07 21:25:21', NULL),
	(11, '25631007003', '0003', 6438, 438, 49.5, 96.4, '2020-10-07 21:25:49', NULL);
/*!40000 ALTER TABLE `tbl_poprices` ENABLE KEYS */;

-- Dumping structure for table db_grubber.tbl_prdtypes
CREATE TABLE IF NOT EXISTS `tbl_prdtypes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `prdtype_code` varchar(4) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `prdtype_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `prdtype_details` text COLLATE utf8mb4_general_ci,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `prdtype_code` (`prdtype_code`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

-- Dumping data for table db_grubber.tbl_prdtypes: ~2 rows (approximately)
DELETE FROM `tbl_prdtypes`;
/*!40000 ALTER TABLE `tbl_prdtypes` DISABLE KEYS */;
INSERT INTO `tbl_prdtypes` (`id`, `prdtype_code`, `prdtype_name`, `prdtype_details`) VALUES
	(1, '0001', 'ยางพารา', NULL),
	(2, '0002', 'ปาล์มน้ำมัน', '');
/*!40000 ALTER TABLE `tbl_prdtypes` ENABLE KEYS */;

-- Dumping structure for table db_grubber.tbl_products
CREATE TABLE IF NOT EXISTS `tbl_products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_code` varchar(4) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `product_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `product_group` char(4) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `product_order` int(4) DEFAULT NULL,
  `product_details` text COLLATE utf8mb4_general_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table db_grubber.tbl_products: ~7 rows (approximately)
DELETE FROM `tbl_products`;
/*!40000 ALTER TABLE `tbl_products` DISABLE KEYS */;
INSERT INTO `tbl_products` (`id`, `product_code`, `product_name`, `product_group`, `product_order`, `product_details`) VALUES
	(1, '0001', 'ยางแผ่นสวย (01)', '0001', 1, ''),
	(2, '0002', 'ยางแผ่นหนา (02)', '0001', 3, ''),
	(3, '0003', 'ยางแผ่นคละ (04)', '0001', 2, ''),
	(4, '0004', 'ยางฟอง', '0001', 6, NULL),
	(5, '0005', 'เศษยาง', '0001', 7, NULL),
	(6, '0006', 'ยางบล๊อก (1)', '0001', 4, ''),
	(7, '0007', 'ยางบล๊อก (2)', '0001', 5, '');
/*!40000 ALTER TABLE `tbl_products` ENABLE KEYS */;

-- Dumping structure for table db_grubber.tbl_purchaseorder
CREATE TABLE IF NOT EXISTS `tbl_purchaseorder` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `po_number` varchar(11) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `po_vlpn` char(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `po_suppcode` char(25) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `po_buytype` char(4) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `po_wgtype` char(4) COLLATE utf8_unicode_ci DEFAULT NULL,
  `po_wgscale` char(4) COLLATE utf8_unicode_ci DEFAULT NULL,
  `po_product` char(4) COLLATE utf8_unicode_ci DEFAULT NULL,
  `po_palletqty` tinyint(3) DEFAULT NULL,
  `po_palletwg` float DEFAULT NULL,
  `po_scalerd` float DEFAULT NULL,
  `po_netwg` float DEFAULT NULL,
  `po_vtype` char(4) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `po_prdgrp` char(4) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `po_creator` char(4) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT '0000' COMMENT '0->Thanos',
  `po_taxrubber` float DEFAULT '0',
  `po_labour` float DEFAULT '0',
  `po_status` tinyint(1) DEFAULT '1' COMMENT '0->Close,1->Open',
  `po_createdat` timestamp NULL DEFAULT NULL,
  `po_updatedat` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table db_grubber.tbl_purchaseorder: ~7 rows (approximately)
DELETE FROM `tbl_purchaseorder`;
/*!40000 ALTER TABLE `tbl_purchaseorder` DISABLE KEYS */;
INSERT INTO `tbl_purchaseorder` (`id`, `po_number`, `po_vlpn`, `po_suppcode`, `po_buytype`, `po_wgtype`, `po_wgscale`, `po_product`, `po_palletqty`, `po_palletwg`, `po_scalerd`, `po_netwg`, `po_vtype`, `po_prdgrp`, `po_creator`, `po_taxrubber`, `po_labour`, `po_status`, `po_createdat`, `po_updatedat`) VALUES
	(1, '25631003001', '70-7177', '000074', '0001', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0003', '0001', '0000', 0, 0.05, 0, '2020-10-03 12:20:53', '2021-07-26 15:04:32'),
	(2, '25631003002', '70-1326', '000006', '0003', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0003', '0001', '0000', 0, 0.05, 0, '2020-10-03 18:45:55', '2020-10-07 11:22:13'),
	(3, '25631007001', '80-5497', '000006', '0003', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0003', '0001', '0000', 0, 0.05, 0, '2020-10-07 15:23:37', '2021-03-27 10:36:06'),
	(4, '25631007002', '80-4676', '000006', '0003', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0003', '0001', '0000', 0, 0.05, 0, '2020-10-07 16:02:49', '2020-10-07 16:27:42'),
	(5, '25631007003', '70-7077', '000004', '0001', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0004', '0001', '0000', 0, 0.05, 0, '2020-10-07 21:13:05', '2021-03-27 10:35:56'),
	(6, '25640327001', '80-5497', '000006', '0003', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0003', '0001', '0000', 0, 0.05, 0, '2021-03-27 10:37:53', '2021-03-27 10:40:28'),
	(7, '25640327002', '8157', '20200519003161342', '0003', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0001', '0001', '0000', 0, 0.05, 1, '2021-03-27 10:42:53', '2021-07-26 15:04:53');
/*!40000 ALTER TABLE `tbl_purchaseorder` ENABLE KEYS */;

-- Dumping structure for table db_grubber.tbl_sellorder
CREATE TABLE IF NOT EXISTS `tbl_sellorder` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `so_number` char(11) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `so_custcode` char(6) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '0: other\n1: buy\n2: sale',
  `so_saletype` char(4) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'if buy doc_for=>supplier, \nif sale doc_for=>customer,\nif other doc_for=>other...',
  `so_vlpn` char(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `so_vtype` char(4) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `so_prdtype` char(4) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `so_creator` char(4) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `so_status` int(11) DEFAULT NULL,
  `so_createdAt` timestamp NULL DEFAULT NULL,
  `so_updatedAt` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table db_grubber.tbl_sellorder: ~0 rows (approximately)
DELETE FROM `tbl_sellorder`;
/*!40000 ALTER TABLE `tbl_sellorder` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_sellorder` ENABLE KEYS */;

-- Dumping structure for table db_grubber.tbl_stocks
CREATE TABLE IF NOT EXISTS `tbl_stocks` (
  `stock_ponum` char(11) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0',
  `stock_product` char(4) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `stock_locaton` char(4) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0',
  `stock_weight` double DEFAULT NULL,
  `stock_update` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `stock_whoup` char(4) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT '0000',
  `stock_prcpior` int(11) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table db_grubber.tbl_stocks: ~0 rows (approximately)
DELETE FROM `tbl_stocks`;
/*!40000 ALTER TABLE `tbl_stocks` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_stocks` ENABLE KEYS */;

-- Dumping structure for table db_grubber.tbl_suppliers
CREATE TABLE IF NOT EXISTS `tbl_suppliers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `supp_code` char(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `supp_category` varchar(4) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '1',
  `supp_name` varchar(150) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `supp_surname` varchar(150) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `supp_address` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `supp_amphoe` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `supp_province` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `supp_zipcode` char(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `supp_details` text COLLATE utf8_unicode_ci,
  `supp_phone` char(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `supp_email` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `supp_line` char(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `supp_createdat` timestamp NULL DEFAULT NULL,
  `supp_updatedat` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `old_code` varchar(6) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `supp_code` (`supp_code`)
) ENGINE=InnoDB AUTO_INCREMENT=85 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table db_grubber.tbl_suppliers: ~78 rows (approximately)
DELETE FROM `tbl_suppliers`;
/*!40000 ALTER TABLE `tbl_suppliers` DISABLE KEYS */;
INSERT INTO `tbl_suppliers` (`id`, `supp_code`, `supp_category`, `supp_name`, `supp_surname`, `supp_address`, `supp_amphoe`, `supp_province`, `supp_zipcode`, `supp_details`, `supp_phone`, `supp_email`, `supp_line`, `supp_createdat`, `supp_updatedat`, `old_code`) VALUES
	(1, '20200519001141559', '0001', 'ฤทัยชนก', 'เทียมสภา', '', '', '', '', '', '0898178790', NULL, '0898178790', '2020-05-19 14:15:59', '2021-07-23 12:56:56', '000001'),
	(2, '20200519002141807', '0003', 'วรจิต', 'สายแก้ว', NULL, NULL, NULL, NULL, NULL, '0927957771', NULL, '0927957771', '2020-05-19 14:18:07', '2021-07-23 09:31:15', '000002'),
	(3, '20200519003161342', '0002', 'นันทชัย', 'เอื้องมี', '', '', '', '', '', '0893923994', '', '0893923994', '2020-05-19 16:13:42', '2021-07-23 12:59:52', '000003'),
	(4, '20200519004164649', '0001', 'ขจร', 'แซ่หลี', NULL, NULL, NULL, NULL, NULL, '0818924845', NULL, '0818924845', '2020-05-19 16:46:49', '2021-07-23 09:31:15', '000004'),
	(5, '20200520005102954', '0001', 'นางกัลยา', 'จักรกฤษ', NULL, NULL, NULL, NULL, NULL, '0853334944', NULL, '0853334944', '2020-05-20 10:29:54', '2021-07-23 09:31:15', '000005'),
	(6, '20200520006103228', '0001', 'นายกานต์', 'สนพิภพ', NULL, NULL, 'ชุมพร', NULL, NULL, '0872704629', NULL, '0872704629', '2020-05-20 10:32:28', '2021-07-23 10:11:55', '000006'),
	(7, '20200520007104956', '0001', 'นางสาวสุวิตา', 'กังวานสุระ', NULL, NULL, NULL, NULL, NULL, '0918264800', NULL, '0918264800', '2020-05-20 10:49:56', '2021-07-23 09:31:15', '000007'),
	(8, '20200520008105139', '0001', 'ฐิติวรรณ', 'กังวานสุระ', NULL, NULL, NULL, NULL, NULL, '0899266501', NULL, '0899266501', '2020-05-20 10:51:39', '2021-07-23 09:31:15', '000008'),
	(10, '20200520010105749', '0001', 'สมจิตร', 'ขนบธรรมคุณ', NULL, NULL, NULL, NULL, NULL, '0647166662', NULL, '0647166662', '2020-05-20 10:57:49', '2021-07-23 09:31:15', '000009'),
	(11, '20200520011105959', '0001', 'มนตรี', 'ภูษณะเบญญา', NULL, NULL, NULL, NULL, NULL, '0872659922', NULL, '0872659922', '2020-05-20 10:59:59', '2021-07-23 09:31:15', '000011'),
	(12, '20200527012092952', '0001', 'นาท', 'ตั้งสัจจะธรรม', NULL, NULL, NULL, NULL, NULL, '0815365614', NULL, '0815365614', '2020-05-27 09:29:52', '2021-07-23 09:31:15', '000012'),
	(13, '20200527013093051', '0001', 'พรรณี', 'ตันติสุวรรณกิจ', NULL, NULL, NULL, NULL, NULL, '0818958058', NULL, '0818958058', '2020-05-27 09:30:51', '2021-07-23 09:31:15', '000013'),
	(14, '20200527014093144', '0002', 'จรูญ', 'พันธ์ถาวรวงศ์', NULL, NULL, NULL, NULL, NULL, '0872682611', NULL, '0872682611', '2020-05-27 09:31:44', '2021-07-23 09:31:15', '000014'),
	(15, '20200527015093249', '0001', 'กฤษฎากร', 'ไชยเดช', NULL, NULL, NULL, NULL, NULL, '0822502312', NULL, '0822502312', '2020-05-27 09:32:49', '2021-07-23 09:31:15', '000015'),
	(16, '20200527016093338', '0001', 'กษิมา', 'แซ่เอี้ยะ', NULL, NULL, NULL, NULL, NULL, '0819582485', NULL, '0819582485', '2020-05-27 09:33:38', '2021-07-23 09:31:15', '000016'),
	(17, '20200527017093451', '0001', 'กำพร', 'เอื้องเรืองโรจน์', NULL, NULL, NULL, NULL, NULL, '0819682732', NULL, '0819682732', '2020-05-27 09:34:51', '2021-07-23 09:31:15', '000017'),
	(18, '20200527018093523', '0001', 'จรัญ', 'ช่วยชื่น', NULL, NULL, NULL, NULL, NULL, '0910343789', NULL, '0910343789', '2020-05-27 09:35:23', '2021-07-23 09:31:15', '000018'),
	(19, '20200527019093607', '0001', 'จิต  ', 'แสงสุวรรณ', NULL, NULL, NULL, NULL, NULL, '', NULL, '', '2020-05-27 09:36:07', '2021-07-23 09:31:15', '000019'),
	(20, '20200527020093802', '0001', 'ธงชัย', 'ใจดี', NULL, NULL, NULL, NULL, NULL, '0878958381', NULL, '0878958381', '2020-05-27 09:38:02', '2021-07-23 09:31:15', '000020'),
	(21, '20200527021093848', '0001', 'นคร', 'แซ่ติ้ง', NULL, NULL, NULL, NULL, NULL, '0815252882', NULL, '0815252882', '2020-05-27 09:38:48', '2021-07-23 09:31:15', '000021'),
	(22, '20200527022093947', '0001', 'นุชธิอร', 'เหล่าพัทรเกษม', NULL, NULL, NULL, NULL, NULL, '0878833532', NULL, '0878833532', '2020-05-27 09:39:47', '2021-07-23 09:31:15', '000022'),
	(23, '20200527023094055', '0001', 'บุญชู', 'ชาญชัยวัฒน์', NULL, NULL, NULL, NULL, NULL, '0818940385', NULL, '0818940385', '2020-05-27 09:40:55', '2021-07-23 09:31:15', '000023'),
	(24, '20200527024094152', '0001', 'มณฑา', 'แซ่หลี', NULL, NULL, NULL, NULL, NULL, '0936644942', NULL, '0936644942', '2020-05-27 09:41:52', '2021-07-23 09:31:15', '000024'),
	(25, '20200527025094244', '0002', 'วรภพ', 'งามอิทธิ', NULL, NULL, NULL, NULL, NULL, '0982648928', NULL, '0982648928', '2020-05-27 09:42:44', '2021-07-23 09:31:15', '000025'),
	(26, '20200527026094555', '0001', 'วันพุธ', '', NULL, NULL, NULL, NULL, NULL, '0910379838', NULL, '0910379838', '2020-05-27 09:45:55', '2021-07-23 09:31:15', '000026'),
	(27, '20200527027094805', '0001', 'วิเชียร', 'วิทยาวานิชชัย', NULL, NULL, NULL, NULL, NULL, '0819701107', NULL, '0819701107', '2020-05-27 09:48:05', '2021-07-23 09:31:15', '000027'),
	(28, '20200527028094905', '0001', 'ศราวุธ', 'นาวีว่อง', NULL, NULL, NULL, NULL, NULL, '0818923075', NULL, '0818923075', '2020-05-27 09:49:05', '2021-07-23 09:31:15', '000028'),
	(29, '20200527029094958', '0001', 'ศุภรัตน์', 'ทองรอด', NULL, NULL, NULL, NULL, NULL, '0952593464', NULL, '0952593464', '2020-05-27 09:49:58', '2021-07-23 09:31:15', '000029'),
	(30, '20200527030095050', '0001', 'ศิขริน ', 'อุษณกรกุล', NULL, NULL, NULL, NULL, NULL, '0817372484', NULL, '0817372484', '2020-05-27 09:50:50', '2021-07-23 09:31:15', '000030'),
	(31, '20200527031095149', '0001', 'สมบูรณ์', 'วิริยะวารี', NULL, NULL, NULL, NULL, NULL, '0816773700', NULL, '0816773700', '2020-05-27 09:51:49', '2021-07-23 09:31:15', '000031'),
	(32, '20200527032095238', '0001', 'สารภี', 'มือสันทัด', NULL, NULL, NULL, NULL, NULL, '0801443920', NULL, '0801443920', '2020-05-27 09:52:38', '2021-07-23 09:31:15', '000032'),
	(33, '20200527033095336', '0001', 'สุจิต', 'กิตตินิรนาถ', NULL, NULL, NULL, NULL, NULL, '0819793390', NULL, '0819793390', '2020-05-27 09:53:36', '2021-07-23 09:31:15', '000033'),
	(34, '20200527034095413', '0001', 'สุจินดา', 'โกยทอง', NULL, NULL, NULL, NULL, NULL, '0619979829', NULL, '0619979829', '2020-05-27 09:54:13', '2021-07-23 09:31:15', '000034'),
	(35, '20200527035095609', '0001', 'สุรสิทธิ์', 'แซ่ติ้ง', NULL, NULL, NULL, NULL, NULL, '0869545353', NULL, '0869545353', '2020-05-27 09:56:09', '2021-07-23 09:31:15', '000035'),
	(36, '20200527036095704', '0001', 'ไสว', 'ช่วยยก', NULL, NULL, NULL, NULL, NULL, '0872736293', NULL, '0872736293', '2020-05-27 09:57:04', '2021-07-23 09:31:15', '000036'),
	(37, '20200527037095739', '0001', 'อภิชัย', 'เตือนวีระเดช', NULL, NULL, NULL, NULL, NULL, '0871510963', NULL, '0871510963', '2020-05-27 09:57:39', '2021-07-23 09:31:15', '000037'),
	(38, '20200527038095815', '0001', 'อรพรรณ', 'จันทร์วิไล', NULL, NULL, NULL, NULL, NULL, '0950959579', NULL, '0950959579', '2020-05-27 09:58:15', '2021-07-23 09:31:15', '000038'),
	(39, '20200527039095853', '0001', 'อรุณรุ่ง', 'อริยวงศ์', NULL, NULL, NULL, NULL, NULL, '0817979554', NULL, '0817979554', '2020-05-27 09:58:53', '2021-07-23 09:31:15', '000039'),
	(40, '20200527040095934', '0001', 'อาคม', 'ศุภกิจธนวัตน์', NULL, NULL, NULL, NULL, NULL, '0843306712', NULL, '0843306712', '2020-05-27 09:59:34', '2021-07-23 09:31:15', '000040'),
	(41, '20200527041100015', '0001', 'อุดมศักดิ์', 'แซ่เอียะ', NULL, NULL, NULL, NULL, NULL, '0957929615', NULL, '0957929615', '2020-05-27 10:00:15', '2021-07-23 09:31:15', '000041'),
	(42, '20200527042100210', '0001', 'นิวัฒน์', 'บุญอยู่', NULL, NULL, NULL, NULL, NULL, '0934659581', NULL, '0934659581', '2020-05-27 10:02:10', '2021-07-23 09:31:15', '000042'),
	(43, '20200527043100356', '0001', 'จุฑาธร', 'หงอสกุล', NULL, NULL, NULL, NULL, NULL, '0872666959', NULL, '0872666959', '2020-05-27 10:03:56', '2021-07-23 09:31:15', '000043'),
	(44, '20200527044100534', '0001', 'วสิยา', 'แสงแก้ว', NULL, NULL, NULL, NULL, NULL, '0909199294', NULL, '0909199294', '2020-05-27 10:05:34', '2021-07-23 09:31:15', '000044'),
	(45, '20200527045100631', '0002', 'ป้ามาลี', '', NULL, NULL, NULL, NULL, NULL, '0954288750', NULL, '', '2020-05-27 10:06:31', '2021-07-23 09:31:15', '000045'),
	(46, '20200527046100830', '0002', 'นพดล', 'พันธ์ถาวรวงศ์', NULL, NULL, NULL, NULL, NULL, '0872682611', NULL, '0872682611', '2020-05-27 10:08:30', '2021-07-23 09:31:15', '000046'),
	(48, '20200527048100935', '0002', 'วิกานดา', '', NULL, NULL, NULL, NULL, NULL, '0924217280', NULL, '0924217280', '2020-05-27 10:09:35', '2021-07-23 09:31:15', '000047'),
	(49, '20200527049101008', '0002', 'นิตยา', '', NULL, NULL, NULL, NULL, NULL, '0968875639', NULL, '0968875639', '2020-05-27 10:10:08', '2021-07-23 09:31:15', '000049'),
	(50, '20200527050101036', '0002', 'พี่ขิง', '', NULL, NULL, NULL, NULL, NULL, '0810901922', NULL, '0810901922', '2020-05-27 10:10:36', '2021-07-23 09:31:15', '000050'),
	(51, '20200527051101106', '0001', 'พี่เสี่ย', '', NULL, NULL, NULL, NULL, NULL, '0862814451', NULL, '0862814451', '2020-05-27 10:11:06', '2021-07-23 09:31:15', '000051'),
	(52, '20200527052101302', '0002', 'ประสิทธิ์', 'ลิ้มปิ่นเพชร', NULL, NULL, NULL, NULL, NULL, '0947272999', NULL, '0947272999', '2020-05-27 10:13:02', '2021-07-23 09:31:15', '000052'),
	(53, '20200527053101330', '0002', 'ประสงค์', '', NULL, NULL, NULL, NULL, NULL, '0817209541', NULL, '0817209541', '2020-05-27 10:13:30', '2021-07-23 09:31:15', '000053'),
	(54, '20200527054101351', '0002', 'ประเสริฐ', '', NULL, NULL, NULL, NULL, NULL, '', NULL, '', '2020-05-27 10:13:51', '2021-07-23 09:31:15', '000054'),
	(55, '20200527055101411', '0002', 'โกลก', '', NULL, NULL, NULL, NULL, NULL, '0818602289', NULL, '0818602289', '2020-05-27 10:14:11', '2021-07-23 09:31:15', '000055'),
	(56, '20200527056101525', '0002', 'โกทุ้ง', '', NULL, NULL, NULL, NULL, NULL, '', NULL, '', '2020-05-27 10:15:25', '2021-07-23 09:31:15', '000056'),
	(57, '20200527057101551', '0002', 'โกควั่น', '', NULL, NULL, NULL, NULL, NULL, '0878854274', NULL, '0878854274', '2020-05-27 10:15:51', '2021-07-23 09:31:15', '000057'),
	(58, '20200527058101614', '0002', 'โกแว่น', '', NULL, NULL, NULL, NULL, NULL, '0819568316', NULL, '0819568316', '2020-05-27 10:16:14', '2021-07-23 09:31:15', '000058'),
	(59, '20200527059101626', '0002', 'ป้านอม', '', NULL, NULL, NULL, NULL, NULL, '', NULL, '', '2020-05-27 10:16:26', '2021-07-23 09:31:15', '000059'),
	(60, '20200527060101726', '0002', 'วีรศักดิ์', 'อัคราวณิชย์', NULL, NULL, NULL, NULL, NULL, '0813967997', NULL, '0813967997', '2020-05-27 10:17:26', '2021-07-23 09:31:15', '000060'),
	(61, '20200527061101757', '0002', 'ชูศรี', 'ธวัชดำ', NULL, NULL, NULL, NULL, NULL, '0862737396', NULL, '0862737396', '2020-05-27 10:17:57', '2021-07-23 09:31:15', '000061'),
	(62, '20200527062101904', '0001', 'สุทัศน์', 'แสงพยัคฆ์', NULL, NULL, NULL, NULL, NULL, '0898716910', NULL, '0898716910', '2020-05-27 10:19:04', '2021-07-23 09:31:15', '000062'),
	(63, '20200527063101959', '0002', 'ธีรพงษ์', 'อุษณพงศ์', NULL, NULL, NULL, NULL, NULL, '0631065198', NULL, '0631065198', '2020-05-27 10:19:59', '2021-07-23 09:31:15', '000063'),
	(64, '20200527064102041', '0003', 'สกย.ปะทิว', '', NULL, NULL, NULL, NULL, NULL, '0833179794', NULL, '0833179794', '2020-05-27 10:20:41', '2021-07-23 09:31:15', '000064'),
	(65, '20200527065102235', '0001', 'ชยพล', 'ยืนยง', NULL, NULL, NULL, NULL, NULL, '0809524241', NULL, '0809524241', '2020-05-27 10:22:35', '2021-07-23 09:31:15', '000065'),
	(66, '20200527066102342', '0002', 'วรภพ', 'งามอิทธิ', NULL, NULL, NULL, NULL, NULL, '0982648928', NULL, '0982648928', '2020-05-27 10:23:42', '2021-07-23 09:31:15', '000066'),
	(67, '20200527067102519', '0002', 'รัชดา', 'รุ่งบรรณพันธุ์', NULL, NULL, NULL, NULL, NULL, '0828117717', NULL, '0828117717', '2020-05-27 10:25:19', '2021-07-23 09:31:15', '000067'),
	(68, '20200527068102545', '0001', 'นรินทร์', 'รุ่งบรรณพันธุ์', NULL, NULL, NULL, NULL, NULL, '0819780320', NULL, '0819780320', '2020-05-27 10:25:45', '2021-07-23 09:31:15', '000068'),
	(69, '20200527069102832', '0001', 'ณรงค์', 'สื่อมโนธรรม', NULL, NULL, NULL, NULL, NULL, '0800569938', NULL, '0800569938', '2020-05-27 10:28:32', '2021-07-23 09:31:15', '000069'),
	(70, '20200527070102932', '0002', 'กิติกร', 'ปภากรพีรกุล', NULL, NULL, NULL, NULL, NULL, '', NULL, '', '2020-05-27 10:29:32', '2021-07-23 09:31:15', '000070'),
	(71, '20200527071103035', '0003', 'สกย.ดอนยาง', '', NULL, NULL, NULL, NULL, NULL, '0895866866', NULL, '0895866866', '2020-05-27 10:30:35', '2021-07-23 09:31:15', '000071'),
	(72, '20200527072103232', '0003', 'สกย.สามร้อยยอด', '', NULL, NULL, NULL, NULL, NULL, '0999852942', NULL, '0999852942', '2020-05-27 10:32:32', '2021-07-23 09:31:15', '000072'),
	(73, '20200527073103352', '0003', 'สกย.ทองผาภูมิ', '', NULL, NULL, NULL, NULL, NULL, '0819810157', NULL, '0819810157', '2020-05-27 10:33:52', '2021-07-23 09:31:15', '000073'),
	(74, '20200527074103444', '0002', 'วิทูรย์', 'โรจเรณุมาศ', NULL, NULL, NULL, NULL, NULL, '0643365060', NULL, '0643365060', '2020-05-27 10:34:44', '2021-07-23 09:31:15', '000074'),
	(75, '20200527075103521', '0001', 'สวัสดิ์', 'โรจเรณุมาศ', NULL, NULL, NULL, NULL, NULL, '', NULL, '', '2020-05-27 10:35:21', '2021-07-23 09:31:15', '000075'),
	(76, '20200527076103909', '0002', 'ปฏิภาณ', 'เขจรบุตร', NULL, NULL, NULL, NULL, NULL, '0936688459', NULL, '0936688459', '2020-05-27 10:39:09', '2021-07-23 09:31:15', '000076'),
	(77, '20200527077103928', '0002', 'โลมา', '', NULL, NULL, NULL, NULL, NULL, '', NULL, '', '2020-05-27 10:39:28', '2021-07-23 09:31:15', '000077'),
	(78, '20200529078161459', '0001', 'เมตตา', '', NULL, NULL, NULL, NULL, NULL, '0803275639', NULL, '0803275639', '2020-05-29 16:14:59', '2021-07-23 09:31:15', '000078'),
	(79, '20200529079161707', '0001', 'ชุมพล', '', NULL, NULL, NULL, NULL, NULL, '', NULL, '', '2020-05-29 16:17:07', '2021-07-23 09:31:15', '000079'),
	(80, '20200529080161832', '0001', 'สุจิน', '', NULL, NULL, NULL, NULL, NULL, '', NULL, '', '2020-05-29 16:18:32', '2021-07-23 09:31:15', '000080');
/*!40000 ALTER TABLE `tbl_suppliers` ENABLE KEYS */;

-- Dumping structure for table db_grubber.tbl_suppliers_copy
CREATE TABLE IF NOT EXISTS `tbl_suppliers_copy` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `supp_code` varchar(6) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `supp_category` varchar(4) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '1',
  `supp_name` varchar(150) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `supp_surname` varchar(150) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `supp_phone` varchar(22) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `supp_line` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `supp_createdat` timestamp NULL DEFAULT NULL,
  `supp_updatedat` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `new_code` char(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `new_time` char(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `supp_code` (`supp_code`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=81 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC;

-- Dumping data for table db_grubber.tbl_suppliers_copy: ~78 rows (approximately)
DELETE FROM `tbl_suppliers_copy`;
/*!40000 ALTER TABLE `tbl_suppliers_copy` DISABLE KEYS */;
INSERT INTO `tbl_suppliers_copy` (`id`, `supp_code`, `supp_category`, `supp_name`, `supp_surname`, `supp_phone`, `supp_line`, `supp_createdat`, `supp_updatedat`, `new_code`, `new_time`) VALUES
	(1, '000001', '0001', 'ฤทัยชนก', 'เทียมสภา', '0898178790', '0898178790', '2020-05-19 14:15:59', '2020-11-10 15:26:20', NULL, NULL),
	(2, '000002', '0003', 'วรจิต', 'สายแก้ว', '0927957771', '0927957771', '2020-05-19 14:18:07', '2020-05-27 12:33:53', NULL, NULL),
	(3, '000003', '0002', 'นันทชัย', 'เอื้องมี', '0893923994', '0893923994', '2020-05-19 16:13:42', '2020-05-27 12:33:45', NULL, NULL),
	(4, '000004', '0001', 'ขจร', 'แซ่หลี', '0818924845', '0818924845', '2020-05-19 16:46:49', '2020-06-11 12:50:24', NULL, NULL),
	(5, '000005', '0001', 'นางกัลยา', 'จักรกฤษ', '0853334944', '0853334944', '2020-05-20 10:29:54', '2020-09-18 12:31:06', NULL, NULL),
	(6, '000006', '0001', 'นายกานต์', 'สนพิภพ', '0872704629', '0872704629', '2020-05-20 10:32:28', '2020-09-18 12:31:30', NULL, NULL),
	(7, '000007', '0001', 'นางสาวสุวิตา', 'กังวานสุระ', '0918264800', '0918264800', '2020-05-20 10:49:56', '2020-09-21 06:23:58', NULL, NULL),
	(8, '000008', '0001', 'ฐิติวรรณ', 'กังวานสุระ', '0899266501', '0899266501', '2020-05-20 10:51:39', '2020-11-09 16:51:17', NULL, NULL),
	(10, '000009', '0001', 'สมจิตร', 'ขนบธรรมคุณ', '0647166662', '0647166662', '2020-05-20 10:57:49', '2020-09-18 12:31:15', NULL, NULL),
	(11, '000011', '0001', 'มนตรี', 'ภูษณะเบญญา', '0872659922', '0872659922', '2020-05-20 10:59:59', '2020-05-31 19:02:31', NULL, NULL),
	(12, '000012', '0001', 'นาท', 'ตั้งสัจจะธรรม', '0815365614', '0815365614', '2020-05-27 09:29:52', '2020-05-31 19:06:53', NULL, NULL),
	(13, '000013', '0001', 'พรรณี', 'ตันติสุวรรณกิจ', '0818958058', '0818958058', '2020-05-27 09:30:51', '2020-11-09 16:51:17', NULL, NULL),
	(14, '000014', '0002', 'จรูญ', 'พันธ์ถาวรวงศ์', '0872682611', '0872682611', '2020-05-27 09:31:44', '2020-11-09 16:51:17', NULL, NULL),
	(15, '000015', '0001', 'กฤษฎากร', 'ไชยเดช', '0822502312', '0822502312', '2020-05-27 09:32:49', '2020-11-09 16:51:17', NULL, NULL),
	(16, '000016', '0001', 'กษิมา', 'แซ่เอี้ยะ', '0819582485', '0819582485', '2020-05-27 09:33:38', '2020-11-09 16:51:17', NULL, NULL),
	(17, '000017', '0001', 'กำพร', 'เอื้องเรืองโรจน์', '0819682732', '0819682732', '2020-05-27 09:34:51', '2020-11-09 16:51:17', NULL, NULL),
	(18, '000018', '0001', 'จรัญ', 'ช่วยชื่น', '0910343789', '0910343789', '2020-05-27 09:35:23', '2020-11-09 16:51:17', NULL, NULL),
	(19, '000019', '0001', 'จิต  ', 'แสงสุวรรณ', '', '', '2020-05-27 09:36:07', '2020-11-09 16:51:17', NULL, NULL),
	(20, '000020', '0001', 'ธงชัย', 'ใจดี', '0878958381', '0878958381', '2020-05-27 09:38:02', '2020-11-09 16:51:17', NULL, NULL),
	(21, '000021', '0001', 'นคร', 'แซ่ติ้ง', '0815252882', '0815252882', '2020-05-27 09:38:48', '2020-11-09 16:51:17', NULL, NULL),
	(22, '000022', '0001', 'นุชธิอร', 'เหล่าพัทรเกษม', '0878833532', '0878833532', '2020-05-27 09:39:47', '2020-11-09 16:51:17', NULL, NULL),
	(23, '000023', '0001', 'บุญชู', 'ชาญชัยวัฒน์', '0818940385', '0818940385', '2020-05-27 09:40:55', '2020-11-09 16:51:17', NULL, NULL),
	(24, '000024', '0001', 'มณฑา', 'แซ่หลี', '0936644942', '0936644942', '2020-05-27 09:41:52', '2020-11-09 16:51:17', NULL, NULL),
	(25, '000025', '0002', 'วรภพ', 'งามอิทธิ', '0982648928', '0982648928', '2020-05-27 09:42:44', '2020-11-09 16:51:17', NULL, NULL),
	(26, '000026', '0001', 'วันพุธ', '', '0910379838', '0910379838', '2020-05-27 09:45:55', '2020-11-09 16:51:17', NULL, NULL),
	(27, '000027', '0001', 'วิเชียร', 'วิทยาวานิชชัย', '0819701107', '0819701107', '2020-05-27 09:48:05', '2020-11-09 16:51:17', NULL, NULL),
	(28, '000028', '0001', 'ศราวุธ', 'นาวีว่อง', '0818923075', '0818923075', '2020-05-27 09:49:05', '2020-11-09 16:51:17', NULL, NULL),
	(29, '000029', '0001', 'ศุภรัตน์', 'ทองรอด', '0952593464', '0952593464', '2020-05-27 09:49:58', '2020-11-09 16:51:17', NULL, NULL),
	(30, '000030', '0001', 'ศิขริน ', 'อุษณกรกุล', '0817372484', '0817372484', '2020-05-27 09:50:50', '2020-11-09 16:51:17', NULL, NULL),
	(31, '000031', '0001', 'สมบูรณ์', 'วิริยะวารี', '0816773700', '0816773700', '2020-05-27 09:51:49', '2020-11-09 16:51:17', NULL, NULL),
	(32, '000032', '0001', 'สารภี', 'มือสันทัด', '0801443920', '0801443920', '2020-05-27 09:52:38', '2020-11-09 16:51:17', NULL, NULL),
	(33, '000033', '0001', 'สุจิต', 'กิตตินิรนาถ', '0819793390', '0819793390', '2020-05-27 09:53:36', '2020-11-09 16:51:17', NULL, NULL),
	(34, '000034', '0001', 'สุจินดา', 'โกยทอง', '0619979829', '0619979829', '2020-05-27 09:54:13', '2020-11-09 16:51:17', NULL, NULL),
	(35, '000035', '0001', 'สุรสิทธิ์', 'แซ่ติ้ง', '0869545353', '0869545353', '2020-05-27 09:56:09', '2020-11-09 16:51:17', NULL, NULL),
	(36, '000036', '0001', 'ไสว', 'ช่วยยก', '0872736293', '0872736293', '2020-05-27 09:57:04', '2020-11-09 16:51:17', NULL, NULL),
	(37, '000037', '0001', 'อภิชัย', 'เตือนวีระเดช', '0871510963', '0871510963', '2020-05-27 09:57:39', '2020-11-09 16:51:17', NULL, NULL),
	(38, '000038', '0001', 'อรพรรณ', 'จันทร์วิไล', '0950959579', '0950959579', '2020-05-27 09:58:15', '2020-11-09 16:51:17', NULL, NULL),
	(39, '000039', '0001', 'อรุณรุ่ง', 'อริยวงศ์', '0817979554', '0817979554', '2020-05-27 09:58:53', '2020-11-09 16:51:17', NULL, NULL),
	(40, '000040', '0001', 'อาคม', 'ศุภกิจธนวัตน์', '0843306712', '0843306712', '2020-05-27 09:59:34', '2020-11-09 16:51:17', NULL, NULL),
	(41, '000041', '0001', 'อุดมศักดิ์', 'แซ่เอียะ', '0957929615', '0957929615', '2020-05-27 10:00:15', '2020-11-09 16:51:17', NULL, NULL),
	(42, '000042', '0001', 'นิวัฒน์', 'บุญอยู่', '0934659581', '0934659581', '2020-05-27 10:02:10', '2020-11-09 16:51:17', NULL, NULL),
	(43, '000043', '0001', 'จุฑาธร', 'หงอสกุล', '0872666959', '0872666959', '2020-05-27 10:03:56', '2020-11-09 16:51:17', NULL, NULL),
	(44, '000044', '0001', 'วสิยา', 'แสงแก้ว', '0909199294', '0909199294', '2020-05-27 10:05:34', '2020-11-09 16:51:17', NULL, NULL),
	(45, '000045', '0002', 'ป้ามาลี', '', '0954288750', '', '2020-05-27 10:06:31', '2020-11-09 16:51:17', NULL, NULL),
	(46, '000046', '0002', 'นพดล', 'พันธ์ถาวรวงศ์', '0872682611', '0872682611', '2020-05-27 10:08:30', '2020-11-09 16:51:17', NULL, NULL),
	(48, '000047', '0002', 'วิกานดา', '', '0924217280', '0924217280', '2020-05-27 10:09:35', '2020-11-09 16:51:17', NULL, NULL),
	(49, '000049', '0002', 'นิตยา', '', '0968875639', '0968875639', '2020-05-27 10:10:08', '2020-11-09 16:51:17', NULL, NULL),
	(50, '000050', '0002', 'พี่ขิง', '', '0810901922', '0810901922', '2020-05-27 10:10:36', '2020-11-09 16:51:17', NULL, NULL),
	(51, '000051', '0001', 'พี่เสี่ย', '', '0862814451', '0862814451', '2020-05-27 10:11:06', '2020-11-09 16:51:17', NULL, NULL),
	(52, '000052', '0002', 'ประสิทธิ์', 'ลิ้มปิ่นเพชร', '0947272999', '0947272999', '2020-05-27 10:13:02', '2020-11-09 16:51:17', NULL, NULL),
	(53, '000053', '0002', 'ประสงค์', '', '0817209541', '0817209541', '2020-05-27 10:13:30', '2020-11-09 16:51:17', NULL, NULL),
	(54, '000054', '0002', 'ประเสริฐ', '', '', '', '2020-05-27 10:13:51', '2020-11-09 16:51:17', NULL, NULL),
	(55, '000055', '0002', 'โกลก', '', '0818602289', '0818602289', '2020-05-27 10:14:11', '2020-11-09 16:51:17', NULL, NULL),
	(56, '000056', '0002', 'โกทุ้ง', '', '', '', '2020-05-27 10:15:25', '2020-11-09 16:51:17', NULL, NULL),
	(57, '000057', '0002', 'โกควั่น', '', '0878854274', '0878854274', '2020-05-27 10:15:51', '2020-11-09 16:51:17', NULL, NULL),
	(58, '000058', '0002', 'โกแว่น', '', '0819568316', '0819568316', '2020-05-27 10:16:14', '2020-11-09 16:51:17', NULL, NULL),
	(59, '000059', '0002', 'ป้านอม', '', '', '', '2020-05-27 10:16:26', '2020-11-09 16:51:17', NULL, NULL),
	(60, '000060', '0002', 'วีรศักดิ์', 'อัคราวณิชย์', '0813967997', '0813967997', '2020-05-27 10:17:26', '2020-11-09 16:51:17', NULL, NULL),
	(61, '000061', '0002', 'ชูศรี', 'ธวัชดำ', '0862737396', '0862737396', '2020-05-27 10:17:57', '2020-11-09 16:51:17', NULL, NULL),
	(62, '000062', '0001', 'สุทัศน์', 'แสงพยัคฆ์', '0898716910', '0898716910', '2020-05-27 10:19:04', '2020-11-09 16:51:17', NULL, NULL),
	(63, '000063', '0002', 'ธีรพงษ์', 'อุษณพงศ์', '0631065198', '0631065198', '2020-05-27 10:19:59', '2020-11-09 16:51:17', NULL, NULL),
	(64, '000064', '0003', 'สกย.ปะทิว', '', '0833179794', '0833179794', '2020-05-27 10:20:41', '2020-05-27 12:45:30', NULL, NULL),
	(65, '000065', '0001', 'ชยพล', 'ยืนยง', '0809524241', '0809524241', '2020-05-27 10:22:35', '2020-11-09 16:51:17', NULL, NULL),
	(66, '000066', '0002', 'วรภพ', 'งามอิทธิ', '0982648928', '0982648928', '2020-05-27 10:23:42', '2020-11-09 16:51:17', NULL, NULL),
	(67, '000067', '0002', 'รัชดา', 'รุ่งบรรณพันธุ์', '0828117717', '0828117717', '2020-05-27 10:25:19', '2020-11-09 16:51:17', NULL, NULL),
	(68, '000068', '0001', 'นรินทร์', 'รุ่งบรรณพันธุ์', '0819780320', '0819780320', '2020-05-27 10:25:45', '2020-11-09 16:51:17', NULL, NULL),
	(69, '000069', '0001', 'ณรงค์', 'สื่อมโนธรรม', '0800569938', '0800569938', '2020-05-27 10:28:32', '2020-11-09 16:51:17', NULL, NULL),
	(70, '000070', '0002', 'กิติกร', 'ปภากรพีรกุล', '', '', '2020-05-27 10:29:32', '2020-11-09 16:51:17', NULL, NULL),
	(71, '000071', '0003', 'สกย.ดอนยาง', '', '0895866866', '0895866866', '2020-05-27 10:30:35', '2020-05-27 12:43:36', NULL, NULL),
	(72, '000072', '0003', 'สกย.สามร้อยยอด', '', '0999852942', '0999852942', '2020-05-27 10:32:32', '2020-05-27 12:46:01', NULL, NULL),
	(73, '000073', '0003', 'สกย.ทองผาภูมิ', '', '0819810157', '0819810157', '2020-05-27 10:33:52', '2020-05-27 12:46:36', NULL, NULL),
	(74, '000074', '0002', 'วิทูรย์', 'โรจเรณุมาศ', '0643365060', '0643365060', '2020-05-27 10:34:44', '2020-11-09 16:51:17', NULL, NULL),
	(75, '000075', '0001', 'สวัสดิ์', 'โรจเรณุมาศ', '', '', '2020-05-27 10:35:21', '2020-11-09 16:51:17', NULL, NULL),
	(76, '000076', '0002', 'ปฏิภาณ', 'เขจรบุตร', '0936688459', '0936688459', '2020-05-27 10:39:09', '2020-11-09 16:51:17', NULL, NULL),
	(77, '000077', '0002', 'โลมา', '', '', '', '2020-05-27 10:39:28', '2020-11-09 16:51:17', NULL, NULL),
	(78, '000078', '0001', 'เมตตา', '', '0803275639', '0803275639', '2020-05-29 16:14:59', NULL, NULL, NULL),
	(79, '000079', '0001', 'ชุมพล', '', '', '', '2020-05-29 16:17:07', NULL, NULL, NULL),
	(80, '000080', '0001', 'สุจิน', '', '', '', '2020-05-29 16:18:32', NULL, NULL, NULL);
/*!40000 ALTER TABLE `tbl_suppliers_copy` ENABLE KEYS */;

-- Dumping structure for table db_grubber.tbl_supptypes
CREATE TABLE IF NOT EXISTS `tbl_supptypes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `supptype_code` varchar(4) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `supptype_name` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `supptype_createdAt` timestamp NULL DEFAULT NULL,
  `supptype_updatedAt` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `supptype_code` (`supptype_code`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table db_grubber.tbl_supptypes: ~3 rows (approximately)
DELETE FROM `tbl_supptypes`;
/*!40000 ALTER TABLE `tbl_supptypes` DISABLE KEYS */;
INSERT INTO `tbl_supptypes` (`id`, `supptype_code`, `supptype_name`, `supptype_createdAt`, `supptype_updatedAt`) VALUES
	(1, '0001', 'ชาวสวน', '2020-05-27 11:37:22', NULL),
	(2, '0002', 'ร้านยาง', '2020-05-27 11:37:35', '2020-11-09 19:41:41'),
	(3, '0003', 'ประมูล', '2020-05-27 12:00:44', NULL);
/*!40000 ALTER TABLE `tbl_supptypes` ENABLE KEYS */;

-- Dumping structure for table db_grubber.tbl_users
CREATE TABLE IF NOT EXISTS `tbl_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usercode` char(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `username` char(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `userpass` char(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `userlevel` char(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `usercode` (`usercode`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table db_grubber.tbl_users: ~1 rows (approximately)
DELETE FROM `tbl_users`;
/*!40000 ALTER TABLE `tbl_users` DISABLE KEYS */;
INSERT INTO `tbl_users` (`id`, `usercode`, `username`, `userpass`, `userlevel`) VALUES
	(1, '0001', 'thanos', '@dmin1234S', '1');
/*!40000 ALTER TABLE `tbl_users` ENABLE KEYS */;

-- Dumping structure for table db_grubber.tbl_vehicleowner
CREATE TABLE IF NOT EXISTS `tbl_vehicleowner` (
  `vehicle_lpn` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `supp_code` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table db_grubber.tbl_vehicleowner: ~0 rows (approximately)
DELETE FROM `tbl_vehicleowner`;
/*!40000 ALTER TABLE `tbl_vehicleowner` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_vehicleowner` ENABLE KEYS */;

-- Dumping structure for table db_grubber.tbl_vehicletype
CREATE TABLE IF NOT EXISTS `tbl_vehicletype` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `vehicletype_code` char(4) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `vehicletype_name` char(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `vehicletype_details` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC;

-- Dumping data for table db_grubber.tbl_vehicletype: ~5 rows (approximately)
DELETE FROM `tbl_vehicletype`;
/*!40000 ALTER TABLE `tbl_vehicletype` DISABLE KEYS */;
INSERT INTO `tbl_vehicletype` (`id`, `vehicletype_code`, `vehicletype_name`, `vehicletype_details`) VALUES
	(1, '0001', 'กระบะ', NULL),
	(2, '0002', 'พ่วงข้าง', NULL),
	(3, '0003', 'หกล้อ', NULL),
	(4, '0004', 'สิบล้อ', NULL),
	(5, '0005', 'เทรลเลอร์', NULL);
/*!40000 ALTER TABLE `tbl_vehicletype` ENABLE KEYS */;

-- Dumping structure for table db_grubber.tbl_weight
CREATE TABLE IF NOT EXISTS `tbl_weight` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `wg_reg4po` char(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `wg_4docno` char(11) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `wg_for` int(11) DEFAULT '1' COMMENT '0 for other,\n1 for buy,\n2 for sell',
  `wg_reg4prd` char(4) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `wg_value` float DEFAULT NULL,
  `wg_pallet` float DEFAULT '0',
  `wg_scaleno` char(4) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `prd_location` char(4) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `wg_createdAt` timestamp NULL DEFAULT NULL,
  `wg_updatedAt` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table db_grubber.tbl_weight: ~30 rows (approximately)
DELETE FROM `tbl_weight`;
/*!40000 ALTER TABLE `tbl_weight` DISABLE KEYS */;
INSERT INTO `tbl_weight` (`id`, `wg_reg4po`, `wg_4docno`, `wg_for`, `wg_reg4prd`, `wg_value`, `wg_pallet`, `wg_scaleno`, `prd_location`, `wg_createdAt`, `wg_updatedAt`) VALUES
	(1, '25631003001', NULL, 1, '0000', 10000, 0, '0000', '0001', '2020-10-03 12:20:53', '2020-10-07 14:47:32'),
	(2, '25631003001', NULL, 1, '0001', 2146, 146, '0001', '0001', '2020-10-03 12:21:50', '2020-10-07 14:47:35'),
	(3, '25631003001', NULL, 1, '0002', 1073, 73, '0001', '0001', '2020-10-03 12:23:07', '2020-10-07 14:47:38'),
	(4, '25631003001', NULL, 1, '0003', 5565, 565, '0001', '0001', '2020-10-03 12:23:57', '2020-10-07 14:47:44'),
	(5, '25631003001', NULL, 1, '9999', 3000, 0, '0000', '0001', '2020-10-03 12:24:30', '2020-10-07 14:47:45'),
	(6, '25631003002', NULL, 1, '0000', 24810, 0, '0000', '0001', '2020-10-03 18:45:55', '2020-10-07 14:47:47'),
	(7, '25631003002', NULL, 1, '0001', 8441, 511, '0001', '0001', '2020-10-03 18:46:53', '2020-10-07 14:47:49'),
	(8, '25631003002', NULL, 1, '0003', 6055, 438, '0001', '0001', '2020-10-03 18:47:28', '2020-10-07 14:47:50'),
	(9, '25631003002', NULL, 1, '0002', 1210, 73, '0001', '0001', '2020-10-03 18:47:47', '2020-10-07 14:47:52'),
	(10, '25631003002', NULL, 1, '9999', 10120, 0, '0000', '0001', '2020-10-03 18:48:24', '2020-10-07 14:47:53'),
	(11, '25631007001', NULL, 1, '0000', 15000, 0, '0000', '0001', '2020-10-07 15:23:37', '2020-10-07 15:51:14'),
	(12, '25631007001', NULL, 1, '0001', 4342, 292, '0001', '0001', '2020-10-07 15:24:24', '2020-10-07 15:51:19'),
	(13, '25631007001', NULL, 1, '0003', 1225, 73, '0001', '0001', '2020-10-07 15:24:45', '2020-10-07 15:51:22'),
	(14, '25631007001', NULL, 1, '0004', 4961, 365, '0001', '0001', '2020-10-07 15:25:10', '2020-10-07 15:51:25'),
	(15, '25631007001', NULL, 1, '9999', 5200, 0, '0000', '0001', '2020-10-07 15:46:23', '2020-10-07 15:51:27'),
	(17, '25631007002', NULL, 1, '0000', 15150, 0, '0000', NULL, '2020-10-07 16:02:49', NULL),
	(18, '25631007002', NULL, 1, '0001', 5989, 365, '0001', '0001', '2020-10-07 16:03:15', '2020-10-07 16:08:47'),
	(19, '25631007002', NULL, 1, '0003', 2950, 219, '0001', '0001', '2020-10-07 16:03:35', '2020-10-07 16:08:49'),
	(20, '25631007002', NULL, 1, '0002', 1837, 146, '0001', '0001', '2020-10-07 16:04:15', '2020-10-07 16:08:51'),
	(21, '25631007002', NULL, 1, '9999', 5090, 0, '0000', '0001', '2020-10-07 16:04:35', '2020-10-07 16:08:53'),
	(22, '25631007001', NULL, 1, '0001', 12345, 73, '0001', '1', '2020-10-07 16:13:08', NULL),
	(23, '25631007003', NULL, 1, '0000', 10000, 0, '0000', NULL, '2020-10-07 21:13:05', NULL),
	(24, '25631007003', NULL, 1, '0001', 2146, 146, '0001', '0001', '2020-10-07 21:13:56', NULL),
	(25, '25631007003', NULL, 1, '0003', 6438, 438, '0001', '0001', '2020-10-07 21:14:33', NULL),
	(26, '25631007003', NULL, 1, '9999', 2000, 0, '0000', '0001', '2020-10-07 21:14:50', NULL),
	(27, '25640327001', NULL, 1, '0000', 15240, 0, '0000', NULL, '2021-03-27 10:37:54', NULL),
	(28, '25631007001', NULL, 1, '0001', 15240, 0, '0001', '0001', '2021-03-27 10:39:42', NULL),
	(29, '25631007001', NULL, 1, '9999', 5170, 0, '0000', '0001', '2021-03-27 10:39:58', NULL),
	(30, '25640327002', NULL, 1, '0000', 15130, 0, '0000', NULL, '2021-03-27 10:42:53', NULL),
	(31, '25640327002', NULL, 1, '9999', 4740, 0, '0000', '0001', '2021-03-27 10:43:10', NULL);
/*!40000 ALTER TABLE `tbl_weight` ENABLE KEYS */;

-- Dumping structure for table db_grubber.tbl_wg4buy
CREATE TABLE IF NOT EXISTS `tbl_wg4buy` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `wg_ponum` varchar(17) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `wg_vlpn` char(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `wg_suppcode` char(17) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `wg_buytype` char(4) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `wg_type` char(4) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `wg_scale` char(4) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `wg_product` char(4) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `wg_palletqty` tinyint(3) DEFAULT NULL,
  `wg_eachpallet` float DEFAULT NULL,
  `wg_scalerd` float DEFAULT NULL,
  `wg_net` float DEFAULT NULL,
  `wg_createdat` timestamp NULL DEFAULT NULL,
  `po_status` tinyint(1) DEFAULT '1' COMMENT '0->Close,1->Open',
  `po_vtype` char(4) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `po_prdgrp` char(4) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `po_creator` char(4) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT '0000' COMMENT '0->Thanos',
  `po_taxrubber` float DEFAULT '0',
  `po_labour` float DEFAULT '0',
  `po_createdat` timestamp NULL DEFAULT NULL,
  `po_updatedat` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC;

-- Dumping data for table db_grubber.tbl_wg4buy: ~5 rows (approximately)
DELETE FROM `tbl_wg4buy`;
/*!40000 ALTER TABLE `tbl_wg4buy` DISABLE KEYS */;
INSERT INTO `tbl_wg4buy` (`id`, `wg_ponum`, `wg_vlpn`, `wg_suppcode`, `wg_buytype`, `wg_type`, `wg_scale`, `wg_product`, `wg_palletqty`, `wg_eachpallet`, `wg_scalerd`, `wg_net`, `wg_createdat`, `po_status`, `po_vtype`, `po_prdgrp`, `po_creator`, `po_taxrubber`, `po_labour`, `po_createdat`, `po_updatedat`) VALUES
	(1, '20210729001044252', 'สฐ-7621', '20200520010105749', '0001', '0002', '0002', '0001', 2, 78.11, 5242, 5085.78, '2021-07-29 04:43:36', 1, NULL, NULL, '0000', 0, 0, NULL, NULL),
	(2, '20210729001044252', 'สฐ-7621', '20200520010105749', '0002', '0002', '0002', '0003', 4, 71.23, 8540, 8255.08, '2021-07-29 05:07:58', 1, NULL, NULL, '0000', 0, 0, NULL, NULL),
	(3, '20210729001044252', 'สฐ-7621', '20200520010105749', '0003', '0002', '0002', '0003', 3, 71.39, 8446, 8231.83, '2021-07-29 10:39:40', 1, NULL, NULL, '0000', 0, 0, NULL, NULL),
	(4, '20210729004104004', 'มย-7845', '20200520008105139', '0004', '0001', '0001', '0000', 0, 0, 12452, 12452, '2021-07-29 10:40:31', 1, NULL, NULL, '0000', 0, 0, NULL, '2021-07-30 04:55:08'),
	(5, '20210729001044252', 'สฐ-7621', '20200520010105749', '', '0003', '0001', '0000', 0, 0, 7544, 7544, '2021-07-29 10:41:05', 1, NULL, NULL, '0000', 0, 0, NULL, NULL),
	(6, '20210805001111458', 'สฐ-7622', '20200527014093144', '0001', '0001', '0001', '0000', 0, 0, 12012, 12012, '2021-08-05 11:15:35', 1, NULL, NULL, '0000', 0, 0, NULL, NULL);
/*!40000 ALTER TABLE `tbl_wg4buy` ENABLE KEYS */;

-- Dumping structure for table db_grubber.tbl_wgscale
CREATE TABLE IF NOT EXISTS `tbl_wgscale` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `wgscale_code` char(4) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `wgscale_name` char(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `wgscale_level` char(1) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '1' COMMENT '0 for none palet, 1 for with palet',
  `wgscale_details` text CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table db_grubber.tbl_wgscale: ~3 rows (approximately)
DELETE FROM `tbl_wgscale`;
/*!40000 ALTER TABLE `tbl_wgscale` DISABLE KEYS */;
INSERT INTO `tbl_wgscale` (`id`, `wgscale_code`, `wgscale_name`, `wgscale_level`, `wgscale_details`) VALUES
	(1, '0001', 'เครื่องชั่งใหญ่ (ชั่งรถ)', '0', 'ชั่งน้ำหนักรถ'),
	(2, '0002', 'เครื่องชั่งเล็กที่ 1', '1', 'ใช้ชั่งแยกประเภทยางเข้าโกดัง'),
	(3, '0003', 'เครื่องชั่งเล็ก #2', '1', 'ใช้ชั่งแยกประเภทยางเข้าโกดัง');
/*!40000 ALTER TABLE `tbl_wgscale` ENABLE KEYS */;

-- Dumping structure for view db_grubber.view_summary
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `view_summary` (
	`Product` CHAR(4) NULL COLLATE 'utf8mb4_general_ci',
	`Weight` DOUBLE NULL,
	`Pallet` DOUBLE NULL,
	`Water` FLOAT NULL,
	`Price` FLOAT NULL COMMENT 'price per kg'
) ENGINE=MyISAM;

-- Dumping structure for view db_grubber.view_summary
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `view_summary`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `view_summary` AS select `tbl_poprices`.`poprice_product` AS `Product`,sum(`tbl_poprices`.`poprice_weight`) AS `Weight`,sum(`tbl_poprices`.`poprice_wgpallet`) AS `Pallet`,`tbl_poprices`.`poprice_percentwater` AS `Water`,`tbl_poprices`.`poprice_buyprice` AS `Price` from `tbl_poprices` where (`tbl_poprices`.`poprice_ponumber` = 25631007003) group by `tbl_poprices`.`poprice_product`,`tbl_poprices`.`poprice_buyprice`,`tbl_poprices`.`poprice_percentwater`;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
