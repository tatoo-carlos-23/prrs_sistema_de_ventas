<?php
require_once "../../clases/Conexion.php";
$c = new conectar();
$conexion = $c->conexion();

$sql = "SELECT art.nombre, art.descripcion, concat_ws('', art.stock_final, ' / ', art.stock_inicial) as cantidad, art.precio, art.ruta, cat.nombreCategoria, art.id_producto FROM articulos AS art INNER JOIN categorias AS cat ON cat.id_categoria = art.id_categoria";

$result = mysqli_query($conexion, $sql);
?>


<table class="table table-hover table-condensed table-bordered" style="text-align: center;">
    <caption><label>Articulos: </label></caption>
    <tr style="background-color: red; color: yellow; font-weight: bold;">
        <td>Modelo</td>
        <td>Descripción</td>
        <td>Cantidad</td>
        <td>Precio</td>
        <td>Imagen</td>
        <td>Categoria</td>
        <td>Editar</td>
        <td>Eliminar</td>
    </tr>

    <?php while ($ver = mysqli_fetch_row($result)) : ?>

        <tr class="lista-productos">
            <td><?php echo $ver[0]; ?></td>
            <td><?php echo $ver[1]; ?></td>
            <td><?php echo $ver[2]; ?></td>
            <td><?php echo $ver[3]; ?></td>
            <td>
                <?php
                $imgVer = explode("/", $ver[4]);
                $imgruta = $imgVer[1] . "/" . $imgVer[2] . "/" . $imgVer[3];
                ?>
                <img widtch="50" height="60" src="<?php echo $imgruta ?>">
            </td>
            <td><?php echo $ver[5]; ?></td>
            <td>
                <span data-toggle="modal" data-target="#abremodalUpdateArticulo" class="btn btn-warning btn-xs" onclick="agregaDatosArticulo('<?php echo $ver[6] ?>')">
                    <span class="glyphicon glyphicon-pencil"></span>
                </span>
            </td>
            <td>
                <span class="btn btn-danger btn-xs" onclick="eliminaArticulo('<?php echo $ver[6] ?>', '<?php echo $ver[4] ?>')">
                    <span class="glyphicon glyphicon-remove"></span>
                </span>
            </td>
        </tr>
    <?php endwhile; ?>
</table>