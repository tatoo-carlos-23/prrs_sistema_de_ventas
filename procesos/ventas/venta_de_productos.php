<?php
session_start();
require_once "../../clases/Conexion.php";
$c = new conectar();
$conexion = $c->conexion();


if (!empty($_POST)) {
    if ($_POST['accion'] == 'buscar_cliente') {

        $buscar_cliente = $_POST['data_buscar'];

        if (empty(trim($buscar_cliente))) {
            $resultado = [];
        } else {
            $consulta = mysqli_query($conexion, "SELECT cli.id_cliente, UPPER(CONCAT_WS('', cli.nombre,' ', cli.apellido, ', Dni: ', cli.rfc)) AS nombres FROM clientes AS cli WHERE cli.rfc LIKE CONCAT_WS('', '%','$buscar_cliente','%') OR cli.nombre LIKE CONCAT_WS('', '%','$buscar_cliente','%') OR cli.apellido LIKE CONCAT_WS('', '%','$buscar_cliente','%') OR cli.email LIKE CONCAT_WS('', '%','$buscar_cliente','%')");

            $vec = [];
            while ($reg = mysqli_fetch_array($consulta, MYSQLI_ASSOC)) {
                $vec[] = $reg;
            }
            $resultado = $vec;
        }
    } else if ($_POST['accion'] == 'buscar_producto') {

        $buscar_producto = $_POST['data_buscar'];

        if (empty(trim($buscar_producto))) {
            $resultado = [];
        } else {
            $consulta = mysqli_query($conexion, "SELECT art.id_producto, art.nombre, UPPER(CONCAT_WS('', art.descripcion, ', STOCK INICIAL: ', art.stock_inicial)) AS descripcion, art.stock_final, art.precio, art.ruta FROM articulos AS art WHERE art.nombre LIKE CONCAT_WS('','%','$buscar_producto','%') OR art.descripcion LIKE CONCAT_WS('','%','$buscar_producto','%')");

            $vec = [];
            while ($reg = mysqli_fetch_array($consulta, MYSQLI_ASSOC)) {
                $vec[] = $reg;
            }
            $resultado = $vec;
        }
    } else if ($_POST['accion'] == 'actualizar_stock') {

        $id = $_POST['id_producto'];
        $cantidad = $_POST['cantidad'];
        $valor = $_POST['valor'];

        $consulta = "call ACTUALIZAR_CANTIDAD_DE_PRODUCTOS($id, $cantidad, '$valor')";
        if (mysqli_query($conexion, $consulta)) {
            $resultado  = 'success';
        } else {
            $resultado = 'warning';
        }
    } else if ($_POST['accion'] == 'insertar_venta') {

        $id_cliente = $_POST['id_cliente'];
        $id_usuario = $_SESSION['iduser'];
        $igv = $_POST['igv'];
        $sub_total = $_POST['sub_total'];
        $total = $_POST['total'];

        $consulta = "INSERT INTO venta(id_cliente, id_usuario, igv, sub_total, total,estado) values($id_cliente, $id_usuario, $igv, $sub_total, $total, 'VENDIDA')";
        if (mysqli_query($conexion, $consulta)) {
            $id_venta = $conexion->insert_id;
            $resultado = $id_venta;
        } else {
            $resultado = 'warning';
        }
    } else if ($_POST['accion'] == 'insertar_detalle_venta') {

        $id_venta = $_POST['id_venta'];
        $id_producto = $_POST['id_producto'];
        $cantidad = $_POST['cantidad'];
        $precio = $_POST['precio'];
        $total = $_POST['total'];

        $consulta = "INSERT INTO detalle_venta (id_venta, id_producto, cantidad, precio, total)VALUES($id_venta, $id_producto, $cantidad, $precio, $total)";
        if (mysqli_query($conexion, $consulta)) {
            $resultado  = 'success';
        } else {
            $resultado = 'warning';
        }
    } else {
        $resultado = ['estado' => 'error', 'mensaje' => 'Ocurrio un error, revise los datos enviados porfavor.'];
    }
} else {
    $resultado = ['estado' => 'error', 'mensaje' => 'Ocurrio un error, revise los datos enviados porfavor.'];
}

echo json_encode($resultado);
mysqli_close($conexion);
exit;
///////////////
