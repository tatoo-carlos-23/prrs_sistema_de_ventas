<?php
class ventas{
    public function obtenDatosProducto($idproducto){
        $c=new conectar();  
        $conexion=$c->conexion();

        $sql = "SELECT art.nombre, art.descripcion, art.stock_final, art.ruta, art.precio FROM articulos AS art WHERE art.id_producto = $idproducto";
        
        $result=mysqli_query($conexion,$sql);
        $ver=mysqli_fetch_row($result);

        $d = explode('/', $ver[3]);

        $img = $d[1].'/'.$d[2].'/'.$d[3];

        $data=array('nombre' => $ver[0], 
                    'descripcion' => $ver[1], 
                    'cantidad' => $ver[2],
                    'ruta' => $img,
                    'precio' => $ver[4]); 
            return $data;
    }

    public function crearVenta(){
        $c = new conectar();
        $conexion = $c-> conexion();

        $fecha = date('Y-m-d');
        $idventa = self::creaFolio();
        $datos=$_SESSION['tablaComprasTemp'];
        $idusuario = $_SESSION['iduser'];
        $r=0;

        for ($i=0; $i < count($datos); $i++) { 
            $d = explode("||", $datos[$i]);

            $sql = "INSERT INTO ventas (id_venta, id_cliente, 
                                        id_producto,id_usuario, precio,fechaCompra)
                    VALUES('$idventa','$d[5]','$d[0]','$idusuario','$d[3]','$fecha')";

            $r=$r + $result=mysqli_query($conexion,$sql);
        }

        return $r;
    }

    public function creaFolio(){
        $c = new conectar();
        $conexion = $c-> conexion();

        $sql = "SELECT id_venta FROM ventas 
                GROUP BY id_venta DESC";

        $result = mysqli_query($conexion,$sql);
        // $id = mysqli_fetch_row($result)[0];

        // if ($id=="" or $id==null or $id==0) {
        //     return 1;
        // }else{
        //     return $id + 1;
        // }
        $id = isset(mysqli_fetch_row($result)[0]);

        if ($id > 0){
            return $id +1;
        }else{
            return 1;
        }
    }

    public function nombreCliente($idCliente){
        $c = new conectar();
        $conexion = $c->conexion();

        $sql = "SELECT apellido, nombre
                FROM clientes
                WHERE id_cliente =$idCliente";

        $result = mysqli_query($conexion,$sql);
        $ver = mysqli_fetch_array($result);
       
        $filas = mysqli_num_rows($result);
        
        if($filas == 1){
            return $x = $ver[0]." ".$ver[1];
        }else if($filas == 0){
            return "Sin cliente";
        }
        
    }

    public function obtenerTotal($idventa){
        $c = new conectar();
        $conexion = $c->conexion();

        $sql = "SELECT precio FROM ventas
                WHERE id_venta='$idventa'";

        $result = mysqli_query($conexion,$sql);
        $total=0;

        while ($ver=mysqli_fetch_row($result)) {
            $total += $ver[0];
        }

        return $total;
    }
}
?>
