<?php
session_start();
if (isset($_SESSION['usuario'])) {

?>

    <!DOCTYPE html>
    <html lang="es">

    <head>
        <meta charset="UTF-8">
        <link rel="shortcut icon" href="../img/iconInicio.png" type="image/x-icon">
        <title>Inicio</title>
        <link rel="stylesheet" href="../css/inicio.css">
        <?php require_once "menu.php"; ?>
    </head>

    <body>
        <?php
        require_once "../clases/Conexion.php";

        $obj = new conectar();
        $conexion = $obj->conexion();

        $sql = "SELECT art.id_producto, art.id_categoria, cat.nombreCategoria, art.nombre, art.descripcion, art.stock_final, art.precio, art.ruta from articulos as art inner join categorias as cat on cat.id_categoria = art.id_categoria";

        $result = mysqli_query($conexion, $sql);
        ?>

        <div class="data-inicio">
            <div class="celular">
                <?php
                while ($ver = mysqli_fetch_row($result)) :
                ?>
                    <div class="items">
                        <img alt="" class="img-celular" src="<?php
                                                                $imgVer = explode("/", $ver[7]);
                                                                $imgruta = $imgVer[1] . "/" . $imgVer[2] . "/" . $imgVer[3];
                                                                echo $imgruta;
                                                                ?>">
                        <div class="datos-celular w-100">
                            <div class="titulo-cel w-100">
                                <?php echo $ver[3] ?>
                            </div>
                            <div class="descripcion-cel w-100">
                                <?php echo $ver[4] ?>
                            </div>
                            <div class="mas-datos w-100">
                                <div class="precio-cat-cel w-100">
                                    PRECIO:  S/<strong><span><?php echo $ver[6] ?></span></strong>
                                </div>
                                <div class="precio-cat-cel w-100">
                                    CATEGORIA: <strong><span><?php echo $ver[2] ?></span></strong>
                                </div>
                                <div class="stock-cel w-100">
                                    DISPONIBLE: <span id="<?php if ($ver[5] > 0) {
                                                                echo 'stock_lleno';
                                                            } else {
                                                                echo 'stock_vacio';
                                                            } ?>"><strong><?php echo $ver[5] ?></strong> unidades.</span>
                                </div>
                            </div>

                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>

    </body>

    </html>
<?php
} else {
    header("location:../index.php");
}
?>