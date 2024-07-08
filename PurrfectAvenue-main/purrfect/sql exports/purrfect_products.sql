-- MySQL dump 10.13  Distrib 8.0.36, for Win64 (x86_64)
--
-- Host: localhost    Database: purrfect
-- ------------------------------------------------------
-- Server version	8.4.0

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `products` (
  `product_id` int NOT NULL AUTO_INCREMENT,
  `image_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `product_name` varchar(70) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `product_desc` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `product_price` decimal(10,2) NOT NULL,
  `product_group` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` VALUES (2,'https://th.bing.com/th/id/OIP.SUw13_i02C83iht6_IjV_QHaHa?rs=1&pid=ImgDetMain','Special Cat - Beef and Liver','This is a delicious canned cat food made. with beef and liver.',19.99,'food'),(3,'https://www.petwarehouse.ph/23230-big_default/canicee-ascorbic-acid-60ml-vitamin-c-syrup-for-dogs.jpg','Ascorbic Acid - Canicee','Product description',19.99,'health'),(4,'https://m.media-amazon.com/images/I/81ZgJBoWL+L._AC_SY300_SX300_.jpg','Cat Harness and Leash - Black','A premium harness releases the pressure on the cat&#39;s chest so keep them in comfort.',150.00,'accessory'),(6,'https://www.petexpress.com.ph/cdn/shop/products/10277023-Bearing-Anti-Tick-and-Flea-All-Breed-F1-Pet-Shampoo-1500ml-front_600x.png?v=1652773342','Bearing - Tick and Flea Dog Shampoo','Product description',19.99,'supplies'),(7,'https://th.bing.com/th/id/OIP.R7eo3snKHmMBjPxvUVo5rQHaHa?rs=1&pid=ImgDetMain','Cat Toy Roller Ball Track Tower','Product Desc',19.99,'toy'),(8,'https://th.bing.com/th/id/OIP.8EWc1Jpz2StfkRBnOO25iAHaFt?rs=1&pid=ImgDetMain','Cat Harness and Leash - Blue','A premium harness releases the pressure on the cat&#39;s chest so keep them in comfort.',150.00,'accessory'),(11,'https://www.purina-arabia.com/sites/default/files/2022-05/Friskies%20Kitten%20Discoveries.jpg','Friskies - Kittens','Cat Food',59.99,'food'),(12,'https://doggo.com.ph/cdn/shop/products/DOGTREATS3_1024x1024@2x.jpg?v=1602291434','Doggo Dog Treats','They are low in calories and are made with all natural ingredients.',119.00,'food'),(13,'https://th.bing.com/th/id/OIP.tv_cW69EAFlc1ap2nhhXiAHaHa?w=1000&h=1000&rs=1&pid=ImgDetMain','Dreamies - Tasty Chicken','Deliciously crunchy on the outside, soft on the inside cat treats.',89.00,'food'),(14,'https://d7rh5s3nxmpy4.cloudfront.net/CMP9365/1/8711231129515_1.png','Beaphar - Multi-Vit Paste','Product description',29.99,'health'),(15,'https://www.petwarehouse.ph/10992-big_default/lc-vit-plus-multivitamins-cat-and-kitten-syrup.jpg','LC-Vit Plus Syrup','Product description',29.99,'health'),(16,'https://th.bing.com/th/id/OIP.n5AlFlOAf3hGgFyHYh7FzQHaHa?w=720&h=720&rs=1&pid=ImgDetMain','Nutri-Vet - Multi-Vite Cat Paw Gel','Product description',29.99,'health'),(17,'https://www.petwarehouse.ph/23580-thickbox_default/troy-nutripet-dietary-supplement-200g-high-energy-vitamin-concentrate-for-dogs-and-cats.jpg','Troy - Nutripet','Product description',29.99,'health'),(18,'https://assets.petco.com/petco/image/upload/c_pad,dpr_1.0,f_auto,q_auto,h_636,w_636/c_pad,h_636,w_636/3584056-center-1','VetriScience Laboratories Multivitamin for Cats','cat',29.99,'health'),(20,'https://th.bing.com/th/id/OIP.Fjf16UGNXexbs8b1X9-hQQHaFv?rs=1&pid=ImgDetMain','Cat Harness and Leash - Pink','A premium harness releases the pressure on the cat&#39;s chest so keep them in comfort.',150.00,'accessory'),(21,'https://i5.walmartimages.com/asr/235197f1-bca4-4b95-8c64-02d0b266c982.6b8e163f13acf37e85214bbb87f05240.jpeg','Dog Collar and Leash - Blue','A premium harness releases the pressure on the cat&#39;s chest so keep them in comfort.',150.00,'accessory'),(22,'https://th.bing.com/th/id/OIP.wSNomZ1QsWRRzuob55Y4ZwHaFj?rs=1&pid=ImgDetMain','Dog Collar and Leash - Pink','A strap made of leather, nylon or other similar material attached to the collar.',150.00,'accessory'),(23,'https://i5.walmartimages.com/asr/cc64912b-864d-4e93-ac5d-1f035d40eb2d.a6532b4428cc391afb9e56a996f84e2d.jpeg','Dog Collar and Leash - Purple','A strap made of leather, nylon or other similar material attached to the collar.',150.00,'accessory'),(25,'https://th.bing.com/th/id/OIP.TGQpUV3DMPSGHcD9vPIxAQHaHa?rs=1&pid=ImgDetMain','Knotted Rope Dog Toy','Product description',29.99,'toy'),(27,'https://th.bing.com/th/id/OIP.jQ97EgzHeu0TrYEC3qp-ywHaIF?rs=1&pid=ImgDetMain','Linen Ball Cat Toy','desc',29.99,'toy'),(28,'https://th.bing.com/th/id/OIP.6NKg8h6CFh3sYJe8CB6LSQHaHa?rs=1&pid=ImgDetMain','Rubber Dog Ball','Product Desc',29.99,'toy'),(29,'https://th.bing.com/th/id/OIP.tJel69VEvdqYIhhALZkeWgHaHB?rs=1&pid=ImgDetMain','Wooven and Feather Ball Cat Toy','Product description',29.99,'toy'),(30,'https://afhomeph.com/cdn/shop/products/dogcageblack_04236da9-9694-43cc-8866-a495b62170fe.webp?v=1649233446&width=500','Collapsible Pet Cage - Black','Snaps together with a handle for carrying to make traveling with your pet a breeze.',905.00,'bedcage'),(31,'https://www.petwarehouse.ph/14754-thickbox_default/petto-ai-collapsible-pet-cage-purple.jpg','Collapsible Pet Cage - Purple','Snaps together with a handle for carrying to make traveling with your pet a breeze.',905.00,'bedcage'),(32,'https://images-na.ssl-images-amazon.com/images/I/41+9Rl8nSBL.SS700.jpg','Cat Backpack - Pink','Is designed for ease of use with adjustable padded shoulder straps, a sturdy handle.',305.00,'bedcage'),(33,'https://ae01.alicdn.com/kf/S70306c544b5445f8a679bb70c3ad16aav/Cat-Carrier-Bag-Outdoor-Pet-Shoulder-bag-Carriers-Backpack-Breathable-Portable-Travel-Transparent-Bag-For-Small.png_640x640.png_.webp','Cat Backpack - Black','Is designed for ease of use with adjustable padded shoulder straps, a sturdy handle.',305.00,'bedcage'),(34,'https://r.r10s.jp/ran/img/3001/0008/010/690/167/084/30010008010690167084_1.jpg','Pet Carrier - Black','Small portable boxes, crates, or cages used to transport small animals.',205.00,'bedcage'),(35,'https://p.globalsources.com/IMAGES/PDT/B1181485477/pet-carrier.jpg','Pet Carrier - Brown','Small portable boxes, crates, or cages used to transport small animals.',205.00,'bedcage'),(36,'https://images.yaoota.com/gChGSYzU_Qq-3piYziWKTSTUd7w=/trim/fit-in/500x500/filters:quality(80)/yaootaweb-production-ke/media/crawledproductimages/2af9f9a497a6a1e10091c45c32d61efa2b5d8a9d.jpg','Nail Cutter and Trimmer - Blue','Product Description',29.99,'supplies'),(37,'https://www.petwarehouse.ph/3269-big_default/oster-oatmeal-naturals-dander-control-532ml-cat-shampoo.jpg','Oster Oatmeal Naturals - Dander Control','Product description',29.99,'supplies'),(38,'https://www.decormartph.com/assets-static/assets/portal-assets/73/product/images/3895/3895__496x496.jpg','Our Cat - Pink Rose Shampoo','Product description',29.99,'supplies'),(39,'https://www.petwarehouse.ph/14568-thickbox_default/our-dog-aloe-vera-1l-dog-shampoo.jpg','Our Dog - Aloe Vera Shampoo','Product description',29.99,'supplies'),(40,'https://images-na.ssl-images-amazon.com/images/I/6150DiBJhoL._AC_SL1000_.jpg','Pet Hair Grooming Brush - Blue','Product Desc',29.99,'supplies'),(41,'https://encrypted-tbn3.gstatic.com/shopping?q=tbn:ANd9GcSLmVnHELFgC2hYmR8NWEpStHYaIR7jIDgV-xhJuqCKNAtB1OxhrJQLmCPbpivBencXl0x63hle&amp;usqp=CAY','Ceramic Dog Bowl','Product description',19.99,'utility'),(42,'https://www.georgebarclay.co.uk/cdn/shop/products/Concave_Wht.jpg?v=1629122057','Concave Double Feeding Dog Bowl','Product description',29.99,'utility'),(43,'https://m.media-amazon.com/images/I/51aBYJgvewL._AC_SX679_.jpg','Elevated Cat Bowls','Product description',29.99,'utility'),(44,'https://www.petdiscount.ph/wp-content/uploads/2017/02/NEW-Feline-Lavender.jpg','Feline Fresh - Lavander','adasdasdsa',29.99,'utility'),(45,'https://down-vn.img.susercontent.com/file/3c1ef72ac611b3a9909134929fb9ee85','Jolly Cat - Espresso Cat Litter','Product description',29.99,'utility'),(46,'https://catsgarage.com.sg/cdn/shop/products/Screenshot2023-01-09at1.01.57PM_480x608.png?v=1673240539','Jolly Cat - Lemon Cat Litter','The fast-clumping action makes an easy job of maintaining your cat&#39;s litter tray.',690.00,'utility');
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-07-07  4:08:34
