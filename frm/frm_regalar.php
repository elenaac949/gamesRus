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
    <title>Regalar</title>
</head>

<body>
    <?php
    include './common/cabecera.php';
    ?>
    <p class="errores"><?= $error ?></p>
    <?php $data;  ?>


    <main class="contenido_principal">
        <section class="vista-formulario">
            <h2>Regala un juego</h2>
            <?php var_dump($data) ?>
            <?php /*var_dump($_POST)*/ ?>
            <form action="#" method="post" name="formulario_regalar_juego">
                <input type="hidden" name="idJuego" id="" value="<?= $_POST['idJuegoCatalogo'] ?>">
                <!-- HACER UNA QUERY QUE ACCEDA AL NOMBRE DEL JUEGO POR EL ID -->
                <input type="text" readonly id="" value="<?php echo $data['titulo']; ?>">
                <input type="text" name="nombre-usuario" id="" placeholder="Usuario a quien regalas" required>
                <input type="submit" name="btn_confirmar_regalo" value="Regalar">
            </form>
        </section>
    </main>
    <?php
    include './common/footer.php';
    ?>
</body>

</html>