<?php
    require_once "../../clases/Conexion.php";
    require_once "../../clases/Articulos.php";

    $idart = $_POST['id_articulo'];
    $ruta = $_POST['ruta'];

    //echo $_POST['idarticulo'];

    $obj=new articulos();
    echo $obj->eliminaArticulo($idart, $ruta);

?>