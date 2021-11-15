<?php 

    class articulos{
        public function agregaImagen($datos){
            $c=new conectar();
            $conexion=$c->conexion();
            $fecha=date("Y-m-d");

            $sql="INSERT INTO imagenes(nombre,
                ruta,fechaSubida) 
                VALUES ('$datos[0]','$datos[1]','$fecha')";
            
            $result=mysqli_query($conexion,$sql);

            return mysqli_insert_id($conexion);
        }

        public function insertaArticulo($datos){
            $c=new conectar();
            $conexion=$c->conexion();
            $fecha=date("Y-m-d");


            $sql="INSERT INTO articulos (id_categoria,
                                        id_usuario, 
                                        nombre,
                                        descripcion,
                                        stock_inicial,
                                        stock_final,
                                        precio,                               
                                        ruta,
                                        fechaCaptura) 
                VALUES('$datos[0]','$datos[1]','$datos[2]','$datos[3]','$datos[4]','$datos[4]','$datos[5]','$datos[6]','$fecha')";

            return mysqli_query($conexion,$sql);
        }

        public function obtenDatosArticulo($idarticulo){
			$c=new conectar();
			$conexion=$c->conexion();
            
			$sql="SELECT id_producto, 
						id_categoria, 
						nombre,
						descripcion,
						cantidad,
						precio 
				from articulos 
				where id_producto='$idarticulo'";

			$result=mysqli_query($conexion,$sql);
			$ver=mysqli_fetch_row($result);

			$datos=array(
					"id_producto" => $ver[0],
					"id_categoria" => $ver[1],
					"nombre" => $ver[2],
					"descripcion" => $ver[3],
					"cantidad" => $ver[4],
					"precio" => $ver[5]
            );
			return $datos;
		}
        public function actualizaArticulo($datos){
            $c=new conectar();
			$conexion=$c->conexion(); 
 
            $sql="UPDATE articulos SET id_categoria='$datos[1]', 
                                        nombre='$datos[2]',
                                        descripcion='$datos[3]',
                                        cantidad='$datos[4]',
                                        precio='$datos[5]'
                    WHERE id_producto='$datos[0]'";
            
            return mysqli_query($conexion,$sql);
        }

        public function eliminaArticulo($idarticulo, $ruta){
            $c=new conectar();
			$conexion=$c->conexion(); 
    
            $sql = "DELETE FROM articulos 
                    WHERE id_producto=$idarticulo";

            $result=mysqli_query($conexion,$sql);

            if ($result) {
                if (unlink($ruta)) {
                    return 1;
                }
            }
        }

        public function obtenIdImg($idProducto){
            $c= new conectar();
            $conexion=$c->conexion();

            $sql="SELECT id_imagen 
                    from articulos 
                    where id_producto='$idProducto'";

            $result=mysqli_query($conexion,$sql);
            return mysqli_fetch_row($result)[0];

        }

        public function obtenRutaImagen($idImg){
            $c= new conectar();
            $conexion=$c->conexion();
    
            $sql="SELECT ruta 
                    from imagenes 
                    where id_imagen='$idImg'";
    
            $result=mysqli_query($conexion,$sql);
    
            return mysqli_fetch_row($result)[0];
        }
    }
?>
    
