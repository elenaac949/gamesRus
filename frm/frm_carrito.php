<?php
include __DIR__ . '/../common/controlSesion.php';
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito</title>
    <link rel="stylesheet" href="/gamesRus/css/general.css">
    <link rel="stylesheet" href="/gamesRus/css/frm_carrito.css">
</head>

<body>
    <?php
    include './common/cabecera.php';
    ?>
    <p class="errores"><?= $error ?></p>
    <main>
        <section class="juegos_carrito">
            <?php foreach ($data as $juego): ?>
                <div class="juego">
                    <img src="<?php echo $juego['portada'] ?? 'https://placehold.co/200x100' ?>" alt="<?php echo $juego['titulo']; ?>">
                    <div class="titulo_botones">
                        <p><?php echo $juego['titulo']; ?></p>

                        <div class="botones_juego">
                            <form action="" method="post">
                                <input type="hidden" value="<?php echo $juego['idJuego']; ?>" name="idJuegoCatalogo">
                                <input type="submit" value="Eliminar" name="btn_eliminar_del_carrito">
                                <input type="button" value="Regalar" name="btn_regalar_juego">
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </section>
        <aside class="total_pago">
            <div>
                <p>Aqui va el total</p>
            </div>
            <form action="" method="post">
                <input type="submit" value="Pagar" name="btn_pagar">
            </form>
        </aside>
    </main>

    <?php
    include './common/footer.php';
    ?>
</body>

</html>