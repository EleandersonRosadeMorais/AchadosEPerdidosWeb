-- Criar o banco de dados
CREATE DATABASE achados_perdidos;
USE achados_perdidos;

-- Tabela administrador
CREATE TABLE administrador (
    id_pk INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(100) NOT NULL,
    cpf VARCHAR(14) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    senha VARCHAR(255) NOT NULL
);

-- Tabela itemPerdido
CREATE TABLE itemPerdido (
id_pk INT PRIMARY KEY AUTO_INCREMENT,
nome VARCHAR(100) NOT NULL,
dataEncontrado DATE NOT NULL,
localizacaoEncontrada VARCHAR(200) NOT NULL,
localizacaoBuscar VARCHAR(200) NOT NULL,
tipo VARCHAR(50),
imagem VARCHAR(255),
administrador_fk INT,
status ENUM('disponivel', 'devolvido', 'arquivado') DEFAULT 'disponivel',
dataCadastro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
FOREIGN KEY (administrador_fk) REFERENCES administrador(id_pk)
);

-- Inserindo alguns dados de exemplo
INSERT INTO administrador (nome, cpf, email, senha) VALUES 
('João Silva', '123.456.789-00', 'joao.silva@email.com', 'senha123'),
('Maria Santos', '987.654.321-00', 'maria.santos@email.com', 'senha456');

INSERT INTO itemPerdido (nome, dataEncontrado, localizacaoEncontrada, localizacaoBuscar, tipo, imagem, administrador_fk, status) VALUES 
('Celular Samsung', '2024-01-15', 'Bloco A - Sala 101', 'Secretaria - Bloco Central', 'Eletrônico', 'celular.jpg', 1, 'disponivel'),
('Mochila Preta', '2024-01-10', 'Biblioteca - Setor de Estudos', 'Portaria 1', 'Acessório', 'mochila.jpg', 2, 'disponivel'),
('Garrafa Térmica Azul', '2024-01-12', 'Refeitório - Mesa 5', 'Secretaria - Bloco Central', 'Utensílio', 'garrafa.jpg', 1, 'devolvido');