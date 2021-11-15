<?php
session_start();
if (isset($_SESSION['usuario'])) {

?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <link rel="shortcut icon" href="../img/iconArticulos.png" type="image/x-icon">
        <title>Articulos</title>
        <?php require_once "menu.php"; ?>
        <?php require_once "../clases/Conexion.php";
        $c = new conectar();
        $conexion = $c->conexion();
        $sql = "SELECT id_categoria, nombreCategoria 
              FROM categorias";

        $result = mysqli_query($conexion, $sql);
        ?>

        <style>
            .error {
                color: #f5222d;
                margin: 10px 0;
                border: none;
                width: 100%;
                outline: none;               
            }
        </style>
    </head>

    <body>
        <div class="container">
            <h1>Aticulos</h1>
            <div class="row">
                <div class="col-sm-4">
                    <form id="frmArticulos" enctype="multipart/form-data">
                        <label>Categoria:</label>
                        <select class="form-control input-sm" id="categoriaSelect" name="categoriaSelect">
                            <option value="A">Selecciona Categoria</option>
                            <?php while ($ver = mysqli_fetch_row($result)) : ?>
                                <option value="<?php echo $ver[0] ?>"><?php echo $ver[1]; ?>
                                </option>
                            <?php endwhile; ?>
                        </select>

                        <label>Modelo:</label>
                        <input type="text" class="form-control input-sm" id="nombre" name="nombre">

                        <label>Descripción:</label>
                        <input type="text" class="form-control input-sm" id="descripcion" name="descripcion">

                        <label>Cantidad:</label>
                        <input type="text" onkeyup="validamos('cantidad',{n:'n', p:'_'},'btnAgregarArticulo')" class="form-control input-sm" id="cantidad" name="cantidad">

                        <label>Precio:</label>
                        <input type="text" onkeyup="validamos('precio',{n:'_', p:'p'},'btnAgregarArticulo')" class="form-control input-sm" id="precio" name="precio">

                        <label>Imagen:</label>
                        <input type="file" class="form-control input-sm" id="imagen" name="imagen">

                        <input type="text" readonly class="error" id="error_formulario" value="" name="1">
                        
                        <br>
                        <button type="button" id="btnAgregarArticulo" class="btn btn-info">Agregar </button>
                    </form>
                </div>
                <div class="col-sm-8" style="max-height: 450px; overflow-y: scroll;">
                    <div id="tablaArticulosLoad"></div>
                </div>
            </div>
        </div>

        <!-- Button trigger modal -->


        <!-- Modal -->
        <div class="modal fade" id="abremodalUpdateArticulo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog modal-sm" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Actializar Articulo </h4>
                    </div>
                    <div class="modal-body">

                        <form id="frmArticulosU" enctype="multipart/form-data">
                            <input type="text" id="idArticulo" hidden="" name="idArticulo">
                            <label>Categoria:</label>
                            <select class="form-control input-sm" id="categoriaSelectU" name="categoriaSelectU">
                                <option value="A">Selecciona Categoria</option>

                                <?php
                                $sql = "SELECT id_categoria, nombreCategoria 
							FROM categorias";

                                $result = mysqli_query($conexion, $sql);
                                ?>

                                <?php while ($ver = mysqli_fetch_row($result)) : ?>
                                    <option value="<?php echo $ver[0] ?>"><?php echo $ver[1]; ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>

                            <label>Modelo:</label>
                            <input type="text" class="form-control input-sm" id="nombreU" name="nombreU">

                            <label>Descripción:</label>
                            <input type="text" class="form-control input-sm" id="descripcionU" name="descripcionU">

                            <label>Cantidad:</label>
                            <input type="text" class="form-control input-sm" id="cantidadU" name="cantidadU">

                            <label>Precio:</label>
                            <input type="text" class="form-control input-sm" id="precioU" name="precioU">

                            <!-- <span clase="btn btn-success" id="btnAgregarArticulo">Agregar</span> -->
                        </form>

                    </div>
                    <div class="modal-footer">
                        <span id="btnActualizaarticulo" type="button" class="btn btn-warning" data-dismiss="modal">Actualizar
                        </span>
                    </div>
                </div>
            </div>
        </div>

    </body>

    </html>

    <script src="../js/validacion_formularios.js"></script>

    <script type="text/javascript">
        function agregaDatosArticulo(idarticulo) {

            $.ajax({
                type: "POST",
                data: "idart=" + idarticulo,
                url: "../procesos/articulos/obtenDatosArticulo.php",
                success: function(r) {
                    //alert(r);
                    dato = jQuery.parseJSON(r);
                    $('#idArticulo').val(dato['id_producto']);
                    $('#categoriaSelectU').val(dato['id_categoria']);
                    $('#nombreU').val(dato['nombre']);
                    $('#descripcionU').val(dato['descripcion']);
                    $('#cantidadU').val(dato['cantidad']);
                    $('#precioU').val(dato['precio']);
                }
            });
        }

        function eliminaArticulo(idArticulo, ruta) {

            let datos = {
                "id_articulo": idArticulo,
                "ruta": ruta
            }
            Swal.fire({
                title: 'Desa eliminar categoria?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'SI',
                confirmButtonColor: '#29C419',
                cancelButtonColor: '#E40000'

            }).then((ok) => {

                if (ok.isConfirmed) {

                    $.ajax({
                        type: "POST",
                        data: datos,
                        url: "../procesos/articulos/eliminarArticulo.php",
                        success: function(r) {

                            if (r == 1) {

                                $("#tablaArticulosLoad").load("articulos/tablaArticulos.php");
                                Swal.fire('Eliminacion exitosa!!', '', 'success');

                            } else {
                                Swal.fire('No se pudo eliminar', '', 'error');
                            }
                        }
                    });
                }
            });
        }
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#btnActualizaarticulo').click(function() {

                datos = $('#frmArticulosU').serialize();
                $.ajax({
                    type: "POST",
                    data: datos,
                    url: "../procesos/articulos/actualizaArticulos.php",
                    success: function(r) {
                        if (r == 1) {
                            $("#tablaArticulosLoad").load("articulos/tablaArticulos.php");
                            Swal.fire('Actualizacion exitosa', '', 'success');
                        } else {
                            Swal.fire('Error al actualizar', '', 'error');
                        }
                    }
                });
            });
        });
    </script>

    <script type="text/javascript">
        $(document).ready(function() {

            $("#tablaArticulosLoad").load("articulos/tablaArticulos.php");

            $('#btnAgregarArticulo').click(function() {

                vacios = validarFormVacio('frmArticulos');
                if (vacios > 0) {
                    Swal.fire('Debes llenar todos los campos!', '', 'warning');
                    return false;
                }
                var formData = new FormData(document.getElementById("frmArticulos"));
                console.log(formData);
                $.ajax({
                    url: "../procesos/articulos/insertaArticulos.php",
                    type: "post",
                    dataType: "html",
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,

                    success: function(r) {
                        console.log(r);

                        if (r == 1) {
                            $('#frmArticulos')[0].reset();
                            $("#tablaArticulosLoad").load("articulos/tablaArticulos.php");
                            Swal.fire('Ariticulo agregado con exitoso', '', 'success');
                        } else {
                            Swal.fire('Fallo al agregar articulo', '', 'error');
                        }
                    }
                });
            });
        });
    </script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<?php
    # code...
} else {
    header("location:../index.php");
}
?>