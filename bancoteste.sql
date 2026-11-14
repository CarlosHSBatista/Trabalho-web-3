CREATE DATABASE IF NOT EXISTS loja
  DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE loja;

CREATE TABLE clientes (
  id int(11) NOT NULL AUTO_INCREMENT,
  nome varchar(100) NOT NULL,
  email varchar(100) NOT NULL,
  data_cadastro timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE enderecos (
  id int(11) NOT NULL AUTO_INCREMENT,
  cliente_id int(11) NOT NULL,
  logradouro varchar(150) NOT NULL,
  numero varchar(10) NOT NULL,
  complemento varchar(100),
  bairro varchar(80) NOT NULL,
  cidade varchar(80) NOT NULL,
  estado char(2) NOT NULL,
  cep char(8) NOT NULL,
  PRIMARY KEY (id),
  FOREIGN KEY (cliente_id) REFERENCES clientes(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE pedidos (
  id int(11) NOT NULL AUTO_INCREMENT,
  cliente_id int(11) NOT NULL,
  nome_pedido varchar(100) NOT NULL,
  endereco_id int(11) NOT NULL,
  valor decimal(10,2) NOT NULL,
  data_pedido timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (id),
  FOREIGN KEY (cliente_id) REFERENCES clientes(id) ON UPDATE CASCADE,
  FOREIGN KEY (endereco_id) REFERENCES enderecos(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE itens_pedido (
  id int(11) NOT NULL AUTO_INCREMENT,
  pedido_id int(11) NOT NULL,
  produto varchar(100) NOT NULL,
  quantidade int NOT NULL,
  valor_unitario decimal(10,2) NOT NULL,
  PRIMARY KEY (id),
  FOREIGN KEY (pedido_id) REFERENCES pedidos(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


INSERT INTO clientes (id, nome, email, data_cadastro) VALUES
(1, 'João', 'algo@email.com', '2026-10-10 00:50:44'),
(4, 'Lara', 'lara@email.com', '2026-11-06 15:38:47');

INSERT INTO enderecos (id, cliente_id, logradouro, numero, complemento, bairro, cidade, estado, cep) VALUES
(1, 1, 'Rua Exemplo', '100', NULL, 'Centro', 'Uberaba', 'MG', '38000000'),
(2, 4, 'Av. Exemplo', '200', 'Apto 5', 'Centro', 'Uberaba', 'MG', '38000001');

INSERT INTO pedidos (id, cliente_id, nome_pedido, endereco_id, valor, data_pedido) VALUES
(1, 4, 'Pedido 1', 2, 3.00, '2026-11-06 16:25:36'),
(2, 4, 'Pedido 2', 2, 78.00, '2026-11-06 16:42:34'),
(3, 1, 'Pedido 3', 1, 0.01, '2026-11-06 16:42:44');