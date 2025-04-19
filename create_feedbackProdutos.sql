-- Criação do banco de dados
CREATE DATABASE IF NOT EXISTS feedback_produtos;
USE feedback_produtos;

-- Tabela de Usuários
CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL,
    admin BOOLEAN DEFAULT FALSE,
    deleted TINYINT(1) DEFAULT 0
);

-- Tabela de Produtos
CREATE TABLE IF NOT EXISTS produtos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100),
    descricao TEXT,
    preco DECIMAL(10, 2) NOT NULL,
    imagem VARCHAR(255)
);

-- Tabela de Feedback
CREATE TABLE IF NOT EXISTS feedbacks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    produto_id INT NOT NULL,
    usuario_id INT NOT NULL,
    nota INT NOT NULL CHECK (nota BETWEEN 1 AND 5),
    comentario TEXT,
    FOREIGN KEY (produto_id) REFERENCES produtos(id) ON DELETE CASCADE,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE
);

-- Inserir usuário administrador padrão
-- Senha: admin123 (hash gerado com password_hash)
INSERT INTO usuarios (nome, email, senha, admin) 
VALUES ('Administrador', 'admin@casasluiza.com', '$2y$12$dK/kPTCUdlxlHeo6B12EXehwE.Ai8exXQ9c4OBw41I6OoyKe91RxK', 1);