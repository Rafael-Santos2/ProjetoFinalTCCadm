CREATE DATABASE voz_infantil;
USE voz_infantil;

CREATE TABLE denuncias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    protocolo VARCHAR(12) NOT NULL,
    cep VARCHAR(10),
    estado VARCHAR(50),
    cidade VARCHAR(100),
    bairro VARCHAR(100),
    rua VARCHAR(150),
    numero VARCHAR(20),
    tipo_crime VARCHAR(100),
    complemento VARCHAR(200),
    arquivo VARCHAR(255),
    data_envio TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 1) adiciona coluna status na tabela denuncias (se ainda não existir)
ALTER TABLE denuncias
  ADD COLUMN status VARCHAR(30) NOT NULL DEFAULT 'recebido';

-- 2) cria tabela de usuarios (policiais / operadores)
CREATE TABLE usuarios (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nome VARCHAR(150) NOT NULL,
  email VARCHAR(150) NOT NULL UNIQUE,
  senha_hash VARCHAR(255) NOT NULL,
  role VARCHAR(50) NOT NULL DEFAULT 'operador', -- exemplo: 'operador' ou 'admin' ou 'policia'
  criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 3) cria tabela de logs de alteração de status
CREATE TABLE denuncias_log (
  id INT AUTO_INCREMENT PRIMARY KEY,
  denuncia_id INT NOT NULL,
  usuario_id INT NULL,
  acao VARCHAR(100),
  observacao TEXT NULL,
  criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (denuncia_id) REFERENCES denuncias(id) ON DELETE CASCADE,
  FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE SET NULL
);