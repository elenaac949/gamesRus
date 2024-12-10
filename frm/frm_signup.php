<?php
include __DIR__ . '/../controlSesion.php';

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <link rel="stylesheet" href="/gamesRus/css/frm_signup.css">
</head>

<body>
    <h1>Registro</h1>
    <form action="" method="post">
        <fieldset>
            <legend>Credenciales</legend>
            <input type="text" name="alias" id="alias" placeholder="Nick o Alias">
            <input type="email" name="correo" id="correo" placeholder="Correo Electrónico">
            <input type="password" name="contrasenia1" placeholder="Contraseña">
            <input type="password" name="contrasenia2" placeholder="Repite la contraseña">
        </fieldset>
        <fieldset>
            <legend>Datos personales</legend>
            <input type="text" name="nombre" placeholder="Nombre" value="<?php if (isset($_POST['nick'])) {
                                                                                echo $_POST['nick'];
                                                                            } ?>">
            <input type="text" name="apellidos" placeholder="Apellidos">

        </fieldset>
        <fieldset>
            <legend>Datos de contacto</legend>
            <input type="text" name="tipo_via" placeholder="Tipo de vía">
            <input type="text" name="nombre_via" placeholder="Nombre de la vía">
            <input type="text" name="numero_via" placeholder="Número">
            <input type="tel" name="telefono" placeholder="Teléfono">
        </fieldset>

        <input type="submit" name="registroUsuario" value="Registrarse" class="registrar">

        <div class="link-login">
            <p>¿Ya tienes cuenta? </p>
            <input type="submit" name="irInicioSesion" value="Login" class="boton-login">
        </div>

    </form>
</body>

</html>