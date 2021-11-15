DROP DATABASE if exists pedro_sis_ventas;
CREATE DATABASE pedro_sis_ventas;

use pedro_sis_ventas;

CREATE TABLE articulos (
  id_producto int PRIMARY KEY AUTO_INCREMENT,
  id_categoria int NOT NULL,
  id_usuario int NOT NULL,
  nombre varchar(500)  NULL UNIQUE,
  descripcion varchar(2000)  NULL,
  stock_inicial int null,
  stock_final int null,
  precio float  NULL,
  fechaCaptura DATE NULL,
  #imagenes
  ruta varchar(500)  NULL
) ;

CREATE TABLE categorias (
  id_categoria int PRIMARY KEY AUTO_INCREMENT,
  nombreCategoria varchar(150)  NULL UNIQUE,
  fechaCaptura DATE NULL 
);

CREATE TABLE clientes (
  id_cliente int PRIMARY KEY AUTO_INCREMENT,
  id_usuario int NOT NULL,
  nombre varchar(200)  NULL,
  apellido varchar(200)  NULL,
  direccion varchar(200)  NULL,
  email varchar(200)  NULL UNIQUE,
  telefono varchar(200)  NULL,
  rfc varchar(200)  NULL unique #DOCUMENTO DE IDENTIDAD
) ;

CREATE TABLE usuarios (
  id_usuario int PRIMARY KEY AUTO_INCREMENT,
  nombre varchar(50)  NULL,
  apellido varchar(50)  NULL,
  usuario varchar(20)  NULL UNIQUE,
  dni char(8)  NULL UNIQUE,
  password tinytext  NULL,
  fechaCaptura DATE NULL,
  rol varchar(25) null
);

CREATE TABLE venta (
  id_venta BIGINT PRIMARY KEY AUTO_INCREMENT,
  id_cliente int  NULL,
  id_usuario int  NULL,
  igv DECIMAL(10,2) NULL,
  sub_total DECIMAL(10,2) NULL,
  total DECIMAL(10,2) NULL,
  estado VARCHAR(25) NULL,
  fechaCompra DATEtime NULL default now()
);

CREATE TABLE detalle_venta (
  id_detalle_venta BIGINT PRIMARY KEY AUTO_INCREMENT,
  id_venta BIGINT NULL,
  id_producto INT  NULL,
  cantidad INT NULL,
  precio DECIMAL(10,2) NULL,
  total DECIMAL(10,2) NULL
);

# CLAVE 12345678 -> 7c222fb2927d828af22f592134e8932480637c0d
