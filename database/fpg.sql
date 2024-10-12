/*
SQLyog Ultimate v9.50 
MySQL - 5.5.5-10.4.22-MariaDB : Database - fpg
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`fpg` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;

USE `fpg`;

/*Table structure for table `tb_admin` */

DROP TABLE IF EXISTS `tb_admin`;

CREATE TABLE `tb_admin` (
  `user` varchar(16) NOT NULL,
  `pass` varchar(16) DEFAULT NULL,
  PRIMARY KEY (`user`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `tb_admin` */

insert  into `tb_admin`(`user`,`pass`) values ('admin','admin');

/*Table structure for table `tb_data` */

DROP TABLE IF EXISTS `tb_data`;

CREATE TABLE `tb_data` (
  `id_data` int(11) NOT NULL AUTO_INCREMENT,
  `id_transaksi` varchar(16) DEFAULT NULL,
  `item` varchar(255) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  PRIMARY KEY (`id_data`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;

/*Data for the table `tb_data` */

insert  into `tb_data`(`id_data`,`id_transaksi`,`item`,`tanggal`) values (1,'T000001','Apel','2019-02-26'),(2,'T000001','Bir','2019-02-26'),(3,'T000001','Nasi','2019-02-26'),(4,'T000001','Ayam','2019-02-26'),(5,'T000002','Apel','2019-02-27'),(6,'T000002','Bir','2019-02-28'),(7,'T000002','Nasi','2019-03-01'),(8,'T000003','Apel','2019-03-02'),(9,'T000003','Bir','2019-03-02'),(10,'T000004','Apel','2019-03-03'),(11,'T000004','Bir','2019-03-03'),(12,'T000005','Bir','2019-03-04'),(13,'T000005','Nasi','2019-03-04'),(14,'T000005','Ayam','2019-03-04'),(15,'T000005','Susu','2019-03-04'),(16,'T000006','Bir','2019-03-05'),(17,'T000006','Nasi','2019-03-05'),(18,'T000006','Susu','2019-03-05'),(19,'T000007','Bir','2019-03-06'),(20,'T000007','Susu','2019-03-06'),(21,'T000008','Pir','2019-03-07'),(22,'T000008','Susu','2019-03-07');

/*Table structure for table `tb_hasil` */

DROP TABLE IF EXISTS `tb_hasil`;

CREATE TABLE `tb_hasil` (
  `id_hasil` int(11) NOT NULL AUTO_INCREMENT,
  `left_item` varchar(255) DEFAULT NULL,
  `right_item` varchar(255) DEFAULT NULL,
  `supp` double DEFAULT NULL,
  `conf` double DEFAULT NULL,
  `lift` double DEFAULT NULL,
  PRIMARY KEY (`id_hasil`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

/*Data for the table `tb_hasil` */

insert  into `tb_hasil`(`id_hasil`,`left_item`,`right_item`,`supp`,`conf`,`lift`) values (1,'bir, ayam','nasi',0.25,1,2),(2,'nasi, ayam','bir',0.25,1,1.1428571428571),(3,'ayam','bir, nasi',0.25,1,2),(4,'ayam','bir',0.25,1,1.1428571428571),(5,'ayam','nasi',0.25,1,2),(6,'nasi, susu','bir',0.25,1,1.1428571428571),(7,'susu','bir',0.375,0.75,0.85714285714286),(8,'apel, nasi','bir',0.25,1,1.1428571428571),(9,'nasi','bir',0.5,1,1.1428571428571),(10,'apel','bir',0.5,1,1.1428571428571);

/*Table structure for table `tb_options` */

DROP TABLE IF EXISTS `tb_options`;

CREATE TABLE `tb_options` (
  `option_name` varchar(255) NOT NULL,
  `option_value` text DEFAULT NULL,
  PRIMARY KEY (`option_name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `tb_options` */

insert  into `tb_options`(`option_name`,`option_value`) values ('fpg_conf','75'),('fpg_data','8'),('fpg_memory','629.8984375'),('fpg_supp','25'),('fpg_time','1.7130019664764');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
