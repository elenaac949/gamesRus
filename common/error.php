<?php
include __DIR__ . '/../common/controlSesion.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página de error</title>
    <link rel="stylesheet" href="/gamesRus/css/general.css">
    <link rel="stylesheet" href="/gamesRus/css/error.css">
</head>

<body>

    <?php
    include './common/cabecera.php';
    ?>

    <main>

        <img src="/gamesRus/img/error.webp" alt="Imagen de dificultades tecnicas.">

        <form action="" method="post">
            <input type="submit" name="btn_volver" value="Volver a la Biblioteca">
        </form>

    </main>

    <?php
    include './common/footer.php';
    ?>

</body>

</html>