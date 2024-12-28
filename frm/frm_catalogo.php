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
     <p class="errores"><?= $error ?></p>
     <?php /* var_dump($data)  */ ?>
    <main class="contenido_principal">
        <aside class="filtros">
            <p>aqui van los filtros</p>
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