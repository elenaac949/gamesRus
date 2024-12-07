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
    <form action="" method="post">
        <label for="nombre">Nombre:
            <input type="text" name="nombre" id="nombre" placeholder="Nombre" value="<?php if (isset($_POST['nombre'])) {
                                                                                            echo $_POST['nombre'];
                                                                                        } ?>">
        </label>
        <label for="apellidos">Apellidos:
            <input type="text" name="apellidos" id="apellidos" placeholder="Apellidos" value="<?php if (isset($_POST['apellidos'])) {
                                                                                                    echo $_POST['apellidos'];
                                                                                                } ?>">
        </label>
        <label for="correo">Correo electrónico:
            <input type="email" name="correo" id="correo" placeholder="Correo electrónico" value="<?php if (isset($_POST['correo'])) {
                                                                                                        echo $_POST['correo'];
                                                                                                    } ?>">
        </label>
        <label for="nick">Nick:
            <input type="text" name="nick" id="nick" placeholder="Nombre de usuario" value="<?php if (isset($_POST['nick'])) {
                                                                                                echo $_POST['nick'];
                                                                                            } ?>">
        </label>
        <label for="contrasenia"> Contraseña:
            <input type="password" name="contrasenia" id="contrasenia" placeholder="Contraseña">
        </label>
        <label for="contrasenia2"> Confirma la contraseña:
            <input type="password" name="contrasenia2" id="contrasenia2" placeholder="Contraseña">
        </label>

        <input type="submit" name="registroUsuario" value="Registrarse" class="registrar">

        <div class="link-login">
            <p>¿Ya tienes cuenta? </p>
            <input type="submit" name="irInicioSesion" value="Login" class="boton-login">
        </div>

    </form>
</body>

</html>