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
                <input type="hidden" name="administrar">
                <div>
                    <input type="submit" name="mostrar_anadir_juego" value="Nuevo Juego">
                </div>
                <div>
                    <input type="submit" name="mostrar_eliminar_juego" value="Eliminar Juego">
                </div>
                <div>
                    <input type="submit" name="mostrar_modificar_juego" value="Editar Juego">
                </div>
            </form>
        </aside>
        <section>
            <!-- si damos al boton de añadir juego se muestra el formulario correspondiente-->
            <?php if (isset($_POST['mostrar_anadir_juego'])) : ?>
                <h2>Datos Juego Nuevo</h2>
                <form action="" method="post" name="formulario_anadir_juego">
                    <input type="text" name="titulo_juego" placeholder="Título">

                    <select name="genero_juego">
                        <option value="">Selecciona un género</option>
                        <?php foreach ($data as $genero) : ?>
                            <option value="<?= $genero['idGenero']; ?>"><?= $genero['genero']; ?></option>
                        <?php endforeach ?>
                    </select>
                    <input type="text" name="desarrollador_juego" placeholder="Desarrollador">
                    <input type="text" name="distribuidor_juego" placeholder="Distribuidor">
                    <input type="date" name="anio_lanzamiento" placeholder="Año">
                    <input type="text" name="ruta_juego" placeholder="Ruta">
                    <textarea name="descripcion_juego" placeholder="Descripción"></textarea>
                    <input type="submit" name="anadir-juego" value="Añadir Juego">
                </form>
            <?php endif ?>
        </section>

    </main>


    <?php
    include './common/footer.php';
    ?>
</body>

</html>