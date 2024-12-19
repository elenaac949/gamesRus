<?php
include __DIR__ . '/../common/controlSesion.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Administrador</title>
    <link rel="stylesheet" href="/gamesRus/css/general.css">
    <link rel="stylesheet" href="/gamesRus/css/frm_administracion.css">
</head>

<body>
    <?php
    include './common/cabecera.php';
    ?>

    <main>
        <aside class="">
            
            <form action="" method="post" name="elegir_accion_administrador">
                <!-- <input type="hidden" name="administrar"> -->
                <div>
                    <input type="submit" name="mostrar_anadir_juego" value="Nuevo Juego">
                </div>
                <div>
                    <input type="submit" name="mostrar_eliminar_juego" value="Eliminar Juego">
                </div>
                <div>
                    <input type="submit" name="mostrar_editar_juego" value="Editar Juego">
                </div>
            </form>
        </aside>
        <section>
        <p class="errores"><?= $error ?></p>
            <?php if (isset($_POST['mostrar_anadir_juego'])) {
                include "./frm/frm_anadir_juego.php";
            }elseif (isset($_POST['mostrar_eliminar_juego'])) {
                include "./frm/frm_eliminar_juego.php";
            }else if (isset($_POST['mostrar_editar_juego'])) {
                include "./frm/frm_editar_juego.php";
            }?>
            
        </section>

    </main>


    <?php
    include './common/footer.php';
    ?>
</body>

</html>