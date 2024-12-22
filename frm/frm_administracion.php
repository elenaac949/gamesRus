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
            
            <!-- Le estamos pasando el parametro administrar para que en controlador nos cargue esta vista  NO TIENE QUE VER CON EL submit DE ADMINISTRAR se llaman igual porque con ese valor vamos a hacer la misma función, es decir, mostrar la vista de administrador-->
                <input type="hidden" name="administrar">
                <div>

                    <input type="submit" name="mostrar_anadir_juego" value="Nuevo Juego">
                </div>
                <div>
                    <input type="submit" name="boton" value="Eliminar">
                </div>
                <div>
                    <input type="submit" name="mostrar_editar_juego" value="Editar">
                </div>
            </form>
        </aside>
        <section>
        
        <p class="errores"><?= $error ?></p>
            <!-- si damos al boton de añadir juego se muestra el formulario correspondiente-->
            <?php if (isset($_POST['mostrar_anadir_juego'])) : ?>
                
                <h2>Datos Juego Nuevo</h2>
                
                <form action="#" method="post" name="formulario_anadir_juego">
                
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
                    <input type="text" name="portada_juego" placeholder="Portada">
                    <input type="submit" name="anadir-juego" value="Añadir Juego">
                    
                </form>
            <?php endif ?>
            
            <!-- ELIMINAR LOS JUEGOS -->
            <?php if (isset($_POST['mostrar_eliminar_juego'])) : ?>
            <h2>Eliminar Juego</h2>
            <form action="" method="post" name="formulario_eliminar_juego">
                <select name="nombre_juego">
                <option value="">Selecciona un titulo</option>
                        <?php foreach ($data as $titulo) : ?>
                            <option value="<?= $titulo['titulo']; ?>"><?= $titulo['titulo']; ?></option>
                        <?php endforeach ?>
                </select>
                <input type="submit" name="eliminar-juego" value="Eliminar juego">
            </form>
            <?php endif ?>
            
            <!-- Editar los juegos -->
            <?php if (isset($_POST['mostrar_editar_juego'])) : ?>
                <h2>Editar juego</h2>
                <form action="" method="post" name="formulario_editar_juego">
                <select name="nombre_juego">
                <option value="">Selecciona un titulo</option>
                        <?php foreach ($data as $titulo) : ?>
                            <option value="<?= $titulo['titulo']; ?>"><?= $titulo['titulo']; ?></option>
                        <?php endforeach ?>
                </select>
                
                <input type="text" name="desarrollador_juego" placeholder="Desarrollador" value="">
                <input type="text" name="distribuidor_juego" placeholder="Distribuidor">
                <input type="date" name="anio_lanzamiento" placeholder="Año">
                <input type="text" name="ruta_juego" placeholder="Ruta">
                <textarea name="descripcion_juego" placeholder="Descripción"></textarea>
                <input type="submit" name="editar-juego" value="Editar Juego">


                </form>
            <?php endif ?>
        </section>

    </main>


    <?php
    include './common/footer.php';
    ?>
</body>

</html>