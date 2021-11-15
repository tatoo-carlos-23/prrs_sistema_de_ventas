<?php
    session_start();
    if (isset($_SESSION['usuario'])) {
       
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="shortcut icon" href="../img/iconCategorias.png" type="image/x-icon">
    <title>Categorias</title>
    <?php require_once "menu.php"; ?>
</head>
<body>
    <div class="container">
    <h1>Categorias</h1>
        <div class="row">
            <div class="col-sm-4">
                <form id="frmCategorias">
                    <label>Categorias</label>
                    <input type="text" class="form-control input-sm" name="categoria" id="categoria">
                    <p></p>
                    <span class="btn btn-primary" id="btnAgregarCategoria">Agregar</span>
                </form>
            </div>
            <div class="col-sm-8" style="  height: 450px; overflow-y: scroll;">
                <div id="tablaCategoriaLoad"></div>
            </div>
        </div>
        
    </div>
    
    <!-- Button trigger modal -->

<!-- Modal -->
<div class="modal fade" id="actualizaCategoria" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
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

<script type="text/javascript">
    $(document).ready(function(){

        $("#tablaCategoriaLoad").load("categorias/tablaCategorias.php");

        $('#btnAgregarCategoria').click(function(){
        
            vacios=validarFormVacio('frmCategorias');

            if(vacios > 0){
                Swal.fire('Debes llenar todos los campos!','','warning');
                return false;
            }
        
        datos=$('#frmCategorias').serialize();
        $.ajax({
            type: "POST",
            data: datos,
            url: "../procesos/categorias/agregaCategoria.php",
            success:function(r){
                if(r==1){
                    //esta linea nos permite limpiar el formulario al insertar un registro.
                    $('#frmCategorias')[0].reset();

                    $("#tablaCategoriaLoad").load("categorias/tablaCategorias.php");

                    Swal.fire('Registro exitoso','','success');
                }else{
                    Swal.fire('Registro fallido','','error');
                }
            }
        });
    });
    });
</script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#btnActualizaCategoria').click(function(){
        
            datos=$('#frmCategoriaU').serialize();
            $.ajax({
                type: "POST",
                data: datos,
                url: "../procesos/categorias/actualizaCategoria.php",
                success:function(r){
                    if (r==1) {
                        $("#tablaCategoriaLoad").load("categorias/tablaCategorias.php");
                        Swal.fire('Datos actualizados correctamente','','success');
                    }else{
                        Swal.fire('Actualizacion fallida','','error');
                    }
                }
            });
        });
    });
</script>

<script type="text/javascript">
    function agregaDato(idCategoria,categoria){
        $('#idcategoria').val(idCategoria);
        $('#categoriaU').val(categoria);
    }

    function eliminaCategoria(idcategoria){
       // alert("dentro del puto if");
        Swal.fire({
                title: 'Desa eliminar categoria?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'SI',
                confirmButtonColor: '#29C419',
                cancelButtonColor: '#E40000'

        }).then((ok)=>{
            
            if(ok.isConfirmed){
                
                $.ajax({
                    type:"POST",
                    data:"idcategoria="+idcategoria,
                    url:"../procesos/categorias/eliminarCategoria.php",
                    success:function(r){
                    
                        if(r==1){
                    
                            $("#tablaCategoriaLoad").load("categorias/tablaCategorias.php");   
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

<script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<?php
    # code...
    }else {
        header("location:../index.php");
    }
?>