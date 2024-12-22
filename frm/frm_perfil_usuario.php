<?php
include __DIR__ . '/../common/controlSesion.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil de Usuario</title>
    <link rel="stylesheet" href="/gamesRus/css/general.css">
</head>

<body>
    <?php
    include './common/cabecera.php';
    ?>
    <form action="" method="post">
        <p class="errores"><?= $data ?></p>
        <fieldset>
            <legend>Credenciales</legend>
            <input type="text" name="alias" id="alias" placeholder="Nick o Alias*" >
            <input type="email" name="correo" id="correo" placeholder="Correo Electrónico*" >
            <input type="password" name="contrasenia1" placeholder="Contraseña*">
            <input type="password" name="contrasenia2" placeholder="Repite la contraseña*">
        </fieldset>
        <fieldset>
            <legend>Datos personales</legend>
            <input type="text" name="nombre" placeholder="Nombre*" >
            <input type="text" name="apellidos" placeholder="Apellidos*" >

        </fieldset>
        <fieldset>
            <legend>Datos de contacto</legend>
            <input type="text" name="tipo_via" placeholder="Tipo de vía" >
            <input type="text" name="nombre_via" placeholder="Nombre de la vía" >
            <input type="text" name="numero_via" placeholder="Número" >
            <input type="tel" name="telefono" placeholder="Teléfono*" >

        </fieldset>

        <input type="button" name="btn_modificar_datos" value="Actualizar Datos" class="actualizar">



    </form>

    <?php
    include './common/footer.php';
    ?>
</body>

</html>