<?php
include __DIR__ . '/../common/controlSesion.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/gamesRus/css/general.css">
    <link rel="stylesheet" href="/gamesRus/css/frm_prestar.css">
    <title>Prestar</title>
</head>

<body>
    <?php
    include './common/cabecera.php';
    ?>
    <p class="errores"><?= $error ?></p>
    <?php /* var_dump($_POST['idJuegoCatalogo'];)  */ ?>
    <main class="contenido_principal">
        <aside class="filtros">
            <p>aqui van los filtros</p>
        </aside>
        <section class="vista-formulario">
            <h2>Préstamo de juegos</h2>
            <?php var_dump($data) ?>
            <form action="#" method="post" name="formulario_prestar_juego">
                <input type="hidden" name="idJuego" id="" value="<?= $data ?>">
                <!-- HACER UNA QUERY QUE ACCEDA AL NOMBRE DEL JUEGO POR EL ID -->
                <input type="text" readonly id="" value="Nombre del juego">
                <input type="text" name="nombre-usuario" id="" placeholder="Usuario a quien prestas" required>
                <input type="submit" name="prestar-juego" value="Prestar">
            </form>
        </section>
    </main>
    <?php
    include './common/footer.php';
    ?>
</body>

</html>