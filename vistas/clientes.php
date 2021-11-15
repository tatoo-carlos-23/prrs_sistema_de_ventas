<?php
    session_start();
    if (isset($_SESSION['usuario'])) {
       
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="shortcut icon" href="../img/iconClientes.png" type="image/x-icon">
    <title>Clientes</title>
    <?php require_once "menu.php"; ?>
</head>
<body>
    <div class="container">
        <h1>Clientes</h1>
        <div class="row">
            <div class="col-sm-4">
                <form id="frmClientes">
                    <label>Nombre:</label>
                    <input type="text" class="form-control input-sm" id="nombre" name="nombre">

                    <label>Apellido:</label>
                    <input type="text" class="form-control input-sm" id="apellido" name="apellido">

                    <label>Direccion:</label>
                    <input type="text" class="form-control input-sm" id="direccion" name="direccion">

                    <label>Email:</label>
                    <input type="text" class="form-control input-sm" id="email" name="email">

                    <label>Telefono:</label>
                    <input type="text" class="form-control input-sm" id="telefono" name="telefono">

                    <label>DNI:</label>
                    <input type="text" class="form-control input-sm" id="rfc" name="rfc">
                    <p></p>
                    <span class="btn btn-primary" id="btnAgregarCliente">Agregar</span>
                </form>
            </div>
            <div class="col-sm-8" style="max-height: 450px; overflow-y: scroll;">
                <div id="tablaClientesLoad"></div>
            </div>
        </div>
    </div>
    
     <!-- Button trigger modal -->
<!-- Modal -->
<div class="modal fade" id="abremodalClientesUpdate" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Actualiza Cliente</h4>
      </div>
      <div class="modal-body">

        <form id="frmClientesU">
            <input type="text" hidden="" id="idclienteU" name="idclienteU">
            <label>Nombre:</label>
            <input type="text" class="form-control input-sm" id="nombreU" name="nombreU">

            <label>Apellido:</label>
            <input type="text" class="form-control input-sm" id="apellidoU" name="apellidoU">

            <label>Direccion:</label>
            <input type="text" class="form-control input-sm" id="direccionU" name="direccionU">

            <label>Email:</label>
            <input type="text" class="form-control input-sm" id="emailU" name="emailU">

            <label>Telefono:</label>
            <input type="text" class="form-control input-sm" id="telefonoU" name="telefonoU">

            <label>DNI:</label>
            <input type="text" class="form-control input-sm" id="rfcU" name="rfcU">
            
        </form>

      </div>
      <div class="modal-footer">
        <button id="btnAgregarClienteU" type="button" class="btn btn-warning" data-dismiss="modal">Guardar</button>
        
      </div>
    </div>
  </div>
</div>

</body>
</html>

<script type="text/javascript">
    function agregaDatosCliente(idcliente) { 

        $.ajax({
            type: "POST",
            data: "idcliente="+idcliente,
            url: "../procesos/clientes/obtenDatosCliente.php",
            success:function(r){
                dato=jQuery.parseJSON(r);
                $("#idclienteU").val(dato['id_cliente']);
                $("#nombreU").val(dato['nombre']);
                $("#apellidoU").val(dato['apellido']);
                $("#direccionU").val(dato['direccion']);
                $("#emailU").val(dato['email']);
                $("#telefonoU").val(dato['telefono']);
                $("#rfcU").val(dato['rfc']);
            }
        });
    }

    function eliminarCliente(idcliente){
       // alert("dentro del puto if");
        Swal.fire({
                title: 'Desa eliminar Cliente?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'SI',
                confirmButtonColor: '#29C419',
                cancelButtonColor: '#E40000'

        }).then((ok)=>{
            
            if(ok.isConfirmed){
                
                $.ajax({
                    type:"POST",
                    data:"idcliente="+idcliente,
                    url:"../procesos/clientes/eliminarCliente.php",
                    success:function(r){
                    
                        if(r==1){
                    
                            $("#tablaClientesLoad").load("clientes/tablaClientes.php");
                            Swal.fire('Eliminacion exitosa!!','','success');                     
                        
                        }else{
                        Swal.fire('No se pudo eliminar','','error');
                        }
                    }
                });
            }
        });
    }
</script>

<script type="text/javascript">
    $(document).ready(function(){

        $("#tablaClientesLoad").load("clientes/tablaClientes.php");

        $('#btnAgregarCliente').click(function(){
        
            vacios=validarFormVacio('frmClientes');

            if(vacios > 0){
                Swal.fire('Debes llenar todos los campos!','','warning');
                return false;
            }
        
        datos=$('#frmClientes').serialize();
        
        $.ajax({
            type: "POST",
            data: datos,
            url: "../procesos/clientes/agregaCliente.php",
            success:function(r){
                // alert(r);
                if(r==1){
                    $('#frmClientes')[0].reset();
                    $("#tablaClientesLoad").load("clientes/tablaClientes.php");
                    Swal.fire('Registrado exitoso','','success');
                }else{
                    Swal.fire('Registrado fallido','','error');
                }
            }
        });
    });
    });
</script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#btnAgregarClienteU').click(function(){
            datos=$('#frmClientesU').serialize();
        
            $.ajax({
                type: "POST",
                data: datos,
                url: "../procesos/clientes/actualizaCliente.php",
                success:function(r){
                    // alert(r);
                    if(r==1){
                        $('#frmClientes')[0].reset();
                        $("#tablaClientesLoad").load("clientes/tablaClientes.php");
                        Swal.fire('Actualizacion exitosa','','success');
                    }else{
                        Swal.fire('Error al actualizar','','error');
                    }
                }
            });
        });
    });
</script>
<?php
    }else {
        header("location:../index.php");
    }
?>