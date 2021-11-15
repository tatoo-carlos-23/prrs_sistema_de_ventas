<?php
    require_once "clases/Conexion.php";
    $obj = new conectar();
    $conexion = $obj->conexion();

    $sql = "SELECT * FROM usuarios WHERE usuario='admin'";
    $resut=mysqli_query($conexion,$sql);
    $validar = 0;
    if (mysqli_num_rows($resut) > 0) {
        
        header("Location:index.php");
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro</title>
    <link rel="stylesheet" type="text/css" href="librerias/bootstrap/css/bootstrap.css">
    <script src="librerias/jquery-3.2.1.min.js"></script>
    <script src="js/funciones.js"></script>
</head>

<body style="background-color: #5664A3;">
    <br><br><br>
    <div class="container">
        <div class="row">
            <div class="col-sm-4"></div>
            <div class="col-sm-4">
                <div class="panel panel-danger">
                    <div class="panel panel-heading">Registrar Administrador</div>
                    <div class="panel panel-body">
                        <form id="frmRegistro">
                            <label>Nombre</label>
                            <input type="text" class="form-control input-sm" name="nombre" id="nombre">

                            <label>DNI</label>
                            <input type="text" class="form-control input-sm" name="dni" id="dni">

                            <label>Apellido</label>
                            <input type="text" class="form-control input-sm" name="apellido" id="apellido">
                            
                            <label>Usuario</label>
                            <input type="text" class="form-control input-sm" name="usuario" id="usuario">

                            <label>Contraseña</label>
                            <input type="password" class="form-control input-sm" name="password" id="password">
                            <p></p>

                            <span class="btn btn-primary" id="registro">Registrar</span>
                            <a href="index.php" class="btn btn-default">Regresar Login</a>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-sm-4 "></div>
        </div>
    </div>
</body>
</html>
<script type="text/javascript">
	$(document).ready(function(){
		$('#registro').click(function(){

			vacios=validarFormVacio('frmRegistro');

			if(vacios > 0){
                Swal.fire('Debes llenar todos los campos!','','warning');
				return false;
			}

			datos=$('#frmRegistro').serialize();
            Swal.fire({
                title: 'Desa registrar un cliente?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'SI',
                confirmButtonColor: '#29C419',
                cancelButtonColor: '#E40000'
            }).then((ok)=>{
                if (ok.isConfirmed) {
                    $.ajax({

                    type:"POST",
                    data:datos,
                    url:"procesos/regLogin/registrarUsuario.php",
                    success:function(r){
                        
                        if(r==1){
                            Swal.fire('Registrado exitoso','','success');
                        }else{
                            Swal.fire('Registrado fallido','','error');
                        }
                    }
                    });
                }
            })
			
		});
	});
</script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>