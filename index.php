<?php
    require_once "clases/Conexion.php";
    $obj = new conectar();
    $conexion = $obj->conexion();

    $sql = "SELECT * FROM usuarios WHERE usuario='admin'";
    $resut=mysqli_query($conexion,$sql);
    $validar = 0;
    if (mysqli_num_rows($resut) > 0) {
        $validar=1;
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="shortcut icon" href="img/iconLogin.png" type="image/x-icon">
    <link rel="stylesheet" type="text/css" href="librerias/bootstrap/css/bootstrap.css">
    
    <script src="librerias/jquery-3.2.1.min.js"></script>
    <script src="js/funciones.js"></script>
    <title>Login de Usuario</title>
</head>
<body style="background-color: #46C1A9;
">
    <br><br><br>
    <div class="container">
        <div class="row">
            <div class="col-sm-4"></div>
            <div class="col-sm-4">
                <div class="panel panel-primary">
                    <div class="panel panel-heading">Sistema de Ventas y Almacen</div>
                    <div class="panel panel-body">
                        <p>
                            <img src="img/Logo.jpeg"  height="150" alt="Error al cargar imagen"px>
                        </p>
                        <form id="frmLogin">
                            <label>Usuario</label>
                            <input type="text" class="form-control input-sm" name="usuario" id="usuario">

                            <label>Contraseña</label>
                            <input type="password" name="password" class="form-control input-sm" id="password">
                            <p></p>

                            <span class="btn btn-primary btn-sm" id="entrarSistema">Ingresar</span>
                            <?php if (!$validar): ?>
                                <a href="registro.php" class="btn btn-danger btn-sm">Registrar</a>
                            <?php endif; ?>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-sm-4"></div>
        </div>
    </div>
</body>
</html>

<script type="text/javascript">
    $(document).ready(function(){
        $('#entrarSistema').click(function(){
        
        vacios=validarFormVacio('frmLogin');

			if(vacios > 0){
                Swal.fire('Debes llenar todos los campos!','','warning');
				return false;
			}

        datos=$('#frmLogin').serialize();
        
        // Swal.fire({
                
        //     html: `<img src="../../img/Logo.jpeg" alt="">`,
        //         // title: 'CARGANDO...',      
        //         // text: "Espere porfavor",
        //         padding: '0.5em',
        //         width:350,       
        //         showConfirmButton: false,       
        //         allowOutsideClick: false,       
        //         timerProgressBar: false,       
        //         timer:60000,       
        //         background: 'rgba(255,255,255,0)',
        //         //'white url(../../assets/cargandodestapp.png)',       
        //         backdrop: `
        //         rgba(0,0,0, 0.8)        
        //         center        
        //         no-repeat`});

        $.ajax({
            type: "POST",
            data: datos,
            url: "procesos/regLogin/login.php",

            

            success:function(r){
                if (r==1) {
                    Swal.fire('Bienvenido al sistema de ventas superschik','','Success');
                    setTimeout(()=>{
                        window.location="vistas/inicio.php"
                    },800)
                }else{
                    Swal.fire('Erorr: Usuario Incorrecto','','error');
                }
            }
        });
    });
    });

</script>

<script src="./librerias/sweetalert2/dist/sweetalert2.all.min.js"></script>
