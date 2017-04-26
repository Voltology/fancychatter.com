/*
 Navicat Premium Data Transfer

 Source Server         : MySQL
 Source Server Type    : MySQL
 Source Server Version : 50538
 Source Host           : localhost
 Source Database       : fancychatter_dev

 Target Server Type    : MySQL
 Target Server Version : 50538
 File Encoding         : utf-8

 Date: 04/26/2017 12:14:30 PM
*/

SET NAMES utf8;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
--  Table structure for `alerts`
-- ----------------------------
DROP TABLE IF EXISTS `alerts`;
CREATE TABLE `alerts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `body` text,
  `viewed` int(1) DEFAULT NULL,
  `creation` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_idx` (`id`) USING BTREE,
  KEY `user_id_idx` (`user_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=9293 DEFAULT CHARSET=latin1;

-- ----------------------------
--  Table structure for `applications`
-- ----------------------------
DROP TABLE IF EXISTS `applications`;
CREATE TABLE `applications` (
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
  `gmt_offset` int(11) DEFAULT NULL,
  `dst` int(1) DEFAULT '0',
  `creation` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=latin1;

-- ----------------------------
--  Table structure for `chitchat`
-- ----------------------------
DROP TABLE IF EXISTS `chitchat`;
CREATE TABLE `chitchat` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `body` text,
  `distance` int(11) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `latitude` double DEFAULT NULL,
  `longitude` double DEFAULT NULL,
  `creation` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_idx` (`id`) USING BTREE,
  KEY `user_id_idx` (`user_id`) USING BTREE,
  KEY `category_id_idx` (`category_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=85 DEFAULT CHARSET=latin1;

-- ----------------------------
--  Table structure for `chitchat_merchant_deletions`
-- ----------------------------
DROP TABLE IF EXISTS `chitchat_merchant_deletions`;
CREATE TABLE `chitchat_merchant_deletions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `chitchat_id` int(11) DEFAULT NULL,
  `merchant_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
--  Table structure for `chitchat_responses`
-- ----------------------------
DROP TABLE IF EXISTS `chitchat_responses`;
CREATE TABLE `chitchat_responses` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `chitchat_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `merchant_id` int(11) DEFAULT NULL,
  `last_response` varchar(12) DEFAULT NULL,
  `body` text,
  `creation` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `d_idx` (`id`) USING BTREE,
  KEY `chitchat_id_idx` (`chitchat_id`) USING BTREE,
  KEY `user_id_idx` (`user_id`) USING BTREE,
  KEY `merchant_id_idx` (`merchant_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=240 DEFAULT CHARSET=latin1;

-- ----------------------------
--  Table structure for `followers`
-- ----------------------------
DROP TABLE IF EXISTS `followers`;
CREATE TABLE `followers` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type` int(1) DEFAULT NULL,
  `follower_id` int(11) DEFAULT NULL,
  `followee_id` int(11) DEFAULT NULL,
  `creation` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_idx` (`id`) USING BTREE,
  KEY `follwer_id_idx` (`follower_id`) USING BTREE,
  KEY `followee_id_idx` (`followee_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=72 DEFAULT CHARSET=latin1;

-- ----------------------------
--  Table structure for `livechatter`
-- ----------------------------
DROP TABLE IF EXISTS `livechatter`;
CREATE TABLE `livechatter` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `merchant_id` int(11) DEFAULT NULL,
  `body` text,
  `latitude` float(10,8) DEFAULT NULL,
  `longitude` float(10,8) DEFAULT NULL,
  `starttime` int(11) DEFAULT NULL,
  `endtime` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `alerted` int(11) DEFAULT NULL,
  `creation` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_idx` (`id`) USING BTREE,
  KEY `merchant_id_idx` (`merchant_id`) USING BTREE,
  KEY `latitude_idx` (`latitude`) USING BTREE,
  KEY `longitude_idx` (`longitude`) USING BTREE,
  KEY `alerted_idx` (`alerted`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=188 DEFAULT CHARSET=latin1;

-- ----------------------------
--  Table structure for `livechatter_categories`
-- ----------------------------
DROP TABLE IF EXISTS `livechatter_categories`;
CREATE TABLE `livechatter_categories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `category` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

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
--  Table structure for `locations`
-- ----------------------------
DROP TABLE IF EXISTS `locations`;
CREATE TABLE `locations` (
  `zipcode` int(5) unsigned zerofill NOT NULL,
  `latitude` float(10,8) DEFAULT NULL,
  `longitude` float(10,8) DEFAULT NULL,
  `state` varchar(2) DEFAULT NULL,
  `city` varchar(128) DEFAULT NULL,
  `county` varchar(128) DEFAULT NULL,
  PRIMARY KEY (`zipcode`),
  KEY `zipcode_idx` (`zipcode`) USING BTREE,
  KEY `latitude_idx` (`latitude`) USING BTREE,
  KEY `longitude_idx` (`longitude`) USING BTREE,
  KEY `state_idx` (`state`) USING BTREE,
  KEY `city_idx` (`city`) USING BTREE,
  KEY `country_idx` (`county`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
--  Table structure for `merchant_tokens`
-- ----------------------------
DROP TABLE IF EXISTS `merchant_tokens`;
CREATE TABLE `merchant_tokens` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `merchant_id` int(11) DEFAULT NULL,
  `token` varchar(40) DEFAULT NULL,
  `creation` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
--  Table structure for `merchant_user_associations`
-- ----------------------------
DROP TABLE IF EXISTS `merchant_user_associations`;
CREATE TABLE `merchant_user_associations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `merchant_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- ----------------------------
--  Table structure for `merchants`
-- ----------------------------
DROP TABLE IF EXISTS `merchants`;
CREATE TABLE `merchants` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `category_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `description` text,
  `contact_email` varchar(255) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `address1` varchar(255) DEFAULT NULL,
  `address2` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `state` varchar(3) DEFAULT NULL,
  `zipcode` varchar(16) DEFAULT NULL,
  `country` int(11) DEFAULT NULL,
  `phone` varchar(24) DEFAULT NULL,
  `latitude` double(10,7) DEFAULT NULL,
  `longitude` double(10,7) DEFAULT NULL,
  `gmt_offset` int(11) DEFAULT NULL,
  `dst` int(1) DEFAULT '0',
  `creation` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_idx` (`id`) USING BTREE,
  KEY `category_id_idx` (`category_id`) USING BTREE,
  KEY `name_idx` (`name`) USING BTREE,
  KEY `latitude_idx` (`latitude`) USING BTREE,
  KEY `longitude_idx` (`longitude`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=92 DEFAULT CHARSET=latin1;

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
--  Table structure for `posts`
-- ----------------------------
DROP TABLE IF EXISTS `posts`;
CREATE TABLE `posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `poster_id` int(11) DEFAULT NULL,
  `body` text,
  `status` int(11) DEFAULT NULL,
  `viewed` int(1) DEFAULT NULL,
  `creation` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_idx` (`id`) USING BTREE,
  KEY `user_id_idx` (`user_id`) USING BTREE,
  KEY `poster_id_idx` (`poster_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=90 DEFAULT CHARSET=latin1;

-- ----------------------------
--  Table structure for `redemptions`
-- ----------------------------
DROP TABLE IF EXISTS `redemptions`;
CREATE TABLE `redemptions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `livechatter_id` int(11) DEFAULT NULL,
  `creation` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_idx` (`id`) USING BTREE,
  KEY `user_id_idx` (`user_id`) USING BTREE,
  KEY `livechatter_id_idx` (`livechatter_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=71 DEFAULT CHARSET=latin1;

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
--  Table structure for `searches`
-- ----------------------------
DROP TABLE IF EXISTS `searches`;
CREATE TABLE `searches` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `latitude` float(10,8) DEFAULT NULL,
  `longitude` float(10,8) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `distance` int(11) DEFAULT NULL,
  `saved` int(1) DEFAULT NULL,
  `active` int(1) DEFAULT NULL,
  `creation` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_idx` (`id`) USING BTREE,
  KEY `user_id_idx` (`user_id`) USING BTREE,
  KEY `category_id_idx` (`category_id`) USING BTREE,
  KEY `saved_idx` (`saved`) USING BTREE,
  KEY `active_idx` (`active`) USING BTREE,
  KEY `distance_idx` (`distance`) USING BTREE,
  KEY `latitude_idx` (`latitude`) USING BTREE,
  KEY `longitude_idx` (`longitude`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=1335 DEFAULT CHARSET=latin1;

-- ----------------------------
--  Table structure for `user_tokens`
-- ----------------------------
DROP TABLE IF EXISTS `user_tokens`;
CREATE TABLE `user_tokens` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `token` varchar(40) DEFAULT NULL,
  `creation` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;

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
  `profile_img` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `state` varchar(2) DEFAULT NULL,
  `role` int(11) DEFAULT NULL,
  `merchant_id` int(11) DEFAULT NULL,
  `gmt_offset` int(11) DEFAULT NULL,
  `dst` int(1) DEFAULT NULL,
  `creation` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_idx` (`id`) USING BTREE,
  KEY `email_idx` (`email`) USING BTREE,
  KEY `merchant_id_idx` (`merchant_id`) USING BTREE,
  KEY `firstname_idx` (`firstname`) USING BTREE,
  KEY `lastname_idx` (`lastname`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=211 DEFAULT CHARSET=latin1;

SET FOREIGN_KEY_CHECKS = 1;
