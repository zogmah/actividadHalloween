-- Crear la base de datos
CREATE DATABASE IF NOT EXISTS halloween;
USE halloween;

-- Crear la tabla de disfraces
CREATE TABLE disfraces (
    id INT NOT NULL AUTO_INCREMENT,
    nombre VARCHAR(50) NOT NULL,
    descripcion TEXT NOT NULL,
    votos INT NOT NULL DEFAULT 0,
    foto VARCHAR(255) NOT NULL,
    foto_blob BLOB,
    eliminado INT NOT NULL DEFAULT 0,
    PRIMARY KEY (id)
);

-- Crear la tabla de usuarios
CREATE TABLE usuarios (
    id INT NOT NULL AUTO_INCREMENT,
    nombre VARCHAR(50) NOT NULL UNIQUE,
    clave TEXT NOT NULL,
    PRIMARY KEY (id)
);

-- Crear la tabla de votos
CREATE TABLE votos (
    id INT NOT NULL AUTO_INCREMENT,
    id_usuario INT NOT NULL,
    id_disfraz INT NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id),
    FOREIGN KEY (id_disfraz) REFERENCES disfraces(id)
);
