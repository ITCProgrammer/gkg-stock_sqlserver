/*
Navicat MySQL Data Transfer

Source Server         : dit
Source Server Version : 50516
Source Host           : svr4:3306
Source Database       : invqc

Target Server Type    : MYSQL
Target Server Version : 50516
File Encoding         : 65001

Date: 2019-01-17 11:11:59
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for tbl_barang
-- ----------------------------
DROP TABLE IF EXISTS `tbl_barang`;
CREATE TABLE `tbl_barang` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kode` varchar(10) NOT NULL,
  `nama` text NOT NULL,
  `jenis` text NOT NULL,
  `harga` int(11) NOT NULL DEFAULT '0',
  `satuan` varchar(50) NOT NULL,
  `jumlah` decimal(11,2) NOT NULL DEFAULT '0.00',
  `jumlah_min` decimal(11,2) NOT NULL DEFAULT '3.00',
  `jumlah_min_a` decimal(11,2) DEFAULT '7.00',
  `tgl_buat` date NOT NULL,
  `tgl_update` date NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `kode` (`kode`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=186 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tbl_barang
-- ----------------------------
INSERT INTO `tbl_barang` VALUES ('73', 'LT 06', 'BUKU KECIL', '-', '0', 'pcs', '54.00', '3.00', '7.00', '2019-01-11', '2019-01-15');
INSERT INTO `tbl_barang` VALUES ('71', 'LT 04', 'FORM LUNTUR', '', '0', 'pcs', '11.00', '3.00', '7.00', '2019-01-11', '2019-01-11');
INSERT INTO `tbl_barang` VALUES ('72', 'LT 05', 'BUKU BESAR', '', '0', 'pcs', '35.00', '3.00', '7.00', '2019-01-11', '2019-01-11');
INSERT INTO `tbl_barang` VALUES ('70', 'LT 03', 'MULTIFIBER DW', 'MULTIFIBER ', '0', 'pcs', '3.00', '3.00', '7.00', '2019-01-11', '2019-01-16');
INSERT INTO `tbl_barang` VALUES ('69', 'LT 02', 'MULTIFIBER 10 A', 'MULTIFIBER ', '0', 'pcs', '15.00', '3.00', '7.00', '2019-01-11', '2019-01-16');
INSERT INTO `tbl_barang` VALUES ('68', 'LT 01', 'MULTIFIBER 10', 'MULTIFIBER ', '0', 'pcs', '4.00', '3.00', '7.00', '2019-01-11', '2019-01-16');
INSERT INTO `tbl_barang` VALUES ('58', 'LT 10', 'ALKALI ISO', '', '0', 'gr', '3.00', '3.00', '7.00', '2019-01-11', '2019-01-11');
INSERT INTO `tbl_barang` VALUES ('59', 'LT 11', 'NAOH LIQUID', '', '0', 'gr', '4.00', '3.00', '7.00', '2019-01-11', '2019-01-11');
INSERT INTO `tbl_barang` VALUES ('60', 'LT 12', 'ACID AATCC', '', '0', 'gr', '11.00', '3.00', '7.00', '2019-01-11', '2019-01-11');
INSERT INTO `tbl_barang` VALUES ('61', 'LT 13', 'AMONIUM CARBONAT', '', '0', 'gr', '4.00', '3.00', '7.00', '2019-01-11', '2019-01-11');
INSERT INTO `tbl_barang` VALUES ('62', 'LT 14', 'CROCK CLOTH', '', '0', 'gr', '6.00', '3.00', '7.00', '2019-01-11', '2019-01-11');
INSERT INTO `tbl_barang` VALUES ('63', 'LT 15', 'PAPER BLOTING', '', '0', 'pcs', '5.00', '3.00', '7.00', '2019-01-11', '2019-01-11');
INSERT INTO `tbl_barang` VALUES ('64', 'LT 16', 'ACETIC ACID', '', '0', 'liter', '5.00', '3.00', '7.00', '2019-01-11', '2019-01-11');
INSERT INTO `tbl_barang` VALUES ('65', 'LT 17', 'PERSPIRO METER', '', '0', 'pcs', '0.00', '3.00', '7.00', '2019-01-11', '2019-01-11');
INSERT INTO `tbl_barang` VALUES ('66', 'LT 18', 'STEEL BALL', '-', '0', 'pcs', '0.00', '3.00', '7.00', '2019-01-11', '2019-01-14');
INSERT INTO `tbl_barang` VALUES ('67', 'LT 19', 'COTTON LAWN', '', '0', 'kg', '0.00', '3.00', '7.00', '2019-01-11', '2019-01-11');
INSERT INTO `tbl_barang` VALUES ('74', 'LT 07', 'LEM FOX', 'LEM', '0', 'gr', '6.00', '3.00', '7.00', '2019-01-11', '2019-01-11');
INSERT INTO `tbl_barang` VALUES ('75', 'LT 08', 'HISTIDINE', '', '0', 'gr', '4.00', '3.00', '7.00', '2019-01-11', '2019-01-11');
INSERT INTO `tbl_barang` VALUES ('76', 'LT 09', 'NACL', '', '0', 'gr', '20.00', '3.00', '7.00', '2019-01-11', '2019-01-11');
INSERT INTO `tbl_barang` VALUES ('77', 'PH 01', 'BUFFER 04', 'PH 4', '0', 'liter', '2.00', '3.00', '7.00', '2019-01-11', '2019-01-16');
INSERT INTO `tbl_barang` VALUES ('78', 'PH 02', 'BUFFER 07', 'PH 7', '0', 'liter', '2.00', '3.00', '7.00', '2019-01-12', '2019-01-12');
INSERT INTO `tbl_barang` VALUES ('79', 'PH 03', 'BUFFER 10', 'PH 10', '0', 'liter', '1.00', '3.00', '7.00', '2019-01-12', '2019-01-12');
INSERT INTO `tbl_barang` VALUES ('80', 'PH 04', 'GLISERIN 87%', '87%', '0', 'liter', '1.00', '3.00', '7.00', '2019-01-12', '2019-01-16');
INSERT INTO `tbl_barang` VALUES ('81', 'PH 05', 'ALUMINIUM B.S. 1', 'S-B 26.1 +/- 1.5', '0', 'pcs', '1.00', '3.00', '7.00', '2019-01-12', '2019-01-12');
INSERT INTO `tbl_barang` VALUES ('82', 'PH 06', 'ALUMINIUM B.S. 2', 'S-D 58 +/- 2.0', '0', 'pcs', '6.00', '3.00', '7.00', '2019-01-12', '2019-01-12');
INSERT INTO `tbl_barang` VALUES ('83', 'PH 07', 'ALUMINIUM B.S. 3', 'S-F 82.4 +/- 3.0', '0', 'pcs', '0.00', '3.00', '7.00', '2019-01-12', '2019-01-12');
INSERT INTO `tbl_barang` VALUES ('84', 'PH 08', 'ALUMINIUM B.S. 4', 'S-F 83.3 +/- 3.0', '0', 'pcs', '0.00', '3.00', '7.00', '2019-01-12', '2019-01-12');
INSERT INTO `tbl_barang` VALUES ('85', 'PH 09', 'ALUMINIUM B.S. 5', 'S-G 119.2 +/- 3.5', '0', 'pcs', '1.00', '3.00', '7.00', '2019-01-12', '2019-01-12');
INSERT INTO `tbl_barang` VALUES ('86', 'PH 10', 'ALUMINIUM B.S. 6', 'S-G 115.9 +/- 3.5', '0', 'pcs', '1.00', '3.00', '7.00', '2019-01-12', '2019-01-12');
INSERT INTO `tbl_barang` VALUES ('87', 'PH 11', 'KARET B.S.', '', '0', 'pcs', '4.00', '3.00', '7.00', '2019-01-12', '2019-01-12');
INSERT INTO `tbl_barang` VALUES ('88', 'PH 12', 'FELT BESAR', '', '0', 'dus', '4.00', '3.00', '7.00', '2019-01-12', '2019-01-12');
INSERT INTO `tbl_barang` VALUES ('89', 'PH 13', 'FELT KECIL', '', '0', 'dus', '4.00', '3.00', '7.00', '2019-01-12', '2019-01-12');
INSERT INTO `tbl_barang` VALUES ('90', 'PH 14', 'SPON MARTINDALE', '', '0', 'pcs', '45.00', '3.00', '7.00', '2019-01-12', '2019-01-12');
INSERT INTO `tbl_barang` VALUES ('91', 'PH 15', 'ABRADANT FABRIC', '', '0', 'pcs', '1.00', '3.00', '7.00', '2019-01-12', '2019-01-12');
INSERT INTO `tbl_barang` VALUES ('92', 'PH 16', 'AQUA BIDEST', '', '0', 'pcs', '1.00', '3.00', '7.00', '2019-01-12', '2019-01-12');
INSERT INTO `tbl_barang` VALUES ('93', 'PH 17', 'CONTROL FABRIC', '', '0', 'pcs', '2.00', '3.00', '7.00', '2019-01-12', '2019-01-12');
INSERT INTO `tbl_barang` VALUES ('94', 'PH 18', 'PLASTIC BHT', '63 MICRON', '0', 'dus', '45.00', '3.00', '7.00', '2019-01-12', '2019-01-12');
INSERT INTO `tbl_barang` VALUES ('95', 'PH 19', 'TEST PAPER', '', '0', 'pcs', '1.00', '3.00', '7.00', '2019-01-12', '2019-01-12');
INSERT INTO `tbl_barang` VALUES ('96', 'PH 20', 'FORM FASTNES', '', '0', 'dus', '10.00', '3.00', '7.00', '2019-01-12', '2019-01-12');
INSERT INTO `tbl_barang` VALUES ('97', 'PH 21', 'FORM DEVELOP BESAR', '', '0', 'dus', '4.00', '3.00', '7.00', '2019-01-12', '2019-01-12');
INSERT INTO `tbl_barang` VALUES ('98', 'PH 22', 'FORM DEVELOPE KECIL', '-', '0', 'dus', '2.00', '3.00', '7.00', '2019-01-12', '2019-01-12');
INSERT INTO `tbl_barang` VALUES ('99', 'PH 23', 'FORM TR NIKE', '', '0', 'dus', '10.00', '3.00', '7.00', '2019-01-12', '2019-01-12');
INSERT INTO `tbl_barang` VALUES ('100', 'PH 24', 'FORM TR NON-NIKE', '', '0', 'dus', '2.00', '3.00', '7.00', '2019-01-12', '2019-01-12');
INSERT INTO `tbl_barang` VALUES ('101', 'PH 25', 'METYL ORANGE 0.1%', '', '0', 'pcs', '2.00', '3.00', '7.00', '2019-01-12', '2019-01-12');
INSERT INTO `tbl_barang` VALUES ('102', 'PH 26', 'GLISERIN', '99.5%', '0', 'liter', '2.00', '3.00', '7.00', '2019-01-12', '2019-01-12');
INSERT INTO `tbl_barang` VALUES ('103', 'PH 27', 'ELECTROLYTE SLOUTION FOR PH AND REDOX ELECTRODES', '', '0', 'pcs', '1.00', '3.00', '7.00', '2019-01-12', '2019-01-12');
INSERT INTO `tbl_barang` VALUES ('104', 'PH 28', 'PH INDIKATOR', '4.0 S/D 10.0', '0', 'pcs', '4.00', '3.00', '7.00', '2019-01-12', '2019-01-12');
INSERT INTO `tbl_barang` VALUES ('130', 'SHRG 03', 'STIKER ORDER (SHRINKAGE)', '', '0', 'pcs', '2.00', '3.00', '7.00', '2019-01-14', '2019-01-14');
INSERT INTO `tbl_barang` VALUES ('129', 'SHRG 02', 'STIKER FINISHING', '', '0', 'pcs', '10.00', '3.00', '7.00', '2019-01-14', '2019-01-14');
INSERT INTO `tbl_barang` VALUES ('131', 'SHRG 01', 'CROCK LINER PILL.TUMBLE', '', '0', 'dus', '1.00', '3.00', '7.00', '2019-01-14', '2019-01-14');
INSERT INTO `tbl_barang` VALUES ('134', 'SHRG 05', 'COTTON SLIVER', '', '0', 'pack', '3.00', '3.00', '7.00', '2019-01-14', '2019-01-14');
INSERT INTO `tbl_barang` VALUES ('135', 'SHRG 06', 'TINTA SPIDOL', '', '0', 'pcs', '6.00', '3.00', '7.00', '2019-01-14', '2019-01-14');
INSERT INTO `tbl_barang` VALUES ('133', 'SHRG 08', 'BALLAST 100% COTTON', '', '0', 'dus', '1.00', '3.00', '7.00', '2019-01-14', '2019-01-14');
INSERT INTO `tbl_barang` VALUES ('136', 'SHRG 07', 'BALLAST 50/50 %', '', '0', 'pack', '4.00', '3.00', '7.00', '2019-01-14', '2019-01-14');
INSERT INTO `tbl_barang` VALUES ('120', 'SHRG 11', 'FORM GRAFIK ISUZU', '', '0', 'dus', '2.00', '3.00', '7.00', '2019-01-12', '2019-01-12');
INSERT INTO `tbl_barang` VALUES ('132', 'SHRG 04', 'FORM GRAFIK HAENI', '', '0', 'dus', '4.00', '3.00', '7.00', '2019-01-14', '2019-01-14');
INSERT INTO `tbl_barang` VALUES ('119', 'SHRG 10', 'FORM PHYSICAL', '', '0', 'dus', '10.00', '3.00', '7.00', '2019-01-12', '2019-01-12');
INSERT INTO `tbl_barang` VALUES ('121', 'SHRG 12', 'BLUE WOOL 01', '', '0', 'pcs', '3.00', '3.00', '7.00', '2019-01-12', '2019-01-12');
INSERT INTO `tbl_barang` VALUES ('122', 'SHRG 13', 'BLUE WOOL 02', '', '0', 'pcs', '3.00', '3.00', '7.00', '2019-01-12', '2019-01-12');
INSERT INTO `tbl_barang` VALUES ('123', 'SHRG 14', 'BLUE WOOL 03', '', '0', 'pcs', '1.00', '3.00', '7.00', '2019-01-12', '2019-01-12');
INSERT INTO `tbl_barang` VALUES ('124', 'SHRG 15', 'BLUE WOOL 04', '', '0', 'pcs', '1.00', '3.00', '7.00', '2019-01-12', '2019-01-12');
INSERT INTO `tbl_barang` VALUES ('125', 'SHRG 16', 'BLUE WOOL 05', '', '0', 'pcs', '1.00', '3.00', '7.00', '2019-01-12', '2019-01-12');
INSERT INTO `tbl_barang` VALUES ('166', 'LD 01', 'T8 LED TUBE 18 W', 'LAMPU ', '0', 'pcs', '4.00', '4.00', '8.00', '2019-01-15', '2019-01-15');
INSERT INTO `tbl_barang` VALUES ('137', 'SHRG 17', 'HUMIDITY RED', '-', '0', 'pcs', '2.00', '3.00', '7.00', '2019-01-14', '2019-01-14');
INSERT INTO `tbl_barang` VALUES ('138', 'SHRG 18', 'FILTER IR', '', '0', 'pcs', '6.00', '2.00', '6.00', '2019-01-14', '2019-01-14');
INSERT INTO `tbl_barang` VALUES ('139', 'SHRG 19', 'PAPER WHITE NON UV', '', '0', 'pack', '0.00', '1.00', '5.00', '2019-01-14', '2019-01-14');
INSERT INTO `tbl_barang` VALUES ('140', 'SHRG 20', 'PLASTIC BHT', '25 MICRON', '0', 'pack', '1.00', '1.00', '5.00', '2019-01-14', '2019-01-14');
INSERT INTO `tbl_barang` VALUES ('141', 'SHRG 21', 'XENON LAMP', '', '0', 'pcs', '1.00', '2.00', '6.00', '2019-01-14', '2019-01-14');
INSERT INTO `tbl_barang` VALUES ('142', 'SHRG 22', 'BALLAST 100% POLY', '', '0', 'pack', '3.00', '4.00', '8.00', '2019-01-14', '2019-01-14');
INSERT INTO `tbl_barang` VALUES ('143', 'DF 01', 'PVC SNAG POD', '', '0', 'pack', '0.00', '4.00', '8.00', '2019-01-14', '2019-01-14');
INSERT INTO `tbl_barang` VALUES ('144', 'DF 02', 'FELT SNAG MACE', '', '0', 'pack', '4.00', '4.00', '8.00', '2019-01-14', '2019-01-14');
INSERT INTO `tbl_barang` VALUES ('145', 'DF 03', 'CROCKLINER PILL.BOX', '', '0', 'pack', '1.00', '4.00', '8.00', '2019-01-14', '2019-01-14');
INSERT INTO `tbl_barang` VALUES ('146', 'DF 04', 'ISOLASI PILL.BOX', '', '0', 'dus', '5.00', '4.00', '8.00', '2019-01-14', '2019-01-14');
INSERT INTO `tbl_barang` VALUES ('147', 'DF 05', 'D M F ', '', '0', 'pcs', '5.00', '6.00', '10.00', '2019-01-14', '2019-01-14');
INSERT INTO `tbl_barang` VALUES ('148', 'DF 06', 'M-CRESOL', '', '0', 'pcs', '0.00', '1.00', '5.00', '2019-01-14', '2019-01-14');
INSERT INTO `tbl_barang` VALUES ('149', 'DF 07', 'ACETON', '', '0', 'pcs', '0.00', '1.00', '5.00', '2019-01-14', '2019-01-14');
INSERT INTO `tbl_barang` VALUES ('150', 'DF 08', 'AMONIAC', '', '0', 'pcs', '4.00', '2.00', '6.00', '2019-01-14', '2019-01-14');
INSERT INTO `tbl_barang` VALUES ('151', 'DF 09', 'HYPO CLORIDE', '', '0', 'pcs', '0.00', '2.00', '6.00', '2019-01-14', '2019-01-14');
INSERT INTO `tbl_barang` VALUES ('152', 'DF 10', 'CLOROX', '', '0', 'pcs', '0.00', '1.00', '5.00', '2019-01-14', '2019-01-14');
INSERT INTO `tbl_barang` VALUES ('153', 'DF 11', 'CLOROX BLAECH', '', '0', 'pcs', '0.00', '1.00', '5.00', '2019-01-14', '2019-01-14');
INSERT INTO `tbl_barang` VALUES ('154', 'DF 12', 'CLOROX POWDER', '', '0', 'pcs', '0.00', '1.00', '5.00', '2019-01-14', '2019-01-14');
INSERT INTO `tbl_barang` VALUES ('155', 'DF 13', 'DETERGENT ECE', '', '0', 'kg', '30.00', '15.00', '19.00', '2019-01-14', '2019-01-14');
INSERT INTO `tbl_barang` VALUES ('156', 'DF 14', 'DETREGENT IEC', '', '0', 'kg', '15.00', '15.00', '19.00', '2019-01-14', '2019-01-14');
INSERT INTO `tbl_barang` VALUES ('157', 'DF 15', 'DETERGENT ATTACK', 'DETERGENT ', '0', 'pcs', '8.00', '6.00', '10.00', '2019-01-14', '2019-01-16');
INSERT INTO `tbl_barang` VALUES ('158', 'DF 16', 'DETERGENT TIDE', '', '0', 'dus', '7.20', '4.00', '8.00', '2019-01-14', '2019-01-14');
INSERT INTO `tbl_barang` VALUES ('159', 'DF 17', 'DETERGENT WOB', '', '0', 'kg', '45.00', '15.00', '19.00', '2019-01-14', '2019-01-14');
INSERT INTO `tbl_barang` VALUES ('160', 'DF 18', 'DETERGENT OBA', '', '0', 'kg', '10.80', '15.00', '19.00', '2019-01-14', '2019-01-14');
INSERT INTO `tbl_barang` VALUES ('161', 'DF 19', 'ADJ FABRIC POLYESTER', '', '0', 'pack', '1.00', '2.00', '6.00', '2019-01-14', '2019-01-14');
INSERT INTO `tbl_barang` VALUES ('162', 'DF 20', 'POLYURETHANE TUBE', '', '0', 'pack', '2.00', '4.00', '8.00', '2019-01-14', '2019-01-14');
INSERT INTO `tbl_barang` VALUES ('163', 'DF 21', 'LOCKING RING', '', '0', 'pcs', '0.00', '2.00', '6.00', '2019-01-14', '2019-01-14');
INSERT INTO `tbl_barang` VALUES ('164', 'DF 22', 'METIL SPRIT', '', '0', 'pcs', '1.00', '1.00', '5.00', '2019-01-14', '2019-01-14');
INSERT INTO `tbl_barang` VALUES ('165', 'DF 23', 'EMBROIDERY HOOP', 'ALAT TES ABSORBENCY', '0', 'pcs', '3.00', '2.00', '6.00', '2019-01-14', '2019-01-15');
INSERT INTO `tbl_barang` VALUES ('167', 'LD 02', 'USHIO HALOGEN LAMP', 'LAMPU', '0', 'pcs', '6.00', '4.00', '8.00', '2019-01-15', '2019-01-15');
INSERT INTO `tbl_barang` VALUES ('168', 'LD 03', 'QUARTZLINE LAMP STAGE STUDIO', 'LAMPU', '0', 'pcs', '2.00', '2.00', '6.00', '2019-01-15', '2019-01-15');
INSERT INTO `tbl_barang` VALUES ('169', 'LD 04', 'TUBULAR LAMP', 'LAMPU', '0', 'pcs', '4.00', '4.00', '8.00', '2019-01-15', '2019-01-15');
INSERT INTO `tbl_barang` VALUES ('170', 'LD 05', 'PHILIPS MCFE 20W/840 P15', 'LAMPU', '0', 'pcs', '9.00', '4.00', '8.00', '2019-01-15', '2019-01-15');
INSERT INTO `tbl_barang` VALUES ('171', 'LD 06', 'VERIVIDE F18 T8 D65 23 KWH', 'LAMPU', '0', 'pcs', '17.00', '4.00', '8.00', '2019-01-15', '2019-01-15');
INSERT INTO `tbl_barang` VALUES ('172', 'LD 07', 'PHILIPS TL 20W/52', 'LAMPU', '0', 'pcs', '12.00', '4.00', '8.00', '2019-01-15', '2019-01-15');
INSERT INTO `tbl_barang` VALUES ('173', 'LD 08', 'SYLVANIA BLACKLIGHT-BLUE F18 W/BLB T8', 'LAMPU', '0', 'pcs', '5.00', '5.00', '9.00', '2019-01-15', '2019-01-15');
INSERT INTO `tbl_barang` VALUES ('174', 'LD 09', 'PHILIPS MASTER TL-D 18W/830 ', 'LAMPU', '0', 'pcs', '7.00', '4.00', '8.00', '2019-01-15', '2019-01-15');
INSERT INTO `tbl_barang` VALUES ('175', 'LD 10', 'SYLVANIA F20W/33-640 COOL WHITE ', 'LAMPU', '0', 'pcs', '2.00', '4.00', '8.00', '2019-01-15', '2019-01-15');
INSERT INTO `tbl_barang` VALUES ('176', 'LD 11', 'HG LAMP', 'LAMPU', '0', 'pcs', '14.00', '4.00', '8.00', '2019-01-15', '2019-01-15');
INSERT INTO `tbl_barang` VALUES ('177', 'LD 12', 'SYLVANIA 8W F8W/T5 288 MM', 'LAMPU', '0', 'pcs', '3.00', '3.00', '7.00', '2019-01-15', '2019-01-15');
INSERT INTO `tbl_barang` VALUES ('178', 'LD 13', 'DMC 8W-TS', 'LAMPU', '0', 'pcs', '10.00', '4.00', '8.00', '2019-01-15', '2019-01-15');
INSERT INTO `tbl_barang` VALUES ('179', 'LD 14', 'SYLVANIA OCTRON 25W 3000K F025/830/XP/8000', 'LAMPU', '0', 'pcs', '4.00', '4.00', '8.00', '2019-01-15', '2019-01-15');
INSERT INTO `tbl_barang` VALUES ('180', 'LD 15', 'CWF VERIVIDE 20 WATT', 'LAMPU', '0', 'pcs', '0.00', '4.00', '8.00', '2019-01-15', '2019-01-15');
INSERT INTO `tbl_barang` VALUES ('181', 'LD 16', 'BLB UV 18 WATT', 'LAMPU', '0', 'pcs', '0.00', '4.00', '8.00', '2019-01-15', '2019-01-15');
INSERT INTO `tbl_barang` VALUES ('182', 'LT 20', 'ACID ISO', '', '0', 'pcs', '12.00', '4.00', '4.00', '2019-01-16', '2019-01-16');
INSERT INTO `tbl_barang` VALUES ('183', 'SHRG 23', 'LEM ELMER', '', '0', 'kg', '1.00', '4.00', '4.00', '2019-01-16', '2019-01-16');
INSERT INTO `tbl_barang` VALUES ('184', 'DF 24', 'DETERGENT PERSIL', '', '0', 'kg', '7.00', '4.00', '4.00', '2019-01-16', '2019-01-16');
INSERT INTO `tbl_barang` VALUES ('185', 'LD 17', 'SYLVANIA COOL WHITE F30T8/CW 30 W', '', '0', 'kg', '7.00', '4.00', '4.00', '2019-01-16', '2019-01-16');

-- ----------------------------
-- Table structure for tbl_barang_in
-- ----------------------------
DROP TABLE IF EXISTS `tbl_barang_in`;
CREATE TABLE `tbl_barang_in` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_barang` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `jumlah` decimal(11,2) NOT NULL,
  `note` text,
  `userid` varchar(50) NOT NULL,
  `tgl_update` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=203 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tbl_barang_in
-- ----------------------------
INSERT INTO `tbl_barang_in` VALUES ('104', '70', '2019-01-16', '3.00', 'meter', 'qcf', null);
INSERT INTO `tbl_barang_in` VALUES ('102', '68', '2019-01-16', '4.00', '', 'qcf', null);
INSERT INTO `tbl_barang_in` VALUES ('103', '69', '2019-01-16', '15.00', '', 'qcf', null);
INSERT INTO `tbl_barang_in` VALUES ('97', '73', '2019-01-11', '59.00', '', 'qcf', '2019-01-16 00:26:43');
INSERT INTO `tbl_barang_in` VALUES ('100', '71', '2019-01-14', '11.00', '', 'qcf', '2019-01-16 00:26:33');
INSERT INTO `tbl_barang_in` VALUES ('105', '72', '2019-01-16', '35.00', '', 'qcf', null);
INSERT INTO `tbl_barang_in` VALUES ('106', '74', '2019-01-16', '6.00', '', 'qcf', null);
INSERT INTO `tbl_barang_in` VALUES ('107', '75', '2019-01-16', '4.00', '', 'qcf', null);
INSERT INTO `tbl_barang_in` VALUES ('109', '76', '2019-01-16', '20.00', '', 'qcf', '2019-01-16 00:28:23');
INSERT INTO `tbl_barang_in` VALUES ('110', '182', '2019-01-16', '12.00', '', 'qcf', null);
INSERT INTO `tbl_barang_in` VALUES ('111', '58', '2019-01-16', '3.00', '', 'qcf', null);
INSERT INTO `tbl_barang_in` VALUES ('112', '59', '2019-01-16', '4.00', '', 'qcf', null);
INSERT INTO `tbl_barang_in` VALUES ('113', '60', '2019-01-16', '11.00', '', 'qcf', null);
INSERT INTO `tbl_barang_in` VALUES ('114', '61', '2019-01-16', '4.00', '', 'qcf', null);
INSERT INTO `tbl_barang_in` VALUES ('115', '62', '2019-01-16', '6.00', '', 'qcf', null);
INSERT INTO `tbl_barang_in` VALUES ('116', '63', '2019-01-16', '5.00', '', 'qcf', null);
INSERT INTO `tbl_barang_in` VALUES ('117', '64', '2019-01-16', '5.00', '', 'qcf', null);
INSERT INTO `tbl_barang_in` VALUES ('118', '130', '2019-01-16', '2.00', '', 'qcf', null);
INSERT INTO `tbl_barang_in` VALUES ('119', '129', '2019-01-16', '10.00', '', 'qcf', null);
INSERT INTO `tbl_barang_in` VALUES ('120', '119', '2019-01-16', '10.00', '', 'qcf', null);
INSERT INTO `tbl_barang_in` VALUES ('121', '131', '2019-01-16', '1.00', '', 'qcf', null);
INSERT INTO `tbl_barang_in` VALUES ('122', '183', '2019-01-16', '1.00', '', 'qcf', null);
INSERT INTO `tbl_barang_in` VALUES ('123', '134', '2019-01-16', '3.00', '', 'qcf', null);
INSERT INTO `tbl_barang_in` VALUES ('124', '135', '2019-01-16', '6.00', '', 'qcf', '2019-01-16 00:36:59');
INSERT INTO `tbl_barang_in` VALUES ('125', '136', '2019-01-16', '4.00', '', 'qcf', null);
INSERT INTO `tbl_barang_in` VALUES ('126', '133', '2019-01-16', '1.00', '', 'qcf', null);
INSERT INTO `tbl_barang_in` VALUES ('127', '132', '2019-01-16', '4.00', '', 'qcf', null);
INSERT INTO `tbl_barang_in` VALUES ('128', '120', '2019-01-16', '2.00', '', 'qcf', null);
INSERT INTO `tbl_barang_in` VALUES ('129', '121', '2019-01-16', '3.00', '', 'qcf', null);
INSERT INTO `tbl_barang_in` VALUES ('130', '122', '2019-01-16', '3.00', '', 'qcf', null);
INSERT INTO `tbl_barang_in` VALUES ('131', '123', '2019-01-16', '1.00', '', 'qcf', null);
INSERT INTO `tbl_barang_in` VALUES ('132', '124', '2019-01-16', '1.00', '', 'qcf', null);
INSERT INTO `tbl_barang_in` VALUES ('133', '125', '2019-01-16', '1.00', '', 'qcf', null);
INSERT INTO `tbl_barang_in` VALUES ('134', '137', '2019-01-16', '2.00', '', 'qcf', null);
INSERT INTO `tbl_barang_in` VALUES ('135', '138', '2019-01-16', '6.00', '', 'qcf', null);
INSERT INTO `tbl_barang_in` VALUES ('136', '139', '2019-01-16', '0.00', '', 'qcf', null);
INSERT INTO `tbl_barang_in` VALUES ('137', '140', '2019-01-16', '1.00', '', 'qcf', null);
INSERT INTO `tbl_barang_in` VALUES ('138', '141', '2019-01-16', '1.00', '', 'qcf', '2019-01-16 00:40:15');
INSERT INTO `tbl_barang_in` VALUES ('139', '142', '2019-01-16', '3.00', '', 'qcf', null);
INSERT INTO `tbl_barang_in` VALUES ('140', '143', '2019-01-16', '0.00', '', 'qcf', null);
INSERT INTO `tbl_barang_in` VALUES ('141', '144', '2019-01-16', '4.00', '', 'qcf', null);
INSERT INTO `tbl_barang_in` VALUES ('142', '145', '2019-01-16', '1.00', '', 'qcf', null);
INSERT INTO `tbl_barang_in` VALUES ('143', '146', '2019-01-16', '5.00', '', 'qcf', null);
INSERT INTO `tbl_barang_in` VALUES ('144', '147', '2019-01-16', '5.00', '', 'qcf', null);
INSERT INTO `tbl_barang_in` VALUES ('145', '150', '2019-01-16', '4.00', '', 'qcf', null);
INSERT INTO `tbl_barang_in` VALUES ('146', '151', '2019-01-16', '0.00', '', 'qcf', null);
INSERT INTO `tbl_barang_in` VALUES ('147', '152', '2019-01-16', '0.00', '', 'qcf', null);
INSERT INTO `tbl_barang_in` VALUES ('148', '153', '2019-01-16', '0.00', '', 'qcf', null);
INSERT INTO `tbl_barang_in` VALUES ('149', '154', '2019-01-16', '0.00', '', 'qcf', null);
INSERT INTO `tbl_barang_in` VALUES ('150', '155', '2019-01-16', '30.00', '', 'qcf', null);
INSERT INTO `tbl_barang_in` VALUES ('151', '156', '2019-01-16', '15.00', '', 'qcf', '2019-01-16 00:44:25');
INSERT INTO `tbl_barang_in` VALUES ('152', '157', '2019-01-16', '8.00', '', 'qcf', null);
INSERT INTO `tbl_barang_in` VALUES ('153', '158', '2019-01-16', '7.20', '', 'qcf', null);
INSERT INTO `tbl_barang_in` VALUES ('154', '159', '2019-01-16', '45.00', '', 'qcf', null);
INSERT INTO `tbl_barang_in` VALUES ('155', '160', '2019-01-16', '10.80', '', 'qcf', null);
INSERT INTO `tbl_barang_in` VALUES ('156', '161', '2019-01-16', '1.00', '', 'qcf', null);
INSERT INTO `tbl_barang_in` VALUES ('157', '162', '2019-01-16', '2.00', '', 'qcf', null);
INSERT INTO `tbl_barang_in` VALUES ('158', '163', '2019-01-16', '0.00', '', 'qcf', null);
INSERT INTO `tbl_barang_in` VALUES ('159', '164', '2019-01-16', '1.00', '', 'qcf', null);
INSERT INTO `tbl_barang_in` VALUES ('160', '165', '2019-01-16', '3.00', '', 'qcf', null);
INSERT INTO `tbl_barang_in` VALUES ('161', '184', '2019-01-16', '7.00', '', 'qcf', null);
INSERT INTO `tbl_barang_in` VALUES ('162', '77', '2019-01-16', '2.00', '', 'qcf', null);
INSERT INTO `tbl_barang_in` VALUES ('163', '78', '2019-01-16', '2.00', '', 'qcf', null);
INSERT INTO `tbl_barang_in` VALUES ('164', '79', '2019-01-16', '1.00', '', 'qcf', null);
INSERT INTO `tbl_barang_in` VALUES ('165', '80', '2019-01-16', '1.00', '', 'qcf', null);
INSERT INTO `tbl_barang_in` VALUES ('166', '81', '2019-01-16', '1.00', '', 'qcf', null);
INSERT INTO `tbl_barang_in` VALUES ('167', '82', '2019-01-16', '6.00', '', 'qcf', null);
INSERT INTO `tbl_barang_in` VALUES ('168', '86', '2019-01-16', '1.00', '', 'qcf', null);
INSERT INTO `tbl_barang_in` VALUES ('169', '85', '2019-01-16', '1.00', '', 'qcf', null);
INSERT INTO `tbl_barang_in` VALUES ('170', '87', '2019-01-16', '4.00', '', 'qcf', null);
INSERT INTO `tbl_barang_in` VALUES ('171', '88', '2019-01-16', '4.00', '', 'qcf', null);
INSERT INTO `tbl_barang_in` VALUES ('172', '89', '2019-01-16', '4.00', '', 'qcf', null);
INSERT INTO `tbl_barang_in` VALUES ('173', '90', '2019-01-16', '45.00', '', 'qcf', null);
INSERT INTO `tbl_barang_in` VALUES ('174', '91', '2019-01-16', '1.00', '', 'qcf', null);
INSERT INTO `tbl_barang_in` VALUES ('175', '92', '2019-01-16', '1.00', '', 'qcf', null);
INSERT INTO `tbl_barang_in` VALUES ('176', '93', '2019-01-16', '2.00', '', 'qcf', null);
INSERT INTO `tbl_barang_in` VALUES ('177', '94', '2019-01-16', '45.00', '', 'qcf', null);
INSERT INTO `tbl_barang_in` VALUES ('178', '95', '2019-01-16', '1.00', '', 'qcf', null);
INSERT INTO `tbl_barang_in` VALUES ('179', '96', '2019-01-16', '10.00', '', 'qcf', null);
INSERT INTO `tbl_barang_in` VALUES ('180', '97', '2019-01-16', '4.00', '', 'qcf', null);
INSERT INTO `tbl_barang_in` VALUES ('181', '98', '2019-01-16', '2.00', '', 'qcf', null);
INSERT INTO `tbl_barang_in` VALUES ('182', '99', '2019-01-16', '10.00', '', 'qcf', null);
INSERT INTO `tbl_barang_in` VALUES ('183', '100', '2019-01-16', '2.00', '', 'qcf', null);
INSERT INTO `tbl_barang_in` VALUES ('184', '101', '2019-01-16', '2.00', '', 'qcf', null);
INSERT INTO `tbl_barang_in` VALUES ('185', '102', '2019-01-16', '2.00', '', 'qcf', null);
INSERT INTO `tbl_barang_in` VALUES ('186', '103', '2019-01-16', '1.00', '', 'qcf', null);
INSERT INTO `tbl_barang_in` VALUES ('187', '104', '2019-01-16', '4.00', '', 'qcf', null);
INSERT INTO `tbl_barang_in` VALUES ('188', '166', '2019-01-16', '4.00', '', 'qcf', null);
INSERT INTO `tbl_barang_in` VALUES ('189', '167', '2019-01-16', '6.00', '', 'qcf', null);
INSERT INTO `tbl_barang_in` VALUES ('190', '168', '2019-01-16', '2.00', '', 'qcf', null);
INSERT INTO `tbl_barang_in` VALUES ('191', '169', '2019-01-16', '4.00', '', 'qcf', null);
INSERT INTO `tbl_barang_in` VALUES ('192', '170', '2019-01-16', '9.00', '', 'qcf', null);
INSERT INTO `tbl_barang_in` VALUES ('193', '171', '2019-01-16', '17.00', '', 'qcf', null);
INSERT INTO `tbl_barang_in` VALUES ('194', '172', '2019-01-16', '12.00', '', 'qcf', null);
INSERT INTO `tbl_barang_in` VALUES ('195', '173', '2019-01-16', '5.00', '', 'qcf', null);
INSERT INTO `tbl_barang_in` VALUES ('196', '174', '2019-01-16', '7.00', '', 'qcf', null);
INSERT INTO `tbl_barang_in` VALUES ('197', '175', '2019-01-16', '2.00', '', 'qcf', null);
INSERT INTO `tbl_barang_in` VALUES ('198', '176', '2019-01-16', '14.00', '', 'qcf', null);
INSERT INTO `tbl_barang_in` VALUES ('199', '177', '2019-01-16', '3.00', '', 'qcf', null);
INSERT INTO `tbl_barang_in` VALUES ('200', '178', '2019-01-16', '10.00', '', 'qcf', null);
INSERT INTO `tbl_barang_in` VALUES ('201', '179', '2019-01-16', '4.00', '', 'qcf', null);
INSERT INTO `tbl_barang_in` VALUES ('202', '185', '2019-01-16', '7.00', '', 'qcf', null);

-- ----------------------------
-- Table structure for tbl_barang_out
-- ----------------------------
DROP TABLE IF EXISTS `tbl_barang_out`;
CREATE TABLE `tbl_barang_out` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tanggal` date NOT NULL,
  `id_barang` int(11) NOT NULL,
  `jumlah` decimal(11,2) NOT NULL,
  `total_harga` decimal(20,2) NOT NULL,
  `note` text,
  `userid` varchar(50) NOT NULL,
  `tgl_update` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_barang` (`id_barang`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tbl_barang_out
-- ----------------------------
INSERT INTO `tbl_barang_out` VALUES ('13', '2019-01-11', '73', '5.00', '0.00', '', 'qcf', null);

-- ----------------------------
-- Table structure for tbl_satuan
-- ----------------------------
DROP TABLE IF EXISTS `tbl_satuan`;
CREATE TABLE `tbl_satuan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `satuan` varchar(50) DEFAULT NULL,
  `ket` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tbl_satuan
-- ----------------------------
INSERT INTO `tbl_satuan` VALUES ('1', 'kg', 'kilogram');
INSERT INTO `tbl_satuan` VALUES ('2', 'liter', 'liter');
INSERT INTO `tbl_satuan` VALUES ('3', 'gr', 'gram');
INSERT INTO `tbl_satuan` VALUES ('4', 'dus', 'dus');
INSERT INTO `tbl_satuan` VALUES ('5', 'pcs', 'piece');
INSERT INTO `tbl_satuan` VALUES ('7', 'pack', 'Pack/Bungkus');
INSERT INTO `tbl_satuan` VALUES ('8', 'm', 'meter');
INSERT INTO `tbl_satuan` VALUES ('9', 'cm', 'centimeter');

-- ----------------------------
-- Table structure for tbl_user
-- ----------------------------
DROP TABLE IF EXISTS `tbl_user`;
CREATE TABLE `tbl_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `level` int(2) NOT NULL,
  `status` enum('Aktif','Non-Aktif') DEFAULT NULL,
  `mamber` varchar(255) DEFAULT NULL,
  `jabatan` enum('Web Developer','Manager','Staff','Asst. Manager') DEFAULT NULL,
  `foto` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tbl_user
-- ----------------------------
INSERT INTO `tbl_user` VALUES ('13', 'operator', 'c4ca4238a0b923820dcc509a6f75849b', '3', 'Aktif', '2019', 'Staff', 'avatar.png');
INSERT INTO `tbl_user` VALUES ('12', 'edwin', 'c4ca4238a0b923820dcc509a6f75849b', '1', 'Aktif', '2019', 'Staff', 'avatar.png');
INSERT INTO `tbl_user` VALUES ('11', 'qcf', '3181ed6854a777f5eac233a21f7c94ad', '2', 'Aktif', '2019', 'Staff', 'avatar.png');
INSERT INTO `tbl_user` VALUES ('14', 'usman', '202cb962ac59075b964b07152d234b70', '1', 'Aktif', '2019', 'Manager', 'avatar.png');
