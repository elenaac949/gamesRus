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
    <p class="errores"><?= $data ?></p>
        <fieldset>
            <legend>Credenciales</legend>
            <input type="text" name="alias" id="alias" placeholder="Nick o Alias*" value="<?php if (isset($_POST['alias'])) {
                                                                                echo $_POST['alias'];
                                                                            } ?>">
            <input type="email" name="correo" id="correo" placeholder="Correo Electrónico*" value="<?php if (isset($_POST['correo'])) {
                                                                                echo $_POST['correo'];
                                                                            } ?>">
            <input type="password" name="contrasenia1" placeholder="Contraseña*">
            <input type="password" name="contrasenia2" placeholder="Repite la contraseña*">
        </fieldset>
        <fieldset>
            <legend>Datos personales</legend>
            <input type="text" name="nombre" placeholder="Nombre*" value="<?php if (isset($_POST['nombre'])) {
                                                                                echo $_POST['nombre'];
                                                                            } ?>">
            <input type="text" name="apellidos" placeholder="Apellidos*" value="<?php if (isset($_POST['apellidos'])) {
                                                                                echo $_POST['apellidos'];
                                                                            } ?>">

        </fieldset>
        <fieldset>
            <legend>Datos de contacto</legend>
            <input type="text" name="tipo_via" placeholder="Tipo de vía" value="<?php if (isset($_POST['tipo_via'])) {
                                                                                echo $_POST['tipo_via'];
                                                                            } ?>">
            <input type="text" name="nombre_via" placeholder="Nombre de la vía" value="<?php if (isset($_POST['nombre'])) {
                                                                                echo $_POST['nombre_via'];
                                                                            } ?>">
            <input type="text" name="numero_via" placeholder="Número" value="<?php if (isset($_POST['numero_via'])) {
                                                                                echo $_POST['numero_via'];
                                                                            } ?>">
            <input type="tel" name="telefono" placeholder="Teléfono*" value="<?php if (isset($_POST['telefono'])) {
                                                                                echo $_POST['telefono'];
                                                                            } ?>">
                                                    
        </fieldset>

        <input type="submit" name="registroUsuario" value="Registrarse" class="registrar">

        <div class="link-login">
            <p>¿Ya tienes cuenta? </p>
            <input type="submit" name="irInicioSesion" value="Login" class="boton-login">
        </div>
        
    </form>
</body>

</html>