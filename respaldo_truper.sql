-- MySQL dump 10.13  Distrib 8.0.45, for Linux (x86_64)
--
-- Host: localhost    Database: truper_equipo_ocho
-- ------------------------------------------------------
-- Server version	8.0.45-0ubuntu0.24.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `productos`
--

DROP TABLE IF EXISTS `productos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `productos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `codigo` varchar(20) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `categoria` varchar(50) DEFAULT NULL,
  `precio` decimal(10,2) NOT NULL,
  `stock` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=55 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `productos`
--

LOCK TABLES `productos` WRITE;
/*!40000 ALTER TABLE `productos` DISABLE KEYS */;
INSERT INTO `productos` VALUES (1,'TRU-1001','Taladro Rotomartillo 1/2 550W','Herramientas Eléctricas',899.00,25),(2,'TRU-1002','Esmeriladora Angular 4-1/2 800W','Herramientas Eléctricas',750.00,15),(3,'TRU-1003','Juego de Autocle 1/2 42 piezas','Herramientas de Mano',1599.00,10),(4,'TRU-1004','Inversor para Soldar 130A','Herramientas Eléctricas',2499.00,8),(5,'TRU-1005','Carretilla 5.5 Pies Cúbicos Neumática','Construcción',1250.00,30),(6,'TRU-1006','Pala Redonda Puño Y','Construcción',285.00,50),(7,'TRU-1007','Pala Cuadrada Puño Y','Construcción',285.00,45),(8,'TRU-1008','Martillo de Uña Curva 16 oz','Herramientas de Mano',165.00,60),(9,'TRU-1009','Juego de Destornilladores 6 piezas','Herramientas de Mano',210.00,40),(10,'TRU-1010','Pinzas de Presión 10pulg','Herramientas de Mano',195.00,35),(11,'TRU-1011','Flexómetro Gripper 5 metros','Medición',115.00,100),(12,'TRU-1012','Arco para Segueta Profesional','Herramientas de Mano',185.00,28),(13,'TRU-1013','Llave Ajustable (Perica) 8pulg','Herramientas de Mano',145.00,40),(14,'TRU-1014','Compresor de Aire 25 Litros 2.5 HP','Herramientas Eléctricas',2899.00,12),(15,'TRU-1015','Gato Hidráulico de Botella 4 Ton','Automotriz',450.00,18),(16,'TRU-1016','Nivel de Aluminio 24pulg','Medición',230.00,22),(17,'TRU-1017','Cinta Asilante Negra 18m','Electricidad',25.00,200),(18,'TRU-1018','Multímetro Digital Escolar','Electricidad',199.00,50),(19,'TRU-1019','Soldador de Cautín 40W','Electricidad',135.00,30),(20,'TRU-1020','Juego de Llaves Allen 9 piezas','Herramientas de Mano',175.00,45),(21,'TRU-1021','Machete Estándar 22pulg','Jardinería',120.00,70),(22,'TRU-1022','Tijera para Podar Cuchilla Recta','Jardinería',240.00,33),(23,'TRU-1023','Manguera de Riego 15 metros 1/2','Jardinería',320.00,40),(24,'TRU-1024','Fumigador de Mochila 16 Litros','Jardinería',950.00,15),(25,'TRU-1025','Pico Zapapico 5 lb con mango','Construcción',380.00,25),(26,'TRU-1026','Cisterna Hidroneumática 1/2 HP','Plomería',2150.00,7),(27,'TRU-1027','Bomba Periférica de Agua 1/2 HP','Plomería',650.00,20),(28,'TRU-1028','Llave de Tubo (Stilson) 14pulg','Plomería',290.00,15),(29,'TRU-1029','Cortador de Tubo de Cobre','Plomería',185.00,22),(30,'TRU-1030','Cinta Teflon 1/2 pulg Caja 10 pzs','Plomería',85.00,120),(31,'TRU-1031','Gafas de Seguridad Transparentes','Seguridad',45.00,150),(32,'TRU-1032','Guantes de Carnaza Cortos','Seguridad',89.00,90),(33,'TRU-1033','Casco de Seguridad Amarillo','Seguridad',110.00,65),(34,'TRU-1034','Mascarilla Respiradora contra Polvo','Seguridad',140.00,40),(35,'TRU-1035','Arnés de Seguridad Cuerpo Completo','Seguridad',680.00,14),(36,'TRU-1036','Sierra Circular 7-1/4 1500W','Herramientas Eléctricas',1650.00,11),(37,'TRU-1037','Lijadora Orbital 1/4 Hoja 200W','Herramientas Eléctricas',620.00,19),(38,'TRU-1038','Caladora de Banco 550W','Herramientas Eléctricas',1199.00,8),(39,'TRU-1039','Juego de Brocas para Concreto 5 pzs','Accesorios',145.00,85),(40,'TRU-1040','Disco de Diamante General 4-1/2','Accesorios',125.00,110),(41,'TRU-1041','Caja de Herramientas Plástica 16pulg','Almacenamiento',260.00,35),(42,'TRU-1042','Organizador de Tornillos 25 Gavetas','Almacenamiento',340.00,25),(43,'TRU-1043','Moleta Cortadora de Azulejo 24pulg','Construcción',1450.00,9),(44,'TRU-1044','Brocha para Pintar 3 pulgadas','Pintura',38.00,180),(45,'TRU-1045','Rodillo Profesional Felpa 3/8','Pintura',75.00,95),(46,'TRU-1046','Espátula de Acero Flexible 2pulg','Pintura',45.00,70),(47,'TRU-1047','Pistola de Calor 1500W','Herramientas Eléctricas',580.00,16),(48,'TRU-1048','Caimán Eléctrico Juego de Cables','Automotriz',160.00,40),(49,'TRU-1049','Cargador de Baterías de Auto 12V','Automotriz',1150.00,10),(50,'TRU-1050','Linterna LED Recargable Alta Potencia','Iluminación',275.00,55),(51,'TRU-2001','Lona Reforzada Azul 3x4m','Accesorios',350.00,15),(52,'TRU-2001','Lona Reforzada Azul 3x4m','Accesorios',350.00,15),(53,'TRU-2002','Sierra Electrica','Herramientas Electricas',5000.00,5),(54,'TRU-2002','Sierra Electrica','Herramientas Electricas',5000.00,5);
/*!40000 ALTER TABLE `productos` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-06-01  6:14:29
