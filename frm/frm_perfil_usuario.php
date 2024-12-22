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
    <section class="actualizar_datos">
        <h2>Actualizar Datos de Usuario</h2>
        <form action="" method="post">
            <p class="errores"><?= $error ?></p>
            <?php /* var_dump($data) */ ?>
            <fieldset>
                <legend>Credenciales</legend>
                <input required type="text" name="alias" id="alias" placeholder="Nick o Alias*" value="<?php echo $data['nick']; ?>">
                <input required type="email" name="correo" id="correo" placeholder="Correo Electrónico*" value="<?php echo $data['email']; ?>">

            </fieldset>
            <fieldset>
                <legend>Datos personales</legend>
                <input required type="text" name="nombre" placeholder="Nombre*" value="<?php echo $data['nombre']; ?>">
                <input required type="text" name="apellidos" placeholder="Apellidos*" value="<?php echo $data['apellidos']; ?>">

            </fieldset>
            <fieldset>
                <legend>Datos de contacto</legend>
                <input required type="text" name="tipo_via" placeholder="Tipo de vía" value="<?php echo $data['TipoDeVia']; ?>">
                <input required type="text" name="nombre_via" placeholder="Nombre de la vía" value="<?php echo $data['NombreDeVia']; ?>">
                <input required type="text" name="numero_via" placeholder="Número Vía" value="<?php echo $data['Numero']; ?>">
                <input required type="text" name="numeros" placeholder="Número Piso" value="<?php echo $data['Numeros']; ?>">
                <input required type="text" name="otros" placeholder="Otros datos" value="<?php echo $data['Otros']; ?>">
                <input required type="tel" name="telefono" placeholder="Teléfono*" value="<?php echo $data['NumeroTelefono']; ?>">

            </fieldset>

            <input type="submit" name="btn_actualizar_datos" value="Actualizar Datos" class="actualizar">

        </form>
    </section>

    <section class="tarjetas">
        <!-- mostrar tarjetas de credito -->
    </section>

    <section class="borrar_cuenta">
        <!-- si la sesion no es del acministrador podra eliminar su cuenta -->
        <h2>Eliminar Cuenta de usuario</h2>
        <form action="" method="post">
            <?php if ($_SESSION['nickUsuario'] == 'admin') : ?>
                <p>No puedes eliminar esta cuenta</p>
            <?php else : ?>
                <input type="submit" name="btn_eliminar_cuenta" value="Eliminar Cuenta">
            <?php endif; ?>
        </form>


    </section>

    <?php
    include './common/footer.php';
    ?>

    <script>
        document.getElementById('formEliminarCuenta').addEventListener('submit', function(event) {
            const isConfirmed = confirm("¿Estás seguro de que deseas eliminar tu cuenta? Esta acción no se puede deshacer.");
            if (!isConfirmed) {
                // Si el usuario cancela, se previene el envío del formulario
                event.preventDefault();
            }
        });
    </script>
</body>

</html>