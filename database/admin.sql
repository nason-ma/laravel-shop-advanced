-- MySQL dump 10.13  Distrib 5.7.24, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: laravel-shop
-- ------------------------------------------------------
-- Server version	5.7.24

-- 导出命令 mysqldump -t laravel-shop admin_menu admin_permissions admin_role_menu admin_role_permissions admin_role_users admin_roles admin_user_permissions admin_users > database/admin.sql
-- -t 选项代表不导出数据表结构，这些表的结构我们会通过 Laravel 的 migration 迁移文件来创建
-- laravel-shop 代表我们要导出的数据库名称，后面则是要导出的表列表
-- > database/admin.sql 把导出的内容保存到 database/admin.sql 文件中
-- 导入命令 mysql laravel-shop < database/admin.sql

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Dumping data for table `admin_menu`
--

LOCK TABLES `admin_menu` WRITE;
/*!40000 ALTER TABLE `admin_menu` DISABLE KEYS */;
INSERT INTO `admin_menu` VALUES (1,0,1,'首页','fa-bar-chart','/',NULL,NULL,'2021-03-02 02:43:04'),(2,0,9,'系统管理','fa-tasks',NULL,NULL,NULL,'2021-03-23 13:31:57'),(3,2,10,'管理员','fa-users','auth/users',NULL,NULL,'2021-03-23 13:31:57'),(4,2,11,'角色','fa-user','auth/roles',NULL,NULL,'2021-03-23 13:31:57'),(5,2,12,'权限','fa-ban','auth/permissions',NULL,NULL,'2021-03-23 13:31:57'),(6,2,13,'菜单','fa-bars','auth/menu',NULL,NULL,'2021-03-23 13:31:57'),(7,2,14,'操作日志','fa-history','auth/logs',NULL,NULL,'2021-03-23 13:31:57'),(8,0,2,'用户管理','fa-users','/users',NULL,'2021-03-02 02:59:04','2021-03-02 02:59:38'),(9,0,4,'商品管理','fa-cubes','/products',NULL,'2021-03-04 02:32:50','2021-03-23 03:21:17'),(10,0,7,'订单管理','fa-rmb','/orders',NULL,'2021-03-17 03:07:49','2021-03-23 13:31:57'),(11,0,8,'优惠券管理','fa-tags','/coupon_codes',NULL,'2021-03-18 12:46:32','2021-03-23 13:31:57'),(12,0,3,'类目管理','fa-bars','/categories',NULL,'2021-03-23 03:20:56','2021-03-23 03:21:17'),(13,9,6,'众筹商品','fa-flag-checkered','/crowdfunding_products',NULL,'2021-03-23 13:29:33','2021-03-23 13:31:57'),(14,9,5,'普通商品','fa-cubes','/products',NULL,'2021-03-23 13:31:50','2021-03-23 13:31:57');
/*!40000 ALTER TABLE `admin_menu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `admin_permissions`
--

LOCK TABLES `admin_permissions` WRITE;
/*!40000 ALTER TABLE `admin_permissions` DISABLE KEYS */;
INSERT INTO `admin_permissions` VALUES (1,'All permission','*','','*',NULL,NULL),(2,'Dashboard','dashboard','GET','/',NULL,NULL),(3,'Login','auth.login','','/auth/login\r\n/auth/logout',NULL,NULL),(4,'User setting','auth.setting','GET,PUT','/auth/setting',NULL,NULL),(5,'Auth management','auth.management','','/auth/roles\r\n/auth/permissions\r\n/auth/menu\r\n/auth/logs',NULL,NULL),(6,'用户管理','users','','/users*','2021-03-02 04:46:31','2021-03-02 04:46:31'),(7,'商品管理','products','','/products*','2021-03-19 06:04:51','2021-03-19 06:04:51'),(8,'订单管理','orders','','/orders*','2021-03-19 06:05:19','2021-03-19 06:05:19'),(9,'优惠券管理','coupon_codes','','/coupon_codes*','2021-03-19 06:05:57','2021-03-19 06:05:57');
/*!40000 ALTER TABLE `admin_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `admin_role_menu`
--

LOCK TABLES `admin_role_menu` WRITE;
/*!40000 ALTER TABLE `admin_role_menu` DISABLE KEYS */;
INSERT INTO `admin_role_menu` VALUES (1,2,NULL,NULL);
/*!40000 ALTER TABLE `admin_role_menu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `admin_role_permissions`
--

LOCK TABLES `admin_role_permissions` WRITE;
/*!40000 ALTER TABLE `admin_role_permissions` DISABLE KEYS */;
INSERT INTO `admin_role_permissions` VALUES (1,1,NULL,NULL),(2,2,NULL,NULL),(2,3,NULL,NULL),(2,4,NULL,NULL),(2,6,NULL,NULL),(2,7,NULL,NULL),(2,8,NULL,NULL),(2,9,NULL,NULL);
/*!40000 ALTER TABLE `admin_role_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `admin_role_users`
--

LOCK TABLES `admin_role_users` WRITE;
/*!40000 ALTER TABLE `admin_role_users` DISABLE KEYS */;
INSERT INTO `admin_role_users` VALUES (1,1,NULL,NULL),(2,2,NULL,NULL);
/*!40000 ALTER TABLE `admin_role_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `admin_roles`
--

LOCK TABLES `admin_roles` WRITE;
/*!40000 ALTER TABLE `admin_roles` DISABLE KEYS */;
INSERT INTO `admin_roles` VALUES (1,'Administrator','administrator','2021-03-02 01:56:34','2021-03-02 01:56:34'),(2,'运营','operator','2021-03-02 04:49:13','2021-03-02 04:49:13');
/*!40000 ALTER TABLE `admin_roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `admin_user_permissions`
--

LOCK TABLES `admin_user_permissions` WRITE;
/*!40000 ALTER TABLE `admin_user_permissions` DISABLE KEYS */;
/*!40000 ALTER TABLE `admin_user_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `admin_users`
--

LOCK TABLES `admin_users` WRITE;
/*!40000 ALTER TABLE `admin_users` DISABLE KEYS */;
INSERT INTO `admin_users` VALUES (1,'admin','$2y$10$gX2VqftBtPAY2xVnaZaTYuQnfCLCnbdeUydCyRabxQvENW5FCHjjC','Administrator',NULL,'VSPHvLs6a2hC5Hbgs6dbGlQVBnTjg6eqIvxfEIqdf1h2jhCBmNsvI8o1SZd5','2021-03-02 01:56:34','2021-03-02 01:56:34'),(2,'operator','$2y$10$gCR5r25W1QNHI4n0vqH2JOTf39a.hZETR.k5r4fK2gdfJYT5iaLqy','运营',NULL,'kjttVadB3IGz0lHx7y1ybwmxtlygm9iJ4fEqpaaucLGj69Hlz2vwEEybZH6B','2021-03-02 04:50:22','2021-03-02 04:50:22');
/*!40000 ALTER TABLE `admin_users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2021-03-23 22:20:02
