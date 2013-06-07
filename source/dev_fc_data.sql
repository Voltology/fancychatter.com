/*
 Navicat Premium Data Transfer

 Source Server         : localhost
 Source Server Type    : MySQL
 Source Server Version : 50509
 Source Host           : localhost
 Source Database       : dev_fc

 Target Server Type    : MySQL
 Target Server Version : 50509
 File Encoding         : utf-8

 Date: 05/30/2013 20:02:32 PM
*/

SET NAMES utf8;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
--  Table structure for `chitchat`
-- ----------------------------
DROP TABLE IF EXISTS `chitchat`;
CREATE TABLE `chitchat` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `body` text,
  `creation` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- ----------------------------
--  Records of `chitchat`
-- ----------------------------
BEGIN;
INSERT INTO `chitchat` VALUES ('1', '0', '1', 'adlfkjaskldfjalksjfklasd', '1369958833'), ('2', '0', '1', 'asdkfjaklsdjflkasjdfklasd', '1369959085'), ('3', '0', '1', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.', '1369961135');
COMMIT;

-- ----------------------------
--  Table structure for `chitchat_responses`
-- ----------------------------
DROP TABLE IF EXISTS `chitchat_responses`;
CREATE TABLE `chitchat_responses` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `chitchat_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `merchant_id` int(11) DEFAULT NULL,
  `body` text,
  `creation` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
--  Table structure for `livechatter`
-- ----------------------------
DROP TABLE IF EXISTS `livechatter`;
CREATE TABLE `livechatter` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `merchant_id` int(11) DEFAULT NULL,
  `body` text,
  `starttime` int(11) DEFAULT NULL,
  `endtime` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `creation` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=latin1;

-- ----------------------------
--  Records of `livechatter`
-- ----------------------------
BEGIN;
INSERT INTO `livechatter` VALUES ('19', '1', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.', '1367384400', '1368729720', '4', '1367989943'), ('32', '1', 'laritas est etiam processus dynamicus, qui sequitur mutationem consuetudium lectorum. Mirum est notare quam littera gothica, quam nunc putamus parum claram, anteposuerit litterarum formas humanitatis per seacula quarta decima et quinta decima', '1369285200', '1370581200', '1', '1369961954');
COMMIT;

-- ----------------------------
--  Table structure for `livechatter_categories`
-- ----------------------------
DROP TABLE IF EXISTS `livechatter_categories`;
CREATE TABLE `livechatter_categories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `category` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

-- ----------------------------
--  Records of `livechatter_categories`
-- ----------------------------
BEGIN;
INSERT INTO `livechatter_categories` VALUES ('1', 'Automotive'), ('2', 'Community'), ('3', 'Dental'), ('4', 'Grocery'), ('5', 'Home & Garden'), ('6', 'Restaurants'), ('7', 'Sports & Outdoor');
COMMIT;

-- ----------------------------
--  Table structure for `livechatter_statuses`
-- ----------------------------
DROP TABLE IF EXISTS `livechatter_statuses`;
CREATE TABLE `livechatter_statuses` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `status` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- ----------------------------
--  Records of `livechatter_statuses`
-- ----------------------------
BEGIN;
INSERT INTO `livechatter_statuses` VALUES ('1', 'activated'), ('2', 'paused'), ('3', 'deactivated'), ('4', 'deleted');
COMMIT;

-- ----------------------------
--  Table structure for `merchants`
-- ----------------------------
DROP TABLE IF EXISTS `merchants`;
CREATE TABLE `merchants` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `category_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `contact_email` varchar(255) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `address1` varchar(255) DEFAULT NULL,
  `address2` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `state` int(11) DEFAULT NULL,
  `zipcode` varchar(16) DEFAULT NULL,
  `country` int(11) DEFAULT NULL,
  `phone` varchar(24) DEFAULT NULL,
  `latitude` double(10,7) DEFAULT NULL,
  `longitude` double(10,7) DEFAULT NULL,
  `gmt_offset` int(11) DEFAULT NULL,
  `dst` int(1) DEFAULT '0',
  `creation` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=latin1;

-- ----------------------------
--  Records of `merchants`
-- ----------------------------
BEGIN;
INSERT INTO `merchants` VALUES ('1', null, 'Test', 'cvuletich@gmail.com', null, '925 W Huron', 'Apt 103', 'Chicago', '1', '60642', '1', '123-456-7890', '41.8948980', '-87.6504090', '-6', '0', '1368219209'), ('34', null, 'Merchant Name', null, '.jpg', null, null, null, null, null, null, null, '0.0000000', '0.0000000', null, '0', null);
COMMIT;

-- ----------------------------
--  Table structure for `offers`
-- ----------------------------
DROP TABLE IF EXISTS `offers`;
CREATE TABLE `offers` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `brand` char(2) DEFAULT NULL,
  `country` char(2) DEFAULT NULL,
  `language` char(2) DEFAULT NULL,
  `code` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `amount` varchar(255) DEFAULT NULL,
  `qualifier` varchar(255) DEFAULT NULL,
  `description` text,
  `redemptions` varchar(255) DEFAULT NULL,
  `artcode` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `creation` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
--  Table structure for `roles`
-- ----------------------------
DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `role` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- ----------------------------
--  Records of `roles`
-- ----------------------------
BEGIN;
INSERT INTO `roles` VALUES ('1', 'user'), ('2', 'administrator'), ('3', 'merchant_admin'), ('4', 'merchant_editor'), ('5', 'merchant_publis');
COMMIT;

-- ----------------------------
--  Table structure for `users`
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(40) DEFAULT NULL,
  `firstname` varchar(255) DEFAULT NULL,
  `lastname` varchar(255) DEFAULT NULL,
  `role` int(11) DEFAULT NULL,
  `merchant_id` int(11) DEFAULT NULL,
  `gmt_offset` int(11) DEFAULT NULL,
  `dst` int(1) DEFAULT NULL,
  `creation` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- ----------------------------
--  Records of `users`
-- ----------------------------
BEGIN;
INSERT INTO `users` VALUES ('1', 'chris@fancychatter.com', 'ae2b1fca515949e5d54fb22b8ed95575', 'Chris', 'Vuletich', '2', null, '-6', null, null), ('5', 'merchant@test.com', 'ae2b1fca515949e5d54fb22b8ed95575', 'Test', 'Merchant', '3', '1', '0', '1', null);
COMMIT;

SET FOREIGN_KEY_CHECKS = 1;
