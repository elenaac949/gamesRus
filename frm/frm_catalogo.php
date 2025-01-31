<?php
include __DIR__ . '/../common/controlSesion.php';
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo</title>
    <link rel="stylesheet" href="/gamesRus/css/general.css">
    <link rel="stylesheet" href="/gamesRus/css/frm_catalogo.css">
</head>

<body>
    <?php
    include './common/cabecera.php';
    ?>
    <p class="errores"><?= !$error  ? $data1 : $error ?></p>


    <?php /*var_dump($data1)*/   ?>
    <main class="contenido_principal">
        <aside class="filtros">
            <h4>Buscar:</h4>
            <form action="" name="formulario_filtrar" method="post" class="formulario_filtrar">
                <label for="genero">Géneros</label>
                <select name="genero" id="genero">
                    <option value="0">Todos</option>
                    <?php foreach ($data2 as $genero) : ?>
                        <option <?php echo isset($_POST['genero'])&& $_POST['genero']==$genero['idGenero']? "selected": "" ?> value="<?php echo $genero['idGenero']; ?>"><?php echo $genero['genero']; ?></option>
                    <?php endforeach; ?>
                </select>
                <label for="sistema">Sistemas</label>
                <select name="sistema" id="sistema">
                    <option value="0">Todos</option>
                    <?php foreach ($data3 as $sistema) : ?>
                        <option <?php echo isset($_POST['sistema'])&& $_POST['sistema']==$sistema['idSistema']? "selected": "" ?> value="<?php echo $sistema['idSistema']; ?>"><?php echo $sistema['nombre']; ?></option>
                    <?php endforeach; ?>
                <input type="number" name="fecha" id="fecha" placeholder="Año" value="<?php echo isset($_POST['fecha'])? $_POST['fecha']: "" ?>">
                <input type="submit" name="btn_filtrar_juegos" value="Filtrar">

            </form>

        </aside>
        <section class="vista_juegos">


            <?php foreach ($data as $juego): ?>
                <div class="juego">
                    <div class="imagen_juego">
                        <img src="<?php echo $juego['portada'] ?? 'https://placehold.co/200x100' ?>" alt="<?php echo $juego['titulo']; ?>">
                    </div>
                    <div class="nombre_juego">
                        <p><?php echo $juego['titulo']; ?></p>
                    </div>
                    <div class="botones_juego">
                        <form action="" method="post">
                            <input type="hidden" value="<?php echo $juego['idJuego']; ?>" name="idJuegoCatalogo">
                            <input type="button" value="Detalles">
                            <input type="submit" value="Añadir al carrito" name="btn_anadir_carrito">
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        </section>
    </main>

    <?php
    include './common/footer.php';
    ?>
</body>

</html>