<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página de pago</title>
    <link rel="stylesheet" href="/gamesRus/css/general.css">
    <link rel="stylesheet" href="/gamesRus/css/frm_pago.css">
</head>

<body>
    <?php
    include './common/cabecera.php';
    ?>

    <?php
    /* if(isset($_SESSION)){
        var_dump($_SESSION);
    } */
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
    <main>
        <h2>Confirmación el pago</h2>
        <p class="errores"><?= $error ?></p>

        <section class="tarjetas">
            <?php /* var_dump($data); */  ?>

            <div class="anadir_tarjetas">
                <h3>Añadir tarjeta nueva</h3>

                <form action="" method="post" class="form_anadir_tarjeta">
                    <div class="datos">
                        <div class="dato">
                            <label for="numero_tarjeta">Numero de Tarjeta: </label>
                            <input type="text" name="numero_tarjeta" placeholder="xxxx xxxx xxxx xxxx" maxlength="19" pattern="\d{13,19}">
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
                        <input type="hidden" name="pago">
                        <input type="submit" name="btn_anadir_tarjeta" value="Añadir">
                    </div>
                </form>
            </div>

            <div id="seleccionar_tarjetas">
                <h3>Selecciona una tarjeta</h3>
                <form action="" method="POST">
                    <label for="tarjeta">Tarjetas disponibles:</label>
                    <select name="tarjeta" id="tarjeta" >
                    <option value="0">Selecciona una tarjeta</option>
                        <?php if (!empty($data)): ?>
                            <?php foreach ($data as $tarjeta): ?>
                                <option value="<?= $tarjeta['idTarjeta'] ?>">
                                    Número: <?= $tarjeta['numeroTarjeta'] ?> | Caduca: <?= date("m/Y", strtotime($tarjeta['fechaCaducidad'])) ?>
                                </option>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <option>No se encontraron tarjetas</option>
                        <?php endif; ?>
                    </select>
                    <label for="ccv_tarjeta">CCV: </label>
                            <input type="text" name="ccv_tarjeta" placeholder="xxx">
                    <br><br>
                    <input type="submit" name="btn_confirmar_pago" value="Confirmar el Pago">
                </form>
            </div>
        </section>
    </main>

    <?php
    include './common/footer.php';
    ?>
</body>

</html>