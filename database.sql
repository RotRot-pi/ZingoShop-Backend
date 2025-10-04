-- ZingoShop E-commerce Platform

-- ------------------------------------------------------

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Database: `e_commerce`
--
CREATE DATABASE IF NOT EXISTS `e_commerce` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `e_commerce`;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--
CREATE TABLE `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(100) NOT NULL,
  `user_email` varchar(100) NOT NULL,
  `user_phone` varchar(100) NOT NULL,
  `user_password` varchar(100) NOT NULL,
  `user_verifycode` int(11) NOT NULL,
  `user_approve` tinyint(4) NOT NULL DEFAULT 0,
  `user_create` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `user_email` (`user_email`),
  UNIQUE KEY `user_phone` (`user_phone`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--
CREATE TABLE `admin` (
  `admin_id` int(11) NOT NULL AUTO_INCREMENT,
  `admin_name` varchar(100) NOT NULL,
  `admin_email` varchar(100) NOT NULL,
  `admin_phone` varchar(100) NOT NULL,
  `admin_password` varchar(100) NOT NULL,
  `admin_role` int(11) NOT NULL DEFAULT 0,
  `admin_verifycode` int(11) NOT NULL,
  `admin_approve` tinyint(4) NOT NULL DEFAULT 0,
  `admin_create` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`admin_id`),
  UNIQUE KEY `admin_email` (`admin_email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `deliveries`
--
CREATE TABLE `deliveries` (
  `delivery_id` int(11) NOT NULL AUTO_INCREMENT,
  `delivery_name` varchar(100) NOT NULL,
  `delivery_email` varchar(100) NOT NULL,
  `delivery_phone` varchar(100) NOT NULL,
  `delivery_password` varchar(100) NOT NULL,
  `delivery_verifycode` int(11) NOT NULL,
  `delivery_approve` tinyint(4) NOT NULL DEFAULT 0,
  `delivery_create` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`delivery_id`),
  UNIQUE KEY `delivery_email` (`delivery_email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--
CREATE TABLE `categories` (
  `categories_id` int(11) NOT NULL AUTO_INCREMENT,
  `categories_name` varchar(255) NOT NULL,
  `categories_name_ar` varchar(255) NOT NULL,
  `categories_image` varchar(255) NOT NULL,
  `categories_datetime` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`categories_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `items`
--
CREATE TABLE `items` (
  `items_id` int(11) NOT NULL AUTO_INCREMENT,
  `items_name` varchar(100) NOT NULL,
  `items_name_ar` varchar(100) NOT NULL,
  `items_description` varchar(255) NOT NULL,
  `items_description_ar` varchar(255) NOT NULL,
  `items_image` varchar(255) NOT NULL,
  `items_count` int(11) NOT NULL,
  `items_active` int(11) NOT NULL DEFAULT 1,
  `items_price` double NOT NULL,
  `items_discount` smallint(6) NOT NULL DEFAULT 0,
  `items_datetime` timestamp NOT NULL DEFAULT current_timestamp(),
  `items_category` int(11) NOT NULL,
  PRIMARY KEY (`items_id`),
  KEY `items_category_fk` (`items_category`),
  CONSTRAINT `items_category_fk` FOREIGN KEY (`items_category`) REFERENCES `categories` (`categories_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `address`
--
CREATE TABLE `address` (
  `address_id` int(11) NOT NULL AUTO_INCREMENT,
  `address_user_id` int(11) NOT NULL,
  `address_name` varchar(255) NOT NULL,
  `address_city` varchar(255) NOT NULL,
  `address_street` varchar(255) NOT NULL,
  `address_lat` double NOT NULL,
  `address_long` double NOT NULL,
  PRIMARY KEY (`address_id`),
  KEY `address_user_fk` (`address_user_id`),
  CONSTRAINT `address_user_fk` FOREIGN KEY (`address_user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `coupon`
--
CREATE TABLE `coupon` (
  `coupon_id` int(11) NOT NULL AUTO_INCREMENT,
  `coupon_name` varchar(50) NOT NULL,
  `coupon_discount` smallint(6) NOT NULL,
  `coupon_expire_date` datetime NOT NULL,
  `coupon_count` int(11) NOT NULL,
  PRIMARY KEY (`coupon_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--
CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL AUTO_INCREMENT,
  `order_user_id` int(11) NOT NULL,
  `order_address_id` int(11) NOT NULL,
  `order_type` int(11) NOT NULL DEFAULT 0 COMMENT '0=delivery, 1=pickup',
  `order_delivery_price` double NOT NULL DEFAULT 0,
  `order_price` float NOT NULL,
  `order_coupon_id` int(11) DEFAULT NULL,
  `order_totalprice` double NOT NULL DEFAULT 0,
  `order_payment_type` int(11) NOT NULL COMMENT '0=cash, 1=card',
  `stripe_payment_intent_id` varchar(255) DEFAULT NULL,
  `order_status` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0=pending, 1=approved, 2=preparing, 3=onway, 4=delivered',
  `order_delivery` int(11) DEFAULT NULL,
  `order_rating` tinyint(4) NOT NULL DEFAULT 0,
  `order_notating` varchar(255) DEFAULT NULL,
  `order_date_time` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`order_id`),
  KEY `order_user_fk` (`order_user_id`),
  KEY `order_address_fk` (`order_address_id`),
  KEY `order_coupon_fk` (`order_coupon_id`),
  KEY `order_delivery_fk` (`order_delivery`),
  CONSTRAINT `order_user_fk` FOREIGN KEY (`order_user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  CONSTRAINT `order_address_fk` FOREIGN KEY (`order_address_id`) REFERENCES `address` (`address_id`) ON DELETE CASCADE,
  CONSTRAINT `order_coupon_fk` FOREIGN KEY (`order_coupon_id`) REFERENCES `coupon` (`coupon_id`) ON DELETE SET NULL,
  CONSTRAINT `order_delivery_fk` FOREIGN KEY (`order_delivery`) REFERENCES `deliveries` (`delivery_id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--
CREATE TABLE `cart` (
  `cart_id` int(11) NOT NULL AUTO_INCREMENT,
  `cart_user_id` int(11) NOT NULL,
  `cart_item_id` int(11) NOT NULL,
  `cart_item_count` int(11) NOT NULL DEFAULT 1,
  `cart_order_id` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`cart_id`),
  KEY `cart_user_fk` (`cart_user_id`),
  KEY `cart_item_fk` (`cart_item_id`),
  CONSTRAINT `cart_user_fk` FOREIGN KEY (`cart_user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  CONSTRAINT `cart_item_fk` FOREIGN KEY (`cart_item_id`) REFERENCES `items` (`items_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `favorite`
--
CREATE TABLE `favorite` (
  `favorite_id` int(11) NOT NULL AUTO_INCREMENT,
  `favorite_user_id` int(11) NOT NULL,
  `favorite_item_id` int(11) NOT NULL,
  PRIMARY KEY (`favorite_id`),
  KEY `favorite_user_fk` (`favorite_user_id`),
  KEY `favorite_item_fk` (`favorite_item_id`),
  CONSTRAINT `favorite_user_fk` FOREIGN KEY (`favorite_user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  CONSTRAINT `favorite_item_fk` FOREIGN KEY (`favorite_item_id`) REFERENCES `items` (`items_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--
CREATE TABLE `notifications` (
  `notification_id` int(11) NOT NULL AUTO_INCREMENT,
  `notification_user_id` int(11) NOT NULL,
  `notification_title` varchar(100) NOT NULL,
  `notification_body` varchar(255) NOT NULL,
  `notification_date_time` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`notification_id`),
  KEY `notification_user_fk` (`notification_user_id`),
  CONSTRAINT `notification_user_fk` FOREIGN KEY (`notification_user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `home_cart_settings`
--
CREATE TABLE `home_cart_settings` (
  `home_cart_settings_id` int(11) NOT NULL AUTO_INCREMENT,
  `home_cart_settings_title` varchar(60) NOT NULL,
  `home_cart_settings_body` varchar(120) NOT NULL,
  `delivery_time` int(10) NOT NULL DEFAULT 30,
  PRIMARY KEY (`home_cart_settings_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


COMMIT;
