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
    <link rel="stylesheet" href="/gamesRus/css/frm_perfil.css">
</head>

<body>
    <?php
    include './common/cabecera.php';
    ?>
    <main>
        <p class="errores"><?= $error ?></p>
        <section class="actualizar_datos">
            <h3>Actualizar Datos de Usuario</h3>
            <form action="" method="post">

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

            <div class="mostrar_tarjetas">
                <h3>Tus tarjetas</h3>
                <form method="post">
                    <table>
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Últimos 4 dígitos</th>
                                <th>CCV</th>
                                <th>Caducidad</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $contador = 1; ?>
                            <?php foreach ($data1 as $tarjeta): ?>
                                <tr>
                                    <!-- Número de fila -->
                                    <td><?php echo $contador++; ?></td>

                                    <!-- Últimos 4 dígitos de la tarjeta -->
                                    <td><?php echo substr($tarjeta['numeroTarjeta'], -4); ?></td>

                                    <!-- CCV oculto -->
                                    <td><?php echo $tarjeta['ccv']; ?></td>

                                    <!-- Fecha de caducidad -->
                                    <td>
                                        <?php
                                        $fechaActual = date('Y-m');
                                        if ($tarjeta['fechaCaducidad'] < $fechaActual) {
                                            echo 'Caducada'; // Si la fecha de caducidad es anterior a la fecha actual
                                        } else {
                                            echo $tarjeta['fechaCaducidad']; // Mostrar la fecha si no está caducada
                                        }
                                        ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>

                </form>
            </div>

            <div class="anadir_tarjetas">
                <h3>Añadir tarjeta nueva</h3>

                <form action="" method="post" class="form_anadir_tarjeta">
                    <div class="datos">
                        <div class="dato">
                            <label for="numero_tarjeta">Numero de Tarjeta: </label>
                            <input type="text" name="numero_tarjeta" placeholder="xxxx xxxx xxxx xxxx">
                        </div>
                        <div class="dato">
                            <label for="ccv_tarjeta">CCV: </label>
                            <input type="text" name="ccv_tarjeta" placeholder="xxx">
                        </div>
                        <div class="dato">
                            <label for="fecha_caducidad_tarjeta">Fecha de caducidad: </label>
                            <input type="month" name="fecha_caducidad_tarjeta">
                        </div>

                    </div>
                    <div class="boton">
                        <input type="submit" name="btn_anadir_tarjeta" value="Añadir">
                    </div>


                </form>
            </div>

            <div class="eliminar_tarjetas">
                
            </div>

        </section>

        <section class="borrar_cuenta">
            <!-- si la sesion no es del acministrador podra eliminar su cuenta -->
            <h3>Eliminar Cuenta de usuario</h3>
            <form action="" method="post">

                <input type="submit" name="btn_eliminar_cuenta" value="Eliminar Cuenta">

            </form>


        </section>
    </main>




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