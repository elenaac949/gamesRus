<?php
include __DIR__ . '/../common/controlSesion.php';
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo</title>
    <link rel="stylesheet" href="/gamesRus/css/general.css">
    <link rel="stylesheet" href="/gamesRus/css/frm_catalogo.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <?php
    include './common/cabecera.php';
    ?>
    <p class="errores"><?= !$error  ? $data1 : $error ?></p>
    <div id="notificacion"></div>


    <?php /*var_dump($data);*/ ?>
    <h2>Catálogo</h2>
    <main class="contenido_principal">
        <aside class="filtros">
            <form action="" name="formulario_filtrar" method="post" class="formulario_filtrar">
                <label for="genero">Géneros</label>
                <select name="genero" id="genero">
                    <option value="0">Todos</option>
                    <?php foreach ($data2 as $genero) : ?>
                        <option <?php echo isset($_POST['genero']) && $_POST['genero'] == $genero['idGenero'] ? "selected" : "" ?> value="<?php echo $genero['idGenero']; ?>"><?php echo $genero['genero']; ?></option>
                    <?php endforeach; ?>
                </select>
                <label for="sistema">Sistemas</label>
                <select name="sistema" id="sistema">
                    <option value="0">Todos</option>
                    <?php foreach ($data3 as $sistema) : ?>
                        <option <?php echo isset($_POST['sistema']) && $_POST['sistema'] == $sistema['idSistema'] ? "selected" : "" ?> value="<?php echo $sistema['idSistema']; ?>"><?php echo $sistema['nombre']; ?></option>
                    <?php endforeach; ?>
                </select>
                <label for="fecha">Fecha</label>
                <input type="number" name="fecha" id="fecha" placeholder="1900" value="<?php echo isset($_POST['fecha']) ? $_POST['fecha'] : "" ?>">
                <input type="submit" name="btn_filtrar_juegos" value="Filtrar">

            </form>

        </aside>
        <section class="vista_juegos">


            <?php foreach ($data as $juego): ?>
                <div class="juego">
                    <div class="imagen_juego">
                        <img src="<?php echo $juego['portada'] ?? 'https://placehold.co/200x100' ?>" alt="<?php echo $juego['titulo']; ?>">
                    </div>
                    <div class="nombre_juego">
                        <p><?php echo $juego['titulo']; ?></p>
                    </div>
                    <div class="botones_juego">
                        <form action="" method="post">
                            <input type="hidden" value="<?php echo $juego['idJuego']; ?>" name="idJuegoCatalogo">
                            <input type="button" data-id="<?php echo $juego['idJuego']; ?>" value="Detalles" id="btn_mostrar_detalles" name="btn_mostrar_detalles">
                            <input type="submit" value="Añadir al carrito" name="btn_anadir_carrito">
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        </section>
        <dialog name="detalles_juego" id="detalles_juego">

            <div id="contenido_detalles"></div>
            <button id="cerrar_detalles">Salir</button>
        </dialog>
    </main>

    <?php
    include './common/footer.php';
    ?>

    <script>
        // Seleccionamos todos los botones
        let botones = document.querySelectorAll("#btn_mostrar_detalles");
        let dialogo = document.querySelector("#detalles_juego");
        let contenidoDetalles = document.querySelector("#contenido_detalles"); // Contenedor dinámico
        let cerrar = document.querySelector("#cerrar_detalles");

        // Añadimos el evento a cada botón
        botones.forEach(boton => {
            boton.addEventListener("click", (e) => {
                e.preventDefault();
                let idJuego = boton.getAttribute("data-id");

                // Accedemos a los datos del juego
                let juegos = <?php echo json_encode($data); ?>;
                console.log(juegos);
                let juegoSeleccionado = juegos.find(juego => juego.idJuego == idJuego);
                console.log(juegoSeleccionado); // el juego selecionado los detalles



                // Verificamos si el juego fue encontrado
                if (juegoSeleccionado) {
                    // Mostramos los datos del juego en el contenedor dinámico
                    contenidoDetalles.innerHTML = `
                    <h3>${juegoSeleccionado.titulo}</h3>
                    <img src="${juegoSeleccionado.portada}" alt="${juegoSeleccionado.titulo}">
                    <p>Descripción: ${juegoSeleccionado.descripcion}</p>                    
                    <p>Fecha de Lanzamiento: ${juegoSeleccionado.anio}</p>
                    <p>Género: ${juegoSeleccionado.generos}</p>
                    <p>Desarrollador: ${juegoSeleccionado.desarrollador}</p>
                    
                    <p>Sistemas: ${juegoSeleccionado.sistemas}</p>
                    
                `;
                } else {
                    contenidoDetalles.innerHTML = "<p>Juego no encontrado.</p>";
                }

                // Mostramos el diálogo
                dialogo.showModal();
            });
        });

        // Evento para cerrar el diálogo
        cerrar.addEventListener("click", () => {
            dialogo.close();
        });


        // Función para mostrar la notificación con AJAX
        function obtenerPromocion() {
            $.ajax({
                url: 'frm/fichero.php', // El archivo PHP que retorna la promoción
                method: 'GET',
                success: function(response) {
                    if (response && response.mensaje) {
                        // Mostramos el mensaje de promoción en el contenedor
                        $('#notificacion').text(response.mensaje).fadeIn();

                        // Hacemos que la notificación desaparezca después de 5 segundos
                        setTimeout(function() {
                            $('#notificacion').fadeOut();
                        }, 5000);
                    }
                },
                error: function() {
                    console.error('Error al obtener la promoción.');
                }
            });
        }

        // Llamamos a la función para obtener la promoción cuando cargue la página
        $(document).ready(function() {
            obtenerPromocion();
        });
    </script>
</body>

</html>