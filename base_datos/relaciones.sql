use pedro_sis_ventas;

ALTER TABLE articulos ADD FOREIGN KEY (id_categoria) REFERENCES categorias(id_categoria);
ALTER TABLE articulos ADD FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario);

ALTER TABLE venta ADD FOREIGN KEY (id_cliente) REFERENCES clientes(id_cliente);
ALTER TABLE venta ADD FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario);

ALTER TABLE detalle_venta ADD FOREIGN KEY (id_venta) REFERENCES venta(id_venta);
ALTER TABLE detalle_venta ADD FOREIGN KEY (id_producto) REFERENCES articulos(id_producto);