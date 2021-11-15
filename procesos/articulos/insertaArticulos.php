<?php
    session_start();
    $iduser = $_SESSION['iduser'];
    require_once "../../clases/Conexion.php";
    require_once "../../clases/Articulos.php";

    function hora_fecha_actual(){
        $anno = (new DateTime())->format('Y');
        $mes = (new DateTime())->format('m');
        $dia = (new DateTime())->format('d');
        $hora = (new DateTime())->format('H');
        $min = (new DateTime())->format('i');
        $seg = (new DateTime())->format('s');
    
        return $anno.$mes.$dia.$hora.$min.$seg;
    }
    
    /* Instanciamos los articulos */
    $obj = new articulos();
    $datos=array();

    $nombreImg=$_FILES['imagen']['name'];
    $rutaAlmacenamiento=$_FILES['imagen']['tmp_name'];
    $carpeta='../../archivos/';
    $rutaFinal=$carpeta.hora_fecha_actual().$nombreImg;
 

    $datos[0]=$_POST['categoriaSelect'];
    $datos[1]=$iduser;
    $datos[2]=$_POST['nombre'];
    $datos[3]=$_POST['descripcion'];
    $datos[4]=$_POST['cantidad'];
    $datos[5]=$_POST['precio'];
    $datos[6]=$rutaFinal;
    $resultado =  $obj->insertaArticulo($datos);

    if($resultado == 1){
        if (move_uploaded_file($rutaAlmacenamiento, $rutaFinal)){
            echo "1";
        }
    }else{
        echo 0;
    }


?>