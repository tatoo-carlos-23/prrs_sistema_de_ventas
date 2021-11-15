<?php
    class usuarios{
        public function registroUsuario($datos){
			$c=new conectar();
			$conexion=$c->conexion();

			$fecha=date('Y-m-d');

			$sql="INSERT into usuarios (nombre,
								apellido,
								usuario,
								password,
								fechaCaptura,
                                dni)
						values ('$datos[0]',
								'$datos[1]',
								'$datos[2]',
								'$datos[3]',
								'$fecha',
                                '$datos[4]')";
			$query = mysqli_query($conexion,$sql);
            echo $query;
		}
		public function loginUser($datos){
			//Instancias
			$c=new conectar();
			$conexion=$c->conexion();

			$password=sha1($datos[1]);

			$_SESSION['usuario']=$datos[0];
			$_SESSION['iduser']=self::traeID($datos);

			$sql = "SELECT * FROM usuarios 
					WHERE usuario='$datos[0]' 
					AND password='$password'";

			$result=mysqli_query($conexion,$sql);

			if (mysqli_num_rows($result) > 0) {
				return 1;
			}else {
				return 0;
			}
		}
		public function traeID($datos){
			//Instancias
			$c=new conectar();
			$conexion=$c->conexion();

			$password=sha1($datos[1]);

			$sql = "SELECT id_usuario FROM usuarios WHERE usuario='$datos[0]' AND password='$password'";
			
			$result=mysqli_query($conexion,$sql);
			return mysqli_fetch_row($result)[0];
		}

		public function obtenDatosUsuario($idusuario){
			$c=new conectar();
			$conexion=$c->conexion();

			$sql = "SELECT 
						id_usuario,
						nombre,
						dni,
						apellido,
						usuario
					FROM usuarios 
					WHERE id_usuario='$idusuario'";

			$result=mysqli_query($conexion,$sql);
			$ver=mysqli_fetch_row($result);
			$datos=array('id_usuario' =>$ver[0],
						'nombre' =>$ver[1],
						'dni' =>$ver[2],
						'apellido' =>$ver[3],
						'usuario' =>$ver[4]);
			return $datos;
		}

		public function actualizaUsuario($datos){
			$c=new conectar();
			$conexion=$c->conexion();

			$sql = "UPDATE usuarios 
					SET nombre='$datos[1]', dni='$datos[2]', 
					apellido='$datos[3]', usuario='$datos[4]'
					WHERE id_usuario='$datos[0]'";

			return mysqli_query($conexion,$sql);
		}

		public function eliminaUsuario($idusuario){
			$c=new conectar();
			$conexion=$c->conexion();

			$sql = "DELETE FROM usuarios 
					WHERE id_usuario='$idusuario'";

			return mysqli_query($conexion,$sql);
		}
    }
?>