-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Nov 11, 2016 at 04:08 PM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `san_xuat_vai`
--
CREATE DATABASE IF NOT EXISTS `san_xuat_vai` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
USE `san_xuat_vai`;

-- --------------------------------------------------------

--
-- Table structure for table `cay_vai_moc`
--
-- Creation: Nov 11, 2016 at 03:04 PM
--

DROP TABLE IF EXISTS `cay_vai_moc`;
CREATE TABLE IF NOT EXISTS `cay_vai_moc` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_loai_vai` smallint(5) unsigned NOT NULL,
  `id_loai_soi` smallint(5) unsigned NOT NULL,
  `so_met` smallint(5) unsigned NOT NULL,
  `id_nhan_vien_det` smallint(5) unsigned NOT NULL,
  `ma_may_det` smallint(5) unsigned NOT NULL,
  `ngay_gio_det` datetime NOT NULL,
  `id_kho` tinyint(2) unsigned NOT NULL,
  `ngay_gio_nhap_kho` datetime NOT NULL,
  `id_phieu_xuat_moc` int(10) unsigned DEFAULT NULL,
  `tinh_trang` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Chưa xuất' COMMENT 'Chưa xuất / Đã xuất',
  `id_lo_nhuom` int(10) unsigned DEFAULT NULL,
  `da_xoa` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '0: Sai ; 1: Đúng',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=22 ;

--
-- Dumping data for table `cay_vai_moc`
--

INSERT INTO `cay_vai_moc` (`id`, `id_loai_vai`, `id_loai_soi`, `so_met`, `id_nhan_vien_det`, `ma_may_det`, `ngay_gio_det`, `id_kho`, `ngay_gio_nhap_kho`, `id_phieu_xuat_moc`, `tinh_trang`, `id_lo_nhuom`, `da_xoa`) VALUES
(1, 1, 1, 103, 4, 1, '2016-03-10 15:28:36', 3, '2016-03-11 08:49:08', 1, 'Đã xuất', 1, 0),
(2, 1, 1, 103, 4, 1, '2016-03-10 15:28:36', 3, '2016-03-11 08:49:08', 1, 'Đã xuất', 1, 0),
(3, 1, 1, 103, 4, 1, '2016-03-10 15:28:36', 3, '2016-03-11 08:49:08', 1, 'Đã xuất', 1, 0),
(4, 1, 1, 103, 4, 2, '2016-03-10 15:28:36', 3, '2016-03-11 08:49:08', 1, 'Đã xuất', 1, 0),
(5, 1, 1, 103, 4, 2, '2016-03-10 15:28:36', 3, '2016-03-11 08:49:08', NULL, 'Chưa xuất', NULL, 0),
(6, 5, 5, 102, 4, 3, '2016-03-10 15:28:36', 4, '2016-03-12 14:13:36', 2, 'Đã xuất', 2, 0),
(7, 5, 5, 102, 4, 3, '2016-03-10 15:28:36', 4, '2016-03-12 14:13:36', 2, 'Đã xuất', 2, 0),
(8, 5, 5, 102, 4, 1, '2016-03-11 09:13:28', 4, '2016-03-12 14:13:36', 2, 'Đã xuất', 2, 0),
(9, 5, 5, 102, 4, 1, '2016-03-11 09:13:28', 4, '2016-03-12 14:13:36', NULL, 'Chưa xuất', NULL, 0),
(10, 6, 2, 51, 4, 2, '2016-03-11 09:13:28', 4, '2016-03-12 14:13:36', 2, 'Đã xuất', 3, 0),
(11, 6, 2, 51, 4, 2, '2016-03-11 09:13:28', 4, '2016-03-12 14:13:36', 2, 'Đã xuất', 3, 0),
(12, 6, 2, 51, 4, 3, '2016-03-11 10:37:49', 4, '2016-03-12 14:13:36', 2, 'Đã xuất', 3, 0),
(13, 6, 2, 51, 4, 3, '2016-03-11 10:37:49', 4, '2016-03-12 14:13:36', NULL, 'Chưa xuất', NULL, 0),
(14, 2, 3, 101, 4, 1, '2016-03-12 08:54:05', 3, '2016-03-13 10:24:12', 3, 'Đã xuất', 4, 0),
(15, 2, 3, 101, 4, 1, '2016-03-12 08:54:05', 3, '2016-03-13 10:24:12', 3, 'Đã xuất', 4, 0),
(16, 2, 3, 101, 4, 2, '2016-03-12 09:41:07', 3, '2016-03-13 10:24:12', 3, 'Đã xuất', 4, 0),
(17, 2, 3, 101, 4, 2, '2016-03-12 09:41:07', 3, '2016-03-13 10:24:12', NULL, 'Chưa xuất', NULL, 0),
(18, 4, 6, 52, 4, 3, '2016-03-12 10:05:14', 3, '2016-03-13 10:24:12', 3, 'Đã xuất', 5, 0),
(19, 4, 6, 52, 4, 3, '2016-03-12 10:05:14', 3, '2016-03-13 10:24:12', NULL, 'Chưa xuất', NULL, 0),
(20, 4, 6, 102, 4, 1, '2016-03-12 14:28:09', 3, '2016-03-13 10:24:12', 3, 'Đã xuất', 5, 0),
(21, 4, 6, 102, 4, 1, '2016-03-12 14:28:09', 3, '2016-03-13 10:24:12', NULL, 'Chưa xuất', NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `cay_vai_thanh_pham`
--
-- Creation: Nov 11, 2016 at 03:04 PM
--

DROP TABLE IF EXISTS `cay_vai_thanh_pham`;
CREATE TABLE IF NOT EXISTS `cay_vai_thanh_pham` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_cay_vai_moc` int(10) unsigned NOT NULL,
  `id_loai_vai` smallint(5) unsigned NOT NULL,
  `id_mau` smallint(5) unsigned NOT NULL,
  `kho` float unsigned NOT NULL COMMENT '0.5 ; 1.0 ; 1.5 mét',
  `so_met` smallint(5) unsigned NOT NULL,
  `don_gia` mediumint(8) unsigned DEFAULT NULL COMMENT 'VNĐ/mét',
  `thanh_tien` int(10) unsigned DEFAULT NULL COMMENT 'VNĐ',
  `id_lo_nhuom` int(10) unsigned NOT NULL,
  `id_kho` tinyint(2) unsigned NOT NULL,
  `ngay_gio_nhap_kho` datetime NOT NULL,
  `id_hoa_don_xuat` int(10) unsigned DEFAULT NULL,
  `tinh_trang` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Chưa xuất' COMMENT 'Chưa xuất / Đã xuất',
  `da_xoa` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '0: Sai ; 1: Đúng',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=16 ;

--
-- Dumping data for table `cay_vai_thanh_pham`
--

INSERT INTO `cay_vai_thanh_pham` (`id`, `id_cay_vai_moc`, `id_loai_vai`, `id_mau`, `kho`, `so_met`, `don_gia`, `thanh_tien`, `id_lo_nhuom`, `id_kho`, `ngay_gio_nhap_kho`, `id_hoa_don_xuat`, `tinh_trang`, `da_xoa`) VALUES
(1, 1, 1, 1, 0.5, 100, 30000, 3000000, 1, 5, '2016-04-01 09:00:12', 1, 'Đã xuất', 0),
(2, 2, 1, 1, 0.5, 100, 30000, 3000000, 1, 5, '2016-04-01 09:00:12', 1, 'Đã xuất', 0),
(3, 3, 1, 1, 0.5, 100, 30000, 3000000, 1, 5, '2016-04-01 09:00:12', 1, 'Đã xuất', 0),
(4, 4, 1, 1, 0.5, 100, 30000, 3000000, 1, 5, '2016-04-01 09:00:12', NULL, 'Chưa xuất', 0),
(5, 6, 5, 6, 1, 100, 38000, 3800000, 2, 6, '2016-04-01 09:00:12', 3, 'Đã xuất', 0),
(6, 7, 5, 6, 1, 100, 38000, 3800000, 2, 6, '2016-04-01 09:00:12', 3, 'Đã xuất', 0),
(7, 8, 5, 6, 1, 100, 38000, 3800000, 2, 6, '2016-04-01 09:00:12', NULL, 'Chưa xuất', 0),
(8, 10, 6, 8, 1.5, 50, 64000, 3200000, 3, 6, '2016-04-01 09:00:12', 2, 'Đã xuất', 0),
(9, 11, 6, 8, 1.5, 50, 64000, 3200000, 3, 6, '2016-04-01 09:00:12', 2, 'Đã xuất', 0),
(10, 12, 6, 8, 1.5, 50, 64000, 3200000, 3, 6, '2016-04-01 09:00:12', NULL, 'Chưa xuất', 0),
(11, 14, 2, 9, 1, 100, 60000, 6000000, 4, 5, '2016-04-02 10:28:33', NULL, 'Chưa xuất', 0),
(12, 15, 2, 9, 1, 100, 60000, 6000000, 4, 5, '2016-04-02 10:28:33', NULL, 'Chưa xuất', 0),
(13, 16, 2, 9, 1, 100, 60000, 6000000, 4, 5, '2016-04-02 10:28:33', NULL, 'Chưa xuất', 0),
(14, 18, 4, 3, 0.5, 50, 53000, 2650000, 5, 5, '2016-04-02 10:28:33', NULL, 'Chưa xuất', 0),
(15, 20, 4, 3, 0.5, 100, 53000, 5300000, 5, 5, '2016-04-02 10:28:33', NULL, 'Chưa xuất', 0);

-- --------------------------------------------------------

--
-- Table structure for table `don_hang_cong_ty`
--
-- Creation: Nov 11, 2016 at 03:04 PM
--

DROP TABLE IF EXISTS `don_hang_cong_ty`;
CREATE TABLE IF NOT EXISTS `don_hang_cong_ty` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_loai_soi` smallint(5) unsigned NOT NULL,
  `khoi_luong` mediumint(8) unsigned NOT NULL COMMENT 'kg',
  `han_chot` date DEFAULT NULL,
  `id_nha_cung_cap` smallint(5) unsigned NOT NULL,
  `ngay_gio_dat_hang` datetime NOT NULL,
  `tinh_trang` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Mới' COMMENT 'Mới / Chưa hoàn thành / Hoàn thành',
  `da_xoa` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '0: Sai ; 1: Đúng',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=8 ;

--
-- Dumping data for table `don_hang_cong_ty`
--

INSERT INTO `don_hang_cong_ty` (`id`, `id_loai_soi`, `khoi_luong`, `han_chot`, `id_nha_cung_cap`, `ngay_gio_dat_hang`, `tinh_trang`, `da_xoa`) VALUES
(1, 1, 2000, NULL, 1, '2016-01-04 09:27:25', 'Hoàn thành', 0),
(2, 2, 1000, NULL, 2, '2016-01-10 08:54:19', 'Chưa hoàn thành', 0),
(3, 3, 300, NULL, 3, '2016-01-15 10:05:07', 'Hoàn thành', 0),
(4, 4, 1200, NULL, 4, '2016-02-09 11:15:17', 'Chưa hoàn thành', 0),
(5, 5, 500, NULL, 5, '2016-02-22 13:32:37', 'Hoàn thành', 0),
(6, 6, 100, NULL, 6, '2016-03-10 14:46:49', 'Hoàn thành', 0),
(7, 6, 100, NULL, 6, '2016-10-07 15:19:51', 'Mới', 0);

-- --------------------------------------------------------

--
-- Table structure for table `don_hang_khach_hang`
--
-- Creation: Nov 11, 2016 at 03:04 PM
--

DROP TABLE IF EXISTS `don_hang_khach_hang`;
CREATE TABLE IF NOT EXISTS `don_hang_khach_hang` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_khach_hang` smallint(5) unsigned NOT NULL,
  `id_loai_vai` smallint(5) unsigned NOT NULL,
  `id_mau` smallint(5) unsigned NOT NULL,
  `kho` float unsigned NOT NULL COMMENT '0.5 ; 1.0 ; 1.5 mét',
  `tong_so_met` mediumint(8) unsigned NOT NULL,
  `han_chot` date DEFAULT NULL,
  `ngay_gio_dat_hang` datetime NOT NULL,
  `tinh_trang` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Mới' COMMENT 'Mới / Chưa hoàn thành / Hoàn thành',
  `da_xoa` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '0: Sai ; 1: Đúng',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

--
-- Dumping data for table `don_hang_khach_hang`
--

INSERT INTO `don_hang_khach_hang` (`id`, `id_khach_hang`, `id_loai_vai`, `id_mau`, `kho`, `tong_so_met`, `han_chot`, `ngay_gio_dat_hang`, `tinh_trang`, `da_xoa`) VALUES
(1, 1, 1, 1, 0.5, 300, NULL, '2016-04-04 10:30:25', 'Hoàn thành', 0),
(2, 3, 6, 8, 1.5, 200, NULL, '2016-04-26 09:11:08', 'Chưa hoàn thành', 0),
(3, 2, 5, 6, 1, 500, NULL, '2016-05-17 15:10:43', 'Chưa hoàn thành', 0),
(4, 4, 2, 9, 1, 400, NULL, '2016-10-31 11:21:03', 'Mới', 0);

-- --------------------------------------------------------

--
-- Table structure for table `hoa_don_nhap`
--
-- Creation: Nov 11, 2016 at 03:04 PM
--

DROP TABLE IF EXISTS `hoa_don_nhap`;
CREATE TABLE IF NOT EXISTS `hoa_don_nhap` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_don_hang_cong_ty` int(10) unsigned NOT NULL,
  `id_nha_cung_cap` smallint(5) unsigned NOT NULL,
  `id_loai_soi` smallint(5) unsigned NOT NULL,
  `so_thung` smallint(5) unsigned NOT NULL,
  `khoi_luong_thung` float unsigned NOT NULL COMMENT 'kg/thùng',
  `tong_khoi_luong_nhap` mediumint(8) unsigned NOT NULL COMMENT 'kg',
  `don_gia` mediumint(8) unsigned NOT NULL COMMENT 'VNĐ/kg',
  `tong_tien` bigint(20) unsigned NOT NULL COMMENT 'VNĐ',
  `id_kho` tinyint(2) unsigned NOT NULL,
  `id_nhan_vien_nhap` smallint(5) unsigned NOT NULL,
  `ngay_gio_xuat_hoa_don` datetime NOT NULL,
  `tinh_chat` varchar(20) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Trả dần / Trả liền',
  `da_xoa` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '0: Sai ; 1: Đúng',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=9 ;

--
-- Dumping data for table `hoa_don_nhap`
--

INSERT INTO `hoa_don_nhap` (`id`, `id_don_hang_cong_ty`, `id_nha_cung_cap`, `id_loai_soi`, `so_thung`, `khoi_luong_thung`, `tong_khoi_luong_nhap`, `don_gia`, `tong_tien`, `id_kho`, `id_nhan_vien_nhap`, `ngay_gio_xuat_hoa_don`, `tinh_chat`, `da_xoa`) VALUES
(1, 1, 1, 1, 27, 37.04, 1000, 37000, 37000000, 1, 7, '2016-01-14 13:32:39', 'Trả dần', 0),
(2, 1, 1, 1, 14, 35.72, 500, 37000, 18500000, 1, 7, '2016-02-02 10:05:23', 'Trả dần', 0),
(3, 1, 1, 1, 14, 35.72, 500, 37000, 18500000, 1, 7, '2016-02-23 14:08:58', 'Trả dần', 0),
(4, 2, 2, 2, 22, 36.37, 800, 35000, 28000000, 1, 7, '2016-02-26 09:11:08', 'Trả dần', 0),
(5, 3, 3, 3, 8, 37.5, 300, 32000, 9600000, 1, 7, '2016-01-31 15:21:03', 'Trả dần', 0),
(6, 4, 4, 4, 26, 38.47, 1000, 39000, 39000000, 2, 7, '2016-03-09 11:42:16', 'Trả dần', 0),
(7, 5, 5, 5, 13, 38.47, 500, 34000, 17000000, 2, 7, '2016-03-19 16:10:43', 'Trả dần', 0),
(8, 6, 6, 6, 3, 33.34, 100, 40000, 4000000, 2, 7, '2016-03-17 08:57:02', 'Trả dần', 0);

-- --------------------------------------------------------

--
-- Table structure for table `hoa_don_xuat`
--
-- Creation: Nov 11, 2016 at 03:06 PM
--

DROP TABLE IF EXISTS `hoa_don_xuat`;
CREATE TABLE IF NOT EXISTS `hoa_don_xuat` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_don_hang_khach_hang` int(10) unsigned NOT NULL,
  `id_khach_hang` smallint(5) unsigned NOT NULL,
  `id_loai_vai` smallint(5) unsigned NOT NULL,
  `id_mau` smallint(5) unsigned NOT NULL,
  `kho` float unsigned NOT NULL COMMENT '0.5 ; 1.0 ; 1.5 mét',
  `tong_so_cay_vai` mediumint(8) unsigned NOT NULL,
  `tong_so_met` mediumint(8) unsigned NOT NULL,
  `tong_tien` bigint(20) unsigned NOT NULL COMMENT 'VNĐ',
  `id_kho` tinyint(2) unsigned NOT NULL,
  `id_nhan_vien_xuat` smallint(5) unsigned NOT NULL,
  `ngay_gio_xuat_hoa_don` datetime NOT NULL,
  `tinh_chat` varchar(20) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Trả dần / Trả liền',
  `da_xoa` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '0: Sai ; 1: Đúng',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Dumping data for table `hoa_don_xuat`
--

INSERT INTO `hoa_don_xuat` (`id`, `id_don_hang_khach_hang`, `id_khach_hang`, `id_loai_vai`, `id_mau`, `kho`, `tong_so_cay_vai`, `tong_so_met`, `tong_tien`, `id_kho`, `id_nhan_vien_xuat`, `ngay_gio_xuat_hoa_don`, `tinh_chat`, `da_xoa`) VALUES
(1, 1, 1, 1, 1, 0.5, 3, 300, 9000000, 5, 10, '2016-05-20 10:30:25', 'Trả dần', 0),
(2, 2, 3, 6, 8, 1.5, 2, 100, 6400000, 6, 10, '2016-06-13 09:11:08', 'Trả dần', 0),
(3, 3, 2, 5, 6, 1, 2, 200, 7600000, 6, 10, '2016-07-02 14:15:43', 'Trả dần', 0);

-- --------------------------------------------------------

--
-- Table structure for table `khach_hang`
--
-- Creation: Nov 11, 2016 at 03:04 PM
--

DROP TABLE IF EXISTS `khach_hang`;
CREATE TABLE IF NOT EXISTS `khach_hang` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `ho_ten` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `ten_dang_nhap` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `mat_khau` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `dia_chi` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `so_dien_thoai` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cong_no` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT 'VNĐ',
  `da_xoa` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '0: Sai ; 1: Đúng',
  PRIMARY KEY (`id`),
  UNIQUE KEY `ten_dang_nhap` (`ten_dang_nhap`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `so_dien_thoai` (`so_dien_thoai`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=7 ;

--
-- Dumping data for table `khach_hang`
--

INSERT INTO `khach_hang` (`id`, `ho_ten`, `ten_dang_nhap`, `mat_khau`, `dia_chi`, `email`, `so_dien_thoai`, `cong_no`, `da_xoa`) VALUES
(1, 'Hiếu', 'hieu', 'e10adc3949ba59abbe56e057f20f883e', '648 Thành Thái, Q.10', 'hieu@gmail.com', '0934689574', 4000000, 0),
(2, 'Mai', 'mai', 'e10adc3949ba59abbe56e057f20f883e', '394 Lữ Gia, Q.11', 'mai@gmail.com', '0923469571', 2600000, 0),
(3, 'Phúc', 'phuc', 'e10adc3949ba59abbe56e057f20f883e', '267 Tô Hiến Thành, Q.10', 'phuc@gmail.com', '0934698571', 3200000, 0),
(4, 'Nhân', 'nhan', 'e10adc3949ba59abbe56e057f20f883e', '167 Nguyễn Kiệm, Q.Gò Vấp', 'nhan@gmail.com', '0937468134', 0, 0),
(5, 'Long', 'long', 'e10adc3949ba59abbe56e057f20f883e', '369 Phạm Hữu Lầu, P.6, TP.Cao Lãnh, Đồng Tháp', 'long@gmail.com', '0904687231', 0, 0),
(6, 'Công', 'cong', 'e10adc3949ba59abbe56e057f20f883e', '267 Bạch Đằng, Q.Hải Châu, Đà Nẵng', 'cong@gmail.com', '0916487265', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `kho`
--
-- Creation: Nov 11, 2016 at 03:04 PM
--

DROP TABLE IF EXISTS `kho`;
CREATE TABLE IF NOT EXISTS `kho` (
  `id` tinyint(2) unsigned NOT NULL AUTO_INCREMENT,
  `ten` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `id_nhan_vien_quan_ly` smallint(5) unsigned DEFAULT NULL,
  `dien_tich` float unsigned NOT NULL COMMENT 'mét vuông',
  `dia_chi` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `so_dien_thoai` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `da_xoa` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '0: Sai ; 1: Đúng',
  PRIMARY KEY (`id`),
  UNIQUE KEY `ten` (`ten`),
  UNIQUE KEY `so_dien_thoai` (`so_dien_thoai`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=7 ;

--
-- Dumping data for table `kho`
--

INSERT INTO `kho` (`id`, `ten`, `id_nhan_vien_quan_ly`, `dien_tich`, `dia_chi`, `so_dien_thoai`, `da_xoa`) VALUES
(1, 'Kho sợi A', 7, 60, '123 Lê Minh Xuân, Q.Tân Bình, TP.Hồ Chí Minh', '(08) 38246972', 0),
(2, 'Kho sợi B', 7, 100, '125 Lê Minh Xuân, Q.Tân Bình, TP.Hồ Chí Minh', '(08) 38246973', 0),
(3, 'Kho mộc A', 8, 120, '127 Lê Minh Xuân, Q.Tân Bình, TP.Hồ Chí Minh', '(08) 38246974', 0),
(4, 'Kho mộc B', 8, 150, '129 Lê Minh Xuân, Q.Tân Bình, TP.Hồ Chí Minh', '(08) 38246975', 0),
(5, 'Kho thành phẩm A', 9, 120, '131 Lê Minh Xuân, Q.Tân Bình, TP.Hồ Chí Minh', '(08) 38246976', 0),
(6, 'Kho thành phẩm B', 9, 150, '133 Lê Minh Xuân, Q.Tân Bình, TP.Hồ Chí Minh', '(08) 38246977', 0);

-- --------------------------------------------------------

--
-- Table structure for table `loai_soi`
--
-- Creation: Nov 11, 2016 at 03:04 PM
--

DROP TABLE IF EXISTS `loai_soi`;
CREATE TABLE IF NOT EXISTS `loai_soi` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `ten` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `thong_tin_ky_thuat` text COLLATE utf8_unicode_ci,
  `khoi_luong_ton` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT 'kg',
  `so_thung` smallint(5) unsigned NOT NULL DEFAULT '0',
  `da_xoa` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '0: Sai ; 1: Đúng',
  PRIMARY KEY (`id`),
  UNIQUE KEY `ten` (`ten`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=7 ;

--
-- Dumping data for table `loai_soi`
--

INSERT INTO `loai_soi` (`id`, `ten`, `thong_tin_ky_thuat`, `khoi_luong_ton`, `so_thung`, `da_xoa`) VALUES
(1, 'Sợi bông (Cotton)', 'Sợi bông được làm từ cây sợi bông – một giống cây trồng rất lâu đời. Trong ngành may mặc và chế biến người ta phân biệt các loại bông trước tiên theo chiều dài của sợi, sau đó đến mùi, màu và độ sạch của cuộn sợi. Sợi bông càng dài thì càng có chất lượng cao.\r\n\r\nSợi bông là loại sợi thiên nhiên có khả năng hút/ thấm nước rất cao; sợi bông có thể thấm nước đến 65% so với trọng lượng. Sợi bông có khuynh hướng dính bẩn và dính dầu mỡ, dù vậy có thể giặt sạch được. Sợi bông thân thiện với da người (không làm ngứa) và không tạo ra các nguy cơ dị ứng việc khiến cho sợi bông trở thành nguyên liệu quan trọng trong ngành dệt may.\r\n\r\nSợi bông không hòa tan trong nước, khi ẩm hoặc ướt sẽ dẻo dai hơn khi khô ráo. Sợi bông bền đối với chất kềm, nhưng không bền đối với acid và có thể bị vi sinh vật phân hủy. Dù vậy khả năng chịu được mối mọt và các côn trùng khác rất cao. Sợi bông dễ cháy nhưng có thể nấu trong nước sôi để tiệt trùng.\r\n\r\nLãnh vực chính của sợi bông là việc ứng dụng trong ngành may mặc. Ngoài ra, sợi bông còn được dùng làm thành phần trong các chất liệu tổng hợp.', 1000, 25, 0),
(2, 'Sợi tơ tằm (Lụa)', 'Có 4 loại tơ tằm tự nhiên, tơ của tằm dâu là loại được sản xuất nhiều chiếm 95% sản lượng trên thế giới. Sợi tơ tằm được tôn vinh là "Nữ Hoàng” của ngành dệt mặc dù sản lượng sợi tơ sản xuất ra thấp hơn nhiều so với các loại sợi khác như: bông, đay, gai… nhưng nó vẫn chiếm vị trí quan trọng trong ngành dệt, nó tô đậm màu sắc hàng đầu thế giới về mốt thời trang tơ tằm.\r\n\r\nĐặc điểm chủ yếu của tơ là chiều dài tơ đơn và độ mảnh tơ. Sợi tơ có thể hút ẩm, bị ảnh hưởng bởi nước nóng, axit, bazơ, muối kim loại, chất nhuộm màu. Mặt cắt ngang sợi tơ có hình dạng tam giác với các góc tròn. Vì có hình dạng tam giác nên ánh sáng có thể rọi vào ở nhiều góc độ khác nhau, sợi tơ có vẻ óng ánh tự nhiên.\r\n\r\nLụa là một loại vải mịn, mỏng được dệt bằng tơ. Loại lụa tốt nhất được dệt từ tơ tằm. Người cầm có thể cảm nhận được vẻ mịn và mượt mà của lụa không giống như các loại vải dệt từ sợi nhân tạo. Quần áo bằng lụa rất thích hợp với thời tiết nóng và hoạt động nhiều vì lụa dễ thấm mồ hôi. Quần áo lụa cũng thích hợp cho thời tiết lạnh vì lụa dẫn nhiệt kém làm cho người mặc ấm hơn.', 500, 14, 0),
(3, 'Sợi Polyester (PES)', 'Polyester là một loại sợi tổng hợp với thành phần cấu tạo đặc trưng là ethylene (nguồn gốc từ dầu mỏ). Quá trình hóa học tạo ra các polyester hoàn chỉnh được gọi là quá trình trùng hợp. Có bốn dạng sợi polyester cơ bản là sợi filament, xơ, sợi thô, và fiberfill.\r\n\r\nPolyester được ứng dụng nhiều trong ngành công nghiệp để sản xuất các loại sản phẩm như quần áo, đồ nội thất gia dụng, vải công nghiệp, vật liệu cách điện… Sợi Polyester có nhiều ưu thế hơn khi so sánh với các loại sợi truyền thống là không hút ẩm, nhưng hấp thụ dầu. Chính những đặc tính này làm cho Polyester trở thành một loại vải hoàn hảo đối với những ứng dụng chống nước, chống bụi và chống cháy. Khả năng hấp thụ thấp của Polyester giúp nó tự chống lại các vết bẩn một cách tự nhiên. Vải Polyester không bị co khi giặt, chống nhăn và chống kéo dãn. Nó cũng dễ dàng được nhuộm màu và không bị hủy hoại bởi nấm mốc. Vải Polyester là vật liệu cách nhiệt hiệu quả, do đó nó được dung để sản xuất gối, chăn, áo khoác ngoài và túi ngủ.', 200, 5, 0),
(4, 'Sợi CM / Sợi CD', 'Là sợi 100% cotton chải kỹ (sợi CM); 100% cotton chải thô (CD). Sơi này hút ẩm tốt, dễ chịu khi tiếp xúc với da người. Thường dùng để dệt các loại vải mềm, đố lót.', 800, 16, 0),
(5, 'Sợi TCM / Sợi TCD (Tetron Cotton)', 'TC là sợi với thành phần bao gồm 65% PE và 35% cotton chải kỹ (TCM); 65 % PE, 35 % cotton chải thô (TCD). Sợi này dễ dễ chịu khi tiếp xúc với da người, chịu là (ủi) phẳng, giặt dễ sạch và chóng khô, phù hợp dệt vải áo quần.', 200, 5, 0),
(6, 'Sợi CVC (Chief Value of Cotton)', 'Là sợi với thành phần chính là cotton; ví dụ CVC 65% cotton và 35% PE. Vải sợi pha này mang tính chất của cả hai loại sợi cấu thành nên nó là sợi cotton và PE.', 72, 2, 0);

-- --------------------------------------------------------

--
-- Table structure for table `loai_vai`
--
-- Creation: Nov 11, 2016 at 03:04 PM
--

DROP TABLE IF EXISTS `loai_vai`;
CREATE TABLE IF NOT EXISTS `loai_vai` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `ten` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `don_gia` mediumint(8) unsigned DEFAULT NULL COMMENT 'VNĐ/mét',
  `da_xoa` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '0: Sai ; 1: Đúng',
  PRIMARY KEY (`id`),
  UNIQUE KEY `ten` (`ten`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=8 ;

--
-- Dumping data for table `loai_vai`
--

INSERT INTO `loai_vai` (`id`, `ten`, `don_gia`, `da_xoa`) VALUES
(1, 'Cotton', 30000, 0),
(2, 'Polyester (PES)', 47000, 0),
(3, 'Kaki', 42000, 0),
(4, 'CVC', 53000, 0),
(5, 'TC', 38000, 0),
(6, 'Lụa', 64000, 0),
(7, 'Thun', 34000, 0);

-- --------------------------------------------------------

--
-- Table structure for table `loai_vai_loai_soi`
--
-- Creation: Nov 11, 2016 at 03:04 PM
--

DROP TABLE IF EXISTS `loai_vai_loai_soi`;
CREATE TABLE IF NOT EXISTS `loai_vai_loai_soi` (
  `id_loai_vai` smallint(5) unsigned NOT NULL,
  `id_loai_soi` smallint(5) unsigned NOT NULL,
  `dinh_muc` float unsigned DEFAULT NULL COMMENT 'kg/mét',
  `da_xoa` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '0: Sai ; 1: Đúng',
  PRIMARY KEY (`id_loai_vai`,`id_loai_soi`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `loai_vai_loai_soi`
--

INSERT INTO `loai_vai_loai_soi` (`id_loai_vai`, `id_loai_soi`, `dinh_muc`, `da_xoa`) VALUES
(1, 1, NULL, 0),
(1, 4, NULL, 0),
(1, 5, NULL, 0),
(1, 6, NULL, 0),
(2, 3, NULL, 0),
(4, 6, NULL, 0),
(5, 5, NULL, 0),
(6, 2, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `lo_nhuom`
--
-- Creation: Nov 11, 2016 at 03:04 PM
--

DROP TABLE IF EXISTS `lo_nhuom`;
CREATE TABLE IF NOT EXISTS `lo_nhuom` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_mau` smallint(5) unsigned NOT NULL,
  `id_nhan_vien_nhuom` smallint(5) unsigned DEFAULT NULL,
  `ngay_gio_nhuom` datetime DEFAULT NULL,
  `da_xoa` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '0: Sai ; 1: Đúng',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=6 ;

--
-- Dumping data for table `lo_nhuom`
--

INSERT INTO `lo_nhuom` (`id`, `id_mau`, `id_nhan_vien_nhuom`, `ngay_gio_nhuom`, `da_xoa`) VALUES
(1, 1, 5, '2016-03-30 08:40:12', 0),
(2, 6, 5, '2016-03-30 09:50:03', 0),
(3, 8, 5, '2016-03-30 11:00:26', 0),
(4, 9, 5, '2016-03-31 09:07:33', 0),
(5, 3, 5, '2016-03-31 10:02:45', 0);

-- --------------------------------------------------------

--
-- Table structure for table `mau`
--
-- Creation: Nov 11, 2016 at 03:04 PM
--

DROP TABLE IF EXISTS `mau`;
CREATE TABLE IF NOT EXISTS `mau` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `ten` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `cong_thuc` text COLLATE utf8_unicode_ci,
  `id_nhan_vien_pha_che` smallint(5) unsigned DEFAULT NULL,
  `ngay_gio_tao` datetime DEFAULT NULL,
  `da_xoa` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '0: Sai ; 1: Đúng',
  PRIMARY KEY (`id`),
  UNIQUE KEY `ten` (`ten`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=10 ;

--
-- Dumping data for table `mau`
--

INSERT INTO `mau` (`id`, `ten`, `cong_thuc`, `id_nhan_vien_pha_che`, `ngay_gio_tao`, `da_xoa`) VALUES
(1, 'Trắng', NULL, NULL, NULL, 0),
(2, 'Đen', NULL, NULL, NULL, 0),
(3, 'Xanh', NULL, NULL, NULL, 0),
(4, 'Đỏ', NULL, NULL, NULL, 0),
(5, 'Vàng', NULL, NULL, NULL, 0),
(6, 'Tím', '39% đỏ + 61% xanh', 6, '2015-11-23 09:37:54', 0),
(7, 'Cam', '41% đỏ + 59% vàng', 6, '2015-11-30 11:53:31', 0),
(8, 'Lục', '28% xanh + 72% vàng', 6, '2015-12-09 14:03:07', 0),
(9, 'Lam', '56% xanh + 44% lục', 6, '2015-12-27 13:48:22', 0);

-- --------------------------------------------------------

--
-- Table structure for table `nhan_vien`
--
-- Creation: Nov 11, 2016 at 03:04 PM
--

DROP TABLE IF EXISTS `nhan_vien`;
CREATE TABLE IF NOT EXISTS `nhan_vien` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `ho_ten` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `ten_dang_nhap` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `mat_khau` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `chuc_vu` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `quyen` tinyint(2) unsigned NOT NULL COMMENT '1: Admin ; 2: Bộ phận Sản xuất ; 3: Bộ phận Kho ; 4: Bộ phận Bán hàng',
  `luong` int(10) unsigned NOT NULL COMMENT 'VNĐ',
  `ghi_chu` text COLLATE utf8_unicode_ci,
  `ngay_thang_nam_sinh` date DEFAULT NULL,
  `gioi_tinh` tinyint(1) unsigned NOT NULL COMMENT '0: Nữ ; 1: Nam',
  `dia_chi` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `so_dien_thoai` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `da_xoa` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '0: Sai ; 1: Đúng',
  PRIMARY KEY (`id`),
  UNIQUE KEY `ten_dang_nhap` (`ten_dang_nhap`),
  UNIQUE KEY `so_dien_thoai` (`so_dien_thoai`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=11 ;

--
-- Dumping data for table `nhan_vien`
--

INSERT INTO `nhan_vien` (`id`, `ho_ten`, `ten_dang_nhap`, `mat_khau`, `chuc_vu`, `quyen`, `luong`, `ghi_chu`, `ngay_thang_nam_sinh`, `gioi_tinh`, `dia_chi`, `email`, `so_dien_thoai`, `da_xoa`) VALUES
(1, 'Bách', 'bach', 'e10adc3949ba59abbe56e057f20f883e', 'Quản lý', 1, 10000000, NULL, NULL, 1, '123 Thành Thái, Q.10', 'bach@gmail.com', '0931647295', 0),
(2, 'Bình', 'binh', 'e10adc3949ba59abbe56e057f20f883e', 'Quản lý', 1, 10000000, NULL, NULL, 1, '234 Nguyễn Tri Phương, Q.5', 'binh@gmail.com', '0904679167', 0),
(3, 'Tùng', 'tung', 'e10adc3949ba59abbe56e057f20f883e', 'Quản lý', 1, 10000000, NULL, NULL, 1, '345 Tô Hiến Thành, Q.10', 'tung@gmail.com', '0907931431', 0),
(4, 'Nam', 'nam', 'e10adc3949ba59abbe56e057f20f883e', 'Nhân viên dệt', 2, 8000000, NULL, '1990-08-10', 1, '456 Lê Lợi, Q.1', 'nam@gmail.com', '0934612379', 0),
(5, 'Tuấn', 'tuan', 'e10adc3949ba59abbe56e057f20f883e', 'Nhân viên nhuộm', 2, 8000000, NULL, '1991-05-22', 1, '56 Phạm Phú Thứ, Q.Tân Bình', 'tuan@gmail.com', '0914679531', 0),
(6, 'Lan', 'lan', 'e10adc3949ba59abbe56e057f20f883e', 'Nhân viên pha chế màu', 2, 8000000, NULL, '1992-01-17', 0, '32 Lê Minh Xuân, Q.Tân Bình', 'lan@gmail.com', '0926479531', 0),
(7, 'Sơn', 'son', 'e10adc3949ba59abbe56e057f20f883e', 'Nhân viên kho sợi', 3, 8000000, NULL, '1989-12-05', 1, '567 Tôn Đức Thắng, Q.1', 'son@gmail.com', '0913647953', 0),
(8, 'Huy', 'huy', 'e10adc3949ba59abbe56e057f20f883e', 'Nhân viên kho mộc', 3, 8000000, NULL, '1988-06-09', 1, '97 Lạc Long Quân, Q.Tân Bình', 'huy@gmail.com', '0934978264', 0),
(9, 'Đào', 'dao', 'e10adc3949ba59abbe56e057f20f883e', 'Nhân viên kho thành phẩm', 3, 8000000, NULL, '1993-11-30', 0, '19 Âu Cơ, Q.Tân Bình', 'dao@gmail.com', '0927943168', 0),
(10, 'Trúc', 'truc', 'e10adc3949ba59abbe56e057f20f883e', 'Nhân viên Bán hàng', 4, 8000000, NULL, '1994-03-28', 0, '678 Lê Thánh Tôn, Q.1', 'truc@gmail.com', '0926479543', 0);

-- --------------------------------------------------------

--
-- Table structure for table `nha_cung_cap`
--
-- Creation: Nov 11, 2016 at 03:04 PM
--

DROP TABLE IF EXISTS `nha_cung_cap`;
CREATE TABLE IF NOT EXISTS `nha_cung_cap` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `ten` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `dia_chi` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `so_dien_thoai` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `fax` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cong_no` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT 'VNĐ',
  `da_xoa` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '0: Sai ; 1: Đúng',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `so_dien_thoai` (`so_dien_thoai`),
  UNIQUE KEY `fax` (`fax`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=7 ;

--
-- Dumping data for table `nha_cung_cap`
--

INSERT INTO `nha_cung_cap` (`id`, `ten`, `dia_chi`, `email`, `so_dien_thoai`, `fax`, `cong_no`, `da_xoa`) VALUES
(1, 'Hải Yến', 'Số 8, Đường số 6, P.Tam Phú, Q.Thủ Đức, Tp.HCM', 'ctytnhhsoihaiyen@gmail.com', '0932041041', '(08) 38970962', 44000000, 0),
(2, 'Nam Hưng', 'Số 13, Đường 48C, P.Tân Tạo, Q.Bình Tân, Tp.HCM', 'ctydetmaynamhung@yahoo.com', '(08) 37507398', NULL, 14000000, 0),
(3, 'Topnet Việt Nam', '122 Đường Nguyễn Hoàng, P.An Phú, Q.2, Tp.HCM', 'salesvietnam.topnet@gmail.com', '(08) 62811102', NULL, 5000000, 0),
(4, 'Việt Thắng Lợi', '23/6 Nguyễn Ảnh Thủ, Ấp Hưng Lân, Xã Bà Điểm, Huyện Hóc Môn, Tp.HCM', 'sales@vietthangloi.vn', '(08) 37182234', '(08) 37182224', 27000000, 0),
(5, 'Huê Đạt', 'Số 85 Phạm Văn Xảo, P.Phú Thọ Hòa, Q.Tân Phú, Tp.HCM', 'congtyhuedat@gmail.com', '(08) 39780228', '(08) 39780228', 10000000, 0),
(6, 'Nam Việt', 'Số 86, Tổ 2, Khu phố Bà Tri, P.Tân Hiệp, Xã Tân Uyên, Tỉnh Bình Dương', 'sales@navipoly.com', '+84 0650 3655361', '+84 650 3655360', 2000000, 0);

-- --------------------------------------------------------

--
-- Table structure for table `phieu_xuat_moc`
--
-- Creation: Nov 11, 2016 at 03:04 PM
--

DROP TABLE IF EXISTS `phieu_xuat_moc`;
CREATE TABLE IF NOT EXISTS `phieu_xuat_moc` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tong_so_cay_moc` smallint(5) unsigned NOT NULL,
  `tong_so_met` mediumint(8) unsigned NOT NULL,
  `id_kho` tinyint(2) unsigned NOT NULL,
  `id_nhan_vien_xuat` smallint(5) unsigned NOT NULL,
  `ngay_gio_xuat_kho` datetime NOT NULL,
  `da_xoa` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '0: Sai ; 1: Đúng',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Dumping data for table `phieu_xuat_moc`
--

INSERT INTO `phieu_xuat_moc` (`id`, `tong_so_cay_moc`, `tong_so_met`, `id_kho`, `id_nhan_vien_xuat`, `ngay_gio_xuat_kho`, `da_xoa`) VALUES
(1, 4, 412, 3, 8, '2016-03-30 08:24:12', 0),
(2, 6, 459, 4, 8, '2016-03-30 10:15:49', 0),
(3, 5, 457, 3, 8, '2016-03-31 09:37:26', 0);

-- --------------------------------------------------------

--
-- Table structure for table `phieu_xuat_soi`
--
-- Creation: Nov 11, 2016 at 03:04 PM
--

DROP TABLE IF EXISTS `phieu_xuat_soi`;
CREATE TABLE IF NOT EXISTS `phieu_xuat_soi` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_loai_soi` smallint(5) unsigned NOT NULL,
  `so_thung` smallint(5) unsigned NOT NULL,
  `khoi_luong_thung` float unsigned NOT NULL COMMENT 'kg/thùng',
  `tong_khoi_luong_xuat` smallint(5) unsigned NOT NULL COMMENT 'kg',
  `id_kho` tinyint(2) unsigned NOT NULL,
  `id_nhan_vien_xuat` smallint(5) unsigned NOT NULL,
  `ngay_gio_xuat_kho` datetime NOT NULL,
  `da_xoa` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '0: Sai ; 1: Đúng',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=8 ;

--
-- Dumping data for table `phieu_xuat_soi`
--

INSERT INTO `phieu_xuat_soi` (`id`, `id_loai_soi`, `so_thung`, `khoi_luong_thung`, `tong_khoi_luong_xuat`, `id_kho`, `id_nhan_vien_xuat`, `ngay_gio_xuat_kho`, `da_xoa`) VALUES
(1, 1, 15, 33.34, 500, 1, 7, '2016-03-10 14:08:58', 0),
(2, 1, 15, 33.34, 500, 1, 7, '2016-05-23 10:13:27', 0),
(3, 2, 8, 37.5, 300, 1, 7, '2016-03-20 09:11:08', 0),
(4, 3, 3, 33.34, 100, 1, 7, '2016-03-31 11:21:03', 0),
(5, 4, 10, 20, 200, 2, 7, '2016-04-01 13:42:16', 0),
(6, 5, 8, 37.5, 300, 2, 7, '2016-04-30 15:10:43', 0),
(7, 6, 1, 28, 28, 2, 7, '2016-04-17 08:57:02', 0);

-- --------------------------------------------------------

--
-- Table structure for table `thu_chi`
--
-- Creation: Nov 11, 2016 at 03:04 PM
--

DROP TABLE IF EXISTS `thu_chi`;
CREATE TABLE IF NOT EXISTS `thu_chi` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `loai` varchar(20) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Thu / Chi',
  `id_nha_cung_cap` smallint(5) unsigned DEFAULT NULL,
  `id_khach_hang` smallint(5) unsigned DEFAULT NULL,
  `so_tien` bigint(20) unsigned NOT NULL COMMENT 'VNĐ',
  `ngay_gio` datetime NOT NULL,
  `phuong_thuc` varchar(20) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Tiền mặt / Chuyển khoản',
  `da_xoa` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '0: Sai ; 1: Đúng',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=14 ;

--
-- Dumping data for table `thu_chi`
--

INSERT INTO `thu_chi` (`id`, `loai`, `id_nha_cung_cap`, `id_khach_hang`, `so_tien`, `ngay_gio`, `phuong_thuc`, `da_xoa`) VALUES
(1, 'Chi', 1, NULL, 10000000, '2016-04-07 14:08:57', 'Chuyển khoản', 0),
(2, 'Chi', 1, NULL, 10000000, '2016-05-29 10:16:43', 'Chuyển khoản', 0),
(3, 'Chi', 1, NULL, 10000000, '2016-07-02 09:54:15', 'Chuyển khoản', 0),
(4, 'Chi', 2, NULL, 6000000, '2016-04-01 11:27:08', 'Chuyển khoản', 0),
(5, 'Chi', 2, NULL, 8000000, '2016-05-19 13:42:36', 'Chuyển khoản', 0),
(6, 'Chi', 3, NULL, 4600000, '2016-03-31 15:21:03', 'Tiền mặt', 0),
(7, 'Chi', 4, NULL, 12000000, '2016-06-08 16:03:24', 'Chuyển khoản', 0),
(8, 'Chi', 5, NULL, 7000000, '2016-05-17 14:06:02', 'Chuyển khoản', 0),
(9, 'Chi', 6, NULL, 2000000, '2016-06-23 08:57:02', 'Tiền mặt', 0),
(10, 'Thu', NULL, 1, 2500000, '2016-06-30 10:30:25', 'Tiền mặt', 0),
(11, 'Thu', NULL, 1, 2500000, '2016-07-31 13:55:28', 'Tiền mặt', 0),
(12, 'Thu', NULL, 3, 3200000, '2016-08-06 14:23:55', 'Tiền mặt', 0),
(13, 'Thu', NULL, 2, 5000000, '2016-08-28 11:05:36', 'Chuyển khoản', 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
