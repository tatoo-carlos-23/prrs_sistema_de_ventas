USE pedro_sis_ventas;

# PROCEDIMIENTO ALMACENADO PARA ACTUALZIAR EL STOCK DE LOS PRODUCTOS
#/* *********** ACTUALIZAR STOCK ************** */
DROP PROCEDURE IF EXISTS ACTUALIZAR_CANTIDAD_DE_PRODUCTOS;
DELIMITER $$
CREATE PROCEDURE ACTUALIZAR_CANTIDAD_DE_PRODUCTOS(
IN id INT,
IN cant INT,
IN valor VARCHAR(7)
)
BEGIN
DECLARE stock INT;
SELECT art.stock_final INTO stock FROM articulos AS art WHERE art.id_producto = id;
IF(valor = 'MAS') THEN
# SELECT (stock_ini + 100);
UPDATE articulos SET stock_final = (stock + cant) WHERE id_producto = id;
#SELECT '';
ELSEIF(valor = 'MENOS') then
# SELECT (stock_ini - 100);
UPDATE articulos SET stock_final = (stock - cant) WHERE id_producto = id;
#SELECT '';
END if;
end$$
#DELIMITER;