<script type="text/javascript">
    //script para evento click y ajax
    $('#').click(function(){
        
        datos=$('#').serialize();
        $.ajax({
            type: "POST",
            data: datos,
            url: "../procesos/",
            success:function(r){

            }
        });
    });
    //Funcion para validar datos vacios
    function validarFormVacio(formulario){
        datos=$('#' + formulario).serialize();
        d=datos.slit('&');
        vacios=0;
        for (i=0; i< d.length; i++) {
            controles=d[i].split("=");
            if (controles[1]=="A" || controles[1]=="") {
                vacios++;
            } 
        }
        return vacios;
    }
</script>
<script type="text/javascript">
		$('#').click(function(){
			var formData = new FormData(document.getElementById("frm"));

				$.ajax({
					url: "../procesos/articulos/insertaArchivo.php",
					type: "post",
					dataType: "html",
					data: formData,
					cache: false,
					contentType: false,
					processData: false,

					success:function(data){
						
						if(data == 1){
							$('#frm')[0].reset();
							$('#tablaArticulos').load('articulos/tablaArticulos.php');
							Swal.fire('Registrado exitoso','','success');
						}else{
                            Swal.fire('Fallo al subir el archivo','','error');
						}
					}
				});
		});
</script>
<?php

    class eliminar{
        public function obtenIdImg($idProducto){
            $c= new conectar();
            $conexion=$c->conexion();

            $sql="SELECT id_imagen 
                    from productos 
                    where id_producto='$idProducto'";

            $result=mysqli_query($conexion,$sql);
            return mysqli_fetch_row($result)[0];

        }

        public function obtenRutaImagen($idImg){
            $c= new conectar();
            $conexion=$c->conexion();
    
            $sql="SELECT ruta 
                    from imagenes 
                    where id_imagen='$idImg'";
    
            $result=mysqli_query($conexion,$sql);
    
            return mysqli_fetch_row($result)[0];
        }
        public function creaFolio(){
            $c = new conectar();
            $conexion = $c-> conexion();

            $sql = "SELECT id_venta FROM ventas 
                    GROUP BY id_venta DESC";

            $result = mysqli_query($conexion,$sql);
            $id = mysqli_fetch_row($result)[0];

            if ($id == "" or $id=null or $id==0) {
                return 1;
            }else{
                return $id +1;
            }
        }

        public function nombreCliente($idCliente){
            $c = new conectar();
            $conexion = $c->conexion();

            $sql = "SELECT apellido, nombre
                    FROM clientes
                    WHERE id_cliente ='$idCliente'";

            $result = mysqli_query($conexion,$sql);
            $ver = mysqli_fetch_row($result);

            return $ver[0]." ".$ver[1];
        }

        public function obtenerTotal($idventa){
            $c = new conectar();
            $conexion = $c->conexion();

            $sql = "SELECT precio FROM ventas
                    WHERE id_venta='$idventa'";

            $result = mysqli_query($conexion,$sql);
            $total=0;

            while ($ver=mysqli_fetch_row($result)) {
                $total += $ver[0];
            }

            return $total;
        }
    }
?>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>