<?php
    class conectar{
        private $servidor="localhost";
        private $usuario="root";
        private $password="";
        private $bd="pedro_sis_ventas";

        public function conexion(){
            $conexion=mysqli_connect($this->servidor,$this->usuario,
                                    $this->password,$this->bd);
            return $conexion; 
        }
    }

    // $obj = new conectar();
    // if ($obj->conexion()) {
    //     echo "conxion ok";
    // }
?>