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

                <?php  /*  var_dump($data); var_dump($data1);  */  ?>
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
                    <input required type="text" name="tipo_via" placeholder="Tipo de vía" value="<?php echo $data['tipoDeVia']; ?>">
                    <input required type="text" name="nombre_via" placeholder="Nombre de la vía" value="<?php echo $data['nombreDeVia']; ?>">
                    <input required type="text" name="numero_via" placeholder="Número Vía" value="<?php echo $data['numeroDeVia']; ?>">
                    <input required type="text" name="numeros" placeholder="Número Piso" value="<?php echo $data['numeros']; ?>">
                    <input required type="text" name="otros" placeholder="Otros datos" value="<?php echo $data['otros']; ?>">
                    <input required type="tel" name="telefono" placeholder="Teléfono*" value="<?php echo $data['numeroTelefono']; ?>">

                </fieldset>

                <input type="submit" name="btn_actualizar_datos" value="Actualizar Datos" class="actualizar">

            </form>
        </section>

        <?php
        $meses = [
            1 => "Enero",
            2 => "Febrero",
            3 => "Marzo",
            4 => "Abril",
            5 => "Mayo",
            6 => "Junio",
            7 => "Julio",
            8 => "Agosto",
            9 => "Septiembre",
            10 => "Octubre",
            11 => "Noviembre",
            12 => "Diciembre"
        ];

        // Año actual y rango de años futuros
        $anioActual = date("Y");
        $aniosFuturos = 10; // Mostrar 10 años futuros
        ?>



        <section class="tarjetas">

            <div class="mostrar_tarjetas">
                <h3>Tus tarjetas</h3>
                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Últimos 4 dígitos</th>
                            <th>CCV</th>
                            <th>Caducidad</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $contador = 1; 
                        ?>
                        <?php foreach ($data1 as $tarjeta): ?>
                            <?php
                            $fechaCaducidad = $tarjeta['fechaCaducidad']; // Ejemplo de fecha obtenida
                            list($anioCaducidad, $mesCaducidad, $diaCaducidad) = explode('-', $fechaCaducidad);
                            ?>
                            <tr>
                                <form action="" method="post" class="form_mostrar_tarjeta">
                                    <!-- Número de fila -->
                                    <td><?php echo $contador++; ?></td>

                                    <!-- Últimos 4 dígitos de la tarjeta -->
                                    <td><?php echo substr($tarjeta['numeroTarjeta'],-4); ?></td>

                                    <!-- CCV oculto -->
                                    <td><input type="text" name="ccv_tarjeta" placeholder="xxx" value="<?php echo $tarjeta['ccv']; ?>"></td>

                                    <!-- Fecha de caducidad -->
                                    <td>
                                        <label for="mes_cad_tarjeta">Mes</label>
                                        <select name="mes_cad_tarjeta">
                                            <?php foreach ($meses as $numeroMes => $nombreMes): ?>
                                                <option value="<?= $numeroMes ?>" <?= $numeroMes == intval($mesCaducidad) ? 'selected' : '' ?>>
                                                    <?= $nombreMes ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>

                                        <label for="anio_cad_tarjeta">Año</label>
                                        <select name="anio_cad_tarjeta">
                                            <?php for ($i = 0; $i <= $aniosFuturos; $i++):
                                                $anio = $anioActual + $i;
                                            ?>
                                                <option value="<?= $anio ?>" <?= $anio == intval($anioCaducidad) ? 'selected' : '' ?>>
                                                    <?= $anio ?>
                                                </option>
                                            <?php endfor; ?>
                                        </select>
                                    </td>
                                    <td class="editar-eliminar">
                                        <input type="hidden" value="<?php echo $tarjeta['idTarjeta']; ?>" name="idTarjeta">
                                        <input type="submit" value="Eliminar" name="btn_eliminar_tarjeta" class="btn_eliminar_tarjeta">
                                        <input type="submit" value="Editar" name="btn_editar_tarjeta" class="btn_editar_tarjeta">
                                    </td>
                                </form>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>


            </div>

            <div class="anadir_tarjetas">
                <h3>Añadir tarjeta nueva</h3>

                <form action="" method="post" class="form_anadir_tarjeta">
                    <div class="datos">
                        <div class="dato">
                            <label for="numero_tarjeta">Numero de Tarjeta: </label>
                            <input type="text" name="numero_tarjeta" placeholder="xxxx xxxx xxxx xxxx" pattern="\d{13,19}">
                        </div>
                        <div class="dato">
                            <label for="ccv_tarjeta">CCV: </label>
                            <input type="text" name="ccv_tarjeta" placeholder="xxx">
                        </div>
                        <div class="dato">
                            <label for="fecha_caducidad_tarjeta">Fecha de caducidad: </label>
                            <!-- <input type="month" name="fecha_caducidad_tarjeta"> -->
                            <label for="mes_cad_tarjeta">Mes</label>
                            <select name="mes_cad_tarjeta">
                                <?php
                                foreach ($meses as $numero => $nombre) {
                                    echo "<option value=\"$numero\">$nombre</option>";
                                }
                                ?>
                            </select>
                            <label for="anio_cad_tarjeta">Año</label>
                            <select name="anio_cad_tarjeta">
                                <?php
                                $anioActual = date("Y");
                                
                                for ($i = 0; $i <= $aniosFuturos; $i++) {
                                    $anio = $anioActual + $i;
                                    echo "<option value=\"$anio\">$anio</option>";
                                }
                                ?>
                            </select>

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