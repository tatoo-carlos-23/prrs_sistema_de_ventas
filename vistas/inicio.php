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
        <div class="data-inicio">
            <div class="celular">
                <div class="items">
                    <img src="../archivos/20211021214122kisspng-samsung-galaxy-j2-prime-android-telephone-samsung-j2-prime-5ad80bf0cb5d14.548586101524108272833.png" alt="" class="img-celular">
                    <div class="datos-celular">
                        Lorem ipsum dolor sit amet consectetur adipisici Lorem ipsum, dolor sit amet consectetur adipisicing elit. Sequi consectetur repudiandae modi quo officiis blanditiis neque, quas reiciendis vero, itaque qui, nesciunt perferque qui, nesciunt perferque qui, nesciunt perferque qui, nesciunt perferque qui, nesciunt perferque qui, nesciunt perferque qui, nesciunt perferque qui, nesciunt perferque qui, nesciunt perferque qui, nesciunt perferque qui, nesciunt perferque qui, nesciunt perferque qui, nesciunt perferque qui, nesciunt perferque qui, nesciunt perferque qui, nesciunt perferque qui, nesciunt perferque qui, nesciunt perferque qui, nesciunt perferque qui, nesciunt perferque qui, nesciunt perferque qui, nesciunt perferque qui, nesciunt perferque qui, nesciunt perferque qui, nesciunt perferque qui, nesciunt perferque qui, nesciunt perferque qui, nesciunt perferque qui, nesciunt perferque qui, nesciunt perferque qui, nesciunt perferque qui, nesciunt perferque qui, nesciunt perferque qui, nesciunt perferque qui, nesciunt perferque qui, nesciunt perferque qui, nesciunt perferque qui, nesciunt perferque qui, nesciunt perferque qui, nesciunt perferque qui, nesciunt perferque qui, nesciunt perferque qui, nesciunt perferque qui, nesciunt perferque qui, nesciunt perferque qui, nesciunt perferque qui, nesciunt perferque qui, nesciunt perferque qui, nesciunt perferque qui, nesciunt perferque qui, nesciunt perferque qui, nesciunt perferque qui, nesciunt perferque qui, nesciunt perferque qui, nesciunt perferque qui, nesciunt perferque qui, nesciunt perferque qui, nesciunt perferque qui, nesciunt perferque qui, nesciunt perferque qui, nesciunt perferque qui, nesciunt perferque qui, nesciunt perferque qui, nesciunt perferque qui, nesciunt perferque qui, nesciunt perferque qui, nesciunt perferque qui, nesciunt perferque qui, nesciunt perferque qui, nesciunt perferque qui, nesciunt perferque qui, nesciunt perferque qui, nesciunt perferque qui, nesciunt perferque qui, nesciunt perferque qui, nesciunt perferque qui, nesciunt perferque qui, nesciunt perferque qui, nesciunt perferque qui, nesciunt perferque qui, nesciunt perferque qui, nesciunt perferque qui, nesciunt perferque qui, nesciunt perferque qui, nesciunt perferque qui, nesciunt perferque qui, nesciunt perferque qui, nesciunt perferque qui, nesciunt perferque qui, nesciunt perferque qui, nesciunt perferque qui, nesciunt perferque qui, nesciunt perferque qui, nesciunt perferque qui, nesciunt perferque qui, nesciunt perferque qui, nesciunt perferque qui, nesciunt perferque qui, nesciunt perferque qui, nesciunt perferque qui, nesciunt perferque qui, nesciunt perferque qui, nesciunt perferque qui, nesciunt perferque qui, nesciunt perferque qui, nesciunt perferque qui, nesciunt perferendis eaque nemo praesentium possimus quae architecto impedit! Lorem ipsum dolor, sit amet consectetur adipisicing elit. Cupiditate eos nihil reprehenderit eveniet facere accusamus iste sit fuga natus quia. Alias tempora non et soluta, eum unde repudiandae aliquid quo? ng elit. Quibusdam fugit ea sed aut quasi pariatur quisquam, qui quos itaque. Aliquid quis et in voluptate dignissimos quisquam fuga, vitae quia iste?
                    </div>
                </div>

            </div>
        </div>

    </body>

    </html>
<?php
} else {
    header("location:../index.php");
}
?>