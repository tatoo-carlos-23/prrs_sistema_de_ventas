<?php
session_start();
if (isset($_SESSION['usuario'])) {

?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <link rel="shortcut icon" href="../img/iconVentas.png" type="image/x-icon">
        <title>Ventas y Reportes</title>
        <?php require_once "menu.php"; ?>
        <link rel="stylesheet" href="../css/vender_articulo.css">
        <link rel="stylesheet" type="text/css" href="../librerias/bootstrap/css/bootstrap.css">
    </head>

    <body>
        <div class="container venta">

            <!-- <span class="anular-venta" id="id_anular_venta">Anular venta</span> -->
            <h5 class="anular-venta" id="id_anular_venta">Anular venta</h5>
            <div class="div-img-producto" id="img_producto_busqueda" style="display: none;">
                <img src="../css/telefono.png" alt="" class="img-producto" id="img_resultado">
            </div>

            <div class="titulo">
                <h3>Ventas de productos</h3>

            </div>
            <div class="fila">
                <!-- BUSCAMOS DATOS PRODUCTO Y CLIENTE-->
                <div class="datos">
                    <!-- CLIENTE-->
                    <div class="w 100 p-05">
                        <div class="fila">
                            <input type="search" class="none w-100 input-buscar" placeholder="Buscar cliente" id="buscador_cliente">
                            <span id="limpiar_cliente" class="input-buscar" style="cursor:pointer;"><i class="fas fa-backspace"></i></span>
                        </div>

                        <div class="w-100 div-input-venta">
                            <span><i class="fas fa-users"></i> Nombre del cliente</span>
                            <input type="text" class="none w-100" readonly placeholder="Resultados de la busqueda cliente." id="nombre_cliente">
                        </div>
                        <input type="hidden" class="none w-100 input-venta" readonly placeholder="ID" id="id_cliente">
                    </div>
                    <!-- PRODUCTO-->
                    <div class="w-100 p-05">
                        <div class="fila">
                            <input type="search" class="none w-100 input-buscar" placeholder="Buscar producto" id="buscador_producto">
                            <span id="limpiar_producto" class="input-buscar" style="cursor:pointer;"><i class="fas fa-backspace"></i></span>
                        </div>
                        <!-- ID DEL PRODUCTO-->
                        <input type="hidden" name="" id="id_producto">
                        <div class="w-100 div-input-venta">
                            <span><i class="fas fa-mobile-alt"></i> Nombre del producto</span>
                            <input type="text" class="none w-100" readonly placeholder="Producto" id="nombre_producto">
                        </div>
                        <div class="fila w-100 stk-precio">
                            <div class="w-100 div-input-venta">
                                <span><i class="fas fa-layer-group"></i> Stock restante</span>
                                <input type="text" class="none w-100" readonly placeholder="Stock restante" id="stock_restante">
                            </div>
                            <div class="w-100 div-input-venta">
                                <span><i class="far fa-money-bill-alt"></i> Precio</span>
                                <input type="text" class="none w-100" readonly placeholder="Precio" id="precio">
                            </div>
                        </div>
                        <textarea class="none w-100 descripcion-ta" cols="30" rows="2" placeholder="Descripcion del producto..." id="descripcion"></textarea>
                    </div>
                    <div class="w-100 p-05">
                        <div class="fila w-100 stk-precio">
                            <div class="w-100 div-input-venta" style=" background-color: #fafafa !important;">
                                <span><i class="fas fa-sort-numeric-up-alt"></i> Ingrese cantidad</span>
                                <input type="number" class="none w-100 agregar" placeholder="Cantidad" id="cantidad" min="1" max="1000">
                            </div>
                            <div class="w-100 div-input-venta btn-agregar-producto" id="btn_agregar_nuevo_producto">
                                <span><i class="fas fa-plus"></i> Agregar</span>
                                <input type="text" value="PRODUCTO" class="none w-100" readonly placeholder="Precio">
                            </div>
                        </div>
                    </div>
                </div>
                <!-- INSERTAMOS LOS PRODUCTOS A VENDER -->
                <div class="items-venta columna">
                    <div class="fila w-100">
                        <div class="fila">
                            <input type="text" readonly class="none input-buscar" value="S/" style="text-align: left; width:40px;">
                            <input id="total_detalle_productos" type="text" readonly class="none input-buscar" placeholder="Total" style="text-align: right; width:180px;">
                            <input id="sub_total_detalle_productos" type="hidden">
                            <input id="igv_detalle_productos" type="hidden">
                        </div>
                        <div class="w-100 " style="  text-align: right;">
                            <input type="text" readonly class="none btn-registrar-nueva-venta" value="Registrar nueva venta" id="btn_registrar_nueva_venta">
                        </div>
                    </div>
                    <div class="table-venta">
                        <input type="hidden" value="carlos" data-toggle="modal" data-target="#venta_de_productos" id="abrir_modal_venta_final">
                        <table class="table">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col">Producto</th>
                                    <th scope="col">Cantidad</th>
                                    <th scope="col">Precio</th>
                                    <th scope="col">IGV</th>
                                    <th scope="col">Sub total</th>
                                    <th scope="col">Total</th>
                                    <!-- <th><i class="fas fa-trash-alt" style="color:#ffff;"></i></th> -->
                                </tr>
                            </thead>
                            <tbody id="tbl_detalle_venta_productos">

                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="venta_de_productos" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog modal-sm"> role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Actualizar Categorias</h4>
                    </div>
                    <div class="modal-body">
                        <form id="frmCategoriaU">
                            <input type="text" hidden="" id="idcategoria" name="idcategoria">

                            <label>Categoria: </label>
                            <input type="text" id="categoriaU" name="categoriaU" class="form-control input-sm">
                        </form>

                    </div>
                    <div class="modal-footer">
                        <button type="button" id="btnActualizaCategoria" class="btn btn-warning" data-dismiss="modal">Guardar</button>
                    </div>
                </div>
            </div>
        </div>
    </body>

    </html>

    <script src="../librerias/jquery-3.1.1.min.js"></script>
    <script src="../librerias/sweetalert2/dist/sweetalert2.all.min.js"></script>
    <script src="../js/vender_productos.js"></script>

    <!-- <script>
         Swal.fire('','Seleccione un producto','success')
    </script> -->

<?php
    # code...
} else {
    header("location:../index.php");
}
?>