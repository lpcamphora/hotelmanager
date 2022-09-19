DROP DATABASE hotel_manager;
CREATE DATABASE IF NOT EXISTS hotel_manager;
USE hotel_manager;

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id_user` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_role` int(11) unsigned NOT NULL,
  `name` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(170) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(80) COLLATE utf8_unicode_ci DEFAULT NULL,
  `id_github` int(11) unsigned DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

INSERT INTO users VALUES (NULL, 1, 'Gerente 1', 'gerente@hotel', '$2y$10$sEb25qQBGDCn8fiz41VdIOuU.BkpqInE2iENoOaAvATYQAtgaiMJi', NULL, NOW(), NOW());
INSERT INTO users VALUES (NULL, 2, 'Atendente 1', 'atendente@hotel', '$2y$10$sEb25qQBGDCn8fiz41VdIOuU.BkpqInE2iENoOaAvATYQAtgaiMJi', NULL, NOW(), NOW());

CREATE TABLE `roles` (
  `id_role` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id_role`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

INSERT INTO roles VALUES (1, 'Gerência', NOW(), NOW());
INSERT INTO roles VALUES (2, 'Atendimento', NOW(), NOW());

DROP TABLE IF EXISTS `apartments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `apartments` (
  `id_apartment` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `number` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id_apartment`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

INSERT INTO apartments VALUES (1, 'Apartamento', 101, NOW(), NOW());
INSERT INTO apartments VALUES (2, 'Apartamento', 102, NOW(), NOW());
INSERT INTO apartments VALUES (3, 'Apartamento', 103, NOW(), NOW());
INSERT INTO apartments VALUES (4, 'Apartamento', 104, NOW(), NOW());
INSERT INTO apartments VALUES (5, 'Apartamento', 201, NOW(), NOW());
INSERT INTO apartments VALUES (6, 'Apartamento', 202, NOW(), NOW());
INSERT INTO apartments VALUES (7, 'Apartamento', 203, NOW(), NOW());
INSERT INTO apartments VALUES (8, 'Apartamento', 204, NOW(), NOW());
INSERT INTO apartments VALUES (9, 'Cobertura', 301, NOW(), NOW());

DROP TABLE IF EXISTS `clients`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `clients` (
  `id_client` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `last_name` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cpf` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id_client`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

DROP TABLE IF EXISTS `plans`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `plans` (
  `id_plan` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `days` int(11) DEFAULT NULL,
  `price` decimal(12, 2) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id_plan`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

INSERT INTO plans VALUES (1, 'Diária', 1, 1250.00, NOW(), NOW());
INSERT INTO plans VALUES (2, 'Mensal', 30, 15750.00, NOW(), NOW());

DROP TABLE IF EXISTS `services`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `services` (
  `id_service` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `price` decimal(12, 2) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id_service`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

INSERT INTO services VALUES (1, 'Café', 25.00, NOW(), NOW());
INSERT INTO services VALUES (2, 'Almoço', 50.00, NOW(), NOW());
INSERT INTO services VALUES (3, 'Janta', 50.00, NOW(), NOW());
INSERT INTO services VALUES (4, 'Faxina', 150.00, NOW(), NOW());
INSERT INTO services VALUES (5, 'Lavanderia', 70.00, NOW(), NOW());

DROP TABLE IF EXISTS `controls`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `controls` (
  `id_control` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_apartment` int(11) unsigned DEFAULT NULL,
  `id_client` int(11) unsigned DEFAULT NULL,
  `id_plan` int(11) unsigned DEFAULT NULL,
  `payment_method` int(11) unsigned DEFAULT NULL,
  `total` decimal(12, 2) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id_control`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

DROP TABLE IF EXISTS `controls_services`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `controls_services` (
  `id_control_service` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_control` int(11) unsigned NOT NULL,
  `id_service` int(11) unsigned NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id_control_service`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

DROP TABLE IF EXISTS `reports`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `reports` (
  `id_report` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_apartment` int(11) unsigned DEFAULT NULL,
  `id_client` int(11) unsigned DEFAULT NULL,
  `id_plan` int(11) unsigned DEFAULT NULL,
  `payment_method` int(11) unsigned DEFAULT NULL,
  `total` decimal(12, 2) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id_report`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;


ALTER TABLE users ADD CONSTRAINT userRole FOREIGN KEY(id_role) REFERENCES roles(id_role);
ALTER TABLE controls ADD CONSTRAINT controlBedroom FOREIGN KEY(id_apartment) REFERENCES apartments(id_apartment);
ALTER TABLE controls ADD CONSTRAINT controlClient FOREIGN KEY(id_client) REFERENCES clients(id_client);
ALTER TABLE controls ADD CONSTRAINT controlPlan FOREIGN KEY(id_plan) REFERENCES plans(id_plan);
ALTER TABLE controls_services ADD CONSTRAINT controlParent FOREIGN KEY(id_control) REFERENCES controls(id_control) ON DELETE CASCADE;
ALTER TABLE controls_services ADD CONSTRAINT controlService FOREIGN KEY(id_service) REFERENCES services(id_service);
ALTER TABLE reports ADD CONSTRAINT reportBedroom FOREIGN KEY(id_apartment) REFERENCES apartments(id_apartment);
ALTER TABLE reports ADD CONSTRAINT reportClient FOREIGN KEY(id_client) REFERENCES clients(id_client);
ALTER TABLE reports ADD CONSTRAINT reportPlan FOREIGN KEY(id_plan) REFERENCES plans(id_plan);

