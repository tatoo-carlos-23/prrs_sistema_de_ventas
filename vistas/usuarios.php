<?php
session_start();
if (isset($_SESSION['usuario']) and $_SESSION['usuario'] == 'admin') {

?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <link rel="shortcut icon" href="../img/iconUsuarios.png" type="image/x-icon">
        <title>Usuarios</title>
        <?php require_once "menu.php"; ?>
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
            <h1>Administrar Usuarios</h1>
            <div class="row">
                <div class="col-sm-4">
                    <form id="frmRegistro">
                        <label>Nombre</label>
                        <input type="text" onkeyup="validamos('nombre',{l:'l'},'registro');" class="form-control input-sm" name="nombre" id="nombre">

                        <label>DNI</label>
                        <input type="text" maxlength="11" onkeyup="validamos('dni',{c:'n',nc:8},'registro');" class="form-control input-sm" name="dni" id="dni">

                        <label>Apellido</label>
                        <input type="text" onkeyup="validamos('apellido',{l:'l'},'registro')" class="form-control input-sm" name="apellido" id="apellido">

                        <label>Usuario</label>
                        <input type="text" class="form-control input-sm" name="usuario" id="usuario">

                        <label>Contraseña</label>
                        <input type="password" class="form-control input-sm" name="password" id="password">

                        <input type="text" readonly class="error" id="error_formulario" value="" name="1">
                        <p></p>
                        <button type="button" class="btn btn-primary" id="registro">Registrar </button>
                    </form>
                </div>
                <div class="col-sm-8" style="max-height: 450px; overflow-y: scroll;">
                    <div id="tablaUsuarioLoad"></div>
                </div>
            </div>
        </div>

        <!-- Button trigger modal -->
        <!-- Modal -->
        <div class="modal fade" id="actualizaUsuarioModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog modal-sm" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Actualiza Usuario</h4>
                    </div>
                    <div class="modal-body">

                        <form id="frmRegistroU">
                            <input type="text" hidden="" name="idUsuario" id="idUsuario">
                            <label>Nombre</label>
                            <input type="text" class="form-control input-sm" name="nombreU" id="nombreU">

                            <label>DNI</label>
                            <input type="text" class="form-control input-sm" name="dniU" id="dniU">

                            <label>Apellido</label>
                            <input type="text" class="form-control input-sm" name="apellidoU" id="apellidoU">

                            <label>Usuario</label>
                            <input type="text" class="form-control input-sm" name="usuarioU" id="usuarioU">
                        </form>

                    </div>
                    <div class="modal-footer">
                        <button id="btnActualizaUsuario" type="button" class="btn btn-warning" data-dismiss="modal">Actualiza Usuario</button>

                    </div>
                </div>
            </div>
        </div>

    </body>

    </html>
    <script src="../js/validacion_formularios.js"></script>
    <script type="text/javascript">
        function agregaDatosUsuarios(idusuario) {

            $.ajax({
                type: "POST",
                data: "idusuario=" + idusuario,
                url: "../procesos/usuarios/obtenDatoUsuario.php",
                success: function(r) {
                    dato = jQuery.parseJSON(r);

                    $("#idUsuario").val(dato['id_usuario']);
                    $("#nombreU").val(dato['nombre']);
                    $("#dniU").val(dato['dni']);
                    $("#apellidoU").val(dato['apellido']);
                    $("#usuarioU").val(dato['usuario']);
                }
            });
        }

        function eliminaUsuario(idusuario) {
            // alert("dentro del puto if");
            Swal.fire({
                title: 'Desa eliminar el usurario?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'SI',
                confirmButtonColor: '#29C419',
                cancelButtonColor: '#E40000'

            }).then((ok) => {

                if (ok.isConfirmed) {

                    $.ajax({
                        type: "POST",
                        data: "idusuario=" + idusuario,
                        url: "../procesos/usuarios/eliminarUsuario.php",
                        success: function(r) {

                            if (r == 1) {

                                $('#tablaUsuarioLoad').load('usuarios/tablaUsuarios.php');
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
            btnActualizaUsuario
            $('#btnActualizaUsuario').click(function() {

                datos = $('#frmRegistroU').serialize();
                $.ajax({
                    type: "POST",
                    data: datos,
                    url: "../procesos/usuarios/actualizaUsuario.php",
                    success: function(r) {
                        //console.log(r);
                        if (r == 1) {
                            $('#tablaUsuarioLoad').load('usuarios/tablaUsuarios.php');
                            Swal.fire('Registros actualizados con exito', '', 'success');
                        } else {
                            Swal.fire('Error: Nose pudo actualizar', '', 'error');
                        }
                    }
                });
            });
        });
    </script>

    <script type="text/javascript">
        $(document).ready(function() {

            $('#tablaUsuarioLoad').load('usuarios/tablaUsuarios.php');

            $('#registro').click(function() {

                vacios = validarFormVacio('frmRegistro');

                if (vacios > 0) {
                    Swal.fire('Debes llenar todos los campos!', '', 'warning');
                    return false;
                }

                datos = $('#frmRegistro').serialize();
                Swal.fire({
                    title: 'Desa registrar un usuario?',
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
                            url: "../procesos/regLogin/registrarUsuario.php",
                            success: function(r) {

                                if (r == 1) {
                                    $('#frmRegistro')[0].reset();
                                    $('#tablaUsuarioLoad').load('usuarios/tablaUsuarios.php');

                                    Swal.fire('Registrado exitoso', '', 'success');
                                } else {
                                    Swal.fire('Registrado fallido', '', 'error');
                                }
                            }
                        });
                    }
                })

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