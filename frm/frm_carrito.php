<?php
include __DIR__ . '/../common/controlSesion.php';
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito</title>
    <link rel="stylesheet" href="/gamesRus/css/general.css">
    <link rel="stylesheet" href="/gamesRus/css/frm_carrito.css">
</head>

<body>
    <?php
    include './common/cabecera.php';
    ?>
    <p class="errores"><?= $error ?></p>
    <h2>Carrito</h2>
    <main>
        <?php /*var_dump($data);*/ ?>
        <section class="juegos_carrito">
            <?php foreach ($data as $juego): ?>
                <div class="juego">
                    <img src="<?php echo $juego['portada'] ?? 'https://placehold.co/200x100' ?>" alt="<?php echo $juego['titulo']; ?>">
                    <div class="titulo_botones">
                        <p><?php echo $juego['titulo']; ?></p>

                        <div class="botones_juego">
                            <form action="" method="post">
                                <input type="hidden" value="<?php echo $juego['idJuego']; ?>" name="idJuegoCatalogo">


                                <input type="submit" value="Eliminar" name="btn_eliminar_del_carrito">
                                <!-- Tiene que ser boton porque solo activa una funcionalidad del HTML, no manda datos -->

                                <!-- Esto esta mal lo tengo que cambiar -->
                                <!-- MENSAJE DE JUEGO YA REGALADO -->
                                <?php if (!isset($data1)) {

                                ?>
                                    <button type="button" class="btn_regalar" data-id="<?php echo $juego['idJuego']; ?>" data-titulo="<?php echo $juego['titulo']; ?>">Regalar</button>
                                <?php
                                } else {
                                ?>
                                    <p <?= $data1 ?>></p>
                                <?php
                                } ?>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </section>
        <aside class="total_pago">
            <div>
                <p>Aqui va el total</p>
            </div>

            <form action="" method="post">
                <input type="submit" value="Pagar" name="btn_pagar">
            </form>
        </aside>
        <!-- Diálogo para regalar juego -->
        <dialog id="dialogo_regalar">

            <h3>Regalar <span id="nombre_juego"></span></h3>
            <input type="hidden" name="idJuego" id="input_id_juego">
            <input type="text" id="nombre_usuario" placeholder="Nombre del usuario" required>
            <menu>
                <!-- Tiene que ser boton porque solo activa una funcionalidad del HTML, no manda datos -->
                <button type="button" id="btn_cancelar">Cancelar</button>
                <button type="button" id="btn_confirmar_regalo">Confirmar</button>
            </menu>

        </dialog>
    </main>


    <?php
    include './common/footer.php';
    ?>

    <script>
        // Seleccionamos todos los botones de "Regalar"
        const botonesRegalar = document.querySelectorAll(".btn_regalar");
        const dialogo = document.querySelector("#dialogo_regalar");
        const inputIdJuego = document.querySelector("#input_id_juego");
        const nombreJuegoSpan = document.querySelector("#nombre_juego");
        const btnCancelar = document.querySelector("#btn_cancelar");
        const btnConfirmarRegalo = document.querySelector("#btn_confirmar_regalo");
        const nombreUsuario = document.querySelector('#nombre_usuario');


        btnConfirmarRegalo.addEventListener('click', (e) => {
            const idJuego = inputIdJuego.value;
            const boton = Array.from(botonesRegalar).filter((boton) => {
                // if(boton.getAttribute("data-id") == idJuego){
                //     return true;
                // }
                // return false;

                return boton.getAttribute("data-id") == idJuego;

            })[0];

            const parent = boton.parentElement;
            boton.remove();
            const child = document.createElement('p');
            child.innerText = 'Este juego se regalará a ' + nombreUsuario.value;
            parent.appendChild(child);
            nombreUsuario.value = '';
            dialogo.close();


        })
        // Añadimos el evento a cada botón "Regalar"
        botonesRegalar.forEach(boton => {
            boton.addEventListener("click", (e) => {

                const idJuego = boton.getAttribute("data-id");

                const tituloJuego = boton.getAttribute("data-titulo");

                // Rellenamos el diálogo con los datos del juego
                inputIdJuego.value = idJuego;
                nombreJuegoSpan.textContent = tituloJuego;

                // Mostramos el diálogo
                dialogo.showModal();
            });
        });

        // Evento para cerrar el diálogo al pulsar "Cancelar"
        btnCancelar.addEventListener("click", () => {
            dialogo.close();
        });
    </script>
</body>

</html>