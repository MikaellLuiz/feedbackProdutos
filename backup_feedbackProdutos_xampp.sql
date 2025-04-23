-- Versão modificada do backup adaptada para MySQL do XAMPP
-- Mudanças principais: collation alterada para utf8mb4_general_ci e sintaxe CHECK modificada

-- Criação do banco de dados
CREATE DATABASE IF NOT EXISTS feedback_produtos DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE feedback_produtos;

-- Tabela de Usuários
DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `admin` tinyint(1) DEFAULT '0',
  `deleted` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dados dos usuários
INSERT INTO `usuarios` VALUES (5,'Administrador','admin@casasluiza.com','$2y$12$dK/kPTCUdlxlHeo6B12EXehwE.Ai8exXQ9c4OBw41I6OoyKe91RxK',1,0);

-- Tabela de Produtos
DROP TABLE IF EXISTS `produtos`;
CREATE TABLE `produtos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) DEFAULT NULL,
  `descricao` text,
  `preco` decimal(10,2) NOT NULL,
  `imagem` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dados dos produtos
INSERT INTO `produtos` VALUES 
(1,'Notebook','Notebook Dell Inspiron 15 I15-I120K-A46P Intel Core i7 16GB RAM SSD 512 GB 15,6',4556.07,'/feedbackProdutos/public/img/produtos/produto_680293c48c792.png'),
(2,'Galaxy A15','Smartphone Samsung Galaxy A15 6,5\" 128GB Azul Escuro 4G 4GB RAM Câm. Tripla 50MP + Selfie 13MP 5000mAh Dual Chip',809.10,'/feedbackProdutos/public/img/produtos/produto_68029367ee175.png'),
(3,'Jogo De Panelas','Jogo de Panelas Brinox Revestimento Cerâmico de Alumínio Preto 5 Peças Carbon Ceramic Life',569.91,'/feedbackProdutos/public/img/produtos/produto_6802941fd9faf.png'),
(4,'Sofá','Sofá Retrátil Reclinável 3 Lugares Suede - Phormatta Evolution SMP',1139.99,'/feedbackProdutos/public/img/produtos/produto_680294540cc94.png'),
(5,'Guarda Roupa','Guarda-Roupa Casal Colosseo 8 Portas 4 Gavetas Canelato/Natura - Panorama Móveis',669.90,'/feedbackProdutos/public/img/produtos/produto_68029481ae1a1.png'),
(6,'TV','Smart TV 50" 4K UHD LED Samsung 50DU7700 - Wi-Fi Bluetooth Alexa 3 HDMI',2349.06,'/feedbackProdutos/public/img/produtos/produto_680294aa35a7d.png');

-- Tabela de Feedbacks
DROP TABLE IF EXISTS `feedbacks`;
CREATE TABLE `feedbacks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `produto_id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `nota` int(11) NOT NULL,
  `comentario` text,
  PRIMARY KEY (`id`),
  KEY `produto_id` (`produto_id`),
  KEY `usuario_id` (`usuario_id`),
  CONSTRAINT `feedbacks_ibfk_1` FOREIGN KEY (`produto_id`) REFERENCES `produtos` (`id`) ON DELETE CASCADE,
  CONSTRAINT `feedbacks_ibfk_2` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Adiciona a restrição CHECK para o campo nota (compatível com MySQL 5.7)
ALTER TABLE `feedbacks` ADD CONSTRAINT `check_nota` CHECK (nota >= 1 AND nota <= 5);