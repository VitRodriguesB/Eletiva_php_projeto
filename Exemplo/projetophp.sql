-- Banco de Dados: restaurante_db
CREATE DATABASE IF NOT EXISTS restaurante_db;
USE restaurante_db;

-- Tabela: usuarios
CREATE TABLE IF NOT EXISTS usuarios (
  id INT(11) NOT NULL AUTO_INCREMENT,
  nome VARCHAR(150) NOT NULL,
  email VARCHAR(150) NOT NULL,
  senha VARCHAR(255) NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Tabela: categoria
CREATE TABLE IF NOT EXISTS categoria (
  id INT NOT NULL AUTO_INCREMENT,
  nome VARCHAR(255) NOT NULL,
  descricao VARCHAR(255) NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB;

-- Tabela: produto
CREATE TABLE IF NOT EXISTS produto (
  id INT NOT NULL AUTO_INCREMENT,
  nome VARCHAR(255) NULL,
  descricao VARCHAR(255) NULL,
  preco DECIMAL(8,2) NULL,
  categoria_id INT NOT NULL,
  PRIMARY KEY (id),
  INDEX fk_produto_categoria_idx (categoria_id ASC),
  CONSTRAINT fk_produto_categoria
    FOREIGN KEY (categoria_id)
    REFERENCES categoria (id)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
) ENGINE=InnoDB;

-- Tabela: clientes
CREATE TABLE IF NOT EXISTS clientes (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nome VARCHAR(100) NOT NULL,
  telefone VARCHAR(20),
  email VARCHAR(100)
) ENGINE=InnoDB;

-- Tabela: mesas
CREATE TABLE IF NOT EXISTS mesas (
  id INT AUTO_INCREMENT PRIMARY KEY,
  numero INT NOT NULL UNIQUE,
  nome_reserva VARCHAR(100) DEFAULT NULL;
  status BOOLEAN DEFAULT TRUE
) ENGINE=InnoDB;

-- Tabela: pedidos
CREATE TABLE IF NOT EXISTS pedidos (
  id INT AUTO_INCREMENT PRIMARY KEY,
  cliente_id INT,
  mesa_id INT,
  data_pedido DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (cliente_id) REFERENCES clientes(id),
  FOREIGN KEY (mesa_id) REFERENCES mesas(id)
) ENGINE=InnoDB;

-- Tabela: itens_pedido
CREATE TABLE IF NOT EXISTS itens_pedido (
  id INT AUTO_INCREMENT PRIMARY KEY,
  pedido_id INT,
  produto_id INT,
  quantidade INT NOT NULL,
  FOREIGN KEY (pedido_id) REFERENCES pedidos(id),
  FOREIGN KEY (produto_id) REFERENCES produto(id)
) ENGINE=InnoDB;
