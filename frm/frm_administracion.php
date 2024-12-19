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
    <aside>
        <form action="" method="post" name="elegir_accion_administrador">
            <ul>
                <li>
                    <input type="button" value="Juegos">
                    <ul class="dropdown">
                        <li>
                        <input type="submit" name="mostrar_anadir_juego" value="Nuevo Juego">
                        </li>
                        <li>
                            <input type="submit" name="mostrar_eliminar_juego" value="Eliminar Juego">
                        </li>
                        <li>
                            <input type="submit" name="mostrar_editar_juego" value="Editar Juego">
                        </li>
                    </ul>
                </li>
                <li>
                    <input type="button" value="Usuarios">
                    <ul class="dropdown">
                        <li>
                            <input type="submit" name="anadir" value="Nuevo Usuario">
                        </li>
                        <li>
                            <input type="submit" name="eliminar" value="Eliminar Usuario">
                        </li>
                        <li>
                            <input type="submit" name="editar" value="Editar Usuario">
                        </li>
                    </ul>
                </li>
            </ul>
        </form>
    </aside>

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